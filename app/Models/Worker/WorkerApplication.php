<?php

namespace App\Models\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerApplication extends Model
{
    protected $fillable = [
        'worker_id',
        'business_id',
        'status',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function business()
    {
        return $this->belongsTo(\App\Models\Business\Business::class);
    }
}
