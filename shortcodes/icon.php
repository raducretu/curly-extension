<?php
add_shortcode("icon", "curly_icon"); 		

function curly_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        'icon'  => null,
		'boxed'  => 'no',
		'size'  => null,
		'position' => null
    ), $atts)); 
	
	$css = null;
	
	if ($boxed != "no") $css = ' fa-boxed fa-fw'; 
	
	switch ($size){
		case '2x'   : $css .= ' fa-2x'; break;
		case '3x'   : $css .= ' fa-3x'; break;
		case '4x'   : $css .= ' fa-4x'; break;
		case '5x'   : $css .= ' fa-5x'; break;
	}
	
	switch ($position){
		case 'left'    : $css .= ' pull-left'; break;
		case 'right'   : $css .= ' pull-right'; break;
	}
	
	$inline = null;
	if(isset($atts['color']) || isset($atts['bg']) || isset($atts['border'])){
		$inline  = 'style="';
		$inline .= (isset($atts['bg']) && $atts['bg'] != null) ? 'background-color: '.$atts['bg'].';' : null;
		$inline .= (isset($atts['border']) && $atts['border'] != null) ? 'border-color: '.$atts['border'].';' :  null;
		$inline .= (isset($atts['color']) && $atts['color'] != null) ? 'color: '.$atts['color'].';' : null;
		$inline .= '"';
	}
	 
    return '<i class="fa fa-'.$icon.$css.'" '.$inline.'></i>';  
}
?>