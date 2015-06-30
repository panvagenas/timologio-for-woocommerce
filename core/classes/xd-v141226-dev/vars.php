<?php
/**
 * Variable Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120329
 */
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Variable Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120329
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class vars extends framework
	{
		/**
		 * Short version of `if(isset()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Optional. Defaults to a NULL value. This is the return value if `$var` is NOT set yet.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return mixed Value of `$var`, if `isset()`. Else returns `$or` (which defaults to NULL).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function isset_or(&$var, $or = NULL, $set_var = FALSE)
		{
			if(isset($var))
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
		 * @param mixed $or This is the return value if `$var` is NOT set.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = NULL)
		{
			if(isset($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of `if(!empty()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Optional. Defaults to a NULL value. This is the return value if `$var` IS empty.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return mixed Value of `$var`, if `!empty()`. Else returns `$or` (which defaults to NULL).
		 *
		 * @note Objects are never considered `empty()` by PHP.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_not_empty_or(&$var, $or = NULL, $set_var = FALSE)
		{
			if(!empty($var))
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
		 * @param mixed $or This is the return value if `$var` IS empty.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return mixed See `$this->is_not_empty_or()` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = NULL)
		{
			if(!empty($var))
				return $var;

			return $or;
		}

		/**
		 * Check if values are set.
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
		 * @return boolean TRUE if all arguments are set.
		 */
		public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg))
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
				if(!isset($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if vars are NOT empty.
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
		 * @return boolean TRUE if all arguments are NOT empty.
		 *
		 * @note Objects are never considered `empty()` by PHP.
		 */
		public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg))
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
				if(empty($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check deeply if values are NOT empty.
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
		 * @return boolean TRUE if all arguments, and their values/properties, are NOT empty.
		 *    Can have multidimensional arrays/objects (unlimited nesting).
		 *    CANNOT have empty arrays; e.g. empty arrays are considered an empty value.
		 *    CANNOT have empty objects; e.g. empty objects are considered empty values.
		 *       However, note that PHP not consider any object to be `empty()`.
		 *    TRUE if no values scanned deeply are empty; else FALSE.
		 */
		public function are_not_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg) || is_object($_arg))
				{
					if(empty($_arg))
						return FALSE;

					foreach($_arg as $__arg)
						if(!$this->are_not_empty_in($__arg))
							return FALSE;
				}
				else if(empty($_arg))
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
					if(empty($_arg))
						return FALSE;

					foreach($_arg as $__arg)
						if(!$this->¤are_not_empty_in($__arg))
							return FALSE;
				}
				else if(empty($_arg))
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
		 * @return mixed The first argument that's NOT empty, else NULL.
		 *
		 * @note Objects are never considered `empty()` by PHP.
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg))
					return $_arg;

			return NULL;
		}

		/**
		 * Same as `$this->not_empty_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->not_empty_coalesce()` for further details.
		 */
		public function ¤not_empty_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg))
					return $_arg;

			return NULL;
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
		 * @return mixed The first argument that's set, else NULL.
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg))
					return $_arg;

			return NULL;
		}

		/**
		 * Same as `$this->isset_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->isset_coalesce()` for further details.
		 */
		public function ¤isset_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg))
					return $_arg;

			return NULL;
		}

		/**
		 * Generates a URL-encoded query string.
		 *
		 * @param mixed       $value Usually an object/array.
		 *
		 * @param null|string $prefix Optional. Defaults to a NULL value.
		 *    If numeric indexes are used in the base array, and this parameter is passed through,
		 *    it will be prepended to the numeric index for elements in the base array only.
		 *
		 * @param null|string $separator Optional. Defaults to `&`, which is NOT the same as PHP's `http_build_query()`.
		 *    This default value is the one used most often by the XDaRk Core. If a different separator is needed, please pass it in.
		 *    If this is set to a NULL value, the system's default value will be used (e.g. `ini_get('arg_separator.output')`).
		 *
		 * @param null|string $enc_type Optional. Defaults to {@link fw_constants::rfc1738}, indicating `urlencode()`.
		 *    Or, this can also be set to {@link fw_constants::rfc3986}, indicating `rawurlencode()`.
		 *    Or, if this is set to a NULL value, no URL-encoding will occur whatsoever.
		 *    Should be specified with one of these constants:
		 *       • {@link fw_constants::rfc1738}
		 *       • {@link fw_constants::rfc3986}
		 *
		 * @param null        $___nested_key Internal use only; for recursion.
		 *
		 * @return string A URL-encoded query string.
		 *
		 * @see The `parse_query()` method in this class, for the opposite.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$separator` is passed as a string, and it's empty.
		 * @throws exception If `$enc_type` is passed as a string, and it's empty.
		 */
		public function build_query($value, $prefix = NULL, $separator = '&', $enc_type = self::rfc1738, $___nested_key = NULL)
		{
			if(!isset($___nested_key)) // Only check arg types initially (i.e. NOT in recursive calls).
				$this->check_arg_types('', array('null', 'string'), array('null', 'string:!empty'), array('null', 'string:!empty'), array('null', 'string', 'integer'), func_get_args());

			if(!isset($separator)) // System default?
				$separator = (string)ini_get('arg_separator.output');

			$query = array(); // Initialize array of query data.

			foreach((array)$value as $_key => $_value)
			{
				if($_value === NULL)
					continue;
				else if($_value === FALSE)
					$_value = '0';

				if(isset($___nested_key))
					$_key = $___nested_key.'['.$_key.']';
				else if(isset($prefix) && is_numeric($_key))
					$_key = $prefix.$_key;

				if(is_array($_value) || is_object($_value))
				{
					if(strlen($_value = $this->build_query($_value, NULL, $separator, $enc_type, $_key)))
						$query[] = $_value;
				}
				else if($enc_type === $this::rfc1738)
					$query[] = urlencode($_key).'='.urlencode((string)$_value);

				else if($enc_type === $this::rfc3986)
					$query[] = rawurlencode($_key).'='.rawurlencode((string)$_value);

				else $query[] = $_key.'='.(string)$_value;
			}
			unset($_key, $_value, $_nested_value);

			return implode($separator, $query);
		}

		/**
		 * Generates a raw URL-encoded query string.
		 *
		 * @note This method is an alias for `build_query()` with `$enc_type` set to: {@link fw_constants::rfc3986}.
		 *    Please check the `build_query()` method for further details.
		 *
		 * @param mixed       $value Usually an object/array.
		 *
		 * @param null|string $prefix Optional. Defaults to a NULL value.
		 *
		 * @param null|string $separator Optional. Defaults to `&`.
		 *
		 * @return string A raw URL-encoded query string.
		 */
		public function build_raw_query($value, $prefix = NULL, $separator = '&')
		{
			return $this->build_query($value, $prefix, $separator, $this::rfc3986);
		}

		/**
		 * Generates an array from a string of query vars.
		 *
		 * @param string      $string An input string of query vars.
		 *
		 * @param boolean     $convert_dots_spaces Optional. This defaults to a TRUE value (just like PHP's `parse_str()` function).
		 *    Setting this to a FALSE value, makes it possible to preserve variables that actually SHOULD contain dots and/or spaces.
		 *
		 * @param null|string $dec_type Optional. Defaults to {@link fw_constants::rfc1738}, indicating `urldecode()`.
		 *    Or, this can also be set to {@link fw_constants::rfc3986}, indicating `rawurldecode()`.
		 *    Or, if this is set to a NULL value, no URL-decoding will occur whatsoever.
		 *    Should be specified with one of these constants:
		 *       • {@link fw_constants::rfc1738}
		 *       • {@link fw_constants::rfc3986}
		 *
		 * @param null|array  $___parent_array Internal use only; for recursion.
		 *
		 * @return array An array of data, based on the input `$string` value.
		 *
		 * @see The `build_query()` method in this class, for the opposite.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dec_type` is passed as a string, and it's empty.
		 */
		public function parse_query($string, $convert_dots_spaces = TRUE, $dec_type = self::rfc1738, &$___parent_array = NULL)
		{
			if(!isset($___parent_array)) // Only check arg types initially (i.e. NOT in recursive calls).
				$this->check_arg_types('string', 'boolean', array('null', 'string:!empty'), array('null', 'array'), func_get_args());

			if(isset($___parent_array))
				$array = & $___parent_array;
			else $array = array(); // Initialize array.

			foreach(explode('&', $string) as $_name_value)
			{
				if(strlen($_name_value) && $_name_value !== '=')
				{
					$_name_value = explode('=', $_name_value, 2);
					$_name       = $_name_value[0]; // Always has length.
					$_value      = (isset($_name_value[1])) ? $_name_value[1] : '';

					if($dec_type === $this::rfc1738)
						$_name = urldecode($_name);
					else if($dec_type === $this::rfc3986)
						$_name = rawurldecode($_name);

					if($convert_dots_spaces)
						$_name = str_replace(array('.', ' '), '_', $_name);

					if(strlen($_name) // Handles recursion into multiple dimensions of arrays.
					   && preg_match('/^(?P<name>[^\[]+)\[(?P<nested_name>[^\]]*)\](?P<deep>.*)$/', $_name, $_m)
					) // Here we use regex, and parent arrays by &reference; to parse all dimensions.
					{
						if(!isset($array[$_m['name']]))
							$array[$_m['name']] = array();

						if(!strlen($_m['nested_name']))
							$_m['nested_name'] = count($array[$_m['name']]);

						if($dec_type === $this::rfc1738)
							$_value = urlencode($_m['nested_name'].$_m['deep']).'='.$_value;
						else if($dec_type === $this::rfc3986)
							$_value = rawurlencode($_m['nested_name'].$_m['deep']).'='.$_value;
						else $_value = $_m['nested_name'].$_m['deep'].'='.$_value;

						$array[$_m['name']] = $this->parse_query($_value, $convert_dots_spaces, $dec_type, $array[$_m['name']]);
					}
					else // NOT an array.
					{
						if($dec_type === $this::rfc1738)
							$_value = urldecode($_value);
						else if($dec_type === $this::rfc3986)
							$_value = rawurldecode($_value);

						$array[$_name] = $_value;
					}
					unset($_m); // Housekeeping.
				}
			}
			unset($_name_value, $_name, $_value);

			return $array; // Final array.
		}

		/**
		 * Generates an array from a string of query vars.
		 *
		 * @note This method is an alias for `parse_query()` with `$enc_type` set to: {@link fw_constants::rfc3986}.
		 *    Please check the `parse_query()` method for further details.
		 *
		 * @param string  $string An input string of query vars.
		 *
		 * @param boolean $convert_dots_spaces Optional. This defaults to a TRUE value.
		 *
		 * @return array An array of data, based on the input `$string` value.
		 */
		public function parse_raw_query($string, $convert_dots_spaces = TRUE)
		{
			return $this->parse_query($string, $convert_dots_spaces, $this::rfc3986);
		}

		/**
		 * Returns a copy of all `$_GET` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @return array|mixed|null Copy of all `$_GET` vars (trimmed/stripped/cached), else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _GET($key = NULL)
		{
			return $this->_super_global_tsc('_GET', $_GET, $key);
		}

		/**
		 * Returns a copy of all `$_POST` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @param boolean        $include_files Optional. Defaults to a FALSE value.
		 *    If TRUE, we'll include `$_FILES` as part of the array — in a proprietary arrangement.
		 *    NOTE: If a specific `$key` is requested, this parameter is ignored completely.
		 *
		 * @return array|mixed|null Copy of all `$_POST` vars (trimmed/stripped/cached), else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _POST($key = NULL, $include_files = FALSE)
		{
			if(!isset($key) && $include_files)
				return $this->merge_FILES_deeply_into($this->_super_global_tsc('_POST', $_POST));

			return $this->_super_global_tsc('_POST', $_POST, $key);
		}

		/**
		 * Returns a copy of all `$_REQUEST` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @param boolean        $include_files Optional. Defaults to a FALSE value.
		 *    If TRUE, we'll include `$_FILES` as part of the array — in a proprietary arrangement.
		 *    NOTE: If a specific `$key` is requested, this parameter is ignored completely.
		 *
		 * @return array|mixed|null Copy of all `$_REQUEST` vars (trimmed/stripped/cached), else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _REQUEST($key = NULL, $include_files = FALSE)
		{
			if(!isset($key) && $include_files)
				return $this->merge_FILES_deeply_into($this->_super_global_tsc('_REQUEST', $_REQUEST));

			return $this->_super_global_tsc('_REQUEST', $_REQUEST, $key);
		}

		/**
		 * Returns a copy of all `$_COOKIE` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @return array|mixed|null Copy of all `$_COOKIE` vars (trimmed/stripped/cached), else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _COOKIE($key = NULL)
		{
			return $this->_super_global_tsc('_COOKIE', $_COOKIE, $key);
		}

		/**
		 * Returns a copy of all `$_SESSION` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @return array|mixed|null Copy of all `$_SESSION` vars by default, else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _SESSION($key = NULL)
		{
			$this->check_arg_types(array('null', 'integer', 'string'), func_get_args());

			if(!empty($_SESSION))
			{
				if(isset($key)) // A specific key?
				{
					if(array_key_exists($key, (array)$_SESSION))
						return $_SESSION[$key];
					return NULL;
				}
				return (array)$_SESSION;
			}
			return isset($key) ? NULL : array();
		}

		/**
		 * Returns a copy of all `$_FILES`.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @return array|mixed|null Copy of all `$_FILES` by default, else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _FILES($key = NULL)
		{
			$this->check_arg_types(array('null', 'integer', 'string'), func_get_args());

			if(!empty($_FILES))
			{
				if(isset($key)) // A specific key?
				{
					if(array_key_exists($key, (array)$_FILES))
						return $_FILES[$key];
					return NULL;
				}
				return (array)$_FILES;
			}
			return isset($key) ? NULL : array();
		}

		/**
		 * Merges `$_FILES` deeply into another array.
		 *
		 * @param array $array The array to have `$_FILES` merged into.
		 *
		 * @return array The original `$array` with `$_FILES` merged in also.
		 *    Files with `error` code `UPLOAD_ERR_NO_FILE`; will NOT be included in any way.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the `$_FILES` array contains an unexpected data type.
		 *
		 * @note Files with `error` code `UPLOAD_ERR_NO_FILE`; will NOT be included in any way.
		 * @note File `name` values are modified by this routine. We make sure each file name is unique.
		 * @note Files are always merged as string values pointing to the base `name` for each file (always unique).
		 *    In addition, a sibling array w/ key `___file_info` includes child keys created for each file in the array.
		 *    Each array of info is an associative array of file data for each file.
		 *
		 * Example #1: `<input type="file" name="file" />`
		 *
		 *    `file => (string)name`
		 *    `___file_info[file] = array('name' => '', 'tmp_name' => '', etc.)`
		 *
		 * Example #2: `<input type="file" name="fields[file]" />`
		 *
		 *    `fields[file] => (string)name`
		 *    `fields[___file_info][file] = array('name' => '', 'tmp_name' => '', etc.)`
		 *
		 * Example #3: `<input type="file" name="files[]" multiple="multiple" />`
		 *
		 *    `files[0] => (string)name`
		 *    `files[___file_info][0] = array('name' => '', 'tmp_name' => '', etc.)`
		 *
		 *    `files[1] => (string)name`
		 *    `files[___file_info][1] = array('name' => '', 'tmp_name' => '', etc.)`
		 *
		 * Example #4: `<input type="file" name="fields[files][]" multiple="multiple" />`
		 *
		 *    `fields[files][0] => (string)name`
		 *    `fields[files][___file_info][0] = array('name' => '', 'tmp_name' => '', etc.)`
		 *
		 *    `fields[files][1] => (string)name`
		 *    `fields[files][___file_info][1] = array('name' => '', 'tmp_name' => '', etc.)`
		 */
		public function merge_FILES_deeply_into($array)
		{
			$this->check_arg_types('array', func_get_args());

			if(!($_files = $this->_FILES()))
				return $array; // No files.

			$files = array(); // Initialize files.

			foreach($_files as $_key => $_value)
			{
				if(!is_array($_value)) // This should NOT happen.
					throw $this->©exception(
						$this->method(__FUNCTION__).'#unexpected_data_type', get_defined_vars(),
						$this->__('Unexpected data type in `$_FILES` array.')
					);
				foreach($_value as $_file_info_key => $_scalar_or_nested_array_value)
					$files[$_file_info_key][$_key] = $_scalar_or_nested_array_value;
			}
			unset($_key, $_value, $_file_info_key, $_scalar_or_nested_array_value);

			foreach(array('name', 'tmp_name', 'type', 'size', 'error' /* MUST be last key. */) as $_file_info_key)
				if(!empty($files[$_file_info_key])) $this->_merge_FILES_deeply_into($array, $_file_info_key, $files[$_file_info_key]);
			unset($_file_info_key);

			return $array; // With `$_FILES` merged in.
		}

		/**
		 * Merges `$_FILES` deeply into another array (helper routine).
		 *
		 * @param array   $array The array to have `$_FILES` merged into (passed by reference).
		 *
		 * @param string  $file_info_key A specific file info key (`name`, `tmp_name`, `type`, `size`, `error`).
		 *
		 * @param array   $file_info_values An array of values which represent file info values.
		 *    These might be scalar values; and/or nested array values (depending on the underlying `<form>` tag).
		 *
		 * @param integer $___depth For internal use only. Do NOT pass these in.
		 * @param boolean $___recursion For internal use only.
		 *
		 * @works-by-reference Modifies the original `$array` by reference.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file_info_key` is empty; or it is NOT an associative array key.
		 */
		protected function _merge_FILES_deeply_into(&$array, $file_info_key, $file_info_values, $___depth = 0, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'string:!empty', 'array', 'integer', 'boolean', func_get_args());

			static $keychain = array(); // Maintains a static keychain across all file info keys.

			foreach($file_info_values as $_key => $_scalar_or_nested_array_value)
			{
				if(is_array($_scalar_or_nested_array_value))
				{
					if(!$this->©array->is($array[$_key]))
					{
						$keychain[$___depth][$_key] = TRUE;
						$array[$_key]               = array();
					}
					$this->_merge_FILES_deeply_into($array[$_key], $file_info_key, $_scalar_or_nested_array_value, $___depth + 1, TRUE);
					if(empty($array[$_key]) && isset($keychain[$___depth][$_key])) unset($array[$_key]);
				}
				else // Here's where everything comes together.
				{
					if($file_info_key === 'error' /* MUST be last key. */)
						if($_scalar_or_nested_array_value === UPLOAD_ERR_NO_FILE)
						{
							unset($array[$_key], $array['___file_info'][$_key]);
							if(empty($array['___file_info'])) unset($array['___file_info']);
							continue; // Stop here after emptying keys we built-in.
						}
					if($file_info_key === 'name') // Handle file names.
					{
						$_extension                    = $this->©file->extension($_scalar_or_nested_array_value);
						$_scalar_or_nested_array_value = $this->©string->unique_id(); // Make file name unique.
						if($_extension) $_scalar_or_nested_array_value .= '.'.$_extension;
						unset($_extension); // Housekeeping.

						$array[$_key] = $_scalar_or_nested_array_value;
					}
					$array['___file_info'][$_key][$file_info_key] = $_scalar_or_nested_array_value;
				}
			}
			if(!$___recursion && $file_info_key === 'error') $keychain = array(); // Reset this on last key.
		}

		/**
		 * Returns a copy of all `$_SERVER` vars.
		 *
		 * @param string|integer $key Optional. Looking for a specific array key?
		 *
		 * @return array|mixed|null Copy of all `$_SERVER` vars by default, else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 */
		public function _SERVER($key = NULL)
		{
			$this->check_arg_types(array('null', 'integer', 'string'), func_get_args());

			if(!empty($_SERVER))
			{
				if(isset($key)) // A specific key?
				{
					if(array_key_exists($key, (array)$_SERVER))
						return $_SERVER[$key];
					return NULL;
				}
				return (array)$_SERVER;
			}
			return isset($key) ? NULL : array();
		}

		/**
		 * Returns a copy of a specific super global (trimmed/stripped/cached).
		 *
		 * @param string              $name The name of this super global (i.e. `_GET`, `_POST`, `_REQUEST`, etc.).
		 *
		 * @param &array          $value A reference to the value for this super global (absolutely required at all times).
		 *    The value MUST be passed in explicitly, so we trigger `auto_globals_jit` (in case it's enabled).
		 *
		 * @param null|string|integer $key Optional. Defaults to a NULL value.
		 *    Looking for a specific array key? If so, pass a string or integer in this parameter.
		 *
		 * @return array Copy of a specific super global (trimmed/stripped/cached), else an empty array.
		 *    If a specific `$key` is requested, the value of that `$key`; else NULL.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		protected function _super_global_tsc($name, &$value, $key = NULL)
		{
			$this->check_arg_types('string', 'array', array('null', 'integer', 'string'), func_get_args());

			$checksum = md5(serialize($value)); // Current checksum (e.g. current array keys/values).

			if(!isset($this->static[__FUNCTION__.'__'.$name], $this->static[__FUNCTION__.'__'.$name.'_checksum'])
			   || $this->static[__FUNCTION__.'__'.$name.'_checksum'] !== $checksum
			) // Either NOT yet defined; or values have changed since last cache.
			{
				$this->static[__FUNCTION__.'__'.$name]             = array();
				$this->static[__FUNCTION__.'__'.$name.'_checksum'] = $checksum;
				$this->static[__FUNCTION__.'__'.$name]             = $this->©strings->trim_strip_deep((array)$value);
			}
			if(isset($key)) // Requesting a specific key?
			{
				if(array_key_exists($key, $this->static[__FUNCTION__.'__'.$name]))
					return $this->static[__FUNCTION__.'__'.$name][$key];
				return NULL; // Default return value.
			}
			return $this->static[__FUNCTION__.'__'.$name];
		}

		/**
		 * Converts PHP variables into JavaScript.
		 *
		 * @note This follows JSON standards; except we use single quotes instead of double quotes.
		 *    Also, see {@link strings::esc_js_sq_deep()} for subtle differences when it comes to line breaks.
		 *    • Special handling for line breaks in strings: `\r\n` and `\r` are converted to `\n`.
		 *
		 * @param mixed   $var Any input variable (or an expression is fine also).
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return string JavaScript value (w/ string representation).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_js($var, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', func_get_args());

			switch(($type = gettype($var))) // Based on type.
			{
				case 'object': // Iterates each object property.
				case 'array': // Or, each array key (if this is an array).

					if($type === 'array' && (empty($var) || array_keys($var) === range(0, count($var) - 1)))
						$js_value = '['.implode(',', array_map(array($this, __FUNCTION__), $var, array_fill(0, count($var), TRUE))).']';

					else // It's an object; or an associative array (which is converted to an object).
					{
						$_nested_key_props = array(); // Initialize.

						foreach($var as $_nested_key_prop => &$_nested_value)
							$_nested_key_props[] = "'".$this->©string->esc_js_sq((string)$_nested_key_prop)."':".$this->to_js($_nested_value, TRUE);
						$js_value = '{'.implode(',', $_nested_key_props).'}';

						unset($_nested_key_prop, $_nested_value, $_nested_key_props); // Housekeeping.
					}
					break; // Break switch.

				// Everything else is MUCH simpler to handle.

				case 'integer':
					$js_value = (string)$var;
					break; // Break switch.

				case 'real': // Alias for `float` type.
				case 'double': // Alias for `float` type.
				case 'float': // Standardized as `float` type.
					$js_value = (string)$var;
					break; // Break switch.

				case 'string':
					$js_value = "'".$this->©string->esc_js_sq($var)."'";
					break; // Break switch.

				case 'boolean':
					$js_value = ($var) ? 'true' : 'false';
					break; // Break switch.

				case 'resource':
					$js_value = "'".$this->©string->esc_js_sq((string)$var)."'";
					break; // Break switch.

				case 'NULL':
					$js_value = 'null';
					break; // Break switch.

				default: // Default case handler.
					$js_value = "'".$this->©string->esc_js_sq((string)$var)."'";
					break; // Break switch.
			}
			return $js_value; // JavaScript value.
		}

		/**
		 * A better `var_dump()`.
		 *
		 * @note This provides better output, better indentation, and it returns a string.
		 *    While this routine is NOT faster than `var_dump()`, it IS faster than `print_r()`.
		 *
		 * @param mixed          $var Any input variable to dump (or an expression is fine also).
		 *
		 * @param string|boolean $echo Optional. Defaults to an empty string.
		 *    If this is {@link fw_constants::do_echo} or TRUE, data will be output via `echo()` as well as returned.
		 *
		 * @param integer        $tab_size Optional. Defaults to a value of `1`, for tabbed indentation.
		 *    This can be customized, to control the overall tab indentation size.
		 *
		 * @param boolean        $dump_circular_ids Optional. Defaults to a value of FALSE (cleaner output).
		 *    If this is TRUE, all circular IDs for objects/arrays will be included in the dump.
		 *    This can be helpful when trying to determine the origin of circular references.
		 *
		 * @return string A dump of the input `$var`.
		 *
		 * @note This method DOES have built-in protection against circular references.
		 *
		 * @performance This was benchmarked a few times against PHP's own `var_dump()`, and also against `print_r()`.
		 *    This routine is NOT faster than `var_dump()`, but it is MUCH faster than `print_r()`.
		 *
		 * @note This routine MUST be very careful that it does NOT write to any variables.
		 *    Writing to a variable (or to a variable reference), could cause damage in other routines.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function dump($var, $echo = '', $tab_size = 1, $dump_circular_ids = FALSE)
		{
			$this->check_arg_types('', array('string', 'boolean'), 'integer', 'boolean', func_get_args());

			$echo = ($echo === $this::do_echo || $echo === TRUE) ? $this::do_echo : '';

			return $this->_dump($var, $echo, abs($tab_size), $dump_circular_ids);
		}

		/**
		 * A protected child routine; used by `dump()`.
		 *
		 * @param mixed   $var Any input variable to dump.
		 *    Passing this by reference conserves memory in extreme cases.
		 *
		 * @param string  $echo Optional. Defaults to an empty string.
		 *    If this is {@link fw_constants::do_echo}, data will be output via `echo()`, as well as returned.
		 *
		 * @param integer $tab_size Optional. Defaults to a value of `1`, for tabbed indentation.
		 *    This can be customized, to control the overall tab indentation size.
		 *
		 * @param boolean $dump_circular_ids Optional. Defaults to a value of FALSE (cleaner output).
		 *    If this is TRUE, all circular IDs for objects/arrays will be included in the dump.
		 *    This can be helpful when trying to determine the origin of circular references.
		 *
		 * @param integer $___current_tab_size Used in recursion. This is for internal use only.
		 *
		 * @param array   $___nested_circular_ids Used in recursion. For internal use only.
		 *
		 * @param boolean $___recursion Tracks recursion. For internal use only.
		 *
		 * @return string A dump of the input `$var` (always in string format).
		 *
		 * @note This method DOES have built-in protection against circular references.
		 *
		 * @performance This was benchmarked a few times against PHP's own `var_dump()`, and also against `print_r()`.
		 *    This routine is NOT faster than `var_dump()`, but it is MUCH faster than `print_r()`.
		 *
		 * @note This routine MUST be very careful that it does NOT write to any variables.
		 *    Writing to a variable (or to a variable reference), could cause damage in other routines.
		 */
		protected function _dump(&$var, $echo = '', $tab_size = 1, $dump_circular_ids = FALSE, $___current_tab_size = 0, $___nested_circular_ids = array(), $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'string', 'integer', 'boolean', 'integer', 'array', 'boolean', func_get_args());

			switch(($type = $real_type = gettype($var))) // Formatting based on type.
			{
				case 'object': // Iterates each object property.
				case 'array': // Or, each array key (if this is an array).

					$longest_nested_key_prop_length = 0;
					$nested_dumps                   = array();

					$dump_tab_size        = $___current_tab_size + ($tab_size * 1);
					$nested_dump_tab_size = $___current_tab_size + ($tab_size * 2);

					$current_tabs     = str_repeat("\t", $___current_tab_size);
					$dump_tabs        = $current_tabs.str_repeat("\t", $dump_tab_size);
					$nested_dump_tabs = $current_tabs.str_repeat("\t", $nested_dump_tab_size);

					$opening_encap          = ($type === 'object') ? '{' : '(';
					$closing_encap          = ($type === 'object') ? '}' : ')';
					$opening_key_prop_encap = ($type === 'object') ? '{' : '[';
					$closing_key_prop_encap = ($type === 'object') ? '}' : ']';
					$key_prop_value_sep     = ' => '; // Same for object/array.

					if($type === 'object') // Object instance type with hash/ID.
						$real_type = 'object'.(($dump_circular_ids) ? '::'.spl_object_hash($var) : '').'::'.get_class($var);
					else if($type === 'array') // Calculate an ID for arrays.
						$real_type = 'array'.(($dump_circular_ids) ? '::'.md5(serialize($var)) : '');

					$var_dump = $real_type."\n".$dump_tabs.$opening_encap."\n";

					foreach($var as $_nested_key_prop => $_nested_value /* NOT by reference. */)
						// Do NOT use `&`. Some iterators CANNOT be iterated by reference.
					{
						$_nested_type = gettype($_nested_value);

						if(is_string($_nested_key_prop))
							$_nested_key_prop = "'".$_nested_key_prop."'";

						$_nested_key_prop_length = strlen((string)$_nested_key_prop);
						if($_nested_key_prop_length > $longest_nested_key_prop_length)
							$longest_nested_key_prop_length = $_nested_key_prop_length;

						switch($_nested_type) // Formatting based on type.
						{
							case 'integer':
								$nested_dumps[$_nested_key_prop] = (string)$_nested_value;
								break; // Break switch.

							case 'real': // Alias for `float` type.
							case 'double': // Alias for `float` type.
							case 'float': // Standardized as `float` type.
								$_nested_type                    = 'float';
								$nested_dumps[$_nested_key_prop] = (string)$_nested_value;
								break; // Break switch.

							case 'string':
								$nested_dumps[$_nested_key_prop] = "'".$_nested_value."'";
								break; // Break switch.

							case 'boolean':
								$nested_dumps[$_nested_key_prop] = ($_nested_value) ? 'TRUE' : 'FALSE';
								break; // Break switch.

							case 'resource':
								$nested_dumps[$_nested_key_prop] = '['.(string)$_nested_value.']';
								break; // Break switch.

							case 'object': // Recurses into object values.

								$_nested_circular_id_key = spl_object_hash($_nested_value);
								$_nested_real_type       = $_nested_type.(($dump_circular_ids) ? '::'.$_nested_circular_id_key : '').'::'.get_class($_nested_value);

								if(isset($___nested_circular_ids[$_nested_circular_id_key]))
									$nested_dumps[$_nested_key_prop] = $_nested_real_type.'{} *circular*';

								else if(($___nested_circular_ids[$_nested_circular_id_key] = -1) // To catch circular references.
								        && ($_nested_dump = $this->_dump($_nested_value, '', $tab_size, $dump_circular_ids, $dump_tab_size, $___nested_circular_ids, TRUE))
								) $nested_dumps[$_nested_key_prop] = $_nested_dump;

								else // Else, this object has no properties.
									$nested_dumps[$_nested_key_prop] = $_nested_real_type.'{}';

								unset($_nested_real_type, $_nested_circular_id_key, $_nested_dump);

								break; // Break switch.

							case 'array': // Recurses into array values.

								$_nested_circular_id_key = md5(serialize($_nested_value));
								$_nested_real_type       = $_nested_type.(($dump_circular_ids) ? '::'.$_nested_circular_id_key : '');

								if(isset($___nested_circular_ids[$_nested_circular_id_key]))
									$nested_dumps[$_nested_key_prop] = $_nested_real_type.'() *circular*';

								else if(($___nested_circular_ids[$_nested_circular_id_key] = -1) // To catch circular references.
								        && ($_nested_dump = $this->_dump($_nested_value, '', $tab_size, $dump_circular_ids, $dump_tab_size, $___nested_circular_ids, TRUE))
								) $nested_dumps[$_nested_key_prop] = $_nested_dump;

								else // Else, this is an empty array.
									$nested_dumps[$_nested_key_prop] = $_nested_real_type.'()';

								unset($_nested_real_type, $_nested_circular_id_key, $_nested_dump);

								break; // Break switch.

							case 'NULL':
								$nested_dumps[$_nested_key_prop] = 'NULL';
								break; // Break switch.

							default: // Default case handler.
								$nested_dumps[$_nested_key_prop] = (string)$_nested_value;
								break; // Break switch.
						}
					}
					unset($_nested_key_prop, $_nested_value, $_nested_type, $_nested_key_prop_length);

					if(!empty($nested_dumps)) // Any dumps to format?
					{
						foreach($nested_dumps as $_nested_key_prop => $_nested_dump)
						{
							$_aligning_spaces = str_repeat(' ', $longest_nested_key_prop_length - strlen($_nested_key_prop));
							$var_dump .= $nested_dump_tabs.$opening_key_prop_encap.$_nested_key_prop.$closing_key_prop_encap.$_aligning_spaces.$key_prop_value_sep.$_nested_dump."\n";
						}
						unset($_nested_key_prop, $_nested_dump, $_aligning_spaces);

						$var_dump = $var_dump.$dump_tabs.$closing_encap;
					}
					else $var_dump = rtrim($var_dump, "\n\t".$opening_encap).$opening_encap.$closing_encap;

					break; // Break switch.

				// Everything else is MUCH simpler to handle.

				case 'integer':
					$var_dump = (string)$var;
					break; // Break switch.

				case 'real': // Alias for `float` type.
				case 'double': // Alias for `float` type.
				case 'float': // Standardized as `float` type.
					$real_type = 'float'; // Real type.
					$var_dump  = (string)$var;
					break; // Break switch.

				case 'string':
					$var_dump = "'".$var."'";
					break; // Break switch.

				case 'boolean':
					$var_dump = ($var) ? 'TRUE' : 'FALSE';
					break; // Break switch.

				case 'resource':
					$var_dump = '['.(string)$var.']';
					break; // Break switch.

				case 'NULL':
					$var_dump = 'NULL';
					break; // Break switch.

				default: // Default case handler.
					$var_dump = (string)$var;
					break; // Break switch.
			}
			if($echo === $this::do_echo)
				echo $var_dump."\n"; // With a trailing line break.
			return $var_dump; // We ALWAYS return the value of `$var_dump`.
		}
	}
}