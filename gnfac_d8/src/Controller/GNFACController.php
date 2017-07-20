<?php

namespace Drupal\gnfac_d8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Example module.
 */
class GNFACController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function AdvisoryPage() {
    $element = array(
      '#markup' => 'Hello, Advisory',
    );
    return $element;
  }

}

