<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('auth.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('auth.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    {{-- profile --}}
                                    <a class="dropdown-item" href="{{ route('auth.changePassword') }}">
                                        {{ __('Profile') }}
                                    </a>

                                    {{-- Logout --}}
                                    <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                        {{ __('Logout') }}
                                    </a>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Login') }}</div>

                        <div class="card-body">
                            {{-- <form method="POST" action="{{ route('auth.login') }}"> --}}
                            <form id="loginForm" name="Login">
                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control" name="email"
                                            value="{{ old('username') ?: old('email') }}" autocomplete="off"
                                            autofocus>
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="error-email"></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password"
                                            autocomplete="off">
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="error-password"></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        <a class="btn btn-link" href="/forget-password">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            data: $('#loginForm').serialize(),
            url: "{{ route('auth.authenticate') }}",
            type: "POST",
            dataType: 'JSON',
            beforeSend: function(req) {
                req.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // alert(data);
            },
            success: function(data) {
                console.log(data.access_token);
                // sessionStorage.setItem('token', data.access_token);
                sessionStorage.setItem('token', data.access_token);


                // window.location.pathname = 'api/ceo';
                // if (data.success) {
                //     console.log(data.access_token)
                //     sessionStorage.setItem('token',data.access_token);
                //     window.location.pathname = '/dashboard';
                //     html = '<div class="alert alert-success">' + data.success +
                //         '</div>';
                //     $('.form-control').removeClass('is-invalid');
                //     $('#loginForm')[0].reset();
                //     $('#c_ajaxModal').modal('hide');
                //     table.ajax.reload();
                // }

            },
            error: function(data) {
                var XHR = $.parseJSON(data.responseText);
                if (XHR.errors) {
                    $.each(XHR.errors, function(key, value) {
                        if (key == $('#' + key).attr('id')) {
                            $('#' + key).addClass('is-invalid')
                            $('#error-' + key).text(value)
                        }
                    })
                }
            }
        });
    });

</script>

</html>
