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
                    <h1>Contact Us</h1>
                    <h3>{{ $beacon->name }}</h3>
                </header>
            </div>
            <div class = indexContent>
                @if(isset($beacon->phone))
                    <div>Phone: {{ $beacon->phone }}</div>
                @endif
                @if(isset($beacon->website))
                    <div><a href = "{{ $beacon->website }}" target="_blank">Website</a></div>
                    @endif
            </div>
            </div>

        <div class = "contentCard">
            <div id='map'></div>
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

    </article>


@stop

