{{-- resources/views/faborites/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    @include('fragment.meta')
    @include('fragment.styles')
    <title>お気に入り一覧</title>
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
                            <li class="breadcrumb-item active" aria-current="page">お気に入り一覧</li>
                        </ol>
                    </nav>

                    <h1 class="mb-3 text-center">お気に入り一覧</h1>

                    @foreach($fabosPage as $fabo)
                         <a href="{{ route('houses.show', ['id' => $fabo->house->id]) }}" class="link-dark samuraitravel-card-link">
                         <div class="card h-80 mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if($fabo->house->image_name)
                                        <img src="{{ asset('storage/' . $fabo->house->image_name) }}" class="card-img-top samuraitravel-horizontal-card-image" alt="店舗画像">
                                    @else
                                        <img src="{{ asset('images/noImage.png') }}" class="card-img-top samuraitravel-horizontal-card-image" alt="NO IMAGE">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h3 class="card-title mb-3">{{ $fabo->house->name }}</h3>
                                        <hr class="mb-3">
                                        <p class="card-text mb-2">{{ $fabo->house->description }}</p>
                                        <p class="card-text mb-2">
                                            <small class="text-muted">〒{{ $fabo->house->postal_code }}</small>
                                            <small class="text-muted">{{ $fabo->house->address }}</small>
                                        </p>
                                        <p class="card-text">
                                            <span>{{ number_format($fabo->house->price) }}円 / 泊</span>
                                        </p>
                                        <a href="{{ url('houses/' . $fabo->house->id . '/favorite/' . $fabo->loves->user_id . '/remove') }}">［お気に入りから削除］</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach

                    {{-- ページネーション --}}
                    @if($fabosPage->lastPage() > 1)
                        <div class="d-flex justify-content-center">
                            {{ $fabosPage->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
