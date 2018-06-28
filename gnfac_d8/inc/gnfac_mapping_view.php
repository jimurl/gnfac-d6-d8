<?php

$node = \Drupal::routeMatch()->getParameter('node');

$longitude = ''; $latitude = '';

if ( isset ( $node->field_latitude->value ) && isset( $node->field_longitude->value) ){ // if the user set the gmap location ( lat long ) on an older snowpit, this will still work. 
		$latitude = $node->field_latitude->value;
		$longitude = $node->field_longitude->value;

?>


<link rel="stylesheet" href="https://google-developers.appspot.com/maps/documentation/javascript/demos/demos.css">

<div id="map" ></div>
    <script>
      function initMap() {
        var myLatLng = {lat: <?php echo $latitude  ?>, lng: <?php  echo $longitude; ?>};
        
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          scrollwheel: false,
          zoom: 10,
          mapTypeId: 'terrain'

        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
          map: map,
          position: myLatLng,
          title: '<?php echo $node->title->value; ?>'
        });
      }

    </script>
<?php
}
?>
