<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('service_requests', function (Blueprint $table) {
        $table->integer('quantity')->default(1);
        $table->decimal('final_amount', 10, 2)->nullable();
        $table->decimal('remaining_amount', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('service_requests', function (Blueprint $table) {
        $table->dropColumn(['quantity','final_amount','remaining_amount']);
    });
}

};
