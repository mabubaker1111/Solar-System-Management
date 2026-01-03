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
        Schema::table('workers', function (Blueprint $table) {
            if (!Schema::hasColumn('workers', 'shift_start')) {
                $table->time('shift_start')->nullable()->after('status');
            }
            if (!Schema::hasColumn('workers', 'shift_end')) {
                $table->time('shift_end')->nullable()->after('shift_start');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            if (Schema::hasColumn('workers', 'shift_start')) {
                $table->dropColumn('shift_start');
            }
            if (Schema::hasColumn('workers', 'shift_end')) {
                $table->dropColumn('shift_end');
            }
        });
    }
};
