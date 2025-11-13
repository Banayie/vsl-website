@extends('layouts.app')

@section('title', 'Từ Điển')

@section('content')
<div>
    <h1 class="page-title">Từ Điển Ký Hiệu</h1>
    <p class="page-subtitle">Tra cứu các từ và cụm từ bằng ngôn ngữ ký hiệu</p>

    <div class="content-box">
        <h2 class="content-title">Tìm kiếm từ vựng</h2>
        <input type="text" 
               placeholder="Nhập từ cần tra cứu..." 
               style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; margin-bottom: 20px;">
        
        <div class="content-text">
            <p>Nhập từ hoặc cụm từ bạn muốn tra cứu trong ngôn ngữ ký hiệu. Chúng tôi sẽ hiển thị video minh họa và hướng dẫn chi tiết.</p>
        </div>
    </div>

    <div class="content-box" style="margin-top: 20px;">
        <h2 class="content-title">Từ phổ biến</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;">
            <div style="padding: 12px; background: #f5f5f5; border-radius: 8px; text-align: center; cursor: pointer;">Xin chào</div>
            <div style="padding: 12px; background: #f5f5f5; border-radius: 8px; text-align: center; cursor: pointer;">Cảm ơn</div>
            <div style="padding: 12px; background: #f5f5f5; border-radius: 8px; text-align: center; cursor: pointer;">Tạm biệt</div>
            <div style="padding: 12px; background: #f5f5f5; border-radius: 8px; text-align: center; cursor: pointer;">Xin lỗi</div>
        </div>
    </div>
</div>
@endsection