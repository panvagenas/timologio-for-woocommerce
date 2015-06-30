<?php
/**
 * Database Cache.
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
	 * Database Cache.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class db_cache extends framework
	{
		/**
		 * @var string WordPress® autoload option.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $option = '';

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance); // Construct instance.

			$this->option = $this->instance->plugin_root_ns_stub.'__db_cache';

			if(!is_array($this->cache = get_option($this->option)))
			{
				delete_option($this->option); // Delete & recreate.
				add_option($this->option, ($this->cache = array()), '', 'no');
				// We do NOT want to autoload this option value, because that requires twice the memory.
				// If we allowed WordPress® to autoload this, it would also be stored into a cache by WordPress® under `alloptions`.
			}
		}

		/**
		 * Gets a cache entry (if it exists).
		 *
		 * @param string $entry Name of a cache entry.
		 *
		 * @param string $group Name of group this cache entry is in.
		 *    This is optional. Defaults to `default` group.
		 *
		 * @return null|mixed Value of cache entry (if it exists); else a NULL value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get($entry, $group = 'default')
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			if(isset($this->cache[$group][$entry]))
				return $this->cache[$group][$entry];

			return NULL; // Default return value.
		}

		/**
		 * Sets and/or updates a cache entry.
		 *
		 * @param string $entry Name of this cache entry.
		 *
		 * @param mixed  $value Value for this cache entry.
		 *
		 * @param string $group Name of a cache group for this entry.
		 *    This is optional. Defaults to `default` group.
		 *
		 * @return mixed Reverberates input `$value` back to the caller.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function update($entry, $value, $group = 'default')
		{
			$this->check_arg_types('string:!empty', '', 'string:!empty', func_get_args());

			$this->cache[$group][$entry] = $value;

			update_option($this->option, $this->cache);

			return $this->cache[$group][$entry];
		}

		/**
		 * Handles automatic cache purges.
		 *
		 * @attaches-to WordPress® `init` hook.
		 * @hook-priority `-10000` Before most everything else.
		 */
		public function init()
		{
			if(is_admin()) $this->purge();
		}

		/**
		 * Purges all cache entries from the database.
		 */
		public function purge()
		{
			$this->cache = array();

			update_option($this->option, $this->cache);
		}

		/**
		 * Deletes all cache entries from the database.
		 */
		public function delete()
		{
			$this->cache = array();

			return delete_option($this->option);
		}

		/**
		 * Adds data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully installed.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___activate___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation)
				return FALSE; // Added security.

			$this->purge();

			return TRUE;
		}

		/**
		 * Removes data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully uninstalled.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___uninstall___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation)
				return FALSE; // Added security.

			$this->delete();

			return TRUE;
		}
	}
}