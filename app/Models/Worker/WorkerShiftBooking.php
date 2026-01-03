<?php

namespace App\Models\Worker;

use Illuminate\Database\Eloquent\Model;

class WorkerShiftBooking extends Model
{
    protected $fillable = ['worker_shift_id', 'client_request_id', 'booking_date'];

    public function shift()
    {
        return $this->belongsTo(WorkerShift::class, 'worker_shift_id');
    }

    public function request()
    {
        return $this->belongsTo(\App\Models\Client\ServiceRequest::class, 'client_request_id');
    }
}
