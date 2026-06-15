<?php

/**
 * REST API endpoint for comprehensive WordPress site diagnostics.
 * Intended for AI-assisted support debugging.
 *
 * GET /wp-json/curly-extension/v1/diagnostic
 */
class Curly_Extension_Site_Diagnostic {

	const API_NAMESPACE = 'curly-extension/v1';
	const API_ROUTE     = '/diagnostic';

	/** @var self|null */
	private static $instance = null;

	public function __construct() {
		self::$instance = $this;
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * @return self
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function register_routes() {
		register_rest_route(
			self::API_NAMESPACE,
			self::API_ROUTE,
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_diagnostic' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function get_diagnostic( WP_REST_Request $request ) {
		return new WP_REST_Response( $this->get_report(), 200 );
	}

	/**
	 * Full diagnostic payload (used by REST endpoint and remote support ingest).
	 *
	 * @return array
	 */
	public function get_report() {
		$data = array(
			'meta'        => $this->get_meta(),
			'summary'     => '',
			'wordpress'   => $this->get_wordpress_info(),
			'theme'       => $this->get_theme_info(),
			'plugins'     => $this->get_plugins_info(),
			'content'     => $this->get_content_counts(),
			'media'       => $this->get_media_info(),
			'users'       => $this->get_users_info(),
			'server'      => $this->get_server_info(),
			'php'         => $this->get_php_info(),
			'database'    => $this->get_database_info(),
			'hosting'     => $this->get_hosting_info(),
			'filesystem'  => $this->get_filesystem_info(),
			'cron'        => $this->get_cron_info(),
			'urls'        => $this->get_urls_info(),
			'cache'       => $this->get_cache_info(),
			'security'    => $this->get_security_info(),
			'issues'      => array(),
			'environment' => $this->get_environment_constants(),
		);

		$data['issues']  = $this->detect_issues( $data );
		$data['summary'] = $this->build_summary( $data );

		return $data;
	}

	private function get_meta() {
		return array(
			'generated_at'     => gmdate( 'c' ),
			'endpoint'         => rest_url( self::API_NAMESPACE . self::API_ROUTE ),
			'diagnostic_version' => '1.0.0',
			'plugin'           => array(
				'name'    => 'Curly Themes Extension',
				'version' => $this->get_curly_extension_version(),
			),
			'description'      => 'Diagnostic complet al site-ului WordPress pentru debugging și suport tehnic. Fiecare secțiune conține date structurate; câmpul summary oferă o descriere în limbaj natural pentru analiză AI.',
		);
	}

	private function get_curly_extension_version() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$data = get_plugin_data( CURLY_EXTENSION_PATH . 'curly-extension.php', false, false );
		return isset( $data['Version'] ) ? $data['Version'] : 'unknown';
	}

	private function get_wordpress_info() {
		global $wp_version;

		if ( ! function_exists( 'get_core_updates' ) ) {
			require_once ABSPATH . 'wp-admin/includes/update.php';
		}

		$updates = get_core_updates();
		$update  = ! empty( $updates ) && ! is_wp_error( $updates ) ? $updates[0] : null;

		return array(
			'description' => 'Informații despre instalarea WordPress: versiune, limbă, fus orar, setări de debug și permalink.',
			'version'     => $wp_version,
			'update_available' => $update && isset( $update->response ) && 'upgrade' === $update->response,
			'latest_version'   => $update && isset( $update->version ) ? $update->version : null,
			'is_multisite'     => is_multisite(),
			'blog_id'          => get_current_blog_id(),
			'locale'           => get_locale(),
			'timezone'         => wp_timezone_string(),
			'gmt_offset'       => (float) get_option( 'gmt_offset' ),
			'date_format'      => get_option( 'date_format' ),
			'time_format'      => get_option( 'time_format' ),
			'permalink_structure' => get_option( 'permalink_structure' ),
			'users_can_register'  => (bool) get_option( 'users_can_register' ),
			'default_role'        => get_option( 'default_role' ),
			'wp_debug'            => defined( 'WP_DEBUG' ) && WP_DEBUG,
			'wp_debug_log'        => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG,
			'wp_debug_display'    => defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY,
			'script_debug'        => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
			'wp_memory_limit'     => defined( 'WP_MEMORY_LIMIT' ) ? WP_MEMORY_LIMIT : null,
			'wp_max_memory_limit' => defined( 'WP_MAX_MEMORY_LIMIT' ) ? WP_MAX_MEMORY_LIMIT : null,
			'automatic_updater_disabled' => defined( 'AUTOMATIC_UPDATER_DISABLED' ) && AUTOMATIC_UPDATER_DISABLED,
			'file_mod_allowed'    => function_exists( 'wp_is_file_mod_allowed' ) ? wp_is_file_mod_allowed( 'all' ) : null,
			'auto_update_core'    => get_site_option( 'auto_update_core_major' ),
		);
	}

	private function get_theme_info() {
		$theme      = wp_get_theme();
		$parent     = $theme->parent();
		$stylesheet = get_stylesheet();

		return array(
			'description' => 'Tema activă și tema părinte (dacă există), cu versiune și autor.',
			'active'      => array(
				'name'        => $theme->get( 'Name' ),
				'version'     => $theme->get( 'Version' ),
				'stylesheet'  => $stylesheet,
				'template'    => get_template(),
				'author'      => $theme->get( 'Author' ),
				'author_uri'  => $theme->get( 'AuthorURI' ),
				'theme_uri'   => $theme->get( 'ThemeURI' ),
				'is_child'    => (bool) $parent,
				'text_domain' => $theme->get( 'TextDomain' ),
			),
			'parent'      => $parent ? array(
				'name'       => $parent->get( 'Name' ),
				'version'    => $parent->get( 'Version' ),
				'stylesheet' => $parent->get_stylesheet(),
			) : null,
			'curly_extension_theme_prefix' => defined( 'THEMEPREFIX' ) ? THEMEPREFIX : null,
		);
	}

	private function get_plugins_info() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$all_plugins    = get_plugins();
		$active_plugins = (array) get_option( 'active_plugins', array() );
		$mu_plugins     = get_mu_plugins();
		$dropins          = get_dropins();

		$plugins = array();
		foreach ( $all_plugins as $file => $plugin ) {
			$plugins[] = array(
				'name'    => $plugin['Name'],
				'version' => $plugin['Version'],
				'file'    => $file,
				'author'  => $plugin['Author'],
				'active'  => in_array( $file, $active_plugins, true ),
				'network' => is_plugin_active_for_network( $file ),
			);
		}

		usort( $plugins, function ( $a, $b ) {
			return strcasecmp( $a['name'], $b['name'] );
		} );

		$mu_list = array();
		foreach ( $mu_plugins as $file => $plugin ) {
			$mu_list[] = array(
				'name'    => $plugin['Name'],
				'version' => isset( $plugin['Version'] ) ? $plugin['Version'] : 'unknown',
				'file'    => $file,
			);
		}

		$dropin_list = array();
		foreach ( $dropins as $file => $plugin ) {
			$dropin_list[] = array(
				'name' => $plugin['Name'],
				'file' => $file,
			);
		}

		return array(
			'description'    => 'Lista pluginurilor instalate (active/inactive), must-use plugins și drop-ins.',
			'total'          => count( $plugins ),
			'active_count'   => count( array_filter( $plugins, function ( $p ) { return $p['active']; } ) ),
			'inactive_count' => count( array_filter( $plugins, function ( $p ) { return ! $p['active']; } ) ),
			'plugins'        => $plugins,
			'must_use'       => $mu_list,
			'dropins'        => $dropin_list,
		);
	}

	private function get_content_counts() {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$counts     = array();

		foreach ( $post_types as $type => $object ) {
			$stat = wp_count_posts( $type );
			$counts[ $type ] = array(
				'label'       => $object->labels->name,
				'publish'     => (int) $stat->publish,
				'draft'       => (int) $stat->draft,
				'pending'     => (int) $stat->pending,
				'private'     => (int) $stat->private,
				'trash'       => (int) $stat->trash,
				'future'      => (int) $stat->future,
				'total'       => array_sum( (array) $stat ),
			);
		}

		$comments = wp_count_comments();

		return array(
			'description' => 'Număr de conținuturi pe tip de post (pagini, articole, CPT-uri publice) și comentarii.',
			'post_types'  => $counts,
			'comments'    => array(
				'approved'  => (int) $comments->approved,
				'pending'   => (int) $comments->moderated,
				'spam'      => (int) $comments->spam,
				'trash'     => (int) $comments->trash,
				'total'     => (int) $comments->total_comments,
			),
			'menus'       => count( wp_get_nav_menus() ),
			'sidebars'    => count( $GLOBALS['wp_registered_sidebars'] ?? array() ),
			'taxonomies'  => $this->get_taxonomy_counts(),
		);
	}

	private function get_taxonomy_counts() {
		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
		$result     = array();

		foreach ( $taxonomies as $tax => $object ) {
			$terms = wp_count_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
			$result[ $tax ] = array(
				'label' => $object->labels->name,
				'count' => is_wp_error( $terms ) ? 0 : (int) $terms,
			);
		}

		return $result;
	}

	private function get_media_info() {
		global $wpdb;

		$attachment_stat = wp_count_posts( 'attachment' );

		$size_query = $wpdb->get_row(
			"SELECT COUNT(*) AS file_count,
				COALESCE(SUM(CAST(meta_value AS UNSIGNED)), 0) AS total_bytes
			FROM {$wpdb->postmeta}
			WHERE meta_key = '_wp_attached_file'
			AND post_id IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_status != 'trash')"
		);

		$upload_dir = wp_upload_dir();

		$mime_counts = $wpdb->get_results(
			"SELECT post_mime_type, COUNT(*) AS count
			FROM {$wpdb->posts}
			WHERE post_type = 'attachment' AND post_status != 'trash'
			GROUP BY post_mime_type
			ORDER BY count DESC
			LIMIT 20",
			ARRAY_A
		);

		return array(
			'description'      => 'Statistici media: număr imagini/fișiere, dimensiune totală estimată, tipuri MIME.',
			'total_attachments' => (int) $attachment_stat->inherit + (int) $attachment_stat->publish,
			'in_trash'          => (int) $attachment_stat->trash,
			'upload_dir'        => array(
				'path'    => $upload_dir['basedir'],
				'url'     => $upload_dir['baseurl'],
				'writable' => wp_is_writable( $upload_dir['basedir'] ),
				'error'   => $upload_dir['error'] ?: null,
			),
			'estimated_size_bytes' => $size_query ? (int) $size_query->total_bytes : 0,
			'estimated_size_human' => size_format( $size_query ? (int) $size_query->total_bytes : 0 ),
			'mime_types'        => $mime_counts ?: array(),
			'max_upload_size'   => size_format( wp_max_upload_size() ),
			'max_upload_bytes'  => wp_max_upload_size(),
		);
	}

	private function get_users_info() {
		$user_count = count_users();

		return array(
			'description' => 'Utilizatori înregistrați pe rol.',
			'total'       => (int) $user_count['total_users'],
			'by_role'     => $user_count['avail_roles'],
		);
	}

	private function get_server_info() {
		return array(
			'description'    => 'Informații server web și sistem de operare.',
			'software'       => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : null,
			'hostname'       => isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : null,
			'server_name'    => isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : null,
			'server_addr'    => isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : null,
			'document_root'  => isset( $_SERVER['DOCUMENT_ROOT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) : null,
			'https'          => is_ssl(),
			'remote_addr'    => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : null,
			'user_agent'     => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : null,
		);
	}

	private function get_php_info() {
		$ini_keys = array(
			'memory_limit',
			'max_execution_time',
			'max_input_time',
			'max_input_vars',
			'upload_max_filesize',
			'post_max_size',
			'display_errors',
			'log_errors',
			'error_reporting',
			'allow_url_fopen',
			'allow_url_include',
			'disable_functions',
			'disable_classes',
			'open_basedir',
			'safe_mode',
			'max_file_uploads',
			'default_socket_timeout',
			'opcache.enable',
			'zlib.output_compression',
		);

		$ini = array();
		foreach ( $ini_keys as $key ) {
			$value = ini_get( $key );
			$ini[ $key ] = ( false === $value || '' === $value ) ? null : $value;
		}

		$extensions = get_loaded_extensions();
		sort( $extensions );

		$critical_extensions = array( 'curl', 'gd', 'imagick', 'mbstring', 'mysqli', 'json', 'zip', 'intl', 'exif', 'fileinfo', 'openssl', 'dom', 'xml' );
		$ext_status = array();
		foreach ( $critical_extensions as $ext ) {
			$ext_status[ $ext ] = extension_loaded( $ext );
		}

		return array(
			'description'          => 'Configurație PHP: versiune, limite, extensii critice, funcții dezactivate.',
			'version'              => PHP_VERSION,
			'version_id'           => PHP_VERSION_ID,
			'sapi'                 => PHP_SAPI,
			'os'                   => PHP_OS,
			'uname'                => function_exists( 'php_uname' ) ? php_uname() : null,
			'ini'                  => $ini,
			'extensions_loaded'    => count( $extensions ),
			'critical_extensions'  => $ext_status,
			'disabled_functions'   => $this->parse_ini_list( $ini['disable_functions'] ),
			'open_basedir_paths'   => $this->parse_ini_list( $ini['open_basedir'] ),
		);
	}

	private function parse_ini_list( $value ) {
		if ( empty( $value ) ) {
			return array();
		}
		return array_values( array_filter( array_map( 'trim', explode( ',', $value ) ) ) );
	}

	private function get_database_info() {
		global $wpdb;

		$version = $wpdb->get_var( 'SELECT VERSION()' );
		$charset = $wpdb->get_var( 'SELECT @@character_set_database' );
		$collation = $wpdb->get_var( 'SELECT @@collation_database' );

		$tables = $wpdb->get_results(
			$wpdb->prepare(
				'SHOW TABLE STATUS LIKE %s',
				$wpdb->esc_like( $wpdb->prefix ) . '%'
			),
			ARRAY_A
		);

		$total_size = 0;
		$table_count = 0;
		if ( $tables ) {
			foreach ( $tables as $table ) {
				$total_size += (int) ( $table['Data_length'] ?? 0 ) + (int) ( $table['Index_length'] ?? 0 );
				$table_count++;
			}
		}

		return array(
			'description'   => 'Bază de date MySQL/MariaDB: versiune, charset, număr tabele, dimensiune estimată.',
			'version'     => $version,
			'charset'     => $charset,
			'collation'   => $collation,
			'prefix'      => $wpdb->prefix,
			'table_count' => $table_count,
			'size_bytes'  => $total_size,
			'size_human'  => size_format( $total_size ),
			'db_name'     => DB_NAME,
			'db_host'     => DB_HOST,
			'db_charset'  => defined( 'DB_CHARSET' ) ? DB_CHARSET : null,
			'db_collate'  => defined( 'DB_COLLATE' ) ? DB_COLLATE : null,
		);
	}

	private function get_hosting_info() {
		$signals = array();
		$detected = 'unknown';

		$checks = array(
			'kinsta'     => array( 'KINSTAMU_VERSION', 'KINSTA_CACHE_ZONE' ),
			'wp_engine'  => array( 'WPE_APIKEY', 'PWP_NAME' ),
			'cloudways'  => array( 'CLOUDWAYS_PLATFORM' ),
			'siteground' => array( 'SiteGround_Optimizer\Options\Options' ),
			'pantheon'   => array( 'PANTHEON_ENVIRONMENT' ),
			'flywheel'   => array( 'FLYWHEEL_CONFIG_DIR' ),
			'local_wp'   => array( 'WP_LOCAL_DEV', 'LOCAL_WP_ENV' ),
			'docker'     => array(),
			'aws'        => array(),
		);

		if ( defined( 'KINSTAMU_VERSION' ) || defined( 'KINSTA_CACHE_ZONE' ) ) {
			$detected = 'kinsta';
		} elseif ( defined( 'WPE_APIKEY' ) || defined( 'PWP_NAME' ) ) {
			$detected = 'wp_engine';
		} elseif ( defined( 'PANTHEON_ENVIRONMENT' ) ) {
			$detected = 'pantheon';
			$signals['pantheon_env'] = PANTHEON_ENVIRONMENT;
		} elseif ( defined( 'FLYWHEEL_CONFIG_DIR' ) ) {
			$detected = 'flywheel';
		} elseif ( defined( 'WP_LOCAL_DEV' ) || defined( 'LOCAL_WP_ENV' ) ) {
			$detected = 'local_wp';
		} elseif ( file_exists( '/.dockerenv' ) ) {
			$detected = 'docker';
		} elseif ( isset( $_SERVER['SERVER_SOFTWARE'] ) && false !== stripos( $_SERVER['SERVER_SOFTWARE'], 'nginx' ) ) {
			$signals['likely_stack'] = 'nginx';
		}

		if ( function_exists( 'apache_get_modules' ) ) {
			$signals['apache_modules'] = apache_get_modules();
		}

		if ( defined( 'PANTHEON_ENVIRONMENT' ) ) {
			$signals['pantheon_environment'] = PANTHEON_ENVIRONMENT;
		}

		return array(
			'description' => 'Detectare hosting pe baza constantelor, fișierelor și variabilelor server. Poate fi imprecisă.',
			'detected'    => $detected,
			'signals'     => $signals,
			'is_local'    => in_array( $detected, array( 'local_wp', 'docker' ), true ) || ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'local' === WP_ENVIRONMENT_TYPE ),
			'environment_type' => defined( 'WP_ENVIRONMENT_TYPE' ) ? WP_ENVIRONMENT_TYPE : null,
		);
	}

	private function get_filesystem_info() {
		if ( ! function_exists( 'get_filesystem_method' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$paths = array(
			'ABSPATH'       => ABSPATH,
			'WP_CONTENT_DIR' => WP_CONTENT_DIR,
			'uploads'       => wp_upload_dir()['basedir'],
			'plugins'       => WP_PLUGIN_DIR,
			'themes'        => get_theme_root(),
		);

		$writable = array();
		foreach ( $paths as $key => $path ) {
			$writable[ $key ] = array(
				'path'      => $path,
				'exists'    => file_exists( $path ),
				'readable'  => is_readable( $path ),
				'writable'  => wp_is_writable( $path ),
			);
		}

		$fs_method = get_filesystem_method();

		return array(
			'description' => 'Permisiuni filesystem: directoare critice și metoda de scriere WordPress.',
			'paths'       => $writable,
			'fs_method'   => $fs_method,
			'fs_direct'   => ( 'direct' === $fs_method ),
		);
	}

	private function get_cron_info() {
		$cron_array = _get_cron_array();
		$event_count = is_array( $cron_array ) ? count( $cron_array, COUNT_RECURSIVE ) : 0;

		$next_scheduled = wp_next_scheduled( 'wp_version_check' );

		return array(
			'description' => 'Cron WordPress: dacă e dezactivat, evenimente programate.',
			'disabled'    => defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON,
			'alternate'   => defined( 'ALTERNATE_WP_CRON' ) && ALTERNATE_WP_CRON,
			'event_slots' => is_array( $cron_array ) ? count( $cron_array ) : 0,
			'next_core_check' => $next_scheduled ? gmdate( 'c', $next_scheduled ) : null,
		);
	}

	private function get_urls_info() {
		return array(
			'description' => 'URL-uri site: home, siteurl, admin, REST API.',
			'home'        => home_url(),
			'siteurl'     => site_url(),
			'admin_url'   => admin_url(),
			'rest_url'    => rest_url(),
			'is_ssl'      => is_ssl(),
			'home_siteurl_match' => untrailingslashit( home_url() ) === untrailingslashit( site_url() ),
		);
	}

	private function get_cache_info() {
		return array(
			'description' => 'Cache object și page cache detectabil.',
			'object_cache' => wp_using_ext_object_cache(),
			'advanced_cache_dropin' => file_exists( WP_CONTENT_DIR . '/advanced-cache.php' ),
			'object_cache_dropin'   => file_exists( WP_CONTENT_DIR . '/object-cache.php' ),
			'page_cache_plugins'    => $this->detect_cache_plugins(),
		);
	}

	private function detect_cache_plugins() {
		$cache_plugins = array();
		$known = array(
			'wp-super-cache/wp-cache.php'           => 'WP Super Cache',
			'w3-total-cache/w3-total-cache.php'   => 'W3 Total Cache',
			'wp-rocket/wp-rocket.php'               => 'WP Rocket',
			'litespeed-cache/litespeed-cache.php'   => 'LiteSpeed Cache',
			'sg-cachepress/sg-cachepress.php'       => 'SiteGround Optimizer',
			'redis-cache/redis-cache.php'           => 'Redis Object Cache',
			'wp-fastest-cache/wpFastestCache.php'   => 'WP Fastest Cache',
		);

		foreach ( $known as $file => $name ) {
			if ( is_plugin_active( $file ) ) {
				$cache_plugins[] = $name;
			}
		}

		return $cache_plugins;
	}

	private function get_security_info() {
		return array(
			'description' => 'Setări securitate și expunere.',
			'force_ssl_admin' => defined( 'FORCE_SSL_ADMIN' ) && FORCE_SSL_ADMIN,
			'disallow_file_edit' => defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT,
			'disallow_file_mods' => defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS,
			'xmlrpc_enabled' => apply_filters( 'xmlrpc_enabled', true ),
			'rest_api_available' => true,
		);
	}

	private function get_environment_constants() {
		$constants = array(
			'WP_ENV',
			'WP_ENVIRONMENT_TYPE',
			'WP_CACHE',
			'COMPRESS_CSS',
			'COMPRESS_SCRIPTS',
			'CONCATENATE_SCRIPTS',
			'ENFORCE_GZIP',
			'COOKIE_DOMAIN',
			'COOKIEHASH',
			'MULTISITE',
			'SUBDOMAIN_INSTALL',
			'DOMAIN_CURRENT_SITE',
		);

		$values = array();
		foreach ( $constants as $const ) {
			if ( defined( $const ) ) {
				$val = constant( $const );
				$values[ $const ] = is_bool( $val ) ? $val : (string) $val;
			}
		}

		return array(
			'description' => 'Constante WordPress relevante definite în wp-config.',
			'defined'     => $values,
		);
	}

	private function detect_issues( $data ) {
		$issues = array();

		if ( $data['wordpress']['wp_debug'] ) {
			$issues[] = array(
				'severity' => 'info',
				'code'     => 'WP_DEBUG_ENABLED',
				'message'  => 'WP_DEBUG este activ. Util pentru debugging, dar nu recomandat în producție.',
			);
		}

		if ( ! $data['filesystem']['fs_direct'] ) {
			$issues[] = array(
				'severity' => 'warning',
				'code'     => 'FS_NOT_DIRECT',
				'message'  => 'WordPress nu folosește scriere directă pe filesystem (fs_method: ' . $data['filesystem']['fs_method'] . '). Actualizările automate pot eșua.',
			);
		}

		if ( ! $data['media']['upload_dir']['writable'] ) {
			$issues[] = array(
				'severity' => 'error',
				'code'     => 'UPLOADS_NOT_WRITABLE',
				'message'  => 'Directorul uploads nu este writable. Upload-urile de media vor eșua.',
			);
		}

		$memory = $this->parse_size( $data['php']['ini']['memory_limit'] ?? '128M' );
		if ( $memory < 128 * 1024 * 1024 ) {
			$issues[] = array(
				'severity' => 'warning',
				'code'     => 'LOW_PHP_MEMORY',
				'message'  => 'memory_limit PHP este sub 128M (' . ( $data['php']['ini']['memory_limit'] ?? 'unknown' ) . ').',
			);
		}

		$max_vars = (int) ( $data['php']['ini']['max_input_vars'] ?? 1000 );
		if ( $max_vars > 0 && $max_vars < 3000 ) {
			$issues[] = array(
				'severity' => 'warning',
				'code'     => 'LOW_MAX_INPUT_VARS',
				'message'  => 'max_input_vars este ' . $max_vars . '. Paginile cu multe câmpuri (menus, page builders) pot pierde date la salvare.',
			);
		}

		if ( $data['cron']['disabled'] ) {
			$issues[] = array(
				'severity' => 'info',
				'code'     => 'WP_CRON_DISABLED',
				'message'  => 'WP-Cron este dezactivat (DISABLE_WP_CRON). Verifică dacă există cron de sistem configurat.',
			);
		}

		if ( $data['wordpress']['update_available'] ) {
			$issues[] = array(
				'severity' => 'warning',
				'code'     => 'CORE_UPDATE_AVAILABLE',
				'message'  => 'Actualizare WordPress disponibilă: ' . $data['wordpress']['latest_version'],
			);
		}

		foreach ( $data['php']['critical_extensions'] as $ext => $loaded ) {
			if ( ! $loaded && in_array( $ext, array( 'curl', 'mbstring', 'json', 'mysqli' ), true ) ) {
				$issues[] = array(
					'severity' => 'error',
					'code'     => 'MISSING_PHP_EXTENSION',
					'message'  => 'Extensia PHP lipsă: ' . $ext,
				);
			}
		}

		if ( untrailingslashit( $data['urls']['home'] ) !== untrailingslashit( $data['urls']['siteurl'] ) ) {
			$issues[] = array(
				'severity' => 'warning',
				'code'     => 'HOME_SITEURL_MISMATCH',
				'message'  => 'home_url și site_url diferă. Poate cauza probleme de redirect sau resurse mixte.',
			);
		}

		return $issues;
	}

	private function parse_size( $size ) {
		$size = trim( (string) $size );
		if ( '' === $size || '-1' === $size ) {
			return PHP_INT_MAX;
		}
		$unit = strtolower( substr( $size, -1 ) );
		$value = (float) $size;
		switch ( $unit ) {
			case 'g':
				$value *= 1024;
				// no break
			case 'm':
				$value *= 1024;
				// no break
			case 'k':
				$value *= 1024;
		}
		return (int) $value;
	}

	private function build_summary( $data ) {
		$wp     = $data['wordpress'];
		$theme  = $data['theme']['active'];
		$plugins = $data['plugins'];
		$content = $data['content']['post_types'];
		$media  = $data['media'];
		$php    = $data['php'];
		$db     = $data['database'];
		$host   = $data['hosting'];
		$issues = $data['issues'];

		$pages   = isset( $content['page'] ) ? $content['page']['publish'] : 0;
		$posts   = isset( $content['post'] ) ? $content['post']['publish'] : 0;

		$active_plugin_names = array();
		foreach ( $plugins['plugins'] as $p ) {
			if ( $p['active'] ) {
				$active_plugin_names[] = $p['name'] . ' v' . $p['version'];
			}
		}

		$issue_summary = array();
		foreach ( $issues as $issue ) {
			$issue_summary[] = '[' . strtoupper( $issue['severity'] ) . '] ' . $issue['message'];
		}

		$lines = array(
			'Site WordPress ' . $wp['version'] . ( $wp['is_multisite'] ? ' (multisite)' : '' ) . ' la ' . $data['urls']['home'] . '.',
			'Temă activă: ' . $theme['name'] . ' v' . $theme['version'] . ( $theme['is_child'] ? ' (child theme)' : '' ) . '.',
			'Conținut: ' . $pages . ' pagini publicate, ' . $posts . ' articole publicate, ' . $media['total_attachments'] . ' fișiere media (' . $media['estimated_size_human'] . ' estimat).',
			'Pluginuri: ' . $plugins['active_count'] . ' active din ' . $plugins['total'] . ' instalate.',
			'Active: ' . implode( '; ', array_slice( $active_plugin_names, 0, 15 ) ) . ( count( $active_plugin_names ) > 15 ? '... (+' . ( count( $active_plugin_names ) - 15 ) . ')' : '' ) . '.',
			'Server: PHP ' . $php['version'] . ' (' . $php['sapi'] . '), ' . ( $data['server']['software'] ?: 'server necunoscut' ) . '.',
			'Hosting detectat: ' . $host['detected'] . ( $host['environment_type'] ? ' (env: ' . $host['environment_type'] . ')' : '' ) . '.',
			'Bază de date: ' . $db['version'] . ', ' . $db['table_count'] . ' tabele, ' . $db['size_human'] . '.',
			'PHP memory_limit=' . ( $php['ini']['memory_limit'] ?? '?' ) . ', max_execution_time=' . ( $php['ini']['max_execution_time'] ?? '?' ) . 's, upload_max=' . ( $php['ini']['upload_max_filesize'] ?? '?' ) . ', post_max=' . ( $php['ini']['post_max_size'] ?? '?' ) . '.',
			'Upload max WordPress: ' . $media['max_upload_size'] . '.',
			'Debug: WP_DEBUG=' . ( $wp['wp_debug'] ? 'ON' : 'OFF' ) . ', WP_DEBUG_LOG=' . ( $wp['wp_debug_log'] ? 'ON' : 'OFF' ) . '.',
			'SSL: ' . ( $data['urls']['is_ssl'] ? 'da' : 'nu' ) . '.',
		);

		if ( ! empty( $issue_summary ) ) {
			$lines[] = 'Probleme detectate: ' . implode( ' | ', $issue_summary );
		} else {
			$lines[] = 'Nu s-au detectat probleme critice automat.';
		}

		return implode( "\n", $lines );
	}
}

new Curly_Extension_Site_Diagnostic();
