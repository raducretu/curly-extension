<?php
add_shortcode("person", "curly_person"); 		

function curly_person( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'style'   	=>  null,
		'picture'	=>	null,
		'name'		=>  null,
		'facebook'	=>  null,
		'twitter'	=>  null,
		'linkedin'	=>  null,
		'position'	=>  null,
		'email'	=>  null
	), $atts));
	
	$html = '<div class="person clearfix '.( ( $style ) ? $style : null ).'">';
	
	$style 	= is_null( $style ) ? 'normal' : $style;
	$picture	= is_numeric( $picture ) ? wp_get_attachment_url( $picture ) : $picture;
	$content = function_exists( 'wpb_js_remove_wpautop' ) ? wpb_js_remove_wpautop( $content, true ) : $content; 
	if ( $style ) {
		if($style == 'mini') {
			$html .= ( $picture ) ? '<img src="'.$picture.'" alt="'.$name.'">' : null;
			$html .= '<div>';
				$html .= ( $name ) ? '<strong>'.$name.'</strong><br>' : null;
				$html .= ( $position ) ? $position.'<br>' : null;
				$html .= ( $content ) ? apply_filters( 'the_content', $content) : null; 
			$html .= '</div>';
		} else{
			$html .= ( $picture ) ? '<p class="text-center"><img src="'.$picture.'" alt="'.$name.'"></p>' : null;
			$html .= '<div class="text-center">';
			$html .= ( $name ) ? '<h5>'.$name.'</h5>' : null;
			$html .= ( $position ) ? $position.'<br><br>' : null;
			$html .= ( $content ) ? '<p>'.apply_filters( 'the_content', $content).'</p>' : null;
			$html .= ( $facebook || $twitter || $linkedin || $email ) ? '<p>' : null;
				$html .= ( $facebook ) ? '<a href="'.$facebook.'">'.do_shortcode('[icon icon="facebook" boxed="yes"]').'</a> ' : null;
				$html .= ( $twitter ) ? '<a href="'.$twitter.'">'.do_shortcode( '[icon icon="twitter" boxed="yes"]').'</a> ' : null;
				$html .= ( $linkedin ) ? '<a href="'.$linkedin.'">'.do_shortcode('[icon icon="linkedin" boxed="yes"]').'</a> ' : null;
				$html .= ( $email ) ? '<a href="mailto:'.$email.'">'.do_shortcode('[icon icon="envelope" boxed="yes"]').'</a> ' : null;
			$html .= ( $facebook || $twitter || $linkedin || $email ) ? '</p>' : null;	
			$html .= '</div>';
		}
	}
	
	$html .= '</div>';
    return $html;  
}  
?>