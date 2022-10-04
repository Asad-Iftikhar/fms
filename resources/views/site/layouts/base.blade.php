<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset("/assets/css/bootstrap.css") !!}">
    <link rel="stylesheet" href="{!! asset("/assets/vendors/bootstrap-icons/bootstrap-icons.css") !!}">
    <link rel="stylesheet" href="{!! asset("/assets/css/app.css") !!}">
    {{--    <link rel="stylesheet" href="{{ asset("/assets/css/pages/auth.css") }}">--}}
    <link rel="stylesheet" href="{!! asset("assets/css/site.css") !!}">

</head>
<body>
    <div id="app">
        <div id="main" class='layout-navbar'>
            <header style="border-bottom: 1px solid #00000021">
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#"><img src="{{ asset('assets/images/logo/nxblogo.svg') }}" alt="Logo" srcset=""></a>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Notifications</h6>
                                        </li>
                                        <li><a class="dropdown-item">No notification available</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h6>
                                            @if(Auth::user()->can('admin'))
                                                <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                            @endif
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('assets/images/faces/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('account/setting/profile') }}">
                                            <i class="icon-mid bi bi-person me-2"></i>
                                            My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('account/setting/change-password') }}">
                                            <i class="icon-mid bi bi-lock me-2"></i>
                                            Change Password
                                        </a>
                                    </li>
                                    @if(Auth::user()->can('admin'))
                                    <li>
                                        <a class="dropdown-item" href="{{ url('admin') }}">
                                            <i class="icon-mid bi bi-wallet me-2"></i>
                                            Administration
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('account/logout') }}">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="main-content">
                @yield('content')

            </div>
            <footer style="padding: 2rem">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; FMS</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="{{ url('') }}">NextBridge</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="{!! asset("assets/js/bootstrap.bundle.min.js") !!}"></script>
</body>
</html>
