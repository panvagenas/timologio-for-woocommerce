<?php
/**
 * Project: woocommerce-timologio
 * File: initializer.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 30/6/2015
 * Time: 2:45 μμ
 * Since: 150630
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace timologio;


class initializer extends \xd_v141226_dev\initializer {
	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	public function after_setup_theme_hooks() {
		$this->add_action('wp_loaded', '©initializer.wcInit');
	}

	/**
	 * @throws \xd_v141226_dev\exception
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	public function wcInit(){
			$this->add_action( 'woocommerce_checkout_fields', '©timologio.checkoutFields' );
			$this->add_action( 'woocommerce_checkout_process', '©timologio.checkoutProcess' );
			$this->add_action( 'woocommerce_checkout_update_order_meta', '©timologio.updateOrderMeta' );

			$this->©script->register( array(
					$this->instance->plugin_root_ns_with_dashes . '--checkout' => array(
						'deps' => array( 'jquery'),
						'url'  => $this->©url->to_plugin_dir_file( 'assets/js/checkout.min.js' ),
						'ver'  => $this->instance->plugin_version_with_dashes
					)
				)
			);
			$this->©script->enqueue($this->instance->plugin_root_ns_with_dashes . '--checkout');

		if ( is_admin() ) {
			$this->add_action( 'woocommerce_admin_order_data_after_billing_address',
				'©timologio.adminOrderDataAfterBillingAddress' );
		}

		$this->add_filter( 'woocommerce_email_order_meta_fields', '©timologio.emailOrderMetaKeys', 100, 3 );

		load_plugin_textdomain('wc-timologio');
	}
}