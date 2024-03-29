@extends('layouts.app')

@section('contents')
    {{-- 로그인된 사용자만 보이는 부분 --}}
    @if (Auth::check())
        <div class="find-sort">
            <button type="submit" id="deleteSelected">Delete Selected</button>
            <form method="GET">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" placeholder="Enter keyword" value="{{ request('search') }}">

                <label for="searchBy">Search By:</label>
                <select id="searchBy" name="searchBy">
                    <option value="all" @selected(request('searchBy') == 'all')>All</option>
                    <option value="title" @selected(request('searchBy') == 'title')>Title</option>
                    <option value="content" @selected(request('searchBy') == 'content')>Content</option>
                </select>
                <button type="submit">Search</button>
            </form>
            {{-- 정렬 선택 --}}
            <form>
                <label for="sort">sort by: </label>
                <select id="sort" name="sort">
                    <option value="recent" @selected(request('sort') == 'recent')>recent</option>
                    <option value="oldest" @selected(request('sort') == 'oldest')>oldest</option>
                </select>
            </form>
        </div>
    @endif

    <div class="selallbtn">
        <input type="checkbox" id="checkSelectAll" onchange="toggleSelectAll()">
        <label for="checkSelectAll">Check All</label>
    </div>

    {{-- 메모 리스트 --}}
    <div class="memo-container">
        @if (Auth::check())
            @if ($memoCount > 0)
                <div class="memo-list">
                    @foreach ($memos as $memo)
                        <div class="memo-item" data-memo-id="{{ $memo->id }}">
                            <input type="checkbox" class="memo-checkbox" value="{{ $memo->id }}"
                                onchange="handleCheckboxChange()">
                            <div class="memo-title">{{ $memo->title }}
                                <div class="memo-created-at">{{ $memo->created_at->format('Y-m-d H:i:s') }}</div>
                            </div>
                            <div class="memo-content">
                                <div class="memo-text">
                                    {{ $memo->content }} {{-- 메모 내용 출력 --}}
                                </div>
                                <div class="memo-date">
                                    @if (!empty($memo->updated_at))
                                        <div class="memo-updated-at">Updated at:
                                            {{ $memo->updated_at->format('Y-m-d H:i:s') }}</div>
                                    @else
                                        <div class="memo-created-at-down">Created at:
                                            {{ $memo->created_at->format('Y-m-d H:i:s') }}</div>
                                    @endif
                                </div>

                                <div class="edit-del-button">
                                    <form action="/edit/{{ $memo->id }}" method="GET">
                                        <button class="edit-button" type="submit">Edit</button>
                                    </form>

                                    <!-- 삭제 버튼 -->
                                    <form action="{{ route('memos.destroy', $memo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-memo-message">Please create a memo first.</div>
            @endif
        @else
            <div class="no-memo-message">Please log in to view memos.</div>
        @endif
    </div>
@endsection
