<?php
/**
 * Shortcode.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev\shortcodes
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Shortcode.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class shortcode extends \xd_v141226_dev\framework
	{
		/**
		 * Gets default shortcode attributes.
		 *
		 * @note This should be overwritten by class extenders.
		 *
		 * @return array Default shortcode attributes.
		 */
		public function attr_defaults()
		{
			return array();
		}

		/**
		 * Gets all shortcode attribute keys, interpreted as boolean values.
		 *
		 * @note This should be overwritten by class extenders.
		 *
		 * @return array Boolean attribute keys.
		 */
		public function boolean_attr_keys()
		{
			return array();
		}

		/**
		 * Normalizes shortcode attributes.
		 *
		 * @param string|array $attr An array of all shortcode attributes (if there were any).
		 *    Or, a string w/ the entire attributes section (when WordPress® fails to parse attributes).
		 *
		 * @return array An array of all shortcode attributes. One dimension (all string values).
		 */
		public function normalize_attr_strings($attr)
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$attr = (array)$attr;
			$attr = $this->©array->to_one_dimension($attr);
			$attr = $this->©strings->trim_deep($attr);

			foreach($this->boolean_attr_keys() as $_attr_key)
			{
				if(isset($attr[$_attr_key]) && is_string($attr[$_attr_key]))
					if($this->©string->is_true($attr[$_attr_key]))
						$attr[$_attr_key] = '1';
					else $attr[$_attr_key] = '0';
			}
			unset($_attr_key); // Just a little housekeeping.

			return array_merge($this->attr_defaults(), $attr);
		}
	}
}