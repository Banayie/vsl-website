@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa bài học')
@section('page-title', 'Chỉnh sửa bài học')
@section('content')
    <style>
        .alert-error {
            background: #fee;
            padding: 14px 18px;
            border-left: 4px solid #e53e3e;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #c53030;
            font-size: 14px;
        }

        .form-container {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            max-width: 800px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-select,
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-select:focus,
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-file {
            padding: 10px 0;
            font-size: 14px;
        }

        .video-info {
            background: #f8f9fb;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .video-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .video-link:hover {
            text-decoration: underline;
        }

        .btn-update {
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-update:hover {
            background: #5558e3;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
    </style>

    @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Chủ đề</label>
                <select name="topic_id" required class="form-select">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}" {{ $lesson->topic_id == $topic->id ? 'selected' : '' }}>
                            {{ $topic->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Tiêu đề bài học</label>
                <input type="text" name="title" value="{{ $lesson->title }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Nội dung</label>
                <textarea name="content" rows="6" required class="form-textarea">{{ $lesson->content }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Video hiện tại:</label>
                <div class="video-info">
                    @if ($lesson->video_url)
                        <!-- <a href="{{ asset('storage/videos/' . $lesson->video_url) }}" target="_blank" class="video-link"> -->
                        <a href="{{ asset('videos/' . $lesson->video_url) }}" target="_blank">
                            Xem video
                        </a>
                    @else
                        <span style="color: #718096;">Không có video</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Thay video mới (tùy chọn):</label>
                <input type="file" name="video" accept="video/*" class="form-file">
            </div>

            <button type="submit" class="btn-update">
                Cập nhật
            </button>
        </form>
    </div>
@endsection