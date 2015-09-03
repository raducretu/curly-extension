<?php
add_shortcode("alert", "curly_alert"); 		

function curly_alert( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
			'color' => null
		), $atts ) );
	
	switch ( $color ) {
		case 'green'	: $css = ' alert-success'; break;
		case 'blue' 	: $css = ' alert-info'; break;
		case 'red' 		: $css = ' alert-danger'; break;
		case 'green' 	: $css = ' alert-success'; break;
		default			: $css = ' alert-warning';
	}
	 
    return '<div class="alert '.$css.'"><button class="fa fa-times" data-dismiss="alert"></button>'.$content.'</div>';  
}  

?>