<?php
/**
 * Currencies.
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
	 * Currencies.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class currencies extends framework
	{
		/**
		 * Currency converter.
		 *
		 * Uses the Google® currency conversion API.
		 *
		 * @param float  $amount The amount, in `$from` currency.
		 * @param string $from A 3 character currency code.
		 * @param string $to A 3 character currency code.
		 *
		 * @return float Amount in `$to`, after having been converted.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$from` or `$to` are empty strings, or NOT 3 characters in length.
		 * @throws exception If currency conversion fails for any reason.
		 *
		 * @see http://www.google.com/finance/converter
		 * @see http://www.techmug.com/ajax-currency-converter-with-google-api/
		 */
		public function convert($amount, $from, $to)
		{
			$this->check_arg_types('float', 'string:!empty', 'string:!empty', func_get_args());

			if(strlen($from) !== 3)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_from_currency', get_defined_vars(),
					$this->__('Argument `$from` MUST be 3 characters in length.').
					' '.sprintf($this->__('Got: `%1$s`.'), $from)
				);
			if(strlen($to) !== 3)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_to_currency', get_defined_vars(),
					$this->__('Argument `$to` MUST be 3 characters in length.').
					' '.sprintf($this->__('Got: `%1$s`.'), $to)
				);
			// Attempt to convert the currency via Google's calculator.

			$q        = strtoupper($from.'-'.$to); // Also need this to test the return value.
			$endpoint = 'http://www.freecurrencyconverterapi.com/api/convert?q='.urlencode($q).'&compact=y';

			if( // Test several conditions for success.
				($json = $this->©url->remote($endpoint)) && is_object($json = json_decode($json))
				&& isset($json->{$q}->val) && is_numeric($json->{$q}->val)
				&& is_float($conversion = $amount * (float)$json->{$q}->val)
			) return $conversion; // It's a good day in Eureka!

			// Throw exception when currency conversion fails.
			$error_msg = $this->__('unknown error');

			throw $this->©exception(
				$this->method(__FUNCTION__).'#currency_conversion_failure', get_defined_vars(),
				sprintf($this->__('Currency conversion failed with error: `%1$s`.'), $error_msg).
				' '.sprintf($this->__('JSON response data: `%1$s`'), $this->©var->dump($json))
			);
		}

		/**
		 * Formats floats into amounts with two decimal places.
		 *
		 * @param float   $amount The amount.
		 *
		 * @param string  $currency Optional. Defaults to an empty string.
		 *    By default, this returns the amount only. If a currency code is passed in,
		 *    the amount will be prefixed with a currency symbol,
		 *    and suffixed with the currency code.
		 *
		 * @param boolean $prefix If `$currency` is passed in, should we add a prefix?
		 *    This defaults to TRUE, when `$currency` is passed in.
		 *    Setting this to FALSE will exclude the prefix.
		 *
		 * @param boolean $suffix If `$currency` is passed in, should we add a suffix?
		 *    This defaults to TRUE, when `$currency` is passed in.
		 *    Setting this to FALSE will exclude the suffix.
		 *
		 * @return string A numeric string representation, with two decimal places.
		 *    The resulting amount is rounded up, to the nearest penny.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$currency` is passed with a value that is NOT 3 characters in length.
		 * @throws exception If `$currency` is passed with a value that is NOT a currently supported currency.
		 * @throws exception See `get()` method for further details.
		 */
		public function format($amount, $currency = '', $prefix = TRUE, $suffix = TRUE)
		{
			$this->check_arg_types('float', 'string', 'boolean', 'boolean', func_get_args());

			$currencies = $this->get();

			if(($currency = strtoupper($currency)) && strlen($currency) !== 3)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_currency', get_defined_vars(),
					$this->__('Argument `$currency` MUST be 3 characters in length.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $currency)
				);
			if($currency && !isset($currencies[$currency]))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unsupported_currency', get_defined_vars(),
					$this->__('The `$currency` code is NOT currently supported by this software.').
					' '.sprintf($this->__('Unsupported currency code: `%1$s`.'), $currency)
				);
			$format = number_format($amount, 2, '.', '');
			$format = ($currency && $prefix) ? $this->get($currency, 'symbol').$format : $format;
			$format = ($currency && $suffix) ? $format.' '.strtoupper($currency) : $format;

			return $format;
		}

		/**
		 * Gets supported currency details.
		 *
		 * @param string $currency Optional. Defaults to an empty string.
		 *    By default, an array with all currencies/components will be returned.
		 *    If passed in, this MUST be a valid 3 character currency code to retrieve components for.
		 *
		 * @param string $component Defaults to an empty string.
		 *    By default, an array with all components will be returned.
		 *    If passed in, this MUST be one of: `symbol`, `singular_name`, `plural_name`.
		 *
		 * @return string|array Currency component(s).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$currency` is passed with a value that is NOT 3 characters in length.
		 * @throws exception If `$currency` is passed with a value that is NOT a currently supported currency.
		 * @throws exception If `$component` is passed with a value that is NOT one of:
		 *    `symbol`, `singular_name`, `plural_name`.
		 */
		public function get($currency = '', $component = '')
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!isset($this->cache[__FUNCTION__]))
				$this->cache[__FUNCTION__] = array
				(
					'AUD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('Australian Dollar'),
						'plural_name'   => $this->_x('Australian Dollars')
					),
					'BRL' => array(
						'symbol'        => 'R$',
						'singular_name' => $this->_x('Brazilian Real'),
						'plural_name'   => $this->_x('Brazilian Reais')
					),
					'CAD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('Canadian Dollar'),
						'plural_name'   => $this->_x('Canadian Dollars')
					),
					'CZK' => array(
						'symbol'        => 'Kč',
						'singular_name' => $this->_x('Czech Koruna'),
						'plural_name'   => $this->_x('Czech Koruny')
					),
					'DKK' => array(
						'symbol'        => 'kr',
						'singular_name' => $this->_x('Danish Krone'),
						'plural_name'   => $this->_x('Danish Kroner')
					),
					'EUR' => array(
						'symbol'        => '€',
						'singular_name' => $this->_x('Euro'),
						'plural_name'   => $this->_x('Euros')
					),
					'HKD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('Hong Kong Dollar'),
						'plural_name'   => $this->_x('Hong Kong Dollars')
					),
					'HUF' => array(
						'symbol'        => 'Ft',
						'singular_name' => $this->_x('Hungarian Forint'),
						'plural_name'   => $this->_x('Hungarian Forintok')
					),
					'ILS' => array(
						'symbol'        => '₪',
						'singular_name' => $this->_x('Israeli New Sheqel'),
						'plural_name'   => $this->_x('Israeli New Shekalim')
					),
					'JPY' => array(
						'symbol'        => '¥',
						'singular_name' => $this->_x('Japanese Yen'),
						'plural_name'   => $this->_x('Japanese Yen')
					),
					'MYR' => array(
						'symbol'        => 'RM',
						'singular_name' => $this->_x('Malaysian Ringgit'),
						'plural_name'   => $this->_x('Malaysian Ringgit')
					),
					'MXN' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('Mexican Peso'),
						'plural_name'   => $this->_x('Mexican Pesos')
					),
					'NOK' => array(
						'symbol'        => 'kr',
						'singular_name' => $this->_x('Norwegian Krone'),
						'plural_name'   => $this->_x('Norwegian Kroner')
					),
					'NZD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('New Zealand Dollar'),
						'plural_name'   => $this->_x('New Zealand Dollars')
					),
					'PHP' => array(
						'symbol'        => 'Php',
						'singular_name' => $this->_x('Philippine Peso'),
						'plural_name'   => $this->_x('Philippine Pesos')
					),
					'PLN' => array(
						'symbol'        => 'zł',
						'singular_name' => $this->_x('Polish Zloty'),
						'plural_name'   => $this->_x('Polish Zlotys')
					),
					'GBP' => array(
						'symbol'        => '£',
						'singular_name' => $this->_x('Pound Sterling'),
						'plural_name'   => $this->_x('Pounds Sterling')
					),
					'SGD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('Singapore Dollar'),
						'plural_name'   => $this->_x('Singapore Dollars')
					),
					'SEK' => array(
						'symbol'        => 'kr',
						'singular_name' => $this->_x('Swedish Krona'),
						'plural_name'   => $this->_x('Swedish Kronor')
					),
					'CHF' => array(
						'symbol'        => 'CHF',
						'singular_name' => $this->_x('Swiss Franc'),
						'plural_name'   => $this->_x('Swiss Francs')
					),
					'TWD' => array(
						'symbol'        => 'NT$',
						'singular_name' => $this->_x('Taiwan New Dollar'),
						'plural_name'   => $this->_x('Taiwan New Dollars')
					),
					'THB' => array(
						'symbol'        => '฿',
						'singular_name' => $this->_x('Thai Baht'),
						'plural_name'   => $this->_x('Thai Bahts')
					),
					'USD' => array(
						'symbol'        => '$',
						'singular_name' => $this->_x('U.S. Dollar'),
						'plural_name'   => $this->_x('U.S. Dollars')
					)
				);
			// Further validate arguments.

			if(($currency = strtoupper($currency)) && strlen($currency) !== 3)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_currency', get_defined_vars(),
					$this->__('Argument `$currency` MUST be 3 characters in length.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $currency)
				);
			if(($component = strtolower($component)) && !in_array($component, array('symbol', 'singular_name', 'plural_name'), TRUE))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_component', get_defined_vars(),
					$this->__('Argument `$component` MUST be one of: `symbol`, `singular_name`, `plural_name`.').
					' '.sprintf($this->__('Instead got: `%1$s`.'), $component)
				);
			if($currency && !isset($this->cache[__FUNCTION__][$currency]))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unsupported_currency', get_defined_vars(),
					$this->__('The `$currency` code is NOT currently supported by this software.').
					' '.sprintf($this->__('Unsupported currency code: `%1$s`.'), $currency)
				);
			// Everything looks good. Return now.

			if(!$currency)
				return $this->cache[__FUNCTION__];

			if(!$component)
				return $this->cache[__FUNCTION__][$currency];

			if($component === 'symbol')
				return $this->cache[__FUNCTION__][$currency]['symbol'];

			if($component === 'singular_name')
				return $this->cache[__FUNCTION__][$currency]['singular_name'];

			if($component === 'plural_name')
				return $this->cache[__FUNCTION__][$currency]['plural_name'];

			throw $this->©exception(
				$this->method(__FUNCTION__).'#unknown_component', get_defined_vars(),
				sprintf($this->__('Unknown currency component: `%1$s`.'), $component)
			);
		}
	}
}