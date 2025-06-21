<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500&display=swap" rel="stylesheet">
    <!-- オリジナルCSS -->
    <link href="/css/style.css" rel="stylesheet">
    <title>会員詳細</title>
</head>
<body>
    <div class="samuraitravel-wrapper">

        <!-- ヘッダー -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm samuraitravel-navbar">
            <div class="container samuraitravel-container">
                <a class="navbar-brand" href="/">
                    <img class="samuraitravel-logo me-1" src="/images/logo.png" alt="SAMURAI Travel">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- 管理者メニュー -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                管理者メニュー
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                                <a class="dropdown-item samuraitravel-dropdown-item" href="/admin/users">会員一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="/admin/houses">民宿一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="/reviews">レビュー一覧</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>
                                <form class="d-none" id="logout-form" action="/logout" method="post">@csrf</form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <div class="container pb-5 samuraitravel-container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">会員一覧</a></li>
                                <li class="breadcrumb-item active" aria-current="page">会員詳細</li>
                            </ol>
                        </nav>

                        <h1 class="mb-3 text-center">{{ $user->name }}</h1>

                        <div class="container mb-4">
                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">ID</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->id }}</span>
                                </div>
                            </div>
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
                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">登録日時</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->created_at ? $user->created_at->format('Y/m/d H:i') : '-' }}</span>
                                </div>
                            </div>
                            <div class="row pb-2 mb-2 border-bottom">
                                <div class="col-4">
                                    <span class="fw-bold">更新日時</span>
                                </div>
                                <div class="col">
                                    <span>{{ $user->updated_at ? $user->updated_at->format('Y/m/d H:i') : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-center">
<!--
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary me-2">編集</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger me-2">削除</button>
                            </form>
-->
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">一覧に戻る</a>
                        </div>

                        @if(isset($user->reviews) && $user->reviews->count())
                            <div class="card mt-4">
                                <div class="card-header">
                                    レビュー一覧
                                </div>
                                <div class="card-body">
                                    <ul>
                                    @foreach($user->reviews as $review)
                                        <li>
                                            <a href="{{ route('admin.reviews.show', $review->id) }}">
                                                {{ Str::limit($review->content, 50) }}
                                            </a>
                                            ({{ $review->created_at ? $review->created_at->format('Y/m/d') : '-' }})
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </main>

        <!-- フッター -->
        <footer>
            <div class="d-flex justify-content-center align-items-center h-100">
                <p class="text-center text-muted small mb-0">&copy; SAMURAI Travel All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>



