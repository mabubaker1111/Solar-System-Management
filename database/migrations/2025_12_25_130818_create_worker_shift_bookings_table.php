<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_shift_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_shift_id');
            $table->unsignedBigInteger('client_request_id');
            $table->date('booking_date');
            $table->timestamps();

            $table->foreign('worker_shift_id')->references('id')->on('worker_shifts')->onDelete('cascade');
            $table->foreign('client_request_id')->references('id')->on('service_requests')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_shift_bookings');
    }
};
