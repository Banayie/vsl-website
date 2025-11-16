@extends('layouts.app')

@section('title', 'Cập nhật thông tin')

@section('content')
    <div style="max-width: 500px; margin: 0 auto;">

        <h1 class="page-title">Cập nhật hồ sơ</h1>

        {{-- THÔNG BÁO --}}
        @if (session('success'))
            <div style="background: #d4edda; padding:10px; border-left:5px solid #28a745; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background:#ffdddd; padding:10px; border-left:5px solid red; margin-bottom: 15px;">
                {{ session('error') }}
            </div>
        @endif

        {{-- ======================
        CẬP NHẬT AVATAR
        ======================= --}}
        <div class="content-box" style="margin-bottom: 25px;">
            <h3 style="margin-bottom: 10px;">Ảnh đại diện</h3>

            <div style="text-align:center;">
                <label for="avatarInput" style="cursor:pointer; display:inline-block;">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url('avatars/' . Auth::user()->avatar) }}"
                            style="width:80px; height:80px; border-radius:50%; object-fit:cover;">
                    @else
                        <div style="
                                        width:100px; height:100px; border-radius:50%;
                                        background:#ccc; display:flex;
                                        justify-content:center; align-items:center;
                                        font-size:40px; color:#fff;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </label>

                <form id="avatarForm" action="{{ route('profile.updateAvatar') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar" id="avatarInput" style="display:none;" accept="image/*"
                        onchange="document.getElementById('avatarForm').submit()">
                </form>

                <p style="font-size:13px; color:#666; margin-top:8px;">
                    (Nhấn vào ảnh để chọn ảnh mới)
                </p>
            </div>
        </div>

        {{-- ======================
        CẬP NHẬT THÔNG TIN
        ======================= --}}
        <div class="content-box" style="margin-bottom: 25px;">
            <h3 style="margin-bottom: 15px;">Thông tin cá nhân</h3>

            <form action="{{ route('profile.updateInfo') }}" method="POST" onsubmit="return confirmPasswordPopup(event)">
                @csrf

                <label>Họ và tên</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

                {{-- Mật khẩu xác nhận --}}
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="password_confirm" placeholder="Nhập mật khẩu để xác nhận" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:20px;">

                <button type="submit"
                    style="width:100%; padding:10px; background:#1976D2; color:#fff; border:none; border-radius:6px; font-size:16px;">
                    Lưu thay đổi
                </button>
            </form>
        </div>

        {{-- ======================
        ĐỔI MẬT KHẨU
        ======================= --}}
        <div class="content-box">
            <h3 style="margin-bottom: 15px;">Đổi mật khẩu</h3>

            <form action="{{ route('profile.updatePassword') }}" method="POST">
                @csrf

                <label>Mật khẩu hiện tại</label>
                <input type="password" name="current_password" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

                <label>Mật khẩu mới</label>
                <input type="password" name="new_password" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:15px;">

                <label>Xác nhận mật khẩu mới</label>
                <input type="password" name="new_password_confirmation" required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; margin-bottom:20px;">

                <button type="submit"
                    style="width:100%; padding:10px; background:#e57373; color:#fff; border:none; border-radius:6px; font-size:16px;">
                    Đổi mật khẩu
                </button>
            </form>
        </div>
    </div>

    {{-- ======================
    JS XÁC NHẬN MẬT KHẨU
    ====================== --}}
    <script>
        function confirmPasswordPopup(event) {
            const pass = event.target.querySelector("input[name='password_confirm']").value;
            if (!pass) {
                alert("Vui lòng nhập mật khẩu để xác nhận!");
                return false;
            }
            return true;
        }
    </script>

@endsection