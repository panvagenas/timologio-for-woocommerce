<?php
/**
 * Project: woocommerce-timologio
 * File: timologio.php
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 30/6/2015
 * Time: 2:46 μμ
 * Since: 150630
 * Copyright: 2015 Panagiotis Vagenas
 */

namespace timologio;


class timologio extends framework {
	protected $fields = array(
		'timologio_company_name',
		'timologio_field',
		'timologio_vat_number',
		'timologio_doy',
	);

	protected $fieldsNames = array();

	public function __construct($instance){
		parent::__construct($instance);

		$this->fieldsNames = array(
			'timologio_company_name' => __( 'Company Name', 'wc-timologio' ),
			'timologio_field' => __( 'Drastiriotita', 'wc-timologio' ),
			'timologio_vat_number' => __( 'VAT Number', 'wc-timologio' ),
			'timologio_doy' => __( 'DOY', 'wc-timologio' ),
		);
	}

	/**
	 * @param $fields
	 *
	 * @return mixed
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	public function checkoutFields( $fields ) {
		$fields['billing']['timologio'] = array(
			'type'        => 'select',
			'label'       => __( 'Invoice', 'wc-timologio' ),
			'placeholder' => _x( 'Invoicing', 'placeholder', 'wc-timologio' ),
			'required'    => false,
			'class'       => array( 'form-row-wide', 'timologio-select' ),
			'clear'       => true,
			'options'     => array(
				__( 'No', 'wc-timologio' ),
				__( 'Yes', 'wc-timologio' )
			)
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
			'label'    => __( 'Drastiriotita', 'wc-timologio' ),
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
			'label'    => __( 'DOY', 'wc-timologio' ),
			'required' => false,
			'class'    => array( 'form-row-wide', 'timologio-hide' ),
			'clear'    => true,
		);

		return $fields;
	}

	/**
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	public function checkoutProcess() {
		if ( $this->©var->_POST( 'timologio' ) ) {
			$valid = $this->validateInvoicePostFields();

			if ( ! $valid ) {
				wc_add_notice( __( 'Please fill all invoice fields', 'wc-timologio' ), 'error' );
			}
		}
	}

	/**
	 * @param $orderId
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	public function updateOrderMeta( $orderId ) {
		if ( $this->©var->_POST( 'timologio' ) ) {
			$data = $this->validateInvoicePostFields();

			if ( $data ) {
				foreach ( $data as $k => $v ) {
					update_post_meta( $orderId, $k, $v );
				}
			}
		}
	}

	/**
	 * @return array
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
	 */
	protected function validateInvoicePostFields() {
		$timologio_company_name = (string) $this->©var->_POST( 'timologio_company_name' );
		$timologio_field        = (string) $this->©var->_POST( 'timologio_field' );
		$timologio_vat_number   = (string) $this->©var->_POST( 'timologio_vat_number' );
		$timologio_doy          = (string) $this->©var->_POST( 'timologio_doy' );

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
	 * @param $order
	 *
	 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
	 * @since 150630
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
	 * @since 150630
	 */
	public function emailOrderMetaKeys( $fields, $sent_to_admin, $order ) {
		$data = array();
		foreach ( $this->fields as $fieldName ) {
			if ( $metaValue = get_post_meta( $order->id, $fieldName, true ) ) {
				$data[$fieldName] = $metaValue;
			}
		}

		if($data){
			foreach ( $data as $k => $v ) {
				$fields[] = array(
					'label' => $this->fieldsNames[$k],
					'value' => $v,
				);
			}

		}

		return $fields;
	}
}