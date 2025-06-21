@extends('admin.layouts.app')

@section('title', '民宿情報編集')

@section('content')
<div class="samuraitravel-wrapper">
    {{-- ヘッダー --}}
    @include('admin.fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">

                    <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.houses.index') }}">民宿一覧</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.houses.show', $house->id) }}">民宿詳細</a></li>
                            <li class="breadcrumb-item active" aria-current="page">民宿情報編集</li>
                        </ol>
                    </nav>

                    <h1 class="mb-4 text-center">民宿情報編集</h1>

                    {{-- エラーメッセージ表示 --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.houses.update', $house->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $house->id }}">

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="name" class="col-form-label fw-bold">民宿名</label>
                            </div>
                            <div class="col-md-8">
                                @error('name')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $house->name) }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="imageFile" class="col-form-label fw-bold">民宿画像</label>
                            </div>
                            <div class="col-md-8">
                                @error('imageFile')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="file" name="imageFile" id="imageFile" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- 画像プレビュー --}}
                        <div class="row" id="imagePreview">
                            @if ($house->image_name)
                                <img src="{{ asset('storage/' . $house->image_name) }}" class="mb-3" style="max-width:100%;">
                            @endif
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="description" class="col-form-label fw-bold">説明</label>
                            </div>
                            <div class="col-md-8">
                                @error('description')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <textarea name="description" id="description" class="form-control" cols="30" rows="5">{{ old('description', $house->description) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="price" class="col-form-label fw-bold">宿泊料金（単位：円）</label>
                            </div>
                            <div class="col-md-8">
                                @error('price')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $house->price) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="capacity" class="col-form-label fw-bold">定員（単位：人）</label>
                            </div>
                            <div class="col-md-8">
                                @error('capacity')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $house->capacity) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="postal_code" class="col-form-label fw-bold">郵便番号</label>
                            </div>
                            <div class="col-md-8">
                                @error('postal_code')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $house->postal_code) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="address" class="col-form-label fw-bold">住所</label>
                            </div>
                            <div class="col-md-8">
                                @error('address')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $house->address) }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="phone_number" class="col-form-label fw-bold">電話番号</label>
                            </div>
                            <div class="col-md-8">
                                @error('phone_number')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $house->phone_number) }}">
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-center my-4">
                            <button type="submit" class="btn text-white shadow-sm w-50 samuraitravel-btn">更新</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

    @include('admin.fragment.footer')
</div>
@endsection

@push('styles')
    @include('admin.fragment.styles')
@endpush

@push('scripts')
    @include('admin.fragment.scripts')
    <script src="{{ asset('js/preview.js') }}"></script>
@endpush


