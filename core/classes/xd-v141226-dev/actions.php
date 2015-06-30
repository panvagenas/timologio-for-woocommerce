<?php
/**
 * Actions.
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
	 * Actions.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class actions extends framework
	{
		/**
		 * @var array The current action.
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $action; // Defaults to a NULL value.

		/**
		 * @var array Array of `call` action data.
		 */
		public $call_data_for = array();

		/**
		 * Handles actions.
		 *
		 * @attaches-to WordPress® `wp_loaded` action hook.
		 * @hook-priority `-10000` Before most everything else.
		 */
		public function wp_loaded()
		{
			if(!$this->is()) return;

			$this->©env->increase_db_wait_timeout();

			if($this->is('call')) $this->call($this->action);
			else if($this->is('ajax')) $this->ajax($this->action);
		}

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If a request contains an expired action key.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			$_r = $this->©vars->_REQUEST(NULL, TRUE); // REQUEST (including files).

			if($this->©array->is_not_empty($_r[$this->instance->plugin_var_ns]['a']))
				$this->action = $_r[$this->instance->plugin_var_ns]['a'];

			else if($this->©string->is_not_empty($_r[$this->instance->plugin_var_ns.'_action']))
			{
				if(strpos($_r[$this->instance->plugin_var_ns.'_action'], '.key.') !== FALSE)
				{
					$action_key = $_r[$this->instance->plugin_var_ns.'_action'];
					$action     = $this->©db_utils->get_transient($action_key);

					if(!$this->©array->is_not_empty($action))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#invalid_or_expired_action_key', get_defined_vars(),
							sprintf($this->__('Invalid or expired action key: `%1$s`.'), $action_key)
						);
					$this->action = $action; // Define action property.
				}
				else // Treat the `action` as a slug (we construct an array from this).
					$this->action = array('s' => $_r[$this->instance->plugin_var_ns.'_action']);
			}
		}

		/**
		 * Is the current plugin performing an action?
		 *
		 * @param null|string $slug Optional. A specific action slug to check for.
		 *    This defaults to a NULL value (e.g. any type of action).
		 *
		 * @return boolean TRUE if the current plugin is performing an action; else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is($slug = NULL)
		{
			$this->check_arg_types(array('null', 'string'), func_get_args());

			if(!empty($this->action['s']) && (!$slug || $this->action['s'] === $slug))
				return TRUE; // Returns action array values.

			return FALSE; // Default return value.
		}

		/**
		 * Is the current plugin performing a `call` action?
		 *
		 * @param null|string $call Optional. A `call` (i.e. dynamic `©class.®method` action) to check for.
		 *    This defaults to a NULL value (e.g. any type of `call` action).
		 *
		 * @return boolean TRUE if the current plugin is performing a `call` action; else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_call($call = NULL)
		{
			$this->check_arg_types(array('null', 'string'), func_get_args());

			if($this->is('call') && (!$call || (isset($this->action['c']) && $this->action['c'] === $call)))
				return TRUE;

			return FALSE; // Default return value.
		}

		/**
		 * Handles `call` actions for the current plugin.
		 *
		 * @param array $action An action array, as returned by `$this->is()`.
		 *
		 * @return mixed Value from method being called upon, else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$action` is empty; or if it CANNOT be called upon, for any reason.
		 */
		public function call($action)
		{
			$this->check_arg_types('array:!empty', func_get_args());

			$call = $this->©string->is_not_empty_or($action['c'], '');
			$type = $this->©string->is_not_empty_or($action['t'], '');

			if($this->©string->is_not_empty($action['a']))
				$action['a'] = json_decode($action['a'], TRUE);
			$args = $this->©array->is_not_empty_or($action['a'], array());

			ksort($args, SORT_NUMERIC); // Make sure arguments are ordered by key.
			if(isset($args['___file_info'])) // `___file_info` into last position always.
			{
				$___file_info = $args['___file_info'];
				unset($args['___file_info']);
				$args[] = $___file_info;
			}
			$verifier = $this->©string->is_not_empty_or($action['v'], '');

			if($this->©strings->are_not_empty($call, $type, $verifier))
				if($this->verify_call($call, $type, $verifier))
					return $this->__call($call, $args);

			throw $this->©exception(
				$this->method(__FUNCTION__).'#invalid_or_expired_call_action_verifier', get_defined_vars(),
				$this->__('Invalid or expired `call` action verifier. Unable to process.').
				' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($action))
			);
		}

		/**
		 * Handles `ajax` call actions for the current plugin.
		 *
		 * @param array $action An action array, as returned by `$this->is()`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$action` is empty; or if it CANNOT be called upon, for any reason.
		 */
		public function ajax($action)
		{
			$this->check_arg_types('array:!empty', func_get_args());

			$call = $this->©string->is_not_empty_or($action['c'], '');
			$type = $this->©string->is_not_empty_or($action['t'], '');

			if($this->©string->is_not_empty($action['a']))
				$action['a'] = json_decode($action['a'], TRUE);
			$args = $this->©array->is_not_empty_or($action['a'], array());

			ksort($args, SORT_NUMERIC); // Make sure arguments are ordered by key.
			if(isset($args['___file_info'])) // `___file_info` into last position always.
			{
				$___file_info = $args['___file_info'];
				unset($args['___file_info']);
				$args[] = $___file_info;
			}
			$verifier = $this->©string->is_not_empty_or($action['v'], '');

			if($this->©strings->are_not_empty($call, $type, $verifier))
				if($this->verify_call($call, $type, $verifier))
				{
					$this->©headers->clean_status_type(200, 'text/plain', TRUE);
					$this->__call($call, $args);
					exit(); // Stop here.
				}
			throw $this->©exception(
				$this->method(__FUNCTION__).'#invalid_or_expired_ajax_action_verifier', get_defined_vars(),
				$this->__('Invalid or expired `ajax` action verifier. Unable to process.').
				' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($action))
			);
		}

		/**
		 * Generates a link/URL that performs a dynamic `©class.®method` action call.
		 *
		 * @param string  $call A dynamic `©class.®method` action call that we need to make.
		 *
		 * @param string  $type Call type. One of these class constants (e.g. types):
		 *
		 *    • Public — {@link fw_constants::public_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Public `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Public `call` actions do NOT include a timestamp; and they do NOT expire.
		 *
		 *    • Protected — {@link fw_constants::protected_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Protected `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Protected `call` actions can include a custom expiration time (expires after 7 days, by default).
		 *
		 *    • Private — {@link fw_constants::private_type}
		 *    This type always requires a logged-in user matching the `$verifier`.
		 *    Private `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Private `call` actions can include a custom expiration time (expires after 24 hours, by default).
		 *
		 * @param array   $args Optional. An array of arguments we're passing to `$call`.
		 *
		 * @param integer $expires_after Optional. Time (in seconds) the underlying call verifier should last for.
		 *
		 *    Some additional notes regarding the `$expires_after` parameter:
		 *
		 *       • Public — {@link fw_constants::public_type}
		 *       Public `call` actions do NOT expire (ever). The string verifier will not even include an expiration time.
		 *       Therefore, this argument is ignored when `$type` is {@link fw_constants::public_type}.
		 *
		 *       • Protected — {@link fw_constants::protected_type}
		 *       For protected `call` actions, this will default to `604800` (7 days).
		 *
		 *       • Private — {@link fw_constants::private_type}
		 *       For private `call` actions, this will default to `86400` (24 hours).
		 *
		 * @param string  $base Optional. Defaults to WordPress® home URL. A base URL to use instead of the default value.
		 *
		 * @param boolean $use_action_key Optional. Defaults to a TRUE value. Links are compressed w/ the use of an action key.
		 *    If this is FALSE, we'll embed the action array into the link itself. However, this can produce MUCH longer/uglier links.
		 *    If this is FALSE, the `$action_key_expires_after` parameter is ignored completely (e.g. irrelevant).
		 *
		 * @param integer $action_key_expires_after Optional. The time (in seconds) a link w/ an action key should last for.
		 *    Defaults to the computed `$expires_after` value. Set this to override the default value. Set to `-1` for no link expiration time.
		 *    Note: it is usually NOT necessary to pass this value in, because it's synchronized with `$expires_after`.
		 *
		 * @return string Link/URL for a dynamic `©class.®method` action call (using an action key, or with array elements in the URL).
		 *
		 * @security-note Exposing this URL can lead to a security issue.
		 *    NEVER call upon this method without first checking permissions/capabilities.
		 *    A different capability might be required for any given action call.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` or `$type` are empty.
		 * @throws exception If `$call` is NOT a valid dynamic `©class.®method` action call.
		 * @throws exception If `$type` is NOT a valid type.
		 */
		public function url_for_call($call, $type, $args = array(), $expires_after = 0, $base = '',
		                             $use_action_key = TRUE, $action_key_expires_after = 0)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', // Others optional :-)
			                       'array', 'integer', 'string', 'boolean', 'integer', func_get_args());

			if(!$this->is_dynamic_call($call))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_call', get_defined_vars(),
					sprintf($this->__('Invalid dynamic `$call` action: `%1$s`.'), $call)
				);
			switch($type) // Action key expiration time (based on type).
			{
				case $this::public_type: // Does NOT expire.

					if($action_key_expires_after === 0)
						$action_key_expires_after = -1;

					break; // Break switch handler.

				case $this::protected_type: // In 7 days.

					if($action_key_expires_after === 0)
						if($expires_after > 0) // Automatically.
							$action_key_expires_after = $expires_after;
						else $action_key_expires_after = 604800;

					break; // Break switch handler.

				case $this::private_type: // In 24 hours.

					if($action_key_expires_after === 0)
						if($expires_after > 0) // Automatically.
							$action_key_expires_after = $expires_after;
						else $action_key_expires_after = 86400;

					break; // Break switch handler.
			}
			if(!$base) $base = $this->©url->to_wp_home_uri();

			$query_args['a']['s'] = 'call'; // This IS a `call`.
			$query_args['a']['c'] = $call; // Dynamic `©class.®method`.
			$query_args['a']['t'] = $type; // Dynamic `call` action type.
			$query_args['a']['v'] = $this->get_call_verifier($call, $type, $expires_after);

			if(!empty($args)) $query_args['a']['a'] = array_values($args);

			if($use_action_key) // Compressing this URL w/ the use of an action key?
			{
				$action_key = str_replace(array('©', '®'), '', $call).'.key.'.md5(serialize($query_args['a']));
				$this->©db_utils->set_transient($action_key, $query_args['a'], $action_key_expires_after);
				$query_args = array($this->instance->plugin_var_ns.'_action' => $action_key);
			}
			else $query_args = array($this->instance->plugin_var_ns => $query_args);

			return add_query_arg(urlencode_deep($query_args), $base);
		}

		/**
		 * Hidden input fields that verify a dynamic `©class.®method` `call` action.
		 *
		 * @param string  $call A dynamic `©class.®method` action call that we need to make.
		 *
		 * @param string  $type Call type. One of these class constants (e.g. types):
		 *
		 *    • Public — {@link fw_constants::public_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Public `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Public `call` actions do NOT include a timestamp; and they do NOT expire.
		 *
		 *    • Protected — {@link fw_constants::protected_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Protected `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Protected `call` actions can include a custom expiration time (expires after 7 days, by default).
		 *
		 *    • Private — {@link fw_constants::private_type}
		 *    This type always requires a logged-in user matching the `$verifier`.
		 *    Private `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Private `call` actions can include a custom expiration time (expires after 24 hours, by default).
		 *
		 * @param integer $expires_after Optional. Time (in seconds) the underlying call verifier should last for.
		 *
		 *    Some additional notes regarding the `$expires_after` parameter:
		 *
		 *       • Public — {@link fw_constants::public_type}
		 *       Public `call` actions do NOT expire (ever). The string verifier will not even include an expiration time.
		 *       Therefore, this argument is ignored when `$type` is {@link fw_constants::public_type}.
		 *
		 *       • Protected — {@link fw_constants::protected_type}
		 *       For protected `call` actions, this will default to `604800` (7 days).
		 *
		 *       • Private — {@link fw_constants::private_type}
		 *       For private `call` actions, this will default to `86400` (24 hours).
		 *
		 * @return string Hidden input fields that verify a dynamic `©class.®method` action call.
		 *
		 * @security-note Exposing these hidden fields can lead to a security issue.
		 *    NEVER call upon this method without first checking permissions/capabilities.
		 *    A different capability might be required for any given action call.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` or `$type` are empty.
		 * @throws exception If `$call` is NOT a valid dynamic `©class.®method` action call.
		 * @throws exception If `$type` is NOT a valid type.
		 */
		public function hidden_inputs_for_call($call, $type, $expires_after = 0)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer', func_get_args());

			if(!$this->is_dynamic_call($call))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_call', get_defined_vars(),
					sprintf($this->__('Invalid dynamic `$call` action: `%1$s`.'), $call)
				);
			$hidden_inputs = '<input type="hidden" name="'.esc_attr($this->instance->plugin_var_ns.'[a][s]').'" value="call" />';
			$hidden_inputs .= '<input type="hidden" name="'.esc_attr($this->instance->plugin_var_ns.'[a][c]').'" value="'.esc_attr($call).'" />';
			$hidden_inputs .= '<input type="hidden" name="'.esc_attr($this->instance->plugin_var_ns.'[a][t]').'" value="'.esc_attr($type).'" />';
			$hidden_inputs .= '<input type="hidden" name="'.esc_attr($this->instance->plugin_var_ns.'[a][v]').'" value="'.esc_attr($this->get_call_verifier($call, $type, $expires_after)).'" />';

			return $hidden_inputs; // A hidden input fields.
		}

		/**
		 * Generates an input field name for `call` action arguments.
		 *
		 * @param integer $position The argument position number. Starting with `1`.
		 *
		 * @return string Input field name for a call argument value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$position` is empty.
		 */
		public function input_name_for_call_arg($position)
		{
			$this->check_arg_types('integer:!empty', func_get_args());

			return $this->instance->plugin_var_ns.'[a][a]['.($position - 1).']';
		}

		/**
		 * Verifies a `call` action type.
		 *
		 * @param string $call A dynamic `©class.®method` action call that we're attempting to make.
		 *
		 * @param string $type Call type. One of these class constants (e.g. types):
		 *
		 *    • Public — {@link fw_constants::public_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Public `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Public `call` actions do NOT include a timestamp; and they do NOT expire.
		 *
		 *    • Protected — {@link fw_constants::protected_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Protected `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Protected `call` actions can include a custom expiration time (expires after 7 days, by default).
		 *
		 *    • Private — {@link fw_constants::private_type}
		 *    This type always requires a logged-in user matching the `$verifier`.
		 *    Private `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Private `call` actions can include a custom expiration time (expires after 24 hours, by default).
		 *
		 * @param string $verifier A string verifier, as produced internally by `$this->get_call_verifier()`.
		 *
		 * @return boolean TRUE if the call is verified, else FALSE by default (i.e. unable to verify).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function verify_call($call, $type, $verifier)
		{
			$this->check_arg_types('string', 'string', 'string', func_get_args());

			if(!$call || !$type || !$verifier || !$this->is_dynamic_call($call)
			   || !in_array($type, array($this::public_type, $this::protected_type, $this::private_type), TRUE)
			) return FALSE; // Something missing, or NOT a dynamic `call` action, or it's NOT a valid type.

			switch($type) // Handles verification (based on `call` action type).
			{
				case $this::public_type: // No `$expiration_time-`. Does NOT expire.

					if($verifier === $this->get_call_verifier($call, $type))
						return TRUE; // Simple enough (this looks OK).

					break; // Break (unable to verify).

				case $this::protected_type: // Requires an `$expiration_time-`.

					if(($expiration_time = (integer)strstr($verifier, '-', TRUE)))
						if($verifier === $this->get_call_verifier($call, $type, 0, $expiration_time))
							if($expiration_time > time()) // Check the expiration time now.
								return TRUE; // Still valid (based on current time).

					break; // Break (unable to verify).

				case $this::private_type: // Requires user & an `$expiration_time-`.

					if($this->©user->is_logged_in()) // Requires a logged-in user w/ an ID.
						// Verifier includes a user ID (it MUST match up with the current user).

						if(($expiration_time = (integer)strstr($verifier, '-', TRUE)))
							if($verifier === $this->get_call_verifier($call, $type, 0, $expiration_time))
								if($expiration_time > time()) // Check the expiration time now.
									return TRUE; // Still valid (based on current time).

					break; // Break (unable to verify).
			}
			return FALSE; // Default return value (unable to verify).
		}

		/**
		 * Checks a dynamic `©class.®method` action call string.
		 *
		 * @param string $call A dynamic `©class.®method` action call string.
		 *
		 * @return boolean TRUE if it's valid, else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function is_dynamic_call($call)
		{
			$this->check_arg_types('string', func_get_args());

			if(substr_count($call, '.') === 1) // A single `.` separator?
			{
				list($class, $method) = explode('.', $call, 2);

				if(substr_count($class, '©') === 1 && $this->©string->is_userland_name(trim($class, '©'))
				   && substr_count($method, '®') === 1 && $this->©string->is_userland_name(trim($method, '®'))
				) return TRUE; // It's fine.
			}
			return FALSE; // Default return value.
		}

		/**
		 * Generates a `call` action verifier.
		 *
		 * @param string  $call A dynamic `©class.®method` action call that we need to make.
		 *
		 * @param string  $type Call type. One of these class constants (e.g. types):
		 *
		 *    • Public — {@link fw_constants::public_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Public `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Public `call` actions do NOT include a timestamp; and they do NOT expire.
		 *
		 *    • Protected — {@link fw_constants::protected_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Protected `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Protected `call` actions can include a custom expiration time (expires after 7 days, by default).
		 *
		 *    • Private — {@link fw_constants::private_type}
		 *    This type always requires a logged-in user matching the `$verifier`.
		 *    Private `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Private `call` actions can include a custom expiration time (expires after 24 hours, by default).
		 *
		 * @param integer $expires_after Optional. Time (in seconds) the underlying call verifier should last for.
		 *
		 *    Some additional notes regarding the `$expires_after` parameter:
		 *
		 *       • Public — {@link fw_constants::public_type}
		 *       Public `call` actions do NOT expire (ever). The string verifier will not even include an expiration time.
		 *       Therefore, this argument is ignored when `$type` is {@link fw_constants::public_type}.
		 *
		 *       • Protected — {@link fw_constants::protected_type}
		 *       For protected `call` actions, this will default to `604800` (7 days).
		 *
		 *       • Private — {@link fw_constants::private_type}
		 *       For private `call` actions, this will default to `86400` (24 hours).
		 *
		 * @param integer $expiration_time A UNIX timestamp, indicating the time at which this call verifier will automatically expire.
		 *    This argument can be passed in explicitly, in order to generate a string verifier matching an original `$expiration_time` value.
		 *    Passing an original `$expiration_time`, makes it possible to generate a verifier which should match up (else `$this->verify_call()` MUST fail).
		 *    If `$expiration_time` is passed in, `$expires_after` is ignored completely, in favor of `$expiration_time`.
		 *
		 * @return string A signed verification string (URL-safe).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` or `$type` are empty.
		 * @throws exception If `$call` is NOT a valid dynamic `©class.®method` action call.
		 * @throws exception If `$type` is invalid.
		 */
		public function get_call_verifier($call, $type, $expires_after = 0, $expiration_time = 0)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer', 'integer', func_get_args());

			if(!$this->is_dynamic_call($call))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_call', get_defined_vars(),
					sprintf($this->__('Invalid dynamic `$call` action: `%1$s`.'), $call)
				);
			switch($type) // Generates verifier (based on `call` action type).
			{
				case $this::public_type: // Does NOT include `$expiration_time-`. Does NOT expire.
					return $this->©encryption->hmac_sha1_sign($call.$type);

				case $this::protected_type: // Requires an `$expiration_time-`.

					$this->©no_cache->constants($this::reason_dynamic); // Caching NOT allowed in this case.

					if($expires_after > 0 && $expiration_time <= 0) // Can we use `$expires_after`?
						// If `$expires_after`, and there's NO explicit `$expiration_time`.
						$expiration_time = time() + $expires_after;

					$expiration_time = ($expiration_time <= 0) ? strtotime('+7 days') : $expiration_time;

					return $expiration_time.'-'.$this->©encryption->hmac_sha1_sign($call.$type.$expiration_time);

				case $this::private_type: // Requires a logged-in user, and an `$expiration_time-`.

					$this->©no_cache->constants($this::reason_dynamic); // Caching NOT allowed in this case.

					if($expires_after > 0 && $expiration_time <= 0) // Can we use `$expires_after`?
						// If `$expires_after`, and there's NO explicit `$expiration_time`.
						$expiration_time = time() + $expires_after;

					$expiration_time = ($expiration_time <= 0) ? strtotime('+24 hours') : $expiration_time;

					return $expiration_time.'-'.$this->©encryption->hmac_sha1_sign($call.$type.$this->©user->ID.$expiration_time);
			}
			throw $this->©exception( // Should NOT happen!
				$this->method(__FUNCTION__).'#invalid_type', get_defined_vars(),
				$this->__('Invalid `$type`. Expecting `$this::public_type|$this::protected_type|$this::private_type`.').
				' '.sprintf($this->__('Got: `%1$s`.'), $type)
			);
		}

		/**
		 * Property:value that verifies an AJAX `call` action.
		 *
		 * @param string  $call A dynamic `©class.®method` action call that we need to make.
		 *
		 * @param string  $type Call type. One of these class constants (e.g. types):
		 *
		 *    • Public — {@link fw_constants::public_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Public `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Public `call` actions do NOT include a timestamp; and they do NOT expire.
		 *
		 *    • Protected — {@link fw_constants::protected_type}
		 *    This type of call is less secure. It does NOT require a logged-in user.
		 *    Protected `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Protected `call` actions can include a custom expiration time (expires after 7 days, by default).
		 *
		 *    • Private — {@link fw_constants::private_type}
		 *    This type always requires a logged-in user matching the `$verifier`.
		 *    Private `call` actions MUST be registered by class methods containing a `®` in their name.
		 *    Private `call` actions can include a custom expiration time (expires after 24 hours, by default).
		 *
		 * @param integer $expires_after Optional. Time (in seconds) the underlying call verifier should last for.
		 *
		 *    Some additional notes regarding the `$expires_after` parameter:
		 *
		 *       • Public — {@link fw_constants::public_type}
		 *       Public `call` actions do NOT expire (ever). The string verifier will not even include an expiration time.
		 *       Therefore, this argument is ignored when `$type` is {@link fw_constants::public_type}.
		 *
		 *       • Protected — {@link fw_constants::protected_type}
		 *       For protected `call` actions, this will default to `604800` (7 days).
		 *
		 *       • Private — {@link fw_constants::private_type}
		 *       For private `call` actions, this will default to `86400` (24 hours).
		 *
		 * @return string A caller object property for AJAX, which verifies a dynamic `©class.®method` action call, made via AJAX integration.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` or `$type` are empty.
		 * @throws exception If `$call` is NOT a valid dynamic `©class.®method` action call.
		 */
		public function ajax_verifier_property_for_call($call, $type, $expires_after = 0)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer', func_get_args());

			if(!$this->is_dynamic_call($call))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_call', get_defined_vars(),
					sprintf($this->__('Invalid dynamic `$call` action: `%1$s`.'), $call)
				);
			return "'".$this->©string->esc_js_sq($type.'::'.$call)."':".
			       "'".$this->©string->esc_js_sq($this->get_call_verifier($call, $type, $expires_after))."'";
		}

		/**
		 * Sets data for a `call` action (placing it into a `call` action group).
		 *
		 * @param string       $call A dynamic `©class.®method` action call that we're setting data for.
		 *
		 * @param array|object $data An array (or object) containing custom data, specifically for this `call` action.
		 *    Or (if there is no data) an errors/successes/messages object instance can be passed directly through this argument value.
		 *
		 *    • Incoming `$data` will always be objectified by one dimension (e.g. we force object properties).
		 *
		 *    • If we have data AND `errors|successes|messages`, the data (along with `errors|successes|messages`)
		 *       can be passed into this method by adding the object instance(s) for `errors|successes|messages` to `$data`,
		 *       with array keys (or object property names) matching `errors`, `successes`, `messages` (when/if applicable).
		 *
		 *    • If a user object instance is passed through `$data` w/ the array key (or property name) `user`;
		 *       the `user` value is parsed with `$this->©user_utils->which()`; allowing variations supported by this utility.
		 *
		 * @param string       $group Optional. A `call` action group (defaults to same value as `$call`).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 * @throws exception If `$call` is NOT a valid dynamic `©class.®method` action call.
		 */
		public function set_call_data_for($call, $data, $group = '')
		{
			$this->check_arg_types('string:!empty', array('array', 'object'), 'string', func_get_args());

			$structured_data = $this->parse_call_data($data); // Structured object.
			$group           = ($group) ? $group : $call; // Defaults to `$call` value.

			if(!$this->is_dynamic_call($call))
				throw $this->©exception($this->method(__FUNCTION__).'#invalid_call', get_defined_vars(),
				                        sprintf($this->__('Invalid dynamic `$call` action: `%1$s`.'), $call)
				);
			$this->call_data_for[$group][$call] = $structured_data;
		}

		/**
		 * Parses incoming data into a structured object instance.
		 *
		 * @param array|object $data Incoming `$data` array (or an object).
		 *
		 * @return object A structured data object instance.
		 */
		public function parse_call_data($data)
		{
			$this->check_arg_types(array('array', 'object'), func_get_args());

			$structured_data         = new \stdClass();
			$structured_data->errors = $structured_data->successes // Defaults.
				= $structured_data->messages = $structured_data->data = NULL;

			if($data && $this->©errors->instance_in($data))
			{
				$structured_data->errors = $data;
				$structured_data->data   = new \stdClass();

				return $structured_data; // Object properties.
			}
			if($data && $this->©successes->instance_in($data))
			{
				$structured_data->successes = $data;
				$structured_data->data      = new \stdClass();

				return $structured_data; // Object properties.
			}
			if($data && $this->©messages->instance_in($data))
			{
				$structured_data->messages = $data;
				$structured_data->data     = new \stdClass();

				return $structured_data; // Object properties.
			}
			$structured_data->data = (object)$data; // Array/object of another type.

			if(property_exists($structured_data->data, 'user'))
				$structured_data->data->user = $this->©user_utils->which($structured_data->data->user);

			if(isset($structured_data->data->errors) && $this->©errors->instance_in($structured_data->data->errors))
				$structured_data->errors = $structured_data->data->errors;

			if(isset($structured_data->data->successes) && $this->©successes->instance_in($structured_data->data->successes))
				$structured_data->successes = $structured_data->data->successes;

			if(isset($structured_data->data->messages) && $this->©messages->instance_in($structured_data->data->messages))
				$structured_data->messages = $structured_data->data->messages;

			return $structured_data; // Object properties.
		}

		/**
		 * Gets structured data objects for all `call` actions (in a specific group).
		 *
		 * @param string $group A call action group.
		 *
		 * @return array An associative array of all structured data objects for `call` actions in the `$group`, else an empty array.
		 *    Keys are dynamic `©class.®method` action calls. Data values are always structured object instances.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$group` is empty.
		 */
		public function get_call_data_structures_for_group($group)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!empty($this->call_data_for[$group]))
				return $this->call_data_for[$group];

			return array(); // Default return value.
		}

		/**
		 * Gets data object for a specific `call` action (in a specific group).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need data for.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return object|null Data object properties; else NULL if NO data is available.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function get_call_data_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if(isset($this->call_data_for[$group][$call]->data))
				return $this->call_data_for[$group][$call]->data;

			return NULL; // Default return value.
		}

		/**
		 * Checks data object for a specific `call` action (in a specific group).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need to check on.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return errors|boolean Errors if this `call` action has errors.
		 *    Otherwise, this returns a boolean FALSE value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function has_call_data_errors_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if(isset($this->call_data_for[$group][$call]->errors)
			   && $this->©errors->exist_in($this->call_data_for[$group][$call]->errors)
			) return $this->call_data_for[$group][$call]->errors;

			return FALSE; // Default return value.
		}

		/**
		 * Checks data object for a specific `call` action (in a specific group).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need to check on.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return successes|boolean Successes if this `call` action has successes.
		 *    Otherwise, this returns a boolean FALSE value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function has_call_data_successes_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if(isset($this->call_data_for[$group][$call]->successes)
			   && $this->©successes->exist_in($this->call_data_for[$group][$call]->successes)
			) return $this->call_data_for[$group][$call]->successes;

			return FALSE; // Default return value.
		}

		/**
		 * Checks data object for a specific `call` action (in a specific group).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need to check on.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return messages|boolean Messages if this `call` action has messages.
		 *    Otherwise, this returns a boolean FALSE value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function has_call_data_messages_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if(isset($this->call_data_for[$group][$call]->messages)
			   && $this->©messages->exist_in($this->call_data_for[$group][$call]->messages)
			) return $this->call_data_for[$group][$call]->messages;

			return FALSE; // Default return value.
		}

		/**
		 * Checks data object for a specific `call` action (in a specific group).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need to check on.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return boolean TRUE if this `call` action has responses.
		 *    Otherwise, this returns a FALSE value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function has_call_data_responses_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if($this->has_call_data_errors_for($call, $group)
			   || $this->has_call_data_successes_for($call, $group)
			   || $this->has_call_data_messages_for($call, $group)
			) return TRUE; // Yes.

			return FALSE; // Default return value.
		}

		/**
		 * Gets responses for a specific `call` action (in a specific group).
		 *
		 * @note This includes errors, successes, messages (when/if they exist).
		 *
		 * @param string $call A dynamic `©class.®method` action call that we need responses for.
		 * @param string $group Optional. A call action group (defaults to `$call`).
		 *
		 * @return string Responses (as HTML markup); else an empty string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$call` is empty.
		 */
		public function get_call_responses_for($call, $group = '')
		{
			$this->check_arg_types('string:!empty', 'string', func_get_args());

			$group = ($group) ? $group : $call; // Defaults to `$call` value.

			if(!$this->has_call_data_responses_for($call, $group)) return ''; // Nothing.

			$responses = ''; // Initialize responses (as HTML markup).

			if(($errors = $this->has_call_data_errors_for($call, $group)))
				$responses .= // Errors (as HTML markup). Also w/ a specific icon.
					'<div class="responses errors alert alert-danger em-padding">'.
					'<ul>'.$errors->get_messages_as_list_items('', 0, '<i class="fa fa-exclamation-triangle"></i> ').'</ul>'.
					'</div>';

			if(($successes = $this->has_call_data_successes_for($call, $group)))
				$responses .= // Successes (as HTML markup). Also w/ a specific icon.
					'<div class="responses successes alert alert-success em-padding">'.
					'<ul>'.$successes->get_messages_as_list_items('', 0, '<i class="fa fa-thumbs-o-up"></i> ').'</ul>'.
					'</div>';

			if(($messages = $this->has_call_data_messages_for($call, $group)))
				$responses .= // Messages (as HTML markup). Also w/ a specific icon.
					'<div class="responses messages alert alert-info em-padding">'.
					'<ul>'.$messages->get_messages_as_list_items('', 0, '<i class="fa fa-comments-o"></i> ').'</ul>'.
					'</div>';

			return $responses; // All types of responses (as HTML markup).
		}
	}
}