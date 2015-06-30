<?php
/**
 * Package Utilities.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 140523
 */
namespace xd_v141226_dev
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Package Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class packages extends framework
	{
		public function query($search = '', $page = 1, $per_page = 25)
		{
			$this->check_arg_types('string', 'integer:!empty', 'integer:!empty', func_get_args());

			$page          = $page < 1 ? 1 : $page;
			$credentials   = $this->©plugin->get_site_credentials();
			$endpoint      = $this->©url->to_plugin_site_uri('/packages/json.php');
			$endpoint_vars = array_merge($credentials, compact('search', 'page', 'per_page'));
			$response      = json_decode($this->©url->remote($endpoint, $credentials));

			if(!$this->©integer->is($response->next_page)
			   || !$this->©integer->is($response->total)
			   || !$this->©array->is($response->packages)
			) throw $this->©exception(
				$this->method(__FUNCTION__).'#invalid_response', get_defined_vars(),
				sprintf($this->__('Invalid response from package server. Got: `%1$s`.'), $this->©var->dump($response))
			);
			foreach($response->packages as &$_package)
				$_package = $this->©packages__package($_package);
			unset($_package); // Housekeeping.

			return $response;
		}

		public function ®install($package)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$package = json_decode($package);
			$package = $this->©packages__package($package);
			$install = $package->install();

			if($this->©errors->exist_in($install))
				$errors = $install; // Errors.

			else $successes = $this->©success(
				$this->method(__FUNCTION__.'#success'), get_defined_vars(),
				sprintf($this->__('%1$s installed successfully.'), $package->title)
			);
			$this->©action->set_call_data_for($this->dynamic_call(__METHOD__), get_defined_vars());
		}

		public function ®uninstall($package)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$package   = json_decode($package);
			$package   = $this->©packages__package($package);
			$uninstall = $package->uninstall();

			if($this->©errors->exist_in($uninstall))
				$errors = $uninstall; // Errors.

			else $successes = $this->©success(
				$this->method(__FUNCTION__.'#success'), get_defined_vars(),
				sprintf($this->__('%1$s uninstalled successfully.'), $package->title)
			);
			$this->©action->set_call_data_for($this->dynamic_call(__METHOD__), get_defined_vars());
		}
	}
}