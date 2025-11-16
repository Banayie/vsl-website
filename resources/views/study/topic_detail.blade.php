@extends('layouts.app')

@section('content')
<style>
    .lessons-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px 16px 100px;
        background: linear-gradient(180deg, #FFF5F7 0%, #FFE8E8 100%);
        min-height: 100vh;
    }

    .header-section {
        text-align: center;
        margin-bottom: 32px;
        padding-top: 8px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #E57373;
        border: 2px solid #FFCDD2;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .back-button:hover {
        background: #FFF0F0;
        transform: translateX(-4px);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3748;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 15px;
        color: #718096;
        margin: 0;
        font-weight: 400;
    }

    .lessons-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-top: 24px;
    }

    .lesson-card {
        background: white;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .lesson-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #E57373 0%, #EF5350 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .lesson-card:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 24px rgba(255, 123, 123, 0.15);
        border-color: #FFCDD2;
    }

    .lesson-card:hover::before {
        opacity: 1;
    }

    .lesson-info {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
    }

    .lesson-icon {
        font-size: 28px;
        flex-shrink: 0;
    }

    .lesson-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3748;
        margin: 0;
        line-height: 1.4;
    }

    .lesson-button {
        background: linear-gradient(135deg, #E57373 0%, #EF5350 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(229, 115, 115, 0.3);
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .lesson-button::before {
        content: '▶';
        position: absolute;
        left: 20px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .lesson-button:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(229, 115, 115, 0.4);
        padding-left: 32px;
    }

    .lesson-button:hover::before {
        opacity: 1;
        left: 12px;
    }

    .lesson-button:active {
        transform: scale(0.98);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 16px;
    }

    .empty-text {
        font-size: 16px;
        color: #718096;
    }

    @media (max-width: 640px) {
        .lessons-container {
            padding: 20px 12px 100px;
        }

        .lesson-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 20px;
        }

        .lesson-info {
            width: 100%;
        }

        .lesson-button {
            width: 100%;
            padding: 12px 20px;
        }

        .lesson-button:hover {
            padding-left: 20px;
        }

        .lesson-button::before {
            display: none;
        }

        .page-title {
            font-size: 24px;
        }
    }
</style>

<div class="lessons-container">
    <div class="header-section">
        <a href="{{ route('study') }}" class="back-button">
            ← Quay lại
        </a>
        <h1 class="page-title">{{ $topic->title }}</h1>
        <p class="page-subtitle">Danh sách bài học trong chủ đề này</p>
    </div>

    <div class="lessons-list">
        @forelse ($lessons as $index => $lesson)
            <div class="lesson-card">
                <div class="lesson-info">
                    <span class="lesson-icon">📘</span>
                    <h3 class="lesson-title">{{ $lesson->title }}</h3>
                </div>

                <a href="{{ route('study.lesson', $lesson->id) }}" style="text-decoration: none;">
                    <button class="lesson-button">Bắt đầu học</button>
                </a>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📚</div>
                <p class="empty-text">Chưa có bài học nào trong chủ đề này</p>
            </div>
        @endforelse
    </div>
</div>
@endsection