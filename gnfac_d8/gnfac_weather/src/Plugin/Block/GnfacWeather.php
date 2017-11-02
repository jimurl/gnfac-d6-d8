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
    return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }

}