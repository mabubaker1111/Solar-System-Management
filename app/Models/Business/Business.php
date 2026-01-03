<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'owner_id', 'business_name', 'business_Owner', 'description', 
        'address', 'city', 'slots', 'status', 'image',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id');
    }

    public function services()
    {
        return $this->hasMany(\App\Models\Business\Service::class, 'business_id');
    }

    public function queries()
    {
        return $this->hasMany(\App\Models\Query::class, 'business_id');
    }
}
