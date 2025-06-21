<header class="mb-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/admin') }}">SAMURAI Travel 管理者</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="メニュー">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            管理者メニュー
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAdmin">
                            <a class="dropdown-item samuraitravel-dropdown-item" href="{{ url('/admin/users') }}">会員一覧</a>
                            <a class="dropdown-item samuraitravel-dropdown-item" href="{{ url('/admin/houses') }}">民宿一覧</a>
                            <a class="dropdown-item samuraitravel-dropdown-item" href="{{ url('/reviews') }}">レビュー一覧</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item samuraitravel-dropdown-item" href="{{ url('/logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form class="d-none" id="logout-form" action="{{ url('/logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

