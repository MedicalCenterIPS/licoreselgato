@php
    $appHeaderAttr = !empty($appHeaderInverse) ? ' data-bs-theme=dark' : '';
    $appHeaderMenu = !empty($appHeaderMenu) ? $appHeaderMenu : '';
    $appHeaderMegaMenu = !empty($appHeaderMegaMenu) ? $appHeaderMegaMenu : '';
    $appHeaderTopMenu = !empty($appHeaderTopMenu) ? $appHeaderTopMenu : '';
@endphp

<!-- BEGIN #header -->
<div id="header" class="app-header" {{ $appHeaderAttr }}>
    <!-- BEGIN navbar-header -->
    <div class="navbar-header d-flex align-items-center justify-content-center">
        @if ($appSidebarTwo)
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-end-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        @endif
        <div class="d-flex align-items-center">
            <a href="#" class="navbar-brand keychainify-checked">
                <img src="{{ asset('assets/img/logo/logo - hc white.png') }}" class="p-0">
            </a>
        </div>
        @if ($appHeaderMegaMenu && !$appSidebarTwo)
            <button type="button" class="navbar-mobile-toggler" data-bs-toggle="collapse" data-bs-target="#top-navbar">
                <span class="fa-stack fa-lg">
                    <i class="far fa-square fa-stack-2x"></i>
                    <i class="fa fa-cog fa-stack-1x mt-1px"></i>
                </span>
            </button>
        @endif
        @if ($appTopMenu && !$appSidebarHide && !$appSidebarTwo)
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-top-menu-mobile">
                <span class="fa-stack fa-lg">
                    <i class="far fa-square fa-stack-2x"></i>
                    <i class="fa fa-cog fa-stack-1x mt-1px"></i>
                </span>
            </button>
        @endif
        @if ($appTopMenu && $appSidebarHide && !$appSidebarTwo)
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-top-menu-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        @endif
        @if (!$appSidebarHide)
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        @endif
    </div>

    @includeWhen($appHeaderMegaMenu, 'includes.component.header-mega-menu')

    <!-- BEGIN header-nav -->
    <div class="navbar-nav">
        <div class="navbar-item logo-acs">
            <img src="{{ asset('assets/img/logo/banner - acs.png') }}" class="m-0 img3">
        </div>

        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <span>
                    <span class="d-none d-md-inline fw-bolder fs-16px">{{ auth()->user()->name }}</span>
                    <b class="caret"></b>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1 text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn menu-link no-border fw-bolder fs-14px">
                        <i class="fa fa-power-off"></i>
                        Cerrar Sesion
                    </button>
                </form>
            </div>
        </div>

        @if ($appSidebarTwo)
            <div class="navbar-divider d-none d-md-block"></div>
            <div class="navbar-item d-none d-md-block">
                <a href="javascript:;" data-toggle="app-sidebar-end" class="navbar-link icon">
                    <i class="fa fa-th"></i>
                </a>
            </div>
        @endif
    </div>
    <!-- END header-nav -->
</div>
<!-- END #header -->
