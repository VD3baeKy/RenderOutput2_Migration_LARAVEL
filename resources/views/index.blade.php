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
                            <a href="{{ route('houses.show', ['id' => $newHouse->id]) }}" class="link-dark samuraitravel-card-link">
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
                        <table class="table table-bordered">
    <tbody>
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
        <tr>
            <th>北関東</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '茨城県']) }}" class="me-2">茨城県</a>
                <a href="{{ route('houses.index', ['area' => '栃木県']) }}" class="me-2">栃木県</a>
                <a href="{{ route('houses.index', ['area' => '群馬県']) }}">群馬県</a>
            </td>
        </tr>
        <tr>
            <th>首都圏</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '埼玉県']) }}" class="me-2">埼玉県</a>
                <a href="{{ route('houses.index', ['area' => '千葉県']) }}" class="me-2">千葉県</a>
                <a href="{{ route('houses.index', ['area' => '東京都']) }}" class="me-2">東京都</a>
                <a href="{{ route('houses.index', ['area' => '神奈川県']) }}">神奈川県</a>
            </td>
        </tr>
        <tr>
            <th>甲信越</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '新潟県']) }}" class="me-2">新潟県</a>
                <a href="{{ route('houses.index', ['area' => '山梨県']) }}" class="me-2">山梨県</a>
                <a href="{{ route('houses.index', ['area' => '長野県']) }}">長野県</a>
            </td>
        </tr>
        <tr>
            <th>北陸</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '富山県']) }}" class="me-2">富山県</a>
                <a href="{{ route('houses.index', ['area' => '石川県']) }}" class="me-2">石川県</a>
                <a href="{{ route('houses.index', ['area' => '福井県']) }}">福井県</a>
            </td>
        </tr>
        <tr>
            <th>東海</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '岐阜県']) }}" class="me-2">岐阜県</a>
                <a href="{{ route('houses.index', ['area' => '静岡県']) }}" class="me-2">静岡県</a>
                <a href="{{ route('houses.index', ['area' => '愛知県']) }}" class="me-2">愛知県</a>
                <a href="{{ route('houses.index', ['area' => '三重県']) }}">三重県</a>
            </td>
        </tr>
        <tr>
            <th>近畿</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '滋賀県']) }}" class="me-2">滋賀県</a>
                <a href="{{ route('houses.index', ['area' => '京都府']) }}" class="me-2">京都府</a>
                <a href="{{ route('houses.index', ['area' => '大阪府']) }}" class="me-2">大阪府</a>
                <a href="{{ route('houses.index', ['area' => '兵庫県']) }}" class="me-2">兵庫県</a>
                <a href="{{ route('houses.index', ['area' => '奈良県']) }}" class="me-2">奈良県</a>
                <a href="{{ route('houses.index', ['area' => '和歌山県']) }}">和歌山県</a>
            </td>
        </tr>
        <tr>
            <th>山陽・山陰</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '鳥取県']) }}" class="me-2">鳥取県</a>
                <a href="{{ route('houses.index', ['area' => '島根県']) }}" class="me-2">島根県</a>
                <a href="{{ route('houses.index', ['area' => '岡山県']) }}" class="me-2">岡山県</a>
                <a href="{{ route('houses.index', ['area' => '広島県']) }}" class="me-2">広島県</a>
                <a href="{{ route('houses.index', ['area' => '山口県']) }}">山口県</a>
            </td>
        </tr>
        <tr>
            <th>四国</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '徳島県']) }}" class="me-2">徳島県</a>
                <a href="{{ route('houses.index', ['area' => '香川県']) }}" class="me-2">香川県</a>
                <a href="{{ route('houses.index', ['area' => '愛媛県']) }}" class="me-2">愛媛県</a>
                <a href="{{ route('houses.index', ['area' => '高知県']) }}">高知県</a>
            </td>
        </tr>
        <tr>
            <th>九州</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '福岡県']) }}" class="me-2">福岡県</a>
                <a href="{{ route('houses.index', ['area' => '佐賀県']) }}" class="me-2">佐賀県</a>
                <a href="{{ route('houses.index', ['area' => '長崎県']) }}" class="me-2">長崎県</a>
                <a href="{{ route('houses.index', ['area' => '熊本県']) }}" class="me-2">熊本県</a>
                <a href="{{ route('houses.index', ['area' => '大分県']) }}" class="me-2">大分県</a>
                <a href="{{ route('houses.index', ['area' => '宮崎県']) }}" class="me-2">宮崎県</a>
                <a href="{{ route('houses.index', ['area' => '鹿児島県']) }}">鹿児島県</a>
            </td>
        </tr>
        <tr>
            <th>沖縄</th>
            <td>
                <a href="{{ route('houses.index', ['area' => '沖縄県']) }}">沖縄県</a>
            </td>
        </tr>
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
