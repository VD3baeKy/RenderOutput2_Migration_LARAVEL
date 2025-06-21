<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationToken;
use App\Services\UserService;
use App\Services\VerificationTokenService;
use App\Events\SignupEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $userService;
    protected $verificationTokenService;

    public function __construct(UserService $userService, VerificationTokenService $verificationTokenService)
    {
        $this->userService = $userService;
        $this->verificationTokenService = $verificationTokenService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function signup(Request $request)
    {
        return view('auth.signup', ['signupForm' => new SignupForm()]);
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // ログイン後のリダイレクト先
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->withInput();
    }

    public function postSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // メールアドレスが登録済みであればエラーを追加
        if ($this->userService->isEmailRegistered($request->email)) {
            return redirect()->back()->withErrors(['email' => 'すでに登録済みのメールアドレスです。'])->withInput();
        }

        // ユーザーを作成
        $createdUser = $this->userService->create($request->all());
        $requestUrl = $request->fullUrl();
        event(new SignupEvent($createdUser, $requestUrl));

        Session::flash('successMessage', 'ご入力いただいたメールアドレスに認証メールを送信しました。メールに記載されているリンクをクリックし、会員登録を完了してください。');

        return redirect('/');
    }

    public function verify($token)
    {
        $verificationToken = $this->verificationTokenService->getVerificationToken($token);

        if ($verificationToken) {
            $user = $verificationToken->user;
            $this->userService->enableUser($user);
            $successMessage = '会員登録が完了しました。';
            return view('auth.verify', ['successMessage' => $successMessage]);
        } else {
            $errorMessage = 'トークンが無効です。';
            return view('auth.verify', ['errorMessage' => $errorMessage]);
        }
    }
}
