<?php
/**
 * Cookies.
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
	 * Cookies.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class cookies extends framework
	{
		/**
		 * Gets a cookie value.
		 *
		 * @param string $name Name of the cookie.
		 *
		 * @return string Cookie string value, else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$name` is empty.
		 */
		public function get($name)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if($this->©string->¤is_not_empty($cookie = $this->©vars->_COOKIE($name)))
				$value = $this->©encryption->decrypt($cookie);

			return (!empty($value)) ? $value : '';
		}

		/**
		 * Sets a cookie value.
		 *
		 * @param string  $name Name of the cookie.
		 *
		 * @param string  $value Value for this cookie.
		 *
		 * @param integer $expires_after Optional. Time (in seconds) this cookie should last for. Defaults to `31556926` (one year).
		 *    If this is set to anything <= `0`, the cookie will expire automatically after the current browser session.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$name` is empty.
		 */
		public function set($name, $value, $expires_after = 31556926)
		{
			$this->check_arg_types('string:!empty', 'string', 'integer', func_get_args());

			$value   = $this->©encryption->encrypt($value);
			$expires = ($expires_after > 0) ? time() + $expires_after : 0;

			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent.')
				);
			setcookie($name, $value, $expires, COOKIEPATH, COOKIE_DOMAIN);
			setcookie($name, $value, $expires, SITECOOKIEPATH, COOKIE_DOMAIN);

			if($name !== TEST_COOKIE) $_COOKIE[$name] = $value; // Update in real-time.
		}

		/**
		 * Deletes a cookie.
		 *
		 * @param string $name Name of the cookie.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$name` is empty.
		 */
		public function delete($name)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent.')
				);
			setcookie($name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
			setcookie($name, '', time() - 3600, SITECOOKIEPATH, COOKIE_DOMAIN);

			$_COOKIE[$name] = ''; // Update in real-time.
		}
	}
}