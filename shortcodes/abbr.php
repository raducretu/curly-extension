<?php
add_shortcode("abbr", "curly_abbr"); 
function curly_abbr( $atts, $content = null ) { 
	if( ! isset( $atts['title'] ) ) $atts['title'] = $content;
    return '<abbr title="'.$atts['title'].'">'.$content.'</abbr>';    
} 
?>