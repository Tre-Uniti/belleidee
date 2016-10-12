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
                Location set to: <a href = "{{ url('/newLocation') }}">{{ $location }}</a>
                </p>
            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Total elevation (hearts) of your content</span>
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}">{{ $user->elevation }}</a>
                    </div>
                </div>
                <div class = "beaconSection">
                </div>
                <div class = "extensionSection">
                    <a href="{{ url('/users/extendedBy/'. $user->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                    <span class="tooltiptext">Total extension of your content</span>
                    <a href="{{ url('/users/extendedBy/'. $user->id) }}">{{ $user->extension }}</a>
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
        </div>
    </article>
    <p>
        <a href="{{ url('/posts/create') }}" class = " navLink">Create a Post</a>
        <a href="{{ url('/posts') }}" class = "navLink">Discover Posts</a>
    </p>

    <div class = "contentHeaderSeparator">
        <h3>Your Recent Posts</h3>
    </div>

    @foreach ($posts as $post)
        <article>
        <div class = "contentCard">
            <header>
            <div class = "cardTitleSection">
                <h3>
                    <a href="{{ action('PostController@show', [$post->id])}}">{{ $post->title }}</a>
                </h3>
            </div>
            <div class = "cardHandleSection">
                <p>
                    By: <a href="{{ action('UserController@show', [$post->user_id])}}" class = "contentHandle">{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a>
                </p>
            </div>
            </header>
            <div class = "cardCaptionExcerptSection">

                @if(isset($post->excerpt))
                    <p class = "cardExcerpt">
                        <a href="{{ action('PostController@show', [$post->id])}}" class = "excerptText">{{ $post->excerpt }}</a><a href="{{ action('PostController@show', [$post->id])}}">... Read More</a>
                    </p>
                @elseif(isset($post->caption))
                    <a href="{{ action('PostController@show', [$post->id])}}" class = "excerptText">{{ $post->caption }}</a>
                    <div class = "cardPhoto">
                        <a href="{{ url('/posts/'. $post->id) }}"><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}"></a>
                    </div>
                @endif

            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        @if($post->elevateStatus === 'Elevated')
                            <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                        @else
                            <a href="{{ url('/posts/elevate/'.$post->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        @endif
                        <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                    </div>

                    <div class = "elevationCounter">
                        <a href={{ url('/posts/listElevation/'.$post->id)}}>{{ $post->elevation }}</a>
                    </div>

                </div>

                <div class = "beaconSection">
                    <a href="{{ url('/beacons/'.$post->beacon_tag) }}" >{{ $post->beacon_tag }}</a>
                    <span class="tooltiptext">Beacon community where this post is located</span>
                </div>

                <div class = "extensionSection">
                    <a href="{{ url('/extensions/post/'.$post->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a>

                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>
                <div class = "moreSection">
                    <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                    <div class="moreOptionsMenu">
                        <a href="{{ url('bookmarks/posts/'.$post->id) }}"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i></a>
                        <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$post->title}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/intent/tweet?status={{$post->title}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                        @if($post->user_id != Auth::id())
                            <a href="{{ url('/intolerances/post/'.$post->id) }}"><i class="fa fa-flag-o fa-lg" aria-hidden="true"></i></a>
                        @elseif ($post->status < 1)
                            Status: Tolerant
                        @else
                            Status: Intolerant
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </article>
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
                    By: <a href="{{ action('UserController@show', [$extension->user_id])}}" class = "contentHandle">{{ $extension->user->handle }}</a> on <a href = {{ url('$/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                </p>
            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        @if($extension->elevateStatus === 'Elevated')
                            <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                        @else
                            <a href="{{ url('/extensions/elevate/'.$extension->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        @endif
                        <span class="tooltiptext">Heart to give thanks and recommend to others</span>
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
                    <a href="{{ url('/extensions/extenception/'.$extension->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>
                <div class = "moreSection">
                    <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                    <div class="moreOptionsMenu">
                        <a href="{{ url('bookmarks/extensions/'.$extension->id) }}"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i></a>
                        <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$extension->title}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/intent/tweet?status={{$extension->title}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                        @if($extension->user_id != Auth::id())
                            <a href="{{ url('/intolerances/extension/'.$extension->id) }}"><i class="fa fa-flag-o fa-lg" aria-hidden="true"></i></a>
                        @elseif ($extension->status < 1)
                            Status: Tolerant
                        @else
                            Status: Intolerant
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop

