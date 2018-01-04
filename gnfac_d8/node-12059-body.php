<?php
include DRUPAL_ROOT.'/libraries/avalanche.org-API-Client/AvalancheAPI.php';
//Create and load map
$api = new AvalancheAPI();
$options = array(  'basemap_color' => 'color', 'zoom_level' => 8 );
$map = $api->getMap( 'GNFAC', $options );

?>
<div class="national-map table-border-mobile "><div class="jhmap jhmap-mobile"  ><?php echo $map;  ?>

<div class="block block-superfish block-superfishadvisory-menu" >
  
       <h2>Conditions:</h2>
     
 <ul id="superfish-advisory-menu" class="menu sf-menu sf-advisory-menu sf-horizontal sf-style-white sf-js-enabled sf-shadow">
  
 <li id="advisory-menu-menu-link-contentcec478a9-9acf-4f41-bf0f-ff5caf3b3986" class="sf-depth-1 sf-no-children"><a href="/advisory/bridgers" title="Current Conditions in the Bridger Range" class="sf-depth-1">Bridgers</a></li><li id="advisory-menu-menu-link-content136017c5-8db5-4724-8c10-e5147eaedde1" class="sf-depth-1 sf-no-children"><a href="/advisory/northern-gallatin" title="Current Condtions in the Northern Gallatin Range" class="sf-depth-1">Gallatin - N</a></li><li id="advisory-menu-menu-link-content146c54f3-4f9b-4485-9f92-4b71f19affba" class="sf-depth-1 sf-no-children"><a href="/advisory/northern-madison" title="Current Condtions in the Northern Madison Range" class="sf-depth-1">Madison - N</a></li><li id="advisory-menu-menu-link-contentfc8f125e-200a-45a4-9b50-88631ccb9ff9" class="sf-depth-1 sf-no-children"><a href="/advisory/southern-madison" title="Current Conditions in the Southern Madison Range" class="sf-depth-1">Madison - S</a></li><li id="advisory-menu-menu-link-content01ba51fb-c261-46f2-9433-d9e7cf437f62" class="sf-depth-1 sf-no-children"><a href="/advisory/southern-gallatin" title="Current Conditions in the Southern Gallatin Range" class="sf-depth-1">Gallatin - S</a></li><li id="advisory-menu-menu-link-content446e824b-a111-4a7d-a4ad-92e5731b29e4" class="sf-depth-1 sf-no-children"><a href="/advisory/lionhead" title="Current Conditions in the Lionhead Range" class="sf-depth-1">Lionhead</a></li><li id="advisory-menu-menu-link-content9010fdf8-138a-4b62-8cff-a7209af77680" class="sf-depth-1 sf-no-children"><a href="/advisory/cooke-city" class="sf-depth-1">Cooke City</a></li>
 </ul>

   </div>

</div>

</div><div class = "home-ratings-image"><a href="http://www.mtavalanche.com/images/DangerScale-small.jpg" title="View Avalanche Danger Ratings Chart"><img alt="Danger Scale" class="hazard-image" height="175" src="https://www.mtavalanche.com/images/Danger-scale-small.jpg" width="125" /></a>
</div><div class="contact-info">
<iframe p="" style=" border-width:0 " class = "google-calendar" src="https://www.google.com/calendar/b/0/embed?mode=AGENDA&amp;height=570&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=k726gueudtvpovhonf59dthbjk%40group.calendar.google.com&amp;color=%23A32929&amp;ctz=America%2FDenver" frameborder="0" ></iframe>
<ul class="button-list">
	<li><a class="button-link"  href = "/node/add/snow_observation">Submit Snow Observation</a></li>
	<li><a class="button-link" href = "mailto://mtavalanche@gmail.com" >Send an Email</a></li>
</ul>
</div>
