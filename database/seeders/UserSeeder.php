<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Admin',
                'password' => bcrypt('12345678'),
                'avatar' => '1763085566_484643852_940877374922356_8775914026081731720_n.jpg',
                'role' => 'admin'
            ]
        );
        User::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Tue',
                'password' => bcrypt('12345678'),
                'avatar' => "1763084769_ba7b058bf9a275fc2cb3.jpg",
                'role' => 'user'
            ]
        );
        $extraUsers = [
            ['name' => 'Linh', 'email' => 'linh@mail.com'],
            ['name' => 'Khoa', 'email' => 'khoa@mail.com'],
            ['name' => 'My', 'email' => 'my@mail.com'],
            ['name' => 'Huy', 'email' => 'huy@mail.com'],
            ['name' => 'Trang', 'email' => 'trang@mail.com'],
        ];

        foreach ($extraUsers as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => bcrypt('12345678'),
                    'avatar' => null,
                    'role' => 'user'
                ]
            );
        }
    }

}
