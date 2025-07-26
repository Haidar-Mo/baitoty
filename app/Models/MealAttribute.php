<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealAttribute extends Model
{
    /** @use HasFactory<\Database\Factories\MealAttributeFactory> */
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'name'
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
