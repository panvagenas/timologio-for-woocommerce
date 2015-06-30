<?php
/**
 * Posts.
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
	 * Posts.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class posts extends framework
	{
		/**
		 * Gets a WordPress® post by path; instead of by ID.
		 *
		 * @param string $path A URL path (ex: `/sample-page/`, `/sample-page`, `sample-page`).
		 *    This also works with sub-pages (ex: `/parent-page/sub-page/`).
		 *    Also with post type prefixes (ex: `/post/hello-world/`).
		 *    Also with pagination (ex: `/post/hello-world/page/2`).
		 *
		 * @param array  $exclude_types Optional. Defaults to `array('revision', 'nav_menu_item')`.
		 *    We will NOT search for these post types. Pass an empty array to search all post types.
		 *    Important to note... it is NOT possible to exclude the `attachment` type;
		 *    because {@link \get_page_by_path()} always searches this type.
		 *
		 * @return null|\WP_Post A WP_Post object instance if found; else NULL.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see http://codex.wordpress.org/Function_Reference/get_page_by_path
		 *    NOTE: This supports MORE than just pages; even though the function name implies otherwise.
		 */
		public function by_path($path, $exclude_types = array('revision', 'nav_menu_item'))
		{
			$this->check_arg_types('string', 'array', func_get_args());

			$path = trim($path, '/'); // Trim all slashes.
			$path = preg_replace($this->©url->regex_wp_pagination_page(), '', $path);

			if($path && $path !== '/') foreach(get_post_types() as $_type) if(!in_array($_type, $exclude_types, TRUE))
			{
				$_type_slug  = $_type; // Default slug.
				$_type_specs = get_post_type_object($_type);

				if($this->©array->is_not_empty($_type_specs->rewrite))
					if($this->©string->is_not_empty($_type_specs->rewrite['slug']))
						$_type_slug = $_type_specs->rewrite['slug'];

				if(($_path = preg_replace('/^'.preg_quote($_type_slug, '/').'\//', '', $path)))
					if(($post = get_page_by_path($_path, OBJECT, $_type)))
						return $post;
			}
			unset($_type, $_type_specs, $_type_slug);

			return NULL; // Default return value.
		}
	}
}