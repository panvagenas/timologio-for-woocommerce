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
namespace xd_v141226_dev\menu_pages\panels {
	if ( ! defined( 'WPINC' ) ) {
		exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
	}

	/**
	 * Menu Page Panel.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class edd_license extends panel {
		public $heading_title = 'License';
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
		public function __construct( $instance, $menu_page ) {
			parent::__construct( $instance, $menu_page );
			$this->heading_title = $this->heading_title . ' ' . ($this->©edd_updater->getLicenseStatus() ? '<i class="fa fa-circle" style="color: #008000;"></i>' : '<i class="fa fa-circle" style="color: red;"></i>');
			/**
			 * Add the content
			 */
			$this->content_body = $this->©views->view($this, 'edd_license_panel.php');
		}
	}
}