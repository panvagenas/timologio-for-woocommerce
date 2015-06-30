<?php
/**
 * Array Utilities.
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
	 * Array Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120329
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class arrays extends framework
	{
		/**
		 * Short version of `(isset() && is_array())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable `(isset() && is_array())`.
		 */
		public function is(&$var)
		{
			return is_array($var);
		}

		/**
		 * Short version of `(!empty() && is_array())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is `(!empty() && is_array())`.
		 */
		public function is_not_empty(&$var)
		{
			return !empty($var) && is_array($var);
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
			return !empty($var) && is_array($var);
		}

		/**
		 * Short version of `if(isset() && is_array()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to an empty array. This is the return value if `$var` is NOT set, or is NOT an array.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return array|mixed Value of `$var`, if `(isset() && is_array())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to an empty array).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function isset_or(&$var, $or = array(), $set_var = FALSE)
		{
			if(isset($var) && is_array($var))
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
		 * @param mixed $or This is the return value if `$var` is NOT set, or is NOT an array.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return array|mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = array())
		{
			if(isset($var) && is_array($var))
				return $var;

			return $or;
		}

		/**
		 * Short version of `if(!empty() && is_array()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to an empty array. This is the return value if `$var` IS empty, or is NOT an array.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return array|mixed Value of `$var`, if `(!empty() && is_array())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to an empty array).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_not_empty_or(&$var, $or = array(), $set_var = FALSE)
		{
			if(!empty($var) && is_array($var))
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
		 * @param mixed $or This is the return value if `$var` IS empty, or is NOT an array.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return array|mixed See `$this->is_not_empty_or()` for further details.
		 */
		public function ¤is_not_empty_or($var, $or = array())
		{
			if(!empty($var) && is_array($var))
				return $var;

			return $or;
		}

		/**
		 * Check if array values are set.
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
		 * @return boolean TRUE if all arguments are arrays.
		 */
		public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_array($_arg))
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
				if(!isset($_arg) || !is_array($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if arrays are NOT empty.
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
		 * @return boolean TRUE if all arguments are arrays, and they're NOT empty.
		 */
		public function are_not_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(empty($_arg) || !is_array($_arg))
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
				if(empty($_arg) || !is_array($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if arrays are NOT empty in arrays/objects.
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
		 * @return boolean TRUE if all arguments are arrays; or objects containing arrays; and NONE of the arrays scanned deeply are empty.
		 *    Can have multidimensional arrays/objects containing arrays.
		 *    Can have arrays with any nested value type; e.g. it's NOT an empty array.
		 *    Can have empty objects; e.g. we consider these containers.
		 */
		public function are_not_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			$in_array = '.arrays.are_not_empty_in.in-array.b'; // Cannot use a constant here; MUST be passed by reference.
			// Recursion identifier (while inside an array).

			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg))
				{
					if(empty($_arg)) return FALSE;

					foreach($_arg as $__arg)
						if(!$this->are_not_empty_in($__arg, $in_array))
							return FALSE;
				}
				else if(is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->are_not_empty_in($__arg))
							return FALSE;
				}
				else if($b !== $in_array)
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
			$in_array = '.arrays.¤are_not_empty_in.in-array.b';
			// Recursion identifier (while inside an array).

			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg))
				{
					if(empty($_arg)) return FALSE;

					foreach($_arg as $__arg)
						if(!$this->¤are_not_empty_in($__arg, $in_array))
							return FALSE;
				}
				else if(is_object($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->¤are_not_empty_in($__arg))
							return FALSE;
				}
				else if($b !== $in_array)
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
		 * @return array The first array argument that's NOT empty, else an empty array.
		 */
		public function not_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_array($_arg))
					return $_arg;

			return array();
		}

		/**
		 * Same as `$this->not_empty_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return array See `$this->not_empty_coalesce()` for further details.
		 */
		public function ¤not_empty_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!empty($_arg) && is_array($_arg))
					return $_arg;

			return array();
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
		 * @return array The first array argument, else an empty array.
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_array($_arg))
					return $_arg;
			unset($_arg);

			return array();
		}

		/**
		 * Same as `$this->isset_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return array See `$this->isset_coalesce()` for further details.
		 */
		public function ¤isset_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_array($_arg))
					return $_arg;

			return array();
		}

		/**
		 * Gets the first value in an array.
		 *
		 * @param array $array An input array.
		 *
		 * @return mixed First array value.
		 *
		 * @note This is handy, because here we're dealing with a copy of the array,
		 *    so the array itself is not modified, as it normally would be.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function first($array)
		{
			$this->check_arg_types('array', func_get_args());

			return array_shift($array); // Possible NULL value.
		}

		/**
		 * Gets the last value in an array.
		 *
		 * @param array $array An input array.
		 *
		 * @return mixed Last array value.
		 *
		 * @note This is handy, because here we're dealing with a copy of the array,
		 *    so the array itself is not modified, as it normally would be.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function last($array)
		{
			$this->check_arg_types('array', func_get_args());

			return array_pop($array); // Possible NULL value.
		}

		/**
		 * Forces an initial array value (NOT a deep scan).
		 *
		 * @param mixed   $value Anything can be converted to an array.
		 *
		 * @param boolean $include_protected_private_properties Optional. Defaults to FALSE. By default, we do NOT include protected/private properties
		 *    from objects being converted into arrays (even if they were accessible, which they are in this case). That is, when an object is converted to an array,
		 *    all of its protected/private properties are included in the array, regardless of visibility (because PHP assumes there is no security issue once converted to an array).
		 *    However, this behavior does come as a bit of a surprise, and it goes against the way most other XDaRk utility methods work. In addition, PHP will prefix
		 *    each protected/private property with NULL bytes and namespace\class paths, resulting in a counterintuitive array of elements containing difficult-to-access keys.
		 *
		 *    Therefore, this routine will exclude protected/private properties by default. This behavior can be modified by
		 *    setting `$include_protected_private_properties` to TRUE. If this is TRUE, protected/private properties *will* be included.
		 *    When/if included, this routine removes the NULL byte and namespace\class paths, making protected/private property keys easy to access.
		 *    Static properties are NEVER considered by this routine, because static properties are ignored while typecasting objects to arrays in PHP.
		 *
		 * @return array Arrayified value. This forces an initial array value at all times.
		 *    This automatically includes both scalars and resources too.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.array.php#language.types.array.casting}
		 */
		public function ify($value, $include_protected_private_properties = FALSE)
		{
			if(is_object($value))
			{
				$value = (array)$value;

				foreach($value as $_key => $_value)
					if(strpos($_key, "\0") === 0)
					{
						unset($value[$_key]);
						if($include_protected_private_properties)
						{
							$_key         = (string)substr($_key, strrpos($_key, "\0") + 1);
							$value[$_key] = $_value;
						}
					}
				return $value;
			}
			return (array)$value;
		}

		/**
		 * Forces array values deeply (and intuitively).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 *    Objects convert to arrays. Each object is then scanned deeply as an array value.
		 *
		 * @note By default, this routine will NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if `$include_protected_private_properties` is TRUE.
		 *    Static properties are NEVER considered by this routine, because static properties are ignored while typecasting objects to arrays in PHP.
		 *
		 * @param mixed   $value Anything can be converted to an array.
		 *    However, please see the details regarding parameter `$include_scalars_resources`.
		 *    By default, we do NOT arrayify scalars and/or resources in this routine.
		 *
		 * @param boolean $include_protected_private_properties Optional. Defaults to FALSE. By default, we do NOT include protected/private properties
		 *    from objects now converted into arrays (even if they were accessible, which they are in this case). That is, when an object is converted to an array,
		 *    all of its protected/private properties are included in the array, regardless of visibility (because PHP assumes there is no security issue once converted to an array).
		 *    However, this behavior does come as a bit of a surprise, and it goes against the way most other XDaRk utility methods work. In addition, PHP will prefix
		 *    each protected/private property with NULL bytes and namespace\class paths, resulting in a counterintuitive array of elements containing difficult-to-access keys.
		 *
		 *    Therefore, this routine will exclude protected/private properties by default. This behavior can be modified by
		 *    setting `$include_protected_private_properties` to TRUE. If this is TRUE, protected/private properties *will* be included.
		 *    When/if included, this routine removes the NULL byte and namespace\class paths, making protected/private property keys easy to access.
		 *    Static properties are NEVER considered by this routine, because static properties are ignored while typecasting objects to arrays in PHP.
		 *
		 * @param boolean $include_scalars_resources Optional. Defaults to FALSE. By default, we do NOT arrayify scalars and/or resources.
		 *    Typecasting scalars and/or resources to arrays, counterintuitively results in an array with a single inner value.
		 *    While this might be desirable in some cases, it is FALSE by default. Set this as TRUE, to enable such behavior.
		 *
		 * @param boolean $___recursion Internal use only. Tracks recursion in this routine.
		 *
		 * @return array|mixed Arrayified value. Even objects are converted into array values by this routine.
		 *    However, this method may also return other mixed value types, depending on the parameter: `$include_scalars_resources`.
		 *    If `$include_scalars_resources` is FALSE (it is by default); passing a scalar and/or resource value into this method,
		 *    will result in a return value that is unchanged (i.e. by default we do NOT arrayify scalars and/or resources).
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.array.php#language.types.array.casting}
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ify_deep($value, $include_protected_private_properties = FALSE, $include_scalars_resources = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'boolean', 'boolean', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				if(is_object($value))
				{
					$value = (array)$value;

					foreach($value as $_key => $_value)
						if(strpos($_key, "\0") === 0)
						{
							unset($value[$_key]);
							if($include_protected_private_properties)
							{
								$_key         = (string)substr($_key, strrpos($_key, "\0") + 1);
								$value[$_key] = $_value;
							}
						}
					unset($_key, $_value); // Housekeeping.
				}
				foreach($value as &$_value)
					$_value = $this->ify_deep($_value, $include_protected_private_properties, $include_scalars_resources, TRUE);
				return $value;
			}
			if($include_scalars_resources)
				return (array)$value;

			return $value;
		}

		/**
		 * Gets array values from a specific dimension.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of an array.
		 *    This allows you to obtain all values from a specific dimension; in ANY key.
		 *
		 * @param array   $array Any input array will do fine here.
		 *
		 * @param integer $from_dimension Optional. Defaults to `1`; but normally this is `2` or higher.
		 *    In the case of `1`, it's simpler to just call `array_values()` (native to PHP).
		 *
		 * @param boolean $preserve_keys Optional. Defaults to a FALSE value.
		 *
		 *    If this is TRUE, we'll preserve existing keys. However, please use CAUTION with this.
		 *       Use only when there is CERTAINTY about what the input array contains.
		 *
		 *    CAUTION: An example which demonstrates conflicting keys.
		 *       Values from the 2nd and/or 3rd dimensions have duplicate keys.
		 *       ~ Duplicate keys will override previous keys.
		 *
		 *    `$array[0][1][2] = 'hello';`
		 *    `$array[1][1][2] = 'world';`
		 *
		 *    Values from 2nd dimension = `array(1 => 'world')`; e.g. missing 1st value.
		 *    Values from 3rd dimension = `array(2 => 'world')`; e.g. missing 1st value.
		 *
		 * @param integer $___current_dimension Internal use only.
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Array values (numerically indexed); else an empty array on failure.
		 *    If the requested dimension is NOT available; an empty array (e.g. a failure).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function values($array, $from_dimension = 1, $preserve_keys = FALSE, $___current_dimension = 1, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'integer', 'boolean', 'integer:!empty', 'boolean', func_get_args());

			if($from_dimension <= 1) // This is exactly the same as `array_values()`.
				return array_values($array); // Just in case it's called this way.

			$values = array(); // Initialize array of values.

			foreach($array as $_value)
			{
				if(!is_array($_value)) continue;

				foreach($_value as $__key => $__value)
					if($preserve_keys) $values[$__key] = $__value;
					else $values[] = $__value; // Better (default behavior).
				unset($__key, $__value); // Housekeeping.
			}
			unset($_value); // Housekeeping.

			if($from_dimension === $___current_dimension + 1) return $values;

			return $this->values($values, $from_dimension, $preserve_keys, $___current_dimension + 1, TRUE);
		}

		/**
		 * Builds an array w/ ONE dimension; using DOT `.` keys (e.g. `key.ID`).
		 *
		 * @param array $array Any input array will do fine here.
		 *
		 * @return array An array w/ ONE dimension; using DOT `.` keys.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function dot_keys($array)
		{
			$this->check_arg_types('array', func_get_args());

			foreach(($iterator = $this->iterator($array)) as $_value)
			{
				$_keys = array(); // Initialize keys.

				foreach(range(0, $iterator->getDepth()) as $_depth)
					$_keys[] = $iterator->getSubIterator($_depth)->key();

				$dot_keys[join('.', $_keys)] = $_value;

				unset($_keys, $_depth); // Housekeeping.
			}
			return !empty($dot_keys) ? $dot_keys : array();
		}

		/**
		 * Converts PHP arrays into JS arrays/objects (or JS array values; or JS object properties).
		 *
		 * @note This follows JSON standards; except we use single quotes instead of double quotes.
		 *    Also, see {@link strings::esc_js_sq_deep()} for subtle differences when it comes to line breaks.
		 *    • Special handling for line breaks in strings: `\r\n` and `\r` are converted to `\n`.
		 *
		 * @param array   $array A PHP array to convert to a JS array/object (or JS array values; or JS object properties).
		 *    IMPORTANT: A PHP array is ONLY converted to a true JavaScript array if it's indexed numerically with a `0` based index.
		 *    In all other cases the array is treated as associative; and it's converted to a JavaScript object; following JSON standards.
		 *
		 * @param boolean $encapsulate Optional. This defaults to a TRUE value (recommended).
		 *    If set to FALSE, we return JS array values or JS object properties only (i.e. w/o `[]` or `{}` encapsulations).
		 *
		 * @return string A JS array/object (or JS array values; or JS object properties). See `$encapsulate` parameter.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_js($array, $encapsulate = TRUE)
		{
			$this->check_arg_types('array', 'boolean', func_get_args());

			$js = $this->©var->to_js($array); // Produces a JavaScript array `[]` or object `{}`.

			return !$encapsulate ? ltrim(rtrim($js, '}]'), '{[') : $js;
		}

		/**
		 * Forces an array to a single dimension.
		 *
		 * @param array $array Input array.
		 *
		 * @return array Output array, with only ONE dimension.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_one_dimension($array)
		{
			$this->check_arg_types('array', func_get_args());

			foreach($array as $_key => $_value)
			{
				if(is_array($_value) || is_object($_value))
					unset($array[$_key]);
			}
			return $array;
		}

		/**
		 * Force lowercase array keys (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array   $array Input array.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array, with all lowercase keys (deeply).
		 *    Integer keys are converted to string keys.
		 *
		 * @see http://www.php.net/manual/en/function.array-change-key-case.php
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function lc_keys_deep($array, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'boolean', func_get_args());

			$lc_keys = array(); // Initialize new array.

			foreach($array as $_key => $_value)
			{
				$_key = strtolower((string)$_key);

				if(is_array($_value))
					$lc_keys[$_key] = $this->lc_keys_deep($_value, TRUE);
				else $lc_keys[$_key] = $_value;
			}
			return $lc_keys;
		}

		/**
		 * Sorts arrays by key (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 * @note For mixed key types, use the `SORT_STRING` flag.
		 *
		 * @param array   $array Input array (NOT by reference).
		 *
		 * @param integer $flags Same flags as PHP's `ksort()` function.
		 *    Defaults to `SORT_REGULAR`.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array, sorted by keys (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ksort_deep($array, $flags = SORT_REGULAR, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'integer', 'boolean', func_get_args());

			ksort($array, $flags);

			foreach($array as &$_value)
			{
				if(is_array($_value))
					$_value = $this->ksort_deep($_value, $flags, TRUE);
			}
			return $array;
		}

		/**
		 * Removes all numeric array keys (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array   $array An input array.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array with only non-numeric keys (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remove_numeric_keys_deep($array, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'boolean', func_get_args());

			foreach($array as $_key => &$_value)
			{
				if(is_numeric($_key))
					unset($array[$_key]);

				else if(is_array($_value))
					$_value = $this->remove_numeric_keys_deep($_value, TRUE);
			}
			return $array;
		}

		/**
		 * Removes all empty values from an array (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array   $array An input array.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array with all empty values removed (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remove_empty_values_deep($array, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'boolean', func_get_args());

			foreach($array as $_key => &$_value)
			{
				if(is_array($_value))
					$_value = $this->remove_empty_values_deep($_value, TRUE);
				if(empty($_value)) unset($array[$_key]);
			}
			return $array;
		}

		/**
		 * Removes all null values from an array (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array   $array An input array.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array with all null values removed (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remove_nulls_deep($array, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'boolean', func_get_args());

			foreach($array as $_key => &$_value)
			{
				if(is_array($_value))
					$_value = $this->remove_nulls_deep($_value, TRUE);
				else if(is_null($_value)) unset($array[$_key]);
			}
			return $array;
		}

		/**
		 * Removes all 0-byte strings from an array (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array   $array An input array.
		 *
		 * @param boolean $___recursion Internal use only.
		 *
		 * @return array Output array with all 0-byte strings removed (deeply).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remove_0b_strings_deep($array, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('array', 'boolean', func_get_args());

			foreach($array as $_key => &$_value)
			{
				if(is_array($_value))
					$_value = $this->remove_0b_strings_deep($_value, TRUE);
				else if(is_string($_value) && !isset($_value[0]))
					unset($array[$_key]);
			}
			return $array;
		}

		/**
		 * Forces an array to contain only unique values (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array $array An input array.
		 *
		 * @return array The output array, containing only unique array values deeply.
		 *
		 * @note Resource pointers CANNOT be serialized, and will therefore be lost (i.e. corrupted) when/if they're nested deeply inside the input array.
		 *    Resources NOT nested deeply, DO remain intact (this is fine). Only resource pointers nested deeply are lost via `serialize()`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function unique_deep($array)
		{
			$this->check_arg_types('array', func_get_args());

			foreach($array as &$_value)
			{
				if(!is_resource($_value))
					$_value = serialize($_value);
			}
			unset($_value);

			$array = array_unique($array);

			foreach($array as &$_value)
			{
				if(!is_resource($_value))
					$_value = unserialize($_value);
			}
			return $array;
		}

		/**
		 * Compiles a new array of all `$key` elements.
		 *
		 * @see compile_key_elements_deep()
		 * @inheritdoc compile_key_elements_deep()
		 *
		 * @return array {@inheritdoc}
		 */
		public function compile_key_elements($array, $keys, $preserve_keys = FALSE, $search_dimensions = 1)
		{
			return $this->compile_key_elements_deep($array, $keys, $preserve_keys, $search_dimensions);
		}

		/**
		 * Compiles a new array of all `$key` elements (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays.
		 *
		 * @param array                $array An input array to search in.
		 *
		 * @param string|integer|array $keys An array of `key` elements to compile.
		 *    In other words, elements with one of these array keys, are what we're looking for.
		 *    A string|integer is also accepted here (if only one key), and it's converted internally to an array.
		 *
		 * @param boolean              $preserve_keys Optional. Defaults to a FALSE value.
		 *    If this is TRUE, the return array WILL preserve numeric/associative keys, instead of forcing a numerically indexed array.
		 *    This ALSO prevents duplicates in the return array, which may NOT be desirable in certain circumstances.
		 *    Particularly when/if searching a multidimensional array (where keys could be found in multiple dimensions).
		 *    In fact, in some cases, this could return data you did NOT want/expect, so please be cautious.
		 *
		 * @param integer              $search_dimensions The number of dimensions to search. Defaults to `-1` (infinite).
		 *    If `$preserve_keys` is TRUE, consider setting this to a value of `1`.
		 *
		 * @param integer              $___current_dimension For internal use only; used in recursion.
		 *
		 * @return array The array of compiled key elements, else an empty array, if no key elements were found.
		 *    By default, the return array will be indexed numerically (e.g. keys are NOT preserved here).
		 *    If an associative array is preferred, please set `$preserve_keys` to a TRUE value,
		 *       and please consider setting `$search_dimensions` to `1`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function compile_key_elements_deep($array, $keys, $preserve_keys = FALSE, $search_dimensions = -1, $___current_dimension = 1)
		{
			if($___current_dimension === 1) // We only check arg types initially (i.e. do NOT check recursions).
				$this->check_arg_types('array', array('string', 'integer', 'array'), 'boolean', 'integer', 'integer', func_get_args());

			$key_elements = array(); // Initialize this array.
			$keys         = (array)$keys; // Force array.

			foreach($array as $_key => $_value)
			{
				if(in_array($_key, $keys, TRUE))
					if($preserve_keys) $key_elements[$_key] = $_value;
					else $key_elements[] = $_value;

				if(($search_dimensions < 1 || $___current_dimension < $search_dimensions) && is_array($_value)
				   && ($_key_elements = $this->compile_key_elements_deep($_value, $keys, $preserve_keys, $search_dimensions, $___current_dimension + 1))
				) $key_elements = array_merge($key_elements, $_key_elements);
			}
			return $key_elements;
		}

		/**
		 * Recursive iterator.
		 *
		 * @param array $array Any input array will do fine here.
		 *
		 * @return \RecursiveIteratorIterator Recursive iterator.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function iterator($array)
		{
			$this->check_arg_types('array', func_get_args());

			return new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
		}

        /**
         * Recursively calculates diff of two arrays
         *
         * @param $array1
         * @param $array2
         * @param bool $___recursion Internal, checks if is recursion
         *
         * @return array
         * @throws \xd_v141226_dev\exception
         *
         * @kudos http://forums.devshed.com/php-development/560363-array_diff_assoc-multidimensional-array-post2130226.html#post2130226
         */
        public function array_dif_assoc_deep( $array1, $array2, $___recursion = false ) {
            if ( ! $___recursion ) {
                $this->check_arg_types( 'array', 'array', 'boolean', func_get_args() );
            }

            $ret = array();

            foreach ( $array1 as $k => $v ) {
                if ( ! isset( $array2[ $k ] ) ) {
                    $ret[ $k ] = $v;
                } else if ( is_array( $v ) && is_array( $array2[ $k ] ) ) {
                    $temp = $this->array_dif_assoc_deep( $v, $array2[ $k ], true );
                    if(empty($temp)){
                        $ret = null;
                    } else {
                        $ret[ $k ] = $temp;
                    }
                } else if ( $v != $array2[ $k ] ) {
                    $ret[ $k ] = $v;
                }
            }

            return $ret;

        }
	}
}