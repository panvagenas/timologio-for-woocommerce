<?php

namespace Pan\WcTimologio;

if ( ! defined( 'WPINC' ) ) {
    die;
}

class WcTimologio {
    const META_TIMOLOGIO = 'billing_timologio';

    const META_TIMOLOGIO_Y = 'Y';

    const META_TIMOLOGIO_N = 'N';

    const META_COMPANY = 'billing_company';

    const META_ACTIVITY = 'billing_activity';

    const META_VAT = 'billing_vat';

    const META_DOY = 'billing_doy';

    protected $fields = array(
        self::META_TIMOLOGIO,
        self::META_COMPANY,
        self::META_ACTIVITY,
        self::META_VAT,
        self::META_DOY,
    );

    protected $fieldsNames = array();

    public function __construct() {
        $this->fieldsNames = array(
            self::META_COMPANY  => __( 'Company Name', 'wc-timologio' ),
            self::META_ACTIVITY => __( 'Company Activity', 'wc-timologio' ),
            self::META_VAT      => __( 'VAT Number', 'wc-timologio' ),
            self::META_DOY      => __( 'Public Financial Office', 'wc-timologio' ),
        );
    }

    /**
     * @param $fields
     *
     * @return mixed
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function checkoutFields( $fields ) {
        unset( $fields['billing']['billing_company'] );

        $fields['billing'][ self::META_TIMOLOGIO ] = array(
            'type'        => 'select',
            'label'       => __( 'Invoice', 'wc-timologio' ),
            'placeholder' => _x( 'Invoicing', 'placeholder', 'wc-timologio' ),
            'required'    => false,
            'class'       => array( 'form-row-wide', 'timologio-select' ),
            'clear'       => true,
            'options'     => array(
                self::META_TIMOLOGIO_N => __( 'No', 'wc-timologio' ),
                self::META_TIMOLOGIO_Y => __( 'Yes', 'wc-timologio' ),
            ),
        );

        $fields['billing'][ self::META_COMPANY ] = array(
            'type'     => 'text',
            'label'    => __( 'Company Name', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing'][ self::META_ACTIVITY ] = array(
            'type'     => 'text',
            'label'    => __( 'Company Activity', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing'][ self::META_VAT ] = array(
            'type'     => 'text',
            'label'    => __( 'VAT Number', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing'][ self::META_DOY ] = array(
            'type'     => 'text',
            'label'    => __( 'Public Financial Office', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        return $fields;
    }

    /**
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function checkoutProcess() {
        if ( $this->isTimologioRequest() ) {
            $valid = $this->validateInvoicePostFields();

            if ( count( $valid ) < count( $this->fields ) ) {
                wc_add_notice( __( 'Please fill all invoice fields', 'wc-timologio' ), 'error' );
            }
        }
    }


    /**
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  160130
     */
    protected function isTimologioRequest() {
        return isset( $_POST[ self::META_TIMOLOGIO ] ) && $_POST[ self::META_TIMOLOGIO ] == self::META_TIMOLOGIO_Y;
    }

    /**
     * @return array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    protected function validateInvoicePostFields() {
        if ( ! $this->isTimologioRequest() ) {
            return array();
        }

        $validated = array();
        ini_set( 'display_errors', E_ALL );
        foreach ( $this->fields as $fieldName ) {
            $value = isset( $_POST[ $fieldName ] )
                ? wp_strip_all_tags( wp_check_invalid_utf8( stripslashes( $_POST[ $fieldName ] ) ) )
                : '';
            if ( ! empty( $value ) ) {
                $validated[ $fieldName ] = $value;
            }
        }

        return $validated;
    }

    /**
     * @param $order
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function adminOrderDataAfterBillingAddress( $order ) {
        if ( $this->getOrderMeta( $order->id, self::META_TIMOLOGIO ) != self::META_TIMOLOGIO_Y ) {
            return;
        }

        $data = array();

        foreach ( $this->fields as $fieldName ) {
            if ( $metaValue = $this->getOrderMeta( $order->id, $fieldName ) ) {
                $data[ $fieldName ] = $metaValue;
            }
        }

        unset( $data[ self::META_TIMOLOGIO ] );

        if ( $data ) {
            echo '<p><strong>' . __( 'Company Details', 'wc-timologio' ) . ':</strong></br>';
            foreach ( $data as $fieldKey => $fieldValue ) {
                echo $this->fieldsNames[ $fieldKey ] . ': ' . $fieldValue . '</br>';
            }
        }
    }

    /**
     * @param $fields
     * @param $sent_to_admin
     * @param $order
     *
     * @return array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function emailOrderMetaKeys( $fields, $sent_to_admin, $order ) {
        if ( $this->getOrderMeta( $order->id, self::META_TIMOLOGIO ) != self::META_TIMOLOGIO_Y ) {
            return $fields;
        }

        $data = array();
        foreach ( $this->fields as $fieldName ) {
            if ( $metaValue = $this->getOrderMeta( $order->id, $fieldName ) ) {
                $data[ $fieldName ] = $metaValue;
            }
        }

        unset( $data[ self::META_TIMOLOGIO ] );

        if ( $data ) {
            foreach ( $data as $k => $v ) {
                $fields[] = array(
                    'label' => $this->fieldsNames[ $k ],
                    'value' => $v,
                );
            }
        }

        return $fields;
    }

    public function timologioIconToOrderNotesCol( $column ) {
        if ( $column == 'order_notes' ) {
            global $post;

            $timologio = $this->getOrderMeta( $post->ID, self::META_TIMOLOGIO );

            if ( $timologio && $timologio === WcTimologio::META_TIMOLOGIO_Y ) {
                echo '<span class="dashicons dashicons-format-aside" style="margin-top:5px;"></span>';
            }
        }
    }

    protected function getOrderMeta( $orderId, $fieldName, $type = 'billing' ) {
        $fieldName = str_replace( array( 'billing_', 'shipping_', '_billing_', '_shipping_' ), '', $fieldName );
        $type      = $type == 'billing' ? '_billing_' : '_shipping_';

        return get_post_meta( $orderId, $type . $fieldName, true );
    }
}