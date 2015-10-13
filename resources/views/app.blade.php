<!doctype html>
<html lang="en">
<head>
    <meta charset=""UTF-8">
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
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Directory</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Discover Inspiration</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Home</button></a>
    </div>
    <div class = "leftProfile">
        @yield('leftProfile')
    </div>
    <div class = "bottomLeftMenu">
        @yield('bottomLeftMenu')
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Questions</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Create Inspiration</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Bookmarks</button></a>
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
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Search</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Settings</button></a>
        <a href="https://tre-uniti.org"><button type = "button" class = "interactButton">/-\</button></a>
    </div>
    <div class = "rightProfile">
        @yield('rightProfile')
    </div>
    <div class = "bottomRightMenu">
        @yield('bottomRightMenu')
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Artist Name</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Play</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Next</button></a>
        <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Volume</button></a>
    </div>
</div>
</body>
</html>