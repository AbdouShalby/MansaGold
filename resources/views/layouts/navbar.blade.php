<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">{{ __('navbar.toggle') }}</span>
        </button>
        <!-- search form -->
        <div class="search-form d-none d-lg-inline-block">
            <div class="input-group">
                <form class="form-inline" method="POST" action="{{ route('search') }}" id="search-form">
                    @csrf
                    <input type="search" name="search" id="search-input" class="form-control"
                           placeholder="{{ __('navbar.search-now') }}" autofocus autocomplete="off" />
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat" onclick="document.getElementById('search-form').submit();">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </form>
            </div>
            <div id="search-results-container">
                <ul id="search-results"></ul>
            </div>
        </div>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <i class="mdi mdi-google-translate mdi-18px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('switchLang','en') }}"><i class="mdi mdi-alpha-e-box mdi-18px"></i> {{ __('navbar.english') }}</a>
                    <a class="dropdown-item" href="{{ route('switchLang','ar') }}"><i class="mdi mdi-alpha-a-box mdi-18px"></i> {{ __('navbar.arabic') }}</a>
                </div>
            </li>
        </ul>
        <div class="navbar-right ">
            <ul class="nav navbar-nav">
                <!-- User Account -->
                <li class="dropdown user-menu">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        @if (!empty(Auth::user()->user_avatar))
                            <img class="h-100 user-image" src="{{ asset(Auth::user()->user_avatar) }}" alt="User Image">
                        @else
                            <img class="h-100 user-image" src="{{ asset('img/no-img.png') }}" alt="User Image">
                        @endif
                        <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- User image -->
                        <li class="dropdown-header">
                            @if (!empty(Auth::user()->user_avatar))
                                <img class="h-100 img-circle" src="{{ asset(Auth::user()->user_avatar) }}" alt="User Image">
                            @else
                                <img class="h-100 img-circle" src="{{ asset('img/no-img.png') }}" alt="User Image">
                            @endif
                            <div class="d-inline-block">
                                {{ Auth::user()->name }} <small class="pt-1">{{ Auth::user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('edit.user', Auth::user()->id) }}">
                                <i class="mdi mdi-account"></i> My Profile
                            </a>
                        </li>
                        <li class="right-sidebar-in">
                            <a href="javascript:;"> <i class="mdi mdi-settings"></i> Setting </a>
                        </li>
                        <li class="dropdown-footer">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="mdi mdi-logout"></i> {{ __('navbar.logout') }} </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
