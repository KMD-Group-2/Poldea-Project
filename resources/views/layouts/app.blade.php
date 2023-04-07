<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">

    <title>{{ config('app.name', 'Poldea') }}</title>

    <!-- page css -->
    <link href="{{ asset('css/pages/inbox.css') }}" rel="stylesheet">

    <link href="{{ asset('css/pages/contact-app-page.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    @if ($select2 ?? false)
        <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endif

    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/page.css') }}">

    <link rel="stylesheet" href="{{ asset('css/pages/ribbon-page.css') }}">

    <!-- Custom CSS for Stepper Form -->
    @if ($steps ?? false)
        <link href="{{ asset('css/pages/steps/steps.css') }}" rel="stylesheet">
    @endif

    @if ($progressbar ?? false)
        <!-- Progress bar css -->
        <link href="{{ asset('css/pages/progressbar-page.css') }}" rel="stylesheet" type="text/css" />
    @endif

    @if ($carousel ?? false)
        <!-- Carousel css -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/css/owl.theme.default.min.css') }}">
    @endif

    @if ($imagePopup ?? false)
        <link href="{{ asset('assets/plugins/magnific-popup/css/magnific-popup.css') }}" rel="stylesheet">
    @endif

    @if ($sweetalert ?? false)
        <link href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    @endif

    @if ($htmleditor ?? false)
        <link href="{{ asset('assets/plugins/html5-editor/bootstrap-wysihtml5.css') }}" rel="stylesheet" />
    @endif

    <link href="{{ asset('assets/plugins/html5-editor/lib/css/wysiwyg-color.css') }}" rel="stylesheet">

    @if ($high_chart ?? false)
        <link rel="stylesheet" href="{{ asset('assets/plugins/highcharts/css/highcharts-style.css') }}">
    @endif

    @if ($datepicker ?? false)
        <!-- Date picker plugins css -->
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css" />
    @endif

    @if ($daterangepicker ?? false)
        <!-- Daterange picker plugins css -->
        <link href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    @endif
</head>

<body class="skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Poldea</p>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.navigation')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @if (auth()->user()->hasRole('Admin'))
            @include('layouts.sidebars.admin')
        @elseif (auth()->user()->hasRole('QA Manager'))
            @include('layouts.sidebars.qa-manager')
        @elseif (auth()->user()->hasRole('QA Coordinator'))
            @include('layouts.sidebars.qa-coordinator')
        @elseif (auth()->user()->hasRole('Staff'))
            @include('layouts.sidebars.staff')
        @else
            Side Bar Error ( Role Undefined )
        @endif
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- User Dashboard Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        {{-- @include('layouts.idea.sidebar') --}}
        <!-- ============================================================== -->
        <!-- End User Dashboard Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- Page Content -->
        <div class="page-wrapper">
            {{ $slot }}
        </div>

        <footer class="footer">
            © 2023 Poldea. All rights reserved.
        </footer>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/jquery/jquery-3.2.1.min.js') }}"></script>
    @if ($steps ?? false)
        <script src="{{ asset('assets/plugins/jquery/jquery.steps.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/plugins/jquery/jquery.validate.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

    @if ($carousel ?? false)
        <script src="{{ asset('assets/plugins/owlcarousel/js/owl.carousel.min.js') }}"></script>
    @endif

    @if ($imagePopup ?? false)
        <script src="{{ asset('assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>
    @endif

    @if ($sweetalert ?? false)
        <script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    @endif

    @if ($htmleditor ?? false)
        <!-- wysuhtml5 Plugin JavaScript -->
        <script src="{{ asset('assets/plugins/html5-editor/wysihtml5-0.3.0.js') }}"></script>
        <script src="{{ asset('assets/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    @endif

    @if ($high_chart ?? false)
        <!--High Charts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    @endif

    @if ($select2 ?? false)
        <script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script>
            $(".select2").select2();
        </script>
    @endif

    @if ($datepicker ?? false)
        <!-- Date Picker Plugin JavaScript -->
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-datepicker/datepicker-init.js') }}"></script>
    @endif

    @if ($daterangepicker ?? false)
        <!-- Date range Plugin JavaScript -->
        <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    @endif

    {{ $script ?? false }}

    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
