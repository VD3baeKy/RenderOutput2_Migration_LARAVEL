<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Pagination\Paginator;

    class AdminUserController extends Controller{
        public function index(Request $request){
            $keyword = $request->input('keyword');
            $query = User::query();

            if ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('furigana', 'like', '%' . $keyword . '%');
            }

            $users = $query->orderBy('id', 'asc')->paginate(10);

            return view('admin.users.index', [
                'userPage' => $users,
                'keyword' => $keyword,
            ]);
        }

        public function show($id){
            $user = User::findOrFail($id);

            return view('admin.users.show', [
                'user' => $user,
            ]);
        }
    }
