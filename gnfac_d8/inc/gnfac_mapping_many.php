<?php
use Drupal\Core\Database\Database;

?>

<link rel="stylesheet" href="https://google-developers.appspot.com/maps/documentation/javascript/demos/demos.css">

    <script>
      function initMap() {
        var myLatLng = {lat: 45.3000 , lng: -110.800}; 
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('weather-stations-map'), {
          center: myLatLng,
          scrollwheel: false,
          zoom: 8,
          mapTypeId: 'terrain'

        });
			  var image434 = {
			    url: 'https://www.d8.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/small/blue.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image435 = {
			    url: 'https://www.d8.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/small/orange.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image436 = {
			    url: 'https://www.d8.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/small/green.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image437 = {
			    url: 'https://www.d8.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/small/purple.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var shape = {
			    coords: [1, 1, 1, 20, 18, 20, 18, 1],
			    type: 'poly'
			  };
				

<?php
$connection = Database::getConnection();

$options = array();
$results = $connection->query('SELECT n.nid , nfd.title,nrflat.field_latitude_value, nrflon.field_longitude_value , nrfar.field_advisory_region_target_id, nrfwst.field_weather_station_type_target_id FROM node as n 
   join `node_field_data` as nfd on (n.nid=nfd.nid AND n.vid=nfd.vid) 
	 join `node_revision__field_latitude` as nrflat on ( n.nid = nrflat.entity_id AND n.vid = nrflat.revision_id) 
	 join `node_revision__field_longitude` as nrflon on ( n.nid = nrflon.entity_id AND n.vid = nrflon.revision_id) 
	 join `node_revision__field_advisory_region` as nrfar on ( n.nid = nrfar.entity_id AND n.vid = nrfar.revision_id) 
 	 join `node_revision__field_weather_station_type` as nrfwst on ( n.nid = nrfwst.entity_id AND n.vid = nrfwst.revision_id) 

	 WHERE nfd.status = 1 and n.type = :type ', array(':type' => 'weather_station'), $options);

//$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'weather_station']);

$the_results = $results->fetchAll();
//kint($the_results);

 
	foreach ( $the_results as $result ){
		//kint($result);
    if ( isset ( $result->field_latitude_value ) && isset( $result->field_longitude_value) ){ // if the user set the gmap location ( lat long ) on an older snowpit, this will still work. 
			//kint($result->field_latitude_value);
		//$latitude = $node->field_latitude;
		//$longitude = $node->field_longitude;
 
    ?>
     

    var LatLng<?php echo  $result->nid; ?> = {lat: <?php echo $result->field_latitude_value;  ?> , lng: <?php echo $result->field_longitude_value; ?>}; 

        // Create a marker and set its position.
        var marker<?php echo  $result->nid; ?> = new google.maps.Marker({
          map: map,
          position: LatLng<?php echo  $result->nid; ?>,
          title: '<?php echo $result->title; ?>',
          icon: image<?php echo $result->field_weather_station_type_target_id; ?>,
          shape: shape,
					url: '/advisory/bridgers'
        });

      <?php  
    }
	}  
?>
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIqPh8YaNVnoRZex5LfxLUPnYbFrCaQN0&callback=initMap" async defer></script>