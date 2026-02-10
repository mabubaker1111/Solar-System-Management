<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function business()
    {
        return $this->hasOne(
            \App\Models\Business\Business::class,
            'owner_id'
        );
    }
    public function client()
    {
        return $this->hasOne(\App\Models\Client\Client::class);
    }


    public function worker()
    {
        return $this->hasOne(\App\Models\Worker\Worker::class);
    }
}
