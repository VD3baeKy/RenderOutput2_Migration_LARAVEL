{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>ログイン</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    @include('fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7">
                    <h1 class="mb-4 text-center">ログイン</h1>

                    {{-- エラー表示（Laravelのバリデーションやlogin失敗時） --}}
                    @if(session('error') || $errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger">
                            メールアドレスまたはパスワードが正しくありません。
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" name="email"
                                   value="{{ old('email') }}"
                                   autocomplete="email" placeholder="メールアドレス" autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" name="password"
                                   autocomplete="current-password" placeholder="パスワード">
                        </div>

                        <div class="form-group d-flex justify-content-center my-4">
                            <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn">ログイン</button>
                        </div>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('register') }}">会員登録</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('fragment.footer')
</div>
@include('fragment.scripts')
</body>
</html>
