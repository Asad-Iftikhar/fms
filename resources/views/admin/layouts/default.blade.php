<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') FMS</title>
    @section('styles')
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset("/assets/css/bootstrap.css") }}">
        <link rel="stylesheet" href="{{ asset("/assets/vendors/iconly/bold.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/vendors/simple-datatables/style.css") }}">
        <link rel="stylesheet" href="{{ asset("/assets/vendors/perfect-scrollbar/perfect-scrollbar.css") }}">
        <link rel="stylesheet" href="{{ asset("/assets/vendors/bootstrap-icons/bootstrap-icons.css") }}">
        <link rel="stylesheet" href="{{ asset("/assets/css/admin.css") }}">
    @show
</head>
<body>
    <div id="app">
        @include('admin.layouts.sidebar')
        <div id="main" class='layout-navbar'>
            <header>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                        <span class="badge bg-danger rounded-circle position-relative admin-unread-notification-badge" style="bottom: 12px; right: 12px">{{ \App\Models\Notifications\Notification::countAdminUnreadNotifications() }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        @if( \App\Models\Notifications\Notification::countAdminUnreadNotifications() > 0 )
                                            <li>
                                                <h6 class="dropdown-header">Notifications</h6>
                                            </li>
                                            @foreach( \App\Models\Notifications\Notification::getAdminLatestUnreadNotifications() as $notification )
                                                <li class="{{ empty($notification->read_at)?'bg-light':'' }}">
                                                    <a data-id="{{ $notification->id }}" data-href="{!! url($notification->redirect_url)  !!}" class="dropdown-item notification-link">
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
                                            <a href="{{ url('admin/notifications') }}" class="dropdown-item">
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
                                        <a class="dropdown-item" href="{{url('/')}}">
                                            <i class="icon-mid bi bi-person me-2"></i>
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{url('account/setting/profile')}}">
                                            <i class="icon-mid bi bi-gear me-2"></i>
                                            Settings
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{url('account/logout')}}">
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


                <div class="page-heading">
                    <section class="section">
                        {{--  Notifications  --}}
                        @include('site.layouts.notifications')
                        {{--  Notifications --}}

                        {{-- Load Content --}}
                        @yield('content')
                    </section>
                </div>

                <footer>
                    <div class="footer clearfix px-4 text-muted">
                        <div class="float-start">
                            <p>2022 &copy; Funds Management System</p>
                        </div>
                        <div class="float-end">
                            <p>Made for
                                <span class="text-danger">
                            <i class="bi bi-heart"></i>
                        </span> by
                                <a href="{{ url('admin') }}">NextBridge</a>
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

@section('javascript')
    <script src="{{ asset("/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset("/assets/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("/assets/js/main.js") }}"></script>
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
                    $('.admin-unread-notification-badge').html(res.unread_count);
                }
            });
        }
    </script>
@show
</body>

</html>
