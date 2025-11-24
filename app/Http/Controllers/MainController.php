<?php

namespace App\Http\Controllers;
use App\Models\UserProgress;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        return redirect()->route('study');
    }
    public function dictionary()
    {
        return view('dictionary');
    }

    public function translator()
    {
        return view('translator');
    }
    // Profile
    public function profile()
    {
        // return view('profile');
        $user = auth()->user();
        $userId = $user->id;

        // Tổng từ vựng đã học (bằng số bài học hoàn thành)
        $learnedVocabulary = UserProgress::where('user_id', $userId)
            ->where('progress', 100)
            ->count();

        // Tổng bài học đã hoàn thành (nhưng theo topic = topic completed)
        $topics = Topic::with('lessons')->get();


        $completedTopics = 0;

        foreach ($topics as $topic) {

            $totalLessons = $topic->lessons->count();

            if ($totalLessons === 0)
                continue; // skip topic rỗng

            $doneLessons = UserProgress::where('user_id', $userId)
                ->whereIn('lesson_id', $topic->lessons->pluck('id'))
                ->where('progress', 100)
                ->count();

            if ($doneLessons == $totalLessons) {
                $completedTopics++;
            }
        }


        // Ngày học liên tiếp (sau)
        $dates = UserProgress::where('user_id', $userId)
            ->where('progress', 100)
            ->orderBy('completed_at', 'desc')
            ->pluck('completed_at')
            ->map(function ($d) {
                return Carbon::parse($d)->format('Y-m-d');
            })
            ->unique()
            ->values();

        $streak = 0;
        $today = Carbon::today()->format('Y-m-d');

        // Nếu user chưa học gì → streak = 0
        if ($dates->count() > 0) {

            // Nếu hôm nay có học → streak bắt đầu từ today
            if ($dates->contains($today)) {
                $streak = 1;
                $current = Carbon::today();
            } else {
                // Nếu hôm nay chưa học → chỉ bắt đầu từ ngày gần nhất
                $current = Carbon::parse($dates[0]);
                $streak = 1;
            }

            // Duyệt tiếp
            for ($i = 1; $i < $dates->count(); $i++) {
                $previous = Carbon::parse($dates[$i]);

                if ($previous->diffInDays($current) === 1) {
                    $streak++;
                    $current = $previous;
                } else {
                    break;
                }
            }
        }

        return view('profile', compact(
            'user',
            'completedTopics',
            'learnedVocabulary',
            'streak'
        ));
    }



}