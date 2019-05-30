(function($) {
  "use strict";
	
	/** Allow JS */
	wp.customize( 'custom_js_check', function( value ) {
		value.bind( function( ) { 
			$('#customize-control-custom_js').toggle();
		} );
	} );
	
	/** Check Boxed Content */
	wp.customize( 'footer_style', function( value ) {
		value.bind( function( newval ) { 
			if( newval === '2' ) {
				wp.customize.control( 'footer_bg' ).activate();
				wp.customize.control( 'footer_bg_repeat' ).activate();
				wp.customize.control( 'footer_bg_position' ).activate();
			} else {
				wp.customize.control( 'footer_bg' ).deactivate();
				wp.customize.control( 'footer_bg_repeat' ).deactivate();
				wp.customize.control( 'footer_bg_position' ).deactivate();
			}
		} );
	} );
	
	$(function() {
		$('option[value^=rev_]', '#customize-control-header_slider' ).first().before('<option disabled>Revolution Sliders:</option>');
		$('option[value^=layer_]', '#customize-control-header_slider' ).first().before('<option disabled>Layer Sliders:</option>');
	});
	
})(jQuery);