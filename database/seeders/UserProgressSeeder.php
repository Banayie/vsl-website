<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\UserProgress;
use Carbon\Carbon;

class UserProgressSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get(); // không seed cho admin
        $topics = Topic::all();

        foreach ($users as $user) {

            foreach ($topics as $topic) {
                $lessons = Lesson::where('topic_id', $topic->id)->get();

                if ($lessons->isEmpty())
                    continue;

                // Random số bài học mà user đã hoàn thành
                $totalLessons = $lessons->count();
                $completedCount = rand(0, $totalLessons); // số bài đã hoàn thành

                // Random ngày để test streak
                $baseDate = Carbon::today()->subDays(rand(0, 6));

                foreach ($lessons as $index => $lesson) {

                    $isCompleted = $index < $completedCount;

                    UserProgress::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'lesson_id' => $lesson->id
                        ],
                        [
                            'progress' => $isCompleted ? 100 : 0,
                            'completed_at' => $isCompleted ? $baseDate->copy()->addMinutes(rand(1, 500)) : null,
                            'updated_at' => now(),
                            'created_at' => now()
                        ]
                    );
                }
            }
        }
    }
}
