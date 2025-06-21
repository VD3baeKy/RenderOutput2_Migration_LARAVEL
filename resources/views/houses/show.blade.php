<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- jQuery & Bootstrap（CDN）for modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <title>民宿詳細</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    {{-- ヘッダー --}}
    @include('fragment.header')
    <main>
        @if(session('successMessage'))
            <div class="alert alert-info">{{ session('successMessage') }}</div>
        @endif

        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xxl-9 col-xl-10 col-lg-11">
                    {{-- パンくず --}}
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <div class="d-flex justify-content-between align-items-center" style="background-color: #e9ecef; padding: 10px;">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">ホーム</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('houses.index') }}">民宿一覧</a></li>
                                <li class="breadcrumb-item active" aria-current="page">民宿詳細</li>
                            </ol>
                            <div class="likethis">
                                @auth
                                    @if($likeThis)
                                        <a href="{{ url("/houses/{$house->id}/favorite/" . Auth::id() . "/remove") }}">&#9829;お気に入り解除</a>
                                    @else
                                        <a href="{{ url("/houses/{$house->id}/favorite/" . Auth::id() . "/add") }}">&#9825;お気に入り追加</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </nav>

                    <h1 class="mb-4 text-center">{{ $house->name }}</h1>
                    @if(session('errorMessage'))
                        <div class="alert alert-danger">{{ session('errorMessage') }}</div>
                    @endif

                    <div class="mb-4">
                        @if($house->image_name)
                            <img src="{{ asset('storage/' . $house->image_name) }}" class="w-100" alt="民宿画像">
                        @else
                            <img src="{{ asset('images/noImage.png') }}" class="w-100" alt="NO IMAGE">
                        @endif
                    </div>

                    {{-- 詳細情報 --}}
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 container mb-4">
                                @foreach([
                                    '民宿名'     => $house->name,
                                    '説明'       => $house->description,
                                    '宿泊料金'   => number_format($house->price) . '円',
                                    '定員'       => $house->capacity . '人',
                                    '郵便番号'   => $house->postal_code,
                                    '住所'       => $house->address,
                                    '電話番号'   => $house->phone_number
                                ] as $label => $value)
                                <div class="row pb-2 mb-2 border-bottom">
                                    <div class="col-4"><span class="fw-bold">{{ $label }}</span></div>
                                    <div class="col samuraitravel-pre-wrap">{{ $value }}</div>
                                </div>
                                @endforeach
                            </div>

                            {{-- 予約フォーム・ログイン状態分岐 --}}
                            <div class="col-lg-4 px-0 ps-lg-4 mb-4">
                                @guest
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">
                                            予約するには
                                            <a href="{{ route('login') }}">ログイン</a>
                                            が必要です。
                                        </p>
                                        <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn" disabled>
                                            予約する
                                        </button>
                                    </div>
                                </div>
                                @else
                                <div class="card">
                                    <div class="card-body">
                                        {{-- 予約内容確認画面に進むだけ。決済はまだしない --}}
                                        <form method="post" action="{{ route('houses.reservations.input', ['house' => $house->id]) }}">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <label class="col-form-label text-md-left fw-bold">チェックイン・チェックアウト</label>
                                                @error('checkin_date')
                                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                                @enderror
                                                @error('checkout_date')
                                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                                @enderror
                                                <input type="text" class="form-control" id="checkin_checkout" name="checkin_checkout_range" value="{{ old('checkin_checkout_range') }}" autocomplete="off">
                                                {{-- hiddenで個別日付を保持 --}}
                                                <input type="hidden" name="checkin_date" id="checkin_date" value="{{ old('checkin_date') }}">
                                                <input type="hidden" name="checkout_date" id="checkout_date" value="{{ old('checkout_date') }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="col-form-label text-md-left fw-bold">宿泊人数</label>
                                                @error('number_of_people')
                                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                                @enderror
                                                <input type="number" class="form-control" name="number_of_people" value="{{ old('number_of_people') ?? 1 }}" min="1">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn text-white shadow-sm w-100 samuraitravel-btn">予約内容を確認</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endguest
                            </div>
                        </div>
                    </div>

                    {{-- ------ レビュー部分 ------ --}}
                    <div>
                        <h3>［{{ $house->name }}］のレビュー　全 {{ count($reviews ?? []) }} 件</h3>

                        @if(count($reviews ?? []) > 5)
                            <div style="padding: 20px;">
                                <button id="reviewLinkButton" class="btn text-white shadow-sm w-100 samuraitravel-btn">すべてのレビューを表示する</button>
                                <script>
                                    document.getElementById('reviewLinkButton').onclick = function() {
                                        location.href = '/reviews?uid=0&reviewhouseId={{ $house->id }}';
                                    };
                                </script>
                            </div>
                        @endif

                        {{-- レビュー投稿ボタン（ログイン＆未投稿時） --}}
                        @auth
                        @if(!$hasWrittenReview)
                        <div style="padding: 20px;">
                            <center>
                                <button id="reviewWriteButton" class="btn text-white shadow-sm w-25 samuraitravel-btn" onclick="$('#writeModal').modal('show');">レビューを投稿する</button>
                            </center>
                        </div>
                        @endif
                        {{-- レビュー投稿モーダル --}}
                        @include('houses._review_write_modal', [
                            'house' => $house,
                            'user_id' => auth()->id()
                        ])
                        @endauth

                        {{-- ログインしていない場合 --}}
                        @guest
                            <p class="card-text">
                                レビューを投稿するには <a href="{{ route('login') }}">ログイン</a> が必要です。
                            </p>
                        @endguest

                        {{-- ★★★ レビュー一覧表示 ★★★ --}}
                        <div class="mt-4">
                            @if(count($reviews ?? []) > 0)
                                @foreach($reviews as $review)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                評価: {!! str_repeat('★', $review->rating) . str_repeat('☆', 5 - $review->rating) !!}
                                            </h5>
                                            <p class="card-text">{{ $review->review_text }}</p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    投稿日: {{ $review->created_at->format('Y-m-d H:i') }}
                                                    @if(isset($userAll))
                                                        @php
                                                            $userObj = $userAll->firstWhere('id', $review->user_id);
                                                        @endphp
                                                        @if($userObj)
                                                            ／ 投稿者: {{ $userObj->name }}
                                                        @else
                                                            ／ 投稿者: 退会ユーザー
                                                        @endif
                                                    @endif
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>レビューはまだありません。</p>
                            @endif
                        </div>
                        {{-- ★★★ ここまでレビュー一覧 ★★★ --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('fragment.footer')
</div>
@include('fragment.scripts')

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ja.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#checkin_checkout", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "ja",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                // チェックイン・チェックアウト両方選ばれたらhiddenにセット
                const [checkin, checkout] = selectedDates;
                document.getElementById('checkin_date').value = instance.formatDate(checkin, "Y-m-d");
                document.getElementById('checkout_date').value = instance.formatDate(checkout, "Y-m-d");
            } else if (selectedDates.length === 1) {
                // 片方だけならチェックインのみ
                document.getElementById('checkin_date').value = instance.formatDate(selectedDates[0], "Y-m-d");
                document.getElementById('checkout_date').value = "";
            } else {
                document.getElementById('checkin_date').value = "";
                document.getElementById('checkout_date').value = "";
            }
        }
    });
});

function closeModal() {
    $('#editModal').modal('hide');
    $('#deleteModal').modal('hide');
    $('#writeModal').modal('hide');
    $('#contentModal').modal('hide');
}
</script>
</body>
</html>



