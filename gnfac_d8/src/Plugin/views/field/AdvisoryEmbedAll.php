<?php
 
/**
 * @file
 * Definition of Drupal\gnfac_d8\Plugin\views\field\AdvisoryEmbedAll
 */
 
namespace Drupal\gnfac_d8\Plugin\views\field;
 
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\node\Entity\Node;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Url;
use Drupal\Core\Link;


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
		$options['images_videos'] = 'Display images +  videos, suppress titles';
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

		$target_ids_list = '';
		// First, get the image nodes together
		$image_ids = array();
		foreach( $node->field_images as $image ){
			$target_ids_list .= ' '.$image->target_id;
			$image_ids[] = $image->target_id;
		}
		$image_nodes = \Drupal\node\Entity\Node::loadMultiple($image_ids);
		
		// Second, collect the video nodes
		$video_ids = array();
		foreach( $node->field_attached_videos as $video ){
			if ( $video->target_id ){
				$video_ids[] = $video->target_id;
			}
		}
		$video_nodes = \Drupal\node\Entity\Node::loadMultiple($video_ids);
		$image_size =  $this->options['formatter'] == 'images_videos'  ? 'medium' :'small_plus_150';
		if ( $this->options['formatter'] == 'images_videos' ){
			$image_class =  'field-content';
		  $image_class2 = '';
			$image_class3 = '';
		
		}else {  $image_class = 'image-node'; $image_class2 = 'image-nodes-list'; $image_class3 = 'archive-page-image'; }
		if ( count ( $image_nodes ) || count ( $video_nodes )){
			$container = '<div class ="'. $image_class2 .'">'; $close_container = "</div>"; $styled_image_urls = '';
		  foreach($image_nodes as $image_node){
		  	$styled_image_urls .= '<div class ="'. $image_class .'">';
				$link_text = '<img src ="' . ImageStyle::load($image_size)->buildUrl($image_node->field_image_file->entity->getFileUri()) . '" class = "'. $image_class3 .'" />' ;
				if ( $this->options['formatter'] <> 'images_videos' ){   /// this section is for the advisory archive page
				  $link_text .= '<br/>' . $image_node->title->value ;
			    $url = Url::fromRoute('entity.node.canonical',array( 'node' => $image_node->nid->value));
				}else{       
					//kint ( $node->field_hot_item_link->uri )        ;                                    /// and this section is used in GNFAC News 
			    $url = Url::fromUri(  $node->field_hot_item_link->uri  );
			    //$url = Url::fromRoute('entity.node.canonical',array( 'node' => $image_node->nid->value));
					
				}
		  	$image_node_link = Link::fromTextAndUrl(t($link_text), $url);
			  $image_node_link = $image_node_link->toRenderable(); 
					
				$styled_image_urls .= render ($image_node_link) . check_markup(  '' , 'basic_html');
				
				$styled_image_urls .= '</div>';
		  }
			foreach( $video_nodes as $video_node ){
				
				$styled_image_urls .= '<div class ="image-node">';
				$styled_image_urls .=  gnfac_display_video( gnfac_video_extract_string($video_node->field_video_url->uri), 'image') ;
				if ( $this->options['formatter'] <> 'images_videos' ){
					  $url = Url::fromUri('https://www.youtube.com/watch?v='.gnfac_video_extract_string($video_node->field_video_url->uri));
					
					  $video_node_link = Link::fromTextAndUrl(t($video_node->title->value), $url);
					  $video_node_link = $video_node_link->toRenderable();
					  $styled_image_urls .= render ($video_node_link) . check_markup(  '' , 'basic_html');
				}
				$styled_image_urls .= '</div>';
			}
		}
		return t($container . $styled_image_urls .$close_container) ;
  }
}