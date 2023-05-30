<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow background-dark-black color-white" data-scroll-to-active="true">
    <div class="navbar-header d-none" style="margin-top: 6rem !important;">
        <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                data-ticon="disc"></i></a>
    </div>
    <div class="main-menu-content" style="margin-top: 6rem !important;">
        <ul class="navigation navigation-main background-dark-black color-white" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ str_contains(\Request::route()->getName(), 'company') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('manager.company-manage')}}">
                    <i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="{{__('company-manage')}}">{{__('company-manage')}}</span>
                </a>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'client') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('manager.client-manage')}}">
                    <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="{{__('client-manage')}}">{{__('client-manage')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
