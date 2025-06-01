<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear the users table safely
        User::query()->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get role IDs
        $adminRoleId = DB::table('roles')->where('name', 'admin')->first()->id;
        $ownerRoleId = DB::table('roles')->where('name', 'owner')->first()->id;
        $marketingRoleId = DB::table('roles')->where('name', 'marketing')->first()->id;
        $teknisiRoleId = DB::table('roles')->where('name', 'teknisi')->first()->id;
        $financeRoleId = DB::table('roles')->where('name', 'finance')->first()->id;

        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRoleId,
            'email_verified_at' => now(),
        ]);

        // Create owner user
        User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $ownerRoleId,
            'email_verified_at' => now(),
        ]);

        // Create marketing user
        User::create([
            'name' => 'Marketing',
            'email' => 'marketing@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $marketingRoleId,
            'email_verified_at' => now(),
        ]);

        // Create technician users
        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $teknisiRoleId,
            'email_verified_at' => now(),
        ]);

        // Create finance users
        User::create([
            'name' => 'Finance',
            'email' => 'finance@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $financeRoleId,
            'email_verified_at' => now(),
        ]);
    }
}
