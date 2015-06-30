<?php
/**
 * Capabilities.
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
	 * Capabilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class caps extends framework
	{
		/**
		 * Maps our own custom capabilities to existing capabilities in WordPress®.
		 *
		 * @param string $custom_cap Our own custom capability.
		 *
		 * @param string $context Optional context, which can be useful in some cases.
		 *    A `$context` is particularly helpful when applying filters.
		 *
		 * @return string The WordPress® capability that we mapped to.
		 *    Or a custom capability mapped by a custom filter.
		 *
		 * @note Capability mapping for menu pages follows the below standards.
		 *
		 *    - `$custom_cap` is always `manage_[plugin_root_ns]`.
		 *    - `$context` may contain `menu_pages__[menu_page_slug_with_underscores]`;
		 *       or `menu_pages__[header_controls_feature_with_underscores]`;
		 *       or `menu_pages__panel__[panel_slug_with_underscores]`.
		 */
		public function map($custom_cap, $context = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$cap = 'administrator'; // Default capability mapping.

			switch($custom_cap) // Custom capability mapper.
			{
				case 'manage_'.$this->instance->plugin_root_ns;
					$cap = $this->instance->plugin_cap;
					break; // Break switch loop.

				case 'manage_user_profile_fields':
					$cap = 'edit_users';
					break; // Break switch loop.
			}
			return $this->apply_filters($custom_cap, $cap, $context);
		}
	}
}