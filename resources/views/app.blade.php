<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="description" content="Belle-idee - An online community sharing spiritual ideas, values and experiences.">
    <title>@yield('siteTitle')</title>
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
    <script src="https://use.fontawesome.com/9747c67e36.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/required.js"></script>
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
            <li class = "navDesktopIcon"><a href={{ url('/home') }}><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class = "navMobileIcon">
                <a href = "{{ url('/home') }}"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a></li>
            <li>
            <li class = "navDesktopIcon">
                <p onclick="" class = "nav"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Posts<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/drafts') }}">Drafts</a></li>
                        <li><a href={{ url('/legacyPosts')}}>Legacies</a></li>
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                    </ul>
                </div>
            </li>
            <li class = "navMobileIcon">
                <p onclick="" class = "nav"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/drafts') }}">Drafts</a></li>
                        <li><a href={{ url('/legacyPosts')}}>Legacies</a></li>
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                    </ul>
                </div>
            </li>
            <li class = "navDesktopIcon">
                <p onclick="" class = "nav"> <i class="fa fa-users" aria-hidden="true"></i> Directory<span class="caret"></span></p>
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
            <li class = "navMobileIcon">
                <p onclick="" class = "nav"> <i class="fa fa-users" aria-hidden="true"></i> <span class="caret"></span></p>
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
            <li class = "searchIconBackground">
                {!! Form::open(['url' => '/results', 'method' => 'GET']) !!}
                {!! Form::text('identifier', null, ['placeholder' => 'Search Belle-idee', 'class' => 'searchField']) !!}
                {{Form::button('<i class="fa fa-search" aria-hidden="true"></i>', array('type' => 'submit', 'class' => 'searchButton'))}}
                {!! Form:: close() !!}
            </li>
            <li class = "searchMobileIconBackground">
                <a href = "{{ url('/search') }}"><i class="fa fa-search" aria-hidden="true"></i></a></li>
            <li>
                <p onclick="" class = "nav" id = "pIcon"> <i class="fa fa-cog" aria-hidden="true"></i></p>
                <div>
                    <ul class = "navSettings">
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
                            @if($viewUser->type > 2)
                                <li><a href="{{ url('/admin') }}">Admin</a></li>
                            @endif
                        @elseif($user->type > 2)
                            <li><a href="{{ url('/admin') }}">Admin</a></li>
                        @endif
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>

                </div>
            </li>

            @if($notifyCount > 0)
            <li class = "iconBackground">
                <a href = "{{ url('/notifications') }}" class = "iconOnly"><i class="fa fa-bell" aria-hidden="true"></i> @if($notifyCount > 9) 9+ @else {{$notifyCount}} @endif</a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- Left --- --- -->

    <!-- --- Center --- -->
    <div id = "centerContent">
        <div id = "centerMenu">
            @yield('centerMenu')
        </div>
        <div id = "centerText">
            @include('partials.flash')
            @yield('centerText')

        </div>
        <div id = "centerFooter">

            @yield('centerFooter')
            <div>
                <a href= "#" class= "back-to-top" >
                    Back to Top
                    <i class= "fa fa-arrow-circle-up 2x"></i>
                </a>
            </div>

        </div>
    </div>
    <!-- --- --- Right -->

</div>
</body>
</html>