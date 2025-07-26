<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /** @use HasFactory<\Database\Factories\MealFactory> */
    use HasFactory;

    protected $fillable = [
        'kitchen_id',
        'name',
        'ingredients',
        'type', //- 1: for moona , 2: for normal
        'price',
        'new_price',
        'meal_form',
        'is_available',
    ];

    public function casts(): array
    {
        return [
            'is_available' => 'boolean'
        ];
    }

    protected $appends = [
        'kitchen_name',
        'is_on_sales',
        'can_be_delivered'
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function attribute()
    {
        return $this->hasMany(MealAttribute::class);
    }


    public function order()
    {
        return $this->hasMany(Order::class);
    }
    //!Accessories

    public function getIsOnSalesAttribute()
    {
        return $this->new_price ? true : false;
    }

    public function getKitchenNameAttribute()
    {
        return $this->kitchen()->first()->name;
    }

    public function getCanBeDeliveredAttribute()
    {
        return $this->kitchen()->first()->can_deliver ?? false;
    }
}
