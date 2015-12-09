<?php
add_shortcode("blockquote", "curly_blockquote"); 		

function curly_blockquote( $atts, $content = null ) {
	
	extract(shortcode_atts(array(  
	    "image"  => null,
		'cite' => null
	), $atts)); 
	
	$img = ( $image ) ? '<img src="'.$image.'" alt="'.( ( $cite ) ? $cite : null ).'" class="pull-right hidden-xs">' : null;
	//$content = function_exists( 'wpb_js_remove_wpautop' ) ? wpb_js_remove_wpautop( $content, true ) : $content;  
    return ( $content ) ? '<blockquote>' . $img . do_shortcode( $content ) . ( $cite  ? '<cite>'.$cite . '</cite>' : null ) . '</blockquote>' : null;
}
?>