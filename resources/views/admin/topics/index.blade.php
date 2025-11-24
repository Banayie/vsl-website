@extends('admin.layouts.app')
@section('title', 'Quản lý chủ đề')
@section('page-title', 'Quản lý chủ đề')
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

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.topics.create') }}" class="btn-add">
        + Thêm chủ đề
    </a>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>{{ $topic->title }}</td>
                        <td>{{ $topic->description }}</td>
                        <td class="action-cell">
                            <a href="{{ route('admin.topics.edit', $topic->id) }}" class="link-edit">Sửa</a>
                            <form method="POST" action="{{ route('admin.topics.delete', $topic->id) }}" style="display:inline-block; margin:0;" onsubmit="return confirm('Xoá chủ đề?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection