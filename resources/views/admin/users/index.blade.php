@extends('admin.layouts.app')
@section('title', 'Quản lý người dùng')
@section('page-title', 'Danh sách người dùng')
@section('content')
    <style>
        .alert-success {
            background: #d4edda;
            padding: 14px 18px;
            border-left: 4px solid #28a745;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #155724;
            font-size: 14px;
        }
        
        .btn-add {
            display: inline-block;
            padding: 12px 20px;
            background: #6366f1;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-add:hover {
            background: #5558e3;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-top: 20px;
            overflow: hidden;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table thead tr {
            background: #f8f9fb;
        }
        
        .data-table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 14px;
            color: #1a1a1a;
            vertical-align: middle;
        }
        
        .data-table tbody tr:hover {
            background: #f8f9fb;
        }
        
        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .role-admin {
            background: #e8eaff;
            color: #6366f1;
        }
        
        .role-user {
            background: #f0f2f5;
            color: #4a5568;
        }
        
        .action-cell {
            white-space: nowrap;
        }
        
        .link-edit {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            margin-right: 12px;
            transition: color 0.2s;
            display: inline-block;
        }
        
        .link-edit:hover {
            color: #5558e3;
        }
        
        .btn-delete {
            color: #e53e3e;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
            padding: 0;
            vertical-align: baseline;
        }
        
        .btn-delete:hover {
            color: #c53030;
        }
    </style>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="btn-add">
        + Thêm người dùng
    </a>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <span class="role-badge {{ $u->role === 'admin' ? 'role-admin' : 'role-user' }}">
                                {{ $u->role === 'admin' ? 'Admin' : 'Người dùng' }}
                            </span>
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="link-edit">Sửa</a>
                            <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm('Xóa người dùng này?');">
                                @csrf
                                <button type="submit" class="btn-delete">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection