<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = User::query();

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('furigana', 'like', '%' . $keyword . '%');
        }

        $users = $query->orderBy('id', 'asc')->paginate(10);

        // ここで 'users' という名前でビューに渡す
        return view('admin.users.index', [
            'users' => $users,
            'keyword' => $keyword,
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }
}


