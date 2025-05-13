<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Traits\ExportTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Modules\Agency\Models\Agency;

abstract class BaseResourceController extends Controller
{
    use ExportTrait;

    protected string $resourceName;

    protected string $redirectRouteName;

    protected string $dataRouteName;

    protected string $routeName;
    protected string $modelName;

    protected string $abilityName;

    protected $model;

    protected $with = [];

    protected $columns = [];

    protected $searchableColumns = [];

    protected $formType = 'form'; // Add form type property


    public function __construct(protected ResponseService $responseService)
    {
        $this->responseService = $responseService;
        $this->abilityName = $this->abilityName ?? $this->resourceName;
    }

    protected function authorizeAction(string $ability)
    {
        abort_if(Gate::denies($ability), 403, 'You do not have access to this page.');
    }

    public function index()
    {
        $this->authorizeAction('view '.$this->abilityName);
        $user = auth()->user();


        if ($user->hasRole('Agent') && $user->agent->status !== 'active') {
            abort(403, 'You are not an active agent.');  // Permission error
        }

        if ($user->hasRole('Agency') && $user->agency->status !== 'active') {
            abort(403, 'You are not an active agency.');  // Permission error
        }

        $renderPath = $this->formType === 'modal'
            ? 'backend/pages/resources/ResourceIndex'
            : 'backend/pages/resources/ResourceIndexForm';

            // dd($this->viewType);

        return Inertia::render($renderPath, [
            'columns' => $this->columns,
            'resourceName' => $this->resourceName,
            'modelName' => $this->modelName ?? Str::singular($this->resourceName),
            'dataRoute' => route($this->dataRouteName),
            'dropdownData' => $this->getAdditionalIndexData(),
            'redirectRoute' => route($this->redirectRouteName),
            'abilityName' => $this->abilityName,
        ]);
    }

    public function getData(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];
        $order = $request->get('order')[0];
        $columns = $request->get('columns');

        $validColumns = array_filter($columns, function ($column) {
            return $column['data'] !== 'checkbox' && $column['data'] !== '';
        });

        $columnIndex = $order['column'] >= count($validColumns) ? 0 : $order['column'];
        $columnName = $columns[$columnIndex]['data'];
        $columnSortOrder = $order['dir'];
        $query = $this->model::with($this->with);

        // will amnage for admin and superadmin all default filter

        $query = $this->applyDefaultFilters($query);
        if (! empty($search)) {
            $query = $this->applyGlobalSearch($query, $search);
        }
        if ($this->with) {
            $relationship_table = $this->with[0];
        }
        foreach ($columns as $index => $column) {
            if ($column['searchable'] === 'true' && isset($column['search']['value']) && $column['search']['value'] !== null && $column['search']['value'] !== '') {
                $columnName = $column['data'];
                $searchValue = $column['search']['value'];
                $modelClass = $this->model;
                $modelInstance = new $modelClass;
                $tableName = $modelInstance->getTable();

                if (isset($relationship_table) && $columnName === $relationship_table) {
                    $query->whereHas($relationship_table, function ($q) use ($searchValue) {
                        $q->where('id', $searchValue);
                    });
                } else {
                    $columnType = Schema::getColumnType($tableName, $columnName);
                    if ($columnType === 'date') {
                        $query->whereDate($columnName, 'like', "%$searchValue%");

                    } elseif (in_array($columnType, ['boolean', 'tinyint'])) {
                        $booleanValue = $this->parseBooleanValue($searchValue);

                        if ($booleanValue !== null) {
                            $query->where($columnName, $booleanValue);
                        }
                    } else {
                        $query->where($columnName, 'like', "%$searchValue%");
                        if ($columnName && $columnName !== 'checkbox') {
                            $query->orderBy($columnName, $columnSortOrder);
                        }
                    }
                }
            }
        }
        $totalRecords = $query->count();
        $records = $query->skip($start)
            ->take($length)
            ->get();
        $records = $query->get();
        $mappedData = $this->mapRecords($records);

        return $this->responseService->datatables(
            $mappedData,
            $draw,
            $totalRecords
        );
    }

    protected function applyGlobalSearch(Builder $query, string $search): Builder
    {
        if (! empty($this->searchableColumns)) {
            return $query->where(function ($q) use ($search) {
                foreach ($this->searchableColumns as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }
        if (method_exists($this->model, 'scopeSearch')) {
            return $query->search($search);
        }

        return $query;
    }

    protected function handleRequest(Request $request, callable $callback, ?string $redirectRoute = null)
    {
        try {
            $result = $callback();
            $formattedResourceName = Str::headline($this->resourceName);
            $redirectRoute = $redirectRoute ?? "admin.{$this->resourceName}.index";

            if ($request->header('X-Inertia')) {
                return back()->with([
                    'success' => "$formattedResourceName processed successfully.",
                    'toastr' => [
                        'type' => 'success',
                        'message' => "$formattedResourceName processed successfully.",
                    ],
                ]);
            }

            if ($request->ajax()) {
                return $result instanceof JsonResponse
                    ? $result
                    : $this->responseService->sendJsonResponse('success', "$formattedResourceName processed successfully.");
            }

            return redirect()->route($redirectRoute)->with([
                'success' => "$formattedResourceName processed successfully.",
                'toastr' => [
                    'type' => 'success',
                    'message' => "$formattedResourceName processed successfully.",
                ],
            ]);
        } catch (\Throwable $e) {
            $errorMessage = "An error occurred: {$e->getMessage()}";

            if ($request->header('X-Inertia')) {
                return back()->with([
                    'error' => $errorMessage,
                    'toastr' => [
                        'type' => 'error',
                        'message' => $errorMessage,
                    ],
                ]);
            }

            if ($request->ajax()) {
                return $this->responseService->errorGenericResponse($this->resourceName, true, '', $e);
            }

            return redirect()->route($redirectRoute)->with([
                'error' => $errorMessage,
                'toastr' => [
                    'type' => 'error',
                    'message' => $errorMessage,
                ],
            ]);
        }
    }

    abstract protected function mapRecords($records, $exportType);

    protected function getAdditionalIndexData()
    {
        return [];
    }

    public function create(Request $request)
    {
        $this->authorizeAction('create '.$this->abilityName);
        $user = auth()->user();
        if ($user->hasRole('Agent') && $user->agent->status !== 'active') {
            abort(403, 'You are not an active agent.');  // Permission error
        }

        if ($user->hasRole('Agency') && $user->agency->status !== 'active') {
            abort(403, 'You are not an active agency.');  // Permission error
        }
        $formPath = $this->formPath();

        return Inertia::render($formPath['path'], $formPath['props']);
    }

    public function edit(Request $request, $model)
    {
        $this->authorizeAction('edit '.$this->abilityName);
        $user = auth()->user();
        if ($user->hasRole('Agent') && $user->agent->status !== 'active') {
            abort(403, 'You are not an active agent.');  // Permission error
        }

        if ($user->hasRole('Agency') && $user->agency->status !== 'active') {
            abort(403, 'You are not an active agency.');  // Permission error
        }
        $formPath = $this->formPath();

        return Inertia::render($formPath['path'], array_merge($formPath['props'],$model));
    }
    public function customView(Request $request, $id)
    {
        $this->authorizeAction('view '.$this->abilityName);

        $record = $this->model::findOrFail($id);

        // Prepare data for custom view
        $customViewData = $this->prepareCustomViewData($record);

        // Return Inertia view or JSON based on your requirements
        return Inertia::render('backend/pages/resources/CustomView', [
            'data' => $customViewData,
            'resourceName' => $this->resourceName
        ]);
    }


    public function destroy(Request $request, $model)
    {
        $this->authorizeAction('delete '.$this->abilityName);

        $modelClass = $this->model;
        $modelInstance = $modelClass::findOrFail($model);

        return $this->handleRequest($request, function () use ($modelInstance) {
            $modelInstance->delete();

            return true;
        });
    }

    protected function formPath()
    {
        return [
            'path' => '',
            'props' => [],
        ];
    }

    private function parseBooleanValue($value)
    {
        // Convert string to lowercase for consistent comparison
        if (is_string($value)) {
            $value = strtolower($value);
        }

        // Handle various boolean representations
        switch ($value) {
            case 'true':
            case '1':
            case 1:
            case 'yes':
            case 'active':
                return true;
            case 'false':
            case '0':
            case 0:
            case 'no':
            case 'inactive':
                return false;
            default:
                return null;
        }
    }

    protected function applyDefaultFilters(Builder $query): Builder
    {
        if (! auth()->user()->hasRole(['Admin', 'SuperAdmin'])) {
            return $query->where(function ($query) {
                $user = auth()->user();
                if ($user->hasRole('Agent')) {
                    return $query->where('agent_id', $user->agent->id);
                }

                if ($user->hasRole('User')) {
                    return $query->where('user_id', $user->id);
                }

                if ($user->hasRole('Agency')) {
                    return $query->where('agency_id', $user->agency->id);
                }
            });
        }

        return $query;
    }
}
