<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Traits\Searchable;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Constants\StatusClasses;
use App\Services\ResponseService;
use App\Traits\HandlesExceptions;
use Modules\Agency\Models\Agency;
use App\Traits\BulkDeletableTrait;
use Spatie\Permission\Models\Role;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Controllers\Admin\BaseResourceController;

class UserController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'users';
        $this->redirectRouteName = 'admin.users.index';
        $this->abilityName = 'users';
        $this->routeName = 'admin.users';
        $this->dataRouteName = 'admin.users.data';
        $this->model = User::class;
        $this->with = ['roles','agent','agency'];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'name', 'title' => 'Name', 'searchable' => true, 'type' => 'text'],
            ['data' => 'email', 'title' => 'Email', 'searchable' => true, 'type' => 'text'],
            ['data' => 'mobile_no', 'title' => 'Mobile No', 'searchable' => true, 'type' => 'text'],
            ['data' => 'status', 'title' => 'Status', 'searchable' => true, 'type' => 'select',  'options' => [
                ['id' => 1, 'name' => 'Active'],
                ['id' => 0, 'name' => 'Inactive'],
            ],
            ],
            ['data' => 'roles', 'title' => 'Roles', 'searchable' => true, 'type' => 'select', 'relationship' => 'roles', 'options' => Role::all()->map(function ($role) {
                return ['id' => $role->id, 'name' => $role->name];
            }),
            ],
        ];
    }


    protected function mapRecords($records, $exportType = null)
    {

        return $records->map(function ($record) {
            $mappedData = [
                'id' => $record->id,
                'name' => $record->name,
                'email' => $record->email,
                'mobile_no' => $record->mobile_no,
                'created_at' => $record->created_at,
                'status' => $record->status,
                'status_id' => $record->status,
                'agency_id' => optional($record->agent)->agency_id,
                'license_number' => optional($record->agent)->license_number,

            ];
            if ($record->roles->contains('name', 'agent')) {
                $mappedData['approval_status'] = optional($record->agent)->status;
            } else {
                $mappedData['approval_status'] = optional($record->agency)->status;
            }
            // Format status with badge
            if (isset($mappedData['status'])) {
                $statusText = $mappedData['status'] ? 'Active' : 'Inactive';

                $mappedData['status'] = sprintf(
                    '<span class="%s">%s</span>',
                    StatusClasses::getClass($mappedData['status']),
                    $statusText
                );
            }
            $mappedData['roles'] = $record->roles->map(function ($role)  {
              return $role->name;

            })->implode(' ');
            return $mappedData;
        })->toArray();
    }

    /**
     * Get additional data for user index view
     */
    protected function getAdditionalIndexData()
    {
        return[
            'roles' => Role::all(),
            'agencies' => Agency::all(),

    ];
    }

    // in case if we need custoom export  then we can use this functionm

    public function store(StoreUserRequest $request)
    {
        return $this->handleRequest($request, function () use ($request) {
            $validated = $request->validated();
            $data = Arr::except($validated, ['terms','role','license_number','agency_id','password_confirmation']);
            $role = Role::findById($request->role);
            $user = User::create($data);
            $user->assignRole($role);

            switch ($role->name) {
                case 'Agent':
                    Agent::create([
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'phone' => $user->mobile_no,
                        'license_number' => $request->license_number,
                        'status' => 'pending'
                    ]);
                    break;

                case 'Agency':
                    Agency::create([
                        'user_id' => $user->id,
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->mobile_no,
                        'agency_id' => $request->agency_id,
                        'status' => 'pending'
                    ]);
                    break;
            }


        });
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        return $this->handleRequest($request, function () use ($request, $user) {
            $data = $request->validated();

            // Handle password update
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->input('password'));
            } else {
                unset($data['password']);
            }

            // Handle status_id
            if (isset($data['status_id'])){
                $data['status'] = $request->status_id;
                unset($data['status_id']);
            }

            // Handle approval_status and remarks
            if ($request->has('approval_status')) {
                $data['approval_status'] = $request->input('approval_status');

                // Add remarks only when status is rejected
                if ($data['approval_status'] === 'suspended') {
                    $data['remarks'] = $request->input('remarks', null);
                } else {
                    $data['remarks'] = null;
                }
            }

            // dd($data);

            // Update base user data
            $updatedData = Arr::except($data, ['role', 'license_number', 'agency_id', 'password_confirmation','approval_status','remarks']);
            // dd($updatedData,$data);
            $user->update($updatedData);
            // dd($user);

            if ($request->filled('role')) {
                $role = Role::findById($request->role);
                $user->syncRoles([$role->id]);
                // Handle role-specific updates
                switch ($role->name) {
                    case 'Agent':
                        Agent::updateOrCreate(
                            ['user_id' => $user->id],
                            [
                                'email' => $user->email,
                                'phone' => $user->mobile_no,
                                'license_number' => $request->license_number,
                                'status' => $data['approval_status']
                            ]
                        );
                        break;

                    case 'Agency':
                        // dd($data['approval_status']);
                        Agency::updateOrCreate(
                            ['user_id' => $user->id],
                            [
                                'name' => $request->name,
                                'email' => $request->email,
                                'phone' => $request->mobile_no,
                                'agency_id' => $request->agency_id,
                                'status' => $data['approval_status']
                            ]
                        );
                        break;
                }
            }
        });
    }
    //archive
    public function archive(User $user)
    {
        $roles = $user->getRoleNames(); 
        $primaryRole = $roles->first(); 
        $data = [
            'user' => $user->only(['id', 'name', 'email','mobile_number']),
            'related_data' => [],
            'primary_role' => $primaryRole
        ];
  
        // dd($primaryRole);
    
        switch ($primaryRole) {
            case 'Agent':
                $agent = Agent::where('user_id', $user->id)
                    ->with([
                        'address',
                        'personalInformation' => function ($query) {
                            $query->select('id', 'personal_informationable_id', 'personal_informationable_type', 'phone', 'dob', 'bio_photo');
                        }
                    ])
                    ->first();
                if ($agent) {
                    $data['related_data'] = [
                        'agent' => $agent->only(['id', 'user_id', 'agency_id']),
                        'address' => $agent->address ? $agent->address->toArray() : null,
                        'personal_information' => $agent->personalInformation ? $agent->personalInformation->toArray() : null,
                    ];
                }
                break;
    
            case 'Agency':
                $agency = Agency::where('user_id', $user->id)
                    ->with(['address'])
                    ->first();
                if ($agency) {
                    $data['related_data'] = [
                        'agency' => $agency->only(['id', 'user_id', 'name', 'email','webiste','description','short_description','registered_agency_number']),
                        'address' => $agency->address ? $agency->address->toArray() : null,
                    ];
                }
                break;
    
            default:
                $personalInformation = PersonalInformation::where('informable_id', $user->id)
                    ->where('informable_type', User::class)
                    ->select('id', 'informable_id', 'informable_type',  'date_of_birth')
                    ->first();
                if ($personalInformation) {
                    $data['related_data'] = [
                        'personal_information' => $personalInformation->toArray(),
                    ];
                }
                break;
        }

    
        return Inertia::render('backend/pages/user/archive', ['data'=>$data]);
    }
}
