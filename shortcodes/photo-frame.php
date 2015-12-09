<?php
add_shortcode("photo-frame", "curly_frame"); 
function curly_frame( $atts, $content = null ) { 
    return '<div class="photo-frame">'.apply_filters( 'the_content', $content ).'</div>';    
} 
?>