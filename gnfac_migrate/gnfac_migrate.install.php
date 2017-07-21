<?php
/**
 * @file
 * GNFAC migration install file.
 */
/**
 * Implements hook_uninstall().
 */
function gnfac_migrate_uninstall() {
  // Delete this module's migrations.
  $migrations = [

    'gnfac_user',
		'gnfac_file',
		'gnfac_advisory_region',
		'gnfac_advisory_year',
		'gnfac_glossary',
		'gnfac_weather',
		'gnfac_image_type',
		'gnfac_image',
		'gnfac_advisory',
		'gnfac_accident',
		'gnfac_page',
		'gnfac_wx_station',
		'gnfac_story',
		'gnfac_blog',
		'gnfac_wx_log',
		'gnfac_media_art',
		'gnfac_tech_pubs',
		'gnfac_placename',
		
		
		
  ];
  foreach ($migrations as $migration) {
    Drupal::configFactory()->getEditable('migrate_plus.migration.' . $migration)->delete();
  }
	
	Drupal::configFactory()->getEditable('migrate_plus.migration_group.gnfac')->delete();
			
	drupal_flush_all_caches();
}