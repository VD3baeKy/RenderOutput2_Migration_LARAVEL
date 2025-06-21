{{-- resources/views/reservations/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>予約一覧</title>
</head>
<body>
<div class="samuraitravel-wrapper">
    {{-- ヘッダー --}}
    @include('fragment.header')

    <main>
        <div class="container samuraitravel-container pb-5">
            <div class="row justify-content-center">
                <div class="col-xxl-9 col-xl-10 col-lg-11">
                    <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">ホーム</a></li>
                            <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
                        </ol>
                    </nav>

                    <h1 class="mb-3 text-center">予約一覧</h1>

                    @if(request()->has('reserved'))
                        <div class="alert alert-info">
                            予約が完了しました。
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">民宿名</th>
                                <th scope="col">チェックイン日</th>
                                <th scope="col">チェックアウト日</th>
                                <th scope="col">宿泊人数</th>
                                <th scope="col">宿泊料金</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservationPage as $reservation)
                                <tr>
                                    <td>
                                        <a href="{{ route('houses.show', ['house' => $reservation->house->id]) }}">{{ $reservation->house->name }}</a>
                                    </td>
                                    <td>{{ $reservation->checkin_date }}</td>
                                    <td>{{ $reservation->checkout_date }}</td>
                                    <td>{{ $reservation->number_of_people }}名</td>
                                    <td>{{ number_format($reservation->amount) }}円</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- ページネーション --}}
                    @if($reservationPage->lastPage() > 1)
                       <div class="d-flex justify-content-center">
                            {{ $reservationPage->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                       </div>
                    @endif

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
