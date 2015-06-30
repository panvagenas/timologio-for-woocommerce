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

	class views extends framework {
		/**
		 * @param $callee
		 * @param $file
		 * @param array $viewData
		 * @param bool $echo
		 *
		 * @return string
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function view( &$callee, $file, Array $viewData = null, $echo = false ) {
			( $viewData ) ? extract( $viewData ) : null;

			$this->enqueueScripts( $file );

			ob_start();
			require $this->©dirs_files->view( $file );
			$content = ob_get_clean();
			if ( ! $echo ) {
				return $content;
			}
			echo $content;
			return true;
		}

		/**
		 * @param $viewFile
		 *
		 * @throws exception
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		protected function enqueueScripts( $viewFile ) {
			$styleFilePath  = $this->©dirs_files->view_style( $viewFile );
			$scriptFilePath = $this->©dirs_files->view_scripts( $viewFile );

			if ( ! empty( $styleFilePath ) ) {
				$this->©styles->register( array(
					$this->instance->plugin_root_ns_with_dashes . $this->©string->with_dashes( $viewFile ) . '-style' => array(
						'url'       => $this->©url->to_plugin_dir_file( str_replace( $this->instance->plugin_dir, '', $styleFilePath ) ),
						'ver'       => $this->instance->plugin_version_with_dashes,
						'in_footer' => true
					)
				) );
				$this->©style->enqueue( array( $this->instance->plugin_root_ns_with_dashes . $this->©string->with_dashes( $viewFile ) . '-style' ) );
			}

			if ( ! empty( $scriptFilePath ) ) {
				$this->©script->register( array(
					$this->instance->plugin_root_ns_with_dashes . $this->©string->with_dashes( $viewFile ) . '-script' => array(
						'deps'      => array( 'jquery' ),
						'url'       => $this->©url->to_plugin_dir_file( str_replace( $this->instance->plugin_dir, '', $scriptFilePath ) ),
						'ver'       => $this->instance->plugin_version_with_dashes,
						'in_footer' => true
					)
				) );
				$this->©script->enqueue( array( $this->instance->plugin_root_ns_with_dashes . $this->©string->with_dashes( $viewFile ) . '-script' ) );
			}
		}
	}

}
