mapboxgl.accessToken = 'pk.eyJ1IjoidHJldW5pdGkiLCJhIjoiY2lzd3I4eG5wMDZkajJva2gxaDRlMmZ1cSJ9.eCMHtRz8U82MkHThsnyafA';

var sites = {!! json_encode($sites->toArray()) !!};
$(document).ready(function(){

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/basic-v9',
        zoom: 13,
        center: [4.899, 52.372]
    });
});
