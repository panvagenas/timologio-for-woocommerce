<?php
/**
 * Markdown Parser.
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
	 * Markdown Parser.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class markdown extends framework
	{
		/**
		 * Markdown parser object instance (a singleton).
		 *
		 * @var externals\markdown_x
		 */
		public static $parser;

		/**
		 * Parses PHP Markdown syntax.
		 *
		 * @param string $string Markdown syntax string.
		 *
		 * @return string String after having been parsed as PHP Markdown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function parse($string)
		{
			$this->check_arg_types('string', func_get_args());

			if(!isset(static::$parser))
				static::$parser = new externals\markdown_x();

			return static::$parser->transform($string);
		}
	}
}