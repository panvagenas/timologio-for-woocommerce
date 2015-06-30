<?php
/**
 * User Utilities.
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
	 * User Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class user_utils extends framework
	{
		/**
		 * Username regex pattern.
		 *
		 * @var string Username regex pattern.
		 *
		 * @note Minimum 4 characters. Must be 4-60 characters in length.
		 *    Usernames may NEVER exceed 60 characters (max DB column size).
		 */
		public $regex_valid_username = '/^[a-zA-Z][a-zA-Z0-9@._\-]{3,59}$/';

		/**
		 * Username regex pattern (for multisite networks).
		 *
		 * @var string Username regex pattern (for multisite networks).
		 *
		 * @note Minimum 4 characters. Must be 4-60 characters in length.
		 *    Usernames may NEVER exceed 60 characters (max DB column size).
		 */
		public $regex_valid_multisite_username = '/^[a-z][a-z0-9]{3,59}$/';

		/**
		 * Email address regex pattern.
		 *
		 * @var string Email address regex pattern.
		 *
		 * @note Emails may NEVER exceed 100 chars (the max DB column size).
		 * @note This is NOT 100% RFC compliant. This does NOT grok i18n domains.
		 * @see http://en.wikipedia.org/wiki/Email_address
		 */
		public $regex_valid_email = '/^[a-zA-Z0-9_!#$%&*+=?`{}~|\/\^\'\-]+(?:\.?[a-zA-Z0-9_!#$%&*+=?`{}~|\/\^\'\-]+)*@[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*(?:\.[a-zA-Z0-9]+(?:\-*[a-zA-Z0-9]+)*)*(?:\.[a-zA-Z][a-zA-Z0-9]+)?$/';

		/**
		 * Which user are we working with?
		 *
		 * @param null|integer|\WP_User|users $user Optional. One of the following:
		 *    • NULL indicates the current user (i.e. `$this->©user`).
		 *    • A value of `-1`, indicates NO user explicitly (e.g. a public user w/o an account).
		 *    • An integer indicates a specific user ID (which we'll obtain an object instance for).
		 *    • A `\WP_User` object, indicates a specific user (which we'll obtain an object instance for).
		 *    • A `users` object, indicates a specific user object instance.
		 *
		 * @return users A user object instance.
		 *    Else an exception is thrown (e.g. unable to determine).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to determine which user we're suppose to be working with.
		 */
		public function which($user = NULL)
		{
			$this->check_arg_types($this->which_types(), func_get_args());

			if($user instanceof users)
				return $user;

			if(is_null($user))
				return $this->©user;

			if(is_integer($user))
				return $this->©user($user);

			if($user instanceof \WP_User)
				return $this->©user($user->ID);

			throw $this->©exception(
				$this->method(__FUNCTION__).'#unexpected_user', get_defined_vars(),
				$this->__('Not sure which `$user` we\'re dealing with.').
				' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($user))
			);
		}

		/**
		 * Gets an array of `$this->which()` user types.
		 *
		 * @return array Array of `$this->which()` user types.
		 */
		public function which_types()
		{
			if(isset($this->cache[__FUNCTION__]))
				return $this->cache[__FUNCTION__];

			return ($this->cache[__FUNCTION__]
				= array_unique(array(
					               'null', 'integer', '\\WP_User',
					               $this->instance->core_ns_prefix.'\\users',
					               $this->instance->plugin_root_ns_prefix.'\\users'
				               )));
		}

		/**
		 * Gets a dynamic ©user object instance.
		 *
		 * @param string               $by Searches for a user, by a particular type of value.
		 *
		 *    MUST be one of these values:
		 *    • `ID`
		 *    • `username`
		 *    • `email`
		 *    • `activation_key`
		 *    • Others become possible, when/if `get_id_by()` is enhanced by a class extender.
		 *
		 * @param string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
		 *
		 * @return null|users A user object instance, else NULL on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$by` or `$value` are empty.
		 */
		public function get_by($by, $value)
		{
			$this->check_arg_types('string:!empty', array('string:!empty', 'integer:!empty', 'array:!empty'), func_get_args());

			$by = strtolower($by); // Force lowercase for easier comparison below.

			if($by === 'id' && is_numeric($value)) // Simplify this case.
			{
				if(($value = (integer)$value)
				   && ($user = $this->©user($value)) && $user->has_id()
				) return $user; // User with an ID — good :-)
			}
			else if(($_id_by = $this->get_id_by($by, $value))
			        && ($user = $this->©user($_id_by)) && $user->has_id()
			) return $user; // User with an ID — good :-)

			else if(($user = $this->©user(NULL, $by, $value)) && $user->is_populated())
				return $user; // Last ditch effort (perhaps NOT a real user).

			unset($_id_by); // Housekeeping.

			return NULL; // Failure.
		}

		/**
		 * Gets a WordPress® user ID.
		 *
		 * @param string               $by Searches for a user, by a particular type of value.
		 *
		 *    MUST be one of these values:
		 *    • `ID`
		 *    • `username`
		 *    • `email`
		 *    • `activation_key`
		 *    • Others become possible when/if this method is enhanced by a class extender.
		 *
		 * @param string|integer|array $value A value to search for (e.g. username(s), email address(es), ID(s)).
		 *
		 * @return integer A WordPress® user ID, else `0`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$by` or `$value` are empty.
		 */
		public function get_id_by($by, $value)
		{
			$this->check_arg_types('string:!empty', array('string:!empty', 'integer:!empty', 'array:!empty'), func_get_args());

			$by = strtolower($by); // Force lowercase for easier comparison below.

			if(in_array($by, array('id', 'username', 'email', 'activation_key'), TRUE))
			{
				if($by === 'id')
					$by = 'ID';

				else if($by === 'username')
					$by = 'user_login';

				else if($by === 'email')
					$by = 'user_email';

				else if($by === 'activation_key')
					$by = 'user_activation_key';

				$query =
					"SELECT".
					" `users`.`ID`".

					" FROM".
					" `".$this->©db_tables->get_wp('users')."` AS `users`".

					" WHERE".
					" `users`.`".$this->©string->esc_sql($by)."` IN(".$this->©db_utils->comma_quotify((array)$value).")".

					" LIMIT 1";

				if(($user_id = (integer)$this->©db->get_var($query)))
					return $user_id;
			}
			return 0; // Default return value.
		}

		/**
		 * Formats a user's registration display name.
		 *
		 * @param array|object $data An array of user data, or an object.
		 *
		 *    Should contain at least one of these:
		 *    • `email`
		 *    • `username`
		 *    • `first_name`
		 *    • `last_name`
		 *    • `full_name`
		 *    • `display_name` (we'll use this if it's in the array/object)
		 *
		 * @return string The user's display name, based on formatting options set by a site owner.
		 *    If there is NOT enough data available to fill the display name, this defaults to `Anonymous`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function format_registration_display_name($data = array())
		{
			$this->check_arg_types(array('array', 'object'), func_get_args());

			if(is_array($data)) $data = (object)$data; // Force object properties.

			if($this->©string->is_not_empty($data->display_name))
				return $data->display_name; // That was easy :-)

			switch($this->©options->get('users.registration.display_name_format'))
			{
				// Each case falls through on failure (in order of precedence).

				case 'first_name': // First name?

					if($this->©string->is_not_empty($data->first_name))
						return $data->first_name;

				case 'full_name': // Full (first/last combo)?

					if($this->©string->is_not_empty($data->full_name))
						return $data->full_name; // Easy :-)

					if($this->©string->is_not_empty($data->first_name) || $this->©string->is_not_empty($data->last_name))
						return trim($this->©string->is_not_empty_or($data->first_name, '').' '.$this->©string->is_not_empty_or($data->last_name, ''));

				case 'username': // Username?

					if($this->©string->is_not_empty($data->username))
						return $data->username;

				case 'last_name': // Last name?

					if($this->©string->is_not_empty($data->last_name))
						return $data->last_name;

				case 'email': // Use email address?

					if($this->©string->is_not_empty($data->email))
						return $data->email;

				default: // Default logic (we will choose — w/ same precedence).

					if($this->©string->is_not_empty($data->first_name)) return $data->first_name;
					if($this->©string->is_not_empty($data->full_name)) return $data->full_name;
					if($this->©string->is_not_empty($data->username)) return $data->username;
					if($this->©string->is_not_empty($data->last_name)) return $data->last_name;
					if($this->©string->is_not_empty($data->email)) return $data->email;
			}
			return $this->apply_filters('default_display_name', $this->_x('Anonymous', 'default-display-name'));
		}

		/**
		 * Is this a valid email address for registration?
		 *
		 * @param string $email A possible email address to validate.
		 *
		 * @return boolean|errors TRUE if `$email` is a valid (available) email address.
		 *    Otherwise, this returns an errors object on failure.
		 *
		 * @note Emails may NEVER exceed 100 chars (the max DB column size).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validate_registration_email($email)
		{
			$this->check_arg_types('string', func_get_args());

			$form_field_code = 'email'; // For form errors.
			$user            = (string)strstr($email, '@', TRUE);
			$domain          = ltrim((string)strstr($email, '@'), '@');

			if(!$email)
				return $this->©error(
					$this->method(__FUNCTION__).'#missing_email', get_defined_vars(),
					$this->_x('Missing email address (empty).')
				);
			if(is_multisite()) // A multisite network?
			{
				if(!preg_match($this->regex_valid_email, $email)
				   || !is_email($email)
				   || $email !== sanitize_email($email)
				   || strlen($email) > 100
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_multisite_email', get_defined_vars(),
					sprintf($this->_x('Invalid email address: `%1$s`.'), $email)
				);
				if(email_exists($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#multisite_email_exists', get_defined_vars(),
						sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
					);
				if($this->©array->¤is_not_empty($limited_email_domains = get_site_option('limited_email_domains'))
				   && !in_array(strtolower($domain), $limited_email_domains, TRUE)
				) return $this->©error(
					$this->method(__FUNCTION__).'#unapproved_multisite_email', get_defined_vars(),
					sprintf($this->_x('Unapproved email domain: `%1$s`.'), $domain).
					' '.$this->_x('You cannot use an email address with this domain.')
				);
				if(is_email_address_unsafe($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#restricted_multisite_email', get_defined_vars(),
						sprintf($this->_x('Restricted email domain: `%1$s`.'), $domain).
						' '.$this->_x('We are having problems with this domain blocking some of our email.').
						' '.$this->_x('Please use another email service provider.')
					);
				// Check the WordPress® `signups` table too (in case it's awaiting activation).
				$query = // Checks the WordPress® `signups` table.
					"SELECT".
					" `signups`.*".

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

					" WHERE".
					" `signups`.`user_email` = '".$this->©string->esc_sql($email)."'".

					" LIMIT 1"; // Only need one row here.

				if(is_object($signup = $this->©db->get_row($query, OBJECT)))
				{
					if($signup->active)
						return $this->©error(
							$this->method(__FUNCTION__).'#multisite_email_exists', get_defined_vars(),
							sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
						);
					if(strtotime($signup->registered) < strtotime('-2 days'))
						$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_email' => $email));

					else return $this->©error(
						$this->method(__FUNCTION__).'#reserved_multisite_email', get_defined_vars(),
						sprintf($this->_x('Reserved email address: `%1$s`.'), $email).
						' '.$this->_x('This email address has already been used. Please check your inbox for an activation link.').
						' '.$this->_x('If you do nothing, this email address will become available again — after two days.')
					);
				}
			}
			else // This is a standard WordPress® installation (e.g. it is NOT a multisite network).
			{
				if(!preg_match($this->regex_valid_email, $email)
				   || !is_email($email)
				   || $email !== sanitize_email($email)
				   || strlen($email) > 100
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_email', get_defined_vars(),
					sprintf($this->_x('Invalid email address: `%1$s`.'), $email)
				);
				if(email_exists($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#email_exists', get_defined_vars(),
						sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
					);
			}
			return TRUE; // Default return value.
		}

		/**
		 * Is this a valid email address change?
		 *
		 * @param string $email A possible email address to validate.
		 * @param string $existing_email The user's existing email address (possibly the same).
		 *
		 * @return boolean|errors TRUE if `$email` is a valid (available) email address.
		 *    Otherwise, this returns an errors object on failure.
		 *
		 * @note Emails may NEVER exceed 100 chars (the max DB column size).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validate_email_change_of_address($email, $existing_email)
		{
			$this->check_arg_types('string', 'string', func_get_args());

			$form_field_code = 'email'; // For form errors.
			$user            = (string)strstr($email, '@', TRUE);
			$domain          = ltrim((string)strstr($email, '@'), '@');

			if(!$email)
				return $this->©error(
					$this->method(__FUNCTION__).'#missing_email', get_defined_vars(),
					$this->_x('Missing email address (empty).')
				);
			if(is_multisite()) // A multisite network?
			{
				if(!preg_match($this->regex_valid_email, $email)
				   || !is_email($email)
				   || $email !== sanitize_email($email)
				   || strlen($email) > 100
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_multisite_email', get_defined_vars(),
					sprintf($this->_x('Invalid email address: `%1$s`.'), $email)
				);
				if(strcasecmp($email, $existing_email) !== 0 && email_exists($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#multisite_email_exists', get_defined_vars(),
						sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
					);
				if($this->©array->¤is_not_empty($limited_email_domains = get_site_option('limited_email_domains'))
				   && !in_array(strtolower($domain), $limited_email_domains, TRUE)
				) return $this->©error(
					$this->method(__FUNCTION__).'#unapproved_multisite_email', get_defined_vars(),
					sprintf($this->_x('Unapproved email domain: `%1$s`.'), $domain).
					' '.$this->_x('You cannot use an email address with this domain.')
				);
				if(is_email_address_unsafe($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#restricted_multisite_email', get_defined_vars(),
						sprintf($this->_x('Restricted email domain: `%1$s`.'), $domain).
						' '.$this->_x('We are having problems with this domain blocking some of our email.').
						' '.$this->_x('Please use another email service provider.')
					);
				if(strcasecmp($email, $existing_email) !== 0) // Check the WordPress® `signups` table.
				{
					$query = // Checks the WordPress® `signups` table.
						"SELECT".
						" `signups`.*".

						" FROM".
						" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

						" WHERE".
						" `signups`.`user_email` = '".$this->©string->esc_sql($email)."'".

						" LIMIT 1"; // Only need one row here.

					if(is_object($signup = $this->©db->get_row($query, OBJECT)))
					{
						if($signup->active)
							return $this->©error(
								$this->method(__FUNCTION__).'#multisite_email_exists', get_defined_vars(),
								sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
							);
						if(strtotime($signup->registered) < strtotime('-2 days'))
							$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_email' => $email));

						else return $this->©error(
							$this->method(__FUNCTION__).'#reserved_multisite_email', get_defined_vars(),
							sprintf($this->_x('Reserved email address: `%1$s`.'), $email).
							' '.$this->_x('This email address is already associated with another account holder.').
							' '.$this->_x('However, there\'s a chance it will become available again in a couple of days;').
							' '.$this->_x('should the other account holder fail to complete activation for some reason.')
						);
					}
				}
			}
			else // This is a standard WordPress® installation.
			{
				if(!preg_match($this->regex_valid_email, $email)
				   || !is_email($email)
				   || $email !== sanitize_email($email)
				   || strlen($email) > 100
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_email', get_defined_vars(),
					sprintf($this->_x('Invalid email address: `%1$s`.'), $email)
				);
				if(strcasecmp($email, $existing_email) !== 0 && email_exists($email))
					return $this->©error(
						$this->method(__FUNCTION__).'#email_exists', get_defined_vars(),
						sprintf($this->_x('Email address: `%1$s`, is already in use.'), $email)
					);
			}
			return TRUE; // Default return value.
		}

		/**
		 * Is this a valid/available username?
		 *
		 * @param string $username A possible username to validate.
		 *
		 * @return boolean|errors TRUE if `$username` is a valid (available) username.
		 *    Otherwise, this returns an errors object on failure.
		 *
		 * @note Usernames may NEVER exceed 60 characters (the max DB column size).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validate_registration_username($username)
		{
			$this->check_arg_types('string', func_get_args());

			$form_field_code = 'username'; // For form errors.

			if(!$username)
				return $this->©error(
					$this->method(__FUNCTION__).'#missing_username', get_defined_vars(),
					$this->_x('Missing username (empty).')
				);
			if(is_multisite()) // A multisite network?
			{
				if(!is_array($illegal_names = get_site_option('illegal_names')))
					add_site_option('illegal_names', ($illegal_names = array('www', 'web', 'root', 'admin', 'main', 'invite', 'administrator')));

				if(!preg_match($this->regex_valid_multisite_username, $username)
				   || $username !== sanitize_user($username, TRUE)
				   || strlen($username) > 60
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_multisite_username', get_defined_vars(),
					sprintf($this->_x('Invalid username: `%1$s`.'), $username).
					' '.$this->_x('Please use `a-z0-9` only (lowercase, 4 character minimum).').
					' '.$this->_x('Username MUST start with a letter.')
				);
				if(username_exists($username))
					return $this->©error(
						$this->method(__FUNCTION__).'#multisite_username_exists', get_defined_vars(),
						sprintf($this->_x('Username: `%1$s`, is already in use.'), $username)
					);
				if(in_array(strtolower($username), $illegal_names, TRUE))
					return $this->©error(
						$this->method(__FUNCTION__).'#illegal_multisite_username', get_defined_vars(),
						sprintf($this->_x('Illegal/reserved username: `%1$s`.'), $username)
					);
				// Check the WordPress® `signups` table too (in case it's awaiting activation).
				$query = // Checks the WordPress® `signups` table.
					"SELECT".
					" `signups`.*".

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get_wp('signups'))."` AS `signups`".

					" WHERE".
					" `signups`.`user_login` = '".$this->©string->esc_sql($username)."'".

					" LIMIT 1"; // Only need one row here.

				if(is_object($signup = $this->©db->get_row($query, OBJECT)))
				{
					if($signup->active)
						return $this->©error(
							$this->method(__FUNCTION__).'#multisite_username_exists', get_defined_vars(),
							sprintf($this->_x('Username: `%1$s`, is already in use.'), $username)
						);
					if(strtotime($signup->registered) < strtotime('-2 days'))
						$this->©db->delete($this->©db_tables->get_wp('signups'), array('user_login' => $username));

					else return $this->©error(
						$this->method(__FUNCTION__).'#reserved_multisite_username', get_defined_vars(),
						sprintf($this->_x('Reserved username: `%1$s`.'), $username).
						' '.$this->_x('Username is currently reserved, but might become available in a couple of days.')
					);
				}
			}
			else // This is a standard WordPress® installation (e.g. it is NOT a multisite network).
			{
				if(!preg_match($this->regex_valid_username, $username)
				   || $username !== sanitize_user($username, TRUE)
				   || strlen($username) > 60
				) return $this->©error(
					$this->method(__FUNCTION__).'#invalid_username', get_defined_vars(),
					sprintf($this->_x('Invalid username: `%1$s`.'), $username).
					' '.$this->_x('Please use `A-Z a-z 0-9 _ . @ -` only (4 character minimum).').
					' '.$this->_x('Username MUST start with a letter.')
				);
				if(username_exists($username))
					return $this->©error(
						$this->method(__FUNCTION__).'#username_exists', get_defined_vars(),
						sprintf($this->_x('Username: `%1$s`, is already in use.'), $username)
					);
			}
			return TRUE; // Default return value.
		}

		/**
		 * Checks to see if a username/email combo DOES exist, but NOT on a specific blog ID.
		 *
		 * @param string       $username A WordPress® username.
		 * @param string       $email A matching email address to look for.
		 * @param null|integer $blog_id A specific blog ID. Defaults to a NULL value.
		 *    If this is NULL, we assume the current blog ID.
		 *
		 * @return integer The existing user ID, if the `$username`, `$email` combination actually DOES exist already,
		 *    BUT the `$username`, `$email` combination is NOT currently a member of `$blog_id` (e.g. we can add them to `$blog_id`).
		 *    Otherwise, this returns `0` by default.
		 */
		public function username_email_exists_but_not_on_blog($username, $email, $blog_id = NULL)
		{
			$this->check_arg_types('string', 'string', array('null', 'integer'), func_get_args());

			if(!isset($blog_id)) $blog_id = get_current_blog_id();

			if($username && $email && $blog_id)
			{
				$query = // Looking for a specific username/email combination.
					"SELECT".
					" `users`.`ID`".

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get_wp('users'))."` AS `users`".

					" WHERE".
					" `users`.`user_login` = '".$this->©string->esc_sql($username)."'".
					" AND `users`.`user_email` = '".$this->©string->esc_sql($email)."'".

					" LIMIT 1";

				if(($user_id = (integer)$this->©db->get_var($query)) && !is_user_member_of_blog($user_id, $blog_id))
					return $user_id;
			}
			return 0; // Default return value.
		}

		/**
		 * Is this a valid password?
		 *
		 * @param string $password A possible password to validate.
		 *
		 * @return boolean|errors TRUE if `$password` is a valid (i.e. long/strong enough).
		 *    Otherwise, this returns an errors object on failure.
		 *
		 * @note Passwords may NEVER exceed 100 characters (that's ridiculous).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validate_password($password)
		{
			$this->check_arg_types('string', func_get_args());

			$form_field_code = 'password'; // For form errors.

			if(!$password) // Missing completely?
				return $this->©error(
					$this->method(__FUNCTION__).'#missing_password', get_defined_vars(),
					$this->_x('Missing password (empty).')
				);
			if(strlen($password) < $this->apply_filters('min_password_length', 6))
				return $this->©error(
					$this->method(__FUNCTION__).'#password_too_short', get_defined_vars(),
					$this->_x('Password is too short (must be at least six characters).')
				);
			if(strlen($password) > $this->apply_filters('max_password_length', 100))
				return $this->©error(
					$this->method(__FUNCTION__).'#password_too_long', get_defined_vars(),
					$this->_x('Password is too long (100 characters max).')
				);
			return TRUE; // Default return value.
		}

		/**
		 * Validates additional profile fields implemented by class extenders.
		 *
		 * @note This is NOT handled by the core. It requires a class extender to override this.
		 *    By default, this method simply returns a TRUE value at all times.
		 *
		 * @param null|integer|\WP_User|users $user The user we're working with here.
		 *
		 * @param null|integer|\WP_User|users $reader_writer The user (reader/writer) that we need to check permissions against here.
		 *
		 * @param array                       $profile_field_values An associative array of profile field values (by code).
		 *
		 * @param string                      $context One of these values: {@link fw_constants::context_registration}, {@link fw_constants::context_profile_updates}.
		 *    The context in which profile fields are being updated (defaults to {@link fw_constants::context_profile_updates}).
		 *
		 * @param array                       $args Optional. Arguments that control validation behavior.
		 *
		 * @return boolean|errors TRUE on success; else an errors object on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validate_profile_fields($user, $reader_writer, $profile_field_values,
		                                        $context = self::context_profile_updates, $args = array())
		{
			$this->check_arg_types($this->which_types(), $this->which_types(),
			                       'array', 'string:!empty', 'array', func_get_args());

			return TRUE; // Default return value.
		}

		/**
		 * Creates a new WordPress® user.
		 *
		 * @param $args array Array of arguments:
		 *
		 *  • (string)`ip` A required parameter. An IP address for this user.
		 *  • (string)`email` A required parameter. A valid email address.
		 *
		 *    All other parameters are optional. Except `$username` is required on multisite networks.
		 *
		 *  • (string)`username` Optional on standard WordPress® installs (but required in multisite networks).
		 *       A valid username. Chars allowed: `A-Za-z0-9_.@-`. If empty, defaults to `$email` value.
		 *
		 *       Multisite networks MUST collect a username, because an email address will NOT work in a multisite network.
		 *       WordPress® character restrictions (for usernames) in a multisite network, do NOT allow email addresses.
		 *       On multisite networks, the allowed chars include: `a-z0-9` only (all lowercase).
		 *
		 *  • (string)`password` Optional. A plain text password. If empty, one will be generated automatically.
		 *
		 *  • (string)`first_name` Optional. User's first name (self explanatory).
		 *  • (string)`last_name` Optional. User's last name. Note that a user's `display_name`,
		 *       is NOT collected by this method. Instead, we format a `display_name` automatically, based on preference.
		 *       However, if you'd like to force a specific `display_name`, you can pass it through `$data`, as detailed below.
		 *       See also: `format_display_name()` for further details.
		 *
		 *  • (string)`url` Optional. A URL associated with this user (e.g. their website URL).
		 *
		 *  • (array)`options` Optional associative array. Any additional user option values.
		 *       These are stored via `update_user_option()` (e.g. blog-specific meta values).
		 *
		 *  • (array)`meta` Optional associative array. Any additional user meta values.
		 *       These are stored via `update_user_meta()` (e.g. site-wide meta values).
		 *
		 *  • (array)`data` Optional associative array. Any additional data you'd like to pass through `wp_insert_user()`.
		 *       See: http://codex.wordpress.org/Function_Reference/wp_insert_user
		 *
		 *  • (array)`profile_fields` Optional associative array w/ additional profile field values (by code).
		 *       See {@link validate_profile_fields()} for further details (implemented by class extenders).
		 *       See also {@link users::update_profile_fields()} for further details.
		 *
		 *  • (array)`profile_field_validation_args` Optional associative array w/ additional profile field validation args.
		 *       See {@link validate_profile_fields()} for further details (implemented by class extenders).
		 *       See also {@link users::update_profile_fields()} for further details.
		 *
		 *  • (boolean)`must_activate` Optional. Defaults to a TRUE value.
		 *       When this is TRUE, the user account is created; but the account will require email activation.
		 *       This creates a user option: `must_activate` = `TRUE`, which MUST be deleted before access.
		 *
		 *  • (null|integer|\WP_User|users)`creator` The user (creator) that we MAY validate against here.
		 *       For instance, this MIGHT be used in some validations against profile field submissions.
		 *       This defaults to `-1`, NO user (e.g. the systematic creation of a user).
		 *
		 * @return array|errors An associative array on success, with a new user ID & password; else an errors object on failure.
		 *    The return array contains three elements: (integer)`ID`, (object)`user`, and (string)`password`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire user object instance after creation.
		 */
		public function create($args)
		{
			$this->check_arg_types('array', func_get_args());

			// Formulate and validation incoming args.

			$default_args = array(
				'ip'                            => '', // Required argument value.
				'email'                         => '', // Required argument value.
				'username'                      => '', // Required on multisite networks.

				'role'                          => get_option('default_role'),

				'password'                      => '',
				'first_name'                    => '',
				'last_name'                     => '',
				'url'                           => '',

				'options'                       => array(),
				'meta'                          => array(),
				'data'                          => array(),

				'profile_fields'                => array(),
				'profile_field_validation_args' => array(),

				'must_activate'                 => TRUE,
				'creator'                       => -1
			);
			$args         = $this->check_extension_arg_types(
				'string', 'string', 'string', 'string:!empty', // `ip`, `email`, `username`, `role`.
				'string', 'string', 'string', 'string', // `password`, `first_name`, `last_name`, `url`.
				'array', 'array', 'array', // `options`, `meta`, `data`.
				'array', 'array', // `profile_fields`, `profile_field_validation_args`.
				'boolean', $this->which_types(), // `must_activate`, `creator` (used in some validations).
				$default_args, $args, ((is_multisite()) ? 3 : 2)
			);
			// Handle some default values (when/if possible) & minor adjustments.

			if(!$args['username'] && !is_multisite()) // Username is optional (but NOT on multisite networks).
				$args['username'] = $args['email']; // Allows emails to serve as a username. Not recommended, but possible.

			if(is_multisite()) // Force lowercase in multisite networks. Allowed chars include: `a-z0-9` only (all lowercase).
				$args['username'] = strtolower($args['username']); // WordPress® is VERY restrictive in a multisite network.

			if(!$args['password']) // If we were NOT given a plain text password, let's generate one automatically.
				$args['password'] = $this->©string->random(15); // Not recommended, but possible.

			// Put array of `data` together for our call to `wp_insert_user()` below.

			$data = array_merge(array( // For `wp_insert_user()` below.
			                           'role'       => $args['role'],
			                           'user_email' => (string)substr($args['email'], 0, 100),
			                           'user_login' => (string)substr($args['username'], 0, 60),
			                           'user_pass'  => (string)substr($args['password'], 0, 100),
			                           'first_name' => (string)substr($args['first_name'], 0, 100),
			                           'last_name'  => (string)substr($args['last_name'], 0, 100),
			                           'user_url'   => (string)substr($args['url'], 0, 100)
			                    ), $args['data']);

			$data = array_merge(array( // Format this based on site preference.
			                           'display_name' => (string)substr($this->format_registration_display_name($data), 0, 250)
			                    ), $data);

			if(is_multisite() && $args['username'] && $args['email'] // Multisite user exists?
			   && ($user_id = $this->username_email_exists_but_not_on_blog($args['username'], $args['email']))
			) // In a network, we can add existing users to this blog, IF they're already in the network (on another blog).
			{
				if($this->©errors->exist_in($validate_password = $this->validate_password($args['password'])))
					return $validate_password; // Password issue(s).

				if($args['profile_fields'] && $this->©errors->exist_in( // Validate these too.
						$validate_profile_fields = $this->validate_profile_fields(-1, $args['creator'],
						                                                          $args['profile_fields'], $this::context_registration,
						                                                          $args['profile_field_validation_args']))
				) return $validate_profile_fields; // Profile field issue(s).

				if(is_wp_error($add_existing_user_to_blog = add_existing_user_to_blog(array('user_id' => $user_id, 'role' => $args['role']))))
					// If errors occur here, we'll need to stop. The user MUST be formally added to the current blog.
					// Adding the user to this blog, MAY update their `primary_blog` and `source_domain`.
				{
					/** @var $add_existing_user_to_blog \WP_Error WordPress® error class. */
					if(!$add_existing_user_to_blog->get_error_code() || !$add_existing_user_to_blog->get_error_message())
						return $this->©error(
							$this->method(__FUNCTION__).'#unknown_wp_error', get_defined_vars(),
							$this->_x('Unknown error (please try again).')
						);
					return $this->©error(
						$this->method(__FUNCTION__).'#wp_error_'.$add_existing_user_to_blog->get_error_code(), get_defined_vars(),
						$add_existing_user_to_blog->get_error_message() // Message from `add_existing_user_to_blog()`.
					);
				}
				if(!($user = $this->get_by('id', $user_id))) // A VERY wrong scenario.
					throw $this->©exception($this->method(__FUNCTION__).'#unable_to_acquire_user', get_defined_vars(),
					                        sprintf($this->__('Unable to acquire user ID: `%1$s`.'), $user_id));

				$user->update_password($args['password']); // Set password quietly (i.e. no hooks).
				do_action('user_register', $user->ID); // Actually a registration (so fire this hook).
			}
			else // We're dealing with a brand new user in this scenario (applies also to a multisite network).
			{
				if($this->©errors->exist_in($validate_registration_email = $this->validate_registration_email($args['email'])))
					return $validate_registration_email; // Problem(s) w/ email address.

				if($this->©errors->exist_in($validate_registration_username = $this->validate_registration_username($args['username'])))
					return $validate_registration_username; // Username issue(s).

				if($this->©errors->exist_in($validate_password = $this->validate_password($args['password'])))
					return $validate_password; // Password issue(s).

				if($args['profile_fields'] && $this->©errors->exist_in( // Pre-validate these.
						$validate_profile_fields = $this->validate_profile_fields(-1, $args['creator'],
						                                                          $args['profile_fields'], $this::context_registration,
						                                                          $args['profile_field_validation_args']))
				) return $validate_profile_fields; // Profile field issue(s).

				if(is_wp_error($wp_insert_user = $user_id = wp_insert_user($this->©strings->slash_deep($data))))
					// Given our own validation routines, errors should NOT occur here (but just in case they do).
				{
					if(!$wp_insert_user->get_error_code() || !$wp_insert_user->get_error_message())
						return $this->©error(
							$this->method(__FUNCTION__).'#unknown_wp_error', get_defined_vars(),
							$this->_x('Unknown error (please try again).')
						);
					return $this->©error(
						$this->method(__FUNCTION__).'#wp_error_'.$wp_insert_user->get_error_code(), get_defined_vars(),
						$wp_insert_user->get_error_message() // Message from `wp_insert_user()`.
					);
				}
				if(is_multisite()) // In networks, we need to add the user to the current blog (formally).
					if(is_wp_error($add_existing_user_to_blog = add_existing_user_to_blog(array('user_id' => $user_id, 'role' => $args['role']))))
						// If errors occur here, we'll need to stop. The user MUST be formally added to the current blog.
						// Adding the user to this blog, updates their `primary_blog` and `source_domain`.
					{
						/** @var $add_existing_user_to_blog \WP_Error WordPress® error class. */
						if(!$add_existing_user_to_blog->get_error_code() || !$add_existing_user_to_blog->get_error_message())
							return $this->©error(
								$this->method(__FUNCTION__).'#unknown_wp_error', get_defined_vars(),
								$this->_x('Unknown error (please try again).')
							);
						return $this->©error(
							$this->method(__FUNCTION__).'#wp_error_'.$add_existing_user_to_blog->get_error_code(), get_defined_vars(),
							$add_existing_user_to_blog->get_error_message() // Message from `add_existing_user_to_blog()`.
						);
					}
				if(!($user = $this->get_by('id', $user_id))) // A VERY wrong scenario.
					throw $this->©exception($this->method(__FUNCTION__).'#unable_to_acquire_user', get_defined_vars(),
					                        sprintf($this->__('Unable to acquire user ID: `%1$s`.'), $user_id));
			}
			// Save IP address (as a meta value).
			$user->update_meta('ip', $args['ip']);

			// Handle possible option values.
			foreach($args['options'] as $_key => $_value)
				if($this->©string->is_not_empty($_key)) $user->update_option($_key, $_value);
			unset($_key, $_value); // Housekeeping.

			// Handle possible meta values.
			foreach($args['meta'] as $_key => $_value)
				if($this->©string->is_not_empty($_key)) $user->update_meta($_key, $_value);
			unset($_key, $_value); // Housekeeping.

			// Handle possible profile fields.
			if($args['profile_fields'] && $this->©errors->exist_in($user->update_profile_fields($args['profile_fields'])))
				throw $this->©exception( // Should NOT happen (profile fields were already validated above).
					$this->method(__FUNCTION__).'#unexpected_profile_field_validation_errors', get_defined_vars(),
					$this->__('Unexpected errors while updating profile fields.'));

			// Handle emails and/or activation.
			$activation_key = ''; // Initialize activation key.
			if($args['must_activate']) // Requires email activation?
			{
				$user->update_option('must_activate', TRUE);
				$activation_key = $this->©encryption->encrypt($user->ID.'::'.$args['password']);
				$user->update_activation_key((string)substr($activation_key, 0, 60));
			}
			$this->do_action('creation', $user->ID, get_defined_vars());

			return array('ID' => $user->ID, 'user' => $user, 'password' => $args['password'], 'activation_key' => $activation_key);
		}

		/**
		 * Activates a new WordPress® user.
		 *
		 * @param string $activation_key An encrypted activation key, as produced by `$this->send_activation_email()`.
		 *
		 * @return array|errors This will return an array on success; else an errors object on failure.
		 *    An array on success, includes: (integer)`ID`, (object)`user`, (string)`password`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$activation_key` is empty.
		 */
		public function activate($activation_key)
		{
			$this->check_arg_types('string', func_get_args());

			$decrypted_activation_key = $this->©encryption->decrypt($activation_key);

			if(!$decrypted_activation_key || strpos($decrypted_activation_key, '::') === FALSE)
				return $this->©error( // Unable to decrypt (or it's in the wrong format).
					$this->method(__FUNCTION__).'#invalid_activation_key', get_defined_vars(),
					$this->_x('Activation failure. Invalid activation key.').
					' '.sprintf($this->_x('Got: `%1$s`.'), $activation_key)
				);
			list($ID, $password) = explode('::', $decrypted_activation_key, 2);
			$ID = (integer)$ID; // Force integer ID here.

			if(!$ID || !$password // Check parts, user existence, and key MUST match what's on file.
			   || !($user = $this->get_by('id', $ID)) || substr($activation_key, 0, 60) !== $user->activation_key
			) // Something is wrong. This key does NOT match up in some way.
				return $this->©error( // Should NOT happen (invalid key).
					$this->method(__FUNCTION__).'#invalid_activation_key', get_defined_vars(),
					$this->_x('Activation failure. Invalid activation key.').
					' '.sprintf($this->_x('Got: `%1$s`.'), $activation_key)
				);
			if(!$user->get_option('must_activate'))
				return $this->©error( // Account already active.
					$this->method(__FUNCTION__).'#already_active', get_defined_vars(),
					sprintf($this->_x('User ID: `%1$s`. This account is already active.'), $user->ID).
					' '.sprintf($this->_x('Please <a href="%1$s">log in</a>.'), esc_attr($this->©url->to_wp_login()))
				);
			$user->delete_activation_key();
			$user->delete_option('must_activate');

			do_action('wpmu_activate_user', $user->ID, $password, array());
			$this->do_action('activation', $user->ID, get_defined_vars());

			return array('ID' => $user->ID, 'user' => $user, 'password' => $password);
		}

		/**
		 * Additional user authentications.
		 *
		 * @attaches-to WordPress® filter `wp_authenticate_user`.
		 * @filter-priority `PHP_INT_MAX` After most everything else.
		 *
		 * @param \WP_User|\WP_Error $authentication A `WP_User` object on success, else a `WP_Error` object failure.
		 *
		 * @return \WP_User|\WP_Error A `WP_Error` on failure, else pass `$authentication` through.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function wp_authenticate_user($authentication)
		{
			$this->check_arg_types(array('\\WP_User', '\\WP_Error'), func_get_args());

			if(!($authentication instanceof \WP_User)) return $authentication;

			$user = $this->which($authentication->ID); // Get user object (by ID).
			if(!$user->has_id()) return $authentication; // Sanity check.

			if($user->get_option('must_activate'))
				return new \WP_Error( // Activation is required in this case.
					'must_activate', $this->_x('This account has NOT been activated yet. Please check your email for the activation link.')
				);
			if(is_multisite() && !$user->is_super_admin() && !in_array(get_current_blog_id(), array_keys(get_blogs_of_user($user->ID)), TRUE))
				return new \WP_Error( // They do NOT belong on this child blog.
					'invalid_username', $this->_x('Invalid username for this site.')
				);
			return $authentication; // Default return value.
		}
	}
}