<?php

$prefix = 'eque_recent_';

add_action( 'widgets_init', 'curly_recent_widget' );


function curly_recent_widget() {
	register_widget( 'recent_Widget' );
}

class recent_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'custom_recent_posts', 'description' => __('A widget that displays the recent posts', 'CURLYTHEME') );
		parent::__construct( 'curly_recent_widget', __('Curly Themes: Recent Posts', 'CURLYTHEME'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$limit = $instance['limit'];
		$picture = $instance['picture'];
		$exclude = $instance['exclude'];
		$cat = $instance['cat'];
		$cols = isset( $instance['cols'] ) ? $instance['cols'] : 1;
		
		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
			
		$args = array(
				'posts_per_page'  => $limit,
				'exclude'         => $exclude,
				'category'		  => $cat,
				'post_type'       => 'post'
				);
			
		$posts   = get_posts($args);
		
		$html 	 = "<ul class='recent-posts type-$picture'>";
			$count = 0;
			foreach( $posts as $post ){
				setup_postdata( $post ); $count++;
				
				if ( $count%2 == 0 ) $css = 'recent-news-even'; else $css = 'recent-news-odd';
				
				$css .= ' recent-post  cols-' . $cols;
				
				$html .= '<li class="'.$css.' clearfix">';
				
				if($picture != 'none'){
					if(has_post_thumbnail($post->ID)){
					$html .= '<time datetime="'.get_the_time( 'Y-m-d', $post->ID ).'"><span>'.get_the_time( 'd', $post->ID ).'</span><em>'.get_the_time( 'M' , $post->ID).'</em></time>';
					$html .= '<a href="'.get_permalink().'">';
					$html .= get_the_post_thumbnail($post->ID, $picture, array('class' => 'img-responsive')); 
					$html .= '</a>';
					} else {
						$html .= '<time datetime="'.get_the_time( 'Y-m-d', $post->ID ).'"><span>'.get_the_time( 'd', $post->ID ).'</span><em>'.get_the_time( 'M' , $post->ID).'</em></time>';
					}
				}
				
				$html .= '<h6><a href="'.get_permalink($post->ID).'">'.get_the_title($post).'</a></h6>';
				$html .= '<span>'.get_the_category_list(' - ',null, $post->ID).'</span>';
				
				$html .= '</li>';
			}
			$html 	.= '</ul>';
		
		echo $html;	
		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['picture'] = strip_tags( $new_instance['picture'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['cat'] = strip_tags( $new_instance['cat'] );
		$instance['cols'] = strip_tags( $new_instance['cols'] );
	
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array(
			'title' => null,
			'limit' => null,
			'picture' => 'thumbnail',
			'exclude' => null,
			'cat' => null,
			'cols' => '1'
		);

		//Set up some default widget settings.
		$instance = wp_parse_args( (array) $instance, $defaults); ?>
		<div class="widget-content">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', 'CURLYTHEME'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
            </p>
			
            
            <p>
                <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Limit Posts:', 'CURLYTHEME'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" class="widefat" />
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'picture' ); ?>"><?php _e('Thumbnail:', 'CURLYTHEME'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'picture' ); ?>" name="<?php echo $this->get_field_name( 'picture' ); ?>">
                	<option <?php echo ($instance['picture'] == 'none') ? 'selected="selected"' : null; ?> value="none">no thumbnail</option>
                    <option <?php echo ($instance['picture'] == 'thumbnail') ? 'selected="selected"' : null; ?> value="thumbnail">square thumbnail</option>
                    <option <?php echo ($instance['picture'] == 'large') ? 'selected="selected"' : null; ?> value="large">fullwidth</option>
                </select>
                
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude Posts:', 'CURLYTHEME'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" class="widefat" />
                <small>Comma separated ID's you want to exclude</small>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e('Choose Categories:', 'CURLYTHEME'); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" value="<?php echo $instance['cat']; ?>" class="widefat" />
                <small>Comma separated ID's you want to include</small>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'cols' ); ?>"><?php _e('Display Columns:', 'CURLYTHEME'); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>">
                	<option <?php echo ( $instance['cols'] === '1' ) ? 'selected="selected"' : null; ?> value="1"><?php _e( '1 Column', 'CURLYTHEME' ) ?></option>
                	<option <?php echo ( $instance['cols'] === '2' ) ? 'selected="selected"' : null; ?> value="2"><?php _e( '2 Columns', 'CURLYTHEME' ) ?></option>
                	<option <?php echo ( $instance['cols'] === '3' ) ? 'selected="selected"' : null; ?> value="3"><?php _e( '3 Columns', 'CURLYTHEME' ) ?></option>
                	<option <?php echo ( $instance['cols'] === '4' ) ? 'selected="selected"' : null; ?> value="4"><?php _e( '4 Columns', 'CURLYTHEME' ) ?></option>
                   
                </select>
                
            </p>
            
		</div> 

	<?php
	}
}
?>