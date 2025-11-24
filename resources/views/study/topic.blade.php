@extends('layouts.app')

@section('title', 'Học ngôn ngữ ký hiệu')

@section('content')
<style>
    .study-container {
        padding: 24px 16px 100px;
        background: linear-gradient(180deg, #FFF5F7 0%, #FFE8E8 100%);
        min-height: 100vh;
    }

    .header-section {
        text-align: center;
        margin-bottom: 32px;
        padding-top: 8px;
    }

    .page-emoji {
        font-size: 48px;
        margin-bottom: 12px;
        animation: wave 2s ease-in-out infinite;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-20deg); }
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

    .topics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .topic-card {
        background: white;
        border-radius: 20px;
        padding: 32px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        min-height: 230px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .topic-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #FF9B9B, #FFB5C5, #FFC9C9, #FF8E8E);
        background-size: 300% 100%;
        animation: gradient-shift 3s ease infinite;
    }

    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .topic-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(255, 123, 123, 0.15);
        border-color: #FFCDD2;
    }

    .topic-icon {
        font-size: 56px;
        margin: 0 auto 12px;
        display: block;
        text-align: center;
    }

    .topic-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3748;
        margin: 0;
        text-align: center;
        line-height: 1.4;
    }

    /* New progress badge */
    .progress-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: #E0F7EC;
        color: #16A34A;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        border: 1.5px solid #A7F3D0;
    }

    /* New progress bar */
    .progress-bar-container {
        width: 100%;
        height: 8px;
        border-radius: 6px;
        background: #FFE0E0;
        margin-top: 12px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #FF7E7E, #FF4E4E);
        border-radius: 6px;
        transition: width 0.4s ease;
    }

    .start-button {
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg, #E57373 0%, #EF5350 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(229, 115, 115, 0.3);
        position: relative;
        overflow: hidden;
        margin-top: 12px;
    }

    .start-button:hover {
        transform: scale(1.02);
    }

    @media (max-width: 1024px) {
        .topics-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .topics-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .topic-card {
            padding: 24px 16px;
        }
    }

    @media (max-width: 480px) {
        .topics-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }
</style>

<div class="study-container">
    <div class="header-section">
        <div class="page-emoji">👋</div>
        <h1 class="page-title">Học ngôn ngữ ký hiệu</h1>
        <p class="page-subtitle">Khám phá thế giới giao tiếp bằng tay</p>
    </div>

    <div class="topics-grid">
        @php
            $icons = ['🔤', '🌙', '👋', '👨‍👩‍👧', '⏰', '🎨', '🍽️', '🐾'];
        @endphp

        @foreach ($topics as $index => $topic)
            <div class="topic-card">

                <!-- NEW: badge hiển thị % -->
                <span class="progress-badge">
                    {{ $topic->progressPercent ?? 0 }}%
                </span>

                <span class="topic-icon">{{ $icons[$index % count($icons)] }}</span>

                <h3 class="topic-title">{{ $topic->title }}</h3>

                <!-- NEW: Thanh progress bar -->
                <div class="progress-bar-container">
                    <div class="progress-bar-fill"
                        style="width: {{ $topic->progressPercent }}%;"></div>
                </div>

                <a href="{{ route('study.topic', $topic->id) }}" style="text-decoration: none;">
                    <button class="start-button">Bắt đầu học</button>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
