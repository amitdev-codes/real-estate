<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Searchable
{
    public function searchAndPaginate(Request $request, $model, array $relationships = [], array $filters = [])
    {
        $searchTerm = $request->input('search', '');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $query = $model::with($relationships);

        if ($searchTerm) {
            $columns = $this->searchableColumns($model);
            $query->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$searchTerm}%");
                }
            });
        }

        $this->applyDynamicFilters($query, $filters);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    protected function searchableColumns($model)
    {
        // Define which columns are searchable for each model
        $columns = [
            'App\Models\User' => ['name', 'email', 'mobile_no'],
            'App\Models\master\Country' => ['name', 'code'],
            'App\Models\master\State' => ['name', 'code'],
            'App\Models\master\City' => ['name', 'code'],
            // Add other models and their searchable columns here
        ];

        return $columns[get_class($model)] ?? [];
    }

    protected function applyDynamicFilters($query, array $filters)
    {

        return $query->where($filters);
    }
}
