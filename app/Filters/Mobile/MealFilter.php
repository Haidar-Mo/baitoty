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

        if ($this->request->filled('name')) {
            $query->where('name', "%" . $this->request->name . "%");
        }

        if ($this->request->filled('max_price')) {
            $query->new_price ?
                $query->where('new_price', '<', $this->request->max_price)
                :
                $query->where('price', '<', $this->request->max_price);
        }
        return $query->where('is_available', true);
    }
}