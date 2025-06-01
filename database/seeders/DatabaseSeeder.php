<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles if not exists
        $ownerRoleId = DB::table('roles')->insertGetId([
            'name' => 'owner',
            'description' => 'Owner role with full access'
        ]);

        $adminRoleId = DB::table('roles')->insertGetId([
            'name' => 'admin',
            'description' => 'Administrator role'
        ]);

        $marketingRoleId = DB::table('roles')->insertGetId([
            'name' => 'marketing',
            'description' => 'Marketing role'
        ]);

        $teknisiRoleId = DB::table('roles')->insertGetId([
            'name' => 'teknisi',
            'description' => 'Technical staff role'
        ]);

        $financeRoleId = DB::table('roles')->insertGetId([
            'name' => 'finance',
            'description' => 'Finance staff role'
        ]);

        // Create default users
        User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $ownerRoleId,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRoleId,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Marketing',
            'email' => 'marketing@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $marketingRoleId,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Teknisi',
            'email' => 'teknisi@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $teknisiRoleId,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Finance',
            'email' => 'finance@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $financeRoleId,
            'email_verified_at' => now()
        ]);

        // Run the TechnisiFinanceUserSeeder
        // $this->call(TechnisiFinanceUserSeeder::class);

        $this->call([
            InsightSeeder::class,
        ]);
    }
}
