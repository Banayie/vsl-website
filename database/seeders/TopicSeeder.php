<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topic;
class TopicSeeder extends Seeder
{
    public function run()
    {
        $topics = [
            ['title' => 'Chủ đề 1: Bảng Chữ Cái', 'description' => null],
            ['title' => 'Chủ đề 2: Số Đếm', 'description' => null],
            ['title' => 'Chủ đề 3: Lời Chào', 'description' => null],
            ['title' => 'Chủ đề 4: Gia Đình', 'description' => null],
            ['title' => 'Chủ đề 5: Thời Gian', 'description' => null],
            ['title' => 'Chủ đề 6: Màu Sắc', 'description' => null],
            ['title' => 'Chủ đề 7: Thức Ăn', 'description' => null],
            ['title' => 'Chủ đề 8: Động Vật', 'description' => null],
        ];

        foreach ($topics as $topic) {
            Topic::create($topic);
        }
    }
}