@extends('app')
@section('siteTitle')
    Legacy Posts
@stop

@section('centerText')
    <h2>{{ $filter }} Legacy Posts</h2>

        <div class = "indexNav">
            <a href={{ url('/legacyPosts/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/legacyPosts/extensionTime/'.$time)}}><button type = "button" class = "indexButton">Most Extended</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/legacyPosts') }}><button type = "button" class = "indexButton">Recent Legacy Posts</button></a>
                </li>
            </ul>
        </nav>
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

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop
