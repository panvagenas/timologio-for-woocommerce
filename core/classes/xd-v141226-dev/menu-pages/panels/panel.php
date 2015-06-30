<?php
/**
 * Menu Page Panel.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class panel extends \xd_v141226_dev\framework
	{
		/**
		 * @var string Slug for this panel.
		 * @note Set to the basename of the class w/ dashes.
		 */
		public $slug = '';

		/**
		 * @var string Heading/title for this panel.
		 * @extenders Should be overridden by class extenders.
		 */
		public $heading_title = '';

		/**
		 * @var string Content/body for this panel.
		 * @extenders Should be overridden by class extenders.
		 */
		public $content_body = '';

		/**
		 * @var string Additional documentation for this panel.
		 * @extenders Can be overridden by class extenders.
		 */
		public $documentation = '';

		/**
		 * @var string YouTube® playlist ID for this panel.
		 * @extenders Can be overridden by class extenders.
		 */
		public $yt_playlist = '';

		/**
		 * @var \xd_v141226_dev\menu_pages\menu_page
		 */
		public $menu_page; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param \xd_v141226_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 */
		public function __construct($instance, $menu_page)
		{
			parent::__construct($instance);

			$this->check_arg_types('', $this->instance->core_ns_prefix.'\\menu_pages\\menu_page', func_get_args());

			$this->slug      = $this->instance->ns_class_basename;
			$this->slug      = $this->©string->with_dashes($this->slug);
			$this->menu_page = $menu_page;
		}
	}
}