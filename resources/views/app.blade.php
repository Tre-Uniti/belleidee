<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Idee /-\ @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/app.js"></script>
    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div id = "container">

    <!-- Left --- --- -->
    <div id = "leftContainer">
        <div id = "topLeftMenu">
        @yield('topLeftMenu')
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Directory</button></a>
        <a href="{{ url('/posts') }}"><button type = "button" class = "navButton">Discover Posts</button></a>
        <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Home</button></a>
        </div>
        @yield('leftSideBar')
        <div id = "bottomLeftMenu">
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Questions</button></a>
            <a href="{{ url('/posts/create') }}"><button type = "button" class = "navButton">Create Posts</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
        </div>
    </div>
    <!-- --- Center --- -->
    <div id = "centerContent">
        <article>
        <div id = "centerMenu">
        <header>
            @include('partials.flash')
            @yield('centerMenu')
        </header>
        </div>
        <div id = "centerText">
            @yield('centerText')
        </div>
        <footer>
            <div id = "centerFooter">
                @yield('centerFooter')
            </div>
        </footer>
        </article>
    </div>
    <!-- --- --- Right -->
    <div id = "rightContainer">
        <div id = "topRightMenu">
            @yield('topRightMenu')
            <input type = "text" name = "search" size = "15">
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Search</button></a>
            <a href="{{ url('/settings') }}"><button type = "button" class = "navButton">Settings</button></a>
            <a href="https://tre-uniti.org"><button type = "button" class = "navButton">/-\</button></a>
        </div>
        @yield('rightSideBar')
        <div id = "bottomRightMenu">
            @yield('bottomRightMenu')
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Artist Name</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Play</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Next</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Volume</button></a>
        </div>
    </div>
</div>
</body>
</html>