<?php
add_shortcode("divider", "curly_dividers"); 		

function curly_dividers( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        "style" => null,
        "before"=> 0,
        "after" => 40
    ), $atts)); 
	
	$css = 'divider';
	
	switch( intval( $style ) ){
		case 1  : $css .= ' one'; break;
		case 2  : $css .= ' two'; break;
		case 3  : $css .= ' three'; break;
		case 4  : $css .= ' four'; break;
		case 5  : $css .= ' five'; break;
	}
	
	$inline = null;
	
	$inline .= ( $before ) ? 'margin-top: '.$before.'px;' : null;
	$inline .= ( $after ) ? 'margin-bottom: '.$after.'px;' : null;
	
	$inline = ( $before || $after ) ? 'style="'.$inline.'"' : null;
	 
    return '<hr class="'.$css.'" '.$inline.'>';  
}  

?>