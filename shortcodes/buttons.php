<?php
add_shortcode("button", "curly_buttons"); 		

function curly_buttons( $atts, $content = null ) {
	extract(shortcode_atts(array(  
		'link'   => '#',
        "color"  => null, 
		"size"   => null,
		'title'  => null,
		'target' => '_self',
		'rel'    => null,
		'class'  => null
    ), $atts)); 
	
	$css  = 'btn ';
	$css .= $class;
	
	// Size
	switch ( $size ){
		case 'mini' 	: $css .= ' btn-xs'; break;
		case 'small'	: $css .= ' btn-sm'; break;
		case 'large'	: $css .= ' btn-lg'; break;
	}
	
	// Color
	switch ( $color ){
		case 'red'  	: $css .= ' btn-red'; break;
		case 'green'  	: $css .= ' btn-green'; break;
		case 'blue'  	: $css .= ' btn-blue'; break;
		case 'violet'  	: $css .= ' btn-violet'; break;
		case 'navy'  	: $css .= ' btn-navy'; break;
		case 'gray'  	: $css .= ' btn-gray'; break;
	}
	
	// Rel
	$rel_val = ( isset($rel) ) ? 'rel="'.$rel.'"' : null;
	
	// Return 
    return '<a href="'.$link.'" title="'.$title.'" target="'.$target.'" '.$rel_val.' class="'.$css.'">'.do_shortcode( $content ).'</a>';  
}  
?>