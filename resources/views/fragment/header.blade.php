<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm samuraitravel-navbar">
    <div class="container samuraitravel-container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="samuraitravel-logo me-1" src="{{ asset('images/logo.png') }}" alt="SAMURAI Travel">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                {{-- 未ログイン時 --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">会員登録</a>
                    </li>
                @endguest

                {{-- 一般ユーザー：ログイン時 --}}
                @auth
                    @if(Auth::user()->role->name === 'ROLE_GENERAL')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownGeneral" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownGeneral">
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('user.show') }}">会員情報</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('reservations.index') }}">予約一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ url('/reviews?uid=' . Auth::id()) }}">私のレビュー一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('favorites.index') }}">お気に入り一覧</a>
                                <div class="dropdown-divider"></div>
                                {{-- ログアウト --}}
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif

                    {{-- 管理者ユーザー：ログイン時 --}}
                    @if(Auth::user()->role->name === 'ROLE_ADMIN')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                管理者メニュー
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('admin.users.index') }}">会員一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('admin.houses.index') }}">民宿一覧</a>
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('reviews.index') }}">レビュー一覧</a>
                                <div class="dropdown-divider"></div>
                                {{-- ログアウト --}}
                                <a class="dropdown-item samuraitravel-dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
