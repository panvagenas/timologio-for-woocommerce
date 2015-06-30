<?php
/**
 * Object Utilities.
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
	 * Object Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class objects extends framework
	{
		/**
		 * Short version of `(isset() && is_object())`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable `(isset() && is_object())`.
		 */
		public function is(&$var)
		{
			return is_object($var);
		}

		/**
		 * Short version of `(!empty() && is_object() && NOT ass empty)`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @return boolean TRUE if the variable is `(!empty() && is_object() && NOT ass empty)`.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 */
		public function is_not_ass_empty(&$var)
		{
			return $this->©object_os->is_not_ass_empty($var);
		}

		/**
		 * Same as `$this->is_not_ass_empty()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @return boolean See `$this->is_not_ass_empty()` for further details.
		 */
		public function ¤is_not_ass_empty($var)
		{
			return $this->©object_os->¤is_not_ass_empty($var);
		}

		/**
		 * Short version of `if(isset() && is_object()){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` is NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `stdClass`. This is the return value if `$var` is NOT set, or is NOT an object.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return object|mixed Value of `$var`, if `(isset() && is_object())`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `stdClass`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function isset_or(&$var, $or = NULL, $set_var = FALSE)
		{
			if(isset($var) && is_object($var))
				return $var;

			$or = (func_num_args() >= 2) ? $or : new \stdClass();

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->isset_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` is NOT set, or is NOT an object.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return object|mixed See `$this->isset_or()` for further details.
		 */
		public function ¤isset_or($var, $or = NULL)
		{
			if(isset($var) && is_object($var))
				return $var;

			$or = (func_num_args() >= 2) ? $or : new \stdClass();

			return $or;
		}

		/**
		 * Short version of `if(!empty() && is_object() and NOT ass empty){} else{}`.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @param mixed   $var A variable by reference (no NOTICE).
		 *    If `$var` was NOT already set, it will be set to NULL by PHP, as a result of passing it by reference.
		 *
		 * @param mixed   $or Defaults to `stdClass`. This is the return value if `$var` IS empty, or is NOT an object.
		 *
		 * @param boolean $set_var Defaults to FALSE. If TRUE, the value of `$var` will be set (via reference) to the return value.
		 *
		 * @return object|mixed Value of `$var`, if `(!empty() && is_object() and NOT ass empty)`.
		 *    Else returns `$or` (which could be any mixed data type — defaults to `stdClass`).
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_not_ass_empty_or(&$var, $or = NULL, $set_var = FALSE)
		{
			if($this->©object_os->is_not_ass_empty($var))
				return $var;

			$or = (func_num_args() >= 2) ? $or : new \stdClass();

			if($set_var)
				return ($var = $or);

			return $or;
		}

		/**
		 * Same as `$this->is_not_ass_empty_or()`, but this allows an expression.
		 *
		 * @param mixed $var A variable (or an expression).
		 *
		 * @param mixed $or This is the return value if `$var` IS empty, or is NOT an object.
		 *
		 * @note This does NOT support the `$set_var` parameter, because `$var` is NOT by reference here.
		 *
		 * @return object|mixed See `$this->is_not_ass_empty_or()` for further details.
		 */
		public function ¤is_not_ass_empty_or($var, $or = NULL)
		{
			if($this->©object_os->¤is_not_ass_empty($var))
				return $var;

			$or = (func_num_args() >= 2) ? $or : new \stdClass();

			return $or;
		}

		/**
		 * Check if object values are set.
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
		 * @return boolean TRUE if all arguments are objects.
		 */
		public function are_set(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!isset($_arg) || !is_object($_arg))
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
				if(!isset($_arg) || !is_object($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if object values are NOT ass empty.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
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
		 * @return boolean TRUE if all arguments are objects, and they're NOT ass empty.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 */
		public function are_not_ass_empty(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!$this->©object_os->is_not_ass_empty($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Same as `$this->are_not_ass_empty()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->are_not_ass_empty()` for further details.
		 */
		public function ¤are_not_ass_empty($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(!$this->©object_os->¤is_not_ass_empty($_arg))
					return FALSE;

			return TRUE;
		}

		/**
		 * Check if objects are NOT ass empty in arrays/objects.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
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
		 * @return boolean TRUE if all arguments are objects or arrays containing objects; and none of the objects scanned deeply are empty; else FALSE.
		 *    Can have multidimensional arrays/objects containing objects.
		 *    Can have objects containing any property value; i.e. it's NOT an empty object.
		 *    Can have empty arrays; e.g. we consider these data containers.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 */
		public function are_not_ass_empty_in(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			$in_object = '.objects.are_not_ass_empty_in.in-object.b'; // Cannot use a constant here; MUST be passed by reference.
			// Recursion identifier (while inside an object).

			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->are_not_ass_empty_in($__arg))
							return FALSE;
				}
				else if(is_object($_arg))
				{
					if(!$this->©object_os->is_not_ass_empty($_arg))
						return FALSE;

					foreach($_arg as $__arg)
						if(!$this->are_not_ass_empty_in($__arg, $in_object))
							return FALSE;
				}
				else if($b !== $in_object)
					return FALSE;
			}
			return TRUE;
		}

		/**
		 * Same as `$this->are_not_ass_empty_in()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return boolean See `$this->are_not_ass_empty_in()` for further details.
		 */
		public function ¤are_not_ass_empty_in($a, $b = NULL, $c = NULL)
		{
			$in_object = '.objects.¤are_not_ass_empty_in.in-object.b';
			// Recursion identifier (while inside an object).

			foreach(func_get_args() as $_arg)
			{
				if(is_array($_arg))
				{
					foreach($_arg as $__arg)
						if(!$this->are_not_ass_empty_in($__arg))
							return FALSE;
				}
				else if(is_object($_arg))
				{
					if(!$this->©object_os->¤is_not_ass_empty($_arg))
						return FALSE;

					foreach($_arg as $__arg)
						if(!$this->¤are_not_ass_empty_in($__arg, $in_object))
							return FALSE;
				}
				else if($b !== $in_object)
					return FALSE;
			}
			return TRUE;
		}

		/**
		 * NOT ass empty coalesce.
		 *
		 * @note Unlike PHP's `is_...` functions, this will NOT throw a NOTICE.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
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
		 * @return object The first object argument that's NOT ass empty, else `stdClass`.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 */
		public function not_ass_empty_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if($this->©object_os->is_not_ass_empty($_arg))
					return $_arg;

			return new \stdClass();
		}

		/**
		 * Same as `$this->not_ass_empty_coalesce()`, but this allows expressions.
		 *
		 * @param mixed $a
		 * @param mixed $b
		 * @param mixed $c
		 * @params-variable-length
		 *
		 * @return object See `$this->not_ass_empty_coalesce()` for further details.
		 */
		public function ¤not_ass_empty_coalesce($a, $b = NULL, $c = NULL)
		{
			foreach(func_get_args() as $_arg)
				if($this->©object_os->¤is_not_ass_empty($_arg))
					return $_arg;

			return new \stdClass();
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
		 * @return object The first object argument, else `stdClass`.
		 */
		public function isset_coalesce(&$a, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL, &$g = NULL, &$h = NULL, &$i = NULL, &$j = NULL, &$k = NULL, &$l = NULL, &$m = NULL, &$n = NULL, &$o = NULL, &$p = NULL, &$q = NULL, &$r = NULL, &$s = NULL, &$t = NULL, &$u = NULL, &$v = NULL, &$w = NULL, &$x = NULL, &$y = NULL, &$z = NULL)
		{
			foreach(func_get_args() as $_arg)
				if(isset($_arg) && is_object($_arg))
					return $_arg;

			return new \stdClass();
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
				if(isset($_arg) && is_object($_arg))
					return $_arg;

			return new \stdClass();
		}

		/**
		 * Forces an initial object value (NOT a deep scan).
		 *
		 * @param mixed $value Anything can be converted to an object.
		 *
		 * @return object Objectified value. This forces an initial object value at all times.
		 *    This automatically includes both scalars and resources too.
		 *
		 * @note Scalar and/or resource values (when converted to objects), result in an object with a single `scalar` property value.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.object.php#language.types.object.casting}
		 */
		public function ify($value)
		{
			return (object)$value;
		}

		/**
		 * Forces object values deeply (and intuitively).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 *    Arrays convert to objects. Each array is then scanned deeply as an object value.
		 *
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Anything can be converted to an object.
		 *    However, please see the details regarding parameter `$include_scalars_resources`.
		 *    By default, we do NOT objectify scalars and/or resources in this routine.
		 *
		 * @param boolean $include_scalars_resources Optional. Defaults to FALSE. By default, we do NOT objectify scalars and/or resources.
		 *    Typecasting scalars and/or resources to objects, counterintuitively results in an object with a single `scalar` property.
		 *    While this might be desirable in some cases, it is FALSE by default. Set this as TRUE, to enable such behavior.
		 *
		 * @return object|mixed Objectified value. Even arrays are converted into object values by this routine.
		 *    However, this method may also return other mixed value types, depending on the parameter: `$include_scalars_resources`.
		 *    If `$include_scalars_resources` is FALSE (it is by default); passing a scalar and/or resource value into this method,
		 *    will result in a return value that is unchanged (i.e. by default we do NOT objectify scalars and/or resources).
		 *
		 * @note Scalar and/or resource values (when/if converted to objects), result in an object with a single `scalar` property value.
		 *
		 * @see {@link http://www.php.net/manual/en/language.types.object.php#language.types.object.casting}
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ify_deep($value, $include_scalars_resources = FALSE)
		{
			$this->check_arg_types('', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				if(is_array($value))
					$value = (object)$value;

				foreach($value as &$_value)
					$_value = $this->ify_deep($_value, $include_scalars_resources);
				return $value;
			}
			if($include_scalars_resources)
				return (object)$value;

			return $value;
		}

		/**
		 * Converts PHP objects into JS objects (or JS object properties).
		 *
		 * @note This follows JSON standards; except we use single quotes instead of double quotes.
		 *    Also, see {@link strings::esc_js_sq_deep()} for subtle differences when it comes to line breaks.
		 *    • Special handling for line breaks in strings: `\r\n` and `\r` are converted to `\n`.
		 *
		 * @param object  $object A PHP object to convert to a JS object (or JS object properties).
		 *
		 * @param boolean $encapsulate Optional. This defaults to a TRUE value (recommended).
		 *    If set to FALSE, we return JS object properties only (i.e. without `{}` encapsulation).
		 *
		 * @return string A JS object (or JS object properties). See `$encapsulate` parameter.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_js($object, $encapsulate = TRUE)
		{
			$this->check_arg_types('object', 'boolean', func_get_args());

			$js = $this->©var->to_js($object); // Produces a JavaScript object `{}`.

			return !$encapsulate ? ltrim(rtrim($js, '}'), '{') : $js;
		}
	}
}