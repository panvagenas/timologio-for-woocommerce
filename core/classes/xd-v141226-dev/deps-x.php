<?php
/**
 * Extended Dependency Utilities.
 *
 * @note MUST remain PHP v5.2 compatible.
 * @note Replicates into `[...-]stand-alone.php`.
 * @note Class name MUST be modified before running stand-alone.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# WordPress® MUST be loaded up (unless we're in stand-alone mode).
# -----------------------------------------------------------------------------------------------------------------------------------------

global ${__FILE__}; // Make sure this IS a global var.

${__FILE__}['is_in_stand_alone_mode'] = // Are we in stand-alone mode?
	(class_exists('deps_x_stand_alone_xd_v141226_dev') && basename(__FILE__) !== 'deps-x.php'
	 && !empty($_SERVER['SCRIPT_FILENAME']) && is_string($_SERVER['SCRIPT_FILENAME'])
	 && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__));

if(!defined('WPINC') && !${__FILE__}['is_in_stand_alone_mode']) // Disallow direct access?
	exit('Do NOT access this file directly: '.basename(__FILE__));

# -----------------------------------------------------------------------------------------------------------------------------------------
# Definitions for extended dependency utilities.
# -----------------------------------------------------------------------------------------------------------------------------------------
/**
 * Extended Dependency Utilities.
 *
 * @note MUST remain PHP v5.2 compatible.
 * @note Replicates into `[...-]stand-alone.php`.
 * @note Class name MUST be modified before running stand-alone.
 *
 * @package XDaRk\Core
 * @since 120318
 */
final class deps_x_xd_v141226_dev #!stand-alone!# // MUST remain PHP v5.2 compatible.
{
	# --------------------------------------------------------------------------------------------------------------------------------------
	# Public properties.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Holds `check()` method return value.
	 *
	 * @var array|boolean|null Defaults to a NULL value.
	 */
	public $check; // Defaults to a NULL value.

	/**
	 * Default plugin name to use.
	 *
	 * @var string A generic default value.
	 */
	public $default_plugin_name = 'XDaRk Core';

	/**
	 * Default plugin directory names (comma-delimited).
	 *
	 * @var string A generic default value.
	 */
	public $default_plugin_dir_names = 'xd-v141226-dev';

	/**
	 * Holds original arguments to `check()`.
	 *
	 * @note This helps auto-fix routines, which need additional functionality.
	 *
	 * @var array Original arguments to `check()`.
	 */
	public $auto_fix_orig_check_args = array();

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Protected properties.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Local WordPress® development directory.
	 *
	 * @var string Local WordPress® development directory.
	 *
	 * @note For internal/development use only.
	 */
	protected static $local_wp_dev_dir = '%%$_SERVER[WEBSHARK_HOME]%%/Apache/wordpress.loc';

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

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Static initializer (see also: bottom of this file).
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Static initializer; this runs ONE time only.
	 *
	 * @return boolean Returns the `$initialized` property w/ a TRUE value.
	 *
	 * @throws exception If attempting to run this from a root directory.
	 */
	public static function initialize()
	{
		if(self::$initialized)
			return TRUE; // Initialized already.
		/*
		 * Handle some dynamic regex replacement codes in class properties (as follows).
		 */
		$webshark_home_dir      = (!empty($_SERVER['WEBSHARK_HOME'])) ? (string)$_SERVER['WEBSHARK_HOME'] : '/webshark/home';
		self::$local_wp_dev_dir = str_replace('%%$_SERVER[WEBSHARK_HOME]%%', $webshark_home_dir, self::$local_wp_dev_dir);

		/*
		 * Easier access for those who DON'T CARE about the version (PHP v5.3+ only).
		 */
		if(!$GLOBALS[__FILE__]['is_in_stand_alone_mode'] && !class_exists('xd__deps_x') && function_exists('class_alias'))
			class_alias('deps_x_xd_v141226_dev', 'xd__deps_x');

		if($GLOBALS[__FILE__]['is_in_stand_alone_mode'] && !class_exists('xd__deps_x_stand_alone') && function_exists('class_alias'))
			class_alias('deps_x_stand_alone_xd_v141226_dev', 'xd__deps_x_stand_alone');

		return (self::$initialized = TRUE);
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Main method (this is what we'll be calling upon — for the most part).
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Checks if all XDaRk Core dependencies can be satisfied completely.
	 * This runs a deep scan to identify common problems/conflicts/issues.
	 * It also returns details regarding tests that passed successfully.
	 *
	 * @param string  $plugin_name If empty, defaults to a generic value.
	 *    Name of the plugin that's checking dependencies;
	 *    i.e. the plugin that called this routine.
	 *
	 * @param string  $plugin_dir_names If empty, defaults to a generic value.
	 *    Name of one or more (comma-delimited) plugin directories associated with dependency scans;
	 *    i.e. directories associated with the plugin that called this routine.
	 *
	 * @param boolean $report_notices TRUE by default.
	 *    If FALSE, do NOT report any notices.
	 *
	 * @param boolean $report_warnings TRUE by default.
	 *    If FALSE, do NOT report warnings.
	 *
	 * @param boolean $check_last_ok TRUE by default. Avoids a re-scan if at all possible.
	 *    If `$check_last_ok` is FALSE, it will always force a new full scan.
	 *    Automatically disabled when running in any stand-alone file
	 *    as class: `deps_x_stand_alone_xd_v141226_dev`.
	 *
	 * @param boolean $maybe_display_wp_admin_notices TRUE by default. Applies only when running within WordPress.
	 *    If there are issues, we'll automatically enqueue administrative notices to alert the site owner.
	 *    Automatically disabled when running in any stand-alone file
	 *    as class: `deps_x_stand_alone_xd_v141226_dev`.
	 *
	 * @return boolean|array TRUE if no `issues`.
	 *    If there ARE `issues`, this returns a multidimensional array (which is NEVER empty).
	 *    A possible FALSE return value (initially), if an auto-fix is being requested by the site owner.
	 *    A possible FALSE return value, if invalid types are passed through arguments list.
	 *
	 * @auto-fix A possible FALSE return value, if an auto-fix is being requested (at least, initially).
	 *    If an auto-fix is requested, we check to see if WordPress® is loaded up, and if the `init` hook has been fired yet.
	 *    If it has NOT been fired yet, we return FALSE (initially). Then we run this routine again on the `init` hook, with a priority of `1`.
	 *    This allows auto-fix routines to check permissions and perform other important tasks; with the use of all WordPress® functionality.
	 *
	 * @note The return value of this function depends heavily on the parameters used to call upon it.
	 *    If it's called with `$check_last_ok = TRUE` (the default), there's a good chance it will simply return TRUE.
	 *    That is, if we check a last OK time, and it's valid — a re-scan will NOT be processed; and there are no `issues` to report.
	 *
	 * @note This routine also deals with administrative notices in WordPress®.
	 * @note This routine also deals with auto-fix routines in WordPress®.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 *
	 * @see deps_xd_v141226_dev::check()
	 */
	public function check($plugin_name = '', $plugin_dir_names = '', $report_notices = TRUE, $report_warnings = TRUE,
	                      $check_last_ok = TRUE, $maybe_display_wp_admin_notices = TRUE)
	{
		// Establish some important working variables.

		$is_stand_alone        = $GLOBALS[__FILE__]['is_in_stand_alone_mode'];
		$is_wp_loaded          = defined('WPINC'); // We'll be checking these flags in several places below.
		$_g                    = ($is_wp_loaded && !empty($_GET['xd__deps'])) ? stripslashes_deep($_GET['xd__deps']) : array();
		$is_auto_fix           = ($is_wp_loaded && !empty($_g['auto_fix']) && is_string($_g['auto_fix']) && !empty($_g['checksum']) && is_string($_g['checksum']) && $this->verify_checksum($_g['auto_fix'], $_g['checksum']));
		$is_dismissal          = ($is_wp_loaded && !empty($_g['dismiss']) && is_string($_g['dismiss']) && !empty($_g['checksum']) && is_string($_g['checksum']) && $this->verify_checksum($_g['dismiss'], $_g['checksum']));
		$is_test_email         = ($is_wp_loaded && !empty($_g['test_email']) && is_string($_g['test_email']) && !empty($_g['checksum']) && is_string($_g['checksum']) && $this->verify_checksum($_g['test_email'], $_g['checksum']));
		$is_test_https         = ($is_wp_loaded && !empty($_g['test_https']) && is_string($_g['test_https']) && !empty($_g['checksum']) && is_string($_g['checksum']) && $this->verify_checksum($_g['test_https'], $_g['checksum']));
		$is_localhost_test_url = !empty($_g['localhost_test_url']); // A test back to the same site; we should NOT scan dependencies in a loop.

		# --------------------------------------------------------------------------------------------------------------------------------

		if($is_localhost_test_url) return FALSE; // A test back to the same site; we should NOT scan dependencies in a loop.

		# --------------------------------------------------------------------------------------------------------------------------------

		// If this IS an auto-fix request, should we compact (or extract) the originals?

		if($is_wp_loaded && $is_auto_fix) // Yes, this IS an auto-fix request.
			// Before we can auto-fix anything; we need to wait for `init` hook completion.
			if(!did_action('init') || ($this->is_function_possible('doing_action') && doing_action('init')))
			{
				$this->auto_fix_orig_check_args = // Remember these.
					compact(
						'plugin_name', 'plugin_dir_names',
						'report_notices', 'report_warnings',
						'check_last_ok', 'maybe_display_wp_admin_notices'
					);
				add_action('wp_loaded', array($this, 'check'), 1);

				return ($this->check = FALSE);
			}
			else if(!empty($this->auto_fix_orig_check_args) && (func_num_args() === 0 || func_get_args() === array('')))
				extract($this->auto_fix_orig_check_args); // Overrides existing argument values.

		# --------------------------------------------------------------------------------------------------------------------------------

		// Now let's check all argument value types.

		if(!is_string($plugin_name) || !is_string($plugin_dir_names)
		   || !is_bool($report_notices) || !is_bool($report_warnings)
		   || !is_bool($check_last_ok) || !is_bool($maybe_display_wp_admin_notices)
		) throw new exception( // Fail here; detected invalid arguments.
			sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
		);

		# --------------------------------------------------------------------------------------------------------------------------------

		// Define some other important variables.

		$apache_version = $this->apache_version();
		$php_version    = PHP_VERSION; // Installed PHP version.
		global $wp_version; // Global made available by WordPress®.

		$apache_version_required = '2.1'; #!apache-version-required!#
		$php_version_required    = '5.3.1'; #!php-version-required!#
		$wp_version_required     = '3.5.1'; #!wp-version-required!#

		# --------------------------------------------------------------------------------------------------------------------------------

		// Check if a filter has disabled this scanner.

		if($is_wp_loaded && !$is_stand_alone && apply_filters('xd__deps__check_disable', FALSE))
			return ($this->check = TRUE); // Return now (DISABLED by a filter).

		# --------------------------------------------------------------------------------------------------------------------------------

		// Has a full scan succeeded in the past?

		$check_last_ok = ($is_stand_alone) ? FALSE : $check_last_ok;

		if($is_wp_loaded && !$is_stand_alone && $check_last_ok
		   && is_array($last_ok = get_option('xd__deps__last_ok'))
		   && isset($last_ok['xd_v141226_dev'], $last_ok['time'], $last_ok['php_version'], $last_ok['wp_version'])
		   && $last_ok['time'] >= strtotime('-7 days') && $last_ok['php_version'] === $php_version && $last_ok['wp_version'] === $wp_version
		) return ($this->check = TRUE); // Return TRUE. A re-scan is NOT necessary; everything is still OK.

		# --------------------------------------------------------------------------------------------------------------------------------

		// Else we need to run a full scan now.

		$issues = $passes = $errors = $warnings = $notices = array();

		# --------------------------------------------------------------------------------------------------------------------------------

		if(!is_string($plugin_name) || !$plugin_name)
		{
			if($is_stand_alone && defined('___STAND_ALONE__PLUGIN_NAME') && ___STAND_ALONE__PLUGIN_NAME)
				$plugin_name = ___STAND_ALONE__PLUGIN_NAME;

			else if($is_stand_alone && preg_match('/^(?P<prefix>.+)\-stand\-alone\.php$/i', basename(__FILE__), $_file))
				$plugin_name = preg_replace('/[_\-]+/i', ' ', $_file['prefix']).'™';

			else $plugin_name = $this->default_plugin_name;

			unset($_file); // A little housekeeping.
		}
		if(!is_string($plugin_dir_names) || !$plugin_dir_names)
		{
			if($is_stand_alone && defined('___STAND_ALONE__PLUGIN_DIR_NAMES') && ___STAND_ALONE__PLUGIN_DIR_NAMES)
				$plugin_dir_names = ___STAND_ALONE__PLUGIN_DIR_NAMES;

			else if($is_stand_alone && preg_match('/^(?P<prefix>.+)\-stand\-alone\.php$/i', basename(__FILE__), $_file))
				$plugin_dir_names = strtolower(preg_replace('/[_\-]+/i', '-', $_file['prefix']));

			else $plugin_dir_names = $this->default_plugin_dir_names;

			unset($_file); // A little housekeeping.
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if($apache_version && version_compare($apache_version, $apache_version_required, '<'))
		{
			$errors[] = array(
				'title'   => $this->__('Apache Version'),
				'message' => sprintf(
					$this->__(
						'Apache v%1$s (or higher) is required to run %2$s.'.
						' You are currently running Apache <code>v%3$s</code>. Please upgrade.'
					), htmlspecialchars($apache_version_required), htmlspecialchars($plugin_name), htmlspecialchars($apache_version)
				)
			);
		}
		else if($apache_version) // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Apache Version'),
				'message' => sprintf(
					$this->__(
						'You are currently running Apache <code>%1$s</code> (which is fine).'.
						' Minimum required version is: <code>%2$s</code>.'
					), htmlspecialchars($apache_version), htmlspecialchars($apache_version_required)
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(version_compare($php_version, $php_version_required, '<'))
		{
			$errors[] = array(
				'title'   => $this->__('PHP Version'),
				'message' => sprintf(
					$this->__(
						'PHP v%1$s (or higher) is required to run %2$s.'.
						' You are currently running PHP <code>v%3$s</code>. Please upgrade.'
					), htmlspecialchars($php_version_required), htmlspecialchars($plugin_name), htmlspecialchars($php_version)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('PHP Version'),
				'message' => sprintf(
					$this->__(
						'You are currently running PHP <code>%1$s</code> (which is fine).'.
						' Minimum required version is: <code>%2$s</code>.'
					), htmlspecialchars($php_version), htmlspecialchars($php_version_required)
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if($is_wp_loaded && version_compare($wp_version, $wp_version_required, '<'))
		{
			$errors[] = array(
				'title'   => $this->__('WordPress® Version'),
				'message' => sprintf(
					$this->__(
						'WordPress® v%1$s (or higher) is required to run %2$s.'.
						' You are currently running WordPress® <code>v%3$s</code>. Please <a href="%4$s">upgrade</a>.'
					), htmlspecialchars($wp_version_required), htmlspecialchars($plugin_name), htmlspecialchars($wp_version), esc_attr(admin_url('/update-core.php'))
				)
			);
		}
		else if($is_wp_loaded) // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('WordPress® Version'),
				'message' => sprintf(
					$this->__(
						'You are currently running WordPress® <code>%1$s</code> (which is fine).'.
						' Minimum required version is: <code>%2$s</code>'
					), htmlspecialchars($wp_version), htmlspecialchars($wp_version_required)
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('phar'))
		{
			$errors[] = array(
				'title'   => $this->__('Default Phar Extension (PHP Archives)'),
				'message' => sprintf(
					$this->__(
						'Missing Phar extension. %1$s needs the <a href="http://php.net/manual/en/book.phar.php" target="_blank" rel="xlink">Phar</a> extension for PHP.'.
						' The Phar extension provides a way for developers to put large portions (or even entire PHP applications) into a single file called a "phar" (PHP Archive) for easy distribution and installation.'.
						' In addition to providing this service, the phar extension also provides a file-format abstraction method for creating and manipulating tar and zip files through the PharData class.'.
						' Note, this extension should have been enabled with just a default installation of PHP v5.3+.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(extension_loaded('suhosin') && stripos(ini_get('suhosin.executor.include.whitelist'), 'phar') === FALSE)
		{ // We do NOT need to worry about the Suhosin PATCH; as it does nothing really (only the extension).
			$errors[] = array(
				'title'   => $this->__('Default Phar Extension (PHP Archives)'),
				'message' => sprintf(
					$this->__(
						'Phar stream (<code>phar://</code>) disabled by Suhosin security extension. %1$s needs the <a href="http://php.net/manual/en/book.phar.php" target="_blank" rel="xlink">Phar</a> extension for PHP.'.
						' The Phar extension provides a way for developers to put large portions (or even entire PHP applications) into a single file called a "phar" (PHP Archive) for easy distribution and installation.'.
						' In addition to providing this service, the phar extension also provides a file-format abstraction method for creating and manipulating tar and zip files through the PharData class.'.
						' Your server appears to support the Phar extension, but you are missing this line in your <code>php.ini</code> file: <code>suhosin.executor.include.whitelist = phar</code>.'.
						' Please read <a href="http://stackoverflow.com/questions/15049572/i-downloaded-aws-phar-but-cant-require-it/15052394#15052394" target="_blank" rel="xlink">this article</a> for further details.'.
						' See also: <a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.executor.include.whitelist" target="_blank" rel="xlink">this documentation</a>.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default Phar Extension (PHP Archives)'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.phar.php" target="_blank" rel="xlink">Phar</a> extension is installed.'.
						' Comes with every installation of PHP 5.3+. Your server supports PHP archives.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('zlib'))
		{
			$errors[] = array(
				'title'   => $this->__('ZLib Extension (GZIP)'),
				'message' => sprintf(
					$this->__(
						'Missing ZLib extension. %1$s needs the <a href="http://www.php.net/manual/en/book.zlib.php" target="_blank" rel="xlink">zlib</a> extension for PHP.'.
						' This will add GZIP support to your installation of PHP, allowing your installation to read/write GZIP compressed files.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('ZLib Extension (GZIP)'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.zlib.php" target="_blank" rel="xlink">zlib</a> extension is installed.'.
						' Your server supports GZIP compression.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('mbstring'))
		{
			$errors[] = array(
				'title'   => $this->__('Multibyte String Extension'),
				'message' => sprintf(
					$this->__(
						'Missing PHP extension. %1$s needs the <a href="http://www.php.net/manual/en/book.mbstring.php" target="_blank" rel="xlink">mbstring</a> extension for PHP.'.
						' This will add multibyte support to your installation of PHP, allowing UTF-8 character conversion.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Multibyte String Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.mbstring.php" target="_blank" rel="xlink">mbstring</a> extension is installed.'.
						' Your server supports UTF-8 character conversion.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('hash'))
		{
			$errors[] = array(
				'title'   => $this->__('Default Hash Extension'),
				'message' => sprintf(
					$this->__(
						'Missing Hash extension. %1$s needs the <a href="http://www.php.net/manual/en/book.hash.php" target="_blank" rel="xlink">Hash</a> extension for PHP.'.
						' This will add message digest support to your installation of PHP, and allows for direct or incremental processing of arbitrary length messages using a variety of hashing algorithms.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default Hash Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.hash.php" target="_blank" rel="xlink">Hash</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports message digests.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('xml'))
		{
			$errors[] = array(
				'title'   => $this->__('Default XML Parser Extension'),
				'message' => sprintf(
					$this->__(
						'Missing XML Parser extension. %1$s needs the <a href="http://www.php.net/manual/en/book.xml.php" target="_blank" rel="xlink">XML Parser</a> extension for PHP.'.
						' This will add XML support to your installation of PHP, and allows for the creation of XML parsers/events.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default XML Parser Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.xml.php" target="_blank" rel="xlink">XML Parser</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports XML parsing.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('libxml'))
		{
			$errors[] = array(
				'title'   => $this->__('Default libXML Extension'),
				'message' => sprintf(
					$this->__(
						'Missing libXML extension. %1$s needs the <a href="http://php.net/manual/en/book.libxml.php" target="_blank" rel="xlink">libXML</a> extension for PHP.'.
						' This will add XML support to your installation of PHP. This is a requirement for other extensions, such as SimpleXML and SOAP.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default libXML Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.libxml.php" target="_blank" rel="xlink">libXML</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports this important dependency.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('simplexml'))
		{
			$errors[] = array(
				'title'   => $this->__('Default Simple XML Extension'),
				'message' => sprintf(
					$this->__(
						'Missing Simple XML extension. %1$s needs the <a href="http://www.php.net/manual/en/book.simplexml.php" target="_blank" rel="xlink">Simple XML</a> extension for PHP.'.
						' This will add XML support to your installation of PHP, and allows for the conversion of XML documents to PHP objects.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default Simple XML Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.simplexml.php" target="_blank" rel="xlink">Simple XML</a> extension is installed.'.
						' Comes with every installation of PHP. Your server can convert XML into PHP objects.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('xmlreader'))
		{
			$errors[] = array(
				'title'   => $this->__('Default XML Reader Extension'),
				'message' => sprintf(
					$this->__(
						'Missing XML Reader extension. %1$s needs the <a href="http://www.php.net/manual/en/book.xmlreader.php" target="_blank" rel="xlink">XML Reader</a> extension for PHP.'.
						' This will add XML support to your installation of PHP, and allows for the reading of XML documents.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default XML Reader Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.xmlreader.php" target="_blank" rel="xlink">XML Reader</a> extension is installed.'.
						' Comes with every installation of PHP. Your server has the ability to read XML documents.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('xmlwriter'))
		{
			$errors[] = array(
				'title'   => $this->__('Default XML Writer Extension'),
				'message' => sprintf(
					$this->__(
						'Missing XML Writer extension. %1$s needs the <a href="http://www.php.net/manual/en/book.xmlwriter.php" target="_blank" rel="xlink">XML Writer</a> extension for PHP.'.
						' This will add XML support to your installation of PHP, and allows for the creation of XML documents.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default XML Writer Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.xmlwriter.php" target="_blank" rel="xlink">XML Writer</a> extension is installed.'.
						' Comes with every installation of PHP. Your server has the ability to write XML documents.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('dom'))
		{
			$errors[] = array(
				'title'   => $this->__('Default DOM Extension'),
				'message' => sprintf(
					$this->__(
						'Missing DOM extension. %1$s needs the <a href="http://php.net/manual/en/book.dom.php" target="_blank" rel="xlink">DOM</a> extension for PHP.'.
						' This will add Document Object Model support to your installation of PHP, allowing XML documents to be traversed easily.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default DOM Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.dom.php" target="_blank" rel="xlink">DOM</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports XML document traversal.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('session'))
		{
			$errors[] = array(
				'title'   => $this->__('Default Sessions Extension'),
				'message' => sprintf(
					$this->__(
						'Missing Sessions extension. %1$s needs the <a href="http://www.php.net/manual/en/book.session.php" target="_blank" rel="xlink">Sessions</a> extension for PHP.'.
						' This will add sessioning support to your installation of PHP, allowing read/write access to session data.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default Sessions Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://www.php.net/manual/en/book.session.php" target="_blank" rel="xlink">Sessions</a> extension is installed.'.
						' Comes with every installation of PHP. Your server allows read/write access to session data.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('mysql'))
		{
			$errors[] = array(
				'title'   => $this->__('MySQL Database Extension'),
				'message' => sprintf(
					$this->__(
						'Missing MySQL extension. %1$s needs the <a href="http://php.net/manual/en/book.mysql.php" target="_blank" rel="xlink">MySQL</a> extension for PHP.'.
						' This will add MySQL support to your installation of PHP, allowing MySQL database communication.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('MySQL Database Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.mysql.php" target="_blank" rel="xlink">MySQL</a> extension is installed.'.
						' Your server supports MySQL database communication.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('mcrypt'))
		{
			$errors[] = array(
				'title'   => $this->__('Mcrypt/Encryption Extension'),
				'message' => sprintf(
					$this->__(
						'Missing Mcrypt extension. %1$s needs the <a href="http://php.net/manual/en/book.mcrypt.php" target="_blank" rel="xlink">Mcrypt</a> extension for PHP.'.
						' This will add encryption support to your installation of PHP, with a variety of block algorithms; such as DES, TripleDES, and Blowfish.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Mcrypt/Encryption Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.mcrypt.php" target="_blank" rel="xlink">Mcrypt</a> extension is installed.'.
						' Your server supports advanced data encryption.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('json'))
		{
			$errors[] = array(
				'title'   => $this->__('Default JSON Extension'),
				'message' => sprintf(
					$this->__(
						'Missing JSON extension. %1$s needs the <a href="http://php.net/manual/en/book.json.php" target="_blank" rel="xlink">JSON</a> extension for PHP.'.
						' This will add JSON support to your installation of PHP, a standard JavaScript Object Notation (JSON) data-interchange format.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default JSON Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.json.php" target="_blank" rel="xlink">JSON</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports JavaScript object notation.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('gd') || !is_array($_gd_info = gd_info()))
		{
			$errors[] = array(
				'title'   => $this->__('GD Image Extension'),
				'message' => sprintf(
					$this->__(
						'Missing GD Image extension. %1$s needs the <a href="http://php.net/manual/en/book.image.php" target="_blank" rel="xlink">GD Image</a> extension for PHP.'.
						' This will add image creation support to your installation of PHP, so that images can be generated dynamically.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(empty($_gd_info['FreeType Support']))
		{
			$errors[] = array(
				'title'   => $this->__('GD Image Extension (FreeType Support)'),
				'message' => sprintf(
					$this->__(
						'Missing FreeType library for GD Image extension. %1$s needs the <a href="http://php.net/manual/en/book.image.php" target="_blank" rel="xlink">GD Image</a> extension for PHP, with the FreeType library also.'.
						' This will add image creation support to your installation of PHP, so that images can be generated dynamically. FreeType makes it possible for fonts to be used in image generation.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(empty($_gd_info['JPG Support']) && empty($_gd_info['JPEG Support']))
		{
			$errors[] = array(
				'title'   => $this->__('GD Image Extension (JPEG Support)'),
				'message' => sprintf(
					$this->__(
						'Missing JPEG support for GD Image extension. %1$s needs the <a href="http://php.net/manual/en/book.image.php" target="_blank" rel="xlink">GD Image</a> extension for PHP, with JPEG support enabled.'.
						' This will add JPEG image creation support to your installation of PHP, so that JPEG images can be generated dynamically.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(empty($_gd_info['PNG Support']))
		{
			$errors[] = array(
				'title'   => $this->__('GD Image Extension (PNG Support)'),
				'message' => sprintf(
					$this->__(
						'Missing PNG support for GD Image extension. %1$s needs the <a href="http://php.net/manual/en/book.image.php" target="_blank" rel="xlink">GD Image</a> extension for PHP, with PNG support enabled.'.
						' This will add PNG image creation support to your installation of PHP, so that PNG images can be generated dynamically.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('GD Image Extension (JPEG/PNG/FreeType)'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.image.php" target="_blank" rel="xlink">GD Image</a> extension is installed.'.
						' Your server supports dynamic image creation.'
					), NULL
				)
			);
		}
		unset($_gd_info); // Housekeeping.

		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('ctype'))
		{
			$errors[] = array(
				'title'   => $this->__('Default Ctype Extension'),
				'message' => sprintf(
					$this->__(
						'Missing Ctype extension. %1$s needs the <a href="http://php.net/manual/en/book.ctype.php" target="_blank" rel="xlink">CType</a> extension for PHP.'.
						' This will add character class support to your installation of PHP, allowing detection of certain types of characters, based on locale.'.
						' Note, this extension should have been enabled with just a default installation of PHP.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Default Ctype Extension'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.ctype.php" target="_blank" rel="xlink">Ctype</a> extension is installed.'.
						' Comes with every installation of PHP. Your server supports character class detection.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!extension_loaded('openssl') || !$this->is_function_possible('openssl_sign'))
		{
			$errors[] = array(
				'title'   => $this->__('OpenSSL Extension With <code>openssl_sign()</code>'),
				'message' => sprintf(
					$this->__(
						'PHP not compiled with OpenSSL. Missing PHP function <a href="http://php.net/manual/en/function.openssl-sign.php" target="_blank" rel="xlink">openssl_sign()</a>. In order to run %1$s, your installation of PHP needs the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension</a>.'.
						' Please consult with your web hosting company about this message.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('OpenSSL Extension With <code>openssl_sign()</code>'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension</a> is installed, and PHP function <a href="http://php.net/manual/en/function.openssl-sign.php" target="_blank" rel="xlink">openssl_sign()</a> is available.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_function_possible('eval'))
		{
			$errors[] = array(
				'title'   => $this->__('PHP <code>eval()</code> Function'),
				'message' => sprintf(
					$this->__(
						'Missing PHP function. %1$s needs the PHP <a href="http://php.net/manual/en/function.eval.php" target="_blank" rel="xlink">eval()</a> function.'.
						' Please check with your hosting provider to resolve this issue and have PHP <code>eval()</code> enabled.'.
						' Note... the use of <code>eval()</code>, is limited to areas where it is absolutely necessary to achieve a desired functionality.'.
						' For instance, where PHP code is supplied by a site owner (or by their developer) to achieve advanced customization through a UI panel. This can be evaluated at runtime to allow for the inclusion of PHP conditionals or dynamic values.'.
						' In cases such as these, the PHP <code>eval()</code> function serves a valid purpose. This does NOT introduce a vulnerability, because the code being evaluated has actually been introduced by the site owner (i.e. the code can be trusted in this case).'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('PHP <code>eval()</code> Function'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/function.eval.php" target="_blank" rel="xlink">eval()</a> function is available.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_function_possible('glob'))
		{
			$errors[] = array(
				'title'   => $this->__('PHP <code>glob()</code> Function'),
				'message' => sprintf(
					$this->__(
						'Missing PHP function. %1$s needs the PHP <a href="http://php.net/manual/en/function.glob.php" target="_blank" rel="xlink">glob()</a> function.'.
						' Please check with your hosting provider to resolve this issue and have PHP <code>glob()</code> enabled.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('PHP <code>glob()</code> Function'),
				'message' => sprintf(
					$this->__(
						'The <a href="http://php.net/manual/en/function.glob.php" target="_blank" rel="xlink">glob()</a> function is available.'
					), NULL
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!defined('GLOB_AVAILABLE_FLAGS') || !defined('GLOB_BRACE') || !(GLOB_AVAILABLE_FLAGS & GLOB_BRACE))
		{
			$errors[] = array(
				'title'   => $this->__('PHP <code>GLOB_BRACE</code> Flag'),
				'message' => sprintf(
					$this->__(
						'This installation of PHP <code>v%1$s</code> does NOT support the <code>GLOB_BRACE</code> flag for the <a href="http://php.net/manual/en/function.glob.php" target="_blank" rel="xlink">glob()</a> function in PHP.'.
						' Please check <a href="http://php.net/manual/en/function.glob.php" target="_blank" rel="xlink">this article</a> for further details.'.
						' Or, consult with your web hosting company about this message. This is likely an underlying server compatibility issue.'
					), htmlspecialchars($php_version)
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('PHP <code>GLOB_BRACE</code> Flag'),
				'message' => sprintf(
					$this->__(
						'You are currently running PHP <code>v%1$s</code> w/ support for the <code>GLOB_BRACE</code> flag.'
					), htmlspecialchars($php_version)
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		$_curl_possible               = extension_loaded('curl');
		$_curl_version                = ($_curl_possible) ? curl_version() : array();
		$_curl_over_ssl_possible      = ($_curl_possible && $_curl_version['features'] & CURL_VERSION_SSL);
		$_fopen_url_possible          = filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN);
		$_fopen_url_over_ssl_possible = ($_fopen_url_possible && extension_loaded('openssl'));

		$_curl_over_ssl_test_success                 = $_fopen_url_over_ssl_test_success = FALSE;
		$_curl_fopen_ssl_test_url                    = 'https://www.websharks-inc.com/robots.txt';
		$_curl_fopen_ssl_test_url_return_string_frag = 'user-agent';
		$_curl_localhost_test_success                = $_fopen_url_localhost_test_success = FALSE;
		$_curl_fopen_localhost_test_url              = // A value of `http://localhost` has special meaning below.
			'http://'.((!empty($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : 'localhost');
		$_curl_fopen_localhost_test_url .= '/?xd__deps[localhost_test_url]=1';
		$_curl_fopen_localhost_test_url_return_string_frag = '<html';

		if($_curl_possible && $_curl_over_ssl_possible)
		{
			if(is_resource($_curl_test_resource = curl_init()))
			{
				curl_setopt_array(
					$_curl_test_resource, array(
						CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 5,
						CURLOPT_URL            => $_curl_fopen_ssl_test_url, CURLOPT_RETURNTRANSFER => TRUE,
						CURLOPT_FAILONERROR    => TRUE, CURLOPT_FORBID_REUSE => TRUE, CURLOPT_SSL_VERIFYPEER => FALSE
					)
				);
				if(stripos((string)curl_exec($_curl_test_resource), $_curl_fopen_ssl_test_url_return_string_frag) !== FALSE)
					$_curl_over_ssl_test_success = TRUE;

				curl_close($_curl_test_resource);
			}
			unset($_curl_test_resource); // Housekeeping.

			if($this->is_cli() || $this->is_localhost())
				$_curl_localhost_test_success = TRUE; // No need to run this here.

			else if($_curl_fopen_localhost_test_url === 'http://localhost')
				$_curl_localhost_test_success = TRUE; // Can't run this test here.

			else if(is_resource($_curl_test_resource = curl_init()))
			{
				curl_setopt_array(
					$_curl_test_resource, array(
						CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 5,
						CURLOPT_URL            => $_curl_fopen_localhost_test_url, CURLOPT_RETURNTRANSFER => TRUE,
						CURLOPT_FAILONERROR    => TRUE, CURLOPT_FORBID_REUSE => TRUE, CURLOPT_SSL_VERIFYPEER => FALSE
					)
				);
				if(stripos((string)curl_exec($_curl_test_resource), $_curl_fopen_localhost_test_url_return_string_frag) !== FALSE)
					$_curl_localhost_test_success = TRUE;

				curl_close($_curl_test_resource);
			}
			unset($_curl_test_resource); // Housekeeping.
		}
		if($_fopen_url_possible && $_fopen_url_over_ssl_possible)
		{
			if(is_resource($_fopen_test_resource = stream_context_create(array('http' => array('timeout' => 5.0, 'ignore_errors' => FALSE)))))
			{
				if(stripos((string)file_get_contents($_curl_fopen_ssl_test_url, NULL, $_fopen_test_resource), $_curl_fopen_ssl_test_url_return_string_frag) !== FALSE)
					$_fopen_url_over_ssl_test_success = TRUE;
			}
			unset($_fopen_test_resource); // Housekeeping.

			if($this->is_cli() || $this->is_localhost())
				$_fopen_url_localhost_test_success = TRUE; // No need to run this here.

			else if($_curl_fopen_localhost_test_url === 'http://localhost')
				$_fopen_url_localhost_test_success = TRUE; // Can't run this test here.

			else if(is_resource($_fopen_test_resource = stream_context_create(array('http' => array('timeout' => 5.0, 'ignore_errors' => FALSE)))))
			{
				if(stripos((string)file_get_contents($_curl_fopen_localhost_test_url, NULL, $_fopen_test_resource), $_curl_fopen_localhost_test_url_return_string_frag) !== FALSE)
					$_fopen_url_localhost_test_success = TRUE;
			}
			unset($_fopen_test_resource); // Housekeeping.
		}
		if(!$_curl_possible && !$_fopen_url_possible)
		{
			$errors[] = array(
				'title'   => $this->__('cURL Extension / Or <code>fopen()</code> URL'),
				'message' => sprintf(
					$this->__(
						'In order to run %1$s, your installation of PHP needs one of the following...<br />'.
						'&bull; Either the <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP (plus the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'&bull; Or, set: <code>allow_url_fopen = on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and enable the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'Please consult with your web hosting company about this message. See also: <a href="http://wordpress.org/hosting/" target="_blank" rel="xlink">WordPress recommended hosting platforms</a>.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(!$_curl_over_ssl_possible && !$_fopen_url_over_ssl_possible)
		{
			$errors[] = array(
				'title'   => $this->__('cURL Extension / Or <code>fopen()</code> URL'),
				'message' => sprintf(
					$this->__(
						'PHP not compiled with OpenSSL. In order to run %1$s, your installation of PHP needs one of the following...<br />'.
						'&bull; Either the <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP (plus the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'&bull; Or, set: <code>allow_url_fopen = on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and enable the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'Please consult with your web hosting company about this message. See also: <a href="http://wordpress.org/hosting/" target="_blank" rel="xlink">WordPress recommended hosting platforms</a>.'
					), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(!$_curl_over_ssl_test_success && !$_fopen_url_over_ssl_test_success)
		{
			$errors[] = array(
				'title'   => $this->__('cURL Extension / Or <code>fopen()</code> URL'),
				'message' => sprintf(
					$this->__(
						'One or more HTTPS connection tests failed when connecting to:<br />'.
						'<code>%1$s</code><br /><br />'.

						'In order to run %2$s, your installation of PHP needs one of the following...<br />'.
						'&bull; Either the <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP (plus the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'&bull; Or, set: <code>allow_url_fopen = on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and enable the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'Please consult with your web hosting company about this message. See also: <a href="http://wordpress.org/hosting/" target="_blank" rel="xlink">WordPress recommended hosting platforms</a>.'
					), htmlspecialchars($_curl_fopen_ssl_test_url), htmlspecialchars($plugin_name)
				)
			);
		}
		else if(!$_curl_localhost_test_success && !$_fopen_url_localhost_test_success)
		{
			$errors[] = array(
				'title'   => $this->__('cURL Extension / Or <code>fopen()</code> URL'),
				'message' => sprintf(
					$this->__(
						'One or more HTTP connection tests failed against localhost.<br />'.
						'Cannot connect to self over HTTP — possible DNS resolution issue.<br />'.
						'Can\'t connect to: <code>%1$s</code><br /><br />'.

						'In order to run %2$s, your installation of PHP needs one of the following...<br />'.
						'&bull; Either the <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP (plus the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'&bull; Or, set: <code>allow_url_fopen = on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and enable the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a>).<br />'.
						'Please consult with your web hosting company about this message. See also: <a href="http://wordpress.org/hosting/" target="_blank" rel="xlink">WordPress recommended hosting platforms</a>.'
					), htmlspecialchars($_curl_fopen_localhost_test_url), htmlspecialchars($plugin_name)
				)
			);
		}
		else // Pass on this check.
		{
			if($_curl_possible && $_curl_over_ssl_possible)
			{
				$passes[] = array(
					'title'   => $this->__('cURL Extension w/ SSL Support'),
					'message' => sprintf(
						$this->__(
							'The <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP is available (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled).'
						), NULL
					)
				);
				if($_curl_over_ssl_test_success)
					$passes[] = array(
						'title'   => $this->__('cURL Extension w/ SSL Support (connection test)'),
						'message' => sprintf(
							$this->__(
								'The <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP is available (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled). Test HTTPS connection to: <code>%1$s</code> succeeded.'
							), htmlspecialchars($_curl_fopen_ssl_test_url)
						)
					);
				if($_curl_localhost_test_success)
					$passes[] = array(
						'title'   => $this->__('cURL Extension (localhost connection test)'),
						'message' => sprintf(
							$this->__(
								'The <a href="http://php.net/manual/en/book.curl.php" target="_blank" rel="xlink">cURL extension</a> for remote communication via PHP is available (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled). Test HTTP connection to localhost: <code>%1$s</code> succeeded.'
							), htmlspecialchars($_curl_fopen_localhost_test_url)
						)
					);
			}
			if($_fopen_url_possible && $_fopen_url_over_ssl_possible)
			{
				$passes[] = array(
					'title'   => $this->__('INI <code>fopen()</code> URL w/ SSL Support'),
					'message' => sprintf(
						$this->__(
							'The setting <code>allow_url_fopen</code> is <code>on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled).'
						), NULL
					)
				);
				if($_fopen_url_over_ssl_test_success)
					$passes[] = array(
						'title'   => $this->__('INI <code>fopen()</code> URL w/ SSL Support (connection test)'),
						'message' => sprintf(
							$this->__(
								'The setting <code>allow_url_fopen</code> is <code>on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled). Test HTTPS connection to: <code>%1$s</code> succeeded.'
							), htmlspecialchars($_curl_fopen_ssl_test_url)
						)
					);
				if($_fopen_url_localhost_test_success)
					$passes[] = array(
						'title'   => $this->__('INI <code>fopen()</code> URL (localhost connection test)'),
						'message' => sprintf(
							$this->__(
								'The setting <code>allow_url_fopen</code> is <code>on</code> in your <a href="http://php.net/manual/en/filesystem.configuration.php" target="_blank" rel="xlink">php.ini</a> file (and the <a href="http://php.net/manual/en/book.openssl.php" target="_blank" rel="xlink">OpenSSL extension for PHP</a> is enabled). Test HTTP connection to localhost: <code>%1$s</code> succeeded.'
							), htmlspecialchars($_curl_fopen_localhost_test_url)
						)
					);
			}
		}
		unset($_curl_possible, $_curl_version, $_curl_over_ssl_possible);
		unset($_fopen_url_possible, $_fopen_url_over_ssl_possible); // Housekeeping.
		unset($_curl_over_ssl_test_success, $_curl_fopen_ssl_test_url, $_curl_fopen_ssl_test_url_return_string_frag);
		unset($_curl_localhost_test_success, $_curl_fopen_localhost_test_url, $_curl_fopen_localhost_test_url_return_string_frag);

		# --------------------------------------------------------------------------------------------------------------------------------

		$_temp_dir = ''; // Initialize; in case we're unable to locate.

		if(($_sys_temp_dir = sys_get_temp_dir()) && ($_sys_temp_dir = realpath($_sys_temp_dir)) && is_readable($_sys_temp_dir) && is_writable($_sys_temp_dir))
			$_temp_dir = $_sys_temp_dir; // Ideal location.

		else if(($_upload_temp_dir = ini_get('upload_tmp_dir')) && ($_upload_temp_dir = realpath($_upload_temp_dir)) && is_readable($_upload_temp_dir) && is_writable($_upload_temp_dir))
			$_temp_dir = $_upload_temp_dir; // Secondary (ok, but not as secure).

		if(!$_temp_dir) // Unable to find a readable/writable temp directory.
		{
			$errors[] = array(
				'title'   => $this->__('Temporary Files Directory'),
				'message' => sprintf(
					$this->__(
						'Unable to find a readable/writable temporary files directory. The system\'s default temp directory is either non-existent, NOT yet configured, or is NOT readable/writable by PHP.'.
						' Please review this article covering PHP\'s <a href="http://php.net/manual/en/function.sys-get-temp-dir.php" target="_blank" rel="xlink">sys_get_temp_dir()</a> function, or configure your PHP installation with a secure <code>upload_tmp_dir</code>. See <a href="http://www.php.net/manual/en/ini.core.php#ini.upload-tmp-dir" target="_blank" rel="xlink">this article</a> for further details.'.
						' In some cases, you might need to consult with your web hosting company about this message.'
					), NULL
				)
			);
		}
		else // Pass on this check.
		{
			$passes[] = array(
				'title'   => $this->__('Temporary Files Directory'),
				'message' => sprintf(
					$this->__(
						'A readable/writable temporary files directory was found here: <code>%1$s</code>'
					), htmlspecialchars($_temp_dir)
				)
			);
		}
		unset($_temp_dir, $_sys_temp_dir, $_upload_temp_dir); // Housekeeping.

		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https' && (empty($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) !== 'on') && (empty($_SERVER['SERVER_PORT']) || (integer)$_SERVER['SERVER_PORT'] !== 443))
			{
				array_unshift( // Push to top of the stack.
					$errors, array(
						'title'   => $this->__('<span class="hilite">HTTPS Proxy; Missing <code>$_SERVER[\'HTTPS\']</code></span>'),
						'message' => sprintf(
							$this->__(
								'Possible load balancer w/ HTTPS port forwarding. Load balancers are great, but your PHP environment is missing the <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'HTTPS\'] = on</a> variable. This is needed by WordPress® in order to determine the current protocol in use. See also: <a href="http://codex.wordpress.org/Function_Reference/is_ssl" target="_blank" rel="xlink">is_ssl()</a> for further details.'.
								' Please consult with your web hosting company about this message.'
							), htmlspecialchars($plugin_name)
						)
					));
			}
			else if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
			{
				array_unshift( // Push to top of the stack.
					$passes, array(
						'title'   => $this->__('<span class="hilite">HTTPS Proxy; <code>$_SERVER[\'HTTPS\'] = on</code></span>'),
						'message' => sprintf(
							$this->__(
								'Possible load balancer w/ HTTPS port forwarding; and your PHP environment includes the <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'HTTPS\'] = on</a> and/or <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'SERVER_PORT\'] = 443</a> variables. So you\'re good here.'
							), NULL
						)
					));
			}
			else if($is_test_https && ((empty($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) !== 'on') && (empty($_SERVER['SERVER_PORT']) || (integer)$_SERVER['SERVER_PORT'] !== 443)))
			{
				array_unshift( // Push to top of the stack.
					$errors, array(
						'title'   => $this->__('<span class="hilite"><code>$_SERVER[\'HTTPS\'] = on</code></span>'),
						'message' => sprintf(
							$this->__(
								'Your PHP environment is missing the <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'HTTPS\'] = on</a> and/or <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'SERVER_PORT\'] = 443</a> variables.'.
								' Please consult with your web hosting company about this message.'
							), NULL
						)
					));
			}
			else if($is_test_https) // Pass on this check.
			{
				array_unshift( // Push to top of the stack.
					$passes, array(
						'title'   => $this->__('<span class="hilite"><code>$_SERVER[\'HTTPS\'] = on</code></span>'),
						'message' => sprintf(
							$this->__(
								'Your PHP environment includes the <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'HTTPS\'] = on</a> and/or <a href="http://www.php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">$_SERVER[\'SERVER_PORT\'] = 443</a> variables. So you\'re good here.'
							), NULL
						)
					));
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(empty($_SERVER['DOCUMENT_ROOT']) || !is_string($_SERVER['DOCUMENT_ROOT']))
			{
				$errors[] = array(
					'title'   => $this->__('Missing <code>$_SERVER[\'DOCUMENT_ROOT\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is NOT currently configured with a <code>$_SERVER[\'DOCUMENT_ROOT\']</code> environment variable.'.
							' This is the document root directory under which the current script is executing. It should be defined in the server\'s configuration file.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
						), NULL
					)
				);
			}
			else // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('<code>$_SERVER[\'DOCUMENT_ROOT\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your server reports this value: <code>%1$s</code>'
						), htmlspecialchars($_SERVER['DOCUMENT_ROOT'])
					)
				);
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(empty($_SERVER['HTTP_HOST']) || !is_string($_SERVER['HTTP_HOST']))
			{
				$errors[] = array(
					'title'   => $this->__('Missing <code>$_SERVER[\'HTTP_HOST\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is NOT currently configured with a <code>$_SERVER[\'HTTP_HOST\']</code> environment variable.'.
							' This is the host domain name used to access any given page of your web site (available for each page). It should be defined by your server dynamically.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
						), NULL
					)
				);
			}
			else // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('<code>$_SERVER[\'HTTP_HOST\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your server reports this value: <code>%1$s</code>'
						), htmlspecialchars($_SERVER['HTTP_HOST'])
					)
				);
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI']))
			{
				$errors[] = array(
					'title'   => $this->__('Missing <code>$_SERVER[\'REQUEST_URI\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is NOT currently configured with a <code>$_SERVER[\'REQUEST_URI\']</code> environment variable.'.
							' This is the URI used to access any given page of your web site (available for each page). It should be defined by your server dynamically.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
						), NULL
					)
				);
			}
			else // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('<code>$_SERVER[\'REQUEST_URI\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your server reports this value: <code>%1$s</code>'
						), htmlspecialchars($_SERVER['REQUEST_URI'])
					)
				);
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(empty($_SERVER['REMOTE_ADDR']) || !is_string($_SERVER['REMOTE_ADDR']))
			{
				$errors[] = array(
					'title'   => $this->__('Missing <code>$_SERVER[\'REMOTE_ADDR\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is NOT currently configured with a <code>$_SERVER[\'REMOTE_ADDR\']</code> environment variable.'.
							' This is the IP address from which the user is viewing the current page. It should be defined by your server dynamically.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
						), NULL
					)
				);
			}
			else if(!empty($_SERVER['SERVER_ADDR']) && is_string($_SERVER['SERVER_ADDR']) && $_SERVER['REMOTE_ADDR'] === $_SERVER['SERVER_ADDR'] && !$this->is_localhost())
			{
				$errors[] = array(
					'title'   => $this->__('Invalid <code>$_SERVER[\'REMOTE_ADDR\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is misconfigured, with an invalid value for it\'s <code>$_SERVER[\'REMOTE_ADDR\']</code> environment variable.'.
							' This is the IP address from which the user is viewing the current page. It should be defined by your server dynamically (for the current user).'.
							' The problem is... your server reports the current user as having the same IP address as the server itself? Something is wrong here.'.
							' Your server reports its own IP as: <code>%1$s</code>, and the current user\'s IP as: <code>%2$s</code>.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://stackoverflow.com/questions/4262081/serverremote-addr-gives-server-ip-rather-than-visitor-ip" target="_blank" rel="xlink">this helpful article</a>.'.
							' <strong>Developers:</strong> If the server itself is currently in a localhost environment (this explains it, and that\'s fine). Please add this to your <code>/wp-config.php</code> file, so you can avoid this message while development is underway: <code>define(\'LOCALHOST\', TRUE);</code>'
						), htmlspecialchars($_SERVER['SERVER_ADDR']), htmlspecialchars($_SERVER['REMOTE_ADDR'])
					)
				);
			}
			else // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('<code>$_SERVER[\'REMOTE_ADDR\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your server reports this value: <code>%1$s</code>'
						), htmlspecialchars($_SERVER['REMOTE_ADDR'])
					)
				);
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if(!$this->is_cli())
			if(empty($_SERVER['HTTP_USER_AGENT']) || !is_string($_SERVER['HTTP_USER_AGENT']))
			{
				$errors[] = array(
					'title'   => $this->__('Missing <code>$_SERVER[\'HTTP_USER_AGENT\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your installation of PHP is NOT currently configured with a <code>$_SERVER[\'HTTP_USER_AGENT\']</code> environment variable.'.
							' This is the browser and operating system the current user is viewing the current page with. It should be defined by your server dynamically.'.
							' Please contact your hosting provider about this issue. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
						), NULL
					)
				);
			}
			else // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('<code>$_SERVER[\'HTTP_USER_AGENT\']</code>'),
					'message' => sprintf(
						$this->__(
							'Your server reports this value: <code>%1$s</code>'
						), htmlspecialchars($_SERVER['HTTP_USER_AGENT'])
					)
				);
			}
		# --------------------------------------------------------------------------------------------------------------------------------

		if($report_warnings) // Only run these scans if we're reporting warnings.
		{
			# --------------------------------------------------------------------------------------------------------------------------

			if(!$this->is_cli())
				if(empty($_SERVER['SERVER_ADDR']) || !is_string($_SERVER['SERVER_ADDR']))
				{
					// Note... this got moved into the warnings section,
					// because some installations of PHP just do NOT have this available.
					// FatCow is one example of this (no $_SERVER['SERVER_ADDR']).

					$warnings[] = array(
						'title'   => $this->__('Missing <code>$_SERVER[\'SERVER_ADDR\']</code>'),
						'message' => sprintf(
							$this->__(
								'Although NOT required, %1$s recommends that your installation of PHP be configured with a <code>$_SERVER[\'SERVER_ADDR\']</code> environment variable.'.
								' This is the IP address of the server, under which the current script is executing. It should be defined by your server dynamically.'.
								' Please contact your hosting provider about this message. See also: <a href="http://php.net/manual/en/reserved.variables.server.php" target="_blank" rel="xlink">this PHP article</a>.'
							), htmlspecialchars($plugin_name)
						)
					);
				}
				else // Pass on this check.
				{
					$passes[] = array(
						'title'   => $this->__('<code>$_SERVER[\'SERVER_ADDR\']</code>'),
						'message' => sprintf(
							$this->__(
								'Your server reports this value: <code>%1$s</code>'
							), htmlspecialchars($_SERVER['SERVER_ADDR'])
						)
					);
				}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && $plugin_dir_names) // Have plugin dirs?
			{
				foreach(preg_split('/[,;]+/', $plugin_dir_names) as $_plugin_dir_name)
				{ // Preserve possible spaces in paths when splitting here.

					if(!($_plugin_dir_name = trim($_plugin_dir_name)))
						continue; // It's empty (possible space).

					$_plugin_dir_name = basename($_plugin_dir_name);
					// Only if these DO exist as WordPress® plugins.
					$_plugin_dir     = WP_PLUGIN_DIR.'/'.$_plugin_dir_name;
					$_plugin_pro_dir = WP_PLUGIN_DIR.'/'.$_plugin_dir_name.'-pro';

					if(is_dir($_plugin_dir) && is_file($_plugin_dir.'/checksum.txt'))
						if(is_readable($_plugin_dir) && is_readable($_plugin_dir.'/checksum.txt'))
							$plugin_checksum_dirs[] = $_plugin_dir;

					if(is_dir($_plugin_pro_dir) && is_file($_plugin_pro_dir.'/checksum.txt'))
						if(is_readable($_plugin_pro_dir) && is_readable($_plugin_pro_dir.'/checksum.txt'))
							$plugin_checksum_dirs[] = $_plugin_pro_dir;
				}
				unset($_plugin_dir_name, $_plugin_dir, $_plugin_pro_dir); // Housekeeping.

				if(!empty($plugin_checksum_dirs) && is_array($plugin_checksum_dirs))
				{
					foreach(array_unique($plugin_checksum_dirs) as $_plugin_checksum_dir)
					{
						$_checksum         = $this->dir_checksum($_plugin_checksum_dir);
						$_release_checksum = file_get_contents($_plugin_checksum_dir.'/checksum.txt');

						if($_checksum !== $_release_checksum) // Plugin has an invalid checksum?
						{
							$warnings[] = array(
								'title'   => sprintf($this->__('Plugin Directory Checksum (<code>%1$s</code>)'),
								                     htmlspecialchars(basename($_plugin_checksum_dir))),
								'message' => sprintf(
									$this->__(
										'Although NOT required, %1$s recommends that you reinstall the following plugin directory: <code>%2$s</code>.'.
										' The checksum for this plugin directory (<code>%3$s</code>), does NOT match up with the official release of this plugin (<code>%4$s</code>).'.
										' An invalid checksum can be caused by an incomplete set of files. Or, by files that should NOT appear in this directory. Or, by corrupted files in this directory.'.
										' Reinstalling the official release of this plugin should correct this issue.<br /><br />'.

										' If all else fails, please check your method of upload. We recommend FTP via <a href="http://filezilla-project.org/" target="_blank" rel="xlink">FileZilla™</a>.'.
										' Also, please be sure the following file extensions are uploaded in <code>ASCII</code> mode (<code>php, html, xml, txt, css, js, ini, pot, po, sql, svg</code>). All other files should be uploaded in <code>BINARY</code> mode. Some FTP applications (like FileZilla™), can be configured to automatically recognize file extensions that should be uploaded in <code>ASCII</code> mode, while all others will be uploaded in <code>BINARY</code> mode by default. With this type of configuration, use upload mode <code>AUTO</code>.'
									), htmlspecialchars($plugin_name), htmlspecialchars($_plugin_checksum_dir), htmlspecialchars($_checksum), htmlspecialchars($_release_checksum)
								)
							);
						}
						else // Pass on this check (checksum matches up).
						{
							$passes[] = array(
								'title'   => sprintf($this->__('Plugin Directory Checksum (<code>%1$s</code>)'),
								                     htmlspecialchars(basename($_plugin_checksum_dir))),
								'message' => sprintf(
									$this->__(
										'Scanned all directories and files in the following plugin directory: <code>%1$s</code>.'.
										' The checksum for this plugin directory (<code>%2$s</code>), matches up with the official release of this plugin (<code>%3$s</code>).'
									), htmlspecialchars($_plugin_checksum_dir), htmlspecialchars($_checksum), htmlspecialchars($_release_checksum)
								)
							);
						}
					} // A little housekeeping here.
					unset($_plugin_checksum_dir, $_checksum, $_release_checksum);
				}
			}
			# --------------------------------------------------------------------------------------------------------------------------

			// Handle email testing here. PHPMailer (catch exceptions below).

			if($is_wp_loaded && $is_test_email && get_bloginfo('admin_email'))
			{
				if(!class_exists('PHPMailer'))
					require_once ABSPATH.WPINC.'/class-phpmailer.php';

				if(!class_exists('SMTP'))
					require_once ABSPATH.WPINC.'/class-smtp.php';

				try // PHPMailer (catch exceptions below).
				{
					$_mailer           = new PHPMailer(TRUE);
					$_mailer->SingleTo = TRUE;
					$_mailer->CharSet  = 'UTF-8';

					$_mailer->SetFrom(get_bloginfo('admin_email'), $plugin_name);
					$_mailer->AddAddress(get_bloginfo('admin_email'), $plugin_name);
					$_mailer->Subject = sprintf($this->__('Test Email (Dependency Scan by: %1$s)'), $plugin_name);

					$_mailer->MsgHTML(
						sprintf(
							$this->__(
								'<p><strong>%1$s</strong></p>'.
								'<p>This message was sent as a test.</p>'.
								'<p>It\'s part of a dependency scan processed by: %2$s.</p>'.
								'<p>A plugin for WordPress®.</p>'
							), htmlspecialchars($_mailer->Subject), htmlspecialchars($plugin_name)
						)
					);
					$_mailer->Send();
				}
				catch(phpmailerException $_mail_exception)
				{
					$_mail_exception = $_mail_exception->getMessage();
				}
				catch(exception $_mail_exception)
				{
					$_mail_exception = $_mail_exception->getMessage();
				}
				unset($_mailer); // A little housekeeping here.
			}
			if($is_wp_loaded && $is_test_email && !get_bloginfo('admin_email'))
			{
				array_unshift( // Push this warning to the top of the stack.
					$warnings, array( // Also applying `hilite` class.
					                  'title'   => $this->__('<span class="hilite">PHPMailer Class (Test Email Msg.)</span>'),
					                  'message' => sprintf(
						                  $this->__(
							                  'Unable to send a test email message, because your installation of WordPress® is NOT yet configured with an administrative email address.'.
							                  ' Please see <a href="http://codex.wordpress.org/Settings_General_Screen" target="_blank" rel="xlink">this article</a> for a quick review of general options for WordPress®.'.
							                  ' Please configure your installation of WordPress®, with an administrative email address.'
						                  ), NULL
					                  )
					)
				);
			}
			else if($is_wp_loaded && $is_test_email && isset($_mail_exception))
			{
				array_unshift( // Push this warning to the top of the stack.
					$warnings, array( // Also applying `hilite` class.
					                  'title'   => $this->__('<span class="hilite">PHPMailer Class (Test Email Msg.)</span>'),
					                  'message' => sprintf(
						                  $this->__(
							                  'We sent a test email message to <code>&lt;%1$s&gt;</code>. Unfortunately, the PHPMailer class threw the following exception: <code>possible email delivery failure</code>.'.
							                  ' Please see <a href="http://www.w3schools.com/php/php_ref_mail.asp" target="_blank" rel="xlink">this article</a> for possible solutions.'.
							                  ' Or consult with your web hosting company about this message.'.
							                  ' Note... this test email was processed by the PHPMailer class (which ships with WordPress®), and it uses PHP\'s built-in <code>mail()</code> function.'.
							                  ' On some servers (particularly Windows® servers), you might need to adjust your <a href="http://www.w3schools.com/php/php_ref_mail.asp" target="_blank" rel="xlink">php.ini file</a>, or configure an SMTP server.'.
							                  '<p style="font-size:110%; margin-left:5px; margin-bottom:0;"><strong>Additional Details (Message From PHP Exception):</strong></p>'.
							                  '<pre style="margin:0 0 0 15px; max-width:100%; max-height:300px; overflow:auto;">%2$s</pre>'
						                  ), htmlspecialchars(get_bloginfo('admin_email')), htmlspecialchars($_mail_exception)
					                  )
					)
				);
			}
			else if($is_wp_loaded && $is_test_email) // Pass.
			{
				array_unshift( // Push this to the top of the stack.
					$passes, array( // Also applying `hilite` class.
					                'title'   => $this->__('<span class="hilite">PHPMailer Class (Test Email Msg.)</span>'),
					                'message' => sprintf(
						                $this->__(
							                'We sent a test email message to <code>&lt;%1$s&gt;</code>.'.
							                ' No errors/exceptions were thrown, leading us to believe the message went through successfully. Please check your email to confirm.'
						                ), htmlspecialchars(get_bloginfo('admin_email'))
					                )
					)
				);
			}
			unset($_mail_exception); // Housekeeping.
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if($report_notices) // Only run these scans if we're reporting notices.
		{
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && (!defined('WP_MEMORY_LIMIT') || !is_string(WP_MEMORY_LIMIT) || !WP_MEMORY_LIMIT))
			{
				$notices[] = array(
					'auto_fix' => 'wp_memory_limit',
					'title'    => $this->__('WordPress® Memory Limit'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that you raise your WordPress® memory limit (please set: <code>WP_MEMORY_LIMIT</code> in <code>/wp-config.php</code>), to at least <code>64M</code> (i.e. 64 megabytes).'.
							' Please see: <a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank" rel="xlink">this how-to article</a>.'.
							' Or consult with your web hosting company about this message. Your current memory limit is NOT yet defined.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && $this->abbr_bytes(WP_MEMORY_LIMIT) < 64 * 1024 * 1024)
			{
				$notices[] = array(
					'auto_fix' => 'wp_memory_limit',
					'title'    => $this->__('WordPress® Memory Limit'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that you raise your WordPress® memory limit (please set: <code>WP_MEMORY_LIMIT</code> in <code>/wp-config.php</code>), to at least <code>64M</code> (i.e. 64 megabytes).'.
							' Please see: <a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank" rel="xlink">this how-to article</a>.'.
							' Or consult with your web hosting company about this message. Your current memory limit allows only: <code>%2$s</code>'
						), htmlspecialchars($plugin_name), htmlspecialchars(WP_MEMORY_LIMIT)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® Memory Limit'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® memory limit (<code>WP_MEMORY_LIMIT</code> in <code>/wp-config.php</code>, or by default), is set to: <code>%1$s</code>'
						), htmlspecialchars(WP_MEMORY_LIMIT)
					)
				);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && (!defined('WP_MAX_MEMORY_LIMIT') || !is_string(WP_MAX_MEMORY_LIMIT) || !WP_MAX_MEMORY_LIMIT))
			{
				$notices[] = array(
					'auto_fix' => 'wp_max_memory_limit',
					'title'    => $this->__('WordPress® MAX Memory Limit'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that you raise your WordPress® MAX memory limit (please set: <code>WP_MAX_MEMORY_LIMIT</code> in <code>/wp-config.php</code>), to at least <code>256M</code> (i.e. 256 megabytes).'.
							' Please see: <a href="http://wordpress.org/support/topic/how-to-set-wp_max_memory_limit" target="_blank" rel="xlink">this how-to article</a>.'.
							' Or consult with your web hosting company about this message. Your current MAX memory limit is NOT yet defined.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && $this->abbr_bytes(WP_MAX_MEMORY_LIMIT) < 256 * 1024 * 1024)
			{
				$notices[] = array(
					'auto_fix' => 'wp_max_memory_limit',
					'title'    => $this->__('WordPress® MAX Memory Limit'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that you raise your WordPress® MAX memory limit (please set: <code>WP_MAX_MEMORY_LIMIT</code> in <code>/wp-config.php</code>), to at least <code>256M</code> (i.e. 256 megabytes).'.
							' Please see: <a href="http://wordpress.org/support/topic/how-to-set-wp_max_memory_limit" target="_blank" rel="xlink">this how-to article</a>.'.
							' Or consult with your web hosting company about this message. Your current MAX memory limit allows only: <code>%2$s</code>'
						), htmlspecialchars($plugin_name), htmlspecialchars(WP_MAX_MEMORY_LIMIT)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® MAX Memory Limit'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® MAX memory limit (<code>WP_MAX_MEMORY_LIMIT</code> in <code>/wp-config.php</code>, or by default), is set to: <code>%1$s</code>'
						), htmlspecialchars(WP_MAX_MEMORY_LIMIT)
					)
				);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && defined('WP_HTTP_BLOCK_EXTERNAL') && WP_HTTP_BLOCK_EXTERNAL)
			{
				$notices[] = array(
					'auto_fix' => 'wp_http_block_external',
					'title'    => $this->__('WordPress® External HTTP Requests'),
					'message'  => sprintf(
						$this->__(
							'Although NOT absolutely required, %1$s HIGHLY recommends that you allow all external HTTP requests (please set: <code>WP_HTTP_BLOCK_EXTERNAL</code> in <code>/wp-config.php</code>), to: <code>FALSE</code>.'.
							' Please see: <a href="http://kovshenin.com/2012/how-to-disable-http-calls-in-wordpress/" target="_blank" rel="xlink">this how-to article</a>.'.
							' Or, consult with your web hosting company about this message. Your are currently blocking all external HTTP requests.'.
							' <strong>IMPORTANT:</strong> unless you have ALSO configured <code>WP_ACCESSIBLE_HOSTS</code>, your current'.
							' configuration of <code>WP_HTTP_BLOCK_EXTERNAL</code> will prevent all outbound communication'.
							' from your site to other remote service APIs.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® External HTTP Requests'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® External HTTP Requests (<code>WP_HTTP_BLOCK_EXTERNAL</code> in <code>/wp-config.php</code>, or by default), is set to: <code>FALSE</code>'
						), NULL
					)
				);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && (!defined('DB_CHARSET') || !is_string(DB_CHARSET) || !DB_CHARSET))
			{
				$notices[] = array(
					'auto_fix' => 'wp_db_charset',
					'title'    => $this->__('WordPress® DB Charset'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with a <code>UTF-8</code> database charset (please set: <code>DB_CHARSET</code> in <code>/wp-config.php</code>).'.
							' Please see <a href="http://codex.wordpress.org/Editing_wp-config.php#Database_character_set" target="_blank" rel="xlink">this article</a> for further details.'.
							' Or consult with your web hosting company about this message. Your current DB charset is NOT yet defined.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && !in_array(strtoupper(DB_CHARSET), array('UTF8', 'UTF-8'), TRUE))
			{
				$notices[] = array(
					'auto_fix' => 'wp_db_charset',
					'title'    => $this->__('WordPress® DB Charset'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with a <code>UTF-8</code> database charset (please set: <code>DB_CHARSET</code> in <code>/wp-config.php</code>).'.
							' Please see <a href="http://codex.wordpress.org/Editing_wp-config.php#Database_character_set" target="_blank" rel="xlink">this article</a> for further details.'.
							' Or consult with your web hosting company about this message. Your current DB charset is set to: <code>%2$s</code>'
						), htmlspecialchars($plugin_name), htmlspecialchars(DB_CHARSET)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® DB Charset'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® database charset (<code>DB_CHARSET</code> in <code>/wp-config.php</code>, or by default), is set to: <code>%1$s</code>'
						), htmlspecialchars(DB_CHARSET)
					)
				);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && (!defined('DB_COLLATE') || !is_string(DB_COLLATE)))
			{
				$notices[] = array(
					'auto_fix' => 'wp_db_collate',
					'title'    => $this->__('WordPress® DB Collation'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with a <code>UTF-8</code> database collation (please set: <code>DB_COLLATE</code> in <code>/wp-config.php</code>, to an empty string; or set it as: <code>utf8_general_ci</code>).'.
							' Please see <a href="http://codex.wordpress.org/Editing_wp-config.php#Database_collation" target="_blank" rel="xlink">this article</a> for further details.'.
							' Or consult with your web hosting company about this message. Your current DB collation is NOT yet defined.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && !in_array(strtolower(DB_COLLATE), array('', 'utf8_general_ci', 'utf8_unicode_ci'), TRUE))
			{
				$notices[] = array(
					'auto_fix' => 'wp_db_collate',
					'title'    => $this->__('WordPress® DB Collation'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with a <code>UTF-8</code> database collation (please set: <code>DB_COLLATE</code> in <code>/wp-config.php</code>, to an empty string; or set it as: <code>utf8_general_ci</code>).'.
							' Please see <a href="http://codex.wordpress.org/Editing_wp-config.php#Database_collation" target="_blank" rel="xlink">this article</a> for further details.'.
							' Or consult with your web hosting company about this message. Your current DB collation is set to: <code>%2$s</code>'
						), htmlspecialchars($plugin_name), htmlspecialchars(DB_COLLATE)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® DB Collation'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® database collation (<code>DB_COLLATE</code> in <code>/wp-config.php</code>, or by default), is set to: %1$s'
						), ((!DB_COLLATE) ? $this->__('<code>an empty string</code>') : '<code>'.htmlspecialchars(DB_COLLATE).'</code>')
					)
				);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			$_blog_charset_encoding = ($is_wp_loaded) ? get_bloginfo('charset') : NULL;

			if($is_wp_loaded && (!is_string($_blog_charset_encoding) || !$_blog_charset_encoding))
			{
				$notices[] = array(
					'auto_fix' => 'wp_charset_encoding',
					'title'    => $this->__('WordPress® Character Encoding'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with <code>UTF-8</code> encoding.'.
							' This can be changed in the Dashboard, under: <code>WordPress -› Settings -› Reading -› Encoding</code>.'.
							' See also: <a href="http://codex.wordpress.org/Glossary#Unicode" target="_blank" rel="xlink">this article</a> about UTF-8.'.
							' Your current encoding configuration is NOT yet defined.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && !in_array(strtoupper($_blog_charset_encoding), array('UTF8', 'UTF-8'), TRUE))
			{
				$notices[] = array(
					'auto_fix' => 'wp_charset_encoding',
					'title'    => $this->__('WordPress® Character Encoding'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured to operate with <code>UTF-8</code> encoding.'.
							' This can be changed in the Dashboard, under: <code>WordPress -› Settings -› Reading -› Encoding</code>.'.
							' See also: <a href="http://codex.wordpress.org/Glossary#Unicode" target="_blank" rel="xlink">this article</a> about UTF-8.'.
							' Your current encoding configuration is set to: <code>%2$s</code>'
						), htmlspecialchars($plugin_name), htmlspecialchars($_blog_charset_encoding)
					)
				);
			}
			else if($is_wp_loaded) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® Character Encoding'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® installation is operating with <code>%1$s</code> encoding, under: <code>WordPress -› Settings -› Reading -› Encoding</code>.'
						), htmlspecialchars($_blog_charset_encoding)
					)
				);
			}
			unset($_blog_charset_encoding); // Housekeeping.

			# --------------------------------------------------------------------------------------------------------------------------

			if(!$this->is_cli() && $is_wp_loaded && !is_multisite() && !empty($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST']))
			{
				// Bypass on Multisite Networks (w/ domain mapping; this could produce false positives).

				$_configured_home_host_name = preg_replace('/\:[0-9]+$/', '', strtolower((string)parse_url(home_url('/'), PHP_URL_HOST)));
				$_configured_site_host_name = preg_replace('/\:[0-9]+$/', '', strtolower((string)parse_url(site_url('/'), PHP_URL_HOST)));
				$_current_host_name         = preg_replace('/\:[0-9]+$/', '', strtolower($_SERVER['HTTP_HOST']));

				if($_configured_home_host_name !== $_current_host_name && $_configured_site_host_name !== $_current_host_name)
				{
					$notices[] = array(
						'title'   => $this->__('WordPress® Home/Site URLs'),
						'message' => sprintf(
							$this->__(
								'Although NOT required, %1$s recommends that your WordPress® installation be configured with a matching HOST name.'.
								' This can be changed in the Dashboard, under: <code>WordPress -> Settings -> General -> WordPress/Site URLs</code>.'.
								' Your current configuration does NOT match: <code>%2$s</code>'
							), htmlspecialchars($plugin_name), htmlspecialchars($_current_host_name)
						)
					);
				}
				else // Pass on this check.
				{
					if($_configured_home_host_name === $_current_host_name)
					{
						$passes[] = array(
							'title'   => $this->__('WordPress® Home URL'),
							'message' => sprintf(
								$this->__(
									'Your WordPress® home URL is configured to run on: <code>%1$s</code>, and that matches the current host name: <code>%2$s</code>'
								), htmlspecialchars($_configured_home_host_name), htmlspecialchars($_current_host_name)
							)
						);
					}
					if($_configured_site_host_name === $_current_host_name)
					{
						$passes[] = array(
							'title'   => $this->__('WordPress Site URL'),
							'message' => sprintf(
								$this->__(
									'Your WordPress® site URL is configured to run on: <code>%1$s</code>, and that matches the current host name: <code>%2$s</code>'
								), htmlspecialchars($_configured_site_host_name), htmlspecialchars($_current_host_name)
							)
						);
					}
				}
				unset($_configured_home_host_name, $_configured_site_host_name, $_current_host_name);
			}
			# --------------------------------------------------------------------------------------------------------------------------

			if($is_wp_loaded && defined('WP_DEBUG') && WP_DEBUG)
			{
				$notices[] = array(
					'auto_fix' => 'wp_debug_mode',
					'title'    => $this->__('WordPress® Debugging Mode'),
					'message'  => sprintf(
						$this->__(
							'Although NOT required, %1$s recommends that your WordPress® installation be configured NOT to run in debugging mode (please set: <code>WP_DEBUG</code> to <code>FALSE</code> in <code>/wp-config.php</code>).'.
							' <strong>If you decide to leave <code>WP_DEBUG</code> enabled, please take note...</strong>'.
							' In <code>WP_DEBUG</code> mode, WordPress® will log debug messages into this file: <code>/wp-content/debug.log</code>.'.
							' Please make ABSOLUTELY sure this file is NOT publicly accessible, as it may contain sensitive server details (in some cases).'.
							' Please see <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug" target="_blank" rel="xlink">this article</a> for further details.'.
							' Or consult with your web hosting company about this message.'
						), htmlspecialchars($plugin_name)
					)
				);
			}
			else if($is_wp_loaded && (!defined('WP_DEBUG') || !WP_DEBUG)) // Pass on this check.
			{
				$passes[] = array(
					'title'   => $this->__('WordPress® Debugging Mode'),
					'message' => sprintf(
						$this->__(
							'Your WordPress® installation is NOT running in debugging mode (<code>WP_DEBUG</code> in <code>/wp-config.php</code>, or by default), is NOT set to <code>TRUE</code>.'
						), NULL
					)
				);
			}
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		// Now let's put everything together.

		if($errors) // Major issues.
			foreach($errors as $_key => $_error)
				$issues[] = array(
					'severity'     => 'error',
					'severity_key' => $_key,
					'data'         => $_error,
					'checksum'     => md5('error'.serialize($_error))
				);
		unset($_key, $_error);

		if($warnings && $report_warnings)
			foreach($warnings as $_key => $_warning)
				$issues[] = array(
					'severity'     => 'warning',
					'severity_key' => $_key,
					'data'         => $_warning,
					'checksum'     => md5('warning'.serialize($_warning))
				);
		unset($_key, $_warning);

		if($notices && $report_notices)
			foreach($notices as $_key => $_notice)
				$issues[] = array(
					'severity'     => 'notice',
					'severity_key' => $_key,
					'data'         => $_notice,
					'checksum'     => md5('notice'.serialize($_notice))
				);
		unset($_key, $_notice);

		if($passes) // Tests passed.
			foreach($passes as $_key => $_pass)
				$passes[$_key] = array(
					'severity'     => 'pass',
					'severity_key' => $_key,
					'data'         => $_pass,
					'checksum'     => md5('pass'.serialize($_pass))
				);
		unset($_key, $_pass);

		# --------------------------------------------------------------------------------------------------------------------------------

		if($is_wp_loaded && $issues) // If we have issues, let's take a look at them.
		{
			if(!is_array($_dismissals = get_option('xd__deps__notice__dismissals')))
				add_option('xd__deps__notice__dismissals', ($_dismissals = array()), '', 'no');
			$_dismissals_require_update = FALSE; // Initialize a FALSE value here.

			foreach($issues as $_key => $_issue) // Loop over each issue.
			{
				// Handle auto-fix requests by site owner.

				if($is_auto_fix && isset($_issue['data']['auto_fix'], $_g['auto_fix']) && $_issue['data']['auto_fix'] === $_g['auto_fix'])
				{
					if(($_auto_fix_response = $this->auto_fix($_issue['data']['auto_fix'])) === TRUE)
					{
						$_retry = remove_query_arg('xd__deps', (string)$_SERVER['REQUEST_URI']);

						$issues[$_key]['data']['message'] .= // Append a successful response.
							sprintf(
								$this->__(
									'<p class="auto-fix-success">'.
									'<strong>AUTO-FIX (success):</strong>'.
									' This issue has been resolved automatically.'.
									' <a href="%1$s">%2$s</a>.'.
									'</p>'
								),
								esc_attr($_retry),
								(($is_stand_alone)
									? $this->__('Click here to re-scan')
									: $this->__('Click here to retry activation'))
							);
					}
					else $issues[$_key]['data']['message'] .= // Append error response.
						sprintf($this->__(
								'<p class="auto-fix-error"><strong>AUTO-FIX (error):</strong> %1$s</p>'
							), $_auto_fix_response
						);
				}
				// Handle warning/notice dismissals by site owner.

				if(in_array($_issue['severity'], array('warning', 'notice'), TRUE))
				{
					if(in_array($_issue['checksum'], $_dismissals, TRUE))
						unset($issues[$_key]);

					else if($is_dismissal && isset($_g['dismiss']) && $_issue['checksum'] === $_g['dismiss'])
					{
						unset($issues[$_key]);
						$_dismissals_require_update = TRUE;
						$_dismissals[]              = $_issue['checksum'];
					}
				}
				// Make sure all conditionals in the return array are accurate.

				if(!isset($issues[$_key])) // Unset by auto-fix or dismissal?
				{
					switch($_issue['severity']) // Unset warning/notice.
					{
						case 'warning':
							unset($warnings[$_issue['severity_key']]);
							break;
						case 'notice':
							unset($notices[$_issue['severity_key']]);
							break;
					}
				}
			}
			unset($_key, $_issue, $_auto_fix_response, $_retry);

			if($_dismissals_require_update) // Update now.
			{
				$_dismissals = array_unique(array_merge($_dismissals));
				update_option('xd__deps__notice__dismissals', $_dismissals);
			}
			unset($_dismissals, $_dismissals_require_update);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		if($is_wp_loaded && (($report_warnings && $report_notices && !$issues) || ($this->is_cli() && !$errors)))
		{
			update_option(
				'xd__deps__last_ok', array(
					'xd_v141226_dev' => TRUE,
					'php_version'     => $php_version,
					'wp_version'      => $wp_version,
					'time'            => time()
				)
			);
		}
		else if($is_wp_loaded && ($issues || !get_option('xd__deps__last_ok')))
		{
			update_option(
				'xd__deps__last_ok', array(
					'xd_v141226_dev' => FALSE,
					'php_version'     => '',
					'wp_version'      => '',
					'time'            => 0
				)
			);
		}
		# --------------------------------------------------------------------------------------------------------------------------------

		// Now let's create a final `$this->check` value.
		// We also make use of some additional sub-routines here, which display reports and/or WordPress® notices.

		if($issues || $is_stand_alone)
		{
			$this->check = array(
				// Primary concern.
				'issues'       => $issues,
				'passes'       => $passes,

				// Some additional boolean values.
				'has_issues'   => (($issues) ? TRUE : FALSE),
				'has_passes'   => (($passes) ? TRUE : FALSE),
				'has_errors'   => (($errors) ? TRUE : FALSE),
				'has_warnings' => (($warnings) ? TRUE : FALSE),
				'has_notices'  => (($notices) ? TRUE : FALSE),

				// The plugin name.
				'plugin_name'  => $plugin_name
			);
			if($is_stand_alone) // Running stand-alone?
			{
				if($is_wp_loaded && (!did_action('init') || ($this->is_function_possible('doing_action') && doing_action('init'))))
					add_action('wp_loaded', array($this, 'display_stand_alone_report'), 1);
				else $this->display_stand_alone_report();
			}
			else if($is_wp_loaded && $maybe_display_wp_admin_notices)
				add_action('all_admin_notices', array($this, 'maybe_display_wp_admin_notices'));

			if($this->is_cli())
				if($errors) // Only deal with errors on command-line.
				{
					printf($this->__('%1$s (Dependency Issues)'), $plugin_name)."\n\n";
					exit(print_r($this->check['issues'], TRUE));
				}
				else return TRUE; // Let them slide.
		}
		else $this->check = TRUE; // TRUE indicates there is nothing to report.

		# --------------------------------------------------------------------------------------------------------------------------------

		return $this->check; // Array with report details, or TRUE (nothing to report).
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to directory checksums.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Calculates the MD5 checksum for an entire directory recursively.
	 *
	 * @param string      $dir The directory we should begin with.
	 *
	 * @param boolean     $ignore_readme_files Optional. Defaults to a TRUE value.
	 *    By default, we ignore README files (e.g. `readme.txt` and `readme.md`).
	 *
	 *    NOTE: No matter what this is set to, we always exclude our default globs.
	 *       See: {@link dir_file_ignore()} for further details on this.
	 *
	 * @param null|string $___root_dir Do NOT pass this. For internal use only.
	 *
	 * @return string An MD5 checksum established collectively, based on all directories/files.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 *
	 * @see xd_v141226_dev\dirs::checksum()
	 */
	public function dir_checksum($dir, $ignore_readme_files = TRUE, $___root_dir = NULL)
	{
		if(!isset($___root_dir)) // Only for the initial caller.
			if(!is_string($dir) || !$dir || !is_bool($ignore_readme_files) || (isset($___root_dir) && !is_string($___root_dir)))
				throw new exception( // Fail here; detected invalid arguments.
					sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
				);
		$checksums   = array(); // Initialize array.
		$dir         = $this->n_dir_seps((string)realpath($dir));
		$___root_dir = !isset($___root_dir) ? $dir : $___root_dir;

		if(!$dir || !is_dir($dir) || !is_readable($dir))
			throw new exception(
				sprintf($this->__('Unable to read directory: `%1$s`'), $dir)
			);
		if($dir !== $___root_dir && $this->dir_file_ignore($dir))
			return ''; // Ignoring this directory.

		if(!($handle = opendir($dir)))
			throw new exception(
				sprintf($this->__('Unable to open directory: `%1$s`'), $dir)
			);
		// Mark each directory in case it happens to be empty. We count empty directories too.
		$relative_dir             = preg_replace('/^'.preg_quote($___root_dir, '/').'(?:\/|$)/', '', $dir);
		$checksums[$relative_dir] = md5($relative_dir); // Establish relative directory checksum.

		// Scan each directory and include each file that it contains; except files we ignore.
		while(($entry = readdir($handle)) !== FALSE) if($entry !== '.' && $entry !== '..') // Ignore dots.
			if($entry !== 'checksum.txt' || $dir !== $___root_dir) // Skip `checksum.txt` in the root directory.
				if(!$ignore_readme_files || !in_array(strtolower($entry), array('readme.txt', 'readme.md'), TRUE))
				{
					if(is_dir($dir.'/'.$entry)) // Recursively scan each sub-directory.
						$checksums[$relative_dir.'/'.$entry] = $this->dir_checksum($dir.'/'.$entry, $ignore_readme_files, $___root_dir);

					else if(!$this->dir_file_ignore($dir.'/'.$entry)) // If NOT ignoring this file.
						$checksums[$relative_dir.'/'.$entry] = md5($relative_dir.'/'.$entry.md5_file($dir.'/'.$entry));
				}
		closedir($handle); // Close directory handle now.

		ksort($checksums, SORT_STRING); // In case order changes from one server to another.

		return md5(implode('', $checksums));
	}

	/**
	 * Determines if a directory/file should be ignored.
	 *
	 * @param string $dir_file The directory/file we are checking.
	 *
	 * @return boolean TRUE if the directory/file should be ignored; FALSE otherwise.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 *
	 * @see xd_v141226_dev\dirs_files::ignore()
	 */
	public function dir_file_ignore($dir_file)
	{
		if(!is_string($dir_file) || !$dir_file)
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		if(!strlen($dir_file_basename = basename($dir_file)))
			return TRUE; // Ignore, it has no basename.

		foreach(explode(';', '.~*;*~;*.bak;.idea;*.iml;*.ipr;*.iws;*.sublime-workspace;*.sublime-project;.git;.gitignore;.gitattributes;CVS;.cvsignore;.svn;_svn;.bzr;.bzrignore;.hg;.hgignore;SCCS;RCS;$RECYCLE.BIN;Desktop.ini;Thumbs.db;ehthumbs.db;.Spotlight-V100;.AppleDouble;.LSOverride;.DS_Store;.Trashes;Icon'."\r".';._*;.elasticbeanstalk') as $_glob)
			if(fnmatch($_glob, $dir_file_basename, FNM_CASEFOLD))
				return TRUE; // Yes, we are ignoring this.
		unset($_glob); // Housekeeping.

		return FALSE; // Not ignoring (default behavior).
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to auto-fix routines.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Attempts to auto-fix one of several possible issues.
	 *
	 * @param string $fixable_issue The issue that needs to be fixed automatically.
	 *    This is identified by the issue itself, through its `auto_fix` value.
	 *
	 * @return boolean|string TRUE if the issue was resolved (i.e. fixed automatically).
	 *    Else, this returns a string message, indicating the reason for failure.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 *
	 * @wp-assertion This is tested via WordPress.
	 */
	public function auto_fix($fixable_issue)
	{
		if(!is_string($fixable_issue)) // Have a valid issue?
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);

		if(!defined('WPINC'))
			return $this->__(
				'WordPress® NOT loaded up.'
			);
		else if(!did_action('set_current_user'))
			return $this->__(
				'WordPress® `set_current_user` hook has NOT been fired yet.'.
				' Unable to check user permissions.'
			);
		else if(!is_super_admin())
			return $this->__(
				'Current user is NOT logged into WordPress®,'.
				' or is NOT a WordPress® Super Admin.'
			);

		switch(strtolower($fixable_issue)) // Attempt auto-fix.
		{
			case 'wp_memory_limit':
				return $this->auto_fix_wp_config_file_constant('WP_MEMORY_LIMIT', "'64M'");

			case 'wp_max_memory_limit':
				return $this->auto_fix_wp_config_file_constant('WP_MAX_MEMORY_LIMIT', "'256M'");

			case 'wp_http_block_external':
				return $this->auto_fix_wp_config_file_constant('WP_HTTP_BLOCK_EXTERNAL', 'FALSE');

			case 'wp_db_charset':
				return $this->auto_fix_wp_config_file_constant('DB_CHARSET', "'utf8'");

			case 'wp_db_collate':
				return $this->auto_fix_wp_config_file_constant('DB_COLLATE', "''");

			case 'wp_charset_encoding':
				return (update_option('blog_charset', 'UTF-8')) ? TRUE : TRUE;

			case 'wp_debug_mode':
				return $this->auto_fix_wp_config_file_constant('WP_DEBUG', 'FALSE');

			default: // Default case handler.
				return $this->__(
					'Sorry, an auto-fix routine has NOT been implemented for this yet.'.
					' This particular issue MUST be fixed manually.'
				);
		}
	}

	/**
	 * Attempts to re-define a WordPress® config file constant.
	 *
	 * @param string $constant The name of a WordPress® config file constant.
	 *
	 * @param string $new_value The new value that should defined for the `$constant`.
	 *    Note, this is always passed as a string, but the value is defined explicitly.
	 *    That is, a `$new_value` string `1`, is actually defined as an integer.
	 *    String values should be wrapped explicitly with single quotes.
	 *
	 * @return boolean|string TRUE if the constant was changed (i.e. fixed automatically).
	 *    Else, this returns a string message, indicating the reason for failure.
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 */
	public function auto_fix_wp_config_file_constant($constant, $new_value)
	{
		if(!is_string($constant) // Must have a valid constant name.
		   || !preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $constant) || !is_string($new_value)
		) throw new exception( // Fail here; detected invalid arguments.
			sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
		);

		if(!defined('WPINC'))
			return $this->__(
				'WordPress® NOT loaded up.'
			);
		else if(!did_action('set_current_user'))
			return $this->__(
				'WordPress® `set_current_user` hook has NOT been fired yet.'.
				' Unable to check user permissions.'
			);
		else if(!is_super_admin())
			return $this->__(
				'Current user is NOT logged into WordPress®;'.
				' or is NOT a WordPress® Super Admin.'
			);
		else if(defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS)
			return $this->__(
				'Your current WordPress® configuration disallows file modifications explicitly.'.
				' Cannot modify files (thus, cannot auto-fix this issue).'
			);

		$wp_config_file['path']                 = ABSPATH.'wp-config.php';
		$wp_config_file['is_readable_writable'] = ( // WordPress® config file is readable/writable?
			is_file($wp_config_file['path']) && is_readable($wp_config_file['path']) && is_writable($wp_config_file['path'])
		);
		if(!$wp_config_file['is_readable_writable'] || !($wp_config_file['contents'] = file_get_contents($wp_config_file['path'])))
			return $this->__(
				'WordPress® config file (<code>/wp-config.php</code>) is NOT readable/writable.'.
				' Please set permissions on this file to <code>777</code> and try again.'
			);

		$_new_config_value       = "define('".str_replace("'", "\\'", $constant)."', ".$new_value." /* XDaRk Core auto-fix. */);";
		$_old_config_value_regex = '/define\s*\(\s*(["\'])'.preg_quote($constant, '/').'\\1\s*,[^\)]+\)\s*;/i';
		$_split                  = preg_split($_old_config_value_regex, $wp_config_file['contents'], 2);
		$_php_tag_regex          = '/^\s*\<\?(?:php)?\s*/i';

		if(count($_split) === 2)
			$_new_wp_config_file_contents = $_split[0].$_new_config_value.$_split[1];
		else $_new_wp_config_file_contents = preg_replace($_php_tag_regex, '<?php'."\n".$_new_config_value."\n", $wp_config_file['contents']);

		if(strpos($_new_wp_config_file_contents, $_new_config_value) !== FALSE)
			if(file_put_contents($wp_config_file['path'], $_new_wp_config_file_contents))
				return TRUE;

		unset($_new_config_value, $_old_config_value_regex, $_split, $_php_tag_regex, $_new_wp_config_file_contents);

		return $this->__('Search/replace failed inside WordPress® config file (<code>/wp-config.php</code>).');
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to stand-alone report generation.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Displays a report for the stand-alone version running as class:
	 *    `deps_x_stand_alone_xd_v141226_dev`.
	 *
	 * @return null Nothing. Simply displays the report, and then exits script execution.
	 *
	 * @throws exception If called upon in an invalid/unexpected scenario.
	 */
	public function display_stand_alone_report()
	{
		if(!$GLOBALS[__FILE__]['is_in_stand_alone_mode'] || !is_array($this->check))
			throw new exception( // This should NEVER happen.
				$this->__('Unknown error. Invalid/unexpected scenario.').
				' '.$this->__('Cannot display stand-alone report data here. This method should NOT have been called upon.')
			);
		$this->ob_end_clean(); // Clean output buffers.

		// HTML document w/ DOCTYPE tag.

		header('Content-Type: text/html; charset=UTF-8');

		echo '<!DOCTYPE html>'.
		     '<html>';

		// Configure `<head>` section.

		echo '<head>';

		echo '<title>'.
		     $this->__('Dependency Scan by').
		     ' '.htmlspecialchars($this->check['plugin_name']).
		     '</title>';

		// Configure styles/icons for HTML output below.

		echo '<style type="text/css">';
		echo 'body { margin:50px auto 50px auto; color:#000000; background:#EEEEEE; font:14px "Trebuchet MS","Arial",sans-serif; }';
		echo 'div.wrapper { margin:auto; width:960px; background:#FFFFFF url("'.$this->icons['plugin'].'") no-repeat right top; border:1px solid #999999; border-radius:5px; padding:25px; box-shadow: 0 0 5px #888888; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo 'a { color:#0E5F0E; text-decoration:underline; }';
		echo 'img.icon { width:24px; height:24px; border:0; margin:0 5px 0 0; vertical-align:middle; }';
		echo 'a[rel~="xlink"] { padding-right:18px; background:url("'.$this->icons['xlink'].'") no-repeat center right; }';
		echo 'hr { border:0; height:1px; color:#DDDDDD; background-color:#DDDDDD; margin:10px 0 10px 0; }';
		echo 'pre,code { font-family:"Consolas",monospace; background:#EEEEEE; }';
		echo 'h1, h2, h3 { margin:0; } h1, h2 { margin-bottom:25px; }';
		echo 'h2 p.tip { margin:5px 0 0 5px; font-size:80%; font-style:italic; }';
		echo 'div.message { word-wrap: break-word; }';
		echo 'span.hilite { background:#FDFB76; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo 'div.tools { float:right; margin:10px 125px 0 0; font-size:60%; }';
		echo 'div.tools a { display:inline-block; margin:0 5px 0 5px; font-weight:bold; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo 'div.auto-fix-dismiss { display:inline-block; margin:0 0 0 5px; }';
		echo 'div.auto-fix-dismiss a { display:inline-block; margin:0 5px 0 5px; font-weight:bold; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo 'p.auto-fix-success { color:#FFFFFF; background:#2C7D2C; border-radius:3px; padding:5px; }';
		echo 'p.auto-fix-error { color:#FFFFFF; background:#B94A28; border-radius:3px; padding:5px; }';
		echo 'p.auto-fix-success a, p.auto-fix-error a { color:#FFFFFF; }';
		echo '</style>';

		$icon['error']   = '<img src="'.$this->icons['error'].'" class="icon" alt="" />';
		$icon['warning'] = '<img src="'.$this->icons['warning'].'" class="icon" alt="" />';
		$icon['notice']  = '<img src="'.$this->icons['notice'].'" class="icon" alt="" />';
		$icon['pass']    = '<img src="'.$this->icons['pass'].'" class="icon" alt="" />';

		echo '</head>';

		// Produce HTML output now (using styles/icons from above).

		echo '<body>';
		echo '<div class="wrapper">';
		echo '<div class="inner-wrap">';

		echo '<h1>'.
		     $this->__('Dependency Scan by').
		     ' <strong>'.htmlspecialchars($this->check['plugin_name']).'</strong>';

		echo '<div class="tools">';
		if(defined('WPINC') && is_super_admin())
		{
			$_test_email              = array(
				'xd__deps' => array(
					'test_email' => 'test_email',
					'checksum'   => $this->generate_checksum('test_email')
				)
			);
			$_test_email_confirmation =
				"onclick=\"return confirm('".$this->__("PLEASE CONFIRM\\nSend a test email message now?")."');\"";

			echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_test_email), (string)$_SERVER['REQUEST_URI'])).'" '.$_test_email_confirmation.'>'.
			     $this->__('Test Email?').
			     '</a>';
			unset($_test_email, $_test_email_confirmation);
		}
		if((defined('WPINC') && !is_ssl()))
		{
			$_test_https = array(
				'xd__deps' => array(
					'test_https' => 'test_https',
					'checksum'   => $this->generate_checksum('test_https')
				)
			);
			echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_test_https), 'https://'.(string)$_SERVER['HTTP_HOST'].(string)$_SERVER['REQUEST_URI'])).'">'.
			     $this->__('Test HTTPS?').
			     '</a>';

			unset($_test_https);
		}
		echo '</div>';
		echo '</div>';
		echo '</h1>';

		// Do we have issues or passes to report back with here?

		if($this->check['has_issues'] || $this->check['has_passes'])
		{
			// Display all of the current issues.

			if($this->check['has_issues'])
			{
				echo '<h2>'.
				     $this->__('The following issues were discovered...').
				     (($this->check['has_notices'] || $this->check['has_warnings'])
					     ? ((defined('WPINC') && is_super_admin())
						     ? $this->__(
							     '<p class="tip">'.
							     '<span>'.
							     '<strong>Tip:</strong>'.
							     ' Notices/warnings can be dismissed (if you MUST); please read carefully.'.
							     '</span>'.
							     '</p>'
						     )
						     : $this->__(
							     '<p class="tip">'.
							     '<span>'.
							     '<strong>Tip:</strong>'.
							     ' For additional functionality, please log into WordPress® as a Super Administrator, then come back and re-run this scan.'.
							     ' Additional functionality includes the ability to dismiss and/or AUTO-FIX some issues.'.
							     '</span>'.
							     '</p>'
						     ))
					     : '').
				     '</h2>';

				foreach($this->check['issues'] as $_key => $_issue)
				{
					echo '<h3>'. // With icon.
					     ((!empty($icon[$_issue['severity']])) ? $icon[$_issue['severity']] : '').'['.strtoupper($_issue['severity']).'] '.$_issue['data']['title'];

					echo '<div class="auto-fix-dismiss">';

					if(!empty($_issue['data']['auto_fix']) && defined('WPINC') && is_super_admin())
					{
						$_auto_fix              = array(
							'xd__deps' => array(
								'auto_fix' => $_issue['data']['auto_fix'],
								'checksum' => $this->generate_checksum($_issue['data']['auto_fix'])
							)
						);
						$_auto_fix_confirmation =
							"onclick=\"return confirm('".$this->__("ARE YOU SURE ABOUT THIS?\\nThis is a PHP routine that will attempt to fix the issue automatically (i.e. to fix it programmatically).\\n\\t\\nBACKUP NOTICE: Please backup all of your files, and all of your database tables before running this routine.\\n\\t\\nNOTE: Please consult with a qualified web developer (or your hosting company) before running this routine. It is always better to have a qualified web developer help you. If you run this routine, you do so at your own risk.")."');\"";

						echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_auto_fix), (string)$_SERVER['REQUEST_URI'])).'" '.$_auto_fix_confirmation.'>'.
						     $this->__('AUTO-FIX<em>!</em>').
						     '</a>';
						unset($_auto_fix, $_auto_fix_confirmation);
					}

					if(in_array($_issue['severity'], array('warning', 'notice'), TRUE) && defined('WPINC') && is_super_admin())
					{
						$_dismiss                = array(
							'xd__deps' => array(
								'dismiss'  => $_issue['checksum'],
								'checksum' => $this->generate_checksum($_issue['checksum'])
							)
						);
						$_dismissal_confirmation =
							"onclick=\"return confirm('".$this->__("ARE YOU SURE ABOUT THIS?\\nYou want to dismiss (i.e. ignore) this message?\\n\\t\\nNOTE: Please consult with a qualified web developer (or your hosting company) before ignoring this message. It is better to fix the underlying cause. If you ignore this message, you do so at your own risk.")."');\"";

						echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_dismiss), (string)$_SERVER['REQUEST_URI'])).'" '.$_dismissal_confirmation.'>'.
						     $this->__('dismiss?').
						     '</a>';
						unset($_dismiss, $_dismissal_confirmation);
					}
					echo '</div>';

					echo '</h3>';

					echo '<div class="message">'.
					     $_issue['data']['message'].
					     '</div>';

					if($_key + 1 < count($this->check['issues']))
						echo '<hr />';
				}
				unset($_key, $_issue); // Just a little housekeeping here.
			}

			// Also display any passes (i.e. something positive?).

			if($this->check['has_passes'])
			{
				if(!$this->check['has_issues'])
					echo '<h2>'. // No issues in this case.
					     $this->__('No issues. Your server configuration looks great!').
					     '</h2>';

				else // With a dividing line in this scenario.
					echo '<hr style="margin-bottom:25px; color:#000000; background-color:#000000;" />'.
					     '<h2>'.
					     $this->__('You passed on all of these scans :-)').
					     '</h2>';

				foreach($this->check['passes'] as $_key => $_pass)
				{
					echo '<h3>'. // With icon.
					     ((!empty($icon[$_pass['severity']])) ? $icon[$_pass['severity']] : '').'['.strtoupper($_pass['severity']).'] '.$_pass['data']['title'].
					     '</h3>';

					echo '<div class="message">'.
					     $_pass['data']['message'].
					     '</div>';

					if($_key + 1 < count($this->check['passes']))
						echo '<hr />';
				}
				unset($_key, $_pass);
			}
		}
		else // Else there is nothing to report back with in this case.
			echo '<h2>'. // Simple default message in this case.
			     $this->__('Nothing to report. Your server looks fine!').
			     '</h2>';

		// Closing tags.

		echo '</div>';
		echo '</body>';
		exit('</html>');
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to report generation inside WordPress®.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Handles administrative notices within WordPress®.
	 *
	 * @attaches-to WordPress® `all_admin_notices` hook.
	 * @hook-priority The default is fine.
	 *
	 * @return null Nothing.
	 *
	 * @throws exception If called upon in an invalid/unexpected scenario.
	 */
	public function maybe_display_wp_admin_notices()
	{
		if(!defined('WPINC'))
			throw new exception( // What the heck?
				$this->__('Unknown error. Invalid/unexpected scenario.').
				' '.$this->__('Cannot display notices. This method should NOT have been called upon.')
			);
		if(!is_admin() || !is_array($this->check) || !$this->check['has_issues'])
			return; // There is nothing we need to display.

		// Configure styles/icons.

		echo '<style type="text/css">';
		$div_notice = 'div.xd-deps-notice';
		echo $div_notice.'.wrapper { background:#FBF6DD url(\''.$this->icons['plugin'].'\') no-repeat right top; border:1px solid #C1B98E; border-radius:5px; }';
		echo $div_notice.' div.inner-wrap { padding:25px; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo $div_notice.' a { text-decoration:underline; }';
		echo $div_notice.' h2.heading { font-size:160%; margin:0 0 25px 0; padding:0; }';
		echo $div_notice.' h3.heading { font-size:130%; margin:0 0 25px 0; padding:0; }';
		echo $div_notice.' h3.heading p.tip { margin:5px 0 0 5px; font-style:italic; }';
		echo $div_notice.' h3.issue, '.$div_notice.' h3.pass { margin:0; padding:0; }';
		echo $div_notice.' hr { border:0; height:1px; color:#DDDDDD; background-color:#DDDDDD; margin:10px 0 10px 0; }';
		echo $div_notice.' a[rel~="xlink"] { padding-right:18px; background:url("'.$this->icons['xlink'].'") no-repeat center right; }';
		echo $div_notice.' img.icon { width:24px; height:24px; border:0; margin:0 5px 0 0; vertical-align:middle; }';
		echo $div_notice.' div.message { word-wrap: break-word; }';
		echo $div_notice.' span.hilite { background:#FDFB76; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo $div_notice.' div.auto-fix-dismiss { display:inline-block; margin:0 0 0 5px; }';
		echo $div_notice.' div.auto-fix-dismiss a { display:inline-block; margin:0 5px 0 5px; font-weight:bold; }';
		echo '</style>';

		echo '<style type="text/css">';
		echo $div_notice.' p.auto-fix-success { color:#FFFFFF; background:#2C7D2C; border-radius:3px; padding:5px; }';
		echo $div_notice.' p.auto-fix-error { color:#FFFFFF; background:#B94A28; border-radius:3px; padding:5px; }';
		echo $div_notice.' p.auto-fix-success a, p.auto-fix-error a { color:#FFFFFF; }';
		echo '</style>';

		$icon['error']   = '<img src="'.$this->icons['error'].'" class="icon" alt="" />';
		$icon['warning'] = '<img src="'.$this->icons['warning'].'" class="icon" alt="" />';
		$icon['notice']  = '<img src="'.$this->icons['notice'].'" class="icon" alt="" />';
		$icon['pass']    = '<img src="'.$this->icons['pass'].'" class="icon" alt="" />';

		// Produce HTML output now (using styles/icons from above).

		echo '<div class="xd-deps-notice wrapper updated fade">';
		echo '<div class="inner-wrap">';

		echo '<h2 class="heading">'.
		     $this->__('Dependency Scan by').
		     ' <strong>'.esc_html($this->check['plugin_name']).'</strong>'.
		     '</h2>';

		echo '<h3 class="heading">'.
		     sprintf($this->__('The following issues are preventing full activation of %1$s.'),
		             esc_html($this->check['plugin_name'])).
		     (($this->check['has_notices'] || $this->check['has_warnings'])
			     ? ((is_super_admin())
				     ? $this->__(
					     '<p class="tip">'.
					     '<span>'.
					     '<strong>Tip:</strong>'.
					     ' Notices/warnings can be dismissed (if you MUST); please read carefully.'.
					     '</span>'.
					     '</p>'
				     )
				     : $this->__(
					     '<p class="tip">'.
					     '<span>'.
					     '<strong>Tip:</strong>'.
					     ' For additional functionality, please log into WordPress® as a Super Administrator.'.
					     ' Additional functionality includes the ability to dismiss and/or AUTO-FIX some issues.'.
					     '</span>'.
					     '</p>'
				     ))
			     : '').
		     '</h3>';
		// Display all of the current issues.

		foreach($this->check['issues'] as $_key => $_issue)
		{
			echo '<h3 class="issue">'. // With icon.
			     ((!empty($icon[$_issue['severity']])) ? $icon[$_issue['severity']] : '').'['.strtoupper($_issue['severity']).'] '.$_issue['data']['title'];

			echo '<div class="auto-fix-dismiss">';

			if(!empty($_issue['data']['auto_fix']) && is_super_admin())
			{
				$_auto_fix              = array(
					'xd__deps' => array(
						'auto_fix' => $_issue['data']['auto_fix'],
						'checksum' => $this->generate_checksum($_issue['data']['auto_fix'])
					)
				);
				$_auto_fix_confirmation =
					"onclick=\"return confirm('".$this->__("ARE YOU SURE ABOUT THIS?\\nThis is a PHP routine that will attempt to fix the issue automatically (i.e. to fix it programmatically).\\n\\t\\nBACKUP NOTICE: Please backup all of your files, and all of your database tables before running this routine.\\n\\t\\nNOTE: Please consult with a qualified web developer (or your hosting company) before running this routine. It is always better to have a qualified web developer help you. If you run this routine, you do so at your own risk.")."');\"";

				echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_auto_fix), (string)$_SERVER['REQUEST_URI'])).'" '.$_auto_fix_confirmation.'>'.
				     $this->__('AUTO-FIX<em>!</em>').
				     '</a>';
				unset($_auto_fix, $_auto_fix_confirmation);
			}

			if(in_array($_issue['severity'], array('warning', 'notice'), TRUE) && is_super_admin())
			{
				$_dismiss                = array(
					'xd__deps' => array(
						'dismiss'  => $_issue['checksum'],
						'checksum' => $this->generate_checksum($_issue['checksum'])
					)
				);
				$_dismissal_confirmation =
					"onclick=\"return confirm('".$this->__("ARE YOU SURE ABOUT THIS?\\nYou want to dismiss (i.e. ignore) this message?\\n\\t\\nNOTE: Please consult with a qualified web developer (or your hosting company) before ignoring this message. It is better to fix the underlying cause, and then re-activate the plugin. If you ignore this message, you do so at your own risk.")."');\"";

				echo '<a href="'.esc_attr(add_query_arg(urlencode_deep($_dismiss), (string)$_SERVER['REQUEST_URI'])).'" '.$_dismissal_confirmation.'>'.
				     $this->__('dismiss?').
				     '</a>';
				unset($_dismiss, $_dismissal_confirmation);
			}
			echo '</div>';

			echo '</h3>';

			echo '<div class="message">'.
			     $_issue['data']['message'].
			     '</div>';

			if($_key + 1 < count($this->check['issues']))
				echo '<hr />';
		}
		unset($_key, $_issue); // Just a little housekeeping here.

		// Also display any passes (i.e. something positive?).

		if($this->check['has_passes']) // Has passes?
		{
			echo '<hr style="margin:25px 0 25px 0; color:#000000; background-color:#000000;" />';

			echo '<h3 class="heading">'.
			     $this->__('You passed on all of these scans :-)').
			     '</h3>';

			foreach($this->check['passes'] as $_key => $_pass)
			{
				echo '<h3 class="pass">'. // With icon.
				     ((!empty($icon[$_pass['severity']])) ? $icon[$_pass['severity']] : '').'['.strtoupper($_pass['severity']).'] '.$_pass['data']['title'].
				     '</h3>';

				echo '<div class="message">'.
				     $_pass['data']['message'].
				     '</div>';

				if($_key + 1 < count($this->check['passes']))
					echo '<hr />';
			}
			unset($_key, $_pass);
		}
		// Closing tags.

		echo '</div>';
		echo '</div>';
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Miscellaneous utility methods (many taken from parts of the XDaRk Core).
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Dashes replace non-alphanumeric chars.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::with_dashes()
	 * @inheritdoc xd_v141226_dev::with_dashes()
	 */
	public function with_dashes($string)
	{
		if(!is_string($string))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		$string = str_replace('\\', '--', $string);
		return preg_replace('/[^a-z0-9]/i', '-', $string);
	}

	/**
	 * Underscores replace non-alphanumeric chars.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::with_underscores()
	 * @inheritdoc xd_v141226_dev::with_underscores()
	 */
	public function with_underscores($string)
	{
		if(!is_string($string))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		$string = str_replace('\\', '__', $string);
		return preg_replace('/[^a-z0-9]/i', '_', $string);
	}

	/**
	 * Acquires the currently installed version of Apache.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev\env::apache_version()
	 * @inheritdoc xd_v141226_dev\env::apache_version()
	 */
	public function apache_version()
	{
		if(isset(self::$static[__FUNCTION__]))
			return self::$static[__FUNCTION__];

		$regex = '/Apache\/(?P<version>[1-9][0-9]*\.[0-9][^\s]*)/i';

		if($this->is_function_possible('apache_get_version'))
			if(($apache_get_version = apache_get_version()) && preg_match($regex, $apache_get_version, $apache))
				return (self::$static[__FUNCTION__] = $apache['version']);

		if(!empty($_SERVER['SERVER_SOFTWARE']) && is_string($_SERVER['SERVER_SOFTWARE']))
			if(preg_match($regex, $_SERVER['SERVER_SOFTWARE'], $apache))
				return (self::$static[__FUNCTION__] = $apache['version']);

		if(!$this->is_function_possible('shell_exec') || ini_get('open_basedir'))
			return (self::$static[__FUNCTION__] = ''); // Not possible.

		if(!($httpd_v = @shell_exec('/usr/bin/env httpd -v'))
		   && !($httpd_v = @shell_exec('/usr/bin/env apachectl -v'))
		) // If both of these, let's search just a little more.
		{
			$_possible_httpd_locations = array(
				'/usr/sbin/httpd', '/usr/bin/httpd',
				'/usr/sbin/apache2', '/usr/bin/apache2',
				'/usr/local/sbin/httpd', '/usr/local/bin/httpd',
				'/usr/local/apache/sbin/httpd', '/usr/local/apache/bin/httpd',
			);
			foreach($_possible_httpd_locations as $_httpd_location) if(is_file($_httpd_location))
				if(($httpd_v = @shell_exec(escapeshellarg($_httpd_location).' -v')))
					break; // All done here.
			unset($_possible_httpd_locations, $_httpd_location);
		}
		if($httpd_v && preg_match($regex, $httpd_v, $apache))
			return (self::$static[__FUNCTION__] = $apache['version']);

		return (self::$static[__FUNCTION__] = ''); // Unable to determine.
	}

	/**
	 * Is a particular function, static method, or PHP language construct possible?
	 *
	 * @return boolean {@inheritdoc}
	 *
	 * @see xd_v141226_dev\functions::is_possible()
	 * @inheritdoc xd_v141226_dev\functions::is_possible()
	 */
	public function is_function_possible($function)
	{
		if(!is_string($function))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		$function = ltrim(strtolower($function), '\\'); // Clean this up before checking.

		if(!isset(self::$static[__FUNCTION__][$function]))
		{
			self::$static[__FUNCTION__][$function] = FALSE;

			if((in_array($function, $this->constructs, TRUE) || is_callable($function) || function_exists($function))
			   && !in_array($function, $this->disabled_functions(), TRUE) // And it is NOT disabled in some way.
			) self::$static[__FUNCTION__][(string)$function] = TRUE;
		}
		return self::$static[__FUNCTION__][$function];
	}

	/**
	 * Gets all disabled PHP functions.
	 *
	 * @return array {@inheritdoc}
	 *
	 * @see xd_v141226_dev\functions::disabled()
	 * @inheritdoc xd_v141226_dev\functions::disabled()
	 */
	public function disabled_functions()
	{
		if(isset(self::$static[__FUNCTION__]))
			return self::$static[__FUNCTION__];

		self::$static[__FUNCTION__] = array();

		if(!function_exists('ini_get'))
			return self::$static[__FUNCTION__];

		if(($_ini_val = trim(strtolower(ini_get('disable_functions')))))
			self::$static[__FUNCTION__] = array_merge(self::$static[__FUNCTION__], preg_split('/[\s;,]+/', $_ini_val, NULL, PREG_SPLIT_NO_EMPTY));
		unset($_ini_val); // Housekeeping.

		if(($_ini_val = trim(strtolower(ini_get('suhosin.executor.func.blacklist')))))
			self::$static[__FUNCTION__] = array_merge(self::$static[__FUNCTION__], preg_split('/[\s;,]+/', $_ini_val, NULL, PREG_SPLIT_NO_EMPTY));
		unset($_ini_val); // Housekeeping.

		if(filter_var(ini_get('suhosin.executor.disable_eval'), FILTER_VALIDATE_BOOLEAN))
			self::$static[__FUNCTION__] = array_merge(self::$static[__FUNCTION__], array('eval'));

		return self::$static[__FUNCTION__]; // All disabled functions.
	}

	/**
	 * Converts an abbreviated byte notation into bytes.
	 *
	 * @return float {@inheritdoc}
	 *
	 * @see xd_v141226_dev\files::abbr_bytes()
	 * @inheritdoc xd_v141226_dev\files::abbr_bytes()
	 */
	public function abbr_bytes($string)
	{
		if(!is_string($string)) // Require input string argument value.
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
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
	 * Normalizes directory/file separators.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::n_dir_deps()
	 * @inheritdoc xd_v141226_dev::n_dir_deps()
	 */
	public function n_dir_seps($dir_file, $allow_trailing_slash = FALSE)
	{
		if(!is_string($dir_file) || !is_bool($allow_trailing_slash))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		if(!isset($dir_file[0])) return ''; // Catch empty string.

		if(strpos($dir_file, '://' !== FALSE)) // Quick check here for optimization.
		{
			if(!isset(self::$static[__FUNCTION__.'__regex_stream_wrapper']))
				self::$static[__FUNCTION__.'__regex_stream_wrapper'] = substr($this->regex_valid_dir_file_stream_wrapper, 0, -2).'/';
			if(preg_match(self::$static[__FUNCTION__.'__regex_stream_wrapper'], $dir_file, $stream_wrapper)) // A stream wrapper?
				$dir_file = preg_replace(self::$static[__FUNCTION__.'__regex_stream_wrapper'], '', $dir_file);
		}
		if(strpos($dir_file, ':' !== FALSE)) // Quick drive letter check here for optimization.
		{
			if(!isset(self::$static[__FUNCTION__.'__regex_win_drive_letter']))
				self::$static[__FUNCTION__.'__regex_win_drive_letter'] = substr($this->regex_valid_win_drive_letter, 0, -2).'/';
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
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::n_dir_seps_up()
	 * @inheritdoc xd_v141226_dev::n_dir_seps_up()
	 */
	public function n_dir_seps_up($dir_file, $up = 1, $allow_trailing_slash = FALSE)
	{
		if(!is_string($dir_file) || !is_integer($up) || !is_bool($allow_trailing_slash))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		if(!isset($dir_file[0])) return ''; // Catch empty string.

		$had_trailing_slash = in_array(substr($dir_file, -1), array(DIRECTORY_SEPARATOR, '\\', '/'), TRUE);

		for($_i = 0; $_i < abs($up); $_i++)
			$dir_file = dirname($dir_file);
		unset($_i); // Housekeeping.

		if($had_trailing_slash) $dir_file .= '/';

		return $this->n_dir_seps($dir_file, $allow_trailing_slash);
	}

	/**
	 * Attempts to get `/wp-load.php`.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::wp_load()
	 * @inheritdoc xd_v141226_dev::wp_load()
	 */
	public function wp_load($get_last_value = FALSE, $check_abspath = TRUE, $fallback = NULL)
	{
		if(!is_bool($get_last_value) || !is_bool($check_abspath) || !(is_null($fallback) || is_bool($fallback) || is_string($fallback)))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		if($get_last_value && isset(self::$static[__FUNCTION__]))
			return self::$static[__FUNCTION__];

		if($check_abspath && defined('ABSPATH') && is_file($_wp_load = ABSPATH.'wp-load.php'))
			return (self::$static[__FUNCTION__] = $this->n_dir_seps($_wp_load));

		if(($_wp_load = $this->locate('/wp-load.php')))
			return (self::$static[__FUNCTION__] = $_wp_load);

		if(!isset($fallback)) // Auto-detection.
			$fallback = defined('___DEV_KEY_OK');

		if($fallback) // Fallback on local dev copy?
		{
			if(is_string($fallback))
				$dev_dir = $this->n_dir_seps($fallback);
			else $dev_dir = $this->n_dir_seps(self::$local_wp_dev_dir);

			if(is_file($_wp_load = $dev_dir.'/wp-load.php'))
				return (self::$static[__FUNCTION__] = $_wp_load);
		}
		unset($_wp_load); // Housekeeping.

		return (self::$static[__FUNCTION__] = ''); // Failure.
	}

	/**
	 * Locates a specific directory/file path.
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::locate()
	 * @inheritdoc xd_v141226_dev::locate()
	 */
	public function locate($dir_file, $starting_dir = '__DIR__')
	{
		if(!is_string($dir_file) || !$dir_file || !is_string($starting_dir) || !$starting_dir)
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		$dir_file = ltrim($this->n_dir_seps($dir_file), '/'); // Relative.

		if($starting_dir === '__DIR__') // Using this for PHP v5.2 compatibility.
			$starting_dir = $this->n_dir_seps_up(__FILE__); // Current directory.

		else if(in_array($starting_dir, array('phar://', 'phar://__DIR__'), TRUE)) // With a PHAR stream wrapper?
			$starting_dir = 'phar://'.preg_replace(substr($this->regex_valid_dir_file_stream_wrapper, 0, -2).'/', '', $this->n_dir_seps_up(__FILE__));

		for($_i = 0, $_dir = $this->n_dir_seps($starting_dir); $_i <= 100; $_i++)
		{
			if($_i > 0) // Up one directory now?
				$_dir = $this->n_dir_seps_up($_dir, 1, TRUE);

			if(!$_dir || $_dir === '.' || substr($_dir, -1) === ':')
				break; // Search complete (we're beyond even a root directory or scheme now).

			if(file_exists($_dir.'/'.$dir_file))
				return $this->n_dir_seps($_dir.'/'.$dir_file);

			if(substr($_dir, -1) === '/') // Root directory or scheme?
				break; // Search complete (there is nothing more to search after this).
		}
		unset($_i, $_dir); // Housekeeping.

		return ''; // Failure.
	}

	/**
	 * Checksum to help prevent attacks.
	 *
	 * @param string $value Any string value.
	 *
	 * @return string Checksum (based on `$this->security_salt().$value`).
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 */
	public function generate_checksum($value)
	{
		if(!is_string($value))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		return md5($this->security_salt().$value);
	}

	/**
	 * Verify checksum to help prevent attacks.
	 *
	 * @param string $value The string value we're testing.
	 *
	 * @param string $checksum The checksum that we're testing.
	 *
	 * @return boolean TRUE if the checksum matches, else FALSE (possible attack).
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 */
	public function verify_checksum($value, $checksum)
	{
		if(!is_string($value) || !is_string($checksum))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		return ($checksum === $this->generate_checksum($value));
	}

	/**
	 * Get salt to help prevent attacks.
	 *
	 * @return string MD5 checksum, of the first available salt.
	 *
	 * @throws exception If unable to generate a security salt, for any reason.
	 */
	public function security_salt()
	{
		if(defined('WPINC'))
		{
			if(defined('NONCE_SALT'))
				if(NONCE_SALT && is_string(NONCE_SALT))
					return md5(NONCE_SALT);

			if(defined('AUTH_SALT'))
				if(AUTH_SALT && is_string(AUTH_SALT))
					return md5(AUTH_SALT);
		}
		if(!empty($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST']))
			return md5($_SERVER['HTTP_HOST']);

		throw new exception($this->__('Unable to generate a security salt.'));
	}

	/**
	 * Checks to see if we're in a localhost environment.
	 *
	 * @return boolean {@inheritdoc}
	 *
	 * @see xd_v141226_dev\env::is_localhost()
	 * @inheritdoc xd_v141226_dev\env::is_localhost()
	 */
	public function is_localhost()
	{
		if(!isset(self::$static[__FUNCTION__]))
		{
			self::$static[__FUNCTION__] = FALSE;

			if(defined('LOCALHOST') && LOCALHOST)
				self::$static[__FUNCTION__] = TRUE;

			else if(preg_match('/(?:localhost|127\.0\.0\.1|\.loc$)/i', $_SERVER['HTTP_HOST']))
				self::$static[__FUNCTION__] = TRUE;
		}
		return self::$static[__FUNCTION__];
	}

	/**
	 * Checks to see if we're running under a command line interface.
	 *
	 * @return boolean {@inheritdoc}
	 *
	 * @see xd_v141226_dev\env::is_cli()
	 * @inheritdoc xd_v141226_dev\env::is_cli()
	 */
	public function is_cli()
	{
		if(!isset(self::$static[__FUNCTION__]))
		{
			self::$static[__FUNCTION__] = FALSE;

			if(strcasecmp(PHP_SAPI, 'cli') === 0)
				self::$static[__FUNCTION__] = TRUE;
		}
		return self::$static[__FUNCTION__];
	}

	/**
	 * Cleans any existing output buffers.
	 *
	 * @return boolean {@inheritdoc}
	 *
	 * @see xd_v141226_dev\env::ob_end_clean()
	 * @inheritdoc xd_v141226_dev\env::ob_end_clean()
	 */
	public function ob_end_clean()
	{
		$ob_levels = ob_get_level(); // Cleans output buffers.
		for($ob_level = 0; $ob_level < $ob_levels; $ob_level++)
			@ob_end_clean(); // May fail on a locked buffer.
		unset($ob_levels, $ob_level);

		return ob_get_level() ? FALSE : TRUE;
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to activation/deactivation of the XDaRk Core.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Removes data/procedures associated with this class.
	 *
	 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
	 *    If this is FALSE, nothing will happen; and this method returns FALSE.
	 *
	 * @return boolean TRUE if successfully uninstalled.
	 *
	 * @see deps_xd_v141226_dev::___uninstall___()
	 *
	 * @throws exception If invalid types are passed through arguments list.
	 */
	public function ___uninstall___($confirmation = FALSE)
	{
		if(!is_bool($confirmation))
			throw new exception( // Fail here; detected invalid arguments.
				sprintf($this->__('Invalid arguments: `%1$s`'), print_r(func_get_args(), TRUE))
			);
		if(!defined('WPINC') || !$confirmation)
			return FALSE; // Added security.

		delete_option('xd__deps__last_ok');
		delete_option('xd__deps__notice__dismissals');

		return TRUE;
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Methods related to translations.
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Handles core translations for this class (context: admin-side).
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::__()
	 * @inheritdoc xd_v141226_dev::__()
	 */
	public function __($string)
	{
		$core_ns_stub_with_dashes = 'xd'; // Core namespace stub w/ dashes.
		$string                   = (string)$string; // Typecasting this to a string value.
		$context                  = $core_ns_stub_with_dashes.'--admin-side'; // Admin side.

		return (defined('WPINC')) ? _x($string, $context, $core_ns_stub_with_dashes) : $string;
	}

	/**
	 * Handles core translations for this class (context: front-side).
	 *
	 * @return string {@inheritdoc}
	 *
	 * @see xd_v141226_dev::_x()
	 * @inheritdoc xd_v141226_dev::_x()
	 */
	public function _x($string, $other_contextuals = '')
	{
		$core_ns_stub_with_dashes = 'xd'; // Core namespace stub w/ dashes.
		$string                   = (string)$string; // Typecasting this to a string value.
		$other_contextuals        = (string)$other_contextuals; // Typecasting this to a string value.
		$context                  = $core_ns_stub_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

		return (defined('WPINC')) ? _x($string, $context, $core_ns_stub_with_dashes) : $string;
	}

	# --------------------------------------------------------------------------------------------------------------------------------------
	# Additional properties; (see also: top of this file).
	# --------------------------------------------------------------------------------------------------------------------------------------

	/**
	 * PHP's language constructs.
	 *
	 * @var array PHP's language constructs.
	 *    Keys are currently unimportant. Subject to change.
	 */
	public $constructs = array(
		'die'             => 'die',
		'echo'            => 'echo',
		'empty'           => 'empty',
		'exit'            => 'exit',
		'eval'            => 'eval',
		'include'         => 'include',
		'include_once'    => 'include_once',
		'isset'           => 'isset',
		'list'            => 'list',
		'require'         => 'require',
		'require_once'    => 'require_once',
		'return'          => 'return',
		'print'           => 'print',
		'unset'           => 'unset',
		'__halt_compiler' => '__halt_compiler'
	);

	/**
	 * @var string A directory/file stream wrapper validation pattern.
	 *
	 * @see xd_v141226_dev::$regex_valid_dir_file_stream_wrapper
	 * @inheritdoc xd_v141226_dev::$regex_valid_dir_file_stream_wrapper
	 */
	public $regex_valid_dir_file_stream_wrapper = '/^[a-zA-Z0-9]+\:\/\/$/';

	/**
	 * @var string A directory/file drive letter validation pattern (for Windows®).
	 *
	 * @see xd_v141226_dev::$regex_valid_win_drive_letter
	 * @inheritdoc xd_v141226_dev::$regex_valid_win_drive_letter
	 */
	public $regex_valid_win_drive_letter = '/^[a-zA-Z]\:(?:\/|\\\\)$/';

	/**
	 * Array of base 64 encoded PNG icons.
	 *
	 * @var array PNG icons.
	 */
	public $icons = array(
		'error'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEEElEQVR42s2Va2wUVRTH/3dmOn1tt8u23b63BW0MQmIgQVJEVOSRSHdJSkRitFb5QqLxizF8UuojxugXY2JQE8MXXx+A2lbUNhIxKG0CJK3YYEu3S9dut/vqe7vdeV3PTMmSZcVW1MRJbu7dc885v7nnP/csw3/8sP8VYKip+agOXnvv1+0v/OuAod1eXrRxLTgTEPvVh/t6OlcVuyqna3u8vMLzAGRRAY9FkVIYfBcD2NzdvmL8ig7XvQePiY6iNte2dVBHRihChCSLCIzMIrGotG3qOv3aPwL4HmniNUe8SP3YA1ZSSRYOHpmEZHfiyi8RbO3+it0xILDvQKRwy/qyPGEKOQ/tR86OPZZdOdcD7dQJTCVyEAovhO//pr3izgB7m3lF6y6kzn0H24cdGXtzLR7kllfhylAcW7pOsb8NCO7Zz+3e7ZASIWh+P2zHT2cCnn4MUrkbc7MJ+IPz2PZtB1s1YNJ78HVWUvSK89ENUHx+GKHxbECrF5KrFjJpMuifRlLV3mjsOPnqqgChnU3c/tRuWoxaX40RmoDt/S8yfGYe3gihqh6CqkKXCnAppmLX92fYioCw9/FOuaHGk7/JDT4ehB6PQbvci+Kzv2X4xdcWQKy9G1B1yDpH//UYwkne1bwQ8/4lIHKghTsONSLZ3QFjegqCKMMYHYHjYigT0GBPA5gGyAZD1+A4nkjE2W0Bkzv2TuQ2lFfKYhjaYmp52+AwfMNw9AVvC+Aqh6QDv8cXMBCdDTy5MFWXBQi76jzaktrpfKcF6s994JJkBVsA/ygcF8YyAeudECvr0wCmGigivU4OB82s3kNz8a4MQCivlNvbnoXu66cguq2mUbsBmJlGzs4mFL70puW78PZRpL48AdFZS76aBQABRCpTMqHgzHgEh5MzLA2IuuqOweVsK3imEfrVYbII4IaxDNBpVlTqQ1dhTE4vH9teSKMYor0iA8A1jiLOcHYihmhy6aOWxdkjFmBScHD7Jy9DO/8DIEpW0jTAPEEkBNt7n0PasNkCaAOXMPdcM4Ti0nSJTAAIINBsiv5pIIjnU/OMRddU98meB7cKbomaWJx6Gc8G+K6RyOOZGtzjgFi9LgtgzrkUNjgzj/75uSiL5pVx2/EXoVw4T3dKpuRaNmCMRP7pVpFLSWT3nwLMkU+l+mxiAixaVs9t77ZC6e0lQczy6FkAJBIAtefCtz6AUFJBjW4ftNEhiI6qtAb8FoCTcn0cDBDAUT2W59nuZncJwHzyJkAzLxANWjMq29LAIAUq5t8BWH4+aSUi11EOpJZPICg3ATIV4XJ8xizR8lcUXlMzRjnccNlg0LU36O11xojDodMGpbB+m4fRuW7NKtkNgms39jVaW/4wEF1SyG4EDi/O1v0BdaNJ3oB8YjwAAAAASUVORK5CYII=',
		'warning' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEbElEQVR42s2VfUxVZRzHv8859417FQy4pCEvYmO0JF2jQXOWLok54bpe1kbLNbNNEnOrlm5tBtHKGS5t/pVu4VDnH2ALKBxYMccoxx/lCkx5Gy+Xt3u5L+B9Py9Pv3OQuzkK6G3r7pw95z7nPN/P8/v+fr9zGP7jH/tfAUbqS48qHBk5r3596F8HjJzbya25mwEuwnf7Z+RWXFvR2hU9NFpXzFO3lsJgiQLRKcTCDGOdv+KRyvZl1y/7wOQlR5WwKrn6gcfzIc/eoggMMBhFTPV6EfIHq/P2t3zwjwDOs9t5WtnrkKabwIzr9TkedUI0pqK/YxD5h5eOYsmbU5d2uxLyCu2mpBmMD0yga3oPBIGhKLUJ6x8yYG7aBPeAe3rTwda1fw9w/lmeUvIyJNeXqP2qID7vcs3gxN4hmGwZ6P/BiUcPtLC/DHBfLOa2JxxkhRPK3ACOXXhYn/f7fRgfH0MjOS+aNyDoD8DZ68aWyqtsxQBPg6OGJdqPJW4pgOTvAw8P480zdrjdLgQCQUTCIbSfTtYBRgPH4E9TNBf7cPOBpvdXBJip38FtT5UD8h29anhoFCWHJsFVBZIkQVEUdJwIgCXkQOAxKLINPd138eSR79iyAG+jo9mYnldmzs4h4REokWkonk4Uv5sKmYRVWSGAjOs1fRCtOaA/MDCO290euJzhlpJzQceSAF/Di3zV9jJExy+DxzxgzAQ+O4Cnj2TQTmWoFIWqqOg6PkKAjToAdBgZw7eNgyitC7E/BXjqt02YsjeuM6RMQIlS13K6zTn4XB+2HrZD0cRVlaziuPGJMw7gEoeoVd1wED033aN7vghmLQJ4T9vLlFCkOfG1tyBPXidtw/zudMAQCg+unhfn2snRfcpNSc6KAxhFZTWLaL0yTOXFHGVn77bcB5j5yMJtL70NNdJNySVRbVK9B4h6saMiirkIXavAaouK70/OQhSpsykfGgCyCoHkonNRtLdNoPxymMUBvs/sVUiyV1ue2QnV20uigr5THaBqo4TBnn4SkuJ2ZmdbIQoP3gfQRquZ4cfOabg94c9fOB+u0AGeKoHbKmqhuFoJadSF4wAtgvAERocDONP1nC5eWdSIzDQTBENK3CINAPpYMBoZVVpDsxP7GqKM+T5dc8NYsKtQSDeCB920nC8GzPXj+eOPwefzQorFYLUm4Op7vRAtGxYBIKlUUSoG78ziZl/AzXwfW7h1fw29La+RX2YCyIsAo31j2HsymZosBplKVaEd1r3hR/6mtX8IgKTALHJcaZsE851K5dZX3iFAB5hK9nBlHoCFHGiLgthXw9EzHKIpBbnpBlw46qEkr4vngGuABRBtINEEXPxmggC1SSPmol2ZyBLoaxW6B1jYvUxQ8pQ61T90C21dou5gyTbAZhVgNFOSpXmAoAvTTSpXA0X/2y9ezaL5KvLWrhmh5slEmp0KRmsklZ5j+rVCEWhBKNR0nCzQY6NRpnP+tcE1Tchki0IQRXsTz0TIKT5afjGc9TsS2Z5A9IxylgAAAABJRU5ErkJggg==',
		'notice'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAE+UlEQVR42q1VXUwUVxg9d2Z22ZU/+dnSLrBrAwYBW2AJoASipab2gZJQYmqa1Cftz0Mba036QEyITdtIG0ykSU1NTJrGmPrTaH0xfdJUJCiFWgQNsAFkgUUEKrDAsrtz+907swubPrXhJjt35s4395zzfee7y0Ajo2VgT2qa7cL+oqTsFCsD5zCGKi4MjBmP0ZlzY43Lt2Io8kahny8Qwa3B5dt6mO/3feIOsvTmvj37KtJu/diQjYkljujeckPzgT5HhFCfB4II62FkJidC0Rh0viHaREsg5EQNePOSH/cOORlzfzXg6/+8MPvG2AqW1qKMxK5KbPPR2VUM+Rdiez31TmGbKx01Htc6gLJOyp2kwhIO4a3zT1rZkevjvL7UgcllHRqLaaZ4ZspmGHm2ikPFKchLjsHj8OVh1FW6EQ7r66Qolku1QEWGBUd+GRtjH14b52U7HNAjuhm0rkKIEACPpgP4qDQ9DqC+vRvv1pcQQMRIK8VF31KJkGZT0XpzHKzuvJcf2O2UTKIR6gZGAmBqcQ3vFSbHALyLHGc7J1D0soPY6pKVAsR9b7MoOPPbKNhrPwzypupsyURUipm5NxwjE4XFoI5ihwXFaVb5rn9+DT3+IF5KshJbHqc4+q0AaL0xBlZ79jFv2p2DIKVI25AfMammjX6fDIH7p+X98sKynHeWuuHK3PIvxVEwAfBz9zRYTfsAb6rJRdBMEYvFGgVTyNxdU5Si4kQ0uCyYXdLRMRfBT/0B1DothvllvBIjJi5WTcGVrimwirY+3rg3F3poXaLKFFOBsdYxFUJblR256Xb5fnxuBce6VrA3xyb7QzDR6aLA7COdIcFGAHcnwDynHvDG192IkAJRUI30zq1yTK/oeLoUEX2Mjh4/+o/mxwGUtHuxq+xFJFIqHJSpF+waOUeh5hO9QPuQ5y/f9YGVnerljXXbMBPQMTCzhumFMCIUpalMqlc1C7wDU+g7XhAHUN42iPxXnNB1XR4dQoaVjhkntXFBOkNWogWXbpNNXcc6uMOzDXPzIdpMkXZTSQUjmcwqCsjg/WsSj07sjAN49cs+5Hvc5CJqtAjFUjlYRPQAk2lzplow0j8JZn/7Gs+qKwNClA4CEBYTIIwkMlF3WhvpHsXw1+VxAEXN3cjbnQcuzcFkrZhZbFEH1apg4oFPAFzlmbUeKlJEFkuDwYJFG43yOnZ3BKOnq+IACj7rgqt2OxHTpdMkGatQzqUDVVWB/yEBJDRc4ck1pcBaWDaZZKEZNhX+ZgkqfHcGcf2bvWTTBAnw65MgDrR0IqcijxyjxymWGygCQMXMnyP0WP39uaR9tYcVK7WZyCeizWICEFDw2ZJc6Wkpk7OnpRf2rVtgpU6WCWEs1jsQrSFalm4nb3b5jUy8cWHcUrg9R8nYCpXOFpEi1fxDUYmZQlZc9c1jxesThkdqRQGsNk2eakzlkoiiKhKAWVWE5lfx9/2H0FcCzvXjsbLtJJIyPiX4JHCzYopxvgs2qsMhZ7kJQWvOLKipdiPnxEafXUSIfuFpP0LPFy/xjg/e2XD+/cdR9V0CFWzQvmeXi9ls8kgMDo0iNDT8Pu5/fG5j6P8DiKk+06tUV5dq6SkIDwxDHxssR+fRns0DkCDfXsSOkoNYDdJ/6+NK3Dt+f3MBxCg7eREpmQcRmK9Cd/O9zQcQw/PFVdrtNP44cWfj8j9UfNOrCyXvvwAAAABJRU5ErkJggg==',
		'xlink'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAYAAABy6+R8AAABGElEQVQokX1RMU7DQBAc352MTSC4gdYVElTIaajT5gMRSYEEpojyC0QBFPmHa/gFpEIUrtDRRCAFRwbFxk68FJFQ7s7KVKudGe3OrgUNV+E9zWY/8LwdnUJZLjCZfBl9BCeXtAn9s2sSuokL9l/7flfhpIzAOAPTTbpIysjoi+FgRE/jGABQVYQ8KxSB73chZaRMFen3HI8PtwCAJEnR690YBmNSc3cb+wfeKg9nsKx6w3qtZNpybGRZaYjWUZQLKNdrNBx0Oqc4Oj7HXtMFEZDnBVzXXmVeVgiCQ2A4GBm/yOa/9PmRUBy/UysIychUt4Lj2nBcG5wzMGYZPKuWVe3umyBeXt8QXtyBcfPP02mKdruF57Ha/wMD85DqBSR4DwAAAABJRU5ErkJggg==',
		'plugin'  => 'data:image/png;base64,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',
		'pass'    => 'data:image/png;base64,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'
	);

}

# -----------------------------------------------------------------------------------------------------------------------------------------
# Static initializer routine. This define a few static vars; also creates class aliases.
# -----------------------------------------------------------------------------------------------------------------------------------------

if(${__FILE__}['is_in_stand_alone_mode']) // Running in Stand-Alone mode?
	deps_x_stand_alone_xd_v141226_dev::initialize();
else deps_x_xd_v141226_dev::initialize();

# -----------------------------------------------------------------------------------------------------------------------------------------
# Inline/automatic stand-alone handlers (if applicable).
# -----------------------------------------------------------------------------------------------------------------------------------------
/*
 * Running in Stand-Alone mode?
 *
 * @note MUST remain PHP v5.2 compatible.
 * @note Replicates into `[...-]stand-alone.php`.
 * @note Class name MUST be modified before running stand-alone.
 */
if(${__FILE__}['is_in_stand_alone_mode']) // Running in Stand-Alone mode?
{
	/** @var string Plugin name. */
	define('___STAND_ALONE__PLUGIN_NAME', 'XDaRk Core'); #!stand-alone-plugin-name!#

	/** @var string Plugin directory names (comma-delimited). */
	define('___STAND_ALONE__PLUGIN_DIR_NAMES', 'xd-v141226-dev'); #!stand-alone-plugin-dir-names!#

	$deps_x_stand_alone_xd_v141226_dev = new deps_x_stand_alone_xd_v141226_dev();

	if(!defined('WPINC') && $deps_x_stand_alone_xd_v141226_dev->wp_load())
		require_once $deps_x_stand_alone_xd_v141226_dev->wp_load(TRUE);

	$deps_x_stand_alone_xd_v141226_dev->check();
}