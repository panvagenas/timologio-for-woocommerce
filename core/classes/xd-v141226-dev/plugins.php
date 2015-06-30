<?php
/**
 * Plugin Utilities.
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
	 * Plugin Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class plugins extends framework
	{
		/**
		 * Performs loading sequence.
		 */
		public function load()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already loaded.

			$this->cache[__FUNCTION__] = -1;

			// Don't load the core.
			if($this->is_core()) return;

			// Fires hook before loading.
			$this->do_action('before_loaded');

			// Loads plugin.
			$this->load_classes_dir();
			$this->load_api_classes();
			$this->load_api_funcs();
			$this->load_pro_class();
			$this->load_packages();

			// Prepares plugin hooks.
			$this->©initializer->prepare_hooks();

			// Completes loading sequence.
			$this->do_action('loaded'); // We're loaded now.
			$this->do_action('after_loaded'); // Fully loaded now.
		}

		/**
		 * Loads plugin classes directory.
		 */
		public function load_classes_dir()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already attempted this once.

			$this->cache[__FUNCTION__] = -1;

			autoloader::add_classes_dir($this->instance->plugin_classes_dir);
		}

		/**
		 * Loads plugin API classes.
		 */
		public function load_api_classes()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already attempted this once.

			$this->cache[__FUNCTION__] = -1;

			if(is_file($this->instance->plugin_api_class_file))
				require_once $this->instance->plugin_api_class_file;

			// Define `plugin_root_ns{}` in an API class file if you wish to override these defaults.

			if(!class_exists('\\'.$this->instance->plugin_root_ns))
				$this->©php->¤eval('final class '.$this->instance->plugin_root_ns.' extends \\'.$this->instance->core_ns.'\\api{}');

			if(!class_exists('\\'.$this->instance->plugin_var_ns))
				$this->©php->¤eval('class_alias(\'\\'.$this->instance->plugin_root_ns.'\', \''.$this->instance->plugin_var_ns.'\');');
		}

		/**
		 * Loads plugin API functions.
		 */
		public function load_api_funcs()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already attempted this once.

			$this->cache[__FUNCTION__] = -1;

			// Define these in an API class file if you wish to override these defaults.

			if(!$this->©function->is_possible('\\'.$this->instance->plugin_root_ns))
				$this->©php->¤eval('function '.$this->instance->plugin_root_ns.'(){ return $GLOBALS[\''.$this->instance->plugin_root_ns.'\']; }');

			if(!$this->©function->is_possible('\\'.$this->instance->plugin_var_ns))
				$this->©php->¤eval('function '.$this->instance->plugin_var_ns.'(){ return $GLOBALS[\''.$this->instance->plugin_root_ns.'\']; }');

			if(!$this->©function->is_possible('\\'.$this->instance->plugin_root_ns.'_uninstall'))
				$this->©php->¤eval('function '.$this->instance->plugin_root_ns.'_uninstall(){ $GLOBALS[\''.$this->instance->plugin_root_ns.'\']->©installer->uninstall(); }');
		}

		/**
		 * Loads pro add-on class(es).
		 */
		public function load_pro_class()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already attempted this once.

			$this->cache[__FUNCTION__] = -1;

			if(!$this->has_pro_active()) return; // NOT active.

			if(($is_in_wp_debug_mode = $this->©env->is_in_wp_debug_mode()))
				require_once $this->instance->plugin_pro_class_file;
			else @include_once $this->instance->plugin_pro_class_file;

			if(!class_exists($pro_class = $this->instance->plugin_root_ns_prefix.'\\pro')
			   || empty($pro_class::${'for_plugin_version'}) || $pro_class::${'for_plugin_version'} !== $this->instance->plugin_version
			) $this->enqueue_update_sync_pro_notice(); // Needs to be synchronized w/ framework.

			else // Proceed. Create a pro variable reference & add its classes directory.
			{
				$GLOBALS[$this->instance->plugin_pro_var] = $GLOBALS[$this->instance->plugin_root_ns];
				autoloader::add_classes_dir($this->instance->plugin_pro_classes_dir);
			}
		}

		/**
		 * Loads active plugin packages.
		 */
		public function load_packages()
		{
			if(isset($this->cache[__FUNCTION__]))
				return; // Already attempted this once.

			$this->cache[__FUNCTION__] = -1;

			$packages_dir        = $this->©dir->packages();
			$is_in_wp_debug_mode = $this->©env->is_in_wp_debug_mode();

			foreach($this->©options->get('packages.active') as $_package_slug => $_package)
			{
				$_package_file = $packages_dir.'/'.$_package_slug.'/package.php';

				if($is_in_wp_debug_mode)
					require_once $_package_file;
				else @include_once $_package_file;
			}
			unset($_package_slug, $_package, $_package_file); // Houskeeping.
		}

		/**
		 * Collects an array of all currently active plugins.
		 *
		 * @note This also includes active sitewide plugins in a multisite installation.
		 *
		 * @return array All currently active plugins.
		 */
		public function active() // Active WordPress plugins.
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$active = (is_array($active = get_option('active_plugins'))) ? $active : array();
			if(is_multisite() && is_array($active_sitewide_plugins = get_site_option('active_sitewide_plugins')))
				$active = array_unique(array_merge($active, $active_sitewide_plugins));

			return ($this->static[__FUNCTION__] = $active);
		}

		/**
		 * Checks if the current plugin is active at the currently installed version.
		 *
		 * @param string $reconsider Optional. Empty string default (e.g. do NOT reconsider).
		 *    You MUST use class constant {@link fw_constants::reconsider} for this argument value.
		 *    If this is {@link fw_constants::reconsider}, we force a reconsideration.
		 *
		 * @return boolean TRUE if the current plugin is active at the currently installed version.
		 */
		public function is_active_at_current_version($reconsider = '')
		{
			$this->check_arg_types('string', func_get_args());

			if(!isset($this->cache[__FUNCTION__]) || $reconsider === $this::reconsider)
			{
				$this->cache[__FUNCTION__] = FALSE; // Initialize.
				if(($last_active_version = $this->last_active_version())
				   && version_compare($last_active_version, $this->instance->plugin_version, '>=')
				) $this->cache[__FUNCTION__] = TRUE;
			}
			return $this->cache[__FUNCTION__];
		}

		/**
		 * Gets the last active version of the current plugin.
		 *
		 * @note This is set by install/activation routines for the current plugin.
		 *    This method returns the last version that was successfully activated (i.e. fully active).
		 *
		 * @return string Last active version string, else an empty string.
		 */
		public function last_active_version()
		{
			return (string)get_option($this->instance->plugin_root_ns_stub.'__version');
		}

		/**
		 * Checks to see if the current plugin has it's pro add-on active.
		 *
		 * @return boolean TRUE if the current plugin has it's pro add-on active.
		 */
		public function has_pro_active()
		{
			return in_array($this->instance->plugin_pro_dir_file_basename, $this->active(), TRUE);
		}

		/**
		 * Checks to see if the current plugin has it's pro add-on loaded up.
		 *
		 * @return boolean TRUE if the current plugin has it's pro add-on loaded up.
		 */
		public function has_pro_loaded()
		{
			return $this->has_pro_active() && isset($GLOBALS[$this->instance->plugin_pro_var])
			       && $GLOBALS[$this->instance->plugin_pro_var] instanceof framework;
		}

		/**
		 * Enqueues pro update/sync notice.
		 *
		 * @note This does NOT perform any tests against the current framework and/or pro add-on.
		 *    Tests should be performed BEFORE calling upon this method. See {@link load_pro_class()}.
		 */
		public function enqueue_update_sync_pro_notice()
		{
			$this->©notice->enqueue( // Pro add-on needs to be synchronized with current version.
				'<p>'.$this->__('Your pro add-on MUST be updated now to keep all software running smoothly.').
				' '.sprintf($this->__('Please <a href="%1$s">click here</a> to update automatically.'), $this->©menu_page->url('update-sync', 'update-sync-pro')).
				'</p>'
			);
		}

		/**
		 * Filters site transients, to allow for custom ZIP files during plugin updates.
		 *
		 * @attaches-to WordPress® filter `pre_site_transient_update_plugins`.
		 * @filter-priority `10000` After most everything else.
		 *
		 * @param boolean|mixed $transient This is passed by WordPress® as a FALSE value (initially).
		 *    However, it could be filtered by other plugins, so we need to check for an array.
		 *
		 * @return object|boolean|mixed A modified object, else the original value.
		 */
		public function pre_site_transient_update_plugins($transient)
		{
			if(!is_admin() || !$this->©env->is_admin_page('update.php'))
				return $transient; // Nothing to do here.

			$plugin_update_version = $this->©vars->_REQUEST($this->instance->plugin_var_ns.'_update_version');
			$plugin_update_zip     = $this->©vars->_REQUEST($this->instance->plugin_var_ns.'_update_zip');

			if($this->©strings->are_not_empty($plugin_update_version, $plugin_update_zip))
			{
				if(!is_object($transient)) $transient = new \stdClass();

				$transient->last_checked                                        = time();
				$transient->checked[$this->instance->plugin_dir_file_basename]  = $this->instance->plugin_version;
				$transient->response[$this->instance->plugin_dir_file_basename] = (object)array(
					'id'          => 0, 'slug' => $this->instance->plugin_dir_basename,
					'url'         => $this->©menu_page->url('update-sync'),
					'new_version' => $plugin_update_version,
					'package'     => $plugin_update_zip
				);
			}
			$plugin_pro_update_version = $this->©vars->_REQUEST($this->instance->plugin_var_ns.'_pro_update_version');
			$plugin_pro_update_zip     = $this->©vars->_REQUEST($this->instance->plugin_var_ns.'_pro_update_zip');

			if($this->©strings->are_not_empty($plugin_pro_update_version, $plugin_pro_update_zip))
			{
				if(!is_object($transient)) $transient = new \stdClass();

				$transient->last_checked                                            = time();
				$transient->checked[$this->instance->plugin_pro_dir_file_basename]  = $this->instance->plugin_version;
				$transient->response[$this->instance->plugin_pro_dir_file_basename] = (object)array(
					'id'          => 0, 'slug' => $this->instance->plugin_pro_dir_basename,
					'url'         => $this->©menu_page->url('update-sync'),
					'new_version' => $plugin_pro_update_version,
					'package'     => $plugin_pro_update_zip
				);
			}
			return $transient; // Possibly modified now.
		}

		/**
		 * Updates plugin site credentials (i.e. username/password for the plugin site).
		 *
		 * @param string $username Username for the plugin site.
		 *
		 * @param string $password Password for the plugin site (plain text).
		 *    This is encrypted before we store it in the database.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function set_site_credentials($username, $password)
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$credentials = array(
				'plugin_site.username' => $username,
				'plugin_site.password' => $this->©encryption->encrypt($password)
			);
			$this->©options->update($credentials);
		}

		/**
		 * Gets plugin site credentials (i.e. username/password for the plugin site).
		 *
		 * @param string  $username Optional. A new (i.e. recently submitted) username for the plugin site.
		 *
		 * @param string  $password Optional. A new (i.e. recently submitted) password for the plugin site (plain text).
		 *
		 * @param boolean $update Optional. This defaults to a FALSE value.
		 *    If this is TRUE, and `$username` or `$password` are passed in, we'll update the database with the new values.
		 *
		 * @return array Array containing two elements: `username`, `password` (plain text).
		 */
		public function get_site_credentials($username = '', $password = '', $update = FALSE)
		{
			$this->check_arg_types('string', 'string', 'boolean', func_get_args());

			$credentials = array(
				'username' => $this->©options->get('plugin_site.username'),
				'password' => $this->©encryption->decrypt($this->©options->get('plugin_site.password'))
			);
			if($username || $password) // Have new (i.e. recently submitted) values?
			{
				if($username) $credentials['username'] = $username;
				if($password) $credentials['password'] = $password;

				if($update) // Now, are we updating to these new values?
					$this->set_site_credentials($credentials['username'], $credentials['password']);
			}
			return $credentials; // Two elements: `username`, `password`.
		}

		/**
		 * Updates framework.
		 *
		 * @param string $username Optional. Plugin site username. Defaults to an empty string.
		 *    This is ONLY required if the underlying plugin site requires it.
		 *
		 * @param string $password Optional. Plugin site password. Defaults to an empty string.
		 *    This is ONLY required if the underlying plugin site requires it.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®update($username = '', $password = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!$this->©errors->exist_in($response = $this->©url->to_plugin_update_via_wp($username, $password)))
				$url = $response; // We got the update URL.
			else $errors = $response;

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());

			if(!empty($url)) // We got the update URL. Perform the update now.
				wp_redirect($url).exit();
		}

		/**
		 * Updates (and synchronizes) pro add-on.
		 *
		 * @param string $username Optional. Plugin site username. Defaults to an empty string.
		 *    This is ONLY required if the underlying plugin site requires it.
		 *
		 * @param string $password Optional. Plugin site password. Defaults to an empty string.
		 *    This is ONLY required if the underlying plugin site requires it.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®update_sync_pro($username = '', $password = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!$this->©errors->exist_in($response = $this->©url->to_plugin_pro_update_via_wp($username, $password)))
				$url = $response; // We got the update URL.
			else $errors = $response;

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());

			if(!empty($url)) // We got the update URL. Perform the update now.
				wp_redirect($url).exit();
		}

		/**
		 * The XDaRk Core itself?
		 *
		 * @return boolean TRUE if the current plugin is actually the XDaRk Core.
		 */
		public function is_core() // The XDaRk Core itself?
		{
			return ($this->instance->plugin_root_ns === $this->instance->core_ns);
		}

		/**
		 * Sets selective loading status for front-side styles.
		 *
		 * @param boolean $needs TRUE if the plugin needs front-side styles (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable front-side styles.
		 *
		 * @param string  $theme Optional. Defaults to an empty string.
		 *    If passed in, a specific UI theme will be enqueued or dequeued (depending on `$needs`).
		 */
		public function needs_front_side_styles($needs, $theme = '')
		{
			$this->check_arg_types('boolean', 'string', func_get_args());

			$filter = ($needs) ? '__return_true' : '__return_false';
			remove_all_filters($this->instance->plugin_root_ns_stub.'__styles__front_side');
			add_filter($this->instance->plugin_root_ns_stub.'__styles__front_side', $filter);

			$components = $this->©styles->front_side_components;
			if($theme && in_array($theme, array_keys($this->©styles->themes()), TRUE))
				$components[] = $this->instance->core_ns_with_dashes.'--'.$theme;
			// A specific theme will be enqueued or dequeued (depending on `$needs`).

			if($needs) // Enqueue or dequeue.
				$this->©styles->enqueue($components);
			else $this->©styles->dequeue($components);
		}

		/**
		 * Sets selective loading status for stand-alone styles.
		 *
		 * @param boolean $needs TRUE if the plugin needs stand-alone styles (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable stand-alone styles.
		 *
		 * @param string  $theme Optional. Defaults to an empty string.
		 *    If passed in, a specific UI theme will be enqueued or dequeued (depending on `$needs`).
		 */
		public function needs_stand_alone_styles($needs, $theme = '')
		{
			$this->check_arg_types('boolean', 'string', func_get_args());

			$filter = ($needs) ? '__return_true' : '__return_false';
			remove_all_filters($this->instance->plugin_root_ns_stub.'__styles__stand_alone');
			add_filter($this->instance->plugin_root_ns_stub.'__styles__stand_alone', $filter);

			$components = $this->©styles->stand_alone_components;
			if($theme && in_array($theme, array_keys($this->©styles->themes()), TRUE))
				$components[] = $this->instance->core_ns_with_dashes.'--'.$theme;
			// A specific theme will be enqueued or dequeued (depending on `$needs`).

			if($needs) // Enqueue or dequeue.
				$this->©styles->enqueue($components);
			else $this->©styles->dequeue($components);
		}

		/**
		 * Sets selective loading status for front-side scripts.
		 *
		 * @param boolean $needs TRUE if the plugin needs front-side scripts (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable front-side scripts.
		 */
		public function needs_front_side_scripts($needs)
		{
			$this->check_arg_types('boolean', func_get_args());

			$filter = ($needs) ? '__return_true' : '__return_false';
			remove_all_filters($this->instance->plugin_root_ns_stub.'__scripts__front_side');
			add_filter($this->instance->plugin_root_ns_stub.'__scripts__front_side', $filter);

			if($needs) // Enqueue or dequeue (based on `$needs`).
				$this->©scripts->enqueue($this->©scripts->front_side_components);
			else $this->©scripts->dequeue($this->©scripts->front_side_components);
		}

		/**
		 * Sets selective loading status for stand-alone scripts.
		 *
		 * @param boolean $needs TRUE if the plugin needs stand-alone scripts (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable stand-alone scripts.
		 */
		public function needs_stand_alone_scripts($needs)
		{
			$this->check_arg_types('boolean', func_get_args());

			$filter = ($needs) ? '__return_true' : '__return_false';
			remove_all_filters($this->instance->plugin_root_ns_stub.'__scripts__stand_alone');
			add_filter($this->instance->plugin_root_ns_stub.'__scripts__stand_alone', $filter);

			if($needs) // Enqueue or dequeue (based on `$needs`).
				$this->©scripts->enqueue($this->©scripts->stand_alone_components);
			else $this->©scripts->dequeue($this->©scripts->stand_alone_components);
		}

		/**
		 * Sets selective loading status for stand-alone scripts/styles (both at the same time).
		 *
		 * @param boolean $needs TRUE if the plugin needs stand-alone scripts/styles (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable stand-alone scripts/styles.
		 *
		 * @param string  $theme Optional. Defaults to an empty string.
		 *    If passed in, a specific UI theme will be enqueued or dequeued (depending on `$needs`).
		 */
		public function needs_stand_alone_styles_scripts($needs, $theme = '')
		{
			$this->check_arg_types('boolean', 'string', func_get_args());

			$this->needs_stand_alone_styles($needs, $theme);
			$this->needs_stand_alone_scripts($needs);
		}

		/**
		 * Sets selective loading status for front-side scripts/styles (both at the same time).
		 *
		 * @param boolean $needs TRUE if the plugin needs front-side scripts/styles (or FALSE if it does NOT need them).
		 *    The internal default is FALSE. This MUST be set to TRUE to enable front-side scripts/styles.
		 *
		 * @param string  $theme Optional. Defaults to an empty string.
		 *    If passed in, a specific UI theme will be enqueued or dequeued (depending on `$needs`).
		 */
		public function needs_front_side_styles_scripts($needs, $theme = '')
		{
			$this->check_arg_types('boolean', 'string', func_get_args());

			$this->needs_front_side_styles($needs, $theme);
			$this->needs_front_side_scripts($needs);
		}
	}
}