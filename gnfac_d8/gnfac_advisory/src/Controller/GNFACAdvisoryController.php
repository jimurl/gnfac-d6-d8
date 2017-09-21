<?php

namespace Drupal\gnfac_advisory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class GNFACAdvisoryController extends ControllerBase {

  public function advisory_page() {
		
		$advisory = \Drupal\node\Entity\Node::load(gnfac_current_advisory()) ;
		$node_body = node_view($advisory, 'full');
		
		$new_title = str_replace( 'GNFAC Avalanche Advisory for ' ,'Current Advisory for ',$node_body['#node']->title->value);
		unset ($node_body['#node']->title);
		$message = render ( $node_body ) ;
    return ['#markup' => $message, '#title' => $new_title ];
  }
	
	public function sub_advisory_page($region = 'bridgers'){
		$title = 'Regional Conditions for ';
		switch ($region ){
			case 'bridgers':
		    $title .= 'Bridger Range';
		    $message = gnfac_advisory_bridgers();
			break;
			case 'northern-gallatin':
			  $title .= 'Northern Gallatin Range';
			  $message = gnfac_advisory_n_gallatin();
			break;
			case 'southern-gallatin':
			  $title .= 'Southern Gallatin Range';
			  $message = gnfac_advisory_s_gallatin();
			break;
			case 'northern-madison':
			  $title .= 'Northern Madison';
			  $message = gnfac_advisory_n_madison();
			break;
			case 'southern-madison':
			  $title .= 'Southern Madison';
			  $message = gnfac_advisory_s_madison();
			break;
			case 'lionhead':
			  $title .= 'Lionhead Range';
			  $message = gnfac_advisory_lionhead();
			break;
			case 'cooke-city':
			  $title .= 'Cooke City Area';
			  $message = gnfac_advisory_cooke();
			break;
		}
    return ['#markup' => $message, '#title' => $title];
		
	}

  public function test_page_with_theme($from, $to) {
    return [
      '#theme' => 'gnfac_advisory_page_theme',
      '#from' => $from,
      '#to' => $to,
    ];
  }
}
