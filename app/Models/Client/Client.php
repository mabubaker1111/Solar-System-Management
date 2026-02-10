<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function queries()
    {
        return $this->hasMany(\App\Models\Query::class, 'client_id');
    }
}
