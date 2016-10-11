@extends('app')
@section('siteTitle')
    Search Posts
@stop
@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/posts/')}}><button type = "button" class = "indexButton">Recent Posts</button></a>
               <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Post Search</button></a>
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
    <div class = "contentHeaderSeparator">
        <h3>Post Results</h3>
    </div>
    @if(!count($posts))
        <p>0 posts with this title</p>
    @else
        @foreach ($posts as $post)
            <div class = "contentCard">
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
                <div class = "cardCaptionExcerptSection">

                    @if(isset($post->excerpt))
                        <p class = "cardExcerpt">
                            {{ $post->excerpt }}<a href="{{ action('PostController@show', [$post->id])}}">... Read More</a>
                        </p>
                    @elseif(isset($post->caption))
                        <a href="{{ action('PostController@show', [$post->id])}}">{{ $post->caption }}</a>
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
                        <p onclick="" class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
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
        @endforeach
    @endif

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts->appends(['title' => $title])])
@stop



