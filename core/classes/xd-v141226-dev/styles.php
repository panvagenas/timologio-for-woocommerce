<?php
/**
 * Styles.
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
	 * Styles.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class styles extends framework
	{
		/**
		 * @var array Front-side components.
		 */
		public $front_side_components = array();

		/**
		 * @var array Stand-alone components.
		 */
		public $stand_alone_components = array();

		/**
		 * @var array Menu page components.
		 */
		public $menu_page_components = array();

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If this class is instantiated before the `init` action hook.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			if(!did_action('init'))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#init', NULL,
					$this->__('Doing it wrong (the `init` hook has NOT been fired yet).')
				);
			$themes             = $this->themes();
			$theme_keys         = array_keys($themes);
			$styles_to_register = array(); // Initialize styles.

			// Core libs & themes; available in all contexts.
			if(!wp_style_is($this->instance->core_ns_with_dashes, 'registered'))
				$styles_to_register[$this->instance->core_ns_with_dashes] = array(
					'url' => $this->©url->to_core_dir_file('/client-side/styles/core-libs.min.css'),
					'ver' => $this->instance->core_version_with_dashes
				);
			foreach($themes as $_theme => $_theme_file)
				if(!wp_style_is($_theme, 'registered'))
					$styles_to_register[$this->instance->core_ns_with_dashes.'--'.$_theme] = array(
						'deps' => array($this->instance->core_ns_with_dashes),
						'url'  => $this->©url->to_wp_abs_dir_file($_theme_file),
						'ver'  => $this->instance->core_version_with_dashes
					);
			unset($_theme, $_theme_file); // A little housekeeping.

			// Front-side components (including themes); available in all contexts.

			$this->front_side_components = $this->front_side_components();

			if(!in_array(($current_front_side_theme = $this->©options->get('styles.front_side.theme')), $theme_keys, TRUE))
				$current_front_side_theme = $this->©options->get('styles.front_side.theme', TRUE);
			$front_side_themes = array($this->instance->core_ns_with_dashes.'--'.$current_front_side_theme);

			foreach($this->©options->get('styles.front_side.load_themes') as $_theme)
				if(in_array($_theme, $theme_keys, TRUE)) // Let's make sure it's a valid theme.
					$front_side_themes[] = $this->instance->core_ns_with_dashes.'--'.$_theme;
			$front_side_themes = array_unique($front_side_themes);
			unset($_theme); // Housekeeping.

			if(($front_side_file = $this->©file->template('client-side/styles/front-side.min.css', TRUE)))
			{
				$this->front_side_components[] = $this->instance->plugin_root_ns_with_dashes.'--front-side';

				$styles_to_register[$this->instance->plugin_root_ns_with_dashes.'--front-side'] = array(
					'deps' => array_merge(array($this->instance->core_ns_with_dashes), $front_side_themes),
					'url'  => $this->©url->to_wp_abs_dir_file($front_side_file),
					'ver'  => $this->instance->plugin_version_with_dashes
				);
			}
			else $this->front_side_components = // Running w/ core/themes only; no separate front-side styles.
				array_merge($this->front_side_components, array($this->instance->core_ns_with_dashes), $front_side_themes);

			// Stand-alone components; available in all contexts (depends on front-side).

			$this->stand_alone_components = $this->stand_alone_components();

			if(($stand_alone_file = $this->©file->template('client-side/styles/stand-alone.min.css', TRUE)))
			{
				$this->stand_alone_components[] = $this->instance->plugin_root_ns_with_dashes.'--stand-alone';

				$styles_to_register[$this->instance->plugin_root_ns_with_dashes.'--stand-alone'] = array(
					'deps' => $this->front_side_components, // Includes the core already.
					'url'  => $this->©url->to_wp_abs_dir_file($stand_alone_file),
					'ver'  => $this->instance->plugin_version_with_dashes
				);
			}
			else $this->stand_alone_components = // No separate stand-alone styles.
				array_merge($this->stand_alone_components, $this->front_side_components);

			// Menu page components; only if applicable.

			if($this->©menu_page->is_plugin_page()) // Menu page styles.
			{
				$this->menu_page_components = $this->menu_page_components();

				if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), $theme_keys, TRUE))
					$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

				$this->menu_page_components[] = $this->instance->core_ns_with_dashes.'--menu-pages';

				// Only if NOT already registered by another XDaRk plugin (it should NOT be).
				if(!wp_style_is($this->instance->core_ns_with_dashes.'--menu-pages', 'registered'))
					$styles_to_register[$this->instance->core_ns_with_dashes.'--menu-pages'] = array(
						'deps' => array($this->instance->core_ns_with_dashes.'--'.$current_menu_pages_theme),
						'url'  => $this->©url->to_core_dir_file('/client-side/styles/menu-pages/menu-pages.min.css'),
						'ver'  => $this->instance->core_version_with_dashes
					);
			}
			if($styles_to_register) $this->register($styles_to_register);
		}

		/**
		 * Builds the initial set of front-side components.
		 *
		 * @extenders Can be extended to add additional front-side components.
		 *
		 * @return array An array of any additional front-side components.
		 */
		public function front_side_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * Builds the initial set of stand-alone components.
		 *
		 * @extenders Can be extended to add additional stand-alone components.
		 *
		 * @return array An array of any additional stand-alone components.
		 */
		public function stand_alone_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * Builds the initial set of menu page components.
         * A style must be registered first and the returned by this function as array.
         *
         * @example Return example: [$this->instance->ns_with_dashes . '--menu-pages-my-menu-page']
		 *
		 * @extenders Can be extended to add additional menu page components.
		 *
		 * @return array An array of any additional menu page components.
		 */
		public function menu_page_components()
		{
			return array(); // Not implemented by core.
		}

		/**
		 * An array of all themes.
		 *
		 * @return array An associative array of all themes.
		 *    Array keys are handles; values are absolute directory paths.
		 */
		public function themes() // Bootstrap.
		{
			if(is_array($cache = $this->©db_cache->get($this->method(__FUNCTION__))))
				return $cache; // Already cached these.

			$themes = array(); // Initialize UI themes array.

			foreach($this->©dirs->where_templates_may_reside() as $_dir)
				if(is_dir($_themes_dir = $_dir.'/client-side/styles/themes'))
				{
					foreach(scandir($_themes_dir) as $_theme_dir_slug)
					{
						if(strpos($_theme_dir_slug, '.') === 0)
							continue; // Skip `.` and `..`.
						else if(!empty($themes[$_theme_dir_slug]))
							continue; // Allows themes to be overridden.
						else if(is_file($_theme_file = $_themes_dir.'/'.$_theme_dir_slug.'/theme.min.css'))
							$themes[$_theme_dir_slug] = $_theme_file;
					}
					unset($_theme_dir_slug, $_theme_file); // Housekeeping.
				}
			unset($_dir, $_themes_dir); // Final housekeeping.

			return $this->©db_cache->update($this->method(__FUNCTION__), $themes);
		}

		/**
		 * Plugin components (selective components which apply in the current context).
		 *
		 * @param string|array $others Any other components that we'd like to include in the return value.
		 *    Helpful if we're pulling all current components, along with something else (like a theme).
		 *
		 * @return array Plugin components (selective components which apply in the current context).
		 *    See also `$this->©plugin->needs_*()`; where filters are implemented via easy-to-use methods.
		 */
		public function contextual_components($others = array())
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$components = array(); // Initialize array.
			$others     = ($others) ? (array)$others : array();

			$front_side_load_filter  = $this->apply_filters('front_side', (boolean)$this->©options->get('styles.front_side.load_by_default'));
			$stand_alone_load_filter = $this->apply_filters('stand_alone', FALSE);
			$is_plugin_page          = $this->©menu_page->is_plugin_page();

			if($front_side_load_filter) $components = array_merge($components, $this->front_side_components);
			if($stand_alone_load_filter) $components = array_merge($components, $this->stand_alone_components);
			if($is_plugin_page) $components = array_merge($components, $this->menu_page_components);

			return array_unique(array_merge($components, $others));
		}

		/**
		 * Registers styles with WordPress®.
		 *
		 * @param array $styles An array of styles to register.
         * @example
         * [
         *      $this->instance->ns_with_dashes . '--menu-pages-my-menu-page' => array(
         *      'deps' => array(),
         *      'url' => $this->©url->to_plugin_dir_file('/client-side/styles/random-sets.min.css'),
         *      'ver' => $this->instance->core_version_with_dashes
         * ]
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If a default style is NOT configured properly.
		 */
		public function register($styles)
		{
			$this->check_arg_types('array', func_get_args());

			foreach($styles as $_handle => $_style)
			{
				if( // Validates?
					!is_array($_style)
					|| !$this->©string->is_not_empty($_style['url'])
				) // This MUST be an array with a `url` string.
					throw $this->©exception(
						$this->method(__FUNCTION__).'#url_missing', get_defined_vars(),
						$this->__('Invalid style configuration. Missing and/or invalid `url`.').
						' '.sprintf($this->__('Problematic style handle: `%1$s`.'), $_handle)
					);
				// Additional configurations (all optional).
				$_style['deps']  = $this->©array->isset_or($_style['deps'], array());
				$_style['ver']   = $this->©string->isset_or($_style['ver'], '');
				$_style['ver']   = ($_style['ver']) ? $_style['ver'] : NULL;
				$_style['media'] = $this->©string->isset_or($_style['media'], 'all');

				wp_deregister_style($_handle);
				wp_register_style($_handle, $_style['url'], $_style['deps'], $_style['ver'], $_style['media']);
			}
			unset($_handle, $_style);
		}

		/**
		 * Prints stand-alone/front-side styles.
		 *
		 * @attaches-to WordPress® `wp_print_styles` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function wp_print_styles()
		{
			if(!is_admin()) // Front-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Prints admin styles.
		 *
		 * @attaches-to WordPress® `admin_print_styles` hook.
		 * @hook-priority `9` (before default priority).
		 */
		public function admin_print_styles()
		{
			if(is_admin()) // Admin-side.
				$this->enqueue($this->contextual_components());
		}

		/**
		 * Prints specific styles.
		 *
		 * @param string|array $print A string, or an array of specific handles to print.
		 */
		public function print_styles($print)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$print = (array)$print; // Force an array value.

			global $wp_styles; // Global object reference.
			if(!($wp_styles instanceof \WP_Styles))
				$wp_styles = new \WP_Styles();

			foreach(($print = array_unique($print)) as $_key => $_handle)
				if(!$this->©string->is_not_empty($_handle) || !wp_style_is($_handle, 'registered'))
					unset($print[$_key]); // Remove (NOT a handle, or NOT registered).
			unset($_key, $_handle); // Housekeeping.

			if($print) // Still have something to print?
				$wp_styles->do_items($print);
		}

		/**
		 * Enqueues styles (even if they'll appear in the footer).
		 *
		 * @param string|array $enqueue A string, or an array of specific handles to enqueue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function enqueue($enqueue)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$enqueue = (array)$enqueue; // Force array value.

			foreach(($enqueue = array_unique($enqueue)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_style_is($_handle, 'registered'))
					if(!wp_style_is($_handle, 'queue')) // NOT in the queue?
						wp_enqueue_style($_handle);
			unset($_handle); // Housekeeping.
		}

		/**
		 * Dequeues styles (if it's NOT already too late).
		 *
		 * @param string|array $dequeue A string, or an array of specific handles to dequeue.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function dequeue($dequeue)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$dequeue = (array)$dequeue; // Force array value.

			foreach(($dequeue = array_unique($dequeue)) as $_handle)
				if($this->©string->is_not_empty($_handle) && wp_style_is($_handle, 'registered'))
					if(wp_style_is($_handle, 'queue')) // In the queue?
						wp_dequeue_style($_handle);
			unset($_handle); // Housekeeping.
		}
	}
}