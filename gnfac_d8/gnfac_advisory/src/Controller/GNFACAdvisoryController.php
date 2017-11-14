<?php

namespace Drupal\gnfac_advisory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class GNFACAdvisoryController extends ControllerBase {

  public function advisory_page() {
		
		$advisory = \Drupal\node\Entity\Node::load(gnfac_current_advisory()) ;
		$node_body = node_view($advisory, 'full');
		
		$new_title = str_replace( 'GNFAC Avalanche Advisory for ' ,'Advisory for ',$node_body['#node']->title->value);
		unset ($node_body['#node']->title);
		$message = render ( $node_body ) ;
    return ['#markup' => $message, '#title' => $new_title ];
  }
	
	public function sub_advisory_page($region = 'bridgers'){
		switch ($region ){
			case 'bridgers':
		    $title = 'Bridgers';
		    $message = gnfac_advisory_bridgers($title);
			break;
			case 'northern-gallatin':
			  $title = 'Northern Gallatin';
			  $message = gnfac_advisory_n_gallatin($title);
			break;
			case 'southern-gallatin':
			  $title = 'Southern Gallatin';
			  $message = gnfac_advisory_s_gallatin($title);
			break;
			case 'northern-madison':
			  $title = 'Northern Madison';
			  $message = gnfac_advisory_n_madison($title);
			break;
			case 'southern-madison':
			  $title = 'Southern Madison';
			  $message = gnfac_advisory_s_madison($title);
			break;
			case 'lionhead':
			  $title = 'Lionhead Range';
			  $message = gnfac_advisory_lionhead($title);
			break;
			case 'cooke-city':
			  $title = 'Cooke City Area';
			  $message = gnfac_advisory_cooke($title);
			break;
		}
		$age =  (\Drupal::currentUser()->isAnonymous()) ? 3*60 : 0  ; // 3 minutes for anonymous users, 0 for logged in
		
    return ['#markup' => t($message), '#title' =>  'Regional Conditions for '.$title, 'max-age' => $age ];
	}

  public function test_page_with_theme($from, $to) {
    return [
      '#theme' => 'gnfac_advisory_page_theme',
      '#from' => $from,
      '#to' => $to,
    ];
  }
}
