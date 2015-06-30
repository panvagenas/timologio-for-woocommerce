<?php
/**
 * XDaRk Core framework instance config.
 *
 * Copyright: © 2013 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 130331
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# XDaRk Core framework instance config; used by almost all core classes.
# -----------------------------------------------------------------------------------------------------------------------------------------
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	if(!class_exists('\\'.__NAMESPACE__.'\\instance'))
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
		# XDaRk Core framework instance config.
		# --------------------------------------------------------------------------------------------------------------------------------
		/**
		 * XDaRk Core framework instance config.
		 *
		 * @package XDaRk\Core
		 * @since   130331
		 */
		final class instance // Used by almost all classes.
		{
			# -----------------------------------------------------------------------------------------------------------------------------
			# Protected/static properties (some are defined by the initializer).
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initialized yet?
			 *
			 * @var boolean Initialized yet?
			 *
			 * @by-initializer Set by initializer.
			 */
			protected static $initialized = FALSE;

			# -----------------------------------------------------------------------------------------------------------------------------
			# Initializer.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Initializes properties.
			 *
			 * @return boolean Returns the `$initialized` property w/ a TRUE value.
			 *
			 * @note Sets some class properties & registers class alias.
			 */
			final public static function initialize()
			{
				if(static::$initialized)
					return TRUE; // Initialized already.

				if(!class_exists(stub::$core_ns_stub.'__instance'))
					class_alias(__CLASS__, stub::$core_ns_stub.'__instance');

				return (static::$initialized = TRUE);
			}

			# -----------------------------------------------------------------------------------------------------------------------------
			# Constructor and other magic/overload methods.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * Instance config constructor.
			 *
			 * @param object|array|null $properties
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public A magic/overload constructor MUST always remain public.
			 */
			final public function __construct($properties = NULL)
			{
				if($properties) foreach(($properties = (array)$properties) as $_property => $_value)
					if(is_string($_property) && property_exists($this, $_property)) $this->{$_property} = $_value;
			}

			/**
			 * Sets magic/overload properties (dynamic classes).
			 *
			 * @param string $property A magic/overload property by name.
			 *
			 * @param mixed  $value The new value for this magic/overload property.
			 *
			 * @return mixed The `$value` assigned to the magic/overload `$property`.
			 *
			 * @throws exception If attempting to set magic/overload properties (this is NOT allowed).
			 *    This magic/overload method is currently here ONLY to protect magic/overload property values.
			 *    All magic/overload properties in the XDaRk Core instance config are read-only.
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

			# -----------------------------------------------------------------------------------------------------------------------------
			# Misc. core properties.
			# -----------------------------------------------------------------------------------------------------------------------------

			/**
			 * @var string i.e. `XDaRk Core`
			 */
			public $core_name = '';

			/**
			 * @var string i.e. `http://www.websharks-inc.com`
			 */
			public $core_site = '';

			/**
			 * @var string i.e. `xd`
			 */
			public $xd = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Core prefix properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string i.e. `xd_`
			 */
			public $core_prefix = '';

			/**
			 * @var string i.e. `xd-`
			 */
			public $core_prefix_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Core version properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `141226-dev+123`
			 */
			public $core_version = '';

			/**
			 * @var string e.g. `000000_dev_123`
			 */
			public $core_version_with_underscores = '';

			/**
			 * @var string e.g. `141226-dev-123`
			 */
			public $core_version_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Core directory/file properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `/repo/core`
			 */
			public $core_dir = '';

			/**
			 * @var string e.g. `/repo/core/classes`
			 */
			public $core_classes_dir = '';

			/**
			 * @var string e.g. `$_SERVER[WEBSHARK_HOME]/Apache/wordpress.loc`
			 */
			public $local_wp_dev_dir = '';

			/**
			 * @var string e.g. `$_SERVER[WEBSHARK_HOME]/WebSharks/core`
			 */
			public $local_core_repo_dir = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Core namespace stub properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string i.e. `xd`
			 */
			public $core_ns_stub = '';

			/**
			 * @var string i.e. `xd`
			 */
			public $core_ns_stub_with_dashes = '';

			/**
			 * @var string i.e. `xd_v`
			 */
			public $core_ns_stub_v = '';

			/**
			 * @var string i.e. `xd-v`
			 */
			public $core_ns_stub_v_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Core namespace properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `xd_v141226_dev`
			 */
			public $core_ns = '';

			/**
			 * @var string e.g. `\xd_v141226_dev`
			 */
			public $core_ns_prefix = '';

			/**
			 * @var string e.g. `xd-v141226-dev`
			 */
			public $core_ns_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Misc. plugin properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `Example Plugin™`
			 */
			public $plugin_name = '';

			/**
			 * @var string e.g. `http://example`
			 */
			public $plugin_site = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin var namespace properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `var_ns`
			 */
			public $plugin_var_ns = '';

			/**
			 * @var string e.g. `var-ns`
			 */
			public $plugin_var_ns_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin prefix properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `var_ns_` or `var_` (usually quite short).
			 *    If the current plugin is the core itself, this will be {@link $core_prefix}
			 */
			public $plugin_prefix = '';

			/**
			 * @var string e.g. `var-ns-` or `var-` (usually quite short).
			 *    If the current plugin is the core itself, this will be {@link $core_prefix_with_dashes}
			 */
			public $plugin_prefix_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin capability properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `manage_options`
			 */
			public $plugin_cap = '';

			/**
			 * @var string e.g. `manage-options`
			 */
			public $plugin_cap_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin version properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `141226-dev+123`
			 */
			public $plugin_version = '';

			/**
			 * @var string e.g. `000000_dev_123`
			 */
			public $plugin_version_with_underscores = '';

			/**
			 * @var string e.g. `141226-dev-123`
			 */
			public $plugin_version_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin directory/file properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin`
			 */
			public $plugin_dir = '';

			/**
			 * @var string e.g. `example-plugin`
			 */
			public $plugin_dir_basename = '';

			/**
			 * @var string e.g. `example-plugin/plugin.php`
			 */
			public $plugin_dir_file_basename = '';

			/**
			 * @var string e.g. `/path/to/wp-content/data/example-plugin`
			 */
			public $plugin_data_dir = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin/plugin.php`
			 */
			public $plugin_file = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin/classes`
			 */
			public $plugin_classes_dir = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin/classes/example-plugin.php`
			 */
			public $plugin_api_class_file = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin pro properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `example_plugin_pro`
			 */
			public $plugin_pro_var = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin-pro`
			 */
			public $plugin_pro_dir = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin-pro/plugin.php`
			 */
			public $plugin_pro_file = '';

			/**
			 * @var string e.g. `example-plugin-pro`
			 */
			public $plugin_pro_dir_basename = '';

			/**
			 * @var string e.g. `example-plugin-pro/plugin.php`
			 */
			public $plugin_pro_dir_file_basename = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin-pro/classes`
			 */
			public $plugin_pro_classes_dir = '';

			/**
			 * @var string e.g. `/path/to/wp-content/plugins/example-plugin-pro/classes/example-plugin/pro.php`
			 */
			public $plugin_pro_class_file = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Plugin root namespace properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `example_plugin`
			 */
			public $plugin_root_ns = '';

			/**
			 * @var string e.g. `\example_plugin`
			 */
			public $plugin_root_ns_prefix = '';

			/**
			 * @var string e.g. `example-plugin`
			 */
			public $plugin_root_ns_with_dashes = '';

			/**
			 * @var string e.g. `example_plugin` (same as {@link $plugin_root_ns}).
			 *    If the current plugin is the core itself, this will be {@link $core_ns_stub}
			 */
			public $plugin_root_ns_stub = '';

			/**
			 * @var string e.g. `example-plugin` (same as {@link $plugin_root_ns_with_dashes}).
			 *    If the current plugin is the core itself, this will be {@link $core_ns_stub_with_dashes}
			 */
			public $plugin_root_ns_stub_with_dashes = '';

			/**
			 * @var string e.g. `namespace\sub_namespace`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 */
			public $plugin_stub_as_root_ns = '';

			/**
			 * @var string e.g. `namespace__sub_namespace`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 *    This variation uses underscores in all places.
			 */
			public $plugin_stub_as_root_ns_with_underscores = '';

			/**
			 * @var string e.g. `namespace--sub-namespace`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 *    This variation uses dashes in all places.
			 */
			public $plugin_stub_as_root_ns_with_dashes = '';

			/**
			 * @var string e.g. `namespace\sub_namespace\class`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 */
			public $plugin_stub_as_root_ns_class = '';

			/**
			 * @var string e.g. `namespace__sub_namespace__class`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 *    This variation uses underscores in all places.
			 */
			public $plugin_stub_as_root_ns_class_with_underscores = '';

			/**
			 * @var string e.g. `namespace--sub-namespace--class`;
			 *    where `namespace` is replaced by {@link $plugin_root_ns_stub}.
			 *    This variation uses dashes in all places.
			 */
			public $plugin_stub_as_root_ns_class_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Namespace properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `namespace\sub_namespace`
			 */
			public $ns = '';

			/**
			 * @var string e.g. `\namespace\sub_namespace`
			 */
			public $ns_prefix = '';

			/**
			 * @var string e.g. `namespace__sub_namespace`
			 *    This variation uses underscores in all places.
			 */
			public $ns_with_underscores = '';

			/**
			 * @var string e.g. `namespace--sub-namespace`
			 *    This variation uses dashes in all places.
			 */
			public $ns_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Root namespace properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `namespace`
			 */
			public $root_ns = '';

			/**
			 * @var string e.g. `\namespace`
			 */
			public $root_ns_prefix = '';

			/**
			 * @var string e.g. `namespace` or `name-space`
			 */
			public $root_ns_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Sub-namespace\class properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `sub_namespace\class`
			 */
			public $sub_ns_class = '';

			/**
			 * @var string e.g. `sub_namespace__class`
			 *    This variation uses underscores in all places.
			 */
			public $sub_ns_class_with_underscores = '';

			/**
			 * @var string e.g. `sub-namespace--class`
			 *    This variation uses dashes in all places.
			 */
			public $sub_ns_class_with_dashes = '';

			# -----------------------------------------------------------------------------------------------------------------------------
			# Namespace\class properties.
			# -----------------------------------------------------------------------------------------------------------------------------
			/**
			 * @var string e.g. `namespace\sub_namespace\class`
			 */
			public $ns_class = '';

			/**
			 * @var string e.g. `\namespace\sub_namespace\class`
			 */
			public $ns_class_prefix = '';

			/**
			 * @var string e.g. `namespace__sub_namespace__class`
			 *    This variation uses underscores in all places.
			 */
			public $ns_class_with_underscores = '';

			/**
			 * @var string e.g. `namespace--sub-namespace--class`
			 *    This variation uses dashes in all places.
			 */
			public $ns_class_with_dashes = '';

			/**
			 * @var string e.g. `basename(namespace/sub_namespace/class)`.
			 *    This is the `class` only.
			 */
			public $ns_class_basename = ''; // e.g. `class`

			/**
			 * Instance config properties for JavaScript libs.
			 *
			 * @param boolean $exclude_core Optional; defaults to a FALSE value. If TRUE, this routine will exclude all core-specific config vars.
			 *    Since JS plugin extensions depend on the core itself, there's no reason for plugins to load them again.
			 *
			 * @return \stdClass A new standard class object instance. This will contain only the essentials.
			 */
			public function for_js($exclude_core = FALSE)
			{
				$for_js = new \stdClass;
				foreach($this as $_key => $_value)
				{
					if((!$exclude_core // Not excluding core?
					    && in_array($_key, array('core_name', 'core_site',
					                             'core_prefix', 'core_prefix_with_dashes',
					                             'core_ns', 'core_ns_with_dashes',
					                             'core_ns_stub', 'core_ns_stub_with_dashes'), TRUE))

					   || in_array($_key, array('plugin_name', 'plugin_site',
					                            'plugin_var_ns', 'plugin_var_ns_with_dashes',
					                            'plugin_prefix', 'plugin_prefix_with_dashes',
					                            'plugin_root_ns', 'plugin_root_ns_with_dashes',
					                            'plugin_root_ns_stub', 'plugin_root_ns_stub_with_dashes'), TRUE)
					) $for_js->{$_key} = $_value;
				}
				unset($_key, $_value);

				return $for_js;
			}
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Initialize the XDaRk Core instance config class.
		# --------------------------------------------------------------------------------------------------------------------------------

		instance::initialize(); // Also registers class alias.
	}
}
