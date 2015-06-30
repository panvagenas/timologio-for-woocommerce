<?php
/**
 * Captchas.
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
	 * Captchas.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class captchas extends framework
	{
		/**
		 * Verifies a Google® reCAPTCHA™ code.
		 *
		 * @param string $challenge The value of `recaptcha_challenge_field` during form submission.
		 * @param string $response The value of `recaptcha_response_field` during form submission.
		 *
		 * @return boolean true if `$response` is valid.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function code_validates($challenge, $response)
		{
			$this->check_arg_types('string', 'string', func_get_args());

			if(!$challenge || !$response)
				return FALSE;

			$post_vars = array(
				'privatekey' => $this->©options->get('captchas.google.private_key'),
				'remoteip'   => $this->©env->ip(),
				'challenge'  => $challenge,
				'response'   => $response
			);
			$response  = trim($this->©url->remote('http://www.google.com/recaptcha/api/verify', $post_vars));

			return (preg_match('/^true/i', $response)) ? TRUE : FALSE;
		}

		/**
		 * Builds HTML markup that produces a Google® reCAPTCHA™ box.
		 *
		 * @param string $theme Optional. Theme used in display. Defaults to `clean`.
		 *
		 * @param string $tabindex Optional. Value of `tabindex=""` attribute. Defaults to `-1`.
		 *
		 * @param string $error Optional. An error message to display.
		 *
		 * @return string HTML markup that produces a Google® reCAPTCHA™ box.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function markup($theme = 'clean', $tabindex = -1, $error = '')
		{
			$this->check_arg_types('string', 'integer', 'string', func_get_args());

			$theme = ($theme) ? $theme : 'clean'; // Default theme value.

			// Builds reCAPTCHA™ options.

			$recaptcha_options = '<script type="text/javascript">';
			$recaptcha_options .= '/*<![CDATA[*/';
			$recaptcha_options .= "'use strict';";

			$recaptcha_options .= "var RecaptchaOptions = RecaptchaOptions || {";
			$recaptcha_options .= "theme:'".$this->©string->esc_js_sq($theme)."',";
			$recaptcha_options .= "lang:'".$this->©string->esc_js_sq($this->_x('en', 'google-recaptcha-lang-code'))."',";
			$recaptcha_options .= "tabindex:".$tabindex.",";
			$recaptcha_options = rtrim($recaptcha_options, ',').'};';

			$recaptcha_options .= '/*]]>*/';
			$recaptcha_options .= '</script>';

			// Builds reCAPTCHA™ script `src` value.

			$recaptcha_script_src = 'https://www.google.com/recaptcha/api/challenge?';
			$recaptcha_script_src .= 'k='.urlencode($this->©options->get('captchas.google.public_key'));
			$recaptcha_script_src .= ($error) ? '&error='.urlencode($error) : '';

			// Builds additional JavaScript routines for our reCAPTCHA™ implementation.

			$other_custom_js = '<script type="text/javascript">';
			$other_custom_js .= '/*<![CDATA[*/';
			$other_custom_js .= "'use strict';";

			$other_custom_js .= "if(typeof jQuery === 'function')";
			$other_custom_js .= "jQuery('table#recaptcha_table a').removeAttr('tabindex');";

			$other_custom_js .= '/*]]>*/';
			$other_custom_js .= '</script>';

			// Put everything together now, and return.

			return $this->apply_filters('recaptcha_options', $recaptcha_options, get_defined_vars()).
			       '<script type="text/javascript" src="'.esc_attr($recaptcha_script_src).'"></script>'.
			       $this->apply_filters('other_custom_js', $other_custom_js, get_defined_vars());
		}
	}
}