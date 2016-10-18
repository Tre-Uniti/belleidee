@extends('app')
@section('siteTitle')
    Search Users
@stop

@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/users/')}}><button type = "button" class = "indexButton">Recent User</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">User Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
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
    @include('pagination.custom-paginator', ['paginator' => $results->appends(['title' => $handle])])
@stop



