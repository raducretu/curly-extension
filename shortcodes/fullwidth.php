<?php
add_shortcode("full-width-box", "curly_fullwidthbox"); 		

function curly_fullwidthbox( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'image'	 => null,
		'size'	 => null,
		'background' => null,
		'background_position' => null,
		'background_repeat' => null,
		'background_size' => null,
		'background_attachment' => null,
		'border' => null,
		'border_color' => null,
		'padding_top' => null,
		'padding_bottom' => null
	), $atts));
	
	$style = null;
	$style_inner = null;
	$style_row = null;
	
	$style .= ( $background ) ? 'background-color:'.$background.';' : null; 
	$style .= ( $image ) ? 'background-image: url('.$image.');' : null;
	$style .= ( $background_position ) ? 'background-position:'.$background_position.';' : 'background-position: top center;';
	$style .= ( $background_repeat ) ? 'background-repeat:'.$background_repeat.';' : 'background-repeat: repeat;';
	$style .= ( $background_size ) ? 'background-size:'.$background_size.';' : 'background-size: cover;';
	$style .= ( $background_attachment ) ? 'background-attachment:'.$background_attachment.';' : 'background-attachment: fixed;';
	$style .= ( $border ) ? 'border-top-style: solid; border-bottom-style: solid; border-top-width: '.$border.'px; border-bottom-width: '.$border.'px;' : null;
	$style .= ( $border_color ) ? 'border-color:'.$border_color.';' : null;
	
	$style_inner .= ( isset($size) && !empty($size) ) ? 'padding-left: '.( ( 100 - $size ) / 2 ).'%; padding-right: '.( ( 100 - $size ) / 2 ).'%;' : null;
	$style_row .= ( isset($padding_top) ) ? 'padding-top:'.$padding_top.'px;' : null;
	$style_row .= ( isset($padding_bottom) ) ? 'padding-bottom:'.$padding_bottom.'px;' : null;
	
	$html  = '</div></div></div>';
	$html .= '<div style="'.$style.'" class="fullwidth-row"><div class="container page-content"><div class="row" style="'.$style_row.'"><div class="col-lg-12" style="'.$style_inner.'">';
		$html .= apply_filters( 'the_content', $content);
	$html .= '</div></div></div></div>';
	$html .= '<div class="container page-content"><div class="row"><div class="col-lg-12">';
	
  return $html;
}  


?>