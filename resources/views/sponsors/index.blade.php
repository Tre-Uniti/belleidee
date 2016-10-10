@extends('app')
@section('pageHeader')
    <script src = '/js/index.js'></script>
@stop
@section('siteTitle')
    Sponsors
@stop

@section('centerText')
    <h2>{{ $location }} Sponsor Directory</h2>
        <p>Sponsor: A business or non-profit promoting within Belle-idee</p>
    <div class = "indexNav">
        <a href={{ url('/promotions')}}><button type = "button" class = "indexButton">Promotions</button></a>
        <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/sponsorRequests')}}><button type = "button" class = "indexButton">Requests</button></a>
    </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/sponsors/joinDate')}}><button type = "button" class = "indexButton">Join Date</button></a>
        <a href={{ url('/sponsors/topSponsored')}}><button type = "button" class = "indexButton">Top Sponsored</button></a>
        <a href={{ url('/sponsors/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>
    </div>

    @foreach ($sponsors as $sponsor)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->name}}</a>
                        </h3>
                        <p>
                            <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->sponsor_tag}}</a>
                        </p>
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
                        Latest Activity: {{ $sponsor->updated_at->format('M-d-Y') }}
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
                        <a href="{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a href = "{{ url('/sponsors'. $sponsor->sponsor_tag) }}">{{ $sponsor->sponsorships }}</a>
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
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop


