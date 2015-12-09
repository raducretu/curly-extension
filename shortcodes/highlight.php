<?php
add_shortcode("highlight", "curly_highlight"); 		

function curly_highlight( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style'	 => null,
		'align'	 => null
	), $atts));
	

	$css = ' default'; if( $style == 'different' ) $css = ' different';
	
	switch ( $align ) {
		case 'center' 	: $style = ' style="text-align:center"'; break;
		case 'right' 	: $style = ' style="text-align:right"'; break;
		default			: $style = null;
	}
	
    return '<div class="lead '.$css.'"'.$style.'>'.apply_filters( 'the_content', $content).'</div>';  
} 

?>