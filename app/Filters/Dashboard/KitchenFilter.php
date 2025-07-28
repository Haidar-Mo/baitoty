<?php

namespace App\Filters\Dashboard;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class KitchenFilter extends BaseFilter
{

    public function apply(Builder $query)
    {

        // Filter by name
        if ($this->request->filled('name')) {
            $query->where('name', 'like', '%' . $this->request->name . '%');
        }

        return $query;
    }
}