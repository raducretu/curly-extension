<?php
add_shortcode("blockquote", "curly_blockquote"); 		

function curly_blockquote( $atts, $content = null ) {
	
	extract(shortcode_atts(array(  
	    "image"  => null,
		'cite' => null
	), $atts)); 
	
	$img = ( $image ) ? '<img src="'.$image.'" alt="'.( ( $cite ) ? $cite : null ).'" class="pull-right hidden-xs">' : null;
	 
    return ( $content ) ? '<blockquote class="blockquote clearfix"><i class="fa fa-3x fa-quote-left"></i>'.$img.$content.( ( $cite ) ? '<cite>'.$cite.'</cite>' : null ).'</blockquote>' : null;  
}
?>