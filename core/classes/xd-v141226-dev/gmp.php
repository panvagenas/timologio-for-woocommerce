<?php
/**
 * GMP Utilities.
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
	 * GMP Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class gmp extends framework
	{
		/**
		 * @var resource GMP number resource.
		 * @by-constructor Set dynamically by constructor.
		 */
		public $_0 = '0';

		/**
		 * @var resource GMP number resource.
		 * @by-constructor Set dynamically by constructor.
		 */
		public $_1 = '1';

		/**
		 * @var resource GMP number resource.
		 * @by-constructor Set dynamically by constructor.
		 */
		public $_2 = '2';

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If GMP extension is not loaded up.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			if(!extension_loaded('gmp'))
				throw $this->©exception( // Should NOT happen.
					$this->method(__FUNCTION__), get_defined_vars(),
					$this->__('GMP extension NOT loaded or unavailable.')
				);
			$this->_0 = $this->resource($this->_0); // Converts to resource.
			$this->_1 = $this->resource($this->_1); // Converts to resource.
			$this->_2 = $this->resource($this->_2); // Converts to resource.
		}

		/**
		 * Converts a numeric string into a GMP number resource.
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return resource GMP number resource. Note: resources are always references.
		 *    See also: {@link resource_copy()} for copying a resource.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function resource($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			return (!is_resource($number)) ? gmp_init($number) : $number;
		}

		/**
		 * Copies a GMP resource by reinitializing string value.
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return resource GMP number resource. Note: resources are always references.
		 *    See also: {@link resource()} for producing the initial resource.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function resource_copy($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			return $this->resource($this->string($number));
		}

		/**
		 * Converts a GMP number resource into a string.
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return string Numeric value; converted from a GMP resource into a string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function string($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			return (is_resource($number)) ? gmp_strval($number) : (string)$number;
		}

		/**
		 * Two, to the power of a number (e.g. 2^`$number`).
		 *
		 * @param integer $integer Integer value indicating powers of 2.
		 *    ~ `gmp_pow()` does NOT allow arbitrary precision; integer only.
		 *
		 * @return string Numeric string (e.g. 2^`$number`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function exp_2($integer)
		{
			$this->check_arg_types(array('integer'), func_get_args());

			return $this->string(gmp_pow($this->_2, $integer));
		}

		/**
		 * Logarithm (in base 2).
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return string Numeric string (e.g. logarithm in base 2).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function log_2($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			$log_2  = $this->resource('0');
			$number = $this->resource($number);
			$n      = $this->resource_copy($number);

			if($this->is_power_of_2($number))
				return $this->_perfect_log_2($number);

			while(gmp_cmp($n, $this->_2) >= 0)
			{
				$n     = gmp_div($n, $this->_2);
				$log_2 = gmp_add($log_2, $this->_1);
			}
			return $this->string($log_2);
		}

		/**
		 * Logarithm (in base 2); for perfect powers of 2 only.
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return string Numeric string (e.g. logarithm in base 2).
		 *
		 * @warning This routine has been further optimized to work on perfect powers of 2.
		 *    However, it will loop forever if the number is NOT a perfect power of 2.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		protected function _perfect_log_2($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			$number = $this->resource($number);

			for($log_2 = 1; TRUE; $log_2++)
				if(gmp_cmp(gmp_pow($this->_2, $log_2), $number) === 0)
					break; // Got it! We can stop here.

			return $this->string($log_2);
		}

		/**
		 * Next highest power of 2 (e.g. exponent of 2).
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return string Next highest power of 2 (e.g. exponent of 2).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function next_power_of_2($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			$number = $this->resource($number);

			if(gmp_cmp($number, $this->_2) <= 0)
				return '2'; // Default value.

			if($this->is_power_of_2($number))
				return $this->string($number);

			$n = $this->resource_copy($number);

			while(gmp_cmp(${'n&n-1'} = gmp_and($n, gmp_sub($n, $this->_1)), $this->_0))
				$n = ${'n&n-1'}; // Saves 2 calls on each iteration.

			return $this->string(gmp_mul($n, $this->_2));
		}

		/**
		 * Is number a power of 2 (e.g. an exponential value of 2)?
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return boolean TRUE if `$number` is a power of 2.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_power_of_2($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			$number = $this->resource($number); // Resource.

			return !gmp_cmp(gmp_and($number, gmp_sub($number, $this->_1)), $this->_0);
		}

		/**
		 * Difference between two numbers.
		 *
		 * @param string|resource $number1 Numeric string; or GMP resource.
		 * @param string|resource $number2 Numeric string; or GMP resource.
		 *
		 * @return string Difference between two numbers.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function diff($number1, $number2)
		{
			$this->check_arg_types(array('numeric', 'resource'),
			                       array('numeric', 'resource'), func_get_args());

			$number1 = $this->resource($number1);
			$number1 = $this->resource($number1);

			return $this->string(gmp_sub($number1, $number2));
		}

		/**
		 * Binary representation of number (e.g. `1010010101101`).
		 *
		 * @param string|resource $number Numeric string; or GMP resource.
		 *
		 * @return string Binary representation of number (e.g. `1010010101101`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function num2bin($number)
		{
			$this->check_arg_types(array('numeric', 'resource'), func_get_args());

			$number = $this->resource($number);
			$n      = $this->resource_copy($number);
			$ns     = $this->string($n);

			for($binary = ''; $ns !== '0'; $ns = $this->string($n = gmp_div($n, $this->_2)))
				$binary .= chr(48 + ($ns[strlen($ns) - 1] % 2));

			return strrev($binary);
		}
	}
}