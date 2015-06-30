<?php
/**
 * Menu Page.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 140523
 */
namespace xd_v141226_dev\menu_pages
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class update_sync extends menu_page
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's ``$instance``,
		 *    or a new ``$instance`` array.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			$this->heading_title           = $this->__('Plugin Updater');
			$this->sub_heading_description = $this->__('Update to the latest version. It\'s quick &amp; easy<em>!</em>');
		}

		/**
		 * Displays HTML markup producing content panels for this menu page.
		 */
		public function display_content_panels()
		{
			$this->add_content_panel($this->©menu_pages__panels__update($this), TRUE);

			if($this->©plugin->has_pro_active()) // Allow for pro updates too.
				$this->add_content_panel($this->©menu_pages__panels__update_sync_pro($this));

			parent::display_content_panels();
		}
	}
}