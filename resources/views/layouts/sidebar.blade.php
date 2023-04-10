<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="{{ route('home') }}" title="Sleek Dashboard">
                <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30"
                     height="33" viewBox="0 0 30 33">
                    <g fill="none" fill-rule="evenodd">
                        <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                        <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                </svg>
                <span class="brand-name text-truncate">{{ env('APP_NAME') }}</span>
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <li class="search-form d-inline-block d-lg-none">
                    <form class="form-inline" method="POST" action="{{ route('search') }}" id="search-form">
                        @csrf
                        <input type="search" name="search" id="search-input" class="form-control w-75"
                               placeholder="{{ __('navbar.search-now') }}" autofocus autocomplete="off" />
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat" onclick="document.getElementById('search-form').submit();">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </li>
                <li class="has-sub expand {{ isset($pageTitle) && $pageTitle == 'dashboard' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('home') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span class="nav-text">{{ __('sidebar.dashboard.title') }}</span>
                    </a>
                </li>
                <li class="has-sub {{ isset($pageTitle) && $pageTitle == 'groups' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#groups"
                       aria-expanded="false" aria-controls="groups">
                        <i class="mdi mdi-folder-multiple-outline"></i>
                        <span class="nav-text">{{ __('groups.groups.title') }}</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="groups" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('all.groups') }}">
                                    <span class="nav-text">{{ __('groups.groups.all') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('create.group') }}">
                                    <span class="nav-text">{{ __('groups.groups.create') }}</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="has-sub {{ isset($pageTitle) && $pageTitle == 'users' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#users"
                       aria-expanded="false" aria-controls="users">
                        <i class="mdi mdi-account-group"></i>
                        <span class="nav-text">{{ __('users.users.title') }}</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="users" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('all.users') }}">
                                    <span class="nav-text">{{ __('users.users.all') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('create.user') }}">
                                    <span class="nav-text">{{ __('users.users.create') }}</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="has-sub {{ isset($pageTitle) && $pageTitle == 'codes' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#codes"
                       aria-expanded="false" aria-controls="codes">
                        <i class="mdi mdi-barcode-scan"></i>
                        <span class="nav-text">{{ __('codes.codes.title') }}</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="codes" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('all.codes') }}">
                                    <span class="nav-text">{{ __('codes.codes.all') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('create.code') }}">
                                    <span class="nav-text">{{ __('codes.codes.create') }}</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="has-sub {{ isset($pageTitle) && $pageTitle == 'banners' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#banners"
                       aria-expanded="false" aria-controls="banners">
                        <i class="mdi mdi-camera-image"></i>
                        <span class="nav-text">{{ __('banner.banner.title') }}</span> <b class="caret"></b>
                    </a>
                    <ul class="collapse" id="banners" data-parent="#sidebar-menu">
                        <div class="sub-menu">
                            <li>
                                <a class="sidenav-item-link" href="{{ route('all.banners') }}">
                                    <span class="nav-text">{{ __('banner.banner.all') }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="sidenav-item-link" href="{{ route('create.banner') }}">
                                    <span class="nav-text">{{ __('banner.banner.create') }}</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <li class="has-sub expand {{ isset($pageTitle) && $pageTitle == 'withdraws' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('withdraws') }}">
                        <i class="mdi mdi-credit-card-multiple"></i>
                        <span class="nav-text">{{ __('sidebar.withdraws') }}</span>
                    </a>
                </li>
                <li class="has-sub expand {{ isset($pageTitle) && $pageTitle == 'logs' ? 'active' : '' }}">
                    <a class="sidenav-item-link" href="{{ route('logs') }}">
                        <i class="mdi mdi-book-open-page-variant"></i>
                        <span class="nav-text">{{ __('sidebar.logs') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
