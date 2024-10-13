<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title>Iniciar Sesion | {{ env('TITULO_APP') }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logo/default2.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('assets/img/logo/default2.png') }}">
    <style>
        .login.login-with-news-feed .login-container,
        .login.login-with-news-feed .register-container,
        .register.register-with-news-feed .login-container,
        .register.register-with-news-feed .register-container {
            background: #e9e3d4;
            box-shadow: inset 0px 0px 15px 2px;
        }

        .login.login-with-news-feed .news-feed .news-caption,
        .register.register-with-news-feed .news-feed .news-caption {
            position: relative;
            background: linear-gradient(to top, rgba(0, 0, 0, 0) 0, #000000b8 100%);
        }

        .login.login-with-news-feed .news-feed .news-caption,
        .register.register-with-news-feed .news-feed .news-caption {
            color: rgb(255 255 255);
        }

        .login.login-with-news-feed .login-header .brand .small,
        .login.login-with-news-feed .login-header .brand small,
        .register.register-with-news-feed .login-header .brand .small,
        .register.register-with-news-feed .login-header .brand small {
            font-size: 14px;
            display: block;
            color: rgb(0 0 0 / 94%);
            font-weight: 400;
        }

        .login.login-with-news-feed .news-feed .news-image,
        .register.register-with-news-feed .news-feed .news-image {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: left;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .25rem rgb(156 196 52 / 44%);
        }

        .widget-img.widget-img-xl {
            width: 280px;
            height: 80px;
            line-height: 80px;
        }

        .btn-orange {
            color: #fff;
            background-color: #e16440;
            border-color: #a1381b;
        }

        .btn-orange:hover {
            color: #fff;
            background-color: #a1381b;
            border-color: #a1381b;
        }

        .mt-4 {
            width: 76%;
        }

        .btn-primary {
            color: #fff;
            background-color: #9cc434;
            border-color: #435c24;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #a77b34;
            border-color: #3f2b02;
        }

        .invalid-feedback {
            color: #ffffff;
            background: #cf1e1e;
            text-align: center;
        }
    </style>
</head>

<body class="pace-done pace-top pace-top">

    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <span class="spinner"></span>
    </div>
    <!-- END #loader -->

    <div id="app" class="app app-sidebar-fixed app-without-header app-without-sidebar">

        <div id="content" class="app-content p-0">
            <!-- BEGIN login -->
            <div class="login login-with-news-feed">
                <!-- BEGIN news-feed -->
                <div class="news-feed">
                    <div class="news-image"
                        style="background-image: url({{ asset('assets/img/login-bg/FootPrint.jpg') }})"></div>
                    <div class="news-caption">
                        <h4 class="caption-title"><b>{{ env('TITULO_APP') }}</b></h4>
                        <p class="fw-bolder fs-25px">
                            Bienvenido!!!!
                        </p>
                    </div>
                </div>
                <!-- END news-feed -->

                <!-- BEGIN login-container -->
                <div class="login-container">
                    <!-- BEGIN login-header -->
                    <div class="login-header mb-30px">
                        <div class="brand">
                            <div class="d-flex align-items-center">
                                <div class="widget-img widget-img-xl rounded"
                                    style="background-image: url('assets/img/logo/logo - hc.png')">
                                </div>
                            </div>
                            <small>{{ env('DESC_APP') }}</small>
                        </div>
                        <div class="icon">
                            <i class="fa fa-sign-in-alt"></i>
                        </div>
                    </div>
                    <!-- END login-header -->

                    <!-- BEGIN login-content -->
                    <div class="login-content">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-floating mb-15px">
                                <input type="text"
                                    class="form-control h-45px fs-13px border border-black @error('email') is-invalid @enderror"
                                    placeholder="Correo Electronico" id="email" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus />
                                <label for="email"
                                    class="d-flex align-items-center text-gray-600 fs-13px">{{ __('Correo Electronico') }}</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        @if ($message == 'ldap::errors.password_expired')
                                            <strong>La contraseña de su equipo a expirado, debe actualizarla.</strong>
                                        @elseif($message == 'ldap::errors.user_not_found')
                                            <strong>Usuario no encontrado.</strong>
                                        @elseif($message == 'ldap::errors.account_disabled')
                                            <strong>Su usuario se encuentra inactivo.</strong>
                                        @elseif($message == "Can't contact LDAP server")
                                            <strong>No se ha podido realizar la conexion al servidor.</strong>
                                        @elseif($message == 'auth.failed')
                                            <strong>Usuario o contraseña incorrectos.</strong>
                                        @elseif($message == 'These credentials do not match our records.')
                                            <strong>Usuario no encontrado o contraseña incorrecta.</strong>
                                        @else
                                            <strong>{{ $message }}</strong>
                                        @endif
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-15px">
                                <input type="password"
                                    class="form-control h-45px fs-13px border border-black @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" required autocomplete="current-password" />
                                <label for="emailAddress"
                                    class="d-flex align-items-center text-gray-600 fs-13px">{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="pt-1 pb-1 text-center">
                                <button type="submit" class="btn btn-primary p-3 pt-1 pb-1 btn-lg fs-20px">
                                    Iniciar Sesion
                                </button>
                            </div>
                            <hr class="mb-4">
                            <div class="text-center">
                                <a href="login-azure" class="btn btn-lg btn-white border border-blue">
                                    <span class="d-flex align-items-center text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30"
                                            class="me-2 p-0" height="30" viewBox="0 0 48 48">
                                            <path fill="#ff5722" d="M6 6H22V22H6z" transform="rotate(-180 14 14)">
                                            </path>
                                            <path fill="#4caf50" d="M26 6H42V22H26z" transform="rotate(-180 34 14)">
                                            </path>
                                            <path fill="#ffc107" d="M26 26H42V42H26z" transform="rotate(-180 34 34)">
                                            </path>
                                            <path fill="#03a9f4" d="M6 26H22V42H6z" transform="rotate(-180 14 34)">
                                            </path>
                                        </svg>
                                        <span>
                                            <span class="d-block fs-14px opacity-7">Iniciar con correo
                                                corporativo</span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- END login-content -->
                </div>
                <!-- END login-container -->
            </div>

            <!-- END login -->
        </div>

    </div>
    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

</body>

</html>
