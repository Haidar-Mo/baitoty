<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    /** @use HasFactory<\Database\Factories\KitchenFactory> */
    use HasFactory;


    protected $fillable = [
        'user_id',
        'name',
        'description',
        'phone_number',
        'second_phone_number',
        'latitude',
        'longitude',
        'can_deliver',
        'open_at',
        'close_at'
    ];

    public function casts(): array
    {
        return [
            'can_deliver' => 'boolean',
            'open_at' => 'datetime:H:i',
            'close_at' => 'datetime:H:i',
        ];
    }

    //! Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function meal()
    {
        return $this->hasMany(Meal::class);
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
