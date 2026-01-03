<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_payments', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('service_name');
            $table->decimal('final_amount', 10, 2)->nullable()->after('received_amount');
            $table->enum('payment_status', ['pending', 'done'])->default('pending')->after('remaining_amount');
        });
    }

    public function down(): void
    {
        Schema::table('service_payments', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'final_amount', 'payment_status']);
        });
    }
};
