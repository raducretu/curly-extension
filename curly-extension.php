<?php
/*
Plugin Name: Curly Themes Extension
Plugin URI: http://demo.curlythemes.com
Description: Curly Themes Extension is a collection of Shortcodes, Widgets and Plugins. This plugin exclusive for Curly Themes
Version: 2.4.2
Author: Curly Themes
Author URI: http://www.curlythemes.com
*/

class CurlyThemesExtension {

	public function __construct( $prefix = null ) {

		if ( ! defined( 'THEMEPREFIX' ) ) {
			define( 'THEMEPREFIX' , $prefix );
		}

		add_action('init', array($this, 'add_button'));
		add_filter('the_content', array($this, 'shortcode_sanitizer'));
		add_filter('widget_text', array($this, 'shortcode_sanitizer'));
		add_filter('vc_inner_shortcode', array($this, 'shortcode_sanitizer'));

		add_action('wp_enqueue_scripts', array($this, 'load_shortcodes_scripts'));

		// Plugins
		add_action('after_setup_theme', array($this, 'activate_plugins'));

		// Include Shortcodes
		self::includes();

		// Include Widgets
		self::widgets();

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
			wp_register_style('curly-lightbox-css', plugins_url('/css/magnific-popup.css', __FILE__ ), null, '2.0', 'all');

			wp_enqueue_script('curly-lightbox', plugins_url( '/js/jquery.magnific-popup.min.js', __FILE__ ), 'jquery',  '2.0', true);

			// Enqueue Scripts
			wp_enqueue_script(
				'curly-shortcodes',
				plugins_url( '/js/main.js' , __FILE__ ),
				array( 'jquery', 'curly-main' ),
				null,
				true
			);


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
		/*
		$needle = join("|",array("column", '\/column', "list", "\/list", "tabs", "\/tabs", "tab", "\/tab", "toggle", "\/toggle", "accordion", "\/accordion", "testimonials", "\/testimonials", "testimonial", "\/testimonial", "clear", "divider", "button", "\/button", "blockquote", "\/blockquote", "highlight", "\/highlight", "call2action", "\/call2action", "toggle-box", "\/toggle-box", "slider", "slide", "youtube", "vimeo", "progress", "icon", "clients", "\/clients", "client", "\/client", "pretty-photo", "agenda", "\/agenda", "event-day", "\/event-day", "event", "\/event", "pricing-table", "\/pricing-table", "pricing-column", "\/pricing-column", "pricing-header", "\/pricing-header", "pricing-row", "\/pricing-row", "pricing-footer", "\/pricing-footer", "map-maker", "\/map-maker", "picture-zoom", "full-width-box", '\/full-width-box', "box", "\/box", "alert", "\/alert", "ios-slider", "ios-slide", "roundabout-slider", "roundabout-slide", "person", "\/person", "photo-frame", "\/photo-frame", "gallery", "countdown", "location", "simple-weather", "simple-text-rotator", "\/simple-text-rotator", "simple-qr"));

		$html = preg_replace("/(<p>)?\[($needle)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		$html = preg_replace("/(<p>)?\[\/($needle)](<\/p>|<br \/>)/","[/$2]",$html);

		return $html;

		*/

		$array = array(
	        '<p>['    	=> '[',
	        ']</p>'   	=> ']',
	        ']<br />' 	=> ']',
	        ']&#10;' 	=> ']',
	        '&#10;[' 	=> '['
	    );

	    return strtr( $content, $array );

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

$extension 	= new CurlyThemesExtension('eque');
$builder 	= new CurlyThemesShortcodeBuilder('eque');

require_once( 'class.vc.php' );

?>
