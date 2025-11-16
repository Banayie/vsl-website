@extends('layouts.app')

@section('content')
<div style="max-width: 420px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 10px; border:1px solid #ddd;">
    <h2 style="text-align:center; margin-bottom:20px;">Đăng ký tài khoản</h2>

    {{-- Hiển thị lỗi tổng --}}
    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:5px solid red; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        {{-- Name --}}
        <label>Họ và tên</label>
        <input type="text" name="name" value="{{ old('name') }}"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:5px;" required>
        @error('name')
            <div style="color:red; font-size:13px; margin-bottom:10px;">{{ $message }}</div>
        @enderror

        {{-- Email --}}
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:5px;" required>
        @error('email')
            <div style="color:red; font-size:13px; margin-bottom:10px;">{{ $message }}</div>
        @enderror

        {{-- Password --}}
        <label>Mật khẩu</label>
        <input type="password" name="password"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:5px;" required>
        @error('password')
            <div style="color:red; font-size:13px; margin-bottom:10px;">{{ $message }}</div>
        @enderror

        {{-- Password confirmation --}}
        <label>Nhập lại mật khẩu</label>
        <input type="password" name="password_confirmation"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;" required>

        <button type="submit"
                style="width:100%; padding:10px; background:#4CAF50; color:white; border-radius:6px; border:none; font-size:16px;">
            Đăng ký
        </button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Đã có tài khoản?
        <a href="{{ route('login') }}">Đăng nhập</a>
    </p>
</div>
@endsection
