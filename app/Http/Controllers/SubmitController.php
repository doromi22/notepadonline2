<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Memo;
use Illuminate\Support\Facades\Auth;

class SubmitController extends Controller
{
    public function store(Request $request)
    {
        \Log::info($request->all()); // 로깅으로 요청 데이터 확인

        // 데이터 검증
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Memo::create([
            'author_id' => Auth::id(), // 현재 로그인한 사용자 ID
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        // 처리 후 리다이렉트
        return Redirect::to('/history');
    }
}