<?php

namespace App\Models\Worker;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client\ServiceRequest;
use App\Models\Worker\Worker;

class ServicePayment extends Model
{
    protected $fillable = [
        'service_request_id',
        'worker_id',
        'service_name',
        'quantity',
        'full_payment',
        'discount',
        'received_amount',
        'final_amount',
        'remaining_amount',
        'comment',
        'payment_status',
    ];

    /**
     * Relation to the Service Request
     */
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    /**
     * Relation to the Worker
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    /**
     * Calculate final_amount and remaining_amount dynamically
     * Can be used before saving to DB
     */
    public function calculateAmounts()
    {
        $this->final_amount = ($this->full_payment * $this->quantity) - $this->discount;
        $this->remaining_amount = $this->final_amount - $this->received_amount;
    }
}
