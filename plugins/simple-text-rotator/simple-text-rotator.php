<?php
/*
Plugin Name: Simple Text Rotator
Plugin URI: http://demo.curlythemes.com/?product=text
Description: Super elegant text rotation shortcode.
Version: 1.1
Author: Curly Themes
Author URI: http://www.curlythemes.com
*/

function curly_str_options_header() {
	if ( !is_admin() ) {
		wp_enqueue_style('text-rotator-css', plugins_url( '/css/simpletextrotator.css' , __FILE__ ), true);
		wp_enqueue_script('text-rotator-js', plugins_url( '/js/morphext.min.js' , __FILE__ ), 'jquery', null, true);
	} 
}
add_action('wp_enqueue_scripts', 'curly_str_options_header');


function curly_simple_text_rotator( $atts , $content = null ) {
	extract( shortcode_atts( array(
		'animation' => 'bounceIn',
		'separator' => '|',
		'speed' => 2000
	), $atts ) );
	
	$html = '<span class="str-rotate" data-str-animation="'.$animation.'" data-str-separator="'.$separator.'" data-str-speed="'.$speed.'">';
	$html .= $content;
	$html .= '</span>';
	
	return $html;
	
}
function curly_simple_content_rotator( $atts , $content = null ) {
	extract( shortcode_atts( array(
		'animation' => 'bounceIn',
		'animation_out' => 'bounceOut',
		'speed' => 2000
	), $atts ) );
	
	$html = '<div class="scr-rotate" data-scr-animation="'.$animation.'"  data-scr-animation-out="'.$animation_out.'" data-scr-speed="'.$speed.'">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	
	return $html;
	
}
add_shortcode( 'simple-text-rotator', 'curly_simple_text_rotator');
add_shortcode( 'simple-content-rotator', 'curly_simple_content_rotator');

?>