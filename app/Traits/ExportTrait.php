<?php

namespace App\Traits;

use App\Exports\GenericExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

trait ExportTrait
{
    /**
     * Dynamic export method for all resources
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $validatedData = $request->validate([
            'type.type' => 'required|string|in:excel,csv,pdf,copy,print',
            'type.range' => 'required|string',
            'type.columns' => 'required|array|min:1',
            'type.columns.*' => 'string',
            'type.start' => 'nullable|integer',
            'type.end' => 'nullable|integer',
        ]);

        $validated = $validatedData['type'];
        $query = $this->model::query();

        if (! empty($this->with)) {
            $query->with($this->with);
        }

        // Apply search filters
        $this->applySearchFilters($request, $query);
        $records = $this->getRecordsByRange($query, $validated['range'], $validated);
        $exportData = $this->transformRecordsForExport($records, $validated['columns'],$validatedData['type']);
        return $this->generateExport($exportData, $validated['type']);

    }

    protected function applySearchFilters(Request $request, $query)
    {
        $search = $request->input('search.value', '');
        if (! empty($search)) {
            $query = $this->applyGlobalSearch($query, $search);
        }

        $columns = $request->input('columns', []);
        foreach ($columns as $column) {
            if ($column['searchable'] === 'true' && ! empty($column['search']['value'])) {
                $query->where($column['data'], 'like', "%{$column['search']['value']}%");
            }
        }

        return $query;
    }

    protected function getRecordsByRange($query, $range, $validated)
    {
        switch ($range) {
            case 'current':
                // Get current page records
                $length = request('length', 10);
                $start = request('start', 0);

                return $query->skip($start)->take($length)->get();

            case 'custom':
                // Get records within custom range
                $start = $validated['start'] - 1;
                $length = $validated['end'] - $start;

                return $query->skip($start)->take($length)->get();

            case 'all':
            default:
                // Get all records
                return $query->get();
        }
    }

    protected function transformRecordsForExport($records, $columns,$exportType='dataTable')
    {
        if (empty($columns)) {
            return $this->mapRecords($records, $exportType);
        }

        return $records->map(function ($record) use ($columns,$exportType) {
            $mappedResults = $this->mapRecords(collect([$record]),$exportType);
            $mappedRecord = is_array($mappedResults)
                ? array_shift($mappedResults)
                : $mappedResults->first();

            return collect($columns)->mapWithKeys(function ($column) use ($mappedRecord) {
                return [$column => $mappedRecord[$column] ?? null];
            })->toArray();
        })->toArray();
    }

    public function generateExport($data, $type)
    {
        $filename = $this->getExportFilename($type);
        $title = ucfirst(str_replace('_', ' ', $this->resourceName)).' Report';
        switch ($type) {
            case 'excel':
                return Excel::download(new GenericExport($data,['type'=>$type]), 'filename.xlsx');
            case 'csv':
                return Excel::download(new GenericExport($data,['type'=>$type]), $filename.'.csv');
            case 'pdf':
                return Excel::download(new GenericExport($data,['type'=>$type]),$filename.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            case 'copy':
            case 'print':
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid export type',
                ], 400);
        }
    }

    protected function getExportFilename($type)
    {
        $modelName = class_basename($this->model);

        return strtolower($modelName).'_export_'.date('Y-m-d_His');
    }
}
