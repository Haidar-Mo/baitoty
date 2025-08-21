<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kitchen_id',
        'meal_id',
        'count',
        'total_price',
        'phone_number',
        'latitude',
        'longitude',
        'notes',
        'qr_code',
        'status'
    ];

    protected $appends = [
        'meal_name',
        'user_name',
        'kitchen_name',
        'created_from'
    ];
    public function casts(): array
    {
        return [
            'total_price' => 'double',
            'created_at' => 'date:Y-m-d H:i',
        ];
    }


    //! Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }


    //! Boot function
    protected static function booted()
    {

        static::creating(function ($order) {
            $order->qr_code = Str::uuid();
        });
    }


    //! Accessories
    public function getUserNameAttribute()
    {
        return $this->user()->first()->name;
    }

    public function getMealNameAttribute()
    {
        return $this->meal()->first()->name;
    }
    public function getKitchenNameAttribute()
    {
        return $this->kitchen()->first()->name;
    }

    public function getCreatedFromAttribute()
    {
        Carbon::setLocale('ar');
        $diff = $this->created_at->locale('ar')->diffForHumans();
        return preg_replace('/(d+)/', '<strong>$1</strong>', $diff);
    }
}
