<?php
add_shortcode("ios-slider", "curly_iosslider"); 		

function curly_iosslider( $atts, $content = null ) {
	extract(shortcode_atts(array(), $atts)); 
	
	if( !wp_script_is('curly-easing') ) {
		wp_enqueue_script('curly-easing'); 
	}
	if( !wp_script_is('curly-ios') ) {
		wp_enqueue_script('curly-ios');
	}
	if( !wp_script_is('curly-ios-css') ) {
		wp_enqueue_style('curly-ios-css');
	}
	 
	
	// Start Slider 
    $html  = '<div class="wl-slider-ios-container"><div class="wl-slider-ios"><div class="iosSlider">';
    
    // Populate Slider
    $html .= '<div class="slider">'.apply_filters( 'the_content', $content).'</div>'; 
    
    // Navigation Arrows
    $html .= '<div class="next"></div><div class="prev"></div>';
    
    // Close Slider		  
    $html .= '</div></div></div>';
    
    // Load Javascript
    $html .= "<script type='text/javascript'>
			    	jQuery(document).ready(function() {
			    		
			    		jQuery('.iosSlider').iosSlider({
			    			snapToChildren: true,
			    			desktopClickDrag: true,
			    			scrollbar: true,
			    			keyboardControls: true,
			    			infiniteSlider: true,
			    			navNextSelector: jQuery('.next'),
			    			navPrevSelector: jQuery('.prev'),
			    			responsiveSlides: true,
			    			responsiveSlideContainer: true,
			    			navSlideSelector: jQuery('.selectors .item'),
			    			onSlideChange: slideContentChange,
			    			onSlideComplete: slideContentComplete,
			    			onSliderLoaded: slideContentLoaded
			    		});
			    		
			    	}); 

			    	function slideContentChange(args) {
			    		
			    		/* indicator */
			    		jQuery(args.sliderObject).parent().find('.iosSliderButtons .button').removeClass('selected');
			    		jQuery(args.sliderObject).parent().find('.iosSliderButtons .button:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
			    		
			    	}
			    	
			    	function slideContentComplete(args) {
			    		
			    		if(!args.slideChanged) return false;
			    		
			    		/* animation */
			    		jQuery(args.sliderObject).find('.text1, .text2').attr('style', '');
			    		
			    		jQuery(args.currentSlideObject).children('.text1').animate({
			    			right: '0%',
			    			opacity: '1'
			    		}, 400, 'easeOutQuint');
			    		
			    		jQuery(args.currentSlideObject).children('.text2').delay(200).animate({
			    			right: '0%',
			    			opacity: '1'
			    		}, 400, 'easeOutQuint');
			    		
			    	}
			    	
			    	function slideContentLoaded(args) {
			    		
			    		/* animation */
			    		jQuery(args.sliderObject).find('.text1, .text2').attr('style', '');
			    		
			    		jQuery(args.currentSlideObject).children('.text1').animate({
			    			right: '0%',
			    			opacity: '1'
			    		}, 400, 'easeOutQuint');
			    		
			    		jQuery(args.currentSlideObject).children('.text2').delay(200).animate({
			    			right: '0%',
			    			opacity: '1'
			    		}, 400, 'easeOutQuint');
			    		
			    		/* indicator */
			    		jQuery(args.sliderObject).parent().find('.iosSliderButtons .button').removeClass('selected');
			    		jQuery(args.sliderObject).parent().find('.iosSliderButtons .button:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
			    		
			    	}
			    	
			    	
			    	
			    </script>"; 

	return $html;		    
}  

add_shortcode("ios-slide", "curly_iosslide"); 		

function curly_iosslide( $atts, $content = null ) {
	extract(shortcode_atts(array(), $atts)); 
	 
    return '<div class="item">
	    		<div class="text1"><h3><a href="'.$atts['link'].'" title="'.$atts['title'].'">'.$atts['title'].'</a></h3></div>
	    		<div class="text2"><h4><a href="'.$atts['link'].'" title="'.$atts['subtitle'].'">'.$atts['subtitle'].'</a></h4></div>
	    		<img src='.$atts['image'].' alt="'.$atts['title'].' - '.$atts['subtitle'].'">
    		</div>';  
} 
?>