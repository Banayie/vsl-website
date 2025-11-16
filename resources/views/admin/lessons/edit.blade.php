@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài học')
@section('page-title', 'Chỉnh sửa bài học')

@section('content')

    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">

        @csrf

        <label>Chủ đề</label>
        <select name="topic_id" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">
            @foreach ($topics as $topic)
                <option value="{{ $topic->id }}" {{ $lesson->topic_id == $topic->id ? 'selected' : '' }}>
                    {{ $topic->title }}
                </option>
            @endforeach
        </select>

        <label>Tiêu đề bài học</label>
        <input type="text" name="title" value="{{ $lesson->title }}" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">

        <label>Nội dung</label>
        <textarea name="content" rows="6" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">
            {{ $lesson->content }}
        </textarea>

        <label>Video hiện tại:</label>
        @if ($lesson->video_url)
            <p>
                <a href="{{ asset('storage/videos/' . $lesson->video_url) }}" target="_blank">Xem video</a>
            </p>
        @else
            <p>Không có video</p>
        @endif

        <label>Thay video mới (tùy chọn):</label>
        <input type="file" name="video" accept="video/*" style="margin-bottom:20px;">

        <button type="submit" style="padding:12px 20px; background:#1976D2; color:white; border:none; border-radius:6px;">
            Cập nhật
        </button>
    </form>

@endsection