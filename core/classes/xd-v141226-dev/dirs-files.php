<?php
/**
 * Directory/File Utilities.
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
	 * Directory/File Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class dirs_files extends framework
	{
		/**
		 * Normalizes directory/file separators.
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::n_dir_seps()
		 * @inheritdoc \xd_v141226_dev::n_dir_seps()
		 */
		public function n_seps() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'n_dir_seps'), func_get_args());
		}

		/**
		 * Normalizes directory/file separators (up X directories).
		 *
		 * @return array {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::n_dir_seps_up()
		 * @inheritdoc \xd_v141226_dev::n_dir_seps_up()
		 */
		public function n_seps_up() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'n_dir_seps_up'), func_get_args());
		}

		/**
		 * Locates a specific directory/file path.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::locate()
		 * @inheritdoc \xd_v141226_dev::locate()
		 */
		public function locate() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'locate'), func_get_args());
		}

		/**
		 * Gets a directory/file extension.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::extension()
		 * @inheritdoc \xd_v141226_dev::extension()
		 */
		public function extension() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'extension'), func_get_args());
		}

		/**
		 * Shortens a directory/file path to its relative location from `DOCUMENT_ROOT`.
		 *
		 * @param string  $to_dir_file A full directory/file path.
		 *
		 * @param boolean $try_realpaths Defaults to TRUE. When TRUE, try to acquire `realpath()`;
		 *    thereby resolving all relative paths and/or symlinks in `DOCUMENT_ROOT` and `$to_dir_file`.
		 *
		 * @param boolean $use_win_diff_drive_jctn Defaults to TRUE. When TRUE, we'll try to work around issues with different drives on Windows®,
		 *    by attempting to create a directory junction between the two different drives; so a relative path can be formulated properly.
		 *
		 * @return string String with relative path to: `$to_dir_file` (from: `DOCUMENT_ROOT`); else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `DOCUMENT_ROOT` is empty, or is NOT a string.
		 * @throws exception If `$to_dir_file` is empty, or is NOT a string.
		 */
		public function doc_root_path($to_dir_file, $try_realpaths = TRUE, $use_win_diff_drive_jctn = TRUE)
		{
			$this->check_arg_types('string:!empty', 'boolean', 'boolean', func_get_args());

			if(!$this->©string->¤is_not_empty($doc_root = $this->©vars->_SERVER('DOCUMENT_ROOT')))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#doc_root_missing', get_defined_vars(),
					$this->__('Invalid and/or empty `DOCUMENT_ROOT` (expecting string NOT empty).')
				);
			return $this->rel_path($doc_root, $to_dir_file, $try_realpaths, $use_win_diff_drive_jctn);
		}

		/**
		 * Shortens a directory/file path to its relative location.
		 *
		 * @param string  $dir_file_from The full directory/file path to calculate a relative path from.
		 *
		 * @param string  $dir_file_to The full directory/file path, which this routine will build a relative path to.
		 *
		 * @param boolean $try_realpaths Defaults to TRUE; try to acquire `realpath()` for both `$dir_file_from` and `$dir_file_to`.
		 *
		 * @param boolean $use_win_diff_drive_jctn Defaults to TRUE. When TRUE, we'll try to work around issues with different drives on Windows®,
		 *    by attempting to create a Directory Junction between the two different drives; so a relative path can be formulated properly.
		 *
		 * @return string String with relative path to: `$dir_file_to` (from: `$dir_file_from`); else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If Windows® drive issues cannot be resolved in any way.
		 */
		public function rel_path($dir_file_from, $dir_file_to, $try_realpaths = TRUE, $use_win_diff_drive_jctn = TRUE)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'boolean', 'boolean', func_get_args());

			$from = $dir_file_from; // A shorter name.
			$to   = $dir_file_to; // A shorter name.

			if($try_realpaths) // Try to find realpaths?
			{
				if(($_real_from = realpath($from)) && ($_real_to = realpath($to)))
				{
					$from = $_real_from; // Real path on server.
					$to   = $_real_to; // Use real path on server.
				}
				unset($_real_from, $_real_to); // Housekeeping.
			}
			if($this->has_extension($from) || is_file($from))
				$from = $this->n_seps_up($from); // Need a directory.

			$from = preg_split('/\//', $this->n_seps($from)); // Allow empty values.
			$to   = preg_split('/\//', $this->n_seps($to)); // Allow empty values here too.
			// Either of these could have `[0] => ''` (we anticipate this in the routines below).

			if($this->©env->is_windows()) // Handle Windows® drive issues here.
			{
				if($from[0] && preg_match(stub::$regex_valid_win_drive_letter, $from[0].'/', $_m))
					$_from_drive = $_m['drive_letter']; // Uppercase.

				if($to[0] && preg_match(stub::$regex_valid_win_drive_letter, $to[0].'/', $_m))
					$_to_drive = $_m['drive_letter']; // Uppercase here too.

				if(!empty($_from_drive) && empty($_to_drive)) // Same drive?
				{
					$_to_drive = $_from_drive;
					if(strlen($to[0])) // Shift drive on?
						array_unshift($to, $_to_drive.':');
					else $to[0] = $_to_drive.':'; // Set drive value.
				}
				if(!empty($_to_drive) && empty($_from_drive)) // Same drive?
				{
					$_from_drive = $_to_drive;
					if(strlen($from[0])) // Shift drive on?
						array_unshift($from, $_from_drive.':');
					else $from[0] = $_from_drive.':'; // Set drive value.
				}
				if($use_win_diff_drive_jctn) // Attempt to create a Directory Junction (if needed)?
				{
					if(isset($_from_drive, $_to_drive) && $_from_drive !== $_to_drive)
					{
						$_from_drive_jctn = $_from_drive.':/'.$_to_drive.'-Drive';
						$_jctn            = (is_dir($_from_drive_jctn)) ? $_from_drive_jctn : '';

						if(!$_jctn) // If unable to create a junction on the `$_from_drive`; try temp directory.
						{
							$_temp_dir = $this->©dir->temp(); // Make sure temp directory has a drive letter.

							if(preg_match(substr(stub::$regex_valid_win_drive_letter, 0, -2).'/', $_temp_dir, $_m) && $_from_drive === $_m['drive_letter'])
								$_temp_dir_jctn = $_temp_dir.'/'.$_to_drive.'-Drive';

							if(!empty($_temp_dir_jctn) && is_dir($_temp_dir_jctn))
								$_jctn = $_temp_dir_jctn;
						}
						if(!$_jctn) // A directory junction does NOT exist yet?
						{
							try // Try creating a directory junction on the `$_from_drive`.
							{
								$_jctn = $this->©dir->create_win_jctn($_from_drive_jctn, $_to_drive.':/');
							}
							catch(exception $_exception) // Try temp directory.
							{
								if(!empty($_temp_dir_jctn)) try
								{
									$_jctn = $this->©dir->create_win_jctn($_temp_dir_jctn, $_to_drive.':/');
								}
								catch(exception $_exception)
								{
									// We'll handle below.
								}
								unset($_exception); // Housekeeping.
							}
							if(!$_jctn) throw $this->©exception(
								$this->method(__FUNCTION__).'#windows_drive', get_defined_vars(),
								$this->__('Unable to generate a relative path across different Windows® drives.').
								' '.sprintf($this->__('Please create a Directory Junction here: `%1$s`, pointing to: `%2$s`.'), $_from_drive_jctn, $_to_drive.':/')
							);
						}
						array_shift($to); // Shift drive off and use junction now.
						foreach(array_reverse(preg_split('/\//', $_jctn)) as $_jctn_dir)
							array_unshift($to, $_jctn_dir);
					}
				}
				else if(isset($_from_drive, $_to_drive) && $_from_drive !== $_to_drive)
					throw $this->©exception(
						$this->method(__FUNCTION__).'#windows_drive', get_defined_vars(),
						$this->__('Unable to generate a relative path across different Windows® drives.').
						' '.sprintf($this->__('Drive from: `%1$s`, drive to: `%2$s`.'), $_from_drive.':/', $_to_drive.':/')
					);
				unset($_m, $_from_drive, $_to_drive, $_from_drive_jctn, $_temp_dir, $_temp_dir_jctn, $_jctn, $_jctn_dir);
			}
			foreach(array_keys($from) as $_depth) // Loop through each `$from` directory `$_depth`.
				if(isset($from[$_depth], $to[$_depth]) && $from[$_depth] === $to[$_depth])
					unset($from[$_depth], $to[$_depth]);
				else break; // MUST stop now.

			$to = implode('/', $to);

			for($_depth = 0; $_depth < count($from); $_depth++)
				$to = '../'.$to;
			unset($_depth); // A little housekeeping.

			return $to; // Relative path.
		}

        /**
         * Locates a view directory/file (relative path).
         *
         * @param string $dir_file Template directory/file name (relative path).
         *
         * @param boolean $allow_failure Optional. Defaults to a `FALSE` value.
         *    By default, if the template dir/file does NOT exist, an exception is thrown.
         *    If `TRUE`, an empty string is returned on failure; instead of throwing an exception.
         *
         * @return string Absolute path to a template directory/file (w/ the highest precedence).
         *
         * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
         * @throws \xd_v141226_dev\exception If `$dir_file` is empty (it MUST be passed as a string, NOT empty).
         * @throws \xd_v141226_dev\exception If `$dir_file` does NOT exist, or is NOT readable.
         */
        public function view( $dir_file, $allow_failure = false ) {
            $this->check_arg_types( 'string:!empty', 'boolean', func_get_args() );

            $dir_file = ltrim( $this->n_seps( $dir_file ), '/' );

            foreach ( ( $dirs = $this->©dirs->where_views_may_reside() ) as $_dir ) {
                if ( file_exists( $path = $_dir . '/' . $dir_file ) && is_readable( $path ) ) {
                    return $path;
                }
            } // Absolute directory/file path.
            unset( $_dir ); // Housekeeping.

            if ( $allow_failure ) {
                return '';
            }

            throw $this->©exception(
                $this->method( __FUNCTION__ ) . '#dir_file_missing', get_defined_vars(),
                sprintf( $this->__( 'Unable to locate template directory/file: `%1$s`.' ), $dir_file )
            );
        }

        /**
         * Locates a view style directory/file (relative path).
         *
         * @param string $view_file Template directory/file name (relative path).
         *
         * @param boolean $allow_failure Optional. Defaults to a `FALSE` value.
         *    By default, if the template dir/file does NOT exist, an exception is thrown.
         *    If `TRUE`, an empty string is returned on failure; instead of throwing an exception.
         *
         * @return string Absolute path to a template directory/file (w/ the highest precedence).
         *
         * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
         * @throws \xd_v141226_dev\exception If `$dir_file` is empty (it MUST be passed as a string, NOT empty).
         * @throws \xd_v141226_dev\exception If `$dir_file` does NOT exist, or is NOT readable.
         */
        public function view_style( $view_file, $allow_failure = true ) {
            $this->check_arg_types( 'string:!empty', 'boolean', func_get_args() );

            $view_file = preg_replace( '/(.php|.html)+$/', '', ltrim( $this->n_seps( $view_file ), '/' ) ) . '.min.css';

            foreach ( ( $dirs = $this->©dirs->where_view_styles_may_reside() ) as $_dir ) {
                if ( file_exists( $path = $_dir . '/' . $view_file ) && is_readable( $path ) ) {
                    return $path;
                }
            } // Absolute directory/file path.
            unset( $_dir ); // Housekeeping.

            if ( $allow_failure ) {
                return '';
            }

            throw $this->©exception(
                $this->method( __FUNCTION__ ) . '#dir_file_missing', get_defined_vars(),
                sprintf( $this->__( 'Unable to locate template directory/file: `%1$s`.' ), $view_file )
            );
        }

        /**
         * Locates a view style directory/file (relative path).
         *
         * @param string $view_file Template directory/file name (relative path).
         *
         * @param boolean $allow_failure Optional. Defaults to a `FALSE` value.
         *    By default, if the template dir/file does NOT exist, an exception is thrown.
         *    If `TRUE`, an empty string is returned on failure; instead of throwing an exception.
         *
         * @return string Absolute path to a template directory/file (w/ the highest precedence).
         *
         * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
         * @throws \xd_v141226_dev\exception If `$dir_file` is empty (it MUST be passed as a string, NOT empty).
         * @throws \xd_v141226_dev\exception If `$dir_file` does NOT exist, or is NOT readable.
         */
        public function view_scripts( $view_file, $allow_failure = true ) {
            $this->check_arg_types( 'string:!empty', 'boolean', func_get_args() );

            $view_file = preg_replace( '/(.php|.html)+$/', '', ltrim( $this->n_seps( $view_file ), '/' ) ) . '.min.js';

            foreach ( ( $dirs = $this->©dirs->where_view_scripts_may_reside() ) as $_dir ) {
                if ( file_exists( $path = $_dir . '/' . $view_file ) && is_readable( $path ) ) {
                    return $path;
                }
            } // Absolute directory/file path.
            unset( $_dir ); // Housekeeping.

            if ( $allow_failure ) {
                return '';
            }

            throw $this->©exception(
                $this->method( __FUNCTION__ ) . '#dir_file_missing', get_defined_vars(),
                sprintf( $this->__( 'Unable to locate template directory/file: `%1$s`.' ), $view_file )
            );
        }

		/**
		 * Checks if a directory/file path is actually a link.
		 *
		 * @param string $dir_file Directory/file path (i.e. a possible symlink).
		 *
		 * @return boolean TRUE if `$dir_file` is a link; else FALSE.
		 */
		public function is_link($dir_file)
		{
			$this->check_arg_types('string', func_get_args());

			if(!$dir_file) return FALSE; // Catch empty values.

			$dir_file = $this->n_seps($dir_file);
			$realpath = (file_exists($dir_file)) ? $this->n_seps((string)realpath($dir_file)) : '';

			return ($dir_file && $realpath && $dir_file !== $realpath);
		}

		/**
		 * Locates a template directory/file (relative path).
		 *
		 * @param string  $dir_file Template directory/file name (relative path).
		 *
		 * @param boolean $allow_failure Optional. Defaults to a `FALSE` value.
		 *    By default, if the template dir/file does NOT exist, an exception is thrown.
		 *    If `TRUE`, an empty string is returned on failure; instead of throwing an exception.
		 *
		 * @return string Absolute path to a template directory/file (w/ the highest precedence).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` is empty (it MUST be passed as a string, NOT empty).
		 * @throws exception If `$dir_file` does NOT exist, or is NOT readable.
		 */
		public function template($dir_file, $allow_failure = FALSE)
		{
			$this->check_arg_types('string:!empty', 'boolean', func_get_args());

			$dir_file = ltrim($this->n_seps($dir_file), '/');

			foreach(($dirs = $this->©dirs->where_templates_may_reside()) as $_dir)
				if(file_exists($path = $_dir.'/'.$dir_file) && is_readable($path))
					return $path; // Absolute directory/file path.
			unset($_dir); // Housekeeping.

			if($allow_failure) return '';

			throw $this->©exception(
				$this->method(__FUNCTION__).'#dir_file_missing', get_defined_vars(),
				sprintf($this->__('Unable to locate template directory/file: `%1$s`.'), $dir_file)
			);
		}

		/**
		 * Converts a relative directory/file path into a CSS class name.
		 *
		 * @param string $dir_file Any directory/file (relative path).
		 *
		 * @return string A CSS class name.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_css_class($dir_file)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$dir_file = ltrim($this->n_seps($dir_file), '/');

			$css_class = str_replace('/', '--', $this->no_extension($dir_file));
			$css_class = preg_replace('/[^a-z0-9]/i', '-', $css_class);
			$css_class = trim($css_class, '-');

			return $css_class;
		}

		/**
		 * Absolute basename (no directory/file extension).
		 *
		 * @param string $dir_file A directory/file path.
		 *
		 * @return string Absolute basename (w/o its directory/file extension).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` is empty.
		 */
		public function abs_basename($dir_file)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			return $this->no_extension(basename($dir_file));
		}

		/**
		 * Directory/file path w/o it's extension.
		 *
		 * @param string $dir_file A directory/file path.
		 *
		 * @return string Directory/file path w/o it's extension.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` is empty.
		 */
		public function no_extension($dir_file)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(($extension = $this->extension($dir_file)))
				return preg_replace('/\.'.preg_quote($extension, '/').'$/i', '', $dir_file);

			return $dir_file;
		}

		/**
		 * A directory/file has an extension?
		 *
		 * @param string $dir_file A directory/file path.
		 *
		 * @param string $type Optional. Defaults to {@link fw_constants::any_type}.
		 *    Bypass w/ an empty string; in case of specific `$extensions` only.
		 *
		 * @param array  $extensions Optional. An array of specific extensions.
		 *    It's also possible to test for NO extension, by including an empty string in this array.
		 *
		 * @return boolean TRUE if `$dir_file` has an extension of `$type`.
		 *    Also TRUE if it has a specific extension in the optional `$extensions` array.
		 *
		 * @throws exception If `$dir_file` is empty.
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$type` is NOT empty; and it's unknown (e.g. an invalid type).
		 */
		public function has_extension($dir_file, $type = self::any_type, $extensions = array())
		{
			$this->check_arg_types('string:!empty', 'string', 'array', func_get_args());

			$extension = $this->extension($dir_file); // Get directory/file extension.

			if($type === $this::any_type && $extension)
				return TRUE; // Has an extension.

			if($extensions) // An array of specific extensions?
			{
				$extensions = $this->©array->to_one_dimension($extensions);
				$extensions = $this->©string->ify_deep($extensions);
				$extensions = array_map('strtolower', $extensions);
			}
			if($type) // Specific extension types (based on constants).
				$extensions = array_merge($extensions, $this->©file->extensions($type));

			return in_array($extension, $extensions, TRUE);
		}

		/**
		 * Should a directory/file path be ignored?
		 *
		 * @param string       $dir_file Directory/file path.
		 *    Directory separators are normalized (trailing slashes are stripped).
		 *
		 * @param string       $from_dir_file Optional. A root directory/file to check from (recommended).
		 *    If specified, we remove this root directory (or the directory containing this file) before checking glob exclusion patterns.
		 *    Directory separators are normalized (trailing slashes are stripped).
		 *
		 * @param array|string $globs An array, or a string of `;` separated glob exclusion patterns.
		 *    This defaults to those which are ignored by the XDaRk Core itself (default behavior).
		 *    This can be bypassed with an empty array/string; or with {@link fw_constants::defaults}.
		 *
		 * @param array|string $extra_globs Any additional glob exclusion patterns.
		 *    This should also be passed as an array, or as a string of `;` separated glob exclusion patterns.
		 *    This can be useful if you want to add additional exclusions; while keeping the XDaRk Core defaults.
		 *
		 * @param null|boolean $globs_case_insensitive Optional. This controls the `FNM_CASEFOLD` flag.
		 *    This defaults to a value of NULL (but please read the following for full details on the behavior).
		 *
		 *    • If `$globs` are NOT specified, the default XDaRk Core exclusions will force this to a TRUE value (default behavior).
		 *    • If specific `$globs` ARE passed in; this defaults to a FALSE value. It MUST be set explicitly if TRUE is the desired behavior.
		 *
		 * @param null|integer $glob_x_flags Optional. Defaults to a NULL value.
		 *    Any additional flags supported by PHP's `fnmatch()` function are acceptable here.
		 *
		 * @return boolean TRUE if the directory/file should be ignored; else FALSE.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` is empty.
		 *
		 * @see `/.gitignore` file in the XDaRk Core repo directory.
		 *    This file is where we maintain a master list of all glob exclusion patterns.
		 *    The default set of glob exclusion patterns in THIS routine should be updated if the master list changes.
		 *
		 * @see deps_x_xd_v141226_dev::dir_file_ignore()
		 */
		public function ignore($dir_file, $from_dir_file = '', $globs = self::defaults, $extra_globs = array(), $globs_case_insensitive = NULL, $glob_x_flags = NULL)
		{
			$this->check_arg_types('string:!empty', 'string',
			                       array('array', 'string'), array('array', 'string'),
			                       array('null', 'boolean'), array('null', 'integer'), func_get_args());

			if(!isset($this->static[__FUNCTION__]))
				$this->static[__FUNCTION__] = array();
			$static =& $this->static[__FUNCTION__]; // Shorter reference.

			$dir_file = $this->n_seps($dir_file); // Normalize directory seps.

			if($from_dir_file && ($this->has_extension($from_dir_file) || is_file($from_dir_file)))
				$from_dir = $this->n_seps_up($from_dir_file); // Need a directory.
			else $from_dir = $this->n_seps($from_dir_file); // Directory.

			if($from_dir) // Did we get a from directory?
			{
				if($dir_file === $from_dir) return FALSE; // Do NOT ignore from directory.
				$dir_file = preg_replace('/^'.preg_quote($from_dir, '/').'\//', '/', $dir_file);
			}
			$globs       = ($globs !== $this::defaults && is_string($globs)) ? preg_split('/;+/', $globs, NULL, PREG_SPLIT_NO_EMPTY) : $globs;
			$extra_globs = (is_string($extra_globs)) ? preg_split('/;+/', $extra_globs, NULL, PREG_SPLIT_NO_EMPTY) : $extra_globs;

			if($globs === $this::defaults || !$this->©array->is_not_empty($globs)) // If there are NO specific globs (default behavior).
			{
				if(!isset($static['ignore_glob_defaults']) || !is_array($static['ignore_glob_defaults']))
				{
					$globs = $static['ignore_glob_defaults'] = // From the `/.gitignore` file in the XDaRk Core repo directory.
						'.~*;*~;*.bak;.idea;*.iml;*.ipr;*.iws;*.sublime-workspace;*.sublime-project;.git;.gitignore;.gitattributes;CVS;.cvsignore;.svn;_svn;.bzr;.bzrignore;.hg;.hgignore;SCCS;RCS;$RECYCLE.BIN;Desktop.ini;Thumbs.db;ehthumbs.db;.Spotlight-V100;.AppleDouble;.LSOverride;.DS_Store;.Trashes;Icon'."\r".';._*;.elasticbeanstalk';
					$globs = $static['ignore_glob_defaults'] = preg_split('/;+/', $globs, NULL, PREG_SPLIT_NO_EMPTY);
				}
				else $globs = $static['ignore_glob_defaults']; // We've already defined these once before.

				$globs_case_insensitive = TRUE; // This is forced to a TRUE value on default globs.
			}
			$globs                  = array_merge($globs, $extra_globs);
			$globs_case_insensitive = (boolean)$globs_case_insensitive;

			for($_i = 0, $_dir_file = $dir_file; $_i <= 100; $_i++)
			{
				if($_i > 0) // Up one directory now?
					$_dir_file = $this->n_seps_up($_dir_file, 1, TRUE);

				if(!$_dir_file || $_dir_file === '.' || substr($_dir_file, -1) === ':')
					break; // Search complete (we're beyond even a root directory or scheme now).

				if($this->©string->in_wildcard_patterns($_dir_file, $globs, $globs_case_insensitive, FALSE, $glob_x_flags))
					return TRUE; // We SHOULD ignore this directory/file.

				if($this->©string->in_wildcard_patterns(basename($_dir_file), $globs, $globs_case_insensitive, FALSE, $glob_x_flags))
					return TRUE; // We SHOULD ignore this directory/file.

				if(substr($_dir_file, -1) === '/') // Root directory or scheme?
					break; // Search complete (there is nothing more to search after this).
			}
			unset($_dir_file); // Just a little housekeeping.

			return FALSE; // Default return value.
		}

		/**
		 * Enhances PHP's own `glob()` function.
		 *
		 * @param string       $dir Glob directory.
		 *
		 * @param string       $pattern A glob pattern string.
		 *
		 * @param boolean      $case_insensitive Optional. This defaults to a FALSE value.
		 *    If TRUE, this enables the {@link fw_constants::glob_casefold} flag (as described below).
		 *
		 *    • If TRUE, we force character classes on both `$dir` & `$pattern` (i.e. `[aA][bB]`) to test for caSe variations.
		 *       See also: {@link strings::fnm_case()} for further details about how this works.
		 *
		 * @param null|integer $x_flags Optional. Defaults to a NULL value.
		 *    The defaults are: {@link fw_constants::glob_period}, {@link fw_constants::glob_brace}; unless `$flags` are passed in explicitly.
		 *    Regardless, if you'd like to use additional flags, pass this parameter with a non-NULL value.
		 *
		 *    • You may NOT use the {@link fw_constants::glob_nocheck} flag with this method. It is NOT supported here.
		 *       Attempts to use the {@link fw_constants::glob_nocheck} flag will result in an exception.
		 *
		 * @param null|integer $flags The defaults are recommended; but specific flags can be passed in if you prefer.
		 *    The difference between `$x_flags` and `$flags`; is that `$flags` will override all defaults;
		 *    whereas `$x_flags` will simply add additional flags to the existing defaults.
		 *
		 *    • PHP's own `glob()` function will NOT (by default) find hidden dot `.` files using wildcards.
		 *       However, WE use the {@link fw_constants::glob_period}, {@link fw_constants::glob_brace} flags as follows: `glob('/{,.}*', GLOB_BRACE)`.
		 *       This functionality is enabled automatically; when/if `$flags` includes {@link fw_constants::glob_period}, {@link fw_constants::glob_brace};
		 *       and whenever your `$pattern` contains `/*` combinations. Instances of `/*` are converted into `/{,.}*` glob brace checks.
		 *
		 *       In short, we find all hidden dot `.` files automatically (this is the default behavior).
		 *       To disable this default behavior, pass `$flags` w/o the {@link fw_constants::glob_period} flag.
		 *
		 *    • You may NOT use the {@link fw_constants::glob_nocheck} flag with this method. It is NOT supported here.
		 *       Attempts to use the {@link fw_constants::glob_nocheck} flag will result in an exception.
		 *
		 * @param string       $type Optional. This defaults to {@link fw_constants::any_type}.
		 *    If you want to ONLY glob directories, use: {@link fw_constants::dir_type}.
		 *    If you want to ONLY glob files, use: {@link fw_constants::file_type}.
		 *
		 * @return array An array of absolute file paths; else an empty array.
		 *    Relative paths are removed for security purposes; in case `glob()` finds directory dots.
		 *    All directory separators are normalized by this routine. See {@link n_seps()} for further details.
		 *       If the {@link fw_constants::glob_mark} flag is used, we preserve trailing slashes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the `$dir` or `$pattern` parameters are empty.
		 * @throws exception If the `glob()` function is NOT possible on this PHP installation.
		 * @throws exception If `fw_constants::glob_brace` is NOT compatible with the underlying server for any reason.
		 * @throws exception If you attempt to use the `fw_constants::glob_period` flag (w/o the `fw_constants::glob_brace` flag).
		 * @throws exception If you attempt to use the `fw_constants::glob_nocheck` flag; we do NOT support this flag here.
		 *
		 * @see dirs::glob()
		 * @see files::glob()
		 * @see http://php.net/manual/en/function.glob.php
		 */
		public function glob($dir, $pattern, $case_insensitive = FALSE, $x_flags = NULL, $flags = NULL, $type = self::any_type)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'boolean',
			                       array('null', 'integer'), array('null', 'integer'),
			                       'string:!empty', func_get_args());

			// Standardize parameter values.

			$dir     = $this->n_seps($dir);
			$pattern = '/'.ltrim($pattern, '/');

			if(!isset($flags)) // Defaults.
				$flags = $this::glob_period | $this::glob_brace;
			$flags = ($case_insensitive) ? $flags | $this::glob_casefold : $flags;
			$flags = (isset($x_flags)) ? $flags | $x_flags : $flags;

			// Validate flags & check compatibility.

			if($flags & $this::glob_nocheck)
				throw $this->©exception( // NOT possible on some systems.
					$this->method(__FUNCTION__).'#glob_nocheck_not_possible', get_defined_vars(),
					$this->__('The `glob_nocheck` flag is NOT supported here.')
				);
			if($flags & $this::glob_period && !($flags & $this::glob_brace))
				throw $this->©exception( // NOT possible on some systems.
					$this->method(__FUNCTION__).'#glob_period_not_possible_w/o_glob_brace', get_defined_vars(),
					$this->__('The `glob_brace` flag is missing; it\'s required for `glob_period`.')
				);
			if(!$this->©function->is_possible('glob'))
				throw $this->©exception( // NOT possible.
					$this->method(__FUNCTION__).'#glob_not_possible', get_defined_vars(),
					$this->__('Compatibility issue. The `glob()` PHP function is NOT supported by this server.').
					' '.$this->__('If you\'re running an old Sun-OS server, please upgrade to the latest release.')
				);
			if(!defined('GLOB_AVAILABLE_FLAGS') || !defined('GLOB_BRACE') || !(GLOB_AVAILABLE_FLAGS & GLOB_BRACE))
				throw $this->©exception( // NOT possible on some systems.
					$this->method(__FUNCTION__).'#glob_brace_not_possible', get_defined_vars(),
					$this->__('Compatibility issue. The `GLOB_BRACE` flag is NOT supported by this server.').
					' '.$this->__('`GLOB_BRACE` is NOT compatible w/ Solaris and other non-GNU servers.')
				);
			$php_flags = 0; // Convert core flags into PHP flags.

			if($flags & $this::glob_mark) $php_flags |= GLOB_MARK;
			if($flags & $this::glob_nosort) $php_flags |= GLOB_NOSORT;
			if($flags & $this::glob_nocheck) $php_flags |= GLOB_NOCHECK;
			if($flags & $this::glob_noescape) $php_flags |= GLOB_NOESCAPE;
			if($flags & $this::glob_brace) $php_flags |= GLOB_BRACE;
			if($flags & $this::glob_onlydir) $php_flags |= GLOB_ONLYDIR;
			if($flags & $this::glob_err) $php_flags |= GLOB_ERR;

			// Process glob routines.

			if($flags & $this::glob_casefold)
			{
				$dir     = $this->©string->fnm_case($dir);
				$pattern = $this->©string->fnm_case($pattern);
			}
			if($flags & $this::glob_period && $flags & $this::glob_brace)
				$pattern = str_replace('/*', '/{,.}*', $pattern);

			if(!is_array($glob = glob($dir.$pattern, $php_flags)))
				return array(); // Always an array.

			$_allow_trailing_slash = ($flags & $this::glob_mark) ? TRUE : FALSE;
			foreach($glob as &$_dir_file) // Normalize directory separators.
				$_dir_file = $this->n_seps($_dir_file, $_allow_trailing_slash);
			unset($_dir_file, $_allow_trailing_slash);

			$glob = array_unique($glob); // In case of dupes on brace checks.

			foreach($glob as $_key => $_dir_file) // Remove paths w/ directory dots.
				// Relative dots may cause MASSIVE unexpected deletions; or other problems.
				// This is VERY IMPORTANT; otherwise our glob may contain relative paths.
				if(preg_match('/\/\.+(?:\/|$)/', $_dir_file)) unset($glob[$_key]);
			unset($_key, $_dir_file); // Housekeeping.

			switch($type) // Type handler.
			{
				case $this::dir_type:
					$glob = array_filter($glob, 'is_dir');
					return array_values($glob);

				case $this::file_type:
					$glob = array_filter($glob, 'is_file');
					return array_values($glob);

				case $this::any_type:
				default: // Default case handler.
					return array_values($glob);
			}
		}

		/**
		 * Deletes directories/files deeply.
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Absolute directory/file paths.
		 *    Any value parameter can be converted into a directory/file path string.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param integer $min_mtime Optional. Defaults to `-1` (no minimum).
		 *    If directories/files were last modified after this time, they will NOT be deleted by this routine.
		 *    If this value is less than `0`; there is no minimum time (i.e. this does NOT apply).
		 *
		 * @param integer $min_atime Optional. Defaults to `-1` (no minimum).
		 *    If directories/files were last accessed after this time, they will NOT be deleted by this routine.
		 *    If this value is less than `0`; there is no minimum time (i.e. this does NOT apply).
		 *
		 * @param string  $type Optional. This defaults to {@link fw_constants::any_type}.
		 *    If you want to ONLY delete directories, use: {@link fw_constants::dir_type}.
		 *    If you want to ONLY delete files, use: {@link fw_constants::file_type}.
		 *
		 * @param boolean $___recursion Do NOT pass this. For internal use only.
		 *
		 * @return integer Number of directories/files deleted; else an exception is thrown.
		 *    Files inside deleted directories are NOT counted in this; only the directory itself.
		 *    Directories/files that do NOT even exist; do NOT get counted in this.
		 *    This function may often return a `0` value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to delete a directory/file.
		 *
		 * @see dirs::delete_deep()
		 * @see files::delete_deep()
		 */
		public function delete_deep($value, $min_mtime = -1, $min_atime = -1, $type = self::any_type, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for the initial caller.
				$this->check_arg_types('', 'integer', 'integer', 'string:!empty', 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				$deleted_dirs_files = 0;

				foreach($value as $_value)
					$deleted_dirs_files += $this->delete_deep($_value, $min_mtime, $min_atime, $type, TRUE);
				return $deleted_dirs_files; // Total deletions.
			}
			if(!($value = (string)$value) || $value === '.' || $value === '..')
				return 0; // Ignore empty values & directory dots.

			switch($type) // Type/exists filter handler.
			{
				case $this::dir_type:
					if(!is_dir($value))
						return 0;
					break;

				case $this::file_type:
					if(!is_file($value))
						return 0;
					break;

				case $this::any_type:
				default: // Default case handler.
					if(!file_exists($value))
						return 0;
					break;
			}
			if($min_mtime >= 0 && filemtime($value) > $min_mtime)
				return 0; // Not old enough yet.

			if($min_atime >= 0 && fileatime($value) > $min_atime)
				return 0; // Not old enough yet.

			if(is_dir($value))
				$this->©dir->delete($value);
			else $this->©file->delete($value);

			return 1; // This directory/file deleted now.
		}
	}
}