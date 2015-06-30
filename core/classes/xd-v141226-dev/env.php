<?php
/**
 * Environment.
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
	 * Environment.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class env extends framework
	{
		/**
		 * Is the current User-Agent a browser?
		 *
		 * @return boolean {@inheritdoc}
		 *
		 * @see \xd_v141226_dev::is_browser()
		 * @inheritdoc \xd_v141226_dev::is_browser()
		 */
		public function is_browser() // Arguments are NOT listed here.
		{
			return call_user_func_array(array('\\xd_v141226_dev', 'is_browser'), func_get_args());
		}

		/**
		 * Checks to see if we're in a localhost environment.
		 *
		 * @return boolean TRUE if we're in a localhost environment.
		 *
		 * @see \deps_x_xd_v141226_dev::is_localhost()
		 */
		public function is_localhost()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('LOCALHOST') && LOCALHOST)
				$this->static[__FUNCTION__] = TRUE;

			else if(preg_match('/(?:localhost|127\.0\.0\.1|\.loc$)/i', $this->©url->current_host()))
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're in a Unix environment.
		 *
		 * @return boolean TRUE if we're in a Unix environment.
		 */
		public function is_unix()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(stripos(PHP_OS, 'win') !== 0)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're in a Windows® environment.
		 *
		 * @return boolean TRUE if we're in a Windows® environment.
		 */
		public function is_windows()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(stripos(PHP_OS, 'win') === 0)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're running under an Apache web server.
		 *
		 * @return boolean TRUE if we're running under an Apache web server.
		 */
		public function is_apache()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(is_string($server_software = $this->©vars->_SERVER('SERVER_SOFTWARE'))
			   && stripos($server_software, 'apache') !== FALSE
			) $this->static[__FUNCTION__] = TRUE;

			else if($this->©function->is_possible('apache_get_version'))
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're running under a LiteSpeed web server.
		 *
		 * @return boolean TRUE if we're running under a LiteSpeed web server.
		 */
		public function is_litespeed()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(is_string($server_software = $this->©vars->_SERVER('SERVER_SOFTWARE')))
				if(stripos($server_software, 'litespeed') !== FALSE)
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're running under an Apache-compatible web server.
		 *
		 * @return boolean TRUE if we're running under an Apache-compatible web server.
		 */
		public function is_apache_compatible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->is_apache() || $this->is_litespeed())
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Acquires the currently installed version of Apache.
		 *
		 * @return string Current Apache version (if running Apache); and if it's possible to detect the version.
		 *    Otherwise, if not running Apache (or we're unable to detect the version) an empty string.
		 *
		 * @see \deps_x_xd_v141226_dev::apache_version()
		 */
		public function apache_version()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$regex = '/Apache\/(?P<version>[1-9][0-9]*\.[0-9][^\s]*)/i';

			if($this->©function->is_possible('apache_get_version'))
				if(($apache_get_version = apache_get_version()) && preg_match($regex, $apache_get_version, $apache))
					return ($this->static[__FUNCTION__] = $apache['version']);

			if(!empty($_SERVER['SERVER_SOFTWARE']) && is_string($_SERVER['SERVER_SOFTWARE']))
				if(preg_match($regex, $_SERVER['SERVER_SOFTWARE'], $apache))
					return ($this->static[__FUNCTION__] = $apache['version']);

			if(!$this->©commands->possible()) return ($this->static[__FUNCTION__] = '');

			if(!($httpd_v = $this->©command->exec('/usr/bin/env httpd -v'))
			   && !($httpd_v = $this->©command->exec('/usr/bin/env apachectl -v'))
			) // If both of these, let's search just a little more.
			{
				$_possible_httpd_locations = array(
					'/usr/sbin/httpd', '/usr/bin/httpd',
					'/usr/sbin/apache2', '/usr/bin/apache2',
					'/usr/local/sbin/httpd', '/usr/local/bin/httpd',
					'/usr/local/apache/sbin/httpd', '/usr/local/apache/bin/httpd',
				);
				foreach($_possible_httpd_locations as $_httpd_location) if(is_file($_httpd_location))
					if(($httpd_v = $this->©command->exec(escapeshellarg($_httpd_location).' -v')))
						break; // All done here.
				unset($_possible_httpd_locations, $_httpd_location);
			}
			if($httpd_v && preg_match($regex, $httpd_v, $apache))
				return ($this->static[__FUNCTION__] = $apache['version']);

			return ($this->static[__FUNCTION__] = ''); // Unable to determine.
		}

		/**
		 * Checks to see if we're running under a command line interface.
		 *
		 * @return boolean TRUE if we're running under a command line interface.
		 *
		 * @see \deps_x_xd_v141226_dev::is_cli()
		 */
		public function is_cli()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(strcasecmp(PHP_SAPI, 'cli') === 0)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're running a CRON job.
		 *
		 * @return boolean TRUE if we're running a CRON job.
		 */
		public function is_cron_job()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('DOING_CRON') && DOING_CRON)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're running a systematic routine.
		 *
		 * @return boolean TRUE if we're running a systematic routine.
		 */
		public function is_systematic_routine()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->is_cli()) $this->static[__FUNCTION__] = TRUE;
			else if($this->is_wp_login()) $this->static[__FUNCTION__] = TRUE;
			else if(defined('WP_INSTALLING') && WP_INSTALLING) $this->static[__FUNCTION__] = TRUE;
			else if(defined('WP_REPAIRING') && WP_REPAIRING) $this->static[__FUNCTION__] = TRUE;
			else if(defined('APP_REQUEST') && APP_REQUEST) $this->static[__FUNCTION__] = TRUE;
			else if(defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) $this->static[__FUNCTION__] = TRUE;
			else if(defined('DOING_CRON') && DOING_CRON) $this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if we're currently on `/wp-login.php`.
		 *
		 * @return boolean TRUE if we're currently on `/wp-login.php`.
		 */
		public function is_wp_login()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(strpos($this->©url->current_uri(), '/wp-login.php') !== FALSE)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Determines whether or not this is a multisite farm.
		 *
		 * @return boolean TRUE if `MULTISITE_FARM` is TRUE inside `/wp-config.php`.
		 */
		public function is_multisite_farm()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(is_multisite() && defined('MULTISITE_FARM') && MULTISITE_FARM)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Determines whether or not we're in `WP_DEBUG` mode.
		 *
		 * @return boolean TRUE if we're in `WP_DEBUG` mode.
		 */
		public function is_in_wp_debug_mode()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('WP_DEBUG') && WP_DEBUG)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Determines whether or not we're in `WP_DEBUG_LOG` mode.
		 *
		 * @return boolean TRUE if we're in `WP_DEBUG_LOG` mode.
		 */
		public function is_in_wp_debug_log_mode()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Determines whether or not we're in `WP_DEBUG_DISPLAY` mode.
		 *
		 * @return boolean TRUE if we're in `WP_DEBUG_DISPLAY` mode.
		 */
		public function is_in_wp_debug_display_mode()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Is Quick Cache™ installed/active?
		 *
		 * @return boolean TRUE if Quick Cache™ is installed/active.
		 */
		public function has_qc_active()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('QUICK_CACHE_ENABLE') && QUICK_CACHE_ENABLE)
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Is BuddyPress™ installed/active?
		 *
		 * @return boolean TRUE if BuddyPress™ is installed/active.
		 */
		public function has_bp_active()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if(defined('BP_VERSION') && did_action('bp_core_loaded'))
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * String with current time details.
		 *
		 * @return string String with time representation (in UTC time).
		 */
		public function time_details()
		{
			$date = $this->©date->i18n_utc('D M jS, Y');
			$time = $this->©date->i18n_utc('g:i:s a e');

			$details = $date.' '.$this->_x('@ precisely').' '.$time;

			return $details; // Return all details.
		}

		/**
		 * Acquires information about memory usage.
		 *
		 * @return string `Memory x MB :: Real Memory x MB :: Peak Memory x MB :: Real Peak Memory x MB`.
		 */
		public function memory_details()
		{
			$memory           = $this->©files->bytes_abbr((float)memory_get_usage());
			$real_memory      = $this->©files->bytes_abbr((float)memory_get_usage(TRUE));
			$peak_memory      = $this->©files->bytes_abbr((float)memory_get_peak_usage());
			$real_peak_memory = $this->©files->bytes_abbr((float)memory_get_peak_usage(TRUE));

			$details = 'Memory '.$memory.
			           ' :: Real Memory '.$real_memory.
			           ' :: Peak Memory '.$peak_memory.
			           ' :: Real Peak Memory '.$real_peak_memory;

			return $details;
		}

		/**
		 * String with all version details (for PHP, WordPress®, current plugin).
		 *
		 * @return string `PHP vX.XX :: WordPress® vX.XX :: Plugin vX.XX + Pro Add-On`.
		 */
		public function version_details()
		{
			$details = 'PHP v'.PHP_VERSION.
			           ' :: WordPress® v'.WP_VERSION.
			           ' :: '.$this->instance->plugin_name.' v'.$this->instance->plugin_version;
			$details .= ($this->©plugin->has_pro_loaded()) ? ' :: + Pro Add-On' : '';

			return $details;
		}

		/**
		 * Current HTTP referer (i.e. the referring URL).
		 *
		 * @return string Current HTTP referer (i.e. the referring URL).
		 */
		public function http_referer()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = '';

			$current_url      = $this->©url->current();
			$current_uri      = $this->©url->current_uri();
			$_wp_http_referer = $this->©vars->_REQUEST('_wp_http_referer');
			$http_referer     = $this->©vars->_SERVER('HTTP_REFERER');

			if($this->©string->is_not_empty($_wp_http_referer)
			   && $_wp_http_referer !== $current_url
			   && $this->©url->parse_uri($_wp_http_referer) !== $current_uri
			) $this->static[__FUNCTION__] = $_wp_http_referer;

			else if($this->©string->is_not_empty($http_referer)
			        && $http_referer !== $current_url
			        && $this->©url->parse_uri($http_referer) !== $current_uri
			) $this->static[__FUNCTION__] = $http_referer;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Gets the current administrative area.
		 *
		 * @return string Current administrative area, else an empty string.
		 */
		public function admin_area()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = '';

			if(!is_admin()) // NOT in admin area.
				$this->static[__FUNCTION__] = '';

			else if(is_multisite() && is_network_admin())
				$this->static[__FUNCTION__] = 'network-admin';

			else if(is_blog_admin())
				$this->static[__FUNCTION__] = 'blog-admin';

			else if(is_user_admin())
				$this->static[__FUNCTION__] = 'user-admin';

			return $this->static[__FUNCTION__];
		}

		/**
		 * Gets the current administrative page.
		 *
		 * @return string Current administrative page, else an empty string.
		 */
		public function admin_page()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = '';

			if(!is_admin()) // NOT in admin area.
				$this->static[__FUNCTION__] = '';

			else if(!$this->©string->¤is_not_empty($this->static[__FUNCTION__] = $this->©vars->_REQUEST('page')))
				$this->static[__FUNCTION__] = $this->©string->is_not_empty_or($GLOBALS['pagenow'], '');

			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks if we're on a specific administrative page.
		 *
		 * @param string $slug_or_file Optional. Defaults to an empty string (i.e. any admin page).
		 *    If this is a non-empty string, we'll test for a specific administrative page slug (or file name).
		 *
		 * @return boolean TRUE if we're currently on an administrative page.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_admin_page($slug_or_file = '')
		{
			$this->check_arg_types('string', func_get_args());

			if(is_admin() && (!$slug_or_file || $slug_or_file === $this->admin_page()))
				return TRUE;

			return FALSE; // Default return value.
		}

		/**
		 * Is this WordPress® installation using fancy permalinks?
		 *
		 * @return boolean TRUE if this WordPress® installation is using fancy permalinks.
		 */
		public function uses_fancy_permalinks()
		{
			return get_option('permalink_structure') ? TRUE : FALSE;
		}

		/**
		 * Is this WordPress® installation disallowing files mods?
		 *
		 * @return boolean TRUE if this WordPress® installation disallowing files mods.
		 */
		public function disallows_file_mods()
		{
			return defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS;
		}

		/**
		 * Cleans any existing output buffers.
		 *
		 * @return boolean TRUE if all output buffers are cleaned.
		 *    This can return FALSE if a locked output buffer exists.
		 *
		 * @note It is not possible to clean a locked buffer.
		 */
		public function ob_end_clean()
		{
			$ob_levels = ob_get_level(); // Cleans output buffers.
			for($ob_level = 0; $ob_level < $ob_levels; $ob_level++)
				@ob_end_clean(); // May fail on a locked buffer.
			unset($ob_levels, $ob_level);

			return ob_get_level() ? FALSE : TRUE;
		}

		/**
		 * Enables ALL error reporting (and we display errors).
		 */
		public function enable_all_error_reporting()
		{
			error_reporting(-1);
			ini_set('display_errors', TRUE);
		}

		/**
		 * Ignore user abortions. Continue running behind-the-scene.
		 */
		public function ignore_user_abort()
		{
			ignore_user_abort(TRUE);
		}

		/**
		 * Increases MySQL `wait_timeout` for current session.
		 *
		 * @param integer $timeout Optional. Defaults to `300` seconds.
		 */
		public function increase_db_wait_timeout($timeout = 300)
		{
			$timeout = (integer)$timeout;

			if(isset($this->static[__FUNCTION__]))
				if($this->static[__FUNCTION__] >= $timeout)
					return; // Did this already.

			$this->static[__FUNCTION__] = $timeout;

			$this->©db->query('SET SESSION `wait_timeout` = '.$timeout);
		}

		/**
		 * Maximizes memory and time limitations.
		 */
		public function maximize_time_memory_limits()
		{
			set_time_limit(0);

			$limit = WP_MAX_MEMORY_LIMIT;

			if(is_admin() && current_user_can('manage_options'))
				$limit = apply_filters('admin_memory_limit', $limit);

			ini_set('memory_limit', $limit);
		}

		/**
		 * Preps a CRON procedure.
		 */
		public function prep_for_cron_procedure()
		{
			if(!$this->is_cron_job())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_cron_job', get_defined_vars(),
					$this->__('NOT a CRON job.')
				);
			$this->ignore_user_abort();
			$this->maximize_time_memory_limits();
			$this->increase_db_wait_timeout(900);
		}

		/**
		 * Preps a development procedure from the command-line.
		 */
		public function prep_for_cli_dev_procedure()
		{
			if(!$this->is_cli())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#not_cli', get_defined_vars(),
					$this->__('NOT a command-line interface.')
				);
			$this->enable_all_error_reporting();

			$this->ob_end_clean();
			$this->ignore_user_abort();
			$this->maximize_time_memory_limits();
			$this->increase_db_wait_timeout(900);
		}

		/**
		 * Preps for a file to be downloaded from the server.
		 */
		public function prep_for_file_download()
		{
			$this->ob_end_clean();
			$this->©headers->no_cache();
			$this->©env->disable_gzip();
			$this->maximize_time_memory_limits();
		}

		/**
		 * Attempts to disable GZIP compression.
		 *
		 * @param null|boolean $content_encoding_none Optional. Defaults to an auto-detect behavior.
		 *    If we're in the administration panel we will automatically send `Content-Encoding: none` to further prevent GZIP conflicts.
		 *    Or, this can set to explicitly enable/disable this default auto-detect behavior.
		 */
		public function disable_gzip($content_encoding_none = NULL)
		{
			$this->check_arg_types(array('null', 'boolean'), func_get_args());

			ini_set('zlib.output_compression', 0);

			if($this->©function->is_possible('apache_setenv'))
				apache_setenv('no-gzip', '1');

			$content_encoding_none = $this->apply_filters('disable_gzip_via_content_encoding_none', $content_encoding_none);

			if($content_encoding_none || (!isset($content_encoding_none) && is_admin() && !headers_sent()))
				$this->©headers->content_encoding('none');
		}

		/**
		 * Get the current visitor's real IP address.
		 *
		 * @return string Real IP address, else an empty string on failure.
		 */
		public function ip() // IP address.
		{
			return $this->©ip->get();
		}
	}
}