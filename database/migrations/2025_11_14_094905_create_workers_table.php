<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('skill')->nullable();
            $table->string('experience')->nullable();
            $table->enum('status', ['free', 'busy', 'pending', 'approved'])->default('pending');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('business_id')->references('id')->on('businesses');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('workers');
        Schema::enableForeignKeyConstraints();
    }
};
