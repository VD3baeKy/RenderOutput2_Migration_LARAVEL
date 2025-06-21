{{-- resources/views/index.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    {{-- 共通meta・CSSなどをインクルード --}}
    @include('fragment.meta')
    @include('fragment.styles')
    <title>SAMURAI Travel</title>
</head>
<body>
    <div class="samuraitravel-wrapper">
        {{-- ヘッダー --}}
        @include('fragment.header')

        <main>
            <div class="container pt-4 pb-5 samuraitravel-container">

                @if(request()->has('loggedIn'))
                    <div class="alert alert-info">
                        ログインしました。
                    </div>
                @endif

                @if(request()->has('loggedOut'))
                    <div class="alert alert-info">
                        ログアウトしました。
                    </div>
                @endif

                @if(session('successMessage'))
                    <div class="alert alert-info">
                        {{ session('successMessage') }}
                    </div>
                @endif

                <div class="d-flex justify-content-center">
                    {{-- 検索フォーム --}}
                    <form method="get" action="{{ route('houses.index') }}" class="mb-5 samuraitravel-search-form">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" value="{{ old('keyword', request('keyword')) }}" placeholder="民宿名・目的地">
                            <button type="submit" class="btn text-white shadow-sm samuraitravel-btn">検索</button>
                        </div>
                    </form>
                </div>

                <div style="padding: 20px;">
                    <button id="reviewLinkButton" class="btn text-white shadow-sm w-100 samuraitravel-btn">レビュー一覧ページへ</button>
                    <script>
                        document.getElementById('reviewLinkButton').onclick = function() {
                            location.href = '{{ url("/reviews?uid=0") }}';
                        };
                    </script>
                </div>

                <h2 class="text-center mb-3">新着</h2>
                <div class="row row-cols-lg-5 row-cols-2 g-3 mb-5">
                    @foreach($newHouses as $newHouse)
                        <div class="col">
                            <a href="{{ route('houses.show', ['house' => $newHouse->id]) }}" class="link-dark samuraitravel-card-link">
                                <div class="card h-100">
                                    @if($newHouse->image_name)
                                        <img src="{{ asset('storage/'.$newHouse->image_name) }}" class="card-img-top samuraitravel-vertical-card-image" alt="店舗画像">
                                    @else
                                        <img src="{{ asset('images/noImage.png') }}" class="card-img-top samuraitravel-vertical-card-image" alt="NO IMAGE">
                                    @endif
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $newHouse->name }}</h3>
                                        <p class="card-text mb-1">
                                            <small class="text-muted">{{ $newHouse->address }}</small>
                                        </p>
                                        <p class="card-text">
                                            <span>{{ number_format($newHouse->price) }}円 / 泊</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">

                        <h2 class="text-center mb-3">エリアから探す</h2>

                        <table class="table">
                            <tbody>
                                {{-- 地域リンクは@foreachまたはそのままHTMLで展開 --}}
                                <tr>
                                    <th>北海道</th>
                                    <td>
                                        <a href="{{ route('houses.index', ['area' => '北海道']) }}">北海道</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>東北</th>
                                    <td>
                                        <a href="{{ route('houses.index', ['area' => '青森県']) }}" class="me-2">青森県</a>
                                        <a href="{{ route('houses.index', ['area' => '岩手県']) }}" class="me-2">岩手県</a>
                                        <a href="{{ route('houses.index', ['area' => '宮城県']) }}" class="me-2">宮城県</a>
                                        <a href="{{ route('houses.index', ['area' => '秋田県']) }}" class="me-2">秋田県</a>
                                        <a href="{{ route('houses.index', ['area' => '山形県']) }}" class="me-2">山形県</a>
                                        <a href="{{ route('houses.index', ['area' => '福島県']) }}">福島県</a>
                                    </td>
                                </tr>
                                {{-- ...以下同様、各地域・県ごとにリンクを展開 --}}
                                {{-- 省略：中部、関東、近畿...省略は原文参照 --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        {{-- フッター --}}
        @include('fragment.footer')
    </div>

    {{-- 共通スクリプト --}}
    @include('fragment.scripts')
</body>
</html>
