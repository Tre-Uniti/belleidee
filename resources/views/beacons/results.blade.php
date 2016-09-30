@extends('app')
@section('siteTitle')
    Search Beacons
@stop

@section('centerText')
        <h2>{{ $location }} Beacon Directory</h2>
        <div class = "indexNav">
            <a href={{ url('/beacons/')}}><button type = "button" class = "indexButton">Show All Beacons</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href="{{ url('/beaconRequests/create') }}"><button type = "button" class = "indexButton">Request New Beacon</button></a>
        </div>

        <div class = "contentHeaderSeparator">
            <h3>Search Results ( {{ $beaconCount}}@if($beaconCount == 10)+  @endif ) </h3>
        </div>
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



@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons->appends(['identifier' => $identifier])])
@stop



