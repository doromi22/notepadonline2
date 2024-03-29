<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $query = Memo::where('author_id', $userId);

            // 정렬 순서 설정
            $sortOrder = $request->query('sort', 'recent') == 'oldest' ? 'asc' : 'desc';

            // 검색어가 있는 경우 검색 쿼리 추가
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $searchBy = $request->query('searchBy', 'all');

                if ($searchBy == 'title') {
                    $query->where('title', 'LIKE', "%{$search}%");
                } elseif ($searchBy == 'content') {
                    $query->where('content', 'LIKE', "%{$search}%");
                } else {
                    // 'all'의 경우 또는 searchBy 파라미터가 제공되지 않은 경우
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'LIKE', "%{$search}%")
                            ->orWhere('content', 'LIKE', "%{$search}%");
                    });
                }
            }

            $memos = $query->orderBy('created_at', $sortOrder)->get();
            $memoCount = $memos->count();

            return view('history', compact('memos', 'memoCount'));
        } else {
            return redirect()->route('login');
        }
    }

}
