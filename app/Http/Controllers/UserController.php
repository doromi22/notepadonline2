<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Memo;

class UserController extends Controller
{
    public function delete()
    {
        $userId = Auth::id();

        // 사용자의 모든 메모 삭제
        Memo::where('author_id', $userId)->delete();

        // 사용자 삭제
        $user = User::findOrFail($userId);
        $user->delete();

        // 사용자 로그아웃
        Auth::logout();

        // 세션을 무효화하여 재로그인 방지
        request()->session()->invalidate();

        // 세션 토큰 재생성
        request()->session()->regenerateToken();

        // 홈으로 리다이렉트하며 세션에 메시지 추가
        return redirect('/')->with('success', 'Your account is successfully deleted.');
    }
}
