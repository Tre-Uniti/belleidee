@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Legacy
@stop
@section('centerText')
    <div>
    <h2>Recently Extended Legacy</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Legacy</button></a>
   </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/legacyPosts/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href = {{ url('/legacyPosts/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/legacyPosts/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/legacyPosts/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
    </div>
    <hr class = "contentSeparator"/>
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
                                <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                            @else
                                <a href="{{ url('/legacyPosts/elevate/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                            @endif
                            <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                        </div>

                        <div class = "elevationCounter">
                            <a href={{ url('/legacyPosts/listElevation/'.$legacyPost->id)}}>{{ $legacyPost->elevation }}</a>
                        </div>

                    </div>

                    <div class = "beaconSection">
                        <a href="{{ url('/beliefs/'.$legacyPost->belief) }}" >{{ $legacyPost->belief }}</a>
                        <span class="tooltiptext">Belief or way of life this Legacy relates to</span>
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



