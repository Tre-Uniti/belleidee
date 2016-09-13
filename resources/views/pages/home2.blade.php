<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title></title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.23.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        #map {   width:100%; }

    </style>

</head>
<body>
<div class = "contentCard">
    <div id='map' style='width: 300px; height: 200px;'></div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoidHJldW5pdGkiLCJhIjoiY2lzd3I4eG5wMDZkajJva2gxaDRlMmZ1cSJ9.eCMHtRz8U82MkHThsnyafA';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            zoom: 13,
            center: [{{ $beacon->long }}, {{ $beacon->lat }}]
        });
    </script>

</div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidHJldW5pdGkiLCJhIjoiY2lzd3I4eG5wMDZkajJva2gxaDRlMmZ1cSJ9.eCMHtRz8U82MkHThsnyafA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/basic-v9',
        zoom: 13,
        center: [4.899, 52.372]
    });

    var layerList = document.getElementById('menu');
    var inputs = layerList.getElementsByTagName('input');

    function switchLayer(layer) {
        var layerId = layer.target.id;
        map.setStyle('mapbox://styles/mapbox/' + layerId + '-v9');
    }

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].onclick = switchLayer;
    }
</script>

</body>
</html>
