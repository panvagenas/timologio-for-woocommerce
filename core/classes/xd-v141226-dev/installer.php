<?php
/**
 * Installation Utilities.
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
	 * Installation Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class installer extends framework
	{
		/**
		 * Handles activation and/or re-activation routines.
		 *
		 * @attaches-to WordPress® `register_activation_hook`, for the current plugin.
		 * @hook-priority Irrelevant. WordPress® deals with this automatically.
		 *
		 * @attaches-to WordPress® `setup_theme`, for the current plugin.
		 * @hook-priority `-10000` before most everything else.
		 */
		public function activation()
		{
			if(!isset($this->cache[__FUNCTION__]))
				$this->cache[__FUNCTION__] = 0;

			$this->cache[__FUNCTION__]++; // Increment call counter.
			if($this->cache[__FUNCTION__] > 1 /* More than ONE time? */)
				return; // Only run this routine ONE time.

			wp_get_current_user(); // Make sure WP has this.
			$reactivating = $this->©plugin->last_active_version();

			if( // Run all activation routines.

				$this->©dirs->___activate___(TRUE)
				&& $this->©options->___activate___(TRUE)
				&& $this->©db_utils->___activate___(TRUE)
				&& $this->©db_cache->___activate___(TRUE)
				&& $this->©db_tables->___activate___(TRUE)
				&& $this->©notices->___activate___(TRUE)
				&& $this->©crons->___activate___(TRUE)
				&& $this->activations() // Extenders.

			) // Activation success! Everything TRUE here.
			{
				update_option($this->instance->plugin_root_ns_stub.'__version', $this->instance->plugin_version);
				$this->©plugin->is_active_at_current_version($this::reconsider);
				if($this->©plugin->©edd_updater->isEDD() && $this->©plugin->©edd_updater->hasDemo()){
					$this->©plugin->©edd_updater->startDemo();
				}

				$this->©notice->enqueue( // A complete success.
					'<p>'.
					sprintf($this->__('%1$s was a complete success<em>!</em> Current version: <strong>%2$s</strong>.'),
						(($reactivating) ? $this->__('Reactivation') : $this->__('Activation')), $this->instance->plugin_version).
					'</p>'
				);
			}
			else // The activation failed for some reason.
			{
				$this->©notice->error_enqueue( // Error in some way.
					'<p>'.
					sprintf($this->__('%1$s failed (please try again). Or, contact the developer if you need assistance.'),
						(($reactivating) ? $this->__('Reactivation') : $this->__('Activation'))).
					'</p>'
				);
			}
		}

		/**
		 * Any additional activation routines.
		 *
		 * @extenders This should be overwritten by class extenders (when/if needed).
		 *
		 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
		 */
		public function activations()
		{
			return TRUE; // Indicate success.
		}

		/**
		 * Handles deactivation routines.
		 *
		 * @attaches-to WordPress® `register_deactivation_hook`, for the current plugin.
		 * @hook-priority Irrelevant. WordPress® deals with this automatically.
		 */
		public function deactivation()
		{
			if(!isset($this->cache[__FUNCTION__]))
				$this->cache[__FUNCTION__] = 0;

			$this->cache[__FUNCTION__]++; // Increment call counter.
			if($this->cache[__FUNCTION__] > 1 /* More than ONE time? */)
				return; // Only run this routine ONE time.

			$this->remove_all_actions()
			&& $this->remove_all_filters();
			$this->deactivations(); // Extenders.
		}

		/**
		 * Any additional deactivation routines.
		 *
		 * @extenders This should be overwritten by class extenders (when/if needed).
		 *
		 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
		 */
		public function deactivations()
		{
			return TRUE; // Indicate success.
		}

		/**
		 * Handles uninstall routines.
		 *
		 * @attaches-to WordPress® `register_uninstall_hook`, for the current plugin.
		 * @hook-priority Irrelevant. WordPress® deals with this automatically.
		 */
		public function uninstall()
		{
			if(!isset($this->cache[__FUNCTION__]))
				$this->cache[__FUNCTION__] = 0;

			$this->cache[__FUNCTION__]++; // Increment call counter.
			if($this->cache[__FUNCTION__] > 1 /* More than ONE time? */)
				return; // Only run this routine ONE time.

			$this->remove_all_actions()
			&& $this->remove_all_filters();
			$this->uninstallations(); // Extenders.
			$this->©crons->___uninstall___(TRUE);
			$this->©notices->___uninstall___(TRUE);
			$this->©db_tables->___uninstall___(TRUE);
			$this->©db_cache->___uninstall___(TRUE);
			$this->©db_utils->___uninstall___(TRUE);
			$this->©options->___uninstall___(TRUE);
			$this->©dirs->___uninstall___(TRUE);
			deps::___uninstall___(TRUE);

			delete_option($this->instance->plugin_root_ns_stub.'__version');
			$this->©plugin->is_active_at_current_version($this::reconsider);
		}

		/**
		 * Any additional uninstall routines.
		 *
		 * @extenders This should be overwritten by class extenders (when/if needed).
		 *
		 * @return boolean TRUE if all routines were successful, else FALSE if there were any failures.
		 */
		public function uninstallations()
		{
			return TRUE; // Indicate success.
		}
	}
}