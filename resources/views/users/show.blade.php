@extends('app')
@section('siteTitle')
    Show User
@stop

@section('centerText')
    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h2>{{$user->handle}}</h2>
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
            <div class = "indexLink">
                <a href="{{ url('/posts/user/'. $user->id) }}">Posts: {{ $postCount }}</a>
            </div>
            <div class = "indexLink">
                <a href="{{ url('/extensions/user/'. $user->id) }}">Extensions: {{ $extensionCount }}</a>
            </div>
            <div class = "indexLink">
                <a href="{{ url('/extensions/user/'. $user->id) }}">Followers: {{ $extensionCount }}</a>
            </div>
        </div>
        <div class = "cardHandleSection">
            <p>
                Latest Activity: {{ $user->updated_at->format('M-d-Y') }}
            </p>
        </div>
        <div class = "influenceSection">
            <div class = "elevationSection">
                <div class = "elevationIcon">
                    <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><img src = "/img/elevate.png"> {{ $user->elevation }}</a>
                    <span class="tooltiptext">Total elevation of your content</span>
                </div>
            </div>

            <div class = "extensionSection">
                <a href="{{ url('/users/extendedBy/'. $user->id) }}"><img src = "/img/extend.png"> {{ $user->extension }}</a>
                <span class="tooltiptext">Total extension of your content</span>
            </div>

        </div>
        <div class = "indexNav">
            <div class = "cardImg">
                <h4 class = "underline">Beacon</h4>
                @if(isset($beacon))
                    @if($beacon != NULL)
                        <a href={{ url('/beacons/'. $beacon->beacon_tag) }}><h4>{{ $beacon->name }}</h4></a>
                        <a href={{ url('/beacons/'. $beacon->beacon_tag) }}>{{ $beacon->beacon_tag }}</a>
                    @endif
                @else
                    <a href={{ url('/beacons') }}>No current beacon, discover one here</a>
                @endif
            </div>

            <div class = "cardImg">
                <h4 class = "underline">Sponsor</h4>
                @if(isset($sponsor))
                    @if($sponsor != NULL)
                        <a href={{ url('/sponsors/click/'. $sponsor->id) }}><h4>{{ $sponsor->name }}</h4></a>
                        <a href={{ url('/sponsors/click/'. $sponsor->id) }}>{{ $sponsor->sponsor_tag }}</a>

                    @endif
                @else
                    <a href={{ url('/sponsors/US-SW-TreUniti') }}><h4>Tre-Uniti</h4></a>
                    <a href={{ url('/sponsors/US-SW-TreUniti') }}>US-SW-TreUniti</a>

                @endif
            </div>

        </div>

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
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Recent Posts</h3>
    </div>

    @foreach ($posts as $post)
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <h3>
                    <a href="{{ action('PostController@show', [$post->id])}}">{{ $post->title }}</a>
                </h3>
            </div>
            <div class = "cardCaptionExcerptSection">

                @if(isset($post->excerpt))
                    <p class = "cardExcerpt">
                        {{ $post->excerpt }}<a href="{{ action('PostController@show', [$post->id])}}">... Read More</a>
                    </p>
                @elseif(isset($post->caption))
                    <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->caption }}</button></a>
                    <div class = "cardPhoto">
                        <a href="{{ url('/posts/'. $post->id) }}"><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}"></a>
                    </div>
                @endif

            </div>
            <div class = "cardHandleSection">
                <p>
                    By: <a href="{{ action('UserController@show', [$post->user_id])}}" style = "font-weight: bold">{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a>
                </p>
            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        @if($post->elevateStatus === 'Elevated')
                            <img src = '/img/elevated.png'>
                        @else
                            <a href="{{ url('/posts/elevate/'.$post->id) }}"><img src = '/img/elevate.png'></a>
                        @endif
                        <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
                    </div>
                    <div class = "elevationCounter">
                        <a href={{ url('/posts/listElevation/'.$post->id)}}>{{ $post->elevation }}</a>
                    </div>
                </div>

                <div class = "beaconSection">
                    <a href="{{ url('/beacons/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a>
                    <span class="tooltiptext">Beacon community where this post is located</span>
                </div>

                <div class = "extensionSection">
                    <a href="{{ url('/extensions/post/'.$post->id) }}"><img src = '/img/extend.png'></a>
                    <a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>

            </div>
        </div>
    @endforeach
    <div class = "contentHeaderSeparator">
        <h3>Recent Extensions</h3>
    </div>

    @foreach ($extensions as $extension)
        <div class = "contentExtensionCard">
            <div class = "cardTitleSection">
                <h3>
                    <a href="{{ action('ExtensionController@show', [$extension->id])}}">{{ $extension->title }}</a>
                </h3>
            </div>
            <div class = "cardCaptionExcerptSection">


                <p class = "cardExcerpt">
                    {{ $extension->excerpt }}<a href="{{ action('ExtensionController@show', [$extension->id])}}">... Read More</a>
                </p>

            </div>
            <div class = "cardHandleSection">
                <p>
                    By: <a href="{{ action('UserController@show', [$extension->user_id])}}" style = "font-weight: bold">{{ $extension->user->handle }}</a> on <a href = {{ url('$/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                </p>
            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        @if($extension->elevateStatus === 'Elevated')
                            <img src = '/img/elevated.png'>
                        @else
                            <a href="{{ url('/posts/elevate/'.$post->id) }}"><img src = '/img/elevate.png'></a>
                        @endif
                        <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
                    </div>
                    <div class = "elevationCounter">
                        <a href={{ url('/extensions/listElevation/'.$extension->id)}}>{{ $extension->elevation }}</a>
                    </div>
                </div>

                <div class = "beaconSection">
                    <a href="{{ url('/beacons/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a>
                    <span class="tooltiptext">Beacon community where this post is located</span>
                </div>

                <div class = "extensionSection">
                    <a href="{{ url('/extensions/extenception/'.$extension->id) }}"><img src = '/img/extend.png'></a>
                    <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>

            </div>
        </div>
    @endforeach


@stop

@section('centerFooter')
    <div id = "centerFooter">


    </div>
@stop

