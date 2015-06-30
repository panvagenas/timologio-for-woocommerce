<?php
/**
 * CRON Jobs.
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
	 * CRON Jobs.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class crons extends framework
	{
		/**
		 * Handles loading sequence.
		 *
		 * @attaches-to WordPress® `wp_loaded` action hook.
		 * @hook-priority `10000` After most everything else; but before other hooks that configure CRONs.
		 *    Other `wp_loaded` hooks that setup CRON jobs could just use `10010`.
		 */
		public function wp_loaded()
		{
			$this->add_filter('cron_schedules', '©crons.extend');
			if($this->©env->is_cron_job()) $this->©env->prep_for_cron_procedure();
		}

		/**
		 * Extends CRON schedules to support additional frequencies.
		 *
		 * @attaches-to WordPress® filter `cron_schedules`.
		 * @hook-priority Default is fine.
		 *
		 * @param array $schedules Expects an array of schedules, passed in by the WordPress® filter.
		 *
		 * @return array Modified array of CRON schedules.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function extend($schedules)
		{
			$this->check_arg_types('array', func_get_args());

			$new_schedules = array // New schedules.
			(
			                       'every5m'  => array(
				                       'interval' => 300,
				                       'display'  => $this->__('Every 5 Minutes')
			                       ),
			                       'every15m' => array(
				                       'interval' => 900,
				                       'display'  => $this->__('Every 15 Minutes')
			                       ),
			                       'every30m' => array(
				                       'interval' => 1800,
				                       'display'  => $this->__('Every 30 Minutes')
			                       )
			);
			return array_merge($schedules, $new_schedules);
		}

		/**
		 * Configures CRON job events with WordPress®.
		 *
		 * @param array $cron_jobs An array of CRON jobs to configure.
		 *
		 * @return integer The number of new CRON jobs configured by this routine.
		 *    Returns `0` if nothing was new (e.g. all CRONs already configured properly).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If any CRON job fails validation.
		 */
		public function config($cron_jobs)
		{
			$this->check_arg_types('array', func_get_args());

			$schedules      = array_keys(wp_get_schedules());
			$config         = $this->©options->get('crons.config');
			$configurations = 0; // Initialize to zero.

			foreach($cron_jobs as $_key => $_cron_job) // Main loop. Inspect each of these.
			{
				if( // Each CRON job MUST pass the following validators; else throw exception.
					!is_array($_cron_job) || !$this->©string->is_not_empty($_cron_job['©class.method'])
					|| substr_count($_cron_job['©class.method'], '©') !== 1 || substr_count($_cron_job['©class.method'], '.') !== 1
					|| !$this->©string->is_not_empty($_cron_job['schedule']) || !in_array($_cron_job['schedule'], $schedules, TRUE)
				) throw $this->©exception($this->method(__FUNCTION__).'#invalid_cron_job', get_defined_vars(),
				                          $this->__('Invalid CRON job (missing and/or invalid array keys).').
				                          ' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_cron_job))
				);
				$_key = $_cron_job['©class.method']; // Using this as: `$config[$_key]`.
				list($_cron_job['©class'], $_cron_job['method']) = explode('.', $_cron_job['©class.method'], 2);
				$_cron_job['event_hook'] = '_cron__'.$this->instance->plugin_root_ns_stub.'__'.trim($_cron_job['©class'], '©').'__'.$_cron_job['method'];

				$this->add_action($_cron_job['event_hook'], $_cron_job['©class.method']);

				if(!empty($config[$_key]['last_config_time']))
					$_cron_job['last_config_time'] = (integer)$config[$_key]['last_config_time'];
				else $_cron_job['last_config_time'] = 0;

				if(!$_cron_job['last_config_time']
				   || $_cron_job['schedule'] !== $this->©string->is_not_empty_or($config[$_key]['schedule'], '')
				) // If it's NEVER been configured, or if it's schedule has been changed in some way.
				{
					wp_clear_scheduled_hook($_cron_job['event_hook']);
					wp_schedule_event(time() + mt_rand(300, 18000), $_cron_job['schedule'], $_cron_job['event_hook']);

					$_cron_job['last_config_time'] = time();
					$config[$_key]                 = $_cron_job;
					$this->©options->update(array('crons.config' => $config));

					$configurations++; // Increment.
				}
			}
			unset($_key, $_cron_job); // Housekeeping.

			return $configurations; // If any.
		}

		/**
		 * Deletes CRON job events for the current plugin.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns `0`.
		 *
		 * @param array   $cron_jobs Optional. Defaults to an empty array.
		 *    If this is passed in, and it's NOT empty, we'll ONLY delete CRON jobs in this array.
		 *    Otherwise, by default, all CRON jobs are deleted here.
		 *
		 * @return integer The number of CRON jobs deleted by this routine.
		 *    Returns `0` if nothing was deleted (e.g. no CRON jobs were configured).
		 *    Also returns `0` if `$confirmation` was NOT a TRUE value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function delete($confirmation = FALSE, $cron_jobs = array())
		{
			$this->check_arg_types('boolean', 'array', func_get_args());

			if(!$confirmation) return 0; // Added security.

			$deletions = 0; // Initialize to zero (NO deletions thus far).

			$cron_job_keys = $this->©array->compile_key_elements_deep($cron_jobs, '©class.method');

			foreach(($config = $this->©options->get('crons.config')) as $_key => $_cron_job)
				if(empty($cron_job_keys) || in_array($_key, $cron_job_keys, TRUE))
				{
					if(is_array($_cron_job) // Make sure this IS an array.
					   && $this->©string->is_not_empty($_cron_job['event_hook'])
					) // Delete (i.e. clear) the scheduled CRON job event hook.
						wp_clear_scheduled_hook($_cron_job['event_hook']);

					unset($config[$_key]); // Delete from `$config`.

					$deletions++; // Increment.
				}
			unset($_key, $_cron_job); // Housekeeping.

			$this->©options->update(array('crons.config' => $config));

			return $deletions; // Total deletions.
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

			$this->delete(TRUE);

			return TRUE;
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

			$this->delete(TRUE);

			return TRUE;
		}
	}
}