<?php
add_shortcode("agenda", "curly_agenda"); 		

function curly_agenda( $atts, $content = null ) {
	
    return ( $content ) ? '<div class="event-agenda content-padding-xs container-fluid">'.do_shortcode($content).'</div>' : null;  
} 

add_shortcode("event-day", "curly_day"); 		

function curly_day( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'date'	 => null
	), $atts));
	
	$html = null;
	
	if ( $content || $date ) {
		$html .= '<div class="event-agenda-day row">';
		$html .= ( $content ) ? '<h3 class="col-md-10 col-sm-10 col-lg-10">'.do_shortcode($content).'</h3>' : null;
		$html .= ( $date ) ? '<span class="col-md-2 col-sm-2 col-lg-2 text-right"><i class="fa fa-calendar"></i> '.$date.'</span>' : null;
		$html .= '</div>';
	}
    
    return $html;
} 

add_shortcode("event", "curly_event"); 	

function curly_event( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'time'	 => null,
		'room'	 => null
	), $atts));
	
	$html = null;
	
	if ( $content || $room || $time ) {
		$html .= '<div class="event-agenda-event row">';
		$html .= ( $time ) ? '<span class="col-md-2 col-sm-2 col-lg-2"><i class="fa fa-clock-o"></i>  '.$time.'</span>' : null;
		$html .= ( $content ) ? '<div class="col-md-8 col-sm-8 col-lg-8">'.do_shortcode($content).'</div>' : null;
		$html .= ( $room ) ? '<span class="col-md-2 col-sm-2 col-lg-2 text-right">'.$room.'  <i class="fa fa-map-marker"></i></span>' : null;
		$html .= '</div>';
	}
    return $html;
} 


?>