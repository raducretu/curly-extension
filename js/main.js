jQuery(document).ready(function(){
	"use strict";
	
	if ( jQuery('.video-container').length > 0 ) {
		jQuery(".video-container").fitVids();
    }
	
	// Accordion
	if ( jQuery('.panel-group').length > 0 ) {
		jQuery('.panel-group').each(function () {
			if ( jQuery(this).find('.in').length == 0 ) {
				jQuery('.panel:first-child .panel-collapse' , jQuery(this)).addClass('in');
				jQuery('.panel:first-child .accordion-toggle' , jQuery(this)).removeClass('collapsed');
			}
		});
	}
		
	if( jQuery('.zoom-picture').length > 0 ) { 
		jQuery('.zoom-picture').zoom();
	}
	
});

(function($) {
	"use strict";
	
	/** Gallery Isotope */
  	$(function() {
  	    if ( $('.recent-posts .recent-post').length > 0 ) {
	  	    var $recent = $('.recent-posts');
	  	    $recent.imagesLoaded(function(){
		  	    $recent.masonry({
				  itemSelector: '.recent-post'
				});
	  	    });
  	    }
  	});
	
})(jQuery);


if ( jQuery('.fullwidth-row').length >0 ) {
	jQuery('.fullwidth-row').each(function () {
		if ( jQuery.trim(jQuery(this).prev().not('div.fullwidth-row').children('.row').children('.col-lg-12').html()).length == 0 ) {
			jQuery(this).prev().not('div.fullwidth-row').remove();
		}
		if ( jQuery.trim(jQuery(this).next().not('div.fullwidth-row').children('.row').children('.col-lg-12').html()).length == 0) {
			jQuery(this).next().not('div.fullwidth-row').remove();
		}
	});
}