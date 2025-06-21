@extends('admin.layouts.app')

@section('title', '民宿登録')

@section('content')
<div class="samuraitravel-wrapper">
    @include('admin.fragment.header')
    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <h1 class="mb-4 text-center">民宿登録</h1>
                    <form method="POST" action="{{ route('admin.houses.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('admin.houses.form')
                        <div class="form-group d-flex justify-content-center my-4">
                            <button type="submit" class="btn text-white shadow-sm w-50 samuraitravel-btn">登録</button>
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


