@extends('app')
@section('siteTitle')
    Drafts
@stop

@section('centerText')
    <h2>Recent Drafts</h2>
        <div id = "indexNav">
           <a href={{ url('/drafts/create')}}><button type = "button" class = "indexButton">Create Draft</button></a>
        </div>
    <hr class = "contentSeparator">
    @foreach ($drafts as $draft)
        <article>
            <div class = "contentCard">
                <header>
                    <div class = "cardTitleSection">
                        <h3>
                            <a href="{{ action('DraftController@show', [$draft->id])}}">{{ $draft->title }}</a>
                        </h3>
                    </div>
                    <div class = "cardHandleSection">
                        <p>
                            By: <a href="{{ action('UserController@show', [$draft->user_id])}}" class = "contentHandle">{{ $draft->user->handle }}</a> on {{ $draft->created_at->format('M-d-Y') }}
                        </p>
                    </div>
                </header>
                <div class = "cardCaptionExcerptSection">

                    @if(isset($draft->excerpt))
                        <p class = "cardExcerpt">
                            <a href="{{ action('PostController@show', [$draft->id])}}" class = "excerptText">{{ $draft->excerpt }}</a><a href="{{ action('DraftController@show', [$draft->id])}}">... Read More</a>
                        </p>
                    @elseif(isset($draft->caption))
                        <a href="{{ action('PostController@show', [$draft->id])}}" class = "excerptText">{{ $draft->caption }}</a>
                        <div class = "cardPhoto">
                            <a href="{{ url('/drafts/'. $draft->id) }}"><img src= {{ url(env('IMAGE_LINK'). $draft->draft_path) }} alt="{{$draft->title}}"></a>
                        </div>
                    @endif

                </div>
                <div class = "footerSection">
                    <div class = "centerSection">
                        <a href="{{ url('/beacons/'.$draft->beacon_tag) }}" >{{ $draft->beacon_tag }}</a>
                        <span class="tooltiptext">Beacon community where this draft is located</span>
                    </div>
                </div>
            </div>
        </article>

    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $drafts])
@stop



