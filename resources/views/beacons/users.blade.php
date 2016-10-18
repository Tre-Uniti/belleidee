@extends('app')
@section('siteTitle')
    Beacon Users
@stop
@section('centerText')
    <h2><a href={{ url('/beacons/'. $beacon->beacon_tag)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/beacons/'. $beacon->beacon_tag)}}" class = "indexLink">Profile</a>
        <a href="{{ url('/beacons/contact/' . $beacon->beacon_tag)}}" class = "indexLink">Contact</a>
        <p>Users connected to: <a href = "{{ url('/beacons/' . $beacon->beacon_tag) }}" class = "contentHandle">{{ $beacon->beacon_tag }}</a></p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href="{{ url('/beacons/guide/'.$beacon->beacon_tag)}}" @if($type == 'Guide')class = "navLink" @else class = "indexLink" @endif>Guide</a>
                    <a href = "{{ url('/beacons/posts/' . $beacon->beacon_tag) }}" @if($type == 'Posts') class = "navLink" @else class = "indexLink" @endif>Posts</a>
                    <a href = "{{ url('/beacons/extensions/'. $beacon->beacon_tag) }}" @if($type == 'Extensions') class = "navLink" @else class = "indexLink" @endif>Extensions</a>
                    <a href = "{{ url('/beacons/users/'. $beacon->beacon_tag) }}" @if($type == 'Users') class = "navLink" @else class = "indexLink" @endif>Users</a>
                </li>
            </ul>
        </nav>
    </div>
    <hr class = "contentSeparator">
    @if(count($users) == 0)
        <p>No users connected yet!</p>
    @else
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
    @include('pagination.custom-paginator', ['paginator' => $users])
    @endif
@stop