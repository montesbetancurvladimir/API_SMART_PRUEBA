<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@smart_talent.co',
            'password' => Hash::make('admin123'),
            'enable' => true,
            'role' => 'admin',
            'phone' => '3225164187',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
