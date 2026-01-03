<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'client_id',
        'business_id',
        'message',
        'response',
    ];

    // Corrected relation
    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id');
    }

    public function business()
    {
        return $this->belongsTo(\App\Models\Business\Business::class, 'business_id');
    }
}
