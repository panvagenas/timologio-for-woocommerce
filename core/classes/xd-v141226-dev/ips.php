<?php
/**
 * IPs.
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
	 * IPs.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class ips extends framework
	{
		/**
		 * Get the current visitor's real IP address.
		 *
		 * @return string Real IP address, else `unknown` on failure.
		 */
		public function get()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = 'unknown';

			$_s = $this->©vars->_SERVER();

			if($this->©options->get('ips.prioritize_remote_addr')
			   && ($REMOTE_ADDR = $this->©ips->valid_public($_s['REMOTE_ADDR']))
			) return ($this->static[__FUNCTION__] = $REMOTE_ADDR);

			$sources = $this->apply_filters(
				'sources', array(
					'HTTP_CLIENT_IP',
					'HTTP_X_FORWARDED_FOR',
					'HTTP_X_FORWARDED',
					'HTTP_X_CLUSTER_CLIENT_IP',
					'HTTP_FORWARDED_FOR',
					'HTTP_FORWARDED',
					'HTTP_VIA',
					'REMOTE_ADDR'
				)
			);
			foreach($sources as $_source) // Try each of these; in this order.
				if(!isset($$_source) && ($$_source = $this->©ips->valid_public($_s[$_source])))
					return ($this->static[__FUNCTION__] = $$_source);
			unset($_source); // Housekeeping.

			$this->static[__FUNCTION__] = $this->©string->is_not_empty_or($_s['REMOTE_ADDR'], 'unknown');

			return $this->static[__FUNCTION__];
		}

		/**
		 * Gets a valid/public IP address.
		 *
		 * @param string $possible_ips A single IP, or a possible comma-delimited list of IPs.
		 *    Pass by reference to avoid PHP notices while checking multiple sources.
		 *
		 * @return string A valid/public IP address (if one is found), else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		function valid_public(&$possible_ips)
		{
			if(!isset($this->static[__FUNCTION__]['private_ips']))
			{
				$this->static[__FUNCTION__]['private_ips'] = array(
					array(
						'min' => ip2long('0.0.0.0'),
						'max' => ip2long('2.255.255.255')
					),
					array(
						'min' => ip2long('10.0.0.0'),
						'max' => ip2long('10.255.255.255')
					),
					array(
						'min' => ip2long('127.0.0.0'),
						'max' => ip2long('127.255.255.255')
					),
					array(
						'min' => ip2long('169.254.0.0'),
						'max' => ip2long('169.254.255.255')
					),
					array(
						'min' => ip2long('172.16.0.0'),
						'max' => ip2long('172.31.255.255')
					),
					array(
						'min' => ip2long('192.0.2.0'),
						'max' => ip2long('192.0.2.255')
					),
					array(
						'min' => ip2long('192.168.0.0'),
						'max' => ip2long('192.168.255.255')
					),
					array(
						'min' => ip2long('255.255.255.0'),
						'max' => ip2long('255.255.255.255')
					)
				);
			}
			if($this->©string->is_not_empty($possible_ips))
				foreach(preg_split('/[\s;,]+/', trim($possible_ips)) as $_possible_ip)
					if($_possible_ip && !in_array(($_ip2long = ip2long($_possible_ip)), array(-1, FALSE), TRUE))
					{
						foreach($this->static[__FUNCTION__]['private_ips'] as $_private_ip_range)
							if($_ip2long >= $_private_ip_range['min'] && $_ip2long <= $_private_ip_range['max'])
								continue 2; // This IP is in a private range.
						unset($_private_ip_range); // Housekeeping.

						return long2ip($_ip2long); // Else it's fine!
					}
			unset($_possible_ip, $_ip2long); // Housekeeping.

			return ''; // Default return value.
		}

		/**
		 * Is an IP address is the given range?
		 *
		 * @param string $ip An IP address.
		 * @param string $cidr An IP address, or CIDR notation.
		 *
		 * @return boolean TRUE if `$ip` is within the range specified by `$cidr`; else FALSE;
		 *    Also returns TRUE, if `$cidr` is NOT a CIDR notation; and both `$ip` and `$cidr` are exactly the same.
		 */
		public function in_range($ip, $cidr)
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if($ip && $cidr && substr_count($cidr, '/') === 1)
			{
				list ($net, $mask) = explode('/', $cidr, 2);
				return (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) === ip2long($net);
			}
			else if($ip === $cidr) return TRUE; // Exact match?

			return FALSE; // Default return value.
		}
	}
}