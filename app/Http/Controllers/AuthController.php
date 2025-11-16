<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // chạy route vào /study
            return redirect()->route('home');
        }

        return back()->withErrors([
            'error' => 'Email hoặc mật khẩu không đúng!'
        ]);
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // phải có password_confirmation
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);
        // Đăng nhập ngay sau khi đăng ký
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }
    public function editProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password_confirm' => 'required'
        ]);

        // Kiểm tra mật khẩu
        if (!Hash::check($request->password_confirm, $user->password)) {
            return back()->with('error', 'Mật khẩu xác nhận không chính xác!');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không chính xác!');
        }

        // Lưu mật khẩu mới
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048'
        ]);

        $user = Auth::user();

        // Xóa avatar cũ nếu tồn tại
        if ($user->avatar && file_exists(storage_path('avatars/' . $user->avatar))) {
            unlink(storage_path('avatars/' . $user->avatar));
        }

        // Tạo tên file mới
        $filename = time() . '_' . preg_replace('/\s+/', '_', $request->avatar->getClientOriginalName());

        // Lưu avatar vào disk "public" (ĐÚNG CHUẨN)
        $request->avatar->storeAs('avatars', $filename, 'public');

        // Cập nhật DB
        $user->avatar = $filename;
        $user->save();

        return back()->with('success', 'Cập nhật ảnh đại diện thành công!');
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false], 401);
        }

        return response()->json(['success' => true]);
    }

}
