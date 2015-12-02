<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
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
    <nav>
        <ul>
            <li><a href={{ url('/home') }}>Home</a></li>
            <li>
                <a href="{{ url('/posts') }}">Posts<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/indev') }}">Your Posts</a></li>
                        <li><a href="{{ url('/indev') }}">Extensions</a></li>
                        <li><a href="{{ url('/indev') }}">Bookmarks</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('/indev') }}">Directory<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href="{{ url('/indev') }}">Beliefs</a></li>
                        <li><a href="{{ url('/indev') }}">Questions</a></li>
                        <li><a href="{{ url('/indev') }}">Beacons</a></li>
                        <li><a href="{{ url('/indev') }}">Sponsors</a></li>
                        <li><a href="{{ url('/indev') }}">Legacy Posts</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('/settings') }}">Settings<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href="{{ url('/settings') }}">View/Change</a></li>
                        <li><a href="{{ url('/indev') }}">Support</a></li>
                        <li><a href="{{ url('/indev') }}">Your Sponsor</a></li>
                        <li><a href="{{ url('/invites') }}">Invite Friends</a></li>
                        <li><a href="https://tre-uniti.org">Tre-Uniti</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Left --- --- -->
    <div id = "leftContainer">
        <div id = "leftSide">

        @yield('leftSideBar')
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
        </article>
        @yield('centerFooter')
    </div>
    <!-- --- --- Right -->
    <div id = "rightContainer">
        <div id = "rightSide">

        @yield('rightSideBar')

        </div>
    </div>


</div>
</body>
</html>