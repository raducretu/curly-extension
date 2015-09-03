<?php
add_shortcode("clear", "curly_clear"); 		
function curly_clear( $atts, $content = null ) { 
    return '<div class="clear"></div>';  
}  
?>