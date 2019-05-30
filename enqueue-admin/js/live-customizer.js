(function($) {
  "use strict";
	
	function hextorgb(hex, opacity) {
		
		hex = hex.trim();
		
		if( hex === 'transparent' ){
			return 'transparent';
		} else if( hex.substr(0, 4) === 'rgb(' ){
			opacity = opacity ? opacity : 1;
			hex = hex.substr(5, -1);
			return 'rgba( '+ hex +' , '+ opacity +' )';
		} else if( hex.substr(0, 4) === 'rgba' ){
			hex = hex.substr(5, -1);
			hex = hex.split(',');
			opacity = opacity ? opacity : hex[3];
			return 'rgba( '+ hex[0] +' , '+ hex[1]+' , '+ hex[2] +' , '+ opacity +' )';
		} else {
			opacity = opacity ? opacity : 1;
			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	    result = result ? {
	        r: parseInt(result[1], 16),
	        g: parseInt(result[2], 16),
	        b: parseInt(result[3], 16)
	    } : null;
	    
	    return 'rgba( ' + result.r + ',' + result.g + ',' + result.b + ',' + opacity + ' )';
		}
	}

	// Background Color
	wp.customize( 'background_color_body', function( value ) {
		value.bind( function( newval ) { 
			$('#site').css('background-color', newval );
		} );
	} );
	
	// Navigation Color
	wp.customize( 'header_navigation', function( value ) {
		value.bind( function( newval ) { 
			$('#main-nav').css('background-color', newval );
		} );
	} );
	
	/** Boxed Color */
	wp.customize( 'background_color_box', function( value ) {
		value.bind( function( newval ) {
			$('#content').css( 'background', newval );
		} );
	} );
	
	// Shading Color
	wp.customize( 'header_shading_color', function( value ) {
		value.bind( function( newval ) { 
			$('.header-row').css('background-color', newval );
		} );
	} );
	
	// Header Text Color
	wp.customize( 'header_text_color', function( value ) {
		value.bind( function( newval ) { 
			$('.header-row, .absolute-header a').css('color', newval );
			$('#secondary-nav .menu > .menu-item > a, #secondary-nav .sub-menu').css({ 'color' : newval, 'border-color': newval } );
		} );
	} );
	
	// Navigation Color
	wp.customize( 'header_navigation_text', function( value ) {
		value.bind( function( newval ) { 
			if( curly_navigation_text_color( newval ) === false ){
				$('#main-nav .sub-menu').css({ 'color' : '', 'border-color': '' } );
				$('#main-nav .menu > .menu-item > a, #main-nav .menu > .page_item > a, #main-nav .menu > .current-menu-item > a, #main-nav .menu > .current-menu-ancestor > a, #main-nav .menu > .current_page_parent > a, #main-nav div.menu > ul > .current_page_item > a, #main-nav div.menu > ul > .current_page_parent > a, #main-nav div.menu > ul > .current_page_ancestor > a, #main-nav .menu > .current-menu-item, #main-nav .menu > .current-menu-ancestor, #main-nav .menu > .current_page_parent, #main-nav div.menu > ul > .current_page_item, #main-nav div.menu > ul > .current_page_parent, #main-nav div.menu > ul > .current_page_ancestor, #search-form, #search-form .search-field, #search-form .close-search, #search-form-inline .search-field, #custom-search-form, #search-form .search-field').css('color', '' );
			} else {
				$('#main-nav .sub-menu').css({ 'color' : newval, 'border-color': newval } );
				$('#main-nav .menu > .menu-item > a, #main-nav .menu > .page_item > a, #search-form, #search-form .search-field, #search-form .close-search, #search-form-inline .search-field, #custom-search-form, #search-form .search-field').css('color', newval );
				$('#main-nav .menu > .current-menu-item > a, #main-nav .menu > .current-menu-ancestor > a, #main-nav .menu > .current_page_parent > a, #main-nav div.menu > ul > .current_page_item > a, #main-nav div.menu > ul > .current_page_parent > a, #main-nav div.menu > ul > .current_page_ancestor > a, #main-nav .menu > .current-menu-item, #main-nav .menu > .current-menu-ancestor, #main-nav .menu > .current_page_parent, #main-nav div.menu > ul > .current_page_item, #main-nav div.menu > ul > .current_page_parent, #main-nav div.menu > ul > .current_page_ancestor').css( 'color', hextorgb( newval, 0.75) );
			}
		} );
	} );
	
	// Footer Backgrund Color
	wp.customize( 'footer_color_bg', function( value ) {
		value.bind( function( newval ) { 
			$('#footer').css('background-color', newval );
		} );
	} );
	
	// Footer Text Color
	wp.customize( 'footer_color_text', function( value ) {
		value.bind( function( newval ) { 
			$('#footer').css('color', newval );
			$('#footer abbr').css( 'border-bottom-color', hextorgb( newval, 0.65 ) );
		} );
	} );
	
	// Footer Link Color
	wp.customize( 'footer_color_links', function( value ) {
		value.bind( function( newval ) { 
			$('#footer a, #footer abbr[title]').css('color', newval );
			$('#footer abbr[title]').css('border-bottom-color', newval );
		} );
	} );
	
	// Footer Titles Color
	wp.customize( 'footer_color_titles', function( value ) {
		value.bind( function( newval ) { 
			$('#footer .widget-title').css('color', newval );
			$('#main-footer + #absolute-footer .widget').css( 'border-top-color', hextorgb( newval, 0.1 ) );
		} );
	} );
	
	// H1 Color
	wp.customize( 'color_h1', function( value ) {
		value.bind( function( newval ) { 
			$('h1, h1 small').css('color', newval );
		} );
	} );
	
	// H2 Color
	wp.customize( 'color_h2', function( value ) {
		value.bind( function( newval ) { 
			$('h2, h2 small').css('color', newval );
		} );
	} );
	
	// H3 Color
	wp.customize( 'color_h3', function( value ) {
		value.bind( function( newval ) { 
			$('h3, h3 small').css('color', newval );
		} );
	} );
	
	// H4 Color
	wp.customize( 'color_h4', function( value ) {
		value.bind( function( newval ) { 
			$('h4, h4 small').css('color', newval );
		} );
	} );
	
	// H5 Color
	wp.customize( 'color_h5', function( value ) {
		value.bind( function( newval ) { 
			$('h5, h5 small').css('color', newval );
		} );
	} );
	
	// H6 Color
	wp.customize( 'color_h6', function( value ) {
		value.bind( function( newval ) { 
			$('h6, h6 small').css('color', newval );
		} );
	} );
	
	
	// Link Color
	wp.customize( 'link_color', function( value ) {
		value.bind( function( newval ) {
			if( curly_navigation_text_color( wp.customize.instance('header_navigation_text').get() ) === true ){
				$('#content a:not(.btn-primary), blockquote p, .pullquote, .btn.btn-link, .btn.btn-default, .panel-default > .panel-heading .accordion-toggle.collapsed, #footer a:hover, #footer .widget-title, .owl-theme .owl-controls .owl-nav [class*=owl-], #search-form .close-search, .sidebar-widget h5, .room.dark h4').css('color', newval );
				$('.embed-responsive').css('border-color', newval );
				$('.fa-boxed:not(.fa-facebook, .fa-twitter, .fa-rss, .fa-pinterest)').css( 'background-color', newval );
				$('.btn.btn-default').css( 'border-color', hextorgb( newval, 0.5 ) );
				$('.btn.btn-default:hover, .services-carousel .item:hover .item-content, .pricing-table .content-column').css( 'background-color', hextorgb( newval, 0.1 ) );
			} else {
				$('#main-nav li:not(.current-menu-item) a, #content a:not(.btn-primary), blockquote p, .pullquote, .btn.btn-link, .btn.btn-default, .panel-default > .panel-heading .accordion-toggle.collapsed, #footer a:hover, #footer .widget-title, .owl-theme .owl-controls .owl-nav [class*=owl-], #search-form .close-search, .sidebar-widget h5, #custom-search-form, .room.dark h4').css('color', newval );
				$('.embed-responsive').css('border-color', newval );
				$('.fa-boxed:not(.fa-facebook, .fa-twitter, .fa-rss, .fa-pinterest)').css( 'background-color', newval );
				$('#main-nav .menu > .menu-item:not(.current-menu-item):hover > a, .btn.btn-default').css( 'border-color', hextorgb( newval, 0.5 ) );
				$('.btn.btn-default:hover, .services-carousel .item:hover .item-content, .pricing-table .content-column').css( 'background-color', hextorgb( newval, 0.1 ) );
			}
		} );
	} );
	
	// Text Color
	wp.customize( 'text_color', function( value ) {
		value.bind( function( newval ) {
			$('html, body, a:hover, h1 small, h2 small, h3 small, h4 small, h5 small, h6 small, .btn.btn-link:hover, #site, #main-nav, #map-description .col-lg-4 > div, .panel-default > .panel-heading .accordion-toggle.collapsed:hover, #goog-wm-qt, #main-nav .sub-menu .menu-item:hover > a, .form-control, #footer, #footer a').css('color', newval );
			$('.panel.panel-default, #goog-wm-qt, .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, #isotope .item-content, .nav-tabs > li > a, .tab-pane, .nav-tabs, .form-control').css( 'border-color' , hextorgb( newval, 0.25 ) );
			$('.panel-default > .panel-heading .accordion-toggle.collapsed, #main-nav .sub-menu .menu-item:hover > a, #isotope .item:hover .item-content, .nav-tabs > li > a, .nav-tabs > li > a:hover').css( 'background-color' , hextorgb( newval, 0.25 ) );
			$('.pullquote.pull-left').css( 'border-right', '3px solid '+hextorgb( newval, 0.25 ) );
			$('.pullquote.pull-right').css( 'border-left', '3px solid '+hextorgb( newval, 0.25 ) );
			$('#search-form-inline').css( 'border-top', '1px solid '+hextorgb( newval, 0.25 ) );
			$('.comments > ul > li > ul').css( 'border-left', '1px solid '+hextorgb( newval, 0.25 ) );
			$('.comments h6').css( 'border-bottom', '1px solid '+hextorgb( newval, 0.25 ) );
			$('.form-control:focus').css( 'border-color', hextorgb( newval, 0.65 ) );
			$('#main-footer + #absolute-footer .widget').css( 'border-color', hextorgb( newval, 0.1 ) );
			$('#secondary-nav .sub-menu').css( 'background-color', hextorgb( newval, 0.1 ) );
		} );
	} );
	
	// Primary Color
	wp.customize( 'primary_color', function( value ) {
		value.bind( function( newval ) {
			$('#main-nav .menu > .current-menu-item > a, .btn.btn-link:hover::before').css('color', newval ).css('border-top-color', newval );
			$('#main-nav .sub-menu, .btn.btn-primary:hover').css('color', newval ).css('border-color', newval );
			$('h5:not(.widget-title)').css('color', newval );
			$('blockquote').css('color', newval );
			$('.list-bullet li::before, .list-square li::before, .list-center li::before, .list-center li::after').css('color', newval );
			$('.list-pointer li::before').css('border-color', 'transparent transparent transparent' + newval );
			$('.btn.btn-primary, #commentform input[type="submit"]').css('background-color', newval ).css('border-color', newval );
			$('.btn.btn-link::before').css('color', newval );
			$('.panel-default > .panel-heading .accordion-toggle').css('color', newval );
			$('.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus').css('color', newval );
			$('.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span').css('color', newval );
			$('.owl-theme .owl-controls .owl-nav .owl-next:after, .owl-theme .owl-controls .owl-nav .owl-prev:before').css('color', newval );
			$('.form-group[data-required]::before, div[data-required]::before').css('color', newval );
			$('#goog-wm-sb').css('background', newval ).css('border-color', newval );
			$('.entry h1 > small, .entry h2 > small, .entry h3 > small, .entry.quote blockquote > small').css('color', newval );
			$('.meta .fa').css('color', newval );
			$('.entry-meta, .entry-meta a, .entry h1 > small, .entry h2 > small, .entry h3 > small, .entry.quote blockquote > small').css('color', newval );
			$('.comments .comment-author h6').css('border-bottom-color', newval );
			$('#main-nav .menu > .current-menu-item > a, #main-nav .menu > .current-menu-ancestor > a, #main-nav .sub-menu, h5:not(.widget-title), blockquote, .list-bullet li::before, .list-square li::before, .list-center li::before, .list-center li::after, .btn.btn-link::before, .panel-default > .panel-heading .accordion-toggle, .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span, .owl-theme .owl-controls .owl-nav .owl-next:after, .owl-theme .owl-controls .owl-nav .owl-prev:before, .form-group[data-required]::before, div[data-required]::before, .entry h1 > small, .entry h2 > small, .entry h3 > small, .entry.quote blockquote > small, .meta .fa, .list-center li::before, .list-center li::after, hr').css( 'color', newval );
			$('#main-nav .menu > .current-menu-item > a, #main-nav .menu > .current-menu-ancestor > a, #main-nav .sub-menu').css( 'border-color', newval );
		} );
	} );
	
	/** Box Background Color */
	wp.customize( 'background_color_box', function( value ) {
		value.bind( function( newval ) { 
			$('#content').css( 'background-color', newval );
		} );
	} );
	
	// Layout Size
	wp.customize( 'layout_size', function( value ) {
		value.bind( function( newval ) {
			$('#site').css( 'max-width', newval );
		} );
	} );
	
	
	// Footer Columns
	wp.customize( 'footer_columns', function( value ) {
		value.bind( function( newval ) {
			
			var css = null;
			
			switch ( newval ) {
				case '1' : css = 'col-sm-12 col-md-12'; break;
				case '2' : css = 'col-sm-6 col-md-6'; break;
				case '3' : css = 'col-sm-4 col-md-4'; break;
				case '4' : css = 'col-sm-4 col-md-3'; break;
				case '6' : css = 'col-sm-4 col-md-2'; break;
			}
			$('#main-footer > aside').each(function () {
				$(this)
					.removeClass('col-sm-2 col-sm-3 col-sm-4 col-sm-6 col-sm-12 col-md-2 col-md-3 col-md-4 col-md-6 col-md-12 col-lg-2 col-lg-3 col-lg-4 col-lg-6 col-lg-12')
					.addClass(css);
			});
		} );
	} );
	
	// Copyright
	wp.customize( 'footer_copyright', function( value ) {
		value.bind( function( newval ) {
			if ( newval === 0 ) {
				$('#absolute-footer').hide();
			} else {
				$('#absolute-footer').show();
				$('.widget > p', '#absolute-footer').html( newval );
			}
		} );
	} );
	
	// Header Color
	wp.customize( 'header_bg_color', function( value ) {
		value.bind( function( newval ) {
			$('#header').css( 'background-color', newval );
		} );
	} );
	
	/** Menu Height */
	wp.customize( 'header_height', function( value ) {
		value.bind( function( newval ) {
			$('#main-nav ul.menu > .menu-item > a, #main-nav div.menu > ul > .page_item > a, #logo')
				.css({ 'height': newval + 'px', 'line-height': newval + 'px' });
			$('#main-nav ul.menu > .current-menu-item > a, #main-nav ul.menu > .current-menu-ancestor > a, #main-nav ul.menu > .current_page_parent > a, #main-nav div.menu > ul > .current_page_item > a, #main-nav div.menu > ul > .current_page_parent > a, #main-nav div.menu > ul > .current_page_ancestor > a')
				.css({ 'height': newval + 'px', 'line-height': newval - 6 + 'px' });
			$('.sticky-wrapper #main-nav.stuck ul.menu > .menu-item > a, .sticky-wrapper #main-nav.stuck div.menu > ul > .page_item > a, .stuck #logo')
				.css({ 'height': Math.floor( newval / 1.333333333 ) + 'px', 'line-height': Math.floor( newval / 1.333333333 ) + 'px' });
			$('.sticky-wrapper #main-nav.stuck ul.menu > .current-menu-item > a, .sticky-wrapper #main-nav.stuck ul.menu > .current-menu-ancestor > a, .sticky-wrapper #main-nav.stuck ul.menu > .current_page_parent > a, .sticky-wrapper #main-nav.stuck div.menu > ul > .current_page_item > a, .sticky-wrapper #main-nav.stuck div.menu > ul > .current_page_parent > a, .sticky-wrapper #main-nav.stuck div.menu > ul > .current_page_ancestor > a')
				.css({ 'height': Math.floor( newval / 1.333333333 ) + 'px', 'line-height': Math.floor( newval / 1.333333333 ) - 6 + 'px' });
			$('#search-form .search-field').css( 'height', newval + 'px' );
			$('#search-form .close-search').css( 'line-height', newval + 'px' );
			$('.sticky-wrapper #main-nav.stuck #search-form .search-field').css( 'height', Math.floor( newval / 1.333333333 ) + 'px' );
			$('.stuck #search-form .close-search').css( 'line-height', Math.floor( newval / 1.333333333 ) + 'px' );
			$('.sticky-wrapper').css( 'min-height', newval + 'px' );
		} );
	} );
	
	/** Menu Search */
	wp.customize( 'search_menu', function( value ) {
		value.bind( function( newval ) {
			if( newval === true ) {
				$('.search-button').show();
			} else{
				$('.search-button').hide();
			}
		} );
	} );
	
	/** Header Align */
	wp.customize( 'header_alignment', function( value ) {
		value.bind( function( newval ) {
			switch ( newval ) {
				case 'right' :
					$('#main-nav ul.menu, #main-nav div.menu > ul').css( 'float', 'right' );
					break;
				case 'left' :
					$('#main-nav ul.menu, #main-nav div.menu > ul').css({ 'float' : 'left', 'margin-left' : '2.8rem' });
					break;
			}
		} );
	} );
	
	/** Layout Size */
	wp.customize( 'layout_size', function( value ) {
		value.bind( function( newval ) {
			if( newval === '100%' ){
				$('#site, .sticky-wrapper #main-nav.stuck').css( 'max-width', newval );
				$('#content').css( 'background', 'transparent' );
			} else {
				$('#site, .sticky-wrapper #main-nav.stuck').css( 'max-width', newval );
				$('#content').css( 'background', wp.customize.instance('background_color_box').get() );
			}
		} );
	} );
	
	/** Function Box Color */
	function curly_navigation_text_color( check ){
		if( check === null || check === '' || check === 'transparent' || check === 'none' || ! check ){
			return false;
		} else {
			return true;
		}
	}
	
})(jQuery);