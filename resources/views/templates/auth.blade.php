<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Funds Management System</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('adminassets/bootstrap/bootstrap.css') }}">
{{--    <link rel="stylesheet" href="{{url()}}assets/css/bootstrap.css">--}}

    <link rel="stylesheet" href="{{ URL::asset('adminassets/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('adminassets/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('adminassets/css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('adminassets/css/auth.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('adminassets/images/favicon.jpg') }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; Funds Management System</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://nxb.com.pk">NextBridge</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ URL::asset('adminassets/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('adminassets/bootstrap/bootstrap.bundle.min.js') }}"></script>

{{--    <script src="{{ URL::asset('adminassets/js/main.js') }}"></script>--}}
</body>

</html>
