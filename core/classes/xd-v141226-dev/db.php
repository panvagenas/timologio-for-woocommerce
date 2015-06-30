<?php
/**
 * Database.
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
	 * Database.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 *
	 * @augments \wpdb
	 */
	class db extends framework
	{
		/**
		 * WordPress® database object instance.
		 *
		 * @var \wpdb WordPress® database object instance.
		 */
		private $wpdb; // Set by constructor.

		/**
		 * @var boolean TRUE if modifying plugin tables.
		 */
		private $is_modifying_plugin_tables = FALSE; // Default value.

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			if(!isset($GLOBALS['wpdb']) || !($GLOBALS['wpdb'] instanceof \wpdb))
				throw $this->©exception($this->method(__FUNCTION__).'#wpdb_missing', get_defined_vars(),
				                        $this->__('Missing WordPress® database class instance.'));

			$this->wpdb = $GLOBALS['wpdb'];
		}

		/**
		 * Are we currently modifying plugin tables?
		 *
		 * @param null|boolean $is_modifying_plugin_tables Defaults to a NULL value.
		 *    If this is set, we'll update the current status of `is_modifying_plugin_tables`.
		 *
		 * @return boolean TRUE if modifying plugin tables, else FALSE by default.
		 */
		public function is_modifying_plugin_tables($is_modifying_plugin_tables = NULL)
		{
			$this->check_arg_types(array('null', 'boolean'), func_get_args());

			if(isset($is_modifying_plugin_tables))
				$this->is_modifying_plugin_tables = $is_modifying_plugin_tables;

			return $this->is_modifying_plugin_tables;
		}

		/**
		 * Checks overload properties (and dynamic singleton class instances).
		 *
		 * @param string $property Name of a valid overload property.
		 *    Or a dynamic class to check on, using the special class `©` prefix.
		 *
		 * @return boolean TRUE if the overload property (or dynamic singleton class instance) is set.
		 *    Otherwise, this will return FALSE by default (i.e. the property is NOT set).
		 */
		public function __isset($property)
		{
			$property = (string)$property;

			if(property_exists($this->wpdb, $property))
				return isset($this->wpdb->$property);

			return parent::__isset($property); // Default return value.
		}

		/**
		 * Handles overload properties (and dynamic singleton class instances).
		 *
		 * @param string $property Name of a valid overload property.
		 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
		 *
		 * @return mixed Dynamic property values, or a dynamic object instance; else an exception is thrown.
		 *    Dynamic class instances are defined explicitly in the docBlock above.
		 *    This way IDEs will jive with this dynamic behavior.
		 *
		 * @throws exception If `$property` CANNOT be defined in any way.
		 */
		public function __get($property)
		{
			$property = (string)$property; // Typecasting this to a string value.

			if(property_exists($this->wpdb, $property))
				return $this->wpdb->$property;

			return parent::__get($property); // Default return value.
		}

		/**
		 * Handles overload methods (and dynamic class instances).
		 *
		 * @param string $method Name of a valid overload method to call upon.
		 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
		 *    Or a dynamic singleton class method to call upon; also using the `©` prefix, along with a `.method_name` suffix.
		 *
		 * @param array  $args An array of arguments to the overload method, or dynamic class object constructor.
		 *    In the case of dynamic objects, it's fine to exclude the first argument, which is handled automatically by this routine.
		 *    That is, the first argument to any extender is always the parent instance (i.e. `$this`).
		 *
		 * @return mixed Dynamic return values, or a dynamic object instance; else an exception is thrown.
		 *
		 * @throws exception If `$method` CANNOT be defined in any way.
		 */
		public function __call($method, $args)
		{
			$method = (string)$method; // Typecasting this to a string value.
			$args   = (array)$args; // Typecast these arguments to an array value.

			if(method_exists($this->wpdb, $method)) // Method in WordPress® database class?
			{
				if(!empty($args[0]) && is_string($args[0]) // Have an arg to inspect below?
				   && !in_array($method, array('escape', '_real_escape'), TRUE) // Early exclusion.
				   && !$this->©plugin->is_active_at_current_version() && !$this->is_modifying_plugin_tables()
					// Stops plugin table queries, when plugin is NOT active at it's current version (on current blog).
				) // NOTE: We try to catch `escape`, `_real_escape` early, to prevent unnecessary processing here.
				{
					$lc_method                        = strtolower($method);
					$plugin_tables_imploded_for_regex = $this->©db_tables->imploded_for_regex();

					if( // In all of these cases, we're looking at a full MySQL query string.
						(in_array($lc_method, array('query', 'get_var', 'get_row', 'get_col', 'get_results'), TRUE)
						 && preg_match('/`(?:'.$plugin_tables_imploded_for_regex.')`/', $args[0]))

						// In all of these cases, we're looking at a specific table name.
						|| (in_array($lc_method, array('insert', 'replace', '_insert_replace_helper', 'update', 'delete'), TRUE)
						    && preg_match('/^(?:'.$plugin_tables_imploded_for_regex.')$/', $args[0]))

					) return NULL; // Stop plugin queries.

				} // Else call upon the WordPress® DB class.
				return call_user_func_array(array($this->wpdb, $method), $args);
			}
			return parent::__call($method, $args); // Default return value.
		}
	}
}