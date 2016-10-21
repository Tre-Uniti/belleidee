@extends('app')
@section('siteTitle')
    Show User
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
                    Latest Activity: {{ $user->updated_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Total elevation (hearts) of user content</span>
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
                        <span class="tooltiptext">Total extension of user content</span>
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
                        <a href={{ url('/beacons') }}>No connected Beacon</a>
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
                        <a href={{ url('/sponsors') }}>No Sponsorship</a>
                    @endif
                </div>
            </div>
        </div>
    </article>

    @if(Auth::id() != $user->id)
        <a href="{{ url('/bookmarks/users/'.$user->id) }}"><button type = "button" class = "navButton">Follow</button></a>
    @endif
    @if(Auth::user()->type > 1)
        <a href="{{ url('intolerances/userIndex/'. $user->id) }}"><button type = "button" class = "navButton">Intolerances</button></a>
        <a href="{{ url('users/'. $user->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'class' => 'formDeletion']) !!}
        {!! Form::submit('Delete User', ['class' => 'navButton', 'id' => 'delete']) !!}
        {!! Form::close() !!}
    @endif

    <div class = "contentHeaderSeparator">
        <h3>Recent Posts</h3>
    </div>
    @include('posts._postCards')

    <div class = "contentHeaderSeparator">
        <h3>Recent Extensions</h3>
    </div>
    @include('extensions._extensionCards')

@stop