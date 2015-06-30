<?php
/**
 * Object (Outside Scope) Utilities.
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
	 * Object (Outside Scope) Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 */
	class objects_os // Keep this out of scope.
	{
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
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws \exception If there is a missing and/or invalid `$instance`.
		 */
		public function __construct($instance)
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
		}

		/**
		 * Array of visible default properties for a given object (including static properties).
		 *
		 * @param string|object $class_object A class name (including any namespace prefixes), or an object instance.
		 *
		 * @return array Visible default properties (including static properties).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_all_visible_default_properties($class_object)
		{
			$this->plugin->check_arg_types(array('string:!empty', 'object'), func_get_args());

			if(is_object($class_object))
				$class_name = get_class($class_object);
			else $class_name = $class_object;

			if(is_array($get_class_vars = get_class_vars($class_name)))
				return $get_class_vars;

			return array(); // Default return value.
		}

		/**
		 * Array of visible non-static properties for an object instance.
		 *
		 * @param object $object An object instance is required for this routine.
		 *
		 * @return array Visible non-static properties.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_non_static_visible_properties($object)
		{
			$this->plugin->check_arg_types('object', func_get_args());

			if(is_array($get_object_vars = get_object_vars($object)))
				return $get_object_vars;

			return array(); // Default return value.
		}

		/**
		 * Array of visible object methods (including static methods).
		 *
		 * @param string|object $class_object A class name (including any namespace prefixes), or an object instance.
		 *
		 * @return array Visible object methods (including static methods).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_all_visible_methods($class_object)
		{
			$this->plugin->check_arg_types(array('string:!empty', 'object'), func_get_args());

			if(is_array($get_class_methods = get_class_methods($class_object)))
				return $get_class_methods;

			return array(); // Default return value.
		}

		/**
		 * Checks if variable is an object, and is NOT ass empty.
		 *
		 * @note PHP does NOT consider any object `empty()`, so we have an additional layer of functionality here.
		 *    An object is ass empty (assumed empty), if it has NO public properties/methods (static or otherwise).
		 *
		 * @param mixed $var Any variable (by reference, no NOTICE).
		 *
		 * @return boolean TRUE if it's an object, and it's NOT ass empty.
		 */
		public function is_not_ass_empty(&$var)
		{
			if(is_object($var) && !empty($var))
			{
				if($this->get_all_visible_default_properties($var)
				   || $this->get_non_static_visible_properties($var)
				   || $this->get_all_visible_methods($var)
				) return TRUE;
			}
			return FALSE;
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
			if(is_object($var) && !empty($var))
			{
				if($this->get_all_visible_default_properties($var)
				   || $this->get_non_static_visible_properties($var)
				   || $this->get_all_visible_methods($var)
				) return TRUE;
			}
			return FALSE;
		}
	}
}