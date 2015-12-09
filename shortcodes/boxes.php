<?php
add_shortcode("box", "curly_box"); 		

function curly_box( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => null,
			'icon'  => null,
			'title' => null,
			'background' => null
		), $atts ) );
	$html	= null;
	
	$css = ( $background ) ? 'style="background-color: '.$background.'"' : null;
	
	switch ( intval( $style ) ) {
		case 1 : {
			$html .= '<div class="well well-1" '.$css.'>';
				$html .= do_shortcode($content);
			$html .= '</div>';
		} break;
		case 2 : {
			$html .= '<div class="well well-2" '.$css.'>';
				$html .= ( $icon ) ? do_shortcode('[icon icon="'.$icon.'" boxed="yes" position="left"]') : null;
				$html .= ( $title ) ? '<h3>'.$title.'</h3>' : null;
				$html .= do_shortcode($content);
			$html .= '</div>';
		} break;
		case 3 : {
			$html .= '<div class="well well-3" '.$css.'>';
				$html .= ( $icon ) ? do_shortcode('[icon icon="'.$icon.'" size="3x" boxed="yes" bg="transparent"]') : null;
				$html .= ( $title ) ? '<h3>'.$title.'</h3>' : null;
				$html .= do_shortcode($content);
			$html .= '</div>';
		} break;
		case 4 : {
			$html .= '<div class="well well-4" '.$css.'>';
				$html .= ( $icon ) ? do_shortcode('[icon icon="'.$icon.'" boxed="yes"]') : null;
				$html .= ( $title ) ? '<h3>'.$title.'</h3>' : null;
				$html .= do_shortcode($content);
			$html .= '</div>';
		} break;
		case 6 : {
			$html .= '<div class="well well-5">';
				$html .= ( $icon ) ? do_shortcode('[icon icon="'.$icon.'" boxed="yes" size="4x"]') : null;
				$html .= '<div '.$css.'>';
					$html .= ( $title ) ? '<h3>'.$title.'</h3>' : null;
					$html .= do_shortcode($content);
				$html .= '</div>';
			$html .= '</div>';
		} break;
		default : {
			$html .= '<div class="well" '.$css.'>';
				$html .= do_shortcode($content);
			$html .= '</div>';
		}
	}

	
	
	return $html;
}  


?>