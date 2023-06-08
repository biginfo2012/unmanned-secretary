<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow background-dark-black color-white" data-scroll-to-active="true">
    <div class="navbar-header background-dark-red pt-0">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="/"> <img src="{{asset('icon').'/logo.png'}}" style="width: 30px">
                    <h2 class="brand-text color-white">{{__('manager-sub-title')}}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main background-dark-black color-white" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ str_contains(\Request::route()->getName(), 'client') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('company.client-manage')}}">
                    <i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="{{__('client-manage')}}">{{__('client-manage')}}</span>
                </a>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'my') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('company.my-page')}}">
                    <i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="{{__('my-page')}}">{{__('my-page')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
