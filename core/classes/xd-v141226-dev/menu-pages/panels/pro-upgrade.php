<?php
/**
 * Menu Page Panel.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 140523
 */
namespace xd_v141226_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class pro_upgrade extends panel
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's ``$instance``,
		 *    or a new ``$instance`` array.
		 *
		 * @param \xd_v141226_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($instance, $menu_page)
		{
			parent::__construct($instance, $menu_page);

			$this->heading_title = $this->__('Pro Upgrade').'<em>!</em>';

			$this->content_body = // Pro upgrade.

				'<p class="text-center">'.
				sprintf($this->__('<a href="%1$s" target="_blank"><strong>%2$s Pro</strong></a> is a recommended upgrade. Enhance your site! <a href="%1$s" target="_blank">Click here <i class="fa fa-external-link"></i></a> to learn more about this <strong>amazing software</strong>.'),
				        esc_attr($this->©url->to_plugin_site_uri('/pro/')), esc_html($this->instance->plugin_name)).
				'</p>'.

				'<p class="text-center no-b-margin">'.
				sprintf($this->__('<a class="btn btn-primary width-100" href="%1$s" target="_blank">Upgrade Now <i class="fa fa-external-link"></i></a>'),
				        esc_attr($this->©url->to_plugin_site_uri('/pro/')), esc_html($this->instance->plugin_name)).
				'</p>';
		}
	}
}