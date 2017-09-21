/*
   Use this file for js functions related to conversions between geographic reference types
// UTM to Lat/Long, MGRS, etc
//  
*/

var map;
var marker;

// Function that creates the marker.
function createMarker(lat, lng) {

   // The purpose is to create a single marker, so
   // check if there is already a marker on the map.
   // With a new click on the map the previous
   // marker is removed and a new one is created.

   // If the marker variable contains a value
   if (marker) {
      // remove that marker from the map
      marker.setMap(null);
      // empty marker variable
      marker = "";
   }

   // Set marker variable with new location
   marker = new google.maps.Marker({
      position: new google.maps.LatLng(lat, lng),
      draggable: true, // Set draggable option as true
      map: map
   });


   // This event detects the drag movement of the marker.
   // The event is fired when left button is released.
   google.maps.event.addListener(marker, 'dragend', function() {
    
      // Updates lat and lng position of the marker.
      marker.position = marker.getPosition();

      // Get lat and lng coordinates.
      var lat = marker.position.lat().toFixed(6);
      var lng = marker.position.lng().toFixed(6);

      // Update lat and lng values into text boxes.
      getCoords(lat, lng);

   });
}

// This function updates text boxes values.
function getCoords(lat, lng) {

   // Reference input html element with id="lat".
   var coords_lat = document.getElementById('edit-field-latitude-0-value');

   // Update latitude text box.
   coords_lat.value = lat;

   // Reference input html element with id="lng".
   var coords_lng = document.getElementById('edit-field-longitude-0-value');

   // Update longitude text box.
   coords_lng.value = lng;
	 //
	 //

}

function updatePosition(){
  

    var lat = parseFloat(document.getElementById('edit-field-latitude-und-0-value').value);
    var lon = parseFloat(document.getElementById('edit-field-longitude-und-0-value').value);
    if (lat && lon) {
        //var newPosition = new google.maps.LatLng(lat,lon);
        //placeMarker(newPosition);
        createMarker(lat, lon);
				var latLng = new google.maps.LatLng(lat, lon);
				map.panTo(latLng);
    }
}



