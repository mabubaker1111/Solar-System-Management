<?php

namespace App\Models\Worker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'skill',
        'experience',
        'status',
        'photo',
        'shift_start',
        'shift_end',
    ];

    public function shifts()
    {
        return $this->hasMany(WorkerShift::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function business()
    {
        return $this->belongsTo(\App\Models\Business\Business::class, 'business_id');
    }
}
