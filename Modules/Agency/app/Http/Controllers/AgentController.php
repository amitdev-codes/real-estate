<?php

namespace Modules\Agency\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Modules\Agent\Models\Agent;
use App\Constants\StatusClasses;
use App\Services\ResponseService;
use App\Traits\HandlesExceptions;
use Modules\Agency\Models\Agency;
use App\Traits\BulkDeletableTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseResourceController;

class AgentController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'agents';
        $this->redirectRouteName = 'agency.agents.index';
        $this->abilityName = 'agentsProfile';
        $this->routeName = 'agents';
        $this->dataRouteName = 'agency.agents.data';
        $this->model = Agent::class;
        $this->with = ['media', 'agency'];
        $this->formType = 'form';
        parent::__construct($responseService);
        $this->columns = [
            [
                'data' => 'image',
                'title' => 'Image',
                'searchable' => false,
                'orderable' => false,
                'type' => 'image',
                'width' => '100px', // Add width for responsive handling
            ],
            [
                'data' => 'full_name',
                'title' => 'Full Name',
                'searchable' => true,
                'type' => 'text',
                'width' => '250px',
            ],
            [
                'data' => 'email',
                'title' => 'Email',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'phone',
                'title' => 'Phone',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'license_number',
                'title' => 'License Number',
                'type' => 'text',
                'width' => '120px',
            ],
            [
                'data' => 'experience',
                'title' => 'Experience',
                'type' => 'text',
                'width' => '120px',
            ],


            [
                'data' => 'status',
                'title' => 'Status',
                'searchable' => true,
                'type' => 'select',
                'options' => [
                    ['id' => 'active', 'name' => 'Active'], // Enum 'active'
                    ['id' => 'pending', 'name' => 'Pending'], // Enum 'inactive'
                    ['id' => 'suspended', 'name' => 'Suspended'], // Enum 'suspended'
                ],
            ],
        ];
    }

    protected function mapRecords($records, $exportType=null)
    {
        $mappedData = [];
        return $records->map(function ($record) use ($exportType) {
            $mappedData = [
                'id' => $record->id,
                'image' => $this->getAgentImage($record),
                'full_name' => $record->first_name.' '.$record->last_name,
                'email' => $record->email?? 'N/A',
                'phone' => $record->phone?? 'N/A',
                'license_number' => $record->license_number?? 'N/A',
                'experience' => $record->experience?? 'N/A',
                'status' => $record->status?? 'N/A',
            ];

            if (isset($exportType['type'])) {
                if ($record->status) {
                    $mappedData['status'] = $record->status;
                }
                if (isset($exportType['type']) && $exportType['type'] === 'pdf') {
                    $mappedData['image'] = $record->getFirstMedia('images')
                        ? $record->getFirstMedia('images')->getUrl('thumb')
                        : asset('static/images/bg/01.jpg');
                } else {
                    $mappedData['image'] = $this->getAgentImage($record);
                }
            } else {
                if ($record->status) {
                    $mappedData['status'] = sprintf(
                        '<span class="%s">%s</span>',
                        StatusClasses::getEnumClass($record->status) ?? 'inline-flex px-2 py-1 text-sm font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full',
                        $record->status
                    );
                }
            }



            return $mappedData;
        })->toArray();
    }

    protected function getAgentImage($record)
    {
        $media = $record->getFirstMedia('agents');
        if ($media) {
            return sprintf(
                '<img src="%s" alt="%s" class="w-16 h-16 object-cover rounded-lg shadow-sm">',
                $media->getUrl('thumb'),
                htmlspecialchars($record->title)
            );
        }

        return sprintf(
            '<img src="%s" alt="Default Image" class="w-16 h-16 object-cover rounded-lg shadow-sm">',
            asset('static/images/bg/01.jpg')
        );
    }


    protected function getAdditionalIndexData()
    {
        return [];
    }
    protected function formPath()
    {
        return [
            'path' => 'Agency::agentProfile/create-edit',
            'props'=>[],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $formPath = $this->formPath();
        return Inertia::render($formPath['path'], $formPath['props']);
    }
    public function edit(Request $request,$model)
    {
        $formPath = $this->formPath();
        $userInformation=Agent::with('user', 'media', 'agency')->where('id', $model)->first();
        $data = [
            'id' => $userInformation->id,
            'model' => 'agent',
            'role' => 'Agent',
            'email' => $userInformation->email,
            'name' => $userInformation->first_name.' '.$userInformation->last_name,
            'first_name' => $userInformation->first_name,
            'last_name' => $userInformation->last_name,
            'phone' => $userInformation->phone,
            'license_number' => $userInformation->license_number,
            'short_description' => $userInformation->short_description,
            'status' => $userInformation->user->status,
            'agency_id' => $userInformation->agency->id,
            'experience' => $userInformation->experience ?? null,
            'primary_area' => $userInformation->primary_area ?? null,
            'additional_areas' => $userInformation->additional_areas ?? [],
            'specializations' => $userInformation->specializations ?? [],
            'media_url' => $userInformation->thumb_url,
            'previewUrl' => $userInformation->preview_url,
            'remarks' => $userInformation->remarks
        ];
        $agencies=Agency::get(['id', 'name'])->toArray();
        $testimonials = $userInformation->getMediaItems('agent_testimonials');
        return Inertia::render($formPath['path'],[ 'data' => $data,'testimonials' => $testimonials,
        'agencies' => Agency::get(['id', 'name'])]);
    }

    public function update(Request $request,$model){
        $request->validate([
            'status' => 'required|in:pending,active,suspended',
            'remarks' => 'required_if:status,pending,suspended',
        ]);

        Agent::where('id', $model)->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('agency.agents.index');
    }




}
