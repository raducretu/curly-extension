<?php

/**
 * Secure remote diagnostics for CurlyThemes support.
 *
 * POST /wp-json/curly-support/v1/request-diagnostics
 *
 * Security: HMAC request validation, nonce replay protection, rate limiting.
 * Never returns the diagnostic report in the REST response.
 */
class Curly_Extension_Support_Diagnostics {

	const REST_NAMESPACE     = 'curly-support/v1';
	const REST_ROUTE         = '/request-diagnostics';
	const CUSTOM_ROUTE       = 'curly-support/v1/request-diagnostics';
	const QUERY_VAR          = 'curly_support_diagnostics';
	const INGEST_URL         = 'https://services.curlythemes.com/api/diagnostics/ingest';
	const USER_AGENT         = 'CurlyThemesWordPressDiagnostics/1.0';
	const TIMESTAMP_WINDOW   = 300;
	const NONCE_TTL          = 600;
	const RATE_LIMIT_TTL     = 10;
	const MAX_REPORT_BYTES   = 2097152;
	const DEBUG_LOG_LINES    = 50;

	const OPTION_DISABLED           = 'curly_extension_support_diagnostics_disabled';
	const OPTION_LAST_REQUESTED_AT  = 'curly_extension_support_last_diagnostic_requested_at';
	const OPTION_LAST_SENT_AT       = 'curly_extension_support_last_diagnostic_sent_at';
	const OPTION_LAST_STATUS        = 'curly_extension_support_last_diagnostic_status';
	const OPTION_LAST_ERROR         = 'curly_extension_support_last_diagnostic_error';
	const OPTION_LAST_DEBUG         = 'curly_extension_support_last_diagnostic_debug';

	const TRANSIENT_RATE_LIMIT = 'curly_support_diagnostic_rate_limit';
	const TRANSIENT_NONCE      = 'curly_support_nonce_';

	/** @var self|null */
	private static $instance = null;

	/** @var string */
	private $request_channel = 'rest';

	public function __construct() {
		self::$instance = $this;

		add_action( 'init', array( $this, 'register_custom_endpoint' ), 0 );
		add_action( 'init', array( $this, 'maybe_handle_custom_endpoint' ), 1 );
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_action( 'admin_init', array( $this, 'handle_admin_actions' ) );
	}

	/**
	 * Flush rewrite rules after plugin activation.
	 */
	public static function activate() {
		$instance = self::instance();
		if ( $instance ) {
			$instance->register_custom_endpoint();
		}
		flush_rewrite_rules();
	}

	/**
	 * @return self
	 */
	public static function instance() {
		return self::$instance;
	}

	public function register_rest_routes() {
		register_rest_route(
			self::REST_NAMESPACE,
			self::REST_ROUTE,
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'handle_rest_request' ),
				'permission_callback' => array( $this, 'rest_permission_check' ),
			)
		);
	}

	/**
	 * Pretty URL fallback when REST API is disabled or blocked.
	 */
	public function register_custom_endpoint() {
		add_rewrite_tag( '%' . self::QUERY_VAR . '%', '([0-1])' );
		add_rewrite_rule(
			'^' . self::CUSTOM_ROUTE . '/?$',
			'index.php?' . self::QUERY_VAR . '=1',
			'top'
		);
	}

	/**
	 * Front-end POST endpoint — same auth as REST, no wp-json required.
	 */
	public function maybe_handle_custom_endpoint() {
		if ( ! $this->is_custom_endpoint_request() ) {
			return;
		}

		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
			$this->emit_json_response(
				new WP_REST_Response(
					array(
						'success' => false,
						'message' => 'Method not allowed',
					),
					405
				)
			);
		}

		$this->request_channel = 'custom';
		$request               = $this->create_request_from_server_headers();
		$response              = $this->handle_request( $request );
		$this->emit_json_response( $response );
	}

	/**
	 * @return string
	 */
	public function get_custom_endpoint_url() {
		return home_url( '/' . self::CUSTOM_ROUTE );
	}

	/**
	 * @return string
	 */
	public function get_custom_query_endpoint_url() {
		return home_url( '/?' . self::QUERY_VAR . '=1' );
	}

	/**
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function handle_rest_request( WP_REST_Request $request ) {
		$this->request_channel = 'rest';
		return $this->handle_request( $request );
	}

	/**
	 * External callers are validated via HMAC inside the callback, not WP auth.
	 *
	 * @return bool
	 */
	public function rest_permission_check() {
		return true;
	}

	/**
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function handle_request( WP_REST_Request $request ) {
		update_option( self::OPTION_LAST_REQUESTED_AT, gmdate( 'c' ), false );

		$this->log_request_event(
			'incoming',
			array(
				'channel' => $this->request_channel,
				'headers' => $this->get_request_header_snapshot( $request ),
			)
		);

		if ( $this->is_disabled() ) {
			$this->log_failure( 'disabled', array( 'reason' => 'Remote diagnostics disabled in admin' ) );
			return $this->error_response();
		}

		$validation = $this->validate_request( $request );
		if ( is_wp_error( $validation ) ) {
			$this->log_failure(
				$validation->get_error_code(),
				(array) $validation->get_error_data()
			);
			return $this->error_response();
		}

		$domain       = $validation['domain'];
		$product_slug = $validation['product_slug'];
		$nonce        = $validation['nonce'];
		$derived      = $validation['derived_secret'];

		set_transient( self::TRANSIENT_NONCE . $this->nonce_storage_key( $nonce ), 1, self::NONCE_TTL );

		$report = $this->generate_report();
		$report = $this->sanitize_report( $report );

		$sent = $this->send_report( $report, $domain, $product_slug, $derived );
		if ( is_wp_error( $sent ) ) {
			$this->log_failure(
				$sent->get_error_code(),
				(array) $sent->get_error_data()
			);
			return $this->error_response();
		}

		set_transient( self::TRANSIENT_RATE_LIMIT, time(), self::RATE_LIMIT_TTL );

		$this->log_request_event( 'success', array( 'message' => 'Diagnostics sent to ingest' ) );

		update_option( self::OPTION_LAST_SENT_AT, gmdate( 'c' ), false );
		update_option( self::OPTION_LAST_STATUS, 'sent', false );
		update_option( self::OPTION_LAST_ERROR, '', false );
		update_option( self::OPTION_LAST_DEBUG, '', false );

		return new WP_REST_Response(
			array(
				'success' => true,
				'message' => 'Diagnostics queued',
			),
			200
		);
	}

	/**
	 * @param WP_REST_Request $request
	 * @return array|WP_Error
	 */
	public function validate_request( WP_REST_Request $request ) {
		$domain       = trim( (string) $request->get_header( 'x_curly_domain' ) );
		$product_slug = trim( (string) $request->get_header( 'x_curly_product' ) );
		$timestamp    = trim( (string) $request->get_header( 'x_curly_timestamp' ) );
		$nonce        = trim( (string) $request->get_header( 'x_curly_nonce' ) );
		$signature    = trim( (string) $request->get_header( 'x_curly_signature' ) );

		$missing = array();
		if ( '' === $domain ) {
			$missing[] = 'X-Curly-Domain';
		}
		if ( '' === $product_slug ) {
			$missing[] = 'X-Curly-Product';
		}
		if ( '' === $timestamp ) {
			$missing[] = 'X-Curly-Timestamp';
		}
		if ( '' === $nonce ) {
			$missing[] = 'X-Curly-Nonce';
		}
		if ( '' === $signature ) {
			$missing[] = 'X-Curly-Signature';
		}

		if ( ! empty( $missing ) ) {
			return new WP_Error(
				'curly_support_missing_headers',
				'Missing headers',
				array( 'missing_headers' => $missing )
			);
		}

		$purchase_code = $this->get_purchase_code();
		if ( '' === $purchase_code ) {
			$context = $this->get_theme_license_context();
			return new WP_Error(
				'curly_support_no_license',
				'No license',
				array(
					'expected_option' => $context['option_prefix'] ? $context['option_prefix'] . '_license_code' : 'unknown',
				)
			);
		}

		if ( '' === $this->get_shared_pepper() ) {
			return new WP_Error( 'curly_support_no_pepper', 'Pepper not configured' );
		}

		$local_domain  = $this->normalize_domain( home_url() );
		$header_domain = $this->normalize_domain( $domain );
		if ( $local_domain !== $header_domain ) {
			return new WP_Error(
				'curly_support_domain_mismatch',
				'Domain mismatch',
				array(
					'received_domain'  => $domain,
					'normalized_header'=> $header_domain,
					'expected_domain'  => $local_domain,
					'home_url'         => home_url(),
				)
			);
		}

		$local_product = $this->get_product_slug();
		$header_product = sanitize_title( $product_slug );
		if ( $local_product !== $header_product ) {
			return new WP_Error(
				'curly_support_product_mismatch',
				'Product mismatch',
				array(
					'received_product' => $product_slug,
					'expected_product' => $local_product,
				)
			);
		}

		$derived_secret = $this->derive_secret( $purchase_code, $local_domain, $local_product );

		$sign_string = $domain . '|' . $product_slug . '|' . $timestamp . '|' . $nonce;
		$expected_signature = hash_hmac( 'sha256', $sign_string, $derived_secret );

		if ( ! hash_equals( $expected_signature, strtolower( $signature ) ) ) {
			return new WP_Error(
				'curly_support_bad_signature',
				'Invalid signature',
				array(
					'sign_string'         => $sign_string,
					'expected_signature'  => $expected_signature,
					'received_signature'  => $signature,
					'derive_uses_domain'  => $local_domain,
					'derive_uses_product'=> $local_product,
					'hint'                => 'Sign with header values exactly as sent. derived_secret uses normalized domain + theme_slug from config.',
				)
			);
		}

		if ( ! ctype_digit( $timestamp ) ) {
			return new WP_Error(
				'curly_support_bad_timestamp',
				'Invalid timestamp',
				array( 'received_timestamp' => $timestamp )
			);
		}

		$timestamp_int = (int) $timestamp;
		$now           = time();
		$drift         = abs( $now - $timestamp_int );
		if ( $drift > self::TIMESTAMP_WINDOW ) {
			return new WP_Error(
				'curly_support_expired_timestamp',
				'Expired timestamp',
				array(
					'received_timestamp' => $timestamp_int,
					'server_timestamp'   => $now,
					'drift_seconds'      => $drift,
					'max_window_seconds' => self::TIMESTAMP_WINDOW,
				)
			);
		}

		if ( get_transient( self::TRANSIENT_NONCE . $this->nonce_storage_key( $nonce ) ) ) {
			return new WP_Error(
				'curly_support_reused_nonce',
				'Reused nonce',
				array( 'nonce' => $nonce )
			);
		}

		if ( get_transient( self::TRANSIENT_RATE_LIMIT ) ) {
			return new WP_Error(
				'curly_support_rate_limited',
				'Rate limited',
				array( 'retry_after_seconds' => self::RATE_LIMIT_TTL )
			);
		}

		return array(
			'domain'          => $domain,
			'product_slug'    => $product_slug,
			'timestamp'       => $timestamp_int,
			'nonce'           => $nonce,
			'derived_secret'  => $derived_secret,
		);
	}

	/**
	 * Never expose the purchase code outside this class.
	 * Uses the active Curly theme option_prefix, e.g. jet_one_license_code.
	 *
	 * @return string
	 */
	public function get_purchase_code() {
		$context = $this->get_theme_license_context();
		if ( empty( $context['option_prefix'] ) ) {
			return '';
		}

		$prefix = $context['option_prefix'];
		$code   = trim( (string) get_option( $prefix . '_license_code', '' ) );
		if ( '' !== $code ) {
			return $code;
		}

		if ( ! empty( $context['envato_item_id'] ) ) {
			$code = trim( (string) get_option( 'envato_purchase_code_' . $context['envato_item_id'], '' ) );
			if ( '' !== $code ) {
				return $code;
			}
		}

		return '';
	}

	/**
	 * Product slug from the active Curly theme config (theme_slug).
	 *
	 * @return string
	 */
	public function get_product_slug() {
		if ( defined( 'CT_THEME_SLUG' ) && CT_THEME_SLUG ) {
			return sanitize_title( CT_THEME_SLUG );
		}

		$context = $this->get_theme_license_context();
		if ( ! empty( $context['theme_slug'] ) ) {
			return sanitize_title( $context['theme_slug'] );
		}

		return sanitize_title( get_template() );
	}

	/**
	 * License context for the active CurlyThemes theme.
	 *
	 * @return array{option_prefix: string, theme_slug: string, envato_item_id: string}
	 */
	private function get_theme_license_context() {
		$config = $this->get_theme_manager_config();

		if ( class_exists( 'CT_Theme_Manager' ) ) {
			$manager = CT_Theme_Manager::instance();
			if ( $manager ) {
				$config = wp_parse_args(
					is_array( $config ) ? $config : array(),
					array(
						'option_prefix'  => (string) $manager->get_config( 'option_prefix' ),
						'theme_slug'     => (string) $manager->get_config( 'theme_slug' ),
						'envato_item_id' => (string) $manager->get_config( 'envato_item_id' ),
					)
				);
			}
		}

		if ( ! is_array( $config ) ) {
			return array(
				'option_prefix'  => '',
				'theme_slug'     => '',
				'envato_item_id' => '',
			);
		}

		return array(
			'option_prefix'  => isset( $config['option_prefix'] ) ? (string) $config['option_prefix'] : '',
			'theme_slug'     => isset( $config['theme_slug'] ) ? (string) $config['theme_slug'] : '',
			'envato_item_id' => isset( $config['envato_item_id'] ) ? (string) $config['envato_item_id'] : '',
		);
	}

	/**
	 * @param string $url
	 * @return string
	 */
	public function normalize_domain( $url ) {
		$host = wp_parse_url( $url, PHP_URL_HOST );
		if ( ! $host ) {
			$host = $url;
		}

		$host = strtolower( trim( $host ) );
		if ( 0 === strpos( $host, 'www.' ) ) {
			$host = substr( $host, 4 );
		}

		return $host;
	}

	/**
	 * @param string $purchase_code
	 * @param string $domain
	 * @param string $product_slug
	 * @return string
	 */
	public function derive_secret( $purchase_code, $domain, $product_slug ) {
		return hash_hmac(
			'sha256',
			$purchase_code . '|' . $domain . '|' . $product_slug,
			$this->get_shared_pepper()
		);
	}

	/**
	 * Shared pepper — must match SERVER_SHARED_PEPPER on Lambda.
	 *
	 * @return string
	 */
	private function get_shared_pepper() {
		if ( defined( 'CT_SERVER_SHARED_PEPPER' ) && CT_SERVER_SHARED_PEPPER ) {
			return CT_SERVER_SHARED_PEPPER;
		}

		if ( defined( 'CURLY_SUPPORT_SHARED_PEPPER' ) && CURLY_SUPPORT_SHARED_PEPPER ) {
			return CURLY_SUPPORT_SHARED_PEPPER;
		}

		return '';
	}

	/**
	 * Deterministic JSON — must match Node ct_stable_stringify exactly.
	 *
	 * @param mixed $value
	 * @return string
	 */
	private function stable_stringify( $value ) {
		if ( null === $value ) {
			return 'null';
		}

		if ( is_bool( $value ) ) {
			return $value ? 'true' : 'false';
		}

		if ( is_int( $value ) || is_float( $value ) ) {
			return json_encode( $value, JSON_UNESCAPED_SLASHES );
		}

		if ( is_string( $value ) ) {
			return json_encode( $value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		}

		if ( is_array( $value ) ) {
			if ( array() === $value ) {
				return '[]';
			}

			if ( array_keys( $value ) === range( 0, count( $value ) - 1 ) ) {
				$parts = array();
				foreach ( $value as $item ) {
					$parts[] = $this->stable_stringify( $item );
				}
				return '[' . implode( ',', $parts ) . ']';
			}

			ksort( $value );
			$parts = array();
			foreach ( $value as $key => $item ) {
				$parts[] = json_encode( (string) $key ) . ':' . $this->stable_stringify( $item );
			}
			return '{' . implode( ',', $parts ) . '}';
		}

		return 'null';
	}

	/**
	 * @return array
	 */
	public function generate_report() {
		global $wp_version;

		$theme       = wp_get_theme();
		$parent      = $theme->parent();
		$stylesheet  = get_stylesheet();
		$template    = get_template();
		$plugins     = $this->get_plugin_snapshot();
		$filesystem  = $this->get_filesystem_snapshot();
		$full        = Curly_Extension_Site_Diagnostic::instance()->get_report();

		unset( $full['users'] );

		$report = array(
			'generated_at'          => gmdate( 'c' ),
			'site_url'              => site_url(),
			'home_url'              => home_url(),
			'domain'                => $this->normalize_domain( home_url() ),
			'wordpress_version'     => $wp_version,
			'php_version'           => PHP_VERSION,
			'mysql_version'         => $this->get_mysql_version(),
			'server_software'       => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : null,
			'memory_limit'          => ini_get( 'memory_limit' ),
			'max_execution_time'    => ini_get( 'max_execution_time' ),
			'upload_max_filesize'   => ini_get( 'upload_max_filesize' ),
			'wp_debug'              => defined( 'WP_DEBUG' ) && WP_DEBUG,
			'wp_debug_log'          => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG,
			'wp_cron_disabled'      => defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON,
			'active_theme'          => array(
				'name'       => $theme->get( 'Name' ),
				'version'    => $theme->get( 'Version' ),
				'stylesheet' => $stylesheet,
				'is_child'   => (bool) $parent,
			),
			'parent_theme'          => $parent ? array(
				'name'       => $parent->get( 'Name' ),
				'version'    => $parent->get( 'Version' ),
				'stylesheet' => $template,
			) : null,
			'child_theme'           => ( $stylesheet !== $template ) ? array(
				'name'       => $theme->get( 'Name' ),
				'version'    => $theme->get( 'Version' ),
				'stylesheet' => $stylesheet,
			) : null,
			'active_plugins'        => $plugins['active'],
			'inactive_plugins_count' => $plugins['inactive_count'],
			'woocommerce_version'   => defined( 'WC_VERSION' ) ? WC_VERSION : null,
			'elementor_version'     => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : null,
			'curly_products'        => $this->detect_curly_products(),
			'locale'                => get_locale(),
			'timezone'              => wp_timezone_string(),
			'permalink_structure'   => get_option( 'permalink_structure' ),
			'multisite'             => is_multisite(),
			'rest_api_available'    => (bool) get_rest_url(),
			'filesystem'            => $filesystem,
			'debug_log_tail'        => $this->get_debug_log_tail(),
			'theme_mods'            => $this->get_theme_mods_snapshot(),
			'customizer'            => $this->get_customizer_snapshot(),
			'full_diagnostic'       => $full,
		);

		return $report;
	}

	/**
	 * @param array $report
	 * @return array
	 */
	public function sanitize_report( $report ) {
		$report = $this->mask_sensitive_data( $report );

		if ( isset( $report['full_diagnostic'] ) ) {
			unset( $report['full_diagnostic']['users'] );
			$report['full_diagnostic'] = $this->mask_sensitive_data( $report['full_diagnostic'] );
		}

		return $report;
	}

	/**
	 * @param array  $report
	 * @param string $domain
	 * @param string $product_slug
	 * @param string $derived_secret
	 * @return true|WP_Error
	 */
	public function send_report( $report, $domain, $product_slug, $derived_secret ) {
		$timestamp     = time();
		$nonce         = $this->generate_uuid();
		$stable_report = $this->stable_stringify( $report );

		if ( strlen( $stable_report ) > self::MAX_REPORT_BYTES ) {
			$report['truncated'] = true;
			unset( $report['full_diagnostic'] );
			$stable_report = $this->stable_stringify( $report );
			if ( strlen( $stable_report ) > self::MAX_REPORT_BYTES ) {
				return new WP_Error( 'curly_support_report_too_large', 'Report too large' );
			}
		}

		// Ingest signature uses sha256(stable_stringify(report)) — must match server.
		$report_hash = hash( 'sha256', $stable_report );
		$ingest_sign = $domain . '|' . $product_slug . '|' . $timestamp . '|' . $nonce . '|' . $report_hash;
		$signature   = hash_hmac( 'sha256', $ingest_sign, $derived_secret );

		$payload = array(
			'domain'       => $domain,
			'product_slug' => $product_slug,
			'timestamp'    => $timestamp,
			'nonce'        => $nonce,
			'signature'    => $signature,
			'report'       => $report,
		);

		$response = wp_remote_post(
			self::INGEST_URL,
			array(
				'timeout' => 10,
				'headers' => array(
					'Content-Type' => 'application/json; charset=utf-8',
					'Accept'       => 'application/json',
					'User-Agent'   => self::USER_AGENT,
				),
				'body'    => wp_json_encode( $payload ),
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );
		if ( $code < 200 || $code >= 300 ) {
			$purchase_code = $this->get_purchase_code();
			return new WP_Error(
				'curly_support_ingest_http',
				'Ingest HTTP error',
				array(
					'http_code'        => $code,
					'ingest_url'       => self::INGEST_URL,
					'body_preview'     => substr( (string) $body, 0, 500 ),
					'report_hash'        => $report_hash,
					'ingest_sign_string' => $ingest_sign,
					'ingest_signature'   => $signature,
					'domain'             => $domain,
					'product_slug'       => $product_slug,
					'purchase_code_len'  => strlen( $purchase_code ),
					'pepper_len'         => strlen( $this->get_shared_pepper() ),
					'report_json_len'    => strlen( $stable_report ),
				)
			);
		}

		return true;
	}

	/**
	 * @param mixed $data
	 * @return mixed
	 */
	public function mask_sensitive_data( $data ) {
		if ( is_string( $data ) ) {
			return $this->sanitize_string( $data );
		}

		if ( ! is_array( $data ) ) {
			return $data;
		}

		$sensitive_keys = array(
			'password',
			'passwd',
			'secret',
			'token',
			'api_key',
			'apikey',
			'authorization',
			'cookie',
			'license',
			'license_key',
			'purchase_code',
			'db_name',
			'db_user',
			'db_password',
			'db_host',
			'auth_key',
			'secure_auth_key',
			'logged_in_key',
			'nonce_key',
			'auth_salt',
			'email',
			'user_email',
			'customer',
			'order',
			'billing',
			'shipping',
		);

		$masked = array();
		foreach ( $data as $key => $value ) {
			$key_lower = strtolower( (string) $key );

			if ( in_array( $key_lower, $sensitive_keys, true ) ) {
				$masked[ $key ] = '[REDACTED]';
				continue;
			}

			if ( is_string( $value ) && $this->is_sensitive_key_name( $key_lower ) ) {
				$masked[ $key ] = '[REDACTED]';
				continue;
			}

			if ( is_array( $value ) ) {
				$masked[ $key ] = $this->mask_sensitive_data( $value );
				continue;
			}

			if ( is_string( $value ) ) {
				$masked[ $key ] = $this->sanitize_string( $value );
				continue;
			}

			$masked[ $key ] = $value;
		}

		return $masked;
	}

	public function register_admin_page() {
		add_options_page(
			__( 'Curly Extension Support', 'curly-extension' ),
			__( 'Curly Extension Support', 'curly-extension' ),
			'manage_options',
			'curly-extension-support-diagnostics',
			array( $this, 'render_admin_page' )
		);
	}

	public function handle_admin_actions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( empty( $_POST['curly_extension_support_action'] ) ) {
			return;
		}

		check_admin_referer( 'curly_extension_support_diagnostics' );

		$action = sanitize_key( wp_unslash( $_POST['curly_extension_support_action'] ) );

		if ( 'disable' === $action ) {
			update_option( self::OPTION_DISABLED, '1', false );
		} elseif ( 'enable' === $action ) {
			delete_option( self::OPTION_DISABLED );
		}

		wp_safe_redirect( admin_url( 'options-general.php?page=curly-extension-support-diagnostics&updated=1' ) );
		exit;
	}

	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$disabled   = $this->is_disabled();
		$last_sent  = get_option( self::OPTION_LAST_SENT_AT, '' );
		$last_status = get_option( self::OPTION_LAST_STATUS, '' );
		$last_error = get_option( self::OPTION_LAST_ERROR, '' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Curly Extension Support Diagnostics', 'curly-extension' ); ?></h1>

			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'curly-extension' ); ?></p></div>
			<?php endif; ?>

			<p><?php esc_html_e( 'Support diagnostics: enabled automatically for licensed installations.', 'curly-extension' ); ?></p>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'REST endpoint', 'curly-extension' ); ?></th>
					<td><code><?php echo esc_html( rest_url( self::REST_NAMESPACE . self::REST_ROUTE ) ); ?></code></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Fallback endpoint', 'curly-extension' ); ?></th>
					<td>
						<code><?php echo esc_html( $this->get_custom_endpoint_url() ); ?></code>
						<p class="description"><?php esc_html_e( 'Use when REST API is blocked. Same POST headers and HMAC.', 'curly-extension' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Query fallback', 'curly-extension' ); ?></th>
					<td>
						<code><?php echo esc_html( $this->get_custom_query_endpoint_url() ); ?></code>
						<p class="description"><?php esc_html_e( 'Works without permalink rewrite flush.', 'curly-extension' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Status', 'curly-extension' ); ?></th>
					<td><?php echo $disabled ? esc_html__( 'Disabled by administrator', 'curly-extension' ) : esc_html__( 'Enabled', 'curly-extension' ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Last diagnostic sent', 'curly-extension' ); ?></th>
					<td>
						<?php
						if ( $last_sent ) {
							echo esc_html( $last_sent );
							if ( $last_status ) {
								echo ' — ' . esc_html( $last_status );
							}
						} else {
							esc_html_e( 'Never', 'curly-extension' );
						}
						?>
					</td>
				</tr>
				<?php if ( $last_error ) : ?>
				<tr>
					<th scope="row"><?php esc_html_e( 'Last error', 'curly-extension' ); ?></th>
					<td><?php echo esc_html( $last_error ); ?></td>
				</tr>
				<?php endif; ?>
			</table>

			<form method="post">
				<?php wp_nonce_field( 'curly_extension_support_diagnostics' ); ?>
				<?php if ( $disabled ) : ?>
					<input type="hidden" name="curly_extension_support_action" value="enable" />
					<?php submit_button( __( 'Enable remote diagnostics', 'curly-extension' ), 'primary' ); ?>
				<?php else : ?>
					<input type="hidden" name="curly_extension_support_action" value="disable" />
					<?php submit_button( __( 'Disable remote diagnostics', 'curly-extension' ), 'secondary' ); ?>
				<?php endif; ?>
			</form>
		</div>
		<?php
	}

	/**
	 * @return bool
	 */
	private function is_disabled() {
		return (bool) get_option( self::OPTION_DISABLED, false );
	}

	/**
	 * @param string $code
	 * @param array  $details
	 */
	private function log_failure( $code, $details = array() ) {
		$payload = array_merge(
			array(
				'at'      => gmdate( 'c' ),
				'blog_id' => get_current_blog_id(),
				'code'    => $code,
			),
			$details
		);

		update_option( self::OPTION_LAST_STATUS, 'failed', false );
		update_option( self::OPTION_LAST_ERROR, sanitize_key( $code ), false );
		update_option( self::OPTION_LAST_DEBUG, wp_json_encode( $payload ), false );
		$this->log_request_event( 'failed', $payload );
	}

	/**
	 * @param string          $event
	 * @param array           $details
	 * @param WP_REST_Request $request
	 */
	private function log_request_event( $event, $details = array() ) {
		$entry = array_merge(
			array(
				'time'    => gmdate( 'c' ),
				'event'   => $event,
				'blog_id' => get_current_blog_id(),
			),
			$details
		);

		$line = wp_json_encode( $entry ) . "\n";
		$path = WP_CONTENT_DIR . '/curly-diagnostics-watch.log';

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		@file_put_contents( $path, $line, FILE_APPEND | LOCK_EX );
	}

	/**
	 * @return bool
	 */
	private function is_custom_endpoint_request() {
		if ( isset( $_GET[ self::QUERY_VAR ] ) && '1' === (string) wp_unslash( $_GET[ self::QUERY_VAR ] ) ) {
			return true;
		}

		$query_var = get_query_var( self::QUERY_VAR );
		if ( '1' === (string) $query_var ) {
			return true;
		}

		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( ! is_string( $path ) ) {
			return false;
		}

		$path = untrailingslashit( $path );

		return (bool) preg_match( '#/' . preg_quote( self::CUSTOM_ROUTE, '#' ) . '$#', $path );
	}

	/**
	 * @return WP_REST_Request
	 */
	private function create_request_from_server_headers() {
		$request = new WP_REST_Request( 'POST', '/' . self::REST_NAMESPACE . self::REST_ROUTE );

		foreach ( $this->get_curly_headers_from_server() as $header => $value ) {
			$request->set_header( $header, $value );
		}

		return $request;
	}

	/**
	 * @return array<string, string>
	 */
	private function get_curly_headers_from_server() {
		$keys = array(
			'x_curly_domain'    => 'HTTP_X_CURLY_DOMAIN',
			'x_curly_product'   => 'HTTP_X_CURLY_PRODUCT',
			'x_curly_timestamp' => 'HTTP_X_CURLY_TIMESTAMP',
			'x_curly_nonce'     => 'HTTP_X_CURLY_NONCE',
			'x_curly_signature' => 'HTTP_X_CURLY_SIGNATURE',
		);

		$headers = array();

		if ( function_exists( 'getallheaders' ) ) {
			$all = getallheaders();
			if ( is_array( $all ) ) {
				foreach ( $all as $name => $value ) {
					$normalized = strtolower( str_replace( '-', '_', (string) $name ) );
					if ( isset( $keys[ $normalized ] ) ) {
						$headers[ $normalized ] = trim( (string) $value );
					}
				}
			}
		}

		foreach ( $keys as $header => $server_key ) {
			if ( ! empty( $headers[ $header ] ) ) {
				continue;
			}
			if ( ! empty( $_SERVER[ $server_key ] ) ) {
				$headers[ $header ] = trim( (string) wp_unslash( $_SERVER[ $server_key ] ) );
			}
		}

		return $headers;
	}

	/**
	 * @param WP_REST_Response $response
	 */
	private function emit_json_response( WP_REST_Response $response ) {
		status_header( $response->get_status() );
		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );

		echo wp_json_encode( $response->get_data() );
		exit;
	}

	/**
	 * @param WP_REST_Request $request
	 * @return array
	 */
	private function get_request_header_snapshot( WP_REST_Request $request ) {
		return array(
			'X-Curly-Domain'    => $request->get_header( 'x_curly_domain' ),
			'X-Curly-Product'   => $request->get_header( 'x_curly_product' ),
			'X-Curly-Timestamp' => $request->get_header( 'x_curly_timestamp' ),
			'X-Curly-Nonce'     => $request->get_header( 'x_curly_nonce' ),
			'X-Curly-Signature' => $request->get_header( 'x_curly_signature' )
				? substr( (string) $request->get_header( 'x_curly_signature' ), 0, 12 ) . '...'
				: '',
		);
	}

	/**
	 * @return WP_REST_Response
	 */
	private function error_response() {
		return new WP_REST_Response(
			array(
				'success' => false,
				'message' => 'Invalid request',
			),
			403
		);
	}

	/**
	 * @param string $nonce
	 * @return string
	 */
	private function nonce_storage_key( $nonce ) {
		return hash( 'sha256', $nonce );
	}

	/**
	 * @return string
	 */
	private function generate_uuid() {
		if ( function_exists( 'wp_generate_uuid4' ) ) {
			return wp_generate_uuid4();
		}

		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0x0fff ) | 0x4000,
			wp_rand( 0, 0x3fff ) | 0x8000,
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff ),
			wp_rand( 0, 0xffff )
		);
	}

	/**
	 * @return array|null
	 */
	private function get_theme_manager_config() {
		$candidates = array(
			get_template_directory() . '/framework/theme-manager.config.php',
			get_template_directory() . '/framework-extend/theme-manager.config.php',
			get_template_directory() . '/inc/framework/theme-manager.config.php',
		);

		foreach ( $candidates as $path ) {
			if ( ! file_exists( $path ) ) {
				continue;
			}

			$config = include $path;
			if ( is_array( $config ) ) {
				return $config;
			}
		}

		return null;
	}

	/**
	 * @return string|null
	 */
	private function get_mysql_version() {
		global $wpdb;

		$version = $wpdb->get_var( 'SELECT VERSION()' );
		return $version ? (string) $version : null;
	}

	/**
	 * @return array{active: array, inactive_count: int}
	 */
	private function get_plugin_snapshot() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$all    = get_plugins();
		$active = (array) get_option( 'active_plugins', array() );
		$list   = array();
		$inactive = 0;

		foreach ( $all as $file => $plugin ) {
			$is_active = in_array( $file, $active, true );
			if ( ! $is_active ) {
				$inactive++;
				continue;
			}

			$list[] = array(
				'name'       => $plugin['Name'],
				'version'    => $plugin['Version'],
				'plugin_uri' => $plugin['PluginURI'],
				'author'     => wp_strip_all_tags( $plugin['Author'] ),
			);
		}

		return array(
			'active'          => $list,
			'inactive_count'  => $inactive,
		);
	}

	/**
	 * @return array
	 */
	private function get_filesystem_snapshot() {
		$uploads = wp_upload_dir();
		$theme   = get_theme_root() . '/' . get_stylesheet();

		return array(
			'uploads_writable' => wp_is_writable( $uploads['basedir'] ),
			'theme_writable'   => file_exists( $theme ) ? wp_is_writable( $theme ) : false,
		);
	}

	/**
	 * @return array
	 */
	private function detect_curly_products() {
		$products = array();

		$theme = wp_get_theme();
		$is_curly_theme = false;

		if ( stripos( (string) $theme->get( 'AuthorURI' ), 'curlythemes.com' ) !== false ) {
			$is_curly_theme = true;
		}

		if ( class_exists( 'CT_Theme_Manager' ) || $this->get_theme_manager_config() ) {
			$is_curly_theme = true;
		}

		if ( $is_curly_theme ) {
			$products[] = array(
				'type'    => 'theme',
				'slug'    => get_template(),
				'name'    => $theme->get( 'Name' ),
				'version' => $theme->get( 'Version' ),
			);
		}

		if ( defined( 'CURLY_EXTENSION_PATH' ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$plugin_data = get_plugin_data( CURLY_EXTENSION_PATH . 'curly-extension.php', false, false );
			$products[]  = array(
				'type'    => 'plugin',
				'slug'    => 'curly-extension',
				'name'    => isset( $plugin_data['Name'] ) ? $plugin_data['Name'] : 'Curly Themes Extension',
				'version' => isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '',
			);
		}

		return $products;
	}

	/**
	 * @return array
	 */
	private function get_theme_mods_snapshot() {
		$mods = get_theme_mods();
		if ( ! is_array( $mods ) ) {
			$mods = array();
		}

		$snapshot = array(
			'stylesheet' => get_stylesheet(),
			'template'   => get_template(),
			'mods'       => $this->mask_sensitive_data( $mods ),
		);

		if ( get_stylesheet() !== get_template() ) {
			$parent_mods = get_option( 'theme_mods_' . get_template(), array() );
			$snapshot['parent_mods'] = $this->mask_sensitive_data( is_array( $parent_mods ) ? $parent_mods : array() );
		}

		return $snapshot;
	}

	/**
	 * @return array
	 */
	private function get_customizer_snapshot() {
		$stylesheet = get_stylesheet();
		$raw        = get_option( 'theme_mods_' . $stylesheet, array() );

		return array(
			'stylesheet'        => $stylesheet,
			'custom_css_post_id' => get_theme_mod( 'custom_css_post_id' ),
			'nav_menu_locations' => get_theme_mod( 'nav_menu_locations' ),
			'raw_theme_mods'    => $this->mask_sensitive_data( is_array( $raw ) ? $raw : array() ),
			'custom_logo'       => (int) get_theme_mod( 'custom_logo' ),
			'site_icon'         => (int) get_theme_mod( 'site_icon' ),
			'background_color'  => get_theme_mod( 'background_color' ),
			'header_textcolor'  => get_theme_mod( 'header_textcolor' ),
		);
	}

	/**
	 * @return array
	 */
	private function get_debug_log_tail() {
		$path = WP_CONTENT_DIR . '/debug.log';
		if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
			return array();
		}

		$lines = $this->read_last_lines( $path, self::DEBUG_LOG_LINES );
		$clean = array();

		foreach ( $lines as $line ) {
			$clean[] = $this->sanitize_string( $line );
		}

		return $clean;
	}

	/**
	 * @param string $path
	 * @param int    $lines
	 * @return array
	 */
	private function read_last_lines( $path, $lines ) {
		$handle = @fopen( $path, 'rb' );
		if ( ! $handle ) {
			return array();
		}

		$buffer = '';
		$chunk  = 4096;
		fseek( $handle, 0, SEEK_END );
		$pos = ftell( $handle );
		$line_count = 0;
		$collected  = array();

		while ( $pos > 0 && $line_count <= $lines ) {
			$read = ( $pos - $chunk ) > 0 ? $chunk : $pos;
			$pos -= $read;
			fseek( $handle, $pos );
			$buffer = fread( $handle, $read ) . $buffer;
			$parts  = explode( "\n", $buffer );
			$buffer = array_shift( $parts );
			$collected = array_merge( $parts, $collected );
			$line_count = count( $collected );
		}

		fclose( $handle );

		if ( '' !== $buffer ) {
			array_unshift( $collected, $buffer );
		}

		return array_slice( $collected, -1 * $lines );
	}

	/**
	 * @param string $key_lower
	 * @return bool
	 */
	private function is_sensitive_key_name( $key_lower ) {
		$fragments = array( 'password', 'secret', 'token', 'license', 'purchase', 'api_key', 'apikey', 'auth', 'cookie', 'email' );
		foreach ( $fragments as $fragment ) {
			if ( false !== strpos( $key_lower, $fragment ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param string $value
	 * @return string
	 */
	private function sanitize_string( $value ) {
		if ( defined( 'ABSPATH' ) ) {
			$value = str_replace( ABSPATH, '[ABSPATH]/', $value );
		}

		$value = preg_replace( '/(DB_NAME|DB_USER|DB_PASSWORD|DB_HOST)\s*[=:]\s*[^\s;]+/i', '$1=[REDACTED]', $value );
		$value = preg_replace( '/(password|passwd|secret|token|api[_-]?key|authorization)\s*[=:]\s*[^\s&]+/i', '$1=[REDACTED]', $value );
		$value = preg_replace( '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', '[email@redacted]', $value );
		$value = preg_replace( '/\b(?:[a-f0-9]{32}|[a-f0-9]{40}|[a-f0-9]{64})\b/i', '[hash@redacted]', $value );

		return $value;
	}
}

new Curly_Extension_Support_Diagnostics();
