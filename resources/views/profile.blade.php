@extends('layouts.app')

@section('title', 'Hồ Sơ')

@section('content')
<div>
    <h1 class="page-title">Hồ Sơ Cá Nhân</h1>
    <p class="page-subtitle">Quản lý thông tin và tiến độ học tập</p>

    <div class="content-box">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e57373, #f06292); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 600;">
                U
            </div>
            <div>
                <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 4px;">Người dùng</h2>
                <p style="color: #757575; font-size: 14px;">user@example.com</p>
            </div>
        </div>

        <div style="border-top: 1px solid #e0e0e0; padding-top: 20px;">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #333;">Thống kê học tập</h3>
            
            <div style="display: grid; gap: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f5f5f5; border-radius: 8px;">
                    <span style="color: #666;">Bài học đã hoàn thành</span>
                    <strong style="color: #e57373; font-size: 18px;">0</strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f5f5f5; border-radius: 8px;">
                    <span style="color: #666;">Từ vựng đã học</span>
                    <strong style="color: #e57373; font-size: 18px;">0</strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f5f5f5; border-radius: 8px;">
                    <span style="color: #666;">Ngày học liên tiếp</span>
                    <strong style="color: #e57373; font-size: 18px;">0</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="content-box" style="margin-top: 20px;">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #333;">Cài đặt</h3>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <button style="padding: 16px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; text-align: left; cursor: pointer; font-size: 15px; color: #e57373; transition: background 0.3s;">
                Đăng xuất
            </button>
        </div>
    </div>
</div>
@endsection