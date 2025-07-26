<?php

namespace App\Filters\Mobile;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class MealFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        if ($this->request->filled('type')) {
            $query->where('type', $this->request->type);
        }
        return $query;
    }
}