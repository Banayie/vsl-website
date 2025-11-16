@extends('admin.layouts.app')

@section('title', 'Quản lý chủ đề')

@section('content')
    <h1 class="page-title">Quản lý chủ đề</h1>

    @if(session('success'))
        <div style="background:#d4edda; padding:10px; margin-bottom:10px; border-left:4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.topics.create') }}" style="padding:10px; background:#1976D2; color:white; border-radius:6px;">
        + Thêm chủ đề
    </a>

    <div class="content-box" style="margin-top:20px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:8px;">ID</th>
                    <th style="padding:8px;">Tiêu đề</th>
                    <th style="padding:8px;">Mô tả</th>
                    <th style="padding:8px;">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td style="padding:8px;">{{ $topic->id }}</td>
                        <td style="padding:8px;">{{ $topic->title }}</td>
                        <td style="padding:8px;">{{ $topic->description }}</td>
                        <td>
                            <a href="{{ route('admin.topics.edit', $topic->id) }}"
                                style="color:#1976D2; margin-right:10px;">Sửa</a>

                            <form method="POST" action="{{ route('admin.topics.delete', $topic->id) }}" style="display:inline;"
                                onsubmit="return confirm('Xoá chủ đề?');">
                                @csrf
                                @method('DELETE')
                                <button style="border:none; background:none; color:#e57373; cursor:pointer;">
                                    Xoá
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection