<p>
<?php 
use \Drupal\Core\Render;

//kint(gnfac_current_advisory('nid'));
$advisory = gnfac_current_advisory('node') ;
	
?>

<table border="0" cellpadding="3" cellspacing="0" width="600">
	<tbody>
		<tr>
			<td>Gallatin National Forest AVALANCHE ADVISORY | Web: www.mtavalanche.com | Email: mtavalanche@gmail.com | Recording: 587-6981 | Office: 587-6984</td>
		</tr>
		<tr>
			<td bgcolor="#eeeeee" colspan="1"><a href="http://www.mtavalanche.com/"><img align="middle" src="http://mtavalanche.com/sites/all/themes/zen_ninesixty/images/email-header-bg6.png" /></a>
			<hr width="98%" /></td>
		</tr>
		<tr>
			<td bgcolor="#eeeeee" colspan="1">
			<h2><?php echo $advisory->title->value;?></h2>
			<?php //include_once('/home/jimurl/public_html/d8/sites/all/modules/gnfac_d8/inc/advisory-map.inc.php'); gnfac_generate_advisory_map( $advisory ); ?>

			<table border="0" cellpadding="3" cellspacing="0" id="advisory-links" width="320px">
				<tbody>
					<tr>
						<td valign="absmiddle" width="50px"><a href="http://mtavalanche.com/images/DangerScale-small.jpg" title="Danger Scale"><img align="absmiddle" src="/sites/all/themes/gnfac_theme/images/danger_high_extreme.png" title="Danger Scale" /><br />
						danger ratings</a></td>
						<td valign="absmiddle" width="50px"><a>Audio field</a><img align="absmiddle" border="0" height="35" hspace="5" src="/images/listen.gif" width="35" /><br />
						Play audio</a> </td>
						
						
					</tr>
				</tbody>
			</table>
			<?php echo $advisory->field_intro->value; ?>

			<h3>Mountain Weather</h3>
			<?php echo $advisory->field_weather->value; ?>

			<div class="center" id="callout-button"><strong><a href="https://mtavalanche.com/weather/wx-avalanche-log">Weather and Avalanche Log</a> </strong></div>

      <div class = 'snowpack-discussion'>
				<?php echo  gnfac_d8_compile_regions($advisory);  ?>
			</div>

			<h3>Upcoming Events and Education</h3>
			<?php echo $advisory->body->value; ?>

			<div class="center" id="callout-button"><strong><a href="/node/add/snow-observations">Submit Your Snow Observation</a></strong></div>

			<p>&nbsp;</p>

			<hr /> 
			<?php 
			  $advisory_photos_view = views_embed_view('attached_images','block_3'); 
				//kint ($advisory_photos_view);
				echo( \Drupal::service('renderer')->render($advisory_photos_view));
			  //$output = \Drupal::service('renderer')->render($advisory_photos_view);
			?>
			<h2>Avalanche Guys Videos</h2>
			<? 
			  $advisory_videos_view = views_embed_view('attached_videos', 'block_2');
	 			echo( \Drupal::service('renderer')->render($advisory_videos_view) );
				 
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2">To unsubscribe/change profile:<br />
			#[UNSUB_LINK]#
			<p>To subscribe: #[LIST_SUBLINK]#</p>

			<p>Our address:<br />
			#[SENDER_ADDRESS]#</p>
			</td>
		</tr>
	</tbody>
</table>
