<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable, HasRoles, HasPermissions;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'verification_code',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'verification_code',
        'is_blocked'
    ];

    protected $appends = [
        'role_name'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //! Relations

    public function kitchen()
    {
        return $this->hasOne(Kitchen::class);
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function compliment()
    {
       return $this->hasMany(Compliment::class);
    }

    //! Accessories

    public function getRoleNameAttribute()
    {
        return $this->roles()->first()?->name;
    }
}
