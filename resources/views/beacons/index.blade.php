@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Beacons
@stop

@section('centerText')
    <h2>{{ $location }} Beacon Directory</h2>
        <div class = "indexNav">
            @if($user->last_tag != null)
            <a href="{{ url('/beacons/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
            @endif
            <a href="{{ url('/beacons/topTagged')}}" class = "indexLink">Top <i class="fa fa-hashtag" aria-hidden="true"></i></a>
            <a href="{{ url('/beacons/topViewed')}}" class = "indexLink">Most <i class="fa fa-eye" aria-hidden="true"></i></a>
            <a href="{{ url('/beaconRequests')}}" class = "indexLink">Requests</a>
        </div>
    <p>Beacon: A place of worship or thought</p>
 <hr class = "contentSeparator"/>
        @foreach ($beacons as $beacon)
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{$beacon->name}}</a>
                            </h3>
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
                            Tag: <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{$beacon->beacon_tag}}</a>
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



