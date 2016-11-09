@foreach ($beaconMods as $beaconMod)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/beacons/moderators/'. $beaconMod->beacon->id) }}">{{$beaconMod->beacon->name}}</a>
                    </h3>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($beaconMod->beacon->photo_path != NULL)
                        <a href={{ url('/beacons/moderators/'. $beaconMod->beacon->id) }}><img src= {{ url(env('IMAGE_LINK'). $beaconMod->beacon->photo_path) }} alt="{{$beaconMod->beacon->name}}" height = "99%" width = "99%"></a>
                    @else
                        <a href={{ url('/beacons/moderators/'. $beaconMod->beacon->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                    @endif
                </div>
            </div>
            <div class = "cardHandleSection">
                <p>
                    Tag: <a href = "{{ url('/beacons/moderators/'. $beaconMod->beacon->id) }}">{{$beaconMod->beacon->beacon_tag}}</a>
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <span class="tooltiptext">Number of monthly tags for {{ $beaconMod->beacon->beacon_tag }}</span>
                        <a href="{{ url('/beacons/'. $beaconMod->beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-hashtag" aria-hidden="true"></i></a>
                    </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/beacons/'. $beaconMod->beacon->beacon_tag) }}">{{ $beaconMod->beacon->tag_usage }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/beliefs/' . $beaconMod->beacon->belief) }}">{{ $beaconMod->beacon->belief }}</a>
                    <span class="tooltiptext">Belief or way of life associated to the Beacon </span>
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/beacons/'. $beaconMod->beacon->beacon_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Number of monthly views</span>
                    </div>
                    <div class = "rightCounter">
                        <a href="{{ url('/beacons/'. $beaconMod->beacon->beacon_tag) }}">{{ $beaconMod->beacon->tag_views }}</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endforeach