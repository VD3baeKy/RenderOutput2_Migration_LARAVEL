{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>会員登録</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    @include('fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <h1 class="mb-4 text-center">会員登録</h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- 氏名 --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="name" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">氏名</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('name')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" id="name" name="name" class="form-control"
                                       value="{{ old('name') }}" autocomplete="name" autofocus placeholder="侍 太郎">
                            </div>
                        </div>

                        {{-- フリガナ --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="furigana" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">フリガナ</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('furigana')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" id="furigana" name="furigana" class="form-control"
                                       value="{{ old('furigana') }}" placeholder="サムライ タロウ">
                            </div>
                        </div>

                        {{-- 郵便番号 --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="postal_code" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">郵便番号</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('postal_code')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" id="postal_code" name="postal_code" class="form-control"
                                       value="{{ old('postal_code') }}" autocomplete="postal-code" placeholder="101-0022">
                            </div>
                        </div>

                        {{-- 住所 --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="address" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">住所</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('address')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" id="address" name="address" class="form-control"
                                       value="{{ old('address') }}" placeholder="東京都千代田区神田練塀町300番地">
                            </div>
                        </div>

                        {{-- 電話番号 --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="phone_number" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">電話番号</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('phone_number')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" id="phone_number" name="phone_number" class="form-control"
                                       value="{{ old('phone_number') }}" autocomplete="tel-national" placeholder="090-1234-5678">
                            </div>
                        </div>

                        {{-- メールアドレス --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="email" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">メールアドレス</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('email')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="email" id="email" name="email" class="form-control"
                                       value="{{ old('email') }}" autocomplete="email" placeholder="taro.samurai@example.com">
                            </div>
                        </div>

                        {{-- パスワード --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="password" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">パスワード</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('password')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="password" id="password" name="password" class="form-control"
                                       autocomplete="new-password">
                            </div>
                        </div>

                        {{-- パスワード確認 --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-5">
                                <label for="password_confirmation" class="col-form-label text-md-left fw-bold">
                                    <div class="d-flex align-items-center">
                                        <span class="me-1">パスワード（確認用）</span>
                                        <span class="badge bg-danger">必須</span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-7">
                                @error('password_confirmation')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                       autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-center my-4">
                            <button type="submit" class="btn text-white shadow-sm w-50 samuraitravel-btn">登録</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="{{ route('login') }}">ログイン</a>
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
