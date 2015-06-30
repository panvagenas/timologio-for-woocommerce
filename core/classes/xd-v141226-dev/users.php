<?php
/**
 * Users.
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
	 * Users.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__], 1)
	 */
	class users extends framework
	{
		/**
		 * @var array Constructor arguments.
		 * @by-constructor Set by class constructor.
		 */
		public $args = array();

		/**
		 * @var integer WordPress® ID.
		 * @by-constructor Set by class constructor.
		 */
		public $ID = 0; // No ID (default).

		/**
		 * @var \WP_User WordPress® object instance.
		 * @by-constructor Set by class constructor.
		 */
		public $wp; // Defaults to a NULL value.

		/**
		 * @var boolean Was this object constructed for NO user (explicitly)?
		 * @by-constructor Set by class constructor.
		 */
		public $is_no_user = FALSE;

		/**
		 * @var boolean Was this object constructed for the current default user?
		 * @by-constructor Set by class constructor.
		 */
		public $is_current_default = FALSE;

		/**
		 * @var string Current and/or last known IP address.
		 * @by-constructor Set by class constructor.
		 */
		public $ip = '';

		/**
		 * @var string WordPress® email address.
		 * @by-constructor Set by class constructor.
		 */
		public $email = '';

		/**
		 * @var string WordPress® username.
		 * @by-constructor Set by class constructor.
		 */
		public $username = '';

		/**
		 * @var string WordPress® nicename.
		 * @by-constructor Set by class constructor.
		 */
		public $nicename = '';

		/**
		 * @var string WordPress® encrypted password.
		 * @by-constructor Set by class constructor.
		 */
		public $password = '';

		/**
		 * @var string WordPress® first name.
		 * @by-constructor Set by class constructor.
		 */
		public $first_name = '';

		/**
		 * @var string WordPress® last name.
		 * @by-constructor Set by class constructor.
		 */
		public $last_name = '';

		/**
		 * @var string WordPress® full name.
		 * @by-constructor Set by class constructor.
		 */
		public $full_name = '';

		/**
		 * @var string WordPress® display name.
		 * @by-constructor Set by class constructor.
		 */
		public $display_name = '';

		/**
		 * @var string URL associated with this user.
		 * @by-constructor Set by class constructor.
		 */
		public $url = '';

		/**
		 * @var string AOL® Instant Messenger name for this user.
		 * @by-constructor Set by class constructor.
		 */
		public $aim = '';

		/**
		 * @var string Yahoo® Messenger name for this user.
		 * @by-constructor Set by class constructor.
		 */
		public $yim = '';

		/**
		 * @var string Jabber™ (or Google® Talk) name for this user.
		 * @by-constructor Set by class constructor.
		 */
		public $jabber = '';

		/**
		 * @var string Description (or bio details) for this user.
		 * @by-constructor Set by class constructor.
		 */
		public $description = '';

		/**
		 * @var integer WordPress® registration time.
		 * @by-constructor Set by class constructor.
		 */
		public $registration_time = 0;

		/**
		 * @var string WordPress® activation key.
		 * @by-constructor Set by class constructor.
		 */
		public $activation_key = '';

		/**
		 * @var integer WordPress® status.
		 * @by-constructor Set by class constructor.
		 */
		public $status = 0;

		/**
		 * @var array Any custom data vars.
		 * @by-constructor Set by class constructor.
		 */
		public $data = array();

		/**
		 * User object constructor. Please read carefully.
		 *
		 * @param object|array              $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param null|integer              $user_id Defaults to NULL. A specific user?
		 *    If this and `$by`, `$value` are all NULL, we construct an instance for the current user.
		 *
		 * @param null|string               $by Search for a user, by a particular type of value?
		 *    For further details, please see {@link user_utils::get_id_by()}.
		 *
		 * @param null|string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
		 *    For further details, please see {@link user_utils::get_id_by()}.
		 *
		 * @param array                     $default_properties Optional. Defaults to an empty array.
		 *    Passed to {@link populate()} to establish some default properties before population attempts take place.
		 *    This can be useful if reconstructing an object for a user that does NOT have an ID (as one example).
		 *    See also {@link $data}. It IS possible to define custom {@link $data} keys w/ this parameter.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$default_properties` contains invalid data types.
		 * @throws exception If `$default_properties` contains undefined property keys.
		 */
		public function __construct($instance, $user_id = NULL, $by = NULL, $value = NULL, $default_properties = array())
		{
			parent::__construct($instance); // Parent constructor.

			$this->check_arg_types('', array('null', 'integer'), array('null', 'string:!empty'),
			                       array('null', 'string:!empty', 'integer:!empty', 'array:!empty'),
			                       'array', func_get_args());

			if(!did_action('set_current_user'))
				throw $this->©exception( // Should NOT happen.
					$this->method(__FUNCTION__).'#set_current_user', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('Doing it wrong (the `set_current_user` hook has NOT been fired yet).')
				);
			if($user_id && $user_id < 0) $by = $value = NULL; // Nullify.
			$this->args = array('user_id'            => $user_id, 'by' => $by, 'value' => $value,
			                    'default_properties' => $default_properties);

			if(!isset($user_id) && !isset($by) && !isset($value)) // Current user?
			{
				if(($_wp = wp_get_current_user()) && !empty($_wp->ID))
				{
					$this->wp = $_wp;
					$this->ID = $_wp->ID;
				}
				$this->is_current_default = TRUE;
			}
			else if($user_id && $user_id < 0) // NO user (explicitly)?
			{
				$this->ID         = 0;
				$this->wp         = NULL;
				$this->is_no_user = TRUE;
			}
			else if($user_id // A specific user ID?
			        && ($_wp = new \WP_User($user_id))
			        && !empty($_wp->ID)
			) // Instance for a specific user.
			{
				$this->wp = $_wp;
				$this->ID = $_wp->ID;
			}
			else if($by && $value // Search by ID value?
			        && strtolower($by) === 'id' && is_numeric($value)
			        && ($_wp = new \WP_User((integer)$value))
			        && !empty($_wp->ID)
			) // Instance for a specific user.
			{
				$this->wp = $_wp;
				$this->ID = $_wp->ID;
			}
			else if($by && $value // Search by any other value?
			        && ($_id_by = $this->©user_utils->get_id_by($by, $value))
			        && ($_wp = new \WP_User($_id_by))
			        && !empty($_wp->ID)
			) // Instance for a specific user.
			{
				$this->wp = $_wp;
				$this->ID = $_wp->ID;
			}
			// Else by default this instance has no ID (all default properties).
			// This is NOT the same as having NO user (explicitly) via `-1`; which identifies this instance
			// as having been purposely instantiated for such a purpose (e.g. to indicate NO user explicitly).

			if($this->ID && (!$this->wp || !$this->wp->user_email || !$this->wp->user_login || !$this->wp->user_nicename))
			{
				$this->©error($this->method(__FUNCTION__), array_merge(get_defined_vars(), array('user' => $this)), // For diagnostics.
				              sprintf($this->__('User ID: `%1$s` is missing vital components.'), $this->ID).
				              ' '.$this->__('Possible database corruption.'));
				$this->wp = NULL;
				$this->ID = 0;
			}
			unset($_wp, $_id_by); // Housekeeping.

			$this->populate(); // Populate (if possible).
		}

		/**
		 * Handles wake-up (after being unserialized).
		 *
		 * @see http://www.php.net/manual/en/language.oop5.magic.php#object.wakeup
		 */
		public function __wakeup()
		{
			$this->refresh(); // Refresh object instance.
		}

		/**
		 * Starts a session for this user (if they are the current user).
		 *
		 * @extenders Can be overridden by class extenders (when/if necessary).
		 *
		 * @return null Nothing. Simply starts a session for this user (if they are the current user).
		 */
		public function session_start()
		{
			// Core does NOT use sessions.
		}

		/**
		 * Ends a session for this user (if they are the current user).
		 *
		 * @extenders Can be overridden by class extenders (when/if necessary).
		 *
		 * @return null Nothing. Simply ends a session for this user (if they are the current user).
		 */
		public function session_end()
		{
			// Core does NOT use sessions.
		}

		/**
		 * Populates user object properties.
		 *
		 * @extenders Can be overridden by class extenders.
		 * @note Class extenders may wish to populate with `$this->args['by']`, `$this->args['value']` in some cases.
		 *    The core does NOT handle this on its own however (an extender is required).
		 *
		 * @param array $default_properties Optional. Any default and/or custom properties.
		 *    If empty, this defaults to {@link $args} value for `default_properties`.
		 *
		 * @return null Nothing. Simply populates user object properties.
		 */
		public function populate($default_properties = array())
		{
			$this->check_arg_types('array', func_get_args());

			if(!$default_properties) // Default defaults :-)
				$default_properties = $this->args['default_properties'];
			unset($default_properties['args'], $default_properties['ID'], $default_properties['wp']);
			unset($default_properties['is_no_user'], $default_properties['is_current_default']);
			$this->set_properties($default_properties); // Set any default properties.

			// Get IP (we try this even for current users w/o an ID).

			if($this->is_current())
			{
				$this->ip = $this->©env->ip();
				if($this->has_id() && $this->ip && $this->ip !== $this->get_meta('ip'))
					$this->update_meta('ip', $this->ip);
			}
			else if($this->has_id()) $this->ip = (string)$this->get_meta('ip');

			// Standardize these additional properties (for users w/ an ID).

			if($this->has_id()) // Has a user ID?
			{
				$this->email             = $this->wp->user_email;
				$this->username          = $this->wp->user_login;
				$this->nicename          = $this->wp->user_nicename;
				$this->password          = $this->wp->user_pass;
				$this->first_name        = $this->wp->first_name;
				$this->last_name         = $this->wp->last_name;
				$this->full_name         = trim($this->wp->first_name.' '.$this->wp->last_name);
				$this->display_name      = $this->wp->display_name;
				$this->url               = $this->wp->user_url;
				$this->aim               = $this->wp->aim;
				$this->yim               = $this->wp->yim;
				$this->jabber            = $this->wp->jabber;
				$this->description       = $this->wp->description;
				$this->registration_time = strtotime($this->wp->user_registered);
				$this->activation_key    = $this->wp->user_activation_key;
				$this->status            = (integer)$this->wp->user_status;
			}
			else // Else, there is nothing more we can populate in this case.
			{
				// Class extenders may wish to populate with `$this->args['by']`, `$this->args['value']`.
				// The core does NOT handle this on its own however (an extender is required).
			}
		}

		/**
		 * Does this user have an ID?
		 *
		 * @return boolean TRUE if this user has an ID.
		 *
		 * @note Any user with an ID, will by definition,
		 *    also have these non-empty properties:
		 *
		 *    • `wp`
		 *    • `email`
		 *    • `username`
		 *    • `nicename`
		 */
		public function has_id()
		{
			return ($this->ID) ? TRUE : FALSE;
		}

		/**
		 * Does this user have an email address?
		 *
		 * @return boolean TRUE if this user has an email address.
		 *
		 * @note This is really just for internal standards. It's called upon by `is_populated()`.
		 *
		 * @note Any user with an ID, will by definition,
		 *    also have these non-empty properties:
		 *
		 *    • `wp`
		 *    • `email`
		 *    • `username`
		 *    • `nicename`
		 */
		public function has_email()
		{
			return ($this->email) ? TRUE : FALSE;
		}

		/**
		 * Is this user populated?
		 *
		 * @return boolean TRUE if this user has an ID and/or an email address.
		 */
		public function is_populated()
		{
			return ($this->has_id() || $this->has_email()) ? TRUE : FALSE;
		}

		/**
		 * Is this user currently logged into the site?
		 *
		 * @return boolean TRUE if this user is currently logged in.
		 */
		public function is_logged_in()
		{
			return ($this->has_id() && get_current_user_id() === $this->ID);
		}

		/**
		 * Is this NO user (explicitly)?
		 *
		 * @return boolean TRUE if this is NO user (explicitly).
		 */
		public function is_no_user()
		{
			return ($this->is_no_user) ? TRUE : FALSE;
		}

		/**
		 * Is this the current default user?
		 *
		 * @return boolean TRUE if this is the current default user.
		 */
		public function is_current_default()
		{
			return ($this->is_current_default) ? TRUE : FALSE;
		}

		/**
		 * Is this the current user?
		 *
		 * @return boolean TRUE if this is the current user.
		 */
		public function is_current()
		{
			return ($this->is_current_default() || $this->is_logged_in()) ? TRUE : FALSE;
		}

		/**
		 * Instantiated with `$this->args['by']`, `$this->args['value']`?
		 *
		 * @return boolean TRUE if this was instantiated with `$this->args['by']`, `$this->args['value']`.
		 */
		public function has_args_by_value()
		{
			return ($this->args['by'] && $this->args['value']) ? TRUE : FALSE;
		}

		/**
		 * Is this a super administrator?
		 *
		 * @return boolean TRUE if this is a super administrator.
		 */
		public function is_super_admin()
		{
			if($this->has_id())
				return is_super_admin($this->ID);
			return FALSE;
		}

		/**
		 * Refreshes this object instance.
		 *
		 * @param null|string|array $components Optional. Defaults to a NULL value.
		 *    By default, with a NULL value, we simply refresh the entire object instance.
		 *    If this is a string (or an array), we only refresh specific components.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If an array contains invalid component keys/values (e.g. NOT strings).
		 */
		public function refresh($components = NULL)
		{
			$this->check_arg_types(array('null', 'string:!empty', 'array:!empty'), func_get_args());

			if(isset($components)) // Refresh specific components only?
				goto refresh_components; // See target point below.

			refresh: // Target point. Refresh entire user object instance.

			$this->wp    = NULL;
			$this->cache = array();

			$this->ip                = '';
			$this->email             = '';
			$this->username          = '';
			$this->nicename          = '';
			$this->password          = '';
			$this->first_name        = '';
			$this->last_name         = '';
			$this->full_name         = '';
			$this->display_name      = '';
			$this->url               = '';
			$this->aim               = '';
			$this->yim               = '';
			$this->jabber            = '';
			$this->description       = '';
			$this->registration_time = 0;
			$this->activation_key    = '';
			$this->status            = 0;
			$this->data              = array();

			if($this->has_id()) // User exists?
			{
				clean_user_cache($this->ID);
				wp_cache_delete($this->ID, 'user_meta');

				if(($_wp = new \WP_User($this->ID)) && !empty($_wp->ID))
					$this->wp = $_wp;

				unset($_wp); // Housekeeping.
			}
			$this->populate(); // Repopulate.

			// Restart session (if possible).
			if($this->is_current() && !headers_sent())
				$this->session_start();

			return; // Stop here. We are NOT refreshing specific components in this case.

			refresh_components: // Target point. Refresh specific components only.

			foreach((array)$components as $_component_or_key => $_component_or_value)
				switch(gettype($_component_or_key)) // String or integer array key.
				{
					case 'integer': // Numeric key (value is cache component).

						if(!$this->©string->is_not_empty($_component_or_value))
							throw $this->©exception($this->method(__FUNCTION__).'#invalid_component_or_value', array_merge(get_defined_vars(), array('user' => $this)),
							                        $this->__('Invalid component. Expecting string NOT empty.').
							                        ' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_component_or_value))
							);
						unset($this->cache[$_component_or_value], $this->data[$_component_or_value]); // Refresh (if exists).

						break; // Break switch handler.

					case 'string': // Associative component/property key.
						// The `$_component_or_value` is a newly refreshed property value.
						// The new value MUST have a data type matching the existing value data type.

						if(!$this->©string->is_not_empty($_component_or_key))
							throw $this->©exception($this->method(__FUNCTION__).'#invalid_component_or_key', array_merge(get_defined_vars(), array('user' => $this)),
							                        $this->__('Invalid component. Expecting string NOT empty.').
							                        ' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_component_or_key))
							);
						if(property_exists($this, $_component_or_key))
						{
							if(gettype($this->$_component_or_key) !== gettype($_component_or_value))
								throw $this->©exception($this->method(__FUNCTION__).'#invalid_component_or_value_type', array_merge(get_defined_vars(), array('user' => $this)),
								                        sprintf($this->__('Invalid component value type. Expecting: `%1$s`.'), gettype($this->$_component_or_key)).
								                        ' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_component_or_value)));

							$this->$_component_or_key = $_component_or_value; // Refresh property value.
						}
						unset($this->cache[$_component_or_key], $this->data[$_component_or_key]); // Refresh (if exists).

						break; // Break switch handler.
				}
			unset($_component_or_key, $_component_or_value); // Housekeeping.

			$this->populate(); // Repopulate.

			// Restart session (if possible).
			if($this->is_current() && !headers_sent())
				$this->session_start();

			return; // Stop here. For uniformity in this case handler.
		}

		/**
		 * Logs this user out of their account access (if they are the current user).
		 *
		 * @throws exception If headers have already been sent before calling this routine.
		 */
		public function logout()
		{
			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('Doing it wrong! Headers have already been sent.')
				);
			if($this->is_current()) $this->session_end();
			if($this->is_current() && $this->has_id()) wp_logout();

			$this->do_action('logout', $this, get_defined_vars());
		}

		/**
		 * Deletes this user.
		 *
		 * @note In the case of a multisite network installation of WordPress®,
		 *    this will simply remove the user from the current blog (e.g. they're NOT actually deleted).
		 *
		 * @param null|integer $reassign_posts_to_user_id Optional. A user ID to which any posts will be reassigned.
		 *    If this is NULL (which it is by default), all posts will simply be deleted, along with the user.
		 *
		 * @return boolean|errors TRUE if the user is deleted, else an errors object on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID (e.g. we CANNOT delete them).
		 */
		public function delete($reassign_posts_to_user_id = NULL)
		{
			$this->check_arg_types(array('null', 'integer:!empty'), func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot delete).')
				);
			if($this->is_super_admin())
				return $this->©error(
					$this->method(__FUNCTION__).'#super_admin', array_merge(get_defined_vars(), array('user' => $this)),
					sprintf($this->__('Cannot delete super administrator: `%1$s`.'), $this->username)
				);
			if(!wp_delete_user($this->ID, $reassign_posts_to_user_id))
				return $this->©error(
					$this->method(__FUNCTION__).'#failure', array_merge(get_defined_vars(), array('user' => $this)),
					sprintf($this->__('Failed to delete user ID: `%1$s`.'), $this->ID)
				);
			$this->do_action('delete', $this, array_merge(get_defined_vars(), array('user' => $this)));

			$ID       = $this->ID; // Save for use below.
			$this->ID = 0; // Delete this ID now (force empty ID).

			$this->wp    = NULL;
			$this->cache = array();

			$this->ip                = '';
			$this->email             = '';
			$this->username          = '';
			$this->nicename          = '';
			$this->password          = '';
			$this->first_name        = '';
			$this->last_name         = '';
			$this->full_name         = '';
			$this->display_name      = '';
			$this->url               = '';
			$this->aim               = '';
			$this->yim               = '';
			$this->jabber            = '';
			$this->description       = '';
			$this->registration_time = 0;
			$this->activation_key    = '';
			$this->status            = 0;
			$this->data              = array();

			clean_user_cache($ID);
			wp_cache_delete($ID, 'user_meta');

			return TRUE; // Default return value.
		}

		/**
		 * Updates this user.
		 *
		 * @param         $args array Array of arguments.
		 *
		 *  • (string)`ip` Optional. IP address for this user.
		 *
		 *  • (string)`email` Optional. A valid email address for this user.
		 *
		 *  • (string)`password` Optional. A plain text password (only if changing).
		 *
		 *  • (string)`first_name` Optional. User's first name (self explanatory).
		 *  • (string)`last_name` Optional. User's last name (self explanatory).
		 *  • (string)`display_name` Optional. User's display name (self explanatory).
		 *
		 *  • (string)`url` Optional. A URL associated with this user (e.g. their website URL).
		 *  • (string)`aim` Optional. AOL (AIM) screen name (for contact via instant messenger).
		 *  • (string)`yim` Optional. Yahoo Messenger ID (for contact via instant messenger chat).
		 *  • (string)`jabber` Optional. Google Talk Username (for contact via instant messenger chat).
		 *
		 *  • (string)`description` Optional. About the user (i.e. biographical information).
		 *
		 *  • (array)`options` Optional associative array. Any additional user option values.
		 *       These are stored via `update_user_option()` (e.g. blog-specific meta values).
		 *
		 *  • (array)`meta` Optional associative array. Any additional user meta values.
		 *       These are stored via `update_user_meta()` (e.g. site-wide meta values).
		 *
		 *  • (array)`data` Optional associative array. Any additional data you'd like to pass through `wp_update_user()`.
		 *       See: http://codex.wordpress.org/Function_Reference/wp_update_user
		 *       See: http://codex.wordpress.org/Function_Reference/wp_insert_user
		 *
		 *  • (array)`profile_fields` Optional associative array w/ additional profile fields (by code).
		 *       See {@link validate_profile_fields()} for further details (implemented by class extenders).
		 *
		 *  • (null|integer|\WP_User|users)`updater` The user (updater) that we MAY validate against here.
		 *       For instance, this MIGHT be used in some validations against profile field submissions.
		 *       This defaults to `-1`, NO user (e.g. the systematic update of a user).
		 *
		 * @param array   $optional_requirements An array of optional fields, which we've decided to require in this scenario.
		 *
		 * @return boolean|errors TRUE on success; else an errors object on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID (e.g. we CANNOT update them).
		 */
		public function update($args, $optional_requirements = array())
		{
			$this->check_arg_types('array', 'array', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update).')
				);
			// Formulate & validate incoming args.

			$default_args = array(
				'ip'             => NULL,
				'email'          => NULL,
				'role'           => NULL,
				'password'       => NULL,
				'first_name'     => NULL,
				'last_name'      => NULL,
				'display_name'   => NULL,
				'url'            => NULL,
				'aim'            => NULL,
				'yim'            => NULL,
				'jabber'         => NULL,
				'description'    => NULL,
				'activation_key' => NULL,
				'options'        => NULL,
				'meta'           => NULL,
				'data'           => NULL,
				'profile_fields' => NULL,
				'updater'        => -1
			);
			$args         = $this->check_extension_arg_types(
				'string', 'string', 'string', 'string', 'string', 'string', 'string',
				'string', 'string', 'string', 'string', 'string', 'string', 'array', 'array', 'array', 'array',
				$this->©user_utils->which_types(), $default_args, $args
			);
			$args         = $this->©array->remove_nulls_deep($args); // Remove NULL values (i.e. those we are NOT updating here).

			$old_user_data = (object)(array)$this; // Copy of all object properties (for hooks).

			// Build array of `data` for our call to `wp_update_user()` below.

			$data = array_merge(array( // For `wp_update_user()` below.
			                           'ID'           => $this->ID, // This user's ID.
			                           'role'         => ((isset($args['role'])) ? $args['role'] : NULL),
			                           'user_email'   => ((isset($args['email']) && strlen($args['email'])) ? (string)substr($args['email'], 0, 100) : NULL),
			                           'user_pass'    => ((isset($args['password']) && strlen($args['password'])) ? (string)substr($args['password'], 0, 100) : NULL),
			                           'first_name'   => ((isset($args['first_name'])) ? (string)substr($args['first_name'], 0, 100) : NULL),
			                           'last_name'    => ((isset($args['last_name'])) ? (string)substr($args['last_name'], 0, 100) : NULL),
			                           'display_name' => ((isset($args['display_name'])) ? (string)substr($args['display_name'], 0, 250) : NULL),
			                           'user_url'     => ((isset($args['url'])) ? (string)substr($args['url'], 0, 100) : NULL),
			                           'aim'          => ((isset($args['aim'])) ? (string)substr($args['aim'], 0, 100) : NULL),
			                           'yim'          => ((isset($args['yim'])) ? (string)substr($args['yim'], 0, 100) : NULL),
			                           'jabber'       => ((isset($args['jabber'])) ? (string)substr($args['jabber'], 0, 100) : NULL),
			                           'description'  => ((isset($args['description'])) ? (string)substr($args['description'], 0, 5000) : NULL),
			                    ), ((isset($args['data'])) ? $args['data'] : array()));

			$data = $this->©array->remove_nulls_deep($data); // Remove NULL values (i.e. those we are NOT updating here).

			// Validate a possible change of email address (only if it has length).

			if(isset($args['email'][0])) // If the email has length.
				if($this->©errors->exist_in($validate_email_change_of_address = $this->©user_utils->validate_email_change_of_address($args['email'], $this->email)))
					return $validate_email_change_of_address; // An errors object instance.

			// Validate a possible change of password (only if it has length).

			if(isset($args['password'][0])) // If the password has length.
				if($this->©errors->exist_in($validate_password = $this->©user_utils->validate_password($args['password'])))
					return $validate_password; // An errors object instance.

			// Validate a possible change of name; only if name(s) are required in this scenario.

			if(isset($args['first_name']) && !$args['first_name'] && in_array('first_name', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#first_name_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'first_name')),
					$this->_x('Required field. Missing first name.')
				);
			if(isset($args['last_name']) && !$args['last_name'] && in_array('last_name', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#last_name_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'last_name')),
					$this->_x('Required field. Missing last name.')
				);
			if(isset($args['display_name']) && !$args['display_name'] && in_array('display_name', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#display_name_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'display_name')),
					$this->_x('Required field. Missing display name.')
				);
			// Validate a possible change in online contact info (only if required in this scenario).

			if(isset($args['url']) && !$args['url'] && in_array('url', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#url_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'url')),
					$this->_x('Required field. Missing URL.')
				);
			if(isset($args['url']) && strlen($args['url']) && !preg_match($this->©url->regex_valid_url, $args['url']))
				return $this->©error(
					$this->method(__FUNCTION__).'#invalid_url', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'url')),
					$this->_x('Invalid URL. Must start with `http://` and be a valid URL please.')
				);
			if(isset($args['aim']) && !$args['aim'] && in_array('aim', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#aim_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'aim')),
					$this->_x('Required field. Missing AOL® screen name.')
				);
			if(isset($args['yim']) && !$args['yim'] && in_array('yim', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#yim_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'yim')),
					$this->_x('Required field. Missing Yahoo® ID.')
				);
			if(isset($args['jabber']) && !$args['jabber'] && in_array('jabber', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#jabber_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'jabber')),
					$this->_x('Required field. Missing Jabber™ (or Google® Talk) username.')
				);
			// Validate a possible change in personal bio (i.e. user description).

			if(isset($args['description']) && !$args['description'] && in_array('description', $optional_requirements, TRUE))
				return $this->©error(
					$this->method(__FUNCTION__).'#description_missing', array_merge(get_defined_vars(), array('user' => $this, 'form_field_code' => 'description')),
					$this->_x('Required field. Missing personal description.')
				);
			if(isset($args['ip'])) // Update IP address.
				$this->update_meta('ip', $args['ip']);

			if(isset($args['activation_key'])) // Update activation key.
				$this->update_activation_key($args['activation_key']);

			if(isset($args['options'])) // Update option values for this user.
			{
				foreach($args['options'] as $_key => $_value)
					if($this->©string->is_not_empty($_key)) $this->update_option($_key, $_value);
				unset($_key, $_value);
			}
			if(isset($args['meta'])) // Update meta values for this user.
			{
				foreach($args['meta'] as $_key => $_value)
					if($this->©string->is_not_empty($_key)) $this->update_meta($_key, $_value);
				unset($_key, $_value);
			}
			// Validate/update any additional profile fields.

			if(isset($args['profile_fields'])) // Handled by class extenders.
				if($this->©errors->exist_in($validate_profile_fields = $this->©user_utils->validate_profile_fields($this, $args['updater'], $args['profile_fields'])))
				{
					$this->refresh(); // Refresh (in case of updates above).
					return $validate_profile_fields; // Errors.
				}
				else if($this->©errors->exist_in($update_profile_fields = $this->update_profile_fields($args['profile_fields'])))
				{
					$this->refresh(); // Refresh (in case of updates above).
					return $update_profile_fields; // Errors.
				}
			// Finalize the update for this user (fires `profile_update` hook in WordPress®).
			// Given our own validation routines above, errors should NOT occur here; but we'll check anyway.
			if(is_wp_error($wp_update_user = wp_update_user($this->©strings->slash_deep($data))))
			{
				$this->refresh(); // Let's refresh (in case of updates above).

				if(!$wp_update_user->get_error_code() || !$wp_update_user->get_error_message())
					return $this->©error(
						$this->method(__FUNCTION__).'#unknown_wp_error', array_merge(get_defined_vars(), array('user' => $this)),
						$this->_x('Unknown error (please try again).')
					);
				return $this->©error(
					$this->method(__FUNCTION__).'#wp_error_'.$wp_update_user->get_error_code(), array_merge(get_defined_vars(), array('user' => $this)),
					$wp_update_user->get_error_message() // Message from `wp_update_user()`.
				);
			}
			$this->do_action('update', $this, array_merge(get_defined_vars(), array('user' => $this)));

			$this->refresh(); // Always refresh object instance after an update.

			return TRUE; // Default return value.
		}

		/**
		 * Updates additional profile fields implemented by class extenders.
		 *
		 * @note This is NOT handled by the core. It requires a class extender to override this.
		 *    By default, this method simply returns a TRUE value at all times.
		 *
		 * @param array $profile_field_values An associative array of profile fields (by code).
		 *
		 * @return boolean|errors TRUE on success; else an errors object on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function update_profile_fields($profile_field_values)
		{
			$this->check_arg_types('array', func_get_args());

			return TRUE; // Default return value.
		}

		/**
		 * Handles user profile updates.
		 *
		 * @param array  $args An array of argument values that need to be updated.
		 *    See `$this->update()` for further details.
		 *
		 * @param string $optional_requirements An encrypted/serialized array of optional fields, which we've decided to require.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the user has no ID (i.e. cannot update profile in this case).
		 * @throws exception If `$args` contains data NOT allowed during basic profile updates.
		 *    Keys NOT allowed: `ip`, `role`, `activation_key`, `options`, `meta`, `data`.
		 */
		public function ®profile_update($args, $optional_requirements = '')
		{
			$this->check_arg_types('array', 'string', func_get_args());

			$args['updater'] = $this->©user;

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update).')
				);
			if(isset($args['ip']) || isset($args['role']) || isset($args['activation_key']) || isset($args['options']) || isset($args['meta']) || isset($args['data']))
				throw $this->©exception( // NOT allowed during basic profile updates. See {@link ®update()}.
					$this->method(__FUNCTION__).'#security_issue', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('Security issue. Some data is NOT allowed during basic profile updates.')
				);
			extract($args); // Extract for call data.

			if($optional_requirements && is_array($_optional_requirements = maybe_unserialize($this->©encryption->decrypt($optional_requirements))))
				$optional_requirements = $_optional_requirements; // A specific set of optional fields to require.
			else $optional_requirements = array(); // There are none.
			unset($_optional_requirements); // Housekeeping.

			if($this->©errors->exist_in($response = $this->update($args, $optional_requirements)))
				$errors = $response; // Define `$errors` for template.

			else $successes = $this->©success( // We have success. Profile now up-to-date :-)
				$this->method(__FUNCTION__).'#success', array_merge(get_defined_vars(), array('user' => $this)),
				$this->_x('Profile updated successfully.'));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), array_merge(get_defined_vars(), array('user' => $this)));
		}

		/**
		 * Handles user updates (for general/administrative purposes).
		 *
		 * @param array  $args An array of argument values that need to be updated.
		 *    See `$this->update()` for further details.
		 *
		 * @param string $optional_requirements An encrypted/serialized array of optional fields, which we've decided to require.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If the user has no ID (i.e. cannot update).
		 */
		public function ®update($args, $optional_requirements = '')
		{
			$this->check_arg_types('array', 'string', func_get_args());

			$args['updater'] = $this->©user;

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update).')
				);
			extract($args); // Extract for call data.

			if($optional_requirements && is_array($_optional_requirements = maybe_unserialize($this->©encryption->decrypt($optional_requirements))))
				$optional_requirements = $_optional_requirements; // A specific set of optional fields to require.
			else $optional_requirements = array(); // There are none.
			unset($_optional_requirements); // Housekeeping.

			if($this->©errors->exist_in($response = $this->update($args, $optional_requirements)))
				$errors = $response; // Define `$errors` for template use.

			else $successes = $this->©success( // We have success. The user's profile has been updated :-)
				$this->method(__FUNCTION__).'#success', array_merge(get_defined_vars(), array('user' => $this)),
				$this->__('User updated successfully.'));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), array_merge(get_defined_vars(), array('user' => $this)));
		}

		/**
		 * Gets a user option value.
		 *
		 * @param string $key An option key/name.
		 *
		 * @return mixed Data from call to `get_user_option()`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function get_option($key)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot get option).')
				);
			return get_user_option($key, $this->ID);
		}

		/**
		 * Updates a user option value.
		 *
		 * @param string $key An option key/name.
		 * @param mixed  $value An option value (mixed data types ok).
		 *    If `$value` is NULL, the option `$key` is deleted completely.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function update_option($key, $value)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update option).')
				);
			if(is_null($value))
				delete_user_option($this->ID, $key);
			else update_user_option($this->ID, $key, $value);
		}

		/**
		 * Deletes a user option value.
		 *
		 * @param string $key An option key/name.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function delete_option($key)
		{
			$this->update_option($key, NULL);
		}

		/**
		 * Gets a user meta value.
		 *
		 * @param string $key A meta key/name.
		 *
		 * @return mixed Data from call to `get_user_meta()`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function get_meta($key)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot get meta).')
				);
			return get_user_meta($this->ID, $key, TRUE);
		}

		/**
		 * Updates a user meta value.
		 *
		 * @param string $key A meta key/name.
		 * @param mixed  $value A meta value (mixed data types ok).
		 *    If `$value` is NULL, the meta `$key` is deleted completely.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function update_meta($key, $value)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update meta).')
				);
			if(is_null($value))
				delete_user_meta($this->ID, $key);
			else update_user_meta($this->ID, $key, $value);

			if($key === 'ip')
				$this->ip = (string)$value;

			else if($key === 'first_name')
				$this->first_name = (string)$value;

			else if($key === 'last_name')
				$this->last_name = (string)$value;

			if(in_array($key, array('first_name', 'last_name'), TRUE))
				$this->full_name = trim($this->first_name.' '.$this->last_name);
		}

		/**
		 * Deletes a user meta value.
		 *
		 * @param string $key A meta key/name.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function delete_meta($key)
		{
			$this->update_meta($key, NULL);
		}

		/**
		 * Updates a user's activation key.
		 *
		 * @param string $activation_key A new activation key; or empty to delete.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function update_activation_key($activation_key)
		{
			$this->check_arg_types('string', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update activation key).')
				);
			$activation_key = (string)$activation_key;
			$activation_key = (string)substr($activation_key, 0, 60);

			$this->©db->update(
				$this->©db_tables->get_wp('users'),
				array('user_activation_key' => $activation_key), array('ID' => $this->ID)
			);
			$this->activation_key = $activation_key;
		}

		/**
		 * Deletes a user's activation key.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function delete_activation_key()
		{
			$this->update_activation_key('');
		}

		/**
		 * Updates a user's password.
		 *
		 * @param string $password A new plain text password.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If this user does NOT have an ID.
		 */
		public function update_password($password)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!$this->has_id())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#id_missing', array_merge(get_defined_vars(), array('user' => $this)),
					$this->__('User has no ID (cannot update password).')
				);
			wp_set_password($password, $this->ID);
			$this->delete_activation_key();
		}
	}
}