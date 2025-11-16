<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>

    <style>
        body {
            margin: 0;
            background: #f5f6fa;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #1e1e2d;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            color: #fff;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #cfd1d8;
            font-size: 15px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #27293d;
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 30px;
        }

        .topbar {
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .username {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>ADMIN PANEL</h2>

        <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('admin.topics') }}">📚 Quản lý chủ đề</a>
        <a href="{{ route('admin.lessons') }}">📘 Quản lý bài học</a>
        <a href="{{ route('admin.users') }}">👥 Quản lý người dùng</a>
        <a href="#">📘 Cập nhật model</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 30px;">
            @csrf
            <button type="submit"
                style="background:none;border:none;color:#ff6b6b;padding:12px 20px;cursor:pointer;font-size:15px;text-align:left;width:100%;">
                Đăng xuất
            </button>
        </form>
    </div>

    <div class="content">
        <div class="topbar">
            <h2>@yield('page-title')</h2>
            <span class="username">{{ Auth::user()->name }}</span>
        </div>

        @yield('content')
    </div>

</body>

</html>