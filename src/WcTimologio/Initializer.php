<?php

namespace Pan\WcTimologio;

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Initializer {
    protected $pluginFile;

    public function __construct( $pluginFile ) {
        $this->pluginFile = $pluginFile;
    }

    public function wpLoaded() {
        $timologio = new WcTimologio();

        add_action( 'woocommerce_checkout_fields', array( $timologio, 'checkoutFields' ) );
        add_action( 'woocommerce_checkout_process', array( $timologio, 'checkoutProcess' ) );
        add_action( 'woocommerce_checkout_update_order_meta', array( $timologio, 'updateOrderMeta' ) );

        add_action( 'manage_shop_order_posts_custom_column', array( $timologio, 'timologioIconToOrderNotesCol' ), 2 );

        $scriptUrl = plugins_url( 'assets/js/checkout.min.js', $this->pluginFile );
        add_action('wp_enqueue_scripts', function() use ($scriptUrl){
            if(is_cart() || is_checkout()){
                wp_enqueue_script( 'wc-timologio', $scriptUrl, array('jquery'), false, true);
            }
        });


        if ( is_admin() ) {
            add_action(
                'woocommerce_admin_order_data_after_billing_address',
                array( $timologio, 'adminOrderDataAfterBillingAddress' )
            );
        }

        add_filter( 'woocommerce_email_order_meta_fields', array( $timologio, 'emailOrderMetaKeys' ), 100, 3 );

        load_plugin_textdomain(
            'wc-timologio'
            ,
            false,
            trailingslashit(dirname(plugin_basename($this->pluginFile))) . 'translations'
        );
    }
}