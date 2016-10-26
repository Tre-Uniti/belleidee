@extends('app')
@section('pageHeader')
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

    <script src='https://api.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.js'></script>
    <script src="/js/maps.js"></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.css' rel='stylesheet' />
@stop
@section('siteTitle')
    Show Sponsor
@stop

@section('centerText')
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h1>Contact Us</h1>
                </header>
                <h3><a href = "{{ url('/sponsors'. $sponsor->beacon_tag) }}">{{ $sponsor->name }}</a></h3>
            </div>
            <div class = "cardHandleSection">
                <p>Tag: {{ $sponsor->sponsor_tag }}</p>
                <p><a href = "{{ $sponsor->website }}" target="_blank">{{ $sponsor->website }}</a></p>
                Phone: {{ $sponsor->phone }}
            </div>
        </div>
    </article>

    <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "indexLink">Back to Profile</a>

    <hr class = "contentSeparator"/>

    <div class = "contentCard">
        <div id='map' style='width: auto; height: 500px;'></div>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoidHJldW5pdGkiLCJhIjoiY2lzd3I4eG5wMDZkajJva2gxaDRlMmZ1cSJ9.eCMHtRz8U82MkHThsnyafA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v9',
                zoom: 16,
                center: [{{ $sponsor->long }}, {{ $sponsor->lat }}]
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
                                "coordinates": [{{ $sponsor->long }}, {{ $sponsor->lat }}]
                            },
                            "properties": {
                                "title": "PH-MK-DBCP",
                                "marker-symbol": "monument"
                            }
                        }, {
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [{{ $sponsor->long }}, {{ $sponsor->lat }}]
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

