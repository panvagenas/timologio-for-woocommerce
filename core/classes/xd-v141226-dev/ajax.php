<?php
/**
 * Project: core
 * File: ${FILE_NAME}
 * User: Panagiotis Vagenas <pan.vagenas@gmail.com>
 * Date: 4/12/2014
 * Time: 8:39 πμ
 * Since: TODO ${VERSION}
 * Copyright: 2014 Panagiotis Vagenas
 */

namespace xd_v141226_dev;
{

	if ( ! defined( 'WPINC' ) ) {
		exit( 'Do NOT access this file directly: ' . basename( __FILE__ ) );
	}

	class ajax extends framework {
		/**
		 * @param $response
		 * @param int $responseCode
		 *
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONResult($response, $responseCode = 200){
			$this->©header->clean_status_type( $responseCode, 'application/json' );
			echo json_encode( $response );
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
				wp_die();
			else
				die;
		}

		/**
		 * @param $data
		 * @param int $responseCode
		 *
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONError($data, $responseCode = 400){
			$this->sendJSONResult(array('data' => $data, 'success' => false), $responseCode);
		}

		/**
		 * @param $data
		 * @param int $responseCode
		 *
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function sendJSONSuccess($data, $responseCode = 200){
			$this->sendJSONResult(array('data' => $data, 'success' => true), $responseCode);
		}
	}

}
