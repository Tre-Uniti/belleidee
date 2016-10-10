@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Beacons
@stop

@section('centerText')
    <h2>{{ $location }} Beacon Directory</h2>
        <p>Beacon: A place of worship or thought</p>
        <div class = "indexNav">
            <a href={{ url('/announcements')}}><button type = "button" class = "indexButton">Announcements</button></a>
            <a href={{ url('/beacons/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/beaconRequests')}}><button type = "button" class = "indexButton">Requests</button></a>
        </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/beacons/joinDate')}}><button type = "button" class = "indexButton">Join Date</button></a>
        <a href={{ url('/beacons/topTagged')}}><button type = "button" class = "indexButton">Top Tagged</button></a>
        <a href={{ url('/beacons/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>

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
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop



