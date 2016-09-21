<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>Idee - @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    @if(isset($viewUser))
        @if($viewUser->theme == 1)
        <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
        @else
        <link rel = "stylesheet" href = "{{ elixir('css/app2.css') }}">
        @endif
    @else
         @if($user->theme == 1)
        <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
        @else
        <link rel = "stylesheet" href = "{{ elixir('css/app2.css') }}">
        @endif
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/location.js"></script>
    @if(!App::environment('local'))
        <script src="/js/googleAnalytics.js"></script>
    @endif

    @yield('pageHeader')

    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>

<div id = "container">
    <nav class = "topNav">
        <ul>
            <li><a href={{ url('/home') }}>Home</a></li>
            <li>
                <p onclick="" class = "nav">Posts<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/drafts') }}">Drafts</a></li>
                        <li><a href={{ url('/legacyPosts')}}>Legacy</a></li>
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="" class = "nav">Directory<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href="{{ url('/users') }}">Users</a></li>
                        <li><a href="{{ url('/beacons') }}">Beacons</a></li>
                        <li><a href="{{ url('/sponsors') }}">Sponsors</a></li>
                        <li><a href="{{ url('/beliefs') }}">Beliefs</a></li>
                        <li><a href="{{ url('/questions') }}">Questions</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="" class = "nav">Settings<span class="caret"></span></p>
                <div>

                    <ul>
                        <li><a href="{{ url('/settings') }}">Personal</a></li>
                        <li><a href="{{ url('/supports') }}">Support</a></li>
                        <li><a href="{{ url('/invites') }}">Invite Friends</a></li>
                        @if(isset($viewUser))
                            @if($viewUser->type > 0)
                                <li><a href="{{ url('/moderator') }}">Moderator</a></li>
                            @endif
                        @elseif($user->type > 0)
                                    <li><a href="{{ url('/moderator') }}">Moderator</a></li>
                        @endif
                        @if(isset($viewUser))
                            @if($viewUser->type > 1)
                                <li><a href="{{ url('/admin') }}">Admin</a></li>
                            @endif
                        @elseif($user->type > 1)
                        <li><a href="{{ url('/admin') }}">Admin</a></li>
                        @endif
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>

                </div>
            </li>
            @if($notifyCount > 0)
            <li>
                <a href = "{{ url('/notifications') }}">/{{$notifyCount}}\</a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- Left --- --- -->

    <!-- --- Center --- -->
    <div id = "centerContent">
        <article>
        <div id = "centerMenu">
        <header>

            @yield('centerMenu')
        </header>
        </div>
        <div id = "centerText">
            @include('partials.flash')
            @yield('centerText')
        </div>
        </article>
        <div id = "centerFooter">
            @yield('centerFooter')
        </div>
    </div>
    <!-- --- --- Right -->

</div>
</body>
</html>