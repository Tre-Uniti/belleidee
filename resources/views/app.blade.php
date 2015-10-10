<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset=""UTF-8">
    <title>Idee /-\ @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <Link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Requests and feedback are administered at Bella.ninja
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div id = "container">

    <!-- Left --- --- -->
    <div class = "tLM">
        @yield('topLeftMenu')
    </div>
    <div class = "lP">
        @yield('leftProfile')
    </div>
    <div class = "bLM">
        @yield('bottomLeftMenu')
    </div>

    <!-- --- Center --- -->
    <div class = "cM">
        @yield('centerMenu')
    </div>
    <div class = "cV">
        @yield('centerValve')
    </div>
    <div class = "cF">
        @yield('centerFooter')
    </div>

    <!-- --- --- Right -->
    <div class = "tRM">
        @yield('topRightMenu')
    </div>
    <div class = "rP">
        @yield('rightProfile')
    </div>
    <div class = "bRM">
        @yield('bottomRightMenu')
    </div>
</div>
</body>
</html>