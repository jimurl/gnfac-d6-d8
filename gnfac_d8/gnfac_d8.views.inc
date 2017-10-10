<?php
/**
 * Implements hook_views_data_alter().
 */
function gnfac_d8_views_data_alter(array &$data) {
  $data['node']['advisory_embed_video'] = array(
    'title' => t('Advisory Video embed'),
    'field' => array(
      'title' => t('Advisory Video embed'),
      'help' => t('Embeds a video.'),
      'id' => 'advisory_embed_video',
    ),
  );
  $data['node']['advisory_embed_all'] = array(
    'title' => t('Advisory Archive Embed'),
    'field' => array(
      'title' => t('Advisory Archive Embed'),
      'help' => t('Embeds images,snowpit profiles, and videos in archives.'),
      'id' => 'advisory_embed_all',
    ),
  );
}