<?php
add_shortcode("picture-zoom", "curly_picturezoom"); 		

function curly_picturezoom( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'image'   	=>  null,
	), $atts));

	if( !wp_script_is('curly-picture-zoom') ) { 
		wp_enqueue_script('curly-picture-zoom');
	}	
	
	global $post;
	
	$html = ( $image ) ? '<div class="zoom-picture"><img src="'.( ($image) ? $image : null ).'" style="width:100%;" alt="'.get_the_title($post->ID).'" ></div>' : null;
	
  return $html;
}  


?>