#!/usr/bin/env php
<?php
/**
 * XDaRk Core Scripts (Compiler)
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_dev_utilities
{
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/.dev-utilities/core.php';
	compile(!empty($GLOBALS['argv'][1]) && $GLOBALS['argv'][1] === 'all');

	/*
	 * Compile
	 */
	function compile($all = FALSE)
	{
		$core = core(); // Core.
		$core->©env->prep_for_cli_dev_procedure();

		ob_start(); // Open a PHP output buffer.
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-sprintf.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-jq-scrollto.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-jq-sortable.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core-jq-bs.min.js')."\n";
		echo file_get_contents($core->©dir->n_seps_up(__FILE__).'/core.min.js')."\n";
		file_put_contents(dirname(__FILE__).'/core-libs.min.js', trim(ob_get_clean()));
	}
}