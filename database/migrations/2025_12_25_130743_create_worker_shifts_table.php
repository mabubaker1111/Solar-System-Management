<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_shifts');
    }
};
