<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_queries_table.php
    public function up(): void
    {
      Schema::create('queries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
    $table->text('message');
    $table->text('response')->nullable();
    $table->boolean('read_by_client')->default(false); // essential
    $table->timestamps();
});

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
