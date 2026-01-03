<?php

namespace App\Models\Client;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'role', 'status', 'password',
    ];

    public function queries()
    {
        return $this->hasMany(\App\Models\Query::class, 'client_id');
    }
}
