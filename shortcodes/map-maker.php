<?php
add_shortcode("map-maker", "curly_mapmaker"); 		

function curly_mapmaker( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		      'latitude'    => null,
		      'longitude'   => null,
		      'color' 		=> null,
		      'height' 		=> 400,
		      'zoom'   		=> 15,
		      'type'   		=> 'roadmap',
		      'marker'		=> null,
		      'title'		=> null,
		      'draggable'	=> 'false',
		      'controls'	=> 'true',
		      'address'		=> null,
		      'border'		=> 'true'
	     ), $atts ) );
	
	if ( $latitude && $longitude || $address ) {

		if( !wp_script_is('curly-google-maps') ) { 
			wp_enqueue_script('curly-google-maps');
		}
		if( !wp_script_is('curly-gmap3') ) { 
			wp_enqueue_script('curly-gmap3');
		}
		
		if ( isset( $GLOBALS['mapID'] ) ) {
			$GLOBALS['mapID']++; 
		} else { 
			$GLOBALS['mapID'] = 0;
		}
		
		
		$html  = '<div class="map-container '.( ( $border == "true" ) ? 'featured-image' : null ).'"><div id="map'.$GLOBALS['mapID'].'" style="height: '.$height.'px;"></div></div>';
		
		if ( $content ) {
			$markers = 'marker:{
							values:['.do_shortcode( $content ).'],
							events:{
								mouseover: function(marker, event, context){
									var map = jQuery(this).gmap3("get"),
									infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
									if (infowindow){
										infowindow.open(map, marker);
										infowindow.setContent(context.data);
									} else {
										jQuery(this).gmap3({
											infowindow:{
												anchor:marker, 
												options:{content: context.data}
											}
										});
									}
								},
								mouseout: function(){
									var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
									if (infowindow){
										infowindow.close();
									}
								}
							}
						}';
		} else {
			$markers = 'marker:{
							values:[{
								'.( ( $address ) ? 'address:"'.$address.'", ' : null ).'
								'.( ( $latitude && $longitude ) ? 'latLng:['.$latitude.', '.$longitude.'],' : null ).'
								'.( ( $title ) ? 'data:"'.$title.'",' : null ).'
								'.( ( $marker ) ? 'options:{icon: "'.$marker.'"}' : null ).'
							}],
							events:{
								mouseover: function(marker, event, context){
									var map = jQuery(this).gmap3("get"),
									infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
									if (infowindow){
										infowindow.open(map, marker);
										infowindow.setContent(context.data);
									} else {
										jQuery(this).gmap3({
											infowindow:{
												anchor:marker, 
												options:{content: context.data}
											}
										});
									}
								},
								mouseout: function(){
									var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
									if (infowindow){
										infowindow.close();
									}
								}
							}
						}';
		}
		
		$html .= 
		'<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#map'.$GLOBALS['mapID'].'").gmap3({
				map:{
					options:{
						center: ['.$latitude.', '.$longitude.'],
						zoom: '.$zoom.',
						draggable: '.$draggable.',
						mapTypeControl: '.$controls.',
						scrollwheel: false,
						mapTypeId: google.maps.MapTypeId.'.strtoupper($type).',
						'.( ( $color ) ? 'styles: [{stylers: [{ hue: "'.$color.'" }]}]' : null ).'
					},
				},
				'.$markers.'
			});
		});	
		</script>';
		
		return $html;
	}								 		 
}

add_shortcode("location", "curly_map_location"); 		

function curly_map_location( $atts, $content = null ) {
	extract( shortcode_atts( array(
		      'latitude'    => null,
		      'longitude'   => null,
		      'title' 		=> null,
		      'marker' 		=> null,
		      'address'   	=> null
	     ), $atts ) );
	return '{'	.( ( $address ) ? 'address:"'.$address.'", ' : null )
				.( ( $latitude && $longitude ) ? 'latLng:['.$latitude.', '.$longitude.'], ' : null )
				.( ( $title ) ? 'data:"'.$title.'", ' : null )
				.( ( $marker ) ? 'options:{ icon: "'.$marker.'"}' : null ).
		   '},';
}
?>