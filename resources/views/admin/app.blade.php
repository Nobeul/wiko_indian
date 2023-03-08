<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.1
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<!-- Breadcrumb-->
<html lang="en">

<head>
    <base href="{{ asset('public/admin/./') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty(companyName()) ? companyName() : config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('public/admin/assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('public/admin/assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('public/admin/assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/admin/assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('public/admin/assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/admin/assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('public/admin/assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('public/admin/assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('public/admin/assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/admin/assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/admin/assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/admin/assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('public/admin/assets/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('public/admin/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="{{ asset('public/admin/css/examples.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
    <link href="{{ asset('public/admin/vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" re l="stylesheet">
    @yield('css')
</head>

<body>
    @include('admin.partials.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        @include('admin.partials.header')

        @yield('content')

        @include('admin.partials.footer')
    </div>
<script>
    const product_6 = "{!! isset($product_6) && !empty($product_6) ? $product_6 : 0 !!}";
    const product_5 = "{!! isset($product_5) && !empty($product_5) ? $product_5 : 0 !!}";
    const product_4 = "{!! isset($product_4) && !empty($product_4) ? $product_4 : 0 !!}";
    const product_3 = "{!! isset($product_3) && !empty($product_3) ? $product_3 : 0 !!}";
    const product_2 = "{!! isset($product_2) && !empty($product_2) ? $product_2 : 0 !!}";
    const product_1 = "{!! isset($product_1) && !empty($product_1) ? $product_1 : 0 !!}";
    const product_0 = "{!! isset($product_0) && !empty($product_0) ? $product_0 : 0 !!}";
    const order_6 = "{!! isset($order_6) && !empty($order_6) ? $order_6 : 0 !!}";
    const order_5 = "{!! isset($order_5) && !empty($order_5) ? $order_5 : 0 !!}";
    const order_4 = "{!! isset($order_4) && !empty($order_4) ? $order_4 : 0 !!}";
    const order_3 = "{!! isset($order_3) && !empty($order_3) ? $order_3 : 0 !!}";
    const order_2 = "{!! isset($order_2) && !empty($order_2) ? $order_2 : 0 !!}";
    const order_1 = "{!! isset($order_1) && !empty($order_1) ? $order_1 : 0 !!}";
    const order_0 = "{!! isset($order_0) && !empty($order_0) ? $order_0 : 0 !!}";
</script>
<!-- CoreUI and necessary plugins-->
<script src="{{ asset('public/admin/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin/vendors/simplebar/js/simplebar.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('public/admin/vendors/chart.js/js/chart.min.js') }}"></script>
<script src="{{ asset('public/admin/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
<script src="{{ asset('public/admin/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
<script src="{{ asset('public/admin/js/main.js') }}"></script>
<script src="{{ asset('public/jquery/dist/jquery.js') }}"></script>
@yield('script')

</body>

</html>