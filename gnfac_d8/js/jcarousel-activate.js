// A $( document ).ready() block.
jQuery(document).ready(function ($) {


console.log( "ready!" );

$(function() {
    $('#seven-day-forecast-container').jcarousel();
		
		
});

// equalize forecast heights
$(function () {
	var maxh = 0;
	$(".forecast-tombstone .short-desc").each(function () {
		var h = $(this).height();
		if (h > maxh) { maxh = h; }
	});
	$(".forecast-tombstone .short-desc").height(maxh);
});

});