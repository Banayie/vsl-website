<meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Học ngôn ngữ ký hiệu')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            padding-bottom: 80px;
        }

        .navigation-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #757575;
            padding: 5px 20px;
            transition: color 0.3s;
            cursor: pointer;
        }

        .nav-item.active {
            color: #e57373;
        }

        .nav-item:hover {
            color: #e57373;
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 4px;
        }

        .nav-label {
            font-size: 12px;
            font-weight: 500;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #757575;
            margin-bottom: 30px;
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        @media (max-width: 768px) {
            .topics-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .topics-grid {
                grid-template-columns: 1fr;
            }
        }

        .topic-card {
            background: white;
            border: 2px solid #333;
            border-radius: 12px;
            padding: 24px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .topic-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .topic-card {
                padding: 20px;
            }
        }

        .topic-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
        }

        .start-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            padding: 0;
        }

        .start-button::before {
            content: '▶';
            font-size: 12px;
        }

        .content-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .content-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .content-text {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="main-content">
        @yield('content')
    </div>

    <nav class="navigation-bottom">
        <a href="{{ route('study') }}" class="nav-item {{ request()->routeIs('study') ? 'active' : '' }}">
            <svg class="nav-icon" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
            </svg>
            <span class="nav-label">Học</span>
        </a>

        <a href="{{ route('dictionary') }}" class="nav-item {{ request()->routeIs('dictionary') ? 'active' : '' }}">
            <svg class="nav-icon" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z" />
            </svg>
            <span class="nav-label">Từ Điển</span>
        </a>

        <a href="{{ route('translator') }}" class="nav-item {{ request()->routeIs('translator') ? 'active' : '' }}">
            <svg class="nav-icon" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12.87 15.07l-2.54-2.51.03-.03c1.74-1.94 2.98-4.17 3.71-6.53H17V4h-7V2H8v2H1v1.99h11.17C11.5 7.92 10.44 9.75 9 11.35 8.07 10.32 7.3 9.19 6.69 8h-2c.73 1.63 1.73 3.17 2.98 4.56l-5.09 5.02L4 19l5-5 3.11 3.11.76-2.04zM18.5 10h-2L12 22h2l1.12-3h4.75L21 22h2l-4.5-12zm-2.62 7l1.62-4.33L19.12 17h-3.24z" />
            </svg>
            <span class="nav-label">Dịch Thuật</span>
        </a>

        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <svg class="nav-icon" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            <span class="nav-label">Hồ Sơ</span>
        </a>
    </nav>
</body>
@if (session('success'))
    <div style="background:#d4edda; padding:12px; border-left:5px solid #28a745; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="background:#f8d7da; padding:12px; border-left:5px solid #dc3545; margin-bottom:20px;">
        {{ session('error') }}
    </div>
@endif
</html>