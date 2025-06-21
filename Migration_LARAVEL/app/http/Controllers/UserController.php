<?php
  namespace app\http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Validator;
  use app\Models\User;
  use app\Http\Requests\UserEditRequest; // 後述
  use app\Services\UserService;

  class UserController extends Controller{
    protected $userService;

    // DI（サービス層がある場合）
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    // 会員情報表示
    public function index(){
        $user = Auth::user(); // ログインユーザー取得
        return view('user.index', compact('user'));
    }

    // 会員情報編集フォーム表示
    public function edit(){
        $user = Auth::user();

        // UserEditForm的な使い方（そのまま$userをフォームバインドで利用）
        return view('user.edit', ['userEditForm' => $user]);
    }

    // 会員情報更新（バリデーション付き）
    public function update(Request $request){
        $user = Auth::user();

        // 1. バリデーション
        $validator = Validator::make($request->all(), [
            'name'        => ['required', 'max:255'],
            'furigana'    => ['nullable', 'max:255'],
            'postal_code' => ['nullable', 'max:20'],
            'address'     => ['nullable', 'max:255'],
            'phone_number'=> ['nullable', 'max:30'],
            'email'       => ['required', 'email', 'max:255'],
        ]);
        // メールが変更されていて、かつ登録済みならエラー
        if ($request->input('email') !== $user->email) {
            if (User::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'すでに登録済みのメールアドレスです。');
            }
        }
        if ($validator->fails()) {
            return redirect()->route('user.edit')
                ->withErrors($validator)
                ->withInput();
        }

        // 2. データ更新
        $this->userService->updateProfile($user, $request->all());

        // 3. フラッシュメッセージ
        return redirect()->route('user.index')->with('successMessage', '会員情報を編集しました。');
    }
  }
