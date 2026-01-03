<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Check if superadmin already exists
        if (!User::where('email', 'super@admin.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'fuunyvedios302@gmail.com',
                'password' => Hash::make('password123'), // aap chahe strong password de sakte ho
                'role' => 'superadmin',
                'status' => 'approved'
            ]);
        }
    }
}
