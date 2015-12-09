<?php 

	class CurlyExtensionVisualComposer {
		
		public function __construct() {
			
			/** Add Elements */
			add_action( 'vc_before_init', array( $this, 'add_accordion' ) );
			add_action( 'vc_before_init', array( $this, 'add_action' ) );
			add_action( 'vc_before_init', array( $this, 'add_agenda' ) );
			add_action( 'vc_before_init', array( $this, 'add_alert' ) );
			add_action( 'vc_before_init', array( $this, 'add_box' ) );
			add_action( 'vc_before_init', array( $this, 'add_button' ) );
			add_action( 'vc_before_init', array( $this, 'add_countdown' ) );
			add_action( 'vc_before_init', array( $this, 'add_dividers' ) );
			add_action( 'vc_before_init', array( $this, 'add_person' ) );
			add_action( 'vc_before_init', array( $this, 'add_toggle' ) );
			add_action( 'vc_before_init', array( $this, 'add_tabs' ) );
			add_action( 'vc_before_init', array( $this, 'add_pricing' ) );
			
			/** Construct Elements */
			add_action( 'vc_before_init', array( $this, 'construct_single_image' ) );
			
			/** Add Filters */
			add_filter( 'shortcode_atts_vc_single_image', array( $this, 'filter_single_image_atts' ), 10, 3 );
			
			
			
		}
	    
	    
	    /* !Add Elements */	
	    
	    
	    /** Add Person */
	    public function add_person() {
	    	
	    	vc_map( 
	    		array(
		    	    "name" => __("Person", "CURLYTHEME"),
		    	    "base" => "person",
		    	    "content_element" => true,
		    	    "icon" => "curly_icon",
		    	    "class" => '',
		    	    "category" => __('Curly Themes Extension', "CURLYTHEME"),   
		    	    "params" => array(
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("Person Name", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-6',
		    	            "holder" => "div",
		    	            "param_name" => "name"
		    	        ),
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("Position", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-6 vc_column',
		    	            "param_name" => "position"
		    	        ),
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("E-mail", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-3 vc_column',
		    	            "param_name" => "email"
		    	        ),
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("Facebook", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-3 vc_column',
		    	            "param_name" => "facebook"
		    	        ),
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("Twitter", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-3 vc_column',
		    	            "param_name" => "twitter"
		    	        ),
		    	        array(
		    	            "type" => "textfield",
		    	            "heading" => __("LinkedIn", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-3 vc_column',
		    	            "param_name" => "linkedin"
		    	        ),
		    	         array(
		    	            "type" => "attach_image",
		    	            "heading" => __("Image", "CURLYTHEME"),
		    	            'edit_field_class' => 'vc_col-sm-6 vc_column',
		    	            "param_name" => "picture"
		    	        ),
		    	        array(
							'type' => 'checkbox',
							'heading' => __("Small Pictures?", "CURLYTHEME"),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'param_name' => 'style',
							'value' => array( __( 'Yes', 'CURLYTHEME' ) => 'mini' )
						),
		    	        array(
		    	            "type" => "textarea_html",
		    	            "heading" => __("Extra Description", "CURLYTHEME"),
		    	            "param_name" => "content"
		    	        )
	    	    	)
	    		) 
	    	);
	    }
		
			
		/** Accordion */
		public function add_accordion() {
		
			/** Accordion */
			vc_map( array(
			   "name" => __("Accordion", "CURLYTHEME"),
			   "base" => "accordion",
			   "as_parent" => array( 'only' => 'toggle' ) ,
			   "content_element" => true,
			   'is_container' => true,
			   "show_settings_on_create" => false,
			   "admin_enqueue_css" => array( plugins_url( '/css/vc-icon.css' , __FILE__ ) ),
			   "icon" => "curly_icon",
			   "category" => __('Curly Themes Extension', "CURLYTHEME"),
			   "js_view" => 'VcColumnView'
			) );
			
			/** Toggle */
			vc_map( array(
			    "name" => __("Toggle", "CURLYTHEME"),
			    "base" => "toggle",
			    "as_child" => array( 'only' => 'accordion' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
			        array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "checkbox",
			            "heading" => __("Opened", "CURLYTHEME"),
			            "param_name" => "opened"
			        ),
			        array(
			            "type" => "textarea_html",
			            "heading" => __("Content", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "content"
			        ),
			    )
			) );
		}
		
		
		
		/** Action */
		public function add_action() {
		
			vc_map( array(
			   "name" => __("Action", "CURLYTHEME"),
			   "base" => "call2action",
			   "as_parent" => array( 'only' => 'vc_column_text' ),
			   "content_element" => true,
			   'is_container' => true,
			   "show_settings_on_create" => false,
			   "admin_enqueue_css" => array( plugins_url( '/css/vc-icon.css' , __FILE__ ) ),
			   "icon" => "curly_icon",
			   "category" => __('Curly Themes Extension', "CURLYTHEME"),
			   "params" => array(
			        array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6',
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Button", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "button_vc"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Link", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "link"
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Box Style", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'style',
						'value' => array( 1, 2, 3, 4, 5 )
			        )
			    ),
			   "js_view" => 'VcColumnView'
			) );
			
		}
		
		
		
		
		/** Agenda */
		public function add_agenda() {
		
			vc_map( array(
			   "name" => __("Agenda", "CURLYTHEME"),
			   "base" => "agenda",
			   "as_parent" => array( 'only' => 'event_day,event' ),
			   "content_element" => true,
			   'is_container' => true,
			   "show_settings_on_create" => false,
			   "admin_enqueue_css" => array( plugins_url( '/css/vc-icon.css' , __FILE__ ) ),
			   "icon" => "curly_icon",
			   "category" => __('Curly Themes Extension', "CURLYTHEME"),
			   "js_view" => 'VcColumnView'
			) );
			
			vc_map( array(
			    "name" => __("Event Day", "CURLYTHEME"),
			    "base" => "event_day",
			    "as_child" => array( 'only' => 'agenda' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
			        array(
			            "type" => "textfield",
			            "heading" => __("Date", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "date"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            "param_name" => "content"
			        ),
			    )
			) );
			
			vc_map( array(
			    "name" => __("Event", "CURLYTHEME"),
			    "base" => "event",
			    "as_child" => array( 'only' => 'agenda' ),
			    "as_parent" => array( 'only' => 'vc_column_text,curly_toggle_box' ),
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
			        array(
			            "type" => "textfield",
			            "heading" => __("Time", "CURLYTHEME"),
			            "param_name" => "time"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Room", "CURLYTHEME"),
			            "param_name" => "room"
			        )
			    ),
			    "js_view" => 'VcColumnView'
			) );
			
		}
		
		
		
		/** Add Alerts */
		function add_alert(){
			
			vc_map( array(
			    "name" => __("Alert", "CURLYTHEME"),
			    "base" => "alert",
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",		
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),	    
			    "params" => array(
			        array(
				        'type' => 'dropdown',
						'heading' => __("Color", 'CURLYTHEME'),
						'param_name' => 'color',
						'value' => array(
							__( 'Green', 'CURLYTHEME' ) => 'green',
							__( 'Blue', 'CURLYTHEME' ) => 'blue',
							__( 'Red', 'CURLYTHEME' ) => 'red',
							__( 'Orange', 'CURLYTHEME' ) => 'orange',
						)
			        ),
			        array(
			            "type" => "textarea_html",
			            "heading" => __("Content", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "content"
			        ),
			    )
			) );
			
		}
		
		
		
		/** Add Boxes */
		function add_box(){
			
			vc_map( array(
			    "name" => __("Box", "CURLYTHEME"),
			    "base" => "box",
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",	
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),		    
			    "params" => array(
				    array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6',
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Icon", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "icon"
			        ),
			        array(
			            "type" => "colorpicker",
			            "heading" => __("Background", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "background"
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Box Style", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'style',
						'value' => array( 1, 2, 3, 4, 5 )
			        ),
			        array(
			            "type" => "textarea_html",
			            "heading" => __("Content", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "content"
			        ),
			    )
			) );
			
		}
		
		
		
		/** Add Button */
		function add_button(){
			
			vc_map( array(
			    "name" => __("Button", "CURLYTHEME"),
			    "base" => "button",
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",	
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),		    
			    "params" => array(
				    array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6',
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Label", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "content"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Link", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "link"
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Size", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'style',
						'value' => array( __( 'Normal', 'CURLYTHEME' ) => 'normal', __( 'Mini', 'CURLYTHEME' ) => 'mini', __( 'Small', 'CURLYTHEME' ) => 'small', __( 'Large', 'CURLYTHEME' ) => 'large' )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Color", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'color',
						'value' => array( __( 'Red', 'CURLYTHEME' ) => 'red', __( 'Green', 'CURLYTHEME' ) => 'green', __( 'Blue', 'CURLYTHEME' ) => 'blue', __( 'Violet', 'CURLYTHEME' ) => 'violet', __( 'Navy', 'CURLYTHEME' ) => 'navy', __( 'Gray', 'CURLYTHEME' ) => 'gray' )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Target", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'target',
						'value' => array( '_self', '_blank' )
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Rel Attribute", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "rel"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Class", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-6 vc_column',
			            "param_name" => "class"
			        ),
			    )
			) );
			
		}
		
		
		
		
		/** Add Countdown */
		function add_countdown(){
			
			vc_map( array(
			    "name" => __("Countdown", "CURLYTHEME"),
			    "base" => "countdown",
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",	
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),		    
			    "params" => array(
				    array(
			            "type" => "dropdown",
			            "heading" => __("Year", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-2',
			            "param_name" => "year",
			            "value"	=> array( date("Y"), date("Y") + 1, date("Y") + 2, date("Y") + 3 )
			        ),
			        array(
			            "type" => "dropdown",
			            "heading" => __("Month", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-2',
			            "param_name" => "month",
			            "value"	=> range( 1, 12 )
			        ),
			        array(
			            "type" => "dropdown",
			            "heading" => __("Day", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-2',
			            "param_name" => "day",
			            'value'	=> range( 1, 31 )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Hour", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-2',
						'param_name' => 'hour',
						'value' => range( 0, 23 )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Minutes", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-2 vc_column',
						'param_name' => 'minutes',
						'value' => range( 0, 59 )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Language", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'lang',
						'value' => array( 'en', 'ar',  'bg', 'bn', 'bs', 'ca', 'cs', 'cy', 'da', 'de', 'el', 'es', 'et', 'fa', 'fi', 'fr', 'gl', 'gu', 'he', 'hr', 'hu', 'hy', 'id', 'it', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'ms', 'my', 'nb', 'nl', 'pl', 'pt-BR', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr-SR', 'sr', 'sv', 'th', 'tr', 'uk', 'uz', 'vi', 'zh-CN', 'zh-TW' )
			        ),
			        array(
				        'type' => 'dropdown',
						'heading' => __("Alignment", 'CURLYTHEME'),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
						'param_name' => 'align',
						'value' => array( 'left', 'center', 'right' )
			        )
			    )
			) );
			
		}
		
		
		
		/** Add Dividers */
		function add_dividers(){
			
			vc_map( array(
			    "name" => __("Divider", "CURLYTHEME"),
			    "base" => "divider",
			    "content_element" => true,
			    "icon" => "curly_icon",	
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),		    
			    "params" => array(
			         array(
			            "type" => "textfield",
			            "heading" => __("Space Before", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-4',
			            "param_name" => "before"
			        ),
			         array(
			            "type" => "textfield",
			            "heading" => __("Space After", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-4',
			            "param_name" => "after",
			            'value' => 40
			        ),
			        array(
			            "type" => "dropdown",
			            "heading" => __("Style", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-4',
			            "param_name" => "year",
			            "value"	=> range( 1,5 )
			        ),
			    )
			) );
			
		}
		
		
		/** Add Toggle Box */
		public function add_toggle(){
			
			vc_map( array(
			    "name" => __("Toggle Box", "CURLYTHEME"),
			    "base" => "curly_toggle_box",
			    "content_element" => true,
			    "icon" => "curly_icon",	
			    "category" => __('Curly Themes Extension', "CURLYTHEME"),		    
			    "params" => array(
			        array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "textarea_html",
			            "heading" => __("Content", "CURLYTHEME"),
			            "param_name" => "content"
			        ),
			    )
			) );
			
		}
		
		
		
		/** Tabs */
		public function add_tabs() {
		
			/** Tabs */
			vc_map( array(
			   "name" => __("Tabs", "CURLYTHEME"),
			   "base" => "curly_tabs",
			   "as_parent" => array( 'only' => 'curly_tab' ) ,
			   "content_element" => true,
			   'is_container' => true,
			   "show_settings_on_create" => false,
			   "admin_enqueue_css" => array( plugins_url( '/css/vc-icon.css' , __FILE__ ) ),
			   "icon" => "curly_icon",
			   "category" => __('Curly Themes Extension', "CURLYTHEME"),
			   "js_view" => 'VcColumnView'
			) );
			
			/** Tab */
			vc_map( array(
			    "name" => __("Tab", "CURLYTHEME"),
			    "base" => "curly_tab",
			    "as_child" => array( 'only' => 'curly_tabs' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
				    array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "title"
			        ),
			        array(
			            "type" => "textarea_html",
			            "heading" => __("Content", "CURLYTHEME"),
			            "param_name" => "content"
			        ),
			    )
			) );
		}
		
		
		
		
		/** Pricing Table */
		public function add_pricing() {
		
			vc_map( array(
			   "name" => __("Pricing Table", "CURLYTHEME"),
			   "base" => "curly_pricing_table",
			   "as_parent" => array( 'only' => 'curly_pricing_column' ),
			   "content_element" => true,
			   'is_container' => true,
			   "show_settings_on_create" => false,
			   "admin_enqueue_css" => array( plugins_url( '/css/vc-icon.css' , __FILE__ ) ),
			   "icon" => "curly_icon",
			   "category" => __('Curly Themes Extension', "CURLYTHEME"),
			   "js_view" => 'VcColumnView'
			) );
			
			vc_map( array(
			    "name" => __("Pricing Column", "CURLYTHEME"),
			    "base" => "curly_pricing_column",
			    "as_child" => array( 'only' => 'curly_pricing_table' ) ,
			    "as_parent" => array( 'only' => 'curly_pricing_header,curly_pricing_row,curly_pricing_footer' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
			        array(
			            "type" => "dropdown",
			            "heading" => __("Size", "CURLYTHEME"),
			            "param_name" => "size",
			            'edit_field_class' => 'vc_col-sm-6',
			            'value' => array( '1/4', '1/3', '1/2' )
			        ),
			        array(
						'type' => 'checkbox',
						'heading' => __("Highlight Column", "CURLYTHEME"),
						'param_name' => 'highlight',
						'edit_field_class' => 'vc_col-sm-6',
					)
			    ),
			    "js_view" => 'VcColumnView'
			) );
			
			vc_map( array(
			    "name" => __("Header", "CURLYTHEME"),
			    "base" => "curly_pricing_header",
			    "as_child" => array( 'only' => 'curly_pricing_column' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
				    array(
			            "type" => "textfield",
			            "heading" => __("Title", "CURLYTHEME"),
			            "holder" => "div",
			            "param_name" => "content"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Currency", "CURLYTHEME"),
			            "holder" => "span",
			            'edit_field_class' => 'vc_col-sm-4 vc_column',
			            "param_name" => "currency"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Price", "CURLYTHEME"),
			            "holder" => "span",
			            'edit_field_class' => 'vc_col-sm-4 vc_column',
			            "param_name" => "price"
			        ),
			        array(
			            "type" => "textfield",
			            "heading" => __("Frequency", "CURLYTHEME"),
			            'edit_field_class' => 'vc_col-sm-4 vc_column',
			            "param_name" => "frequency"
			        ),
			    )
			) );
			
			vc_map( array(
			    "name" => __("Row", "CURLYTHEME"),
			    "base" => "curly_pricing_row",
			    "as_child" => array( 'only' => 'curly_pricing_column' ) ,
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",			    
			    "params" => array(
			        array(
			            "type" => "textarea_html",
			            "holder" => "div",
			            "heading" => __("Content", "CURLYTHEME"),
			            "param_name" => "content"
			        ),
			    )
			) );
			
			vc_map( array(
			    "name" => __("Footer", "CURLYTHEME"),
			    "base" => "curly_pricing_footer",
			    "as_child" => array( 'only' => 'curly_pricing_column' ) ,
			    "as_parent" => array( 'only' => 'button,vc_btn' ),
			    "content_element" => true,
			    'is_container' => true,
			    "icon" => "curly_icon",
			    "js_view" => 'VcColumnView'
			) );
			
		}
		
		
		
		
		/* !Constructors */
		
		/** Construct Single Image */
		function construct_single_image(){
			
			vc_add_param( 'vc_single_image', 
				array(
					'type' => 'checkbox',
					'heading' => __("Add Photo Stack Effect", "CURLYTHEME"),
					'param_name' => 'photo_frame',
					'weight'	=> 1
				) 
			);
			
			vc_add_param( 'vc_single_image', 
				array(
					'type' => 'checkbox',
					'heading' => __("Add Zoomify Effect", "CURLYTHEME"),
					'param_name' => 'zoomify',
					'weight'	=> 2
				) 
			);
			
		}
		
		
		
		/* !Filters */
		
		/** Filter Single Image */
		function filter_single_image_atts( $out, $pairs, $atts ){
			
			if( isset( $out['photo_frame'] ) && filter_var( $out['photo_frame'], FILTER_VALIDATE_BOOLEAN ) === true )
				$out['el_class'] = $out['el_class'] . ' photo-frame';
			
			if( isset( $out['zoomify'] ) && filter_var( $out['zoomify'], FILTER_VALIDATE_BOOLEAN ) === true ){
				
				if( ! wp_script_is('curly-picture-zoom' ) ) { 
					
					wp_enqueue_script('curly-picture-zoom');
					
				}
				
				$out['el_class'] = $out['el_class'] . ' zoom-picture-container photo-frame';
				
			}	
		    
		    return $out;
			
		}
		
		
	}
	
	/** Initialize the Class */
	new CurlyExtensionVisualComposer;
	
	/** Check if Visual Composer is Activated */
	if ( defined( 'WPB_VC_VERSION' ) ) {
		
	}
	
	add_action( 'admin_init', 'curly_extenders' );
	
	function curly_extenders(){
			
		/** Extend Classes */
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_accordion extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_call2action extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_agenda extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_event extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_curly_tabs extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_curly_pricing_table extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_curly_pricing_column extends WPBakeryShortCodesContainer {}
			class WPBakeryShortCode_curly_pricing_footer extends WPBakeryShortCodesContainer {}
		}
		if ( class_exists( 'WPBakeryShortCode' ) ) {
		    class WPBakeryShortCode_toggle extends WPBakeryShortCode {}
		    class WPBakeryShortCode_event_day extends WPBakeryShortCode {}
		    class WPBakeryShortCode_curly_tab extends WPBakeryShortCode {}
		    class WPBakeryShortCode_curly_header extends WPBakeryShortCode {}
		    class WPBakeryShortCode_curly_row extends WPBakeryShortCode {}
		    
		}
			
	}
	
	
?>