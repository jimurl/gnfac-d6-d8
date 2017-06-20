<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Advisory Year terms.
 *
 * @MigrateSource(
 *   id = "gnfac_advisory_year"
 * )
 */
class GnfacAdvisoryYear extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('term_data')
      ->fields('term_data', array_keys($this->fields()))
      ->condition('vid', '2', '=');
  }
  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'tid' => $this->t('Term ID'),
      'vid' => $this->t('Vocabulary ID'),
      'name' => $this->t('Term Name'),
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
      ],
    ];
  }
}