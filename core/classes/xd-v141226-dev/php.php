<?php
/**
 * PHP Evaluation.
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
	 * PHP Evaluation.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class php extends framework
	{
		/**
		 * Evaluates PHP code.
		 *
		 * @return string {@inheritdoc}
		 *
		 * @note This variation defaults `$no_tags` to a TRUE value.
		 * @see evaluate() Defaults `$no_tags` to a FALSE value.
		 * @inheritdoc evaluate()
		 */
		public function ¤eval($string, $vars = array(), $no_tags = TRUE)
		{
			return $this->evaluate($string, $vars, $no_tags);
		}

		/**
		 * Evaluates PHP code.
		 *
		 * @param string  $string String (possibly containing PHP tags).
		 *    If `$pure_php` is TRUE; this should NOT have PHP tags.
		 *
		 * @param array   $vars An array of variables to bring into the scope of evaluation.
		 *    This is optional. It defaults to an empty array.
		 *
		 * @param boolean $no_tags Defaults to a FALSE value.
		 *    If this is TRUE, the input `$string` should NOT include PHP tags.
		 *
		 * @return string Output string after having been evaluated by PHP.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to evaluate, according to `can_evaluate()`.
		 *
		 * @note This variation defaults `$pure_php` to a FALSE value.
		 * @see exec() Which defaults `$pure_php` to a TRUE value.
		 */
		public function evaluate($string, $vars = array(), $no_tags = FALSE)
		{
			$this->check_arg_types('string', 'array', 'boolean', func_get_args());

			if(!isset($string[0])) return ''; // Empty.

			if($vars) extract($vars, EXTR_PREFIX_SAME, 'xps');

			if($this->©function->is_possible('eval'))
			{
				ob_start();
				if($no_tags) eval($string);
				else // Mixed content in this case.
					eval('?>'.$string.'<?php ');
				return ob_get_clean();
			}
			// Otherwise, let's do a little explaining here.

			throw $this->©exception(
				$this->method(__FUNCTION__).'#eval_missing', get_defined_vars(),
				$this->__( // Let's do a little explaining here. Why do we NEED `eval()`?
					'The PHP `eval()` function (an application requirement) has been disabled on this server.'.
					' Please check with your hosting provider to resolve this issue and have the PHP `eval()` function enabled.').
				' '.$this->__('The use of `eval()` in this software is limited to areas where it is absolutely necessary to achieve a desired functionality.'.
				              ' For instance, where PHP code is supplied by a site owner (or by their developer) to achieve advanced customization through a UI panel. This can be evaluated at runtime to allow for the inclusion of PHP conditionals or dynamic values.'.
				              ' In cases such as these, the PHP `eval()` function serves a valid/useful purpose. This does NOT introduce a vulnerability, because the code being evaluated has actually been introduced by the site owner (e.g. the PHP code can be trusted in this case).'.
				              ' This software may also use `eval()` to generate dynamic classes and/or API functions for developers; where the use of `eval()` again serves a valid/useful purpose; and where the underlying code was packaged by the software vendor (e.g. the PHP code can be trusted).'
				)
			);
		}

		/**
		 * Hilites PHP code, and also shortcodes.
		 *
		 * @param string $string Input string to be hilited.
		 *
		 * @return string The hilited string.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function hilite($string)
		{
			$this->check_arg_types('string', func_get_args());

			$string = highlight_string($string, TRUE);
			$string = $this->©string->replace_once('<code>', '<code class="hilite">', $string);

			return preg_replace_callback('/(?P<shortcode>\[[^\]]+\])/', array($this, '_hilite_shortcodes'), $string);
		}

		/**
		 * Callback handler for hiliting WordPress® Shortcodes.
		 *
		 * @param array $m An array of regex matches.
		 *
		 * @return string Hilited shortcode.
		 *
		 * @throws exception If invalid types are passed through arguments list (disabled).
		 */
		protected function _hilite_shortcodes($m)
		{
			// Commenting this out for performance.
			// This is used as a callback for `preg_replace()`, so it's NOT absolutely necessary.
			// $this->check_arg_types('array', func_get_args());

			return '<span style="color:#946201;">'.$m[0].'</span>';
		}

		/**
		 * Strip whitespace from a PHP string or source file.
		 *
		 * @note This is here because PHP's `php_strip_whitespace()` suffers from a memory leak
		 *    in PHP v5.6.0beta1. The PHP variation also depends upon output buffering. This is better.
		 *
		 * @param string  $input The input string/file to strip whitespace from.
		 * @param boolean $input_file Optional. Defaults to a `FALSE` value.
		 *    Set this to `TRUE` if `$input` is a file path.
		 *
		 * @return string PHP source code. No comments; minimum whitespace.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$input_file` is TRUE; but `$input` is NOT actually a file.
		 * @throws exception If `$input_file` is TRUE; but `$input` does NOT have a PHP extension.
		 */
		public function strip_whitespace($input, $input_file = FALSE)
		{
			$this->check_arg_types('string:!empty', 'boolean', func_get_args());

			input_file: // Strip whitespace from file.

			if(!$input_file) goto strip_whitespace;

			$file = $input; // Treat as a file path.
			$file = $this->©dir->n_seps($file);

			if(!is_file($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_source', get_defined_vars(),
					sprintf($this->__('Unable to strip whitespace in: `%1$s`.'), $file).
					' '.$this->__('This is NOT an existing file.')
				);
			if(!is_readable($file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					sprintf($this->__('Unable to strip whitespace in this file: `%1$s`.'), $file).
					' '.$this->__('Possible permission issues. This file is not readable.')
				);
			if($this->©file->extension($file) !== 'php')
				throw $this->©exception(
					$this->method(__FUNCTION__).'#extension_not_php', get_defined_vars(),
					sprintf($this->__('Unable to strip whitespace in: `%1$s`.'), $file).
					' '.$this->__('This is NOT a PHP file; i.e. it does not have a `.php` extension.')
				);
			$input = file_get_contents($file);

			strip_whitespace: // Strip whitespace now.

			$stripped = ''; // Initialize stripped value.

			foreach(token_get_all($input) as $_token)
			{
				switch(($_is_array = is_array($_token)) ? $_token[0] : NULL)
				{
					case T_COMMENT:
					case T_DOC_COMMENT:
						break;

					case T_WHITESPACE:
						if(empty($_whitespace))
							$stripped .= ' ';
						$_whitespace = TRUE;
						break;

					default: // Everything else.
						$_whitespace = FALSE;
						$stripped .= $_is_array ? $_token[1] : $_token;
						break;
				}
			}
			unset($_token, $_is_array, $_whitespace); // Housekeeping.

			return $stripped; // No comments; minimunm whitespace.
		}
	}
}