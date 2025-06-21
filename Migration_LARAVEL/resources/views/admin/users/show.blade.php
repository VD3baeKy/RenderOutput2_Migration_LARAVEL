@extends('admin.layouts.app')

@section('title', 'ユーザー詳細')

@section('content')
<div class="container">
    <h1>ユーザー詳細</h1>

    <div class="card mt-4">
        <div class="card-header">
            ユーザー情報
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>氏名</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>登録日時</th>
                    <td>{{ $user->created_at->format('Y/m/d H:i') }}</td>
                </tr>
                <tr>
                    <th>更新日時</th>
                    <td>{{ $user->updated_at->format('Y/m/d H:i') }}</td>
                </tr>
                <!-- 必要に応じて下記を追加してください -->
                {{-- <tr>
                    <th>Stripe顧客ID</th>
                    <td>{{ $user->stripe_customer_id }}</td>
                </tr> --}}
                {{-- <tr>
                    <th>ステータス</th>
                    <td>{{ $user->status }}</td>
                </tr> --}}
            </table>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">編集</a>
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">一覧に戻る</a>
        </div>
    </div>

    @if(isset($user->reviews) && $user->reviews->count())
        <div class="card mt-4">
            <div class="card-header">
                レビュー一覧
            </div>
            <div class="card-body">
                <ul>
                @foreach($user->reviews as $review)
                    <li>
                        <a href="{{ route('admin.reviews.show', $review->id) }}">
                            {{ Str::limit($review->content, 50) }}
                        </a> ({{ $review->created_at->format('Y/m/d') }})
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- 必要に応じて追加機能や関連情報をここに追記 --}}
</div>
@endsection
