<?php
/**
 * Header Utilities.
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
	 * Header Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class headers extends framework
	{
		/**
		 * Sends no-cache headers (as supplied by WordPress®).
		 *
		 * @throws exception If headers have already been sent (i.e. output was already started).
		 *    Actually, PHP triggers this warning by itself. Just something to be aware of.
		 */
		public function no_cache()
		{
			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent. Please check hook priorities.')
				);
			if(isset($this->static[__FUNCTION__]))
				return; // Sent already.

			foreach(headers_list() as $_header)
				if(stripos($_header, 'no-cache') !== FALSE)
				{
					$no_cache_header_already_sent_via_php = $_header;
					break; // Stop now (nothing more to look for).
				}
			unset($_header); // A little housekeeping.

			if(!isset($no_cache_header_already_sent_via_php)) nocache_headers();

			$this->static[__FUNCTION__] = TRUE;
		}

		/**
		 * Cleans buffer; sends HTTP status; and Content-Type headers.
		 *
		 * @param integer $status HTTP status code, as integer.
		 *
		 * @param string  $type The Content-Type (i.e. a MIME type).
		 *
		 * @param boolean $is_utf8 Optional. Defaults to a FALSE value.
		 *    If TRUE, we append `; charset=UTF-8` to the `Content-Type` header.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If headers have already been sent (i.e. output was already started).
		 *    Actually, PHP triggers this warning by itself. Just something to be aware of.
		 */
		public function clean_status_type($status, $type, $is_utf8 = FALSE)
		{
			$this->check_arg_types('integer:!empty', 'string:!empty', 'boolean', func_get_args());

			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent. Please check hook priorities.')
				);
			$content_type = 'Content-Type: '.$type.(($is_utf8) ? '; charset=UTF-8' : '');

			$this->©env->ob_end_clean(); // Cleans output buffers.
			status_header($status); // HTTP status header, with status code.
			header($content_type); // Content-Type header (with possible charset).
		}

		/**
		 * Sets `Content-Encoding` header.
		 *
		 * @param string $encoding Type of content-encoding.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If headers have already been sent (i.e. output was already started).
		 *    Actually, PHP triggers this warning by itself. Just something to be aware of.
		 */
		public function content_encoding($encoding)
		{
			$this->check_arg_types('string', func_get_args());

			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent. Please check hook priorities.')
				);
			header('Content-Encoding:'.((isset($encoding[0])) ? ' '.$encoding : ''));
		}

		/**
		 * Sets `Content-Disposition` header.
		 *
		 * @param string $disposition Type of content-disposition.
		 * @param string $filename If `$disposition` is `attachment`; a file basename.
		 *    This is applicable ONLY if with `Content-Disposition: attachment`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If headers have already been sent (i.e. output was already started).
		 *    Actually, PHP triggers this warning by itself. Just something to be aware of.
		 */
		public function content_disposition($disposition, $filename = '')
		{
			$this->check_arg_types('string', func_get_args());

			if(headers_sent())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#headers_sent_already', get_defined_vars(),
					$this->__('Doing it wrong! Headers have already been sent. Please check hook priorities.')
				);
			if($disposition === 'attachment' && $filename)
				$filename = '; filename="'.$this->©string->esc_dq($filename).'"; filename*=UTF-8\'\''.rawurlencode($filename);
			else $filename = ''; // Not applicable in other scenarios.

			header('Content-Disposition: '.$disposition.$filename);
		}
	}
}