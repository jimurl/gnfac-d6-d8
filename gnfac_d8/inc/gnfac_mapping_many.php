<?php
use Drupal\Core\Database\Database;
use Drupal\field_collection\Entity\FieldCollectionItem;

		$advisory = Drupal\node\Entity\Node::load(gnfac_current_advisory('nid'));
		
		foreach ($advisory->field_region_group_1 as $key => $region_group ){
			$fc_ids[$key] = $region_group->getValue()	;		
			$fc = FieldCollectionItem::load($fc_ids[$key]['value']);
		  // calculate hazard colors
			  // Bridgers First
	  if ( in_array( array ( 'target_id'=> 23 ),  $fc->field_applicable_regions->getValue('target_id')) ){
			$bridger_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }
		// No. Gallatin
	  if ( in_array( array ( 'target_id'=> 25 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$no_gall_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }		
		// So. Gallatin
	  if ( in_array( array ( 'target_id'=> 27 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$so_gall_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }		
		// Lionhead Range
	  if ( in_array( array ( 'target_id'=> 29 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$lionhead_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }		
		// No Madison
	  if ( in_array( array ( 'target_id'=> 24 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$no_madison_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }	
		// So. Madison 
	  if ( in_array( array ( 'target_id'=> 26 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$so_madison_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }	
		// Cooke City
	  if ( in_array( array ( 'target_id'=> 28 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$cooke_hazard_color = $fc->field_regional_hazard_rating->value ? $fc->field_regional_hazard_rating->value : 'None' ;
    }	
	}		
		$None = '#000000';
		$Extreme = '#000000';
		$High = '#ec1d24';
		$Considerable = '#f7941d';
		$Moderate = '#fdf200';
		$Low = '#50b849';



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
			    url: 'https://www.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/blue.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image435 = {
			    url: 'https://www.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/orange.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image436 = {
			    url: 'https://www.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/green.png',
			    // This marker is 20 pixels wide by 32 pixels high.
			    size: new google.maps.Size(20, 32),
			    // The origin for this image is (0, 0).
			    origin: new google.maps.Point(0, 0),
			    // The anchor for this image is the base of the flagpole at (0, 32).
			    anchor: new google.maps.Point(0, 32)
			  };
			  var image437 = {
			    url: 'https://www.mtavalanche.com/sites/all/modules/gnfac_d8/inc/markers/purple.png',
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
			// Define the LatLng coordinates for the polygon's path.
			  var bridgersoutline = [
					{lng:  -110.929413, lat: 45.706179},
					{lng:  -110.893707, lat: 45.777102},
					{lng:  -110.877228, lat: 45.849847},
					{lng:  -110.92392, lat: 45.958788},
					{lng:  -111.009064, lat: 45.996962},
					{lng:  -111.053009, lat: 46.040829},
					{lng:  -111.11618, lat: 46.044642},
					{lng:  -111.105194, lat: 46.014131},
					{lng:  -111.066742, lat: 45.979787},
					{lng:  -111.063995, lat: 45.903389},
					{lng:  -110.975876, lat: 45.833584},
					{lng:  -111.015701, lat: 45.807743},
					{lng:  -111.032181, lat: 45.791467},
					{lng:  -111.004715, lat: 45.765607},
					{lng:  -111.008835, lat: 45.729191},
					{lng:  -110.984116, lat: 45.706179},
					{lng:  -110.929413, lat: 45.706179}
			  ];

			  // Construct the polygon.
			  var bridgers = new google.maps.Polygon({
			    paths: bridgersoutline,
			    strokeColor: '#000000',
				  strokeOpacity: 0.6,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$bridger_hazard_color; ?>',
				  fillOpacity: 0.25
			  });
			  bridgers.setMap(map);
				
				var nmadisonoutline = [
				  { lng: -111.18871, lat: 45.34732},
				  { lng: -111.19283, lat: 45.37144},
				  { lng: -111.21068, lat: 45.38301},
				  { lng: -111.25875, lat: 45.43989},
				  { lng: -111.27935, lat: 45.44568},
				  { lng: -111.30956, lat: 45.4476},
				  { lng: -111.35625, lat: 45.42833},
				  { lng: -111.37822, lat: 45.40905},
				  { lng: -111.39745, lat: 45.39459},
				  { lng: -111.432953, lat: 45.390735},
				  { lng: -111.472778, lat: 45.407128},
				  { lng: -111.505737, lat: 45.389771},
				  { lng: -111.48946, lat: 45.34732},
				  { lng: -111.48397, lat: 45.32801},
				  { lng: -111.49358, lat: 45.30676},
				  { lng: -111.49495, lat: 45.28068},
				  { lng: -111.50594, lat: 45.26618},
				  { lng: -111.50457, lat: 45.22654},
				  { lng: -111.50457, lat: 45.19945},
				  { lng: -111.50594, lat: 45.18494},
				  { lng: -111.494751, lat: 45.141367},
				  { lng: -111.434326, lat: 45.125867},
				  { lng: -111.39196, lat: 45.12296},
				  { lng: -111.345062, lat: 45.117146},
				  { lng: -111.29445, lat: 45.11326},
				  { lng: -111.27385, lat: 45.13361},
				  { lng: -111.26699, lat: 45.15008},
				  { lng: -111.25325, lat: 45.19268},
				  { lng: -111.26287, lat: 45.22364},
				  { lng: -111.26287, lat: 45.27681},
				  { lng: -111.20656, lat: 45.31159},
				  { lng: -111.18871, lat: 45.34732}
				];
			  var nmadison = new google.maps.Polygon({
			    paths: nmadisonoutline,
			    strokeColor: '#000000',
				  strokeOpacity: 0.6,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$no_madison_hazard_color; ?>',
				  fillOpacity: 0.25
			  });
			  nmadison.setMap(map);

				var ngallatinoutline = [
  { lng: -110.940147, lat: 45.619801},
  { lng: -110.838524, lat: 45.561179 },
  { lng: -110.800072, lat: 45.537137 },
  { lng: -110.765739, lat: 45.469762 },
  { lng: -110.798698, lat: 45.376267 },
  { lng: -110.844017, lat: 45.341528 },
  { lng: -110.867363, lat: 45.316426 },
  { lng: -110.890709, lat: 45.277786 },
  { lng: -110.920921, lat: 45.243953 },
  { lng: -110.952507, lat: 45.226546 },
  { lng: -110.993603, lat: 45.191232 },
  { lng: -111.009396, lat: 45.168968 },
  { lng: -111.058834, lat: 45.131196 },
  { lng: -111.089046, lat: 45.128773 },
  { lng: -111.147411, lat: 45.119568 },
  { lng: -111.196163, lat: 45.118599 },
  { lng: -111.230495, lat: 45.159769 },
  { lng: -111.233929, lat: 45.214455 },
  { lng: -111.238049, lat: 45.255555 },
  { lng: -111.212643, lat: 45.27537 },
  { lng: -111.19479, lat: 45.291313 },
  { lng: -111.174877, lat: 45.309183 },
  { lng: -111.161831, lat: 45.333806 },
  { lng: -111.159771, lat: 45.357453 },
  { lng: -111.168697, lat: 45.373855 },
  { lng: -111.174877, lat: 45.388806 },
  { lng: -111.189297, lat: 45.392182 },
  { lng: -111.205776, lat: 45.402307 },
  { lng: -111.218136, lat: 45.41484 },
  { lng: -111.229809, lat: 45.453388 },
  { lng: -111.261394, lat: 45.482281 },
  { lng: -111.259335, lat: 45.493352 },
  { lng: -111.244915, lat: 45.508753 },
  { lng: -111.20509, lat: 45.521744 },
  { lng: -111.136425, lat: 45.532808 },
  { lng: -111.104839, lat: 45.553006 },
  { lng: -111.076, lat: 45.572236 },
  { lng: -111.049908, lat: 45.587615 },
  { lng: -110.980556, lat: 45.607793 },
  { lng: -110.940147, lat: 45.619801 }
				];
			  var ngallatin = new google.maps.Polygon({
			    paths: ngallatinoutline,
			    				  strokeColor: '#000000',
				  strokeOpacity: 0.6,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$no_gall_hazard_color; ?>',
				  fillOpacity: 0.25
			  });
			  ngallatin.setMap(map);
				
				var lionheadoutline = [
{ lng: -111.239525, lat: 44.734052},
{ lng: -111.266991, lat: 44.742832},
{ lng: -111.280724, lat: 44.775011},
{ lng: -111.284843, lat: 44.787683},
{ lng: -111.28759, lat: 44.803276},
{ lng: -111.302696, lat: 44.820812},
{ lng: -111.312309, lat: 44.829578},
{ lng: -111.331535, lat: 44.840291},
{ lng: -111.356255, lat: 44.835422},
{ lng: -111.372734, lat: 44.8325},
{ lng: -111.398827, lat: 44.8325},
{ lng: -111.418053, lat: 44.824708},
{ lng: -111.427666, lat: 44.809122},
{ lng: -111.429039, lat: 44.78281},
{ lng: -111.429039, lat: 44.758436},
{ lng: -111.423546, lat: 44.73015},
{ lng: -111.420799, lat: 44.713562},
{ lng: -111.394707, lat: 44.691112},
{ lng: -111.374107, lat: 44.679395},
{ lng: -111.346642, lat: 44.664746},
{ lng: -111.324669, lat: 44.661816},
{ lng: -111.297203, lat: 44.679395},
{ lng: -111.293083, lat: 44.696969},
{ lng: -111.251884, lat: 44.709658},
{ lng: -111.239525, lat: 44.734052}
				];
			  var lionhead = new google.maps.Polygon({
			    paths: lionheadoutline,
			    				  strokeColor: '#000000',
				  strokeOpacity: 0.6,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$lionhead_hazard_color; ?>',
				  fillOpacity: 0.25
			  });
			  lionhead.setMap(map);
				
				var cookeoutline = [
					{ lng: -109.867607, lat: 45.017244},
					{ lng: -109.884087, lat: 45.033744},
					{ lng: -109.896446, lat: 45.069641},
					{ lng: -109.892326, lat: 45.090005},
					{ lng: -109.896446, lat: 45.107454},
					{ lng: -109.896446, lat: 45.124898},
					{ lng: -109.908806, lat: 45.138461},
					{ lng: -109.929405, lat: 45.150085},
					{ lng: -109.954124, lat: 45.150085},
					{ lng: -109.973351, lat: 45.149116},
					{ lng: -110.014549, lat: 45.146211},
					{ lng: -110.021416, lat: 45.123929},
					{ lng: -110.021416, lat: 45.091944},
					{ lng: -110.020042, lat: 45.070611},
					{ lng: -110.004936, lat: 45.0483},
					{ lng: -110.004936, lat: 45.032774},
					{ lng: -110.004936, lat: 45.011419},
					{ lng: -109.991203, lat: 44.989084},
					{ lng: -109.955498, lat: 44.985199},
					{ lng: -109.901939, lat: 44.991027},
					{ lng: -109.860741, lat: 44.990056},
					{ lng: -109.867607, lat: 45.017244}
				];
				var cooke = new google.maps.Polygon({
				  paths: cookeoutline,
				  strokeColor: '#000000',
				  strokeOpacity: 0.6,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$cooke_hazard_color; ?>',
				  fillOpacity: 0.25
				});
				cooke.setMap(map);
				var smadisonoutline = [
				            { lng: -111.427666, lat: 44.858789 },
				            { lng: -111.446892, lat: 44.882147 },
				            { lng: -111.452385, lat: 44.914249 },
				            { lng: -111.453758, lat: 44.932724 },
				            { lng: -111.452385, lat: 44.959939 },
				            { lng: -111.444145, lat: 44.991027 },
				            { lng: -111.456505, lat: 45.009477 },
				            { lng: -111.467491, lat: 45.033744 },
				            { lng: -111.50045, lat: 45.060912 },
				            { lng: -111.49633, lat: 45.101638 },
				            { lng: -111.478477, lat: 45.115208 },
				            { lng: -111.449638, lat: 45.116177 },
				            { lng: -111.401573, lat: 45.111331 },
				            { lng: -111.339775, lat: 45.105516 },
				            { lng: -111.282097, lat: 45.101638 },
				            { lng: -111.258751, lat: 45.108423 },
				            { lng: -111.235405, lat: 45.101638 },
				            { lng: -111.212059, lat: 45.068671 },
				            { lng: -111.16674, lat: 45.046359 },
				            { lng: -111.100822, lat: 45.016273 },
				            { lng: -111.08709, lat: 44.994911 },
				            { lng: -111.088463, lat: 44.959939 },
				            { lng: -111.059624, lat: 44.940501 },
				            { lng: -111.065117, lat: 44.903551 },
				            { lng: -111.065117, lat: 44.876309 },
				            { lng: -111.080223, lat: 44.84808 },
				            { lng: -111.095329, lat: 44.824708 },
				            { lng: -111.125542, lat: 44.806199 },
				            { lng: -111.165367, lat: 44.810096 },
				            { lng: -111.210686, lat: 44.815941 },
				            { lng: -111.246391, lat: 44.825682 },
				            { lng: -111.284843, lat: 44.846133 },
				            { lng: -111.319176, lat: 44.86755 },
				            { lng: -111.346642, lat: 44.877282 },
				            { lng: -111.376854, lat: 44.873389 },
				            { lng: -111.427666, lat: 44.858789 }
				];
				var smadison = new google.maps.Polygon({
				  paths: smadisonoutline,
				  strokeColor: '#000000',
				  strokeOpacity: 0.8,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$so_madison_hazard_color; ?>',
				  fillOpacity: 0.35
				});
				smadison.setMap(map);
				
				var sgallatinoutline = [
				{ lng: -111.194206, lat: 45.101638 },
				{ lng: -111.147514, lat: 45.105516 },
				{ lng: -111.089836, lat: 45.114238 },
				{ lng: -111.017052, lat: 45.128773 },
				{ lng: -110.971733, lat: 45.150085 },
				{ lng: -110.904442, lat: 45.174293 },
				{ lng: -110.874229, lat: 45.169452 },
				{ lng: -110.848137, lat: 45.151053 },
				{ lng: -110.824791, lat: 45.106485 },
				{ lng: -110.800072, lat: 45.081279 },
				{ lng: -110.784966, lat: 45.0483 },
				{ lng: -110.768486, lat: 45.023068 },
				{ lng: -110.780846, lat: 44.996854 },
				{ lng: -110.783592, lat: 44.961883 },
				{ lng: -110.768486, lat: 44.926891 },
				{ lng: -110.769859, lat: 44.888958 },
				{ lng: -110.771233, lat: 44.854895 },
				{ lng: -110.773979, lat: 44.812045 },
				{ lng: -110.793205, lat: 44.781835 },
				{ lng: -110.817924, lat: 44.754535 },
				{ lng: -110.856377, lat: 44.743807 },
				{ lng: -110.941521, lat: 44.79548 },
				{ lng: -110.964867, lat: 44.828604 },
				{ lng: -111.007439, lat: 44.865603 },
				{ lng: -111.033531, lat: 44.903551 },
				{ lng: -111.041771, lat: 44.943417 },
				{ lng: -111.05825, lat: 44.969656 },
				{ lng: -111.069237, lat: 44.990056 },
				{ lng: -111.071983, lat: 45.023068 },
				{ lng: -111.100822, lat: 45.041508 },
				{ lng: -111.154381, lat: 45.066731 },
				{ lng: -111.188713, lat: 45.07643 },
				{ lng: -111.194206, lat: 45.101638 }
				];
				var sgallatin = new google.maps.Polygon({
				  paths: sgallatinoutline,
				  strokeColor: '#000000',
				  strokeOpacity: 0.8,
				  strokeWeight: 2,
				  fillColor: '<?php echo $$so_gall_hazard_color; ?>',
				  fillOpacity: 0.35
				});
				sgallatin.setMap(map);
<?php
$connection = Database::getConnection();

$options = array();
$results = $connection->query('SELECT n.nid , 
nfd.title,
nrflat.field_latitude_value, 
nrflon.field_longitude_value , 
nrfar.field_advisory_region_target_id, 
nrfwst.field_weather_station_type_target_id, 
nrfrwd.field_recent_wx_data_value,
nrfelv.field_elevation_value
   FROM node as n 
   join `node_field_data` as nfd on (n.nid=nfd.nid AND n.vid=nfd.vid) 
	 join `node_revision__field_latitude` as nrflat on ( n.nid = nrflat.entity_id AND n.vid = nrflat.revision_id) 
	 join `node_revision__field_longitude` as nrflon on ( n.nid = nrflon.entity_id AND n.vid = nrflon.revision_id) 
	 join `node_revision__field_advisory_region` as nrfar on ( n.nid = nrfar.entity_id AND n.vid = nrfar.revision_id) 
 	 join `node_revision__field_weather_station_type` as nrfwst on ( n.nid = nrfwst.entity_id AND n.vid = nrfwst.revision_id) 
   left join `node_revision__field_recent_wx_data` as nrfrwd on (n.nid = nrfrwd.entity_id AND n.vid = nrfrwd.revision_id)
   left join `node_revision__field_elevation` as nrfelv on (n.nid = nrfelv.entity_id AND n.vid = nrfelv.revision_id)
	 WHERE nfd.status = 1 and n.type = :type ', array(':type' => 'weather_station'), $options);

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
          icon: image<?php echo $result->field_weather_station_type_target_id; ?>,
          shape: shape,
					url: '/node/<?php echo $result->nid; ?>'
        });
			  var infowindow<?php echo $result->nid; ?> = new google.maps.InfoWindow({
					content: 'Station: <a href = "/node/<?php echo $result->nid; ?>"><?php echo $result->title; ?></a><br />Elevation: <?php echo $result->field_elevation_value; echo $result->field_recent_wx_data_value ; ?> '
			   });
				google.maps.event.addListener(marker<?php echo  $result->nid; ?>, 'click', function() {
					infowindow<?php echo $result->nid; ?>.open(map, marker<?php echo $result->nid; ?>);
				    });

				
      <?php  
    }
	}
	
?>
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIqPh8YaNVnoRZex5LfxLUPnYbFrCaQN0&callback=initMap" async defer></script>

