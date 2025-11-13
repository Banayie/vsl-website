<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Exception;

class SignLanguageController extends Controller
{
    private $pythonServiceUrl = 'http://localhost:5000/predict';

    public function translateSignLanguage(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:webm,mp4|max:10240'
        ]);

        $videoFile = $request->file('video');
        $filename = time() . '_' . uniqid() . '.webm';
        $path = $videoFile->storeAs('temp_videos', $filename, 'public');
        $fullPath = storage_path('app/public/' . $path);

        try {
            // Gọi Python Flask service
            $response = Http::timeout(30)->post($this->pythonServiceUrl, [
                'video_path' => $fullPath
            ]);

            if (!$response->successful()) {
                throw new Exception('Python service error: ' . $response->body());
            }

            $result = $response->json();

            // Xóa file tạm
            Storage::disk('public')->delete($path);

            return response()->json([
                'success' => true,
                'translation' => $result['text'],
                'confidence' => $result['confidence']
            ]);

        } catch (Exception $e) {
            // Xóa file nếu có lỗi
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => false,
                'message' => 'Lỗi xử lý video: ' . $e->getMessage()
            ], 500);
        }
    }
}