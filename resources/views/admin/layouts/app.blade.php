<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            background: #f0f2f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #ffffff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            color: #4a5568;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.04);
        }
        
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            letter-spacing: 1px;
            color: #1a1a1a;
            font-weight: 700;
        }
        
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #4a5568;
            font-size: 15px;
            text-decoration: none;
            transition: 0.2s;
            margin: 4px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .sidebar a:hover {
            background: #f8f9fb;
            color: #1a1a1a;
        }
        
        .sidebar a.active {
            background: #e8eaff;
            color: #6366f1;
            font-weight: 600;
        }
        
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        
        .topbar {
            background: white;
            padding: 20px 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        
        .topbar h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .username {
            font-weight: 600;
            color: #1a1a1a;
            padding: 8px 16px;
            background: #f8f9fb;
            border-radius: 8px;
            font-size: 14px;
        }
        
        form button[type="submit"] {
            background: none;
            border: none;
            color: #718096;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 15px;
            text-align: left;
            width: calc(100% - 24px);
            margin: 4px 12px;
            border-radius: 8px;
            transition: 0.2s;
            font-weight: 500;
        }
        
        form button[type="submit"]:hover {
            background: #fef2f2;
            color: #e53e3e;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.topics') }}" class="{{ request()->routeIs('admin.topics') ? 'active' : '' }}">Quản lý chủ đề</a>
        <a href="{{ route('admin.lessons') }}" class="{{ request()->routeIs('admin.lessons') ? 'active' : '' }}">Quản lý bài học</a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Quản lý người dùng</a>
        <a href="#">Cập nhật model</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 30px;">
            @csrf
            <button type="submit">
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