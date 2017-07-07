<?php

if( ! class_exists('CurlyRenderCSS') ) return;


/*	Colors
	================================================= */

	$curly_color_text =
		new CurlyThemesColor( get_theme_mod( 'color_text', '#1E1E1E' ) );
	$curly_color_bg =
		new CurlyThemesColor( get_theme_mod( 'color_bg', '#faf6f0' ) );
	$curly_color_primary =
		new CurlyThemesColor( get_theme_mod( 'color_primary', '#C0392B' ) );
	$curly_color_link =
		new CurlyThemesColor( get_theme_mod( 'color_links', '#c0392b' ) );
	$curly_color_hover =
		new CurlyThemesColor( get_theme_mod( 'color_links_hover', '#1E1E1E' ) );
	/**
	$this->_color_header =
		new CurlyThemesColor( get_theme_mod( 'header_text_color', '#ffffff' ) );
	$this->_color_header_bg	=
		new CurlyThemesColor( get_theme_mod( 'header_shading_color', 'rgba(0,0,0, 0.55)' ) );
	*/
	$curly_color_footer_text =
		new CurlyThemesColor( get_theme_mod( 'footer_text_color', '#9C9996' ) );
	/**
	$this->_color_footer_bg =
		new CurlyThemesColor( get_theme_mod( 'footer_bg_color', '#0E0905' ) );
	*/
	$curly_color_footer_link =
		new CurlyThemesColor( get_theme_mod( 'footer_link_color', '#9C9996' ) );
	$curly_color_footer_title =
		new CurlyThemesColor( get_theme_mod( 'footer_title_color', '#FFFFFF' ) );
	$curly_color_h1 =
		new CurlyThemesColor( get_theme_mod( 'color_h1', '#1E1E1E' ) );
	$curly_color_h2 =
		new CurlyThemesColor( get_theme_mod( 'color_h2', '#1E1E1E' ) );
	$curly_color_h3 =
		new CurlyThemesColor( get_theme_mod( 'color_h3', '#1E1E1E' ) );
	$curly_color_h4 =
		new CurlyThemesColor( get_theme_mod( 'color_h4', '#1E1E1E' ) );
	$curly_color_h5 =
		new CurlyThemesColor( get_theme_mod( 'color_h5', '#1E1E1E' ) );
	$curly_color_h6 =
		new CurlyThemesColor( get_theme_mod( 'color_h6', '#1E1E1E' ) );
	$curly_color_menu =
		new CurlyThemesColor( get_theme_mod( 'color_menu_bg', '#C0392B' ) );
	$curly_color_menu_link =
		new CurlyThemesColor( get_theme_mod( 'color_menu_text', '#FFFFFF' ) );
	$curly_color_menu_hover =
		new CurlyThemesColor( get_theme_mod( 'color_menu_hover_text', '#E09C95' ) );
	$curly_color_submenu =
		new CurlyThemesColor( get_theme_mod( 'color_submenu_bg', '#ffffff' ) );
	$curly_color_submenu_link =
		new CurlyThemesColor( get_theme_mod( 'color_submenu_text', '#33332E' ) );
	$curly_color_submenu_hover =
		new CurlyThemesColor( get_theme_mod( 'color_submenu_hover_text', '#c0392b' ) );

/*	Shortcodes
	================================================= */
	$curly_css_output = null;

/*	Shortcodes - Accordion
	================================================= */
	$curly_css_output .= '
				:not(.wc-tabs-wrapper) > .panel{
					border-bottom: 1px solid '.$curly_color_text->opacity(0.15).';
				}
				footer .panel{
					border-bottom: 1px solid '.$curly_color_footer_text->opacity(0.15).';
				}';

/*	Shortcodes - Button
	================================================= */
	$curly_css_output .= '.btn,
				.btn:visited,
				.btn:active,
				.btn:focus,
				input[type="button"],
				input[type="submit"],
				.button:not(.wc-forward){
					background: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().';
				}
				.btn:hover,
				input[type="button"]:hover,
				input[type="submit"]:hover,
				.button:not(.wc-forward):hover{
					background: '.$curly_color_primary->darken().';
					color: '.$curly_color_primary->contrast().';
				}';

/*	Shortcodes - Action Boxes
	================================================= */
	$curly_css_output .= '.action-box{
					background: '.$curly_color_text->opacity(0.075).';
				}
				.action-box.style-1{
					border-color: '.$curly_color_text->opacity(0.25).';
					border-top-color: '.$curly_color_primary.';
				}
				.action-box.style-2{
					border-left-color: '.$curly_color_primary.';
				}
				.action-box.style-3{
					border-color: '.$curly_color_text->opacity(0.25).';
				}
				.action-box.style-4{
					border-color: '.$curly_color_text->opacity(0.25).';
				}
				.action-box.style-5{
					border-color: '.$curly_color_text->opacity(0.25).';
				}';

/*	Shortcodes - Event Agenda
	================================================= */
	$curly_css_output .= '.event-agenda .row{
					border-bottom: 1px solid '.$curly_color_text->opacity(0.15).';
				}
				.event-agenda .row:hover{
					background: '.$curly_color_text->opacity(0.05).';
				}';

/*	Shortcodes - Box
	================================================= */
	$curly_css_output .= '.well{
					border-top: 3px solid '.$curly_color_text->opacity(0.25).';
				}
				.well-1{
					border-top: 3px solid '.$curly_color_primary.'
				}
				.well-2:hover .fa{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().'
				}
				.well-2:hover h3{
					border-color: '.$curly_color_primary.';
					color: '.$curly_color_primary.'
				}
				.well-3 .fa{
					border-color: '.$curly_color_text.';
					color: '.$curly_color_text.'
				}
				.well-3:hover .fa,
				.well-3:hover h3{
					border-color: '.$curly_color_primary.';
					color: '.$curly_color_primary.'
				}
				.well-4:hover .fa{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().'
				}
				.well-4:hover h3{
					border-color: '.$curly_color_primary.';
					color: '.$curly_color_primary.'
				}
				.well-5 .fa{
					background-color: '.$curly_color_text.';
					color: '.$curly_color_text->contrast().'
				}
				.well-5:hover .fa{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().'
				}
				.well-5:hover h3{
					color: '.$curly_color_primary.'
				}
				.well-5 > div{
					background: '.$curly_color_text->opacity(0.075).';
				}';

/*	Shortcodes - Slider
	================================================= */
	$curly_css_output .= '.carousel .carousel-control{
					background: '.$curly_color_text->opacity(0.45).';
				}';

/*	Shortcodes - Divider
	================================================= */
	$curly_css_output .= '.divider.one	{ border-top: 1px solid '.$curly_color_text->opacity(0.25).'; height: 1px; }
				.divider.two	{ border-top: 1px dotted '.$curly_color_text->opacity(0.25).'; height: 1px; }
				.divider.three	{ border-top: 1px dashed '.$curly_color_text->opacity(0.25).'; height: 1px; }
				.divider.four	{ border-top: 3px solid '.$curly_color_text->opacity(0.25) .'; height: 1px; }
				.divider.fire	{ border-top: 1px solid '.$curly_color_text->opacity(0.25) .'; height: 1px; }';

/*	Shortcodes - Tabs
	================================================= */
	$curly_css_output .= '.tab-content{
					border-bottom: 1px solid '.$curly_color_text->opacity(0.15).';
					border-top: 3px solid '.$curly_color_primary.';
				}
				.nav-tabs .active>a,
				.nav-tabs .active>a:hover,
				.nav-tabs .active>a:focus{
					background: '.$curly_color_primary.' !important;
					border-bottom: 1px solid red;
					color: '.$curly_color_primary->contrast().' !important;
				}
				.nav-tabs li a:hover{
					background: '.$curly_color_text->opacity(0.07).';
				}';

/*	Shortcodes - Toggle
	================================================= */
	$curly_css_output .= 'h6[data-toggle="collapse"] i{
					color: '.$curly_color_primary.';
					margin-right: 10px
				}';

/*	Shortcodes - Progress
	================================================= */
	$curly_css_output .= '
				.progress{
					background-color: '.$curly_color_text->opacity(0.1).';
				}
				.progress .progress-bar-default{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().';
				}';

/*	Shortcodes - Blockquote
	================================================= */
	$curly_css_output .= 'blockquote{
					border-color: '.$curly_color_primary.';
				}
				.blockquote i:before{
					color: '.$curly_color_link.';
				}
				.blockquote cite{
					color: '.$curly_color_link.';
				}
				.blockquote img{
					border: 5px solid '.$curly_color_text->opacity(0.2).';
				}';

/*	Shortcodes - Testimonials
	================================================= */
	$curly_css_output .= '.testimonials blockquote{
					background: '.$curly_color_text->opacity(0.07).';
				}
				.testimonials blockquote:before,
				.testimonials cite{ color: '.$curly_color_primary.'; }';

/*	Shortcodes - Lists
	================================================= */
	$curly_css_output .= '*[class*=\'list-\'] li:before{
					color: '.$curly_color_primary.';
				}';

/*	Shortcodes - Person
	================================================= */
	$curly_css_output .= '.person img{
					border: 5px solid '.$curly_color_text->opacity(0.2).';
				}';

/*	Shortcodes - Clients Carousel
	================================================= */
	$curly_css_output .= '.clients-carousel-container .next,
				.clients-carousel-container .prev{
					background-color: '.$curly_color_text->opacity(0.5).';
					color: '.$curly_color_text->contrast().';
				}
				.clients-carousel-container:hover .next,
				.clients-carousel-container:hover .prev{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().';
				}';

/*	Shortcodes - Pricing Tables
	================================================= */
	$curly_css_output .= '.wl-pricing-table .content-column{
					background-color: '.$curly_color_text->opacity(0.05).';
				}
				.wl-pricing-table .content-column h4 *:after,
				.wl-pricing-table .content-column h4 *:before{
					border-top: 3px double '.$curly_color_text->opacity(0.2).';
				}

				.wl-pricing-table.light .content-column.highlight-column{
					background-color: '.$curly_color_primary.';
					color: '.$curly_color_primary->contrast().';
				}
				.wl-pricing-table.light .content-column.highlight-column h3,
				.wl-pricing-table.light .content-column.highlight-column h4{
					color: '.$curly_color_text->contrast().';
				}
				.wl-pricing-table.light .content-column.highlight-column h4 *:after,
				.wl-pricing-table.light .content-column.highlight-column h4 *:before{
					border-top: 3px double '.$curly_color_text->contrast(0.2).'
				}';

/*	Widget
	================================================= */
	$curly_css_output .= "
		.recent-posts time{
			background-color: {$curly_color_text->contrast()};
			color: {$curly_color_text->opacity(0.5)}
		}
		.recent-posts time em{
			color: $curly_color_primary
		}
	";
?>
