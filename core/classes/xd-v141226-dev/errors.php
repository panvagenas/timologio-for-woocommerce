<?php
/**
 * Errors.
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
	 * Errors.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class errors extends diagnostics
	{
		/**
		 * @var string Diagnostic type.
		 */
		public $type = 'error';

		/**
		 * @var boolean Log to a DEBUG file?
		 */
		public $wp_debug_log = TRUE;

		/**
		 * @var boolean Log into a DB table?
		 */
		public $db_log = TRUE;
	}
}