@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Following {{ $user->handle }}
@stop

@section('centerText')
    <div>
        <h2>Followers of <a href = "{{ url('users/'. $user->id) }}">{{ $user->handle }}</a></h2>
        <div class = "indexNav">
            <a href="{{ url('/users/' . $user->id)}}" class = "indexLink">Profile</a>
        </div>
    </div>
    <hr class = "contentSeparator">
    @if(isset($followers))
    @foreach ($followers as $follower)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/users/'. $follower->id) }}">{{$follower->handle}}</a>
                        </h3>
                    </header>
                </div>

                <div class = "indexNav">
                    <div class = "cardImg">
                        @if($follower->photo_path != NULL)
                            <a href={{ url('/users/'. $follower->id) }}><img src= {{ url(env('IMAGE_LINK'). $follower->photo_path) }} alt="{{$follower->handle}}" height = "99%" width = "99%"></a>
                        @else
                            <a href={{ url('/users/'. $follower->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                        @endif
                    </div>
                </div>
                <div class = "cardHandleSection">
                    <p>
                        Latest Activity: {{ $follower->updated_at->format('M-d-Y') }}
                    </p>
                </div>
                <div class = "influenceSection">
                    <div class = "elevationSection">
                        <div class = "elevationIcon">
                            <a href="{{ url('/users/elevatedBy/'. $follower->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                            <span class="tooltiptext">Total elevation (hearts) of user content</span>
                            <a href="{{ url('/users/elevatedBy/'. $follower->id) }}">{{ $follower->elevation }}</a>
                        </div>
                    </div>
                    <div class = "beaconSection">
                        <a href="{{ url('/beacons/'.$follower->last_tag) }}" >{{ $follower->last_tag }}</a>
                        <span class="tooltiptext">Beacon community where this user is located</span>
                    </div>
                    <div class = "extensionSection">
                        <a href="{{ url('/users/extendedBy/'. $follower->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                        <span class="tooltiptext">Total extension of user content</span>
                        <a href="{{ url('/users/extendedBy/'. $follower->id) }}">{{ $follower->extension }}</a>
                    </div>
                </div>
            </div>
        </article>
    @endforeach
    @else
    <p>No followers yet!</p>
    @endif

@stop


