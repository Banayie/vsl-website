@extends('layouts.app')

@section('title', 'Từ Điển')

@section('content')
<style>
    .dictionary-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 48px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 16px;
        color: #64748B;
        font-weight: 400;
    }

    .search-section {
        background: white;
        padding: 32px;
        border-radius: 16px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.2s ease;
        outline: none;
    }

    .search-input:focus {
        border-color: #FF8FA3;
        box-shadow: 0 0 0 3px rgba(255, 107, 129, 0.1);
    }

    .search-input::placeholder {
        color: #9CA3AF;
    }

    .search-hint {
        margin-top: 16px;
        padding: 16px;
        background: #F9FAFB;
        border-radius: 10px;
        color: #6B7280;
        font-size: 14px;
        line-height: 1.6;
    }

    .popular-section {
        background: white;
        padding: 32px;
        border-radius: 16px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .words-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 12px;
    }

    .word-card {
        padding: 16px 20px;
        background: #FAFAFA;
        border: 1px solid #F1F5F9;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 500;
        color: #374151;
    }

    .word-card:hover {
        background: #FFF5F7;
        border-color: #FFE4E9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 129, 0.1);
        color: #FF6B81;
    }

    @media (max-width: 768px) {
        .dictionary-wrapper {
            padding: 24px 16px;
        }

        .page-title {
            font-size: 26px;
        }

        .search-section,
        .popular-section {
            padding: 24px;
        }

        .words-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>

<div class="dictionary-wrapper">
    <div class="page-header">
        <h1 class="page-title">Từ Điển Ký Hiệu</h1>
        <p class="page-subtitle">Tra cứu các từ và cụm từ bằng ngôn ngữ ký hiệu</p>
    </div>

    <div class="search-section">
        <h2 class="section-title">Tìm kiếm từ vựng</h2>
        <input type="text" 
               class="search-input"
               placeholder="Nhập từ cần tra cứu...">
        
        <div class="search-hint">
            Nhập từ hoặc cụm từ bạn muốn tra cứu trong ngôn ngữ ký hiệu. Chúng tôi sẽ hiển thị video minh họa và hướng dẫn chi tiết.
        </div>
    </div>

    <div class="popular-section">
        <h2 class="section-title">Từ phổ biến</h2>
        <div class="words-grid">
            <div class="word-card">Xin chào</div>
            <div class="word-card">Cảm ơn</div>
            <div class="word-card">Tạm biệt</div>
            <div class="word-card">Xin lỗi</div>
            <div class="word-card">Bạn khỏe không</div>
            <div class="word-card">Tên tôi là</div>
            <div class="word-card">Vui lòng</div>
            <div class="word-card">Không sao</div>
        </div>
    </div>
</div>

@endsection