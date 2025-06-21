@extends('admin.layouts.app')

@section('title', '会員一覧')

@section('content')
<div class="samuraitravel-wrapper">
    <!-- ヘッダー -->
    @include('admin.fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xxl-9 col-xl-10 col-lg-11">
                    <h1 class="mb-4 text-center">会員一覧</h1>

                    <div class="d-flex justify-content-between align-items-end">
                        <form method="get" action="{{ route('admin.users.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="氏名・フリガナ">
                                <button type="submit" class="btn text-white shadow-sm samuraitravel-btn">検索</button>
                            </div>
                        </form>
                    </div>

                    @if (session('successMessage'))
                        <div class="alert alert-info">
                            {{ session('successMessage') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">氏名</th>
                                <th scope="col">フリガナ</th>
                                <th scope="col">メールアドレス</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->furigana }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><a href="{{ route('admin.users.show', $user->id) }}">詳細</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">該当する会員がいません。</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- ページネーション（ページが複数ある場合のみ表示） -->
                    @if ($users->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $users->appends(['keyword' => request('keyword')])->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- フッター -->
    @include('admin.fragment.footer')
</div>
@endsection

@push('styles')
    @include('admin.fragment.styles')
@endpush

@push('scripts')
    @include('admin.fragment.scripts')
@endpush
