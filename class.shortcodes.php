<?php 

class CurlyShortcodes {
	
	function __construct() {
		
		/** Icon Shortcode */
		if ( ! shortcode_exists( 'icon' ) ) {
			add_shortcode( 'icon', array( $this, 'icon_shortcode' ) );
			add_shortcode( 'curly_icon', array( $this, 'icon_shortcode' ) );
		} else {
			add_shortcode( 'curly_icon', array( $this, 'icon_shortcode' ) );
		}
		
		/** Dropcap Shortcode */
		if ( ! shortcode_exists( 'dropcap' ) ) {
			add_shortcode( 'dropcap', array( $this, 'dropcap_shortcode' ) );
			add_shortcode( 'curly_dropcap', array( $this, 'dropcap_shortcode' ) );
		} else {
			add_shortcode( 'curly_dropcap', array( $this, 'dropcap_shortcode' ) );
		}
		
		/** Lead Shortcode */
		if ( ! shortcode_exists( 'lead' ) ) {
			add_shortcode( 'lead', array( $this, 'lead_shortcode' ) );
			add_shortcode( 'curly_lead', array( $this, 'lead_shortcode' ) );
		} else {
			add_shortcode( 'curly_lead', array( $this, 'lead_shortcode' ) );
		}
		
	}
	
	/** Lead Shortcode */
	function lead_shortcode( $atts, $content = null ) {
		return '<p class="lead">'.$content.'</p>';
	}
	
	/** Dropcap Shortcode */
	function dropcap_shortcode( $atts, $content = null ) {
		return '<span class="dropcap">'.$content.'</span>';
	}
		
	/** Icon Shortcode */
	function icon_shortcode( $atts, $content = null ) {
		
		$css = $style = array();
		
		/** Check for icon */
		if ( isset( $atts['icon'] ) ) {
			
			/** Set icon */
			if ( strpos( $atts['icon'] ,'fa-') !== false ){
				$icon = $atts['icon'];
			} else {
				$icon = 'fa-'.$atts['icon'];
			}
			
			/** Set icon size */
			if ( isset( $atts['size'] ) ) {
				switch ( strtolower( $atts['size'] ) ) {
					case '2x' : $icon .= ' fa-2x'; break;
					case '3x' : $icon .= ' fa-3x'; break;
					case '4x' : $icon .= ' fa-4x'; break;
					case '5x' : $icon .= ' fa-5x'; break;
					case 'lg' : $icon .= ' fa-lg'; break;
				}
			}
			
			/** Display */
			if ( isset( $atts['display'] ) ) {
				switch ( strtolower( $atts['display'] ) ) {
					case 'inline' : $icon .= ' display-inline'; break;
					case 'block' : $icon .= ' center-block'; break;
				}
			}
			
			/** Icon color */
			if ( isset( $atts['color'] ) ) {
				array_push( $style, 'color: '.$atts['color'] );
			}
			
			/** Border */
			if ( isset( $atts['border'] ) ) {
				array_push( $css, 'fa-bordered' );
				array_push( $style, 'border: '.$atts['border'] );
			}
			if ( isset( $atts['border_color'] ) || isset( $atts['border_style'] ) || isset( $atts['border_size'] ) ) {
				array_push( $css, 'fa-bordered' );
				if ( isset( $atts['border_color'] )  ) {
					array_push( $style, 'border-color: '.$atts['border_color'] );
				}
				if ( isset( $atts['border_style'] )  ) {
					array_push( $style, 'border-style: '.$atts['border_style'] );
				}
				if ( isset( $atts['border_size'] )  ) {
					array_push( $style, 'border-width: '.$atts['border_size'] );
				}
			}
			
			/** Style */
			if ( isset( $atts['boxed'] ) && $atts['boxed'] == 'yes' ) {
				array_push( $css, 'fa-boxed' );
			}
			
			/** Background */
			if ( isset( $atts['background'] ) ) {
				array_push( $css, 'fa-boxed' );
				array_push( $style, 'background-color: '.$atts['background'] );
			}
			
		}
		
		return isset( $atts['icon'] ) ? "<i class='fa fa-fw $icon ".implode( ' ', $css )."' style='".implode( '; ', $style )."'></i>" : null;
	}
}

new CurlyShortcodes();
?>