$( document ).ready(function() {
    // initialize the map on the "map" div with a given center and zoom
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);


// create a new tile layer

    var HERE_normalDay = L.tileLayer('https://1.base.maps.cit.api.here.com/maptile/2.1/maptile/newest/normal.day/13/4400/2680/256/png8?app_id={app_id}&app_code={app_code}', {
        attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
        subdomains: '1234',
        mapID: 'newest',
        app_id: 'Wmwb9vAqiz2jkFFEyENw',
        app_code: 'zvjLeRk3-QpLGK7iq0wiBg',
        base: 'base',

        maxZoom: 20,
        type: 'maptile',
        language: 'eng',
        format: 'png8',
        size: '256'
    });

// add the layer to the map
    mymap.addLayer(HERE_normalDay);
});

