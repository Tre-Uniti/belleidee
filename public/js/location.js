$(document).ready(function(){
    $(document.getElementById("localize")).click(function(){
        getLocation();
    });
    $(document.getElementById("global")).click(function(){
        stopWatch();
    });

    var watchId;
    var geoLoc;
    var listLocation = document.getElementById("listLocation");

    //Error Handler for Location
    function errorHandler(err) {
        if(err.code == 1) {
            alert("Error: Access is denied!");
        }

        else if( err.code == 2) {
            alert("Error: Position is unavailable!");
        }
    }

    //Get location of user
    function getLocation() {
        if (navigator.geolocation) {
            var options = {timeout: 60000};
            geoLoc = navigator.geolocation;
            watchId = geoLoc.watchPosition(showPosition, errorHandler, options);
            //update session on server
            
        }

        else {
            alert("Sorry, browser does not support geolocation!");
        }
    }

    //List their GPS coordinates
    function showPosition(position) {
        listLocation.innerHTML="<p>Content will be localized to:</p> Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
    }

    //Stop watching location and clear it from backend
    function stopWatch(){
        listLocation.innerHTML="You have switched to Global (no localized content)";
        geoLoc.clearWatch(watchId);
        //update session on server

    }
});


