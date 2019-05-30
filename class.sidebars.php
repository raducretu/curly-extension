<?php
/**
* Whitelabel Sidebar Generator
* Used to create dynamic sidebars for your theme or plugin.
*
* @since Whitelabel Theme & Plugin Options 1.1
*
* @param string $url Base folder URI of the options page. This paramenter needs
* to be set for plugins, according with the plugins name. This parameter is
* optional for themes.
*
* @return void
*
*/

if ( ! class_exists( 'WhitelabelSidebars' ) ) {

	class WhitelabelSidebars {
		public $_prefix = 'white';

		public function __construct() {

			if ( is_admin() ) {
				add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
				add_action('admin_menu', array($this, 'add_submenu_page'));
				add_action('wp_ajax_update_sidebars', array($this, 'update_sidebars'));
				add_action('add_meta_boxes', array($this, 'meta_box'));
				add_action('save_post', array($this, 'save_meta_box_data'));
			}

			add_action('widgets_init', array($this, 'create_sidebars'));
			add_shortcode('dynamic-sidebar', array($this, 'sidebar_shortcode'));
		}

		function load_scripts() {
			if ( get_current_screen()->id == 'appearance_page_sidebars' ) {

				global $_wp_admin_css_colors;
				$admin_colors = $_wp_admin_css_colors;
				$color_scheme = $admin_colors[get_user_option('admin_color')]->colors;

				wp_register_style(
					'curly-google-font-roboto',
					'//fonts.googleapis.com/css?family=Roboto:400,300,700,900', 
					true
				);
				wp_register_style(
					'curly-sidebars',
					plugins_url('/enqueue-admin/css/sidebars.css', __FILE__ ),
					null,
					null,
					null
				);
				wp_register_script(
					'curly-sidebars',
					plugins_url('/enqueue-admin/js/sidebars.js', __FILE__ ),
					array('jquery'),
					null,
					true
				);

				if ( ! wp_script_is( 'curly-google-font-roboto', 'enqueued' ) ) {
					wp_enqueue_style( 'curly-google-font-roboto' );
				}

				if ( ! wp_script_is( 'curly-google-font-roboto', 'enqueued' ) ) {
					wp_enqueue_style( 'curly-sidebars' );
				}

				if ( ! wp_script_is( 'curly-google-font-roboto', 'enqueued' ) ) {
					wp_enqueue_script( 'curly-sidebars' );
				}

				$js_data = array(
					__('Remove','whitelabel'),
					__('Are you sure you want to delete this sidebar?','whitelabel'),
					__('Sidebar name cannot be empty. Please provide a valid name for your sidebar.','whitelabel'),
					__('You already have a sidebar with that name. Please provide a valid name for your sidebar.','whitelabel'),
					__('Your sidebar has been succesfully created.','whitelabel'),
					__('You currently have no sidebars created. <br>Use the form above to create your first sidebar.','whitelabel')
				);

				wp_localize_script('curly-sidebars', 'js_data', $js_data);

				$color_scheme = '
					#sidebars-wrapper input[type=submit],
					#sidebar-list li a:hover{
						background-color: '.$color_scheme[3].';
						color: #fff;
					}';

				wp_add_inline_style('curly-sidebars', $color_scheme);
			}
		}

		function update_sidebars() {

			$name 	= sanitize_text_field( $_POST['name'] );
			$id 	= sanitize_text_field( $_POST['id'] );
			$method = sanitize_text_field( $_POST['method'] );

			$sidebars 	= $this->get_sidebars();
			$count 		= $this->get_sidebars_count() + 1;

			if ( $method == 'update' ) {

				if ( !empty($name) ) {

					if ( !$sidebars ) {

						$sidebars = array( $count => $name );
						$sidebars = json_encode($sidebars);
						update_option( $this->_prefix . '_sidebars_list' , $sidebars );
						update_option( $this->_prefix . '_sidebars_list_count' , $count );

						echo json_encode( array( $count, $name ) );

					} else {

						if ( !in_array( $name , $sidebars ) ) {

							$sidebars[$count] = $name ;
							$sidebars = json_encode($sidebars);
							update_option( $this->_prefix . '_sidebars_list' , $sidebars );
							update_option( $this->_prefix . '_sidebars_list_count' , $count );

							echo json_encode( array( $count, $name ) );

						} else {
							echo 'duplicate';
						}
					}

				} else {
					echo 'empty';
				}

			}

			if ( $method == 'delete' ) {
				unset( $sidebars[$id] );
				$sidebars = json_encode($sidebars);
				update_option( $this->_prefix . '_sidebars_list' , $sidebars );
				echo 'success';
			}

			die();
		}

		function add_submenu_page(){
		     add_theme_page( __('Sidebars', 'whitelabel'), __('Sidebars', 'whitelabel'), 'edit_theme_options', 'sidebars', array($this, 'add_submenu_page_cb'));
		}

		function add_submenu_page_cb( $html = null ) {

			$sidebars = $this->get_sidebars();

			$html .= '<div id="sidebars-wrapper">';
				$html .= '<h1>'.__('Sidebars', 'whitelabel').'</h1>';
				$html .= '<form method="post" id="add-sidebar" action="">';
					$html .= '<input type="text" id="add-sidebar-field" placeholder="'.__('Enter new sidebar name','whitelabel').'">';
					$html .= '<input type="submit" id="add-sidebar-button" value="'.__('Add Sidebar','whitelabel').'">';
				$html .= '</form>';
				$html .= '<div id="messages"></div>';
				$html .= '<h3>'.__('Sidebar List','whitelabel').'</h3>';
				$html .= '<ul id="sidebar-list">';

				if ( $sidebars ) {

					foreach ($sidebars as $id => $name) {
						$html .= '<li>'.$name.' <code>[dynamic-sidebar id="'.$id.'"]</code><a href="#" data-sidebar-id="'.$id.'">'.__('Remove','whitelabel').'</a></li>';
					}

				} else {
					$html .= '<li id="no-sidebar">'.__('You currently have no sidebars created. <br>Use the form above to create your first sidebar.','whitelabel').'</li>';
				}

				$html .= '</ul>';
			$html .= '</div>';

			echo $html;
		}

		function get_sidebars() {
			$sidebars = get_option( $this->_prefix . '_sidebars_list' );
			$sidebars = json_decode( $sidebars , true);

			return $sidebars;
		}

		function get_sidebars_count() {
			$count = get_option( $this->_prefix . '_sidebars_list_count', 0 );

			return $count;
		}

		function create_sidebars() {
			$sidebars = $this->get_sidebars();
			if ( $sidebars ) {
				foreach ($sidebars as $id => $name) {
					register_sidebar( array(
					    'name'         => $name,
					    'id'           => 'dynamic-sidebar-'.$id,
					    'before_widget'	 => '<aside id="%1$s" class="sidebar-widget %2$s curly_animated">',
						'after_widget' 	 => '</aside>',
						'before_title'	 => '<h4 class="widget-title">',
						'after_title'	 => '</h4>',
					) );
				}
			}

		}

		public static function sidebar( $default = null, $logic = false, $return = false ) {

			global $post;

			$sidebar = get_post_meta( $post->ID, 'white_dynamic_sidebar', true );

			if( $return === true ){
				if ( $sidebar && is_active_sidebar( $sidebar ) ) return $sidebar;
				elseif( is_active_sidebar( $default ) ) return $default;
				else return;
			} else {
				if ( $logic === true ) {
					if ( $sidebar && is_active_sidebar( $sidebar ) ) {
						dynamic_sidebar( $sidebar );
					} elseif( is_active_sidebar( $default ) ) {
						dynamic_sidebar( $default );
					} else {
						return;
					}
				} else {
					if ( $sidebar ) {
						dynamic_sidebar( $sidebar );
					} else {
						dynamic_sidebar( $default );
					}
				}
			}
		}

		function sidebar_shortcode( $atts ) {

			ob_start();
			dynamic_sidebar( 'sidebar_'.$atts['id'] );
			$sidebar = ob_get_contents();
			ob_end_clean();

			return $sidebar;
		}

		public function meta_box() {
			$screens = array( 'post', 'page' );

				foreach ( $screens as $screen ) {
					add_meta_box('sidebar_metabox', __( 'Sidebar', 'whitelabel' ), array($this, 'meta_box_callback'), $screen, 'side');
				}

		}

		public function meta_box_callback( $post ) {

			wp_nonce_field( 'sidebar_meta_box', 'sidebar_meta_box_nonce' );

			$default_sidebar = get_post_meta( $post->ID, $this->_prefix . '_dynamic_sidebar', true );

			global $wp_registered_sidebars;

			echo '<p><strong><label>'.__('Choose Sidebar:','whitelabel').'</label></strong></p>';
			echo '<select name="sidebar" id="sidebar">';
			echo '<option>'.__('Choose Sidebar','whitelabel').'</option>';
			foreach ( $wp_registered_sidebars as $value ) {
				echo '<option value="'.$value['id'].'" '.selected($default_sidebar, $value['id']).'>'.$value['name'].'</option>';
			}
			echo '</select>';
			echo '<p>'.__('Choose a custom sidebar for this page','whitelabel').'</p>';
		}

		public function save_meta_box_data( $post_id ) {

			if ( ! isset( $_POST['sidebar_meta_box_nonce'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST['sidebar_meta_box_nonce'], 'sidebar_meta_box' ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}

			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			if ( ! isset( $_POST['sidebar'] ) ) {
				return;
			}

			$data = sanitize_text_field( $_POST['sidebar'] );
			update_post_meta( $post_id, $this->_prefix . '_dynamic_sidebar', $data );
		}
	}

	$sidebars = new WhitelabelSidebars();

}
?>
