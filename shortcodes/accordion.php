<?php

// Accordion
add_shortcode('accordion', 'curly_accordion');
	function curly_accordion( $atts, $content = null ) {
	
	if ( isset( $GLOBALS['accordionID'] ) ) {
		$GLOBALS['accordionID']++; 
	} else { 
		$GLOBALS['accordionID'] = 0;
	}
	
	$GLOBALS['accordionPanelID'] = $GLOBALS['accordionID'] * 100;
	
    $html = '<div class="panel-group"  id="accordion'.$GLOBALS['accordionID'].'">';
	$html .= do_shortcode($content).'</div>';
	return $html;
}

// Accodrion Toggle
add_shortcode('toggle', 'curly_toggle');
	function curly_toggle( $atts, $content = null ) {
		
		// Extract Shortcode Atts
		extract(shortcode_atts(array(
			'title'	 => null,
			'opened' => null
		), $atts)); 
	
		// Global Panel ID
		$GLOBALS['accordionPanelID']++;
		
		if ( $opened == "yes" ) {
			$opened = ' in';
			$collapsed = null;
		} else {
			$opened = null;
			$collapsed = ' collapsed';
		}
		
		// Output
		$html = null;
		
		if ( $title ) {
			$html .= '<div class="panel">';
				$html .= '<div class="panel-heading"><h6><a class="accordion-toggle'.$collapsed.'" data-toggle="collapse" data-parent="#accordion'.$GLOBALS['accordionID'].'" href="#panel'.$GLOBALS['accordionPanelID'].'">'.$title.'</a></h6></div>';
				$html .= '<div id="panel'.$GLOBALS['accordionPanelID'].'" class="panel-collapse collapse'.$opened.'"><div class="panel-body">
				       '.do_shortcode($content).'</div></div>';
			$html .= '</div>';
		}	
		
	return $html;
}
?>