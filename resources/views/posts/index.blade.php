@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <script src = "/js/backToTop.js"></script>
@stop
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>{{ $location }} Recent Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Type Filter</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Time Filter</button></a>
    </div>

            <div class = "indexContent" id = "hiddenContent">
                <a href={{ url('/posts/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                <a href={{ url('/posts/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                <a href={{ url('/posts/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                <a href={{ url('/posts/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
            </div>
    </div>
        @foreach ($posts as $post)
            <div class = "contentCard">
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

                <div class = "influenceSection">
                    <div class = "elevationSection">
                        <div class = "elevationIcon">
                            @if($post->elevateStatus === 'Elevated')
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
        @endforeach

    <a href= "#" class= "back-to-top" >
        Back to Top
        <i class= "fa fa-arrow-circle-up 2x"></i>
    </a>

@stop



