@extends('admin.layouts.app')

@section('title', '民宿詳細')

@section('content')
<div class="samuraitravel-wrapper">
    {{-- ヘッダー --}}
    @include('admin.fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">

                    {{-- パンくずリスト --}}
                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.houses.index') }}">民宿一覧</a></li>
                            <li class="breadcrumb-item active" aria-current="page">民宿詳細</li>
                        </ol>
                    </nav>

                    <h1 class="mb-4 text-center">{{ $house->name }}</h1>

                    <div class="d-flex justify-content-end align-items-end mb-3">
                        <div>
                            <a href="{{ route('admin.houses.edit', $house->id) }}">編集</a>
                        </div>
                    </div>

                    <div class="mb-3">
                        @if ($house->image_name)
                            <img src="{{ asset('storage/' . $house->image_name) }}" class="w-100" alt="民宿画像">
                        @else
                            <img src="{{ asset('images/noImage.png') }}" class="w-100" alt="NO IMAGE">
                        @endif
                    </div>

                    <div class="container mb-4">
                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">ID</span></div>
                            <div class="col"><span>{{ $house->id }}</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">民宿名</span></div>
                            <div class="col"><span>{{ $house->name }}</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">説明</span></div>
                            <div class="col"><span class="samuraitravel-pre-wrap">{{ $house->description }}</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">宿泊料金</span></div>
                            <div class="col"><span>{{ number_format($house->price) }}円</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">定員</span></div>
                            <div class="col"><span>{{ $house->capacity }}人</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">郵便番号</span></div>
                            <div class="col"><span>{{ $house->postal_code }}</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">住所</span></div>
                            <div class="col"><span>{{ $house->address }}</span></div>
                        </div>

                        <div class="row pb-2 mb-2 border-bottom">
                            <div class="col-4"><span class="fw-bold">電話番号</span></div>
                            <div class="col"><span>{{ $house->phone_number }}</span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- フッター --}}
    @include('admin.fragment.footer')
</div>
@endsection

@push('styles')
    @include('admin.fragment.styles')
@endpush

@push('scripts')
    @include('admin.fragment.scripts')
@endpush
