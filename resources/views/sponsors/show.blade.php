@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Sponsor
@stop

@section('centerText')
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h1>{{ $sponsor->name }}</h1>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($sponsor->photo_path != NULL)
                        <img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" height = "99%" width = "99%">
                    @else
                        <img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%">
                    @endif
                </div>
            </div>
            <div class = "indexNav">
                <a href="{{ url('promotions/sponsor/'.$sponsor->id)}}" class = "indexLink">Promotions <div>{{ $promoCount }}</div></a>
                <a href="{{ url('/sponsors/sponsorships/'.$sponsor->sponsor_tag)}}" class = "indexLink">Sponsorships <div>{{ $sponsor->sponsorships }}</div></a>
            </div>
            <p>Tag: {{ $sponsor->sponsor_tag }}</p>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <span class="tooltiptext">Number of monthly clicks for {{ $sponsor->sponsor_tag }}</span>
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></a>
                        </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->clicks }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">Status: {{ $sponsor->status }}</a>
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                    <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->views }}</a>
                    <span class="tooltiptext">Number of monthly views</span>
                    </div>
                </div>
            </div>
            @if($user->type > 1 || $user->email == $sponsor->email)

                <button type = "button" id = "managerOptions" class = "navButton">Show Manager Options</button>
                <div id = "hiddenManagerOptions">
                    <div class = "indexNav">
                        <a href = "{{ url('/sponsors/analytics/'. $sponsor->id) }}" class = "indexLink">Analytics</a>
                        <a href = "{{ url('/sponsors/social/'. $sponsor->id) }}" class = "indexLink">Social Button</a>
                        <a href="{{ url('promotions/sponsor/'. $sponsor->id) }}" class = "indexLink">Promotions</a>
                        </div>
                </div>
            @endif
        </div>
    </article>
    @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href="{{ url('/sponsors/pay/'. $sponsor->id) }}" class = "navLink">Pay</a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}" class = "navLink">Edit</a>
    @endif
    @if($eligibleUser != NULL)
        <a href="{{ url('promotions/sponsor/'.$sponsor->id) }}" class = "navLink">All Promos</a>
    @else
        <a href="{{ url('/sponsors/sponsorship/'.$sponsor->id) }}" class = "navLink">Start Sponsorship</a>
    @endif
        <a href=" {{ url('/sponsors/contact/' . $sponsor->sponsor_tag) }}" class = "navLink">Contact</a>

    <div class = "contentHeaderSeparator">
        <h3>Promotions</h3>
    </div>
    @include('promotions._promotionCards')
@stop


