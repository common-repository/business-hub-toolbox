/*
* custom js for Event Calendar
*/

jQuery(function (jQuery) {
    jQuery("div.past").slice(0, 4).show();
	size_past = jQuery("#tab-item-1 div.event-fun-wrapper").size();
	size_future = jQuery("#tab-item-3 div.event-fun-wrapper").size();
	load_future = jQuery("#tab-item-3 div.future").size();
	load_past = jQuery("#tab-item-1 div.past").size();
	past = 1;
	future = 1;
	if( load_past <= 4 ){
		jQuery('#loadMore').hide();
	}
    jQuery("#loadMore").on('click', function (e) {
        e.preventDefault();
		past= (past+2 <= size_past) ? past+2 : size_past;
        jQuery("div.past:hidden").slice(0, 4).slideDown();
        if (jQuery("div.past:hidden").length == 0) {
            jQuery("#load").fadeOut('slow');
        }
        jQuery('html,body').animate({
            scrollTop: jQuery(this).offset().top
        }, 1500);
		if(past == size_past){
            jQuery('#loadMore').hide();
        }
    });
    jQuery("div.future").slice(0, 4).show();
	if( load_future <= 4 ){
		jQuery('#loadMore_future').hide();
	}
    jQuery("#loadMore_future").on('click', function (e) {
        e.preventDefault();
		future= (future+2 <= size_future) ? future+2 : size_future;
        jQuery("div.future:hidden").slice(0, 4).slideDown();
        if (jQuery("div.future:hidden").length == 0) {
            jQuery("#load").fadeOut('slow');
        }
        jQuery('html,body').animate({
            scrollTop: jQuery(this).offset().top
        }, 1500);
		if(future == size_future){
            jQuery('#loadMore_future').hide();
        }
    });
});

jQuery(document).ready(function ($) {
//Horizontal Tab
jQuery('#parentHorizontalTab').easyResponsiveTabs({
    type: 'default', //Types: default, vertical, accordion
    width: 'auto', //auto or any width like 600px
    fit: true, // 100% fit in a container
    tabidentify: 'hor_1', // The tab groups identifier
    activate: function (event) { // Callback function if tab is switched
        var $tab = $(this);
        var $info = $('#nested-tabInfo');
        var $name = $('span', $info);
        $name.text($tab.text());
        $info.show();
    }
});

});
