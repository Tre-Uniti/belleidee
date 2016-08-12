@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>{{ $location }} Recent Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
            <div class = "indexContent" id = "hiddenContent">
                <a href={{ url('/posts/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                <a href={{ url('/posts/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                <a href={{ url('/posts/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                <a href={{ url('/posts/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
            </div>
    </div>
        @foreach ($posts as $post)
            <div class = "postCard">
                <div class = "postTitleSection">
                    <h3>
                        <a href="{{ action('PostController@show', [$post->id])}}">{{ $post->title }}</a>
                    </h3>
                </div>
                <div class = "postCaptionExcerptSection">

                        @if(isset($post->excerpt))
                            <p>
                                {{ $post->excerpt }}<a href="{{ action('PostController@show', [$post->id])}}">... Read More</a>
                            </p>
                        @elseif(isset($post->caption))
                            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->caption }}</button></a>
                            <div class = "cardPhoto">
                            <a href="{{ url('/posts/'. $post->id) }}"><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}"></a>
                            </div>
                        @endif

                </div>
                <div class = "postHandleSection">
                    <p>                    By: <a href="{{ action('UserController@show', [$post->user_id])}}" style = "font-weight: bold">{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a>
                    </p>
                </div>
                <div class = "postTagsSection">

                </div>
                <div class = "influenceSection">
                    <div class = "elevationSection">
                    @if($post->elevateStatus === 'Elevated')
                        <a href="{{ url('/posts/'.$post->id) }}"><img src = '/img/elevate.png'></a>
                    @else
                        <a href="{{ url('/posts/elevate/'.$post->id) }}"> <a href="{{ url('/posts/'.$post->id) }}"><img src = '/img/elevate.png'></a></a>
                    @endif
                    <a href={{ url('/posts/listElevation/'.$post->id)}}>{{ $post->elevation }}</a>
                        <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
                    </div>
                    <a href="{{ url('/beacons/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a>
                    <div class = "extensionSection">
                        <a href="{{ url('/extensions/post/'.$post->id) }}"><img src = '/img/extend.png'></a>
                        <a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a>
                        <span class="tooltiptext">Extend to add any inspiration you received</span>
                    </div>

                </div>
            </div>
        @endforeach

@stop



