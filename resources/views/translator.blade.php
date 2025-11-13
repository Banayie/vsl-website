@extends('layouts.app')

@section('title', 'Dịch Thuật')

@section('content')
<div>
    <h1 class="page-title">Dịch Thuật</h1>
    <p class="page-subtitle">Chuyển đổi ngôn ngữ ký hiệu thành văn bản</p>

    <div class="content-box">
        <h2 class="content-title">Camera</h2>
        
        <!-- Camera Container -->
        <div style="position: relative; width: 100%; max-width: 640px; margin: 0 auto;">
            <video id="cameraFeed" autoplay playsinline style="width: 100%; height: auto; border-radius: 12px; background: #000;"></video>
            <canvas id="videoCanvas" style="display: none;"></canvas>
            
            <!-- Recording Indicator -->
            <div id="recordingIndicator" style="display: none; position: absolute; top: 16px; left: 16px; background: #e53935; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                ● Đang ghi
            </div>
            
            <!-- Countdown -->
            <div id="countdown" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 72px; font-weight: bold; color: white; text-shadow: 0 0 20px rgba(0,0,0,0.5);">
                2
            </div>
        </div>

        <!-- Camera Controls -->
        <div style="display: flex; gap: 12px; margin-top: 20px; justify-content: center; flex-wrap: wrap;">
            <button id="startBtn" onclick="startRecording()" style="padding: 12px 24px; background: #e57373; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
                📹 Thực hiện
            </button>
            
            <button id="stopBtn" onclick="stopRecording()" disabled style="padding: 12px 24px; background: #9e9e9e; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: not-allowed; transition: background 0.3s;">
                ⏹ Dừng
            </button>
            
            <button id="switchCameraBtn" onclick="switchCamera()" style="padding: 12px 24px; background: #64b5f6; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s;">
                🔄 Đổi camera
            </button>
        </div>

        <!-- Processing Status -->
        <div id="processingStatus" style="display: none; margin-top: 20px; padding: 16px; background: #fff3e0; border-radius: 8px; text-align: center;">
            <div style="display: inline-block; width: 24px; height: 24px; border: 3px solid #ff9800; border-top-color: transparent; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <p style="margin-top: 12px; color: #e65100; font-weight: 600;">Đang xử lý video...</p>
        </div>
    </div>

    <!-- Result Section -->
    <div id="resultSection" class="content-box" style="margin-top: 20px; display: none;">
        <h2 class="content-title">Kết quả dịch</h2>
        <div id="translationResult" style="padding: 24px; background: #e8f5e9; border-radius: 8px; font-size: 18px; color: #2e7d32; font-weight: 500; min-height: 60px; display: flex; align-items: center; justify-content: center;">
        </div>
        
        <div style="margin-top: 16px; padding: 16px; background: #f5f5f5; border-radius: 8px;">
            <p style="font-size: 14px; color: #666; margin-bottom: 8px;"><strong>Độ tin cậy:</strong> <span id="confidence">-</span></p>
            <p style="font-size: 14px; color: #666;"><strong>Thời gian xử lý:</strong> <span id="processingTime">-</span></p>
        </div>
    </div>

    <div class="content-box" style="margin-top: 20px; background: #e3f2fd;">
        <div class="content-text">
            <p><strong>💡 Hướng dẫn:</strong></p>
            <ul style="margin-left: 20px; margin-top: 8px; line-height: 1.8;">
                <li>Đảm bảo ánh sáng đủ và bàn tay rõ ràng trong khung hình</li>
                <li>Thực hiện ký hiệu trong khoảng 2 giây</li>
                <li>Giữ bàn tay trong khung hình camera</li>
                <li>Video sẽ tự động dừng sau 2 giây để xử lý</li>
            </ul>
        </div>
    </div>
</div>

<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    #startBtn:not(:disabled):hover {
        background: #ef5350;
    }
    
    #stopBtn:not(:disabled) {
        background: #ef5350;
        cursor: pointer;
    }
    
    #stopBtn:not(:disabled):hover {
        background: #d32f2f;
    }
    
    #switchCameraBtn:hover {
        background: #42a5f5;
    }
</style>

<script>
let stream = null;
let mediaRecorder = null;
let recordedChunks = [];
let currentCamera = 'user'; // 'user' for front, 'environment' for back
let recordingTimeout = null;
let countdownInterval = null;

// Initialize camera when page loads
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
    // Stop current stream
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    
    // Switch camera
    currentCamera = currentCamera === 'user' ? 'environment' : 'user';
    
    // Reinitialize with new camera
    await initCamera();
}

function startRecording() {
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('videoCanvas');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const recordingIndicator = document.getElementById('recordingIndicator');
    const countdownDiv = document.getElementById('countdown');
    const resultSection = document.getElementById('resultSection');
    
    // Hide previous results
    resultSection.style.display = 'none';
    
    // Setup canvas
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    recordedChunks = [];
    
    // Create MediaRecorder
    const canvasStream = canvas.captureStream(30); // 30 FPS
    mediaRecorder = new MediaRecorder(canvasStream, {
        mimeType: 'video/webm;codecs=vp9'
    });
    
    mediaRecorder.ondataavailable = (event) => {
        if (event.data.size > 0) {
            recordedChunks.push(event.data);
        }
    };
    
    mediaRecorder.onstop = processVideo;
    
    // Start recording
    mediaRecorder.start();
    
    // Update UI
    startBtn.disabled = true;
    stopBtn.disabled = false;
    recordingIndicator.style.display = 'block';
    countdownDiv.style.display = 'block';
    
    // Draw video frames to canvas
    const ctx = canvas.getContext('2d');
    const drawFrame = () => {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            requestAnimationFrame(drawFrame);
        }
    };
    drawFrame();
    
    // Countdown and auto-stop after 2 seconds
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
    
    // Clear timeout and interval
    if (recordingTimeout) {
        clearTimeout(recordingTimeout);
    }
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
    
    // Update UI
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const recordingIndicator = document.getElementById('recordingIndicator');
    const countdownDiv = document.getElementById('countdown');
    
    startBtn.disabled = false;
    stopBtn.disabled = true;
    recordingIndicator.style.display = 'none';
    countdownDiv.style.display = 'none';
}

async function processVideo() {
    const processingStatus = document.getElementById('processingStatus');
    const resultSection = document.getElementById('resultSection');
    const translationResult = document.getElementById('translationResult');
    const confidence = document.getElementById('confidence');
    const processingTime = document.getElementById('processingTime');
    
    // Show processing status
    processingStatus.style.display = 'block';
    
    try {
        // Create blob from recorded chunks
        const blob = new Blob(recordedChunks, { type: 'video/webm' });
        
        // Create FormData for sending to backend
        const formData = new FormData();
        formData.append('video', blob, 'sign_language.webm');
        
        const startTime = Date.now();
        
        // Send to Laravel backend for AI processing
        const response = await fetch('{{ route("api.translate") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        const endTime = Date.now();
        
        // Hide processing status
        processingStatus.style.display = 'none';
        
        // Show results
        resultSection.style.display = 'block';
        translationResult.textContent = result.translation || 'Không nhận dạng được';
        confidence.textContent = (result.confidence * 100).toFixed(1) + '%';
        processingTime.textContent = ((endTime - startTime) / 1000).toFixed(2) + 's';
        
        // Scroll to result
        resultSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
    } catch (error) {
        console.error('Error processing video:', error);
        processingStatus.style.display = 'none';
        alert('Có lỗi xảy ra khi xử lý video. Vui lòng thử lại.');
    }
}

// Cleanup when leaving page
window.addEventListener('beforeunload', () => {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
});
</script>
@endsection