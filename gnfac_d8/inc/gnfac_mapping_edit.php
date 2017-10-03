<?php


// default location:
$latitude = 45.25852;
$longitude = -110.4483;

?>
<script>


function initialize() {
   var mapOptions = {
      center: new google.maps.LatLng(<?php echo $latitude ; ?>,<?php  echo $longitude; ?> ),
      zoom: 8 ,
      mapTypeId: 'terrain'
   };

   map = new google.maps.Map(document.getElementById('google-map'), mapOptions);

   // This event detects a click on the map.
   google.maps.event.addListener(map, "click", function(event) {

      // Get lat lng coordinates.
      // This method returns the position of the click on the map.
      var lat = event.latLng.lat().toFixed(6);
      var lng = event.latLng.lng().toFixed(6);

      // Call createMarker() function to create a marker on the map.
      createMarker(lat, lng);

      // getCoords() function inserts lat and lng values into text boxes.
      getCoords(lat, lng);

   });
   <?php   /// If this is an existing node with already-set lat / long, place the marker in appropriate location
	 if ( $existing_node ){  ?>
		 createMarker(<?php echo $latitude ; ?>,<?php  echo $longitude; ?> );
		 <?php } ?>

}
google.maps.event.addDomListener(window, 'load', initialize);


// Add listeners to GNFAC form for latitude and longitude inputs
jQuery("[id^=edit-field-latitude]").blur(updatePosition);
jQuery("[id^=edit-field-longitude]").blur(updatePosition);


</script>
