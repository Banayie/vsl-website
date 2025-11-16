<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
            'role' =>'admin'
        ]);
        \App\Models\User::create([
            'name' => 'Tue',
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user'
        ]);
    }

}
