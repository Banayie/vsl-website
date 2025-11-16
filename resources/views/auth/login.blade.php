@extends('layouts.app')

@section('content')
<div style="max-width: 420px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 10px; border:1px solid #ddd;">
    <h2 style="text-align:center; margin-bottom:20px;">Đăng nhập</h2>

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div style="background:#ffdddd; padding:10px; border-left:5px solid red; margin-bottom:15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        {{-- Email --}}
        <label>Email</label>
        <input type="email" name="email" required
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

        {{-- Password --}}
        <label>Mật khẩu</label>
        <input type="password" name="password" required
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

        <button type="submit"
                style="width:100%; padding:10px; border:none; background:#4CAF50; 
                       color:#fff; border-radius:6px; font-size:16px;">
            Đăng nhập
        </button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        Chưa có tài khoản?  
        <a href="{{ route('register') }}">Đăng ký ngay</a>
    </p>
</div>
@endsection
