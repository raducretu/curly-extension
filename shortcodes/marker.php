<?php
add_shortcode("marker", "curly_marker"); 		

function curly_marker( $atts, $content = null ) {
	extract( shortcode_atts( array(
		      'color'    => null
	), $atts ) );
	
	switch ( $color ) {
		case 'green' 	: $css = 'label-success'; break;
		case 'orange' 	: $css = 'label-warning'; break;
		case 'red' 		: $css = 'label-danger'; break;
		case 'blue' 	: $css = 'label-info'; break;
		case 'black' 	: $css = 'label-default'; break;
		default			: $css = 'label-primary';
	}
	 
    return '<span class="label '.$css.'">'.apply_filters( 'the_content', $content).'</span>';  
}  


?>