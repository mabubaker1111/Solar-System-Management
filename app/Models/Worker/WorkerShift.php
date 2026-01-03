<?php

namespace App\Models\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerShift extends Model
{
    protected $fillable = ['worker_id', 'shift_start', 'shift_end'];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function bookings()
    {
        return $this->hasMany(WorkerShiftBooking::class, 'worker_shift_id');
    }
}
