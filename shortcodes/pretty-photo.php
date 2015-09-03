<?php
add_shortcode("pretty-photo", "curly_prettyphoto"); 		

function curly_prettyphoto( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        "title"  => null,
		'image'  => null,
		'gallery'=> null,
		'visible'=> 'yes'
    ), $atts));
    
    $display = ( $visible == 'no' ) ? ' style="display:none"' : null; 
	
    return '<a href="'.$image.'" title="'.$title.'" data-lightbox="lightbox-'.$gallery.'" '.$display.'>'.do_shortcode($content).'</a>';  
}  


?>