<?php
add_shortcode("list", "curly_lists"); 		

function curly_lists( $atts, $content = null ) {

	extract(shortcode_atts(array(  
        "type"  => null
    ), $atts)); 
	
	switch ($type){
		case 'bullets'  	: $css = 'list-bullets'; break;
		case 'square' 		: $css = 'list-square'; break;
		case 'circle' 		: $css = 'list-circle'; break;
		case 'checklist' 	: $css = 'list-checklist'; break;
		case 'crosslist' 	: $css = 'list-crosslist'; break;
		case 'default' 		: $css = 'list-default-list'; break;
		case 'none' 		: $css = 'list-none'; break;
		default				: $css = 'list-none';
	}
	 
    return '<div class="'.$css.'">'.do_shortcode($content).'</div>';  
} 

?>