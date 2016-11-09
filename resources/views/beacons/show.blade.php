@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Beacon
@stop

@section('centerText')
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h1>{{ $beacon->name }}</h1>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($beacon->photo_path != NULL)
                        <img src= {{ url(env('IMAGE_LINK'). $beacon->photo_path) }} alt="{{$beacon->name}}" height = "99%" width = "99%">
                    @else
                        <img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%">
                    @endif
                </div>

            </div>
            <div class = "indexNav">
                @if($guide != NULL)
                <a href="{{ url('/beacons/guide/'.$beacon->beacon_tag)}}" class = "indexLink">Guide <div>{{ $guide->handle }}</div></a>
                @endif
                <a href="{{ url('/beacons/posts/'.$beacon->beacon_tag)}}" class = "indexLink">Posts <div>{{ $postCount }}</div></a>
                <a href="{{ url('/beacons/users/'. $beacon->beacon_tag)}}" class = "indexLink">Users <div>{{ $userCount }}</div></a>

            </div>
            <p>Tag: {{ $beacon->beacon_tag }}</p>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <span class="tooltiptext">Number of monthly tags for {{ $beacon->beacon_tag }}</span>
                        <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-hashtag" aria-hidden="true"></i></a>
                    </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->tag_usage }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/beliefs/'. $beacon->belief) }}">{{ $beacon->belief }}</a>
                </div>
                <div class = "rightSection">
                    <div class = 'rightIcon'>
                        <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Number of monthly views</span>
                    </div>
                    <div class = "rightCounter">
                        <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->tag_views }}</a>
                    </div>
                </div>
            </div>
            @if($user->type > 1 || $user->id == $beacon->manager)

                <button type = "button" id = "managerOptions" class = "navButton">Show Manager Options</button>
                <div id = "hiddenManagerOptions">
                    <div class = "contentExtensionCard">
                        <h3>Management</h3>
                        <a href = "{{ url('/beacons/moderators/' . $beacon->id) }}" class = "indexLink">Moderators</a>
                        <a href = "{{ url('/beacons/moderators/find/' . $beacon->id) }}" class = "indexLink">Find Moderators</a>
                    <h3>Content</h3>
                        <a href = "{{ url('/beacons/safePost/' . $beacon->id) }}" class = "indexLink">Safe Post</a>
                        <a href="{{ url('/intolerances/beacon/'. $beacon->id) }}" class = "indexLink">Intolerance</a>
                        <a href = "{{ url('/announcements/beaconIndex/'. $beacon->id) }}" class = "indexLink">Announcements</a>
                    <h3>Administration</h3>
                        <a href="{{ url('/beacons/invoice/'. $beacon->id )}}" class = "indexLink">Invoices</a>
                        <a href="{{ url('/beacons/subscription/'. $beacon->id )}}" class = "indexLink">Subscription</a>
                        <a href = "{{ url('/beacons/analytics/'. $beacon->id) }}" class = "indexLink">Analytics</a>
                        <a href = "{{ url('/beacons/integration/'. $beacon->id) }}" class = "indexLink">Integration</a>
                    </div>
                </div>
                @endif
        </div>
    </article>
        @if($user->type > 1)
            <a href="{{ url('/beacons/'.$beacon->id .'/edit') }}" class = "navLink">Edit</a>
            <a href="{{ url('beacons/deactivate/'. $beacon->id)}}" class = "navLink">Deactivate</a>
        @endif
        @if($moderator == true)
            <a href = "{{ url('/beacons/moderators/' . $beacon->id) }}" class = "navLink">Moderation</a>
        @endif
        @if($userConnected == FALSE)
            <a href="{{ url('/bookmarks/beacons/'.$beacon->beacon_tag) }}" class = "navLink">Connect to Beacon</a>
        @endif
    <a href="{{ url('/beacons/contact/' . $beacon->beacon_tag) }}" class = "navLink">Contact</a>


    <div class = "contentHeaderSeparator">
        <h3>Announcements</h3>
    </div>
        @if(!count($announcements))
            <p>No announcements to show</p>
        @else
        @foreach ($announcements as $announcement)
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/announcements/'. $announcement->id) }}">{{$announcement->title}}</a>
                            </h3>
                        </header>
                    </div>

                    <div class = "indexNav">
                       <p>{{ $announcement->description }}</p>
                    </div>
                    <div class = "cardHandleSection">
                        <p>
                            Created: {{ $announcement->created_at->format('M-d-Y') }}
                        </p>
                    </div>
                </div>
            </article>
        @endforeach
    @endif
@stop

