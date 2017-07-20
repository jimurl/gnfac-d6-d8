<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Images.
 *
 * @MigrateSource(
 *   id = "gnfac_weather_station"
 * )
 */
class GnfacWxStation extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'weather_station', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['field_attached_images'] = $this->t('attached image nodes');
		$fields['alias'] = $this->t('Path alias');
    $fields['field_nrcs_wx_sta_no'] = $this->t('snowtel site ID');
		$fields['field_datagarridsson_id'] = $this->t('Datagarrison ID ( many digits )');		
		$fields['latitude'] = $this->t('Latitude. ');
		$fields['longitude'] = $this->t('Longitude. ');
		$fields['tid'] = $this->t('Weather station type');
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
			 ->condition('n.type', 'weather_station' , '=')
			 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
        ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
		$uploads_results = $uploads_query->execute();
		foreach( $uploads_results as $result ){
			$row->setSourceProperty('attached_fid', $result['fid']);
		}
		
		//
		// field_nrcs_wx_sta_no station number for snowtel sites
		//
		$snotel_query = $this->select('content_type_weather_station' , 'ctwx');
		$snotel_query->fields('ctwx', [ 'nid' , 'vid' ,'field_nrcs_wx_sta_no_value', 'field_datagarridsson_id_value'])
	   ->condition('ctwx.nid', $row->getSourceProperty('nid') , '=' )
     ->condition('ctwx.vid', $row->getSourceProperty('vid') , '=' );
		$snotel_results = $snotel_query->execute();
		foreach( $snotel_results as $result ){
			$row->setSourceProperty('field_nrcs_wx_sta_no', $result['field_nrcs_wx_sta_no_value']);
			$row->setSourceProperty('field_datagarridsson_id', $result['field_datagarridsson_id_value']);
			
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
		//
		//  Get the weather station type info
		//
   $query_tids = $this->select('term_node', 'tn');
   $query_tids->join('term_data', 'td' , 'td.tid=tn.tid');
	 $query_tids->fields('tn', ['tid'])
			        ->fields('td', ['tid'])
              ->condition('tn.nid', $row->getSourceProperty('nid'), '=')
              ->condition('tn.vid', $row->getSourceProperty('vid'), '=')
	            ->condition('td.vid', 8, '=');
     $name_tids = $query_tids->execute();
			

			foreach ($name_tids as $name_tid){

				  $row->setSourceProperty('tid', $name_tid['tid']);
			}  
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