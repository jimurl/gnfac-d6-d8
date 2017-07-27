<?php
$advisory = Drupal\node\Entity\Node::load(gnfac_current_advisory()) ;


$offsets = array(
0=>19,
1=>27,
2=>35,
3=>43

);



$offsets2 = array(
  0 => 20,
  1 => 29,
  2 => 38,
  3 => 47,
  4 => 56,
  5 => 65

);
$transforms2 = array( '4' => 'gnfac_cardinal_wind_dir');
$transforms = array( );

$rows = gnfac_fetch_rpt_file("/home/jimurl/public_html/data/BRID48.RPT" , $offsets,$transforms, TRUE, TRUE);
$rows2 = gnfac_fetch_rpt_file("/home/jimurl/public_html/data/RIDGE48.RPT" , $offsets2,$transforms2, TRUE, TRUE);
$time =   substr($rows[0]['data'][1], 0, -3 )  .':'. substr($rows[0]['data'][1], -3 );
$time2 =   substr($rows[0]['data'][1], 0, -3 )  .':'. substr($rows[0]['data'][1], -3 );
echo '<em>Recent Conditions at Bridger Lift:</em> &nbsp; &nbsp;   ';
echo 'Current Temp: '. $rows[0]['data'][2] . '  &nbsp;&nbsp;' ;
echo 'New Snow: '. $rows[0]['data'][3] ;
echo ' at '. $time  . ' o\'clock<br />';

echo '<em>Recent Conditions Bridger Ridgetop:</em> &nbsp; &nbsp;   ';
echo 'Wind Speed: '. $rows2[0]['data'][3] . '  &nbsp;&nbsp;' ;
echo 'Gust Max: '. $rows2[0]['data'][5] . '  &nbsp;&nbsp;' ;
echo 'Wind Direction: '. $rows2[0]['data'][4] . '  &nbsp;&nbsp;' ;
echo ' at '. $time2  . ' o\'clock<br />';

//dsm($rows);
$advisory_region_groups = $advisory->field_region_group_1->getValue() ;


foreach( $advisory_region_groups as $key2 => $region_group) {
    $fc = \Drupal\field_collection\Entity\FieldCollectionItem::load($region_group['value']);
    // $fc_applicable_data = $fc->field_applicable_regions->getValue();
  if ( $fc->field_applicable_regions->target_id == 23   ){  // 23 is the Bridgers
		$bottom_line = $fc->field_regional_discussion->summary;
  }
}



$bridgers_haz = ($advisory->field_bridger_range->value == '' ) ? 'None' : $advisory->field_bridger_range->value;

echo '<img src = "/images/hazard_ratings/'.$bridgers_haz.'.png" />  <br /> ';

echo '<div class ="bottom-line"><em>Bottom Line:</em>'. t($bottom_line) . '</div>';


 echo t('<em>Daily weather and avalanche log</em>');
 echo '<div class="weather_logs" style =" padding: 4px; border: 1px solid #9f9f9f;">';
 
 $daily_wx_view = views_embed_view('weather_log', 'block_1');
 echo  \Drupal::service('renderer')->render($daily_wx_view);
 
echo '</div>'; // end weather logs block

$bundle = 'advisory'; // or $bundle='my_bundle_type';
  $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', $bundle);
    $query->range(0,5);
    $query->sort('created', 'DESC');
    $advisory_ids = $query->execute();
		$advisories_hist = Drupal\node\Entity\Node::loadMultiple($advisory_ids);
		echo '<div class = "hazard-history"  >';
		foreach ( $advisories_hist as $advisory_hist ){
			echo '<div class = "hazard-day" style="width: 18%; display: inline-block;"> ';
			echo date ('D M j', $advisory_hist->created->value); echo '<br />';
			$hist_rating = ($advisory_hist->field_bridger_range->value == '') ? 'None' : $advisory_hist->field_bridger_range->value; 
			
			echo '<img src = "/images/hazard_ratings/simple/'. $hist_rating  .'.png" /><br />';
			echo $hist_rating;
			echo '</div>';
		}
		echo '</div>'; // end hazard history block
		
		// Start Photos, videos, snowpits, weather stations block
		echo '<div class="group">';
		echo '<div class = "two-col first photos" ><h3 class = "advisory sub-page">Photos</h3>';
		$sub_advisory_photos_view=views_embed_view('photos', 'block_3');
	  echo  \Drupal::service('renderer')->render($sub_advisory_photos_view). '</div>';
		
		echo '<div class = "two-col second videos" ><h3 class = "advisory sub-page">Videos</h3>';
		$sub_advisory_videos_view = views_embed_view('videos_list', 'block_1');
	  echo  \Drupal::service('renderer')->render($sub_advisory_videos_view). '</div>';
		
		echo '<div class = "two-col first snowpits" ><h3 class = "advisory sub-page">Snowpit Profiles</h3>';
		$sub_advisory_snowpits_view = views_embed_view('photos', 'block_2') ;
	  echo  \Drupal::service('renderer')->render($sub_advisory_snowpits_view). '</div>';
		
		echo '<div class = "two-col second wx-stations" ><h3 class = "advisory sub-page">Weather Stations</h3>';
		$sub_advisory_wx_view = views_embed_view('weather_stations', 'block_1','23');
	  echo  \Drupal::service('renderer')->render($sub_advisory_wx_view). '</div>';
		echo '</div>';
		

	  $dom = new DOMDocument();
	  //$dom->loadHTMLFile('http://forecast.weather.gov/MapClick.php?lon=-110.9213292039456&lat=45.80593584224556#.WXe_dooko6g');

		$url="http://forecast.weather.gov/MapClick.php?lon=-110.9213292039456&lat=45.80593584224556#.WXe_dooko6g";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$html = curl_exec($ch);
		curl_close($ch);
		$dom->loadHTML($html);
		$dataElement = $dom->getElementById('seven-day-forecast');
		
		$xml = $dataElement->ownerDocument->saveXML($dataElement);
		$xml = (str_replace( '<img src="' , '<img src="http://forecast.weather.gov/',$xml));
		kint($xml);
		
		echo($xml);
		
		
	//	$forecast_list = get_inner_html($dataElement);
	  //$dataElement->setAttribute('border', '3');

	  //$dataElement->removeChild($dataElement->firstChild);
	  //$dataElement->removeChild($dataElement->firstChild);
		
		
?>