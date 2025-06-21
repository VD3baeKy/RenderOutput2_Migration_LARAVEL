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
                                @if($reviewDTO['review'] && $reviewDTO['house'] && $reviewDTO['user'])
                                    <a href="{{ route('houses.show', ['id'=>$reviewDTO['house']->id]) }}" class="link-dark samuraitravel-card-link">
                                        <div class="card h-80 mb-3">
                                            <div class="row g-0">
                                                {{-- 必要なら画像等表示 --}}
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <h3 class="card-title mb-3">{{ $reviewDTO['house']->name }}</h3>
                                                    <h5>
                                                        @if($reviewDTO['review']->updated_at)
                                                            {{ \Carbon\Carbon::parse($reviewDTO['review']->updated_at)->format('Y/m/d') }}
                                                        @else
                                                            日付不明
                                                        @endif
                                                    </h5>
                                                    <h5>
                                                        @for($i=1; $i<=5; $i++)
                                                            {{ $i <= $reviewDTO['review']->rating ? '★' : '☆' }}
                                                        @endfor
                                                    </h5>
                                                    <h5>{{ $reviewDTO['review']->review_text }}</h5>
                                                    <p>{{ $reviewDTO['user']->name }}</p>
                                                    @php
                                                        $isAdmin = Auth::check() && optional(Auth::user()->role)->name === 'ROLE_ADMIN';
                                                        $isOwner = Auth::check() && Auth::id() == $reviewDTO['user']->id;
                                                    @endphp
                                                    @if($isAdmin || $isOwner)
                                                        @if($isOwner)
                                                            <a href="#" class="edit-link" data-id="{{ $reviewDTO['review']->id }}"
                                                               data-house-id="{{ $reviewDTO['house']->id }}"
                                                               data-content="{{ $reviewDTO['review']->review_text }}"
                                                               data-house-name="{{ $reviewDTO['house']->name }}"
                                                               data-rating="{{ $reviewDTO['review']->rating }}"
                                                               data-toggle="modal" data-target="#editModal">
                                                                編集
                                                            </a>
                                                        @endif
                                                        <a href="#" class="delete-link" data-id="{{ $reviewDTO['review']->id }}"
                                                           data-house-id="{{ $reviewDTO['house']->id }}"
                                                           data-content="{{ $reviewDTO['review']->review_text }}"
                                                           data-house-name="{{ $reviewDTO['house']->name }}"
                                                           data-rating="{{ $reviewDTO['review']->rating }}"
                                                           data-toggle="modal" data-target="#deleteModal">
                                                            削除
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <!-- ページネーション -->
                        <div class="d-flex justify-content-center" style="margin-top: 5%;">
                            {{ $reviews->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                        </div>

                        <!-- 編集用モーダル -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form id="editModalForm" method="POST" action="">
                                @csrf
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel">レビュー編集</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="house_id" value="">
                                  <input type="hidden" name="review_id" value="">
                                  <div class="form-group">
                                    <label>民宿名</label>
                                    <input type="text" name="house_name" class="form-control" value="" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label>評価</label>
                                    <input type="number" name="rating" class="form-control" min="1" max="5" value="">
                                  </div>
                                  <div class="form-group">
                                    <label>レビュー</label>
                                    <textarea name="review_text" class="form-control"></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- 削除用モーダル -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form id="deleteModalForm" method="POST" action="">
                                @csrf
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel">レビュー削除</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  本当に削除しますか？
                                </div>
                                <input type="hidden" name="house_id" value="">
                                <input type="hidden" name="review_id" value="">
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  <button type="submit" class="btn btn-danger">削除</button>
                                </div>
                              </form>
                            </div>
                          </div>
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
$(function() {
    // 編集リンククリック時
    $('.edit-link').on('click', function() {
        const review_id = $(this).data('id');
        const house_id = $(this).data('house-id');
        const review_text = $(this).data('content');
        const house_name = $(this).data('house-name');
        const rating = $(this).data('rating');
        // モーダル内に値をセット
        $('#editModal input[name="review_id"]').val(review_id);
        $('#editModal input[name="house_id"]').val(house_id);
        $('#editModal input[name="house_name"]').val(house_name);
        $('#editModal input[name="rating"]').val(rating);
        $('#editModal textarea[name="review_text"]').val(review_text);

        // フォームのactionをセット
        $('#editModalForm').attr('action', '/houses/' + house_id + '/review/' + review_id + '/edit');
    });

    // 削除リンククリック時
    $('.delete-link').on('click', function() {
        const review_id = $(this).data('id');
        const house_id = $(this).data('house-id');
        $('#deleteModal input[name="review_id"]').val(review_id);
        $('#deleteModal input[name="house_id"]').val(house_id);

        // フォームのactionをセット
        $('#deleteModalForm').attr('action', '/houses/' + house_id + '/review/' + review_id + '/delete');
    });
});
function closeModal() {
    $('#editModal').modal('hide');
    $('#deleteModal').modal('hide');
    $('#writeModal').modal('hide');
}
// 必要に応じてreviewDTOをwindow.obj= @json($reviewListJson); で出力＋JS描画もok
</script>
</body>
</html>



