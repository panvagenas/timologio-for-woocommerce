<?php
/**
 * Options.
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
	 * Options.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class options extends framework {
		/**
		 * Array of default options.
		 *
		 * @var array Defaults to an empty array.
		 */
		public $defaults = array();

		/**
		 * Array of option validators.
		 *
		 * @var array Defaults to an empty array.
		 */
		public $validators = array();

		/**
		 * Array of options.
		 *
		 * @var array Defaults to an empty array.
		 */
		public $options = array();

		/**
		 * A form field configuration array for a JSON options import file.
		 *
		 * @var array Set dynamically by class constructor.
		 */
		public $import_json_form_field_config = array();

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 */
		public function __construct( $instance ) {
			parent::__construct( $instance );

			$this->import_json_form_field_config // Form field configuration.
				= array(
				'type'                => 'file',
				'required'            => true,
				'name'                => $this->©action->input_name_for_call_arg( 1 ),
				'validation_patterns' => array(
					array(
						'name'         => 'json_file',
						'description'  => 'A valid `.json` file.',
						'minimum'      => 1, // 1 byte please :-)
						'maximum'      => 10485760, // 10 MB.
						'min_max_type' => 'file_size',
						'regex'        => '/\.json$/i'
					)
				),
				'move_to_dir'         => $this->©dir->temp()
			);

			$defaults   = array(
				'encryption.key'                             => '',
				'support.url'                                => 'mailto:' . get_bloginfo( 'admin_email' ),
				'no_cache.headers.always'                    => '0',
				'styles.front_side.load_by_default'          => '0',
				'styles.front_side.load_themes'              => array(),
				'styles.front_side.theme'                    => 'yeti',
				'scripts.front_side.load_by_default'         => '0',
				'crons.config'                               => array(),
				'menu_pages.theme'                           => 'yeti',
				'menu_pages.panels.order'                    => array(),
				'menu_pages.panels.state'                    => array(),
				'ips.prioritize_remote_addr'                 => '0',
				'captchas.google.public_key'                 => '6LeCANsSAAAAAIIrlB3FrXe42mr0OSSZpT0pkpFK',
				'captchas.google.private_key'                => '6LeCANsSAAAAAGBXMIKAirv6G4PmaGa-ORxdD-oZ',
				'url_shortener.default_built_in_api'         => 'goo_gl',
				'url_shortener.custom_url_api'               => '',
				'url_shortener.api_keys.goo_gl'              => '',
				'templates.stand_alone.styles'               => '<style type="text/css">' . "\n\n" . '</style>',
				'templates.stand_alone.scripts'              => '<script type="text/javascript">' . "\n\n" . '</script>',
				'templates.stand_alone.bg_style'             => 'background: #F2F1F0 url(\'' . $this->©string->esc_sq( $this->©url->to_template_dir_file( 'client-side/images/stand-alone-bg.png' ) ) . '\') repeat left top;',
				'templates.stand_alone.header'               => '<a href="' . esc_attr( $this->©url->to_wp_home_uri() ) . '"><img class="logo" src="' . esc_attr( $this->©url->to_template_dir_file( 'client-side/images/stand-alone-logo.png' ) ) . '" alt="" /></a>',
				'templates.stand_alone.footer'               => '',
				'templates.email.header'                     => '',
				'templates.email.footer'                     => '',
				'users.registration.display_name_format'     => 'first_name',
				'mail.smtp'                                  => '0',
				'mail.smtp.force_from'                       => '0',
				'mail.smtp.from_name'                        => get_bloginfo( 'name' ),
				'mail.smtp.from_addr'                        => get_bloginfo( 'admin_email' ),
				'mail.smtp.host'                             => '',
				'mail.smtp.port'                             => '0',
				'mail.smtp.secure'                           => '', // `tls` or `ssl`
				'mail.smtp.username'                         => '',
				'mail.smtp.password'                         => '',
				'plugin_site.username'                       => '',
				'plugin_site.password'                       => '',
				'menu_pages.panels.email_updates.action_url' => 'http://websharks-inc.us1.list-manage.com/subscribe/post?u=8f347da54d66b5298d13237d9&id=65240782e2',
				'menu_pages.panels.community_forum.feed_url' => 'http://wordpress.org/support/rss',
				'menu_pages.panels.news_kb.feed_url'         => 'http://make.wordpress.org/core/feed/',
				'menu_pages.panels.videos.yt_playlist'       => 'PLBmUTJGsRqNKM--kwBeKJY9wOT-n7OhnC',
				'packages.active'                            => array(),
				'log'                                        => array(),
				/***********************************************
				 * EDD Updates
				 ***********************************************/
				'edd.update'                                 => 0,
				'edd.store_url'                              => '',
				'edd_license'                                => '',
				'edd.license.status'                         => 0,
				'edd.demo'                                   => 0,
				'edd.demo_start'                             => 0,
				'edd.demo_duration'                          => 604800,
			);
			$validators = array(
				'encryption.key'                             => array( 'string:!empty' ),
				'support.url'                                => array( 'string:!empty' ),
				'no_cache.headers.always'                    => array( 'string:numeric >=' => 0 ),
				'styles.front_side.load_by_default'          => array( 'string:numeric >=' => 0 ),
				'styles.front_side.load_themes'              => array( 'array' ),
				'styles.front_side.theme'                    => array( 'string:!empty' ),
				'scripts.front_side.load_by_default'         => array( 'string:numeric >=' => 0 ),
				'crons.config'                               => array( 'array:!empty' ),
				'menu_pages.theme'                           => array( 'string:!empty' ),
				'menu_pages.panels.order'                    => array( 'array:!empty' ),
				'menu_pages.panels.state'                    => array( 'array:!empty' ),
				'ips.prioritize_remote_addr'                 => array( 'string:numeric >=' => 0 ),
				'captchas.google.public_key'                 => array( 'string:!empty' ),
				'captchas.google.private_key'                => array( 'string:!empty' ),
				'url_shortener.default_built_in_api'         => array(
					'string:in_array' => array(
						'tiny_url',
						'goo_gl'
					)
				),
				'url_shortener.custom_url_api'               => array( 'string:preg_match' => '/^https?\:/i' ),
				'url_shortener.api_keys.goo_gl'              => array( 'string:!empty' ),
				'templates.stand_alone.styles'               => array( 'string' ),
				'templates.stand_alone.scripts'              => array( 'string' ),
				'templates.stand_alone.bg_style'             => array( 'string' ),
				'templates.stand_alone.header'               => array( 'string' ),
				'templates.stand_alone.footer'               => array( 'string' ),
				'templates.email.header'                     => array( 'string' ),
				'templates.email.footer'                     => array( 'string' ),
				'users.registration.display_name_format'     => array( 'string:!empty' ),
				'mail.smtp'                                  => array( 'string:numeric >=' => 0 ),
				'mail.smtp.force_from'                       => array( 'string:numeric >=' => 0 ),
				'mail.smtp.from_name'                        => array( 'string:!empty' ),
				'mail.smtp.from_addr'                        => array( 'string:!empty' ),
				'mail.smtp.host'                             => array( 'string:!empty' ),
				'mail.smtp.port'                             => array( 'string:numeric >=' => 1 ),
				'mail.smtp.secure'                           => array( 'string:in_array' => array( 'ssl', 'tls' ) ),
				'mail.smtp.username'                         => array( 'string:!empty' ),
				'mail.smtp.password'                         => array( 'string:!empty' ),
				'plugin_site.username'                       => array( 'string:!empty' ),
				'plugin_site.password'                       => array( 'string:!empty' ),
				'menu_pages.panels.email_updates.action_url' => array( 'string:!empty' ),
				'menu_pages.panels.community_forum.feed_url' => array( 'string:!empty' ),
				'menu_pages.panels.news_kb.feed_url'         => array( 'string:!empty' ),
				'menu_pages.panels.videos.yt_playlist'       => array( 'string:!empty' ),
				'packages.active'                            => array( 'array' ),
				'log'                                        => array( 'array' ),
				/***********************************************
				 * EDD Updates
				 ***********************************************/
				'edd.update'                                 => array(
					'string:numeric >=' => 0,
					'string:numeric <=' => 1
				),
				'edd.store_url'                              => array( 'string' ),
				'edd_license'                                => array( 'string' ),
				'edd.license.status'                         => array(
					'string:numeric >=' => 0,
					'string:numeric <=' => 1
				),
				'edd.demo'                                   => array(
					'string:numeric >=' => 0,
					'string:numeric <=' => 1
				),
				'edd.demo_start'                             => array( 'string:numeric >=' => 0 ),
				'edd.demo_duration'                          => array( 'string:numeric >=' => 0 ),
			);
			$this->setup( $defaults, $validators );
		}

		/**
		 * Sets up default options and validators.
		 *
		 * @extenders Can be overridden by class extenders (i.e. to override the defaults/validators);
		 *    or to add additional default options and their associated validators.
		 *
		 * @param array $defaults An associative array of default options.
		 * @param array $validators An array of validators (can be a combination of numeric/associative keys).
		 *
		 * @return array The current array of options.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `count($defaults) !== count($validators)`.
		 */
		public function setup( $defaults, $validators ) {
			$this->_setup( $defaults, $validators );
		}

		/**
		 * Sets up default options and validators (helper).
		 *
		 * @param array $defaults An associative array of default options.
		 * @param array $validators An array of validators (can be a combination of numeric/associative keys).
		 *
		 * @return array The current array of options.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `count($defaults) !== count($validators)`.
		 */
		protected function _setup( $defaults, $validators ) {
			$this->check_arg_types( 'array', 'array', func_get_args() );

			$defaults   = $this->apply_filters( 'defaults', $defaults );
			$validators = $this->apply_filters( 'validators', $validators );

			if ( count( $defaults ) !== count( $validators ) ) {
				throw $this->©exception( // This helps us catch mistakes.
					$this->method( __FUNCTION__ ) . '#options_mismatch_to_validators', get_defined_vars(),
					$this->__( 'Options mismatch. If you add a new default option, please add a validator for it also.' ) .
					' ' . sprintf( $this->__( 'Got `%1$s` default options, `%2$s` validators. These should match up.' ), count( $defaults ), count( $validators ) )
				);
			}
			if ( ! is_array( $this->options = get_option( $this->instance->plugin_root_ns_stub . '__options' ) ) ) {
				update_option( $this->instance->plugin_root_ns_stub . '__options', ( $this->options = array() ) );
			}

			$this->defaults   = $this->©string->ify_deep( $this->©array->ify_deep( $defaults ) );
			$this->options    = array_merge( $this->defaults, $this->options );
			$this->validators = $validators;
			$this->options    = $this->validate();

			return $this->options; // All options (after setup is complete).
		}

		/**
		 * Gets a specific option value.
		 *
		 * @param string $option_name Required; and it MUST exist as a current option.
		 *    The name of an option to retrieve the value for.
		 *
		 * @param boolean $get_default Defaults to FALSE. If this is TRUE,
		 *    get the default option value, instead of current value.
		 *
		 * @return string|array The option value.
		 *    A string value, array, or multidimensional array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$option_name` is currently unknown.
		 */
		public function get( $option_name, $get_default = false ) {
			$this->check_arg_types( 'string:!empty', 'boolean', func_get_args() );

			if ( $get_default && isset( $this->defaults[ $option_name ] ) ) {
				return $this->apply_filters( 'get_' . $option_name, $this->defaults[ $option_name ] );
			}

			if ( ! $get_default && isset( $this->options[ $option_name ] ) ) {
				return $this->apply_filters( 'get_' . $option_name, $this->options[ $option_name ] );
			}

			throw $this->©exception(
				$this->method( __FUNCTION__ ) . '#unknown_option_name', get_defined_vars(),
				sprintf( $this->__( 'Unknown option name: `%1$s`.' ), $option_name )
			);
		}

		/**
		 * Updates current options with one or more new option values.
		 *
		 * @note It's fine to force an update by calling this method without any arguments.
		 *
		 * @param array $new_options Optional. An associative array of option values to update, with each of their new values.
		 *    This array does NOT need to contain all of the current options. Only those which should be updated.
		 *
		 * @return array The current array of options.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @TODO Updating or importing options should trigger package checks.
		 */
		public function update( $new_options = array() ) {
			$this->check_arg_types( 'array', func_get_args() );

			if ( $new_options ) // An array with `$new_options`, NOT empty?
			{
				$new_options = $this->©string->ify_deep( $this->©array->ify_deep( $new_options ) );

				foreach ( $new_options as &$_new_option ) // Variable by reference.
				{
					if ( is_array( $_new_option ) ) // Remove update markers and possible file info.
					{
						unset( $_new_option['___update'], $_new_option['___file_info'] );
					}
				}
				unset( $_new_option ); // Housekeeping.

				$this->options = array_merge( $this->options, $new_options );
			}
			$this->options = $this->validate( true ); // Full validation before updates.
			update_option( $this->instance->plugin_root_ns_stub . '__options', $this->options );
			$this->©db_cache->purge(); // Updates indicate config changes (so we also purge the DB cache).

			return $this->options; // All options (w/ updates applied).
		}

		/**
		 * Validates the current array of option values.
		 *
		 * @param boolean $use_validators Defaults to FALSE. By default, we perform only a basic validation.
		 *    If TRUE, a full validation is performed, including all `$validators`.
		 *
		 * @return array The current array of options.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If an unknown validation type is found in the array of `$validators`.
		 * @modifies-options-array If an option fails validation, we silently revert that option to it's default value.
		 *
		 * @note Options will ONLY be strings, or multidimensional arrays containing other string option values.
		 *    All `$defaults`, and new options added via `update()`, will be stringified/arrayified deeply.
		 *    See: `setup()` and `update()` for further details regarding this.
		 *
		 * @note Option value types MUST match that of their default option counterpart.
		 *    In addition, options NOT in the list of defaults, are NOT allowed to exist on their own.
		 *    Any options NOT in the list of defaults, are silently removed by this routine.
		 *
		 * @note In order to avoid potential conflicts after a plugin upgrade,
		 *    the `©installation->activation()` routine should always call upon the `update()` method here in this class,
		 *    which fires this full validation routine; thereby preventing possible option value conflicts from one version to the next.
		 */
		public function validate( $use_validators = false ) {
			$this->check_arg_types( 'boolean', func_get_args() );

			foreach ( $this->options as $_key => &$_value ) {
				if ( ! isset( $this->defaults[ $_key ] ) ) {
					unset( $this->options[ $_key ] );
				} else if ( ! in_array( gettype( $_value ), array( 'string', 'array' ), true ) ) {
					$_value = $this->defaults[ $_key ];
				} else if ( gettype( $_value ) !== gettype( $this->defaults[ $_key ] ) ) {
					$_value = $this->defaults[ $_key ];
				} else if ( $use_validators && $this->©array->is_not_empty( $this->validators[ $_key ] ) ) {
					foreach ( $this->validators[ $_key ] as $_validation_key => $_data ) {
						// Can be a combination of numeric/associative keys.

						if ( is_numeric( $_validation_key ) ) // A numeric key?
						{
							$_validation_type = $_data; // As type.
							$_data            = null; // Nullify data.
						} else // Associative key with possible `$_data`.
						{
							/** @var mixed $_data */
							$_validation_type = $_validation_key;
						}
						switch ( $_validation_type ) // By validation type.
						{
							case 'string': // Validation only.

								if ( ! is_string( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:!empty': // Validation only.

								if ( ! is_string( $_value ) || empty( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:strlen': // Validation only.
								if ( ! is_string( $_value ) || ! strlen( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:strlen <=': // Validation only.

								if ( ! is_string( $_value ) || ( is_numeric( $_data ) && strlen( $_value ) > $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:strlen >=': // Validation only.

								if ( ! is_string( $_value ) || ( is_numeric( $_data ) && strlen( $_value ) < $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:numeric': // Validation only.

								if ( ! is_string( $_value ) || ! is_numeric( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:numeric <=': // Validation only.

								if ( ! is_string( $_value ) || ! is_numeric( $_value ) || ( is_numeric( $_data ) && $_value > $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:numeric >=': // Validation only.

								if ( ! is_string( $_value ) || ! is_numeric( $_value ) || ( is_numeric( $_data ) && $_value < $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:preg_match': // Validation only.

								if ( ! is_string( $_value ) || ( is_string( $_data ) && ! preg_match( $_data, $_value ) ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:in_array': // Validation only.

								if ( ! is_string( $_value ) || ( is_array( $_data ) && ! in_array( $_value, $_data ) ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'string:strtolower': // Validation w/procedure.

								if ( ! is_string( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								} else // Just force lowercase.
								{
									$_value = strtolower( $_value );
									break; // Do next validation.
								}

							case 'string:preg_replace': // Validation w/procedure.

								if ( ! is_string( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								} else if ( is_array( $_data ) && $this->©strings->are_set( $_data['replace'], $_data['with'] ) ) {
									$_value = preg_replace( $_data['replace'], $_data['with'], $_value );
								}

								break; // Do next validation.

							case 'array': // Validation only.

								if ( ! is_array( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:!empty': // Validation only.

								if ( ! is_array( $_value ) || empty( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:count <=': // Validation only.

								if ( ! is_array( $_value ) || ( is_numeric( $_data ) && count( $_value ) > $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:count >=': // Validation only.

								if ( ! is_array( $_value ) || ( is_numeric( $_data ) && count( $_value ) < $_data ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:containing': // Validation only.

								if ( ! is_array( $_value ) || ! in_array( $_data, $_value, true ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:containing-any-of': // Validation only.

								if ( ! is_array( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								} else if ( is_array( $_data ) ) {
									foreach ( $_data as $_data_value ) {
										if ( in_array( $_data_value, $_value, true ) ) {
											break;
										}
									} // Do next validation.

									unset( $_data_value ); // Housekeeping.
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								}
								break; // Do next validation.

							case 'array:containing-all-of': // Validation only.

								if ( ! is_array( $_value ) ) {
									$_value = $this->defaults[ $_key ];
									break 2; // Done validating here.
								} else if ( is_array( $_data ) ) {
									foreach ( $_data as $_data_value ) {
										if ( ! in_array( $_data_value, $_value, true ) ) {
											$_value = $this->defaults[ $_key ];
											break 2; // Done validating here.
										}
									}
									unset( $_data_value ); // Housekeeping.
								}
								break; // Do next validation.

							default: // Exception.
								throw $this->©exception(
									$this->method( __FUNCTION__ ) . '#unknown_validation_type', get_defined_vars(),
									sprintf( $this->__( 'Unknown validation type: `%1$s`.' ), $_validation_type )
								);
						}
					}
					unset( $_validation_key, $_validation_type, $_data );
				}
			}
			unset( $_key, $_value ); // A little housekeeping.

			return $this->options; // Returns all options (fully validated).
		}

		/**
		 * Substitutes site-specific option values with replacement codes (and reverse).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value An input value to run substitutions on.
		 * @param boolean $fill_reverse Fill/reverse replacement codes? Default is `FALSE`.
		 *    By default, we substitute site-specific values with replacement codes.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return mixed Output `$value` after having done substitutions (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function substitute_deep( $value, $fill_reverse = false, $___recursion = false ) {
			if ( ! $___recursion ) // Only for the initial caller.
			{
				$this->check_arg_types( '', 'boolean', 'boolean', func_get_args() );
			}

			if ( is_array( $value ) || is_object( $value ) ) {
				foreach ( $value as $_key_prop => &$_value ) {
					$_value = $this->substitute_deep( $_value, $fill_reverse, true );
				}

				return $value; // Nothing more to do here.
			}
			if ( ! is_string( $value ) || ! isset( $value[0] ) ) {
				return $value;
			} // Nothing to do.

			// Establish working variables.

			$is_multisite  = is_multisite();
			$wp_root_parts = $this->©url->wp_root_parts();
			if ( $is_multisite ) // Grab multisite specifics here.
			{
				$current_blog_host_path = rtrim( $GLOBALS['current_blog']->domain . $GLOBALS['current_blog']->path, '/' );
				$current_site_host_path = rtrim( $GLOBALS['current_site']->domain . $GLOBALS['current_site']->path, '/' );
			}
			// Do substitutions now. Either fill; or do replacement codes.

			if ( $fill_reverse ) // Fill replacement codes back in w/ site-specific values.
			{
				if ( $is_multisite && isset( $current_blog_host_path, $current_site_host_path ) ) {
					$value = str_replace( '%%current_blog_host_path%%', $current_blog_host_path, $value );
					$value = str_replace( '%%current_site_host_path%%', $current_site_host_path, $value );
				} else // Convert what were network config values into single-site config values.
				{
					$value = str_replace( '%%current_blog_host_path%%', $wp_root_parts['wp_site_parts']['host'], $value );
					$value = str_replace( '%%current_site_host_path%%', $wp_root_parts['wp_site_parts']['host'], $value );
				}
				$value = str_replace( '%%home_host%%', $wp_root_parts['wp_home_parts']['host'], $value );
				$value = str_replace( '%%site_host%%', $wp_root_parts['wp_site_parts']['host'], $value );

				$value = str_replace( '%%network_home_host%%', $wp_root_parts['wp_network_home_parts']['host'], $value );
				$value = str_replace( '%%network_site_host%%', $wp_root_parts['wp_network_site_parts']['host'], $value );

				$value = str_replace( '%%current_host%%', $this->©url->current_host(), $value ); // For good measure.
			} else // Substitute site-specific values with replacement codes; for replacement on import later.
			{
				if ( $is_multisite && isset( $current_blog_host_path, $current_site_host_path ) ) {
					$value = preg_replace( '/\b' . preg_quote( $current_blog_host_path, '/' ) . '\b/i', '%%current_blog_host_path%%', $value );
					$value = preg_replace( '/\b' . preg_quote( $current_site_host_path, '/' ) . '\b/i', '%%current_site_host_path%%', $value );
				}
				$value = preg_replace( '/\b' . preg_quote( $wp_root_parts['wp_home_parts']['host'], '/' ) . '\b/i', '%%home_host%%', $value );
				$value = preg_replace( '/\b' . preg_quote( $wp_root_parts['wp_site_parts']['host'], '/' ) . '\b/i', '%%site_host%%', $value );

				$value = preg_replace( '/\b' . preg_quote( $wp_root_parts['wp_network_home_parts']['host'], '/' ) . '\b/i', '%%network_home_host%%', $value );
				$value = preg_replace( '/\b' . preg_quote( $wp_root_parts['wp_network_site_parts']['host'], '/' ) . '\b/i', '%%network_site_host%%', $value );

				$value = preg_replace( '/\b' . preg_quote( $this->©url->current_host(), '/' ) . '\b/i', '%%current_host%%', $value ); // For good measure.
			}

			return $value; // All set now.
		}

		/**
		 * Deletes all existing options from the database.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
		 *
		 * @return array The current array of options (i.e. the defaults only) on success.
		 *    On failure this returns an empty array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note Important... this is called upon by the {@link ___uninstall___()} method below.
		 * @note This could also be used to revert a site owner back to our default options.
		 */
		public function delete( $confirmation = false ) {
			$this->check_arg_types( 'boolean', func_get_args() );

			if ( $confirmation ) // Have confirmation?
			{
				$this->options = $this->defaults;
				delete_option( $this->instance->plugin_root_ns_stub . '__options' );

				return $this->options; // Default options.
			}

			return array(); // Failure (no confirmation).
		}

		/**
		 * Updates current options with one or more new option values.
		 *
		 * @note It's fine to force an update by calling this method without any arguments.
		 *
		 * @param array $new_options Optional. An associative array of option values to update, with each of their new values.
		 *    This array does NOT need to contain all of the current options. Only those which should be updated.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®update( $new_options = array() ) {
			$this->check_arg_types( 'array', func_get_args() );

			$this->update( $new_options, true );

			$successes = $this->©success(
				$this->method( __FUNCTION__ ) . '#success', get_defined_vars(),
				sprintf( $this->__( 'Options saved successfully. Great<em>!</em>' ) )
			);
			$this->©action->set_call_data_for( $this->dynamic_call( __FUNCTION__ ), get_defined_vars() );
		}

		/**
		 * Restores default option values; i.e. deletes all existing options configured by the site owner.
		 *
		 * @param string|boolean $confirmation Must have confirmation that a restoration is desired!
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®restore_defaults( $confirmation ) {
			$this->check_arg_types( array( 'string', 'boolean' ), func_get_args() );

			if ( ( $confirmation = $this->©string->is_true( $confirmation ) ) && $this->delete( $confirmation ) ) {
				$successes = $this->©success(
					$this->method( __FUNCTION__ ) . '#success', get_defined_vars(),
					sprintf( $this->__( 'Default options restored successfully. Ah, a fresh start<em>!</em>' ) )
				);
			} else {
				$errors = $this->©error(
					$this->method( __FUNCTION__ ) . '#error', get_defined_vars(),
					sprintf( $this->__( 'Default options NOT restored. Missing required confirmation.' ) )
				);
			}
			$this->©action->set_call_data_for( $this->dynamic_call( __FUNCTION__ ), get_defined_vars() );
		}

		/**
		 * Imports a new set of plugin configuration options.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®import( $file, $___file_info ) {
			$this->check_arg_types( 'string', 'array', func_get_args() );

			$field_values = array( 0 => $file, '___file_info' => $___file_info );
			$fields       = array( $this->import_json_form_field_config );
			$file_path    = $fields[0]['move_to_dir'] . '/' . $file;

			if ( $this->©errors->exist_in( $validation = $this->©form_fields->validate( $field_values, $fields ) ) ) {
				$errors = $validation;
			} // Validation errors exist in this case.

			else if ( ! is_file( $file_path ) || ! is_readable( $file_path )
			          || ! ( $file_contents = file_get_contents( $file_path ) )
			          || ! is_array( $new_options = json_decode( $file_contents, true ) )
			          || ! ( $new_options = $this->substitute_deep( $new_options, true ) )
			          || ! $this->update( $new_options ) // And update!
			) {
				$errors = $this->©error(
					$this->method( __FUNCTION__ ) . '#read_failure', get_defined_vars(),
					sprintf( $this->__( 'Import failure. Unable to read: `%1$s`.' ), $file_path )
				);
			} else {
				$successes = $this->©success(
					$this->method( __FUNCTION__ ) . '#success', get_defined_vars(),
					$this->__( 'Options imported successfully. Wow, that was easy<em>!</em>' )
				);
			}
			$this->©action->set_call_data_for( $this->dynamic_call( __FUNCTION__ ), get_defined_vars() );
		}

		/**
		 * Exports the currently configured options.
		 */
		public function ®export() {
			$this->©env->prep_for_file_download(); // Misc. tweaks.
			$this->©header->clean_status_type( 200, 'application/json', true );
			$this->©header->content_disposition( 'attachment', $this->instance->plugin_root_ns_with_dashes . '.json' );

			$options_for_export = $this->options; // Currently configured options.
			$options_for_export = $this->substitute_deep( $options_for_export );
			unset( $options_for_export['crons.config'] ); // Ditch these.

			exit( json_encode( $options_for_export ) );
		}

		/**
		 * Adds data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully installed.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___activate___( $confirmation = false ) {
			$this->check_arg_types( 'boolean', func_get_args() );

			if ( ! $confirmation ) {
				return false;
			} // Added security.

			$this->update();

			return true;
		}

		/**
		 * Removes data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully uninstalled.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___uninstall___( $confirmation = false ) {
			$this->check_arg_types( 'boolean', func_get_args() );

			if ( ! $confirmation ) {
				return false;
			} // Added security.

			$this->delete( true );

			return true;
		}
	}
}