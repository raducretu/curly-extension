<?php
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
			$html .= do_shortcode($content);
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
	$html = '<div class="tab-pane'.$css.'" id="tab'.( $GLOBALS['tabsSlideID'] - 1 ).'">' . do_shortcode($content) .'</div>';
	
	return $html;
}

?>