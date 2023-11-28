<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Login | Madani Madrasha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- sweetalert2 Css-->
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
</head>

<body class="bg-pattern">
    <div class="bg-overlay"></div>

    @if (session()->has('success'))
        <script>
            Toastify({
                text: '<?php echo session()->get('success'); ?>',
                className: 'info',
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'bottom',
                position: 'center',
                stopOnFocus: true,
                style: {
                    background: 'linear-gradient(to right, #00b09b, #96c93d)',
                },
                onClick: function() {}
            }).showToast();
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Toastify({
                text: '<?php echo session()->get('error'); ?>',
                className: 'info',
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'bottom',
                position: 'center',
                stopOnFocus: true,
                style: {
                    background: 'linear-gradient(to right, var(--bs-pink), var(--bs-danger))',
                },
                onClick: function() {}
            }).showToast();
        </script>
    @endif

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <!-- Begin page -->
    <div class="account-pages my-5 pt-5">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- END layout-wrapper -->



    <!-- JAVASCRIPT -->
    <!-- <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script> -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts js -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('assets/libs/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

    <!-- <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/app.js') }}"></script> -->
</body>

</html>
