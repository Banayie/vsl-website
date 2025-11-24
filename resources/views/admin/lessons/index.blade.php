@extends('admin.layouts.app')
@section('title', 'Quản lý bài học')
@section('page-title', 'Danh sách bài học')
@section('content')
    <style>
        .alert-success {
            background: #d4edda;
            padding: 14px 18px;
            border-left: 4px solid #28a745;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #155724;
            font-size: 14px;
        }

        .btn-add {
            display: inline-block;
            padding: 12px 20px;
            background: #6366f1;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: #5558e3;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-top: 20px;
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead tr {
            background: #f8f9fb;
        }

        .data-table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 14px;
            color: #1a1a1a;
        }

        .data-table tbody tr:hover {
            background: #f8f9fb;
        }

        .link-edit {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            margin-right: 12px;
            transition: color 0.2s;
        }

        .link-edit:hover {
            color: #5558e3;
        }

        .btn-delete {
            color: #e53e3e;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .btn-delete:hover {
            color: #c53030;
        }

        .link-video {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .link-video:hover {
            text-decoration: underline;
        }
    </style>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.lessons.create') }}" class="btn-add">
        + Thêm bài học
    </a>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Chủ đề</th>
                    <th>Tiêu đề</th>
                    <th>Video</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->topic->title }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>
                            @if ($lesson->video_url)
                                <a href="{{ asset('storage/videos/' . $lesson->video_url) }}" target="_blank" class="link-video">
                                    Xem video
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="link-edit">Sửa</a>
                            <form action="{{ route('admin.lessons.delete', $lesson->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Xóa bài học này?')" class="btn-delete">
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