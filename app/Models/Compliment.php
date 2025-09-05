<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliment extends Model
{
    /** @use HasFactory<\Database\Factories\ComplimentFactory> */
    use HasFactory;


    protected $fillable = [
        'user_id',
        'content',
        'image'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
