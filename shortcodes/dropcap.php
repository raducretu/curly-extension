<?php
add_shortcode("dropcap", "curly_dropcap"); 		

function curly_dropcap( $atts, $content = null ) {
    return '<span class="dropcap">'.$content.'</span>';  
} 

?>