<?php

namespace App\Filters\Dashboard;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends BaseFilter
{

    public function apply(Builder $query)
    {
        //: Filter by user 
        if ($this->request->filled('user_name')) {
            $query->whereHas('user', function ($user) {
                $user->where('name', 'like', '%' . $this->request->user_name . '%');
            });
        }

        //: Filter by kitchen name
        if ($this->request->filled('kitchen_name')) {
            $query->whereHas('kitchen', function ($kitchen) {
                $kitchen->where('name', 'like', '%' . $this->request->kitchen_name . '%');
            });
        }

        //: Filter by status
        if ($this->request->filled('status')) {
            $query->whereHas('status', $this->request->status);
        }


        return $query->latest();
    }
}