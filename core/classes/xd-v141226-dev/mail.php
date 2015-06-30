<?php
/**
 * Mail.
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
	 * Mail.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class mail extends framework
	{
		/**
		 * Sends email to a list of recipients.
		 *
		 * @param array $mail A mail configuration array.
		 *
		 *    Possible configuration elements include:
		 *
		 *     • `subject` (string, NOT empty).
		 *     • `message` (string, NOT empty).
		 *
		 *     • `from_addr` (string, NOT empty).
		 *     • `from_name` (string, optional from name).
		 *
		 *     • `recipients` (string|array, NOT empty).
		 *       Strings may contain multiple email addresses (comma or semicolon separated); which this routine parses into an array.
		 *       NOTE: Emails are ALWAYS sent ONE at a time; making the concept of CC/BCC addresses irrelevant.
		 *
		 *    • `headers` (string|array, optional). A custom header string, or an array of custom header strings.
		 *       All header strings are self-contained. We do NOT support any special array elements here.
		 *       Example: `Header: value` (where each string is an email header).
		 *
		 *     • `attachments` (string|array, optional). An absolute file path, or an array of absolute file paths.
		 *       File paths can be absolute, or relative to the current WordPress® `ABSPATH`; if that is easier.
		 *
		 *       Or, this can also be an array of attachment configurations.
		 *          Possible attachment configuration elements include.
		 *             • `path` (absolute or relative server path to a file, NOT empty).
		 *             • `name` (optional string name for this file, defaults to `basename()`).
		 *             • `encoding` (optional string encoding type, defaults to `base64`).
		 *             • `mime_type` (optional string MIME type, defaults to `application/octet-stream`).
		 *
		 * @return boolean|errors TRUE if mail was sent successfully.
		 *    Else this returns an `errors` object instance.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If required configuration elements are missing and/or invalid.
		 */
		public function send($mail)
		{
			$this->check_arg_types('array:!empty', func_get_args());

			// Load PHPMailer classes (if NOT already loaded).

			if(!class_exists('\\PHPMailer'))
				require_once ABSPATH.WPINC.'/class-phpmailer.php';
			if(!class_exists('\\SMTP')) require_once ABSPATH.WPINC.'/class-smtp.php';

			$default_mail_args = array(
				'from_addr'   => '', // Required.
				'subject'     => '', // Required.
				'message'     => '', // Required.
				'recipients'  => '', // Required (string|array).
				'attachments' => '', // Optional (string|array).
				'headers'     => '', // Optional (string|array).
				'from_name'   => '' // Optional from name.
			);
			$mail              = $this->check_extension_arg_types(
				'string:!empty', 'string:!empty', 'string:!empty', array('string:!empty', 'array:!empty'),
				array('string', 'array'), array('string', 'array'), 'string', $default_mail_args, $mail, 4
			);
			$mail['from_addr'] = apply_filters('wp_mail_from', $mail['from_addr']);
			$mail['from_name'] = apply_filters('wp_mail_from_name', $mail['from_name']);

			// Recipients are always parsed into an array here.
			if(!($mail['recipients'] = $this->parse_emails_deep($mail['recipients'])))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#recipients_missing', get_defined_vars(),
					$this->__('Email failure. Missing and/or invalid `recipients` value.')
				);
			// Possible header(s).
			if($this->©string->is_not_empty($mail['headers']))
				$mail['headers'] = array($mail['headers']);
			$this->©array->isset_or($mail['headers'], array(), TRUE);

			// Standardize/validate each header.
			foreach($mail['headers'] as $_header)
				if(!$this->©string->is_not_empty($_header))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#header_missing', get_defined_vars(),
						$this->__('Email failure. Missing and/or invalid `header`.').
						' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_header))
					);
			unset($_header); // Just a little housekeeping.

			// Possible file attachment(s).
			if($this->©string->is_not_empty($mail['attachments']))
				$mail['attachments'] = array($mail['attachments']);
			$this->©array->isset_or($mail['attachments'], array(), TRUE);

			// Standardize/validate each attachment.
			foreach($mail['attachments'] as &$_attachment)
			{
				if(!is_array($_attachment))
					$_attachment = array('path' => $_attachment);

				if(!$this->©string->is_not_empty($_attachment['path']))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#attachment_path_missing', get_defined_vars(),
						$this->__('Email failure. Missing and/or invalid attachment `path` value.').
						' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_attachment))
					);
				if(!is_file($_attachment['path'])) // Perhaps relative?
					if(!is_file(ABSPATH.$_attachment['path']))
						throw $this->©exception(
							$this->method(__FUNCTION__).'#nonexistent_attachment_path', get_defined_vars(),
							$this->__('Email failure. Nonexistent attachment `path` value.').
							' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($_attachment))
						);
					else $_attachment['path'] = ABSPATH.$_attachment['path'];

				if(!$this->©string->is_not_empty($_attachment['name']))
					$_attachment['name'] = basename($_attachment['path']);

				if(!$this->©string->is_not_empty($_attachment['encoding']))
					$_attachment['encoding'] = 'base64'; // Default encoding.

				if(!$this->©string->is_not_empty($_attachment['mime_type']))
					$_attachment['mime_type'] = $this->©file->mime_type($_attachment['path']);
			}
			unset($_attachment); // Just a little housekeeping.

			try // PHPMailer (catch exceptions).
			{
				$mailer = new \PHPMailer(TRUE);

				$mailer->IsMail();
				$mailer->SingleTo = TRUE;
				$mailer->CharSet  = 'UTF-8';
				$mailer->Subject  = $mail['subject'];

				$mailer->SetFrom($mail['from_addr'], $mail['from_name']);

				foreach($mail['recipients'] as $_recipient_addr)
					$mailer->AddAddress($_recipient_addr);
				unset($_recipient_addr);

				foreach($mail['headers'] as $_header)
					$mailer->AddCustomHeader($_header);
				unset($_header); // Housekeeping.

				if(!$this->©string->is_html($mail['message']))
					$mail['message'] = nl2br(esc_html($mail['message']));
				$mailer->MsgHTML($mail['message']);

				foreach($mail['attachments'] as $_attachment)
					$mailer->AddAttachment($_attachment['path'], $_attachment['name'],
					                       $_attachment['encoding'], $_attachment['mime_type']);
				unset($_attachment); // Housekeeping.

				if($this->©option->get('mail.smtp')) // Use SMTP server?
				{
					$mailer->IsSMTP(); // Flag for SMTP use in this case.

					$mailer->SMTPSecure = $this->©option->get('mail.smtp.secure');
					$mailer->Host       = $this->©option->get('mail.smtp.host');
					$mailer->Port       = (integer)$this->©option->get('mail.smtp.port');

					$mailer->SMTPAuth = (boolean)$this->©option->get('mail.smtp.username');
					$mailer->Username = $this->©option->get('mail.smtp.username');
					$mailer->Password = $this->©option->get('mail.smtp.password');

					if($this->©option->get('mail.smtp.force_from') && $this->©option->get('mail.smtp.from_addr'))
						$mailer->SetFrom($this->©option->get('mail.smtp.from_addr'), $this->©option->get('mail.smtp.from_name'));
				}
				do_action('phpmailer_init', $mailer); // WP Mail SMTP, and others like it need this.

				$mailer->Send(); // Send this email message.
			}
			catch(\phpmailerException $exception)
			{
				return $this->©error($this->method(__FUNCTION__), get_defined_vars(), $exception->getMessage());
			}
			catch(\exception $exception)
			{
				return $this->©error($this->method(__FUNCTION__), get_defined_vars(), $exception->getMessage());
			}
			return TRUE; // Default return value.
		}

		/**
		 * Parses email addresses (deeply).
		 *
		 * @note This is a recursive scan running deeply into multiple dimensions of arrays/objects.
		 * @note This routine will usually NOT include private, protected or static properties of an object class.
		 *    However, private/protected properties *will* be included, if the current scope allows access to these private/protected properties.
		 *    Static properties are NEVER considered by this routine, because static properties are NOT iterated by `foreach()`.
		 *
		 * @param mixed   $value Any value can be converted into a string that may form an email address.
		 *    Actually, objects can't, but this recurses into objects.
		 *
		 * @param boolean $strict Optional. Defaults to FALSE (faster). Parses all strings w/ `@` signs.
		 *    If TRUE, we will validate each address; and we ONLY return 100% valid email addresses.
		 *
		 * @param boolean $___recursion Internal use only (indicates function recursion).
		 *
		 * @return array Unique array of all parsed email addresses (lowercase).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function parse_emails_deep($value, $strict = FALSE, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for initial caller.
				$this->check_arg_types('', 'boolean', 'boolean', func_get_args());

			$emails = array(); // Initialize array of email addresses.

			if(is_array($value) || is_object($value))
			{
				foreach($value as $_value) // Collect all emails.
					$emails = array_merge($emails, $this->parse_emails_deep($_value, $strict, TRUE));
				unset($_value); // A little housekeeping.

				return array_unique($emails);
			}
			$value                       = strtolower((string)$value);
			$delimiter                   = (strpos($value, ';') !== FALSE) ? ';' : ',';
			$regex_delimitation_splitter = '/'.preg_quote($delimiter, '/').'+/';

			$possible_addresses = preg_split($regex_delimitation_splitter, $value, NULL, PREG_SPLIT_NO_EMPTY);
			$possible_addresses = $this->©strings->trim_deep($possible_addresses);

			foreach($possible_addresses as $_address) // Iterate all possible addresses.
			{
				if(strpos($_address, '@') === FALSE) continue; // NOT an address.

				if(strpos($_address, '<') !== FALSE && preg_match('/\<(?P<address_in_brackets>.+?)\>/', $_address, $_m))
					if(strpos($_m['address_in_brackets'], '@') !== FALSE && (!$strict || is_email($_m['address_in_brackets'])))
					{
						$emails[] = $_m['address_in_brackets'];
						continue; // Inside brackets; all done here.
					}
				if(!$strict || is_email($_address)) $emails[] = $_address;
			}
			unset($_address, $_m); // Housekeeping.

			return array_unique($emails);
		}
	}
}