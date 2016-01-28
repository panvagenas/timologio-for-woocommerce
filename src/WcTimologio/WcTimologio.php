<?php

namespace Pan\WcTimologio;

if ( ! defined( 'WPINC' ) ) {
    die;
}

class WcTimologio {
    protected $fields = array(
        'timologio_company_name',
        'timologio_field',
        'timologio_vat_number',
        'timologio_doy',
    );

    protected $fieldsNames = array();

    public function __construct() {
        $this->fieldsNames = array(
            'timologio_company_name' => __( 'Company Name', 'wc-timologio' ),
            'timologio_field'        => __( 'Company Activity', 'wc-timologio' ),
            'timologio_vat_number'   => __( 'VAT Number', 'wc-timologio' ),
            'timologio_doy'          => __( 'Public Financial Office', 'wc-timologio' ),
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
        unset($fields['billing']['billing_company']);

        $fields['billing']['timologio'] = array(
            'type'        => 'select',
            'label'       => __( 'Invoice', 'wc-timologio' ),
            'placeholder' => _x( 'Invoicing', 'placeholder', 'wc-timologio' ),
            'required'    => false,
            'class'       => array( 'form-row-wide', 'timologio-select' ),
            'clear'       => true,
            'options'     => array(
                __( 'No', 'wc-timologio' ),
                __( 'Yes', 'wc-timologio' ),
            ),
        );

        $fields['billing']['timologio_company_name'] = array(
            'type'     => 'text',
            'label'    => __( 'Company Name', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing']['timologio_field'] = array(
            'type'     => 'text',
            'label'    => __( 'Company Activity', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing']['timologio_vat_number'] = array(
            'type'     => 'text',
            'label'    => __( 'VAT Number', 'wc-timologio' ),
            'required' => false,
            'class'    => array( 'form-row-wide', 'timologio-hide' ),
            'clear'    => true,
        );

        $fields['billing']['timologio_doy'] = array(
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
        if ( isset( $_POST['timologio'] ) && $_POST['timologio'] == 1 ) {
            $valid = $this->validateInvoicePostFields();

            if ( ! $valid ) {
                wc_add_notice( __( 'Please fill all invoice fields', 'wc-timologio' ), 'error' );
            }
        }
    }

    /**
     * @return array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    protected function validateInvoicePostFields() {
        $timologio_company_name = (string) $_POST['timologio_company_name'];
        $timologio_field        = (string) $_POST['timologio_field'];
        $timologio_vat_number   = (string) $_POST['timologio_vat_number'];
        $timologio_doy          = (string) $_POST['timologio_doy'];

        $data = compact( 'timologio_company_name', 'timologio_field', 'timologio_vat_number', 'timologio_doy' );

        $valid = true;
        foreach ( $data as &$value ) {
            $value = strip_tags( $value );
            $value = trim( $value );
            $valid &= ! empty( $value );
        }

        return $valid ? $data : array();
    }

    /**
     * @param $orderId
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function updateOrderMeta( $orderId ) {
        if ( isset( $_POST['timologio'] ) ) {
            $data = $this->validateInvoicePostFields();

            if ( $data ) {
                foreach ( $data as $k => $v ) {
                    update_post_meta( $orderId, $k, $v );
                }
            }
        }
    }

    /**
     * @param $order
     *
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since  151229
     */
    public function adminOrderDataAfterBillingAddress( $order ) {
        $data = array();

        foreach ( $this->fields as $fieldName ) {
            if ( $metaValue = get_post_meta( $order->id, $fieldName, true ) ) {
                $data[ $fieldName ] = $metaValue;
            }
        }

        if ( $data ) {
            echo '<p><strong>' . __( 'Company Details', 'wc-timologio' ) . ':</strong></br>';
            foreach ( $data as $fieldKey => $fieldValue ) {
                echo $fieldValue . '</br>';
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
        $data = array();
        foreach ( $this->fields as $fieldName ) {
            if ( $metaValue = get_post_meta( $order->id, $fieldName, true ) ) {
                $data[ $fieldName ] = $metaValue;
            }
        }

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
}