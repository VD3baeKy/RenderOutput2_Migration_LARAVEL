<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>民宿一覧</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    @include('fragment.header')

    <main>
        <div class="container samuraitravel-container pb-5">
            <div class="row justify-content-center">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">民宿一覧</li>
                    </ol>
                </nav>

                <div style="padding: 20px;">
                    <button id="reviewLinkButton" class="btn text-white shadow-sm w-100 samuraitravel-btn">レビュー一覧ページへ</button>
                    <script>
                        document.getElementById('reviewLinkButton').onclick = function() {
                            location.href = '{{ url('reviews?uid=0') }}';
                        };
                    </script>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-12">
                    {{-- キーワード検索 --}}
                    <form method="get" action="{{ route('houses.index') }}" class="w-100 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="民宿名・目的地">
                            <button type="submit" class="btn text-white shadow-sm samuraitravel-btn">検索</button>
                        </div>
                    </form>

                    {{-- エリアから探す --}}
                    <div class="card mb-3">
                        <div class="card-header">エリアから探す</div>
                        <div class="card-body">
                            <form method="get" action="{{ route('houses.index') }}" class="w-100">
                                <div class="form-group mb-3">
                                    <select class="form-control form-select" name="area">
                                        <option value="" hidden>選択してください</option>
                                        <optgroup label="北海道">
                                            <option value="北海道" @selected(request('area')=='北海道')>北海道</option>
                                        </optgroup>
                                        <optgroup label="東北">
                                            @foreach(['青森県','岩手県','宮城県','秋田県','山形県','福島県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="北関東">
                                            @foreach(['茨城県','栃木県','群馬県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="首都圏">
                                            @foreach(['埼玉県','千葉県','東京都','神奈川県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="甲信越">
                                            @foreach(['新潟県','山梨県','長野県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="北陸">
                                            @foreach(['富山県','石川県','福井県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="東海">
                                            @foreach(['岐阜県','静岡県','愛知県','三重県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="近畿">
                                            @foreach(['滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="山陽・山陰">
                                            @foreach(['鳥取県','島根県','岡山県','広島県','山口県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="四国">
                                            @foreach(['徳島県','香川県','愛媛県','高知県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="九州">
                                            @foreach(['福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')===$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="沖縄">
                                            <option value="沖縄県" @selected(request('area')=='沖縄県')>沖縄県</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- 予算から探す --}}
                    <div class="card mb-3">
                        <div class="card-header">1泊あたりの予算から探す</div>
                        <div class="card-body">
                            <form method="get" action="{{ route('houses.index') }}" class="w-100">
                                <div class="form-group mb-3">
                                    <select class="form-control form-select" name="price">
                                        <option value="" hidden>選択してください</option>
                                        @foreach([6000,7000,8000,9000,10000] as $p)
                                            <option value="{{ $p }}" @selected(request('price')==$p)>{{ number_format($p) }}円以内</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- メインコンテンツ（民宿一覧） --}}
                <div class="col">
                    <div class="d-flex justify-content-between flex-wrap">
                        <p class="fs-5 mb-3">
                            検索結果：{{ $housePage->total() }}件
                            @if($housePage->lastPage() > 1)
                                （{{ $housePage->currentPage() }} / {{ $housePage->lastPage() }} ページ）
                            @endif
                        </p>
                        <form method="get" action="{{ route('houses.index') }}" class="mb-3 samuraitravel-sort-box">
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            <input type="hidden" name="area" value="{{ request('area') }}">
                            <input type="hidden" name="price" value="{{ request('price') }}">
                            <select class="form-select form-select-sm" name="order" onchange="this.form.submit();">
                                <option value="createdAtDesc" @selected(request('order')=='createdAtDesc' || !request('order'))>新着順</option>
                                <option value="priceAsc" @selected(request('order')=='priceAsc')>宿泊料金が安い順</option>
                            </select>
                        </form>
                    </div>

                    @foreach($housePage as $house)
                        <a href="{{ route('houses.show', ['id' => $house->id]) }}" class="link-dark samuraitravel-card-link">
                        <div class="card h-80 mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if($house->image_name)
                                        <img src="{{ asset('storage/' . $house->image_name) }}" class="card-img-top samuraitravel-horizontal-card-image" alt="店舗画像">
                                    @else
                                        <img src="{{ asset('images/noImage.png') }}" class="card-img-top samuraitravel-horizontal-card-image" alt="NO IMAGE">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h3 class="card-title mb-3">{{ $house->name }}</h3>
                                        <hr class="mb-3">
                                        <p class="card-text mb-2">{{ $house->description }}</p>
                                        <p class="card-text mb-2">
                                            <small class="text-muted">〒{{ $house->postal_code }}</small>
                                            <small class="text-muted">{{ $house->address }}</small>
                                        </p>
                                        <p class="card-text">
                                            <span>{{ number_format($house->price) }}円 / 泊</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach

                    @if($housePage->lastPage() > 1)
                        <div class="d-flex justify-content-center">
                            {{ $housePage->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
    @include('fragment.footer')
</div>
@include('fragment.scripts')
</body>
</html>


