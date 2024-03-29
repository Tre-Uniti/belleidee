<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="canonical" href="https://belle-idee.org/">
    <meta name="title" content="Belle-idee">
    <meta name="description" content="Belle-idee - We are an online community sharing spiritual ideas, values and experiences.">
    <title>@yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <script src="https://use.fontawesome.com/9747c67e36.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
    <script src = "/js/required.js"></script>
    @yield('pageHeader')

    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
    @if(!App::environment('local'))
        <script src="/js/googleAnalytics.js"></script>
    @endif
</head>
<body>
<div id = "container">
    @if(isset($user))
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
                                @if($viewUser->type > 1)
                                    <li><a href="{{ url('/admin') }}">Admin</a></li>
                                @endif
                            @elseif($user->type > 1)
                                <li><a href="{{ url('/admin') }}">Admin</a></li>
                            @endif
                            <li> <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                    {!! Form::submit('Logout', ['class' => 'indexButton', 'id' => 'logout']) !!}
                                    {{ csrf_field() }}
                                </form></li>
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
        @else
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
            </ul>
        </nav>
    @endif
    <div id = "welcome">
        <a href= "{{ url('/') }}"><h1 class = "welcome">Belle-idee</h1></a>
        <h2 class = "welcome">"Beautiful ideas"</h2>
                    @include('partials.flash')
                    @include('errors.list')
                    @yield('centerContent')
    </div>
</div>
</body>
</html>