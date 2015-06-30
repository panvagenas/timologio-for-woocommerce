<?php
/**
 * Initializer.
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
	 * Initializer.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class initializer extends framework
	{
		/**
		 * Prepares initialization routines/hooks.
		 *
		 * @note This is called during the plugin loading phase;
		 *    i.e. as the plugin is being loaded by the core.
		 */
		public function prepare_hooks()
		{
			$this->register_installer_hooks(); // Registers several installer hooks.
			$this->add_action('after_setup_theme', '©initializer.after_setup_theme', -10000);
		}

		/**
		 * Initialization routines/hooks.
		 *
		 * @attaches-to WordPress® `after_setup_theme`.
		 * @hook-priority `-10000` Before most everything else.
		 */
		public function after_setup_theme()
		{
			if(!$this->©plugin->is_active_at_current_version())
				$this->©installer->activation(); // Activate.

			if(!$this->©plugin->is_active_at_current_version())
				return; // Do NOT go any further here.

			$this->add_action('init', '©no_cache.init', -10000);
			$this->add_action('init', '©db_cache.init', -10000);

			$this->add_action('wp_loaded', '©actions.wp_loaded', -10000);
			$this->add_action('wp_loaded', '©crons.wp_loaded', 10000);
			$this->add_action('wp_loaded', '©db_utils.wp_loaded_crons', 10010);

			$this->add_action('wp_print_scripts', '©scripts.wp_print_scripts', 9);
			$this->add_action('wp_print_styles', '©styles.wp_print_styles', 9);

			$this->add_action('admin_print_scripts', '©scripts.admin_print_scripts', 9);
			$this->add_action('admin_print_styles', '©styles.admin_print_styles', 9);

			$this->add_action('admin_menu', '©menu_pages.admin_menu');
			$this->add_action('network_admin_menu', '©menu_pages.network_admin_menu');

			$this->add_action('all_admin_notices', '©notices.all_admin_notices');

            $this->add_action('widgets_init', '©initializer.register_widgets');

			if(!isset($this->static[__FUNCTION__]['urls.http_api_debug']) && $this->©env->is_in_wp_debug_mode())
			{
				$this->static[__FUNCTION__]['urls.http_api_debug'] = 'urls.http_api_debug';
				$this->add_action('http_api_debug', '©urls.http_api_debug', 10000, 5);
			}
			if($this->©edd_updater->isEDD()){
				$this->add_action('admin_init', '©edd_updater.init');
			} else {
				$this->add_filter('pre_site_transient_update_plugins', '©plugins.pre_site_transient_update_plugins', 10000);
			}

			$this->after_setup_theme_hooks(); // Additional hooks/filters needed by an extender.
			$this->do_action('after_setup_theme_hooks'); // Additional hooks/filters.
		}

		/**
		 * Add any additional hooks/filters needed by an extender.
		 *
		 * @extenders This should be overwritten by class extenders (when/if needed).
		 */
		public function after_setup_theme_hooks()
		{
		}

        /**
         * Register widgets
         * @example Function body example: register_widget('\xdark\widget');
         * @extenders Overwrite this to register your widgets
         */
        public function register_widgets(){
        }

		/**
		 * These CANNOT be attached to a hook. Hooks are fired before a plugin is loaded upon activation.
		 *    See: <http://codex.wordpress.org/Function_Reference/register_activation_hook>
		 */
		public function register_installer_hooks()
		{
			register_activation_hook($this->instance->plugin_dir_file_basename, array($this, '©installer.activation'));
			register_deactivation_hook($this->instance->plugin_dir_file_basename, array($this, '©installer.deactivation'));
			register_uninstall_hook($this->instance->plugin_dir_file_basename, $this->instance->plugin_root_ns.'_uninstall');
		}
	}
}