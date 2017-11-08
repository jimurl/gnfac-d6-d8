<?php
 
/**
 * @file
 * Definition of Drupal\gnfac_d8\Plugin\views\field\AdvisoryEmbedVideo
 */
 
namespace Drupal\gnfac_d8\Plugin\views\field;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;


/**
 * Field handler to display embeded video
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("advisory_embed_video")
 */
 
class AdvisoryEmbedVideo extends FieldPluginBase {
 
  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }
 
  /**
   * Define the available options
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['formatter'] = array('default' => 'Default Video Embedded format',
		'large' => '420px wide Large Video Embedded format');
 
    return $options;
  }
 
  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $options = [];
    $options['default'] = 'Default Video Embedded format';
		$options['large'] = '420px Video Embedded format';
		$options['medium'] = '330px Video embedded format';
		$options['image'] = 'Static image of default video image 300px width';
    $form['formatter'] = array(
      '#title' => $this->t('What video display format?'),
      '#type' => 'select',
      '#default_value' => $this->options['formatter'],
      '#options' => $options,
    );
 
    parent::buildOptionsForm($form, $form_state);
  }
 
  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $values->_entity;
		if ( ! $node->field_video_url ) return;
		$video_uri = $node->field_video_url->getValue();
		return $this->t( gnfac_display_video( gnfac_video_extract_string( $video_uri[0]['uri'] ) , $this->options['formatter'] ) );
  }
}