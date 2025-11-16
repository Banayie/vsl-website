@extends('admin.layouts.app')

@section('title', 'Thêm người dùng')
@section('page-title', 'Tạo người dùng mới')

@section('content')

    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:4px solid red; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <label>Họ và tên</label>
        <input type="text" name="name" required style="width:100%; padding:10px; margin-bottom:15px;">

        <label>Email</label>
        <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:15px;">

        <label>Mật khẩu</label>
        <input type="password" name="password" required style="width:100%; padding:10px; margin-bottom:15px;">

        <label>Vai trò</label>
        <select name="role" style="width:100%; padding:10px; margin-bottom:20px;">
            <option value="user">Người dùng</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" style="padding:12px 20px; background:#4CAF50; color:white; border:none; border-radius:6px;">
            Tạo người dùng
        </button>
    </form>

@endsection