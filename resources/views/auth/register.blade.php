<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.1
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
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
  </head>
  <body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-4 mx-4">
              <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="is_admin" value="1">
                    <h1>Register</h1>
                    <p class="text-medium-emphasis">Create your account</p>
                    <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>

                        </svg></span>
                        <input class="form-control" type="text" name="name" placeholder="Username" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    @if ($errors->first('name'))
                        <p class="text-danger small">{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                    <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                        </svg></span>
                        <input class="form-control" type="text" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    @if ($errors->first('email'))
                        <p class="text-danger small">{{ $errors->first('email') }}</strong>
                        </p>
                    @endif
                    <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                        </svg></span>
                        <input class="form-control" type="password" name="password" placeholder="Password" required autocomplete="new-password">
                    </div>
                    @if ($errors->first('password'))
                        <p class="text-danger small">{{ $errors->first('password') }}</strong>
                        </p>
                    @endif
                    <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                        <use xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                        </svg></span>
                        <input class="form-control" type="password" placeholder="Repeat password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Create Account</button>
                    <p class="small mt-2">Already have an account? <a href="{{ url('login') }}">Login now</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('public/admin/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script>
    </script>

  </body>
</html>