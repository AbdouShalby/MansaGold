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
            </ul>
        </div>
    </div>
</aside>
