<?php
use Drupal\field_collection\Entity\FieldCollectionItem;
function gnfac_generate_advisory_map($advisory_nid){

$style = '';//'float: right; margin-left: 8px;';
$advisory = Drupal\node\Entity\Node::load($advisory_nid);

//imagesetthickness ( $img , 2 );
// Allocate a color for the polygon


// Bridgers

$bridgers_polygon = array(109,7,126,20,134,44,134,62,124,78,116,76,107,56,114,42,104,26,102,12 );

// Northern Gallatin
$no_gall_polygon = array(
132,95,
140,97,
142,103,
152,110,
154,118,
162,126,
162,135,
158,142,
162,150,
160,155,
142,172,
136,194,
127,210,
110,218,
96,222,
78,220,
71,214,
70,191,
82,178,
83,163,
72,150,
67,134,
70,121,
);

// Northern Madison

$no_madison_polygon = array(
58,137,
68,144,
71,156,
80,163,
78,177,
63,192,
66,218,
45,224,
25,221,
22,213,
24,200,
22,188,
29,171,
11,155,
8,148,
14,143,
28,142,
32,147,
44,146
);


// Southern Madison
$so_madison_polygon = array(
64,222,
75,244,
85,249,
96,259,
101,296,
94,309,
71,309,
51,292,
37,298,
31,292,
31,262,
20,245,
24,230,
30,226,
47,227
);

// Southern Gallatin

$so_gall_polygon = array(
125,214,
136,218,
136,235,
138,246,
146,259,
147,313,
136,316,
133,313,
120,297,
117,289,
105,277,
100,260,
76,236,
71,222,
96,225
);

$lionhead_polygon = array(
51,297,
62,314,
62,325,
66,325,
70,330,
61,342,
52,330,
46,330,
42,325,
42,330,
37,330,
31,320,
34,306,
40,299
);

// Cooke City

$cooke_polygon = array(
203,215,
212,214,
228,218,
228,243,
232,250,
230,254,
216,256,
207,254,
206,233,
203,224
);

//
// We only generate the image if one doesn't already exist in file structure
//
$existing_image_flag = FALSE;
if ( !file_exists(DRUPAL_ROOT.'/sites/default/files/advisory-maps/'. date('y/m/d', $advisory->created->value ) .'.png'   )  ) {
	$existing_image_flag = TRUE;
	$img = imagecreatefrompng('/home/jimurl/public_html/images/map/map-base5.png');
	$white = imagecolorallocate($img, 255, 255, 255);
	$black = imagecolorallocate($img, 0 , 0 , 0 );
	$None = imagecolorallocate($img, 0 , 0 , 0 , 55);
	$Extreme = imagecolorallocatealpha( $img, 0, 0, 0, 55 );
	$High = imagecolorallocatealpha( $img, 237, 27,36, 55 );
	$Considerable = imagecolorallocatealpha( $img, 247,148, 29, 50);
	$Moderate = imagecolorallocatealpha( $img, 254, 242,0, 55 );
	$Low = imagecolorallocatealpha( $img, 80, 184,73, 55 );

}
	
foreach ($advisory->field_region_group_1 as $key => $region_group ){
	$fc_ids[$key] = $region_group->getValue()	;		
	$fc = FieldCollectionItem::load($fc_ids[$key]['value']);
	
  // calculate hazard colors
	  // Bridgers First
	  if ( in_array( array ( 'target_id'=> 23 ),  $fc->field_applicable_regions->getValue('target_id')) ){
			$bridger_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $bridgers_polygon, 10 , $$bridger_hazard_color);
			imagepolygon($img , $bridgers_polygon, 10 , $black);}
    }
		// No. Gallatin
	  if ( in_array( array ( 'target_id'=> 25 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$no_gall_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $no_gall_polygon, 23 , $$no_gall_hazard_color);
			imagepolygon($img , $no_gall_polygon, 23 , $black);}
    }		
		// So. Gallatin
	  if ( in_array( array ( 'target_id'=> 27 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$so_gall_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $so_gall_polygon, 15 , $$so_gall_hazard_color);
			imagepolygon($img , $so_gall_polygon, 15 , $black);}
    }		
		// Lionhead Range
	  if ( in_array( array ( 'target_id'=> 29 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$lionhead_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $lionhead_polygon, 14 , $colors[$lionhead_hazard_color]);
			imagepolygon($img , $lionhead_polygon, 14 , $black);}
    }		
		// No Madison
	  if ( in_array( array ( 'target_id'=> 24 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$no_madison_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $no_madison_polygon, 19 , $$no_madison_hazard_color);
			imagepolygon($img , $no_madison_polygon, 19 , $black);	}
    }	
		// So. Madison 
	  if ( in_array( array ( 'target_id'=> 26 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$so_madison_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $so_madison_polygon, 15 , $$so_madison_hazard_color);
			imagepolygon($img , $so_madison_polygon, 15 , $black);}
    }	
		// Cooke City
	  if ( in_array( array ( 'target_id'=> 28 ),  $fc->field_applicable_regions->getValue('target_id'))  ){
			$cooke_hazard_color = $fc->field_regional_hazard_rating->value;
			if ($existing_image_flag){
		  imagefilledpolygon($img , $cooke_polygon, 10 , $$cooke_hazard_color);
			imagepolygon($img , $cooke_polygon, 10 , $black);}
    }	
		
}
if ($existing_image_flag){
  imagepng($img, DRUPAL_ROOT.'/sites/default/files/advisory-maps/'.  date('y/m/d', $advisory->created->value ) .'.png');
}

$image_map = "<map name = 'hazards'  >".
	//"<area href ='/' shape = 'poly' coords='17,51,42,35,66,51,66,89,17,89' alt = 'cooke city' />" .
	"<area href ='/advisory/cooke_city' shape = 'poly' coords='". implode( ',' , $cooke_polygon)  ."' title= 'Cooke City: ". $cooke_hazard_color ."' alt = 'Cooke City' class = 'cooke' />" .
	"<area href ='/advisory/lionhead_range' shape = 'poly' coords='". implode( ',' , $lionhead_polygon)  ."' title= 'Lionhead: ". $lionhead_hazard_color ."' alt = 'Lionhead' class = 'lionhead' />" .
	"<area href ='/advisory/southern_gallatin' shape = 'poly' coords='". implode( ',' , $so_gall_polygon)  ."' title= 'Southern Gallatin: ". $so_gall_hazard_color ."' alt = 'Southern Gallatin' class='sogall' />" .
	"<area href ='/advisory/northern_madison' shape = 'poly' coords='". implode( ',' , $no_gall_polygon)  ."' title= 'Northern Gallatin: ". $no_gall_hazard_color ."' alt = 'Northern Gallatin' class='nogall' />" .
	"<area href ='/advisory/southern_madison' shape = 'poly' coords='". implode( ',' , $so_madison_polygon)  ."' title= 'Southern Madison: ". $so_madison_hazard_color ."' alt = 'Southern Madison' class='somad' />" .
	"<area href ='/advisory/northern_madison' shape = 'poly' coords='". implode( ',' , $no_madison_polygon)  ."' title= 'Northern Madison: ". $no_madison_hazard_color ."' alt = 'Northern Madison' class='nomad' />" .
	"<area href ='/advisory/bridgers' shape = 'poly' coords='". implode( ',' , $bridgers_polygon)  ."' title= 'Bridger Range: ". $bridger_hazard_color ."' alt = 'Bridger Range' class='bridgers'  />" .
		
	"</map>"	;

$image_tag = "<a href = '/danger-map' target = '_blank'><img src = '/sites/default/files/advisory-maps/". date('y/m/d', $advisory->created->value ) .".png' style = '". $style ."' usemap = '#hazards' /></a>";

print_r ($image_tag);

print_r ($image_map);
 

}

?>