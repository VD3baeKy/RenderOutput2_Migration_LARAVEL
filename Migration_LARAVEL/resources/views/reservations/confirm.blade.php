{{-- resources/views/reservations/confirm.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>予約内容確認</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    {{-- ヘッダー --}}
    @include('fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9">
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">ホーム</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('houses.index') }}">民宿一覧</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('houses.show', ['house'=>$house->id]) }}">民宿詳細</a></li>
                            <li class="breadcrumb-item active" aria-current="page">予約内容確認</li>
                        </ol>
                    </nav>

                    <h1 class="mb-4 text-center">予約内容確認</h1>

                    {{-- 予約内容確認（表示のみ、hidden入力は不要） --}}
                    <div class="container mb-4">
                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-6"><span class="fw-bold">チェックイン日</span></div>
                            <div class="col">{{ $reservationRegisterForm['checkin_date'] ?? '' }}</div>
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-6"><span class="fw-bold">チェックアウト日</span></div>
                            <div class="col">{{ $reservationRegisterForm['checkout_date'] ?? '' }}</div>
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-6"><span class="fw-bold">宿泊人数</span></div>
                            <div class="col">{{ $reservationRegisterForm['number_of_people'] ?? '' }}名</div>
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-6"><span class="fw-bold">宿泊料金</span></div>
                            <div class="col">{{ isset($reservationRegisterForm['amount']) ? number_format($reservationRegisterForm['amount']) : '' }}円</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{-- Stripe決済用のボタン --}}
                        <button id="paymentButton" class="btn text-white shadow-sm w-100 samuraitravel-btn">決済する</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- フッター --}}
    @include('fragment.footer')
</div>
@include('fragment.scripts')

{{-- Stripe JS --}}
<script src="https://js.stripe.com/v3"></script>
<script>
    // sessionIdはコントローラでViewにセット
    const sessionId = @json($sessionId ?? '');
</script>
<script src="{{ asset('js/stripe.js') }}"></script>
</body>
</html>
