<?php
/**
 * XML Utilities.
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
	 * XML Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class xml extends framework
	{
		/**
		 * Gets an XML attribute value.
		 *
		 * @param \SimpleXMLElement $xml A SimpleXMLElement object instance.
		 * @param string            $attribute The name of the attribute we're looking for.
		 *
		 * @return string The value of the attribute, else an empty string on failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function attribute($xml, $attribute)
		{
			$this->check_arg_types('\\SimpleXMLElement', 'string:!empty', func_get_args());

			foreach($xml->attributes() as $_attribute => $_value)
				if(strcasecmp($_attribute, $attribute) === 0)
					return (string)$_value;
			unset($_attribute, $_value);

			return '';
		}

        /**
         * @param $nodesArray
         * @param $childrenKey
         * @param $childrenValue
         *
         * @return null
         * @throws \xd_v141226_dev\exception
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO Enter Product ${VERSION}
         */
        public function locateNodeWithChildrenValue($nodesArray, $childrenKey, $childrenValue){
            $this->check_arg_types('\\SimpleXMLElement', 'string:!empty', 'string:!empty', func_get_args());

            foreach ( $nodesArray as $key => $value ) {
                if($value->$childrenKey == $childrenValue){
                    return $value;
                }
            }
            return null;
        }

        /**
         * @param $filePath
         *
         * @return \SimpleXMLElement
         * @throws exception
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO Enter Product ${VERSION}
         */
        public function getSimpleXMLFromFile($filePath){
            $this->check_arg_types('string:!empty', func_get_args());

            if(!$this->©dir_file->has_extension($filePath, null, 'xml')){
                throw new exception($this, 'exception', NULL, $message = 'File ' . $filePath . ' has no XML extension');
            }
            return simplexml_load_file($filePath);
        }

        /**
         * @param \SimpleXmlIterator $sxi
         * @param null $key
         * @param null $tmp
         *
         * @return null
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO Enter Product ${VERSION}
         */
        protected function sxiToXpath( $sxi, $key = null, &$tmp = null ) {
            $keys_arr = array();
            //get the keys count array
            for ( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
                $sk = $sxi->key();
                if ( array_key_exists( $sk, $keys_arr ) ) {
                    $keys_arr[ $sk ] += 1;
//					$keys_arr[ $sk ] = $keys_arr[ $sk ];
                } else {
                    $keys_arr[ $sk ] = 1;
                }
            }
            //create the xpath
            for ( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
                $sk = $sxi->key();
                if ( ! isset( $$sk ) ) {
                    $$sk = 1;
                }
                if ( $keys_arr[ $sk ] >= 1 ) {
                    $spk             = $sk . '[' . $$sk . ']';
                    $keys_arr[ $sk ] = $keys_arr[ $sk ] - 1;
                    $$sk ++;
                } else {
                    $spk = $sk;
                }
                $kp = $key ? $key . '/' . $spk : '/' . $sxi->getName() . '/' . $spk;
                if ( $sxi->hasChildren() ) {
                    $this->sxiToXpath( $sxi->getChildren(), $kp, $tmp );
                } else {
                    $tmp[ $kp ] = strval( $sxi->current() );
                }
                $at = $sxi->current()->attributes();
                if ( $at ) {
                    $tmp_kp = $kp;
                    foreach ( $at as $k => $v ) {
                        $kp .= '/@' . $k;
                        $tmp[ $kp ] = $v;
                        $kp         = $tmp_kp;
                    }
                }
            }

            return $tmp;
        }

        /**
         * Transform an SimpleXMLElement to Xpath and return it
         *
         * @param $xml
         *
         * @return null|array
         * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
         * @since TODO Enter Product ${VERSION}
         */
        public function xmlToXpath( $xml ) {
            $this->check_arg_types('string:!empty', func_get_args());

            $sxi = new \SimpleXmlIterator( $xml );

            return $this->sxiToXpath( $sxi );
        }
	}
}