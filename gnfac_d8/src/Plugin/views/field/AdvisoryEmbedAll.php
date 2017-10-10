<?php
 
/**
 * @file
 * Definition of Drupal\gnfac_d8\Plugin\views\field\AdvisoryEmbedAll
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
 * @ViewsField("advisory_embed_all")
 */
 
class AdvisoryEmbedAll extends FieldPluginBase {
 
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
    $options['formatter'] = array('default' => 'Display Images only from this Advisory',
		'images' => 'Images Only');
 
    return $options;
  }
 
  /**
   * Provide the options form.
	 * generally for use on the 
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $options = [];
    $options['default'] = 'Display Images from this Advisory';
		$options['images'] = 'Images Only';
		$options['images_snowpits'] = 'Display images + snowpits';
		$options['image_snowpits_videos'] = 'Display images + snowpits';
    $form['formatter'] = array(
      '#title' => $this->t('How much images/vids/snowpits display?'),
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
		//kint($node);
		return ;//'something';
  }
}