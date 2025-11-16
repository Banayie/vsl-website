@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Danh sách người dùng')

@section('content')

    @if (session('success'))
        <div style="background:#d4edda; padding:10px; border-left:4px solid #28a745; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.users.create') }}"
        style="padding:10px 16px; background:#4CAF50; color:white; border-radius:6px; text-decoration:none;">
        + Thêm người dùng
    </a>

    <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        <thead>
            <tr style="background:#eee;">
                <th style="padding:10px; border:1px solid #ddd;">ID</th>
                <th style="padding:10px; border:1px solid #ddd;">Tên</th>
                <th style="padding:10px; border:1px solid #ddd;">Email</th>
                <th style="padding:10px; border:1px solid #ddd;">Vai trò</th>
                <th style="padding:10px; border:1px solid #ddd;">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $u->id }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $u->name }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">{{ $u->email }}</td>
                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ $u->role === 'admin' ? 'Admin' : 'Người dùng' }}
                    </td>
                    <td style="padding:10px; border:1px solid #ddd;">
                        <a href="{{ route('admin.users.edit', $u->id) }}" style="color:#1976D2;">Sửa</a>

                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button onclick="return confirm('Xóa người dùng này?')"
                                style="color:#e57373; background:none; border:none; cursor:pointer;">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

@endsection