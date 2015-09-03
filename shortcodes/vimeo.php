<?php
add_shortcode("vimeo", "curly_vimeo"); 		

function curly_vimeo( $atts, $content = null ) {
	wp_enqueue_script('curly-fitvid');
	extract(shortcode_atts(array(  
        'id'  => null,
		'width' => 700,
		'height' => 390,
		'fullwidth' => 'yes'
    ), $atts)); 
	 
    return ($fullwidth == 'yes') ? '<div class="video"><div class="video-container"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div>' : '<div class="video"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>'; 
} 

?>