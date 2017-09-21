<?php 

namespace Drupal\gnfac_d8\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "filter_gnfac_d8",
 *   module = "gnfac_d8",
 *   title = @Translation("Avy Hazard Filter"),
 *   description = @Translation("Convert capitalized hazard names to colorized!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class AvyHazardFilter extends FilterBase {
  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $text = preg_replace('/([\s?>&])LOW([\s?<&])/', '$1<span style = "background-color: #4db748; font-weight: bolder;"><span class = "avyhzrd-low">LOW</span></span>$2', $text);
    $text = preg_replace('/([\s?>&])MODERATE([\s?<&])/', '$1<span style = "background-color: #fef102; font-weight: bolder;"><span class = "avayhzrd-moderate">MODERATE</span></span>$2', $text);
    $text = preg_replace('/([\s?>&])HIGH([\s?<&])/', '$1<span style = "background-color: #ee1d23; font-weight: bolder;"><span class = "avayhzrd-high">HIGH</span></span>$2', $text);
    $text = preg_replace('/([\s?>&])CONSIDERABLE([\s?<&])/', '$1<span style = "background-color: #f8931d; font-weight: bolder;"><span class = "avayhzrd-considerable">CONSIDERABLE</span></span>$2', $text);
    $text = preg_replace('/([\s?>&])EXTREME([\s?<&])/', '$1<span style = "background-color: #000000; font-weight: bolder; color: #ffffff;"><span class = "avayhzrd-extreme">EXTREME</span></span>$2', $text);
    $text = preg_replace('/([\s?>&])AVALANCHE WARNING([\s?<&])/', '$1<span style = "background-color: #ee1d23; font-weight: bolder; color: #ffffff;"><span class = "avayhzrd-extreme">AVALANCHE WARNING</span></span>$2', $text);
		
    return new FilterProcessResult($text);
  }
  /**
   * {@inheritdoc}
   */
	
  public function tips($long = FALSE) {
    if ($long) {
      $output = '<h4>' . t('Using AVY HAZARD ratings filter') . '</h4>';
      $output .= '<p>' . t('Avy Hazards are UPPER CASE terms such as LOW , MEDIUM, HIGH, that are colorized to show the color of the hazard.') . '</p>';
			$output .= '<p>' . t('Also includes AVALANCHE HAZARD colorizing. ( black, red )') .'</p>';
		}else{
	    $output = t('Avalanche Hazard Rating colorizer and links to the offical chart.');
    }
    return $output;
		
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
