<?php
/*
Plugin Name: Curly Themes Extension
Plugin URI: http://demo.curlythemes.com
Description: Curly Themes Extension is a collection of Shortcodes, Widgets and Plugins. This plugin exclusive for Curly Themes
Version: 2.2
Author: Curly Themes
Author URI: http://www.curlythemes.com
*/

/**
* Migration Assistant
*/
class CurlyMigrationAssistant {
	
	static function install(){
			
		self::set_value( 'page_heading', '_page_heading' ); // default now if disabled not enabled
		self::set_value( 'comments', '_general_comments_pages' );
		self::set_value( 'sharing', '_general_sharing_box_text' );
		self::set_value( 'sharing_pages', '_general_comments_pages' );
		self::set_value( 'bc', '_bc' );
		self::set_value( 'bc_text_before', '_bc_text_before' );
		self::set_value( 'bc_separator', '_bc_separator' );
		self::set_value( 'bc_text_home', '_bc_text_home' );
		self::set_value( 'bc_text_category', '_bc_text_category' );
		self::set_value( 'bc_text_search', '_bc_text_search' );
		self::set_value( 'bc_text_tag', '_bc_text_tag' );
		self::set_value( 'bc_text_author', '_bc_text_author' );
		self::set_value( 'bc_text_404', '_bc_text_404' );
		self::set_value( 'tf_user', '_theme_options_username' );
		self::set_value( 'tf_api', '_theme_options_api' );
		self::set_value( 'seo_analytics', '_seo_analytics' );
		self::set_value( 'seo_webmaster', '_seo_webmaster' );
		self::set_value( 'favicon', '_general_favicon' );
		self::set_value( 'iphone', '_general_iphone_favicon' );
		self::set_value( 'iphone_retina', '_general_iphone_favicon_retina' );
		self::set_value( 'ipad', '_general_ipad_favicon' );
		self::set_value( 'ipad_retina', '_general_ipad_favicon_retina' );
		self::set_value( 'login_box_position', '_login_box_position' );
		self::set_value( 'admin_logo', '_admin_logo' );
		self::set_value( 'admin_bg', '_admin_bg' );
		self::set_value( '404', '_404_text' );
		self::set_value( 'logo', '_logo' );
		self::set_value( 'logo_retina', '_logo_retina' );
		self::set_value( 'header_style', '_header_style' );
		self::set_value( 'logo_alignment', '_logo_alignment' );
		self::set_value( 'header_margin_top', '_header_margin_top' );
		self::set_value( 'header_margin_bottom', '_header_margin_bottom' );
		self::set_value( 'header_pattern', '_header_shading_pattern' );
		self::set_value( 'footer_logo', '_logo_footer' );
		self::set_value( 'footer_top', '_footer_margin' );
		self::set_value( 'footer_bot', '_footer_margin_bottom' );
		self::set_value( 'footer_bg', '_bg_footer_image' );
		self::set_value( 'footer_bg_repeat', '_bg_footer_repeat' );
		self::set_value( 'footer_bg_position', '_bg_footer_position' );
		self::set_value( 'bg_pattern', '_bg_pattern' );
		
		self::set_value( 'font', '_fonts_body', false, true );
		self::set_value( 'font_style', '_fonts_body_style' );
		self::set_value( 'font_size', '_fonts_body_size' );
		self::set_value( 'font_variant', '_fonts_body_variant' );
		
		self::set_value( 'font_subset', '_fonts_subset' );
		
		self::set_value( 'font_menu', '_fonts_menu', false, true );
		self::set_value( 'font_menu_style', '_fonts_menu_style' );
		self::set_value( 'font_menu_variant', '_fonts_menu_variant' );
		self::set_value( 'font_menu_size', '_fonts_menu_size');
		
		self::set_value( 'font_h1', '_fonts_h1', false, true );
		self::set_value( 'font_h1_style', '_fonts_h1_style');
		self::set_value( 'font_h1_variant', '_fonts_h1_variant' );
		self::set_value( 'font_h1_size', '_fonts_h1_size' );
		
		self::set_value( 'font_h2', '_fonts_h2', false, true );
		self::set_value( 'font_h2_style', '_fonts_h2_style' );
		self::set_value( 'font_h2_variant', '_fonts_h2_variant' );
		self::set_value( 'font_h2_size', '_fonts_h2_size' );
		
		self::set_value( 'font_h3', '_fonts_h3', false, true );
		self::set_value( 'font_h3_style', '_fonts_h3_style' );
		self::set_value( 'font_h3_variant', '_fonts_h3_variant' );
		self::set_value( 'font_h3_size', '_fonts_h3_size' );
		
		self::set_value( 'font_h4', '_fonts_h4', false, true );
		self::set_value( 'font_h4_style', '_fonts_h4_style' );
		self::set_value( 'font_h4_variant', '_fonts_h4_variant' );
		self::set_value( 'font_h4_size', '_fonts_h4_size');
		
		self::set_value( 'font_h5', '_fonts_h5', false, true );
		self::set_value( 'font_h5_style', '_fonts_h5_style' );
		self::set_value( 'font_h5_variant', '_fonts_h5_variant');
		self::set_value( 'font_h5_size', '_fonts_h5_size' );
		
		self::set_value( 'font_h6', '_fonts_h6', false, true );
		self::set_value( 'font_h6_style', '_fonts_h6_style' );
		self::set_value( 'font_h6_variant', '_fonts_h6_variant' );
		self::set_value( 'font_h6_size', '_fonts_h6_size' );
		
		self::set_value( 'font_blockquote', '_fonts_blockquote', false, true );
		self::set_value( 'font_blockquote_style', '_fonts_blockquote_style' );
		self::set_value( 'font_blockquote_variant', '_fonts_blockquote_variant' );
		self::set_value( 'font_blockquote_size', '_fonts_blockquote' );
		
		self::set_value( 'color_text', '_color_text' );
		self::set_value( 'color_bg', '_bg_color' );
		self::set_value( 'color_primary', '_color_primary' );
		self::set_value( 'color_links', '_color_links' );
		self::set_value( 'color_links_hover', '_color_links_hover' );
		self::set_value( 'header_text_color', '_header_text_color' );
		self::set_value( 'header_shading_color', '_header_shading_color', '_header_shading_opacity' );
		self::set_value( 'footer_bg_color', '_footer_bg_color' );
		self::set_value( 'footer_text_color', '_footer_text_color' );
		self::set_value( 'footer_link_color', '_footer_link_color' );
		self::set_value( 'footer_title_color', '_footer_title_color' );
		self::set_value( 'color_h1', '_color_h1' );
		self::set_value( 'color_h2', '_color_h2' );
		self::set_value( 'color_h3', '_color_h3' );
		self::set_value( 'color_h4', '_color_h4' );
		self::set_value( 'color_h5', '_color_h5' );
		self::set_value( 'color_h6', '_color_h6' );
		self::set_value( 'color_menu_text', '_color_menu_text' );
		self::set_value( 'color_menu_hover_text', '_color_menu_hover_text' );
		self::set_value( 'color_menu_bg', '_color_menu_bg_top' );
		self::set_value( 'color_submenu_text', '_color_submenu_text' );
		self::set_value( 'color_submenu_hover_text', '_color_submenu_hover_text' );
		self::set_value( 'color_submenu_bg', '_color_menu_submenu' );
		self::set_value( 'background_image', '_bg_image' );
		self::set_value( 'background_image_repeat', '_bg_repeat' );
		self::set_value( 'background_image_position', '_bg_position' );
		self::set_value( 'general_wide', '_general_wide' );
		self::set_value( 'general_align', '_general_align' );
		self::set_value( 'general_responsive', '_general_responsive' );
		self::set_value( 'animations', '_general_animations' );
		self::set_value( 'custom_css', '_custom_css' );
		self::set_value( 'custom_footer', '_custom_body' );
		self::set_value( 'custom_head', '_custom_head' );
	}
	
	public static function set_value( $theme_mod, $theme_option, $color = false, $font = false ){
		$theme_option =  get_option( 'eque' . $theme_option );
		
		if( get_option( 'eque' . $color ) ){
			$theme_option = 'rgba('.self::hex2rgb( $theme_option ).','.( get_option( 'eque' . $color ) / 100 ).')';	
		}
		if( $font === true ){
			$fonts = json_decode( get_option( 'eque_json_font_list' ), true );
			$theme_option = $fonts[$theme_option][1];
		}
		$temp = get_theme_mod( $theme_mod );
		if( empty( $temp ) && $theme_option ) set_theme_mod( $theme_mod, $theme_option );
		
	}
	
	public static function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return implode(",", $rgb);
	}
}
register_activation_hook( __FILE__, array( 'CurlyMigrationAssistant', 'install' ) );

class CurlyThemesExtension {
	
	public function __construct( $prefix = null ) {
		
		if ( !defined( 'THEMEPREFIX' ) ) {
			define( 'THEMEPREFIX' , $prefix );
		}
	
		add_action('init', array($this, 'add_button'));
		add_filter('the_content', array($this, 'shortcode_sanitizer'));
		add_filter('widget_text', array($this, 'shortcode_sanitizer'));
		
		add_action('wp_enqueue_scripts', array($this, 'load_shortcodes_scripts'));
		
		// Plugins
		add_action('after_setup_theme', array($this, 'activate_plugins'));
		
		// Include Shortcodes
		self::includes();
		
		// Include Widgets
		self::widgets();
		
		if ( function_exists('register_sidebar'))
		register_sidebar(array(
			'name'			 => __('[DEPRECATED]Pre-Footer Left' , 'CURLYTHEME'),
			'id'			 => 'pre_footer_sidebar_left',
			'before_widget'	 => '<div id="%1$s" class="col-lg-8 col-md-8 pre-footer-widget %2$s">',
			'after_widget' 	 => '</div>',
			'before_title'	 => '<h4 class="special-title"><span>',
			'after_title'		 => '</span></h4>',
		));	
		
		if ( function_exists('register_sidebar'))
			register_sidebar(array(
			'name'			 => __('[DEPRECATED]Pre-Footer Right' , 'CURLYTHEME'),
			'id'			 => 'pre_footer_sidebar_right',
			'before_widget'	 => '<div id="%1$s" class="col-lg-4 col-md-4 pre-footer-widget %2$s">',
			'after_widget' 	 => '</div>',
			'before_title'	 => '<h4 class="special-title"><span>',
			'after_title'		 => '</span></h4>',
		));	
		
		if ( function_exists('register_sidebar'))
			register_sidebar(array(
			'name'			 => __('[DEPRECATED]Footer Left Sidebar' , 'CURLYTHEME'),
			'id'			 => 'footer_sidebar_left',
			'before_widget'	 => '<div id="%1$s" class="col-lg-5 col-md-5 col-sm-4 footer-widget %2$s">',
			'after_widget' 	 => '</div>',
			'before_title'	 => '<h5 class="special-title"><span>',
			'after_title'		 => '</span></h5>',
		));	
		
		if ( function_exists('register_sidebar'))
			register_sidebar(array(
			'name'			 => __('[DEPRECATED]Footer Center Sidebar' , 'CURLYTHEME'),
			'id'			 => 'footer_sidebar_center',
			'before_widget'	 => '<div id="%1$s" class="col-lg-4 col-md-4 col-sm-4 footer-widget %2$s">',
			'after_widget' 	 => '</div>',
			'before_title'	 => '<h5 class="special-title"><span>',
			'after_title'		 => '</span></h5>',
		));	
		
		if ( function_exists('register_sidebar'))
			register_sidebar(array(
			'name'			 => __('[DEPRECATED]Footer Right Sidebar', 'CURLYTHEME'),
			'id'			 => 'footer_sidebar_right',
			'before_widget'	 => '<div id="%1$s" class="col-lg-3 col-md-3 col-sm-4 footer-widget %2$s">',
			'after_widget' 	 => '</div>',
			'before_title'	 => '<h5 class="special-title"><span>',
			'after_title'		 => '</span></h5>',
		));	
		
		if ( function_exists('register_sidebar'))
			register_sidebar(array(
			'name'			 => '[DEPRECATED]Absolute Footer',
			'id'			 => 'absolute_footer',
			'before_widget'	 => '',
			'after_widget' 	 => '',
			'before_title'	 => '',
			'after_title'	 => '',
		));
	}

/*  Frontend Scripts
	================================================= */		
	function load_shortcodes_scripts() {
		if ( !is_admin() ) {
			
			// Register Scripts	
			wp_register_script('curly-carousel', plugins_url( '/js/jquery.carouFredSel-6.2.1-packed.js' , __FILE__ ), null, null, true);
			wp_register_script('curly-fitvid', plugins_url( '/js/jquery.fitvids.js' , __FILE__ ), null, null, true);
			wp_register_script('curly-picture-zoom', plugins_url( '/js/jquery.zoom-min.js' , __FILE__ ), null , null, true);
			wp_register_script('curly-roundabout', plugins_url( '/js/jquery.roundabout.min.js', __FILE__ ), null, null, true); 
			wp_register_script('curly-easing', plugins_url( '/js/jquery.easing.1.3.js', __FILE__ ), null, null, true);
			wp_register_script('curly-drag', plugins_url( '/js/jquery.event.drag-2.2.js', __FILE__ ), null, null, true); 
			wp_register_script('curly-drop', plugins_url( '/js/jquery.event.drop-2.2.js', __FILE__ ), null, null, true); 
			wp_register_script('curly-ios', plugins_url( '/js/jquery.iosslider.min.js', __FILE__ ), null, true);
			wp_register_script('curly-countdown', plugins_url( '/js/jquery.countdown.min.js' , __FILE__ ), null, null, true);
			
			// Register Styles
			wp_register_style('curly-ios-css', plugins_url( '/css/slider-ios.css', __FILE__ ), null, null, 'all');
			wp_register_style('curly-lightbox-css', plugins_url('/css/lightbox.css', __FILE__ ), null, null, 'all');		
			
			// Enqueue Scripts
			wp_enqueue_script( 
				'curly-shortcodes', 
				plugins_url( '/js/main.js' , __FILE__ ), 
				array( 'jquery', 'curly-main' ), 
				null, 
				true
			);
			wp_enqueue_script('curly-lightbox', plugins_url( '/js/lightbox-2.6.min.js', __FILE__ ), 'jquery',  null, true);
			
			// Enqueue Styles
			wp_enqueue_style('curly-shortcodes', plugins_url( '/css/style.css' , __FILE__ ), array('curly-style') , null);
			wp_enqueue_style('curly-lightbox-css');
			
			// Dynamic CSS - $output
			include('css/render.css.php');	
			
			///	Minify CSS  
			wp_add_inline_style( 'curly-shortcodes', apply_filters( 'curly_minify_css', htmlspecialchars_decode( $curly_css_output ) ) );
		} 
	}
		
/*  Shortcodes
	================================================= */
	function includes() {
		include ( 'shortcodes/columns.php' );
		include ( 'shortcodes/dividers.php' );	
		include ( 'shortcodes/buttons.php' );
		include ( 'shortcodes/alert.php' );
		include ( 'shortcodes/quotes.php' );
		include ( 'shortcodes/lists.php' );	
		include ( 'shortcodes/abbr.php' );	
		include ( 'shortcodes/dropcap.php' );
		include ( 'shortcodes/highlight.php' );	
		include ( 'shortcodes/action.php' );
		include ( 'shortcodes/tabs.php' );	
		include ( 'shortcodes/toggle-box.php' );				
		include ( 'shortcodes/accordion.php' );			
		include ( 'shortcodes/youtube.php' ); 			
		include ( 'shortcodes/vimeo.php' ); 	
		include ( 'shortcodes/boxes.php' ); 	
		include ( 'shortcodes/marker.php' ); 
		include ( 'shortcodes/testimonials.php' ); 
		include ( 'shortcodes/slider.php' ); 	
		include ( 'shortcodes/person.php' );
		include ( 'shortcodes/clear.php' );	
		include ( 'shortcodes/progress.php' );	
		include ( 'shortcodes/icon.php' );	
		include ( 'shortcodes/client-list.php' );	
		include ( 'shortcodes/pretty-photo.php' );	
		include ( 'shortcodes/agenda.php' );			
		include ( 'shortcodes/pricing.php' );	
		include ( 'shortcodes/map-maker.php' );	
		include ( 'shortcodes/picture-zoom.php' );
		include ( 'shortcodes/fullwidth.php' );
		include ( 'shortcodes/slider-ios.php' );
		include ( 'shortcodes/slider-roundabout.php' );
		include ( 'shortcodes/photo-frame.php' );
		include ( 'shortcodes/countdown.php' );
	}
	
	function widgets() {
		// Widgets
		include ('widgets/recent.php' );
		include ('widgets/search.php' );
	}
	

/*	Add Shortcodes Buttons to TinyMCE
	================================================= */
	function add_button() {  
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
	   {  
	     add_filter('mce_external_plugins', array($this, 'add_plugin'));  
	     add_filter('mce_buttons', array($this, 'register_button'));  
	   }  
	}
	
	function register_button($buttons) {  
	   array_push($buttons, "curly");  
	   return $buttons;  
	}  
	
	function add_plugin($plugin_array) { 
	   $plugin_array['curly']	 = plugins_url('/shortcodes/tinymce/buttons.js', __FILE__ );
	   return $plugin_array;  
	}
	

/*	Shortcode Sanitizer
	================================================= */
	function shortcode_sanitizer( $content ) {
		$needle = join("|",array("column", '\/column', "list", "\/list", "tabs", "\/tabs", "tab", "\/tab", "toggle", "\/toggle", "accordion", "\/accordion", "testimonials", "\/testimonials", "testimonial", "\/testimonial", "clear", "divider", "button", "\/button", "blockquote", "\/blockquote", "highlight", "\/highlight", "call2action", "\/call2action", "toggle-box", "\/toggle-box", "slider", "slide", "youtube", "vimeo", "progress", "icon", "clients", "\/clients", "client", "\/client", "pretty-photo", "agenda", "\/agenda", "event-day", "\/event-day", "event", "\/event", "pricing-table", "\/pricing-table", "pricing-column", "\/pricing-column", "pricing-header", "\/pricing-header", "pricing-row", "\/pricing-row", "pricing-footer", "\/pricing-footer", "map-maker", "\/map-maker", "picture-zoom", "full-width-box", '\/full-width-box', "box", "\/box", "alert", "\/alert", "ios-slider", "ios-slide", "roundabout-slider", "roundabout-slide", "person", "\/person", "photo-frame", "\/photo-frame", "gallery", "countdown", "location", "simple-weather", "simple-text-rotator", "\/simple-text-rotator", "simple-qr"));
	
		$html = preg_replace("/(<p>)?\[($needle)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		$html = preg_replace("/(<p>)?\[\/($needle)](<\/p>|<br \/>)/","[/$2]",$html);
	
		return $html;
	}
	
	function activate_plugins() {
	
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		if ( ! is_plugin_active( 'simple-text-rotator/simple-text-rotator.php' ) ) {
		  include_once ('plugins/simple-text-rotator/simple-text-rotator.php' );
		}
		
		if ( ! is_plugin_active( 'simple-qr/simple-qr.php' ) ) {
		  include_once ('plugins/simple-qr/simple-qr.php' );
		}
	}
	
}
	
class CurlyThemesShortcodeBuilder {
	
	public function __construct( $prefix = null ) {
		
		if ( !defined( 'THEMEPREFIX' ) ) {
			define( 'THEMEPREFIX' , $prefix );
		}
		
		add_action('admin_footer', array($this, 'shortcode_builder'));
		add_action('admin_enqueue_scripts', array($this, 'load_shortcodes_admin_scripts'));
		
	}
	
	function shortcode_builder() {
		
		$html  = '<div id="curly_shortcode_builder" style="display:none">';
			$html .= '<div>';
				$html .= '<ul id="curly_shortcodes">';
				$html .= '<li><a href="#" id="curly-sc-col-12" class="curly-icon-half">1/2 Column <small>Insert a 50% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-col-13" class="curly-icon-third">1/3 Column <small>Insert a 33% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-col-23" class="curly-icon-two-thirds">2/3 Column <small>Insert a 66% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-col-14" class="curly-icon-quarter">1/4 Column <small>Insert a 25% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-col-24" class="curly-icon-two-quarters">2/4 Column <small>Insert a 50% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-col-34" class="curly-icon-three-quarters">3/4 Column <small>Insert a 75% wide column</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-fullwidth" class="curly-icon-full-width">Full Width Box <small>Insert a fullwidth row</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-featured-box" class="curly-icon-box">Featured Box <small>Insert a featured box</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-action" class="curly-icon-call-to-action">Call 2 Action Box <small>Insert a Call 2 Action box</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-divider" class="curly-icon-divider">Content Divider <small>Insert a horizontal divider</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-dropcap" class="curly-icon-dropcap">Dropcap <small>Insert a dropcap</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-abbr" class="curly-icon-abbreviation">Abbreviation <small>Insert a text abbreviation</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-highlight" class="curly-icon-highlighted">Featured Paragraph<small>Insert a featured paragraph</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-blockquote" class="curly-icon-blockquote">Blockquote <small>Insert a blockquote</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-lists" class="curly-icon-list">Styled List <small>Insert a styled list</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-text-rotator" class="curly-icon-text-rotator">Text Rotator <small>Simple text animation</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-text-marker" class="curly-icon-marker">Text Marker <small>Insert a text marker</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-alert" class="curly-icon-alert-box">Alert Box <small>Insert an alert box </small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-clear" class="curly-icon-clear">Clear Floats <small>Clear floats</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-icon" class="curly-icon-icon">FontAwesome Icon <small>369+ FontAwesome Icons</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-button" class="curly-icon-button">Button <small>Insert a button</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-accordion" class="curly-icon-accordion">Accordion <small>Insert an accordion</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-tabs" class="curly-icon-tabs">Tabs <small>Insert Tabs</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-progress" class="curly-icon-progress-bar">Progress Bar <small>Insert a progress bar</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-toggle" class="curly-icon-toggle">Toggle Box <small>Insert a toggle box</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-testimonials" class="curly-icon-testimonials">Testimonials Slider <small>Insert a testimonials slider</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-team" class="curly-icon-team">Person / Team <small>Insert a person / team</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-clients" class="curly-icon-clients">Clients Carousel <small>Insert a clients carousel</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-slider" class="curly-icon-slider">Content Slider <small>Insert a content slider</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-countdown" class="curly-icon-countdown">Countdown <small>Insert a Countdown</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-map" class="curly-icon-map">Google Map <small>Insert a Google Map</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-vimeo" class="curly-icon-vimeo">Vimeo Vimeo <small>Insert a Vimeo video</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-youtube" class="curly-icon-you-tube">YouTube Video <small>Insert a YouTube video</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-zoomify" class="curly-icon-zoomify">Picture Zoomify <small>Insert a Zoomify</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-photo-frame" class="curly-icon-photo-frame">Photo Frame <small>Photo framed image</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-lightbox" class="curly-icon-lightbox">Lightbox Image <small>Insert a lightbox image</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-weather" class="curly-icon-weather">Weather Widget <small>Weather Forecast</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-qr" class="curly-icon-qr-code">QR Code <small>Insert a QR Code</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-pricing" class="curly-icon-pricing-table">Pricing Table <small>Insert a pricing table</small></a></li>';
				$html .= '<li><a href="#" id="curly-sc-agenda" class="curly-icon-agenda">Event Agenda <small>Event agenda table</small></a></li>';
				$html .= '</ul>';
			$html .= '</div>';
		$html .= '</div>';
		
		echo $html;
	}

	function load_shortcodes_admin_scripts() {
	
		wp_enqueue_style('curly-wp-editor', plugins_url( '/css/wp-editor.css' , __FILE__ ), null, null);
		wp_enqueue_script('curly-shortcode-builder', plugins_url( '/js/builder.js' , __FILE__ ), null, null);
		
		// Get Current Color Scheme
		global $_wp_admin_css_colors; 
		$admin_colors = $_wp_admin_css_colors;
		$color_scheme = $admin_colors[get_user_option('admin_color')]->colors;
		
		$color_scheme = '
			#curly_shortcodes a:hover{
				background: '.$color_scheme[3].'
			}
		';
		
		wp_add_inline_style('curly-wp-editor', $color_scheme);
	}
}

class CurlySidebars {
	
	public function __construct( $prefix = null ) {
		
		if ( !defined( 'THEMEPREFIX' ) ) {
			define( 'THEMEPREFIX' , $prefix );
		}
	
		add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
		add_action('admin_menu', array($this, 'add_submenu_page'));
		add_action('wp_ajax_update_sidebars', array($this, 'update_sidebars'));
		add_action('widgets_init', array($this, 'create_sidebars'));
		
		add_shortcode('sidebar', array($this, 'sidebar_shortcode'));
		
	}
	
	function load_scripts() {
		
		// Get Current Color Scheme
		global $_wp_admin_css_colors; 
		$admin_colors = $_wp_admin_css_colors;
		$color_scheme = $admin_colors[get_user_option('admin_color')]->colors;
			
		if (get_current_screen()->id == 'appearance_page_sidebars') {
			
			wp_enqueue_style('curly-google-font-roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,300,700,900', true);
			wp_enqueue_style('curly-sidebars-css', plugins_url( '/css/sidebars.css', __FILE__ ), null,  null, null);
			wp_enqueue_script('curly-sidebars-js', plugins_url( '/js/sidebars.js', __FILE__ ) , 'jquery', null, true);
			
			$js_data = array(
				__('Remove','CURLYTHEME'),
				__('Are you sure you want to delete this sidebar?','CURLYTHEME'),
				__('Sidebar name cannot be empty. Please provide a valid name for your sidebar.','CURLYTHEME'),
				__('You already have a sidebar with that name. Please provide a valid name for your sidebar.','CURLYTHEME'),
				__('Your sidebar has been succesfully created.','CURLYTHEME'),
				__('You currently have no sidebars created. <br>Use the form above to create your first sidebar.','CURLYTHEME')
			);
			
			wp_localize_script('curly-sidebars-js', 'js_data', $js_data);
			
			$color_scheme = '
				#sidebars-wrapper input[type=submit],
				#sidebar-list li a:hover{
					background-color: '.$color_scheme[3].';
					color: #fff;
				}';
			
			wp_add_inline_style('curly-sidebars-css', $color_scheme);
		} 
	}
	
	function update_sidebars() {
		
		$name 	= sanitize_text_field( $_POST['name'] );
		$id 	= sanitize_text_field( $_POST['id'] );
		$method = sanitize_text_field( $_POST['method'] );
		
		$sidebars 	= self::get_sidebars();
		$count 		= self::get_sidebars_count() + 1;
		
		if ( $method == 'update' ) {
			
			if ( !empty($name) ) {
			
				if ( !$sidebars ) {
				
					$sidebars = array( $count => $name );
					$sidebars = json_encode($sidebars);
					update_option( THEMEPREFIX . '_sidebars_list' , $sidebars );
					update_option( THEMEPREFIX . '_sidebars_list_count' , $count );
					
					echo json_encode( array( $count, $name ) );
					
				} else {
				
					if ( !in_array( $name , $sidebars ) ) {
					
						$sidebars[$count] = $name ;
						$sidebars = json_encode($sidebars);
						update_option( THEMEPREFIX . '_sidebars_list' , $sidebars );
						update_option( THEMEPREFIX . '_sidebars_list_count' , $count );
						
						echo json_encode( array( $count, $name ) );
						
					} else {
						echo 'duplicate';
					}
				}
				
			} else {
				echo 'empty';
			}
			
		}
		
		if ( $method == 'delete' ) {
			unset( $sidebars[$id] );
			$sidebars = json_encode($sidebars);
			update_option( THEMEPREFIX . '_sidebars_list' , $sidebars );
			echo 'success';
		}
		
		die();
	}
	
	function add_submenu_page(){
	     add_submenu_page( 'themes.php', __('Sidebars', 'CURLYTHEME'), __('Sidebars', 'CURLYTHEME'), 'manage_options', 'sidebars', array($this, 'add_submenu_page_cb')); 
	}
	
	function add_submenu_page_cb( $html = null ) {
		
		$sidebars = self::get_sidebars();
		
		$html .= '<div id="sidebars-wrapper">';
			$html .= '<h1>'.__('Sidebars', 'CURLYTHEME').'</h1>';
			$html .= '<form method="post" id="add-sidebar" action="">';
				$html .= '<input type="text" id="add-sidebar-field" placeholder="'.__('Enter new sidebar name','CURLYTHEME').'">';
				$html .= '<input type="submit" id="add-sidebar-button" value="'.__('Add Sidebar','CURLYTHEME').'">';
			$html .= '</form>';
			$html .= '<div id="messages"></div>';
			$html .= '<h3>'.__('Sidebar List','CURLYTHEME').'</h3>';
			$html .= '<ul id="sidebar-list">';
			
			if ( $sidebars ) {
			
				foreach ($sidebars as $id => $name) {
					$html .= '<li>'.$name.' <code>[sidebar id="'.$id.'"]</code><a href="#" data-sidebar-id="'.$id.'">'.__('Remove','CURLYTHEME').'</a></li>';
				}
				
			} else {
				$html .= '<li id="no-sidebar">'.__('You currently have no sidebars created. <br>Use the form above to create your first sidebar.','CURLYTHEME').'</li>';
			}
			
			$html .= '</ul>';
		$html .= '</div>';
		
		echo $html;
	}
	
	public static function get_sidebars() {
		$sidebars = get_option( THEMEPREFIX . '_sidebars_list' );
		$sidebars = json_decode($sidebars, true);
		
		return $sidebars;
	}
	
	function get_sidebars_count() {
		$count = get_option( THEMEPREFIX . '_sidebars_list_count', 0 );
		
		return $count;
	}
	
	function create_sidebars() {
		$sidebars = self::get_sidebars();
		if ( $sidebars ) {
			foreach ($sidebars as $id => $name) {
				register_sidebar( array(
				    'name'         => $name,
				    'id'           => 'sidebar_'.$id,
				    'before_widget'=> '<div id="%1$s" class="sidebar-widget %2$s">',
				    'after_widget' => '</div>',
				    'before_title' => '<h5 class="special-title"><span>',
				    'after_title'  => '</span></h3>',
				) );
			}
		}
			
	}
	
	public static function sidebar( $default = null ) {
	
		global $post;
		
		$sidebar = get_post_meta( $post->ID, THEMEPREFIX . '_sidebar', true);
		
		if ( $sidebar ) {
			dynamic_sidebar( $sidebar );
		} else {
			dynamic_sidebar( $default );
		}
	}
	
	function sidebar_shortcode( $atts ) {
	
		ob_start();
		dynamic_sidebar( 'sidebar_'.$atts['id'] );
		$sidebar = ob_get_contents();
		ob_end_clean();
		
		return $sidebar;
	}
	
}

$sidebar 	= new CurlySidebars('eque');
$extension 	= new CurlyThemesExtension('eque');
$builder 	= new CurlyThemesShortcodeBuilder('eque');

?>