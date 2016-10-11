@extends('app')
@section('siteTitle')
    Search Legacy Posts
@stop
@section('centerText')
    <h2>Legacy Posts</h2>
        <div class = "indexNav">
            <a href={{ url('/legacyPosts/')}}><button type = "button" class = "indexButton">Recent Legacy</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Legacy Search Results ( {{ $legacyPostCount}}@if($legacyPostCount == 10)+  @endif ) </h3>
    </div>
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
                            Created on <a href = {{ url('/legacyPosts/date/'.$legacyPost->created_at->format('M-d-Y')) }}>{{ $legacyPost->created_at->format('M-d-Y') }}</a>
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
                        <span class="tooltiptext">Belief or way of life this legacy relates to</span>
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

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts->appends(['identifier', $identifier ])])
@stop



