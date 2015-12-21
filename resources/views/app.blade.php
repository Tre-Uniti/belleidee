<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
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
    <nav class = "topNav">
        <ul>
            <li><a href={{ url('/home') }}>Home</a></li>
            <li>
                <a href="{{ url('/posts') }}">Posts<span class="caret"></span></a>
                <div>

                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('posts/yours') }}">Your Posts</a></li>
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                        <li><a href="{{ url('/posts') }}">Bookmarks</a></li>
                    </ul>

                </div>
            </li>
            <li>
                <a href="{{ url('/indev') }}">Directory<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href="{{ url('/posts') }}">Beliefs</a></li>
                        <li><a href="{{ url('/posts') }}">Questions</a></li>
                        <li><a href="{{ url('/beacons') }}">Beacons</a></li>
                        <li><a href="{{ url('/posts') }}">Sponsors</a></li>
                        <li><a href="{{ url('/posts') }}">Legacy Posts</a></li>
                    </ul>

                </div>
            </li>
            <li>
                <a href="{{ url('/settings') }}">Settings<span class="caret"></span></a>
                <div>

                    <ul>
                        <li><a href="{{ url('/settings') }}">Modify</a></li>
                        <li><a href="{{ url('/posts') }}">Support</a></li>
                        <li><a href="{{ url('/invites') }}">Invite Friends</a></li>
                        <li><a href="https://tre-uniti.org">Tre-Uniti</a></li>
                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                    </ul>

                </div>
            </li>
        </ul>
    </nav>
    <!-- Left --- --- -->
    <div id = "leftContainer">
        <div id = "leftSide">
        @yield('leftSideBar')
            <nav class = "profileNav">
                <ul>
                    @if ($profilePosts->isEmpty())
                        <li><a href="{{url('/posts/create')}}">Posts</a></li>
                    @else
                        <li>
                            <a href="{{ url('/posts') }}">Posts</a>
                            <div>
                                <ul>
                                    @foreach($profilePosts as $profilePost)
                                        <li><a href={{ action('PostController@show', [$profilePost->id])}}>{{ $profilePost->created_at->format('M-d-Y')}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($profileExtensions->isEmpty())
                        <li><a href="{{url('/extensions/create')}}">Extensions</a></li>
                    @else
                        <li>
                            <a href="{{ url('/extensions') }}">Extensions</a>
                            <div>
                                <ul>
                                    @foreach($profileExtensions as $profileExtension)
                                        <li><a href={{ action('ExtensionController@show', [$profileExtension->id])}}>{{ $profileExtension->created_at->format('M-d-Y')}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </nav>
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
        <div id = "centerFooter">
            @yield('centerFooter')
        </div>
    </div>
    <!-- --- --- Right -->
    <div id = "rightContainer">
        <div id = "rightSide">
        @yield('rightSideBar')
            <nav class = "profileNav">
                <ul>
                    @if ($profilePosts->isEmpty())
                        <li><a href="{{url('/post/create')}}">Beacons</a></li>
                    @else
                        <li>
                            <a href="{{url('/posts')}}">Beacons</a>
                            <div>
                                <ul>
                                    <li><a href="{{url('/posts')}}">US-SW-ACE</a></li>
                                    <li><a href="{{url('/posts')}}">US-SW-IHOM</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                        @if ($profileExtensions->isEmpty())
                            <li><a href="{{url('/posts')}}">Legacy</a></li>
                        @else
                            <li>
                                <a href="{{ url('/posts') }}">Legacy</a>
                                <div>
                                    <ul>
                                        @foreach($profileExtensions as $profileExtension)
                                            <li><a href={{ action('ExtensionController@show', [$profileExtension->id])}}>{{ $profileExtension->created_at->format('M-d-Y')}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endif

                </ul>
            </nav>
        </div>
    </div>
</div>
</body>
</html>