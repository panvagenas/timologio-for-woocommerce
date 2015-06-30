<?php
/**
 * Package.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 140523
 */
namespace xd_v141226_dev\packages
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Package.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class package extends \xd_v141226_dev\framework
	{
		/**
		 * @var string Package title.
		 */
		public $title = '';

		/**
		 * @var string Package slug.
		 */
		public $slug = '';

		/**
		 * @var string Package author.
		 */
		public $author = '';

		/**
		 * @var string Package description.
		 */
		public $description = '';

		/**
		 * @var string Package version.
		 */
		public $version = '';

		/**
		 * @var dependency[] An array of dependencies.
		 */
		public $dependencies = array();

		/**
		 * @var string URL with more info on the package.
		 */
		public $info_url = '';

		/**
		 * @var string URL leading to an archive (i.e. ZIP file).
		 */
		public $archive_url = '';

		/**
		 * @var string URL (or data URI) leading to an icon file.
		 */
		public $icon_128x128 = '';

		/**
		 * @var string A description of any special requirements.
		 */
		public $requires = '';

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param array        $properties An array of package properties.
		 */
		public function __construct($instance, $properties)
		{
			$this->check_arg_types('', array('array:!empty', 'object:!empty'), func_get_args());

			parent::__construct($instance);

			$this->set_properties($properties);
			foreach($this->dependencies as &$_dependency)
				$_dependency = $this->©package__dependency($_dependency);
			unset($_dependency); // Housekeeping.
		}

		public function install()
		{
			$package_dir = $this->©dir->packages($this->slug);

			$packages_active              = $this->©options->get('packages.active');
			$packages_active[$this->slug] = get_object_vars($this);
			$this->©options->update(array('packages.active' => $packages_active));
		}

		public function uninstall()
		{
			$package_dir = $this->©dir->packages($this->slug);

			$packages_active = $this->©options->get('packages.active');
			unset($packages_active[$this->slug]);
			$this->©options->update(array('packages.active' => $packages_active));
		}
	}
}