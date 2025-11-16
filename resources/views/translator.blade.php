@extends('layouts.app')

@section('title', 'Dịch Thuật')

@section('content')
<style>
    .translation-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 32px 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #2D3748;
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 16px;
        color: #64748B;
    }

    .content-box {
        background: white;
        border: 1px solid #F1F5F9;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .content-title {
        font-size: 18px;
        font-weight: 600;
        color: #2D3748;
        margin-bottom: 20px;
    }

    .camera-container {
        position: relative;
        width: 100%;
        max-width: 640px;
        margin: 0 auto;
        border-radius: 16px;
        overflow: hidden;
        background: #000;
    }

    #cameraFeed {
        width: 100%;
        height: auto;
        display: block;
    }

    .recording-indicator {
        display: none;
        position: absolute;
        top: 16px;
        left: 16px;
        background: #FF6B81;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(255, 107, 129, 0.3);
    }

    .recording-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        margin-right: 8px;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .countdown {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 80px;
        font-weight: 800;
        color: white;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    .camera-controls {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 14px 28px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #FF6B81 0%, #FF8FA3 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 129, 0.3);
    }

    .btn-primary:hover:not(:disabled) {
        background: linear-gradient(135deg, #FF5A73 0%, #FF7A92 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 107, 129, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748B;
        border: 2px solid #E2E8F0;
    }

    .btn-secondary:hover:not(:disabled) {
        background: #F8FAFC;
        border-color: #CBD5E1;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    .processing-status {
        display: none;
        margin-top: 24px;
        padding: 20px;
        background: #FFF5F7;
        border-radius: 12px;
        text-align: center;
    }

    .spinner {
        display: inline-block;
        width: 32px;
        height: 32px;
        border: 3px solid #FFE4E9;
        border-top-color: #FF6B81;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .processing-text {
        margin-top: 12px;
        color: #FF6B81;
        font-weight: 600;
        font-size: 15px;
    }

    .result-box {
        padding: 24px;
        background: #F0FDF4;
        border: 2px solid #BBF7D0;
        border-radius: 12px;
        font-size: 20px;
        color: #15803D;
        font-weight: 600;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .result-meta {
        margin-top: 16px;
        padding: 16px;
        background: #FAFAFA;
        border-radius: 12px;
        display: flex;
        justify-content: space-around;
        gap: 16px;
    }

    .meta-item {
        text-align: center;
    }

    .meta-label {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 4px;
    }

    .meta-value {
        font-size: 18px;
        font-weight: 700;
        color: #2D3748;
    }

    .guide-box {
        background: #F0F9FF;
        border: 1px solid #E0F2FE;
    }

    .guide-box .content-text {
        color: #0C4A6E;
    }

    .guide-box ul {
        margin-left: 20px;
        margin-top: 12px;
        line-height: 1.8;
    }

    .guide-box li {
        margin-bottom: 8px;
    }

    @media (max-width: 640px) {
        .camera-controls {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .result-meta {
            flex-direction: column;
        }
    }
</style>

<div class="translation-page">
    <div class="page-header">
        <h1 class="page-title">Dịch Thuật</h1>
        <p class="page-subtitle">Chuyển đổi ngôn ngữ ký hiệu thành văn bản</p>
    </div>

    <div class="content-box">
        <h2 class="content-title">Camera</h2>
        
        <div class="camera-container">
            <video id="cameraFeed" autoplay playsinline></video>
            <canvas id="videoCanvas" style="display: none;"></canvas>
            
            <div id="recordingIndicator" class="recording-indicator">
                <span class="recording-dot"></span>
                Đang ghi
            </div>
            
            <div id="countdown" class="countdown">2</div>
        </div>

        <div class="camera-controls">
            <button id="startBtn" onclick="startRecording()" class="btn btn-primary">
                Thực hiện
            </button>
            
            <button id="switchCameraBtn" onclick="switchCamera()" class="btn btn-secondary">
                Đổi camera
            </button>
        </div>

        <div id="processingStatus" class="processing-status">
            <div class="spinner"></div>
            <p class="processing-text">Đang xử lý video...</p>
        </div>
    </div>

    <div id="resultSection" class="content-box" style="display: none;">
        <h2 class="content-title">Kết quả dịch</h2>
        <div id="translationResult" class="result-box"></div>
        
        <div class="result-meta">
            <div class="meta-item">
                <div class="meta-label">Độ tin cậy</div>
                <div class="meta-value" id="confidence">-</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Thời gian xử lý</div>
                <div class="meta-value" id="processingTime">-</div>
            </div>
        </div>
    </div>

    <div class="content-box guide-box">
        <div class="content-text">
            <p style="font-weight: 600; margin-bottom: 8px;">Hướng dẫn sử dụng</p>
            <ul>
                <li>Đảm bảo ánh sáng đủ và bàn tay rõ ràng trong khung hình</li>
                <li>Thực hiện ký hiệu trong khoảng 2 giây</li>
                <li>Giữ bàn tay trong khung hình camera</li>
                <li>Video sẽ tự động dừng sau 2 giây để xử lý</li>
            </ul>
        </div>
    </div>
</div>

<script>
let stream = null;
let mediaRecorder = null;
let recordedChunks = [];
let currentCamera = 'user';
let recordingTimeout = null;
let countdownInterval = null;

window.addEventListener('load', initCamera);

async function initCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: currentCamera },
            audio: false
        });
        
        const video = document.getElementById('cameraFeed');
        video.srcObject = stream;
    } catch (error) {
        console.error('Error accessing camera:', error);
        alert('Không thể truy cập camera. Vui lòng cho phép quyền truy cập camera.');
    }
}

async function switchCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    
    currentCamera = currentCamera === 'user' ? 'environment' : 'user';
    await initCamera();
}

function startRecording() {
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('videoCanvas');
    const startBtn = document.getElementById('startBtn');
    const recordingIndicator = document.getElementById('recordingIndicator');
    const countdownDiv = document.getElementById('countdown');
    const resultSection = document.getElementById('resultSection');
    
    resultSection.style.display = 'none';
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    recordedChunks = [];
    
    const canvasStream = canvas.captureStream(30);
    mediaRecorder = new MediaRecorder(canvasStream, {
        mimeType: 'video/webm;codecs=vp9'
    });
    
    mediaRecorder.ondataavailable = (event) => {
        if (event.data.size > 0) {
            recordedChunks.push(event.data);
        }
    };
    
    mediaRecorder.onstop = processVideo;
    mediaRecorder.start();
    
    startBtn.disabled = true;
    recordingIndicator.style.display = 'block';
    countdownDiv.style.display = 'block';
    
    const ctx = canvas.getContext('2d');
    const drawFrame = () => {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            requestAnimationFrame(drawFrame);
        }
    };
    drawFrame();
    
    let countdown = 2;
    countdownDiv.textContent = countdown;
    
    countdownInterval = setInterval(() => {
        countdown--;
        countdownDiv.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(countdownInterval);
        }
    }, 1000);
    
    recordingTimeout = setTimeout(() => {
        stopRecording();
    }, 2000);
}

function stopRecording() {
    if (mediaRecorder && mediaRecorder.state === 'recording') {
        mediaRecorder.stop();
    }
    
    if (recordingTimeout) {
        clearTimeout(recordingTimeout);
    }
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
    
    const startBtn = document.getElementById('startBtn');
    const recordingIndicator = document.getElementById('recordingIndicator');
    const countdownDiv = document.getElementById('countdown');
    
    startBtn.disabled = false;
    recordingIndicator.style.display = 'none';
    countdownDiv.style.display = 'none';
}

async function processVideo() {
    const processingStatus = document.getElementById('processingStatus');
    const resultSection = document.getElementById('resultSection');
    const translationResult = document.getElementById('translationResult');
    const confidence = document.getElementById('confidence');
    const processingTime = document.getElementById('processingTime');
    
    processingStatus.style.display = 'block';
    
    try {
        const blob = new Blob(recordedChunks, { type: 'video/webm' });
        const formData = new FormData();
        formData.append('video', blob, 'sign_language.webm');
        
        const startTime = Date.now();
        
        const response = await fetch('{{ route("api.translate") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        const endTime = Date.now();
        
        processingStatus.style.display = 'none';
        
        resultSection.style.display = 'block';
        translationResult.textContent = result.translation || 'Không nhận dạng được';
        confidence.textContent = (result.confidence * 100).toFixed(1) + '%';
        processingTime.textContent = ((endTime - startTime) / 1000).toFixed(2) + 's';
        
        resultSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
    } catch (error) {
        console.error('Error processing video:', error);
        processingStatus.style.display = 'none';
        alert('Có lỗi xảy ra khi xử lý video. Vui lòng thử lại.');
    }
}

window.addEventListener('beforeunload', () => {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
});
</script>
@endsection