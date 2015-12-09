<?php
add_shortcode("toggle-box", "curly_toggle_box"); 		
add_shortcode("curly_toggle_box", "curly_toggle_box"); 

function curly_toggle_box( $atts, $content = null ) {
	extract(shortcode_atts(array(  
        'title'  => null
    ), $atts)); 
    
    $GLOBALS['toggleID'] = ( isset($GLOBALS['toggleID']) ) ? $GLOBALS['toggleID'] + 1 : 0;
	 
    return '<div class="toggle-box"><h6 data-toggle="collapse" data-target="#toggle-'.$GLOBALS['toggleID'].'"><i class="fa fa-bars"></i> '.$title.'</h6><div id="toggle-'.$GLOBALS['toggleID'].'" class="collapse">'.apply_filters( 'the_content', $content).'</div></div>';  
} 

?>