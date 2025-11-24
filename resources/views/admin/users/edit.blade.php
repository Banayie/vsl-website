@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa người dùng')
@section('page-title', 'Chỉnh sửa: ' . $user->name)
@section('content')
    <style>
        .alert-error {
            background: #fee;
            padding: 14px 18px;
            border-left: 4px solid #e53e3e;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #c53030;
            font-size: 14px;
        }
        
        .form-container {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            max-width: 600px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-input::placeholder {
            color: #a0aec0;
        }
        
        .btn-primary {
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background: #5558e3;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
    </style>

    @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" value="{{ $user->name }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Mật khẩu mới (tùy chọn)</label>
                <input type="password" name="password" placeholder="Nếu không đổi thì để trống" class="form-input">
            </div>

            <button type="submit" class="btn-primary">
                Cập nhật
            </button>
        </form>
    </div>
@endsection