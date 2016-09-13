@extends('app')
@section('pageHeader')
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

    <script src='https://api.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.js'></script>
    <script src="/js/maps.js"></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.css' rel='stylesheet' />
@stop
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Profile:
            </h3>
        </div>
        <div class = "cardCaptionExcerptSection">
            <div class = "indexNav">

                <div class = "indexLink">
                    <a href="{{ url('/posts/user/'. $user->id) }}">Posts: {{ $posts }}</a>
                </div>
                <div class = "indexLink">
                    <a href="{{ url('/extensions/user/'. $user->id) }}">Extensions: {{ $extensions }}</a>
                </div>
            </div>
            <div class = "cardHandleSection">
                <p>
                    Latest Activity: {{ $user->updated_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><img src = "/img/elevate.png"> {{ $user->elevation }}</a>
                        <span class="tooltiptext">Total elevation of your content</span>
                    </div>
                </div>

                <div class = "beaconSection">
                    <a href="{{ url('/beacons/'.$user->last_tag) }}">{{ $user->last_tag }}</a>
                    <span class="tooltiptext">Your current Beacon</span>
                </div>

                <div class = "extensionSection">
                    <a href="{{ url('/users/extendedBy/'. $user->id) }}"><img src = "/img/extend.png"> {{ $user->extension }}</a>
                    <span class="tooltiptext">Total extension of your content</span>
                </div>

            </div>




        </div>

    </div>




    <div class = "contentCard">
        <div id='map' style='width: auto; height: 500px;'></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoidHJldW5pdGkiLCJhIjoiY2lzd3I4eG5wMDZkajJva2gxaDRlMmZ1cSJ9.eCMHtRz8U82MkHThsnyafA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v9',
                zoom: 16,
                center: [{{ $beacon->long }}, {{ $beacon->lat }}]
            });
            map.on('style.load', function () {

                map.addSource("markers", {
                    "type": "geojson",
                    "data": {
                        "type": "FeatureCollection",
                        "features": [{
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [{{ $beacon->long }}, {{ $beacon->lat }}]
                            },
                            "properties": {
                                "title": "PH-MK-DBCP",
                                "marker-symbol": "monument"
                            }
                        }, {
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [{{ $beacon->long }}, {{ $beacon->lat }}]
                            },
                            "properties": {
                                "title": "Mapbox SF",
                                "marker-color": "#ff00ff"
                            }
                        }]
                    }
                });

                map.addLayer({
                    "id": "markers",
                    "type": "symbol",
                    "source": "markers",
                    "layout": {
                        "icon-image": "{marker-symbol}-15",
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                        "text-offset": [0, 0.6],
                        "text-anchor": "top"
                    }
                });
            });
        </script>

    </div>

@stop

@section('centerFooter')

@stop
