@extends('admin.layouts.app')

@section('title', 'Tạo bài học')
@section('page-title', 'Tạo bài học mới')

@section('content')

    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Chủ đề</label>
        <select name="topic_id" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">
            <option value="">-- Chọn chủ đề --</option>
            @foreach ($topics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->title }}</option>
            @endforeach
        </select>

        <label>Tiêu đề bài học</label>
        <input type="text" name="title" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;">

        <label>Nội dung</label>
        <textarea name="content" rows="6" required
            style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px;"></textarea>

        <label>Video bài học (tùy chọn)</label>
        <input type="file" name="video" accept="video/*" style="margin-bottom:20px;">

        <button type="submit" style="padding:12px 20px; background:#4CAF50; color:white; border:none; border-radius:6px;">
            Tạo bài học
        </button>
    </form>

@endsection