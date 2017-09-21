<?php


// default location:
$latitude = 46.2938;
$longitude = -112.01;
$zoom = 6;

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkTS9yPbgMagrzsAcRmnW_ljcFaXmUuN0" ></script>
<script src="/sites/all/modules/gnfac_d8/js/geographic-scripts.js" ></script>
<script>


function initialize() {
   var mapOptions = {
      center: new google.maps.LatLng(<?php echo $latitude ; ?>,<?php  echo $longitude; ?> ),
      zoom: <?php echo isset( $zoom ) ? $zoom : '9' ; ?> ,
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