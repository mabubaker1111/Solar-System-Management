<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'price',
        'description',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
