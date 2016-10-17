@extends('app')
@section('siteTitle')
    Sponsorships
@stop

@section('centerText')
    <h2><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "indexLink">Profile</a>
        <a href="{{ url('/sponsors/contact' . $sponsor->sponsor_tag) }}" class = "indexLink">Contact</a>
    </div>
    <p>Users sponsored by: <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "contentHandle">{{ $sponsor->sponsor_tag }}</a></p>

    <div class = "indexNav">
        @if($user->id == $sponsor->user_id || $user->type > 1 )
        <a href="{{ url('/sponsors/eligible/'. $sponsor->id) }}" class = "indexLink">Promo Eligible</a>
        @endif
    </div>
    <hr class = "contentSeparator"/>
    @foreach ($sponsorships as $sponsorship)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/users/'. $sponsorship->user->id) }}">{{$sponsorship->user->handle}}</a>
                        </h3>
                    </header>
                </div>

                <div class = "indexNav">
                    <div class = "cardImg">
                        @if($sponsorship->user->photo_path != NULL)
                            <a href={{ url('/users/'. $sponsorship->user->id) }}><img src= {{ url(env('IMAGE_LINK'). $sponsorship->user->photo_path) }} alt="{{$sponsorship->user->handle}}" height = "99%" width = "99%"></a>
                        @else
                            <a href={{ url('/users/'. $sponsorship->user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                        @endif
                    </div>
                </div>
                <div class = "cardHandleSection">
                    <p>
                        Sponsored Since: {{ $sponsorship->created_at->format('M-d-Y') }}
                    </p>
                </div>
                <div class = "influenceSection">
                    <div class = "elevationSection">
                        <div class = "elevationIcon">
                            <a href="{{ url('/users/elevatedBy/'. $sponsorship->user->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                            <span class="tooltiptext">Total elevation (hearts) of user content</span>
                            <a href="{{ url('/users/elevatedBy/'. $sponsorship->user->id) }}">{{ $sponsorship->user->elevation }}</a>
                        </div>
                    </div>
                    <div class = "beaconSection">
                        <a href="{{ url('/beacons/'.$sponsorship->user->last_tag) }}" >{{ $sponsorship->user->last_tag }}</a>
                        <span class="tooltiptext">Beacon community where this user is located</span>
                    </div>
                    <div class = "extensionSection">
                        <a href="{{ url('/users/extendedBy/'. $sponsorship->user->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                        <span class="tooltiptext">Total extension of user content</span>
                        <a href="{{ url('/users/extendedBy/'. $sponsorship->user->id) }}">{{ $sponsorship->user->extension }}</a>
                    </div>
                </div>
            </div>
        </article>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
    <div>
        <a href="{{ url('promotions/sponsor/'.$sponsor->id) }}"><button type = "button" class = "navButton">View All Promos</button></a>
    </div>
@stop


