@extends('layouts.app')

@section('contents')
    @auth {{-- 로그인한 사용자만 내용을 볼 수 있습니다 --}}
        <form action="{{ route('submit') }}" method="post" class="submitbox">
            @csrf {{-- CSRF 보호를 위한 토큰 필드 추가 --}}
            <div class="titlebox">
                <label for="title">title</label><br>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="contentbox">
                <label for="content">content</label><br>
                <textarea id="content" name="content" rows="5" required></textarea><br><br>
                <input type="submit" value="save" onclick="return preventMultipleSubmit()">
            </div>
        </form>
    @else {{-- 로그인하지 않은 사용자에게 보여줄 메시지 --}}
        <p>Please <a href="{{ route('login') }}">login</a> to write a memo.</p>
    @endauth
@endsection
