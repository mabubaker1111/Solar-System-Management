<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;   // ⚠️ required for default

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('worker_id')->nullable(); // Assigned worker
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->time('time')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'assigned', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('service_requests');
        Schema::enableForeignKeyConstraints();
    }
};
