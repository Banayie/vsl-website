<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Topic;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // ────────────────────────────────────────────────
        // Chủ đề 1: Bảng Chữ Cái (theo video thực tế)
        // ────────────────────────────────────────────────
        $topic1 = Topic::where('title', 'LIKE', '%Bảng Chữ Cái%')->first();

        if ($topic1) {
            // Danh sách chữ cái theo đúng video
            $alphabetVideos = [
                'a' => 'a.mp4',
                'b' => 'b.mp4',
                'c' => 'c.mp4',
                'd' => 'd.mp4',
                'đ' => 'd9.mp4',
                'e' => 'e.mp4',
                'g' => 'g.mp4',
                'h' => 'h.mp4',
                'i' => 'i.mp4',
                'k' => 'k.mp4',
                'l' => 'l.mp4',
                'm' => 'm.mp4',
                'n' => 'n.mp4',
                'o' => 'o.mp4',
                'p' => 'p.mp4',
                'q' => 'q.mp4',
                'r' => 'r.mp4',
                's' => 's.mp4',
                't' => 't.mp4',
                'u' => 'u.mp4',
                'v' => 'v.mp4',
                'x' => 'x.mp4',
                'y' => 'y.mp4',
            ];

            foreach ($alphabetVideos as $letter => $file) {
                Lesson::create([
                    'topic_id' => $topic1->id,
                    'title' => "Chữ cái $letter",
                    'content' => "Hướng dẫn ký hiệu tay của chữ cái $letter.",
                    'video_url' => "$file",
                ]);
            }
        }

        // ────────────────────────────────────────────────
        // Chủ đề 2: Số Đếm (1-10)
        // ────────────────────────────────────────────────
        $topic2 = Topic::where('title', 'LIKE', '%Số Đếm%')->first();

        if ($topic2) {
            for ($i = 1; $i <= 10; $i++) {
                Lesson::create([
                    'topic_id' => $topic2->id,
                    'title' => "Số $i",
                    'content' => "Hướng dẫn ký hiệu tay cho số $i.",
                    'video_url' => null,
                ]);
            }
        }

        // ────────────────────────────────────────────────
        // Các chủ đề khác: mỗi chủ đề 5 bài demo
        // ────────────────────────────────────────────────
        $otherTopics = Topic::where('id', '>', 2)->get();

        foreach ($otherTopics as $topic) {
            for ($i = 1; $i <= 5; $i++) {
                Lesson::create([
                    'topic_id' => $topic->id,
                    'title' => "Bài $i của {$topic->title}",
                    'content' => "Nội dung bài $i thuộc {$topic->title}.",
                    'video_url' => null,
                ]);
            }
        }
    }
}
