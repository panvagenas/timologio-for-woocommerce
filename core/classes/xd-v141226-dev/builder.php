<?php
/**
 * XDaRk Core (Build Routines).
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
	 * XDaRk Core (Build Routines).
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 */
	final class builder extends framework
	{
		/**
		 * @var successes A successes object instance.
		 */
		public $successes; // Defaults to a NULL value.

		/**
		 * @var boolean Defaults to a value of FALSE, for security purposes.
		 */
		public $can_build = FALSE;

		/**
		 * @var string Core repo dir.
		 */
		public $core_repo_dir = '';

		/**
		 * @var string Core dir.
		 */
		public $core_dir = '';

		/**
		 * @var string Plugin dir.
		 */
		public $plugin_dir = '';

		/**
		 * @var string Plugin repo dir.
		 */
		public $plugin_repo_dir = '';

		/**
		 * @var string Plugin name.
		 */
		public $plugin_name = '';

		/**
		 * @var string Plugin root namespace.
		 */
		public $plugin_root_ns = '';

		/**
		 * @var string Distros directory.
		 */
		public $distros_dir = '';

		/**
		 * @var string Downloads directory.
		 */
		public $downloads_dir = '';

		/**
		 * @var string Pro plugin dir.
		 */
		public $plugin_pro_dir = '';

		/**
		 * @var string Pro plugin repo dir.
		 */
		public $plugin_pro_repo_dir = '';

		/**
		 * @var string Plugin extras dir.
		 */
		public $plugin_extras_dir = '';

		/**
		 * @var string Version number.
		 */
		public $version = '';

		/**
		 * @var string Requires at least Apache version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $requires_at_least_apache_version = '2.1';

		/**
		 * @var string Tested up to Apache version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $tested_up_to_apache_version = '2.4.7';

		/**
		 * @var string Requires at least PHP version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $requires_at_least_php_version = '5.3.1';

		/**
		 * @var string Tested up to PHP version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $tested_up_to_php_version = PHP_VERSION;

		/**
		 * @var string Requires at least WordPress® version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $requires_at_least_wp_version = '3.9';

		/**
		 * @var string Tested up to WordPress® version.
		 * @note This default value is updated by JasWSInc when it needs to change.
		 */
		public $tested_up_to_wp_version = WP_VERSION;

		/**
		 * @var boolean Distribute core in which way?
		 */
		public $use_core_type = 'submodule';

		/**
		 * @var boolean Build from a specific core version?
		 */
		public $build_from_core_version = '';

		/**
		 * @var boolean Current branches (when we start).
		 */
		public $starting_branches = array('core' => '', 'plugin' => '', 'plugin_pro' => '');

		/**
		 * Constructor (initiates build).
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param string       $plugin_dir Optional. Defaults to an empty string.
		 *    By default, we build the XDaRk Core. If supplied, we will build a specific plugin.
		 * @param string       $plugin_name Defaults to an empty string. Required only if `$plugin_dir` is passed also.
		 * @param string       $plugin_root_ns Defaults to an empty string. Required only if `$plugin_dir` is passed also.
		 * @param string       $distros_dir Optional. Defaults to an empty string. Required only if `$plugin_dir` is passed also.
		 * @param string       $downloads_dir Optional. Defaults to an empty string. Required only if `$plugin_dir` is passed also.
		 *
		 * @param string       $version Optional. Defaults to a value of `$this->©date->i18n_utc('ymd')`.
		 *    Must be valid. See: {@link \xd_v141226_dev::$regex_valid_plugin_version}
		 *
		 * @param string       $requires_at_least_apache_version Optional. Defaults to the oldest version tested by the XDaRk Core.
		 * @param string       $tested_up_to_apache_version Optional. Defaults to the newest version tested by the XDaRk Core.
		 *
		 * @param string       $requires_at_least_php_version Optional. Defaults to the oldest version tested by the XDaRk Core.
		 * @param string       $tested_up_to_php_version Optional. Defaults to the newest version tested by the XDaRk Core.
		 *
		 * @param string       $requires_at_least_wp_version Optional. Defaults to the oldest version tested by the XDaRk Core.
		 * @param string       $tested_up_to_wp_version Optional. Defaults to the newest version tested by the XDaRk Core.
		 *
		 * @param null|string  $use_core_type Defaults to `directory`. Can be: `directory`, `phar`, or `stub`.
		 *    This is ONLY applicable to plugin builds. If building the core itself; this parameter is ignored completely.
		 *
		 * @param string       $build_from_core_version Optional. This is partially ignored here. It is handled mostly by `/._dev-utilities/builder.php`.
		 *    However, what DO still use it here (if it's passed in); to some extent. If this is passed in, we will verify the current core version.
		 *    If `$build_from_core_version` is passed in, but it does NOT match this version of the core; an exception will be thrown.
		 *
		 * @note Instantiation of this class will initiate the build routine (please be VERY careful).
		 *    Property `$successes` will contain messages indicating the final result status of the build procedure.
		 *    If there is a failure, an exception is thrown by this class. We either succeed completely; or throw an exception.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to build according to `$this->can_build` property value.
		 * @throws exception If any parameter values are invalid; based on extensive validation in this class.
		 * @throws exception If a build fails for any reason. See: `build()` method for further details.
		 */
		public function __construct($instance, $plugin_dir = '', $plugin_name = '', $plugin_root_ns = '', $distros_dir = '', $downloads_dir = '',
		                            $version = '', $requires_at_least_apache_version = '', $tested_up_to_apache_version = '',
		                            $requires_at_least_php_version = '', $tested_up_to_php_version = '',
		                            $requires_at_least_wp_version = '', $tested_up_to_wp_version = '',
		                            $use_core_type = '', $build_from_core_version = '')
		{
			parent::__construct($instance);

			$this->check_arg_types('', 'string', 'string', 'string', 'string', 'string',
			                       'string', 'string', 'string', 'string', 'string',
			                       'string', 'string', func_get_args());

			// Security check. Can we build here?

			if($this->©env->is_cli() && $this->©plugin->is_core())
				if(defined('___BUILDER') && ___BUILDER)
					$this->can_build = TRUE;

			if(!$this->can_build)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#cannot_build', get_defined_vars(),
					$this->__('Security check. Unable to build (not allowed here).')
				);
			// Construct object properties.

			$this->core_repo_dir = $this->instance->local_core_repo_dir;
			$this->core_dir      = $this->instance->core_dir;

			$this->plugin_dir      = ($plugin_dir) ? $this->©dir->n_seps($plugin_dir) : '';
			$this->plugin_repo_dir = ($plugin_dir) ? $this->©dir->n_seps_up($plugin_dir) : '';
			$this->plugin_name     = ($plugin_dir && $plugin_name) ? $plugin_name : '';
			$this->plugin_root_ns  = ($plugin_dir && $plugin_root_ns) ? $plugin_root_ns : '';
			$this->distros_dir     = ($plugin_dir && $distros_dir) ? $this->©dir->n_seps($distros_dir) : '';
			$this->downloads_dir   = ($plugin_dir && $downloads_dir) ? $this->©dir->n_seps($downloads_dir) : '';

			$this->version                          = ($version) ? (string)$version : $this->©date->i18n_utc('ymd');
			$this->requires_at_least_apache_version = ($requires_at_least_apache_version) ? $requires_at_least_apache_version : $this->requires_at_least_apache_version;
			$this->tested_up_to_apache_version      = ($tested_up_to_apache_version) ? $tested_up_to_apache_version : $this->tested_up_to_apache_version;
			$this->requires_at_least_php_version    = ($requires_at_least_php_version) ? $requires_at_least_php_version : $this->requires_at_least_php_version;
			$this->tested_up_to_php_version         = ($tested_up_to_php_version) ? $tested_up_to_php_version : $this->tested_up_to_php_version;
			$this->requires_at_least_wp_version     = ($requires_at_least_wp_version) ? $requires_at_least_wp_version : $this->requires_at_least_wp_version;
			$this->tested_up_to_wp_version          = ($tested_up_to_wp_version) ? $tested_up_to_wp_version : $this->tested_up_to_wp_version;

			$this->use_core_type           = ($use_core_type) ? $use_core_type : $this->use_core_type;
			$this->build_from_core_version = ($build_from_core_version) ? $build_from_core_version : $this->©command->git_latest_plugin_stable_version_branch($this->core_repo_dir);

			// Validate object properties (among several other things).

			if(!$this->core_repo_dir || !is_dir($this->core_repo_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_core_repo_dir', get_defined_vars(),
					sprintf($this->__('Nonexistent core repo directory: `%1$s`.'), $this->core_repo_dir)
				);
			if(!is_readable($this->core_repo_dir) || !is_writable($this->core_repo_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#core_repo_dir_permissions', get_defined_vars(),
					sprintf($this->__('Permission issues with core repo directory: `%1$s`.'), $this->core_dir)
				);
			if(!is_file($this->core_repo_dir.'/.gitignore'))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#core_repo_dir_gitignore', get_defined_vars(),
					sprintf($this->__('Core repo directory is missing this file: `%1$s`.'), $this->core_repo_dir.'/.gitignore')
				);

			if(!$this->core_dir || !is_dir($this->core_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_core_dir', get_defined_vars(),
					sprintf($this->__('Nonexistent core directory: `%1$s`.'), $this->core_dir)
				);
			if(!is_readable($this->core_dir) || !is_writable($this->core_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#core_dir_permissions', get_defined_vars(),
					sprintf($this->__('Permission issues with core directory: `%1$s`.'), $this->core_dir)
				);

			if($this->plugin_dir) // Also look for possible `-pro` add-on (and/or `-extras`).
			{
				if(!is_dir($this->plugin_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_plugin_dir', get_defined_vars(),
						sprintf($this->__('Nonexistent plugin directory: `%1$s`.'), $this->plugin_dir)
					);
				if(!is_readable($this->plugin_dir) || !is_writable($this->plugin_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_dir_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with plugin directory: `%1$s`.'), $this->plugin_dir)
					);
				if(!$this->plugin_repo_dir || !is_dir($this->plugin_repo_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_plugin_repo_dir', get_defined_vars(),
						sprintf($this->__('Nonexistent plugin repo directory: `%1$s`.'), $this->plugin_repo_dir)
					);
				if(!is_readable($this->plugin_repo_dir) || !is_writable($this->plugin_repo_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_repo_dir_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with plugin repo directory: `%1$s`.'), $this->plugin_repo_dir)
					);
				if(!is_file($this->plugin_repo_dir.'/.gitignore'))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_repo_dir_gitignore', get_defined_vars(),
						sprintf($this->__('Plugin repo directory is missing this file: `%1$s`.'), $this->plugin_repo_dir.'/.gitignore')
					);
				if(!$this->plugin_name)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#missing_plugin_name', get_defined_vars(),
						sprintf($this->__('Missing plugin name for: `%1$s`.'), $this->plugin_dir)
					);
				if(!$this->plugin_root_ns)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#missing_plugin_root_ns', get_defined_vars(),
						sprintf($this->__('Missing plugin root namespace for: `%1$s`.'), $this->plugin_dir)
					);
				if(!$this->distros_dir || !is_dir($this->distros_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_distros_dir', get_defined_vars(),
						sprintf($this->__('Nonexistent distros directory: `%1$s`.'), $this->distros_dir)
					);
				if(!is_readable($this->distros_dir) || !is_writable($this->distros_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#distros_dir_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with distros directory: `%1$s`.'), $this->distros_dir)
					);
				if(!$this->downloads_dir || !is_dir($this->downloads_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_downloads_dir', get_defined_vars(),
						sprintf($this->__('Nonexistent downloads directory: `%1$s`.'), $this->downloads_dir)
					);
				if(!is_readable($this->downloads_dir) || !is_writable($this->downloads_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#downloads_dir_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with downloads directory: `%1$s`.'), $this->downloads_dir)
					);

				$_plugins_dir           = $this->©dir->n_seps_up($this->plugin_dir, 2);
				$_possible_pro_repo_dir = $_plugins_dir.'/'.basename($this->plugin_dir).'-pro';
				$_possible_pro_dir      = $_possible_pro_repo_dir.'/'.basename($this->plugin_dir).'-pro';

				if(is_dir($_possible_pro_repo_dir) && !is_dir($_possible_pro_dir))
					throw $this->©exception( // Should exist in this case.
						$this->method(__FUNCTION__).'#missing_plugin_pro_dir', get_defined_vars(),
						sprintf($this->__('Missing plugin pro directory here: `%1$s`.'), $_possible_pro_dir)
					);
				if(is_dir($_possible_pro_dir))
				{
					$this->plugin_pro_dir      = $_possible_pro_dir;
					$this->plugin_pro_repo_dir = $_possible_pro_repo_dir;
				}
				unset($_plugins_dir, $_possible_pro_repo_dir, $_possible_pro_dir);

				if($this->plugin_pro_dir) // Validate pro plugin directory if it exists.
				{
					if(!is_readable($this->plugin_pro_dir) || !is_writable($this->plugin_pro_dir))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_dir_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin pro directory: `%1$s`.'), $this->plugin_pro_dir)
						);
					if(!is_readable($this->plugin_pro_repo_dir) || !is_writable($this->plugin_pro_repo_dir))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_repo_dir_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin pro repo directory: `%1$s`.'), $this->plugin_pro_repo_dir)
						);
					if(!is_file($this->plugin_pro_repo_dir.'/.gitignore'))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_repo_dir_gitignore', get_defined_vars(),
							sprintf($this->__('Plugin pro directory is missing this file: `%1$s`.'), $this->plugin_pro_repo_dir.'/.gitignore')
						);
				}
				if(is_dir($this->plugin_dir.'-extras'))
					$this->plugin_extras_dir = $this->plugin_dir.'-extras';

				if($this->plugin_extras_dir) // Validate plugin extras directory if it exists.
				{
					if(!is_readable($this->plugin_extras_dir) || !is_writable($this->plugin_extras_dir))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_extras_dir_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin extras directory: `%1$s`.'), $this->plugin_extras_dir)
						);
				}
			}
			// Validate all version strings now.

			if(!$this->©string->is_plugin_version($this->version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_version', get_defined_vars(),
					sprintf($this->__('Invalid version string: `%1$s`.'), $this->version)
				);
			if(!$this->©string->is_version($this->requires_at_least_php_version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_requires_at_least_php_version', get_defined_vars(),
					sprintf($this->__('Invalid `Requires at least` PHP version string: `%1$s`.'), $this->requires_at_least_php_version)
				);
			if(!$this->©string->is_version($this->tested_up_to_php_version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_tested_up_to_php_version', get_defined_vars(),
					sprintf($this->__('Invalid `Tested up to` PHP version string: `%1$s`.'), $this->tested_up_to_php_version)
				);
			if(!$this->©string->is_version($this->requires_at_least_wp_version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_requires_at_least_wp_version', get_defined_vars(),
					sprintf($this->__('Invalid `Requires at least` WP version string: `%1$s`.'), $this->requires_at_least_wp_version)
				);
			if(!$this->©string->is_version($this->tested_up_to_wp_version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_tested_up_to_wp_version', get_defined_vars(),
					sprintf($this->__('Invalid `Tested up to` WP version string: `%1$s`.'), $this->tested_up_to_wp_version)
				);
			// Validate core type.

			if(!in_array($this->use_core_type, array('directory', 'phar', 'stub', 'submodule'), TRUE))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_core_type', get_defined_vars(),
					sprintf($this->__('Invalid core type: `%1$s`.'), $this->use_core_type)
				);
			// Validate core version that we're supposed to be building from.

			if($this->build_from_core_version !== $this->instance->core_version)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_build_from_core_version', get_defined_vars(),
					sprintf($this->__('Building from incorrect core version: `%1$s`.'), $this->build_from_core_version).
					' '.sprintf($this->__('This is version `%1$s` of the %2$s.'), $this->instance->core_version, $this->instance->core_name)
				);
			// Determine starting branches; also check for uncommitted changes and/or untracked files.

			$this->starting_branches['core'] = $this->©command->git_current_branch($this->core_repo_dir);

			if($this->©command->git_changes_exist($this->core_repo_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#changes_exist_in_core_repo_dir', get_defined_vars(),
					sprintf($this->__('Changes exist on core branch/version: `%1$s`.'), $this->starting_branches['core']).
					' '.$this->__('Please commit changes and/or resolve untracked files on the starting branch/version before building.')
				);
			if($this->plugin_dir) // For plugin directory repo (if building a plugin).
			{
				$this->starting_branches['plugin'] = $this->©command->git_current_branch($this->plugin_repo_dir);

				if($this->©command->git_changes_exist($this->plugin_repo_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#changes_exist_in_plugin_repo_dir', get_defined_vars(),
						sprintf($this->__('Changes exist on plugin branch/version: `%1$s`.'), $this->starting_branches['plugin']).
						' '.$this->__('Please commit changes and/or resolve untracked files on the starting branch/version before building.')
					);
			}
			if($this->plugin_dir && $this->plugin_pro_dir) // Pro plugin's pro add-on repo (if building a plugin).
			{
				$this->starting_branches['plugin_pro'] = $this->©command->git_current_branch($this->plugin_pro_repo_dir);

				if($this->©command->git_changes_exist($this->plugin_pro_repo_dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#changes_exist_in_plugin_repo_dir', get_defined_vars(),
						sprintf($this->__('Changes exist on plugin pro branch/version: `%1$s`.'), $this->starting_branches['plugin_pro']).
						' '.$this->__('Please commit changes and/or resolve untracked files on the starting branch/version before building.')
					);
			}
			// Object construction & initial validation complete.

			$this->successes = $this->build(); // Process build routines.
		}

		/**
		 * Handles XDaRk Core and plugin builds.
		 *
		 * @return successes Returns an instance of successes; else throws an exception on any type of failure.
		 *
		 * @throws exception On any kind of build failure (no matter what the issue is).
		 *    We either succeed completely; or we throw an exception.
		 */
		protected function build()
		{
			$successes = $this->©successes(
				$this->method(__FUNCTION__).'#start_time', get_defined_vars(),
				sprintf($this->__('Start time: %1$s.'), $this->©env->time_details())
			);
			$successes->add($this->method(__FUNCTION__).'#starting_branch_core', get_defined_vars(),
			                sprintf($this->__('Building from %1$s branch: `%2$s` (version: `%3$s`) w/ class file: `%4$s`.'),
			                        $this->instance->core_name, $this->starting_branches['core'], $this->instance->core_version, $this->©dir->n_seps(__FILE__))
			);
			if($this->plugin_dir) // Building a plugin.
			{
				// Create a restore point by committing all files.

				$this->©command->git('add --all', $this->plugin_repo_dir);
				$this->©command->git('commit --all --allow-empty --message '. // Restore point (before building).
				                     escapeshellarg($this->__('Auto-commit; before building plugin.')), $this->plugin_repo_dir);

				$successes->add($this->method(__FUNCTION__).'#before_building_plugin', get_defined_vars(),
				                sprintf($this->__('Restore point. All existing files (new and/or changed) on the starting branch: `%1$s`; have been added to the list of version controlled files in this plugin repo: `%2$s`.'), $this->starting_branches['plugin'], $this->plugin_repo_dir).
				                ' '.$this->__('A commit has been processed for all changes to the existing file structure (before new branch creation).')
				);
				// Create a new branch for this version (and switch to this new branch).

				$this->©command->git('checkout -b '.escapeshellarg($this->version), $this->plugin_repo_dir);

				$successes->add($this->method(__FUNCTION__).'#new_branch_before_building_plugin', get_defined_vars(),
				                sprintf($this->__('A new branch has been created for plugin version: `%1$s`.'), $this->version).
				                ' '.sprintf($this->__('Now working from this new branch: `%1$s`.'), $this->version)
				);
				// XDaRk Core replication.

				$_new_core_dir = $this->plugin_dir.'/'.$this->instance->core_ns_stub_with_dashes;

				$this->©dir->delete($_new_core_dir); // In case it already exists.
				$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_core_dir.'/'), $this->plugin_repo_dir);

				$this->©dir->rename_to($this->©replicate($this->plugin_dir, $this->plugin_repo_dir, '', array($this::gitignore => $this->core_repo_dir.'/.gitignore'))->new_core_dir, $_new_core_dir);
				$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_dir.'/'), $this->plugin_repo_dir);

				// Add/remove directories/files based on build type.

				if($this->use_core_type !== 'directory') // Delete directory?
				{
					$this->©dir->delete($_new_core_dir); // Delete directory immediately.
					$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), $this->plugin_repo_dir);
				}
				$successes->add($this->method(__FUNCTION__).'#new_core_dir_replication_into_plugin_dir', get_defined_vars(),
				                sprintf($this->__('The %1$s has been temporarily replicated into this plugin directory location: `%2$s`.'), $this->instance->core_name, $_new_core_dir).
				                ' '.sprintf($this->__('Every file in the entire plugin repo directory has now been updated to use `v%1$s` of the %2$s.'), $this->instance->core_version, $this->instance->core_name).
				                (($this->use_core_type === 'directory') ? ' '.sprintf($this->__('The temporary %1$s directory has been added to the list of version controlled files in this plugin repo (but only temporarily; for distro creation momentarily).'), $this->instance->core_name)
					                : ' '.sprintf($this->__('The temporary %1$s directory has been deleted; and also removed from the list of version controlled files in this repo. It will be excluded from the final distro.'), $this->instance->core_name))
				);
				if($this->use_core_type !== 'directory') unset($_new_core_dir); // Housekeeping.

				if($this->use_core_type !== 'submodule') // XDaRk Core stub file?
				{
					$_core_stub     = $this->core_dir.'/stub.php';
					$_new_core_stub = $this->plugin_dir.'/'.$this->instance->core_ns_stub_with_dashes.'.php';

					$this->©file->delete($_new_core_stub); // In case it already exists.
					$this->©command->git('rm --cached --ignore-unmatch '.escapeshellarg($_new_core_stub), $this->plugin_repo_dir);

					$this->©file->copy_to($_core_stub, $_new_core_stub);
					$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_stub), $this->plugin_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_core_stub_added_to_plugin_dir', get_defined_vars(),
					                sprintf($this->__('The %1$s stub has been added to the plugin directory here: `%2$s`.'), $this->instance->core_name, $_new_core_stub).
					                ' '.sprintf($this->__('The %1$s stub has also been added to the list of version controlled files in this plugin repo: `%2$s`.'), $this->instance->core_name, $this->plugin_repo_dir).
					                ' '.sprintf($this->__('The %1$s stub will remain in the plugin repo. This unifies the way in which plugins include the %1$s. Making it possible for a plugin to utilize different types of %1$s distributions — without modification.'), $this->instance->core_name).
					                ' '.sprintf($this->__('While a plugin\'s repo will NOT include the entire %1$s (that\'s what the distro is for); leaving the stub behind (in the repo) allows a plugin to function, so long as the %1$s is available somewhere on the site; in one form or another.'), $this->instance->core_name)
					);
					unset($_core_stub, $_new_core_stub); // Housekeeping.
				}
				if($this->use_core_type === 'phar') // Bundle XDaRk Core PHP archive (e.g. the PHAR file)?
				{
					$_core_phar                = $this->core_repo_dir.'/.~'.$this->instance->core_ns_stub_with_dashes.'.php.phar';
					$_new_core_phar            = $this->plugin_dir.'/'.$this->instance->core_ns_stub_with_dashes.'.php.phar';
					$_plugin_dir_htaccess_file = $this->plugin_dir.'/.htaccess';

					$this->©file->delete($_new_core_phar); // In case it already exists.
					$this->©command->git('rm --cached --ignore-unmatch '.escapeshellarg($_new_core_phar), $this->plugin_repo_dir);

					if(!is_file($_plugin_dir_htaccess_file)
					   || !is_readable($_plugin_dir_htaccess_file)
					   || FALSE === strpos(file_get_contents($_plugin_dir_htaccess_file), 'AcceptPathInfo')
					) throw $this->©exception(
						$this->method(__FUNCTION__).'#unable_to_find_valid_htaccess_file_in_plugin_dir', get_defined_vars(),
						sprintf($this->__('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_plugin_dir_htaccess_file).
						' '.$this->__('This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
					);
					$this->©file->copy_to($_core_phar, $_new_core_phar);
					$this->©command->git('add --intent-to-add '.escapeshellarg($_new_core_phar), $this->plugin_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_core_phar_added_to_plugin_dir', get_defined_vars(),
					                sprintf($this->__('The %1$s PHAR file for `v%2$s`; has been copied to: `%3$s`.'), $this->instance->core_name, $this->instance->core_version, $_new_core_phar).
					                ' '.sprintf($this->__('This file (a compressed PHP Archive); has been added to the list of version controlled files in this plugin repo: `%1$s` (but only temporarily; for distro creation momentarily).'), $this->plugin_repo_dir)
					);
					unset($_core_phar, $_plugin_dir_htaccess_file); // Housekeeping.
				}
				// Update various plugin files w/ version numbers and other requirements.

				$_plugin_file           = $this->plugin_dir.'/plugin.php';
				$_plugin_readme_file    = $this->plugin_dir.'/readme.txt';
				$_plugin_framework_file = $this->plugin_dir.'/classes/'.$this->©string->with_dashes($this->plugin_root_ns).'/framework.php';

				if(!is_file($_plugin_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_plugin_file', get_defined_vars(),
						sprintf($this->__('Nonexistent plugin file: `%1$s`.'), $_plugin_file)
					);
				if(!is_readable($_plugin_file) || !is_writable($_plugin_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with plugin file: `%1$s`.'), $_plugin_file)
					);

				if(!is_file($_plugin_readme_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_plugin_readme_file', get_defined_vars(),
						sprintf($this->__('Nonexistent plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
					);
				if(!is_readable($_plugin_readme_file) || !is_writable($_plugin_readme_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_readme_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with plugin `readme.txt` file: `%1$s`.'), $_plugin_readme_file)
					);

				if(!is_file($_plugin_framework_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_plugin_framework_file', get_defined_vars(),
						sprintf($this->__('Nonexistent plugin `framework.php` file: `%1$s`.'), $_plugin_framework_file)
					);
				if(!is_readable($_plugin_framework_file) || !is_writable($_plugin_framework_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_framework_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with plugin `framework.php` file: `%1$s`.'), $_plugin_framework_file)
					);
				$_plugin_file_contents           = file_get_contents($_plugin_file);
				$_plugin_readme_file_contents    = file_get_contents($_plugin_readme_file);
				$_plugin_framework_file_contents = file_get_contents($_plugin_framework_file);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_plugin_readme_file_contents);

				$_plugin_file_contents        = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_file_contents);
				$_plugin_readme_file_contents = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_readme_file_contents);

				$_plugin_framework_file_contents = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_plugin_framework_file_contents);

				if(!file_put_contents($_plugin_file, $_plugin_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_file_write_error', get_defined_vars(),
						$this->__('Unable to write (update) the plugin file.')
					);
				if(!file_put_contents($_plugin_readme_file, $_plugin_readme_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_readme_file_write_error', get_defined_vars(),
						$this->__('Unable to write (update) the plugin `readme.txt` file.')
					);
				if(!file_put_contents($_plugin_framework_file, $_plugin_framework_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#plugin_framework_file_write_error', get_defined_vars(),
						$this->__('Unable to write (update) the plugin `framework.php` file.')
					);
				$successes->add($this->method(__FUNCTION__).'#plugin_file_updates', get_defined_vars(),
				                $this->__('Plugin files updated with versions/requirements.').
				                ' '.sprintf($this->__('Plugin version: `%1$s`.'), $this->version).
				                ' '.sprintf($this->__('Plugin requires at least Apache version: `%1$s`.'), $this->requires_at_least_apache_version).
				                ' '.sprintf($this->__('Tested up to Apache version: `%1$s`.'), $this->tested_up_to_apache_version).
				                ' '.sprintf($this->__('Plugin requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_version).
				                ' '.sprintf($this->__('Tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_version).
				                ' '.sprintf($this->__('Uses %1$s: `v%2$s`.'), $this->instance->core_name, $this->instance->core_version).
				                ' '.sprintf($this->__('Plugin requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_version).
				                ' '.sprintf($this->__('Plugin tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_version)
				);
				unset($_plugin_file, $_plugin_framework_file, $_plugin_readme_file);
				unset($_plugin_file_contents, $_plugin_framework_file_contents, $_plugin_readme_file_contents);

				// Copy distribution files into the distros directory.

				$_plugin_distro_dir = $this->distros_dir.'/'.basename($this->plugin_dir);

				$this->©dir->delete($_plugin_distro_dir);
				$this->©dir->copy_to($this->plugin_dir, $_plugin_distro_dir, array($this::gitignore => $this->plugin_repo_dir.'/.gitignore'), TRUE);

				$successes->add($this->method(__FUNCTION__).'#plugin_distro_files', get_defined_vars(),
				                sprintf($this->__('Plugin distro files copied to: `%1$s`.'), $_plugin_distro_dir)
				);
				// Generate plugin distro directory checksum.

				$_plugin_distro_dir_checksum = $this->©dir->checksum($_plugin_distro_dir, TRUE);

				$successes->add($this->method(__FUNCTION__).'#plugin_distro_dir_checksum', get_defined_vars(),
				                sprintf($this->__('Plugin distro directory checksum file updated to: `%1$s`.'), $_plugin_distro_dir_checksum)
				);
				unset($_plugin_distro_dir_checksum); // Housekeeping.

				// Create ZIP archives.

				$_plugin_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_dir).'.zip';
				$_plugin_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_dir).'-v'.$this->version.'.zip';

				$this->©file->delete($_plugin_download_zip, $_plugin_download_v_zip);
				$this->©dir->zip_to($_plugin_distro_dir, $_plugin_download_zip);
				$this->©file->copy_to($_plugin_download_zip, $_plugin_download_v_zip);

				$successes->add($this->method(__FUNCTION__).'#plugin_distro_zips', get_defined_vars(),
				                sprintf($this->__('Plugin distro zipped into: `%1$s`.'), $_plugin_download_zip).
				                ' '.sprintf($this->__('And copied into this version: `%1$s`.'), $_plugin_download_v_zip)
				);
				unset($_plugin_distro_dir, $_plugin_download_zip, $_plugin_download_v_zip); // Housekeeping.

				// Remove temporary XDaRk Core directory from the plugin directory.

				if($this->use_core_type === 'directory' && isset($_new_core_dir))
				{
					$this->©dir->delete($_new_core_dir); // Delete this directory now.
					$this->©command->git('rm -r --cached '.escapeshellarg($_new_core_dir.'/'), $this->plugin_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_core_dir_deletion', get_defined_vars(),
					                ' '.sprintf($this->__('The temporary %1$s directory: `%2$s`; has been deleted from the plugin directory.'), $this->instance->core_name, $_new_core_dir).
					                ' '.sprintf($this->__('The temporary %1$s directory was also removed from the list of version controlled files in this repo: `%2$s`.'), $this->instance->core_name, $this->plugin_repo_dir)
					);
					unset($_new_core_dir); // Housekeeping.
				}
				// Remove new temporary XDaRk Core PHAR file from the plugin directory.

				if($this->use_core_type === 'phar' && isset($_new_core_phar))
				{
					$this->©file->delete($_new_core_phar); // Delete this file from the plugin directory now.
					$this->©command->git('rm --cached '.escapeshellarg($_new_core_phar), $this->plugin_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_core_phar_deletion', get_defined_vars(),
					                ' '.sprintf($this->__('The temporary %1$s PHAR file: `%2$s`; has been deleted from the plugin directory.'), $this->instance->core_name, $_new_core_phar).
					                ' '.sprintf($this->__('The temporary %1$s PHAR file was also removed from the list of version controlled files in this repo: `%2$s`.'), $this->instance->core_name, $this->plugin_repo_dir)
					);
					unset($_new_core_phar); // Housekeeping.
				}
				// Handle a possible pro add-on directory.

				if($this->plugin_pro_dir) // Is there a pro directory also?
				{
					// Create a restore point by committing all new and/or changed files.

					$this->©command->git('add --all', $this->plugin_pro_repo_dir);
					$this->©command->git('commit --all --allow-empty --message '. // Restore point (before building).
					                     escapeshellarg($this->__('Auto-commit; before building pro add-on.')), $this->plugin_pro_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#before_building_plugin_pro', get_defined_vars(),
					                sprintf($this->__('Restore point. All existing files (new and/or changed) on the starting branch: `%1$s`; have been added to the list of version controlled files in this plugin\'s pro repo directory: `%2$s`.'), $this->starting_branches['plugin_pro'], $this->plugin_pro_repo_dir).
					                ' '.$this->__('A commit has been processed for all changes to the existing file structure (before new branch creation).')
					);
					// Create a new branch for this version (and switch to this new branch).

					$this->©command->git('checkout -b '.escapeshellarg($this->version), $this->plugin_pro_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_branch_before_building_plugin_pro', get_defined_vars(),
					                sprintf($this->__('A new branch has been created for plugin pro version: `%1$s`.'), $this->version).
					                ' '.sprintf($this->__('Now working from this new branch: `%1$s`.'), $this->version)
					);
					// XDaRk Core replication.

					$_new_pro_core_dir = $this->plugin_pro_dir.'/'.$this->instance->core_ns_stub_with_dashes;

					$this->©dir->delete($_new_pro_core_dir); // In case it already exists.
					$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_pro_core_dir.'/'), $this->plugin_pro_repo_dir);

					$this->©dir->rename_to($this->©replicate($this->plugin_pro_dir, $this->plugin_pro_repo_dir, '', array($this::gitignore => $this->core_repo_dir.'/.gitignore'))->new_core_dir, $_new_pro_core_dir);
					$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_pro_core_dir.'/'), $this->plugin_pro_repo_dir);
					$this->©dir->delete($_new_pro_core_dir); // Remove it immediately.

					$successes->add($this->method(__FUNCTION__).'#new_core_dir_replication_into_plugin_pro_dir', get_defined_vars(),
					                sprintf($this->__('The %1$s has been temporarily replicated into this plugin pro directory: `%2$s`.'), $this->instance->core_name, $_new_pro_core_dir).
					                ' '.sprintf($this->__('Every file in the entire plugin pro repo directory has now been updated to use `v%1$s` of the %2$s.'), $this->instance->core_version, $this->instance->core_name).
					                ' '.sprintf($this->__('The temporary %1$s was deleted from the plugin pro directory immediately after processing: `%2$s`.'), $this->instance->core_name, $_new_pro_core_dir)
					);
					unset($_new_pro_core_dir); // Housekeeping.

					// Update various plugin pro files w/ version numbers and other requirements.

					$_plugin_pro_file        = $this->plugin_pro_dir.'/plugin.php';
					$_plugin_pro_readme_file = $this->plugin_pro_dir.'/readme.txt';
					$_plugin_pro_class_file  = $this->plugin_pro_dir.'/classes/'.$this->©string->with_dashes($this->plugin_root_ns).'/pro.php';

					if(!is_file($_plugin_pro_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#nonexistent_plugin_pro_file', get_defined_vars(),
							sprintf($this->__('Nonexistent plugin pro file: `%1$s`.'), $_plugin_pro_file)
						);
					if(!is_readable($_plugin_pro_file) || !is_writable($_plugin_pro_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_file_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin pro file: `%1$s`.'), $_plugin_pro_file)
						);

					if(!is_file($_plugin_pro_readme_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#nonexistent_plugin_pro_readme_file', get_defined_vars(),
							sprintf($this->__('Nonexistent plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
						);
					if(!is_readable($_plugin_pro_readme_file) || !is_writable($_plugin_pro_readme_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_readme_file_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin pro `readme.txt` file: `%1$s`.'), $_plugin_pro_readme_file)
						);

					if(!is_file($_plugin_pro_class_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#nonexistent_plugin_pro_class_file', get_defined_vars(),
							sprintf($this->__('Nonexistent plugin `pro.php` class file: `%1$s`.'), $_plugin_pro_class_file)
						);
					if(!is_readable($_plugin_pro_class_file) || !is_writable($_plugin_pro_class_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_class_file_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with plugin `pro.php` class file: `%1$s`.'), $_plugin_pro_class_file)
						);

					$_plugin_pro_file_contents        = file_get_contents($_plugin_pro_file);
					$_plugin_pro_readme_file_contents = file_get_contents($_plugin_pro_readme_file);
					$_plugin_pro_class_file_contents  = file_get_contents($_plugin_pro_class_file);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_file_contents        = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_pro_file_contents);
					$_plugin_pro_readme_file_contents = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_plugin_pro_readme_file_contents);

					$_plugin_pro_class_file_contents = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_plugin_pro_class_file_contents);

					if(!file_put_contents($_plugin_pro_file, $_plugin_pro_file_contents))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_file_write_error', get_defined_vars(),
							$this->__('Unable to write (update) the plugin pro file.')
						);
					if(!file_put_contents($_plugin_pro_readme_file, $_plugin_pro_readme_file_contents))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_readme_file_write_error', get_defined_vars(),
							$this->__('Unable to write (update) the plugin pro `readme.txt` file.')
						);
					if(!file_put_contents($_plugin_pro_class_file, $_plugin_pro_class_file_contents))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#plugin_pro_class_file_write_error', get_defined_vars(),
							$this->__('Unable to write (update) the plugin `pro.php` class file.')
						);

					$successes->add($this->method(__FUNCTION__).'#plugin_pro_file_updates', get_defined_vars(),
					                $this->__('Plugin pro files updated with versions/requirements.').
					                ' '.sprintf($this->__('Plugin pro version: `%1$s`.'), $this->version).
					                ' '.sprintf($this->__('Pro add-on requires at least Apache version: `%1$s`.'), $this->requires_at_least_apache_version).
					                ' '.sprintf($this->__('Pro add-on tested up to Apache version: `%1$s`.'), $this->tested_up_to_apache_version).
					                ' '.sprintf($this->__('Pro add-on requires at least PHP version: `%1$s`.'), $this->requires_at_least_php_version).
					                ' '.sprintf($this->__('Pro add-on tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_version).
					                ' '.sprintf($this->__('Uses %1$s: `v%2$s`.'), $this->instance->core_name, $this->instance->core_version).
					                ' '.sprintf($this->__('Pro add-on requires at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_version).
					                ' '.sprintf($this->__('Pro add-on tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_version)
					);
					unset($_plugin_pro_file, $_plugin_pro_class_file, $_plugin_pro_readme_file);
					unset($_plugin_pro_file_contents, $_plugin_pro_class_file_contents, $_plugin_pro_readme_file_contents);

					// Copy distribution files into the distros directory.

					$_plugin_pro_distro_dir = $this->distros_dir.'/'.basename($this->plugin_pro_dir);

					$this->©dir->delete($_plugin_pro_distro_dir);
					$this->©dir->copy_to($this->plugin_pro_dir, $_plugin_pro_distro_dir, array($this::gitignore => $this->plugin_pro_repo_dir.'/.gitignore'), TRUE);

					$successes->add($this->method(__FUNCTION__).'#plugin_pro_distro_files', get_defined_vars(),
					                sprintf($this->__('Plugin pro distro files copied to: `%1$s`.'), $_plugin_pro_distro_dir)
					);
					// Generate plugin distro directory checksum.

					$_plugin_pro_distro_dir_checksum = $this->©dir->checksum($_plugin_pro_distro_dir, TRUE);

					$successes->add($this->method(__FUNCTION__).'#plugin_pro_distro_dir_checksum', get_defined_vars(),
					                sprintf($this->__('Plugin pro distro directory checksum file updated to: `%1$s`.'), $_plugin_pro_distro_dir_checksum)
					);
					unset($_plugin_pro_distro_dir_checksum); // Housekeeping.

					// Create ZIP archives.

					$_plugin_pro_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'.zip';
					$_plugin_pro_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_pro_dir).'-v'.$this->version.'.zip';

					$this->©file->delete($_plugin_pro_download_zip, $_plugin_pro_download_zip);
					$this->©dir->zip_to($_plugin_pro_distro_dir, $_plugin_pro_download_zip);
					$this->©file->copy_to($_plugin_pro_download_zip, $_plugin_pro_download_v_zip);

					$successes->add($this->method(__FUNCTION__).'#plugin_pro_distro_zips', get_defined_vars(),
					                sprintf($this->__('Plugin pro distro zipped into: `%1$s`.'), $_plugin_pro_download_zip).
					                ' '.sprintf($this->__('And copied into this version: `%1$s`.'), $_plugin_pro_download_v_zip)
					);
					unset($_plugin_pro_distro_dir, $_plugin_pro_download_zip, $_plugin_pro_download_v_zip);

					// A final commit before we complete the pro add-on build procedure.

					$this->©command->git('add --all', $this->plugin_pro_repo_dir);
					$this->©command->git('commit --all --allow-empty --message '. // Final commit (after building).
					                     escapeshellarg($this->__('Auto-commit; after building pro add-on.')), $this->plugin_pro_repo_dir);

					if($this->©string->is_plugin_stable_version($this->version))
						$this->©command->git('tag --message '. // Tag this commit (after building).
						                     escapeshellarg(sprintf($this->__('%1$s (Pro) v%2$s.'), $this->plugin_name, $this->version)).
						                     ' '.escapeshellarg($this->version), $this->plugin_pro_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#commit_after_building_plugin_pro', get_defined_vars(),
					                sprintf($this->__('All files (new and/or changed) on branch: `%1$s`; have been added to the list of version controlled files in the plugin pro repo.'), $this->version).
					                ' '.$this->__('Pro add-on finale. A commit has been processed for all changes to the new pro directory/file structure.').
					                ' '.sprintf($this->__('Tagged stable release as: `%1$s`.'), $this->version)
					);
				}
				// Handle a possible extras directory.

				if($this->plugin_extras_dir) // Is there an extras directory also?
				{
					// XDaRk Core replication.

					$_new_extras_core_dir = $this->plugin_extras_dir.'/'.$this->instance->core_ns_stub_with_dashes;

					$this->©dir->delete($_new_extras_core_dir); // In case it already exists.
					$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_extras_core_dir.'/'), $this->plugin_repo_dir);

					$this->©dir->rename_to($this->©replicate($this->plugin_extras_dir, $this->plugin_extras_dir, '', array($this::gitignore => $this->core_repo_dir.'/.gitignore'))->new_core_dir, $_new_extras_core_dir);
					$this->©command->git('rm -r --cached --ignore-unmatch '.escapeshellarg($_new_extras_core_dir.'/'), $this->plugin_repo_dir);
					$this->©dir->delete($_new_extras_core_dir); // Remove it immediately.

					$successes->add($this->method(__FUNCTION__).'#new_core_dir_replication_into_plugin_extras_dir', get_defined_vars(),
					                sprintf($this->__('The %1$s has been temporarily replicated into this plugin extras directory: `%2$s`.'), $this->instance->core_name, $_new_extras_core_dir).
					                ' '.sprintf($this->__('Every file in the entire plugin extras directory has now been updated to use `v%1$s` of the %2$s.'), $this->instance->core_version, $this->instance->core_name).
					                ' '.sprintf($this->__('The temporary %1$s was deleted from the plugin extras directory immediately after processing: `%2$s`.'), $this->instance->core_name, $_new_extras_core_dir)
					);
					unset($_new_extras_core_dir); // Housekeeping.

					// Update various extra files w/ version numbers and other requirements.

					$_core_deps_x_file               = $this->core_dir.'/classes/'.$this->instance->core_ns_with_dashes.'/deps-x.php';
					$_new_server_scanner_file        = $this->plugin_extras_dir.'/'.basename($this->plugin_dir).'-server-scanner.php';
					$_new_server_scanner_plugin_dirs = basename($this->plugin_dir).(($this->plugin_pro_dir) ? ','.basename($this->plugin_pro_dir) : '');

					if(!is_file($_core_deps_x_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#nonexistent_core_deps_x_file', get_defined_vars(),
							sprintf($this->__('Nonexistent core `deps-x.php` file: `%1$s`.'), $_core_deps_x_file)
						);
					if(!is_readable($_core_deps_x_file))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#core_deps_x_file_permissions', get_defined_vars(),
							sprintf($this->__('Permission issues with core `deps-x.php` file: `%1$s`.'), $_core_deps_x_file)
						);

					$_new_server_scanner_file_contents = file_get_contents($_core_deps_x_file);
					$_new_server_scanner_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_name', $this->plugin_name, $_new_server_scanner_file_contents);
					$_new_server_scanner_file_contents = $this->regex_replace('php_code__deps_x__define_stand_alone_plugin_dir_names', $_new_server_scanner_plugin_dirs, $_new_server_scanner_file_contents);
					$_new_server_scanner_file_contents = $this->regex_replace('php_code__deps_x__declare_stand_alone_class_name', '_stand_alone', $_new_server_scanner_file_contents);

					$this->©file->delete($_new_server_scanner_file); // In case it already exists.
					$this->©command->git('rm --cached --ignore-unmatch '.escapeshellarg($_new_server_scanner_file.'/'), $this->plugin_repo_dir);

					if(!file_put_contents($_new_server_scanner_file, $_new_server_scanner_file_contents))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#new_server_scanner_file_write_error', get_defined_vars(),
							$this->__('Unable to write the new plugin server scanner file.')
						);
					$this->©command->git('add --intent-to-add '.escapeshellarg($_new_server_scanner_file.'/'), $this->plugin_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#plugin_extra_file_updates', get_defined_vars(),
					                $this->__('Plugin extra files updated with versions/requirements/etc.').
					                ' '.sprintf($this->__('Extras version: `%1$s`.'), $this->version).
					                ' '.sprintf($this->__('Extras require at least PHP version: `%1$s`.'), $this->requires_at_least_php_version).
					                ' '.sprintf($this->__('Extras tested up to PHP version: `%1$s`.'), $this->tested_up_to_php_version).
					                ' '.sprintf($this->__('Extras using %1$s: `v%2$s`.'), $this->instance->core_name, $this->instance->core_version).
					                ' '.sprintf($this->__('Extras require at least WordPress® version: `%1$s`.'), $this->requires_at_least_wp_version).
					                ' '.sprintf($this->__('Extras tested up to WordPress® version: `%1$s`.'), $this->tested_up_to_wp_version).
					                ' '.sprintf($this->__('New server scanner file (now under verion control in the plugin repo): `%1$s`.'), $_new_server_scanner_file)
					);
					unset($_core_deps_x_file, $_new_server_scanner_file, $_new_server_scanner_plugin_dirs, $_new_server_scanner_file_contents);

					// Copy distribution files into the distros directory.

					$_plugin_extras_distro_dir = $this->distros_dir.'/'.basename($this->plugin_extras_dir);

					$this->©dir->delete($_plugin_extras_distro_dir);
					$this->©dir->copy_to($this->plugin_extras_dir, $_plugin_extras_distro_dir);

					$successes->add($this->method(__FUNCTION__).'#plugin_extras_distro_files', get_defined_vars(),
					                sprintf($this->__('Plugin extras distro files copied to: `%1$s`.'), $_plugin_extras_distro_dir)
					);

					// Create ZIP archives.

					$_plugin_extras_download_zip   = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'.zip';
					$_plugin_extras_download_v_zip = $this->downloads_dir.'/'.basename($this->plugin_extras_dir).'-v'.$this->version.'.zip';

					$this->©file->delete($_plugin_extras_download_zip, $_plugin_extras_download_v_zip);
					$this->©dir->zip_to($_plugin_extras_distro_dir, $_plugin_extras_download_zip);
					$this->©file->copy_to($_plugin_extras_download_zip, $_plugin_extras_download_v_zip);

					$successes->add($this->method(__FUNCTION__).'#plugin_extras_distro_zips', get_defined_vars(),
					                sprintf($this->__('Plugin extras distro zipped into: `%1$s`.'), $_plugin_extras_download_zip).
					                ' '.sprintf($this->__('And copied into this version: `%1$s`.'), $_plugin_extras_download_v_zip)
					);
					unset($_plugin_extras_distro_dir, $_plugin_extras_download_zip, $_plugin_extras_download_v_zip);
				}
				// A final commit before we complete the build procedure.

				$this->©command->git('add --all', $this->plugin_repo_dir);
				$this->©command->git('commit --all --allow-empty --message '. // Final commit (after building).
				                     escapeshellarg($this->__('Auto-commit; after building plugin.')), $this->plugin_repo_dir);

				if($this->©string->is_plugin_stable_version($this->version))
					$this->©command->git('tag --message '. // Tag this commit (after building).
					                     escapeshellarg(sprintf($this->__('%1$s v%2$s.'), $this->plugin_name, $this->version)).
					                     ' '.escapeshellarg($this->version), $this->plugin_repo_dir);

				$successes->add($this->method(__FUNCTION__).'#commit_before_plugin_build_complete', get_defined_vars(),
				                sprintf($this->__('All files (new and/or changed) on branch: `%1$s`; have been added to the list of version controlled files in the plugin repo directory: `%2$s`.'), $this->version, $this->plugin_repo_dir).
				                ' '.$this->__('Plugin finale. A commit has been processed for all changes to the new file structure.').
				                ' '.sprintf($this->__('Tagged stable release as: `%1$s`.'), $this->version)
				);
				$successes->add($this->method(__FUNCTION__).'#plugin_build_complete', get_defined_vars(), $this->__('Plugin build complete!'));
			}
			// Building the XDaRk Core.

			else // We will either build a new XDaRk Core (or rebuild this one).
			{
				$is_new       = ($this->instance->core_version !== $this->version);
				$building     = ($is_new) ? $this->__('building') : $this->__('rebuilding');
				$build        = ($is_new) ? $this->__('build') : $this->__('rebuild');
				$ucfirst_core = ($is_new) ? $this->__('New core') : $this->__('Core');
				$new_space    = ($is_new) ? $this->__('new').' ' : '';
				$new_slug     = ($is_new) ? 'new_' : '';

				// Create a restore point by committing all new and/or changed files.

				$this->©command->git('add --all', $this->core_repo_dir);
				$this->©command->git('commit --all --allow-empty --message '. // Restore point (before building).
				                     escapeshellarg(sprintf($this->__('Auto-commit; before %1$s %2$score.'), $building, $new_space)), $this->core_repo_dir);

				$successes->add($this->method(__FUNCTION__).'#before_building_'.$new_slug.'core', get_defined_vars(),
				                sprintf($this->__('Restore point. All existing files (new and/or changed) on the starting branch: `%1$s`; have been added to the list of version controlled files in the %2$s repo directory: `%3$s`.'), $this->starting_branches['core'], $this->instance->core_name, $this->core_repo_dir).
				                ' '.sprintf($this->__('A commit has been processed for all changes to the existing file structure%1$s.'), (($is_new) ? ' '.$this->__('(before new branch creation occurs)') : ''))
				);
				// Create a new branch for this version (and switch to this new branch).

				if($is_new) // Replicate XDaRk Core into a new directory.
				{
					$this->©command->git('checkout -b '.escapeshellarg($this->version), $this->core_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#branch_new_core_dir', get_defined_vars(),
					                sprintf($this->__('A new branch has been created for core version: `%1$s`.'), $this->version).
					                ' '.sprintf($this->__('Now working from this new branch: `%1$s`.'), $this->version)
					);
					$_this_core_dir = $this->©replicate($this->core_repo_dir, $this->core_repo_dir, $this->version)
						->new_core_dir; // Replicate; and then grab the new core directory here.

					$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_dir), $this->core_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#new_core_dir_replication', get_defined_vars(),
					                sprintf($this->__('The %1$s has been temporarily replicated into this directory: `%2$s`.'), $this->instance->core_name, $_this_core_dir).
					                ' '.sprintf($this->__('This directory has also been added to the list of version controlled files in the %1$s repo (but only temporarily; for distro creation momentarily).'), $this->instance->core_name).
					                ' '.sprintf($this->__('This directory will be renamed later in this routine. It will override the existing %1$s on this new branch once we\'re done here.'), $this->instance->core_name)
					);
				}
				else $_this_core_dir = $this->core_dir; // Use directory as-is.

				// Update various core files w/ version numbers and other requirements.

				$_this_core_stub_file   = $_this_core_dir.'/stub.php';
				$_this_core_plugin_file = $_this_core_dir.'/plugin.php';
				$_this_core_readme_file = $_this_core_dir.'/readme.txt';
				$_this_core_deps_x_file = $_this_core_dir.'/classes/'.$this->instance->core_ns_stub_v_with_dashes.$this->©string->with_dashes($this->version).'/deps-x.php';

				if(!is_file($_this_core_stub_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_'.$new_slug.'core_stub_file', get_defined_vars(),
						sprintf($this->__('Nonexistent %1$score `stub.php` file: `%2$s`.'), $new_space, $_this_core_stub_file)
					);
				if(!is_readable($_this_core_stub_file) || !is_writable($_this_core_stub_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_stub_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with %1$score `stub.php` file: `%2$s`.'), $new_space, $_this_core_stub_file)
					);

				if(!is_file($_this_core_plugin_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_'.$new_slug.'core_plugin_file', get_defined_vars(),
						sprintf($this->__('Nonexistent %1$score `plugin.php` file: `%2$s`.'), $new_space, $_this_core_plugin_file)
					);
				if(!is_readable($_this_core_plugin_file) || !is_writable($_this_core_plugin_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_plugin_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with %1$score `plugin.php` file: `%2$s`.'), $new_space, $_this_core_plugin_file)
					);

				if(!is_file($_this_core_readme_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_'.$new_slug.'core_readme_file', get_defined_vars(),
						sprintf($this->__('Nonexistent %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
					);
				if(!is_readable($_this_core_readme_file) || !is_writable($_this_core_readme_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_readme_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with %1$score `readme.txt` file: `%2$s`.'), $new_space, $_this_core_readme_file)
					);

				if(!is_file($_this_core_deps_x_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_'.$new_slug.'core_deps_x_file', get_defined_vars(),
						sprintf($this->__('Nonexistent %1$score `deps-x.php` file: `%2$s`.'), $new_space, $_this_core_deps_x_file)
					);
				if(!is_readable($_this_core_deps_x_file) || !is_writable($_this_core_deps_x_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_deps_x_file_permissions', get_defined_vars(),
						sprintf($this->__('Permission issues with %1$score `deps-x.php` file: `%2$s`.'), $new_space, $_this_core_deps_x_file)
					);
				$_this_core_stub_file_contents   = file_get_contents($_this_core_stub_file);
				$_this_core_plugin_file_contents = file_get_contents($_this_core_plugin_file);
				$_this_core_readme_file_contents = file_get_contents($_this_core_readme_file);
				$_this_core_deps_x_file_contents = file_get_contents($_this_core_deps_x_file);

				$_this_core_stub_file_contents = $this->regex_replace('php_code__quoted_string_with_version_marker', $this->version, $_this_core_stub_file_contents);
				$_this_core_stub_file_contents = $this->regex_replace('php_code__quoted_string_with_version_with_underscores_marker', $this->©string->with_underscores($this->version), $_this_core_stub_file_contents);
				$_this_core_stub_file_contents = $this->regex_replace('php_code__quoted_string_with_version_with_dashes_marker', $this->©string->with_dashes($this->version), $_this_core_stub_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__apache_requires_at_least_version', $this->requires_at_least_apache_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__apache_tested_up_to_version', $this->tested_up_to_apache_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__php_requires_at_least_version', $this->requires_at_least_php_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__php_tested_up_to_version', $this->tested_up_to_php_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__wp_requires_at_least_version', $this->requires_at_least_wp_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__wp_tested_up_to_version', $this->tested_up_to_wp_version, $_this_core_readme_file_contents);

				$_this_core_plugin_file_contents = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_this_core_plugin_file_contents);
				$_this_core_readme_file_contents = $this->regex_replace('plugin_readme__wp_version_stable_tag', $this->version, $_this_core_readme_file_contents);

				$_this_core_deps_x_file_contents = $this->regex_replace('php_code__quoted_string_with_apache_version_required_marker', $this->requires_at_least_apache_version, $_this_core_deps_x_file_contents);
				$_this_core_deps_x_file_contents = $this->regex_replace('php_code__quoted_string_with_php_version_required_marker', $this->requires_at_least_php_version, $_this_core_deps_x_file_contents);
				$_this_core_deps_x_file_contents = $this->regex_replace('php_code__quoted_string_with_wp_version_required_marker', $this->requires_at_least_wp_version, $_this_core_deps_x_file_contents);

				if(!file_put_contents($_this_core_stub_file, $_this_core_stub_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_stub_file_write_error', get_defined_vars(),
						sprintf($this->__('Unable to write (update) the %1$score `stub.php` file.'), $new_space)
					);
				if(!file_put_contents($_this_core_plugin_file, $_this_core_plugin_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_plugin_file_write_error', get_defined_vars(),
						sprintf($this->__('Unable to write (update) the %1$score `plugin.php` file.'), $new_space)
					);
				if(!file_put_contents($_this_core_readme_file, $_this_core_readme_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_readme_file_write_error', get_defined_vars(),
						sprintf($this->__('Unable to write (update) the %1$score `readme.txt` file.'), $new_space)
					);
				if(!file_put_contents($_this_core_deps_x_file, $_this_core_deps_x_file_contents))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#'.$new_slug.'core_deps_x_file_write_error', get_defined_vars(),
						sprintf($this->__('Unable to write (update) the %1$score `deps-x.php` file.'), $new_space)
					);
				$successes->add($this->method(__FUNCTION__).'#'.$new_slug.'core_file_updates', get_defined_vars(),
				                sprintf($this->__('%1$s files updated with versions/requirements.'), $ucfirst_core).
				                ' '.sprintf($this->__('%1$s version: `v%2$s`.'), $ucfirst_core, $this->version).
				                ' '.sprintf($this->__('%1$s directory: `%2$s`.'), $ucfirst_core, $_this_core_dir).
				                ' '.sprintf($this->__('%1$s requires at least Apache version: `%2$s`.'), $ucfirst_core, $this->requires_at_least_apache_version).
				                ' '.sprintf($this->__('%1$s tested up to Apache version: `%2$s`.'), $ucfirst_core, $this->tested_up_to_apache_version).
				                ' '.sprintf($this->__('%1$s requires at least PHP version: `%2$s`.'), $ucfirst_core, $this->requires_at_least_php_version).
				                ' '.sprintf($this->__('%1$s tested up to PHP version: `%2$s`.'), $ucfirst_core, $this->tested_up_to_php_version).
				                ' '.sprintf($this->__('%1$s requires at least WordPress® version: `%2$s`.'), $ucfirst_core, $this->requires_at_least_wp_version).
				                ' '.sprintf($this->__('%1$s tested up to WordPress® version: `%2$s`.'), $ucfirst_core, $this->tested_up_to_wp_version)
				);
				unset($_this_core_stub_file, $_this_core_plugin_file, $_this_core_readme_file, $_this_core_deps_x_file);
				unset($_this_core_stub_file_contents, $_this_core_plugin_file_contents, $_this_core_readme_file_contents, $_this_core_deps_x_file_contents);

				// Compress this core directory into a single PHP Archive.

				$_this_core_phar                     = $this->core_repo_dir.'/.~'.$this->instance->core_ns_stub_with_dashes.'.php.phar';
				$_this_core_distro_temp_dir          = $this->©dir->temp().'/'.$this->instance->core_ns_stub_with_dashes;
				$_this_core_distro_temp_dir_stub     = $_this_core_distro_temp_dir.'/stub.php';
				$_this_core_distro_temp_dir_htaccess = $_this_core_distro_temp_dir.'/.htaccess';

				$this->©dir->delete($_this_core_distro_temp_dir); // In case it already exists.
				$this->©dir->copy_to($_this_core_dir, $_this_core_distro_temp_dir, array($this::gitignore => $this->core_repo_dir.'/.gitignore'), TRUE);

				if(!is_file($_this_core_distro_temp_dir_htaccess)
				   || !is_readable($_this_core_distro_temp_dir_htaccess)
				   || strpos(file_get_contents($_this_core_distro_temp_dir_htaccess), 'AcceptPathInfo') === FALSE
				) throw $this->©exception(
					$this->method(__FUNCTION__).'#unable_to_find_valid_htaccess_file_in_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
					sprintf($this->__('Unable to find a valid `.htaccess` file here: `%1$s`.'), $_this_core_distro_temp_dir_htaccess).
					' '.$this->__('This file MUST exist; and it MUST contain: `AcceptPathInfo` for webPhar compatibility.')
				);
				$this->©file->delete($_this_core_phar); // In case it already exists.

				$this->©dir->phar_to($_this_core_distro_temp_dir, $_this_core_phar,
				                     $_this_core_distro_temp_dir_stub, TRUE, TRUE, array_keys($this->©files->compressable_mime_types()),
				                     $this->instance->core_ns_stub_v.$this->©string->with_underscores($this->version));

				$this->©dir->delete($_this_core_distro_temp_dir); // Remove temp directory now.

				$successes->add($this->method(__FUNCTION__).'#'.$new_slug.'core_phar_built_for_'.$new_slug.'core_distro_temp_dir', get_defined_vars(),
				                sprintf($this->__('A temporary distro copy of the %1$s has been compressed into a single PHP Archive file here: `%2$s`.'), $this->instance->core_name, $_this_core_phar).
				                ' '.sprintf($this->__('The temporary distro copy of the %1$s was successfully deleted after processing.'), $this->instance->core_name)
				);
				unset($_this_core_phar, $_this_core_distro_temp_dir, $_this_core_distro_temp_dir_stub, $_this_core_distro_temp_dir_htaccess);

				// Handle deletion and rename/replacement from existing core directory; to new core directory.

				if($is_new) // We MUST do this last to avoid autoload issues.
					// Everything that occurs after this point; MUST use classes already loaded up.
				{ // Be sure all of these classes are loaded up into memory (to avoid autoload issues).
					array($this->©dirs, $this->©commands, $this->©successes, $this->©exception);

					$this->©dir->delete($this->core_dir);
					$this->©command->git('rm -r --cached '.escapeshellarg($this->core_dir.'/'), $this->core_repo_dir);

					$this->©command->git('rm -r --cached '.escapeshellarg($_this_core_dir.'/'), $this->core_repo_dir);
					$this->©dir->rename_to($_this_core_dir, ($_this_core_dir = $this->core_repo_dir.'/'.$this->instance->core_ns_stub_with_dashes));
					$this->©command->git('add --intent-to-add '.escapeshellarg($_this_core_dir.'/'), $this->core_repo_dir);

					$successes->add($this->method(__FUNCTION__).'#after_new_core_dir', get_defined_vars(),
					                sprintf($this->__('The old core directory has been deleted from this new branch: `%1$s`.'), $this->version).
					                ' '.sprintf($this->__('The new temporary core directory was renamed to take its place here: `%1$s`'), $_this_core_dir).
					                ' '.sprintf($this->__('This new core directory has been added to the list of version controlled files in the %1$s repo.'), $this->instance->core_name)
					);
				}
				unset($_this_core_dir); // Final housekeeping.

				// A final commit before we complete the build procedure.

				$this->©command->git('add --all', $this->core_repo_dir);
				$this->©command->git('commit --all --allow-empty --message '. // Final commit (after building).
				                     escapeshellarg(sprintf($this->__('Auto-commit; after %1$s %2$score.'), $building, $new_space)), $this->core_repo_dir);

				if($is_new && $this->©string->is_plugin_stable_version($this->version))
					$this->©command->git('tag --message '. // Tag this commit (after building).
					                     escapeshellarg(sprintf($this->__('%1$s v%2$s.'), $this->instance->core_name, $this->version)).
					                     ' '.escapeshellarg($this->version), $this->core_repo_dir);

				$successes->add($this->method(__FUNCTION__).'#commit_before_'.$new_slug.'core_build_complete', get_defined_vars(),
				                sprintf($this->__('All files (new and/or changed) on %1$sbranch: `%2$s`; have been added to the list of version controlled files in the %3$s repo directory: `%4$s`.'), $new_space, $this->version, $this->instance->core_name, $this->core_repo_dir).
				                ' '.sprintf($this->__('Finale. A commit has been processed for all changes to the %1$sfile structure.'), $new_space).
				                (($is_new && $this->©string->is_plugin_stable_version($this->version)) // A new stable release?
					                ? ' '.sprintf($this->__('Tagged stable release as: `%1$s`.'), $this->version) : '')
				);
				$successes->add($this->method(__FUNCTION__).'#'.$new_slug.'core_build_complete',
				                get_defined_vars(), sprintf($this->__('%1$s %2$s complete!'), $ucfirst_core, $build));
			}
			$successes->add($this->method(__FUNCTION__).'#finish_time', get_defined_vars(),
			                sprintf($this->__('Finish time: %1$s.'), $this->©env->time_details())
			);
			return $successes; // Return all successes now.
		}

		/**
		 * Handles replacements in regex patterns.
		 *
		 * @param string $pattern_name A regex pattern name. See: {@link regex()}
		 *
		 * @param string $value The value to insert when handling replacements in the pattern.
		 *
		 * @param string $string The input string to perform replacements on.
		 *
		 * @return string The `$string` value after replacements.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If there is no matching pattern name for `$pattern_name`.
		 * @throws exception If `$pattern_name` or `$string` are empty. These MUST be NOT-empty strings.
		 * @throws exception If there are NO replacements than can be performed; or the resulting `$string` is empty.
		 */
		public function regex_replace($pattern_name, $value, $string)
		{
			$this->check_arg_types('string:!empty', 'string', 'string:!empty', func_get_args());

			$pattern = $this->regex($pattern_name);
			$_this   = $this; // For callback handlers below (PHP v5.3).

			switch($pattern_name) // Handle this pattern (by name).
			{
				case 'plugin_readme__apache_requires_at_least_version':
				case 'plugin_readme__apache_tested_up_to_version':
				case 'plugin_readme__php_requires_at_least_version':
				case 'plugin_readme__php_tested_up_to_version':
				case 'plugin_readme__wp_requires_at_least_version':
				case 'plugin_readme__wp_tested_up_to_version':
				case 'plugin_readme__wp_version_stable_tag':
					$string = preg_replace_callback($pattern, function ($m) use ($_this, $value)
					{
						return $m['key'].$value; // New value.

					}, $string, -1, $replacements);
					break; // Stop here.

				case 'php_code__deps_x__define_stand_alone_plugin_name':
				case 'php_code__deps_x__define_stand_alone_plugin_dir_names':
					$string = preg_replace_callback($pattern, function ($m) use ($_this, $value)
					{
						return $m['open_define'].
						       $m['open_sq'].$_this->©string->esc_sq($value).$m['close_sq'].
						       $m['close_define_semicolon'].$m['marker']; // New value.

					}, $string, -1, $replacements);
					break; // Stop here.

				case 'php_code__deps_x__declare_stand_alone_class_name':
					$string = preg_replace_callback($pattern, function ($m) use ($_this, $value)
					{
						return $m['class'].$value.$m['marker']; // New suffix.

					}, $string, -1, $replacements);
					break; // Stop here.

				case 'php_code__quoted_string_with_version_marker':
				case 'php_code__quoted_string_with_version_with_underscores_marker':
				case 'php_code__quoted_string_with_version_with_dashes_marker':
				case 'php_code__quoted_string_with_apache_version_required_marker':
				case 'php_code__quoted_string_with_php_version_required_marker':
				case 'php_code__quoted_string_with_wp_version_required_marker':
					$string = preg_replace_callback($pattern, function ($m) use ($_this, $value)
					{
						return $m['open_sq'].$_this->©string->esc_sq($value).$m['close_sq'].
						       $m['possible_semicolon_or_comma'].$m['marker']; // New value.

					}, $string, -1, $replacements);
					break; // Stop here.

				default: // What?
					throw $this->©exception(
						$this->method(__FUNCTION__).'#regex_replacement_failure_unexpected_pattern_name', get_defined_vars(),
						sprintf($this->__('Unexpected regex pattern name: `%1$s`.'), $pattern_name)
					);
			}
			unset($_this); // Just a little housekeeping.

			if(!$string) // Empty string; something awry.
				throw $this->©exception( // Try to be as specific as possible.
					$this->method(__FUNCTION__).'#regex_es_replacement_failure', get_defined_vars(),
					sprintf($this->__('Failure to match the following pattern name: `%1$s`. %2$s'), $pattern_name, $this->©string->preg_last_error())
				);
			if(empty($replacements)) // No replacements.
				throw $this->©exception( // Try to be as specific as possible.
					$this->method(__FUNCTION__).'#regex_nr_replacement_failure', get_defined_vars(),
					sprintf($this->__('Failure to match the following pattern name: `%1$s`. %2$s'), $pattern_name, $this->©string->preg_last_error())
				);
			return $string; // With replacements.
		}

		/**
		 * Returns a frequently used regex pattern (for build routines).
		 *
		 * @param string $matching A regex pattern matching ID.
		 *
		 * @return string A regex pattern.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If there is no matching pattern.
		 */
		public function regex($matching)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$patterns = array(
				'plugin_readme__apache_requires_at_least_version'              => '/^(?P<key>Requires\s+at\s+least\s+Apache\s+version\:\s*)(?P<value>.*)$/im',
				'plugin_readme__apache_tested_up_to_version'                   => '/^(?P<key>Tested\s+up\s+to\s+Apache\s+version\:\s*)(?P<value>.*)$/im',
				'plugin_readme__php_requires_at_least_version'                 => '/^(?P<key>Requires\s+at\s+least\s+PHP\s+version\:\s*)(?P<value>.*)$/im',
				'plugin_readme__php_tested_up_to_version'                      => '/^(?P<key>Tested\s+up\s+to\s+PHP\s+version\:\s*)(?P<value>.*)$/im',
				'plugin_readme__wp_requires_at_least_version'                  => '/^(?P<key>Requires\s+at\s+least(?:\s+(?:WP|WordPress)\s+version)?\:\s*)(?P<value>.*)$/im',
				'plugin_readme__wp_tested_up_to_version'                       => '/^(?P<key>Tested\s+up\s+to(?:\s+(?:WP|WordPress)\s+version)?\:\s*)(?P<value>.*)$/im',
				'plugin_readme__wp_version_stable_tag'                         => '/^(?P<key>(?:Version|Stable\s+tag)\:\s*)(?P<value>.*)$/im',

				'php_code__deps_x__define_stand_alone_plugin_name'             => '/(?P<open_define>define\s*\(\s*\'___STAND_ALONE__PLUGIN_NAME\'\s*,\s*)'.$this->©string->regex_frag_sq_value.'(?P<close_define_semicolon>\s*\)\s*;)(?P<marker>\s*#\!stand\-alone\-plugin\-name\!#)/i',
				'php_code__deps_x__define_stand_alone_plugin_dir_names'        => '/(?P<open_define>define\s*\(\s*\'___STAND_ALONE__PLUGIN_DIR_NAMES\'\s*,\s*)'.$this->©string->regex_frag_sq_value.'(?P<close_define_semicolon>\s*\)\s*;)(?P<marker>\s*#\!stand\-alone\-plugin\-dir\-names\!#)/i',

				'php_code__deps_x__declare_stand_alone_class_name'             => '/(?P<class>class\s+deps_x_'.substr(stub::$regex_valid_core_ns_version, 2, -2).')(?P<marker>\s*#\!stand\-alone\!#)/i',

				'php_code__quoted_string_with_version_marker'                  => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!version\!#)/i',
				'php_code__quoted_string_with_version_with_underscores_marker' => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!version-with-underscores\!#)/i',
				'php_code__quoted_string_with_version_with_dashes_marker'      => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!version-with-dashes\!#)/i',
				'php_code__quoted_string_with_apache_version_required_marker'  => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!apache\-version\-required\!#)/i',
				'php_code__quoted_string_with_php_version_required_marker'     => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!php\-version\-required\!#)/i',
				'php_code__quoted_string_with_wp_version_required_marker'      => '/'.$this->©string->regex_frag_sq_value.'(?P<possible_semicolon_or_comma>\s*[;,]?)(?P<marker>\s*#\!wp\-version\-required\!#)/i'
			);
			if(empty($patterns[$matching]))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unknown_pattern', get_defined_vars(),
					sprintf($this->__('No regex pattern matching: `%1$s`.'), $matching)
				);
			return $patterns[$matching];
		}
	}
}