<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Images.
 *
 * @MigrateSource(
 *   id = "gnfac_blog"
 * )
 */
class GnfacBlog extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'blog', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['field_attached_images'] = $this->t('attached image nodes');
		$fields['field_attached_videos'] = $this->t('Youtube video URLs');
		$fields['alias'] = $this->t('Path alias');
		$fields['attached_fid'] = $this->t('File ID of a file attached to the page');

		
    return $fields;
  }
  /**
   * {@inheritdoc}
   */
  public function baseFields() {
    $fields = [
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Node revision ID'),
			'type' => $this->t('Node type'),
      'title' => $this->t('Node Title'),
      'uid' => $this->t('Author user ID'),
      'created' => $this->t('Created date UNIX timestamp'),
      'changed' => $this->t('Updated date UNIX timestamp'),
      'status' => $this->t('Node publication status'),
    ];
    return $fields;
  }
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'nid' => [
        'type' => 'integer',
				'alias' => 'node',
      ],
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Get Node revision body and teaser/summary value.
    $revision_data = $this->select('node_revisions')
      ->fields('node_revisions', ['body', 'teaser'])
      ->condition('nid', $row->getSourceProperty('nid'), '=')
      ->condition('vid', $row->getSourceProperty('vid'), '=')
      ->execute()
      ->fetchAll();
    $row->setSourceProperty('body', $revision_data[0]['body']);
    $row->setSourceProperty('teaser', $revision_data[0]['teaser']);
		
		//
		//  Migrate attached file info
		//
		$uploads_query = $this->select ( 'upload', 'u');
		$uploads_query->join('node' , 'n' , ' ( u.nid = n.nid AND u.vid = n.vid )');
		$uploads_query->fields( 'u', ['nid', 'vid' , 'fid', 'description'])
			->fields( 'n' , ['nid', 'vid', 'type' ])
			 ->condition('n.type', 'blog' , '=')
			 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
        ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
		$uploads_results = $uploads_query->execute();
		foreach( $uploads_results as $result ){
			$row->setSourceProperty('attached_fid', $result['fid']);
		}

				//
				//  Migrating images in the image_attach module system into the d8 node reference  field_images
				//
				//
				$images_query = $this->select('image' , 'i');
				$images_query->join('image_attach', 'ia' , 'ia.iid = i.nid');  // but ia.nid is the nid of the advisory node ( or blog node, or whatever.)
				$images_query->join('node', 'n', 'n.nid=ia.nid' );
				$images_query->fields('i' ,['nid','image_size'] )
					           ->fields('ia', [ 'nid' ,'iid' ] )
										 ->fields('n' , ['nid', 'type', 'vid'])
										 ->condition('i.image_size', '_original', '=')
										 ->condition('n.type' , 'blog' , '=')
										 ->condition('n.nid' , $row->getSourceProperty('nid'), '=');
				$images_nids = $images_query->execute();
				foreach( $images_nids as $images_nid){
					$images_array[] = $images_nid['nid'];
				}
				if (count( $images_array)) $row->setSourceProperty('field_attached_images', $images_array);
				//
				//
				//  Migrating video urls
				$videos_query = $this->select('video', 'v');
				$videos_query->join('content_field_video' , 'cfv' , 'v.nid = cfv.field_video_nid');
				$videos_query->join('node' , 'n' , 'cfv.nid = n.nid AND cfv.vid = n.vid');
				$videos_query->fields('v', ['vid', 'nid' , 'vidfile'])
										 ->fields('cfv' , ['nid', 'vid', 'field_video_nid'])
										 ->fields('n', ['nid', 'vid', 'type'])
										 ->condition('n.type', 'blog' , '=')
										 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
			               ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
				
				$videos_results = $videos_query->execute();
				foreach ( $videos_results as $result ){
				  $videos_array[] = $result['nid'];
				}
				if ( count( $videos_array )) $row->setSourceProperty('field_attached_videos', $videos_array );

				//
				// Migrate URL alias.
					    $alias_query = $this->select('url_alias', 'ua');
					      $alias_query->fields('ua', ['dst'])
					      ->condition('ua.src', 'node/' . $row->getSourceProperty('nid'), '=');
					      $alias_result = $alias_query->execute();
					      $alias= $alias_result->fetchField();
					    if (!empty($alias)) {
					      $row->setSourceProperty('alias', '/' . $alias);
					    }
	
    return parent::prepareRow($row);
	
  }
}