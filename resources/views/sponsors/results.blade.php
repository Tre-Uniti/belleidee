@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <h2>Search Results</h2>
    <div class = "indexNav">
        <a href={{ url('/sponsors/')}}><button type = "button" class = "indexButton">All Sponsors</button></a>
        <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
        <a href="{{ url('/sponsorRequests/create') }}"><button type = "button" class = "indexButton">Request New Sponsor</button></a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Search Results ( {{ $sponsorCount}}@if($sponsorCount == 10)+  @endif ) </h3>
    </div>
    @foreach ($sponsors as $sponsor)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->name}}</a>
                        </h3>

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
                        <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->sponsor_tag}}</a>
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
                        <a href="{{ url('/sponsors/sponsorships' . $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a href = "{{ url('/sponsors/sponsorships'. $sponsor->sponsor_tag) }}">{{ $sponsor->sponsorships }}</a>
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

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors->appends(['identifier' => $identifier])])
@stop



