@extends('app')
@section('siteTitle')
    Getting Started
@stop

@section('centerText')
    <h2>Welcome, {{ $user->handle }}</h2>
    <article>
        <div class = "contentCard">
            <header>
                <div class = "cardTitleSection">
                    <h3>
                        Let's get Started!
                    </h3>
                </div>
                <div class = "cardHandleSection">

                </div>
            </header>
            <div class = "cardCaptionExcerptSection">
                <a href="{{ url('/posts/create') }}" class = " indexLink">Create a Post</a>
                <a href="{{ url('/posts') }}" class = "indexLink">Discover Posts</a>
                <p>Location set to: {{ $location }}</p>

            </div>
            </div>
    </article>
    <div class = "contentHeaderSeparator">
        <h3>Your Beacon Community</h3>
    </div>
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

    <div class = "contentHeaderSeparator">
        <h3>Your Sponsor</h3>
    </div>
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

@stop

@section('centerFooter')
    <a href="{{ url('/tutorials') }}"><button type = "button" class = "navButton">Tutorials</button></a>
@stop


