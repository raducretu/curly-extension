<?php
/*
add_shortcode('tabs', 'curly_tabs');
function curly_tabs( $atts, $content = null ) {

	$GLOBALS['tabsID'] = ( isset($GLOBALS['tabsID']) ) ? $GLOBALS['tabsID'] + 1 : 0;
	$GLOBALS['tabsSlideID'] = $GLOBALS['tabsID'] * 100;
	extract(shortcode_atts(array(), $atts));

	$html = '<div class="tabs-container">';

	$html .= '<ul class="nav nav-tabs">';
		foreach ($atts as $key => $tab) {
			if($key == 'tab1') $css = ' class="active"'; else $css = null;
			if (isset($i)) $i++; else $i = 0;
			if(strpos($key,'tab') !== false){
				$key = ( 100 * $GLOBALS['tabsID']) + $i;
			$html .= '<li'.$css.'><a href="#tab' . $key . '" data-toggle="tab">' . $tab . '</a></li>';
			}
		}
		$html .= '</ul>';

		$html .= '<div class="tab-content">';
			$html .= apply_filters( 'the_content', $content);
		$html .= '</div>';

	$html .= '</div>';

	return $html;
}

add_shortcode('tab', 'curly_tab');
function curly_tab( $atts, $content = null ) {
	$GLOBALS['tabsSlideID']++;
	extract(shortcode_atts(array(), $atts));
	if( $GLOBALS['tabsSlideID'] % 100 == 1 ) {
		$css = ' active';
	} else {
		$css = null;
	}
	$html = '<div class="tab-pane'.$css.'" id="tab'.( $GLOBALS['tabsSlideID'] - 1 ).'">' . apply_filters( 'the_content', $content) .'</div>';

	return $html;
}
*/

add_shortcode('curly_tabs', 'curly_tabs_vc');
add_shortcode('curly_tab', 'curly_tab_vc');

function curly_tabs_vc( $atts, $content = null ) {

	$GLOBALS['tabsID'] = isset( $GLOBALS['tabsID'] ) ? $GLOBALS['tabsID'] + 1 : 0;
	$GLOBALS['tabsSlideID'] = $GLOBALS['tabsID'] * 100;

	$pattern = get_shortcode_regex();

	preg_match_all( "/$pattern/", $content, $shortcodes );

	$shortcodes_array = $shortcodes[2];
	$shortcodes_values_array = $shortcodes[3];
	$shortcodes_content_array = $shortcodes[5];

	extract( shortcode_atts( array() , $atts ) );

	if( has_shortcode( $content, 'curly_tab' ) ){

		$html  = '<div class="tabs-container">';

			$html .= '<ul class="nav nav-tabs">';

			$tabs_keys = array_keys( $shortcodes_array, 'curly_tab' );

			$index = 0;

			foreach( $tabs_keys as $key => $tab ){

				extract(
					shortcode_atts(
						array(
							'title' => null
						),
						shortcode_parse_atts( $shortcodes_values_array[ $tab ] ), 'curly_tab'
					)
				);

				$html .= '<li class="'. ( $index === 0 ? 'active' : '' ) .'"><a href="#tab-' . intval( $GLOBALS['tabsSlideID'] / 100 ) . '-' . ( $index++ ) . '" data-toggle="tab">' . $title . '</a></li>';

				$GLOBALS['tabsID']++;
			}

			$html .= '</ul>';

			$html .= '<div class="tab-content">';

				$html .= do_shortcode( $content );

			$html .= '</div>';

		$html .= '</div>';

		return $html;

	}

}



function curly_tab_vc( $atts, $content = null ) {

	extract(shortcode_atts(array( 'id' => null ), $atts));

	$group = intval( $GLOBALS['tabsSlideID'] / 100 );

	if( $GLOBALS['tabsSlideID'] % 100 == 0 ) {
		$css = ' active';
	} else {
		$css = null;
	}
	$html = '<div class="tab-pane'.$css.'" id="tab-' . $group . '-' . intval( $GLOBALS['tabsSlideID'] % 100 ) . '">' . apply_filters( 'the_content', $content) .'</div>';
	$GLOBALS['tabsSlideID']++;
	return $html;
}


?>
