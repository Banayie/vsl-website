@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa chủ đề')

@section('content')
    <div style="max-width:500px;margin:auto;">
        <h1 class="page-title">Chỉnh sửa chủ đề</h1>

        @if($errors->any())
            <div style="background:#ffcccc; padding:10px; border-left:4px solid red;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.topics.update', $topic->id) }}">
            @csrf

            <label>Tiêu đề</label>
            <input type="text" name="title" value="{{ $topic->title }}" class="input">

            <label>Mô tả</label>
            <textarea name="description" class="input">{{ $topic->description }}</textarea>

            <button class="button">Lưu</button>
        </form>
    </div>
@endsection