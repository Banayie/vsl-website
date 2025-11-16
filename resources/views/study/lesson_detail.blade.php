@extends('layouts.app')

@section('content')
    <style>
        .practice-container {
            padding: 0;
            background: white;
            min-height: 100vh;
        }

        .header-section {
            padding: 20px 24px;
            background: white;
            border-bottom: 1px solid #E5E7EB;
        }

        .lesson-title {
            font-size: 22px;
            font-weight: 600;
            color: #1F2937;
            margin: 0 0 8px 0;
            letter-spacing: -0.3px;
        }

        .lesson-description {
            font-size: 14px;
            color: #6B7280;
            margin: 0;
        }

        .content-section {
            padding: 32px 24px 100px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .instruction-text {
            font-size: 16px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 24px;
            text-align: left;
        }

        .videos-wrapper {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 32px;
        }

        .video-box {
            flex: 1;
            max-width: 420px;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .video-box:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-top: 75%;
            /* 4:3 aspect ratio */
            background: #1F2937;
            overflow: hidden;
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-label {
            padding: 14px 20px;
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            background: white;
        }

        .video-label.reference {
            color: #DC2626;
            background: #FEF2F2;
        }

        .video-label.user {
            color: #F59E0B;
            background: #FFFBEB;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            padding: 24px 48px;
            border-top: 1px solid #E5E7EB;
            background: white;
            position: sticky;
            bottom: 60px;
            z-index: 10;
        }

        .btn-custom {
            padding: 14px 40px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-skip {
            background: white;
            color: #9CA3AF;
            border: 2px solid #D1D5DB;
        }

        .btn-skip:hover {
            background: #F9FAFB;
            border-color: #9CA3AF;
            transform: translateY(-1px);
        }

        .btn-check {
            background: #e57373;
            color: white;
            border: 2px solid #e57373;
        }

        .btn-check:hover {
            background: #C99090;
            border-color: #C99090;
            transform: translateY(-1px);
        }

        .btn-custom:active {
            transform: translateY(0);
        }

        /* Loading indicator */
        .loading-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            text-align: center;
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 12px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .videos-wrapper {
                flex-direction: column;
                gap: 20px;
            }

            .video-box {
                max-width: 100%;
            }

            .content-section {
                padding: 24px 16px 100px;
            }

            .action-buttons {
                padding: 16px;
                gap: 12px;
            }

            .btn-custom {
                padding: 12px 32px;
                font-size: 15px;
                min-width: 120px;
            }

            .action-buttons {
                padding: 16px 20px;
            }
        }
    </style>

    <div class="practice-container">
        {{-- Header Section --}}
        <div class="header-section">
            <h1 class="lesson-title">{{ $lesson->title }}</h1>
            <p class="lesson-description">{{ $lesson->content }}</p>
        </div>

        {{-- Content Section --}}
        <div class="content-section">
            <p class="instruction-text">Hãy thực hiện từ vựng sau thông qua webcam:</p>

            <div class="videos-wrapper">
                {{-- Video mẫu bên trái --}}
                <div class="video-box">
                    <div class="video-container">
                        <video id="lessonVideo" autoplay loop muted playsinline>
                            <source src="{{ asset('storage/' . $lesson->video_url) }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="video-label reference">{{ $lesson->title }}</div>
                </div>

                {{-- Webcam bên phải --}}
                <div class="video-box">
                    <div class="video-container">
                        <video id="webcam" autoplay playsinline></video>
                        <div class="loading-indicator" id="loadingIndicator">
                            <div class="spinner"></div>
                            <div>Đang khởi động camera...</div>
                        </div>
                    </div>
                    <div class="video-label user" id="webcamLabel">Đang chờ động tác...</div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="action-buttons">
            <button class="btn-custom btn-skip" onclick="skipLesson()">Bỏ qua</button>
            <button class="btn-custom btn-check" onclick="checkGesture()">Kiểm tra</button>
        </div>
    </div>

    {{-- Script mở webcam và xử lý --}}
    <script>
        const webcam = document.getElementById('webcam');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const webcamLabel = document.getElementById('webcamLabel');

        async function startWebcam() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 1280 },
                        height: { ideal: 960 },
                        facingMode: 'user'
                    }
                });

                webcam.srcObject = stream;

                // Ẩn loading indicator khi webcam đã sẵn sàng
                webcam.onloadedmetadata = () => {
                    loadingIndicator.style.display = 'none';
                    webcamLabel.textContent = 'Đang chờ động tác...';
                };

            } catch (error) {
                loadingIndicator.innerHTML = '<div style="color: #EF4444;">❌ Không thể mở webcam</div>';
                webcamLabel.textContent = 'Lỗi camera';
                console.error("Webcam error:", error);

                alert("Không thể mở webcam. Vui lòng:\n" +
                    "1. Cấp quyền truy cập camera\n" +
                    "2. Kiểm tra camera có hoạt động không\n" +
                    "3. Thử tải lại trang");
            }
        }

        function skipLesson() {
            // Lấy ID bài học hiện tại từ URL
            const currentUrl = window.location.pathname;
            const currentLessonId = parseInt(currentUrl.split('/').pop());

            // Chuyển sang bài học tiếp theo
            const nextLessonId = currentLessonId + 1;
            window.location.href = `/study/lesson/${nextLessonId}`;
        }

        function checkGesture() {
            webcamLabel.textContent = 'Đang kiểm tra...';
            webcamLabel.style.background = '#DBEAFE';
            webcamLabel.style.color = '#1D4ED8';

            setTimeout(() => {
                const isCorrect = Math.random() > 0.5; // Chỗ này bạn sẽ thay bằng AI thật

                if (isCorrect) {
                    webcamLabel.textContent = '✓ Chính xác!';
                    webcamLabel.style.background = '#D1FAE5';
                    webcamLabel.style.color = '#059669';

                    setTimeout(() => {
                        // Lấy ID bài học từ URL
                        const currentUrl = window.location.pathname;
                        const currentLessonId = parseInt(currentUrl.split('/').pop());

                        // Chuyển sang bài tiếp theo
                        const nextLessonId = currentLessonId + 1;

                        window.location.href = `/study/lesson/${nextLessonId}`;
                    }, 1200);

                } else {
                    webcamLabel.textContent = '✗ Chưa chính xác, thử lại';
                    webcamLabel.style.background = '#FEE2E2';
                    webcamLabel.style.color = '#DC2626';

                    setTimeout(() => {
                        webcamLabel.textContent = 'Đang chờ động tác...';
                        webcamLabel.style.background = '#FFFBEB';
                        webcamLabel.style.color = '#F59E0B';
                    }, 2000);
                }
            }, 1500);
        }


        // Khởi động webcam khi trang load
        startWebcam();

        // Dọn dẹp khi rời khỏi trang
        window.addEventListener('beforeunload', () => {
            if (webcam.srcObject) {
                webcam.srcObject.getTracks().forEach(track => track.stop());
            }
        });
    </script>

@endsection