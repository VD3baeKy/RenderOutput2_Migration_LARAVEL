{{-- resources/views/user/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>会員情報</title>
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
                                <li class="breadcrumb-item active" aria-current="page">会員情報</li>
                            </ol>
                        </nav>

                        <h1 class="mb-3 text-center">会員情報</h1>

                        <div class="d-flex justify-content-end align-items-end mb-3">
                            <div>
                                <a href="{{ route('user.edit') }}">編集</a>
                            </div>
                        </div>

                        @if(session('successMessage'))
                            <div class="alert alert-info">
                                {{ session('successMessage') }}
                            </div>
                        @endif

                        <div class="container mb-4">
                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">氏名</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </div>

                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">フリガナ</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->furigana }}</span>
                                </div>
                            </div>

                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">郵便番号</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->postal_code }}</span>
                                </div>
                            </div>

                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">住所</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->address }}</span>
                                </div>
                            </div>

                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">電話番号</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->phone_number }}</span>
                                </div>
                            </div>

                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">メールアドレス</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
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
