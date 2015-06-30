<?php
/**
 * XDaRk Core Replicator.
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
	 * XDaRk Core Replicator.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	final class replicator extends framework
	{
		/**
		 * @var successes A successes object instance.
		 */
		public $success; // Defaults to a NULL value.

		/**
		 * @var boolean Defaults to a value of FALSE, for security purposes.
		 */
		public $can_replicate = FALSE;

		/**
		 * @var string Core repo directory.
		 */
		public $core_repo_dir = '';

		/**
		 * @var string Core directory that we're replicating.
		 */
		public $core_dir = '';

		/**
		 * @var string Replicating into this main directory.
		 */
		public $into_dir = '';

		/**
		 * @var string Directory to update files in, after replication is complete.
		 */
		public $update_dir = '';

		/**
		 * @var string Version for replicated core.
		 */
		public $version = '';

		/**
		 * @var array An array of copy-to exclusions during replication.
		 */
		public $exclusions = array();

		/**
		 * @var string New core namespace w/version.
		 */
		public $new_core_ns_version = '';

		/**
		 * @var string New core namespace w/version (dashed variation).
		 */
		public $new_core_ns_version_with_dashes = '';

		/**
		 * @var string Replicating into this new sub-directory of `$into_dir`.
		 */
		public $new_core_dir = '';

		/**
		 * Constructor (initiates replication).
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param string       $into_dir Optional. Defaults to an empty string.
		 *    If this is supplied, the core will be replicated into this specific directory.
		 *    Else, the core will be replicated into a sub-directory of the local core repo directory.
		 *
		 * @param string       $update_dir Optional. Defaults to an empty string.
		 *    Please use with EXTREME caution; this performs a MASSIVE search/replace routine.
		 *    If TRUE, all files inside `$update_dir` will be updated to match the version of the newly replicated core.
		 *    If FALSE, we simply update files in the new core directory; nothing more.
		 *
		 * @param string       $version Optional. Defaults to an empty string.
		 *    By default, the version remains unchanged (e.g. it will NOT be updated by this routine).
		 *    If this is NOT empty, we will replicate the core as a specific version indicated by this value.
		 *
		 * @param array        $exclusions Optional. An array of copy-to exclusions. Defaults to an empty array.
		 *    See: {@link dirs::copy_to()} for details about this parameter.
		 *
		 * @note Instantiation of this class will initiate the replication routine (please be VERY careful).
		 *    Property `$success` will contain a message indicating the final result status of the replication procedure.
		 *    If there is a failure, an exception is thrown by this class. We either succeed completely; or throw an exception.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to replicate according to `$this->can_replicate`.
		 * @throws exception See: `replicate()` method for further details.
		 */
		public function __construct($instance, $into_dir = '', $update_dir = '', $version = '', $exclusions = array())
		{
			parent::__construct($instance);

			$this->check_arg_types('', 'string', 'string', 'string', 'array', func_get_args());

			// Security check. Can we replicate here?

			if($this->©env->is_cli() && $this->©plugin->is_core())
				if((defined('___REPLICATOR') && ___REPLICATOR) || (defined('___BUILDER') && ___BUILDER))
					$this->can_replicate = TRUE; // We CAN replicate.

			if(!$this->can_replicate)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#cannot_replicate', get_defined_vars(),
					$this->__('Security check. Unable to replicate (not allowed here).')
				);
			// Construct object properties.

			$this->core_dir      = $this->instance->core_dir;
			$this->core_repo_dir = $this->instance->local_core_repo_dir;
			$this->into_dir      = ($into_dir) ? $this->©dir->n_seps($into_dir) : $this->instance->local_core_repo_dir;
			$this->version       = ($version) ? $version : $this->instance->core_version;
			$this->exclusions    = ($exclusions) ? $exclusions : array();

			$this->new_core_ns_version             = $this->instance->core_ns_stub_v.$this->©string->with_underscores($this->version);
			$this->new_core_ns_version_with_dashes = $this->©string->with_dashes($this->new_core_ns_version);
			$this->new_core_dir                    = $this->into_dir.'/'.$this->new_core_ns_version_with_dashes;

			$this->update_dir = ($update_dir) ? $this->©dir->n_seps($update_dir) : $this->new_core_dir;

			// Validate object properties (among several other things).

			if(!is_dir($this->into_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_into_dir', get_defined_vars(),
					sprintf($this->__('Invalid directory: `%1$s`.'), $this->into_dir).
					' '.$this->__('This is NOT an existing directory that we can replicate into.')
				);
			if($this->update_dir !== $this->new_core_dir && !is_dir($this->update_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_update_dir', get_defined_vars(),
					sprintf($this->__('Invalid directory: `%1$s`.'), $this->into_dir).
					' '.$this->__('This is NOT an existing directory that we can update files in.')
				);
			if(!$this->©string->is_plugin_version($this->version))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_version', get_defined_vars(),
					sprintf($this->__('Invalid %1$s version: `%2$s`.'), $this->instance->core_name, $this->version)
				);
			// Object construction & initial validation complete.

			$this->success = $this->replicate(); // Process replication routines.
		}

		/**
		 * Handles XDaRk Core framework replication.
		 *
		 * @return successes Returns an instance of successes; else throws an exception on any type of failure.
		 *
		 * @throws exception If the replication directory already exists & removal is NOT possible.
		 * @throws exception If unable to copy the current core directory to it's new replicated location.
		 * @throws exception If unable to update files after replication is complete.
		 * @throws exception If unable to complete replication for any reason.
		 */
		protected function replicate()
		{
			if(is_dir($this->new_core_dir)) // Exists?
			{
				if($this->new_core_dir === $this->core_dir)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#new_core_dir_exists', get_defined_vars(),
						$this->__('The new core directory already exists; and removal is NOT possible.').
						' '.sprintf($this->__('Cannot replicate into self: `%1$s`.'), $this->new_core_dir)
					);
				$this->©dir->delete($this->new_core_dir);
			}
			// Perform replication routines now.

			$this->©dir->copy_to($this->core_dir, $this->new_core_dir, $this->exclusions, TRUE);
			$this->update_files_in_dir($this->update_dir); // A deep search/replace.

			// Return success; which becomes the value of `$this->success`.

			return $this->©success($this->method(__FUNCTION__).'#complete', get_defined_vars(),
			                       $this->__('Replication completed successfully.').
			                       ' '.sprintf($this->__('Replicated into: `%1$s`.'), $this->new_core_dir)
			);
		}

		/**
		 * Updates namespace references in directories/files (e.g. a deep search/replace routine).
		 *
		 * @note Search/replace includes both underscored and dashed variations of the XDaRk Core namespace.
		 *    This search/replace routine will ALSO rename any core namespace directories/files it encounters.
		 *       However, we ONLY deal with the dashed variation of directories/files when renaming.
		 *
		 * @param string      $dir Directory to begin our search in (a deep recursive scan).
		 *
		 * @param null|string $___initial_dir This is for internal use only.
		 *
		 * @note This routine will NOT search/replace directories/files which are ignored by the XDaRk Core.
		 *    See {@link dirs_files::ignore()} for further details on this behavior.
		 *
		 * @note This routine will NOT search/replace inside any past or present core directory.
		 *    With ONE exception, we DO allow search/replace inside the directory containing our newly replicated core.
		 *
		 * @note It is VERY important that `xd_v141226_dev` and/or `xd-v141226-dev`;
		 *    do NOT have any of these characters after them: `[a-z0-9_+\-]`; UNLESS they are part the version string.
		 *    Any of these characters appearing after the stub will be subjected to a search/replace routine.
		 *
		 *    However, THIS is OK because plugin versions CANNOT end with a dash. Ex: `xd_v141226_dev->`.
		 *       See also: {@link stub::$regex_valid_core_ns_version} for further validation details.
		 *
		 * @throws exception If invalid types are passed through arguments list (e.g. if `$dir` is NOT a string; or is empty).
		 * @throws exception If `$dir` (or any sub-directory) is NOT readable, or CANNOT be opened for any reason.
		 * @throws exception If any file is NOT readable/writable, for any reason.
		 * @throws exception If unable to write search/replace changes to a file.
		 * @throws exception If any recursive failure occurs on a sub-directory.
		 * @throws exception If unable to rename directories (when/if needed), for any reason.
		 * @throws exception If unable to rename files (when/if needed), for any reason.
		 * @throws exception If unable to properly search/replace any file, for any reason.
		 * @throws exception If unable to complete the entire search/replace routine for any reason.
		 */
		protected function update_files_in_dir($dir, $___initial_dir = NULL)
		{
			if(!isset($___initial_dir)) // Only for the initial caller.
				$this->check_arg_types('string:!empty', array('null', 'string'), func_get_args());

			// Establish directory variables.

			$dir          = $this->©dir->n_seps($dir);
			$dir_basename = basename($dir);

			if(!isset($___initial_dir)) $___initial_dir = $dir;
			$___initial_dir_dir = $this->©dir->n_seps_up($___initial_dir);

			if(!is_dir($dir)) // Validate (must be a directory).
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_dir', get_defined_vars(),
					sprintf($this->__('Non-existent directory: `%1$s`.'), $dir)
				);
			// Handle automatic directory exclusions.

			if($this->©dir->ignore($dir, $___initial_dir_dir))
				return; // Ignore this directory (it IS excluded).

			if($dir !== $this->core_repo_dir) // Don't bypass the core repo directory itself.
				if(preg_match('/\/'.preg_quote($this->instance->core_ns_stub_with_dashes, '/').'\//', $dir.'/'))
					if(strpos($dir.'/', $this->new_core_dir.'/') !== 0) // Not inside new core directory?
						return; // Past or present XDaRk Core directory.

			if(preg_match('/\/'.substr(stub::$regex_valid_core_ns_version_with_dashes, 2, -2).'\//', $dir.'/'))
				if(strpos($dir.'/', $this->new_core_dir.'/') !== 0) // Not inside new core directory?
					return; // Past or present XDaRk Core directory.

			// Handle core directories that need to be renamed before processing continues.
			if(preg_match(stub::$regex_valid_core_ns_version_with_dashes, $dir_basename) && $dir_basename !== basename($this->new_core_dir))
			{
				$_o_dir       = $dir; // Original directory.
				$dir          = $this->©dir->n_seps_up($dir).'/'.basename($this->new_core_dir);
				$dir_basename = basename($dir); // Change to the new directory.
				if($_o_dir === $___initial_dir) // Update both of these.
				{
					$___initial_dir     = $dir; // Change to the new directory.
					$___initial_dir_dir = $this->©dir->n_seps_up($___initial_dir);
				}
				$this->©dir->rename_to($_o_dir, $dir);
				unset($_o_dir); // Ditch this now.
			}
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unreadable_dir', get_defined_vars(),
					$this->__('Unable to search a directory; not readable due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable please: `%1$s`.'), $dir)
				);
			if(!($_open_dir = opendir($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#opendir_failure', get_defined_vars(),
					$this->__('Unable to search a directory; cannot open for some unknown reason.').
					' '.sprintf($this->__('Make this directory readable please: `%1$s`.'), $dir)
				);
			while(($_dir_file = readdir($_open_dir)) !== FALSE) // Recursive search/replace.
			{
				if($_dir_file === '.' || $_dir_file === '..')
					continue; // Ignore directory dots.

				$_dir_file = $dir.'/'.$_dir_file; // Absolute.

				if(is_dir($_dir_file)) // Sub-directory?
				{
					$this->update_files_in_dir($_dir_file, $___initial_dir);
					continue; // Recursion into sub-directory complete.
				}
				// Establish file variables.

				$_dir_file_basename     = basename($_dir_file);
				$_dir_file_abs_basename = $this->©file->abs_basename($_dir_file);
				$_dir_file_extension    = $this->©file->extension($_dir_file);

				// Handle automatic file name & file extension exclusions.

				if($this->©file->ignore($_dir_file, $___initial_dir_dir))
					continue; // Ignore this file (it IS excluded).

				if($this->©file->has_extension($_dir_file, $this::binary_type))
					continue; // Also ignore all binary extensions.

				// Handle core files that need to be renamed before processing continues.
				if(preg_match(stub::$regex_valid_core_ns_version_with_dashes, $_dir_file_abs_basename))
					if($_dir_file_abs_basename !== basename($this->new_core_dir))
					{
						$_o_dir_file = $_dir_file; // Original file.
						$_dir_file   = $this->©dir->n_seps_up($_dir_file).'/'.basename($this->new_core_dir);
						if(strlen($_dir_file_extension)) // Has an extension?
							$_dir_file .= '.'.$_dir_file_extension;

						$_dir_file_basename     = basename($_dir_file);
						$_dir_file_abs_basename = $this->©file->abs_basename($_dir_file);
						$_dir_file_extension    = $this->©file->extension($_dir_file);

						$this->©file->rename_to($_o_dir_file, $_dir_file);
						unset($_o_dir_file); // Ditch this now.
					}
				// Make sure this file is readable/writable.

				if(!is_readable($_dir_file) || !is_writable($_dir_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#read_write_file_issue', get_defined_vars(),
						$this->__('Unable to search a file; cannot read/write due to permission issues.').
						' '.sprintf($this->__('Make this file readable/writable please: `%1$s`.'), $_dir_file)
					);
				// Get the contents of this file (and check if empty).

				if(!is_string($_file = file_get_contents($_dir_file)))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#read_file_contents_issue', get_defined_vars(),
						$this->__('Unable to search a file; cannot read file contents for some unknown reason.').
						' '.sprintf($this->__('Make this file readable/writable please: `%1$s`.'), $_dir_file)
					);
				if(!$_file) continue; // The file is empty. We're done here.

				// Handle file search/replace routines (as quickly as possible).

				$_file_contains_core_ns_version             = (preg_match('/'.substr(stub::$regex_valid_core_ns_version, 2, -2).'/', $_file));
				$_file_contains_core_ns_version_with_dashes = (preg_match('/'.substr(stub::$regex_valid_core_ns_version_with_dashes, 2, -2).'/', $_file));
				if(!$_file_contains_core_ns_version && !$_file_contains_core_ns_version_with_dashes)
					continue; // Does NOT contain anything we need to search/replace.

				if($_file_contains_core_ns_version) // Contains normal underscore variation(s)?
				{
					$_file = preg_replace('/'.substr(stub::$regex_valid_core_ns_version, 2, -2).'/', $this->©string->esc_refs($this->new_core_ns_version), $_file);

					if(!$_file || strpos($_file, $this->new_core_ns_version) === FALSE)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#search_replace_failure', get_defined_vars(),
							sprintf($this->__('Unable to properly search/replace file: `%1$s`.'), $_dir_file).
							sprintf($this->__('Last PCRE regex error: `%1$s`.'), $this->©string->preg_last_error())
						);
				}
				if($_file_contains_core_ns_version_with_dashes) // Contains dashed variation(s)?
				{
					$_file = preg_replace('/'.substr(stub::$regex_valid_core_ns_version_with_dashes, 2, -2).'/', $this->©string->esc_refs($this->new_core_ns_version_with_dashes), $_file);

					if(!$_file || strpos($_file, $this->new_core_ns_version_with_dashes) === FALSE)
						throw $this->©exception(
							$this->method(__FUNCTION__).'#search_replace_failure', get_defined_vars(),
							sprintf($this->__('Unable to properly search/replace file: `%1$s`.'), $_dir_file).
							sprintf($this->__('Last PCRE regex error: `%1$s`.'), $this->©string->preg_last_error())
						);
				}
				if(!file_put_contents($_dir_file, $_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
						$this->__('Unable to properly search/replace file due to permission issues.').
						' '.sprintf($this->__('Make this file readable/writable please: `%1$s`.'), $_dir_file)
					);
			}
			closedir($_open_dir); // Close directory; final housekeeping.
			unset($_open_dir, $_dir_file, $_dir_file_basename, $_dir_file_abs_basename, $_dir_file_extension);
			unset($_file, $_file_contains_core_ns_version, $_file_contains_core_ns_version_with_dashes);
		}
	}
}