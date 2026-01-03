<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;                     // <-- ADD THIS
use App\Models\Business\Business;
use App\Models\Business\Service;
use App\Models\Worker\Worker;

class ServiceRequest extends Model
{
    protected $fillable = [
        'client_id',
        'business_id',
        'service_id',
        'full_payment',
        'discount',
        'received_amount',
        'quantity',
        'final_amount',
        'remaining_amount',
        'worker_id', 
        'date',
        'time',
        'notes',
        'price',
        'status',
        'message',
        'deadline',           
        'deadline_notified',  
    ];

    // FIXED: client belongs to USER, not Client model
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
