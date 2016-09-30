@extends('app')
@section('siteTitle')
    Global Results
@stop

@section('centerText')
        <h2>Search Results for '{{$identifier}}'</h2>
        <p>Location scope: {{ $location }}</p>
        <p>Filter by:</p>
        <a href="{{ url('/users/results?identifier=' . $identifier) }}" class = "indexLink">Users: {{ $userCount }}@if($userCount == 10)+ @endif </a>
        <a href="{{ url('/beacons/results?identifier=' . $identifier) }}" class = "indexLink">Beacons: {{ $beaconCount}}@if($beaconCount == 10)+ @endif</a>
        <a href="{{ url('/sponsors/results?identifier=' . $identifier) }}" class = "indexLink">Sponsors: {{ $sponsorCount }}@if($sponsorCount == 10)+ @endif</a>
        <a href="{{ url('/posts/results?identifier=' . $identifier) }}" class = "indexLink">Posts: {{ $postCount }}@if($postCount == 10)+ @endif</a>
        <a href="{{ url('/legacyPosts/results?identifier=' . $identifier) }}" class = "indexLink">Legacies: {{ $legacyCount }}@if($legacyCount == 10)+ @endif</a>
        <a href="{{ url('/extensions/results?identifier=' . $identifier) }}" class = "indexLink">Extensions: {{ $extensionCount }}@if($extensionCount == 10)+ @endif</a>


        <div class = "contentHeaderSeparator">
            <h3>User Results</h3>
        </div>
        @if($userCount == 0)
            <p>0 users with this handle</p>
        @else
        @foreach ($users as $User)
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/users/'. $User->id) }}">{{$User->handle}}</a>
                            </h3>
                        </header>
                    </div>

                    <div class = "indexNav">
                        <div class = "cardImg">
                            @if($User->photo_path != NULL)
                                <a href={{ url('/users/'. $User->id) }}><img src= {{ url(env('IMAGE_LINK'). $User->photo_path) }} alt="{{$User->handle}}" height = "99%" width = "99%"></a>
                            @else
                                <a href={{ url('/users/'. $User->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                            @endif
                        </div>
                    </div>
                    <div class = "cardHandleSection">
                        <p>
                            Latest Activity: {{ $User->updated_at->format('M-d-Y') }}
                        </p>
                    </div>
                    <div class = "influenceSection">
                        <div class = "elevationSection">
                            <div class = "elevationIcon">
                                <a href="{{ url('/users/elevatedBy/'. $User->id) }}" class = "iconLink"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>
                                <span class="tooltiptext">Total elevation of user content</span>
                                <a href="{{ url('/users/elevatedBy/'. $User->id) }}">{{ $User->elevation }}</a>
                            </div>
                        </div>
                        <div class = "beaconSection">
                            <a href="{{ url('/beacons/'.$User->last_tag) }}" >{{ $User->last_tag }}</a>
                            <span class="tooltiptext">Beacon community where this user is located</span>
                        </div>
                        <div class = "extensionSection">
                            <a href="{{ url('/users/extendedBy/'. $User->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                            <span class="tooltiptext">Total extension of user content</span>
                            <a href="{{ url('/users/extendedBy/'. $User->id) }}">{{ $User->extension }}</a>
                        </div>
                    </div>
                    </div>
                </article>
        @endforeach
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Beacon Results</h3>
        </div>
        @if($beaconCount == 0)
            <p>0 beacons with this name or tag</p>
        @else
        @foreach ($beacons as $beacon)
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{$beacon->name}}</a>
                            </h3>
                            <p>
                                <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{$beacon->beacon_tag}}</a>
                            </p>
                        </header>
                    </div>

                    <div class = "indexNav">
                        <div class = "cardImg">
                            @if($beacon->photo_path != NULL)
                                <a href={{ url('/beacons/'. $beacon->beacon_tag) }}><img src= {{ url(env('IMAGE_LINK'). $beacon->photo_path) }} alt="{{$beacon->name}}" height = "99%" width = "99%"></a>
                            @else
                                <a href={{ url('/beacons/'. $beacon->beacon_tag) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                            @endif
                        </div>
                    </div>
                    <div class = "cardHandleSection">
                        <p>
                            Latest Activity: {{ $beacon->updated_at->format('M-d-Y') }}
                        </p>
                    </div>
                    <div class = "influenceSection">
                        <div class = "elevationSection">
                            <div class = "elevationIcon">
                                <span class="tooltiptext">Number of monthly tags for {{ $beacon->beacon_tag }}</span>
                                <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-hashtag" aria-hidden="true"></i></a>
                                <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->tag_usage }}</a>
                            </div>
                        </div>
                        <div class = "beaconSection">
                            <a href="{{ url('/beliefs/' . $beacon->belief) }}">{{ $beacon->belief }}</a>
                            <span class="tooltiptext">Belief or way of life associated to the Beacon </span>
                        </div>
                        <div class = "extensionSection">
                            <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->tag_views }}</a>
                            <span class="tooltiptext">Number of monthly views</span>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Sponsors Results</h3>
        </div>
        @if($sponsorCount == 0)
            <p>0 sponsors with this name or tag</p>
        @else
            @foreach ($sponsors as $sponsor)
                <article>
                    <div class = "contentCard">
                        <div class = "cardTitleSection">
                            <header>
                                <h3>
                                    <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->name}}</a>
                                </h3>
                                <p>
                                    <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->sponsor_tag}}</a>
                                </p>
                            </header>
                        </div>

                        <div class = "indexNav">
                            <div class = "cardImg">
                                @if($sponsor->photo_path != NULL)
                                    <a href={{ url('/sponsors/'. $sponsor->sponsor_tag) }}><img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" height = "99%" width = "99%"></a>
                                @else
                                    <a href={{ url('/sponsors/'. $sponsor->sponsor_tag) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                                @endif
                            </div>
                        </div>
                        <div class = "cardHandleSection">
                            <p>
                                Latest Activity: {{ $sponsor->updated_at->format('M-d-Y') }}
                            </p>
                        </div>
                        <div class = "influenceSection">
                            <div class = "elevationSection">
                                <div class = "elevationIcon">
                                    <span class="tooltiptext">Number of monthly clicks for {{ $sponsor->sponsor_tag }}</span>
                                    <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></a>
                                    <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->clicks }}</a>
                                </div>
                            </div>
                            <div class = "beaconSection">
                                <a href="{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                                    <a href = "{{ url('/sponsors'. $sponsor->sponsor_tag) }}">{{ $sponsor->sponsorships }}</a>
                                <span class="tooltiptext">Number of sponsored users</span>
                            </div>
                            <div class = "extensionSection">
                                <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->views }}</a>
                                <span class="tooltiptext">Number of monthly views</span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Post Results</h3>
        </div>
        @if($postCount == 0)
            <p>0 posts with this title</p>
        @else
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
                                By: <a href="{{ action('UserController@show', [$post->user_id])}}" style = "font-weight: bold">{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a>
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
                                @if($post->elevationStatus === 'Elevated')
                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                @else
                                    <a href="{{ url('/posts/elevate/'.$post->id) }}" class = "iconLink"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>
                                @endif
                                <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
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
                    </div>
                </div>
            </article>
        @endforeach
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Legacy Results</h3>
        </div>
        @if($legacyCount == 0)
            <p>0 legacy posts with this title</p>
        @else
            @foreach ($legacyPosts as $legacyPost)
                <article>
                    <div class = "contentCard">
                        <header>
                            <div class = "cardTitleSection">
                                <h3>
                                    <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}">{{ $legacyPost->title }}</a>
                                </h3>
                            </div>
                            <div class = "cardHandleSection">
                                <p>
                                    Created on {{ $legacyPost->created_at->format('M-d-Y') }}
                                </p>
                            </div>
                        </header>
                        <div class = "cardCaptionExcerptSection">
                                <p class = "cardExcerpt">
                                    <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}" class = "excerptText">{{ $legacyPost->excerpt }}</a>
                                    <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}">... Read More</a>
                                </p>

                        </div>
                        <div class = "influenceSection">
                            <div class = "elevationSection">
                                <div class = "elevationIcon">
                                    @if($legacyPost->elevationStatus === 'Elevated')
                                        <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                    @else
                                        <a href="{{ url('/legacyPosts/elevate/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>
                                    @endif
                                    <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
                                </div>

                                <div class = "elevationCounter">
                                    <a href={{ url('/legacyPosts/listElevation/'.$legacyPost->id)}}>{{ $legacyPost->elevation }}</a>
                                </div>

                            </div>


                            <div class = "beaconSection">
                                <a href="{{ url('/beliefs/'.$legacyPost->belief) }}" >{{ $legacyPost->belief }}</a>
                                <span class="tooltiptext">Belief or way of life this legacy belongs to</span>
                            </div>

                            <div class = "extensionSection">
                                <a href="{{ url('/legacyPost/post/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                                <a href={{ url('/legacyPost/post/list/'.$legacyPost->id)}}>{{ $legacyPost->extension }}</a>

                                <span class="tooltiptext">Extend to add any inspiration you received</span>
                            </div>

                        </div>
                    </div>
                </article>

            @endforeach
        @endif


        <div class = "contentHeaderSeparator">
            <h3>Extension Results</h3>
        </div>
        @if($extensionCount == 0)
            <p>0 extensions with this title</p>
        @else
        @foreach ($extensions as $extension)
            <article>
                <div class = "contentExtensionCard">
                    <header>
                        <div class = "cardTitleSection">
                            <h3>
                                <a href="{{ action('ExtensionController@show', [$extension->id])}}">{{ $extension->title }}</a>
                            </h3>
                        </div>
                        <div class = "cardHandleSection">
                            <p>
                                By: <a href="{{ action('UserController@show', [$extension->user_id])}}">{{ $extension->user->handle }}</a> on <a href = {{ url('$/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                            </p>
                        </div>
                    </header>
                    <div class = "cardCaptionExcerptSection">
                        <p class = "cardExcerpt">
                            <a href="{{ action('ExtensionController@show', [$extension->id])}}" class = "excerptText">{{ $extension->excerpt }}</a><a href="{{ action('ExtensionController@show', [$extension->id])}}">... Read More</a>
                        </p>
                    </div>
                    <div class = "influenceSection">
                        <div class = "elevationSection">
                            <div class = "elevationIcon">
                                @if($extension->elevationStatus === 'Elevated')
                                    <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                                @else
                                    <a href="{{ url('/posts/elevate/'.$post->id) }}" class = "iconLink"><i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i></a>
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
                            <a href="{{ url('/extensions/extenception/'.$extension->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                            <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                            <span class="tooltiptext">Extend to add any inspiration you received</span>
                        </div>

                    </div>
                </div>
            </article>
        @endforeach
    @endif

@stop
@section('centerFooter')

@stop



