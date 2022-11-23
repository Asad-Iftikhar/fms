<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @section('styles')
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
              rel="stylesheet">
        <link rel="stylesheet" href="{!! asset("/assets/css/bootstrap.css") !!}">
        <link rel="stylesheet" href="{!! asset("/assets/vendors/iconly/bold.css") !!}">
        <link rel="stylesheet" href="{!! asset("/assets/vendors/bootstrap-icons/bootstrap-icons.css") !!}">
        <link rel="stylesheet" href="{!! asset("/assets/css/app.css") !!}">
        {{--    <link rel="stylesheet" href="{{ asset("/assets/css/pages/auth.css") }}">--}}
        <link rel="stylesheet" href="{!! asset("assets/css/site.css") !!}">
    @show
</head>
<body>
<div id="app">
    <div id="main" class='layout-navbar'>
        <header style="border-bottom: 1px solid #00000021">
            <nav class="navbar navbar-expand navbar-light ">
                <div class="container-fluid">
                    <a href="{!! url('/') !!}"><img src="{{ asset('assets/images/logo/nxblogo.svg') }}" alt="Logo"
                                                    srcset=""></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav nav-tabs ms-lg-4">
                            <li @class(["nav-item", "active" => \Request::is('collections')])>
                                <a @class(["nav-link", "active" => \Request::is('collections')])
                                href="{{ url('collections') }}">Collection</a>
                            </li>
                            <li @class(["nav-item", "active" => \Request::is('events')])>
                                <a @class(["nav-link", "active" => \Request::is('events')])
                                href="{{ url('events') }}">Event</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                    @if( Auth::user()->getUserLatestNotifications()->count() > 0 )
                                        <span class="badge bg-danger rounded-circle position-relative unread-notification-badge" style="bottom: 12px; right: 12px">{{ Auth::user()->countUserUnreadNotifications() }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    @if( Auth::user()->getUserLatestNotifications()->count() > 0 )
                                        <li>
                                            <h6 class="dropdown-header">Notifications</h6>
                                        </li>
                                        @foreach( Auth::user()->getUserLatestNotifications() as $notification )
                                            <li class="{{ empty($notification->read_at)?'bg-light':'' }}">
                                                <a data-id="{{ $notification->id }}" data-href="{{ url($notification->redirect_url) }}" class="dropdown-item notification-link">
                                                    <b>{{ $notification->title }}</b>
                                                    <br>
                                                    {{ substr($notification->description,0,40).'...' }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <h6 class="dropdown-header">No Notifications Found</h6>
                                        </li>
                                    @endif
                                    <hr>
                                    <li class="text-center">
                                        <a href="{{ url('notifications') }}" class="dropdown-item">
                                            <h6>See All Notifications</h6>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mt-3 text-gray-600">{{ Auth::user()->getFullName() }}</h6>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="{{ Auth::user()->getUserAvatar() }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        <i class="icon-mid bi bi-person me-2"></i>
                                        Home
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
                                    <a class="dropdown-item" href="{{ url('account/setting/profile') }}">
                                        <i class="icon-mid bi bi-gear me-2"></i>
                                        Settings
                                    </a>
                                </li>
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
        <div id="main-content">
            {{--  Notifications  --}}
            @include('site.layouts.notifications')
            {{--  Notifications --}}
            <div class="row">
                <div class="col-12">
                    <!-- Content -->
                @yield('content')
                <!-- ./ content -->
                </div>
            </div>
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

@section('javascript')
    <script src="{!! asset("assets/js/bootstrap.bundle.min.js") !!}"></script>
    <script src="{!! asset("assets/js/jquery-3.6.1.min.js") !!}"></script>

    <script>
        // Ajax request to mark notification as Read
        $('.notification-link').on('click', function (){
            markNotificationRead(this);
        });
        function markNotificationRead(element) {
            let redirectUrl = $(element).data("href");
            let notificationId = $(element).data("id");
            $.ajax({
                type:'POST',
                url: "{{ url('mark-notification-read') }}",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "notification_id": notificationId
                },
                success:function(res) {
                    if ( redirectUrl != '#' ) {
                        window.location = redirectUrl;
                    }
                    $('.unread-notification-badge').html(res.unread_count);
                }
            });
        }
    </script>

@show
</body>
</html>
