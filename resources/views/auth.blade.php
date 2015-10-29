<!doctype html>
<html lang="en">
<head>
    <title>Idee /-\ @yield('loginTitle')</title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Requests and feedback are administered at Bella.ninja
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
    <div id = "welcome">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "35%" width = "35%"></a>
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