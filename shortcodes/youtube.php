<?php
add_shortcode("youtube", "curly_youtube"); 		

function curly_youtube( $atts, $content = null ) {
	wp_enqueue_script('curly-fitvid');
	extract(shortcode_atts(array(  
        'id'  => null,
		'width' => 700,
		'height' => 390,
		'fullwidth' => 'yes'
    ), $atts)); 
	 
    return ($fullwidth == 'yes') ? '<div class="video"><div class="video-container"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?wmode=transparent"></iframe></div></div>' : '<div class="video"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?wmode=transparent"></iframe></div>'; 
} 

?>