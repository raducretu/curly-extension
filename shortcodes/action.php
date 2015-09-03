<?php
add_shortcode("call2action", "curly_action"); 		

function curly_action( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title'	 => null,
		'button' => null,
		'link'	 => null,
		'style'  => null
    ), $atts)); 
    
    switch ( $style ) {
    	case '1' : $style = ' style-1'; break;
    	case '2' : $style = ' style-2'; break;
    	case '3' : $style = ' style-3'; break;
    	case '4' : $style = ' style-4'; break;
    	case '5' : $style = ' style-5'; break;
    	default: $style = null; break;
    }
	
    $html  = '<div class="action-box'.$style.'">';
    $html .= ($button) ? do_shortcode('[button link="'.$link.'" size="large" class="hidden-xs"]'.$button.'[/button]') : null ;
    $html .= ($title) ? '<h3>'.$title.'</h3>' : null;
    $html .= do_shortcode($content);
    $html .= ($button) ? do_shortcode('[button link="'.$link.'" class="visible-xs btn-large btn-block btn-default"]'.$button.'[/button]') : null;
    $html .= '</div>';  
    
    return $html;
} 
?>