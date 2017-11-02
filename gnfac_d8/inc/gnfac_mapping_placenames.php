<?php
use Drupal\Core\Database\Database;

?>

<link rel="stylesheet" href="https://google-developers.appspot.com/maps/documentation/javascript/demos/demos.css">

    <script>
      function initMap() {
        var myLatLng = {lat: 45.3000 , lng: -110.6500}; 
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('placenames-map'), {
          center: myLatLng,
          scrollwheel: false,
          zoom: 9,
          mapTypeId: 'terrain'

        });
			  var bigblue = {
			    url: 'https://www.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/blue.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 34),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 34)
			  };

			  var shape = {
			    coords: [1, 1, 1, 20, 18, 20, 18, 1],
			    type: 'poly'
			  };
				

<?php
$connection = Database::getConnection();

$options = array();
$results = $connection->query('SELECT n.nid , nfd.title,nrflat.field_latitude_value, nrflon.field_longitude_value FROM node as n 
   join `node_field_data` as nfd on (n.nid=nfd.nid AND n.vid=nfd.vid) 
	 join `node_revision__field_latitude` as nrflat on ( n.nid = nrflat.entity_id AND n.vid = nrflat.revision_id) 
	 join `node_revision__field_longitude` as nrflon on ( n.nid = nrflon.entity_id AND n.vid = nrflon.revision_id) 

	 WHERE nfd.status = 1 and n.type = :type ', array(':type' => 'place_name'), $options);

//$nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'weather_station']);

$the_results = $results->fetchAll();
 
	foreach ( $the_results as $result ){
		//kint($result);
    if ( isset ( $result->field_latitude_value ) && isset( $result->field_longitude_value) ){ // if the user set the gmap location ( lat long ) on an older snowpit, this will still work. 
			//kint($result->field_latitude_value);
		//$latitude = $node->field_latitude;
		//$longitude = $node->field_longitude;
 
    ?>
     

    var LatLng<?php echo  $result->nid; ?> = {lat: <?php echo $result->field_latitude_value; ?> , lng: <?php echo $result->field_longitude_value; ?>}; 

        // Create a marker and set its position.
        var marker<?php echo  $result->nid; ?> = new google.maps.Marker({
          map: map,
          position: LatLng<?php echo  $result->nid; ?>,
          title: '<?php echo $result->title; ?>',
          icon: bigblue,
          shape: shape,
					url: '/node/<?php echo $result->nid; ?>'
        });
				google.maps.event.addListener(marker<?php echo  $result->nid; ?>, 'click', function() {
				        window.location.href = this.url;
				    });
      <?php  
    }
	}
	
?>
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIqPh8YaNVnoRZex5LfxLUPnYbFrCaQN0&callback=initMap" async defer></script>

