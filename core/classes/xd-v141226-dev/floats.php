<?php
/**
 * Float Utilities.
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
	 * Float Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class floats extends framework
	{
		/**
		 * Short version of `(isset() && is_float())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable `(isset() && is_float())`.
		 */
		public function is(&$var)
		{
			return is_float($var);
		}

		/**
		 * Short version of `(!empty() && is_float())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is `(!empty() && is_float())`.
		 */
		public function is_not_empty(&$var)
		{
			return !empty($var) && is_float($var);
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
			return !empty($var) && is_float($var);
		}

		/**
		 * Short version of `if(isset() && is_float()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0.0`. This is the return value if `$var` is NOT set, or is NOT a float.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return float|mixed Value of `$var`, if `(isset() && is_float())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `0.0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function isset_or(&$var, $or = 0.0, $set_var = FALSE)
		{
			if(isset($var) && is_float($var))
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
		 * @param mixed $or This is the return value if `$var` is NOT set, or is NOT a float.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return float|mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = 0.0)
		{
			if(isset($var) && is_float($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of `if(!empty() && is_float()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `0.0`. This is the return value if `$var` IS empty, or is NOT a float.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return float|mixed Value of `$var`, if `(!empty() && is_float())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `0.0`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_not_empty_or(&$var, $or = 0.0, $set_var = FALSE)
		{
			if(!empty($var) && is_float($var))
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
		 * @param mixed $or This is the return value if `$var` IS empty, or is NOT a float.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return float|mixed See `$this->is_not_empty_or()` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = 0.0)
		{
			if(!empty($var) && is_float($var))
				return $var;

			return $or;
		}

		/**
		 * Check if float values are set.
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
		 * @return boolean TRUE if all arguments are floats.
		 */
		public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_float($_arg))
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
				if(!isset($_arg) || !is_float($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if float values are NOT empty.
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
		 * @return boolean TRUE if all arguments are floats, and they're NOT empty.
		 */
		public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_float($_arg))
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
				if(empty($_arg) || !is_float($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if float values are NOT empty in floats/arrays/objects.
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
		 * @return boolean TRUE if all arguments are floats — or arrays/objects containing floats; and NONE of the floats scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing floats.
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
				else if(empty($_arg) || !is_float($_arg))
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
				else if(empty($_arg) || !is_float($_arg))
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
		 * @return float The first float argument that's NOT empty, else `0.0`.
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_float($_arg))
					return $_arg;

			return 0.0;
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
				if(!empty($_arg) && is_float($_arg))
					return $_arg;

			return 0.0;
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
		 * @return float The first float argument, else `0.0`.
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_float($_arg))
					return $_arg;

			return 0.0;
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
				if(isset($_arg) && is_float($_arg))
					return $_arg;

			return 0.0;
		}

		/**
		 * Forces an initial float value (NOT a deep scan).
		 *
		 * @param !object $value Anything but an object.
		 *
		 * @return float Floatified value. This forces an initial float value at all times.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.float.php#language.types.float.casting}
		 */
		public function ify($value)
		{
			$this->check_arg_types('!object', func_get_args());

			return (float)$value;
		}

		/**
		 * Forces float values deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed $value Anything can be converted to a float value.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @return float|array|object Floatified value, array, or an object.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.float.php#language.types.float.casting}
		 */
		public function ify_deep($value)
		{
			if(is_array($value) || is_object($value))
			{
				foreach($value as &$_value)
					$_value = $this->ify_deep($_value);
				return $value;
			}
			return (float)$value;
		}
	}
}