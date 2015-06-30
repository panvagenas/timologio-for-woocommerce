<?php
/**
 * Scripts.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Scripts.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class scripts extends framework
	{
		/**
		 * @var array Front-side components.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 */
		public $front_side_components = array();

		/**
		 * @var array Stand-alone components.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 */
		public $stand_alone_components = array();

		/**
		 * @var array Menu page components.
		 *
		 * @by-constructor Set dynamically by the class constructor.
		 */
		public $menu_page_components = array();

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If this class is instantiated before the `init` action hook.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			if(!did_action('init'))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#init', NULL,
					$this->__('Doing it wrong (the `init` hook has NOT been fired yet).')
				);
			$scripts_to_register = array(); // Initialize scripts.

			// Core libs; available in all contexts.
			if(!wp_script_is($this->instance->core_ns_with_dashes, 'registered'))
				$scripts_to_register[$this->instance->core_ns_with_dashes] = array(
					'deps'     => array('jquery'), // jQuery dependency only; we compile others.
					'url'      => $this->©url->to_core_dir_file('/client-side/scripts/core-libs.min.js'),
					'ver'      => $this->instance->core_version_with_dashes,

					'localize' => array( // Array of XDaRk Core JavaScript translations.
					                     /*
					                      * NOTE: It is very important that we namespace all translations.
					                      *    Our core JavaScript class will merge ALL translations into a single object.
					                      *    So while all of these are fine; if plugins (or other core extensions) add a new
					                      *    set of translation entries they MUST follow the standard we set below.
					                      *
					                      * CORE STANDARD: Each translation entry should start with it's associated method name;
					                      *    (i.e. the class method using the translation entry); followed by a
					                      *    double underscore; e.g. `method__translation_key`.
					                      *
					                      *    If a particular translation key is used across multiple methods in the core;
					                      *    the core reserves the right to use a name of it's choosing.
					                      *
					                      *    Core extensions (such as the `menu_pages` extension); MUST prefix each translation key
					                      *    with the extension name; e.g. `menu_pages__method__translation_key`. This goes for plugins too.
					                      *
					                      * PLUGIN STANDARD: All plugins extending the core should prefix each translation entry with a
					                      *    leading underscore; e.g. `_extension__method__translation_key`. Plugins need to be sure
					                      *    that all of their own translation keys are unique across all of their extensions.
					                      *
					                      *    Plugins are also allowed to override any existing translation keys in the core;
					                      *    including in any core extensions. Hopefully not necessary, but permissible.
					                      */
					                     'instance__failure'                               => $this->__('Could NOT get instance config value for key: `%1$s`.'),
					                     'verifier__failure'                               => $this->__('Could NOT get verifier for key: `%1$s`.'),
					                     '____failure'                                     => $this->__('Could NOT get translation string for key: `%1$s`.'),
					                     'core_only_failure'                               => $this->__('Only the core may call upon: `%1$s`.'),

					                     'view_source__doc_title'                          => $this->_x('Source'),
					                     'win_open__turn_off_popup_blockers'               => $this->_x('Please turn off all popup blockers and try again.'),
					                     'ajax__invalid_type'                              => $this->__('Invalid `type`. Expecting `$$.___public_type|$$.___protected_type|$$.___private_type`.'),

					                     'check_arg_types__empty'                          => $this->__('empty'),
					                     'check_arg_types__caller'                         => $this->__('caller'),

					                     'validate_form__required_field'                   => $this->_x('This is a required field.'),
					                     'validate_form__mismatch_fields'                  => $this->_x('Mismatch (please check these fields).'),
					                     'validate_form__unique_field'                     => $this->_x('Please try again (this value MUST be unique please).'),

					                     'validate_form__required_select_at_least_one'     => $this->_x('Please select at least 1 option.'),
					                     'validate_form__required_select_at_least'         => $this->_x('Please select at least %1$s options.'),

					                     'validate_form__required_file'                    => $this->_x('A file MUST be selected please.'),
					                     'validate_form__required_file_at_least_one'       => $this->_x('Please select at least one file.'),
					                     'validate_form__required_file_at_least'           => $this->_x('Please select at least %1$s files.'),

					                     'validate_form__required_radio'                   => $this->_x('Please choose one of the available options.'),

					                     'validate_form__required_checkbox'                => $this->_x('This box MUST be checked please.'),
					                     'validate_form__required_check_at_least_one'      => $this->_x('Please check at least one box.'),
					                     'validate_form__required_check_at_least'          => $this->_x('Please check at least %1$s boxes.'),

					                     'validate_form__validation_description_prefix'    => $this->_x('<strong>REQUIRES:</strong>'),
					                     'validate_form__or_validation_description_prefix' => $this->_x('<strong>OR:</strong>'),

					                     'validate_form__check_issues_below'               => $this->_x('<strong>ERROR:</strong> please check the issues below.'),

					                     'check_arg_types__diff_object_type'               => $this->__('[a different object type]'),
					                     'check_arg_types__missing_args'                   => $this->__('Missing required argument(s); `%1$s` requires `%2$s`, `%3$s` given.'),
					                     'check_arg_types__invalid_arg'                    => $this->__('Argument #%1$s passed to `%2$s` requires `%3$s`, %4$s`%5$s` given.'),

					                     'password_strength_status__empty'                 => $this->_x('password strength indicator'),
					                     'password_strength_status__short'                 => $this->_x('too short (6 character minimum)'),
					                     'password_strength_status__weak'                  => $this->_x('weak (mix caSe, numbers & symbols)'),
					                     'password_strength_status__good'                  => $this->_x('good (reasonably strong)'),
					                     'password_strength_status__strong'                => $this->_x('very strong'),
					                     'password_strength_status__mismatch'              => $this->_x('mismatch')
					)
				);
			// Front-side components; available in all contexts.

			$this->front_side_components = $this->front_side_components();

			if(($front_side_file = $this->©file->template('/client-side/scripts/front-side.min.js', TRUE)))
			{
				$this->front_side_components[] = $this->instance->plugin_root_ns_with_dashes.'--front-side';

				$scripts_to_register[$this->instance->plugin_root_ns_with_dashes.'--front-side'] = array(
					'deps' => array($this->instance->core_ns_with_dashes),
					'url'  => $this->©url->to_wp_abs_dir_file($front_side_file),
					'ver'  => $this->instance->plugin_version_with_dashes
				);
			}
			else $this->front_side_components = // Running w/ core only; no separate front-side scripts.
				array_merge($this->front_side_components, array($this->instance->core_ns_with_dashes));

			// Stand-alone components; available in all contexts (depends on front-side).

			$this->stand_alone_components = $this->stand_alone_components();

			if(($stand_alone_file = $this->©file->template('client-side/scripts/stand-alone.min.js', TRUE)))
			{
				$this->stand_alone_components[] = $this->instance->plugin_root_ns_with_dashes.'--stand-alone';

				$scripts_to_register[$this->instance->plugin_root_ns_with_dashes.'--stand-alone'] = array(
					'deps' => $this->front_side_components, // Includes the core already.
					'url'  => $this->©url->to_wp_abs_dir_file($stand_alone_file),
					'ver'  => $this->instance->plugin_version_with_dashes
				);
			}
			else $this->stand_alone_components = // No separate stand-alone scripts.
				array_merge($this->stand_alone_components, $this->front_side_components);

			// Menu page components; only if applicable.

			if(($is_plugin_page = $this->©menu_page->is_plugin_page()))
			{
				$this->menu_page_components   = $this->menu_page_components();
				$this->menu_page_components[] = $this->instance->core_ns_with_dashes.'--menu-pages';

				if(!wp_script_is($this->instance->core_ns_with_dashes.'--menu-pages', 'registered'))
					$scripts_to_register[$this->instance->core_ns_with_dashes.'--menu-pages'] = array(
						'deps' => array($this->instance->core_ns_with_dashes),
						'url'  => $this->©url->to_core_dir_file('/client-side/scripts/menu-pages/menu-pages.min.js'),
						'ver'  => $this->instance->core_version_with_dashes
					);
			}
			if($scripts_to_register) $this->register($scripts_to_register);

			// Add data separately, as this might change for each plugin the core processes.

			$this->add_data($this->instance->core_ns_with_dashes, $this->_build_plugin_root_namespaces_for_core_inline_data());
			$this->add_data($this->instance->core_ns_with_dashes, $this->_build_instance_for_core_inline_data());
			$this->add_data($this->instance->core_ns_with_dashes, $this->_build_verifiers_for_core_inline_data());

			if(in_array($this->instance->plugin_root_ns_with_dashes.'--front-side', $this->front_side_components, TRUE))
				$this->add_data($this->instance->plugin_root_ns_with_dashes.'--front-side', $this->build_front_side_inline_data());

			if(in_array($this->instance->plugin_root_ns_with_dashes.'--stand-alone', $this->stand_alone_components, TRUE))
				$this->add_data($this->instance->plugin_root_ns_with_dashes.'--stand-alone', $this->build_stand_alone_inline_data());

			if($is_plugin_page) $this->add_data($this->instance->core_ns_with_dashes.'--menu-pages', $this->build_menu_page_inline_data());
		}

		/**
		 * Builds the initial set of front-side components.
         * Scripts must be registered first and then return slugs by this function.
         *
         * @example Return example: [$this->instance->plugin_root_ns_with_dashes . '--my-script']
		 *
		 * @extenders Can be extended to add additional front-side components.
		 *
		 * @return array An array of any additional front-side components.
		 */
		public function front_side_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * Builds the initial set of stand-alone components.
         * Scripts must be registered first and then return slugs by this function.
         *
         * @example Return example: [$this->instance->plugin_root_ns_with_dashes . '--my-script']
		 *
		 * @extenders Can be extended to add additional stand-alone components.
		 *
		 * @return array An array of any additional stand-alone components.
		 */
		public function stand_alone_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * Builds the initial set of menu page components.
		 * Scripts must be registered first and then return slugs by this function.
         *
         * @example Return example: [$this->instance->plugin_root_ns_with_dashes . '--my-script']
         *
		 * @extenders Can be extended to add additional menu page components.
		 *
		 * @return array An array of any additional menu page components.
		 */
		public function menu_page_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * Builds plugin root namespaces for core inline data.
		 *
		 * @return string Plugin root namespaces for core inline data.
		 */
		protected function _build_plugin_root_namespaces_for_core_inline_data()
		{
			if(isset($this->cache[__FUNCTION__])) return $this->cache[__FUNCTION__];

			// Initialize the array of all plugin root namespaces for the core.

			if(empty($GLOBALS[$this->instance->core_ns.'_scripts_initialized_plugin_root_namespaces'])
			   && ($GLOBALS[$this->instance->core_ns.'_scripts_initialized_plugin_root_namespaces'] = TRUE)
			) $data = 'var $'.$this->instance->core_ns.'___plugin_root_namespaces = [];';

			// Plugin plugin root namespace; which is possibly the core also.

			$data = !empty($data) ? $data."\n" : ''; // Appending?
			$data .= '$'.$this->instance->core_ns.'___plugin_root_namespaces.push'.
			         '(\''.$this->©string->esc_js_sq($this->instance->plugin_root_ns).'\');';

			return ($this->cache[__FUNCTION__] = $data);
		}

		/**
		 * Builds instance config for core inline data.
		 *
		 * @return string Instance config for core inline data.
		 */
		protected function _build_instance_for_core_inline_data()
		{
			if(isset($this->cache[__FUNCTION__])) return $this->cache[__FUNCTION__];

			// Core instance config; for the core itself.

			if(empty($GLOBALS[$this->instance->core_ns.'_scripts_loaded_core_instance'])
			   && ($GLOBALS[$this->instance->core_ns.'_scripts_loaded_core_instance'] = TRUE)
			) // Notice the call below pulls an instance from the core itself; i.e. `core()->instance->for_js()`.
			{
				$data = 'var $'.$this->instance->core_ns.'___instance = {';

				$data .= $this->©object->to_js(core()->instance->for_js(), FALSE).',';
				$data .= "'wp_load_url':'".$this->©string->esc_js_sq($this->©url->to_wp_abs_dir_file($this->©file->wp_load()))."',";
				$data .= "'core_dir_url':'".$this->©string->esc_js_sq($this->©url->to_core_dir_file())."',";

				$data = rtrim($data, ',').'};'; // Trim and close curly bracket.
			}
			// Plugin instance config; which is possibly the core also.

			$data = !empty($data) ? $data."\n" : ''; // Appending?
			$data .= 'var $'.$this->instance->plugin_root_ns.'___instance = {';

			$data .= $this->©object->to_js($this->instance->for_js(TRUE), FALSE).',';
			$data .= "'plugin_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_dir_file())."',";
			$data .= "'plugin_data_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_data_dir_file())."',";
			$data .= "'plugin_pro_dir_url':'".$this->©string->esc_js_sq($this->©url->to_plugin_pro_dir_file())."',";

			$data = rtrim($data, ',').'};'; // Trim and close curly bracket.

			return ($this->cache[__FUNCTION__] = $data);
		}

		/**
		 * Builds verifiers for core inline data.
		 *
		 * @return string Verifiers for core inline data.
		 */
		protected function _build_verifiers_for_core_inline_data()
		{
			if(isset($this->cache[__FUNCTION__])) return $this->cache[__FUNCTION__];

			$data = 'var $'.$this->instance->plugin_root_ns.'___verifiers = {';

			if(is_admin() && ($current_menu_page_slug_class_basename = $this->©menu_pages->is_plugin_page('', TRUE)))
			{
				$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages.®update_theme', $this::private_type).',';
				$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_slug_class_basename.'.®update_content_panels_order', $this::private_type).',';
				$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_slug_class_basename.'.®update_content_panels_state', $this::private_type).',';
				$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_slug_class_basename.'.®update_sidebar_panels_order', $this::private_type).',';
				$data .= $this->©action->ajax_verifier_property_for_call('©menu_pages__'.$current_menu_page_slug_class_basename.'.®update_sidebar_panels_state', $this::private_type).',';

				if($this->©edd_updater->isEDD()){
					$data .= $this->©action->ajax_verifier_property_for_call('©edd_updater.®ajaxActivateLicense', $this::private_type).',';
					$data .= $this->©action->ajax_verifier_property_for_call('©edd_updater.®ajaxDeactivateLicense', $this::private_type).',';
				}
			}
			// TODO Differentiate admin from front side
			foreach ( get_class_methods( $this->©ajax ) as $k => $method ) {
				if(strpos(strtolower($method), '®ajax') !== 0) continue;

				$data .= $this->©action->ajax_verifier_property_for_call('©ajax.'.$method, (is_numeric(strpos(strtolower($method), 'public')) ? $this::public_type : $this::private_type)).',';
			}

			$data .= $this->build_verifiers_for_core_inline_data(); // Make this easy for class extenders.

			$data = rtrim($data, ',').'};'; // Trim and close curly bracket.

			return ($this->cache[__FUNCTION__] = $data);
		}

		/**
		 * Builds additional verifiers for inline data.
		 *
		 * @extenders Can be overridden by class extenders that need additional verifiers.
		 *
		 * @return string Additional verifiers for inline data.
		 */
		public function build_verifiers_for_core_inline_data()
		{
			if(isset($this->cache[__FUNCTION__]))
				return $this->cache[__FUNCTION__];

			return ($this->cache[__FUNCTION__] = '');
		}

		/**
		 * Builds front-side inline data.
		 *
		 * @return string Front-side inline data.
		 */
		public function build_front_side_inline_data()
		{
			if(isset($this->cache[__FUNCTION__]))
				return $this->cache[__FUNCTION__];

			return ($this->cache[__FUNCTION__] = '');
		}

		/**
		 * Builds stand-alone inline data.
		 *
		 * @return string Stand-alone inline data.
		 */
		public function build_stand_alone_inline_data()
		{
			if(isset($this->cache[__FUNCTION__]))
				return $this->cache[__FUNCTION__];

			return ($this->cache[__FUNCTION__] = '');
		}

		/**
		 * Builds menu page inline data.
		 *
		 * @return string Menu page inline data.
		 */
		public function build_menu_page_inline_data()
		{
			if(isset($this->cache[__FUNCTION__]))
				return $this->cache[__FUNCTION__];

			return ($this->cache[__FUNCTION__] = '');
		}

		/**
		 * Plugin components (selective components which apply in the current context).
		 *
		 * @param string|array $others Any other components that we'd like to include in the return value.
		 *    Helpful if we're pulling all current components, along with something else.
		 *
		 * @return array Plugin components (selective components which apply in the current context).
		 *    See also `$this->©plugin->needs_*()`; where filters are implemented via easy-to-use methods.
		 */
		public function contextual_components($others = array())
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = array(); // Initialize array.
			$others     = ($others) ? (array)$others : array();

			$front_side_load_filter  = $this->apply_filters('front_side', (boolean)$this->©options->get('scripts.front_side.load_by_default'));
			$stand_alone_load_filter = $this->apply_filters('stand_alone', FALSE);
			$is_plugin_page          = $this->©menu_page->is_plugin_page();

			if($front_side_load_filter) $components = array_merge($components, $this->front_side_components);
			if($stand_alone_load_filter) $components = array_merge($components, $this->stand_alone_components);
			if($is_plugin_page) $components = array_merge($components, $this->menu_page_components);

			return array_unique(array_merge($components, $others));
		}

		/**
		 * Registers scripts with WordPress®.
		 *
		 * @param array $scripts An array of scripts to register.
         * @example
         * [
         *      $this->instance->plugin_root_ns_with_dashes . '--front-side' => array(
         *          'deps' => array('jquery', 'stand-alone'),
         *          'url'  => $this->©url->to_plugin_dir_file('templates/client-side/scripts/front-side.min.js'),
         *          'ver'  => $this->instance->plugin_version_with_dashes
         *      )
         * ]
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If a default script is NOT configured properly.
		 */
		public function register($scripts)
		{
			$this->check_arg_types('array', func_get_args());

			foreach($scripts as $_handle => $_script)
			{
				if(!is_array($_script) // Validates?
				   || !$this->©string->is_not_empty($_script['url'])
				) // This MUST be an array with a `url` string.
					throw $this->©exception(
						$this->method(__FUNCTION__).'#url_missing', get_defined_vars(),
						$this->__('Invalid script configuration. Missing and/or invalid `url`.').
						' '.sprintf($this->__('Problematic script handle: `%1$s`.'), $_handle)
					);
				// Additional configurations (all optional).
				$_script['deps']      = $this->©array->isset_or($_script['deps'], array());
				$_script['ver']       = $this->©string->isset_or($_script['ver'], '');
				$_script['ver']       = ($_script['ver']) ? $_script['ver'] : NULL;
				$_script['in_footer'] = $this->©boolean->isset_or($_script['in_footer'], TRUE);

				// Filter for site owners needing specific scripts in the footer.
				$_script['in_footer'] = $this->apply_filters('in_footer', $_script['in_footer'], $_handle);

				wp_deregister_script($_handle);
				wp_register_script($_handle, $_script['url'], $_script['deps'], $_script['ver'], $_script['in_footer']);

				if($this->©array->is_not_empty($_script['localize'])) // Translation data?
					wp_localize_script($_handle, '$'.$this->©string->with_underscores($_handle).'___i18n', $_script['localize']);

				if($this->©string->is_not_empty($_script['data'])) // Additional inline data?
					$this->add_data($_handle, $_script['data']); // WordPress® is currently lacking this feature.
			}
			unset($_handle, $_script);
		}

		/**
		 * Prints stand-alone/front-side scripts.
		 *
		 * @attaches-to WordPress® `wp_print_scripts` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function wp_print_scripts()
		{
			if(!is_admin()) // Front-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Print admin scripts.
		 *
		 * @attaches-to WordPress® `admin_print_scripts` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function admin_print_scripts()
		{
			if(is_admin()) // Admin-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Prints specific scripts.
		 *
		 * @param string|array $components A string, or an array of specific components to print.
		 */
		public function print_scripts($components)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = (array)$components; // Force an array value.

			global $wp_scripts; // Global object reference.
			if(!($wp_scripts instanceof \WP_Scripts))
				$wp_scripts = new \WP_Scripts();

			foreach(($components = array_unique($components)) as $_key => $_handle)
				if(!$this->©string->is_not_empty($_handle) || !wp_script_is($_handle, 'registered'))
					unset($components[$_key]); // Remove (NOT a handle, or NOT registered).
			unset($_key, $_handle); // Housekeeping.

			if($components) // Still have something to print?
				$wp_scripts->do_items($components);
		}

		/**
		 * Enqueues scripts (even if they'll appear in the footer).
		 *
		 * @param string|array $components A string, or an array of specific components to enqueue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function enqueue($components)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = (array)$components; // Force array value.

			foreach(($components = array_unique($components)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
					if(!wp_script_is($_handle, 'queue')) // NOT in the queue?
						wp_enqueue_script($_handle);
			unset($_handle); // Housekeeping.
		}

		/**
		 * Dequeues scripts (if it's NOT already too late).
		 *
		 * @param string|array $components A string, or an array of specific components to dequeue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function dequeue($components)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = (array)$components; // Force array value.

			foreach(($components = array_unique($components)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
					if(wp_script_is($_handle, 'queue')) // In the queue?
						wp_dequeue_script($_handle);
			unset($_handle); // Housekeeping.
		}

		/**
		 * Adds script data to registered components.
		 *
		 * @note This method implements the ability to add additional inline data to specific scripts.
		 *    As of v3.4, WordPress® is still lacking functions to interact w/ this feature.
		 *    Therefore, we'll need to access `$wp_scripts` directly.
		 *
		 * @param string|array $components A string, or an array of specific components that need `$data` (i.e. inline JavaScript code).
		 *
		 * @param string       $data The data (i.e. inline JavaScript code) that is needed by `$components`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function add_data($components, $data)
		{
			$this->check_arg_types(array('string', 'array'), 'string', func_get_args());

			$components = (array)$components; // Force array value.

			global $wp_scripts; // Global object reference.
			if(!($wp_scripts instanceof \WP_Scripts))
				$wp_scripts = new \WP_Scripts();

			foreach(($components = array_unique($components)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_script_is($_handle, 'registered'))
				{
					$existing_data = $wp_scripts->get_data($_handle, 'data');
					$wp_scripts->add_data($_handle, 'data', trim($existing_data."\n".$data));
				}
		}
	}
}