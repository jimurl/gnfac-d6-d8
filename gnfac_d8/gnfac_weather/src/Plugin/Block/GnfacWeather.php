<?php

namespace Drupal\gnfac_weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "gnfac_weather",
 *   admin_label = @Translation("GNFAC Weather"),
 *   category = @Translation("gnfac"),
 * )
 */
class GnfacWeather extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
		$markup = '';
		
		switch ( $node->field_weather_station_type->target_id ){
			case '434':
	    if ( !$node->field_nrcs_snotel_site->value) return;
			$markup .= gnfac_fetch_nrcs_snotel_data( $node->field_nrcs_snotel_site->value );
        
	    break;
			case '435':  // gnfac weather station
			  if ( !$node->field_data_garrison_id->value ) return ;
			  $markup .=  gnfac_fetch_hobo_file( $node->field_data_garrison_id->value );
			break;
			case '436'; // ski area weather station
			
			break;  
	
	  }
    return array(
      '#markup' => $this->t($markup),
    );
  }

}