@extends('layouts.app')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);
        min-height: 100vh;
    }

    .profile-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 20px;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 32px;
    }

    /* Left panel (User info) */
    .sidebar-card {
        background: white;
        border: none;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(255, 107, 129, 0.12);
        border-top: 4px solid #e57373;
    }

    .avatar-box {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 16px auto;
        border: 4px solid #FFE4E9;
        box-shadow: 0 4px 12px rgba(255, 107, 129, 0.2);
    }

    .avatar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e57373 0%, #FFB3C1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 52px;
        font-weight: 700;
    }

    .username {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        margin-top: 12px;
        color: #2D3748;
        letter-spacing: -0.3px;
    }

    .user-email {
        text-align: center;
        font-size: 14px;
        color: #94A3B8;
        margin-bottom: 20px;
    }

    .edit-btn {
        display: block;
        text-align: center;
        background: linear-gradient(135deg, #FF6B81 0%, #FF8FA3 100%);
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 107, 129, 0.3);
    }

    .edit-btn:hover {
        background: linear-gradient(135deg, #FF5A73 0%, #FF7A92 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 107, 129, 0.4);
    }

    /* Main content */
    .content-area {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .card {
        background: white;
        padding: 28px 32px;
        border-radius: 20px;
        border: none;
        box-shadow: 0 8px 24px rgba(255, 107, 129, 0.12);
        border-top: 4px solid #e57373;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #2D3748;
        margin-bottom: 24px;
        letter-spacing: -0.3px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .stat-box {
        border: none;
        padding: 24px;
        border-radius: 16px;
        background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E9 100%);
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 107, 129, 0.08);
    }

    .stat-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(255, 107, 129, 0.15);
    }

    .stat-label {
        font-size: 14px;
        color: #64748B;
        margin-bottom: 12px;
        display: block;
        font-weight: 500;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, #FF6B81 0%, #FF8FA3 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Logout */
    .logout-btn {
        width: 100%;
        padding: 12px 0;
        font-weight: 600;
        font-size: 15px;
        color: #FF6B81;
        border: 2px solid #FFE4E9;
        background: white;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E9 100%);
        border-color: #e57373;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 129, 0.2);
    }

    /* Mobile */
    @media (max-width: 900px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-wrapper">
    <!-- Sidebar -->
    <div class="sidebar-card">
        <div class="avatar-box">
            @if (Auth::user()->avatar)
                <img src="{{ Storage::url('avatars/' . Auth::user()->avatar) }}">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="username">{{ Auth::user()->name }}</div>
        <div class="user-email">{{ Auth::user()->email }}</div>

        <a href="{{ route('profile.edit') }}" class="edit-btn">Chỉnh sửa hồ sơ</a>
    </div>

    <!-- Main Content -->
    <div class="content-area">
        <div class="card">
            <div class="section-title">Thống kê học tập</div>
            <div class="stats-grid">
                <div class="stat-box">
                    <span class="stat-label">📚 Bài học đã hoàn thành</span>
                    <div class="stat-value">0</div>
                </div>

                <div class="stat-box">
                    <span class="stat-label">📖 Từ vựng đã học</span>
                    <div class="stat-value">0</div>
                </div>

                <div class="stat-box">
                    <span class="stat-label">🔥 Ngày học liên tiếp</span>
                    <div class="stat-value">0</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="section-title">Cài đặt</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">Đăng xuất</button>
            </form>
        </div>
    </div>
</div>

@endsection