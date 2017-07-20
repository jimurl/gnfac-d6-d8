<?php
namespace Drupal\gnfac_migrate\Plugin\migrate\source;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Source plugin for Files .
 *
 * @MigrateSource(
 *   id = "gnfac_file"
 * )
 */
class GnfacFile extends SqlBase {
  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('files')
      ->fields('files', array_keys($this->fields()));
  }
  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'fid' => $this->t('File ID'),
      'uid' => $this->t('User ID'),
      'filename' => $this->t('File name'),
      'filepath' => $this->t('File path (in public files dir)'),
      'filemime' => $this->t('File MIME type'),
      'timestamp' => $this->t('File created date UNIX timestamp'),
			'status' => $this->t('Published or unpublished'),
			'filesize' => $this->t('File size'),
    ];
    return $fields;
  }
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'fid' => [
        'type' => 'integer',
      ],
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Update filepath to remove public:// directory portion.
    $original_path = $row->getSourceProperty('filepath');
    $new_path = str_replace('sites/default/files/', 'public://', $original_path);
    $row->setSourceProperty('filepath', $new_path);
		
		$filename = $row->getSourceProperty('filename'); 		$filemime = $row->getSourceProperty('filemime');

		if ( (substr($filemime, 0, 5 ) == 'image') &&  (! strpos($filename, '.' ) ) ){
			$new_filename =  substr( $original_path,  strrpos( $original_path, '/'   )+1 );
			$row->setSourceProperty('filename' , $new_filename );
		}
		
    return parent::prepareRow($row);
  }
}