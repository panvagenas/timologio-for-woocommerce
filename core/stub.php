<?php
/*                                                                                      a
                                                                                       aaa
                                                                                      aaaaa
                                                              hhhh        hhhh       aaa aaa        rrrrrrrr
                                                  sssssss     hhhh        hhhh      aaaa aaaa      rrrrrrrrrrr    kkkk
www        w        ww eeeeeeeee  bbbbbbbb      sssssssssss   hhhh        hhhh     aaaa   aaaa     rrrr   rrrrr   kkkk     kkk      ssss
 www      www      www eeeeeeeee  bbbbbbbbb    sssss    sss   hhhh        hhhh    aaaaa   aaaaa    rrrr   rrrrr   kkkk   kkkkk   sssssssss
  www    wwwww    www  eee        bbb   bbb     sssss         hhhhhhhhhhhhhhhh   aaaaa     aaaaa   rrrrrrrrrr     kkkk  kkkk     ssss  sss
   www  www www  www   eeeeeeeee  bbbbbbbb       ssssssss     hhhhhhhhhhhhhhhh  aaaaaaaaaaaaaaaaa  rrrrrrrr       kkkkkkkkk      sssss
    www ww   ww www    eeeeeeeee  bbbbbbbbbb        sssssss   hhhh        hhhh aaaaaaaaaaaaaaaaaaa rrrrrrrrr      kkkkkkkk        ssssssss
     wwww     wwww     eee        bbb    bbb            ssss  hhhh        hhhh aaaaa         aaaaa rrrr  rrrr     kkkk kkkkk          sssss
      ww       ww      eeeeeeeee  bbbbbbbbbb   ssss     ssss  hhhh        hhhh aaaa           aaaa rrrr   rrrrr   kkkk  kkkkk   sss     sss
      ww       ww      eeeeeeeee  bbbbbbbb     sssssssssssss  hhhh        hhhh aaa             aaa rrrr    rrrrr  kkkk    kkkkk sssssssssss
                                                 ssssssss     hhhh        hhhh aa               aa rrrr      rrrr kkkk     kkkk   sssssss
     wswswswswswswswswswswswswswswswswsws                                                                                               ®*/
/**
 * Stub: XDaRk Core
 *
 * @note MUST remain PHP v5.2 compatible.
 *
 * Copyright: © 2013 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 130302
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# Version/namespace for this stub file.
# -----------------------------------------------------------------------------------------------------------------------------------------
$GLOBALS[__FILE__]['version'] = '141226-dev'; #!version!#
$GLOBALS[__FILE__]['core_ns'] = 'xd_v141226_dev';

# -----------------------------------------------------------------------------------------------------------------------------------------
# Only if the XDaRk Core stub class does NOT exist yet; (we don't care about WordPress® here yet).
# -----------------------------------------------------------------------------------------------------------------------------------------
if(!class_exists('xd_v141226_dev')) // Core stub class (for this verison).
{
	# -----------------------------------------------------------------------------------------------------------------------------------
	# XDaRk Core stub class definition.
	# -----------------------------------------------------------------------------------------------------------------------------------
	/**
	 * Stub: XDaRk Core class.
	 *
	 * @note MUST remain PHP v5.2 compatible.
	 *
	 * @package XDaRk\Core
	 * @since 130302
	 */
	final class xd_v141226_dev // Static properties/methods only please.
	{
		# --------------------------------------------------------------------------------------------------------------------------------
		# Public properties (see also: bottom of this file).
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * XDaRk Core name.
		 *
		 * @var string XDaRk Core name.
		 */
		public static $core_name = 'XDaRk Core';

		/**
		 * XDaRk Core site.
		 *
		 * @var string XDaRk Core site.
		 */
		public static $core_site = 'http://xdark.eu';

		/**
		 * Local WordPress® development directory.
		 *
		 * @var string Local WordPress® development directory.
		 *
		 * @note For internal/development use only.
		 */
		public static $local_wp_dev_dir = '%%$_SERVER[WEBSHARK_HOME]%%/Apache/wordpress.loc';

		/**
		 * Local XDaRk Core repo directory.
		 *
		 * @var string Local XDaRk Core repo directory.
		 *
		 * @note For internal/development use only.
		 */
		public static $local_core_repo_dir = '%%$_SERVER[WEBSHARK_HOME]%%/WebSharks/core';

		/**
		 * XDaRk Core prefix.
		 *
		 * @var string XDaRk Core prefix.
		 */
		public static $core_prefix = 'xd_';

		/**
		 * XDaRk Core prefix w/ dashes.
		 *
		 * @var string XDaRk Core prefix w/ dashes.
		 */
		public static $core_prefix_with_dashes = 'xd-';

		/**
		 * XDaRk Core capability requirement.
		 *
		 * @var string XDaRk Core capability.
		 */
		public static $core_cap = 'administrator';

		/**
		 * XDaRk Core prefix capability requirement.
		 *
		 * @var string XDaRk Core capability w/ dashes.
		 */
		public static $core_cap_with_dashes = 'administrator';

		/**
		 * XDaRk Core stub.
		 *
		 * @var string XDaRk Core stub.
		 */
		public static $core_ns_stub = 'xd';

		/**
		 * XDaRk Core stub w/ dashes.
		 *
		 * @var string XDaRk Core stub w/ dashes.
		 */
		public static $core_ns_stub_with_dashes = 'xd';

		/**
		 * XDaRk Core stub_v.
		 *
		 * @var string XDaRk Core stub_v.
		 */
		public static $core_ns_stub_v = 'xd_v';

		/**
		 * XDaRk Core stub-v w/ dashes.
		 *
		 * @var string XDaRk Core stub-v w/ dashes.
		 */
		public static $core_ns_stub_v_with_dashes = 'xd-v';

		/**
		 * XDaRk Core namespace.
		 *
		 * @var string XDaRk Core namespace.
		 */
		public static $core_ns = 'xd_v141226_dev';

		/**
		 * XDaRk Core namespace w/ prefix.
		 *
		 * @var string XDaRk Core namespace w/ prefix.
		 */
		public static $core_ns_prefix = '\\xd_v141226_dev';

		/**
		 * XDaRk Core namespace w/ dashes.
		 *
		 * @var string XDaRk Core namespace w/ dashes.
		 */
		public static $core_ns_with_dashes = 'xd-v141226-dev';

		/**
		 * XDaRk Core version string.
		 *
		 * @var string XDaRk Core version string.
		 */
		public static $core_version = '141226-dev'; #!version!#

		/**
		 * XDaRk Core namespace version (with underscores).
		 *
		 * @var string XDaRk Core namespace version (with underscores).
		 */
		public static $core_version_with_underscores = '141226_dev'; #!version-with-underscores!#

		/**
		 * XDaRk Core namespace version (with dashes).
		 *
		 * @var string XDaRk Core namespace version (with dashes).
		 */
		public static $core_version_with_dashes = '141226-dev'; #!version-with-dashes!#

		# --------------------------------------------------------------------------------------------------------------------------------
		# Protected properties (see also: bottom of this file).
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Initialized yet?
		 *
		 * @var boolean Initialized yet?
		 */
		protected static $initialized = FALSE;

		/**
		 * A static cache (for all instances).
		 *
		 * @var array A static cache (for all instances).
		 */
		protected static $static = array();

		# --------------------------------------------------------------------------------------------------------------------------------
		# Initializes XDaRk Core stub (see also: bottom of this file).
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Initializes XDaRk Core stub.
		 *
		 * @return boolean Returns the `$initialized` property w/ a TRUE value.
		 *
		 * @throws exception If attempting to run the XDaRk Core from a root directory.
		 */
		public static function initialize()
		{
			if(self::$initialized)
				return TRUE; // Initialized already.
			/*
			 * Do NOT run this file from a root directory.
			 */
			if(substr(self::n_dir_seps_up(__FILE__, 1, TRUE), -1) === '/')
				throw new exception( // Fail here; do NOT access this file from a root directory.
					sprintf(self::__('This file should NOT be accessed from a root directory: `%1$s`'), __FILE__));
			/*
			 * Handle some dynamic regex replacement codes in class properties (as follows).
			 */
			$webshark_home_dir                             = (!empty($_SERVER['WEBSHARK_HOME'])) ? (string)$_SERVER['WEBSHARK_HOME'] : '/webshark/home';
			self::$local_wp_dev_dir                        = str_replace('%%$_SERVER[WEBSHARK_HOME]%%', $webshark_home_dir, self::$local_wp_dev_dir);
			self::$local_core_repo_dir                     = str_replace('%%$_SERVER[WEBSHARK_HOME]%%', $webshark_home_dir, self::$local_core_repo_dir);
			self::$regex_valid_core_ns_version             = str_replace('%%self::$core_ns_stub_v%%', preg_quote(self::$core_ns_stub_v, '/'), self::$regex_valid_core_ns_version);
			self::$regex_valid_core_ns_version_with_dashes = str_replace('%%self::$core_ns_stub_v_with_dashes%%', preg_quote(self::$core_ns_stub_v_with_dashes, '/'), self::$regex_valid_core_ns_version_with_dashes);

			/*
			 * Easier access for those who DON'T CARE about the version (PHP v5.3+ only).
			 */
			if(!class_exists(self::$core_ns_stub.'__stub') && function_exists('class_alias'))
				class_alias(__CLASS__, self::$core_ns_stub.'__stub');

			return (self::$initialized = TRUE);
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Routines related to PHAR/autoload conditionals.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Global PHAR variable for the XDaRk Core.
		 *
		 * @return string The PHAR variable for the XDaRk Core.
		 */
		public static function is_phar_var()
		{
			return 'is_phar_'.self::$core_ns;
		}

		/**
		 * Global autoload var for the XDaRk Core.
		 *
		 * @return string Autoload var for the XDaRk Core.
		 */
		public static function autoload_var()
		{
			return 'autoload_'.self::$core_ns;
		}

		/**
		 * This file is a PHP Archive?
		 *
		 * @return string A PHP Archive file?
		 */
		public static function is_phar()
		{
			$is_phar_var = self::is_phar_var();

			if(!empty($GLOBALS[$is_phar_var]) && $GLOBALS[$is_phar_var] === 'phar://'.__FILE__)
				return $GLOBALS[$is_phar_var];

			return '';
		}

		/**
		 * Php Archives are possible?
		 *
		 * @return boolean Php Archives are possible?
		 */
		public static function can_phar()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			self::$static[__FUNCTION__] = extension_loaded('phar');

			if(self::$static[__FUNCTION__] && extension_loaded('suhosin'))
				if(stripos(ini_get('suhosin.executor.include.whitelist'), 'phar') === FALSE)
					self::$static[__FUNCTION__] = FALSE;

			return self::$static[__FUNCTION__];
		}

		/**
		 * A webPhar instance?
		 *
		 * @return boolean A webPhar instance?
		 */
		public static function is_webphar()
		{
			if(defined('WPINC'))
				return FALSE;

			$is_phar = $phar = self::is_phar();

			if($is_phar && !empty($_SERVER['SCRIPT_FILENAME']) && is_string($_SERVER['SCRIPT_FILENAME']))
				if(realpath($_SERVER['SCRIPT_FILENAME']) === realpath(substr($phar, 7)))
					return TRUE;

			return FALSE;
		}

		/**
		 * Autoload XDaRk Core?
		 *
		 * @return boolean Autoload XDaRk Core?
		 */
		public static function is_autoload()
		{
			if(self::is_webphar())
				return FALSE;

			$autoload_var = self::autoload_var();

			if(!isset($GLOBALS[$autoload_var]) || $GLOBALS[$autoload_var])
				return TRUE;

			return FALSE;
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Routines that locate WordPress®.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Attempts to locate `/wp-load.php`.
		 *
		 * @param boolean             $get_last_value Defaults to a FALSE value.
		 *    This function stores it's last return value for quicker access on repeated calls.
		 *    If this is TRUE; no search will take place. We simply return the last/previous value.
		 *
		 * @param boolean             $check_abspath Defaults to TRUE (recommended).
		 *    If TRUE, we will first check the `ABSPATH` constant (if defined) for `/wp-load.php`.
		 *
		 * @param null|boolean|string $fallback Defaults to NULL (recommended).
		 *
		 *    • If NULL, and WordPress® cannot be located anywhere else;
		 *       and `___DEV_KEY_OK` is TRUE; automatically fallback on a local development copy.
		 *
		 *    • If TRUE, and WordPress® cannot be located anywhere else;
		 *       automatically fallback on a local development copy.
		 *
		 *    • If NULL|TRUE, we'll look inside: `self::$local_wp_dev_dir` (a default XDaRk Core location).
		 *       If STRING, we'll look inside the directory path defined by the string value.
		 *
		 *    • If FALSE — we will NOT fallback under any circumstance.
		 *
		 * @return string Full server path to `/wp-load.php` on success, else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function wp_load($get_last_value = FALSE, $check_abspath = TRUE, $fallback = NULL)
		{
			if(!is_bool($get_last_value) || !is_bool($check_abspath) || !(is_null($fallback) || is_bool($fallback) || is_string($fallback)))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			if($get_last_value && isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			if($check_abspath && defined('ABSPATH') && is_file($_wp_load = ABSPATH.'wp-load.php'))
				return (self::$static[__FUNCTION__] = self::n_dir_seps($_wp_load));

			if(($_wp_load = self::locate('/wp-load.php')))
				return (self::$static[__FUNCTION__] = $_wp_load);

			if(!isset($fallback)) // Auto-detection.
				$fallback = defined('___DEV_KEY_OK');

			if($fallback) // Fallback on local dev copy?
			{
				if(is_string($fallback))
					$dev_dir = self::n_dir_seps($fallback);
				else $dev_dir = self::n_dir_seps(self::$local_wp_dev_dir);

				if(is_file($_wp_load = $dev_dir.'/wp-load.php'))
					return (self::$static[__FUNCTION__] = $_wp_load);
			}
			unset($_wp_load); // Housekeeping.

			return (self::$static[__FUNCTION__] = ''); // Failure.
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Routines that locate class files.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Gets XDaRk Core `deps.php` class file path.
		 *
		 * @param boolean $enable_display_errors This is TRUE by default.
		 *    If TRUE, we will make sure any exceptions are displayed on-screen.
		 *    We assume (by default); that if dependency utilities CANNOT be loaded up;
		 *    we need to force a display that indicates the reason why.
		 *
		 * @note If we CANNOT load dependency utilities; something MUST be said to a site owner.
		 *    If `error_reporting` hides or log exceptions, this important dependency may never be known.
		 *    Dependency utilities are what we use to address common issues. If they CANNOT be loaded up;
		 *    we have a BIG problem here; and the site owner MUST be made aware of that issue.
		 *
		 * @return string Absolute path to XDaRk Core `deps.php` class file.
		 *
		 * @throws exception If unable to locate the XDaRk Core `deps.php` class file.
		 */
		public static function deps($enable_display_errors = TRUE)
		{
			if(!is_bool($enable_display_errors))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			try // Any exceptions will be re-thrown below.
			{
				return self::locate_core_ns_class_file('deps.php');
			}
			catch(exception $exception) // Now re-throw.
			{
				if($enable_display_errors)
				{
					error_reporting(-1);
					ini_set('display_errors', TRUE);
				}
				throw $exception;
			}
		}

		/**
		 * Gets XDaRk Core `framework.php` class file path.
		 *
		 * @return string Absolute path to XDaRk Core `framework.php` class file.
		 *
		 * @throws exception If unable to locate the XDaRk Core `framework.php` class file.
		 */
		public static function framework()
		{
			return self::locate_core_ns_class_file('framework.php');
		}

		/**
		 * Gets a XDaRk Core class file (absolute path).
		 *
		 * @param string $class_file_basename Class file (basename only please).
		 *    Ex: `class.php`; or `sub-namespace/class.php` is OK too.
		 *
		 * @return string Absolute path to the requested `$class_file_basename`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$class_file_basename` is empty; or it is NOT a string value.
		 * @throws exception If unable to locate the XDaRk Core `$class_file_basename`.
		 *
		 * @note It's VERY important that we obtain class file paths for THIS version of the XDaRk Core.
		 *    This is accomplished by looking for classes along a path which includes this XDaRk Core namespace.
		 */
		public static function locate_core_ns_class_file($class_file_basename)
		{
			if(!is_string($class_file_basename) || !($class_file_basename = trim(self::n_dir_seps($class_file_basename), '/')))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$this_dir                     = self::n_dir_seps_up(__FILE__);
			$local_core_repo_dir_basename = basename(self::$local_core_repo_dir);
			$is_phar                      = $this_phar = self::n_dir_seps(self::is_phar());

			$locate_core_dir      = '/'.self::$core_ns_stub_with_dashes;
			$locate_core_phar     = '/'.self::$core_ns_stub_with_dashes.'.php.phar';
			$locate_core_dev_dir  = '/'.$local_core_repo_dir_basename.'/'.self::$core_ns_stub_with_dashes;
			$locate_core_dev_phar = '/'.$local_core_repo_dir_basename.'/'.self::$core_ns_stub_with_dashes.'.php.phar';
			$relative_class_path  = 'classes/'.self::$core_ns_with_dashes.'/'.$class_file_basename;

			if(is_file($class_path = $this_dir.'/'.$relative_class_path))
				return $class_path; // We first check this directory.

			if(($class_path = self::locate($locate_core_dir.'/'.$relative_class_path)))
				return $class_path; // Sitewide (or nearest) XDaRk Core.

			if($is_phar && self::can_phar() && is_file($class_path = $this_phar.'/'.$relative_class_path))
				return $class_path; // If this is a PHAR (and PHAR is possible); we can use this archive.

			if(self::can_phar() && ($class_path = self::locate($locate_core_phar.'/'.$relative_class_path, 'phar://')))
				return $class_path; // Sitewide (or nearest) XDaRk Core archive (if possible).

			if(defined('___DEV_KEY_OK') && ($class_path = self::locate($locate_core_dev_dir.'/'.$relative_class_path)))
				return $class_path; // Development copy (for authenticated developers).

			if(defined('___DEV_KEY_OK') && ($class_path = self::locate($locate_core_dev_phar.'/'.$relative_class_path, 'phar://')))
				return $class_path; // Development copy (for authenticated developers).

			// Upon failure, we can make an attempt to notify site owners about PHAR compatibility.
			$has_phar = ($is_phar || self::locate($locate_core_phar) || self::locate($locate_core_dev_phar));

			// The error is actually displayed in the WordPress® Dashboard this way :-)
			if($class_file_basename === 'deps.php' && $has_phar && !self::can_phar() && defined('WPINC'))
				if(($class_path = self::cant_phar_msg_notice_in_wp_temp_deps()))
					return $class_path; // Temporary file.

			if($has_phar && !self::can_phar())
				throw new exception(self::cant_phar_msg());

			throw new exception(sprintf(self::__('Unable to locate: `%1$s`.'), $locate_core_dir.'/'.$relative_class_path));
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Routines that help handle webPhar instances.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * XDaRk Core webPhar rewriter.
		 *
		 * @param string $uri_or_path_info Passed in by webPhar.
		 *    The `$uri` is either `$_SERVER['REQUEST_URI']` or `$_SERVER['PATH_INFO']`.
		 *    See: {@link http://docs.php.net/manual/en/phar.webphar.php}.
		 *
		 * @note We ignore `$uri_or_path_info` from webPhar.
		 *    We determine this on our own; hopefully more effectively.
		 *
		 * @return string|boolean Boolean An internal URI; else FALSE if denying access.
		 *    A FALSE return value causes webPhar to issue a 403 forbidden response.
		 *
		 * @throws exception If this is NOT a PHAR file (which really should NOT happen).
		 * @throws exception If the PHAR extension is not possible for any reason.
		 */
		public static function web_phar_rewriter($uri_or_path_info)
		{
			// Current PHAR file w/stream prefix.

			$is_phar = $phar = self::n_dir_seps(self::is_phar());

			if(!$is_phar) // A couple of quick sanity checks.
				throw new exception(self::__('This is NOT a PHAR file.'));
			if(!self::can_phar()) throw new exception(self::cant_phar_msg());

			// Determine path info.

			if(!empty($_SERVER['PATH_INFO']))
				$path_info = (string)$_SERVER['PATH_INFO'];

			else if(function_exists('apache_lookup_uri') && !empty($_SERVER['REQUEST_URI']))
			{
				$_apache_lookup = apache_lookup_uri((string)$_SERVER['REQUEST_URI']);
				if(!empty($_apache_lookup->path_info))
					$path_info = (string)$_apache_lookup->path_info;
				unset($_apache_lookup); // Housekeeping.
			}
			$path_info = (!empty($path_info)) ? $path_info : '/'.basename(__FILE__);

			// Normalize directory separators; and force a leading slash on all internal URIs.
			// We allow a trailing slash; so it's easier to parse directory indexes.

			$internal_uri = self::n_dir_seps($path_info, TRUE);
			$internal_uri = '/'.ltrim($internal_uri, '/'); // Absolute (e.g. a URI).
			if(substr($internal_uri, -1) === '/') // Handle directory indexes.
				$internal_uri .= 'index.php';

			$internal_uri_basename  = basename($internal_uri);
			$internal_uri_extension = self::extension($internal_uri);

			// Here we'll try to make webPhar a little more security-conscious.

			if(strpos($internal_uri, '..') !== FALSE)
				return FALSE; // Do NOT allow relative dots; 403 (forbidden).

			if(strpos($internal_uri_basename, '.') === 0)
				return FALSE; // Do NOT serve DOT files; 403 (forbidden).

			if(substr($internal_uri_basename, -1) === '~')
				return FALSE; // Do NOT serve backups; 403 (forbidden).

			$phar_dir = self::n_dir_seps_up($phar); // We'll need this below.

			for($_i = 0, $_dir = self::n_dir_seps_up($phar.$internal_uri); $_i <= 100; $_i++)
			{
				if($_i > 0 && $_dir === $phar_dir)
					break; // Search complete now.

				if($_i > 0) // Up one directory now?
					$_dir = self::n_dir_seps_up($_dir, 1, TRUE);

				if(!$_dir || $_dir === '.' || substr($_dir, -1) === ':')
					break; // Search complete now.

				$_dir_basename = basename($_dir);

				if(strpos($_dir_basename, '.') === 0)
					return FALSE; // Dotted; 403 (forbidden).

				if(substr($_dir_basename, -1) === '~')
					return FALSE; // Backup dir; 403 (forbidden).

				if(strcasecmp($_dir_basename, 'app_data') === 0)
					return FALSE; // Private; 403 (forbidden).

				if(is_file($_dir.'/.htaccess')) // Options file exists here?
				{
					if(!is_readable($_dir.'/.htaccess'))
						return FALSE; // Unreadable; 403 (forbidden).

					if(stripos(file_get_contents($_dir.'/.htaccess'), 'require all denied') !== FALSE)
						return FALSE; // Private; 403 (forbidden).

					if(stripos(file_get_contents($_dir.'/.htaccess'), 'deny from all') !== FALSE)
						return FALSE; // Private; 403 (forbidden).

					if(stripos(file_get_contents($_dir.'/.htaccess'), 'require all granted') !== FALSE)
						break; // Break; this directory explicitly allows access.

					if(stripos(file_get_contents($_dir.'/.htaccess'), 'allow from all') !== FALSE)
						break; // Break; this directory explicitly allows access.
				}
				if(substr($_dir, -1) === '/') // Root directory or scheme?
					break; // Search complete (there is nothing more to search after this).
			}
			unset($_i, $_dir, $_dir_basename); // Housekeeping.

			// Process MIME-type headers.

			$mime_types           = self::mime_types();
			$cacheable_mime_types = self::cacheable_mime_types();

			if($internal_uri_extension && !empty($mime_types[$internal_uri_extension]))
				header('Content-Type: '.$mime_types[$internal_uri_extension]);

			// Handle cacheable MIME-types.

			if(!empty($cacheable_mime_types[$internal_uri_extension]))
			{
				header('Expires: '.gmdate('D, d M Y H:i:s', strtotime('+1 year')).' GMT');
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				header('Cache-Control: max-age='.(86400 * 365));
				header('Pragma: public');
			}
			return $internal_uri; // Final value (internal URI).
		}

		/**
		 * A map of MIME types (for webPhar).
		 *
		 * @return array A map of MIME types (for webPhar).
		 *    With flags for PHP execution & hiliting.
		 *
		 * @note Anything compressable needs to be parsed as PHP;
		 *    so webPhar will decompress it when serving.
		 *
		 * @note Source file extensions (i.e. code sample extensions);
		 *    are marked for automatic syntax hiliting by webPhar.
		 *
		 * @throws exception If PHAR extension not possible.
		 */
		public static function web_phar_mime_types()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			if(!self::can_phar()) // Not possible.
				throw new exception(self::cant_phar_msg());

			$mime_types = self::mime_types();

			foreach(self::compressable_mime_types() as $_extension => $_type)
				$mime_types[$_extension] = Phar::PHP;
			unset($_extension, $_type); // Housekeeping.

			$mime_types['phps'] = Phar::PHPS; // Source file.

			return (self::$static[__FUNCTION__] = $mime_types);
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# MIME-type routines.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Textual MIME types.
		 *
		 * @return array Textual MIME types.
		 *    Those with a `text/` MIME type or `charset=UTF-8` specification.
		 *
		 * @note Some files do NOT have a `text/` MIME type or `charset=UTF-8` specification.
		 *    However, they ARE still textual. Such as: `svg`, `bat`, `sh` files.
		 */
		public static function textual_mime_types()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			$other_textual_extensions = array('svg', 'bat', 'sh');

			foreach(($mime_types = self::mime_types()) as $_extension => $_type)
				if(stripos($_type, 'text/') === 0 ||
				   stripos($_type, 'charset=UTF-8') !== FALSE ||
				   in_array($_extension, $other_textual_extensions, TRUE)
				) continue; // It's textual in this case.
				else unset($mime_types[$_extension]);
			unset($_extension, $_type);

			return (self::$static[__FUNCTION__] = $mime_types);
		}

		/**
		 * Compressable MIME types.
		 *
		 * @return array Compressable MIME types.
		 *
		 * @note Any textual MIME type is compressable.
		 */
		public static function compressable_mime_types()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			$mime_types = self::textual_mime_types();

			return (self::$static[__FUNCTION__] = $mime_types);
		}

		/**
		 * Binary MIME types.
		 *
		 * @return array Binary MIME types.
		 *
		 * @note Any MIME type which is NOT textual; is considered binary.
		 */
		public static function binary_mime_types()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			$mime_types         = self::mime_types();
			$textual_mime_types = self::textual_mime_types();
			$mime_types         = array_diff_assoc($mime_types, $textual_mime_types);

			return (self::$static[__FUNCTION__] = $mime_types);
		}

		/**
		 * Cacheable extensions.
		 *
		 * @return array Those we make cacheable.
		 *
		 * @note Only dynamic files (like PHP scripts) are uncacheable.
		 */
		public static function cacheable_mime_types()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			$mime_types = self::mime_types();
			$m          =& $mime_types; // Shorter reference.

			// Remove dynamic scripts (NOT cacheable).
			unset($m['php'], $m['php4'], $m['php5'], $m['php6']);
			unset($m['asp'], $m['aspx']);
			unset($m['cgi'], $m['pl']);

			return (self::$static[__FUNCTION__] = $mime_types);
		}

		/**
		 * A map of MIME types (for headers).
		 *
		 * @return array A map of MIME types (for headers).
		 *
		 * @note This list is grouped logically according to the nature of certain files.
		 *    It is then ordered alphabetically within each group of files.
		 *
		 * @note This should always be synchronized with our `.gitattributes` file.
		 */
		public static function mime_types()
		{
			$utf8 = '; charset=UTF-8';

			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			return (self::$static[__FUNCTION__] = array(

				// Text files.
				'md'              => 'text/plain'.$utf8,
				'txt'             => 'text/plain'.$utf8,

				// Log files.
				'log'             => 'text/plain'.$utf8,

				// Translation files.
				'pot'             => 'text/plain'.$utf8,

				// SQL files.
				'sql'             => 'text/plain'.$utf8,
				'sqlite'          => 'text/plain'.$utf8,

				// Template files.
				'tmpl'            => 'text/plain'.$utf8,
				'tpl'             => 'text/plain'.$utf8,

				// Server config files.
				'admins'          => 'text/plain'.$utf8,
				'cfg'             => 'text/plain'.$utf8,
				'conf'            => 'text/plain'.$utf8,
				'htaccess'        => 'text/plain'.$utf8,
				'htaccess-apache' => 'text/plain'.$utf8,
				'htpasswd'        => 'text/plain'.$utf8,
				'ini'             => 'text/plain'.$utf8,

				// CSS/JavaScript files.
				'css'             => 'text/css'.$utf8,
				'js'              => 'application/x-javascript'.$utf8,
				'json'            => 'application/json'.$utf8,

				// PHP scripts/files.
				'inc'             => 'text/html'.$utf8,
				'php'             => 'text/html'.$utf8,
				'php4'            => 'text/html'.$utf8,
				'php5'            => 'text/html'.$utf8,
				'php6'            => 'text/html'.$utf8,
				'phps'            => 'text/html'.$utf8,
				'x-php'           => 'text/plain'.$utf8,
				'php~'            => 'text/plain'.$utf8,

				// ASP scripts/files.
				'asp'             => 'text/html'.$utf8,
				'aspx'            => 'text/html'.$utf8,

				// Perl scripts/files.
				'cgi'             => 'text/html'.$utf8,
				'pl'              => 'text/html'.$utf8,

				// HTML/XML files.
				'dtd'             => 'application/xml-dtd'.$utf8,
				'hta'             => 'application/hta'.$utf8,
				'htc'             => 'text/x-component'.$utf8,
				'htm'             => 'text/html'.$utf8,
				'html'            => 'text/html'.$utf8,
				'shtml'           => 'text/html'.$utf8,
				'xhtml'           => 'application/xhtml+xml'.$utf8,
				'xml'             => 'text/xml'.$utf8,
				'xsl'             => 'application/xslt+xml'.$utf8,
				'xslt'            => 'application/xslt+xml'.$utf8,
				'xsd'             => 'application/xsd+xml'.$utf8,

				// Document files.
				'csv'             => 'text/csv'.$utf8,
				'doc'             => 'application/msword',
				'docx'            => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'odt'             => 'application/vnd.oasis.opendocument.text',
				'pdf'             => 'application/pdf',
				'rtf'             => 'application/rtf',
				'xls'             => 'application/vnd.ms-excel',

				// Image/animation files.
				'ai'              => 'image/vnd.adobe.illustrator',
				'blend'           => 'application/x-blender',
				'bmp'             => 'image/bmp',
				'eps'             => 'image/eps',
				'fla'             => 'application/vnd.adobe.flash',
				'gif'             => 'image/gif',
				'ico'             => 'image/x-icon',
				'jpe'             => 'image/jpeg',
				'jpeg'            => 'image/jpeg',
				'jpg'             => 'image/jpeg',
				'png'             => 'image/png',
				'psd'             => 'image/vnd.adobe.photoshop',
				'pspimage'        => 'image/vnd.corel.psp',
				'svg'             => 'image/svg+xml',
				'swf'             => 'application/x-shockwave-flash',
				'tif'             => 'image/tiff',
				'tiff'            => 'image/tiff',

				// Audio files.
				'mid'             => 'audio/midi',
				'midi'            => 'audio/midi',
				'mp3'             => 'audio/mp3',
				'wav'             => 'audio/wav',
				'wma'             => 'audio/x-ms-wma',

				// Video files.
				'avi'             => 'video/avi',
				'flv'             => 'video/x-flv',
				'ogg'             => 'video/ogg',
				'ogv'             => 'video/ogg',
				'mp4'             => 'video/mp4',
				'mov'             => 'movie/quicktime',
				'mpg'             => 'video/mpeg',
				'mpeg'            => 'video/mpeg',
				'qt'              => 'video/quicktime',
				'webm'            => 'video/webm',
				'wmv'             => 'audio/x-ms-wmv',

				// Font files.
				'eot'             => 'application/vnd.ms-fontobject',
				'otf'             => 'application/x-font-otf',
				'ttf'             => 'application/x-font-ttf',
				'woff'            => 'application/x-font-woff',

				// Archive files.
				'7z'              => 'application/x-7z-compressed',
				'dmg'             => 'application/x-apple-diskimage',
				'gtar'            => 'application/x-gtar',
				'gz'              => 'application/gzip',
				'iso'             => 'application/iso-image',
				'jar'             => 'application/java-archive',
				'phar'            => 'application/php-archive',
				'rar'             => 'application/x-rar-compressed',
				'tar'             => 'application/x-tar',
				'tgz'             => 'application/x-gtar',
				'zip'             => 'application/zip',

				// Other misc files.
				'bat'             => 'application/octet-stream',
				'bin'             => 'application/octet-stream',
				'class'           => 'application/octet-stream',
				'com'             => 'application/octet-stream',
				'dll'             => 'application/octet-stream',
				'exe'             => 'application/octet-stream',
				'sh'              => 'application/octet-stream',
				'so'              => 'application/octet-stream'
			));
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Miscellaneous utility routines.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Dashes replace non-alphanumeric chars.
		 *
		 * @param string $string Any input string value.
		 *
		 * @return string Dashes replace non-alphanumeric chars.
		 *    Escape characters `\` are converted into double dashes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function with_dashes($string)
		{
			if(!is_string($string))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$string = str_replace('\\', '--', $string);
			return preg_replace('/[^a-z0-9]/i', '-', $string);
		}

		/**
		 * Underscores replace non-alphanumeric chars.
		 *
		 * @param string $string Any input string value.
		 *
		 * @return string Underscores replace non-alphanumeric chars.
		 *    Escape characters `\` are converted into double underscores.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function with_underscores($string)
		{
			if(!is_string($string))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$string = str_replace('\\', '__', $string);
			return preg_replace('/[^a-z0-9]/i', '_', $string);
		}

		/**
		 * Gets a directory/file extension (lowercase).
		 *
		 * @param string $dir_file A directory/file path.
		 *
		 * @return string Directory/file extension (lowercase).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function extension($dir_file)
		{
			if(!is_string($dir_file) || !$dir_file)
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			return strtolower(ltrim((string)strrchr(basename($dir_file), '.'), '.'));
		}

		/**
		 * Determines a file's MIME type.
		 *
		 * @param string $file A file path.
		 *
		 * @param string $default_mime_type Defaults to `application/octet-stream`.
		 *    This can be passed as an empty string to make it easier to test for a failure here.
		 *
		 * @return string File's MIME type; else `$default_mime_type` value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function mime_type($file, $default_mime_type = 'application/octet-stream')
		{
			if(!is_string($file) || !$file || !is_string($default_mime_type))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$mime_types = self::mime_types();
			$extension  = self::extension($file);

			if($extension && !empty($mime_types[$extension]))
				return $mime_types[$extension];

			return $default_mime_type;
		}

		/**
		 * Attempts to find a readable/writable temporary directory.
		 *
		 * @return string Readable/writable temp directory; else an empty string.
		 *
		 * @throws exception If unable to find a readable/writable directory.
		 */
		public static function get_temp_dir()
		{
			if(defined('WPINC') && ($wp_temp_dir = get_temp_dir()) && is_string($wp_temp_dir))
				if(($wp_temp_dir = realpath($wp_temp_dir)) && is_readable($wp_temp_dir) && is_writable($wp_temp_dir))
					return self::n_dir_seps($wp_temp_dir);

			if(($sys_temp_dir = sys_get_temp_dir()) && is_string($sys_temp_dir))
				if(($sys_temp_dir = realpath($sys_temp_dir)) && is_readable($sys_temp_dir) && is_writable($sys_temp_dir))
					return self::n_dir_seps($sys_temp_dir);

			if(($upload_tmp_dir = ini_get('upload_tmp_dir')) && is_string($upload_tmp_dir))
				if(($upload_tmp_dir = realpath($upload_tmp_dir)) && is_readable($upload_tmp_dir) && is_writable($upload_tmp_dir))
					return self::n_dir_seps($upload_tmp_dir);

			if(!empty($_SERVER['TEMP']) && ($server_temp_dir = $_SERVER['TEMP']) && is_string($server_temp_dir))
				if(($server_temp_dir = realpath($server_temp_dir)) && is_readable($server_temp_dir) && is_writable($server_temp_dir))
					return self::n_dir_seps($server_temp_dir);

			if(!empty($_SERVER['TMPDIR']) && ($server_tmpdir_dir = $_SERVER['TMPDIR']) && is_string($server_tmpdir_dir))
				if(($server_tmpdir_dir = realpath($server_tmpdir_dir)) && is_readable($server_tmpdir_dir) && is_writable($server_tmpdir_dir))
					return self::n_dir_seps($server_tmpdir_dir);

			if(!empty($_SERVER['TMP']) && ($server_tmp_dir = $_SERVER['TMP']) && is_string($server_tmp_dir))
				if(($server_tmp_dir = realpath($server_tmp_dir)) && is_readable($server_tmp_dir) && is_writable($server_tmp_dir))
					return self::n_dir_seps($server_tmp_dir);

			if(stripos(PHP_OS, 'win') === 0 && (is_dir('C:/Temp') || @mkdir('C:/Temp', 0777)))
				if(is_readable('C:/Temp') && is_writable('C:/Temp'))
					return self::n_dir_seps('C:/Temp');

			if(stripos(PHP_OS, 'win') !== 0 && (is_dir('/tmp') || @mkdir('/tmp', 0777)))
				if(is_readable('/tmp') && is_writable('/tmp'))
					return self::n_dir_seps('/tmp');

			throw new exception(self::__('Unable to find a readable/writable temp directory.'));
		}

		/**
		 * Normalizes directory/file separators.
		 *
		 * @param string  $dir_file Directory/file path.
		 *
		 * @param boolean $allow_trailing_slash Defaults to FALSE.
		 *    If TRUE; and `$dir_file` contains a trailing slash; we'll leave it there.
		 *
		 * @return string Normalized directory/file path.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function n_dir_seps($dir_file, $allow_trailing_slash = FALSE)
		{
			if(!is_string($dir_file) || !is_bool($allow_trailing_slash))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			if(!isset($dir_file[0])) return ''; // Catch empty string.

			if(strpos($dir_file, '://' !== FALSE)) // Quick check here for optimization.
			{
				if(!isset(self::$static[__FUNCTION__.'__regex_stream_wrapper']))
					self::$static[__FUNCTION__.'__regex_stream_wrapper'] = substr(self::$regex_valid_dir_file_stream_wrapper, 0, -2).'/';
				if(preg_match(self::$static[__FUNCTION__.'__regex_stream_wrapper'], $dir_file, $stream_wrapper)) // A stream wrapper?
					$dir_file = preg_replace(self::$static[__FUNCTION__.'__regex_stream_wrapper'], '', $dir_file);
			}
			if(strpos($dir_file, ':' !== FALSE)) // Quick drive letter check here for optimization.
			{
				if(!isset(self::$static[__FUNCTION__.'__regex_win_drive_letter']))
					self::$static[__FUNCTION__.'__regex_win_drive_letter'] = substr(self::$regex_valid_win_drive_letter, 0, -2).'/';
				if(preg_match(self::$static[__FUNCTION__.'__regex_win_drive_letter'], $dir_file)) // It has a Windows® drive letter?
					$dir_file = preg_replace_callback(self::$static[__FUNCTION__.'__regex_win_drive_letter'], create_function('$m', 'return strtoupper($m[0]);'), $dir_file);
			}
			$dir_file = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $dir_file));
			$dir_file = ($allow_trailing_slash) ? $dir_file : rtrim($dir_file, '/'); // Strip trailing slashes.

			if(!empty($stream_wrapper[0])) // Stream wrapper (force lowercase).
				$dir_file = strtolower($stream_wrapper[0]).$dir_file;

			return $dir_file; // Normalized now.
		}

		/**
		 * Normalizes directory/file separators (up X directories).
		 *
		 * @param string  $dir_file A directory/file path.
		 *
		 * @param integer $up Optional. Defaults to a value of `1`.
		 *    Number of directories to move up.
		 *
		 * @param boolean $allow_trailing_slash Defaults to FALSE.
		 *    If TRUE; and `$dir_file` contains a trailing slash; we'll leave it there.
		 *
		 * @return string Up one directory (normalized directory/file separators).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function n_dir_seps_up($dir_file, $up = 1, $allow_trailing_slash = FALSE)
		{
			if(!is_string($dir_file) || !is_integer($up) || !is_bool($allow_trailing_slash))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			if(!isset($dir_file[0])) return ''; // Catch empty string.

			$had_trailing_slash = in_array(substr($dir_file, -1), array(DIRECTORY_SEPARATOR, '\\', '/'), TRUE);

			for($_i = 0; $_i < abs($up); $_i++)
				$dir_file = dirname($dir_file);
			unset($_i); // Housekeeping.

			if($had_trailing_slash) $dir_file .= '/';

			return self::n_dir_seps($dir_file, $allow_trailing_slash);
		}

		/**
		 * Locates a specific directory/file (by relative path).
		 *
		 * @param string $dir_file A specific directory/file (w/ a relative path).
		 *
		 * @param string $starting_dir Optional. A specific directory to start searching from.
		 *     Defaults to the string `'__DIR__'` for PHP v5.2 compatibility (explained in further detail below).
		 *
		 *    There are TWO special string values that are translated by this routine.
		 *
		 *    • The `__DIR__` constant is NOT PHP v5.2 compatible; so you can use a string value to achieve this.
		 *       The string `'__DIR__'` translates to the directory of this file; e.g. `dirname(__FILE__)`.
		 *
		 *    • Or, it is ALSO possible to specify `phar://` or `phar://__DIR__` in this parameter.
		 *       The strings `phar://` and `phar://__DIR__` both translate to `dirname(__FILE__)` with a forced PHAR stream wrapper.
		 *
		 * @return string Directory/file path (if found); else an empty string.
		 *    The search will continue until there are no more directories to search through.
		 *    However, there is an upper limit of 100 directories maximum.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` or `$starting_dir` are empty.
		 */
		public static function locate($dir_file, $starting_dir = '__DIR__' /* PHP v5.2 compatibility. */)
		{
			if(!is_string($dir_file) || !$dir_file || !is_string($starting_dir) || !$starting_dir)
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$dir_file = ltrim(self::n_dir_seps($dir_file), '/'); // Relative.

			if($starting_dir === '__DIR__') // Using this for PHP v5.2 compatibility.
				$starting_dir = self::n_dir_seps_up(__FILE__); // Current directory.

			else if(in_array($starting_dir, array('phar://', 'phar://__DIR__'), TRUE)) // With a PHAR stream wrapper?
				$starting_dir = 'phar://'.preg_replace(substr(self::$regex_valid_dir_file_stream_wrapper, 0, -2).'/', '', self::n_dir_seps_up(__FILE__));

			for($_i = 0, $_dir = self::n_dir_seps($starting_dir); $_i <= 100; $_i++)
			{
				if($_i > 0) // Up one directory now?
					$_dir = self::n_dir_seps_up($_dir, 1, TRUE);

				if(!$_dir || $_dir === '.' || substr($_dir, -1) === ':')
					break; // Search complete (we're beyond even a root directory or scheme now).

				if(file_exists($_dir.'/'.$dir_file))
					return self::n_dir_seps($_dir.'/'.$dir_file);

				if(substr($_dir, -1) === '/') // Root directory or scheme?
					break; // Search complete (there is nothing more to search after this).
			}
			unset($_i, $_dir); // Housekeeping.

			return ''; // Failure.
		}

		/**
		 * Is the current User-Agent a browser?
		 * This checks only for the most common browser engines.
		 *
		 * @return boolean TRUE if the current User-Agent is a browser.
		 */
		public static function is_browser()
		{
			if(isset(self::$static[__FUNCTION__]))
				return self::$static[__FUNCTION__];

			self::$static[__FUNCTION__] = FALSE;

			$regex = '/(?:msie|trident|gecko|webkit|presto|konqueror|playstation)[\/\s]+[0-9]/i';
			if(!empty($_SERVER['HTTP_USER_AGENT']) && is_string($_SERVER['HTTP_USER_AGENT']))
				if(preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
					self::$static[__FUNCTION__] = TRUE;

			return self::$static[__FUNCTION__];
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Dynamic error messages.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Regarding an inability to locate `/wp-load.php`.
		 *
		 * @param boolean $markdown Defaults to a FALSE value.
		 *    If this is TRUE; we'll parse some basic markdown syntax to
		 *    produce HTML output that is easier to read in a browser.
		 *
		 * @return string Error message w/ details about the `/wp-load.php` file.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public static function no_wp_msg($markdown = FALSE)
		{
			if(!is_bool($markdown))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			$msg = sprintf(self::__('Unable to load the %1$s. WordPress® (a core dependency) is NOT loaded up yet.'.
			                        ' Please include WordPress® in your scripts using: `require_once \'wp-load.php\';`.'), self::$core_name);

			if($markdown) $msg = nl2br(preg_replace('/`(.*?)`/', '<code>'.'${1}'.'</code>', $msg), TRUE);

			return $msg; // Final message.
		}

		/**
		 * Regarding a lack of support for Php Archives.
		 *
		 * @param boolean $markdown Defaults to a FALSE value.
		 *    If this is TRUE; we'll parse some basic markdown syntax to
		 *    produce HTML output that is easier to read in a browser.
		 *
		 * @see cant_phar_msg_notice_in_wp_temp_deps()
		 *
		 * @return string Error message w/ details about the `Phar` class and PHP v5.3+.
		 *    This error message will also include details about Suhosin; when/if applicable.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If an inappropriate call is made (really should NOT happen).
		 */
		public static function cant_phar_msg($markdown = FALSE)
		{
			if(!is_bool($markdown))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf(self::__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
			if(self::can_phar())
				throw new exception( // Fail here; we should NOT have called this.
					sprintf(self::__('Inappropriate call to: `%1$s`'), __METHOD__)
				);
			$msg = sprintf(self::__('Unable to load the %1$s. This installation of PHP is missing the `Phar` extension.'.
			                        ' The %1$s (and WordPress® plugins powered by it); requires PHP v5.3+ — which has `Phar` built-in.'.
			                        ' Please upgrade to PHP v5.3 (or higher) to get rid of this message.'), self::$core_name);

			$can_phar              = extension_loaded('phar');
			$suhosin_running       = extension_loaded('suhosin');
			$suhosin_blocking_phar = ($suhosin_running && stripos(ini_get('suhosin.executor.include.whitelist'), 'phar') === FALSE);

			if($suhosin_running && $suhosin_blocking_phar) // Be verbose.
			{
				$verbose = ($can_phar) ? self::__('THE PROBLEM') : self::__('ALSO');
				$msg .= "\n\n".sprintf(self::__('%1$s: On your installation the `Phar` extension needs to be ENABLED by adding'.
				                                ' the following line to your `php.ini` file: `suhosin.executor.include.whitelist = phar`.'.
				                                ' If you need assistance, please contact your hosting company about this message.'), $verbose);
			}
			if($markdown) $msg = nl2br(preg_replace('/`(.*?)`/', '<code>'.'${1}'.'</code>', $msg), TRUE);

			return $msg; // Final message.
		}

		/**
		 * Regarding a lack of support for PHP Archives.
		 *
		 * Creates a temporary deps class & returns absolute path to that class file.
		 *    This can ONLY be used if we're within WordPress®; because it attaches
		 *    itself to a WordPress® administrative notice.
		 *
		 * @return string Absolute path to temporary deps; else an empty string if NOT possible.
		 *
		 * @throws exception If an inappropriate call is made (really should NOT happen).
		 *
		 * @see $wp_temp_deps
		 * @see cant_phar_msg()
		 */
		public static function cant_phar_msg_notice_in_wp_temp_deps()
		{
			if(!defined('WPINC') || self::can_phar())
				throw new exception( // Fail here; we should NOT have called this.
					sprintf(self::__('Inappropriate call to: `%1$s`'), __METHOD__)
				);
			$temp_deps          = self::get_temp_dir().'/wp-temp-deps.tmp';
			$temp_deps_contents = base64_decode(self::$wp_temp_deps); // This uses version `141226_dev`.
			$temp_deps_contents = str_ireplace(self::$core_ns_stub_v.'141226_dev', self::$core_ns, $temp_deps_contents);
			$temp_deps_contents = str_ireplace('%%notice%%', str_replace("'", "\\'", self::cant_phar_msg(TRUE)), $temp_deps_contents);

			if(!is_file($temp_deps) || (is_writable($temp_deps) && unlink($temp_deps)))
				if(file_put_contents($temp_deps, $temp_deps_contents))
					return $temp_deps;

			return ''; // Failure.
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Translation routines.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Handles core translations for this class (context: admin-side).
		 *
		 * @param string $string String to translate.
		 *
		 * @return string Translated string.
		 */
		public static function __($string)
		{
			$string  = (string)$string; // Typecasting this to a string value.
			$context = self::$core_ns_stub_with_dashes.'--admin-side'; // Admin side.

			return (defined('WPINC')) ? _x($string, $context, self::$core_ns_stub_with_dashes) : $string;
		}

		/**
		 * Handles core translations for this class (context: front-side).
		 *
		 * @param string $string String to translate.
		 *
		 * @param string $other_contextuals Optional. Other contextual slugs relevant to this translation.
		 *    Contextual slugs normally follow the standard of being written with dashes.
		 *
		 * @return string Translated string.
		 */
		public static function _x($string, $other_contextuals = '')
		{
			$string            = (string)$string; // Typecasting this to a string value.
			$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
			$context           = self::$core_ns_stub_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

			return (defined('WPINC')) ? _x($string, $context, self::$core_ns_stub_with_dashes) : $string;
		}

		# --------------------------------------------------------------------------------------------------------------------------------
		# Additional properties (see also: top of this file).
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * Regarding a lack of support for Php Archives.
		 *
		 * XDaRk temporary WP deps class (base64 encoded).
		 *
		 * @var string Base64 encoded version of `/includes/deps.tmp` in XDaRk Core.
		 *
		 * @see cant_phar_msg_notice_in_wp_temp_deps()
		 */
		public static $wp_temp_deps = 'PD9waHAKaWYoIWRlZmluZWQoJ1dQSU5DJykpCglleGl0KCdEbyBOT1QgYWNjZXNzIHRoaXMgZmlsZSBkaXJlY3RseTogJy5iYXNlbmFtZShfX0ZJTEVfXykpOwoKaWYoIWNsYXNzX2V4aXN0cygnZGVwc193c2NfdjAwMDAwMF9kZXYnKSkKewoJZmluYWwgY2xhc3MgZGVwc193c2NfdjAwMDAwMF9kZXYKCXsKCQlwdWJsaWMgZnVuY3Rpb24gY2hlY2soJHBsdWdpbl9uYW1lID0gJycpCgkJewoJCQlpZighaXNfYWRtaW4oKSB8fCAhY3VycmVudF91c2VyX2NhbignaW5zdGFsbF9wbHVnaW5zJykpCgkJCQlyZXR1cm4gRkFMU0U7IC8vIE5vdGhpbmcgdG8gZG8gaGVyZS4KCgkJCSRub3RpY2UgPSAnPGRpdiBjbGFzcz0iZXJyb3IgZmFkZSI+JzsKCQkJJG5vdGljZSAuPSAnPHA+JzsKCgkJCSRub3RpY2UgLj0gKCRwbHVnaW5fbmFtZSkgPwoJCQkJJ1JlZ2FyZGluZyA8c3Ryb25nPicuZXNjX2h0bWwoJHBsdWdpbl9uYW1lKS4nOjwvc3Ryb25nPicuCgkJCQknJm5ic3A7Jm5ic3A7Jm5ic3A7JyA6ICcnOwoKCQkJJG5vdGljZSAuPSAnJSVub3RpY2UlJSc7CgoJCQkkbm90aWNlIC49ICc8L3A+JzsKCQkJJG5vdGljZSAuPSAnPC9kaXY+JzsKCgkJCWFkZF9hY3Rpb24oJ2FsbF9hZG1pbl9ub3RpY2VzJywgLy8gTm90aWZ5IGluIGFsbCBhZG1pbiBub3RpY2VzLgoJCQkgICAgICAgICAgIGNyZWF0ZV9mdW5jdGlvbignJywgJ2VjaG8gXCcnLnN0cl9yZXBsYWNlKCInIiwgIlxcJyIsICRub3RpY2UpLidcJzsnKSk7CgoJCQlyZXR1cm4gRkFMU0U7IC8vIEFsd2F5cyByZXR1cm4gYSBGQUxTRSB2YWx1ZSBpbiB0aGlzIHNjZW5hcmlvLgoJCX0KCX0KfQ==';

		# --------------------------------------------------------------------------------------------------------------------------------
		# Regex pattern properties.
		# --------------------------------------------------------------------------------------------------------------------------------

		/**
		 * PHP userland validation pattern.
		 *
		 * @var string PHP userland validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. MUST adhere to {@link http://php.net/manual/en/userlandnaming.php PHP Userland guidelines}.
		 *
		 * @see http://php.net/manual/en/userlandnaming.php
		 */
		public static $regex_valid_userland_name = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

		/**
		 * @var string XDaRk Core namespace (w/ version) validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics and/or underscores `_` only.
		 *       2. MUST start with: {@link $core_ns_stub_v} (with underscores).
		 *       3. MUST end with a plugin version string (with underscores).
		 *          See: {@link $regex_valid_plugin_version}
		 *
		 * @see initialize()
		 * @see $core_ns_stub_v
		 * @see $regex_valid_plugin_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_core_ns_version = '/^%%self::$core_ns_stub_v%%[0-9]{6}(?:_(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))?(?:_(?:[0-9](?:[a-z0-9]|_(?!_))*[a-z0-9]|[0-9]))?$/';

		/**
		 * @var string XDaRk Core namespace (w/ version) validation pattern (dashed variation).
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics and/or dashes `-` only.
		 *       2. MUST start with {@link $core_ns_stub_v_with_dashes} (with dashes).
		 *       3. MUST end with a plugin version string (with dashes).
		 *          See: {@link $regex_valid_plugin_version}
		 *
		 * @see initialize()
		 * @see $core_ns_stub_v_with_dashes
		 * @see $regex_valid_plugin_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_core_ns_version_with_dashes = '/^%%self::$core_ns_stub_v_with_dashes%%[0-9]{6}(?:\-(?:[a-z](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[a-z]))?(?:\-(?:[0-9](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[0-9]))?$/';

		/**
		 * @var string Plugin root namespace validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics and/or underscores `_` only.
		 *       2. CANNOT start or end with an underscore `_`.
		 *       3. MUST start with a letter `[a-z]`.
		 *       4. No double underscores `__`.
		 */
		public static $regex_valid_plugin_root_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

		/**
		 * @var string Plugin variable namespace validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics and/or underscores `_` only.
		 *       2. CANNOT start or end with an underscore `_`.
		 *       3. MUST start with a letter `[a-z]`.
		 *       4. No double underscores `__`.
		 */
		public static $regex_valid_plugin_var_ns = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

		/**
		 * @var string Plugin capability validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics and/or underscores `_` only.
		 *       2. CANNOT start or end with an underscore `_`.
		 *       3. MUST start with a letter `[a-z]`.
		 *       4. No double underscores `__`.
		 */
		public static $regex_valid_plugin_cap = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])$/';

		/**
		 * @var string Plugin namespace\class path validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics, underscores `_`, and/or namespace `\` separators only.
		 *       2. MUST contain at least one namespace separator `\` (i.e. it MUST be within a namespace).
		 *       3. A path element CANNOT start or end with an underscore `_`.
		 *       4. Each path element MUST start with a letter `[a-z]`.
		 *       5. No double underscores `__` in any path element.
		 */
		public static $regex_valid_plugin_ns_class = '/^(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z])(?:\\\\(?:[a-z](?:[a-z0-9]|_(?!_))*[a-z0-9]|[a-z]))+$/';

		/**
		 * @var string Plugin version string validation pattern.
		 *    This has additional limitations (but still compatible w/ PHP version strings).
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Lowercase alphanumerics, dashes `-`, and/or pluses `+` only.
		 *       2. MUST be compatible with file names on both Windows® and Unix operating systems.
		 *       3. MUST start with 6 digits (i.e. `YYMMDD` — normally a dated version).
		 *       4. An optional development state suffix is allowed (MUST start w/ a dash `-`; followed by a letter `[a-z]`).
		 *       5. An optional build suffix is allowed (MUST start w/ a plus `+` sign; followed by a numeric value `[0-9]`).
		 *       6. A plus `+` sign is allowed only ONE time (use this ONLY to specify a build suffix).
		 *       7. MUST always end with an alphanumeric value `[a-z0-9]`.
		 *       8. May NOT contain any double dashes `--`.
		 *
		 * @see $regex_valid_plugin_dev_version
		 * @see $regex_valid_plugin_stable_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_plugin_version = '/^[0-9]{6}(?:\-(?:[a-z](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[a-z]))?(?:\+(?:[0-9](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[0-9]))?$/';

		/**
		 * @var string Plugin dev version string validation pattern.
		 *    This has additional limitations (but still compatible w/ PHP dev version strings).
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. MUST adhere to {@link $regex_valid_plugin_version} guidelines.
		 *       2. MUST end with a development state suffix; perhaps followed by an optional build suffix.
		 *
		 * @see $regex_valid_plugin_version
		 * @see $regex_valid_plugin_stable_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_plugin_dev_version = '/^[0-9]{6}(?:\-(?:[a-z](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[a-z]))(?:\+(?:[0-9](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[0-9]))?$/';

		/**
		 * @var string Plugin stable version string validation pattern.
		 *    This has additional limitations (but still compatible w/ PHP stable version strings).
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. MUST adhere to {@link $regex_valid_plugin_version} guidelines.
		 *       2. It may NOT contain a development state suffix (indicating it's a stable version).
		 *             However, it MAY contain an optional build suffix; and still be stable.
		 *
		 * @see $regex_valid_plugin_version
		 * @see $regex_valid_plugin_dev_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_plugin_stable_version = '/^[0-9]{6}(?:\+(?:[0-9](?:[a-z0-9]|\-(?!\-))*[a-z0-9]|[0-9]))?$/';

		/**
		 * @var string PHP version string validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Must follow {@link http://semver.org semantic versioning guidelines}.
		 *       2. MUST be compatible with file names on both Windows® and Unix operating systems.
		 *
		 * @see $regex_valid_dev_version
		 * @see $regex_valid_stable_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_version = '/^(?:[0-9](?:[0-9]|\.(?!\.))*[0-9]|[0-9])(?:\-?(?:[a-zA-Z0-9](?:[a-zA-Z0-9]|[.\-](?![.\-]))*[a-zA-Z0-9]|[a-zA-Z0-9]))?(?:\+(?:[a-zA-Z0-9](?:[a-zA-Z0-9]|[.\-](?![.\-]))*[a-zA-Z0-9]|[a-zA-Z0-9]))?$/';

		/**
		 * @var string PHP dev version string validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Must follow {@link http://semver.org semantic versioning guidelines}.
		 *       2. MUST end with a development state suffix; perhaps followed by an optional build suffix.
		 *
		 * @see $regex_valid_version
		 * @see $regex_valid_stable_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_dev_version = '/^(?:[0-9](?:[0-9]|\.(?!\.))*[0-9]|[0-9])(?:\-?(?:[a-zA-Z0-9](?:[a-zA-Z0-9]|[.\-](?![.\-]))*[a-zA-Z0-9]|[a-zA-Z0-9]))(?:\+(?:[a-zA-Z0-9](?:[a-zA-Z0-9]|[.\-](?![.\-]))*[a-zA-Z0-9]|[a-zA-Z0-9]))?$/';

		/**
		 * @var string PHP stable version string validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Must follow {@link http://semver.org semantic versioning guidelines}.
		 *       2. May NOT contain a development state suffix (indicating it's a stable version).
		 *             However, it MAY contain an optional build suffix; and still be stable.
		 *
		 * @see $regex_valid_version
		 * @see $regex_valid_dev_version
		 * @see http://php.net/manual/en/function.version-compare.php
		 * @see http://semver.org
		 */
		public static $regex_valid_stable_version = '/^(?:[0-9](?:[0-9]|\.(?!\.))*[0-9]|[0-9])(?:\+(?:[a-zA-Z0-9](?:[a-zA-Z0-9]|[.\-](?![.\-]))*[a-zA-Z0-9]|[a-zA-Z0-9]))?$/';

		/**
		 * @var string A directory/file stream wrapper validation pattern.
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Must follow {@link http://php.net/manual/en/wrappers.php.php PHP guidelines}.
		 *
		 * @see http://php.net/manual/en/wrappers.php.php
		 */
		public static $regex_valid_dir_file_stream_wrapper = '/^(?P<stream_wrapper>[a-zA-Z0-9]+)\:\/\/$/';

		/**
		 * @var string A directory/file drive letter validation pattern (for Windows®).
		 *
		 * @note Requirements are as follows:
		 *
		 *       1. Must follow {@link http://en.wikipedia.org/wiki/Drive_letter_assignment Windows® guidelines}.
		 *
		 * @see http://en.wikipedia.org/wiki/Drive_letter_assignment
		 */
		public static $regex_valid_win_drive_letter = '/^(?P<drive_letter>[a-zA-Z])\:[\/\\\\]$/';
	}

	# -----------------------------------------------------------------------------------------------------------------------------------
	# Initialize the XDaRk Core stub.
	# -----------------------------------------------------------------------------------------------------------------------------------

	xd_v141226_dev::initialize(); // Also creates class alias.
}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Inline webPhar handler.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * A XDaRk Core webPhar instance?
 * This serves files straight from a PHP Archive.
 */
if(xd_v141226_dev::is_webphar())
{
	unset($GLOBALS[xd_v141226_dev::autoload_var()]);

	if(!xd_v141226_dev::can_phar())
		throw new exception(xd_v141226_dev::cant_phar_msg());

	Phar::webPhar('xd-v141226-dev', 'index.php', '',
	              xd_v141226_dev::web_phar_mime_types(),
	              'xd_v141226_dev::web_phar_rewriter');

	return; // We can stop here.
}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Inline autoload handler.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * A XDaRk Core autoload instance?
 * On by default (disable w/ global var as necessary).
 */
if(xd_v141226_dev::is_autoload())
{
	unset($GLOBALS[xd_v141226_dev::autoload_var()]);

	if(!defined('WPINC') && !xd_v141226_dev::wp_load())
		throw new exception(xd_v141226_dev::no_wp_msg());

	if(!defined('WPINC')) // Need to load WordPress?
		require_once xd_v141226_dev::wp_load(TRUE);

	if(!class_exists('deps_xd_v141226_dev'))
		require_once xd_v141226_dev::deps(FALSE);

	if(!class_exists('\\xd_v141226_dev\\framework'))
		require_once xd_v141226_dev::framework();

	return; // We can stop here.
}
# -----------------------------------------------------------------------------------------------------------------------------------------
# Default inline handlers.
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * Always unset XDaRk Core autoload var.
 */
unset($GLOBALS[xd_v141226_dev::autoload_var()]);
/*
 * The XDaRk Core is in WordPress?
 * If we're in WordPress®; it is NOT direct access.
 */
if(defined('WPINC')) return; // We can stop here.
/*
 * WordPress® is NOT loaded up in this scenario.
 * By default, we disallow direct file access.
 */
exit('Do NOT access this file directly: '.basename(__FILE__));