<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow background-dark-black color-white" data-scroll-to-active="true">
    <div class="navbar-header">
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
            <li class="{{ str_contains(\Request::route()->getName(), 'company') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('manager.company-manage')}}">
                    <i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="{{__('company-manage')}}">{{__('company-manage')}}</span>
                </a>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'client') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('manager.client-manage')}}">
                    <img src="{{asset('icon').'/clients.png'}}" style="width: 25px;" class="me-1"><span class="menu-title text-truncate" data-i18n="{{__('client-manage')}}">{{__('client-manage')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
