<?php 

use \Drupal\Core\Render;

$advisory = gnfac_current_advisory('node') ;
	
//var_dump($nodeobject);

///////////////////////////////////////////////
?>

<table border=0 cellpadding=3 cellspacing=0 width="600" style = "width:600px;">
	<tr><td>
<tr> <td colspan="1" bgcolor="#fafafaø" style = "padding: 6px; font-family: Calibri, Georgia, serif;"><a href= "https://www.mtavalanche.com/"><img src="https://www.mtavalanche.com/images/gnfac-bg-email.jpg" align="middle"></a> </td></tr>

<tr> 
<td COLSPAN="1" bgcolor="#fafafa" style ="font-family: Calibri, Georgia, serif; padding: 6px; backgroundf-color: #fafafa;">
<table border="0" cellpadding="3" cellspacing="0"  style = "background-color: #617490; margin-top: 0; padding: 3px 0; font-size: .80rem; border: 1px solid #162f50; width: 600px;" width = "600">
 <tr>
	<td style = "padding: 2px 8px; color: #fafafa; " >Conditions: </td>

		<td style = "padding: 2px 5px;" ><a href="/advisory/bridgers"  style = "color: #fafafa;">Bridgers</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/northern-gallatin"  style = "color: #fafafa;">Gallatin-N</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/southern-gallatin"  style = "color: #fafafa;">Gallatin-S</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/northern-madison" style = "color: #fafafa;">Madison-N</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/southern-madison"  style = "color: #fafafa;">Madison-S</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/lionhead"  style = "color: #fafafa;">Lionhead</a></td>
		<td style = "padding: 2px 5px;"><a href="/advisory/cooke-city" style = "color: #fafafa;">Cooke</a></td>
	</tr>
  </table> 
<h2><?php echo $advisory->title->value;?></h2>
  
<?php 
include_once(DRUPAL_ROOT.'/sites/all/modules/gnfac_d8/inc/advisory-map.inc.php');

gnfac_generate_advisory_map( $advisory->nid->value , 'email'); 
?>



<?php 
$intro_content = [
  '#type' => 'processed_text',
  '#text' => $advisory->field_intro->value,
  '#format' => 'basic_html',
];
echo \Drupal::service('renderer')->renderPlain($intro_content); 
?>
<h3 style = "background-color: #617490; border-top: 4px solid #162f50; margin-top: 15px; color: #fafafa; padding: 3px 10px; font-size: 1.2rem;">Mountain Weather</h3>

<?php 
$weather_content = [
  '#type' => 'processed_text',
  '#text' => $advisory->field_weather->value,
  '#format' => 'basic_html',
];
echo \Drupal::service('renderer')->renderPlain($weather_content); 
?>
<span class = "center" 
		style = "text-align: center;    
		background-color: #617490;
    border-radius: 6px;
		border: 2px solid #3a5274;
    background-repeat: repeat-x;
    height: 38px;
    padding: 6px;
    display: inline;
    margin: 0px 4px; " >
<strong>
<a href="http://www.mtavalanche.com/weather/wx-avalanche-log" style ="color: #ffffff;" >Weather and Avalanche Log</a>
</strong>
</span>
<h3 style = "background-color: #617490; border-top: 4px solid #162f50; margin-top: 15px; margin-bottom: 0; color: #fafafa; padding: 3px 10px; font-size: 1.2rem;">Snowpack and Avalanche Discussion</h3>

<?php $format = 'email'; echo  gnfac_d8_compile_regions($advisory, $format );  ?>

<?php echo gnfac_style_h3($advisory->body->value); ?>



<span class = "center" 
		style = "text-align: center;  
		background-color: #617490;
    border-radius: 6px;
		border: 2px solid #3a5274;
    background-repeat: repeat-x;
    height: 38px;
    padding: 6px;
    display: inline;
    margin: 0px 4px; " >
		<strong><a href="http://www.mtavalanche.com/node/add/snow_observation" style = "color: #fafafa;">Submit Your Snow Observation</a></strong>
</span>

			<h3  style = "background: #617490; border-top: 4px solid #162f50; padding: 3px 6px; margin-top: 35px; color: #fafafa; ">Photos and Snowpits</h3>
			<?php 
			  $advisory_photos_view = views_embed_view('attached_images','block_3'); 
				echo( \Drupal::service('renderer')->render($advisory_photos_view));
			?>
			<h3  style = "background: #617490; border-top: 4px solid #162f50; padding: 3px 6px; margin-top: 35px; color: #fafafa; ">Avalanche Guys Videos</h3>
			<? 
			  $advisory_videos_view = views_embed_view('attached_videos', 'block_3');
	 			echo( \Drupal::service('renderer')->render($advisory_videos_view) );
				 
			?>

</td></tr>
		
</table>

