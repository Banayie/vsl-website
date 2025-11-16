@extends('admin.layouts.app')

@section('title', 'Tạo chủ đề')

@section('content')
<div style="max-width:500px;margin:auto;">
    <h1 class="page-title">Tạo chủ đề mới</h1>

    @if($errors->any())
        <div style="background:#ffcccc; padding:10px; border-left:4px solid red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.topics.store') }}">
        @csrf

        <label>Tiêu đề</label>
        <input type="text" name="title" class="input" required>

        <label>Mô tả</label>
        <textarea name="description" class="input"></textarea>

        <button class="button">Tạo</button>
    </form>
</div>
@endsection
