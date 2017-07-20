<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Images.
 *
 * @MigrateSource(
 *   id = "gnfac_accident"
 * )
 */
class GnfacAccident extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'accident', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['advisory_year'] = $this->t('Advisory Year');
		$fields['advisory_region'] = $this->t('Advisory Year');
		$fields['field_attached_images'] = $this->t('attached image nodes');
		$fields['field_attached_videos'] = $this->t('Youtube video URLs');
		$fields['alias'] = $this->t('Path alias');
		$fields['field_date'] = $this->t('Date of accident');
		$fields['latitude'] = $this->t('Latitude');
		$fields['longitude'] = $this->t('Longitude');
		$fields['accident_fid'] = $this->t('File ID of accident report');
		
		
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
		

			////
			// Get advisory Year info
			//
	    $adv_yr_tids = $this->select('term_node', 'tn');
	    $adv_yr_tids->join('term_data', 'td' , 'td.tid=tn.tid');
	 	 $adv_yr_tids->fields('tn', ['tid'])
	 			        ->fields('td', ['tid'])
	               ->condition('tn.nid', $row->getSourceProperty('nid'), '=')
	               ->condition('tn.vid', $row->getSourceProperty('vid'), '=')
	 	            ->condition('td.vid', 2, '=');
	      $year_tids = $adv_yr_tids->execute();
			

	 			foreach ($year_tids as $year_tid){

	 				  $row->setSourceProperty('advisory_year', $year_tid['tid']);
	 			}  
				////
				// Get Latitude longitude info
				//
				$location_query = $this->select('location_instance', 'li');
				$location_query->join('location', 'l', 'l.lid = li.lid');
				$location_query->fields( 'l' ,['latitude','longitude', 'lid'])
					->fields('li', ['lid', 'nid','vid'])
            ->condition('li.nid', $row->getSourceProperty('nid'), '=')
            ->condition('li.vid', $row->getSourceProperty('vid'), '=');
				$location_results = $location_query->execute();
				
				foreach( $location_results as $loc_result ){
					
					$row->setSourceProperty('latitude', $loc_result['latitude']);
					$row->setSourceProperty('longitude', $loc_result['longitude']);
					
				}
				/////
				//  Migrate C B K information, goes from node ref field into a file rel field
				
				////
				
				$cbk_query = $this->select('content_type_accident', 'a');
				$cbk_query->fields('a', ['nid', 'vid' ,'field_cbk_value'] )
												 ->condition( 'a.nid', $row->getSourceProperty('nid')   )
												 ->condition( 'a.vid' , $row->getSourceProperty('vid'));
				$cbk_results = $cbk_query->execute();
				foreach($cbk_results as $result){
					$row->setSourceProperty('field_cbk',$result['field_cbk_value']);
	
				}
				//
				//   Migrating the field_date info straight over
				// 
				$date_query = $this->select('content_field_date', 'cfd');
				$date_query->fields('cfd', ['nid', 'vid' ,'field_date_value'] )
												 ->condition( 'cfd.nid', $row->getSourceProperty('nid')   )
												 ->condition( 'cfd.vid' , $row->getSourceProperty('vid'));
				$date_results = $date_query->execute();
				foreach($date_results as $result){
					$row->setSourceProperty('field_date',$result['field_date_value']);
	
				}
				//
				//  Migrating images in the image_attach module system into the d8 node reference  field_images
				//
				//
				$images_query = $this->select('image' , 'i');
				$images_query->join('image_attach', 'ia' , 'ia.iid = i.nid');  // but ia.nid is the nid of the advisory node ( or accident node, or whatever.)
				$images_query->join('node', 'n', 'n.nid=ia.nid' );
				$images_query->fields('i' ,['nid','image_size'] )
					           ->fields('ia', [ 'nid' ,'iid' ] )
										 ->fields('n' , ['nid', 'type', 'vid'])
										 ->condition('i.image_size', '_original', '=')
										 ->condition('n.type' , 'accident' , '=')
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
										 ->condition('n.type', 'accident' , '=')
										 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
			               ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
				
				$videos_results = $videos_query->execute();
				foreach ( $videos_results as $result ){
				  $videos_array[] = $result['nid'];
				}
				if ( count( $videos_array )) $row->setSourceProperty('field_attached_videos', $videos_array );
				//
				// Migrate Activity ( snowmobiling, skiing, etc )
				//
				$activity_query = $this->select('content_field_activity', 'cfa');
				$activity_query->fields('cfa', ['nid', 'vid' ,'field_activity_value'] )
												 ->condition( 'cfa.nid', $row->getSourceProperty('nid')   )
												 ->condition( 'cfa.vid' , $row->getSourceProperty('vid'));
				$activity_results = $activity_query->execute();
				foreach($activity_results as $result){
					$row->setSourceProperty('field_activity',$result['field_activity_value']);
	
				}			
				//
				//  Migrate accident report file info
				//
				$uploads_query = $this->select ( 'upload', 'u');
				$uploads_query->join('node' , 'n' , ' ( u.nid = n.nid AND u.vid = n.vid )');
				$uploads_query->fields( 'u', ['nid', 'vid' , 'fid', 'description'])
					->fields( 'n' , ['nid', 'vid', 'type' ])
					 ->condition('n.type', 'accident' , '=')
					 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
            ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
				$uploads_results = $uploads_query->execute();
				foreach( $uploads_results as $result ){
					$row->setSourceProperty('accident_fid', $result['fid']);
				}
				//
				//
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