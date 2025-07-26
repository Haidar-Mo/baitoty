<?php

namespace App\Filters\Mobile;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends BaseFilter
{
    public function apply(Builder $query): Builder
    {
        // Filter by status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }
        return $query->latest();
    }
}