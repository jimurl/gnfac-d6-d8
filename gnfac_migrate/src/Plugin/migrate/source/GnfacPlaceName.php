<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Placenames.
 *
 * @MigrateSource(
 *   id = "gnfac_placename"
 * )
 */
class GnfacPlaceName extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'placename', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['field_attached_images'] = $this->t('attached image nodes');
		$fields['alias'] = $this->t('Path alias');
		$fields['latitude'] = $this->t('Latitude. ');
		$fields['longitude'] = $this->t('Longitude. ');
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