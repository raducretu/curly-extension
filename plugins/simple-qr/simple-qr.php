<?php
/*
Plugin Name: Simple QR Codes
Plugin URI: http://www.curlythemes.com
Description: This plugin gives you a simple shortcode for QR Codes
Version: 1.1.1
Author: Curly Themes
Author URI: http://www.curlythemes.com
*/

function curly_qr_options_header() {
	if ( !is_admin() ) {
		wp_enqueue_style('arrow-icons', plugins_url( '/css/arrow-icons.css' , __FILE__ ), true);
		wp_enqueue_style('arrow-icons-font', 'http://fonts.googleapis.com/css?family=Pacifico', true);
	} 
}
add_action('wp_enqueue_scripts', 'curly_qr_options_header');

function curly_qr( $atts ) {
	extract(shortcode_atts(array(  
	    'type'  	=> null,
		'title'  	=> null,
		'url'  		=> null,
		'name'  	=> null,
		'address'  	=> null,
		'phone'  	=> null,
		'email'  	=> null,
		'message'  	=> null,
		'wifi_type' => null,
		'ssid'  	=> null,
		'password'  => null,
		'text'  	=> null,
		'lat'  		=> null,
		'lon'  		=> null,
		'height'  	=> null,
		'align'  	=> null,
		'size'  	=> '200',
		'alt' 		=> get_the_title(),
		'pointer_text' 		=> null,
		'pointer_color' 	=> '#CC0000',
		'pointer_position' 	=> 'left',
		'margin' 	=> 20
		
	), $atts)); 
	
	switch($type){
	
		case 'url' : 
			$out = 'type=url&amp;url='.$atts['url']; 
			break;
		case 'contact' : 
			$out = 'type=contact&amp;name='.$atts['name'].'&amp;address='.$atts['address'].'&amp;phone='.$atts['phone'].'&amp;email='.$atts['email']; 
			break;
		case 'email' : 
			$out = 'type=email&amp;email='.$atts['email'].'&amp;subject='.$atts['subject'].'&amp;message='.$atts['message']; 
			break;
		case 'geo' : 
			$out = 'type=geo&amp;lat='.$atts['lat'].'&amp;lon='.$atts['lon'].'&amp;height='.$atts['height']; 
			break;
		case 'phone' : 
			$out = 'type=phone&amp;phone='.$atts['phone']; 
			break;
		case 'sms' : 
			$out = 'type=sms&amp;phone='.$atts['phone'].'&amp;message='.$atts['message']; 
			break;
		case 'text' : 
			$out = 'type=text&amp;text='.$text; 
			break;
		case 'wifi' : 
			$out = 'type=wifi&amp;wifi_type='.$atts['wifi_type'].'&amp;ssid='.$atts['ssid'].'&amp;password='.$atts['password']; 
			break;
		case 'bookmark' : 
			$out = 'type=bookmark&amp;text='.$title.'&amp;url='.$url; 
			break;
		case 'auto' : 
			$out = 'type=url&amp;url='.get_permalink(); 
			break;
	}
	
	$css = 'alignnone';
	
	switch($align){
		case 'right'  :  $css = 'alignright'; break;
		case 'left'   :  $css = 'alignleft'; break;
		case 'center' :  $css = 'aligncenter'; break;
	}
	$arrow = null;
	if(isset($pointer_text)){
		$arrow = '<span style="color:'.$pointer_color.'; margin-top: -'.($margin+3).'px; text-align: '.$pointer_position.'" data-arrow-icon="4">';
		$arrow .= $pointer_text.'</span>';
	}
	
	$inline = ($margin) ? ' style="margin-bottom: '.$margin.'px" ' : null;
	
	$html = '<div class="simple-qr" style="width: '.$size.'px"><img src="'.plugins_url().'/curly-extension/plugins/simple-qr/qr-generator.php?size='.$atts['size'].'&amp;'.$out.'" class="wp-image-qr '.$css.'" alt="'.$alt.'" '.$inline.'>'.$arrow.'</div>';
	
	return $html;
	
}
add_shortcode( 'simple-qr', 'curly_qr' );

?>