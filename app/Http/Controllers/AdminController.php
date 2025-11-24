<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Lesson;
use app\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    // =========================
    // DASHBOARD
    // =========================
    public function dashboard()
    {
        $totalTopics = Topic::count();
        $totalLessons = Lesson::count();

        return view('admin.dashboard', compact('totalTopics', 'totalLessons'));
    }

    // =========================
    // QUẢN LÝ CHỦ ĐỀ
    // =========================
    public function topics()
    {
        $topics = Topic::orderBy('id')->get();
        return view('admin.topics.index', compact('topics'));
    }

    public function topicCreate()
    {
        return view('admin.topics.create');
    }

    public function topicStore(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Topic::whereRaw('LOWER(title) = ?', [mb_strtolower($value, 'UTF8')])->exists()) {
                        $fail('Chủ đề này đã tồn tại!');
                    }
                }
            ],
            'description' => 'nullable|string'
        ]);

        Topic::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('admin.topics')->with('success', 'Tạo chủ đề thành công!');
    }

    public function topicEdit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('admin.topics.edit', compact('topic'));
    }

    public function topicUpdate(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $request->validate([
            'title' => [
                'required',
                function ($attribute, $value, $fail) use ($topic) {
                    if (
                        Topic::whereRaw('LOWER(title) = ?', [mb_strtolower($value, 'UTF8')])
                            ->where('id', '!=', $topic->id)
                            ->exists()
                    ) {
                        $fail('Chủ đề này đã tồn tại!');
                    }
                }
            ],
            'description' => 'nullable|string',
        ]);

        $topic->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.topics')->with('success', 'Cập nhật chủ đề thành công!');
    }

    public function topicDelete($id)
    {
        Topic::findOrFail($id)->delete();
        return back()->with('success', 'Xoá chủ đề thành công!');
    }
    public function lessons()
    {
        $lessons = Lesson::with('topic')->orderBy('topic_id', 'asc')->get();
        return view('admin.lessons.index', compact('lessons'));
    }

    // --- CREATE FORM ---
    public function createLesson()
    {
        $topics = Topic::orderBy('id')->get();
        return view('admin.lessons.create', compact('topics'));
    }

    // --- STORE ---
    // public function storeLesson(Request $request)
    // {
    //     $request->validate([
    //         'topic_id' => 'required|exists:topics,id',
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //         'video' => 'nullable|mimes:mp4,mov,avi,wmv,mkv|max:51200'
    //     ]);

    //     $data = $request->only(['topic_id', 'title', 'content']);

    //     if ($request->hasFile('video')) {
    //         $filename = time() . '_' . $request->video->getClientOriginalName();
    //         $path = $request->video->storeAs('videos', $filename, 'public');
    //         $data['video_url'] = $path;
    //     }

    //     Lesson::create($data);

    //     return redirect()->route('admin.lessons')->with('success', 'Tạo bài học thành công!');
    // }
    public function storeLesson(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,mkv|max:51200'
        ]);

        $data = $request->only(['topic_id', 'title', 'content']);

        if ($request->hasFile('video')) {

            // Tạo tên file
            $filename = $request->video->getClientOriginalName();

            // Lưu trực tiếp vào public/videos
            $request->video->storeAs('videos', $filename, 'public');

            // Chỉ lưu tên file vào DB
            $data['video_url'] = $filename;
        }

        Lesson::create($data);

        return redirect()->route('admin.lessons')->with('success', 'Tạo bài học thành công!');
    }


    // --- EDIT FORM ---
    public function editLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $topics = Topic::orderBy('id')->get();

        return view('admin.lessons.edit', compact('lesson', 'topics'));
    }

    // --- UPDATE ---
    public function updateLesson(Request $request, $id)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,mkv|max:51200'
        ]);

        $lesson = Lesson::findOrFail($id);

        $lesson->fill($request->only(['topic_id', 'title', 'content']));

        if ($request->hasFile('video')) {

            if ($lesson->video_url && file_exists(storage_path('app/public/videos/' . $lesson->video_url))) {
                unlink(storage_path('app/public/videos/' . $lesson->video_url));
            }

            $filename = time() . '_' . $request->video->getClientOriginalName();
            $request->video->storeAs('videos', $filename, 'public');
            $lesson->video_url = $filename;
        }

        $lesson->save();

        return redirect()->route('admin.lessons')->with('success', 'Cập nhật bài học thành công!');
    }

    // --- DELETE ---
    public function deleteLesson($id)
    {
        Lesson::destroy($id);
        return back()->with('success', 'Xóa bài học thành công!');
    }

    // =========================
    // QUẢN LÝ NGƯỜI DÙNG
    // =========================

    public function users()
    {
        $users = User::orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Tạo người dùng thành công!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'Xóa người dùng thành công!');
    }

}
