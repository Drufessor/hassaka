<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Insert new roles
        DB::table('roles')->insert([
            ['name' => 'teknisi', 'description' => 'Technical staff role'],
            ['name' => 'finance', 'description' => 'Finance staff role']
        ]);
    }

    public function down()
    {
        // Remove the roles
        DB::table('roles')->whereIn('name', ['teknisi', 'finance'])->delete();
    }
}; 