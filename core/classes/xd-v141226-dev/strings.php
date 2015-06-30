<?php
/**
 * String Utilities.
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
	 * String Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class strings extends framework
	{
		/**
		 * Short version of `(isset() && is_string())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable `(isset() && is_string())`.
		 */
		public function is(&$var)
		{
			return is_string($var);
		}

		/**
		 * Short version of `(!empty() && is_string())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is `(!empty() && is_string())`.
		 */
		public function is_not_empty(&$var)
		{
			return !empty($var) && is_string($var);
		}

		/**
		 * Same as `$this->is_not_empty()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @return boolean See `$this->is_not_empty()` for further details.
		 */
		public function ¤is_not_empty($var)
		{
			return !empty($var) && is_string($var);
		}

		/**
		 * Short version of `if(isset() && is_string()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to an empty string. This is the return value if `$var` is NOT set, or is NOT a string.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return string|mixed Value of `$var`, if `(isset() && is_string())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to an empty string).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function isset_or(&$var, $or = '', $set_var = FALSE)
		{
			if(isset($var) && is_string($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->isset_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` is NOT set, or is NOT a string.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return string|mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = '')
		{
			if(isset($var) && is_string($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of `if(!empty() && is_string()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to an empty string. This is the return value if `$var` IS empty, or is NOT a string.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return string|mixed Value of `$var`, if `(!empty() && is_string())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to an empty string).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_not_empty_or(&$var, $or = '', $set_var = FALSE)
		{
			if(!empty($var) && is_string($var))
				return $var;

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->is_not_empty_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` IS empty, or is NOT a string.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return string|mixed See `$this->is_not_empty_or()` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = '')
		{
			if(!empty($var) && is_string($var))
				return $var;

			return $or;
		}

		/**
		 * Check if string values are set.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note Max 26 arguments by reference. If vars are/were NOT already set,
		 *    they will be set to NULL by PHP, as a result of passing them by reference.
		 *    Starting with argument #27, vars cannot be passed by reference.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @param mixed $d
		 * @param mixed $e
		 * @param mixed $f
		 * @param mixed $g
		 * @param mixed $h
		 * @param mixed $i
		 * @param mixed $j
		 * @param mixed $k
		 * @param mixed $l
		 * @param mixed $m
		 * @param mixed $n
		 * @param mixed $o
		 * @param mixed $p
		 * @param mixed $q
		 * @param mixed $r
		 * @param mixed $s
		 * @param mixed $t
		 * @param mixed $u
		 * @param mixed $v
		 * @param mixed $w
		 * @param mixed $x
		 * @param mixed $y
		 * @param mixed $z
		 * @params-variable-length
		 *
		 * @return boolean TRUE if all arguments are strings.
		 */
		public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_string($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Same as `$this->are_set()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->are_set()` for further details.
		 */
		public function ¤are_set($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_string($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if string values are NOT empty.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note Max 26 arguments by reference. If vars are/were NOT already set,
		 *    they will be set to NULL by PHP, as a result of passing them by reference.
		 *    Starting with argument #27, vars cannot be passed by reference.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @param mixed $d
		 * @param mixed $e
		 * @param mixed $f
		 * @param mixed $g
		 * @param mixed $h
		 * @param mixed $i
		 * @param mixed $j
		 * @param mixed $k
		 * @param mixed $l
		 * @param mixed $m
		 * @param mixed $n
		 * @param mixed $o
		 * @param mixed $p
		 * @param mixed $q
		 * @param mixed $r
		 * @param mixed $s
		 * @param mixed $t
		 * @param mixed $u
		 * @param mixed $v
		 * @param mixed $w
		 * @param mixed $x
		 * @param mixed $y
		 * @param mixed $z
		 * @params-variable-length
		 *
		 * @return boolean TRUE if all arguments are strings, and they're NOT empty.
		 */
		public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_string($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Same as `$this->are_not_empty()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->are_not_empty()` for further details.
		 */
		public function ¤are_not_empty($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_string($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if string values are NOT empty in strings/arrays/objects.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @note Max 26 arguments by reference. If vars are/were NOT already set,
		 *    they will be set to NULL by PHP, as a result of passing them by reference.
		 *    Starting with argument #27, vars cannot be passed by reference.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @param mixed $d
		 * @param mixed $e
		 * @param mixed $f
		 * @param mixed $g
		 * @param mixed $h
		 * @param mixed $i
		 * @param mixed $j
		 * @param mixed $k
		 * @param mixed $l
		 * @param mixed $m
		 * @param mixed $n
		 * @param mixed $o
		 * @param mixed $p
		 * @param mixed $q
		 * @param mixed $r
		 * @param mixed $s
		 * @param mixed $t
		 * @param mixed $u
		 * @param mixed $v
		 * @param mixed $w
		 * @param mixed $x
		 * @param mixed $y
		 * @param mixed $z
		 * @params-variable-length
		 *
		 * @return boolean TRUE if all arguments are strings — or arrays/objects containing strings; and NONE of the strings scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing strings.
		 *    Can have empty arrays; e.g. we consider these to be data containers.
		 *    Can have empty objects; e.g. we consider these data containers.
		 */
		public function are_not_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg) || is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->are_not_empty_in($__arg))
							return FALSE;
				}
				else if(empty($_arg) || !is_string($_arg))
					return FALSE;
			}
			return TRUE;
		}

		/**
		 * Same as `$this->are_not_empty_in()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->are_not_empty_in()` for further details.
		 */
		public function ¤are_not_empty_in($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg) || is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->¤are_not_empty_in($__arg))
							return FALSE;
				}
				else if(empty($_arg) || !is_string($_arg))
					return FALSE;
			}
			return TRUE;
		}

		/**
		 * NOT empty coalesce.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note Max 26 arguments by reference. If vars are/were NOT already set,
		 *    they will be set to NULL by PHP, as a result of passing them by reference.
		 *    Starting with argument #27, vars cannot be passed by reference.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @param mixed $d
		 * @param mixed $e
		 * @param mixed $f
		 * @param mixed $g
		 * @param mixed $h
		 * @param mixed $i
		 * @param mixed $j
		 * @param mixed $k
		 * @param mixed $l
		 * @param mixed $m
		 * @param mixed $n
		 * @param mixed $o
		 * @param mixed $p
		 * @param mixed $q
		 * @param mixed $r
		 * @param mixed $s
		 * @param mixed $t
		 * @param mixed $u
		 * @param mixed $v
		 * @param mixed $w
		 * @param mixed $x
		 * @param mixed $y
		 * @param mixed $z
		 * @params-variable-length
		 *
		 * @return string The first string argument that's NOT empty, else an empty string.
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_string($_arg))
					return $_arg;

			return '';
		}

		/**
		 * Same as `$this->not_empty_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return string See `$this->not_empty_coalesce()` for further details.
		 */
		public function ¤not_empty_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_string($_arg))
					return $_arg;

			return '';
		}

		/**
		 * Is set coalesce.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note Max 26 arguments by reference. If vars are/were NOT already set,
		 *    they will be set to NULL by PHP, as a result of passing them by reference.
		 *    Starting with argument #27, vars cannot be passed by reference.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @param mixed $d
		 * @param mixed $e
		 * @param mixed $f
		 * @param mixed $g
		 * @param mixed $h
		 * @param mixed $i
		 * @param mixed $j
		 * @param mixed $k
		 * @param mixed $l
		 * @param mixed $m
		 * @param mixed $n
		 * @param mixed $o
		 * @param mixed $p
		 * @param mixed $q
		 * @param mixed $r
		 * @param mixed $s
		 * @param mixed $t
		 * @param mixed $u
		 * @param mixed $v
		 * @param mixed $w
		 * @param mixed $x
		 * @param mixed $y
		 * @param mixed $z
		 * @params-variable-length
		 *
		 * @return string The first string argument, else an empty string.
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_string($_arg))
					return $_arg;

			return '';
		}

		/**
		 * Same as `$this->isset_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return string See `$this->isset_coalesce()` for further details.
		 */
		public function ¤isset_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_string($_arg))
					return $_arg;

			return '';
		}

		/**
		 * Should a variable be interpreted as TRUE?
		 *
		 * @param mixed $var Any value to test against here.
		 *
		 * @return boolean TRUE for: TRUE, 'TRUE', 'true', 1, '1', 'on', 'ON', 'yes', 'YES' — else FALSE.
		 *    Any resource/object/array is of course NOT one of these values, and will always return FALSE.
		 *    In other words, any value that is NOT scalar, is NOT TRUE.
		 */
		public function is_true($var)
		{
			return is_scalar($var) && filter_var($var, FILTER_VALIDATE_BOOLEAN);
		}

		/**
		 * Should a variable be interpreted as FALSE?
		 *
		 * @param mixed $var Any value to test against here.
		 *
		 * @return boolean TRUE for anything that is (NOT): TRUE, 'TRUE', 'true', 1, '1', 'on', 'ON', 'yes', 'YES' — else FALSE.
		 *    Any resource/object/array is of course NOT one of these values (which means it `is_false()`).
		 *    In other words, any value that is NOT scalar, is NOT TRUE.
		 */
		public function is_false($var)
		{
			return !$this->is_true($var);
		}

		/**
		 * Is a string in HTML format?
		 *
		 * @param string $string Any input string to test here.
		 *
		 * @return boolean TRUE if string is HTML; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_html($string)
		{
			$this->check_arg_types('string', func_get_args());

			return strpos($string, '<') !== FALSE && preg_match('/\<[^<>]+\>/', $string);
		}

		/**
		 * Is a PHP userland name?
		 *
		 * @param string $string Any input string.
		 *
		 * @return boolean TRUE if the string IS a valid userland name; else FALSE.
		 */
		public function is_userland_name($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_userland_name, $string);
		}

		/**
		 * Is a version string?
		 *
		 * @param string $string Any input string.
		 *
		 * @return boolean TRUE if a version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_version, $string);
		}

		/**
		 * Is a plugin version string?
		 *
		 * @param string $string Any input string.
		 *
		 * @return boolean TRUE if a plugin version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_plugin_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_plugin_version, $string);
		}

		/**
		 * Is a dev version string?
		 *
		 * @param string $string Any input string.
		 *
		 * @return boolean TRUE if a dev version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_dev_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_dev_version, $string);
		}

		/**
		 * Is a plugin dev version string?
		 *
		 * @param string $string Any input string to test against version guidelines.
		 *
		 * @return boolean TRUE if a plugin dev version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_plugin_dev_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_plugin_dev_version, $string);
		}

		/**
		 * Is a stable version string?
		 *
		 * @param string $string Any input string to test against version guidelines.
		 *
		 * @return boolean TRUE if a stable version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_stable_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_stable_version, $string);
		}

		/**
		 * Is a plugin stable version string?
		 *
		 * @param string $string Any input string to test against version guidelines.
		 *
		 * @return boolean TRUE if a plugin stable version string; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_plugin_stable_version($string)
		{
			$this->check_arg_types('string', func_get_args());

			return isset($string[0]) && preg_match(stub::$regex_valid_plugin_stable_version, $string);
		}

		/**
		 * Dashes replace non-alphanumeric chars.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::with_dashes()
		 * @inheritdoc \xd_v141226_dev::with_dashes()
		 */
		public function with_dashes() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'with_dashes'), func_get_args());
		}

		/**
		 * Underscores replace non-alphanumeric chars.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::with_underscores()
		 * @inheritdoc \xd_v141226_dev::with_underscores()
		 */
		public function with_underscores() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'with_underscores'), func_get_args());
		}

		/**
		 * Forces string values deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Any value can be converted into a string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return string|array|object Stringified value, array, or an object.
		 */
		public function ify_deep($value)
		{
			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->ify_deep($_value);
				return $value;
			}
			return (string)$value;
		}

		/**
		 * Converts char counts into a string of chars.
		 *
		 * @param array   $char_counts An array of char counts. See {@link count_chars()}.
		 *
		 * @param boolean $key_is_ascii_code Optional. Defaults to a TRUE value. See {@link count_chars()}.
		 *    If this is FALSE, each array key is treated as the char value, instead of an ASCII code.
		 *
		 * @return string String of all chars; in order of the underlying array keys. Ex: `aabbcdeffgg...`.
		 *    PHP's {@link count_chars()} function returns a list of ASCII codes in ascending order.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function chars($char_counts, $key_is_ascii_code = TRUE)
		{
			$this->check_arg_types('array', 'boolean', func_get_args());

			$chars = ''; // Initialize chars we're building below.

			foreach($char_counts as $_key => $_count)
			{
				if($key_is_ascii_code) // See {@link count_chars()}.
					$chars .= str_repeat(chr((integer)$_key), (integer)$_count);
				else $chars .= str_repeat((string)$_key, (integer)$_count);
			}
			return $chars; // Ex: aabbcdeffgg...
		}

		/**
		 * Match a regex pattern against other values.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string  $regex A regular expression.
		 *
		 * @param mixed   $value Any value can be converted into a string before comparison.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $collect_key_props Collect array keys and/or object properties?
		 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
		 *    However, if the initial input `$value` is NOT an object/array, this flag is ignored completely.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return boolean|array TRUE if regular expression finds a match.
		 *    If `$collect_key_props` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
		 *       else an empty array if no matches are found in the search for keys/properties.
		 *
		 *    IMPORTANT: if `$collect_key_props` is TRUE, but the initial input `$value` is NOT an object/array,
		 *       the `$collect_key_props` flag is ignored completely (e.g. there's no object/array to search).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function regex_pattern_in($regex, $value, $collect_key_props = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('string', '', 'boolean', 'boolean', func_get_args());

			$matching_key_props = array(); // Initialize.

			if(strlen($regex)) // Need a regex pattern (i.e. CANNOT be empty).
			{
				if(is_array($value) || is_object($value))
				{
					foreach($value as $_key_prop => $_value)
					{
						if(is_array($_value) || is_object($_value))
						{
							if(($_matching_key_props = $this->regex_pattern_in($regex, $_value, $collect_key_props, TRUE)))
								if($collect_key_props) // Are we collecting keys, or can we just return now?
									$matching_key_props[] = array($_key_prop => $_matching_key_props);
								else // We can return now.
									return TRUE;
							unset($_matching_key_props);
						}
						else if(preg_match($regex, (string)$_value))
							if($collect_key_props) $matching_key_props[] = $_key_prop;
							else // We can return now.
								return TRUE;
					}
					unset($_key_prop, $_value);

					if($collect_key_props) // Matching keys/properties.
						return $matching_key_props;
				}
				else if(preg_match($regex, (string)$value))
					return TRUE; // We can return now.
			}
			return FALSE; // Defaults to a FALSE return value.
		}

		/**
		 * Search values containing regex patterns against a string.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string  $string String to search within (possibly an empty string).
		 *
		 * @param mixed   $value This routine runs deeply into any value, looking for values that are already strings, and uses them as regex patterns.
		 *    This differs slightly from `in_wildcard_patterns()`, where we cast any non-array/object value as a string.
		 *    This is because regex patterns will ONLY match if they are indeed a regex string pattern,
		 *    whereas wildcard patterns might match any value that we've cast as a string.
		 *    So, this routine will only look for values that are already strings.
		 *
		 * @param boolean $collect_key_props Collect array keys and/or object properties?
		 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
		 *    However, if the initial input `$value` is NOT an object/array, this flag is ignored completely.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return boolean|array TRUE if any string as a regex pattern finds a match.
		 *    If `$collect_key_props` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
		 *       else an empty array if no matches are found in the search for keys/properties.
		 *
		 *    IMPORTANT: if `$collect_key_props` is TRUE, but the initial input `$value` is NOT an object/array,
		 *       the `$collect_key_props` flag is ignored completely (e.g. there's no object/array to search).
		 *
		 * @note Error suppression applies to `@ preg_match()` here,
		 *    simply due to the nature of this method. Searching through multiple dimensions, we need to suppress errors
		 *    that may occur as a result of a non-regex string comparison being applied inadvertently.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function in_regex_patterns($string, $value, $collect_key_props = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('string', '', 'boolean', 'boolean', func_get_args());

			$matching_key_props = array(); // Initialize.

			if(is_array($value) || is_object($value))
			{
				foreach($value as $_key_prop => $_value)
				{
					if(is_array($_value) || is_object($_value))
					{
						if(($_matching_key_props = $this->in_regex_patterns($string, $_value, $collect_key_props, TRUE)))
							if($collect_key_props) // Are we collecting keys, or can we just return now?
								$matching_key_props[] = array($_key_prop => $_matching_key_props);
							else // We can return now.
								return TRUE;
						unset($_matching_key_props);
					}
					else if(is_string($_value) && strlen($_value))
					{
						if(@preg_match($_value, $string))
							if($collect_key_props) $matching_key_props[] = $_key_prop;
							else // We can return now.
								return TRUE;
					}
				}
				unset($_key_prop, $_value);

				if($collect_key_props) // Matching keys/properties.
					return $matching_key_props;
			}
			else if(is_string($value) && strlen($value))
			{
				if(@preg_match($value, $string))
					return TRUE; // Return now.
			}
			return FALSE; // Defaults to a FALSE return value.
		}

		/**
		 * Match a wildcard pattern against other scalar values.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string       $wildcard A wildcard pattern (possibly an empty string).
		 *
		 * @param mixed        $value Any value can be converted into a string before comparison.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
		 *    If TRUE, the search is NOT case sensitive. We enable the `FNM_CASEFOLD` flag.
		 *
		 * @param boolean      $collect_key_props Collect array keys and/or object properties?
		 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
		 *    However, if the initial input `$value` is NOT an object/array, this flag is ignored completely.
		 *
		 * @param null|integer $x_flags Optional. Defaults to a NULL value.
		 *    Any additional flags supported by PHP's `fnmatch()` function are acceptable here.
		 *
		 * @param boolean      $___recursion Internal use only. Tracks recursion in this routine.
		 *
		 * @return boolean|array TRUE if wildcard pattern finds a match.
		 *    If `$collect_key_props` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
		 *       else an empty array if no matches are found in the search for keys/properties.
		 *
		 *    IMPORTANT: if `$collect_key_props` is TRUE, but the initial input `$value` is NOT an object/array,
		 *       the `$collect_key_props` flag is ignored completely (e.g. there's no object/array to search).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see http://linux.die.net/man/3/fnmatch The underlying functionality provided by this routine.
		 */
		public function wildcard_pattern_in($wildcard, $value, $case_insensitive = FALSE,
		                                    $collect_key_props = FALSE, $x_flags = NULL, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('string', '', 'boolean', 'boolean', array('null', 'integer'), 'boolean', func_get_args());

			$matching_key_props = array(); // Initialize.
			$flags              = ($case_insensitive) ? FNM_CASEFOLD : 0;
			$flags              = (isset($x_flags)) ? $flags | $x_flags : $flags;

			if(is_array($value) || is_object($value))
			{
				foreach($value as $_key_prop => $_value)
				{
					if(is_array($_value) || is_object($_value))
					{
						if(($_matching_key_props = // Keys are stored below.
							$this->wildcard_pattern_in($wildcard, $_value, $case_insensitive, $collect_key_props, $x_flags, TRUE))
						)
							if($collect_key_props) // Are we collecting keys, or can we just return now?
								$matching_key_props[] = array($_key_prop => $_matching_key_props);
							else return TRUE; // We can return now.
						unset($_matching_key_props);
					}
					else // Treat this as a string value.
					{
						$_value = (string)$_value;

						if(fnmatch($wildcard, $_value, $flags))
							if($collect_key_props) $matching_key_props[] = $_key_prop;
							else return TRUE; // We can return now.
					}
				}
				unset($_key_prop, $_value); // Housekeeping.

				if($collect_key_props) // Matching keys/properties.
					return $matching_key_props;
			}
			else // Treat this as a string value.
			{
				$_value = (string)$value;

				if(fnmatch($wildcard, $_value, $flags))
					return TRUE; // We can return now.

				unset($_value); // Housekeeping.
			}
			return FALSE; // Defaults to a FALSE return value.
		}

		/**
		 * Search values containing wildcard patterns against a string.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string       $string String to search within (possibly an empty string).
		 *
		 * @param mixed        $value This routine runs deeply into any value,
		 *    converting each non-array/object value into a wildcard string pattern.
		 *    This differs slightly from `in_regex_patterns()`, where we only use values that are already strings.
		 *    This is because regex patterns will only match if they are indeed a regex string pattern,
		 *    whereas wildcard patterns might match any value that we've cast as a string.
		 *
		 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
		 *    If TRUE, the search is NOT case sensitive. We enable the `FNM_CASEFOLD` flag.
		 *
		 * @param boolean      $collect_key_props Collect array keys and/or object properties?
		 *    This defaults to a FALSE value. If TRUE, this method returns an array with matching keys/properties.
		 *    However, if the initial input `$value` is NOT an object/array, this flag is ignored completely.
		 *
		 * @param null|integer $x_flags Optional. Defaults to a NULL value.
		 *    Any additional flags supported by PHP's `fnmatch()` function are acceptable here.
		 *
		 * @param boolean      $___recursion Internal use only. Tracks recursion in this routine.
		 *
		 * @return boolean|array TRUE if any wildcard pattern finds a match.
		 *    If `$collect_key_props` is TRUE, this will return an array instead (i.e. containing all matching keys/properties);
		 *       else an empty array if no matches are found in the search for keys/properties.
		 *
		 *    IMPORTANT: if `$collect_key_props` is TRUE, but the initial input `$value` is NOT an object/array,
		 *       the `$collect_key_props` flag is ignored completely (e.g. there's no object/array to search).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see http://linux.die.net/man/3/fnmatch The underlying functionality provided by this routine.
		 */
		public function in_wildcard_patterns($string, $value, $case_insensitive = FALSE,
		                                     $collect_key_props = FALSE, $x_flags = NULL, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('string', '', 'boolean', 'boolean', array('null', 'integer'), 'boolean', func_get_args());

			$matching_key_props = array(); // Initialize.
			$flags              = ($case_insensitive) ? FNM_CASEFOLD : 0;
			$flags              = (isset($x_flags)) ? $flags | $x_flags : $flags;

			if(is_array($value) || is_object($value))
			{
				foreach($value as $_key_prop => $_value)
				{
					if(is_array($_value) || is_object($_value))
					{
						if(($_matching_key_props = // Keys are stored below.
							$this->in_wildcard_patterns($string, $_value, $case_insensitive, $collect_key_props, $x_flags, TRUE))
						)
							if($collect_key_props) // Are we collecting keys, or can we just return now?
								$matching_key_props[] = array($_key_prop => $_matching_key_props);
							else return TRUE; // We can return now.
						unset($_matching_key_props);
					}
					else // Treat this as a string value.
					{
						$_value = (string)$_value;

						if(fnmatch($_value, $string, $flags))
							if($collect_key_props) $matching_key_props[] = $_key_prop;
							else return TRUE; // We can return now.
					}
				}
				unset($_key_prop, $_value); // Housekeeping.

				if($collect_key_props) // Matching keys/properties.
					return $matching_key_props;
			}
			else // Treat this as a string value.
			{
				$_value = (string)$value;

				if(fnmatch($_value, $string, $flags))
					return TRUE; // We can return now.

				unset($_value); // Housekeeping.
			}
			return FALSE; // Defaults to a FALSE return value.
		}

		/**
		 * Escapes double quotes.
		 *
		 * @param string  $string A string value.
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @return string Escaped string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_dq($string, $times = 1)
		{
			$this->check_arg_types('string', 'integer', func_get_args());

			return $this->esc_dq_deep($string, $times);
		}

		/**
		 * Escapes double quotes deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_dq_deep($value, $times = 1, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_dq_deep($_value, $times, TRUE);
				return $value;
			}
			return str_replace('"', str_repeat('\\', abs($times)).'"', (string)$value);
		}

		/**
		 * Escapes single quotes.
		 *
		 * @param string  $string A string value.
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @return string Escaped string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_sq($string, $times = 1)
		{
			$this->check_arg_types('string', 'integer', func_get_args());

			return $this->esc_sq_deep($string, $times);
		}

		/**
		 * Escapes single quotes deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_sq_deep($value, $times = 1, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_sq_deep($_value, $times, TRUE);
				return $value;
			}
			return str_replace("'", str_repeat('\\', abs($times))."'", (string)$value);
		}

		/**
		 * Escapes JS line breaks (removes "\r"); and escapes single quotes.
		 *
		 * @param string  $string A string value.
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @return string Escaped string, ready for JavaScript.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_js_sq($string, $times = 1)
		{
			$this->check_arg_types('string', 'integer', func_get_args());

			return $this->esc_js_sq_deep($string, $times);
		}

		/**
		 * Escapes JS; and escapes single quotes deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @note This follows {@link http://www.json.org JSON} standards, with TWO exceptions.
		 *    1. Special handling for line breaks: `\r\n` and `\r` are converted to `\n`.
		 *    2. This does NOT escape double quotes; only single quotes.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object (ready for JavaScript).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_js_sq_deep($value, $times = 1, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_js_sq_deep($_value, $times, TRUE);
				return $value;
			}
			$value = str_replace(array("\r\n", "\r", '"'), array("\n", "\n", '%%!dq!%%'), (string)$value);
			$value = str_replace(array('%%!dq!%%', "'"), array('"', "\\'"), trim(json_encode($value), '"'));

			return str_replace('\\', str_repeat('\\', abs($times) - 1).'\\', $value);
		}

		/**
		 * Escapes regex backreference chars (i.e. `\\$` and `\\\\`).
		 *
		 * @param string  $string A string value.
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @return string Escaped string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_refs($string, $times = 1)
		{
			$this->check_arg_types('string', 'integer', func_get_args());

			return $this->esc_refs_deep($string, $times);
		}

		/**
		 * Escapes regex backreference chars deeply (i.e. `\\$` and `\\\\`).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $times Number of escapes. Defaults to `1`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_refs_deep($value, $times = 1, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_refs_deep($_value, $times, TRUE);
				return $value;
			}
			return str_replace(array('\\', '$'), array(str_repeat('\\', abs($times)).'\\', str_repeat('\\', abs($times)).'$'), (string)$value);
		}

		/**
		 * Escapes SQL strings.
		 *
		 * @param string  $string A string value.
		 *
		 * @return string Escaped string.
		 *
		 * @param boolean $convert_nulls_no_esc Optional. Defaults to a FALSE value.
		 *    By default, we convert all values into strings, and then we escape them via the DB class.
		 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`,
		 *    and they are NOT escaped here. This should be enabled when/if NULL values are being inserted into a DB table.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note This method intentionally has NO `$times` parameter, because that makes no sense for SQL.
		 *    In addition, if we attempted to use `$times` here, it would negate WordPress's ability to use `mysql_real_escape_string()`.
		 */
		public function esc_sql($string, $convert_nulls_no_esc = FALSE)
		{
			$this->check_arg_types('string', 'boolean', func_get_args());

			return $this->esc_sql_deep($string, $convert_nulls_no_esc);
		}

		/**
		 * Escapes SQL strings deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $convert_nulls_no_esc Optional. Defaults to a FALSE value.
		 *    By default, we convert all values into strings, and then we escape them via the DB class.
		 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`,
		 *    and they are NOT escaped here. This should be enabled when/if NULL values are being inserted into a DB table.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object (possible `NULL` string if `$convert_null_no_wrap` is TRUE).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note This method intentionally has NO `$times` parameter, because that makes no sense for SQL.
		 *    In addition, if we attempted to use `$times` here, it would negate WordPress's ability to use `mysql_real_escape_string()`.
		 */
		public function esc_sql_deep($value, $convert_nulls_no_esc = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_sql_deep($_value, $convert_nulls_no_esc, TRUE);
				return $value;
			}
			if(is_null($value) && $convert_nulls_no_esc)
				return 'NULL'; // String `NULL` in this case.

			return esc_sql((string)$value);
		}

		/**
		 * Plain text excerpt with a trailing `...`.
		 *
		 * @param string  $string A string value.
		 *
		 * @param integer $max_length Maximum string length before trailing `...` appears.
		 *    If strings are within this length, the `...` does NOT appear at all.
		 *
		 * @return string Plain text excerpt (i.e. all HTML tags stripped).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function excerpt($string, $max_length = 45)
		{
			$this->check_arg_types('string', 'integer', func_get_args());

			return $this->excerpt_deep($string, $max_length);
		}

		/**
		 * Plain text excerpts with a trailing `...`.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a plain text excerpt.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $max_length Maximum string length before trailing `...` appears.
		 *    If strings are within this length, the `...` does NOT appear at all.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Plain text excerpt (i.e. all HTML tags stripped), array, or object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function excerpt_deep($value, $max_length = 45, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->excerpt_deep($_value, $max_length, TRUE);
				return $value;
			}
			else if(strlen($value = strip_tags((string)$value)) > $max_length)
				return (string)substr($value, 0, (($max_length > 3) ? $max_length - 3 : 0)).'...';

			return (string)$value;
		}

		/**
		 * Escapes registered WordPress® Shortcodes (i.e. `[[shortcode]]`).
		 *
		 * @param string $string A string value.
		 *
		 * @return string String with registered WordPress® Shortcodes escaped.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_shortcodes($string)
		{
			$this->check_arg_types('string', func_get_args());

			return $this->esc_shortcodes_deep($string);
		}

		/**
		 * Escapes registered WordPress® Shortcodes (i.e. `[[shortcode]]`) deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into an escaped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function esc_shortcodes_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->esc_shortcodes_deep($_value, TRUE);
				return $value;
			}
			if(empty($GLOBALS['shortcode_tags']) || !is_array($GLOBALS['shortcode_tags']))
				return (string)$value; // Nothing to do.

			return preg_replace_callback('/'.get_shortcode_regex().'/s', array($this, '_esc_shortcodes'), (string)$value);
		}

		/**
		 * Callback handler for escaping WordPress® Shortcodes.
		 *
		 * @param array $m An array of regex matches.
		 *
		 * @return string Escaped Shortcode.
		 *
		 * @throws exception If invalid types are passed through arguments list (disabled).
		 */
		protected function _esc_shortcodes($m)
		{
			if(isset($m[1], $m[6]) && $m[1] === '[' && $m[6] === ']')
				return $m[0]; // Already escaped.

			else // Escape by wrapping with `[` ... `]`.
				return '['.$m[0].']';
		}

		/**
		 * Escapes regex special chars deeply (i.e. `preg_quote()` deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a quoted string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string  $delimiter Same as PHP's `preg_quote()`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Escaped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function preg_quote_deep($value, $delimiter = '', $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'string', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->preg_quote_deep($_value, $delimiter, TRUE);
				return $value;
			}
			return preg_quote((string)$value, $delimiter);
		}

		/**
		 * Trims a string value.
		 *
		 * @param string $string A string value.
		 *
		 * @param string $chars Specific chars to trim.
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string $extra_chars Additional chars to trim.
		 *
		 * @return string Trimmed string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim($string, $chars = '', $extra_chars = '')
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			return $this->trim_deep($string, $chars, $extra_chars);
		}

		/**
		 * Trims strings deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string  $chars Specific chars to trim.
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string  $extra_chars Additional chars to trim.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Trimmed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_deep($value, $chars = '', $extra_chars = '', $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'string', 'string', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->trim_deep($_value, $chars, $extra_chars, TRUE);
				return $value;
			}
			$chars = (strlen($chars)) ? $chars : " \r\n\t\0\x0B";
			$chars = $chars.$extra_chars;

			return trim((string)$value, $chars);
		}

		/**
		 * Strips slashes (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a stripped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Stripped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function strip_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->strip_deep($_value, TRUE);
				return $value;
			}
			return stripslashes((string)$value);
		}

		/**
		 * Adds slashes (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a slashes string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Slashed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function slash_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->slash_deep($_value, TRUE);
				return $value;
			}
			return addslashes((string)$value);
		}

		/**
		 * Trims and strips slashes from a string.
		 *
		 * @param string $string A string value.
		 *
		 * @param string $chars Specific chars to trim.
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string $extra_chars Additional chars to trim.
		 *
		 * @return string Trimmed string value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_strip($string, $chars = '', $extra_chars = '')
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			return $this->trim_strip_deep($string, $chars, $extra_chars);
		}

		/**
		 * Trims/strips slashes from strings deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed  $value Any value can be converted into a trimmed/stripped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string $chars Specific chars to trim.
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string $extra_chars Additional chars to trim.
		 *
		 * @return string|array|object Trimmed/stripped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_strip_deep($value, $chars = '', $extra_chars = '')
		{
			$this->check_arg_types('', 'string', 'string', func_get_args());

			return $this->trim_deep($this->strip_deep($value), $chars, $extra_chars);
		}

		/**
		 * Trims an HTML content string.
		 *
		 * @param string $string A string value.
		 *
		 * @param string $chars Other specific chars to trim (HTML whitespace is always trimmed).
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string $extra_chars Additional specific chars to trim.
		 *
		 * @return string Trimmed string (HTML whitespace is always trimmed).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_content($string, $chars = '', $extra_chars = '')
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			return $this->trim_content_deep($string, $chars, $extra_chars);
		}

		/**
		 * Trims an HTML content string deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string  $chars Other specific chars to trim (HTML whitespace is always trimmed).
		 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
		 *
		 * @param string  $extra_chars Additional specific chars to trim.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Trimmed string, array, object (HTML whitespace is always trimmed).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_content_deep($value, $chars = '', $extra_chars = '', $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'string', 'string', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->trim_content_deep($_value, $chars, $extra_chars, TRUE);
				return $this->trim_deep($value, $chars, $extra_chars);
			}
			if(!isset($this->static[__FUNCTION__.'__whitespace']))
				$this->static[__FUNCTION__.'_whitespace'] = implode('|', array_keys($this->html_whitespace));
			$whitespace =& $this->static[__FUNCTION__.'__whitespace']; // Shorter reference.

			$value = preg_replace('/^(?:'.$whitespace.')+|(?:'.$whitespace.')+$/', '', (string)$value);

			return $this->trim_deep($value, $chars, $extra_chars);
		}

		/**
		 * Trims double quotes (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return string|array|object Trimmed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_dq_deep($value)
		{
			return $this->trim_deep($value, '', '"');
		}

		/**
		 * Trims single quotes (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return string|array|object Trimmed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_sq_deep($value)
		{
			return $this->trim_deep($value, '', "'");
		}

		/**
		 * Trims double/single quotes (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return string|array|object Trimmed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_dsq_deep($value)
		{
			return $this->trim_deep($value, '', '"\'');
		}

		/**
		 * Trims all single/double quotes, including entity variations (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a trimmed string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $trim_dsq Defaults to TRUE.
		 *    If FALSE, normal double/single quotes will NOT be trimmed, only entities.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Trimmed string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function trim_qts_deep($value, $trim_dsq = TRUE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->trim_qts_deep($_value, $trim_dsq, TRUE);
				return $value;
			}
			$qts = implode('|', array_keys($this->quote_entities_w_variations));
			$qts = ($trim_dsq) ? $qts.'|"|\'' : $qts;

			return preg_replace('/^(?:'.$qts.')+|(?:'.$qts.')+$/', '', (string)$value);
		}

		/**
		 * Case insensitive string replace (ONE time).
		 *
		 * @param string|array $needle String, or an array of strings, to search for.
		 *
		 * @param string|array $replace String, or an array of strings, to use as replacements.
		 *
		 * @param string       $string A string to run replacements on (i.e. the string to search in).
		 *
		 * @return string Value of `$string` after ONE replacement.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside `$needle` or `$replace` values.
		 *    To avoid string conversion errors from PHP, please refrain from passing objects in `$needle` or `$replace` arrays (that would make no sense anyway).
		 */
		public function ireplace_once($needle, $replace, $string)
		{
			$this->check_arg_types(array('string', 'array'), array('string', 'array'), 'string', func_get_args());

			return $this->replace_once_deep($needle, $replace, $string, TRUE);
		}

		/**
		 * Case insensitive string replace (ONE time), and deeply into arrays/objects.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string|array $needle String, or an array of strings, to search for.
		 *
		 * @param string|array $replace String, or an array of strings, to use as replacements.
		 *
		 * @param mixed        $value Any value can be converted into a string to run replacements on.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return mixed Values after ONE replacement (deeply).
		 *    Any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside `$needle` or `$replace` values.
		 *    To avoid string conversion errors from PHP, please refrain from passing objects in `$needle` or `$replace` arrays (that would make no sense anyway).
		 */
		public function ireplace_once_deep($needle, $replace, $value)
		{
			$this->check_arg_types(array('string', 'array'), array('string', 'array'), '', func_get_args());

			return $this->replace_once_deep($needle, $replace, $value, TRUE);
		}

		/**
		 * String replace (ONE time).
		 *
		 * @param string|array $needle String, or an array of strings, to search for.
		 *
		 * @param string|array $replace String, or an array of strings, to use as replacements.
		 *
		 * @param string       $string A string to run replacements on (i.e. the string to search in).
		 *
		 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
		 *    If TRUE, the search is NOT case sensitive.
		 *
		 * @return string Value of `$string` after ONE string replacement.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside `$needle` or `$replace` values.
		 *    To avoid string conversion errors from PHP, please refrain from passing objects in `$needle` or `$replace` arrays (that would make no sense anyway).
		 */
		public function replace_once($needle, $replace, $string, $case_insensitive = FALSE)
		{
			$this->check_arg_types(array('string', 'array'), array('string', 'array'), 'string', 'boolean', func_get_args());

			return $this->replace_once_deep($needle, $replace, $string, $case_insensitive);
		}

		/**
		 * String replace (ONE time), and deeply into arrays/objects.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param string|array $needle String, or an array of strings, to search for.
		 *
		 * @param string|array $replace String, or an array of strings, to use as replacements.
		 *
		 * @param mixed        $value Any value can be converted into a string to run replacements on.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean      $case_insensitive Case insensitive? Defaults to FALSE.
		 *    If TRUE, the search is NOT case sensitive.
		 *
		 * @param boolean      $___recursion Internal use only.
		 *
		 * @return mixed Values after ONE string replacement (deeply).
		 *    Any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception For better performance, this function will NOT try to catch PHP string conversion errors when objects are passed inside `$needle` or `$replace` values.
		 *    To avoid string conversion errors from PHP, please refrain from passing objects in `$needle` or `$replace` arrays (that would make no sense anyway).
		 *
		 * @see http://stackoverflow.com/questions/8177296/when-to-use-strtr-vs-str-replace
		 */
		public function replace_once_deep($needle, $replace, $value, $case_insensitive = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types(array('string', 'array'), array('string', 'array'), '', 'boolean', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->replace_once_deep($needle, $replace, $_value, $case_insensitive, TRUE);
				return $value;
			}
			$value = (string)$value; // Force string.

			if($case_insensitive) // Case insensitive scenario?
				$strpos = 'stripos'; // Use `stripos()`.
			else $strpos = 'strpos'; // Default.

			if(is_array($needle)) // Array of needles?
			{
				if(is_array($replace)) // Optimized for `$replace` array.
				{
					foreach($needle as $_key => $_needle)
						if(($_strpos = $strpos($value, ($_needle = (string)$_needle))) !== FALSE)
						{
							$_length  = strlen($_needle);
							$_replace = (isset($replace[$_key])) ? (string)$replace[$_key] : '';
							$value    = substr_replace($value, $_replace, $_strpos, $_length);
						}
					return $value; // String value.
				}
				else // Optimized for `$replace` string.
				{
					$replace = (string)$replace;

					foreach($needle as $_needle)
						if(($_strpos = $strpos($value, ($_needle = (string)$_needle))) !== FALSE)
						{
							$_length = strlen($_needle);
							$value   = substr_replace($value, $replace, $_strpos, $_length);
						}
					return $value; // String value.
				}
			}
			else // Otherwise, just a simple case here.
			{
				$needle = (string)$needle;

				if(($_strpos = $strpos($value, $needle)) !== FALSE)
				{
					$_length = strlen($needle);

					if(is_array($replace)) // Use 1st element, else empty string.
						$_replace = (isset($replace[0])) ? (string)$replace[0] : '';
					else $_replace = (string)$replace; // Use string value.

					$value = substr_replace($value, $_replace, $_strpos, $_length);
				}
				return $value; // String value.
			}
		}

		/**
		 * Process replacement codes (case insensitive).
		 *
		 * @param string  $string A string to run replacements on.
		 *
		 * @param array   $meta_vars Optional. Defaults to an empty array.
		 *    ~ This array is always given precedence over any other secondary `$vars`.
		 *    This is the primary array of data which will be used to replace codes in the `$string`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param array   $vars Optional (any other secondary vars). Defaults to an empty array.
		 *    This is an additional array of data which will be used to replace codes in the `$string`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param boolean $urlencode Optional. Defaults to a FALSE value.
		 *    If this is TRUE, all replacement code values will be urlencoded automatically.
		 *    Setting this to a TRUE value also enables some additional magic replacement codes.
		 *
		 * @param string  $implode_non_scalars Optional. By default, any non-scalar values
		 *    in `$primary_vars` and/or `$vars` will be JSON encoded by this routine before replacements are performed here.
		 *    However, this behavior can be modified by passing this parameter with a non-empty string value to implode such values.
		 *
		 * @return string String after replacing all codes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ireplace_codes($string, $meta_vars = array(), $vars = array(), $urlencode = FALSE, $implode_non_scalars = '')
		{
			$this->check_arg_types('string', 'array', 'array', 'boolean', 'string', func_get_args());

			return $this->replace_codes_deep($string, $meta_vars, $vars, TRUE, FALSE, $urlencode, $implode_non_scalars);
		}

		/**
		 * Process replacement codes deeply (case insensitive).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a string to run replacements on.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param array   $meta_vars Optional. Defaults to an empty array.
		 *    ~ This array is always given precedence over any other secondary `$vars`.
		 *    This is the primary array of data which will be used to replace codes in the `$value`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param array   $vars Optional (any other secondary vars). Defaults to an empty array.
		 *    This is an additional array of data which will be used to replace codes in the `$value`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param boolean $preserve_types Optional. Defaults to a FALSE value.
		 *    If this is TRUE, we will preserve data types; only searching/replacing existing string values deeply.
		 *    By default, anything that is NOT an array/object is converted to a string by this routine.
		 *
		 * @param boolean $urlencode Optional. Defaults to a FALSE value.
		 *    If this is TRUE, all replacement code values will be urlencoded automatically.
		 *    Setting this to a TRUE value also enables some additional magic replacement codes.
		 *
		 * @param string  $implode_non_scalars Optional. By default, any non-scalar values
		 *    in `$primary_vars` and/or `$vars` will be JSON encoded by this routine before replacements are performed here.
		 *    However, this behavior can be modified by passing this parameter with a non-empty string value to implode such values.
		 *
		 * @return mixed Values after replacing all codes (deeply).
		 *    By default, any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
		 *    However, you can pass `$preserve_types` as TRUE to prevent this from occurring.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ireplace_codes_deep($value, $meta_vars = array(), $vars = array(), $preserve_types = FALSE, $urlencode = FALSE, $implode_non_scalars = '')
		{
			$this->check_arg_types('', 'array', 'array', 'boolean', 'boolean', 'string', func_get_args());

			return $this->replace_codes_deep($value, $meta_vars, $vars, TRUE, $preserve_types, $urlencode, $implode_non_scalars);
		}

		/**
		 * Process replacement codes.
		 *
		 * @param string  $string A string to run replacements on.
		 *
		 * @param array   $meta_vars Optional. Defaults to an empty array.
		 *    ~ This array is always given precedence over any other secondary `$vars`.
		 *    This is the primary array of data which will be used to replace codes in the `$string`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param array   $vars Optional (any other secondary vars). Defaults to an empty array.
		 *    This is an additional array of data which will be used to replace codes in the `$string`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param boolean $case_insensitive Case insensitive? Defaults to a FALSE value (caSe sensitivity on).
		 *    If TRUE, the search/replace routine is NOT caSe sensitive (e.g. `%%uSer.Id%%` is the same as `%%user.ID%%`).
		 *
		 * @param boolean $urlencode Optional. Defaults to a FALSE value.
		 *    If this is TRUE, all replacement code values will be urlencoded automatically.
		 *    Setting this to a TRUE value also enables some additional magic replacement codes.
		 *
		 * @param string  $implode_non_scalars Optional. By default, any non-scalar values
		 *    in `$primary_vars` and/or `$vars` will be JSON encoded by this routine before replacements are performed here.
		 *    However, this behavior can be modified by passing this parameter with a non-empty string value to implode such values.
		 *
		 * @return string String after replacing all codes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function replace_codes($string, $meta_vars = array(), $vars = array(), $case_insensitive = FALSE, $urlencode = FALSE, $implode_non_scalars = '')
		{
			$this->check_arg_types('string', 'array', 'array', 'boolean', 'boolean', 'string', func_get_args());

			return $this->replace_codes_deep($string, $meta_vars, $vars, $case_insensitive, FALSE, $urlencode, $implode_non_scalars);
		}

		/**
		 * Process replacement codes deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value will do just fine here.
		 *
		 * @param array   $meta_vars Optional. Defaults to an empty array.
		 *    ~ This array is always given precedence over any other secondary `$vars`.
		 *    This is the primary array of data which will be used to replace codes in the `$value`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param array   $vars Optional (any other secondary vars). Defaults to an empty array.
		 *    This is an additional array of data which will be used to replace codes in the `$value`.
		 *    This is normally an associative array, but a numerically indexed array is also allowable.
		 *
		 * @param boolean $case_insensitive Case insensitive? Defaults to a FALSE value (caSe sensitivity on).
		 *    If TRUE, the search/replace routine is NOT caSe sensitive (e.g. `%%uSer.Id%%` is the same as `%%user.ID%%`).
		 *
		 * @param boolean $preserve_types Optional. Defaults to a FALSE value.
		 *    If this is TRUE, we will preserve data types; only searching/replacing existing string values deeply.
		 *    By default, anything that is NOT an array/object is converted to a string by this routine.
		 *
		 * @param boolean $urlencode Optional. Defaults to a FALSE value.
		 *    If this is TRUE, all replacement code values will be urlencoded automatically.
		 *    Setting this to a TRUE value also enables some additional magic replacement codes.
		 *
		 * @param string  $implode_non_scalars Optional. By default, any non-scalar values
		 *    in `$meta_vars` and/or `$vars` will be JSON encoded by this routine before replacements are performed here.
		 *    However, this behavior can be modified by passing this parameter with a non-empty string value to implode such values by.
		 *
		 * @param boolean $___raw_vars Internal use only.
		 * @param boolean $___vars Internal use only.
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return mixed Values after replacing all codes (deeply).
		 *    By default, any values that were NOT strings|arrays|objects, will be converted to strings by this routine.
		 *    However, you can pass `$preserve_types` as TRUE to prevent this from occurring.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function replace_codes_deep($value, $meta_vars = array(), $vars = array(), $case_insensitive = FALSE,
		                                   $preserve_types = FALSE, $urlencode = FALSE, $implode_non_scalars = '',
		                                   $___raw_vars = NULL, $___vars = NULL, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'array', 'array', 'boolean', 'boolean', 'boolean', 'string',
				                       array('null', 'array'), array('null', 'array'), 'boolean', func_get_args());

			if(!isset($this->static[__FUNCTION__]['__return_value']))
				$this->static[__FUNCTION__]['__return_value'] = create_function('$value', 'return $value;');

			prepare_and_process_all_recursion_vars: // Prepare & process recursion variables.

			if(isset($___raw_vars, $___vars)) goto replace_codes_deep; // Did this?

			$___raw_vars = $meta_vars + $vars; // A union between these two.
			$___vars     = array(); // Initialize this (we're building it below).

			foreach($___raw_vars + $this->©array->dot_keys($___raw_vars) as $_key => $_value)
			{
				if(is_resource($_value)) continue; // Bypass.

				if(!is_scalar($_value)) // Array/object; NOT a resource.
				{
					if($implode_non_scalars) // Implode these values?
					{
						$_value = (array)$_value; // Objects to arrays.
						$_value = $this->©array->to_one_dimension($_value);
						$_value = implode($implode_non_scalars, $_value);
					}
					else $_value = json_encode($_value); // JSON encode.
				}
				else if($_value === FALSE) $_value = '0'; // As a string.

				$___vars[$_key] = (string)$_value;
			}
			unset($_key, $_value); // Housekeeping.

			replace_codes_deep: // Target point. Do the magic here :-)

			if(is_array($value) || is_object($value)) // Array/object recursion.
			{
				foreach($value as &$_value) // Handles deep array/object recursion.
					$_value = $this->replace_codes_deep($_value, $meta_vars, $vars, $case_insensitive,
					                                    $preserve_types, $urlencode, $implode_non_scalars,
					                                    $___raw_vars, $___vars, TRUE);
				unset($_value); // Just a little housekeeping.

				if(!$___recursion) // Run a 2nd time (supporting nested `%%` codes).
					return $this->replace_codes_deep($value, $meta_vars, $vars, $case_insensitive,
					                                 $preserve_types, $urlencode, $implode_non_scalars,
					                                 $___raw_vars, $___vars, TRUE);
				return $value; // Array/object value.
			}
			if($preserve_types && !is_string($value)) return $value;
			if(!($value = (string)$value) || strpos($value, '%%') === FALSE) return $value;

			$str_replace_ = ($case_insensitive) ? 'str_ireplace' : 'str_replace'; // CaSe handler.
			$urlencode_   = ($urlencode) ? 'urlencode' : $this->static[__FUNCTION__]['__return_value'];

			if(stripos($value, '%%__var_dump__%%') !== FALSE) // Dump all vars.
				$value = $str_replace_('%%__var_dump__%%', $urlencode_($this->©vars->dump($___raw_vars)), $value);

			if(stripos($value, '%%__serialize__%%') !== FALSE) // Serialize all vars.
				$value = $str_replace_('%%__serialize__%%', $urlencode_(serialize($___raw_vars)), $value);

			if(stripos($value, '%%__json_encode__%%') !== FALSE) // JSON encode all vars.
				$value = $str_replace_('%%__json_encode__%%', $urlencode_(json_encode($___raw_vars)), $value);

			if($urlencode && stripos($value, '%%__query_string__%%') !== FALSE) // Query string.
				$value = $str_replace_('%%__query_string__%%', // Wraps them into an array (using `plugin_var_ns`).
				                       $this->©vars->build_query(array($this->instance->plugin_var_ns => $___vars)), $value);

			$_iteration_counter = 1; // Check completion every 10th iteration to save time.

			foreach($___vars as $_key => $_value) // There could be MANY keys here.
			{
				$value = $str_replace_('%%'.$_key.'%%', $urlencode_($_value), $value);

				if($_iteration_counter >= 10) $_iteration_counter = 0;
				if(!$_iteration_counter && strpos($value, '%%') === FALSE) return $value;
				$_iteration_counter++; // Increment counter.
			}
			unset($_iteration_counter, $_key, $_value); // Housekeeping.

			if(strpos($value, '.*') !== FALSE && strpos($value, '%%') !== FALSE)
			{
				$_this = $this; // Need reference for the callback in PHP < v5.4.
				$value = preg_replace_callback('/%%(?P<pattern>.+?\.\*)(?:\|(?P<delimiter>.*?))?'.
				                               '(?P<include_keys>\[(?P<key_delimiter>.*?)\])?%%/s',
					function ($m) use ($_this, $case_insensitive, $___vars, $urlencode_ /* Closure. */)
					{
						$values      = array();
						$___var_keys = array_keys($___vars);
						$keys        = $_this->wildcard_pattern_in($m['pattern'], $___var_keys, $case_insensitive, TRUE);
						foreach($keys as $_key) $values[$___var_keys[$_key]] = $___vars[$___var_keys[$_key]];

						if(empty($m['delimiter'])) $m['delimiter'] = ', ';
						if(empty($m['include_keys'])) $m['include_keys'] = '';
						if(empty($m['key_delimiter'])) $m['key_delimiter'] = ' = ';

						if($m['delimiter'] === '&' && !$m['include_keys']) // This indicates a query string.
							return $_this->©vars->build_query(array($_this->instance->plugin_var_ns => $values));

						$m['delimiter']     = str_replace(array('\r', '\n', '\t'), array("\r", "\n", "\t"), $m['delimiter']);
						$m['key_delimiter'] = str_replace(array('\r', '\n', '\t'), array("\r", "\n", "\t"), $m['key_delimiter']);

						if($m['include_keys']) foreach($values as $_key => &$_value)
							$_value = $_key.$m['key_delimiter'].$_value; // Custom key delimiter.
						unset($_value); // Housekeeping.

						return $urlencode_(implode($m['delimiter'], $values));
					}, $value);
				unset($_this); // Housekeeping.
			}
			if(!$___recursion) // Run a 2nd time (supporting nested `%%` codes).
				return $this->replace_codes_deep($value, $meta_vars, $vars, $case_insensitive,
				                                 $preserve_types, $urlencode, $implode_non_scalars,
				                                 $___raw_vars, $___vars, TRUE);
			return preg_replace('/%%.+?%%/', '', $value);
		}

		/**
		 * Strips leading space and/or tab indentations.
		 *
		 * @param string  $string A string value.
		 *
		 * @param integer $leading_at_line Optional. This defaults to a value of `1`.
		 *    By default, we strip leading indentation that precedes line #1 (the expected behavior).
		 *    However, if this is passed in, we strip leading indentation that may start at a different line number.
		 *    This can be extremely useful in cases where a string is obtained (already trimmed); so it needs leading indents
		 *    calculated from line #2 instead of line #1. Doc blocks obtained from the Reflection class are a good example of this.
		 *
		 * @param string  $add_leading_chars Optional. This simply defaults to an empty string.
		 *    However, if this is passed in, we will add the leading chars given to each and every line.
		 *    This can be useful if we need to strip leading indentation and then re-indent or prefix each line.
		 *    NOTE: these chars are added even if we do NOT strip any leading indentation from one or more lines.
		 *
		 * @return string String minus leading indentation.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function strip_leading_indents($string, $leading_at_line = 1, $add_leading_chars = '')
		{
			$this->check_arg_types('string', 'integer', 'string', func_get_args());

			return $this->strip_leading_indents_deep($string, $leading_at_line, $add_leading_chars);
		}

		/**
		 * Strips leading space and/or tab indentations deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a stripped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $leading_at_line Optional. This defaults to a value of `1`.
		 *    By default, we strip leading indentation that precedes line #1 (the expected behavior).
		 *    However, if this is passed in, we strip leading indentation that may start at a different line number.
		 *    This can be extremely useful in cases where a string is obtained (already trimmed); so it needs leading indents
		 *    calculated from line #2 instead of line #1. Doc blocks obtained from the Reflection class are a good example of this.
		 *
		 * @param string  $add_leading_chars Optional. This simply defaults to an empty string.
		 *    However, if this is passed in, we will add the leading chars given to each and every line.
		 *    This can be useful if we need to strip leading indentation and then re-indent or prefix each line.
		 *    NOTE: these chars are added even if we do NOT strip any leading indentation from one or more lines.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Stripped string, array, object.
		 */
		public function strip_leading_indents_deep($value, $leading_at_line = 1, $add_leading_chars = '', $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'string', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->strip_leading_indents_deep($_value, $leading_at_line, $add_leading_chars, TRUE);
				return $value;
			}
			$string          = trim((string)$value, "\r\n");
			$leading_at_line = max(1, abs($leading_at_line));
			$string_lines    = preg_split('/'."\r\n".'|'."\r".'|'."\n".'/', $string);

			if(!empty($string_lines[$leading_at_line]))
				if(preg_match("/^([ \t]+)/", $string_lines[$leading_at_line], $_m))
					$string = preg_replace("/^[ \t]{".strlen($_m[1])."}/m", '', $string);
			unset($_m); // A little housekeeping.

			if(strlen($add_leading_chars)) // Add leading chars?
				$string = preg_replace("/^/m", $add_leading_chars, $string);

			return $string; // Stripped now.
		}

		/**
		 * Sanitizes a string; by stripping characters NOT on a standard U.S. keyboard.
		 *
		 * @param string $string Input string.
		 *
		 * @return string Output string, after characters NOT on a standard U.S. keyboard have been stripped.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function strip_2_kb_chars($string)
		{
			$this->check_arg_types('string', func_get_args());

			return $this->strip_2_kb_chars_deep($string);
		}

		/**
		 * Sanitizes strings deeply; by stripping characters NOT on a standard U.S. keyboard.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a stripped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Stripped string, array, object.
		 */
		public function strip_2_kb_chars_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->strip_2_kb_chars_deep($_value, TRUE);
				return $value;
			}
			return preg_replace('/[^0-9a-z\s\'"`\-\^\/[\]{}()\\\\.,;_~!@#$%&*+=|:?<>]/i', '', remove_accents((string)$value));
		}

		/**
		 * Generates a random string with letters/numbers/symbols.
		 *
		 * @param integer $length Optional. Defaults to `12`.
		 *    Length of the random string.
		 *
		 * @param boolean $special_chars Defaults to TRUE.
		 *    If FALSE, special chars are NOT included.
		 *
		 * @param boolean $extra_special_chars Defaults to FALSE.
		 *    If TRUE, extra special chars are included.
		 *
		 * @return string A randomly generated string, based on configuration.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function random($length = 12, $special_chars = TRUE, $extra_special_chars = FALSE)
		{
			$this->check_arg_types('integer', 'boolean', 'boolean', func_get_args());

			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$chars .= ($special_chars) ? '!@#$%^&*()' : '';
			$chars .= ($extra_special_chars) ? '-_ []{}<>~`+=,.;:/?|' : '';

			for($i = 0, $random_str = ''; $i < abs($length); $i++)
				$random_str .= (string)substr($chars, mt_rand(0, strlen($chars) - 1), 1);

			return $random_str;
		}

		/**
		 * Base64 URL-safe encoding.
		 *
		 * @param string $string Input string to be base64 encoded.
		 *
		 * @param array  $url_unsafe_chars Optional. An array of un-safe characters.
		 *    Defaults to: `array('+', '/')`.
		 *
		 * @param array  $url_safe_chars Optional. An array of safe character replacements.
		 *    Defaults to: `array("-", "_")`.
		 *
		 * @param string $trim_padding_chars Optional. A string of padding chars to rtrim.
		 *    Defaults to: `=`.
		 *
		 * @return string The base64 URL-safe encoded string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the call to `base64_encode()` fails.
		 */
		public function base64_url_safe_encode($string, $url_unsafe_chars = array('+', '/'), $url_safe_chars = array('-', '_'), $trim_padding_chars = '=')
		{
			$this->check_arg_types('string', 'array', 'array', 'string', func_get_args());

			if(!is_string($base64_url_safe = base64_encode($string)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					$this->__('Base64 encoding failed (`$base64_url_safe` is NOT a string).')
				);
			$base64_url_safe = str_replace($url_unsafe_chars, $url_safe_chars, $base64_url_safe);
			$base64_url_safe = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;

			return $base64_url_safe;
		}

		/**
		 * Base64 URL-safe decoding.
		 *
		 * @param string $base64_url_safe Input string to be base64 decoded.
		 *
		 * @param array  $url_unsafe_chars Optional. An array of un-safe character replacements.
		 *    Defaults to: `array('+', '/')`.
		 *
		 * @param array  $url_safe_chars Optional. An array of safe characters.
		 *    Defaults to: `array('-', '_')`.
		 *
		 * @param string $trim_padding_chars Optional. A string of padding chars to rtrim.
		 *    Defaults to: `=`.
		 *
		 * @return string The decoded string. Or, possibly the original string, if `$base64_url_safe`
		 *    was NOT base64 encoded to begin with. Helps prevent accidental data corruption.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the call to `base64_decode()` fails.
		 */
		public function base64_url_safe_decode($base64_url_safe, $url_unsafe_chars = array('+', '/'), $url_safe_chars = array('-', '_'), $trim_padding_chars = '=')
		{
			$this->check_arg_types('string', 'array', 'array', 'string', func_get_args());

			$string = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
			$string = (strlen($trim_padding_chars)) ? str_pad($string, strlen($string) % 4, '=', STR_PAD_RIGHT) : $string;
			$string = str_replace($url_safe_chars, $url_unsafe_chars, $string);

			if(!is_string($string = base64_decode($string, TRUE)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					$this->__('Base64 decoding failed (`$string` is NOT a string).')
				);
			return $string;
		}

		/**
		 * Decodes unreserved chars encoded by PHP's `urlencode()`.
		 *
		 * @param string $string The input string to be decoded here.
		 *
		 * @return string Decoded string.
		 *
		 * @see http://www.faqs.org/rfcs/rfc3986.html
		 */
		public function urldecode_ur_chars($string)
		{
			$this->check_arg_types('string', func_get_args());

			return $this->urldecode_ur_chars_deep($string);
		}

		/**
		 * Decodes unreserved chars deeply; encoded by PHP's `urlencode()`.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a decoded string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Decoded string, array, object.
		 *
		 * @see http://www.faqs.org/rfcs/rfc3986.html
		 */
		public function urldecode_ur_chars_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->urldecode_ur_chars_deep($_value, TRUE);
				return $value;
			}
			return str_replace(array('%2D', '%2E', '%5F', '%7E'), array('-', '.', '_', '~'), (string)$value);
		}

		/**
		 * Wraps strings with the characters provided (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a wrapped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string  $beginning Optional. Defaults to an empty string.
		 *    A string value to wrap at the beginning of each value.
		 *
		 * @param string  $end Optional. Defaults to an empty string.
		 *    A string value to wrap at the end of each value.
		 *
		 * @param boolean $wrap_0b_strings Optional. Defaults to a TRUE value.
		 *    Should 0-byte strings be wrapped too?
		 *
		 * @param boolean $convert_nulls_no_wrap Optional. Defaults to a FALSE value.
		 *    By default, we convert all values into strings, and wrap them (based on `$wrap_0b_strings`).
		 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`, and they are NOT wrapped up.
		 *    This is useful when data is being prepared for database insertion and/or updates.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Wrapped string, array, object (possible `NULL` string if `$convert_null_no_wrap` is TRUE).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function wrap_deep($value, $beginning = '', $end = '', $wrap_0b_strings = TRUE, $convert_nulls_no_wrap = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'string', 'string', 'boolean', 'boolean', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->wrap_deep($_value, $beginning, $end, $wrap_0b_strings, $convert_nulls_no_wrap, TRUE);
				return $value;
			}
			if(is_null($value) && $convert_nulls_no_wrap)
				return 'NULL'; // String `NULL` in this case.

			$value = (string)$value;
			if($wrap_0b_strings || strlen($value))
				$value = $beginning.$value.$end;

			return $value; // Final value.
		}

		/**
		 * Wordwrap (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a word-wrapped string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $width See PHP's `wordwrap()` function.
		 * @param string  $break See PHP's `wordwrap()` function.
		 * @param boolean $cut See PHP's `wordwrap()` function.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Word-wrapped string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function wordwrap_deep($value, $width = 75, $break = "\n", $cut = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'string', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->wordwrap_deep($_value, $width, $break, $cut, TRUE);
				return $value;
			}
			return wordwrap((string)$value, $width, $break, $cut);
		}

		/**
		 * Checks if a string is encoded as UTF-8.
		 *
		 * @param string $string An input string to test against.
		 *
		 * @return boolean TRUE if the string is UTF-8.
		 */
		public function is_utf8($string)
		{
			$this->check_arg_types('string', func_get_args());

			return (isset($string[0]) && seems_utf8($string));
		}

		/**
		 * Converts a string to UTF-8 encoding.
		 *
		 * @param string       $string An input string to convert to UTF-8.
		 *
		 * @param string|array $detection_order Optional. Defaults to `$this->mb_detection_order`.
		 *    If a NON-empty string/array is provided, it is used instead.
		 *
		 * @return string A UTF-8 encoded string value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_utf8($string, $detection_order = array())
		{
			$this->check_arg_types('string', array('string', 'array'), func_get_args());

			return $this->to_utf8_deep($string, $detection_order);
		}

		/**
		 * Converts strings to UTF-8 (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed        $value Any value can be converted into a UTF-8 string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param string|array $detection_order Optional. Defaults to `$this->mb_detection_order`.
		 *    If a NON-empty string/array is provided, it is used instead.
		 *
		 * @param boolean      $___recursion Internal use only.
		 *
		 * @return string|array|object UTF-8 string, array, object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_utf8_deep($value, $detection_order = array(), $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', array('string', 'array'), 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->to_utf8_deep($_value, $detection_order, TRUE);
				return $value;
			}
			if(!$this->is_utf8($value = (string)$value))
			{
				if(empty($detection_order))
					$detection_order = $this->mb_detection_order;

				if(extension_loaded('mbstring'))
					$value = mb_convert_encoding($value, 'UTF-8', $detection_order);
			}
			return $value;
		}

		/**
		 * Converts a string into a hexadecimal notation.
		 *
		 * @param string $string String to convert into a hexadecimal notation.
		 *
		 * @return string Hexadecimal notation.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_hex($string)
		{
			$this->check_arg_types('string', func_get_args());

			return $this->to_hex_deep($string);
		}

		/**
		 * Converts strings to a hexadecimal notation (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a UTF-8 string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object Hexadecimal notation. Or an array/object containing strings in hexadecimal notation.
		 */
		public function to_hex_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->to_hex_deep($_value, TRUE);
				return $value;
			}
			if(strlen($value = (string)$value))
				$value = '\\x'.substr(chunk_split(bin2hex($value), 2, '\\x'), 0, -2);

			return $value;
		}

		/**
		 * Converts characters into `[aA][bB]`.
		 *
		 * @param string $string String to be converted into `[aA][bB]`.
		 *
		 * @return string String as `[aA][bB]`; suitable for `fnmatch()` or `glob()`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function fnm_case($string)
		{
			$this->check_arg_types('string', func_get_args());

			return $this->fnm_case_deep($string);
		}

		/**
		 * Converts characters into `[aA][bB]`.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @note This will NOT convert stream wrappers (i.e. `phar://`); or drive letters (i.e. `C:/` or `E:\`).
		 *    This is because the PHP `glob()` function is NOT compatible with character classes in those locations.
		 *
		 * @note This will NOT convert characters ALREADY inside character class brackets `[]`.
		 *    Also, this routine is smart enough to determine when square brackets have been escaped as literals.
		 *    Thus, we do NOT ignore characters inside escaped brackets; because these are literals (e.g. not character classes).
		 *
		 * @param mixed   $value Any value can be converted into an `[aA][bB]` string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string|array|object String as `[aA][bB]`; suitable for `fnmatch()` or `glob()`.
		 *    Or an array/object containing strings converted into `[aA][bB]`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function fnm_case_deep($value, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->fnm_case_deep($_value, TRUE);
				return $value;
			}
			if(strlen($value = (string)$value))
			{
				$_aA_value         = ''; // Initialize value we're building here.
				$_sq_brackets_open = array(); // Initialize open brackets.

				$regex_stream_wrapper   = substr(stub::$regex_valid_dir_file_stream_wrapper, 0, -2).'/';
				$regex_win_drive_letter = substr(stub::$regex_valid_win_drive_letter, 0, -2).'/';

				if(preg_match($regex_stream_wrapper, $value, $_stream_wrapper))
					$value = preg_replace($regex_stream_wrapper, '', $value);

				if(preg_match($regex_win_drive_letter, $value, $_win_drive_letter))
					$value = preg_replace($regex_win_drive_letter, '', $value);

				for($_i = 0; $_i < strlen($value); $_i++)
				{
					if($value[$_i] === '[')
						if($_i === 0 || $value[$_i - 1] !== '\\')
						{
							$_aA_value .= $value[$_i];
							$_sq_brackets_open[] = $value[$_i];
							continue;
						}
					if($_sq_brackets_open && $value[$_i] === ']')
						if($_i === 0 || $value[$_i - 1] !== '\\')
						{
							$_aA_value .= $value[$_i];
							array_pop($_sq_brackets_open);
							continue;
						}
					if($_sq_brackets_open) // Skip.
					{
						$_aA_value .= $value[$_i];
						continue;
					}
					if(ctype_alpha($value[$_i]))
						$_aA_value .= '['.strtolower($value[$_i]).strtoupper($value[$_i]).']';
					else $_aA_value .= $value[$_i];
				}
				$value = $_aA_value; // Use newly formulated string value.

				if(!empty($_win_drive_letter[0])) // Restore a Windows® drive letter?
					$value = $_win_drive_letter[0].$value; // Use entire match `[0]`.

				if(!empty($_stream_wrapper[0])) // Restore a PHP stream wrapper?
					$value = $_stream_wrapper[0].$value; // Entire match `[0]`.

				unset($_stream_wrapper, $_win_drive_letter, $_aA_value, $_sq_brackets_open, $_i); // Housekeeping.
			}
			return $value; // String as `[aA][bB]`.
		}

		/**
		 * Gets a string containing a verbose description of: `preg_last_error()`.
		 *
		 * @return string Verbose description of `preg_last_error()`.
		 */
		public function preg_last_error()
		{
			$error_code = preg_last_error();

			if($error_code == PREG_NO_ERROR)
				return $this->__('No error: `PREG_NO_ERROR`.');

			if($error_code == PREG_INTERNAL_ERROR)
				return $this->__('Internal: `PREG_INTERNAL_ERROR`.');

			if($error_code == PREG_BACKTRACK_LIMIT_ERROR)
				return $this->__('Backtrack limit exhausted: `PREG_BACKTRACK_LIMIT_ERROR`.');

			if($error_code == PREG_RECURSION_LIMIT_ERROR)
				return $this->__('Recursion limit exhausted: `PREG_RECURSION_LIMIT_ERROR`.');

			if($error_code == PREG_BAD_UTF8_ERROR)
				return $this->__('Bad UTF8: `PREG_BAD_UTF8_ERROR`.');

			if($error_code == PREG_BAD_UTF8_OFFSET_ERROR)
				return $this->__('Bad UTF8 offset: `PREG_BAD_UTF8_OFFSET_ERROR`.');

			return $this->__('Unknown PREG error code.');
		}

		/**
		 * Gets a string containing a verbose error code description.
		 *
		 * @param mixed $error_code The file upload error code.
		 *
		 * @return string Verbose description of `$error_code`.
		 */
		public function file_upload_error($error_code)
		{
			if($error_code == UPLOAD_ERR_OK)
				return $this->__('No error: `UPLOAD_ERR_OK`.');

			if($error_code == UPLOAD_ERR_INI_SIZE)
				return $this->__('Too large: `UPLOAD_ERR_INI_SIZE`.'.
				                 ' The uploaded file exceeds the `upload_max_filesize` directive in `php.ini`.');

			if($error_code == UPLOAD_ERR_FORM_SIZE)
				return $this->__('Too large: `UPLOAD_ERR_FORM_SIZE`.'.
				                 ' The uploaded file exceeds the `MAX_FILE_SIZE` directive that was specified in the HTML form.');

			if($error_code == UPLOAD_ERR_PARTIAL)
				return $this->__('Did not get entire file: `UPLOAD_ERR_PARTIAL`. The uploaded file was only partially uploaded.');

			if($error_code == UPLOAD_ERR_NO_FILE)
				return $this->__('Missing: `UPLOAD_ERR_NO_FILE`. No file was uploaded.');

			if($error_code == UPLOAD_ERR_NO_TMP_DIR)
				return $this->__('Missing temp directory on server: `UPLOAD_ERR_NO_TMP_DIR`.');

			if($error_code == UPLOAD_ERR_CANT_WRITE)
				return $this->__('Failed to write file to disk: `UPLOAD_ERR_CANT_WRITE`.');

			if($error_code == UPLOAD_ERR_EXTENSION)
				return $this->__('Exension failure: `UPLOAD_ERR_EXTENSION`.'.
				                 ' A PHP extension stopped the file upload (this is an unusual error code).'.
				                 ' PHP does not provide a way to ascertain which extension caused the file upload to stop.'.
				                 ' Examining the list of loaded extensions with `phpinfo()` may help.');

			return sprintf($this->__('Unknown file upload error code: `%1$s`.'), (string)$error_code);
		}

		/**
		 * Generates a unique alphanumeric ID (based on time).
		 *
		 * @param string $prefix Optional. Defaults to an empty string.
		 *    See PHP's `uniqid()` function, for further details.
		 *
		 * @return string A unique alphanumeric ID (always w/ extra entropy).
		 *    Always 32 characters; plus the length of the optional `$prefix`.
		 */
		public function unique_id($prefix = '')
		{
			$this->check_arg_types('string', func_get_args());

			return str_replace('.', '', uniqid($prefix.$this->random(10, FALSE), TRUE));
		}

		/**
		 * Ampersand entities. Keys are actually regex patterns here.
		 *
		 * @var array Ampersand entities. Keys are actually regex patterns here.
		 */
		public $ampersand_entities = array(
			'&amp;'       => '&amp;',
			'&#0*38;'     => '&#38;',
			'&#[xX]0*26;' => '&#x26;'
		);

		/**
		 * HTML whitespace. Keys are actually regex patterns here.
		 *
		 * @var array HTML whitespace. Keys are actually regex patterns here.
		 */
		public $html_whitespace = array(
			'\0\x0B'                  => "\0\x0B",
			'\s'                      => "\r\n\t ",
			'&nbsp;'                  => '&nbsp;',
			'\<br\>'                  => '<br>',
			'\<br\s*\/\>'             => '<br/>',
			'\<p\>(?:&nbsp;)*\<\/p\>' => '<p></p>'
		);

		/**
		 * Quote entities. Keys are actually regex patterns here.
		 *
		 * @var array Quote entities. Keys are actually regex patterns here.
		 */
		public $quote_entities_w_variations = array(
			'&apos;'           => '&apos;',
			'&#0*39;'          => '&#39;',
			'&#[xX]0*27;'      => '&#x27;',
			'&lsquo;'          => '&lsquo;',
			'&#0*8216;'        => '&#8216;',
			'&#[xX]0*2018;'    => '&#x2018;',
			'&rsquo;'          => '&rsquo;',
			'&#0*8217;'        => '&#8217;',
			'&#[xX]0*2019;'    => '&#x2019;',
			'&quot;'           => '&quot;',
			'&#0*34;'          => '&#34;',
			'&#[xX]0*22;'      => '&#x22;',
			'&ldquo;'          => '&ldquo;',
			'&#0*8220;'        => '&#8220;',
			'&#[xX]0*201[cC];' => '&#x201C;',
			'&rdquo;'          => '&rdquo;',
			'&#0*8221;'        => '&#8221;',
			'&#[xX]0*201[dD];' => '&#x201D;'
		);

		/**
		 * Multibyte detection order.
		 *
		 * @var array Default character encoding detections.
		 */
		public $mb_detection_order = array('UTF-8', 'ISO-8859-1');

		/**
		 * Finds a double quoted value.
		 *
		 * @var string Regular expression fragment (dot matches newline inside quotes).
		 */
		public $regex_frag_dq_value = '(?P<open_dq>(?<!\\\\)")(?P<dq_value>(?s:\\\\.|[^\\\\"])*?)(?P<close_dq>")';

		/**
		 * Finds a single quoted value.
		 *
		 * @var string Regular expression fragment (dot matches newline inside quotes).
		 */
		public $regex_frag_sq_value = '(?P<open_sq>(?<!\\\\)\')(?P<sq_value>(?s:\\\\.|[^\\\\\'])*?)(?P<close_sq>\')';

		/**
		 * Finds a single or double quoted value.
		 *
		 * @var string Regular expression fragment (dot matches newline inside quotes).
		 */
		public $regex_frag_dsq_value = '(?P<open_dsq>(?<!\\\\)["\'])(?P<dsq_value>(?s:\\\\.|(?!\\\\|(?P=open_dsq)).)*?)(?P<close_dsq>(?P=open_dsq))';
	}
}