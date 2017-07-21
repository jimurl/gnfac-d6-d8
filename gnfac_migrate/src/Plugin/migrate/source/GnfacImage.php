<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Images.
 *
 * @MigrateSource(
 *   id = "gnfac_image"
 * )
 */
class GnfacImage extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query->join('image', 'image', 'image.nid = node.nid');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->fields('image', ['fid', 'image_size'])		
      ->condition('node.type', 'image', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['type'] = $this->t('Node type');
    $fields['fid'] = $this->t('Image file ID');
    $fields['image_size'] = $this->t('Image size');
		$fields['image_types'] = $this->t('Image type');
		$fields['advisory_year'] = $this->t('Advisory Year');
    return $fields;
  }
  /**
   * {@inheritdoc}
   */
  public function baseFields() {
    $fields = [
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Node revision ID'),
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
    // Get image type for this image.
		//
   $query_tids = $this->select('term_node', 'tn');
   $query_tids->join('term_data', 'td' , 'td.tid=tn.tid');
	 $query_tids->fields('tn', ['tid'])
			        ->fields('td', ['tid'])
              ->condition('tn.nid', $row->getSourceProperty('nid'), '=')
              ->condition('tn.vid', $row->getSourceProperty('vid'), '=')
	            ->condition('td.vid', 7, '=');
     $name_tids = $query_tids->execute();
			

			foreach ($name_tids as $name_tid){

				  $row->setSourceProperty('image_types', $name_tid['tid']);
			}  
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
				// Get advisory REGION info
				//
		    $adv_region_tids = $this->select('term_node', 'tn');
		    $adv_region_tids->join('term_data', 'td' , 'td.tid=tn.tid');
		 	 $adv_region_tids->fields('tn', ['tid'])
		 			        ->fields('td', ['tid'])
		               ->condition('tn.nid', $row->getSourceProperty('nid'), '=')
		               ->condition('tn.vid', $row->getSourceProperty('vid'), '=')
		 	            ->condition('td.vid', 1, '=');
		      $region_tids = $adv_region_tids->execute();
			

		 			foreach ($region_tids as $region_tid){

		 				  $row->setSourceProperty('advisory_region', $region_tid['tid']);
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
					// Migrate URL alias.
					    $alias_query = $this->select('url_alias', 'ua');
					      $alias_query->fields('ua', ['dst'])
					      ->condition('ua.src', 'node/' . $row->getSourceProperty('nid'), '=');
					      $alias_result = $alias_query->execute();
					      $alias= $alias_result->fetchField();
								var_dump($alias);
					    if (!empty($alias)) {
					      $row->setSourceProperty('alias', '/' . $alias);
					    }
	
    return parent::prepareRow($row);
	
  }
}