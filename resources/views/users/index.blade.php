@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Users
@stop

@section('centerText')
    <h2>{{ $location }} User Directory</h2>
        <div class = "indexNav">
            <a href="{{ url('/users/following/' . $user->id)}}" class = "indexLink">Following</a>
            @if($user->last_tag != null)
                <a href="{{ url('/beacons/users/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
            @endif
            <a href="{{ url('users/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart" aria-hidden="true"></i></a>
            <a href="{{ url('users/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
        </div>

    <hr class = "contentSeparator"/>
    @foreach ($users as $User)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/users/'. $User->id) }}">{{$User->handle}}</a>
                        </h3>
                    </header>
                </div>

                <div class = "indexNav">
                    <div class = "cardImg">
                        @if($User->photo_path != NULL)
                            <a href={{ url('/users/'. $User->id) }}><img src= {{ url(env('IMAGE_LINK'). $User->photo_path) }} alt="{{$User->handle}}" height = "99%" width = "99%"></a>
                        @else
                            <a href={{ url('/users/'. $User->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                        @endif
                    </div>
                </div>
                <div class = "cardHandleSection">
                    <p>
                        Latest Activity: {{ $User->updated_at->format('M-d-Y') }}
                    </p>
                </div>
                <div class = "influenceSection">
                    <div class = "elevationSection">
                        <div class = "elevationIcon">
                            <a href="{{ url('/users/elevatedBy/'. $User->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                            <span class="tooltiptext">Total elevation (hearts) of user content</span>
                            <a href="{{ url('/users/elevatedBy/'. $User->id) }}">{{ $User->elevation }}</a>
                        </div>
                    </div>
                    <div class = "beaconSection">
                        <a href="{{ url('/beacons/'.$User->last_tag) }}" >{{ $User->last_tag }}</a>
                        <span class="tooltiptext">Beacon community where this user is located</span>
                    </div>
                    <div class = "extensionSection">
                        <div class = "extensionIcon">
                            <a href="{{ url('/users/extendedBy/'. $user->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                            <span class="tooltiptext">Total extension of user content</span>
                            <a href="{{ url('/users/extendedBy/'. $user->id) }}">{{ $user->extension }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @endforeach
@stop
@section('centerFooter')

@stop


