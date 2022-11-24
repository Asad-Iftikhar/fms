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
                @if ( Auth::user()->can('manage_users') || Auth::user()->can('manage_roles') )
                    <li @class(["sidebar-item has-sub", "active" => \Request::is('admin/users/*') || \Request::is('admin/users') || \Request::is('admin/roles/*') || \Request::is('admin/roles')])>
                        <a href="#" class='sidebar-link'>
                            <i class="iconly-boldProfile"></i>
                            <span>Manage Users</span>
                        </a>
                        <ul @class(["submenu", "active" => \Request::is('admin/users/*') || \Request::is('admin/users') || \Request::is('admin/roles/*') || \Request::is('admin/roles')])>
                            @if ( Auth::user()->can('manage_users') )
                                <li @class(["submenu-item", "active" => \Request::is('admin/users') || \Request::is('admin/users/*')])>
                                    <a href="{!! url('admin/users') !!}">Users</a>
                                </li>
                            @endif
                            @if ( Auth::user()->can('manage_roles') )
                                <li @class(["submenu-item", "active" => \Request::is('admin/roles') || \Request::is('admin/roles/*')])>
                                    <a href="{{ url('admin/roles') }}">Roles</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if ( Auth::user()->can('manage_funding_collections') || Auth::user()->can('manage_funding_types') )
                    <li @class(["sidebar-item has-sub", "active" => \Request::is('admin/funding/types') || \Request::is('admin/funding/types/*')
                            || \Request::is('admin/funding/collections') || \Request::is('admin/funding/collections/*') ])>
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-cash-stack"></i>
                            <span>Manage Funds</span>
                        </a>
                        <ul @class(["submenu", "active" => \Request::is('admin/funding/types') || \Request::is('admin/funding/types/*')
                            || \Request::is('admin/funding/collections') || \Request::is('admin/funding/collections/*')])>
                            @if ( Auth::user()->can('manage_funding_collections') )
                                <li @class(["submenu-item", "active" => \Request::is('admin/funding/collections') || \Request::is('admin/funding/collections/*')])>
                                    <a href="{{ url('admin/funding/collections') }}">Collections</a>
                                </li>
                            @endif
                            @if ( Auth::user()->can('manage_funding_types') )
                                <li @class(["submenu-item", "active" => \Request::is('admin/funding/types') || \Request::is('admin/funding/types/*')])>
                                    <a href="{{ url('admin/funding/types') }}">Types</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if ( Auth::user()->can('manage_events') )
                    <li @class(["sidebar-item", "active" => \Request::is('admin/events') || \Request::is('admin/events/*') ])>
                        <a href="{{ url('admin/events') }}" class='sidebar-link'>
                            <i class="bi bi-calendar-event"></i>
                            <span>Events</span>
                        </a>
                    </li>
                @endif
                <li @class(["sidebar-item", "active" => \Request::is('admin/notifications') || \Request::is('admin/notifications/*') ])>
                    <a href="{{ url('admin/notifications') }}" class='sidebar-link'>
                        <i class="bi bi-alarm"></i>
                        <span>Notifications</span>
                        @if( \App\Models\Notifications\Notification::countAdminUnreadNotifications() > 0 )
                            <span class="badge bg-danger rounded-circle admin-unread-notification-badge">{{ \App\Models\Notifications\Notification::countAdminUnreadNotifications() }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
