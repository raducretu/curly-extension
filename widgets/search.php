<?php

$prefix = 'eque_search_';

add_action( 'widgets_init', 'curly_search_widget' );


function curly_search_widget() {
	register_widget( 'search_Widget' );
}

class search_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'custom_search', 'description' => __('A widget that displays the custom search', 'CURLYTHEME') );
		parent::__construct( 'curly_search_widget', __('Curly Themes: Custom Search', 'CURLYTHEME'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		if (isset($title)) {
			$title = apply_filters('widget_title', $instance['title'] );
		}
		
		echo $before_widget;
		
		if (isset($title)) echo $before_title . $title . $after_title;
			
		$out  = '<form role="search" method="get" id="custom-search-form" action="'.get_bloginfo('url').'">
					<input type="text" value="" class="form-control" placeholder="'.__('Search ...','CURLYTHEME').'" name="s" id="s">
				</form>';
		
		echo $out;
		echo $after_widget;
	}

	//Update the widget 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array(  
			           'title' => null
			       );
			       
		//Set up some default widget settings.
		$instance = wp_parse_args( (array) $instance, $defaults); ?>
		<div class="widget-content">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', 'CURLYTHEME'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
            </p>       
		</div> 

	<?php
	}
}
?>