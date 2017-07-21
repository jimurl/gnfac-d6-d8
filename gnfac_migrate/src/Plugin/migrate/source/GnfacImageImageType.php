<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for GNFAC Image to tomage type mappings
 *
 * @MigrateSource(
 *   id = "gnfac_image_image_type"
 * )
 */
class GnfacImageImageType extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('term_node', 'tn');
    $query->join('term_data', 'td', 'td.tid = tn.tid');
    $query
      ->fields('tn', array_keys($this->fields()))
      ->fields('td', ['tid', 'vid'])		
      ->condition('td.vid', '7' , '=');
    return $query;
  }
  /**
   * {@inheritdoc}
   */
  public function baseFields() {
    $fields = [
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Node revision ID'),
			'tid' => $this->t('Term ID')
    ];
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Revision ID'),
      'tid' => $this->t('Term ID'),

    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'tid' => [
        'type' => 'integer',
				'alias' => 'tn'
      ],
    ];
  }

}
?>