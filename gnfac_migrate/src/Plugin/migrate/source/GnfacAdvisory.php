<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Images.
 *
 * @MigrateSource(
 *   id = "gnfac_advisory"
 * )
 */
class GnfacAdvisory extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'advisory', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['advisory_year'] = $this->t('Advisory Year');
		$fields['field_intro'] = $this->t('Introduction to the advisory');
		$fields['field_discussion'] = $this->t('Full discussion field');
		$fields['audio_file_fid'] = $this->t('Audio file fid');
		$fields['field_attached_images'] = $this->t('attached image nodes');
		$fields['field_attached_videos'] = $this->t('Youtube video URLs');
		$fields['field_bridger_haz'] = $this->t('Bridgers hazard rating for this advisory day');
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
				/////
				//  Migrate audio information, goes from node ref field into a file rel field
				
				///   Also fetching and recording of intro and discussion fields
				//    nameing conventions between d6 -> d8 change confusingly here, with d6 node.body going into d8 node.field_intro, 
				//    d6 node.field_intro ( which is mainly weather info and updates to the advisory ) goes into d8 node.body/summary
				//  and finally d6 node.field_discussion goes into d8 node.body/value , where the main advisory info is held 
				//   
				//   joining the audio field was the tricky part of this
				////
				
				$audio_file_query = $this->select('content_type_advisory', 'cta');
				$audio_file_query->leftJoin('audio', 'a' , 'a.nid  = cta.field_audio_nid');
				$audio_file_query->fields('cta', ['field_audio_nid', 'nid', 'vid' ,'field_discussion_value', 'field_intro_value', 'field_bridger_haz_value','field_n_gall_value' ,'field_s_gall_value', 'field_n_madison_value','field_s_madison_value', 'field_lionhead_value','field_cooke_value' ,'field_expiration_value2'] )
                         ->fields('a', ['fid', 'nid', 'vid', 'title_format' ])
												 ->condition( 'cta.nid', $row->getSourceProperty('nid')   )
												 ->condition( 'cta.vid' , $row->getSourceProperty('vid'));
				$audio_fids = $audio_file_query->execute();
				foreach($audio_fids as $audio_fid){
					$row->setSourceProperty('audio_file_fid',$audio_fid['fid']);
					$row->setSourceProperty('field_intro', $audio_fid['field_intro_value']);
					$row->setSourceProperty('field_discussion', $audio_fid['field_discussion_value']);
				  $row->setSourceProperty('field_bridger_haz', $audio_fid['field_bridger_haz_value']);
					$row->setSourceProperty('field_s_gall', $audio_fid['field_s_gall_value']);
					$row->setSourceProperty('field_n_madison', $audio_fid['field_n_madison_value']);
					$row->setSourceProperty('field_s_madison', $audio_fid['field_s_madison_value']);
					$row->setSourceProperty('field_n_gall', $audio_fid['field_n_gall_value']);
					$row->setSourceProperty('field_lionhead', $audio_fid['field_lionhead_value']);
					$row->setSourceProperty('field_cooke', $audio_fid['field_cooke_value']);
					$row->setSourceProperty('field_valid_dates', $audio_fid['field_expiration_value2']);
					
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
										 ->condition('n.type' , 'advisory' , '=')
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
										 ->condition('n.type', 'advisory' , '=')
										 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
			               ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
				
				$videos_results = $videos_query->execute();
				foreach ( $videos_results as $result ){
				  $videos_array[] = $result['nid'];
				}
				if ( count( $videos_array )) $row->setSourceProperty('field_attached_videos', $videos_array );
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