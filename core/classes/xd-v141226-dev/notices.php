<?php
/**
 * Notice Utilities.
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
	 * Notice Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class notices extends framework
	{
		/**
		 * Enqueues an administrative notice.
		 *
		 * @param string|array $notice The notice itself (i.e. a string message).
		 *    Or, an array with notice configuration parameters.
		 *
		 * @return boolean TRUE if the notice was enqueued.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function enqueue($notice)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			// Force array.
			if(!is_array($notice))
				$notice = array('notice' => $notice);

			// Check for empty notices.
			if(!$this->©string->is_not_empty($notice['notice']))
				return FALSE; // Nothing to enqueue.

			// Gather notices/dismissals.
			if(!is_array($notices = get_option($this->instance->plugin_root_ns_stub.'__notices')))
				update_option($this->instance->plugin_root_ns_stub.'__notices', ($notices = array()));

			if(!is_array($dismissals = get_option($this->instance->plugin_root_ns_stub.'__notice__dismissals')))
				add_option($this->instance->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

			// Standardize & add to array of enqueued notices.
			$notice = $this->standardize($notice);

			// This notice is already enqueued?
			if(isset($notices[$notice['checksum']]))
				return FALSE; // Nothing more to do here.

			// Enqueue this notice, ONLY if we're NOT allowing dismissals.
			// Or, if we ARE allowing dismissals, but this has NOT been dismissed yet.
			if(!$notice['allow_dismissals'] || !in_array($notice['checksum'], $dismissals, TRUE))
			{
				$notices[$notice['checksum']] = $notice;
				update_option($this->instance->plugin_root_ns_stub.'__notices', $notices);
				return TRUE;
			}
			return FALSE; // Default return value.
		}

		/**
		 * Enqueues an administrative error notice.
		 *
		 * @param string|array $notice The notice itself (i.e. a string message).
		 *    Or, an array with notice configuration parameters.
		 *
		 * @return boolean TRUE if the notice was enqueued.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function error_enqueue($notice)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			if(!is_array($notice))
				$notice = array('notice' => $notice);
			$notice['error'] = TRUE;

			return $this->enqueue($notice);
		}

		/**
		 * Displays an administrative notice.
		 *
		 * @param string|array $notice The notice itself (i.e. a string message).
		 *    Or, an array with notice configuration parameters.
		 *
		 * @return boolean TRUE if the notice is displayed.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function display($notice)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			// Not in an administrative area?
			if(!is_admin()) return FALSE; // Do NOT display.

			// Force array.
			if(!is_array($notice))
				$notice = array('notice' => $notice);

			// Check for empty notices.
			if(!$this->©string->is_not_empty($notice['notice']))
				return FALSE; // Nothing to display.

			// Standardize this notice.
			$notice = $this->standardize($notice);

			if($notice['with_prefix']) // Adding a prefix?
			{
				$icon = ''; // Default. Assume we are NOT displaying an icon.

				if($notice['with_prefix_icon']) // A prefix icon?
					$icon = '<i class="'.esc_attr($notice['with_prefix_icon']).'"></i> ';

				if(stripos($notice['notice'], '<p>') === 0)
				{
					$notice['notice'] = substr($notice['notice'], 3);
					if(isset($notice['notice'][0]) && ctype_upper($notice['notice'][0]))
						$notice['notice'][0] = strtolower($notice['notice'][0]);

					$notice['notice'] = '<p class="no-t-margin">'.$icon.'<strong>'.$this->instance->plugin_name.' '.$this->__('says...').'</strong> '.$notice['notice'];
				}
				else // It doesn't start with a `<p>` tag, so we'll do the best we can here.
				{
					if(isset($notice['notice'][0]) && ctype_upper($notice['notice'][0]))
						$notice['notice'][0] = strtolower($notice['notice'][0]);

					$notice['notice'] = '<p class="no-t-margin">'.$icon.'<strong>'.$this->instance->plugin_name.' '.$this->__('says...').'</strong></p>'.$notice['notice'];
				}
			}
			if($notice['allow_dismissals']) // Allowing dismissals?
			{
				if(!is_array($dismissals = get_option($this->instance->plugin_root_ns_stub.'__notice__dismissals')))
					add_option($this->instance->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

				if(in_array($notice['checksum'], $dismissals, TRUE))
					return FALSE; // Already dismissed this notice.

				$dismiss = array($this->instance->plugin_root_ns_stub.'__notice__dismiss' => $notice['checksum']);
				$dismiss = add_query_arg(urlencode_deep($dismiss), $this->©url->current_uri());

				$notice['notice'] .= ' [ <a href="'.$dismiss.'">'.$this->__('dismiss this message').'</a> ]';
			}
			if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), array_keys($this->©styles->themes()), TRUE))
				$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

			$classes[] = $this->instance->core_ns_with_dashes;
			$classes[] = $this->instance->plugin_root_ns_with_dashes;

			$classes[] = $this->instance->core_ns_with_dashes.'--t--'.$current_menu_pages_theme;
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--t--'.$current_menu_pages_theme;

			echo '<div class="'.esc_attr(implode(' ', $classes)).'">'.
			     '<div class="notice no-l-margin t-margin em-padding clearfix'. // WP `fade` class clashes w/ Bootstrap.
			     ' '.(($notice['error']) ? 'error' : 'updated').' alert alert-'.(($notice['error']) ? 'danger' : 'info').'"'.
			     '>'. // With WordPress® styles (and also w/ UI theme styles).

			     $notice['notice']. // HTML markup.

			     '</div>'.
			     '</div>';
			return TRUE; // Notice displayed indicator.
		}

		/**
		 * Handles `all_admin_notices` hook in WordPress®.
		 *
		 * Runs through all notices in the queue, and displays those which should be displayed.
		 *
		 * @note Notices are removed from the queue by this routine (automatically).
		 *
		 * @return boolean TRUE if any notices are displayed.
		 *
		 * @attaches-to `all_admin_notices` action hook.
		 * @hook-priority Default is fine.
		 */
		public function all_admin_notices()
		{
			// Not in an administrative area?
			if(!is_admin()) return FALSE; // Do NOT process.

			// Establish current area/page.
			$current_area = $this->©env->admin_area();
			$current_page = $this->©env->admin_page();

			// Gather notices/dismissals.
			if(!is_array($notices = get_option($this->instance->plugin_root_ns_stub.'__notices')))
				update_option($this->instance->plugin_root_ns_stub.'__notices', ($notices = array()));

			if(!is_array($dismissals = get_option($this->instance->plugin_root_ns_stub.'__notice__dismissals')))
				add_option($this->instance->plugin_root_ns_stub.'__notice__dismissals', ($dismissals = array()), '', 'no');

			// Possible dismissal via query string.
			$current_dismissal = $this->©vars->_REQUEST($this->instance->plugin_root_ns_stub.'__notice__dismiss');

			// Initialize a few variables.
			$notices_require_update = $dismissals_require_update = $notices_displayed = FALSE;

			// Process the notice queue now.
			foreach($notices as $_checksum => $_notice) // Here we check on several things.
			{
				if(empty($_notice['in_areas']) || $this->©string->in_wildcard_patterns($current_area, $_notice['in_areas']))
					if(empty($_notice['on_pages']) || $this->©string->in_wildcard_patterns($current_page, $_notice['on_pages']))
						if(empty($_notice['on_time']) || strtotime('now') >= $_notice['on_time'])
						{
							$_has_been_dismissed = FALSE; // Initialize FALSE value.

							if($_notice['allow_dismissals']) // Allow dismissals?
							{
								if(in_array($_notice['checksum'], $dismissals, TRUE))
									$_has_been_dismissed = TRUE;

								else if($current_dismissal === $_notice['checksum'])
									$_has_been_dismissed = TRUE; // Dismissing now.
							}
							if(!empty($_notice['notice']) && !$_has_been_dismissed) // Should display?
							{
								if($this->display($_notice)) // Did display?
									$notices_displayed = TRUE;
							}
							if(!$_notice['allow_dismissals'] || $_has_been_dismissed) // Dismiss?
							{
								unset($notices[$_checksum]);
								$notices_require_update = TRUE;

								if($_has_been_dismissed)
								{
									$dismissals_require_update = TRUE;
									$dismissals[]              = $_notice['checksum'];
								}
							}
						}
			}
			unset($_checksum, $_notice, $_has_been_dismissed); // Housekeeping.

			if($notices_require_update)
				update_option($this->instance->plugin_root_ns_stub.'__notices', $notices);

			if($dismissals_require_update)
				update_option($this->instance->plugin_root_ns_stub.'__notice__dismissals', array_unique($dismissals));

			return ($notices_displayed) ? TRUE : FALSE;
		}

		/**
		 * Standardizes a notice configuration array.
		 *
		 * @param array $notice An array of notice configuration parameters.
		 *
		 * @return array Standardized array of notice configuration parameters.
		 */
		public function standardize($notice)
		{
			$this->check_arg_types('array', func_get_args());

			$default_notice     = array(
				'notice'           => '',
				'error'            => FALSE,
				'on_pages'         => array(),
				'in_areas'         => array(),
				'on_time'          => 0,
				'with_prefix'      => TRUE,
				'with_prefix_icon' => !empty($notice['error'])
					? 'fa fa-exclamation-triangle' : 'fa fa-comments-o',
				'allow_dismissals' => FALSE,
				'checksum'         => '' // Determined below.
			);
			$notice             = $this->check_extension_arg_types(
				'string', 'boolean', 'array', 'array', 'integer', 'boolean', 'string', 'boolean', 'string',
				$default_notice, $notice
			);
			$notice             = $this->©array->ksort_deep($notice, SORT_STRING);
			$notice['checksum'] = md5(serialize($notice));

			return $notice; // Standardized now.
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
		public function ___activate___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation)
				return FALSE; // Added security.

			return TRUE; // Nothing here (at least for now).
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
		public function ___uninstall___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation)
				return FALSE; // Added security.

			delete_option($this->instance->plugin_root_ns_stub.'__notices');
			delete_option($this->instance->plugin_root_ns_stub.'__notice__dismissals');

			return TRUE;
		}
	}
}