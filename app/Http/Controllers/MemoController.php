<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    // 메모 수정 폼을 표시
    public function edit(Memo $memo)
    {
        // 수정 권한 검사를 추가할 수 있습니다.
        if (Auth::id() !== $memo->author_id) {
            abort(403);
        }

        return view('edit', compact('memo'));
    }

    // 메모 수정 처리
    public function update(Request $request, Memo $memo)
    {
        // 수정 권한 검사를 추가할 수 있습니다.
        if (Auth::id() !== $memo->author_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $memo->update($validated);

        // 수정 후 리다이렉션할 경로를 지정합니다.
        return redirect()->route('history', $memo);
    }

    public function destroy(Memo $memo)
    {
        // 삭제 권한 검사
        if (Auth::id() !== $memo->author_id) {
            abort(403, 'Unauthorized action.');
        }

        $memo->delete();

        // 삭제 후 리다이렉션, 예를 들어 메모 목록 페이지로 리다이렉션
        return redirect()->route('history')->with('success', 'Memo deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $memoIds = $request->input('memoIds', []);
        Memo::whereIn('id', $memoIds)->delete();

        return response()->json(['message' => 'Selected memos deleted successfully.']);
    }
    public function index(Request $request)
    {
        $query = Memo::query();

        // 검색 기능
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // 정렬 기능
        if ($request->has('sort')) {
            if ($request->sort == 'recent') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        }

        $memos = $query->get();

        return view('history', compact('memos'));
    }

    
}
