<?php 

namespace Drupal\gnfac_d8\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "filter_double_p_gnfac_d8",
 *   module = "gnfac_d8",
 *   title = @Translation("Double paragraph Filter"),
 *   description = @Translation("REmove double paragraphs!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   weight = 12
 * )
 */
class DoubleP extends FilterBase {
  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
		
		$text =  preg_replace( '/<p>.{0,3}<\/p>/i' , '' , $text );
		
		//kint ($new_text);
    return new FilterProcessResult($text);
  }
 
}
