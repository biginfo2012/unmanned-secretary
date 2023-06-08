<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow background-dark-black color-white" data-scroll-to-active="true">
    <div class="navbar-header background-sky pt-0">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="/"> <img src="{{asset('icon').'/logo.png'}}" style="width: 30px">
                    <h2 class="brand-text color-white">{{__('manager-sub-title')}}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main background-dark-black color-white" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ str_contains(\Request::route()->getName(), 'cost') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('client.cost-manage')}}">
                    <img src="{{asset('icon').'/money.png'}}" style="width: 25px;" class="me-1"><span class="menu-title text-truncate" data-i18n="{{__('cost-manage')}}">{{__('cost-manage')}}</span>
                </a>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'software') ? 'sidebar-group-active open' : '' }} nav-item has-sub">
                <a class="d-flex align-items-center" href="#">
                    <img src="{{asset('icon').'/export.png'}}" style="width: 25px;" class="me-1"><span class="menu-title text-truncate" data-i18n="{{__('account-software')}}">{{__('account-software')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ str_contains(\Request::route()->getName(), 'software-add') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{str_contains(\Request::route()->getName(), 'software-add') ? '#' : route('client.software-add')}}">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="{{__('new')}}">{{__('new')}}</span>
                        </a>
                    </li>
                    <li class="{{ str_contains(\Request::route()->getName(), 'software-history') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{str_contains(\Request::route()->getName(), 'software-history') ? '#' : route('client.software-history')}}">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="{{__('history')}}">{{__('history')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'account') ? 'sidebar-group-active open' : '' }} nav-item has-sub">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="{{__('setting')}}">{{__('setting')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ str_contains(\Request::route()->getName(), 'account') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{str_contains(\Request::route()->getName(), 'account-manage') ? '#' : route('client.account-manage')}}">
                            <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="{{__('account-manage')}}">{{__('account-manage')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ str_contains(\Request::route()->getName(), 'my') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{route('client.my-page')}}">
                    <i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="{{__('my-page')}}">{{__('my-page')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
