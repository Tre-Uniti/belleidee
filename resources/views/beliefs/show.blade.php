@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')

    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h1>{{ $belief->name }}</h1>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($belief->photo_path != NULL)
                        <img src= {{ url(env('IMAGE_LINK'). $belief->photo_path) }} alt="{{$belief->name}}" height = "99%" width = "99%">
                    @else
                        <img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%">
                    @endif
                </div>

            </div>
            <div class = "indexNav">
                <a href="{{ url('/beliefs/posts/'. $belief->name) }}" class = "indexLink">Posts <div>{{ $belief->posts }}</div></a>
                <a href="{{ url('/beliefs/extensions/'. $belief->name) }}" class = "indexLink">Extensions <div>{{ $belief->extensions }}</div></a>
                <a href="{{ url('/beliefs/beacons/'. $belief->name) }}" class = "indexLink">Beacons <div>{{ $belief->beacons }}</div></a>
            </div>
            <p>{{ $belief->description }}</p>
        </div>
    </article>

    <div class = "contentHeaderSeparator">
        <h3>
            Legacy Posts
        </h3>
    </div>
    @include('legacyPosts._legacyPostCards')
@stop

@section('centerFooter')
    <a href="{{ url('/beliefs/') }}"><button type = "button" class = "navButton">Belief Directory</button></a>
    <a href="{{ url('/legacyPosts/belief/'. $belief->name) }}"><button type = "button" class = "navButton">More Legacy</button></a>
    @if($user->type > 2)
        <a href="{{ url('/beliefs/'.$belief->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop