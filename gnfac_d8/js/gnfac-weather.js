jQuery(document).ready(function ($) {
	console.log("Joe Debug");
    $('select[name="field_bridgers_weather_station"]').change(function() {
			var bridgers_station = '_'+$('#edit-field-bridgers-weather-station').val() ;
			
			var bridgers_station_values = { swe: '1.03', snow_depth: '44.2' };
			
			console.log(drupalSettings.gnfac_d8.gnfac_weather.bridgers._13920.swe );
			
			console.log( 'bridgers station: ' + bridgers_station);
      $('#edit-field-bridgers-swe-0-value').val(drupalSettings.gnfac_d8.gnfac_weather.bridgers._13920.swe );

    });
});
