<?php
/**
 * Menu Page Utilities.
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
    use xd_v141226_dev\menu_pages\menu_page;

    if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class menu_pages extends framework
	{
		/**
		 * Handles WordPress® `admin_menu` hook.
		 *
		 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
		 *
		 * @attaches-to WordPress® `admin_menu` hook.
		 * @hook-priority Default is fine.
		 *
		 * @return null Nothing.
		 */
		public function admin_menu()
		{
		}

		/**
		 * Handles WordPress® `network_admin_menu` hook.
		 *
		 * @extenders Should be overridden by class extenders, if a plugin has menu pages.
		 *
		 * @attaches-to WordPress® `network_admin_menu` hook.
		 * @hook-priority Default is fine.
		 *
		 * @return null Nothing.
		 */
		public function network_admin_menu()
		{
		}

		/**
		 * Default (core-driven) menu pages.
		 *
		 * @return array Default (core-driven) menu pages.
		 *
		 * @see add() for further details about how to add menu pages.
		 */
		public function default_menu_pages()
		{
			$main_page_slug // A standard in the core.
				= $this->instance->plugin_root_ns_stub_with_dashes;
			// We want the menu page slug to come out the same in all versions.

			return array(
				$main_page_slug     => array(
					'menu_title' => $this->instance->plugin_name,
					'icon'       => $this->©url->to_template_dir_file('/client-side/images/icon-16x16.png')
				),
				'-'.$main_page_slug => array(
					'is_under_slug' => $main_page_slug,
					'menu_title'    => $this->__('Quick-Start Guide'),
				),
				'general_options'   => array(
					'is_under_slug' => $main_page_slug,
					'menu_title'    => $this->__('General Options'),
				),
				'update_sync'       => array(
					'is_under_slug' => $main_page_slug,
					'menu_title'    => $this->__('Plugin Updater'),
				)
			);
		}

		/**
		 * Is this an administrative page for the current plugin?
		 *
		 * @param string|array $slugs Optional. By default, we simply check to see if this is an administrative page for the current plugin.
		 *    If this is a string (NOT empty), we'll also check if it's a specific page (for the current plugin) matching: `$slugs`.
		 *    If this is an array, we'll check if it's any page (for the current plugin) in the array of: `$slugs`.
		 *    If this is an array, the array can also contain wildcard patterns (optional).
		 *
		 * @note The value of `$slugs`, whether it be a string or an array, should attempt to match ONLY the page slug itself; NOT the full prefixed value.
		 *    Each page name for the current plugin is dynamically prefixed with `$this->instance->plugin_root_ns_stub.'__[page_slug]`.
		 *    The prefix should be excluded from `$slugs` values. In other words, we're only testing for `[page_slug]` here.
		 *
		 * @param boolean      $return_slug_class_basename Optional. Defaults to a `FALSE` value.
		 *    If this is `TRUE`, instead of returning the slug (with dashes) we return the associated
		 *    menu page class basename (with underscores).
		 *
		 * @return string A string with the `[page slug]` value; IF this an administrative page for the current plugin.
		 *    Or, if `$return_slug_class_basename` is `TRUE`; the slug's class basename.
		 *    Otherwise, this returns an empty string by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_plugin_page($slugs = array(), $return_slug_class_basename = FALSE)
		{
			$this->check_arg_types(array('string', 'array'), 'boolean', func_get_args());

			if(is_admin() && $this->©string->¤is_not_empty($current_page = $this->©vars->_GET('page'))
			   && preg_match('/^'.preg_quote($this->instance->plugin_root_ns_stub_with_dashes, '/').'(?:\-\-(?P<slug>.+))?$/', $current_page, $page)
			) // This regex pattern matches the plugin's root namespace stub with or without an additional sub-menu slug.
			{
				$page['slug'] = // Default value is the current plugin's root namespace stub.
					$this->©string->is_not_empty_or($page['slug'], $this->instance->plugin_root_ns_stub_with_dashes);

				if($return_slug_class_basename) // If so, convert this into a string.
					if($page['slug'] === $this->instance->plugin_root_ns_stub_with_dashes)
						$slug_class_basename = 'main_page'; // Convert slug to it's class.
					else $slug_class_basename = $this->©string->with_underscores($page['slug']);

				if(!$slugs // Don't care which slug?
				   || (is_string($slugs) && $page['slug'] === $slugs)
				   || (is_array($slugs) && $this->©string->in_wildcard_patterns($page['slug'], $slugs))
				) return $return_slug_class_basename && !empty($slug_class_basename)
					? $slug_class_basename : $page['slug'];
			}
			return ''; // Default return value.
		}

		/**
		 * Adds an array of menu page configurations.
		 *
		 * @param array $menu_pages An associative array of configurations.
		 *    Each array key is the intended menu page slug (with dashes); and each of these
		 *    slugs MUST correlate with a menu page class that will serve as the menu page displayer.
		 *    e.g. the slug `general_options` correlates with `©menu_pages__general_options`.
		 *
		 *    The slug itself is required; i.e. the associative array key.
		 *    Additional configuration keys listed below; where only `menu_title` is required.
		 *
		 *    - `menu_title` The title to use in the menu itself (required).
		 *
		 *    - `doc_title` (optional) The title to use in the browser's title bar.
		 *          If empty, this will default to the plugin's name.
		 *
		 *    - `cap_required` (optional) The WP capability required to access this menu page.
		 *          If empty, the core will use it's capability mapper (see source code below).
		 *
		 *    - `icon` (optional) The URL to an icon; or a data URI may also be accepted. See {@link add_menu_page()}
		 *          in the WordPress core for further details on this. Valid only for main menu pages.
		 *
		 *    - `is_under_slug` (optional) Indicates a child sub-menu page of another primary menu page.
		 *
		 * @note Associative array keys with leading|trailing dashes are trimmed before use.
		 *    The ability to use leading dashes specifically, allows for sub-menu items to be added in duplicate;
		 *    i.e. in a case where a sub-menu item should simply be a pointer back to the primary menu link itself.
		 *    If you prefix a sub-menu item's key with a dash, the slug is NOT prefixed with `is_under_slug`.
		 *
		 *    A clearer example to help illustrate the way in which this actually works...
		 *
		 *    * `[key=my-plugin]` Main Menu (slug will be: `my-plugin`)
		 *
		 *       * `[key=-my-plugin]` Quick Start Guide (slug also: `my-plugin`)
		 *         `[is_under_slug=my-plugin]`
		 *
		 *       * `[key=--my-plugin]` Another Symlink (slug also: `my-plugin`)
		 *         `[is_under_slug=my-plugin]`
		 *
		 * @return null Nothing. Simply adds each of the menu pages defined in the configuration array.
		 *
		 * @throws exception If invalid types are passed through the arguments list.
		 * @throws exception If the array of `$menu_pages` is empty, or contains an invalid configuration set.
		 */
		public function add($menu_pages) // This makes the addition of menu pages super easy!
		{
			$this->check_arg_types('array:!empty', func_get_args()); // Must have an array here.

			foreach($menu_pages as $_menu_page_slug_key => $_menu_page) // Iterate configs.
			{
				if($this->©string->is_not_empty($_menu_page_slug_key) // MUST have slug & menu page title.
				   && $this->©array->is_not_empty($_menu_page) && $this->©string->is_not_empty($_menu_page['menu_title'])
				) // Have everything we need? If not, throw an exception down below.
				{
					$_menu_page['slug'] = $_menu_page_slug_key = $this->©string->with_dashes($_menu_page_slug_key);
					$_menu_page['slug'] = trim($_menu_page['slug'], '-'); // Cleanup prefixed dupes.

					if($_menu_page['slug'] === 'update-sync' && $this->©env->disallows_file_mods())
						continue; // Do NOT offer automatic updates when this is enabled please.

					if($_menu_page['slug'] === $this->instance->plugin_root_ns_stub_with_dashes)
						$_menu_page['displayer'] = array($this, '©menu_pages__main_page.display'); // Special case handler.
					else $_menu_page['displayer'] = array($this, '©menu_pages__'.$this->©string->with_underscores($_menu_page['slug']).'.display');

					if(!$this->©string->is_not_empty($_menu_page['doc_title']))
						$_menu_page['doc_title'] = $this->instance->plugin_name;

					if(!$this->©string->is_not_empty($_menu_page['cap_required']))
						$_menu_page['cap_required'] = // We can work this out dynamically.
							$this->©caps->map('manage_'.$this->instance->plugin_root_ns,
							                  'menu_pages__'.$this->©string->with_underscores($_menu_page['slug']));

					if($this->©string->is_not_empty($_menu_page['is_under_slug'])) // Sub-menu page?
					{
						$_menu_page['is_under_slug'] // This is a slug too.
							= $this->©string->with_dashes($_menu_page['is_under_slug']);

						if(strpos($_menu_page_slug_key, '-') !== 0) // A leading dash prevents a prefix.
							$_menu_page['submenu_slug'] = $_menu_page['is_under_slug'].'--'.$_menu_page['slug'];
						else $_menu_page['submenu_slug'] = $_menu_page['slug']; // Allow a duplicate (i.e. a symlink).

						add_submenu_page($_menu_page['is_under_slug'], $_menu_page['doc_title'], $_menu_page['menu_title'], $_menu_page['cap_required'], $_menu_page['submenu_slug'], $_menu_page['displayer']);
					}
					else add_menu_page($_menu_page['doc_title'], $_menu_page['menu_title'], $_menu_page['cap_required'], $_menu_page['slug'], $_menu_page['displayer'], $this->©string->isset_or($_menu_page['icon'], ''));
				}
				else throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_menu_page_config', get_defined_vars(),
					sprintf($this->__('Invalid menu page configuration: %1$s'), $this->©var->dump($_menu_page))
				);
			}
			unset($_menu_page_slug_key, $_menu_page); // A little housekeeping.
		}

        /**
         *
         * @param string $page_title Optional if only one page is added
         * @param string $menu_title Optional if only one page is added
         * @param string $capability Optional if only one page is added
         * @param string $menu_page
         *
         * @return bool|string See WP add_options_page()
         * @see add_options_page()
         *
         * @example (
         *      $this->instance->plugin_name . ' Settings',
         *      $this->instance->plugin_name,
         *      $this->instance->plugin_cap,
         *      'my_menu_page'
         * )
         *
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO ${VERSION}
         */
        public function add_options_page($menu_page, $page_title = '', $menu_title = '', $capability = '' ){
            $page_title = empty($page_title) ? $this->instance->plugin_name . ' Settings' : $page_title;
            $menu_title = empty($menu_title) ? $this->instance->plugin_name : $menu_title;
            $capability = empty($capability) ? $this->instance->plugin_cap : $capability;

            $menuPage = '©menu_pages__'.$menu_page;

            return add_options_page(
                $page_title,
                $menu_title,
                $capability,
                $this->instance->plugin_root_ns_stub_with_dashes.'--'.$this->$menuPage->slug,
                array($this, $menuPage.'.display')
            );
        }

		/**
		 * Builds a URL leading to a menu page, for the current plugin.
		 *
		 * @param string $slug Optional slug (with dashes).
		 *    A slug indicating a specific page we need to build a URL to.
		 *    If empty, the URL will lead to the main plugin page.
		 *
		 * @param string $content_panel_slug Optional panel slug (with dashes).
		 *    A specific content panel slug to display upon reaching the menu page.
		 *
		 * @param string $sidebar_panel_slug Optional panel slug (with dashes).
		 *    A specific sidebar panel slug to display upon reaching the menu page.
		 *
		 * @return string A full URL leading to a menu page, for the current plugin.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function url($slug = '', $content_panel_slug = '', $sidebar_panel_slug = '')
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			$page_arg = array('page' => $this->instance->plugin_root_ns_stub_with_dashes.(($slug) ? '--'.$slug : ''));
			$url      = add_query_arg(urlencode_deep($page_arg), $this->©url->to_wp_self_admin_uri('/admin.php'));

			if($content_panel_slug) // A specific slug? e.g. `#!content_panel_slug=quick-start-video`.
				$url = $this->©url->add_query_hash('content_panel_slug', $content_panel_slug, $url);

			if($sidebar_panel_slug) // A specific slug? e.g. `#!sidebar_panel_slug=pro-upgrade`.
				$url = $this->©url->add_query_hash('sidebar_panel_slug', $sidebar_panel_slug, $url);

			return $url; // URL leading to a specific menu page.
		}

		/**
		 * Updates the administrative theme for all menu pages.
		 *    This is a registered action handler.
		 *
		 * @param string $new_theme The new theme that's been selected for use.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ®update_theme($new_theme)
		{
			$this->check_arg_types('string', func_get_args());

			$this->©options->update(array('menu_pages.theme' => $new_theme));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}
	}
}