<?php
/**
 * Project: woocommerce-timologio
 * File: framework.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 30/6/2015
 * Time: 2:44 μμ
 * Since: 150630
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace timologio;

if (!defined('WPINC')) {
	die;
}
require_once dirname(dirname(dirname(__FILE__))).'/core/stub.php';

class framework extends \xd__framework{

}

$GLOBALS[__NAMESPACE__] = new framework(
	array(
		'plugin_root_ns' => __NAMESPACE__, // The root namespace
		'plugin_var_ns'  => 'tml',
		'plugin_cap'     => 'manage_options',
		'plugin_name'    => 'WooCommerce Timologio',
		'plugin_version' => '150630',
		'plugin_site'    => 'https://github.com/panvagenas/woocommerce-timologio',
		'plugin_dir'     => dirname(dirname(dirname(__FILE__)))
	)
);