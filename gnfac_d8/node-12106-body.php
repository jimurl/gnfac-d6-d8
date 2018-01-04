<?php 

use \Drupal\Core\Render;

use Drupal\file\Entity\File;
use Drupal\Core\Url;
use Drupal\Core\Link;
$advisory = gnfac_current_advisory('node') ;
	
//var_dump($nodeobject);

///////////////////////////////////////////////
?>

<table border=0 cellpadding=3 cellspacing=0 width="590" style = "width:590px; font-family: Arial, sans-serif; font-size: 1.3em;">
	<tr><td>
<tr> <td colspan="1" bgcolor="#fafafa" style = "padding: 6px;"><a href= "https://www.mtavalanche.com/advisory"><img src="https://www.mtavalanche.com/images/gnfac-bg-email.jpg" align="middle" width = "590"></a> </td></tr>

<tr> 
<td COLSPAN="1" bgcolor="#fafafa" style ="padding: 6px; backgroundf-color: #fafafa;">
<table border="0" cellpadding="3" cellspacing="0"  style = "background-color: #617490; margin-top: 0; padding: 3px 0; font-size: 10pt; border: 1px solid #162f50; width: 590px; font-family: Arial, sans-serif;" width = "590">
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
<?php 
	
	echo '<h2>' . $advisory->title->value . '</h2>';  
	?>
  <div style ="float: right; margin-left: 8px;"  align ='right' width = '265' height = '371' >
		<div class = 'print-buttons'>
<?php if ( $advisory->field_audio_file->target_id ){
	$audio = entity_load( 'file', $advisory->field_audio_file->target_id );
  $url = $audio->getFileUri();
	$url = str_replace( 'public://' , '/sites/default/files/',  $url );
	echo '<a href ="'. $url .'" target = "_blank" title = "Listen to Advisory"><img src = "/images/listen.png"></a>' ;    
} ?>
			<a href="/entityprint/node/<?php echo $advisory->nid->value;  ?>" target="_blank" title="Print this page"><img src="/sites/all/themes/gnfac_theme/images/icons/print.png" height="32px"></a>
	  </div>	
<?php 
include_once(DRUPAL_ROOT.'/sites/all/modules/gnfac_d8/inc/advisory-map.inc.php');
gnfac_generate_advisory_map( $advisory->nid->value , 'email'); 
?>
  </div>

<?php 
$intro_content = [
  '#type' => 'processed_text',
  '#text' => gnfac_style_h3($advisory->field_intro->value),
  '#format' => 'basic_html',
];
//echo str_replace ( '<p>' , '<p style ="font-size: 1.2em;">' ,\Drupal::service('renderer')->renderPlain($intro_content)); 
echo \Drupal::service('renderer')->renderPlain($intro_content);

?>
<h3 style = "background-color: #617490; border-top: 4px solid #162f50; margin-top: 15px; color: #fafafa; padding: 3px 10px; font-size: 1.2rem;">Mountain Weather</h3>

<?php 
$weather_content = [
  '#type' => 'processed_text',
  '#text' => $advisory->field_weather->value,
  '#format' => 'basic_html',
];
// echo str_replace ( '<p>' , '<p style ="font-size: 1.2em;">' ,\Drupal::service('renderer')->renderPlain($weather_content)); 
echo \Drupal::service('renderer')->renderPlain($weather_content);
?>
<span class = "center" 
		style = "text-align: center;    
		display: inline-block;
		margin: 0 3px;
		border: 1px solid #284e86;
		overflow: hidden;
		background: #e28600;
		padding-bottom: 0.2rem;
		border-radius: .5em;
		box-shadow: .1em .1em 0.3em;
    height: 38px;
    padding: 6px;
    display: inline;
    margin: 0px 4px; " >
<strong>
<a href="http://www.mtavalanche.com/weather/wx-avalanche-log" style ="color: #ffffff;" >Weather and Avalanche Log</a>
</strong>
</span>
<h3 style = "background-color: #617490; border-top: 4px solid #162f50; margin-top: 15px; margin-bottom: 0; color: #fafafa; padding: 3px 10px; font-size: 1.2rem;">Snowpack and Avalanche Discussion</h3>

<?php $format = 'email'; 
//echo  str_replace ( '<p>' , '<p style ="font-size: 1.2em;">' ,gnfac_d8_compile_regions($advisory, $format ));  
echo gnfac_d8_compile_regions($advisory, $format );
	
	?>

<span class = "center" 
		style = "text-align: center;    
		display: inline-block;
		margin: 0 3px;
		border: 1px solid #284e86;
		overflow: hidden;
		background: #e28600;
		padding-bottom: 0.2rem;
		border-radius: .5em;
		box-shadow: .1em .1em 0.3em;
    height: 38px;
    padding: 6px;
    display: inline;
    margin: 0px 4px; " >
		<strong><a href="http://www.mtavalanche.com/node/add/snow_observation" style = "color: #fafafa;">Submit Your Snow Observation</a></strong>
</span>

<?php 
//echo str_replace ( '<p>' , '<p style ="font-size: 1.2em;">' ,gnfac_style_h3($advisory->body->value)); 
echo gnfac_style_h3($advisory->body->value);
?>

<?php if ( $advisory->field_forecasters_choice_text )  { ?>
  <h3 style = "background: #617490; border-top: 4px solid #162f50; padding: 3px 6px; margin-top: 35px; color: #fafafa; ">The Last Word</h3>
<?php //echo str_replace ( '<p>' , '<p style ="font-size: 1.2em;">' ,$advisory->field_forecasters_choice_text->value) ;  
	echo $advisory->field_forecasters_choice_text->value;
}  ?>


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

