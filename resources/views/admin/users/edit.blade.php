@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa người dùng')
@section('page-title', 'Chỉnh sửa: ' . $user->name)

@section('content')

    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf

        <label>Họ và tên</label>
        <input type="text" name="name" value="{{ $user->name }}" required
            style="width:100%; padding:10px; margin-bottom:15px;">

        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required
            style="width:100%; padding:10px; margin-bottom:15px;">

        <label>Vai trò</label>
        <select name="role" style="width:100%; padding:10px; margin-bottom:15px;">
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Người dùng</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <label>Mật khẩu mới (tùy chọn)</label>
        <input type="password" name="password" placeholder="Nếu không đổi thì để trống"
            style="width:100%; padding:10px; margin-bottom:20px;">

        <button type="submit" style="padding:12px 20px; background:#1976D2; color:white; border:none; border-radius:6px;">
            Cập nhật
        </button>
    </form>

@endsection