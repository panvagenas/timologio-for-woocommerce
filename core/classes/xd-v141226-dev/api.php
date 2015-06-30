<?php
/**
 * Base API Class Abstraction
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
	 * Base API Class Abstraction
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @note Some static calls to aliases without a `©` prefix will NOT work properly.
	 *    This occurs with dynamic XDaRk Core classes that use PHP keywords.
	 *    Such as: `::array`, `::class`, `::function` and `::var`.
	 *    For these static aliases one MUST use a `©` prefix.
	 */
	abstract class api implements fw_constants
	{
		/**
		 * Framework for current plugin instance.
		 *
		 * @var framework Framework for current plugin instance.
		 *
		 * @by-constructor Set by class constructor (if API class is instantiated).
		 *
		 * @final Should NOT be overridden by class extenders.
		 *    Would be `final` if PHP allowed such a thing.
		 *
		 * @protected Available only to self & extenders.
		 */
		protected $___framework; // NULL value (by default).

		/**
		 * Constructs global framework reference.
		 *
		 * @constructor Sets up global framework reference.
		 *
		 * @throws exception If unable to locate current plugin framework instance.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public A magic/overload constructor MUST always remain public.
		 */
		final public function __construct()
		{
			$class        = get_class($this);
			$core_ns      = core()->instance->core_ns;
			$core_ns_stub = core()->instance->core_ns_stub;

			if($class === $core_ns.'\\core') // XDaRk Core internal class?
			{
				if(!isset($GLOBALS[$core_ns]) || !($GLOBALS[$core_ns] instanceof framework))
					throw core()->©exception(
						$class.'::'.__FUNCTION__.'#missing_framework_instance', get_defined_vars(),
						sprintf(core()->__('Missing $GLOBALS[\'%1$s\'] framework instance.'), $core_ns)
					);
				$this->___framework = $GLOBALS[$core_ns];
				return; // Stop (special case).
			}
			if(!isset($GLOBALS[$class]) || !($GLOBALS[$class] instanceof framework))
				throw core()->©exception(
					$class.'::'.__FUNCTION__.'#missing_framework_instance', get_defined_vars(),
					sprintf(core()->__('Missing $GLOBALS[\'%1$s\'] framework instance.'), $class)
				);
			$this->___framework = $GLOBALS[$class];
		}

		/**
		 * Handles overload properties (dynamic classes).
		 *
		 * @param string $property A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @return framework|object A singleton class instance.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic/overload methods are always public.
		 */
		final public function __get($property)
		{
			$property = (string)$property;

			return $this->___framework->{'©'.ltrim($property, '©')};
		}

		/**
		 * Sets magic/overload properties (dynamic classes).
		 *
		 * @param string $property A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @param mixed  $value The new value for this magic/overload property.
		 *
		 * @return mixed The `$value` assigned to the magic/overload `$property`.
		 *
		 * @throws exception If attempting to set magic/overload properties (this is NOT allowed).
		 *    This magic/overload method is currently here ONLY to protect magic/overload property values.
		 *    All magic/overload properties in the XDaRk Core API (and plugins that extend it); are read-only.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic/overload methods must always remain public.
		 */
		final public function __set($property, $value)
		{
			$property = (string)$property;

			throw core()->©exception(
				get_class($this).'::'.__FUNCTION__.'#read_only_magic_property_error_via____set()', get_defined_vars(),
				sprintf(core()->__('Attempting to set magic/overload property: `%1$s` (which is NOT allowed).'), $property).
				' '.sprintf(core()->__('This property MUST be defined explicitly by: `%1$s`.'), get_class($this))
			);
		}

		/**
		 * Checks magic/overload properties (dynamic classes).
		 *
		 * @param string $property A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @return boolean TRUE if the magic/overload property (dynamic class) is set; else FALSE.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic/overload methods are always public.
		 */
		final public function __isset($property)
		{
			$property = (string)$property;

			return $this->___framework->__isset('©'.ltrim($property, '©'));
		}

		/**
		 * Unsets magic/overload properties (dynamic classes).
		 *
		 * @param string $property A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @throws exception If attempting to unset magic/overload properties (this is NOT allowed).
		 *    This magic/overload method is currently here ONLY to protect magic/overload property values.
		 *    All magic/overload properties in the XDaRk Core API (and plugins that extend it); are read-only.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic/overload methods must always remain public.
		 */
		final public function __unset($property)
		{
			$property = (string)$property;

			throw core()->©exception(
				get_class($this).'::'.__FUNCTION__.'#read_only_magic_property_error_via____unset()', get_defined_vars(),
				sprintf(core()->__('Attempting to unset magic/overload property: `%1$s` (which is NOT allowed).'), $property).
				' '.sprintf(core()->__('This property MUST be defined explicitly by: `%1$s`.'), get_class($this))
			);
		}

		/**
		 * Handles overload methods (dynamic classes).
		 *
		 * @param string $method A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @param array  $args Optional. Arguments to the dynamic class constructor.
		 *
		 * @return framework|object A new dynamic class instance.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic/overload methods are always public.
		 */
		final public function __call($method, $args = array())
		{
			$method = (string)$method;
			$args   = (array)$args;

			return call_user_func_array(array($this->___framework, '©'.ltrim($method, '©')), $args);
		}

		/**
		 * Framework for current plugin instance.
		 *
		 * @return framework Framework for current plugin instance.
		 *
		 * @throws exception If unable to locate current plugin framework instance.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Available for public access.
		 */
		final public static function ___framework()
		{
			static $framework; // A static cache.

			if(isset($framework)) return $framework;

			$class        = get_called_class();
			$core_ns      = core()->instance->core_ns;
			$core_ns_stub = core()->instance->core_ns_stub;

			if($class === $core_ns.'\\core') // XDaRk Core internal class?
			{
				if(!isset($GLOBALS[$core_ns]) || !($GLOBALS[$core_ns] instanceof framework))
					throw core()->©exception(
						$class.'::'.__FUNCTION__.'#missing_framework_instance', get_defined_vars(),
						sprintf(core()->__('Missing $GLOBALS[\'%1$s\'] framework instance.'), $core_ns)
					);
				return ($framework = $GLOBALS[$core_ns]); // Stop (special case; we're all done).
			}
			if(!isset($GLOBALS[$class]) || !($GLOBALS[$class] instanceof framework))
				throw core()->©exception(
					$class.'::'.__FUNCTION__.'#missing_framework_instance', get_defined_vars(),
					sprintf(core()->__('Missing $GLOBALS[\'%1$s\'] framework instance.'), $class)
				);
			return ($framework = $GLOBALS[$class]);
		}

		/**
		 * Handles static overload methods (dynamic classes).
		 *
		 * @param string $method A dynamic class object name (w/o the `©` prefix) — simplifying usage.
		 *    The `©` prefix is optional however. We always add this prefix regardless.
		 *
		 * @param array  $args Optional. Arguments to the dynamic class constructor.
		 *
		 * @return framework|object A new dynamic class object instance.
		 *    Or, a singleton class object instance; if there are NO arguments.
		 *
		 * @final Cannot be overridden by class extenders.
		 *
		 * @public Magic methods are always public.
		 */
		final public static function __callStatic($method, $args = array())
		{
			$method = (string)$method;
			$args   = (array)$args;

			if(!empty($args)) // Instantiate a new class instance w/ arguments.
				return call_user_func_array(array(static::___framework(), '©'.ltrim($method, '©')), $args);

			return static::___framework()->{'©'.ltrim($method, '©')};
		}
	}
}