jQuery(document).ready(function ($) {
		// Detect change events on the region selects and fill out the associated text fields
		// with values from the drupalSettings array
		$('#node-wx-log-form').on('change', 'select[id^=edit-field][id$=weather-station]', function(e) {
				// the value of the select is the station ID
				// prepend an underscore to match drupalSettings array
				var stationId = '_' + e.target.value;

				// parse out region name from the element ID
				var re = /edit-field-(.*)-weather-station/;
				var regionSelector = e.target.id.match(re)[1];
				// convert dash to underscore for drupalSettings array
				var regionSetting = regionSelector.replace('-', '_');
	
				$('#edit-field-' + regionSelector + '-swe-0-value').val(
					drupalSettings.gnfac_d8.gnfac_weather[regionSetting][stationId].swe);
				$('#edit-field-' + regionSelector + '-snow-depth-0-value').val(
					drupalSettings.gnfac_d8.gnfac_weather[regionSetting][stationId].depth);
				$('#edit-field-' + regionSelector + '-wind-avg-0-value').val(
					drupalSettings.gnfac_d8.gnfac_weather[regionSetting][stationId].wind);
				$('#edit-field-' + regionSelector + '-wind-gust-0-value').val(
					drupalSettings.gnfac_d8.gnfac_weather[regionSetting][stationId].wind_gust);
				$('#edit-field-' + regionSelector + '-wind-dir-0-value').val(
					drupalSettings.gnfac_d8.gnfac_weather[regionSetting][stationId].wind_dir);
		});
})(jQuery)