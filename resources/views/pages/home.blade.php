@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                <h1>{{$user->handle}}</h1>
                </header>
            </div>

        <div class = "indexNav">
            <div class = "cardImg">
            @if($user->photo_path != NULL)
                <a href={{ url('/users/'. $user->id) }}><img src= {{ url(env('IMAGE_LINK'). $user->photo_path) }} alt="{{$user->handle}}" height = "99%" width = "99%"></a>
            @else
                <a href={{ url('/users/'. $user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
            @endif
            </div>

        </div>
            <div class = "indexNav">
                <a href="{{ url('/posts/user/'. $user->id) }}" class = "indexLink">Posts <div>{{ $postCount }}</div></a>
                <a href="{{ url('/users/following/'. $user->id) }}" class = "indexLink">Following <div>{{ $followingCount }}</div></a>
                <a href="{{ url('/users/followers/'. $user->id) }}" class = "indexLink">Followers <div>{{ $followerCount }}</div></a>
            </div>
            <div class = "cardHandleSection">
                <p>
                    @if($location == null)
                        Set your location <a href = "{{ url('/newLocation') }}">here</a>
                    @else
                    Location set to: <a href = "{{ url('/settings') }}">{{ $location }}</a>
                    @endif
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Total elevation (hearts) of your content</span>
                        </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}">{{ $user->elevation }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/users/extendedBy/'. $user->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                        <span class="tooltiptext">Total extension of your content</span>
                        </div>
                    <div class = "rightCounter">
                        <a href="{{ url('/users/extendedBy/'. $user->id) }}">{{ $user->extension }}</a>
                    </div>
                </div>
            </div>
            <div class = "indexNav">
                <div class = "userConnections">
                    <h4 class = "underline">Beacon</h4>
                    @if(isset($beacon))
                        @if($beacon != NULL)
                            <a href={{ url('/beacons/'. $beacon->beacon_tag) }}><h4>{{ $beacon->name }}</h4></a>
                            <a href={{ url('/beacons/'. $beacon->beacon_tag) }}>{{ $beacon->beacon_tag }}</a>
                        @endif
                    @else
                        <h4>No Beacon yet</h4>
                        <a href = " {{ url('/beacons') }}">Discover one here</a>
                    @endif
                </div>
                <div class = "userConnections">
                    <h4 class = "underline">Sponsor</h4>
                        @if(isset($sponsor))
                            @if($sponsor != NULL)
                                <a href={{ url('/sponsors/click/'. $sponsor->id) }}><h4>{{ $sponsor->name }}</h4></a>
                                <a href={{ url('/sponsors/click/'. $sponsor->id) }}>{{ $sponsor->sponsor_tag }}</a>

                            @endif
                        @else
                        <h4>No Sponsor yet</h4>
                        <a href = " {{ url('/sponsors') }}">Discover one here</a>

                        @endif
                </div>
            </div>
        </div>
    </article>
    <p>
        @if($user->startup < 5)
                <a href="{{ url('/gettingStarted') }}" class = "navLink">Startup Guide</a>
        @endif
        <a href="{{ url('/posts/create') }}" class = " navLink">Create a Post</a>
        <a href="{{ url('/posts') }}" class = "navLink">Discover Posts</a>
    </p>

    <div class = "contentHeaderSeparator">
        <h3>Your Recent Posts</h3>
    </div>
    @include('posts._postCards')
    @if(count($posts) == 0))
    <p>Create your first <a href = "{{ url('/posts/create') }}">here</a></p>
    @endif

    <div class = "contentHeaderSeparator">
        <h3>Your Recent Extensions</h3>
    </div>
    @include('extensions._extensionCards')
    @if(count($extensions) == 0)
    <p>Find a post to extend <a href = "{{ url('/posts') }}">here</a></p>
    @endif
@stop

