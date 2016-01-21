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
                <p onclick="">Posts<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/drafts') }}">Drafts</a></li>
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                        <li><a href="{{ url('/indev') }}">Legacy</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="">Directory<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href="{{ url('/users') }}">Users</a></li>
                        <li><a href="{{ url('/beacons') }}">Beacons</a></li>
                        <li><a href="{{ url('/beliefs') }}">Beliefs</a></li>
                        <li><a href="{{ url('/questions') }}">Questions</a></li>
                        <li><a href="{{ url('/sponsors') }}">Sponsors</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="">Settings<span class="caret"></span></p>
                <div>

                    <ul>
                        <li><a href="{{ url('/settings') }}">Personal</a></li>
                        <li><a href="{{ url('/indev') }}">Support</a></li>
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
            <div>
                <h2><a href="{{ action('UserController@show', [$user->id])}}">{{$user->handle}}</a></h2>

                <div class = "innerPhotos">
                    @if($photoPath === '')
                        <a href="/"><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "97%" width = "85%"></a>
                    @else
                        <a href={{ url('/users/'. $user->id) }}><img src= {{ url('https://d3ekayvyzr0uoc.cloudfront.net'. $photoPath) }} alt="{{$user->handle}}" height = "97%" width = "85%"></a>
                    @endif
                </div>
            </div>
            <nav class = "profileNav">
                <ul>
                    @if ($profilePosts->isEmpty())
                        <li><a href="{{url('/posts/create')}}">Posts</a></li>
                    @else
                        <li>
                            <a href="{{ url('/posts/user/'. $user->id) }}">Posts</a>
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
                            <a href="{{ url('/extensions/user/' .$user->id) }}">Extensions</a>
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
            <h2>Hosted:</h2>
            <div class = "innerPhotos">
                @if(isset($beaconPath))
                    <a href="/"><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "97%" width = "85%"></a>
                @elseif(isset($sponsor))

                    <a href={{ url('/sponsors/'. $sponsor->id) }}><img src= {{ url('https://d3ekayvyzr0uoc.cloudfront.net'. $sponsor->photo_path) }} alt="{{$sponsor->name}}" height = "97%" width = "85%"></a>
                @else
                    <a href={{ url('/users/'. $user->id) }}><img src= {{ asset('img/tre-uniti.png') }} alt="{{$user->handle}}" height = "97%" width = "85%"></a>
                @endif
            </div>
            <nav class = "profileNav">
                <ul>
                    @if ($profilePosts->isEmpty())
                        <li><a href="{{url('/beacons')}}">Beacons</a></li>
                    @else
                        <li>
                            <a href="{{url('/beacons')}}">Beacons</a>
                            <div>
                                <ul>
                                    <li><a href="{{url('/beacons/tags/US-SW-ACE')}}">US-SW-ACE</a></li>
                                    <li><a href="{{url('/beacons/tags/US-SW-IHOM')}}">US-SW-IHOM</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                        @if ($profileExtensions->isEmpty())
                            <li><a href="{{url('/indev')}}">Legacy</a></li>
                        @else
                            <li>
                                <a href="{{ url('/indev') }}">Legacy</a>
                                <div>
                                    <ul>
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