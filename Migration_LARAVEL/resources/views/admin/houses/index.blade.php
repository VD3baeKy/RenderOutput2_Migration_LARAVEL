@extends('admin.layouts.app')

@section('title', '民宿一覧')

@section('content')
<div class="samuraitravel-wrapper">
    @include('admin.fragment.header')

    <main>
        <div class="container pt-4 pb-5 samuraitravel-container">
            <div class="row justify-content-center">
                <div class="col-xxl-9 col-xl-10 col-lg-11">
                    <h1 class="mb-4 text-center">民宿一覧</h1>
                    
                    <div class="d-flex justify-content-between align-items-end flex-wrap">
                        <form method="get" action="{{ route('admin.houses.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="民宿名">
                                <button type="submit" class="btn text-white shadow-sm samuraitravel-btn">検索</button>
                            </div>
                        </form>
                        <a href="{{ route('admin.houses.create') }}" class="btn text-white shadow-sm mb-3 samuraitravel-btn">登録</a>
                    </div>
                    
                    @if(session('successMessage'))
                        <div class="alert alert-info">
                            {{ session('successMessage') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">民宿名</th>
                                <th scope="col">郵便番号</th>
                                <th scope="col">住所</th>
                                <th scope="col">電話番号</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($houses as $house)
                                <tr>
                                    <td>{{ $house->id }}</td>
                                    <td>{{ $house->name }}</td>
                                    <td>{{ $house->postal_code }}</td>
                                    <td>{{ $house->address }}</td>
                                    <td>{{ $house->phone_number }}</td>
                                    <td>
                                        <a href="{{ route('admin.houses.show', $house->id) }}">詳細</a>
                                    </td>
                                    <td>
                                        <!-- 削除リンク（モーダル起動）-->
                                        <a href="#" class="samuraitravel-link-danger" data-bs-toggle="modal" data-bs-target="#deleteHouseModal{{ $house->id }}">削除</a>
                                        <!-- 削除用モーダル -->
                                        <div class="modal fade" id="deleteHouseModal{{ $house->id }}" tabindex="-1" aria-labelledby="deleteHouseModalLabel{{ $house->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteHouseModalLabel{{ $house->id }}">
                                                            {{ $house->name }}を削除してもよろしいですか？
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('admin.houses.destroy', $house->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn samuraitravel-btn-danger text-white shadow-sm">削除</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center">該当する民宿はありません。</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- ページネーション --}}
                    @if ($houses->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $houses->appends(['keyword' => request('keyword')])->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @endif
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
@endpush
