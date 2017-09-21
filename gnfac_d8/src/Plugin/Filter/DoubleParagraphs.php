<?php 

namespace Drupal\gnfac_d8\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "gnfac_d8_filter_double_p",
 *   module = "gnfac_d8",
 *   title = @Translation("Double Paragraph Filter"),
 *   description = @Translation("Rid yourself of double line breaks turning into double paras!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class RmDoublePara extends FilterBase {
  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    //$text = strtoupper($text);
    return new FilterProcessResult($text);
  }
  /**
   * {@inheritdoc}
   */
	
  public function tips($long = FALSE) {
    if ($long) {
      $output = '<h4>' . t('Using double paragraph stripper.') . '</h4>';
			$output .= '<p>' . t('Really cleans up the ugly') .'</p>';
      return $output;
		}else{
	$output = t('Removes double paragraphs left by MS word and other editors.');
    }
  }
	
	/*public function settingsForm(array $form, FormStateInterface $form_state) {
	    $form['gnfac_d8_avyhazard'] = array(
	      '#type' => 'checkbox',
	      '#title' => $this->t('Colorize Hazards?'),
	      '#default_value' => $this->settings['gnfac_d8_avyhazard'],
	      '#description' => $this->t('Display in colorizd format.'),
	    );
	    return $form;
	  } 
	*/	
}
?>