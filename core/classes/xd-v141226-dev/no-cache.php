<?php
/**
 * No-Cache Utilities.
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
	 * No-Cache Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class no_cache extends framework
	{

		/**
		 * Handles no-cache headers/constants.
		 *
		 * @attaches-to WordPress® `init` action hook.
		 * @hook-priority `-10000` Before most everything else.
		 */
		public function init()
		{
			if(is_admin())
			{
				$this->headers($this::reason_is_admin);
				$this->constants($this::reason_is_admin);
			}
			else if($this->©env->is_systematic_routine())
			{
				$this->headers($this::reason_is_systematic_routine);
				$this->constants($this::reason_is_systematic_routine);
			}
			else if($this->©user->is_logged_in())
			{
				$this->headers($this::reason_is_logged_in);
				$this->constants($this::reason_is_logged_in);
			}
			else if($this->©action->is())
			{
				$this->headers($this::reason_is_action);
				$this->constants($this::reason_is_action);
			}
			else if($this->©options->get('no_cache.headers.always'))
				$this->headers($this::reason_is_option);
		}

		/**
		 * Sends no-cache headers.
		 *
		 * @param string $reason Optional; specify a reason why.
		 *    Use a framework constant for this parameter.
		 */
		public function headers($reason = self::reason_other)
		{
			if(isset($this->static[__FUNCTION__][$reason]))
				return; // Already done.

			$this->static[__FUNCTION__][$reason] = -1;

			$has_qc_active = $this->©env->has_qc_active();
			if($has_qc_active && $this->©string->is_true($this->©vars->_REQUEST('qcABC')))
				return; // Respect Quick Cache `?qcABC` variable.

			$this->©headers->no_cache();
		}

		/**
		 * Sets no-cache constants.
		 *
		 * @param string $reason Optional; specify a reason why.
		 *    Use a framework constant for this parameter.
		 */
		public function constants($reason = self::reason_other)
		{
			if(isset($this->static[__FUNCTION__][$reason]))
				return; // Already done.

			$this->static[__FUNCTION__][$reason] = -1;

			$has_qc_active = $this->©env->has_qc_active();
			if($has_qc_active && $this->©string->is_true($this->©vars->_REQUEST('qcAC')))
				return; // Respect Quick Cache `?qcAC` variable.

			if($has_qc_active && $reason === $this::reason_is_logged_in)
				if(defined('QUICK_CACHE_WHEN_LOGGED_IN') && QUICK_CACHE_WHEN_LOGGED_IN)
					return; // Allow Quick Cache to do its thing here.

			if(!defined('DONOTCACHEDB'))
				/**
				 * @var boolean For cache plugins.
				 */
				define ('DONOTCACHEDB', TRUE);

			if(!defined('DONOTCACHEPAGE'))
				/**
				 * @var boolean For cache plugins.
				 */
				define ('DONOTCACHEPAGE', TRUE);

			if(!defined('DONOTCACHEOBJECT'))
				/**
				 * @var boolean For cache plugins.
				 */
				define ('DONOTCACHEOBJECT', TRUE);

			if(!defined('QUICK_CACHE_ALLOWED'))
				/**
				 * @var boolean For Quick Cache.
				 */
				define ('QUICK_CACHE_ALLOWED', FALSE);
		}
	}
}