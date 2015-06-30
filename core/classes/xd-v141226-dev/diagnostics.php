<?php
/**
 * Diagnostics.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev {
	if ( ! defined( 'WPINC' ) ) {
		exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
	}

	/**
	 * Diagnostics.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class diagnostics extends framework {
		/**
		 * Diagnostic type.
		 *
		 * @extenders Should be overridden by class extenders.
		 *
		 * @var string Defaults to `diagnostic`.
		 */
		public $type = 'diagnostic';

		/**
		 * Should this type of diagnostic be logged into a DEBUG file?
		 *    Applies only when/if `WP_DEBUG_LOG` mode is enabled.
		 *
		 * @extenders Should be overridden by class extenders.
		 *
		 * @var boolean Should this type of diagnostic be logged into a DEBUG file?
		 *    Applies only when/if `WP_DEBUG_LOG` mode is enabled.
		 */
		public $wp_debug_log = false;

		/**
		 * Should this type of diagnostic be logged into a DB table?
		 *
		 * @extenders Should be overridden by class extenders.
		 *
		 * @var boolean Should this type of diagnostic be logged into a DB table?
		 */
		public $db_log = false;

		/**
		 * Array of diagnostics.
		 *
		 * @var array Defaults to an empty array.
		 */
		public $diagnostics = array();

		/**
		 * Array of diagnostic data values.
		 *
		 * @var array Defaults to an empty array.
		 */
		public $data = array();

		/**
		 * Force log, only for internal use
		 * @var bool Defaults to false
		 */
		protected $force = false;

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param string $code Optional diagnostic code (to construct with a new diagnostic).
		 *
		 * @param mixed $data Optional diagnostic data (i.e. something to assist in reporting/logging).
		 *    This argument can be bypassed using a NULL value (that's fine).
		 *
		 * @param string $message Optional diagnostic message (if constructing with a new diagnostic).
		 *
		 * @param string $log Optional. This defaults to the value of {@link fw_constants::log_enable}.
		 *    This simply provides some additional control over which specific diagnostics will be logged (if any).
		 *    By default, we enable logging on a per-diagnostic basis. However, even if this is {@link fw_constants::log_enable},
		 *    logging ONLY occurs if enabled overall (based on diagnostic type). Can also be set to {@link fw_constants::log_disable}.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function __construct( $instance, $code = '', $data = null, $message = '', $log = self::log_enable ) {
			parent::__construct( $instance );

			$this->check_arg_types( '', 'string:!empty', '', 'string', 'string:!empty', func_get_args() );

			if ( ! empty( $code ) ) {
				$this->add( $code, $data, $message, $log );
			}
		}

		/**
		 * Add new diagnostic.
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 *
		 * @param mixed $data Optional diagnostic data (i.e. something to assist in reporting/logging).
		 *    This argument can be bypassed using a NULL value (that's fine).
		 *
		 * @param string $message Optional diagnostic message. Defaults to `Diagnostic code: $code`.
		 *
		 * @param string $log Optional. This defaults to the value of {@link fw_constants::log_enable}.
		 *    This simply provides some additional control over which specific diagnostics will be logged.
		 *    By default, we enable logging on a per-diagnostic basis. However, even if this is {@link fw_constants::log_enable},
		 *    logging only occurs if enabled overall (based on diagnostic type). Can also be set to {@link fw_constants::log_disable}.
		 *
		 * @param string $logType Optional. This defaults to the value of {@link fw_constants::log_type_txt}.
		 *
		 * @return string The diagnostic `$code`, else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function add( $code, $data = null, $message = '', $log = self::log_enable, $logType = self::log_type_txt ) {
			$this->check_arg_types( 'string:!empty', '', 'string', 'string:!empty', 'string:!empty', func_get_args() );

			$message = ( $message ) ? $message : sprintf( $this->__( 'Diagnostic code: `%1$s`.' ), $code );

			$this->diagnostics[ $code ][] = $message;

			if ( isset( $data ) ) // Can be empty.
			{
				$this->data[ $code ] = $data;
			}

			if ( $log === $this::log_enable || $this->force ) // Possible debug/database logging.
			{
				$this->wp_debug_log( $code, $data, $message, $logType );
				$this->db_log( $code, $data, $message, $logType );
			}

			return $code; // Diagnostic code.
		}

		/**
		 * Forces log regardless of WP_DEBUG and WP_DEBUG_LOG
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 *
		 * @param mixed $data Optional diagnostic data (i.e. something to assist in reporting/logging).
		 *    This argument can be bypassed using a NULL value (that's fine).
		 *
		 * @param string $message Optional diagnostic message. Defaults to `Diagnostic code: $code`.
		 *
		 * @param string $log Optional. This defaults to the value of {@link fw_constants::log_enable}.
		 *    This simply provides some additional control over which specific diagnostics will be logged.
		 *    By default, we enable logging on a per-diagnostic basis. However, even if this is {@link fw_constants::log_enable},
		 *    logging only occurs if enabled overall (based on diagnostic type). Can also be set to {@link fw_constants::log_disable}.
		 *
		 * @param string $logType Optional. This defaults to the value of {@link fw_constants::log_type_txt}.
		 *
		 * @return string The diagnostic `$code`, else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function forceAdd( $code, $data = null, $message = '', $log = self::log_enable, $logType = self::log_type_txt ) {
			$this->force = true;
			$code        = $this->add( $code, $data, $message, $log, $logType );
			$this->force = false;

			return $code;
		}

		/**
		 * Format message as JSON string
		 *
		 * @uses ©var->to_js()
		 *
		 * @param $code
		 * @param $data
		 * @param $message
		 *
		 * @return string
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		protected function getJson( $code, $data, $message ) {
			$this->check_arg_types( 'string:!empty', '', 'string:!empty', func_get_args() );

			return json_encode( array(
				'type' => $this->type,
				'code' => $code,
				'time' => $this->©env->time_details(),
				'mem'  => $this->©env->memory_details(),
				'ver'  => $this->©env->version_details(),
				'uid'  => $this->©user->ID,
				'uem'  => $this->©user->email,
				'msg'  => $message,
				'data' => json_encode( $data )
			) );
		}

		/**
		 * Forces log regardless of WP_DEBUG and WP_DEBUG_LOG. Stores only to JSON format
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 * @param mixed $data Optional diagnostic data (i.e. something to assist in reporting/logging).
		 *    This argument can be bypassed using a NULL value (that's fine).
		 * @param string $message Optional diagnostic message. Defaults to `Diagnostic code: $code`.
		 *
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function forceDBLog( $code, $data, $message ) {
			$this->check_arg_types( 'string:!empty', '', 'string:!empty', func_get_args() );

			$message                      = ( $message ) ? $message : sprintf( $this->__( 'Diagnostic code: `%1$s`.' ), $code );
			$this->diagnostics[ $code ][] = $message;
			$this->data[ $code ]          = $data;

			$log = $this->©option->get( 'log' );

			$log[] = $this->getJson( $code, $data, $message );

			$this->©option->update( array( 'log' => $log ) );
		}

		/**
		 * Load log entries that was stored in DB using forceDBLog method
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function loadDBLog() {
			$data = $this->©option->get( 'log' );

			foreach ( (array)$data as $k => $json ) {
				$entry = json_decode( $json );

				$this->diagnostics[ $entry->code ][] = array(
					'type' => $entry->type,
					'code' => $entry->code,
					'time' => $entry->time,
					'mem'  => $entry->mem,
					'ver'  => $entry->ver,
					'uid'  => $entry->uid,
					'uem'  => $entry->uem,
					'msg'  => $entry->msg,
					'data' => $entry->data
				);
			}
		}

		/**
		 * Remove a diagnostic.
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 *
		 * @return string The diagnostic `$code`, else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remove( $code ) {
			$this->check_arg_types( 'string:!empty', func_get_args() );

			unset( $this->diagnostics[ $code ], $this->data[ $code ] );

			return $code; // Diagnostic code.
		}

		/**
		 * Logs diagnostics (if `WP_DEBUG_LOG` is enabled).
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 *
		 * @param mixed $data Required diagnostic data (i.e. something to assist in reporting/logging).
		 *    This is a required argument, but a NULL value is accepted here (that's fine).
		 *
		 * @param string $message Required diagnostic message (must NOT be empty).
		 */
		public function wp_debug_log( $code, $data, $message, $logType ) {
			$this->check_arg_types( 'string:!empty', '', 'string:!empty', func_get_args() );

			if ( ! $this->force && ( ! $this->wp_debug_log || ! $this->©env->is_in_wp_debug_log_mode() ) ) {
				return;
			} // Logging NOT enabled. Stop here.

			$log_dir  = $this->©dir->logs( 'debug', $this::private_type );
			$log_file = $this->©file->maybe_archive( $log_dir . '/debug.log' );

			$content = $logType === self::log_type_json
				? $this->getJson( $code, $data, $message )
				: ( $this->__( '— DIAGNOSTIC —' ) . "\n" .
				    $this->__( 'Diagnostic Type' ) . ': ' . $this->type . "\n" .
				    $this->__( 'Diagnostic Code' ) . ': ' . $code . "\n" .
				    $this->__( 'Diagnostic Time' ) . ': ' . $this->©env->time_details() . "\n" .
				    $this->__( 'Memory Details' ) . ': ' . $this->©env->memory_details() . "\n" .
				    $this->__( 'Version Details' ) . ': ' . $this->©env->version_details() . "\n" .
				    $this->__( 'Current User ID' ) . ': ' . $this->©user->ID . "\n" .
				    $this->__( 'Current User Email' ) . ': ' . $this->©user->email . "\n" .
				    $this->__( 'Diagnostic Message' ) . ': ' . $message . "\n" .
				    $this->__( 'Diagnostic Data (if applicable)' ) . ': ' . $this->©var->dump( $data ) . "\n\n"
				);

			file_put_contents( $log_file, $content, FILE_APPEND );
		}

		/**
		 * Logs diagnostics into a database.
		 *
		 * @extenders This is NOT implemented by the XDaRk Core.
		 *    Class extenders can easily extend this method, and perform their own DB logging routine.
		 *
		 * @param string $code Required diagnostic code (must NOT be empty).
		 *
		 * @param mixed $data Required diagnostic data (i.e. something to assist in reporting/logging).
		 *    This is a required argument, but a NULL value is accepted here (that's fine).
		 *
		 * @param string $message Required diagnostic message (must NOT be empty).
		 */
		public function db_log( $code, $data, $message, $logType ) {
			$this->check_arg_types( 'string:!empty', '', 'string:!empty', func_get_args() );

			if ( ! $this->db_log ) {
				return;
			}
		}

		/**
		 * Get first diagnostic code.
		 *
		 * @return string First diagnostic code (if diagnostics exist), else an empty string.
		 */
		public function get_code() {
			$codes = $this->get_codes();

			return ( ! empty( $codes ) ) ? $codes[0] : '';
		}

		/**
		 * Get all diagnostic codes.
		 *
		 * @return array Array of all diagnostic codes (if diagnostics exist), else an empty array.
		 */
		public function get_codes() {
			return ( ! empty( $this->diagnostics ) ) ? array_keys( $this->diagnostics ) : array();
		}

		/**
		 * Get first diagnostic message (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting first message associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @return string First diagnostic message (possibly associated with a specific diagnostic code), if one exists; else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_message( $code = '', $wordwrap = 0 ) {
			$this->check_arg_types( 'string', 'integer', func_get_args() );

			$messages = $this->get_messages( $code );

			if ( $wordwrap > 0 && ! empty( $messages ) ) {
				return wordwrap( $messages[0], $wordwrap );
			} else if ( ! empty( $messages ) ) {
				return $messages[0];
			}

			return ''; // Default return value.
		}

		/**
		 * Get first diagnostic message markup (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting first message associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @return string First diagnostic message markup (possibly associated with a specific diagnostic code), if one exists; else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_message_as_markup( $code = '', $wordwrap = 0 ) {
			$this->check_arg_types( 'string', 'integer', func_get_args() );

			$message = $this->get_message( $code, $wordwrap );

			return ( $message ) ? $this->©markdown->parse( $message ) : '';
		}

		/**
		 * Get all diagnostic messages (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting messages associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @return array Array of all diagnostic messages (or an array of all messages associated with a specific diagnostic code).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_messages( $code = '', $wordwrap = 0 ) {
			$this->check_arg_types( 'string', 'integer', func_get_args() );

			if ( ! $code ) // No code implies all messages.
			{
				$all_messages = array();

				foreach ( $this->diagnostics as $_code => $_all_messages_for_code ) {
					$all_messages = array_merge( $all_messages, $_all_messages_for_code );
				}
				unset( $_code, $_all_messages_for_code );

				if ( $wordwrap > 0 ) // Wrapping?
				{
					return $this->©strings->wordwrap_deep( $all_messages, $wordwrap );
				}

				return $all_messages;
			}
			if ( $wordwrap > 0 && ! empty( $this->diagnostics[ $code ] ) ) {
				return $this->©strings->wordwrap_deep( $this->diagnostics[ $code ], $wordwrap );
			} else if ( ! empty( $this->diagnostics[ $code ] ) ) {
				return $this->diagnostics[ $code ];
			}

			return array(); // Default return value.
		}

		/**
		 * Gets markup for all diagnostic messages (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting messages associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @param string $list_item_prefix Optional list item prefix (defaults to a value of: `• `).
		 * @param string $list_item_sep Optional list item separator (defaults to a value of: `\n\n`).
		 *
		 * @return array Array of all diagnostic messages w/markup (or an array of all messages associated with a specific diagnostic code).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_messages_as_list( $code = '', $wordwrap = 0, $list_item_prefix = '• ', $list_item_sep = "\n\n" ) {
			$this->check_arg_types( 'string', 'integer', 'string', 'string', func_get_args() );

			$messages = $this->get_messages( $code, $wordwrap );

			$list             = '';
			$last_message_key = count( $messages ) - 1;

			foreach ( $messages as $_key => $_message ) {
				$list .= $list_item_prefix . $_message . ( ( $_key < $last_message_key ) ? $list_item_sep : '' );
			}
			unset( $_key, $_message );

			return $list;
		}

		/**
		 * Gets markup for all diagnostic messages (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting messages associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @return array Array of all diagnostic messages w/markup (or an array of all messages associated with a specific diagnostic code).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_messages_as_markup( $code = '', $wordwrap = 0 ) {
			$this->check_arg_types( 'string', 'integer', func_get_args() );

			$messages = $this->get_messages( $code, $wordwrap );

			foreach ( $messages as &$_message ) {
				$_message = $this->©markdown->parse( $_message );
			}
			unset( $_message ); // Housekeeping.

			return $messages;
		}

		/**
		 * Gets markup for all diagnostic messages (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting messages associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @param string $list_item_prefix Optional list item prefix (defaults to a value of: `• `).
		 * @param string $list_item_sep Optional list item separator (defaults to a value of: `<br /><br />`).
		 *
		 * @return array Array of all diagnostic messages w/markup (or an array of all messages associated with a specific diagnostic code).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_messages_as_markup_list( $code = '', $wordwrap = 0, $list_item_prefix = '• ', $list_item_sep = '<br /><br />' ) {
			$this->check_arg_types( 'string', 'integer', 'string', 'string', func_get_args() );

			$messages = $this->get_messages_as_markup( $code, $wordwrap );

			$list             = '';
			$last_message_key = count( $messages ) - 1;

			foreach ( $messages as $_key => $_message ) {
				$list .= $list_item_prefix . $_message . ( ( $_key < $last_message_key ) ? $list_item_sep : '' );
			}
			unset( $_key, $_message );

			return $list;
		}

		/**
		 * Gets list items for all diagnostic messages (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting messages associated with a specific diagnostic code.
		 *
		 * @param integer $wordwrap Optional. Defaults to a `0` value.
		 *    If this is `> 0`; wordwrap is enabled (wrapped to the given length).
		 *
		 * @param string $prefix Optional. A prefix for each list item (an icon might be useful in some scenarios).
		 *
		 * @return string List items for all diagnostic messages (or list items for messages associated with a specific diagnostic code).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_messages_as_list_items( $code = '', $wordwrap = 0, $prefix = '' ) {
			$this->check_arg_types( 'string', 'integer', 'string', func_get_args() );

			if ( ! $code ) // No code implies all messages.
			{
				$all_messages = ''; // Initialize empty string.

				foreach ( $this->diagnostics as $_code => $_messages_for_code ) {
					$_data            = (object) $this->get_data( $_code );
					$_form_field_code = ( isset( $_data->form_field_code ) ) ? $_data->form_field_code : '';

					foreach ( $_messages_for_code as $_message ) {
						$all_messages .= // With attributes.
							'<li data-code="' . esc_attr( $_code ) . '"' .
							( ( $_form_field_code ) ? ' data-form-field-code="' . esc_attr( $_form_field_code ) . '"' : '' ) . '>' .
							$this->©markdown->parse( ( ( $wordwrap > 0 ) ? $prefix . wordwrap( $_message, $wordwrap ) : $prefix . $_message ) ) .
							'</li>';
					}
					unset( $_data, $_form_field_code, $_message ); // Housekeeping.
				}
				unset( $_messages_for_code ); // Housekeeping.

				return $all_messages; // For all codes.
			}
			// Else for a specific diagnostic code.

			$messages = ''; // Initialize empty string.

			$_data            = (object) $this->get_data( $code );
			$_form_field_code = ( isset( $_data->form_field_code ) ) ? $_data->form_field_code : '';

			foreach ( $this->diagnostics[ $code ] as $_messages_for_code ) {
				foreach ( $_messages_for_code as $_message ) {
					$messages .= // With attributes.
						'<li data-code="' . esc_attr( $code ) . '"' .
						( ( $_form_field_code ) ? ' data-form-field-code="' . esc_attr( $_form_field_code ) . '"' : '' ) . '>' .
						$this->©markdown->parse( ( ( $wordwrap > 0 ) ? $prefix . wordwrap( $_message, $wordwrap ) : $prefix . $_message ) ) .
						'</li>';
				}
				unset( $_message ); // Housekeeping.
			}
			unset( $_data, $_form_field_code, $_messages_for_code ); // Housekeeping.

			return $messages; // Messages for a specific code.
		}

		/**
		 * Get first diagnostic data (perhaps related to a specific diagnostic code).
		 *
		 * @param string $code Optional diagnostic code.
		 *    If requesting data associated with a specific diagnostic code.
		 *
		 * @return mixed First diagnostic data (possibly associated with a specific diagnostic code), if it exists, else NULL.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_data( $code = '' ) {
			$this->check_arg_types( 'string', func_get_args() );

			$code = ( $code ) ? $code : $this->get_code();

			return ( $code && isset( $this->data[ $code ] ) ) ? $this->data[ $code ] : null;
		}

		/**
		 * Check if diagnostics exist in this instance.
		 *
		 * @return diagnostics|null If diagnostics exist in `$this` instance, we return `$this` instance.
		 *    Diagnostics exist when this instance has at least one diagnostic code.
		 *    Otherwise, this will return NULL by default.
		 */
		public function exist() {
			if ( $this->get_code() ) {
				return $this;
			}

			return null; // Default return value.
		}

		/**
		 * Check if diagnostics exist in any given value.
		 *
		 * @param diagnostics|mixed $diagnostics Any value to check for diagnostics.
		 *
		 * @return diagnostics|null If `$diagnostics` is an instance of this class, with the same diagnostic `type`.
		 *    And, diagnostics exist in this instance (e.g. `$diagnostics` has at least one diagnostic code).
		 *    If so, we return the `$diagnostics` instance. Otherwise, NULL by default.
		 */
		public function exist_in( $diagnostics ) {
			if ( $diagnostics instanceof diagnostics && $diagnostics->type === $this->type ) {
				if ( $diagnostics->get_code() ) {
					return $diagnostics;
				}
			}

			return null; // Default return value.
		}

		/**
		 * Check for a diagnostics instance in any given value.
		 *
		 * @param diagnostics|mixed $diagnostics Any value to check for a diagnostics instance.
		 *
		 * @return diagnostics|null If `$diagnostics` is an instance of this class, with the same diagnostic `type`.
		 *    Otherwise, this will return NULL by default.
		 */
		public function instance_in( $diagnostics ) {
			if ( $diagnostics instanceof diagnostics && $diagnostics->type === $this->type ) {
				return $diagnostics;
			}

			return null; // Default return value.
		}
	}
}