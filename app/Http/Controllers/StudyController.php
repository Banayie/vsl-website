<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\UserProgress;
class StudyController extends Controller
{
    //
    public function topics()
    {
        $userId = auth()->id();

        $topics = Topic::withCount('lessons')
            ->with([
                'lessons.progress' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)->where('progress', 100);
                }
            ])
            ->get();

        // Tính % hoàn thành
        foreach ($topics as $topic) {
            $completed = 0;

            foreach ($topic->lessons as $lesson) {
                if ($lesson->progress->count() > 0) {
                    $completed++;
                }
            }

            $topic->progressPercent = $topic->lessons_count
                ? round(($completed / $topic->lessons_count) * 100)
                : 0;
        }

        return view('study.topic', compact('topics'));
    }

    public function lessonDetail(Lesson $lesson)
    {
        return view('study.lesson_detail', compact('lesson'));
    }

    public function study()
    {
        $userId = auth()->id();

        $topics = Topic::withCount('lessons')
            ->with([
                'lessons.progress' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)->where('progress', 100);
                }
            ])
            ->get();

        foreach ($topics as $topic) {
            $completed = 0;
            foreach ($topic->lessons as $lesson) {
                if ($lesson->progress->count() > 0) {
                    $completed++;
                }
            }

            $topic->progressPercent = $topic->lessons_count == 0
                ? 0
                : round(($completed / $topic->lessons_count) * 100);
        }

        return view('study.topic', compact('topics'));
    }

    public function topicDetail($topicId)
    {
        $userId = auth()->id();

        $topic = Topic::findOrFail($topicId);

        $lessons = Lesson::where('topic_id', $topicId)
            ->with([
                'progress' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ])
            ->get();

        return view('study.topic_detail', compact('topic', 'lessons'));
    }
    public function completeLesson(Request $request, $lessonId)
    {
        $userId = auth()->id();

        UserProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ],
            [
                'progress' => 100,
                'completed_at' => now()
            ]
        );

        return response()->json(['success' => true]);
    }




}
