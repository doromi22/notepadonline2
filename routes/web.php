<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/write', function () {
    return view('write');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// 로그인한 사용자만 접근 가능
Route::middleware('auth')->group(function () {
    Route::get('/write', function () {
        // 메모 작성 페이지 뷰 반환
        return view('write');
    });

    Route::get('/history', function () {
        // 메모 히스토리 페이지 뷰 반환
        return view('history');
    });
});

// 메모 수정 페이지를 보여주는 라우트
Route::get('/edit/{memo}', [MemoController::class, 'edit'])->name('memo.edit');
// 메모 수정을 처리하는 라우트
Route::post('/memos/{memo}', [MemoController::class, 'update'])->name('memos.update');
// 메모 삭제 라우트
Route::delete('/memos/{memo}', [MemoController::class, 'destroy'])->name('memos.destroy');

Route::get('/history', [HistoryController::class, 'index'])->name('history')->middleware('auth');
Route::post('/submit', [SubmitController::class, 'store'])->name('submit');

Route::post('/delete-selected', [MemoController::class, 'deleteSelected'])->name('memos.deleteSelected');

Route::delete('/user/delete', [UserController::class, 'delete'])->name('user.delete')->middleware('auth');

require __DIR__ . '/auth.php';
