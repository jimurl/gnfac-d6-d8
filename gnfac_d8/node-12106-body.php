
<?php 
use \Drupal\Core\Render;

//kint(gnfac_current_advisory('nid'));
$advisory = gnfac_current_advisory('node') ;
	
?>
<table border="0" cellpadding="3px" cellspacing="0" width="600px" style = "width: 600px;">
	<tbody>
		
		<tr>
			<td bgcolor="#fafafa" colspan="1"><a href="https://www.mtavalanche.com/"><img align="middle" src="https://www.d8.mtavalanche.com/images/email-header-bg6.png" /></a>
		</tr>
		<tr>
			<td bgcolor="#fafafa" colspan="1" style = "padding: 0px 7px;">
			<h2><?php echo $advisory->title->value; ?></h2>
			
			<ul style = "background-color: #617490; padding: 3px 0; font-size: .85rem; border: 1px solid #162f50; ">
  
			<li  style = "display: inline-block; padding: 2px 8px;" ><a href="/advisory/bridgers" title="Current Conditions in the Bridger Range" style = "color: #fafafa;">Bridgers</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/northern-gallatin" title="Current Condtions in the Northern Gallatin Range" style = "color: #fafafa;">Gallatin - N</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/southern-gallatin" title="Current Conditions in the Southern Gallatin Range" style = "color: #fafafa;">Gallatin - S</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/northern-madison" title="Current Condtions in the Northern Madison Range" style = "color: #fafafa;">Madison - N</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/southern-madison" title="Current Conditions in the Southern Madison Range" style = "color: #fafafa;">Madison - S</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/lionhead" title="Current Conditions in the Lionhead Range" style = "color: #fafafa;">Lionhead</a></li>
			<li style = "display: inline-block; padding: 2px 8px;"><a href="/advisory/cooke-city" style = "color: #fafafa;">Cooke City</a></li>
			</ul>
			
			<div style ="float: right; display: inline-block; border: 1px solid #162f50; margin-left: 8px;" align = "right">
				<?php include_once('/home/jimurl/public_html/d8/sites/all/modules/gnfac_d8/inc/advisory-map.inc.php'); 
				      gnfac_generate_advisory_map( $advisory->nid->value ); ?>
			</div>


			<?php echo $advisory->field_intro->value; ?>

			<h3 style = "background-color: #617490; border-top: 4px solid #162f50; margin-top: 35px; color: #fafafa; padding: 3px 10px;">Mountain Weather</h3>
			<?php echo $advisory->field_weather->value; ?>

			<div style = "margin: 0 3px;	border: 1px solid #162f50;	background: #617490;  padding: 3px 6px; display: inline;"><strong><a style = "color: #fafafa;"  href="https://www.mtavalanche.com/weather/wx-avalanche-log">Weather and Avalanche Log</a> </strong></div>

      <div class = 'snowpack-discussion'>
				<?php $format = 'email'; echo  gnfac_d8_compile_regions($advisory, $format );  ?>
			</div>


			<?php echo gnfac_style_h3($advisory->body->value); ?>

			<div class="center" style = "margin: 0 3px;	border: 1px solid #162f50;	background: #617490; padding: 3px 6px; display:inline;"><strong><a style = "color:#fafafa; padding: 3px 6px;" href="https://www.mtavalanche.com/node/add/snow-observations">Submit Your Snow Observation</a></strong></div>

			<h3  style = "background: #617490; border-top: 4px solid #162f50; padding: 3px 6px; margin-top: 35px; color: #fafafa; ">Photos and Snowpits</h3>
			<?php 
			  $advisory_photos_view = views_embed_view('attached_images','block_3'); 
				//kint ($advisory_photos_view);
				echo( \Drupal::service('renderer')->render($advisory_photos_view));
			  //$output = \Drupal::service('renderer')->render($advisory_photos_view);
			?>
			<h3  style = "background: #617490; border-top: 4px solid #162f50; padding: 3px 6px; margin-top: 35px; color: #fafafa; ">Avalanche Guys Videos</h3>
			<? 
			  $advisory_videos_view = views_embed_view('attached_videos', 'block_3');
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
