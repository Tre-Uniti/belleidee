<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Idee /-\ @yield('loginTitle')</title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
    <div id = "welcome">
        <a href="/"><img src={{secure_asset('img/idee.png')}} alt="idee" height = "35%" width = "35%"></a>
            <hr/>
                <div id = "login">
                    @include('partials.flash')
                    @include('errors.list')
                    @yield('login')
                </div>
            <hr/>
            @yield('footer')
    </div>
</body>
</html>