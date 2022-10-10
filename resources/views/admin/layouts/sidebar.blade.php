<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ url('admin/') }}"><img src="{{ asset('assets/images/logo/nxblogo.svg') }}" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="{{ url('admin/') }}" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li @class(["sidebar-item", "active" => \Request::is('admin')])>
                    <a href="{{ url('admin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li @class(["sidebar-item has-sub", "active" => \Request::is('admin/users/*') || \Request::is('admin/users') || \Request::is('admin/roles/*') || \Request::is('admin/roles')])>
                    <a href="#" class='sidebar-link'>
                        <i class="iconly-boldProfile"></i>
                        <span>Manage Users</span>
                    </a>
                    <ul @class(["submenu", "active" => \Request::is('admin/users/*') || \Request::is('admin/users') || \Request::is('admin/roles/*') || \Request::is('admin/roles')])>
                        <li @class(["submenu-item", "active" => \Request::is('admin/users') || \Request::is('admin/users/*')])>
                            <a href="{!! url('admin/users') !!}">Users</a>
                        </li>
                        <li @class(["submenu-item", "active" => \Request::is('admin/roles') || \Request::is('admin/roles/*')])>
                            <a href="{{url('admin/roles')}}">User Roles</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cash-stack"></i>
                        <span>Manage Funds</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="{{url('admin/categories')}}">Collections Categories</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{url('admin/collections')}}">Funds Collections</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{url('admin/spendings')}}">Funds Spending</a>
                        </li>
                    </ul>
                </li>
                <li @class(["sidebar-item", "active" => \Request::is('admin/events') || \Request::is('admin/events/*') ])>
                    <a href="{{ url('admin/events') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-event"></i>
                        <span>Events</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
