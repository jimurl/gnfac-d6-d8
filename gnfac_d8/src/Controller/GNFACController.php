<?php

namespace Drupal\gnfac_d8\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Provides route responses for the Example module.
 */
class GNFACController extends ControllerBase {
  /**
   * {@inheritdoc}
   */
	
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content() {
    $element = array(
			'#type' => 'markup',
      '#markup' => 'Hello, Advisory',
    );
    return $element;
  }

}

