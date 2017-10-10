jQuery(document).ready(function ($) {
    $('select[name="field_advisory_region"]').change(function() {
			var region = $('#edit-field-advisory-region').val() ;
			console.log('advisory region changed: '+region);
        $('#edit-field-regions-similar-'+region).prop("checked" , true);

    });
});