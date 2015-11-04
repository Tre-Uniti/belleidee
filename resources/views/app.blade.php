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
        <a href="{{ url('/posts') }}"><button type = "button" class = "navButton">Discover Inspiration</button></a>
        <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Home</button></a>
    </div>
    <div id = "leftProfile">
        <h1>@yield('handle')</h1>

        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>


        <p>This is someone's motto, it is customized by the user</p>
        <p>It can be your motto, or another motto you like</p>
        <hr/>
        <h2>Top 3</h2>

        <ul style = "text-align: left;">
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Create and Post your first inspiration</button></a></li>
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Post a second</button></a></li>
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Post a third</button></a></li>
        </ul>
        <hr/>
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>

    </div>
    <div id = "bottomLeftMenu">
        @yield('bottomLeftMenu')
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Questions</button></a>
        <a href="{{ url('/posts/create') }}"><button type = "button" class = "navButton">Create Inspiration</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
    </div>
    </div>
    <!-- --- Center --- -->
    <div id = "centerContent">
        <article>
            @yield('centerContent')
        <div id = "centerMenu">
        <header>
            @include('partials.flash')
            @yield('centerMenu')
        </header>
        </div>
        <div id = "centerText">
            @yield('centerText')
        </div>
        <hr/>
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

    <div id = "rightProfile">
        <h2>Inspired By:</h2>
        <ul style = "text-align: left;">
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend someone elses' post</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend 2 Posts</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend 3 Posts</button></a></li>
        </ul>
        <hr/>
        <h2>Inspires:</h2>
        <ul style = "text-align: left;">
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Need 1 person to extend your post</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">2nd person</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">3rd person</button></a></li>
        </ul>
        <hr/>
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
    </div>
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