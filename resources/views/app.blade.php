<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Idee /-\ @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/location.js"></script>

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
                        <li><a href="{{ url('/extensions') }}">Extensions</a></li>
                        <li><a href="{{ url('/questions') }}">Questions</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="" class = "nav">Directory<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href="{{ url('/users') }}">Users</a></li>
                        <li><a href="{{ url('/beacons') }}">Beacons</a></li>
                        <li><a href="{{ url('/beliefs') }}">Beliefs</a></li>
                        <li><a href="{{ url('/sponsors') }}">Sponsors</a></li>
                        <li><a href={{ url('/legacy')}}>Legacy</a></li>
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
    <div id = "leftContainer">
        <div id = "leftSide">
            <div>
                <h2><a href="{{ action('UserController@show', [$user->id])}}">{{$user->handle}}</a></h2>
                <div class = "innerPhotos">
                    @if(isset($sourcePhotoPath))
                        @if($sourcePhotoPath != NULL)
                            <a href={{ url('/users/'. $user->id) }}><img src= {{ url(env('IMAGE_LINK'). $sourcePhotoPath) }} alt="{{$user->handle}}" height = "95%" width = "95%"></a>
                        @else
                            <a href={{ url('/users/'. $user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "95%" width = "95%"></a>
                        @endif
                    @elseif($photoPath != NULL)
                        <a href={{ url('/users/'. $user->id) }}><img src= {{ url(env('IMAGE_LINK'). $photoPath) }} alt="{{$user->handle}}" height = "95%" width = "95%"></a>
                    @else
                        <a href={{ url('/users/'. $user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "95%" width = "95%"></a>
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
                        <li><a href="{{ url('/extensions/user/' .$user->id) }}">Extensions</a></li>
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
                @if(isset($beacon))
                    @if($beacon != NULL)
                    <a href={{ url('/beacons/'. $beacon->id) }}><img src= {{ url(env('IMAGE_LINK'). $beacon->photo_path) }} alt="{{$beacon->name}}" height = "95%" width = "95%"></a>
                    @endif
                @elseif(isset($sponsor))
                    @if($sponsor != NULL)
                    <a href={{ url('/sponsors/click/'. $sponsor->id) }}><img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" height = "95%" width = "95%"></a>
                    @endif
                @elseif(isset($userSponsor))
                    @if($userSponsor != NULL)
                        <a href={{ url('/sponsors/click/'. $userSponsor->id) }}><img src= {{ url(env('IMAGE_LINK'). $userSponsor->photo_path) }} alt="{{$userSponsor->name}}" height = "95%" width = "95%"></a>
                    @endif
                @else
                    <a href={{ url('/sponsors/1') }}><img src= {{ asset('img/tre-uniti.png') }} alt="Tre-Uniti" height = "95%" width = "95%"></a>
                @endif
            </div>
            <nav class = "profileNav">
                <ul>
                        <li>
                            <a href="{{url('/beacons')}}">Beacons</a>
                            <div>
                                <ul>
                                    @if(isset($userBeacons))
                                        @foreach($userBeacons as $userBeacon)
                                            <li><a href={{ action('BeaconController@posts', [$userBeacon->pointer])}}>{{ $userBeacon->pointer }}</a></li>
                                        @endforeach
                                    @else
                                        @foreach($profileBeacons as $profileBeacon)
                                            <li><a href={{ action('BeaconController@posts', [$profileBeacon->pointer])}}>{{ $profileBeacon->pointer }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @if ($profileExtensions->isEmpty())
                            <li><a href="{{url('/legacy')}}">Legacy</a></li>
                        @else
                            <li>
                                <a href="{{ url('/legacy') }}">Legacy</a>
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