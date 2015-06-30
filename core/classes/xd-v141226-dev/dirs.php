<?php
/**
 * Directory Utilities.
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
	 * Directory Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class dirs extends dirs_files
	{
		/**
		 * Gets a readable/writable temporary directory.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::get_temp_dir()
		 * @inheritdoc \xd_v141226_dev::get_temp_dir()
		 */
		public function temp() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'get_temp_dir'), func_get_args());
		}

		/**
		 * Glob directories.
		 *
		 * @note This will NOT glob files; only directories.
		 *    However, this MAY glob directories containing files of course.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see dirs_files::glob()
		 * @inheritdoc dirs_files::glob()
		 */
		public function glob($dir, $pattern, $case_insensitive = FALSE, $x_flags = NULL, $flags = NULL, $type = self::dir_type)
		{
			return parent::glob($dir, $pattern, $case_insensitive, $x_flags, $flags, $this::dir_type);
		}

		/**
		 * Strips a trailing `/app_data/` sub-directory.
		 *
		 * @param string $dir Directory path.
		 *
		 * @return string Directory path without `/app_data/`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function rtrim_app_data($dir)
		{
			$this->check_arg_types('string', func_get_args());

			return preg_replace('/\/app_data$/', '', $this->n_seps($dir));
		}

		/**
		 * Basename (including a possible `/app_data/` sub-directory).
		 *
		 * @param string $dir Directory path.
		 *
		 * @return string Basename (including a possible `/app_data/` sub-directory).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function app_data_basename($dir)
		{
			$this->check_arg_types('string', func_get_args());

			$dir = preg_replace('/\/app_data$/', '', $this->n_seps($dir), 1, $app_data);

			return basename($dir).(($app_data) ? '/app_data' : '');
		}

		/**
		 * Creates a directory Junction in Windows®.
		 *
		 * @param string $jctn Directory location of the Junction (i.e. the symlink).
		 *
		 * @param string $target Target directory that this Junction will connect to.
		 *
		 * @return string Location of the Junction; else an empty string on failure.
		 *    If the Junction already exists as a link (and it already points to the `$target`);
		 *    we simply return `$jctn` without any change (e.g. there is nothing more to do in that scenario).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$jctn` exists already and it's an existing directory or file (i.e. NOT a link).
		 * @throws exception If `$jctn` exists and it's NOT writable (or we are unable to remove it before recreating).
		 * @throws exception If `$target` does NOT exist; or if it does exist, but it's NOT a directory.
		 * @throws exception If the Junction needs to be created; but Windows® commands are NOT possible.
		 * @throws exception If creation of a Directory Junction fails for any reason.
		 */
		public function create_win_jctn($jctn, $target)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			$jctn   = $this->n_seps($jctn);
			$target = $this->n_seps($target);

			$is_jctn_dir   = is_dir($jctn);
			$is_target_dir = is_dir($target);
			$is_jctn_link  = $this->is_link($jctn);

			$realpath_jctn   = ($is_jctn_dir) ? $this->n_seps((string)realpath($jctn)) : '';
			$realpath_target = ($is_target_dir) ? $this->n_seps((string)realpath($target)) : '';

			if($is_jctn_dir && $is_target_dir && $is_jctn_link && $realpath_jctn && $realpath_target && $realpath_jctn === $realpath_target)
				return $jctn; // It already exists; and it's already pointing to the proper location.

			if(!$is_target_dir)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#target_not_dir', get_defined_vars(),
					$this->__('Unable to create a Windows® Directory Junction. Invalid target.').
					' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $jctn, $target)
				);
			else if(!$this->©commands->windows_possible())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_possible', get_defined_vars(),
					$this->__('Not possible to create a Windows® Directory Junction.').
					' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $jctn, $target)
				);
			else if(!$this->delete_win_jctn($jctn))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#jctn_exists', get_defined_vars(),
					$this->__('Unable to create a Windows® Directory Junction. Already exists.').
					' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $jctn, $target)
				);
			$mklink_args = $this->©commands->mklink.' /J '.escapeshellarg($jctn).' '.escapeshellarg($target);
			$mklink      = $this->©commands->exec($mklink_args, '', TRUE);

			$mklink_status = $mklink['status'];
			$mklink_errors = $mklink['errors'];
			/** @var errors $mklink_errors */

			if($mklink_status !== 0 || $mklink_errors->exist())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#issue', get_defined_vars(),
					$this->__('Failed to create a Windows® Directory Junction.').
					' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $jctn, $target).
					' '.sprintf($this->__('The command: `%1$s`, returned a non-zero status or error; `mklink` said: `%2$s`'),
					            $mklink_args, $mklink_errors->get_message())
				);
			clearstatcache(); // Clear cache.

			if(!is_dir($jctn)) // Now we test this again.
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					$this->__('Failed to create a Windows® Directory Junction.').
					' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $jctn, $target)
				);
			return $jctn; // It's a good day in Eureka!
		}

		/**
		 * Deletes a Windows® Directory Junction.
		 *
		 * @param string $jctn Directory location of the Junction (i.e. the symlink).
		 *
		 * @return boolean TRUE if Directory Junction is NOT a directory or file; or if it was deleted successfully.
		 *    Else this will throw an exception. We either return TRUE; or we throw an exception.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$jctn` exists already and it's an actual directory/file (i.e. NOT a link).
		 * @throws exception If `$jctn` exists and it's NOT writable (or we are unable to remove it).
		 * @throws exception If deletion of a Directory Junction fails for any reason.
		 */
		public function delete_win_jctn($jctn)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$jctn         = $this->n_seps($jctn);
			$is_jctn_link = $this->is_link($jctn);
			$is_jctn_file = is_file($jctn);
			$is_jctn_dir  = is_dir($jctn);

			if(!$is_jctn_link && !$is_jctn_file && !$is_jctn_dir)
				return TRUE; // It's already gone :-)

			if($is_jctn_file)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#file', get_defined_vars(),
					$this->__('Unable to delete a Windows® Directory Junction.').
					' '.sprintf($this->__('This is NOT a Directory Junction (it\'s a file): `%1$s`.'), $jctn)
				);
			else if(!$is_jctn_dir)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_dir', get_defined_vars(),
					$this->__('Unable to delete a Windows® Directory Junction.').
					' '.sprintf($this->__('This is NOT a Directory Junction: `%1$s`.'), $jctn)
				);
			else if(!$is_jctn_link)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_link', get_defined_vars(),
					$this->__('Unable to delete a Windows® Directory Junction.').
					' '.sprintf($this->__('This is NOT a Directory Junction: `%1$s`.'), $jctn)
				);

			if(!is_writable($jctn))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#permissions', get_defined_vars(),
					$this->__('Unable to delete a Windows® Directory Junction.').
					' '.sprintf($this->__('This Directory Junction is NOT writable: `%1$s`.'), $jctn)
				);

			if(!$this->©commands->windows_possible())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_possible', get_defined_vars(),
					$this->__('Not possible to delete a Windows® Directory Junction.').
					' '.sprintf($this->__('Please delete this Directory Junction: `%1$s`.'), $jctn)
				);
			$rmdir_args = $this->©commands->rmdir.' '.escapeshellarg(str_replace('/', '\\', $jctn));
			$rmdir      = $this->©commands->exec($rmdir_args, '', TRUE);

			$rmdir_status = $rmdir['status'];
			$rmdir_errors = $rmdir['errors'];
			/** @var errors $rmdir_errors */

			if($rmdir_status !== 0 || $rmdir_errors->exist())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#issue', get_defined_vars(),
					sprintf($this->__('The command: `%1$s`, returned a non-zero status or error. Rmdir said: `%2$s`'),
					        $rmdir_args, $rmdir_errors->get_message())
				);
			clearstatcache(); // Clear cache.

			return TRUE; // Default return value.
		}

		/**
		 * Calculates the MD5 checksum for an entire directory recursively.
		 *
		 * @param string      $dir The directory we should begin with.
		 *
		 * @param boolean     $update_checksum_file Defaults to a FALSE value.
		 *    If this is TRUE, the `checksum.txt` file in the root directory will be updated accordingly.
		 *    If the `checksum.txt` file does NOT exist yet, this routine will attempt to create it.
		 *
		 * @param boolean     $ignore_readme_files Optional. Defaults to a TRUE value.
		 *    By default, we ignore README files (e.g. `readme.txt` and `readme.md`).
		 *
		 *    NOTE: No matter what this is set to, we always exclude our default globs.
		 *       See: {@link dir_files::ignore()} for further details on this.
		 *
		 * @param null|string $___root_dir Do NOT pass this. For internal use only.
		 *
		 * @return string An MD5 checksum established collectively, based on all directories/files.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir` is empty; is NOT a directory; or is not readable.
		 * @throws exception If `$update_checksum_file` is TRUE, and permission issues (of any kind)
		 *    prevent the update and/or creation of the `checksum.txt` file.
		 *
		 * @see deps_x_xd_v141226_dev::dir_checksum()
		 */
		public function checksum($dir, $update_checksum_file = FALSE, $ignore_readme_files = TRUE, $___root_dir = NULL)
		{
			if(!isset($___root_dir)) // Only for the initial caller.
				$this->check_arg_types('string:!empty', 'boolean', 'boolean', array('null', 'string'), func_get_args());

			$checksums   = array(); // Initialize array.
			$dir         = $this->n_seps((string)realpath($dir));
			$___root_dir = !isset($___root_dir) ? $dir : $___root_dir;

			if(!$dir || !is_dir($dir) || !is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#cannot_read_dir', NULL,
					sprintf($this->__('Unable to read directory: `%1$s`'), $dir)
				);
			if($dir !== $___root_dir && $this->ignore($dir, $___root_dir))
				return ''; // Ignoring this directory.

			if(!($handle = opendir($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#cannot_read_dir', NULL,
					sprintf($this->__('Unable to open directory: `%1$s`'), $dir)
				);
			// Mark each directory in case it happens to be empty. We count empty directories too.
			$relative_dir             = preg_replace('/^'.preg_quote($___root_dir, '/').'(?:\/|$)/', '', $dir);
			$checksums[$relative_dir] = md5($relative_dir); // Relative directory checksum.

			// Scan each directory and include each file that it contains; except files we ignore.
			while(($entry = readdir($handle)) !== FALSE) if($entry !== '.' && $entry !== '..') // Ignore dots.
				if($entry !== 'checksum.txt' || $dir !== $___root_dir) // Skip `checksum.txt` in the root directory.
					if(!$ignore_readme_files || !in_array(strtolower($entry), array('readme.txt', 'readme.md'), TRUE))
					{
						if(is_dir($dir.'/'.$entry)) // Recursively scan each sub-directory.
							$checksums[$relative_dir.'/'.$entry] = $this->checksum($dir.'/'.$entry, FALSE, $ignore_readme_files, $___root_dir);

						else if(!$this->ignore($dir.'/'.$entry, $___root_dir)) // If NOT ignoring this file.
							$checksums[$relative_dir.'/'.$entry] = md5($relative_dir.'/'.$entry.md5_file($dir.'/'.$entry));
					}
			closedir($handle); // Close directory handle now.

			ksort($checksums, SORT_STRING); // In case order changes from one server to another.

			$checksum = md5(implode('', $checksums)); // Collective checksum.

			if($update_checksum_file && $dir === $___root_dir)
			{
				if(!is_file($dir.'/checksum.txt') && !is_writable($dir))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#permission_issue', get_defined_vars(),
						sprintf($this->__('Need this directory to be writable: `%1$s`'), $dir)
					);
				if(is_file($dir.'/checksum.txt') && !is_writable($dir.'/checksum.txt'))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#permission_issue', get_defined_vars(),
						sprintf($this->__('Need this file to be writable: `%1$s`'), $dir.'/checksum.txt')
					);
				file_put_contents($dir.'/checksum.txt', $checksum);
			}
			return $checksum; // Collective checksum.
		}

		/**
		 * Get cache directory (public or private).
		 *
		 * @return string See {@link data_sub()}
		 *
		 * @inheritdoc {@link data_sub()}
		 * @see data_sub()
		 */
		public function cache($sub_dir = '', $type = self::private_type)
		{
			return $this->data_sub('cache/'.$sub_dir, $type);
		}

		/**
		 * Empties and deletes a cache directory (public or private).
		 *
		 * @return boolean See {@link delete_data_sub()}
		 *
		 * @inheritdoc {@link delete_data_sub()}
		 * @see delete_data_sub()
		 */
		public function delete_cache($sub_dir = '', $type = self::private_type)
		{
			return $this->delete_data_sub('cache/'.$sub_dir, $type);
		}

		/**
		 * Get logs directory (public or private).
		 *
		 * @return string See {@link data_sub()}
		 *
		 * @inheritdoc {@link data_sub()}
		 * @see data_sub()
		 */
		public function logs($sub_dir = '', $type = self::private_type)
		{
			return $this->data_sub('logs/'.$sub_dir, $type);
		}

		/**
		 * Empties and deletes a logs directory (public or private).
		 *
		 * @return boolean See {@link delete_data_sub()}
		 *
		 * @inheritdoc {@link delete_data_sub()}
		 * @see delete_data_sub()
		 */
		public function delete_logs($sub_dir = '', $type = self::private_type)
		{
			return $this->delete_data_sub('logs/'.$sub_dir, $type);
		}

		/**
		 * Get packages directory (public or private).
		 *
		 * @return string See {@link data_sub()}
		 *
		 * @inheritdoc {@link data_sub()}
		 * @see data_sub()
		 */
		public function packages($sub_dir = '', $type = self::public_type)
		{
			return $this->data_sub('packages/'.$sub_dir, $type);
		}

		/**
		 * Empties and deletes a packages directory (public or private).
		 *
		 * @return boolean See {@link delete_data_sub()}
		 *
		 * @inheritdoc {@link delete_data_sub()}
		 * @see delete_data_sub()
		 */
		public function delete_packages($sub_dir = '', $type = self::public_type)
		{
			return $this->delete_data_sub('packages/'.$sub_dir, $type);
		}

		/**
		 * Gets/creates a data sub-directory (public or private).
		 *
		 * @param string $sub_dir A data sub-directory name; or nested; e.g. `stuff` or `my/stuff`.
		 *
		 * @param string $type The type of data sub-directory (public or private). Defaults to {@link fw_constants::private_type}.
		 *    This MUST be passed using class constants {@link fw_constants::public_type} or {@link fw_constants::private_type}.
		 *
		 * @return string Full path to a readable/writable data sub-directory, else an exception is thrown on failure.
		 *    If the directory does NOT yet exist, it's created by this routine.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$sub_dir` is empty; or is a relative path (this is a NO-no, for security).
		 * @throws exception If an invalid `$type` is passed in. Use class constants please.
		 * @throws exception If the requested data sub-directory is NOT readable/writable, or CANNOT be created for any reason.
		 */
		public function data_sub($sub_dir, $type = self::private_type)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			// Creates the required `$sub_dir` appendage.

			if(!($sub_dir = $this->©string->trim($this->n_seps($sub_dir), '', '/')))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#empty', get_defined_vars(),
					$this->__('Expecting a data sub-directory that is more than just slashes.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $sub_dir)
				);
			if(strpos($sub_dir, '..') !== FALSE) // No relative paths.
				throw $this->©exception(
					$this->method(__FUNCTION__).'#relative_paths', get_defined_vars(),
					$this->__('Expecting a data sub-directory with NO relative paths.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $sub_dir)
				);
			// Check data sub-directory type.

			if(!in_array($type, array($this::public_type, $this::private_type), TRUE))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_type', get_defined_vars(),
					$this->__('Invalid data sub-directory type. Expecting class contant for public or private type.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $type)
				);
			// Clean these up and piece them together.

			$data_sub_dir      = $this->n_seps($this->instance->plugin_data_dir.'/'.$sub_dir);
			$app_data_sub_dir  = ($type === $this::private_type && $this->©env->is_windows() && !$this->©env->is_apache()) ? '/app_data' : '';
			$data_sub_dir_type = $this->n_seps($data_sub_dir.'/'.(($type === $this::private_type) ? 'private' : 'public').$app_data_sub_dir);

			// Need to create the `$data_sub_dir_type`?

			if(!is_dir($data_sub_dir_type))
			{
				mkdir($data_sub_dir_type, 0755, TRUE);
				clearstatcache(); // Clear cache before checking again.

				if(!is_dir($data_sub_dir_type) || !is_readable($data_sub_dir_type) || !is_writable($data_sub_dir_type))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
						$this->__('Unable to create a readable/writable data sub-directory.').
						' '.sprintf($this->__('Need this directory to be readable/writable please: `%1$s`.'), $data_sub_dir_type)
					);
				if($type === $this::private_type && !is_file($data_sub_dir.'/private/.htaccess'))
					file_put_contents($data_sub_dir.'/private/.htaccess', $this->htaccess_deny);

				return $data_sub_dir_type; // Created successfully!
			}
			// Else it exists. Is `$data_sub_dir_type` still readable/writable?

			else if(!is_readable($data_sub_dir_type) || !is_writable($data_sub_dir_type))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to find a readable/writable data sub-directory.').
					' '.sprintf($this->__('Need this directory to be readable/writable please: `%1$s`.'), $data_sub_dir_type)
				);
			return $data_sub_dir_type; // Everything still OK. It's a good day in Eureka!

		}

		/**
		 * Empties and deletes a data sub-directory (public or private).
		 *
		 * @param string $sub_dir A data sub-directory name; or nested; e.g. `stuff` or `my/stuff`.
		 *
		 * @param string $type The type of data sub-directory (public or private). Defaults to {@link fw_constants::private_type}.
		 *    This MUST be passed using class constants {@link fw_constants::public_type} or {@link fw_constants::private_type}.
		 *
		 * @return boolean TRUE if the directory was successfully removed.
		 *    Also returns TRUE if the directory is already non-existent (i.e. nothing to remove).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$sub_dir` is empty; or is a relative path (this is a NO-no, for security).
		 * @throws exception If an invalid `$type` is passed in. Use class constants please.
		 *
		 * @throws exception See: {@link data_sub()} for additional exceptions this may throw.
		 * @throws exception See: {@link delete()} for additional exceptions this may throw.
		 */
		public function delete_data_sub($sub_dir, $type = self::private_type)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			return $this->delete($this->data_sub($sub_dir, $type));
		}

		/**
		 * Recursively empties/deletes a directory.
		 *
		 * @param string      $dir A full directory path to delete.
		 *
		 * @param null|string $___initial_dir Do NOT pass this. Internal use only.
		 *
		 * @return boolean TRUE if the directory was successfully deleted, else an exception is thrown.
		 *    Also returns TRUE if `$dir` is already non-existent (i.e. nothing to delete).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir` is NOT a string; or it's an empty string.
		 * @throws exception If the `$dir` given, is NOT readable/writable, or CANNOT be opened for any reason.
		 * @throws exception If any sub-directory or file within `$dir` is NOT readable/writable, or CANNOT be opened for any reason.
		 * @throws exception If any failure occurs during processing (e.g. we only return TRUE on success).
		 */
		public function delete($dir, $___initial_dir = NULL)
		{
			if(!isset($___initial_dir)) // Only for the initial caller.
				$this->check_arg_types('string:!empty', array('null', 'string'), func_get_args());

			$dir = $this->n_seps($dir);
			if(!isset($___initial_dir)) $___initial_dir = $dir;

			if(!file_exists($dir))
				return TRUE;

			if(!is_dir($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_a_directory', get_defined_vars(),
					$this->__('Unable to remove a directory; argument value is NOT a directory path.').
					' '.sprintf($this->__('The invalid directory path given: `%1$s`.'), $dir)
				);
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to remove a directory; not readable, due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable/writable please: `%1$s`.'), $dir)
				);
			if(!is_writable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to remove a directory; not writable, due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable/writable please: `%1$s`.'), $dir)
				);
			if(!($_open_dir = opendir($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to remove a directory; cannot open, for some unknown reason.').
					' '.sprintf($this->__('Make this directory readable/writable please: `%1$s`.'), $dir)
				);
			while(($_dir_file = readdir($_open_dir)) !== FALSE) // Recursively delete all sub-directories/files.
			{
				if($_dir_file !== '.' && $_dir_file !== '..') // Ignore directory dots.
				{
					$_dir_file = $dir.'/'.$_dir_file; // We need the full path now.

					if(is_dir($_dir_file)) // Sub-directory.
						$this->delete($_dir_file, $___initial_dir);

					else $this->©file->delete($_dir_file);
				}
			}
			closedir($_open_dir); // Close resource handle now.
			unset($_open_dir, $_dir_file); // Unset (unlocks directory).

			$rmdir = rmdir($dir); // We should be able to delete the directory now.
			clearstatcache(); // This makes other routines aware. Very important to clear the cache.

			if(!$rmdir) throw $this->©exception(
				$this->method(__FUNCTION__).'#possible_read_write_or_existing_resource_handle_issues', get_defined_vars(),
				sprintf($this->__('Unable to remove this directory: `%1$s`.'), $dir)
			);
			return TRUE; // It's a good day in Eureka!
		}

		/**
		 * Empties/deletes directories deeply.
		 *
		 * @note This will NOT delete file entries found in the array; we only delete directories.
		 *    However, this MAY delete directories containing files; depending on what the array contains.
		 *
		 * @return integer {@inheritdoc}
		 *
		 * @see dirs_files::delete_deep()
		 * @inheritdoc dirs_files::delete_deep()
		 */
		public function delete_deep($value, $min_mtime = -1, $min_atime = -1, $type = self::dir_type, $___recursion = FALSE)
		{
			return parent::delete_deep($value, $min_mtime, $min_atime, $this::dir_type, $___recursion);
		}

		/**
		 * Recursively copies a directory via PHP.
		 *
		 * @param string       $dir A full directory path to copy.
		 *
		 * @param string       $to A new directory path, to copy `$dir` to.
		 *    This new directory must NOT already exist. If it does, an exception is thrown.
		 *
		 * @param array        $exclusions Optional. Defaults to an empty array.
		 *
		 *    • A list of files/directories to ignore (using `FNMATCH` wildcard patterns).
		 *       The `FNM_PATHNAME` flag (by default) is NOT in use for any wildcard patterns you specify here.
		 *       A wildcard `*` WILL match directory separators (by default). See: `$exclusion_x_flags` for further details.
		 *       The `FNM_CASEFOLD` flag is also off (by default). Enable w/ `$exclusions_case_insensitive` or `$exclusion_x_flags`.
		 *
		 *    • Special case handler ({@link fw_constants::ignore_globs}) for ignoring shell glob patterns (i.e. directory/file masks).
		 *       If `$exclusions[fw_constants::ignore_globs]` is an array/string; we will ignore the given shell glob patterns.
		 *       This triggers an underlying call to {@link dirs_files::ignore()} for each absolute directory/file path.
		 *       Calls to {@link dirs_files::ignore()} start `from` the parent of your initial `$dir`.
		 *
		 *       If you specify an empty array/string (or {@link fw_constants::defaults}),
		 *          you are using the default XDaRk Core glob exclusion patterns.
		 *
		 *       The `FNM_PATHNAME` flag (by default) is NOT in use for any shell glob patterns you specify here.
		 *       A wildcard `*` WILL match directory separators (by default). See: `$exclusion_x_flags` for further details.
		 *       However, it's IMPORTANT to note that shell glob patterns are tested against each component of the absolute directory/file path.
		 *       Therefore, while `FNM_PATHNAME` is off (by default); turning it on does NOT accomplish much for shell glob patterns.
		 *
		 *       The `FNM_CASEFOLD` flag is also off (by default). Enable w/ `$exclusions_case_insensitive` or `$exclusion_x_flags`.
		 *
		 *    • Special case handler ({@link fw_constants::ignore_extra_globs}) for ignoring extra shell glob patterns (i.e. directory/file masks).
		 *       If `$exclusions[fw_constants::ignore_extra_globs]` is an array/string; we will attempt to ignore extra shell glob patterns.
		 *       This triggers an underlying call to {@link dirs_files::ignore()} for each absolute directory/file path.
		 *       Calls to {@link dirs_files::ignore()} start `from` the parent of your initial `$dir`.
		 *
		 *       If you specify ONLY {@link fw_constants::ignore_extra_globs}; the default XDaRk Core glob exclusion patterns are in use.
		 *       Extra glob patterns are handy in cases where you simply want to use the XDaRk Core default glob patterns; but
		 *          you would like to add some additional glob patterns of your own (e.g. these are extra glob patterns).
		 *
		 *       The `FNM_PATHNAME` flag (by default) is NOT in use for any shell glob patterns you specify here.
		 *       A wildcard `*` WILL match directory separators (by default). See: `$exclusion_x_flags` for further details.
		 *       However, it's IMPORTANT to note that shell glob patterns are tested against each component of the absolute directory/file path.
		 *       Therefore, while `FNM_PATHNAME` is off (by default); turning it on does NOT accomplish much for shell glob patterns.
		 *
		 *       The `FNM_CASEFOLD` flag is also off (by default). Enable w/ `$exclusions_case_insensitive` or `$exclusion_x_flags`.
		 *
		 *    • Special case handler ({@link fw_constants::gitignore}) for `.gitignore` functionality when copying directories/files in Git repos.
		 *       If `basename($exclusions[fw_constants::gitignore])` === `.gitignore`; we will attempt to process Git via command line.
		 *       We use: `git ls-files --others --directory` to compile a complete list of exclusions automatically.
		 *       This way the copied directory will reflect only the files under Git version control.
		 *       Your `.gitignore` file MUST exist in the parent of your initial `$dir`.
		 *
		 *       The `FNM_CASEFOLD` flag is off (by default). Enable w/ `$exclusions_case_insensitive` or `$exclusion_x_flags`.
		 *       There is only ONE additional exclusion flag (`FNM_CASEFOLD`) that works together w/ {@link fw_constants::gitignore}.
		 *       Attempting to use additional exclusions flags w/ {@link fw_constants::gitignore} will result in an exception.
		 *
		 *    • Regarding wildcard pattern matching (`FNMATCH` exclusions array and/or {@link fw_constants::gitignore} functionality).
		 *       Note: these rules do NOT apply to shell glob exclusion patterns; which are handled by {@link dirs_files::ignore()}.
		 *
		 *       • Files/directories will always include a leading slash `/` when checking exclusions.
		 *          We use an absolute relative path; starting with the initial `$dir` that you're copying from.
		 *          In other words, relative from the parent directory of your initial `$dir`.
		 *
		 *          Assuming your initial value for `$dir` is `/path/to/dir`.
		 *          And, assuming this file exists that you want to exclude: `/path/to/dir/sub-dir/file.php`.
		 *          You will need a pattern that matches this path: `/dir/sub-dir/file.php`.
		 *
		 *       • Directories will include a trailing slash when checking exclusions.
		 *
		 *          Assuming your initial value for `$dir` is `/path/to/dir`.
		 *          And, assuming this directory exists that you want to exclude: `/path/to/dir/sub-dir`.
		 *          You will need a pattern that matches this path: `/dir/sub-dir/`.
		 *
		 *       • File/directory paths obtained through `git ls-files --others --directory` are converted into `FNMATCH` wildcard patterns
		 *          automatically by this routine. A `.gitignore` file MUST exist in the parent of your initial `$dir`.
		 *
		 * @param boolean      $exclusions_case_insensitive Defaults to a FALSE value.
		 *    If TRUE, wildcard pattern matching is NOT case sensitive.
		 *    The `FNM_CASEFOLD` flag is enabled if this is TRUE.
		 *
		 * @param null|integer $exclusion_x_flags Optional. Defaults to a NULL value.
		 *    Any additional flags supported by PHP's `fnmatch()` function are acceptable here.
		 *
		 * @param null|array   $___ignore Do NOT pass this. It's for internal use only.
		 *
		 * @param null|string  $___initial_dir This if for internal use only.
		 *
		 * @return boolean TRUE if the directory was successfully copied, else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the `$dir` given, is NOT a readable directory, or CANNOT be opened for any reason.
		 * @throws exception If any sub-directory or file within `$dir` is NOT readable, or CANNOT be opened for any reason.
		 * @throws exception If the `$to` directory already exists, or CANNOT be created by this routine for any reason.
		 *
		 * @throws exception If a `.gitignore` file is used for `$exclusions`; but the `.gitignore` file does NOT exist.
		 * @throws exception If a `.gitignore` file is used for `$exclusions`; but it's NOT in the initial parent `$dir`.
		 * @throws exception If a `.gitignore` file is used for `$exclusions`; but the `git` command is currently NOT possible.
		 * @throws exception If a `.gitignore` file is used for `$exclusions`; but `git` returns a non-zero status.
		 * @throws exception If a `.gitignore` file is used for `$exclusions`; together w/ additional exclusion flags.
		 *    The only additional exclusion flag supported together with `.gitignore` is the `FNM_CASEFOLD` flag.
		 * @throws exception If a copy failure of any kind occurs (e.g. we are NOT successful for any reason).
		 *
		 * @see dirs_files::ignore()
		 * @see strings::in_wildcard_patterns()
		 *
		 * @WARNING This routine can become resource intensive on large directories.
		 *    See: {@link env::maximize_time_memory_limits()}
		 */
		public function copy_to($dir, $to, $exclusions = array(), $exclusions_case_insensitive = FALSE, $exclusion_x_flags = NULL, $___ignore = NULL, $___initial_dir = NULL)
		{
			if(!isset($___initial_dir)) // Only for the initial caller.
				$this->check_arg_types('string:!empty', 'string:!empty', 'array', 'boolean', array('null', 'integer'), array('null', 'array'), array('null', 'string'), func_get_args());

			$dir    = $this->n_seps($dir);
			$to     = $this->n_seps($to);
			$to_dir = $this->n_seps_up($to);

			if(!isset($___initial_dir)) $___initial_dir = $dir;
			$___initial_dir_dir = $this->n_seps_up($___initial_dir);
			if(!isset($___ignore)) $___ignore = array();

			if(!is_dir($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to copy a directory (source `dir` missing).').
					sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to copy a directory; not readable due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable please: `%1$s`.'), $dir)
				);
			if(!($_open_dir = opendir($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to copy a directory; cannot open for some unknown reason.').
					' '.sprintf($this->__('Make this directory readable please: `%1$s`.'), $dir)
				);

			if(file_exists($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#destination_to_exists', get_defined_vars(),
					$this->__('Unable to copy a directory; destination already exists.').
					' '.sprintf($this->__('Please delete this file or directory: `%1$s`.'), $to)
				);
			if(!is_writable($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to copy a directory; destination not writable due to permission issues.').
					' '.sprintf($this->__('Need this directory to be writable please: `%1$s`.'), $to_dir)
				);
			mkdir($to, 0755, TRUE); // Create the destination directory (with recursion).
			clearstatcache(); // Clear cache before re-testing; (also makes other routines aware it exists).

			if(!is_dir($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#mkdir_to_failure', get_defined_vars(),
					$this->__('Unable to copy a directory; destination creation failure.').
					' '.sprintf($this->__('Please create this directory: `%1$s`.'), $to)
				);

			if($dir === $___initial_dir // Only do this ONE time.
			   && isset($exclusions[$this::ignore_globs]) // Ignoring glob patterns?
			   && (is_array($exclusions[$this::ignore_globs]) || is_string($exclusions[$this::ignore_globs]))
			) // This special array element triggers glob ignore/exclusion patterns.
			{
				$___ignore['globs'] = $exclusions[$this::ignore_globs];
				unset($exclusions[$this::ignore_globs]);
			}
			if($dir === $___initial_dir // Only do this ONE time.
			   && isset($exclusions[$this::ignore_extra_globs]) // Ignoring extra glob patterns?
			   && (is_array($exclusions[$this::ignore_extra_globs]) || is_string($exclusions[$this::ignore_extra_globs]))
			) // This special array element triggers extra glob ignore/exclusion patterns.
			{
				$___ignore['extra_globs'] = $exclusions[$this::ignore_extra_globs];
				unset($exclusions[$this::ignore_extra_globs]);
			}
			if($dir === $___initial_dir // Only do this ONE time.
			   && isset($exclusions[$this::gitignore]) && $this->©string->is_not_empty($exclusions[$this::gitignore])
			   && basename($exclusions[$this::gitignore]) === '.gitignore' // MUST have a `.gitignore` basename.
			) // This special array element is a `.gitignore` file; triggering automatic `.gitignore` exclusions.
			{
				$_gitignore_file = $this->n_seps($exclusions[$this::gitignore]);
				$_gitignore_dir  = $this->n_seps_up($_gitignore_file);
				unset($exclusions[$this::gitignore]);

				if(!is_file($_gitignore_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#nonexistent_gitignore_file', get_defined_vars(),
						sprintf($this->__('Nonexistent `.gitignore` file: `%1$s`.'), $_gitignore_file)
					);
				if($_gitignore_dir !== $___initial_dir_dir)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_gitignore_file', get_defined_vars(),
						sprintf($this->__('Invalid `.gitignore` file: `%1$s`.'), $_gitignore_file).
						sprintf($this->__('Your `.gitignore` file MUST exist here: `%1$s`.'), $___initial_dir_dir.'/.gitignore')
					);
				if(!$this->©command->git_possible())
					throw $this->©exception(
						$this->method(__FUNCTION__).'#git_command_not_possible', get_defined_vars(),
						sprintf($this->__('You specified the following `.gitignore` file: `%1$s`.'), $_gitignore_file).
						' '.$this->__('However, the `git` command is NOT possible in the current environment.')
					);
				if(isset($exclusion_x_flags) && $exclusion_x_flags !== FNM_CASEFOLD)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#gitignore_not_compatible_w/exclusion_x_flags', get_defined_vars(),
						sprintf($this->__('You specified the following `.gitignore` file: `%1$s`.'), $_gitignore_file).
						' '.$this->__('You\'re attempting to mix `.gitignore` functionality w/ additional exclusion flags; which is NOT compatible.'),
						' '.$this->__('The only additional exclusion flag supported together with `.gitignore` is the `FNM_CASEFOLD` flag.')
					);
				$_gitignore_files = $this->©command->git('ls-files --others --directory', $_gitignore_dir);

				if($_gitignore_files) // Do we have output (e.g. a list of ignored files)?
				{
					foreach(preg_split('/['."\r\n".']+/', $_gitignore_files, NULL, PREG_SPLIT_NO_EMPTY) as $_path)
						// No need to normalize directory separators here; Git already does that for us.
						// Directories returned by Git always include a trailing slash (so they're easy to identify).
						// Git does NOT include leading slashes though (we add those to achieve absolute relative paths).
						$exclusions[] = (substr($_path, -1) === '/') ? '/'.$_path.'*' : '/'.$_path;
				}
				unset($_gitignore_file, $_gitignore_dir, $_gitignore_files, $_path);
			}
			while(($_dir_file = readdir($_open_dir)) !== FALSE) // Recursively copy all sub-directories/files.
			{
				if($_dir_file !== '.' && $_dir_file !== '..') // Ignore directory dots.
				{
					$_dir_file        = $dir.'/'.$_dir_file;
					$_dir_file_is_dir = is_dir($_dir_file);
					$_dir_file_arp    = preg_replace('/^'.preg_quote($___initial_dir_dir, '/').'\//', '/', $_dir_file);
					$_dir_file_arp .= ($_dir_file_is_dir) ? '/' : ''; // Trailing dir separator on actual directories.
					$_dir_file_to = $to.'/'.basename($_dir_file); // New copy location.

					if((!isset($___ignore['globs']) && !isset($___ignore['extra_globs'])) || !$this->©dirs_files->ignore($_dir_file, $___initial_dir_dir, $this->©var->isset_or($___ignore['globs'], array()), $this->©var->isset_or($___ignore['extra_globs'], array()), $exclusions_case_insensitive, $exclusion_x_flags))
						if(!$exclusions || !$this->©string->in_wildcard_patterns($_dir_file_arp, $exclusions, $exclusions_case_insensitive, FALSE, $exclusion_x_flags))
						{ // Only if this directory/file has NOT been excluded via the `$exclusions` array.

							if($_dir_file_is_dir) // Recursive sub-directories.
								$this->copy_to($_dir_file, $_dir_file_to, $exclusions, $exclusions_case_insensitive, $exclusion_x_flags, $___ignore, $___initial_dir);
							else $this->©file->copy_to($_dir_file, $_dir_file_to);
						}
				}
			}
			closedir($_open_dir); // Close directory resource handle.
			unset($_open_dir, $_dir_file, $_dir_file_is_dir, $_dir_file_arp, $_dir_file_to);

			clearstatcache(); // This makes other routines aware. Very important to clear the cache.

			return TRUE; // It's a good day in Eureka!
		}

		/**
		 * Creates a PHAR (PHP Archive) file from an entire directory.
		 *
		 * @param string       $dir The directory we want to create a PHAR file for.
		 *
		 * @param string       $to The new PHAR file location; with a `.phar` extension.
		 *
		 * @param string       $stub_file Stub file path. The contents of this stub file will be used as
		 *    the stub for the resulting PHAR file. Required for all PHARs created by this routine.
		 *    A final call to `__HALT_COMPILER();` is automatically appended by this routine.
		 *
		 * @param boolean      $strip_ws Optional. Defaults to a TRUE value (highly recommended).
		 *    If this is TRUE; any PHP files in the archive will be further reduced in filesize by this routine.
		 *    This is made possible by the `php_strip_whitespace()` function.
		 *
		 * @param boolean      $compress Optional. Defaults to a TRUE value (highly recommended).
		 *    If this is TRUE; any compressable files in the archive will be further reduced in filesize.
		 *
		 * @param string|array $compressable_extensions Optional. An array of GZIP-compressable extensions.
		 *    This will default to only those which are 100% webPhar-compatible: `array('php', 'phps')`.
		 *    Or, you can provide your own array of compressable extensions.
		 *
		 * @param string       $is_phar_var_suffix Optional. Defaults to `stub`.
		 *    A global variable at the top of your PHAR stub file will be declared as follows.
		 *    `$GLOBALS['is_phar_'.$is_phar_var_suffix] = 'phar://'.__FILE__;` (just a helpful identifier).
		 *
		 * @return string The new PHAR file path; else an exception is thrown on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir` is empty, does NOT exist; or is NOT readable for any reason.
		 * @throws exception If `$to` is empty, or is NOT specified with a `.phar` extension.
		 * @throws exception If `$to` parent directory does NOT exist; or is not writable.
		 * @throws exception If `$stub_file` is empty, does NOT exist; or is NOT readable for any reason.
		 * @throws exception If `$compressable_extensions` or `$is_phar_var_suffix` is empty.
		 * @throws \exception If any Phar class failures occur. The Phar class may throw exceptions.
		 * @throws exception On any type of failure (e.g. NOT successful).
		 *
		 * @WARNING This routine can become resource intensive on large directories.
		 *    Mostly because of the compression routines applied here intuitively. It takes some time.
		 *    See: {@link env::maximize_time_memory_limits()}
		 */
		public function phar_to($dir, $to, $stub_file, $strip_ws = TRUE, $compress = TRUE, $compressable_extensions = array('php', 'phps'), $is_phar_var_suffix = 'stub')
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'string:!empty', 'boolean', 'boolean', 'array:!empty', 'string:!empty', func_get_args());

			$dir    = $this->n_seps($dir);
			$to     = $this->n_seps($to);
			$to_dir = $this->n_seps_up($to);

			if(!is_dir($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to PHAR a directory (source `dir` missing).').
					sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to PHAR a directory; not readable, due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable please: `%1$s`.'), $dir)
				);

			if(file_exists($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#existing_phar', get_defined_vars(),
					$this->__('Unable to PHAR a directory; destination PHAR file already exists.').
					' '.sprintf($this->__('Please delete this file first: `%1$s`.'), $to)
				);
			if($this->extension($to) !== 'phar')
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_phar_file', get_defined_vars(),
					$this->__('Unable to PHAR a directory; invalid destination PHAR file.').
					' '.sprintf($this->__('Please use a `.phar` extension instead of: `%1$s`.'), $to)
				);
			if(!is_dir($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#phar_to_dir_missing', get_defined_vars(),
					$this->__('Destination PHAR directory does NOT exist yet.').
					' '.sprintf($this->__('Please check this directory: `%1$s`.'), $to_dir)
				);
			if(!is_writable($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to PHAR a directory; destination not writable due to permission issues.').
					' '.sprintf($this->__('Need this directory to be writable please: `%1$s`.'), $to_dir)
				);
			if(!\Phar::canWrite())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to PHAR a directory; PHP configuration does NOT allow write access.').
					' '.$this->__('Need this INI setting please: `phar.readonly = 0`.')
				);

			if(!is_file($stub_file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_stub_file', get_defined_vars(),
					$this->__('Unable to PHAR a directory; missing stub file.').
					' '.sprintf($this->__('File does NOT exist: `%1$s`.'), $stub_file)
				);
			if(!is_readable($stub_file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#stub_file_issues', get_defined_vars(),
					$this->__('Unable to PHAR a directory; permission issues with stub file.').
					' '.sprintf($this->__('Need this file to be writable please: `%1$s`.'), $stub_file)
				);
			// Phar class throws exceptions on failure.

			$_stub_file_is_phar_var = '$GLOBALS[\'is_phar_'.$this->©string->esc_sq($is_phar_var_suffix).'\'] = \'phar://\'.__FILE__;';
			$_stub_file_contents    = ($strip_ws) ? $this->©php->strip_whitespace($stub_file) : file_get_contents($stub_file);
			$_stub_file_contents    = trim(preg_replace('/\W\?\>\s*$/', '', $_stub_file_contents, 1)); // No close tag & trim.
			$_stub_file_contents    = preg_replace('/\<\?php|\<\?/i', '<?php '.$_stub_file_is_phar_var, $_stub_file_contents, 1);
			$_stub_file_contents    = preg_replace('/\W__HALT_COMPILER\s*\(\s*\)\s*;/i', '', $_stub_file_contents, 1).' __HALT_COMPILER();';

			$_phar = new \Phar($to, $this->iteration_flags());
			$_phar->startBuffering(); // Don't create file yet (wait until we're done here).
			$_phar->setStub($_stub_file_contents); // Defines the stub for this PHAR file.

			if(!$strip_ws && !$compress) $_phar->buildFromDirectory($dir); // Simple.

			else // Stripping/compressing takes work, but worth the effort :-)
			{
				$_strippable_extensions         = array('php');
				$_regex_compressable_extensions = $this->©string->preg_quote_deep($compressable_extensions, '/');
				$_regex_compressable_extensions = '/\.(?:'.implode('|', $_regex_compressable_extensions).')$/i';
				$_temp_dir                      = $this->temp().'/'.$this->©string->unique_id().'-'.basename($dir);

				$this->copy_to($dir, $_temp_dir);
				$_temp_dir_iteration = $this->iteration($_temp_dir);

				if($strip_ws) foreach($_temp_dir_iteration as $_dir_file)
				{
					if(!$_dir_file->isFile()) continue;

					$_path      = $_dir_file->getPathname();
					$_phar_path = $_dir_file->getSubPathName();
					$_extension = $this->©file->extension($_path);

					if(in_array($_extension, $_strippable_extensions, TRUE))
						file_put_contents($_path, $this->©php->strip_whitespace($_path, TRUE));
				}
				$_phar->buildFromDirectory($_temp_dir, $_regex_compressable_extensions);
				if($compress && $_phar->count()) // Compressing files?
					$_phar->compressFiles(\Phar::GZ);

				foreach($_temp_dir_iteration as $_dir_file) // Everything else.
				{
					if(!$_dir_file->isFile()) continue;

					$_path      = $_dir_file->getPathname();
					$_phar_path = $_dir_file->getSubPathName();
					$_extension = $this->©file->extension($_path);

					if(!in_array($_extension, $compressable_extensions, TRUE))
						$_phar->addFile($_path, $_phar_path);
				}
			}
			$_phar->stopBuffering(); // Write to disk now.

			unset($_phar, $_stub_file_is_phar_var, $_stub_file_contents, $_strippable_extensions, $_regex_compressable_extensions);
			unset($_temp_dir_iteration, $_dir_file, $_path, $_phar_path, $_extension);
			if(isset($_temp_dir)) // A little more housekeeping now.
				$this->delete($_temp_dir);
			unset($_temp_dir);

			return $to; // It's a good day in Eureka!
		}

		/**
		 * Recursively ZIPs a directory via PHP.
		 *
		 * @param string $dir A full directory path to ZIP.
		 *
		 * @param string $to A new ZIP file path — to ZIP `$dir` into.
		 *    The directory this lives in MUST already exist and be writable.
		 *    If this file already exists, an exception will be thrown.
		 *
		 * @return string New ZIP file location; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the `$dir` is NOT a readable directory, or CANNOT be zipped for any reason.
		 * @throws exception If the `$to` ZIP already exists, or CANNOT be created by this routine for any reason.
		 * @throws exception If the `$to` ZIP does NOT end with the proper `.zip` extension.
		 * @throws exception If the `$to` ZIP parent directory does NOT exist or is not writable.
		 * @throws \exception The PclZip class may throw exceptions of it's own here.
		 */
		public function zip_to($dir, $to)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			$dir    = $this->n_seps($dir);
			$to     = $this->n_seps($to);
			$to_dir = $this->n_seps_up($to);

			if(!class_exists('\\PclZip'))
				require_once ABSPATH.'wp-admin/includes/class-pclzip.php';

			if(!is_dir($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to ZIP a directory (source `dir` missing).').
					' '.sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to ZIP a directory; not readable; due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable please: `%1$s`.'), $dir)
				);

			if(file_exists($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#existing_zip', get_defined_vars(),
					$this->__('Destination ZIP exists; it MUST first be deleted please.').
					' '.sprintf($this->__('Please check this ZIP archive: `%1$s`.'), $to)
				);
			if($this->extension($to) !== 'zip')
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_zip', get_defined_vars(),
					$this->__('Invalid ZIP extension. The destination must end with `.zip`.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $to)
				);
			if(!is_dir($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#zip_to_dir_missing', get_defined_vars(),
					$this->__('Destination ZIP directory does NOT exist yet.').
					' '.sprintf($this->__('Please check this directory: `%1$s`.'), $to_dir)
				);
			if(!is_writable($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#zip_to_dir_permissions', get_defined_vars(),
					$this->__('Destination ZIP directory is not writable.').
					' '.sprintf($this->__('Please check permissions on this directory: `%1$s`.'), $to_dir)
				);

			$archive = new \PclZip($to);
			if(!$archive->create($dir, PCLZIP_OPT_REMOVE_PATH, $this->n_seps_up($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#pclzip_archive_failure#'.$archive->errorCode(), get_defined_vars(),
					sprintf($this->__('PclZip archive failure: `%1$s`.'), $archive->errorInfo(TRUE))
				);
			return $to; // It's a good day in Eureka!
		}

		/**
		 * Rename a directory.
		 *
		 * @param string $dir A full directory path.
		 * @param string $to A new full directory path.
		 *
		 * @return string Path to new directory location; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the `$dir` does NOT exist; or is NOT a readable/writable directory.
		 * @throws exception If the `$to` directory already exists (either as a file or directory).
		 * @throws exception If the `$to` parent directory does NOT exist or is NOT writable.
		 * @throws exception If the underlying call to PHP's `rename()` function fails for any reason.
		 */
		public function rename_to($dir, $to)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			$dir    = $this->n_seps($dir);
			$to     = $this->n_seps($to);
			$to_dir = $this->n_seps_up($to);

			if(!is_dir($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to rename a directory (source `dir` missing).').
					' '.sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			if(!is_readable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to rename a directory; not readable; due to permission issues.').
					' '.sprintf($this->__('Need this directory to be readable please: `%1$s`.'), $dir)
				);
			if(!is_writable($dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Unable to rename a directory; not writable; due to permission issues.').
					' '.sprintf($this->__('Need this directory to be writable please: `%1$s`.'), $dir)
				);

			if(file_exists($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#destination_exists', get_defined_vars(),
					$this->__('Destination exists; it MUST first be deleted please.').
					' '.sprintf($this->__('Please check this file or directory: `%1$s`.'), $to)
				);
			if(!is_dir($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#destination_dir_missing', get_defined_vars(),
					$this->__('Destination\'s parent directory does NOT exist yet.').
					' '.sprintf($this->__('Please check this directory: `%1$s`.'), $to_dir)
				);
			if(!is_writable($to_dir))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#destination_dir_permissions', get_defined_vars(),
					$this->__('Destination\'s directory is not writable.').
					' '.sprintf($this->__('Please check permissions on this directory: `%1$s`.'), $to_dir)
				);

			if(!rename($dir, $to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#rename_failure', get_defined_vars(),
					sprintf($this->__('Rename failure. Could NOT rename: `%1$s`; to: `%2$s`.'), $dir, $to)
				);
			return $to; // It's a good day in Eureka!
		}

		/**
		 * Checks the current plugin's data directory.
		 *
		 * @return boolean TRUE if the current plugin's data directory exists, and is readable/writable; else FALSE.
		 *    If the directory does NOT exist, this routine will attempt to create it before checking.
		 */
		public function data_readable_writable()
		{
			$data_dir = $this->instance->plugin_data_dir;

			if(!is_dir($data_dir)) // Create if not exists.
			{
				@mkdir($data_dir, 0755, TRUE); // Including parents.
				clearstatcache(); // Clear stat cache for checks below.
			}
			if(is_dir($data_dir) && is_readable($data_dir) && is_writable($data_dir))
				return TRUE; // Yes, we have a good data directory now.

			return FALSE; // Default return value.
		}

		/**
		 * Gets all possible template directories (ordered by precedence).
		 *
		 * @return array All possible template directories (ordered by precedence).
		 */
		public function where_templates_may_reside()
		{
			$dirs = array(
				$this->n_seps(get_stylesheet_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes,
				$this->n_seps(get_template_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes,

				$this->instance->plugin_pro_dir.'/templates/'.$this->instance->plugin_root_ns_stub_with_dashes,
				$this->instance->plugin_dir.'/templates/'.$this->instance->plugin_root_ns_stub_with_dashes,

				$this->instance->plugin_pro_dir.'/templates/', // Extends core; NOT intended for further customization.
				$this->instance->plugin_dir.'/templates/', // Extends core; NOT intended for further customization.

				$this->instance->core_dir.'/templates/', // Default core template files.
			);
			return $this->apply_filters(__FUNCTION__, $dirs);
		}

		/**
		 * A recursive directory iterator.
		 *
		 * @param string       $dir An absolute directory path.
		 *
		 * @param null|integer $x_flags The defaults are recommended; but extra flags can be passed in.
		 *
		 * @param null|integer $flags The defaults are recommended; but specific flags can be passed in if you prefer.
		 *    The difference between `$x_flags` and `$flags`; is that `$flags` will override all defaults;
		 *    whereas `$x_flags` will simply add additional flags to the existing defaults.
		 *
		 * @return \RecursiveIteratorIterator|\RecursiveDirectoryIterator[]|\SplFileInfo[]
		 *    Navigable with {@link \foreach()}; where each item is a {@link \RecursiveDirectoryIterator} instance.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir` is NOT a directory.
		 */
		public function iteration($dir, $x_flags = NULL, $flags = NULL)
		{
			$this->check_arg_types('string:!empty', array('null', 'integer'), array('null', 'integer'), func_get_args());

			if(!is_dir($dir = $this->n_seps($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to iterate a directory (source `dir` missing).').
					' '.sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			$flags = $this->iteration_flags($x_flags, $flags);

			$recursive_dir_iterator      = new \RecursiveDirectoryIterator($dir, $flags);
			$recursive_iterator_iterator = new \RecursiveIteratorIterator($recursive_dir_iterator, \RecursiveIteratorIterator::CHILD_FIRST);

			return $recursive_iterator_iterator;
		}

		/**
		 * Recursive directory iterator based on a regex pattern.
		 *
		 * @param string       $dir An absolute directory path.
		 *
		 * @param string       $regex A regex pattern; compares to each full file path.
		 *
		 * @param null|integer $x_flags The defaults are recommended; but extra flags can be passed in.
		 *
		 * @param null|integer $flags The defaults are recommended; but specific flags can be passed in if you prefer.
		 *    The difference between `$x_flags` and `$flags`; is that `$flags` will override all defaults;
		 *    whereas `$x_flags` will simply add additional flags to the existing defaults.
		 *
		 * @return \RegexIterator|\RecursiveIteratorIterator|\RecursiveDirectoryIterator[]|\SplFileInfo[]
		 *    Navigable with {@link \foreach()}; where each item is a {@link \RecursiveDirectoryIterator} instance.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir` is NOT a directory.
		 */
		public function regex_iteration($dir, $regex, $x_flags = NULL, $flags = NULL)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', array('null', 'integer'), array('null', 'integer'), func_get_args());

			if(!is_dir($dir = $this->n_seps($dir)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#source_dir_missing', get_defined_vars(),
					$this->__('Unable to iterate a directory (source `dir` missing).').
					' '.sprintf($this->__('Non-existent source directory: `%1$s`.'), $dir)
				);
			$flags = $this->iteration_flags($x_flags, $flags);

			$recursive_dir_iterator      = new \RecursiveDirectoryIterator($dir, $flags);
			$recursive_iterator_iterator = new \RecursiveIteratorIterator($recursive_dir_iterator, \RecursiveIteratorIterator::CHILD_FIRST);
			$regex_iterator              = new \RegexIterator($recursive_iterator_iterator, $regex, \RegexIterator::MATCH, \RegexIterator::USE_KEY);

			return $regex_iterator;
		}

		/**
		 * Default directory iteration flags.
		 *
		 * @param null|integer $x_flags The defaults are recommended; but extra flags can be passed in.
		 *
		 * @param null|integer $flags The defaults are recommended; but specific flags can be passed in if you prefer.
		 *    The difference between `$x_flags` and `$flags`; is that `$flags` will override all defaults;
		 *    whereas `$x_flags` will simply add additional flags to the existing defaults.
		 *
		 * @return integer Flags for `\RecursiveDirectoryIterator`.
		 */
		public function iteration_flags($x_flags = NULL, $flags = NULL)
		{
			$this->check_arg_types(array('null', 'integer'), array('null', 'integer'), func_get_args());

			if(!isset($flags)) // Defaults.
				$flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_SELF |
				         \FilesystemIterator::FOLLOW_SYMLINKS | \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS;
			if(isset($x_flags)) $flags = $flags | $x_flags;

			return $flags;
		}

        /**
         * Returns possible views location
         * @return mixed
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO ${VERSION}
         */
        public function where_views_may_reside(){

            $dirs = array(
                $this->n_seps(get_stylesheet_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view',
                $this->n_seps(get_template_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view',

                $this->instance->plugin_pro_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes,
                $this->instance->plugin_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes,

                $this->instance->plugin_pro_dir.'/view', // Extends core; NOT intended for further customization.
                $this->instance->plugin_dir.'/view', // Extends core; NOT intended for further customization.

	            $this->instance->core_dir.'/view/', // Default core template files.
            );

            return $this->apply_filters(__FUNCTION__, $dirs);
        }

        /**
         * Returns possible view styles locations
         * @return mixed
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO ${VERSION}
         */
        public function where_view_styles_may_reside(){

            $dirs = array(
                $this->n_seps(get_stylesheet_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view/styles',
                $this->n_seps(get_template_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view/styles',

                $this->instance->plugin_pro_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes . '/styles',
                $this->instance->plugin_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes . '/styles',

                $this->instance->plugin_pro_dir.'/view/styles', // Extends core; NOT intended for further customization.
                $this->instance->plugin_dir.'/view/styles', // Extends core; NOT intended for further customization.

	            $this->instance->core_dir.'/view/styles', // Default core template files.
            );

            return $this->apply_filters(__FUNCTION__, $dirs);
        }

        /**
         * Returns possible view scripts locations
         * @return mixed
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO ${VERSION}
         */
        public function where_view_scripts_may_reside(){

            $dirs = array(
                $this->n_seps(get_stylesheet_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view/scripts',
                $this->n_seps(get_template_directory()).'/'.$this->instance->plugin_root_ns_stub_with_dashes . '/view/scripts',

                $this->instance->plugin_pro_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes . '/scripts',
                $this->instance->plugin_dir.'/view/'.$this->instance->plugin_root_ns_stub_with_dashes . '/scripts',

                $this->instance->plugin_pro_dir.'/view/scripts', // Extends core; NOT intended for further customization.
                $this->instance->plugin_dir.'/view/scripts', // Extends core; NOT intended for further customization.
            );

            return $this->apply_filters(__FUNCTION__, $dirs);
        }

		/**
		 * Adds data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully installed.
		 *
		 * @notice Enqueues notice if we do NOT have a readable/writable data directory.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___activate___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation)
				return FALSE; // Added security.

			if($this->data_readable_writable())
				return TRUE; // That's it! We're good here.

			$this->©notice->enqueue( // Ask for manual creation.
				'<p>'.
				sprintf(
					$this->__('Please create this directory: <code>%1$s</code>.'),
					$this->©dirs->doc_root_path($this->instance->plugin_data_dir)
				).
				' '.$this->__('You\'ll need to log in via FTP and set directory permissions to <code>755</code> (or higher).').
				' '.$this->__('Please use an application like <a href="http://filezilla-project.org/" target="_blank">FileZilla</a>.').
				' '.$this->__('If you\'re unfamiliar with FTP, please watch <a href="http://www.youtube.com/watch?v=oq0oM2w9lcQ" target="_blank">this video tutorial</a>.').
				'</p>'
			);
			return FALSE; // Default return value.
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

			$this->delete($this->instance->plugin_data_dir);

			return TRUE;
		}

		/**
		 * Apache `.htaccess` rules that deny public access to the contents of a directory.
		 *
		 * @var string `.htaccess` rules.
		 */
		public $htaccess_deny = "<IfModule authz_core_module>\n\tRequire all denied\n</IfModule>\n<IfModule !authz_core_module>\n\tdeny from all\n</IfModule>";

	}
}