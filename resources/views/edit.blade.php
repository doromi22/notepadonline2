@extends('layouts.app')

@section('contents')
    {{-- resources/views/memos/edit.blade.php --}}
    <form action="{{ route('memos.update', $memo->id) }}" method="post" class="submitbox">
        @csrf
        <div class="titlebox">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="{{ old('title', $memo->title) }}" required>
        </div>
        <div class="contentbox">
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="5" required>{{ old('content', $memo->content) }}</textarea><br><br>
            <input type="hidden" name="memo_id" value="{{ $memo->id }}">
            <input type="submit" value="Save">
        </div>
    </form>
@endsection
