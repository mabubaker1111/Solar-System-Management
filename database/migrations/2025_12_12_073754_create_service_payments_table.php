<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('service_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_request_id');
            $table->unsignedBigInteger('worker_id');
            $table->string('service_name');

            $table->decimal('full_payment', 10, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->decimal('received_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->nullable();

            $table->text('comment')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_payments');
    }
};
