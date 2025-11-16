@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Trang quản trị')

@section('content')

    <div style="
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 1px 4px rgba(0,0,0,0.1);
        ">
        <h3>Xin chào, {{ Auth::user()->name }} 👋</h3>
        <p>Chào mừng bạn đến trang quản trị hệ thống.</p>

        <div style="margin-top:20px; display:flex; gap:20px;">

            <div style="
                    background:#f8f9fa;
                    padding:20px;
                    border-radius:8px;
                    width:200px;
                    text-align:center;
                    box-shadow:0 1px 4px rgba(0,0,0,0.1);
                ">
                <h2>🎓</h2>
                <h3>8 Chủ đề</h3>
            </div>

            <div style="
                    background:#f8f9fa;
                    padding:20px;
                    border-radius:8px;
                    width:200px;
                    text-align:center;
                    box-shadow:0 1px 4px rgba(0,0,0,0.1);
                ">
                <h2>📘</h2>
                <h3>56 Bài học</h3>
            </div>

            <div style="
                    background:#f8f9fa;
                    padding:20px;
                    border-radius:8px;
                    width:200px;
                    text-align:center;
                    box-shadow:0 1px 4px rgba(0,0,0,0.1);
                ">
                <h2>👤</h2>
                <h3>{{ \App\Models\User::count() }} Người dùng</h3>
            </div>

        </div>

    </div>

@endsection