<?php
add_shortcode("testimonials", "curly_testimonials"); 		

function curly_testimonials( $atts, $content = null ) {
	
	extract(shortcode_atts(array(  
	    "speed"  => 5000,
	    "height" => null
	), $atts)); 
	
	$GLOBALS['carouselID'] = ( isset($GLOBALS['carouselID']) ) ? +1 : 0;
	$GLOBALS['carouselSlideID'] = $GLOBALS['carouselID'] * 100;
	 
    $html = '<div id="carousel-'.$GLOBALS['carouselID'].'" class="carousel slide testimonials" data-ride="carousel" data-interval="'.$speed.'"><div class="carousel-inner">'.apply_filters( 'the_content', $content).'</div></div>'; 
    
    if ( $height && $height == "equal" ) {
    	$html .= "<script type='text/javascript'>jQuery(document).ready(function(){ jQuery('.testimonials .carousel-inner').equalize('height'); });</script>";
    }
    
    return $html; 
}  

add_shortcode("testimonial", "curly_testimonial"); 		

function curly_testimonial( $atts, $content = null ) {
	
	extract(shortcode_atts(array(  
	    "name"  => null,
	    "image" => null
	), $atts)); 
	
	$GLOBALS['carouselSlideID'] += ( isset($GLOBALS['carouselSlideID']) ) ? 1 : 0;
	
	$css = ( $GLOBALS['carouselSlideID'] % 100 == 1) ? 'active ': null; 
	
	$img = ( $image ) ? '<img src="'.$image.'" alt="'.( ( $name ) ? $name : null ).'" class="pull-right hidden-xs">' : null;
	 
    return '<div class="'.$css.'item"><blockquote class="blockquote">'.$img.$content.'</blockquote>'.( ( isset($name) ) ? '<cite>'.$name.'</cite>' : null ).'</div>';  
}  

?>
