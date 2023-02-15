<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-language me-3">
                <p id="now_time" class="mb-0" style="margin-right: 15px;"></p>
            </li>
            <li class="nav-item d-none d-lg-block me-3">
                <span class="user-name fw-bolder">ログイン名: {{Auth::user()->name}}</span>
            </li>
            <li class="nav-item nav-search">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="me-50" data-feather="power"></i> {{__('logout')}}</a>
                </form>
            </li>
        </ul>
    </div>
</nav>
