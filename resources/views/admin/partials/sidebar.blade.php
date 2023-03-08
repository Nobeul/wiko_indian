<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        @if (companyImage())
            <img src="{{ asset('public/admin/assets/img/company_settings/'.companyImage()) }}" class="sidebar-brand-full" width="118" height="46" alt="Company Image">
        @else
            <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('public/admin/assets/brand/coreui.svg#full') }}"></use>
            </svg>
        @endif
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('home') ? 'active' : '' }}" href="{{ url('home') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}">
                    </use>
                </svg> Dashboard
            </a>
        </li>
        <li class="nav-group {{ isset($module) && $module == 'Users' ? 'show' : '' }}"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-user') }}">
                </use>
            </svg> Users</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link {{ isset($sub_module) && ($sub_module == 'Buyers' || $sub_module == 'Create New Buyers' || $sub_module == 'Edit Buyers') ? 'active' : '' }}" href="{{ url('buyers') }}">Buyers</a></li>
            <li class="nav-item"><a class="nav-link {{ isset($sub_module) && ($sub_module == 'Sellers' || $sub_module == 'Create New Sellers' || $sub_module == 'Edit Sellers') ? 'active' : '' }}" href="{{ url('sellers') }}">Sellers</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Products' ? 'active' : '' }}" href="{{ url('products') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-gift') }}">
                    </use>
                </svg> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Products Selling Today' ? 'active' : '' }}" href="{{ url('products-selling-today') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-gift') }}">
                    </use>
                </svg> Products Selling Today
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Expired Products' ? 'active' : '' }}" href="{{ url('expired-products') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-gift') }}">
                    </use>
                </svg> Expired Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Orders' ? 'active' : '' }}" href="{{ url('orders') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-cart') }}">
                    </use>
                </svg> Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Verifications' ? 'active' : '' }}" href="{{ url('verifications') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-bank') }}">
                    </use>
                </svg> Verifications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ isset($module) && $module == 'Activity Logs' ? 'active' : '' }}" href="{{ url('activity-logs') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-airplay') }}">
                    </use>
                </svg> Activity Logs
            </a>
        </li>
        <li class="nav-title">Settings</li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('company-settings') ? 'active' : '' }}" href="{{ url('company-settings') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-settings') }}">
                    </use>
                </svg> Company Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('units') ? 'active' : '' }}" href="{{ url('units') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-vector') }}">
                    </use>
                </svg> Units
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('sizes') ? 'active' : '' }}" href="{{ url('sizes') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-line-weight') }}">
                    </use>
                </svg> Sizes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('countries') ? 'active' : '' }}" href="{{ url('countries') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-bank') }}">
                    </use>
                </svg> Country
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('packaging-sizes') ? 'active' : '' }}" href="{{ url('packaging-sizes') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-line-spacing') }}">
                    </use>
                </svg> Packaging Sizes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('packaging-materials') ? 'active' : '' }}" href="{{ url('packaging-materials') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-flip-to-back') }}">
                    </use>
                </svg> Packaging Material
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('locations') ? 'active' : '' }}" href="{{ url('locations') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-gradient') }}">
                    </use>
                </svg> Locations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() == url('varieties') ? 'active' : '' }}" href="{{ url('varieties') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-color-fill') }}">
                    </use>
                </svg> Variety
            </a>
        </li>
    </ul>
</div>