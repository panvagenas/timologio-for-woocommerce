<?php
/**
 * XDaRk Core Autoloader.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# XDaRk Core autoloader (only if it does NOT exist yet). Autoloads the XDaRk Core (and plugins powered by it).
# -----------------------------------------------------------------------------------------------------------------------------------------
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	if(!class_exists('\\'.__NAMESPACE__.'\\autoloader'))
	{
		# --------------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core stub class; and an internal/namespaced alias.
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!class_exists('\\'.__NAMESPACE__))
		{
			$GLOBALS['autoload_'.__NAMESPACE__] = FALSE;
			require_once dirname(dirname(dirname(__FILE__))).'/stub.php';
		}
		if(!class_exists('\\'.__NAMESPACE__.'\\stub'))
			class_alias('\\'.__NAMESPACE__, __NAMESPACE__.'\\stub');

		# --------------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core autoloader definition.
		# --------------------------------------------------------------------------------------------------------------------------------
		/**
		 * XDaRk Core Autoloader.
		 *
		 * @package XDaRk\Core
		 * @since 120318
		 *
		 * @note This should NOT rely directly or indirectly on any other core class objects.
		 *    Any static properties/methods in the XDaRk Core stub will be fine to use though.
		 */
		final class autoloader // Static properties/methods only please.
		{
			# -----------------------------------------------------------------------------------------------------------------------------
			# Protected/static autoloader properties (many of these are defined by the initializer).
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initialized yet?
			 *
			 * @var boolean Initialized yet?
			 *
			 * @by-initializer Set by initializer.
			 */
			protected static $initialized = FALSE;

			/**
			 * Map of special classes.
			 *
			 * @var array Map of special classes.
			 *
			 * @by-initializer Set by initializer.
			 */
			protected static $special_classes_map = array();

			/**
			 * Core classes directory.
			 *
			 * @var string Core classes directory.
			 *
			 * @by-initializer Set by initializer.
			 */
			protected static $core_classes_dir = '';

			/**
			 * Array of directories containing classes.
			 *
			 * @var array Array of directories containing classes.
			 *
			 * @by-initializer Set by initializer.
			 */
			protected static $class_dirs = array();

			# -----------------------------------------------------------------------------------------------------------------------------
			# Initializer.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initializes the XDaRk Core autoloader.
			 *
			 * @return boolean Returns the `$initialized` property w/ a TRUE value.
			 *
			 * @note This also registers the XDaRk Core autoload handler.
			 */
			public static function initialize()
			{
				if(static::$initialized)
					return TRUE; // Initialized already.

				$core_ns_classes_dir      = stub::n_dir_seps_up(__FILE__);
				static::$core_classes_dir = stub::n_dir_seps_up($core_ns_classes_dir);
				$core_dir                 = stub::n_dir_seps_up(static::$core_classes_dir);

				static::add_special_class(stub::$core_ns, $core_dir.'/stub.php');
				static::add_special_class(stub::$core_ns_stub.'__stub', $core_dir.'/stub.php');

				static::add_special_class('deps_'.stub::$core_ns, $core_ns_classes_dir.'/deps.php');
				static::add_special_class(stub::$core_ns_stub.'__deps', $core_ns_classes_dir.'/deps.php');

				static::add_special_class('deps_x_'.stub::$core_ns, $core_ns_classes_dir.'/deps-x.php');
				static::add_special_class(stub::$core_ns_stub.'__deps_x', $core_ns_classes_dir.'/deps-x.php');

				static::add_special_class(stub::$core_ns.'\\stub', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns.'\\deps', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns.'\\core', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns.'\\fw_constants', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns.'\\instance', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns.'\\exception_handler', $core_ns_classes_dir.'/framework.php');
				static::add_special_class(stub::$core_ns_stub, $core_ns_classes_dir.'/framework.php');

				static::add_classes_dir(static::$core_classes_dir);

				spl_autoload_register('\\'.__CLASS__.'::load_ns_class');

				if(!class_exists(stub::$core_ns_stub.'__autoloader'))
					class_alias(__CLASS__, stub::$core_ns_stub.'__autoloader');

				return (static::$initialized = TRUE);
			}

			# -----------------------------------------------------------------------------------------------------------------------------
			# Autoload handler.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Autoloads classes for the XDaRk Core (and for plugins powered by it).
			 *
			 * @note Capable of loading classes for any portion of the XDaRk Core.
			 *    Can also load classes for plugins built on the XDaRk Core.
			 *
			 * @note This autoloader also handles XDaRk Core class aliases dynamically.
			 *
			 * @param string $ns_class A `namespace\class` to load (the PHP interpreter passes this in).
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 */
			public static function load_ns_class($ns_class)
			{
				if(!is_string($ns_class) || !$ns_class)
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
				# Special classes (always check this map first).

				if(!empty(static::$special_classes_map[$ns_class]))
				{
					require_once static::$special_classes_map[$ns_class];
					return; // We're all done here.
				}
				# XDaRk Core class aliases (detected/created dynamically).

				if(($is_core_class_alias = (strpos($ns_class, stub::$core_ns_stub.'__') === 0)))
				{
					$ns_class = str_replace(array(stub::$core_ns_stub.'__', '__'), array(stub::$core_ns.'__', '\\'), $ns_class);

					if(class_exists('\\'.$ns_class, FALSE) || interface_exists('\\'.$ns_class, FALSE) || (function_exists('trait_exists') && trait_exists('\\'.$ns_class, FALSE)))
					{ // ↑ The underlying class COULD be available already. If so, we simply need the alias.

						static::add_core_ns_class_alias($ns_class); // Add alias.
						return; // We're all done here.
					}
				}
				# Look for this namespace/class in one of the class directories we're autoloading from.

				$ns_class_file = str_replace(array('\\', '_'), array('/', '-'), $ns_class).'.php';

				foreach(static::$class_dirs as $_classes_dir) if(is_file($_classes_dir.'/'.$ns_class_file))
				{
					require_once $_classes_dir.'/'.$ns_class_file;

					if($is_core_class_alias) // A XDaRk Core alias?
						static::add_core_ns_class_alias($ns_class);

					return; // We're all done here.
				}
				unset($_classes_dir); // Housekeeping.
			}

			# -----------------------------------------------------------------------------------------------------------------------------
			# Utility methods.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Adds a new special class to the map.
			 *
			 * @param string $ns_class A namespace/class path (or a global class).
			 *
			 * @param string $ns_class_file Full absolute path to the file that loads `$ns_class`.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If `$ns_class` is empty, or is already in the special classes map.
			 * @throws \exception If `$ns_class_file` is empty.
			 */
			public static function add_special_class($ns_class, $ns_class_file)
			{
				if(!is_string($ns_class) || !($ns_class = trim($ns_class, '\\')) || !is_string($ns_class_file) || !$ns_class_file)
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
				if(isset(static::$special_classes_map[$ns_class]))
					throw new \exception( // Fail here; detected existing special class.
						sprintf(stub::__('Special namespace\\class already exists in map: `%1$s`'), $ns_class)
					);
				static::$special_classes_map[$ns_class] = stub::n_dir_seps($ns_class_file);
			}

			/**
			 * Adds a new `classes` directory.
			 *
			 * @param string $classes_dir Any `classes` directory; w/ basename `classes`.
			 *
			 * @note This directory MUST use sub-directories with a `namespace/class` hierarchy.
			 *    Nested sub-namespaces are also supported in the same structure (i.e. `/namespace/sub_namespace/class`).
			 *    Underscores in any namespace and/or class should be replaced with dashes in the file structure.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If `$classes_dir` is empty, or is NOT an existing directory.
			 * @throws \exception If `$classes_dir` does NOT have a `classes` basename.
			 *
			 * @note Each classes directory is pushed to the top of the stack by this routine.
			 *    This way `load_ns_class()` is looking for class files in the last directory first;
			 *    and then searching up the stack until it finds a matching class file.
			 *
			 *    This makes it possible for pro add-ons and/or other plugins integrated with the core,
			 *    to create classes that will override any that may already exist for a particular plugin.
			 *    For example, a pro add-on MAY wish to override default/free plugin classes.
			 *
			 *    However, the underlying core classes (when called explicitly); may NOT be overwritten.
			 *    We keep the core classes directory ALWAYS at the top of the stack when adding new directories.
			 *
			 * @note A plugin CAN override core classes (for use in that plugin); by extending core classes and placing them into
			 *    the plugin's own classes directory. That is NOT handled here though; it is handled with `©` dynamic class instances.
			 *    See: {@link framework::__get()}, {@link framework::__call()}
			 */
			public static function add_classes_dir($classes_dir)
			{
				if(!is_string($classes_dir) || !$classes_dir || !is_dir($classes_dir))
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
				if(basename($classes_dir) !== 'classes')
					throw new \exception( // Fail here; detected invalid `classes` directory.
						sprintf(stub::__('Invalid `classes` directory basename: `%1$s`.'), basename($classes_dir)).
						' '.stub::__('A `classes` directory MUST have basename: `classes`.')
					);
				$classes_dir = stub::n_dir_seps($classes_dir); // Normalize for comparison.

				if(!in_array($classes_dir, static::$class_dirs, TRUE))
				{
					$class_dirs =& static::$class_dirs; // PhpStorm™ needs this.

					array_unshift($class_dirs, $classes_dir);
					$class_dirs = array_diff($class_dirs, array(static::$core_classes_dir));
					array_unshift($class_dirs, static::$core_classes_dir);
				}
			}

			/**
			 * Adds a new core class alias.
			 *
			 * @param string $ns_or_ns_class A class path (including namespace); or ONLY the namespace.
			 *    If this is ONLY the namespace; `$class_file` MUST be passed in also.
			 *
			 * @param string $class_file Optional. If passed, `$ns_or_ns_class` is assumed to be the namespace only.
			 *
			 * @throws \exception If invalid types are passed through arguments list.
			 * @throws \exception If the parsed `$ns_class` is empty, or is NOT a valid core class name.
			 * @throws \exception If the parsed `$ns_class` is NOT from this version of the core.
			 * @throws \exception If the parsed `$ns_class` is NOT already defined.
			 */
			public static function add_core_ns_class_alias($ns_or_ns_class, $class_file = '')
			{
				if(!is_string($ns_or_ns_class) || !($ns_or_ns_class = trim($ns_or_ns_class, '\\')) || !is_string($class_file))
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
					);
				if($class_file) // Interpret `$ns_or_ns_class` as a namespace only.
					$ns_class = $ns_or_ns_class.'\\'.stub::with_underscores(basename($class_file, '.php'));
				else $ns_class = $ns_or_ns_class; // Presume full class path.

				if(!preg_match(stub::$regex_valid_plugin_ns_class, $ns_class))
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Namespace\\class contains invalid chars: `%1$s`.'), $ns_class)
					);
				if(strpos($ns_class, stub::$core_ns.'\\') !== 0)
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Namespace\\class is NOT from this core: `%1$s`.'), $ns_class)
					);
				if(!class_exists('\\'.$ns_class, FALSE) && !interface_exists('\\'.$ns_class, FALSE) && (!function_exists('trait_exists') || !trait_exists('\\'.$ns_class, FALSE)))
					throw new \exception( // Fail here; detected invalid arguments.
						sprintf(stub::__('Namespace\\class does NOT exist yet: `%1$s`.'), $ns_class)
					);
				$alias = str_replace(array(stub::$core_ns.'\\', '\\'), array(stub::$core_ns_stub.'\\', '__'), $ns_class);

				if(!class_exists('\\'.$alias, FALSE) && !interface_exists('\\'.$alias, FALSE) && (!function_exists('trait_exists') || !trait_exists('\\'.$alias, FALSE)))
					class_alias('\\'.$ns_class, $alias);
			}
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Initialize the XDaRk Core autoloader.
		# --------------------------------------------------------------------------------------------------------------------------------

		autoloader::initialize(); // Also registers autoloader handler.
	}
}
