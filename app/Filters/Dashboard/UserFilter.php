<?php

namespace App\Filters\Dashboard;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends BaseFilter
{

    public function apply(Builder $query)
    {

        // Filter by block status
        if ($this->request->filled('is_blocked')) {
            $query->where('is_blocked', $this->request->is_blocked);
        }
        // Filter by name
        if ($this->request->filled('name')) {
            $query->where('name', 'like', '%' . $this->request->name . '%');
        }

        // Filter by email
        if ($this->request->filled('email')) {
            $query->where('email', $this->request->email);
        }

        // Filter by role
        if ($this->request->filled('role')) {
            $query->hasRole($this->request->role);
        }

        // Filter by created_at date range
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('created_at', [$this->request->start_date, $this->request->end_date]);
        }

        return $query;
    }
}