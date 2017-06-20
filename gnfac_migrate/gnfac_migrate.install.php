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
		 
  ];
  foreach ($migrations as $migration) {
    Drupal::configFactory()->getEditable('migrate_plus.migration.' . $migration)->delete();
  }
}