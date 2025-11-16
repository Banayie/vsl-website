@extends('admin.layouts.app')

@section('title', 'Quản lý bài học')
@section('page-title', 'Danh sách bài học')

@section('content')

    @if (session('success'))
        <div style="background:#d4edda; padding:10px; border-left:4px solid #28a745; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.lessons.create') }}"
        style="padding:10px 16px; background:#4CAF50; color:white; border-radius:6px; text-decoration:none;">
        + Thêm bài học
    </a>

    <div style="margin-top:20px;">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#eee;">
                    <th style="padding:10px; border:1px solid #ddd;">ID</th>
                    <th style="padding:10px; border:1px solid #ddd;">Chủ đề</th>
                    <th style="padding:10px; border:1px solid #ddd;">Tiêu đề</th>
                    <th style="padding:10px; border:1px solid #ddd;">Video</th>
                    <th style="padding:10px; border:1px solid #ddd;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $lesson->id }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $lesson->topic->title }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">{{ $lesson->title }}</td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            @if ($lesson->video_url)
                                <a href="{{ asset('storage/videos/' . $lesson->video_url) }}" target="_blank">
                                    Xem video
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" style="color:#1976D2;">Sửa</a>

                            <form action="{{ route('admin.lessons.delete', $lesson->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                <button onclick="return confirm('Xóa bài học này?')"
                                    style="color:#e57373; background:none; border:none; cursor:pointer;">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

@endsection