<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('service_payments', function (Blueprint $table) {

        if (!Schema::hasColumn('service_payments', 'quantity')) {
            $table->integer('quantity')->default(1)->after('service_name');
        }

        if (!Schema::hasColumn('service_payments', 'final_amount')) {
            $table->decimal('final_amount', 10, 2)->nullable()->after('received_amount');
        }

        if (!Schema::hasColumn('service_payments', 'payment_status')) {
            $table->enum('payment_status', ['pending', 'done'])
                  ->default('pending')
                  ->after('remaining_amount');
        }

    });
}

    public function down(): void
    {
        Schema::table('service_payments', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'final_amount', 'payment_status']);
        });
    }
};
