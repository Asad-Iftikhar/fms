<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') - FMS</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/assets/css/bootstrap.css") }}">

    <link rel="stylesheet" href="{{ asset("/assets/vendors/iconly/bold.css") }}">

    <link rel="stylesheet" href="{{ asset("/assets/vendors/perfect-scrollbar/perfect-scrollbar.css") }}">
    <link rel="stylesheet" href="{{ asset("/assets/vendors/bootstrap-icons/bootstrap-icons.css") }}">
    <link rel="stylesheet" href="{{ asset("/assets/css/custom_app.css") }}">
    <link rel="shortcut icon" href="{{ asset("/assets/images/favicon.svg") }}" type="image/x-icon">
</head>
<body>
<div id="main-content">
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item active ">
                        <a href="//index.html" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
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

                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-users"></i>
                            <span>Manage Users</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item">
                                <a href="{{url('admin/users')}}">Users</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{url('admin/roles')}}">User Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-lock"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-lock"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-door-closed"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Finds Statistics</h3>
        </div>

        @yield('content')

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2022 &copy; Funds Management System</p>
                </div>
                <div class="float-end">
                    <p>Made for
                        <span class="text-danger">
                            <i class="bi bi-heart"></i>
                        </span> by
                        <a href="http://nxb.com.pk">NextBridge</a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</div>
</div>
<script src="{{ asset("/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js") }}"></script>
<script src="{{ asset("/assets/js/bootstrap.bundle.min.js") }}"></script>

<script src="{{ asset("/assets/vendors/apexcharts/apexcharts.js") }}"></script>
<script src="{{ asset("/assets/js/pages/dashboard.js") }}"></script>

<script src="{{ asset("/assets/js/main.js") }}"></script>
</body>

</html>
