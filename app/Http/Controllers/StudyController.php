<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Lesson;
class StudyController extends Controller
{
    //
    public function topics()
    {
        $topics = Topic::all();   // lấy tất cả chủ đề
        return view('study.topic', compact('topics'));
    }
    public function topicDetail(Topic $topic)
    {
        $lessons = $topic->lessons;  // <-- quan trọng

        return view('study.topic_detail', compact('topic', 'lessons'));
    }
    public function lessonDetail(Lesson $lesson)
    {
        return view('study.lesson_detail', compact('lesson'));
    }

}
