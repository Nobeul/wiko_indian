<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-menu') }}">
                </use>
            </svg>
        </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('public/admin/assets/brand/coreui.svg#full') }}"></use>
            </svg></a>
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('company-settings') }}">Settings</a></li>
        </ul>
        <ul class="header-nav ms-auto">
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown"
                    href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    @if (auth()->user()->profile_image)
                        <div class="avatar avatar-md"><img class="avatar-img"
                                src="{{ asset('public/admin/assets/img/avatars/'.auth()->user()->profile_image) }}" alt="Profile Image">
                        </div>
                    @else 
                        <div class="avatar avatar-md"><img class="avatar-img"
                            src="{{ asset('public/admin/assets/img/avatars/default-profile.png') }}" alt="Profile Image">
                        </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div>
                        <a class="dropdown-item" href="{{ url('profile') }}">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-user') }}">
                            </use>
                        </svg> Profile</a>                     
                    </div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <svg class="icon me-2">
                            <use
                                xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}">
                            </use>
                        </svg> Logout</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>{{ isset($module) && !empty($module) ? $module : '' }}</span>
                </li>
                <li class="breadcrumb-item active"><span>{{ isset($sub_module) && !empty($sub_module) ? $sub_module : '' }}</span></li>
            </ol>
        </nav>
    </div>
</header>

@if(Session::has('message'))
    <div class="alert {{ Session::get('alert-class') }} alert-dismissible fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
    </div>
@endif