{{-- resources/views/user/edit.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>会員情報編集</title>
</head>
<body>
    <div class="samuraitravel-wrapper">
        {{-- ヘッダー --}}
        @include('fragment.header')

        <main>
            <div class="container pb-5 samuraitravel-container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">ホーム</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('user.show') }}">会員情報</a></li>
                                <li class="breadcrumb-item active" aria-current="page">会員情報編集</li>
                            </ol>
                        </nav>

                        <h1 class="mb-4 text-center">会員情報編集</h1>

                        <form method="POST" action="{{ route('user.update') }}">
                            @csrf
                            {{-- @method('PUT') ← update用なら付けてもOK --}}

                            <input type="hidden" name="id" value="{{ old('id', $user->id ?? '') }}">

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
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" autocomplete="name" autofocus placeholder="侍 太郎">
                                </div>
                            </div>

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
                                    <input type="text" class="form-control" id="furigana" name="furigana" value="{{ old('furigana', $user->furigana ?? '') }}" placeholder="サムライ タロウ">
                                </div>
                            </div>

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
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}" autocomplete="postal-code" placeholder="101-0022">
                                </div>
                            </div>

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
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address ?? '') }}" placeholder="東京都千代田区神田練塀町300番地">
                                </div>
                            </div>

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
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" autocomplete="tel-national" placeholder="090-1234-5678">
                                </div>
                            </div>

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
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" autocomplete="email" placeholder="taro.samurai@example.com">
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-center my-4">
                                <button type="submit" class="btn text-white shadow-sm w-50 samuraitravel-btn">更新</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        {{-- フッター --}}
        @include('fragment.footer')
    </div>

    @include('fragment.scripts')
</body>
</html>
