<?php
/**
 * Function Utilities.
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
	 * Function Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class functions extends framework
	{
		/**
		 * PHP's language constructs.
		 *
		 * @var array PHP's language constructs.
		 *    Keys are currently unimportant. Subject to change.
		 */
		public $constructs = array(
			'die'             => 'die',
			'echo'            => 'echo',
			'empty'           => 'empty',
			'exit'            => 'exit',
			'eval'            => 'eval',
			'include'         => 'include',
			'include_once'    => 'include_once',
			'isset'           => 'isset',
			'list'            => 'list',
			'require'         => 'require',
			'require_once'    => 'require_once',
			'return'          => 'return',
			'print'           => 'print',
			'unset'           => 'unset',
			'__halt_compiler' => '__halt_compiler'
		);

		/**
		 * Is a particular function, static method, or PHP language construct possible?
		 *
		 * @param string $function The name of a function, a static method, or a PHP language construct.
		 *
		 * @param string $reconsider Optional. Empty string default (e.g. do NOT reconsider).
		 *    You MUST use class constant {@link fw_constants::reconsider} for this argument value.
		 *    If this is {@link fw_constants::reconsider}, we force a reconsideration.
		 *
		 * @return boolean TRUE if (in `$this->constructs` || `is_callable()` || `function_exists()`),
		 *    and it's NOT been disabled via `ini_get('disable_functions')` (or via Suhosin).
		 *    Else this returns FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$function` is empty.
		 *
		 * @see \deps_x_xd_v141226_dev::is_function_possible()
		 */
		public function is_possible($function, $reconsider = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$function = ltrim(strtolower($function), '\\'); // Clean this up before checking.

			if(isset($this->static[__FUNCTION__][$function]) && $reconsider !== $this::reconsider)
				return $this->static[__FUNCTION__]; // Use the cache.

			$this->static[__FUNCTION__][$function] = FALSE;

			if((in_array($function, $this->constructs, TRUE) || is_callable($function) || function_exists($function))
			   && !in_array($function, $this->disabled(), TRUE) // And it is NOT disabled in some way.
			) $this->static[__FUNCTION__][(string)$function] = TRUE;

			return $this->static[__FUNCTION__][$function];
		}

		/**
		 * Gets all disabled PHP functions.
		 *
		 * @return array An array of all disabled functions, else an empty array.
		 *
		 * @see \deps_x_xd_v141226_dev::disabled_functions()
		 */
		public function disabled()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = array();

			if(!function_exists('ini_get')) return $this->static[__FUNCTION__];

			if(($_ini_val = trim(strtolower(ini_get('disable_functions')))))
				$this->static[__FUNCTION__] = array_merge($this->static[__FUNCTION__], preg_split('/[\s;,]+/', $_ini_val, NULL, PREG_SPLIT_NO_EMPTY));
			unset($_ini_val); // Housekeeping.

			if(($_ini_val = trim(strtolower(ini_get('suhosin.executor.func.blacklist')))))
				$this->static[__FUNCTION__] = array_merge($this->static[__FUNCTION__], preg_split('/[\s;,]+/', $_ini_val, NULL, PREG_SPLIT_NO_EMPTY));
			unset($_ini_val); // Housekeeping.

			if($this->©string->is_true(ini_get('suhosin.executor.disable_eval')))
				$this->static[__FUNCTION__] = array_merge($this->static[__FUNCTION__], array('eval'));

			return $this->static[__FUNCTION__];
		}

		/**
		 * Array of all backtrace callers (or a specific backtrace caller).
		 *
		 * @param array               $debug_backtrace Array from `debug_backtrace()`.
		 *
		 * @param null|string|integer $position Default is NULL (all callers).
		 *
		 *    • NULL indicates a full array of all callers.
		 *    • Set to `last`, to get the last caller.
		 *    • Set to `previous`, to get the previous caller.
		 *    • Set to `before-previous` to receive caller before previous caller.
		 *    • Set to an integer value to specify an exact array index position.
		 *
		 * @return array|string Array of all backtrace callers (default behavior).
		 *    Or, a string with a specific backtrace caller. See `$position` for details.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_backtrace_callers($debug_backtrace, $position = NULL)
		{
			$this->check_arg_types('array', array('null', 'string', 'integer'), func_get_args());

			$callers = array(); // Initialize.

			$exclusions = array( // Exclude these.
			                     'require', 'require_once',
			                     'include', 'include_once',
			                     'call_user_func', 'call_user_func_array',
			                     'check_arg_types', 'check_extension_arg_types'
			);
			foreach($debug_backtrace as $_caller) // Compile callers.
			{
				if(!is_array($_caller)) continue;
				if(!$this->©string->is_not_empty($_caller['function'])) continue;
				if(in_array(strtolower($_caller['function']), $exclusions)) continue;

				if($this->©strings->are_not_empty($_caller['class'], $_caller['type']))
					$callers[] = $_caller['class'].$_caller['type'].$_caller['function'];
				else $callers[] = $_caller['function'];
			}
			unset($_caller); // A little housekeeping.

			if(!isset($position)) return array_map('strtolower', $callers);
			if($position === 'last') return (!empty($callers[0])) ? strtolower($callers[0]) : 'unknown-caller';
			if($position === 'previous') return (!empty($callers[1])) ? strtolower($callers[1]) : 'unknown-caller';
			if($position === 'before-previous') return (!empty($callers[2])) ? strtolower($callers[2]) : 'unknown-caller';
			if(is_integer($position)) return (!empty($callers[$position])) ? strtolower($callers[$position]) : 'unknown-caller';

			return array_map('strtolower', $callers); // Defaults to all callers.
		}
	}
}