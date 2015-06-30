<?php
/**
 * URL Utilities.
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
	 * URL Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120329
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class urls extends framework
	{
		/**
		 * @var string Regex matches a `scheme://`.
		 */
		public $regex_frag_scheme = '(?:[a-zA-Z0-9]+\:)?\/\/';

		/**
		 * @var string Regex matches a `host` name (TLD optional).
		 */
		public $regex_frag_host = '[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?';

		/**
		 * @var string Regex matches a `host:port` (`:port`, TLD are optional).
		 */
		public $regex_frag_host_port = '[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?';

		/**
		 * @var string Regex matches a `user:pass@host:port` (`user:pass@`, `:port`, TLD are optional).
		 */
		public $regex_frag_user_host_port = '(?:[a-zA-Z0-9\-_.~+%]+(?:\:[a-zA-Z0-9\-_.~+%]+)?@)?[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?';

		/**
		 * @var string Regex matches a valid `scheme://user:pass@host:port/path/?query#fragment` URL (`scheme:`, `user:pass@`, `:port`, `TLD`, `path`, `query` and `fragment` are optional).
		 */
		public $regex_valid_url = '/^(?:[a-zA-Z0-9]+\:)?\/\/(?:[a-zA-Z0-9\-_.~+%]+(?:\:[a-zA-Z0-9\-_.~+%]+)?@)?[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?(?:\:[0-9]+)?(?:\/(?!\/)[a-zA-Z0-9\-_.~+%]*)*(?:\?(?:[a-zA-Z0-9\-_.~+%]+(?:\=[a-zA-Z0-9\-_.~+%&]*)?)*)?(?:#[^\s]*)?$/';

		/**
		 * Regex matches page on the end of a path.
		 *
		 * @return string Regex matches page on the end of a path.
		 */
		public function regex_wp_pagination_page()
		{
			return '/(?P<page>\/'.preg_quote($GLOBALS['wp_rewrite']->pagination_base, '/').'\/(?P<page_number>[0-9]+)\/?)(?=[?#]|$)/';
		}

		/**
		 * Gets the current URL (via environment variables).
		 *
		 * @param string $scheme Optional. A scheme to force. (i.e. `https`, `http`).
		 *    Use `//` to force a cross-protocol compatible scheme.
		 *
		 * @note If `$scheme` is NOT passed in (or is empty), we detect the current scheme, and use that by default.
		 *    For instance, if this `is_ssl()`, an SSL scheme will be used; else `http`.
		 *
		 * @return string The current URL, else an exception is thrown on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to determine the current URL.
		 */
		public function current($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			if(isset($this->static[__FUNCTION__][$scheme]))
				return $this->static[__FUNCTION__][$scheme];

			$this->static[__FUNCTION__][$scheme] = $this->current_scheme().'://'.$this->current_host().$this->current_uri();
			if($scheme) $this->static[__FUNCTION__][$scheme] = $this->set_scheme($this->static[__FUNCTION__][$scheme], $scheme);

			return $this->static[__FUNCTION__][$scheme];
		}

		/**
		 * Gets the current scheme (via environment variables).
		 *
		 * @return string The current scheme, else an exception is thrown on failure.
		 *
		 * @throws exception If unable to determine the current scheme.
		 */
		public function current_scheme()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$scheme = $this->©vars->_SERVER('REQUEST_SCHEME');

			if($this->©string->is_not_empty($scheme))
				$this->static[__FUNCTION__] = $this->n_scheme($scheme);
			else $this->static[__FUNCTION__] = (is_ssl()) ? 'https' : 'http';

			return $this->static[__FUNCTION__];
		}

		/**
		 * Gets the current host name (via environment variables).
		 *
		 * @return string The current host name, else an exception is thrown on failure.
		 *
		 * @throws exception If unable to determine the current host name.
		 */
		public function current_host()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$host = $this->©vars->_SERVER('HTTP_HOST');

			if(!$this->©string->is_not_empty($host))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_server_http_host', get_defined_vars(),
					$this->__('Missing required `$_SERVER[\'HTTP_HOST\']`.')
				);
			return ($this->static[__FUNCTION__] = $host);
		}

		/**
		 * Gets the current URI (via environment variables).
		 *
		 * @return string The current URI, else an exception is thrown on failure.
		 *
		 * @throws exception If unable to determine the current URI.
		 */
		public function current_uri()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			if(is_string($uri = $this->©vars->_SERVER('REQUEST_URI')))
				$uri = $this->parse_uri($uri);

			if(!$this->©string->is_not_empty($uri))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_server_request_uri', get_defined_vars(),
					$this->__('Missing required `$_SERVER[\'REQUEST_URI\']`.')
				);
			return ($this->static[__FUNCTION__] = $uri);
		}

		/**
		 * Parses a URL (or a URI/query/fragment only) into an array.
		 *
		 * @param string       $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @note A query string or fragment MUST be prefixed with the appropriate delimiters.
		 *    This is bad `name=value` (interpreted as path). This is good `?name=value` (query string).
		 *    This is bad `anchor` (interpreted as path). This is good `#fragment` (fragment).
		 *
		 * @param null|integer $component Same as PHP's `parse_url()` component.
		 *    Defaults to NULL; which defaults to an internal value of `-1` before we pass to PHP's `parse_url()`.
		 *
		 * @param null|integer $normalize A bitmask. Defaults to NULL (indicating a default bitmask).
		 *    Defaults include: {@link fw_constants::url_scheme}, {@link fw_constants::url_host}, {@link fw_constants::url_path}.
		 *    However, we DO allow a trailing slash (even if path is being normalized by this parameter).
		 *
		 * @return array|string|integer|null If a component is requested, returns a string component (or an integer in the case of `PHP_URL_PORT`).
		 *    If a specific component is NOT requested, this returns a full array, of all component values.
		 *    Else, this returns NULL on any type of failure (even if a component was requested).
		 *
		 * @note Arrays returned by this method, will include a value for each component (a bit different from PHP's `parse_url()` function).
		 *    We start with an array of defaults (i.e. all empty strings, and `0` for the port number).
		 *    Components found in the URL are then merged into these default values.
		 *    The array is also sorted by key (e.g. alphabetized).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function parse($url_uri_query_fragment, $component = NULL, $normalize = NULL)
		{
			$this->check_arg_types('string', array('null', 'integer'), array('null', 'integer'), func_get_args());

			if(!isset($normalize)) // Use defaults?
				$normalize = $this::url_scheme | $this::url_host | $this::url_path;

			if(strpos($url_uri_query_fragment, '//') === 0 && preg_match($this->regex_valid_url, $url_uri_query_fragment))
			{
				$url_uri_query_fragment = $this->current_scheme().':'.$url_uri_query_fragment; // So URL is parsed properly.
				// Works around a bug in `parse_url()` prior to PHP v5.4.7. See: <http://php.net/manual/en/function.parse-url.php>.
				$x_protocol_scheme = TRUE; // Flag this, so we can remove scheme below.
			}
			else $x_protocol_scheme = FALSE; // No scheme; or scheme is NOT cross-protocol compatible.

			$parsed = @parse_url($url_uri_query_fragment, ((!isset($component)) ? -1 : $component));

			if($x_protocol_scheme) // Cross-protocol scheme?
			{
				if(!isset($component) && is_array($parsed))
					$parsed['scheme'] = ''; // No scheme.

				else if($component === PHP_URL_SCHEME)
					$parsed = ''; // No scheme.
			}
			if($normalize & $this::url_scheme) // Normalize scheme?
			{
				if(!isset($component) && is_array($parsed))
				{
					if(!$this->©string->is($parsed['scheme']))
						$parsed['scheme'] = ''; // No scheme.
					$parsed['scheme'] = $this->n_scheme($parsed['scheme']);
				}
				else if($component === PHP_URL_SCHEME)
				{
					if(!is_string($parsed))
						$parsed = ''; // No scheme.
					$parsed = $this->n_scheme($parsed);
				}
			}
			if($normalize & $this::url_host) // Normalize host?
			{
				if(!isset($component) && is_array($parsed))
				{
					if(!$this->©string->is($parsed['host']))
						$parsed['host'] = ''; // No host.
					$parsed['host'] = $this->n_host($parsed['host']);
				}
				else if($component === PHP_URL_HOST)
				{
					if(!is_string($parsed))
						$parsed = ''; // No scheme.
					$parsed = $this->n_host($parsed);
				}
			}
			if($normalize & $this::url_path) // Normalize path?
			{
				if(!isset($component) && is_array($parsed))
				{
					if(!$this->©string->is($parsed['path']))
						$parsed['path'] = '/'; // Home directory.
					$parsed['path'] = $this->n_path_seps($parsed['path'], TRUE);
					if(strpos($parsed['path'], '/') !== 0) $parsed['path'] = '/'.$parsed['path'];
				}
				else if($component === PHP_URL_PATH)
				{
					if(!is_string($parsed))
						$parsed = '/'; // Home directory.
					$parsed = $this->n_path_seps($parsed, TRUE);
					if(strpos($parsed, '/') !== 0) $parsed = '/'.$parsed;
				}
			}
			if(in_array(gettype($parsed), array('array', 'string', 'integer'), TRUE))
			{
				if(is_array($parsed)) // An array?
				{
					// Standardize.
					$defaults       = array(
						'fragment' => '',
						'host'     => '',
						'pass'     => '',
						'path'     => '',
						'port'     => 0,
						'query'    => '',
						'scheme'   => '',
						'user'     => ''
					);
					$parsed         = array_merge($defaults, $parsed);
					$parsed['port'] = (integer)$parsed['port'];
					ksort($parsed); // Sort by key.
				}
				return $parsed; // A `string|integer|array`.
			}
			return NULL; // Default return value.
		}

		/**
		 * Parses a URL (or a URI/query/fragment only) into an array.
		 *
		 * @return array|string|integer|null {@inheritdoc}
		 *
		 * @throws exception If unable to parse.
		 *
		 * @see parse()
		 * @inheritdoc parse()
		 */
		public function must_parse() // Arguments are NOT listed here.
		{
			if(is_null($parsed = call_user_func_array(array($this, 'parse'), func_get_args())))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					sprintf($this->__('Unable to parse: `%1$s`.'), (string)func_get_arg(0))
				);
			return $parsed;
		}

		/**
		 * Unparses a URL (putting it all back together again).
		 *
		 * @param array        $parsed An array with at least one URL component.
		 *
		 * @param null|integer $normalize A bitmask. Defaults to NULL (indicating a default bitmask).
		 *    Defaults include: {@link fw_constants::url_scheme}, {@link fw_constants::url_host}, {@link fw_constants::url_path}.
		 *    However, we DO allow a trailing slash (even if path is being normalized by this parameter).
		 *
		 * @return string A full or partial URL, based on components provided in the `$parsed` array.
		 *    It IS possible to receive an empty string, when/if `$parsed` does NOT contain any portion of a URL.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function unparse($parsed, $normalize = NULL)
		{
			$this->check_arg_types('array', array('null', 'integer'), func_get_args());

			$unparsed = ''; // Initialize string value.

			if(!isset($normalize)) // Use defaults?
				$normalize = $this::url_scheme | $this::url_host | $this::url_path;

			if($normalize & $this::url_scheme) // Normalize scheme?
			{
				if(!$this->©string->is($parsed['scheme']))
					$parsed['scheme'] = ''; // No scheme.
				$parsed['scheme'] = $this->n_scheme($parsed['scheme']);
			}
			if($this->©string->is_not_empty($parsed['scheme']))
				$unparsed .= $parsed['scheme'].'://';
			else if($this->©string->is($parsed['scheme']) && $this->©string->is_not_empty($parsed['host']))
				$unparsed .= '//'; // Cross-protocol compatible (ONLY if there is a host name also).

			if($this->©string->is_not_empty($parsed['user']))
			{
				$unparsed .= $parsed['user'];
				if($this->©string->is_not_empty($parsed['pass']))
					$unparsed .= ':'.$parsed['pass'];
				$unparsed .= '@';
			}
			if($normalize & $this::url_host) // Normalize host?
			{
				if(!$this->©string->is($parsed['host']))
					$parsed['host'] = ''; // No host.
				$parsed['host'] = $this->n_host($parsed['host']);
			}
			if($this->©string->is_not_empty($parsed['host']))
				$unparsed .= $parsed['host'];

			if($this->©integer->is_not_empty($parsed['port']))
				$unparsed .= ':'.(string)$parsed['port']; // A `0` value is excluded here.
			else if($this->©string->is_not_empty($parsed['port']) && (integer)$parsed['port'])
				$unparsed .= ':'.(string)(integer)$parsed['port']; // We also accept string port numbers.

			if($normalize & $this::url_path) // Normalize path?
			{
				if(!$this->©string->is($parsed['path']))
					$parsed['path'] = '/'; // Home directory.
				$parsed['path'] = $this->n_path_seps($parsed['path'], TRUE);
				if(strpos($parsed['path'], '/') !== 0) $parsed['path'] = '/'.$parsed['path'];
			}
			if($this->©string->is($parsed['path']))
				$unparsed .= $parsed['path'];

			if($this->©string->is_not_empty($parsed['query']))
				$unparsed .= '?'.$parsed['query'];

			if($this->©string->is_not_empty($parsed['fragment']))
				$unparsed .= '#'.$parsed['fragment'];

			return $unparsed; // Possible empty string.
		}

		/**
		 * Unparses a URL (putting it all back together again).
		 *
		 * @return string {@inheritdoc}
		 *
		 * @throws exception If unable to unparse.
		 *
		 * @see unparse()
		 * @inheritdoc unparse()
		 */
		public function must_unparse() // Arguments are NOT listed here.
		{
			if('' === ($unparsed = call_user_func_array(array($this, 'unparse'), func_get_args())))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					sprintf($this->__('Unable to unparse: `%1$s`.'), $this->©var->dump(func_get_arg(0)))
				);
			return $unparsed;
		}

		/**
		 * Parses URI parts from a URL (or a URI/query/fragment only).
		 *
		 * @param string       $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param null|integer $normalize A bitmask. Defaults to NULL (indicating a default bitmask).
		 *    Defaults include: {@link fw_constants::url_scheme}, {@link fw_constants::url_host}, {@link fw_constants::url_path}.
		 *    However, we DO allow a trailing slash (even if path is being normalized by this parameter).
		 *
		 * @return array|null An array with the following components, else NULL on any type of failure.
		 *
		 *    • `path`(string) Possible URI path.
		 *    • `query`(string) A possible query string.
		 *    • `fragment`(string) A possible fragment.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function parse_uri_parts($url_uri_query_fragment, $normalize = NULL)
		{
			$this->check_arg_types('string', array('null', 'integer'), func_get_args());

			if(($parts = $this->parse($url_uri_query_fragment, NULL, $normalize)))
				return array('path' => $parts['path'], 'query' => $parts['query'], 'fragment' => $parts['fragment']);

			return NULL; // Default return value.
		}

		/**
		 * Parses URI parts from a URL (or a URI/query/fragment only).
		 *
		 * @return array|null {@inheritdoc}
		 *
		 * @throws exception If unable to parse.
		 *
		 * @see parse_uri_parts()
		 * @inheritdoc parse_uri_parts()
		 */
		public function must_parse_uri_parts() // Arguments are NOT listed here.
		{
			if(is_null($parts = call_user_func_array(array($this, 'parse_uri_parts'), func_get_args())))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					sprintf($this->__('Unable to parse: `%1$s`.'), (string)func_get_arg(0))
				);
			return $parts;
		}

		/**
		 * Parses a URI from a URL (or a URI/query/fragment only).
		 *
		 * @param string       $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param null|integer $normalize A bitmask. Defaults to NULL (indicating a default bitmask).
		 *    Defaults include: {@link fw_constants::url_scheme}, {@link fw_constants::url_host}, {@link fw_constants::url_path}.
		 *    However, we DO allow a trailing slash (even if path is being normalized by this parameter).
		 *
		 * @param boolean      $include_fragment Defaults to TRUE. Include a possible fragment?
		 *
		 * @return string|null A URI (i.e. a URL path), else NULL on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function parse_uri($url_uri_query_fragment, $normalize = NULL, $include_fragment = TRUE)
		{
			$this->check_arg_types('string', array('null', 'integer'), 'boolean', func_get_args());

			if(($parts = $this->parse_uri_parts($url_uri_query_fragment, $normalize)))
			{
				if(!$include_fragment) // Ditch fragment?
					unset($parts['fragment']);

				return $this->unparse($parts, $normalize);
			}
			return NULL; // Default return value.
		}

		/**
		 * Parses a URI from a URL (or a URI/query/fragment only).
		 *
		 * @return string|null {@inheritdoc}
		 *
		 * @throws exception If unable to parse.
		 *
		 * @see parse_uri()
		 * @inheritdoc parse_uri()
		 */
		public function must_parse_uri() // Arguments are NOT listed here.
		{
			if(is_null($parsed = call_user_func_array(array($this, 'parse_uri'), func_get_args())))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#failure', get_defined_vars(),
					sprintf($this->__('Unable to parse: `%1$s`.'), (string)func_get_arg(0))
				);
			return $parsed;
		}

		/**
		 * Resolves a relative URL into a full URL from a base.
		 *
		 * @param string $relative_url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $base_url A base URL. Optional. Defaults to current location.
		 *    This defaults to the current URL. See: {@link current()}.
		 *
		 * @return string A full URL; else an exception will be thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to parse `$relative_url_uri_query_fragment`.
		 * @throws exception If there is no `$base`, and we're unable to detect current location.
		 * @throws exception If unable to parse `$base` (or if `$base` has no host name).
		 */
		public function resolve_relative($relative_url_uri_query_fragment, $base_url = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!$base_url) // No base URL? The `$base` is optional (defaults to current URL).
				$base_url = $this->current(); // Auto-detects current URL/location.

			$relative_parts         = $this->must_parse($relative_url_uri_query_fragment, NULL, 0);
			$relative_parts['path'] = $this->n_path_seps($relative_parts['path'], TRUE);
			$base_parts             = $parts = $this->must_parse($base_url);

			if($relative_parts['host']) // Already resolved?
			{
				if(!$relative_parts['scheme']) // If no scheme, use base scheme.
					$relative_parts['scheme'] = $base_parts['scheme'];
				return $this->unparse($relative_parts);
			}
			if(!$base_parts['host']) // We MUST have a base host name to resolve.
				throw $this->©exception($this->method(__FUNCTION__).'#missing_base_host_name', get_defined_vars(),
				                        sprintf($this->__('Unable to parse (missing base host name): `%1$s`.'), $base_url)
				);
			if(strlen($relative_parts['path'])) // It's important that we mimic browser behavior here.
			{
				if(strpos($relative_parts['path'], '/') === 0)
					$parts['path'] = ''; // Reduce to nothing if relative is absolute.
				else $parts['path'] = preg_replace('/\/[^\/]*$/', '', $parts['path']).'/'; // Reduce to nearest `/`.

				// Replace `/./` and `/foo/../` with `/` (resolve relatives).
				for($_i = 1, $parts['path'] = $parts['path'].$relative_parts['path']; $_i > 0;)
					$parts['path'] = preg_replace(array('/\/\.\//', '/\/(?!\.\.)[^\/]+\/\.\.\//'), '/', $parts['path'], -1, $_i);
				unset($_i); // Just a little housekeeping.

				// We can ditch any unresolvable `../` patterns now.
				// For instance, if there were too many `../../../../../` back references.
				$parts['path'] = str_replace('../', '', $parts['path']);

				$parts['query'] = $relative_parts['query']; // Use relative query.
			}
			else if(strlen($relative_parts['query'])) // Only if there is a new query (or path above) in the relative.
				$parts['query'] = $relative_parts['query']; // Relative query string supersedes base.

			$parts['fragment'] = $relative_parts['fragment']; // Always changes.

			return $this->unparse($parts); // Resolved now.
		}

		/**
		 * Builds a WordPress® URL to: `/wp-login.php`.
		 *
		 * @param string  $redirect_to Optional. A URL to redirect to after login.
		 *
		 * @param string  $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @param boolean $force_reauth Optional. Defaults to a FALSE value.
		 *    Whether to force reauthorization, even if a cookie is present.
		 *
		 * @return string WordPress® URL to: `/wp-login.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_login($redirect_to = '', $scheme = '', $force_reauth = FALSE)
		{
			$this->check_arg_types('string', 'string', 'boolean', func_get_args());

			$url = wp_login_url($redirect_to, $force_reauth);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-login.php?action=logout`.
		 *
		 * @param string $redirect_to Optional. A URL to redirect to after logout.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-login.php?action=logout`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_logout($redirect_to = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$url = wp_logout_url($redirect_to);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-login.php?action=lostpassword`.
		 *
		 * @param string $redirect_to Optional. A URL to redirect to after login.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-login.php?action=lostpassword`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_lost_password($redirect_to = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$url = wp_lostpassword_url($redirect_to);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-login.php?action=register`.
		 *
		 * @param string $redirect_to Optional. A URL to redirect to after registration.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-login.php?action=register`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_register($redirect_to = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$url = add_query_arg(urlencode_deep(array('action' => 'register')), $this->to_wp_login($redirect_to));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-signup.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-signup.php`.
		 *
		 * @note Here we support the same filter that WordPress® does.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_signup($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = apply_filters('wp_signup_location', $this->to_wp_network_site_uri('/wp-signup.php'));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-activate.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-activate.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_activate($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_network_site_uri('/wp-activate.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-app.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-app.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_app($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/wp-app.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-cron.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-cron.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_cron($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/wp-cron.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-links-opml.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-links-opml.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_links_opml($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/wp-links-opml.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-mail.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-mail.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_mail($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/wp-mail.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/wp-trackback.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/wp-trackback.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_trackback($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/wp-trackback.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® URL to: `/xmlrpc.php`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string WordPress® URL to: `/xmlrpc.php`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_xmlrpc($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			$url = $this->to_wp_site_uri('/xmlrpc.php');

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a BuddyPress URL to: `/register`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string BuddyPress URL to: `/register`, if BuddyPress is installed; else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_bp_register($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			if($this->©env->has_bp_active() && function_exists('bp_get_signup_page'))
				$url = bp_get_signup_page();
			else $url = ''; // Not applicable.

			return ($url && $scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a BuddyPress URL to: `/activate`.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string BuddyPress URL to: `/activate`, if BuddyPress is installed; else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_bp_activate($scheme = '')
		{
			$this->check_arg_types('string', func_get_args());

			if($this->©env->has_bp_active() && function_exists('bp_get_activation_page'))
				$url = bp_get_activation_page();
			else $url = ''; // Not applicable.

			return ($url && $scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® taxonomy URL (for a given term).
		 *
		 * @param null|object $term Optional. Defaults to the current term (if possible).
		 *
		 * @param string      $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string Full URL to a WordPress® taxonomy URL (for a given term).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_term($term = NULL, $scheme = '')
		{
			$this->check_arg_types(array('null', 'object'), 'string', func_get_args());

			if(!isset($term)) $term = get_queried_object();

			if(empty($term->term_id) || empty($term->taxonomy))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_term', get_defined_vars(),
					$this->__('Invalid term. Missing `term_id`, `taxonomy` properties.')
				);
			if(!is_string($url = get_term_link($term))) $url = '';

			return ($url && $scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a WordPress® permalink URL (for a given Post ID).
		 *
		 * @param integer $id Optional. Defaults to the current Post ID.
		 *
		 * @param string  $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string Full URL to a WordPress® permalink URL (for a given Post ID).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_permalink_id($id = 0, $scheme = '')
		{
			$this->check_arg_types('integer', 'string', func_get_args());

			if(!is_string($url = get_permalink($id))) $url = '';

			return ($url && $scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® home/permalink URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® home/permalink URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note If fancy permalinks are NOT enabled, we perform a lookup based on the URI path & combine query strings.
		 *    If we're unable to find the underlying post by path, we stick w/ the fancy permalink (as a fallback).
		 *
		 * @note This uses {@link \user_trailingslashit()} to force proper permalink structure.
		 */
		public function to_wp_permalink_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $uri_parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(!$this->©env->uses_fancy_permalinks() && ($post = $this->©post->by_path($parts['path'])))
			{
				$parts = $this->must_parse_uri_parts($this->to_wp_permalink_id($post->ID));

				if(preg_match($this->regex_wp_pagination_page(), $uri_parts['path'], $pagination))
					$parts['query'] .= ((!$parts['query']) ? '' : '&').'paged='.$pagination['page_number'];

				if($uri_parts['query']) // Combine query strings?
					$parts['query'] .= ((!$parts['query']) ? '' : '&').$uri_parts['query'];

				$parts['fragment'] = $uri_parts['fragment']; // URI fragment always.
			}
			if(!$this->©file->has_extension($parts['path']))
				$parts['path'] = user_trailingslashit($parts['path']);

			$url = home_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® Dashboard URI (directory/file).
		 *
		 * @param null|integer|\WP_User|users $user User we're dealing with here.
		 *    This defaults to a NULL value (indicating the current user).
		 *
		 * @param string                      $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string                      $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® admin URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_user_dashboard_uri($user = NULL, $url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types($this->©user_utils->which_types(), 'string', 'string', func_get_args());

			$user = $this->©user_utils->which($user);

			if(!$user->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', get_defined_vars(),
					$this->__('The `$user` has no ID (cannot get Dashboard URL).')
				);
			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = get_dashboard_url($user->ID, $this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® admin URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® admin URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_admin_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = admin_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® user admin URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® user admin URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_user_admin_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = user_admin_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® network admin URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® network admin URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_network_admin_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = network_admin_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® self admin URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® self admin URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_self_admin_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = self_admin_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® home URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® home URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_home_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = home_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® network home URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® network home URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_network_home_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = network_home_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® site URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® site URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_site_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = site_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® network site URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® network site URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_network_site_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = network_site_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® content URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® content URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_content_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = content_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® includes URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® includes URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_includes_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = includes_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® plugins URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® plugins URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_plugins_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = plugins_url($this->unparse($parts));

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® stylesheet URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® stylesheet URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_stylesheet_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = get_stylesheet_directory_uri().$this->unparse($parts);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a WordPress® template URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a WordPress® template URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_template_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = get_template_directory_uri().$this->unparse($parts);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Constructs a URL leading to a plugin site URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *    Note: `$this->instance->plugin_site` will always have an `http` scheme by default.
		 *    This is a standard that is followed strictly by the XDaRk Core framework.
		 *
		 * @return string URL leading to a plugin site URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_plugin_site_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = $this->instance->plugin_site.$this->unparse($parts);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * Builds a URL leading to an absolute URI (directory/file).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be parsed here.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to an absolute URI (directory/file).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_abs_uri($url_uri_query_fragment = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$parts = $this->must_parse_uri_parts($url_uri_query_fragment);

			if(substr($parts['path'], -1) !== '/' && !$this->©file->has_extension($parts['path']))
				$parts['path'] = trailingslashit($parts['path']);

			$url = $this->current_scheme().'://'.$this->current_host().$this->unparse($parts);

			return ($scheme) ? $this->set_scheme($url, $scheme) : $url;
		}

		/**
		 * URL leading to a WordPress® `/directory-or-file`.
		 *
		 * @param string  $abs_dir_file Absolute server path to a WordPress® `/directory-or-file`.
		 *    Note that relative paths are NOT possible here (this MUST be absolute).
		 *
		 * @param string  $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @param boolean $___realpath Internal use only; used in recursion.
		 *
		 * @return string URL leading to a WordPress® `/directory-or-file` (no trailing slash).
		 *    Else if file is NOT within WordPress; we return a direct URL using a `file://` stream wrapper.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_wp_abs_dir_file($abs_dir_file, $scheme = '', $___realpath = FALSE)
		{
			if(!$___realpath) // Only on the initial call w/o a realpath check.
				$this->check_arg_types('string:!empty', 'string', 'boolean', func_get_args());

			// Normalize & break apart the `$dir`/`$file` portions.

			if(!($abs_dir_file = $this->©dir->n_seps($abs_dir_file)))
				return ''; // Catch empty directory here.

			if($this->©file->has_extension($abs_dir_file) || is_file($abs_dir_file))
			{
				$dir  = $this->©dir->n_seps_up($abs_dir_file);
				$file = '/'.basename($abs_dir_file);
			}
			else // Else, NO file (i.e. it's a directory path).
			{
				$dir  = $this->©dir->n_seps($abs_dir_file);
				$file = ''; // No file, it's a directory.
			}
			if(!$dir) return ''; // Catch empty directory here.

			// Remove stream wrappers (assuming WordPress® does NOT use these).

			if(!isset($this->static[__FUNCTION__.'__regex_stream_wrapper'])) // We only need this ONE time.
				$this->static[__FUNCTION__.'__regex_stream_wrapper'] = substr(stub::$regex_valid_dir_file_stream_wrapper, 0, -2).'/';

			if(strpos($dir, '://') !== FALSE) // Has a stream wrapper?
				$dir = preg_replace($this->static[__FUNCTION__.'__regex_stream_wrapper'], '', $dir);

			// Check WordPress® absolute/root directory (this is enough in most cases).

			if(strpos($dir.'/', ($wp_dir = $this->©dir->n_seps(ABSPATH)).'/') === 0)
				return rtrim($this->to_wp_site_uri($this->encode_path_parts($this->©string->replace_once($wp_dir, '', $dir).$file), $scheme), '/');

			// Check WordPress® plugin paths (in case of a symlinked plugin).

			if($this->©array->is_not_empty($GLOBALS['wp_plugin_paths'])) foreach($GLOBALS['wp_plugin_paths'] as $_plugin_dir => $_plugin_realdir)
				if(($_plugin_realdir = $this->©dir->n_seps($_plugin_realdir)) && strpos($dir.'/', $_plugin_realdir.'/') === 0)
					return rtrim($this->to_wp_plugins_uri($this->encode_path_parts($this->©string->replace_once($this->©dir->n_seps_up($_plugin_realdir), '', $dir).$file), $scheme), '/');
			unset($_plugin_dir, $_plugin_realdir); // Housekeeping.

			// Check WordPress® content directory (in case this resides in a non-standard location).

			if(strpos($dir.'/', ($wp_content_dir = $this->©dir->n_seps(WP_CONTENT_DIR)).'/') === 0)
				return rtrim($this->to_wp_content_uri($this->encode_path_parts($this->©string->replace_once($wp_content_dir, '', $dir).$file), $scheme), '/');

			// Check WordPress® includes directory (in case this resides in a non-standard location).

			if(strpos($dir.'/', ($wp_includes_dir = $this->©dir->n_seps(ABSPATH.WPINC)).'/') === 0)
				return rtrim($this->to_wp_includes_uri($this->encode_path_parts($this->©string->replace_once($wp_includes_dir, '', $dir).$file), $scheme), '/');

			// Check WordPress® plugins directory (in case this resides in a non-standard location).

			if(strpos($dir.'/', ($wp_plugins_dir = $this->©dir->n_seps(WP_PLUGIN_DIR)).'/') === 0)
				return rtrim($this->to_wp_plugins_uri($this->encode_path_parts($this->©string->replace_once($wp_plugins_dir, '', $dir).$file), $scheme), '/');

			// Check WordPress® active style directory (in case this resides in a non-standard location).

			if(strpos($dir.'/', ($wp_active_style_dir = $this->©dir->n_seps(get_stylesheet_directory())).'/') === 0)
				return rtrim($this->to_wp_stylesheet_uri($this->encode_path_parts($this->©string->replace_once($wp_active_style_dir, '', $dir).$file), $scheme), '/');

			// Check WordPress® active theme directory (in case this resides in a non-standard location).

			if(strpos($dir.'/', ($wp_active_theme_dir = $this->©dir->n_seps(get_template_directory())).'/') === 0)
				return rtrim($this->to_wp_template_uri($this->encode_path_parts($this->©string->replace_once($wp_active_theme_dir, '', $dir).$file), $scheme), '/');

			if(!$___realpath && ($abs_dir_file_realpath = $this->©dir->n_seps((string)realpath($abs_dir_file))) && $abs_dir_file_realpath !== $abs_dir_file)
				return $this->to_wp_abs_dir_file($abs_dir_file_realpath, $scheme, TRUE); // Retry w/ a `realpath()` now.

			// By default we use `file://`. A Windows® drive letter becomes: `file://[drive letter]/`.

			if(!isset($this->static[__FUNCTION__.'__regex_win_drive_letter'])) // We only need this ONE time.
				$this->static[__FUNCTION__.'__regex_win_drive_letter'] = substr(stub::$regex_valid_win_drive_letter, 0, -2).'/';

			if(preg_match($this->static[__FUNCTION__.'__regex_win_drive_letter'], $dir, $_drive))
				$dir = preg_replace($this->static[__FUNCTION__.'__regex_win_drive_letter'], '', $dir);

			return 'file://'.((!empty($_drive[0])) ? $_drive[0] : '').$this->encode_path_parts($dir.$file);
		}

		/**
		 * Locates a template directory/file (relative path).
		 *
		 * @param string $dir_file Template directory/file name (relative path).
		 *    This MUST be a relative path, because a template directory is found dynamically.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL to a template directory/file (no trailing slash).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$dir_file` is empty (it MUST be passed as a string, NOT empty).
		 * @throws exception If `$dir_file` does NOT exist, or is NOT readable.
		 */
		public function to_template_dir_file($dir_file, $scheme = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			return $this->to_wp_abs_dir_file($this->©file->template($dir_file), $scheme);
		}

		/**
		 * URL leading to a XDaRk Core `/directory-or-file`.
		 *
		 * @param string $dir_file Absolute server path to a XDaRk Core `/directory-or-file`.
		 *    Or, a relative path is also acceptable here, making this method very handy.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a XDaRk Core `/directory-or-file` (no trailing slash).
		 *    Else an empty string on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_core_dir_file($dir_file = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$dir_file = $this->©dir->n_seps($dir_file);

			if($dir_file && ($realpath = realpath($dir_file)))
				$realpath = $this->©dir->n_seps($dir_file);
			else $realpath = ''; // Not possible.

			if(!$dir_file || strpos($dir_file.'/', $this->instance->core_dir.'/') !== 0)
				if(!$realpath || strpos($realpath.'/', $this->instance->core_dir.'/') !== 0)
					$dir_file = $this->instance->core_dir.'/'.ltrim($dir_file, '/');

			return $this->to_wp_abs_dir_file($dir_file, $scheme);
		}

		/**
		 * URL leading to a plugin `/directory-or-file`.
		 *
		 * @param string $dir_file Absolute server path to a plugin `/directory-or-file`.
		 *    Or, a relative path is also acceptable here, making this method very handy.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a plugin `/directory-or-file` (no trailing slash).
		 *    Else an empty string on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_plugin_dir_file($dir_file = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$dir_file = $this->©dir->n_seps($dir_file);

			if($dir_file && ($realpath = realpath($dir_file)))
				$realpath = $this->©dir->n_seps($dir_file);
			else $realpath = ''; // Not possible.

			if(!$dir_file || strpos($dir_file.'/', $this->instance->plugin_dir.'/') !== 0)
				if(!$realpath || strpos($realpath.'/', $this->instance->plugin_dir.'/') !== 0)
					$dir_file = $this->instance->plugin_dir.'/'.ltrim($dir_file, '/');

			return $this->to_wp_abs_dir_file($dir_file, $scheme);
		}

		/**
		 * URL leading to a plugin data `/directory-or-file`.
		 *
		 * @param string $dir_file Absolute server path to a plugin data `/directory-or-file`.
		 *    Or, a relative path is also acceptable here, making this method very handy.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a plugin data `/directory-or-file` (no trailing slash).
		 *    Else an empty string on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @TODO This should include a data directory 'type'?
		 */
		public function to_plugin_data_dir_file($dir_file = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$dir_file = $this->©dir->n_seps($dir_file);

			if($dir_file && ($realpath = realpath($dir_file)))
				$realpath = $this->©dir->n_seps($dir_file);
			else $realpath = ''; // Not possible.

			if(!$dir_file || strpos($dir_file.'/', $this->instance->plugin_data_dir.'/') !== 0)
				if(!$realpath || strpos($realpath.'/', $this->instance->plugin_data_dir.'/') !== 0)
					$dir_file = $this->instance->plugin_data_dir.'/'.ltrim($dir_file, '/');

			return $this->to_wp_abs_dir_file($dir_file, $scheme);
		}

		/**
		 * URL leading to a plugin pro `/directory-or-file`.
		 *
		 * @param string $dir_file Absolute server path to a plugin pro `/directory-or-file`.
		 *    Or, a relative path is also acceptable here, making this method very handy.
		 *
		 * @param string $scheme Optional. To force a specific scheme (i.e. `//`, `http`, `https`).
		 *
		 * @return string URL leading to a plugin pro `/directory-or-file` (no trailing slash).
		 *    Else an empty string on any type of failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_plugin_pro_dir_file($dir_file = '', $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$dir_file = $this->©dir->n_seps($dir_file);

			if($dir_file && ($realpath = realpath($dir_file)))
				$realpath = $this->©dir->n_seps($dir_file);
			else $realpath = ''; // Not possible.

			if(!$dir_file || strpos($dir_file.'/', $this->instance->plugin_pro_dir.'/') !== 0)
				if(!$realpath || strpos($realpath.'/', $this->instance->plugin_pro_dir.'/') !== 0)
					$dir_file = $this->instance->plugin_pro_dir.'/'.ltrim($dir_file, '/');

			return $this->to_wp_abs_dir_file($dir_file, $scheme);
		}

		/**
		 * Gets automatic update URL (w/ custom ZIP file source).
		 *
		 * @param string $username Optional. Plugin site username. Defaults to an empty string.
		 *    This is ONLY required, if the underlying plugin site requires it.
		 *
		 * @param string $password Optional. Plugin site password. Defaults to an empty string.
		 *    This is ONLY required, if the underlying plugin site requires it.
		 *
		 * @return string|errors URL leading to an automatic update of plugin (powered by WordPress®).
		 *    Else an `errors` object (with at least one error) is returned on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_plugin_update_via_wp($username = '', $password = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			// Connects to the plugin site (POST array includes `slug`, `version`, `username`, `password`).
			// The plugin site should return a JSON object with `version`, `zip` elements (e.g. version + full URL to a ZIP file).
			// If an error occurs at the plugin site, the plugin site can return an `error` element w/ an error message.

			$plugin_site_credentials = $this->©plugin->get_site_credentials($username, $password, TRUE);

			$plugin_site_post_vars = array('data' => array( // See: <http://git.io/tHGlQw> for API specs.
			                                                'slug'     => $this->instance->plugin_dir_basename, 'version' => 'latest-stable',
			                                                'username' => $plugin_site_credentials['username'], 'password' => $plugin_site_credentials['password']
			));
			$plugin_site_response  = $this->remote($this->to_plugin_site_uri('/updater/update-sync.php'), $plugin_site_post_vars);
			if(!is_array($plugin_site_response = json_decode($plugin_site_response, TRUE))) $plugin_site_response = array();

			if($this->©strings->are_not_empty($plugin_site_response['version'], $plugin_site_response['zip']))
			{
				$update_args                                                             = array(
					'action'   => 'upgrade-plugin',
					'plugin'   => $this->instance->plugin_dir_file_basename,
					'_wpnonce' => wp_create_nonce('upgrade-plugin_'.$this->instance->plugin_dir_file_basename)
				);
				$update_args[$this->instance->plugin_var_ns.'_update_version'] = $plugin_site_response['version'];
				$update_args[$this->instance->plugin_var_ns.'_update_zip']     = $plugin_site_response['zip'];

				return add_query_arg(urlencode_deep($update_args), $this->to_wp_self_admin_uri('/update.php'));
			}
			if($this->©string->is_not_empty($plugin_site_response['error']))
				return $this->©error(
					$this->method(__FUNCTION__).'#plugin_site_error', get_defined_vars(),
					$plugin_site_response['error']
				);
			return $this->©error( // Assume connectivity issue.
				$this->method(__FUNCTION__).'#plugin_site_connectivity_issue', get_defined_vars(),
				$this->__('Unable to communicate with plugin site (i.e. could NOT obtain ZIP package).').
				' '.$this->__('Possible connectivity issue. Please try again in 15 minutes.')
			);
		}

		/**
		 * Gets automatic update URL (w/ custom ZIP file source).
		 *
		 * @param string $username Optional. Plugin site username. Defaults to an empty string.
		 *    This is ONLY required, if the underlying plugin site requires it.
		 *
		 * @param string $password Optional. Plugin site password. Defaults to an empty string.
		 *    This is ONLY required, if the underlying plugin site requires it.
		 *
		 * @return string|errors URL leading to an automatic update of pro add-on (powered by WordPress®).
		 *    Else an `errors` object (with at least one error) is returned on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function to_plugin_pro_update_via_wp($username = '', $password = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			// Connects to the plugin site (POST array includes `slug`, `version`, `username`, `password`).
			// The plugin site should return a JSON object with `version`, `zip` elements (e.g. version + full URL to a ZIP file).
			// If an error occurs at the plugin site, the plugin site can return an `error` element w/ an error message.

			$plugin_site_credentials = $this->©plugin->get_site_credentials($username, $password, TRUE);

			$plugin_site_post_vars = array('data' => array( // See: <http://git.io/tHGlQw> for API specs.
			                                                'slug'     => $this->instance->plugin_pro_dir_basename, 'version' => $this->instance->plugin_version,
			                                                'username' => $plugin_site_credentials['username'], 'password' => $plugin_site_credentials['password']
			));
			$plugin_site_response  = $this->remote($this->to_plugin_site_uri('/updater/update-sync.php'), $plugin_site_post_vars);
			if(!is_array($plugin_site_response = json_decode($plugin_site_response, TRUE))) $plugin_site_response = array();

			if($this->©strings->are_not_empty($plugin_site_response['version'], $plugin_site_response['zip']))
			{
				$update_args                                                                 = array(
					'action'   => 'upgrade-plugin',
					'plugin'   => $this->instance->plugin_pro_dir_file_basename,
					'_wpnonce' => wp_create_nonce('upgrade-plugin_'.$this->instance->plugin_pro_dir_file_basename)
				);
				$update_args[$this->instance->plugin_var_ns.'_pro_update_version'] = $plugin_site_response['version'];
				$update_args[$this->instance->plugin_var_ns.'_pro_update_zip']     = $plugin_site_response['zip'];

				return add_query_arg(urlencode_deep($update_args), $this->to_wp_self_admin_uri('/update.php'));
			}
			if($this->©string->is_not_empty($plugin_site_response['error']))
				return $this->©error(
					$this->method(__FUNCTION__).'#plugin_site_error', get_defined_vars(),
					$plugin_site_response['error']
				);
			return $this->©error( // Assume connectivity issue.
				$this->method(__FUNCTION__).'#plugin_site_connectivity_issue', get_defined_vars(),
				$this->__('Unable to communicate with plugin site (i.e. could NOT obtain ZIP package).').
				' '.$this->__('Possible connectivity issue. Please try again in 15 minutes.')
			);
		}

		/**
		 * Processes remote connections.
		 *
		 * @param string            $url A full URL to a remote location.
		 *
		 * @param null|string|array $post_body Optional. Defaults to a NULL value (and defaults to a connection method type of `GET`).
		 *    If a string|array is passed in (empty or otherwise), the connection `method` is set to `POST` (if NOT already set);
		 *    and `$post_body` is POSTed to the remote location by this routine.
		 *
		 * @param array             $args An optional array of argument specifications (same as the `WP_Http` class).
		 *    In addition, we accept some other array elements here: `return_xml_object`, `xml_object_flags`, `return_array`, and `return_errors`.
		 *    For further details, please check the docs below regarding return values.
		 *
		 * @param integer           $timeout Optional. Defaults to a value of `5` seconds.
		 *    For important API communications, a value of `20` (or higher), is suggested for stability.
		 *    In the cURL transport layer, this controls both the connection and stream timeout values.
		 *    This can also be passed through `$args['timeout']`, which produces more readable code.
		 *
		 * @return string|array|\SimpleXMLElement|object|errors|null This function has MANY possible return values.
		 *    By default, this method returns the string received from the remote request, else an empty string on ANY type of error (even connection errors). Very simple (default behavior).
		 *    If an XML object is requested via `$args['return_xml_object']` (and `$args['return_array']` is FALSE, which it is by default), this method returns an instance of `SimpleXMLElement`; else NULL on any type of connection error.
		 *    If an array is requested via `$args['return_array']`, this method returns a full array of connection details (`code`, `message`, `headers`, `body`, `xml [populated only if $args['return_xml_object'] is TRUE]`); else NULL on any type of connection error.
		 *    If errors are requested via `$args['return_errors']`, this method will always return an `errors` object instance on any type of connection error.
		 *
		 * @note Please note that `$args['return_array']` takes precedence over `$args['return_xml_object']`.
		 *    This way it is possible to get a return array, with an `xml` element containing the XML object.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function remote($url, $post_body = NULL, $args = array(), $timeout = 5)
		{
			$this->check_arg_types('string:!empty', array('null', 'string', 'array'), 'array', 'integer:!empty', func_get_args());

			if(!empty($args['method']) && is_string($args['method']))
				$args['method'] = strtoupper($args['method']);

			if(isset($post_body)) // Have a `$post_body`? (e.g. POST vars, or other data).
			{
				$args = array_merge( // Original `$args` ALWAYS take precedence here.
					array('method' => 'POST', 'body' => $post_body), $args
				);
				if(!isset($args['headers']['Content-Type']))
					$args['headers']['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
			}
			if($timeout) // Do we have a `$timeout` value?
				$args = array_merge(array('timeout' => $timeout), $args);

			// Set default return value options.
			$return_array      = $this->©boolean->isset_or($args['return_array'], FALSE);
			$return_errors     = $this->©boolean->isset_or($args['return_errors'], FALSE);
			$return_xml_object = $this->©boolean->isset_or($args['return_xml_object'], FALSE);

			// Additional default option values.
			$xml_object_flags    = LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING;
			$xml_object_flags    = $this->©integer->isset_or($args['xml_object_flags'], $xml_object_flags);
			$args['sslverify']   = $this->©boolean->isset_or($args['sslverify'], FALSE);
			$args['httpversion'] = $this->©string->isset_or($args['httpversion'], '1.1');

			// Developers might like to fine tune things a bit further here.
			$url  = $this->apply_filters(__FUNCTION__.'__url', $url, get_defined_vars());
			$args = $this->apply_filters(__FUNCTION__.'__args', $args, get_defined_vars());

			// Now unset these `$args`, so they don't get passed through WordPress® and cause problems.
			unset($args['return_array'], $args['return_errors'], $args['return_xml_object'], $args['xml_object_flags']);

			$response = wp_remote_request($url, $args); // Process with `wp_remote_request()`.

			// Now let's handle return values provided by this routine.

			if(!is_wp_error($response)) // NO connection errors.
			{
				// XML object?
				if($return_xml_object)
				{
					$xml = simplexml_load_string(
						(string)wp_remote_retrieve_body($response),
						NULL, $xml_object_flags
					);
					// In case the XML string was BAD.
					// Here we force a SimpleXMLElement.
					if(!($xml instanceof \SimpleXMLElement))
						$xml = new \SimpleXMLElement('<xml />');
				}
				else $xml = NULL; // Not populating this.

				// Returning array?
				if($return_array) // Lots of useful info here.
				{
					return array(
						'code'                => (integer)wp_remote_retrieve_response_code($response),
						'message'             => (string)wp_remote_retrieve_response_message($response),
						'xml'                 => (($return_xml_object) ? (object)$xml : NULL),
						'headers'             => (array)wp_remote_retrieve_headers($response),
						'body'                => (string)wp_remote_retrieve_body($response),
						'last_http_debug_log' => $this->last_http_debug_log()
					);
				}
				// Returning XML object?
				else if($return_xml_object)
					return (object)$xml;

				// Else return string (default behavior).
				return (string)wp_remote_retrieve_body($response);
			}
			else // We have a connection error to deal with now.
			{
				// Get last HTTP debug log.
				$last_http_debug_log = $this->last_http_debug_log();

				// Generate errors.
				$errors = $this->©error(
					$this->method(__FUNCTION__), get_defined_vars(),
					$response->get_error_message()
				);
				// Returning errors?
				if($return_errors) return $errors;

				// Should return NULL on connection error?
				else if($return_array || $return_xml_object) return NULL;

				return ''; // String (default behavior).
			}
		}

		/**
		 * Catches details sent through the WordPress® `WP_Http` class.
		 *
		 * @attaches-to WordPress® `http_api_debug` hook (if `WP_DEBUG` mode is enabled).
		 * @hook-priority `10000` After most everything else (if `WP_DEBUG` mode is enabled).
		 *
		 * @param array  $response `WP_Http` response array.
		 * @param string $state `WP_Http` current state (i.e. `response`).
		 * @param string $class `WP_Http` transport class name.
		 * @param array  $args Input args to the `WP_Http` class.
		 * @param string $url The `WP_Http` connection URL.
		 */
		public function http_api_debug($response = NULL, $state = NULL, $class = NULL, $args = NULL, $url = NULL)
		{
			$this->static['last_http_debug_log'] = array(
				'state'           => $state,
				'transport_class' => $class,
				'args'            => $args,
				'url'             => $url,
				'response'        => $response
			);
		}

		/**
		 * Returns a reference to the last HTTP communication log.
		 *
		 * @return array A reference to the last HTTP communication log.
		 */
		public function &last_http_debug_log()
		{
			$last_http_debug_log = array(); // Initialize.

			if(isset($this->static[__FUNCTION__]))
				$last_http_debug_log =& $this->static[__FUNCTION__];

			else if(!$this->©env->is_in_wp_debug_mode())
			{
				$this->static['last_http_debug_log'] = array($this->__('`WP_DEBUG` mode is NOT currently enabled.'));
				$last_http_debug_log                 =& $this->static[__FUNCTION__];
			}
			return $last_http_debug_log; // Returns reference.
		}

		/**
		 * Encodes ampersands in a URL (or a URI/query/fragment only); with the HTML entity `&amp;`.
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be encoded here.
		 *
		 * @return string Input URL (or a URI/query/fragment only); after having been converted by this routine.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function e_amps($url_uri_query_fragment)
		{
			$this->check_arg_types('string', func_get_args());

			return str_replace('&', '&amp;', $this->n_amps($url_uri_query_fragment));
		}

		/**
		 * Converts all ampersand entities in a URL (or a URI/query/fragment only); to just `&`.
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be normalized here.
		 *
		 * @return string Input URL (or a URI/query/fragment only); after having been normalized by this routine.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function n_amps($url_uri_query_fragment)
		{
			$this->check_arg_types('string', func_get_args());

			if(!isset($this->static[__FUNCTION__.'__regex']))
				$this->static[__FUNCTION__.'__regex'] = '/(?:'.implode('|', array_keys($this->©strings->ampersand_entities)).')/';

			return preg_replace($this->static[__FUNCTION__.'__regex'], '&', $url_uri_query_fragment);
		}

		/**
		 * Normalizes a URL scheme.
		 *
		 * @param string $scheme An input URL scheme.
		 *
		 * @return string A normalized URL scheme (always lowercase).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function n_scheme($scheme)
		{
			$this->check_arg_types('string', func_get_args());

			if(strpos($scheme, ':') !== FALSE)
				$scheme = strstr($scheme, ':', TRUE);

			return strtolower($scheme); // Normalized scheme.
		}

		/**
		 * Normalizes a URL host name.
		 *
		 * @param string $host An input URL host name.
		 *
		 * @return string A normalized URL host name (always lowercase).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function n_host($host)
		{
			$this->check_arg_types('string', func_get_args());

			return strtolower($host); // Normalized host name.
		}

		/**
		 * Sets a particular scheme.
		 *
		 * @param string $url A full URL.
		 *
		 * @param string $scheme Optional. The scheme to use (i.e. `//`, `https`, `http`).
		 *    Use `//` to use a cross-protocol compatible scheme.
		 *    Defaults to the current scheme.
		 *
		 * @return string The full URL w/ `$scheme`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function set_scheme($url, $scheme = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!$scheme) // Current scheme?
				$scheme = $this->current_scheme();

			if($scheme !== '//') $scheme = $this->n_scheme($scheme).'://';

			return preg_replace('/^'.$this->regex_frag_scheme.'/', $this->©string->esc_refs($scheme), $url);
		}

		/**
		 * Normalizes a URL path from a URL (or a URI/query/fragment only).
		 *
		 * @param string  $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be normalized here.
		 *
		 * @param boolean $allow_trailing_slash Defaults to a FALSE value.
		 *    If TRUE, and `$url_uri_query_fragment` contains a trailing slash; we'll leave it there.
		 *
		 * @return string Normalized URL (or a URI/query/fragment only).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function n_path_seps($url_uri_query_fragment, $allow_trailing_slash = FALSE)
		{
			$this->check_arg_types('string', 'boolean', func_get_args());

			if(!strlen($url_uri_query_fragment)) return '';

			if(!($parts = $this->parse($url_uri_query_fragment, NULL, 0)))
				$parts['path'] = $url_uri_query_fragment;

			if(strlen($parts['path'])) // Normalize directory separators.
				$parts['path'] = $this->©dir->n_seps($parts['path'], $allow_trailing_slash);

			return $this->unparse($parts, 0); // Back together again.
		}

		/**
		 * Normalizes a URL path (up X directories) from a URL (or a URI/query/fragment only).
		 *
		 * @param string  $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be normalized here.
		 *
		 * @param integer $up Optional. Defaults to a value of `1`.
		 *    Number of directories to move up.
		 *
		 * @param boolean $allow_trailing_slash Defaults to a FALSE value.
		 *    If TRUE, and `$url_uri_query_fragment` contains a trailing slash; we'll leave it there.
		 *
		 * @return string Normalized URL (up X directories) (or a URI/query/fragment only).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function n_path_seps_up($url_uri_query_fragment, $up = 1, $allow_trailing_slash = FALSE)
		{
			$this->check_arg_types('string', 'integer', 'boolean', func_get_args());

			if(!strlen($url_uri_query_fragment)) return '';

			if(!($parts = $this->parse($url_uri_query_fragment, NULL, 0)))
				$parts['path'] = $url_uri_query_fragment;

			if(strlen($parts['path'])) // Normalize directory separators.
				$parts['path'] = $this->©dir->n_seps_up($parts['path'], $up, $allow_trailing_slash);

			return $this->unparse($parts, 0); // Back together again.
		}

		/**
		 * Encodes URL path parts (while preserving path separators).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be normalized here.
		 *
		 * @return string URL w/ encoded path parts (or a URI/query/fragment only).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function encode_path_parts($url_uri_query_fragment)
		{
			$this->check_arg_types('string', func_get_args());

			if(!strlen($url_uri_query_fragment)) return '';

			if(!($parts = $this->parse($url_uri_query_fragment, NULL, 0)))
				$parts['path'] = $url_uri_query_fragment;

			if(strlen($parts['path'])) // Encode path parts.
				$parts['path'] = str_ireplace('%2F', '/', urlencode($parts['path']));

			return $this->unparse($parts, 0); // Back together again.
		}

		/**
		 * Adds a query string name/value pair onto a URL's hash/anchor.
		 *
		 * @param string $name The name of the variable we're adding. This CANNOT be empty.
		 *
		 * @param string $value The value that we're setting the variable to.
		 *    This can be any scalar value. Converts to a string. This can be empty, but always scalar.
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be hashed by this routine.
		 *
		 * @return string Full URL with appended hash/anchor query string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$name` is empty. The name of the variable we're adding.
		 * @throws exception If `$url_uri_query_fragment` is malformed.
		 */
		public function add_query_hash($name, $value, $url_uri_query_fragment)
		{
			$this->check_arg_types('string:!empty', 'scalar', 'string', func_get_args());

			$parts = $this->must_parse($url_uri_query_fragment, NULL, 0);

			if($parts['fragment'] && $parts['fragment'][0] === '!')
				$vars = $this->©vars->parse_query(ltrim($parts['fragment'], '!'));
			else $vars = array(); // No vars; or it's an anchor.

			$vars[$name]       = (string)$value; // Force string.
			$parts['fragment'] = '!'.$this->©vars->build_query($vars);

			return $this->unparse($parts, 0); // Back together again.
		}

		/**
		 * Adds a query string signature onto a URL (or a URI/query/fragment only).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be handled here.
		 *
		 * @param string $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
		 *
		 * @return string A URL (or a URI/query/fragment only); now with a signature too (e.g. a query string).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$sig_var` is empty.
		 */
		public function add_query_sig($url_uri_query_fragment, $sig_var = '_sig')
		{
			$this->check_arg_types('string', 'string:!empty', func_get_args());

			$parts = $this->must_parse($url_uri_query_fragment, NULL, 0);

			$vars = $this->©vars->parse_query($parts['query']);
			unset($vars[$sig_var]); // Need to remove any existing signature variable.
			$vars = $this->©array->remove_0b_strings_deep($this->©strings->trim_deep($vars));
			$vars = serialize($this->©array->ksort_deep($vars));

			$sig                                = ($time = time()).'-'.$this->©encryption->hmac_sha1_sign($vars.$time);
			$url_uri_query_fragment_w_query_sig = add_query_arg(urlencode_deep(array($sig_var => $sig)), $url_uri_query_fragment);

			return $url_uri_query_fragment_w_query_sig;
		}

		/**
		 * Verifies a signature; in a URL (or a URI/query/fragment only).
		 *
		 * @param string  $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be handled here.
		 *
		 * @param boolean $check_time Optional. Defaults to FALSE.
		 *    If TRUE, also check if the signature has expired, based on `$exp_secs`.
		 *
		 * @param integer $exp_secs Optional. Defaults to `10`.
		 *    If `$check_time` is TRUE, check if the signature has expired, based on `$exp_secs`.
		 *
		 * @param string  $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
		 *
		 * @return boolean TRUE if the signature is OK.
		 */
		public function query_sig_ok($url_uri_query_fragment, $check_time = FALSE, $exp_secs = 10, $sig_var = '_sig')
		{
			$this->check_arg_types('string', 'boolean', 'integer', 'string:!empty', func_get_args());

			if(!($parts = $this->parse($url_uri_query_fragment)))
				return FALSE; // Not possible to check.

			if(!$parts['query'] || !($vars = $this->©vars->parse_query($parts['query'])))
				return FALSE; // No query string variables.

			if(empty($vars[$sig_var]) || !preg_match('/^(?P<time>[0-9]+)\-(?P<sig>.+)$/', $vars[$sig_var], $sig_parts))
				return FALSE; // There is no signature in the query string.

			unset($vars[$sig_var]); // Need to remove the signature variable now.
			$vars = $this->©array->remove_0b_strings_deep($this->©strings->trim_deep($vars));
			$vars = serialize($this->©array->ksort_deep($vars));

			$valid_sig = $this->©encryption->hmac_sha1_sign($vars.$sig_parts['time']);

			if($check_time) // Checking time too?
				return ($sig_parts['sig'] === $valid_sig && $sig_parts['time'] >= strtotime('-'.abs($exp_secs).' seconds'));

			return ($sig_parts['sig'] === $valid_sig);
		}

		/**
		 * Removes all signatures from a URL (or a URI/query/fragment only).
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be handled here.
		 *
		 * @param string $sig_var Optional signature name. Defaults to `_sig`. The name of the signature variable.
		 *
		 * @return string A URL (or a URI/query/fragment only); without any signatures.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$sig_var` is empty.
		 */
		public function remove_query_sig($url_uri_query_fragment, $sig_var = '_sig')
		{
			$this->check_arg_types('string', 'string:!empty', func_get_args());

			return remove_query_arg($sig_var, $url_uri_query_fragment);
		}

		/**
		 * Shortens a long URL.
		 *
		 * @param string  $url A full/long URL to be shortened.
		 *
		 * @param string  $specific_built_in_api Optional. A specific URL shortening API to use.
		 *    Defaults to that which is configured in the options.
		 *
		 * @param boolean $try_backups Defaults to TRUE. If a failure occurs with the first API,
		 *    we'll try others until we have success. Also used internally by this routine.
		 *
		 * @return string The shortened URL on success, else the original `$url` on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function shorten($url, $specific_built_in_api = '', $try_backups = TRUE)
		{
			$this->check_arg_types('string:!empty', 'string', 'boolean', func_get_args());

			$built_in_apis        = array('goo_gl', 'tiny_url');
			$custom_url_api       = $this->©options->get('url_shortener.custom_url_api');
			$default_built_in_api = $this->©options->get('url_shortener.default_built_in_api');
			$current_built_in_api = ($specific_built_in_api) ? $specific_built_in_api : $default_built_in_api;

			// First try custom APIs (if nothing specific was requested here).

			if(!$specific_built_in_api) // Expose this filter to plugins.
				if(($custom_url = trim($this->apply_filters('shorten', '', get_defined_vars()))) && stripos($custom_url, 'http') === 0)
					return ($shorter_url = $custom_url);

			if(!$specific_built_in_api && $custom_url_api) // A custom default URL API?
				if(($custom_url_api = str_ireplace(array('%%long_url%%', '%%long_url_md5%%'),
				                                   array(rawurlencode($url), urlencode(md5($url))), $custom_url_api))
				) if(($custom_url = trim($this->remote($custom_url_api))) && stripos($custom_url, 'http') === 0)
					return ($shorter_url = $custom_url);

			// Nothing custom; so let's go with the current built-in API.

			if($current_built_in_api === 'goo_gl') // Google® shortener (recommended).
				if(is_string($goo_gl_key = ($goo_gl_key = $this->©options->get('url_shortener.api_keys.goo_gl')) ? '?key='.urlencode($goo_gl_key) : ''))
					if(is_array($goo_gl = json_decode(trim($this->remote('https://www.googleapis.com/urlshortener/v1/url'.$goo_gl_key, json_encode(array('longUrl' => $url)), array('headers' => array('Content-Type' => 'application/json')))), TRUE)))
						if(($goo_gl_url = $this->©string->is_not_empty_or($goo_gl['id'], '')) && stripos($goo_gl_url, 'http') === 0)
							return ($shorter_url = $goo_gl_url.'#'.(string)$this->parse($url, PHP_URL_HOST));

			if($current_built_in_api === 'tiny_url') // TinyURL™ shortener.
				if(($tiny_url = trim($this->remote('http://tinyurl.com/api-create.php?url='.rawurlencode($url)))) && stripos($tiny_url, 'http') === 0)
					return ($shorter_url = $tiny_url.'#'.(string)$this->parse($url, PHP_URL_HOST));

			// Still nothing. Let's try some backups.

			if($try_backups && count($built_in_apis) > 1) // If we have one.
			{
				foreach(array_diff($built_in_apis, array($current_built_in_api)) as $backup)
					if(($backup = $this->shorten($url, $backup, FALSE)) !== $url)
						return ($shorter_url = $backup);
			}
			return $url; // Default return value (failure).
		}

		/**
		 * Pre-parsed WordPress root URL parts.
		 *
		 * @return array An array of pre-parsed WordPress root URL parts.
		 */
		public function wp_root_parts()
		{
			if(!isset($this->static[__FUNCTION__]))
				$this->static[__FUNCTION__] = array(
					'wp_home_parts'         => $this->must_parse($this->to_wp_home_uri()),
					'wp_site_parts'         => $this->must_parse($this->to_wp_site_uri()),
					'wp_network_home_parts' => $this->must_parse($this->to_wp_network_home_uri()),
					'wp_network_site_parts' => $this->must_parse($this->to_wp_network_site_uri()),
				);
			return $this->static[__FUNCTION__];
		}

		/**
		 * Checks to see if a URL/URI leads to a WordPress® root URL.
		 *
		 * @param string       $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be tested here.
		 *
		 * @param string|array $type Defaults to {@link fw_constants::any_type}.
		 *    By default, this method returns TRUE if `$url_uri` matches any WordPress® root URL.
		 *    Set this to {@link fw_constants::home_type}, to test against the WordPress® `home_url('/')`.
		 *    Set this to {@link fw_constants::site_type}, to test against the WordPress® `site_url('/')`.
		 *    Set this to {@link fw_constants::network_home_type}, to test against the WordPress® `network_home_url('/')`.
		 *    Set this to {@link fw_constants::network_site_type}, to test against the WordPress® `network_site_url('/')`.
		 *    This can also be set to an array to test for multiple/specific types.
		 *
		 * @return boolean TRUE if the URL or URI leads to a WordPress® root URL.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$type` is empty.
		 */
		public function is_wp_root($url_uri_query_fragment, $type = self::any_type)
		{
			$this->check_arg_types('string', array('string:!empty', 'array:!empty'), func_get_args());

			$type     = (array)$type; // Force array.
			$any_type = in_array($this::any_type, $type, TRUE);

			if(!($parts = $this->parse($url_uri_query_fragment)))
				return FALSE; // Not possible to check.

			$wp_root_parts = $this->wp_root_parts(); // WP root parts.

			if($any_type || in_array($this::home_type, $type, TRUE))
			{
				if(!$parts['host'] || strcasecmp($parts['host'], $wp_root_parts['wp_home_parts']['host']) === 0)
					if($parts['path'] === $wp_root_parts['wp_home_parts']['path'])
						return TRUE;
			}
			if($any_type || in_array($this::site_type, $type, TRUE))
			{
				if(!$parts['host'] || strcasecmp($parts['host'], $wp_root_parts['wp_site_parts']['host']) === 0)
					if($parts['path'] === $wp_root_parts['wp_site_parts']['path'])
						return TRUE;
			}
			if(is_multisite() && ($any_type || in_array($this::network_home_type, $type, TRUE)))
			{
				if(!$parts['host'] || strcasecmp($parts['host'], $wp_root_parts['wp_network_home_parts']['host']) === 0)
					if($parts['path'] === $wp_root_parts['wp_network_home_parts']['path'])
						return TRUE;
			}
			if(is_multisite() && ($any_type || in_array($this::network_site_type, $type, TRUE)))
			{
				if(!$parts['host'] || strcasecmp($parts['host'], $wp_root_parts['wp_network_site_parts']['host']) === 0)
					if($parts['path'] === $wp_root_parts['wp_network_site_parts']['path'])
						return TRUE;
			}
			return FALSE; // Default return value.
		}

		/**
		 * Leads to a WordPress® administrative area?
		 *
		 * @param string $url_uri_query_fragment A full URL; or a partial URI;
		 *    or only a query string, or only a fragment. Any of these can be tested here.
		 *
		 * @return boolean TRUE if `$url_uri_query_fragment` leads to a WordPress® administrative area.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_in_wp_admin($url_uri_query_fragment)
		{
			$this->check_arg_types('string', func_get_args());

			if(!$url_uri_query_fragment || !($parts = $this->parse($url_uri_query_fragment)))
				return FALSE; // Not something we can test? Catch this early.

			return (preg_match('/\/wp-admin(?:[\/?#]|$)/', $parts['path'])) ? TRUE : FALSE;
		}

		/**
		 * Filters content redirection status.
		 *
		 * @param integer $status A redirection status code.
		 *
		 * @return integer A status redirection code; possibly modified to a value of `302` by this filter.
		 *
		 * @throws exception If invalid types are passed through arguments lists.
		 *
		 * @see http://en.wikipedia.org/wiki/Web_browser_engine
		 */
		public function redirect_browsers_using_302_status($status)
		{
			$this->check_arg_types('integer', func_get_args());

			if($status === 301 && $this->©env->is_browser()) return 302;

			return $status; // Default value.
		}
	}
}