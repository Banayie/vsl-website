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

        /* NEW STATUS */
        .lesson-status {
            font-weight: 700;
            margin-right: 12px;
        }

        .status-complete {
            color: #16A34A;
        }

        .status-pending {
            color: #D97706;
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

        .lesson-button:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="lessons-container">
        <div class="header-section">
            <a href="{{ route('study') }}" class="back-button">← Quay lại</a>
            <h1 class="page-title">{{ $topic->title }}</h1>
            <p class="page-subtitle">Danh sách bài học trong chủ đề này</p>
        </div>

        <div class="lessons-list">
            @forelse ($lessons as $lesson)
                @php
                    $done = $lesson->progress->first();
                @endphp

                <div class="lesson-card">

                    <div class="lesson-info">
                        <span class="lesson-icon">📘</span>
                        <h3 class="lesson-title">{{ $lesson->title }}</h3>
                    </div>

                    <!-- NEW STATUS -->
                    <span class="lesson-status 
                            {{ ($done && $done->progress == 100) ? 'status-complete' : 'status-pending' }}">
                        {{ ($done && $done->progress == 100) ? '✔ Chính xác' : 'Chưa hoàn thành' }}
                    </span>

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