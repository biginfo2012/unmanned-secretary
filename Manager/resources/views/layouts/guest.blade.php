<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

{{--    <link rel="apple-touch-icon" href="{{ asset('theme/images/ico/apple-icon-120.png') }}">--}}
{{--    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('theme/images/ico/favicon.ico') }}">--}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/themes/bordered-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/themes/semi-dark-layout.min.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- END: Custom CSS-->
    <script src="{{ asset('theme/vendors/js/vendors.min.js') }}"></script>
    <style>
        body, tr, .form-control, .form-select, label, .form-label{
            color: black;
            font-size: 15px;
        }
        tr{
            font-size: 15px;
        }
    </style>
</head>
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content " style="height: calc(100% - 3.35rem); overflow: hidden;">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            {{ $slot }}
        </div>
    </div>
</div>
<!-- END: Content-->
<footer class="footer footer-static footer-light" style="background: white">
    <p class="clearfix mb-0 d-flex"><span class="float-md-start d-block d-md-inline-block mt-25" style="margin: auto">Copyright © 2023 HubSystem.Inc, All rights Reserved</span></p>
</footer>
<!-- BEGIN: Vendor JS-->

<script src="{{ asset('theme/vendors/js/extensions/moment.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('theme/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('theme/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('theme/js/core/app.min.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('theme/js/scripts/pages/auth-login.js') }}"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({width: 14, height: 14});
        }
    })
    $(document).ready(function () {
        var interval = setInterval(function () {
            var momentNow = moment();
            $('#current_time').html(momentNow.format('YYYY年MM月DD日 A hh:mm'));
        }, 100);
    });
</script>
</body>
<!-- END: Body-->

</html>
