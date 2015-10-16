<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Idee /-\ @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Requests and feedback are administered at Bella.ninja
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div id = "container">
    <!-- Left --- --- -->
    <div class = "topLeftMenu">
        @yield('topLeftMenu')
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Directory</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Discover Inspiration</button></a>
        <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Home</button></a>
    </div>
    <div class = "leftProfile">
        @yield('leftProfile')
    </div>
    <div class = "bottomLeftMenu">
        @yield('bottomLeftMenu')
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Questions</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Create Inspiration</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
    </div>

    <!-- --- Center --- -->
    <div class = "centerContent">
        @yield('centerContent')
        <div class = "centerMenu">
            @yield('centerMenu')
        </div>
        <div class = "centerText">
            @yield('centerText')
        </div>
    </div>
    <div class = "centerFooter">
        @yield('centerFooter')
    </div>

    <!-- --- --- Right -->
    <div class = "topRightMenu">
        @yield('topRightMenu')
        <input type = "text" name = "search" size = "15">
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Search</button></a>
        <a href="{{ url('/settings') }}"><button type = "button" class = "navButton">Settings</button></a>
        <a href="https://tre-uniti.org"><button type = "button" class = "navButton">/-\</button></a>
    </div>
    <div class = "rightProfile">
        @yield('rightProfile')
    </div>
    <div class = "bottomRightMenu">
        @yield('bottomRightMenu')
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Artist Name</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Play</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Next</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Volume</button></a>
    </div>
</div>
</body>
</html>