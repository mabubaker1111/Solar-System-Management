<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Modify existing enum
        DB::statement("ALTER TABLE service_requests MODIFY status ENUM('pending','approved','rejected','assigned','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Remove 'cancelled' if rollback
        DB::statement("ALTER TABLE service_requests MODIFY status ENUM('pending','approved','rejected','assigned','completed') NOT NULL DEFAULT 'pending'");
    }
};
