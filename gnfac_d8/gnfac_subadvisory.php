<?php
use Drupal\image\Entity\ImageStyle;
use Drupal\Component\Utility\Xss;
$advisory = gnfac_current_advisory('node') ;


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
echo '<div class = "current-weather"><em>Bridger Lift:</em> ';
echo 'Current Temp: '. $rows[0]['data'][2] . ' ' ;
echo 'New Snow: '. $rows[0]['data'][3] ;
echo ' at '. $time  . '<br />';

echo '<em>Bridger Ridge:</em> &nbsp; &nbsp;   ';
echo 'Wind Speed: '. $rows2[0]['data'][3] . ' &nbsp;' ;
echo 'Gust Max: '. $rows2[0]['data'][5] . ' &nbsp' ;
echo 'Wind Direction: '. $rows2[0]['data'][4] . ' &nbsp;' ;
echo ' at '. $time2  . '<br />';
echo '</div>'; // end of .current-weather

//dsm($rows);
$advisory_region_groups = $advisory->field_region_group_1->getValue() ;


foreach( $advisory_region_groups as $key2 => $region_group) {
    $fc = \Drupal\field_collection\Entity\FieldCollectionItem::load($region_group['value']);
    // $fc_applicable_data = $fc->field_applicable_regions->getValue();
  if ( $fc->field_applicable_regions->target_id == 23   ){  // 23 is the Bridgers
		$bottom_line = $fc->field_regional_discussion->summary;
		$options = $fc->field_problem_type->getSetting('allowed_values');
    $problem_type = $options [ $fc->field_problem_type->value ];
	
	//kint ($fc->field_regional_hazard_rating);
	$bridgers_haz = ($fc->field_regional_hazard_rating->value == '' ) ? 'None' : $fc->field_regional_hazard_rating->value;
		//kint($styled_image_url);
	}
}

$forecasters_choice_image = Drupal\node\Entity\Node::load(($advisory->field_choice_image->target_id));

if (isset ( $forecasters_choice_image->field_image_file )){
  $styled_image_url = ImageStyle::load('medium')->buildUrl($advisory->field_image_file->entity->getFileUri());
  $image_title = $forecasters_choice_image->title->value;
}
$fc_text = $advisory->field_forecasters_choice_text->value;

echo '<img src = "/images/hazard_ratings/'.$bridgers_haz.'.png" class ="hazard-image" />  <br /> ';
echo '<div class = "bottom-problem-container group">';
echo '<div class ="bottom-line first"><em>Bottom Line: </em>'. t($bottom_line) . '</div>';

 
echo '<div class = "problem-type second"><em>Problem Type: </em>'. $problem_type .'</em></div>';
echo '</div>';
 //echo t('<em>Daily weather and avalanche log</em>');
 echo '<div class="weather_logs" >';
 
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
		array_reverse($advisory_ids);
		$advisories_hist = Drupal\node\Entity\Node::loadMultiple($advisory_ids);
		echo '<div class = "hazard-history"  >';
		foreach ( $advisories_hist as $key => $advisory_hist ){
			$advisory_region_groups = $advisory_hist->field_region_group_1->getValue() ;
			$hist_rating[$key] = 'None'; // start with None,set to something , if it exists
      foreach( $advisory_region_groups as $key3 => $region_group) {	
	      $fc2 = \Drupal\field_collection\Entity\FieldCollectionItem::load($region_group['value']);
	      if ( in_array( array( 'target_id' => '23'), $fc2->field_applicable_regions->getValue())   ){  // 23 is the Bridgers
					$hist_rating[$key] = !isset($fc2->field_regional_hazard_rating->value ) ? 'None' : $fc2->field_regional_hazard_rating->value; 
			
				}
			}
			echo '<div class = "hazard-day"> ';
			echo date ('D M j', $advisory_hist->created->value); echo '<br />';
			
			echo '<img src = "/images/hazard_ratings/simple/'. $hist_rating[$key]  .'.png" /><br />';
			echo $hist_rating[$key];
			echo '</div>';
		}
		echo '</div>'; // end hazard history block
		
		// Start Photos, videos, snowpits, weather stations block
		echo '<div class="group media-blocks">';
		echo '<div class = "two-col first photos" ><h3 class = "advisory sub-page">Photos</h3>';
		$sub_advisory_photos_view=views_embed_view('photos', 'block_3');
	  echo  \Drupal::service('renderer')->render($sub_advisory_photos_view);
		echo '</div>';
				
		echo '<div class = "two-col second videos" ><h3 class = "advisory sub-page">Videos</h3>';
		$sub_advisory_videos_view = views_embed_view('videos_list', 'block_1');
	  echo  \Drupal::service('renderer')->render($sub_advisory_videos_view);
		echo '</div>';		
		echo '<div class = "two-col first snowpits" ><h3 class = "advisory sub-page">Snowpit Profiles</h3>';
		$sub_advisory_snowpits_view = views_embed_view('photos', 'block_2') ;
	  echo  \Drupal::service('renderer')->render($sub_advisory_snowpits_view);
		echo '</div>';
		
		echo '<div class = "two-col second wx-stations" ><h3 class = "advisory sub-page">Weather Stations</h3>';
		$sub_advisory_wx_view = views_embed_view('weather_stations', 'block_1','23');
	  echo  \Drupal::service('renderer')->render($sub_advisory_wx_view);
		echo '</div>';
		echo '</div>'; // end class 'group' and media-blocks
		

		// Weather forecast / Point forecast block  
		
		$url="http://forecast.weather.gov/MapClick.php?lon=-110.9213292039456&lat=45.80593584224556#.WXe_dooko6g";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$html = curl_exec($ch);
		curl_close($ch);
	  $dom = new DOMDocument();
		@$dom->loadHTML($html);
		$dataElement = $dom->getElementById('seven-day-forecast');
		
		$xml = $dataElement->ownerDocument->saveXML($dataElement);
		$xml = (str_replace( '<img src="' , '<img src="http://forecast.weather.gov/',$xml));
		
		echo '<div class = "group point-choice">';
		echo '<div class = "two-col first point-forecast" ><h3 class = "advisory sub-page">Weather Forecast</h3>';
		$final_text = preg_replace( '/<script type="text\/javascript">[\s\S]*<\/script>/' , '', $xml );
		echo Xss::filterAdmin($final_text);

		echo '</div>';
		
		// Forecaster's Choice
		
		//if 
		echo '<div class ="two-col second forecasters-choice"><h3 class = "advisory sub-page">Forecaster\'s Choice</h3>';
		echo '';
		echo '<div class ="forecasters-image title">'.'<img src ="'.$styled_image_url. '" /><br />';
		echo $image_title.'</div>';
		if ( isset( $fc_text)){
  		echo '<div class ="forecasters-text"><blockquote>'.$fc_text.'</blockquote></div>';
		}
		echo '</div>'; // end forecasters choice
		echo '</div>'; // end group point choice
		
		
?>