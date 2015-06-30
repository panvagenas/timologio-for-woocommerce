<?php
/**
 * File Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120329
 */
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * File Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120329
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class files extends dirs_files
	{
		/**
		 * Attempts to get `/wp-load.php`.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::wp_load()
		 * @inheritdoc \xd_v141226_dev::wp_load()
		 */
		public function wp_load() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'wp_load'), func_get_args());
		}

		/**
		 * Gets a file MIME type.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::mime_type()
		 * @inheritdoc \xd_v141226_dev::mime_type()
		 */
		public function mime_type() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'mime_type'), func_get_args());
		}

		/**
		 * A map of MIME types.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::mime_types()
		 * @inheritdoc \xd_v141226_dev::mime_types()
		 */
		public function mime_types() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'mime_types'), func_get_args());
		}

		/**
		 * A map of textual MIME types.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::textual_mime_types()
		 * @inheritdoc \xd_v141226_dev::textual_mime_types()
		 */
		public function textual_mime_types() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'textual_mime_types'), func_get_args());
		}

		/**
		 * A map of compressable MIME types.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::compressable_mime_types()
		 * @inheritdoc \xd_v141226_dev::compressable_mime_types()
		 */
		public function compressable_mime_types() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'compressable_mime_types'), func_get_args());
		}

		/**
		 * A map of binary MIME types.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::binary_mime_types()
		 * @inheritdoc \xd_v141226_dev::binary_mime_types()
		 */
		public function binary_mime_types() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'binary_mime_types'), func_get_args());
		}

		/**
		 * A map of cacheable MIME types.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::cacheable_mime_types()
		 * @inheritdoc \xd_v141226_dev::cacheable_mime_types()
		 */
		public function cacheable_mime_types() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'cacheable_mime_types'), func_get_args());
		}

		/**
		 * Glob files.
		 *
		 * @note This will NOT glob directories; only files.
		 *    However, this MAY glob files in directories, depending on the pattern of course.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see dirs_files::glob()
		 * @inheritdoc dirs_files::glob()
		 */
		public function glob($dir, $pattern, $case_insensitive = FALSE, $x_flags = NULL, $flags = NULL, $type = self::file_type)
		{
			return parent::glob($dir, $pattern, $case_insensitive, $x_flags, $flags, $this::file_type);
		}

		/**
		 * Gets a new writable temporary file path.
		 *
		 * @param string $prefix Optional. This defaults to an empty string.
		 *    This is passed to the underlying call to PHP's `uniqid()` function.
		 *
		 * @param string $extension Optional. This defaults to `tmp`.
		 *
		 * @return string A new writable temporary file path.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$extension` is empty.
		 */
		public function temp($prefix = '', $extension = 'tmp')
		{
			$this->check_arg_types('string', 'string:!empty', func_get_args());

			return $this->©dir->temp().'/'.$this->©string->unique_id($prefix).'.'.$extension;
		}

		/**
		 * An array of known file extensions.
		 *
		 * @param string $type Optional. Defaults to {@link fw_constants::any_type}.
		 *
		 * @return array An array of file extensions; of a specific `$type`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$type` is empty or unknown (e.g. invalid).
		 */
		public function extensions($type = self::any_type)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			switch($type) // Let's figure out which type.
			{
				case $this::textual_type:
					return array_keys($this->textual_mime_types());

				case $this::compressable_type:
					return array_keys($this->compressable_mime_types());

				case $this::cacheable_type:
					return array_keys($this->cacheable_mime_types());

				case $this::binary_type:
					return array_keys($this->binary_mime_types());

				case $this::any_known_type:
				case $this::any_type: // The same.
					return array_keys($this->mime_types());

				default: // Throw exception (invalid type).
					throw $this->©exception(
						$this->method(__FUNCTION__).'#unknown_type', get_defined_vars(),
						sprintf($this->__('Unknown extension type: `%1$s`.'), $type)
					);
			}
		}

		/**
		 * Abbreviated byte notation for a particular file.
		 *
		 * @param string $file Absolute path to an existing file.
		 *
		 * @return string If file exists, an abbreviated byte notation; else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file` is NOT a string; or is an empty string.
		 * @throws exception If `$file` is NOT actually a file.
		 * @throws exception If `$file` is NOT readable.
		 */
		public function size_abbr($file)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!is_file($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_file', get_defined_vars(),
					sprintf($this->__('Nonexistent file: `%1$s`.'), $file)
				);
			if(!is_readable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_issues', get_defined_vars(),
					$this->__('Expecting a readable file (permission issues).').
					' '.sprintf($this->__('Got: `%1$s`.'), $file)
				);
			return $this->bytes_abbr((float)filesize($file));
		}

		/**
		 * Abbreviated byte notation for file sizes.
		 *
		 * @param float   $bytes File size in bytes. A (float) value.
		 *    We need this converted to a (float), so it's possible to deal with numbers beyond that of an integer.
		 *
		 * @param integer $precision Number of decimals to use.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @return string Byte notation.
		 */
		public function bytes_abbr($bytes, $precision = 2)
		{
			$this->check_arg_types('float', 'integer', func_get_args());

			$precision = ($precision >= 0) ? $precision : 2;
			$units     = array('bytes', 'kbs', 'MB', 'GB', 'TB');

			$bytes = ($bytes > 0) ? $bytes : 0;
			$power = floor(($bytes ? log($bytes) : 0) / log(1024));

			$abbr_bytes = round($bytes / pow(1024, $power), $precision);
			$abbr       = $units[min($power, count($units) - 1)];

			if($abbr_bytes === (float)1 && $abbr === 'bytes')
				$abbr = 'byte'; // Quick fix here.

			else if($abbr_bytes === (float)1 && $abbr === 'kbs')
				$abbr = 'kb'; // Quick fix here.

			return $abbr_bytes.' '.$abbr;
		}

		/**
		 * Converts an abbreviated byte notation into bytes.
		 *
		 * @param string $string A string value in byte notation.
		 *
		 * @return float A float indicating the number of bytes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @see \deps_x_xd_v141226_dev::abbr_bytes()
		 */
		public function abbr_bytes($string)
		{
			$this->check_arg_types('string', func_get_args());

			$notation = '/^(?P<value>[0-9\.]+)\s*(?P<modifier>bytes|byte|kbs|kb|k|mb|m|gb|g|tb|t)$/i';

			if(!preg_match($notation, $string, $_op))
				return (float)0;

			$value    = (float)$_op['value'];
			$modifier = strtolower($_op['modifier']);
			unset($_op); // Housekeeping.

			switch($modifier) // Fall through based on modifier.
			{
				case 't': // Multiplied four times.
				case 'tb':
					$value *= 1024;
				case 'g': // Multiplied three times.
				case 'gb':
					$value *= 1024;
				case 'm': // Multiple two times.
				case 'mb':
					$value *= 1024;
				case 'k': // One time only.
				case 'kb':
				case 'kbs':
					$value *= 1024;
			}
			return (float)$value;
		}

		/**
		 * Archive/rename file; if existing size is too large.
		 *
		 * @param string  $file An absolute file path (which may NOT exist yet).
		 *    However, if the file DOES exist; it MUST be readable/writable.
		 *
		 * @param integer $max_size Optional. This defaults to a value of `2097152` (2MB).
		 *    This is the size at which files will be archived; if they exceed this max size.
		 *
		 * @return string A reverberation of `$file` (which may no longer exist after we're done here).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file` exists, but it's NOT readable/writable.
		 * @throws exception If the containing dir is NOT readable/writable.
		 * @throws exception If a PHP `rename()` fails.
		 */
		public function maybe_archive($file, $max_size = 2097152)
		{
			$this->check_arg_types('string:!empty', 'integer:!empty', func_get_args());

			if(!is_file($file)) return $file;

			if(!is_readable($file) || !is_writable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					$this->__('Expecting a readable/writable file (permission issues).').
					' '.sprintf($this->__('Got: `%1$s`.'), $file)
				);
			if(filesize($file) < $max_size) return $file;

			$archived_file = $this->©dir->n_seps_up($file).'/'.$this->abs_basename($file).'-archived-'.time().
			                 (($extension = $this->extension($file)) ? '.'.$extension : '');

			$this->rename_to($file, $archived_file);

			return $file; // Original `$file`.
		}

		/**
		 * Copy a file to a new location.
		 *
		 * @param string $file Path to file.
		 * @param string $to Path to new copy location.
		 *
		 * @return string New copy location; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file` is NOT a string; or is an empty string.
		 * @throws exception If `$file` is NOT actually a file.
		 * @throws exception If `$file` is NOT readable.
		 * @throws exception If `$to` is NOT a string; or is an empty string.
		 * @throws exception If `$to` already exists.
		 * @throws exception If `$to` parent directory does NOT exist; or is NOT writable.
		 * @throws exception If the underlying call to PHP's `copy()` function fails for any reason.
		 *
		 * @note This will NOT copy directories; only a single file.
		 */
		public function copy_to($file, $to)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			$file   = $this->©dir->n_seps($file);
			$to     = $this->©dir->n_seps($to);
			$to_dir = $this->©dir->n_seps_up($to);

			if(!is_file($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_source', get_defined_vars(),
					sprintf($this->__('Unable to copy. Nonexistent source: `%1$s`.'), $file)
				);
			if(!is_readable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_issues', get_defined_vars(),
					sprintf($this->__('Unable to copy this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not readable.')
				);

			if(file_exists($to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#destination_exists', get_defined_vars(),
					$this->__('Destination exists; it MUST first be deleted please.').
					' '.sprintf($this->__('Please check this file: `%1$s`.'), $to)
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

			if(!copy($file, $to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					sprintf($this->__('Unable to copy this file: `%1$s`; to `%2$s`.'), $file, $to).
					' '.$this->__('Possible permission issues. Please copy this file manually.')
				);
			clearstatcache(); // Make other routines aware.

			return $to; // It's a good day in Eureka!
		}

		/**
		 * Renames a file.
		 *
		 * @param string $file A full file path.
		 * @param string $to A new full file path.
		 *
		 * @return string Path to new location; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$file` is NOT a string; or is an empty string.
		 * @throws exception If `$file` is NOT actually a file.
		 * @throws exception If `$file` is NOT a readable/writable file.
		 * @throws exception If `$to` is NOT a string; or is an empty string.
		 * @throws exception If `$to` already exists.
		 * @throws exception If `$to` parent directory does NOT exist; or is NOT writable.
		 * @throws exception If the underlying call to PHP's `rename()` function fails for any reason.
		 *
		 * @note This will NOT rename directories; only a single file.
		 */
		public function rename_to($file, $to)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', func_get_args());

			$file   = $this->©dir->n_seps($file);
			$to     = $this->©dir->n_seps($to);
			$to_dir = $this->©dir->n_seps_up($to);

			if(!is_file($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_source', get_defined_vars(),
					sprintf($this->__('Unable to rename. Nonexistent source: `%1$s`.'), $file)
				);
			if(!is_readable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_issues', get_defined_vars(),
					sprintf($this->__('Unable to rename this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not readable.')
				);
			if(!is_writable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					sprintf($this->__('Unable to rename this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not writable.')
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

			if(!rename($file, $to))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#rename_failure', get_defined_vars(),
					sprintf($this->__('Rename failure. Could NOT rename: `%1$s`; to: `%2$s`.'), $file, $to)
				);
			clearstatcache(); // Make other routines aware.

			return $to; // It's a good day in Eureka!
		}

		/**
		 * Deletes a file.
		 *
		 * @param string|array $file Path to file (or an array of file paths).
		 * @params-variable-length This function accepts a variable-length list of arguments.
		 *    You can pass in any number of file paths for deletion (even string/array mixtures).
		 *
		 * @return boolean TRUE if all files are deleted; else an exception is thrown.
		 *    Also returns TRUE for any files that do NOT even exist.
		 *
		 * @note This will NOT delete directories; only files.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If any `$file` is NOT a string|array; or is an empty string|array.
		 * @throws exception If any `$file` exists; but it is NOT actually a file.
		 * @throws exception If any `$file` is NOT writable.
		 * @throws exception If deletion fails.
		 */
		public function delete($file)
		{
			$this->check_arg_types(array('string:!empty', 'array:!empty'), func_get_args());

			$files = array(); // Initialize array of files to delete here.

			foreach(func_get_args() as $_file) // Collect all arguments.
			{
				if(is_array($_file))
					$files = array_merge($files, $_file);
				else $files[] = $_file;
			}
			unset($_file); // Housekeeping.

			foreach($files as $_file) // Iterate all files now.
			{
				if(!$this->©string->is_not_empty($_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_file', get_defined_vars(),
						sprintf($this->__('Unable to delete this file: `%1$s`.'), $this->©var->dump($_file)).
						' '.$this->__('Each file MUST be represented by a (string) that is NOT empty.')
					);
				if(!file_exists($_file)) continue; // It's already gone.

				if(!is_file($_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_file', get_defined_vars(),
						sprintf($this->__('Unable to delete this file path. NOT a file: `%1$s`.'), $_file)
					);
				if(!is_writable($_file) || !unlink($_file))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
						sprintf($this->__('Unable to delete this file: `%1$s`.'), $_file).
						' '.$this->__('Possible permission issues. Please delete this file manually.')
					);
			}
			unset($_file); // Housekeeping.

			clearstatcache(); // Make other routines aware.

			return TRUE; // Default return value.
		}

		/**
		 * Deletes files deeply.
		 *
		 * @note This will NOT delete entire directories found in the array; we only delete files.
		 *    However, this MAY delete files in directories; depending on what the array actually contains.
		 *
		 * @return integer {@inheritdoc}
		 *
		 * @see dirs_files::delete_deep()
		 * @inheritdoc dirs_files::delete_deep()
		 */
		public function delete_deep($value, $min_mtime = -1, $min_atime = -1, $type = self::file_type, $___recursion = FALSE)
		{
			return parent::delete_deep($value, $min_mtime, $min_atime, $this::file_type, $___recursion);
		}

		/**
		 * Search/replace data in a file.
		 *
		 * @param string $pattern A regular expression to search for.
		 *    IMPORTANT: Search/replace is always performed ONE line at a time.
		 *    This means a regex pattern which includes `^$` will match against a line;
		 *    even without the `m` (multiline) modifier having been applied to the pattern.
		 *
		 * @param string $replacement A regular expression replacement string.
		 *    Remember to use {@link \xd_v141226_dev\strings\esc_refs()}
		 *
		 * @param string $file The file to search/replace in.
		 *
		 * @return integer Total number of replacements performed. This may return `0` in some cases.
		 *    An exception is thrown otherwise; e.g. we either succeed or fail with an exception.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$pattern` is empty.
		 * @throws exception If `$file` is NOT actually a file.
		 */
		public function preg_replace($pattern, $replacement, $file)
		{
			$this->check_arg_types('string:!empty', 'string', 'string:!empty', func_get_args());

			$file      = $this->©dir->n_seps($file);
			$temp_file = $this->©dir->temp().'/'.$this->©string->unique_id().'-'.basename($file);

			if(!is_file($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_source', get_defined_vars(),
					sprintf($this->__('Unable to search/replace: `%1$s`.'), $file).
					' '.$this->__('This is NOT an existing file.')
				);
			if(!is_readable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					sprintf($this->__('Unable to search/replace in this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not readable.')
				);
			if(!is_writable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					sprintf($this->__('Unable to search/replace in this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not writable.')
				);

			if(!is_resource($_file_resource = fopen($file, 'rb')))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#file_resource', get_defined_vars(),
					sprintf($this->__('Unable to open file resource: `%1$s`.'), $file)
				);
			if(!is_resource($_temp_file_resource = fopen($temp_file, 'ab')))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#temp_file_resource', get_defined_vars(),
					sprintf($this->__('Unable to open temp file resource: `%1$s`.'), $temp_file)
				);

			$replacements = 0; // Initialize counter.

			while(!feof($_file_resource))
			{
				$_line = fgets($_file_resource); // One line at a time.
				$_line = preg_replace($pattern, $replacement, $_line, -1, $_replacements);
				$replacements += $_replacements;

				if(!fwrite($_temp_file_resource, $_line))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#temp_write_failure', get_defined_vars(),
						sprintf($this->__('Failed to write a chunk of bytes to: `%1$s`.'), $temp_file)
					);
			}
			fclose($_file_resource);
			fclose($_temp_file_resource); // Housekeeping.
			unset($_file_resource, $_temp_file_resource, $_line, $_replacements);

			$this->rename_to($temp_file, $file.'-tmp'); // Make sure this works.
			// If this throws an exception; the original file remains intact (no data loss).
			$this->delete($file); // Delete the original file now (we will replace it here).
			$this->rename_to($file.'-tmp', $file); // Temp file takes its place.

			return $replacements; // Total replacements.
		}
	}
}