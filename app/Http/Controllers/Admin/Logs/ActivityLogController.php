<?php

namespace App\Http\Controllers\Admin\Logs;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Models\ActivityLog;
use App\Services\ResponseService;
use App\Traits\BulkDeletableTrait;
use App\Traits\HandlesExceptions;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ActivityLogController extends BaseResourceController
{
    use BulkDeletableTrait;
    use HandlesExceptions,searchable;

    public function __construct(protected ResponseService $responseService)
    {
        $this->resourceName = 'activityLogs';
        $this->abilityName = 'activityLogs';
        $this->routeName = 'admin.activityLogs';
        $this->redirectRouteName = 'admin.activityLogs.index';
        $this->dataRouteName = 'admin.activityLogs.data';
        $this->model = ActivityLog::class;
        $this->with = [];
        $this->formType = 'modal';
        parent::__construct($responseService);
        $this->columns = [
            ['data' => 'log_name', 'title' => 'Log', 'searchable' => true, 'type' => 'text'],
            ['data' => 'description', 'title' => 'Description', 'searchable' => true, 'type' => 'text'],
            ['data' => 'event', 'title' => 'Event', 'searchable' => true, 'type' => 'text'],
            ['data' => 'causer_id', 'title' => 'Causer Id', 'searchable' => true, 'type' => 'text'],
            ['data' => 'subject_id', 'title' => 'Subject Id', 'searchable' => true, 'type' => 'text'],
            ['data' => 'changes', 'title' => 'Changes','type' => 'text'],

        ];
    }

    protected function mapRecords($records,$exportType=null)
    {
        return $records->map(function ($activityLog) {
            return [
                'id' => $activityLog->id,
                'log_name' => $activityLog->log_name,
                'description' => $activityLog->description,
                'event' => $activityLog->event,
                'causer_id' => $activityLog->causer_id ? $activityLog->user->name : 'seeder',
                'subject_id' => $activityLog->subject_id,
                'changes' => $this->getChangedProperties($activityLog->properties),
            ];
        });
    }

    protected function getAdditionalIndexData()
    {
        return [];
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        //
    }
    protected function getChangedProperties($properties)
    {
        if (!$properties) {
            return '';
        }

        $properties = is_string($properties) ? json_decode($properties, true) : $properties;

        if (!isset($properties['old']) || !isset($properties['attributes'])) {
            return '';
        }

        $changes = [];
        foreach ($properties['attributes'] as $key => $newValue) {
            // Skip password comparisons for security
            if ($key === 'password') {
                continue;
            }

            $oldValue = $properties['old'][$key] ?? null;
            if ($oldValue !== $newValue) {
                $changes[] = sprintf(
                    "%s: %s → %s",
                    ucfirst($key),
                    $oldValue,
                    $newValue
                );
            }
        }

        return implode(', ', $changes);
    }

    protected function getDetailedProperties($properties)
    {
        if (!$properties) {
            return '';
        }

        $properties = is_string($properties) ? json_decode($properties, true) : $properties;

        if (!isset($properties['old']) || !isset($properties['attributes'])) {
            return '';
        }

        $html = '<div class="properties-comparison">';
        $html .= '<table class="table table-bordered">';
        $html .= '<thead><tr><th>Field</th><th>Old Value</th><th>New Value</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($properties['attributes'] as $key => $newValue) {
            if ($key === 'password') {
                continue;
            }

            $oldValue = $properties['old'][$key] ?? '';
            $html .= sprintf(
                '<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
                ucfirst($key),
                $oldValue,
                $newValue
            );
        }

        $html .= '</tbody></table></div>';
        return $html;
    }
}
