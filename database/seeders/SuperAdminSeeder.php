<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
DB::table('users')->insert([
    'name' => 'Super Admin',
    'email' => 'noorafifi@example.net',
    'password' => Hash::make('password'),
    'created_at' => now(),
    'updated_at' => now(),
]);
}

}
