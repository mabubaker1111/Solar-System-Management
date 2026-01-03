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
        Schema::table('service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('service_requests', 'worker_id')) {
                $table->unsignedBigInteger('worker_id')->nullable()->after('service_id');
            }
        });
    }


    public function down()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['worker_id']);
            $table->dropColumn('worker_id');
        });
    }
};
