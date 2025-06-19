{{-- resources/views/reviews/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>レビュー一覧</title>
    <!-- JQuery & Bootstrap（モーダル用）CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="samuraitravel-wrapper">
    @include('fragment.header')

    <main>
        <div class="container samuraitravel-container pb-5">
            <div class="row justify-content-center">

                <!-- パンくず -->
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">レビュー一覧</li>
                    </ol>
                </nav>

                <div style="padding: 20px;">
                    <button id="housesLinkButton" class="btn text-white shadow-sm w-100 samuraitravel-btn">民宿一覧ページへ</button>
                    <script>
                        document.getElementById('housesLinkButton').onclick = function() {
                            location.href = '{{ url('houses') }}';
                        };
                    </script>
                </div>

                <!-- サイドバー検索UI -->
                <div class="col-xl-3 col-lg-4 col-md-12">
                    {{-- フリーワード検索 --}}
                    <form method="get" action="{{ route('reviews.index') }}" class="w-100 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="民宿名・目的地">
                            <button type="submit" class="btn text-white shadow-sm samuraitravel-btn">検索</button>
                        </div>
                    </form>

                    {{-- エリアで検索 --}}
                    <div class="card mb-3">
                        <div class="card-header">エリアから探す</div>
                        <div class="card-body">
                            <form method="get" action="{{ route('reviews.index') }}" class="w-100">
                                <div class="form-group mb-3">
                                    <select class="form-control form-select" name="area"> 
                                        <option value="" hidden>選択してください</option>
                                        <optgroup label="北海道"><option value="北海道" @selected(request('area')=='北海道')>北海道</option></optgroup>
                                        <optgroup label="東北">
                                            @foreach(['青森県','岩手県','宮城県','秋田県','山形県','福島県'] as $a)
                                                <option value="{{ $a }}" @selected(request('area')==$a)>{{ $a }}</option>
                                            @endforeach
                                        </optgroup>
                                        {{-- ...他のエリアも同様に展開 --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    {{-- 予算から検索 --}}
                    <div class="card mb-3">
                        <div class="card-header">1泊あたりの予算から探す</div>
                        <div class="card-body">
                            <form method="get" action="{{ route('reviews.index') }}" class="w-100">
                                <div class="form-group mb-3">
                                    <select class="form-control form-select" name="price">
                                        <option value="" hidden>選択してください</option>
                                        @foreach([6000,7000,8000,9000,10000] as $pr)
                                            <option value="{{ $pr }}" @selected(request('price') == $pr)>{{ number_format($pr) }}円以内</option>
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

                <!-- メイン：レビュー一覧 -->
                <div class="col">
                    <div class="col" style="height: 3%;">
                        <div class="d-flex justify-content-between flex-wrap">
                            <p class="fs-5 mb-3">
                                検索結果：{{ $reviews->total() ?? 0 }}件
                                @if(($reviews->lastPage() ?? 1) > 1)
                                    （{{ $reviews->currentPage() }} / {{ $reviews->lastPage() }} ページ）
                                @endif
                            </p>
                            <form method="get" action="{{ route('reviews.index') }}" class="mb-3 samuraitravel-sort-box">
                                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                                <input type="hidden" name="area" value="{{ request('area') }}">
                                <input type="hidden" name="uid" value="{{ Auth::check() ? Auth::id() : 0 }}">
                                <select class="form-select form-select-sm" name="order" onchange="this.form.submit();">
                                    <option value="createdAtDesc" @selected(request('order') == 'createdAtDesc' || !request('order'))>新着順</option>
                                    <option value="priceAsc" @selected(request('order') == 'priceAsc')>宿泊料金が安い順</option>
                                </select>
                            </form>
                        </div>

                        <div id="reviews-container" class="mb-3" style="display: block; margin-top: 5%;">
                            @foreach($reviews as $reviewDTO)
                                <a href="{{ route('houses.show', ['house'=>$reviewDTO->house->id]) }}" class="link-dark samuraitravel-card-link">
                                    <div class="card h-100 mb-3">
                                        <div class="row g-0">
                                            {{-- 必要なら画像等表示 --}}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h3 class="card-title mb-3">{{ $reviewDTO->house->name }}</h3>
                                                <h5>{{ \Carbon\Carbon::parse($reviewDTO->review->updated_at)->format('Y/m/d') }}</h5>
                                                <h5>
                                                    @for($i=1; $i<=5; $i++)
                                                        {{ $i <= $reviewDTO->review->rating ? '★' : '☆' }}
                                                    @endfor
                                                </h5>
                                                <h5>{{ $reviewDTO->review->review_text }}</h5>
                                                <p>{{ $reviewDTO->user->name }}</p>
                                                @if(Auth::check() && Auth::id() == $reviewDTO->user->id)
                                                    <a href="#" class="edit-link" data-id="{{ $reviewDTO->review->id }}"
                                                       data-house-id="{{ $reviewDTO->house->id }}"
                                                       data-content="{{ $reviewDTO->review->review_text }}"
                                                       data-house-name="{{ $reviewDTO->house->name }}"
                                                       data-rating="{{ $reviewDTO->review->rating }}"
                                                       data-toggle="modal" data-target="#editModal">
                                                        編集
                                                    </a>
                                                    <a href="#" class="delete-link" data-id="{{ $reviewDTO->review->id }}"
                                                       data-house-id="{{ $reviewDTO->house->id }}"
                                                       data-content="{{ $reviewDTO->review->review_text }}"
                                                       data-house-name="{{ $reviewDTO->house->name }}"
                                                       data-rating="{{ $reviewDTO->review->rating }}"
                                                       data-toggle="modal" data-target="#deleteModal">
                                                        削除
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- ページネーション -->
                        <div class="d-flex justify-content-center" style="margin-top: 5%;">
                            {{ $reviews->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('fragment.footer')
</div>
@include('fragment.scripts')

<script>
    function closeModal() {
        $('#editModal').modal('hide');
        $('#deleteModal').modal('hide');
        $('#writeModal').modal('hide');
    }
    // 必要に応じてreviewDTOをwindow.obj= @json($reviewListJson); で出力＋JS描画もok
</script>
</body>
</html>
