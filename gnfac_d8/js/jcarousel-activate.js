// A $( document ).ready() block.
jQuery(document).ready(function ($) {

  console.log( "Ready! ...Set!" );
	
    $('#seven-day-forecast-container').jcarousel();

  $('.colorbox').triggerHandler("click");
	
//
// equalize forecast heights
// taken from noaa website inline script
// 
	
	

  $(function () {
	  var maxh = 0;
	  $(".forecast-tombstone .short-desc").each(function () {
		  var h = $(this).height();
		  if (h > maxh) { maxh = h; }
	  });
	  $(".forecast-tombstone .short-desc").height(maxh);
  });

});

//
// this routine makes external links open in a new window 
//
this.blankwin = function(){
	var hostname = window.location.hostname;
	hostname = hostname.replace("www.","").toLowerCase();
	var a = document.getElementsByTagName("a");	
	this.check = function(obj){
		var href = obj.href.toLowerCase();
		return (href.indexOf("http://")!=-1 && href.indexOf(hostname)==-1 && href.indexOf('fsavalanche.org')==-1 ) ? true : false;				
	};
	this.set = function(obj){
		obj.target = "_blank";
		obj.className = "external";
	};	
	for (var i=0;i<a.length;i++){
		if(check(a[i])) set(a[i]);
	};		
};

this.addEvent = function(obj,type,fn){
	if(obj.attachEvent){
		obj['e'+type+fn] = fn;
		obj[type+fn] = function(){obj['e'+type+fn](window.event );}
		obj.attachEvent('on'+type, obj[type+fn]);
	} else {
		obj.addEventListener(type,fn,false);
	};
};
addEvent(window,"load",blankwin);

/* Make table headers stick to the top */
/*experimental, added from drupal stack exchange
/* Put tables inside two divs */
var tables = $(".nrcstable");
tables.each(function(){
    var parent = $(this).parent();
    var container = $("<div class='table-container'></div>");
    container.append($(this));
    parent.append(container);
});

var inners = $(".table-container");
inners.each(function(){
    var parent = $(this).parent();
    var container = $("<div class='outer'></div>");
    container.append($(this));
    parent.append(container);
});

var widths = new Array();

//create array of <th> widths
var i = 0;
$('tbody tr:first td').each(function () {
    widths[i] = $(this).width();
    i++;
});

// Make th have same size as td
i = 0;
$('thead > tr > th').each(function(){
    $(this).width(widths[i] + 1);
    i++;
})


/* ------------- Reposition the thead so it won't overlap -----------------*/
var h = 0;
// Move the thead up. 
$('thead').each(function(){
    h =$(this).height();
    $(this).css('top', -$(this).height() + 1)
})

 //Now move the whole table down same distance
$('.outer').each(function(){
     $(this).css('top', h);
})
/** End code from drupal.stackexchange.com */
