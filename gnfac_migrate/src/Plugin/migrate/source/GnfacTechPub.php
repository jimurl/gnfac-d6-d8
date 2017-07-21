<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Tech pubs to media articles.
 *
 * @MigrateSource(
 *   id = "gnfac_tech_pub"
 * )
 */
class GnfacTechPub extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'node');
    $query
      ->fields('node', array_keys($this->baseFields()))
      ->condition('node.type', 'tech_pubs', '=');
    return $query;
  }
  public function fields() {
    $fields = $this->baseFields();
    $fields['body'] = $this->t('Node body');
    $fields['teaser'] = $this->t('Node teaser');
		$fields['alias'] = $this->t('Path alias');
		$fields['field_date'] = $this->t('Date of Publication');
		$fields['field_publication'] = $this->t('Publication');
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
			 ->condition('n.type', 'tech_pub' , '=')
			 ->condition('n.nid', $row->getSourceProperty('nid') , '=' )
        ->condition('n.vid', $row->getSourceProperty('vid') , '=' );
		$uploads_results = $uploads_query->execute();
		foreach( $uploads_results as $result ){
			$row->setSourceProperty('attached_fid', $result['fid']);
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