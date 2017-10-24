
<?php
//
//  Find default Year and Month values from url
//
$alias = \Drupal::request()->getRequestUri();
$path = \Drupal::service('path.current')->getPath(); // of the format /node/nid

$request = explode('/' , $alias);
if ($request[1] == 'archive'){
  array_shift($request); 
  $year_default = substr( $request[2] , 2 ,2);
	$month_default = $request[3];
	$day_default = $request[4];
} elseif( substr( $alias, 0, 9 ) == '/advisory' ){
	
	if ( !is_numeric( $request[2] ) || !is_numeric( $request[3] ) || !is_numeric( $request[4] )){
	  $current_advisory = gnfac_current_advisory('node');
    $year_default = date('y', $current_advisory->created->value );
    $month_default = date('m' , $current_advisory->created->value);
    $day_default = date('d', $current_advisory->created->value);
  }else{
	  $year_default = $request[2];
	  $month_default = $request[3];
	  $day_default = $request[4];
  }
  
}

//
//   Build Year Options Array
//
for ($year = 9; $year <= (int)date('y'); $year++){
  $year_display = str_pad($year, 2, '0', STR_PAD_LEFT );
  $selected = "";
  if ($year_default){
    if($year_default == $year_display ){
       $selected = " selected = 'selected' ";
    }
  }elseif((date('Y') == $year_display)) {
      $selected =  " selected = 'selected' ";
  }
  $year_options[] ="  <option$selected value ='$year_display'>20$year_display</option>";
}
//
//   Build Month Options Array
//

$months = array("01" => 'January', "02" => 'February' , '03' => 'March',"04" => 'April',"05" => 'May' ,"06" => 'June',"07" => 'July',"08" => 'August',"09" => 'September',"10" => 'October',"11" => 'November',"12" => 'December');
for ($month = 1 ; $month < 13 ; $month++ ){
  $month_value = str_pad($month, 2, '0', STR_PAD_LEFT );
  $selected = "";
  if ($month_default) {
    if ($month_default == $month_value){
      $selected = " selected = 'selected' ";
    }
  }elseif( $month_value == date('m')){
      $selected = " selected = 'selected' ";      
  }
  $disabled = '';
  if ( ($month < 10)  && ($month > 4) ) $disabled = " disabled = 'disabled' ";
  
  $month_options[] = "  <option$selected value ='$month_value'$disabled>".$months[$month_value]."</option> ";
}

//
// Build days option array
//
for($day =1 ; $day < 32 ; $day++ ){
  $day_value = str_pad($day, 2, '0' , STR_PAD_LEFT);
  $selected = "";
  if ($day_default){
    if($day_default == $day_value){
      $selected = " selected = 'selected' ";    
    }
  }
  // would like to use disabled to disable the options for which there is no advisory,
  // but not really possible without jQuery, due to multiple month options
  // if (drupal_lookup_path($action, $path = '') $selected = " disabled = 'disabled'";
  $day_options[] = "  <option ".$selected." value ='$day_value'>".$day."</option> ";
}


?>


<p style="text-align: center;">
<form action = "#" style="text-align: center;">
<select name = "year">
  <option value ="">Any</option>
  <?php  print( implode("\n" , $year_options) );  ?>
</select>

<select name ="month">
  <option value = "" >Any</option>
<?php  
  print( implode("\n", $month_options)); 
?>
</select>


<select name = "day">
  <option value = "" >Any</option>
<?php  
  print( implode("\n", $day_options)); 
?>

</select>


<input type="button" name="submit" value="Find Forecast" onclick="fetcharchive(this.form);">

</form>
<br />
<div style = "text-align: center;">
<?php
//
//  This routine finds the next previous existing advisory, and produces a link to it.
//
//

if ( $day_default && $month_default && $year_default){
    // look for next day that theres exists an advisory
  $day_inc = $day_default-1 ; $month_inc = $month_default; $year_inc = $year_default;
    while (  (substr( \Drupal::service('path.alias_manager')->getPathByAlias( "/advisory/". str_pad($year_inc, 2, '0', STR_PAD_LEFT) ."/". str_pad($month_inc, 2, '0', STR_PAD_LEFT) ."/". str_pad($day_inc, 2, '0', STR_PAD_LEFT) ) , 0 , 5) <> '/node')
		){
			$day_inc--;
      if ($day_inc <= 0){
        $day_inc = 31; $month_inc--; 
        if ($month_inc <= 0){
          $month_inc = 12; $year_inc--;
          if ( $year_inc <= 2008 ) break;
        }
      } 
    }
    echo "<div style ='padding-top:2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px; background-color: #cccccc;border: 1px solid #aaaaaa; display: inline;'><a href='/advisory/". str_pad($year_inc, 2, '0', STR_PAD_LEFT) ."/". 
                      str_pad($month_inc, 2, '0', STR_PAD_LEFT) ."/". 
                      str_pad($day_inc, 2, '0', STR_PAD_LEFT)."' style ='text-decoration: none;'> $month_inc / $day_inc / $year_inc</a></div>&nbsp;&nbsp;<<&nbsp;&nbsp;";
} 


//
//  This routine finds the next existing advisory AFTER the indicated date, and produces a link to it.
//
//
if ( $day_default && $month_default && $year_default){
    // look for next day that theres exists an advisory
  $day_inc = $day_default + 1 ; $month_inc = $month_default; $year_inc = $year_default; $last_advisory = FALSE;
  if ( \Drupal::service('current_route_match')->getRouteName() == 'gnfac_advisory.advisory_page' ){
		$last_advisory = TRUE;
	}
    while (  substr( \Drupal::service('path.alias_manager')->getPathByAlias( "/advisory/". str_pad($year_inc, 2, '0', STR_PAD_LEFT) ."/". str_pad($month_inc, 2, '0', STR_PAD_LEFT) ."/". str_pad($day_inc, 2, '0', STR_PAD_LEFT) ) , 0 , 5) <> '/node'){
        $day_inc++;
        if ($day_inc >= 32){
          $day_inc = 0; $month_inc++; 
          if ($month_inc >= 13){
            $month_inc = 0; $year_inc++;
            if ( $year_inc >= (int) date('y') +1 ){
							$last_advisory = TRUE;
							break;
            }

          }
        } 
      } 
	if ( ! $last_advisory ){
    echo "&nbsp; >>&nbsp; <div style ='padding-top:2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px; background-color: #cccccc;border: 1px solid #aaaaaa; display: inline;'><a href='/advisory/". 
     str_pad($year_inc, 2, '0', STR_PAD_LEFT) ."/". 
     str_pad($month_inc, 2, '0', STR_PAD_LEFT) ."/". 
     str_pad($day_inc, 2, '0', STR_PAD_LEFT)."' style ='text-decoration: none;'> $month_inc / $day_inc / $year_inc</a></div>";
		}else { 
			echo "This is the most recent advisory."; 
		}
} 

?>
</div>
