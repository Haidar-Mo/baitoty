<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'mediaable_id',
        'mediaable_type',
    ];

    protected $appends = ['full_path'];
    
    public function mediaable()
    {
        return $this->morphTo('mediaable');
    }


    //! Accessories

    public function getFullPathAttribute()
    {
        return asset($this->path);
    }
}
