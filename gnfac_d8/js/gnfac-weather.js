jQuery(document).ready(function ($) {
    $('select[name="field_bridgers_weather_station"]').change(function() {
			var bridgers_station = '_'+$('#edit-field-bridgers-weather-station').val() ;
			
			var bridgers_station_values = { swe: '1.03', snow_depth: '44.2' };
			drupalSettings.gnfac_d8.gnfac_weather.bridgers.forEach( bridgerStations );
			
			console.log(drupalSettings.gnfac_d8.gnfac_weather.bridgers.bridgers_station.swe );
			console.log(drupalSettings.gnfac_d8.gnfac_weather.bridgers._13920.swe );
			
			console.log( 'bridgers station: ' + bridgers_station);
      //$('#edit-field-bridgers-swe-0-value').val(drupalSettings.gnfac_d8.gnfac_weather.bridgers..swe );

    });
});

function bridgerStations( item, key, array ){
	$('#edit-field-bridgers-swe-0-value').val
}