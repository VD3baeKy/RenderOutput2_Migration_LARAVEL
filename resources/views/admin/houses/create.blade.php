@extends('admin.layouts.app')

@section('title', '民宿登録')

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
                            <li class="breadcrumb-item active" aria-current="page">民宿登録</li>
                        </ol>
                    </nav>

                    <h1 class="mb-4 text-center">民宿登録</h1>

                    <form method="POST" action="{{ route('admin.houses.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="name" class="col-form-label text-md-left fw-bold">民宿名</label>
                            </div>
                            <div class="col-md-8">
                                @error('name')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="imageFile" class="col-form-label text-md-left fw-bold">民宿画像</label>
                            </div>
                            <div class="col-md-8">
                                @error('imageFile')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="file" class="form-control" name="imageFile" id="imageFile" accept="image/*">
                            </div>
                        </div>

                        {{-- 画像プレビュー --}}
                        <div class="row mb-3" id="imagePreview"></div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="description" class="col-form-label text-md-left fw-bold">説明</label>
                            </div>
                            <div class="col-md-8">
                                @error('description')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="price" class="col-form-label text-md-left fw-bold">宿泊料金（単位：円）</label>
                            </div>
                            <div class="col-md-8">
                                @error('price')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="capacity" class="col-form-label text-md-left fw-bold">定員（単位：人）</label>
                            </div>
                            <div class="col-md-8">
                                @error('capacity')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="number" class="form-control" name="capacity" id="capacity" value="{{ old('capacity') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="postalCode" class="col-form-label text-md-left fw-bold">郵便番号</label>
                            </div>
                            <div class="col-md-8">
                                @error('postalCode')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="postalCode" id="postalCode" value="{{ old('postalCode') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="address" class="col-form-label text-md-left fw-bold">住所</label>
                            </div>
                            <div class="col-md-8">
                                @error('address')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-4">
                                <label for="phoneNumber" class="col-form-label text-md-left fw-bold">電話番号</label>
                            </div>
                            <div class="col-md-8">
                                @error('phoneNumber')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber') }}">
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-center my-4">
                            <button type="submit" class="btn text-white shadow-sm w-50 samuraitravel-btn">登録</button>
                        </div>
                    </form>

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
    <script src="{{ asset('js/preview.js') }}"></script>
@endpush
