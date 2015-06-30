<?php
/**
 * Exception.
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
	 * Exception.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 */
	class exception extends \exception // Allow extenders.
	{
		/**
		 * @var boolean Enable debug file logging?
		 * @extenders Can be overridden by class extenders.
		 */
		public $wp_debug_log = TRUE;

		/**
		 * @var boolean Enable DB table logging?
		 * @extenders Can be overridden by class extenders.
		 */
		public $db_log = TRUE;

		/**
		 * Diagnostic data.
		 *
		 * @var mixed Diagnostic data.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $data; // Defaults to a NULL value.

		/**
		 * Plugin/framework instance.
		 *
		 * @var framework Plugin/framework instance.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $plugin; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array    $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param string          $code Optional error code (string, NO integers please).
		 *
		 * @param null|mixed      $data Optional exception data (i.e. something to assist in reporting/logging).
		 *    This argument can be bypassed using a NULL value (that's fine).
		 *
		 * @param string          $message Optional exception message (i.e. an error message).
		 *
		 * @param null|\exception $previous Optional previous exception (if re-thrown).
		 *
		 * @throws \exception If there is a missing and/or invalid `$instance`.
		 * @throws \exception A standard exception class; if any additional issues occur during this type of exception.
		 *    This prevents endless exceptions, which may occur when/if we make use of a plugin instance.
		 */
		public function __construct($instance = NULL, $code = 'exception', $data = NULL, $message = '', \exception $previous = NULL)
		{
			try // We'll re-throw as an \exception if there are any issues here.
			{
				if($instance instanceof framework)
					$plugin_root_ns = $instance->instance->plugin_root_ns;
				else if(is_array($instance) && !empty($instance['plugin_root_ns']))
					$plugin_root_ns = (string)$instance['plugin_root_ns'];

				if(empty($plugin_root_ns) || !isset($GLOBALS[$plugin_root_ns]) || !($GLOBALS[$plugin_root_ns] instanceof framework))
					throw new \exception(sprintf(stub::__('Invalid `$instance` to constructor: `%1$s`'),
					                             print_r($instance, TRUE))
					);
				$this->plugin = $GLOBALS[$plugin_root_ns];
				$code         = ((string)$code) ? (string)$code : 'exception';
				$message      = ((string)$message) ? (string)$message : sprintf($this->plugin->__('Exception code: `%1$s`.'), $code);

				parent::__construct($message, 0, $previous); // Call parent constructor.
				$this->code = $code; // Set code for this instance. We always use string exception codes (no exceptions :-).
				$this->data = $data; // Optional diagnostic data associated with this exception (possibly a NULL value).

				$this->wp_debug_log(); // Possible debug logging.
				$this->db_log(); // Possible database logging routine.
			}
			catch(\exception $_exception) // Rethrow a standard exception class.
			{
				throw new \exception( // Standard exceptions are also caught by our exception handler.
					sprintf(stub::__('Could NOT instantiate exception code: `%1$s` with message: `%2$s`.'), $code, $message).
					' '.sprintf(stub::__('Failure caused by exception code: `%1$s` with message: `%2$s`.'), $_exception->getCode(), $_exception->getMessage()), 20, $_exception
				);
			}
		}

		/**
		 * Logs exceptions.
		 *
		 * @note We only log exceptions if the class instance enables this,
		 *    and `WP_DEBUG_LOG` MUST be enabled also (for this to work).
		 */
		public function wp_debug_log()
		{
			if(!$this->wp_debug_log || !$this->plugin->©env->is_in_wp_debug_log_mode())
				return; // Logging NOT enabled. Stop here.

			$log_dir  = $this->plugin->©dir->logs('debug', constant(get_class($this->plugin).'::private_type'));
			$log_file = $this->plugin->©file->maybe_archive($log_dir.'/debug.log');

			file_put_contents( // Log this exception!
				$log_file, $this->plugin->__('— EXCEPTION —')."\n".
				           $this->plugin->__('Exception Code').': '.$this->getCode()."\n".
				           $this->plugin->__('Exception Line #').': '.$this->getLine()."\n".
				           $this->plugin->__('Exception File').': '.$this->getFile()."\n".
				           $this->plugin->__('Exception Time').': '.$this->plugin->©env->time_details()."\n".
				           $this->plugin->__('Memory Details').': '.$this->plugin->©env->memory_details()."\n".
				           $this->plugin->__('Version Details').': '.$this->plugin->©env->version_details()."\n".
				           (did_action('set_current_user') ? // Only if `set_current_user` fired already.
					           $this->plugin->__('Current User ID').': '.$this->plugin->©user->ID."\n".
					           $this->plugin->__('Current User Email').': '.$this->plugin->©user->email."\n" : '').
				           $this->plugin->__('Exception Message').': '.$this->getMessage()."\n\n".
				           $this->plugin->__('Exception Stack Trace').': '.$this->getTraceAsString()."\n\n".
				           $this->plugin->__('Exception Data (if applicable)').': '.$this->plugin->©var->dump($this->data)."\n\n",
				FILE_APPEND
			);
		}

		/**
		 * Logs exceptions.
		 *
		 * @note We only log exceptions if the class instance enables this.
		 *
		 * @extenders This is NOT implemented by the XDaRk Core.
		 *    Class extenders can easily extend this method, and perform their own DB logging routine.
		 */
		public function db_log()
		{
			if(!$this->db_log) return;
		}
	}
}