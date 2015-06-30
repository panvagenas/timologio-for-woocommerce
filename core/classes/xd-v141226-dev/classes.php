<?php
/**
 * Classes.
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
	 * Classes.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class classes extends framework
	{
		/**
		 * Details about all XDaRk Core (and plugin) classes/properties/methods.
		 *
		 * @param string|array $details Defaults to `array('class_doc_blocks')`.
		 *
		 *    Possible inclusions/exclusions (e.g. values passed in the `$details` array).
		 *
		 *       • `all` Include everything possible? This will also make it possible for you to use exclusions.
		 *             If (and only if) `all` is passed in, specific details can be excluded by `!`negating details.
		 *             Example: `array('all', '!properties')` ~ indicating `all` details EXCEPT `properties`.
		 *
		 *       Or, if you want to be absolutely specific, you can pass these detail values individually.
		 *          However, please NOTE that if new details are made possible (and you've requested only these specific details);
		 *          you will NOT get any of the new details made possible as this method is improved over time.
		 *
		 *       • `class_doc_blocks` Includes all class doc blocks.
		 *
		 *       • `properties` Includes all class properties.
		 *       • `property_doc_blocks` Includes all class property doc blocks.
		 *             Only applicable if `properties` are requested.
		 *
		 *       • `methods` Includes all class methods.
		 *       • `method_doc_blocks` Includes all class method doc blocks.
		 *             Only applicable if `methods` are requested.
		 *       • `method_parameters` Includes all class method parameters.
		 *             Only applicable if `methods` are requested.
		 *
		 * @return array Details about all XDaRk Core (and plugin) classes/properties/methods.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function get_details($details = array('class_doc_blocks'))
		{
			$this->check_arg_types(array('string', 'array'), func_get_args());

			$details  = (array)$details; // Force array value.
			$ns_class = $ns_class_details = array(); // Initialize arrays.

			# Handle `$details` array (w/ `all` inclusions/exclusions).

			if(in_array('all', $details)) // Including all details?
			{
				$_details = array();

				foreach(array('class_doc_blocks',
				              'properties', 'property_doc_blocks',
				              'methods', 'method_doc_blocks', 'method_parameters') as $_detail)
				{
					if(!in_array('!'.$_detail, $details, TRUE))
						$_details[] = $_detail;
				}
				$details = $_details; // Use the new array.
				unset($_details); // Just a little housekeeping.
			}
			if(empty($details)) return $ns_class_details; // No details?

			# Include all plugin classes (if this is NOT the XDaRk Core itself).

			if(!$this->©plugin->is_core()) // Should we include a plugin's classes here too?
			{
				$ns_class[] = '\\'.$this->instance->plugin_root_ns; // API class.

				foreach($this->©dir->iteration($this->instance->plugin_classes_dir) as $_dir_file)
					if($_dir_file->isFile()) // We're dealing only with class files here.
					{
						$_file_sub_path = $this->©dir->n_seps($_dir_file->getSubPathname());
						$_ns_class_path = '\\'.str_replace(array('/', '-'), array('\\', '_'), preg_replace('/\.php$/i', '', $_file_sub_path));

						if(class_exists($_ns_class_path) || interface_exists($_ns_class_path) || ($this->©function->is_possible('trait_exists') && trait_exists($_ns_class_path)))
							$ns_class[] = $_ns_class_path;
					}
				unset($_dir_file, $_file_sub_path, $_ns_class_path); // Housekeeping.
			}

			# XDaRk Core classes (all plugins inherit these core classes).

			$ns_class[] = '\\'.$this->instance->core_ns_stub; // API class.

			foreach($this->©dir->iteration($this->instance->core_classes_dir) as $_dir_file)
				if($_dir_file->isFile()) // We're dealing only with class files here.
				{
					$_file_sub_path = $this->©dir->n_seps($_dir_file->getSubPathname());
					$_ns_class_path = '\\'.str_replace(array('/', '-'), array('\\', '_'), preg_replace('/\.php$/i', '', $_file_sub_path));

					if($_ns_class_path === '\\'.$this->instance->core_ns.'\\deps')
						$_ns_class_path = '\\deps_'.$this->instance->core_ns; // Special class (no namespace).

					else if($_ns_class_path === '\\'.$this->instance->core_ns.'\\deps_x')
						$_ns_class_path = '\\deps_x_'.$this->instance->core_ns; // Special class.

					if(class_exists($_ns_class_path) || interface_exists($_ns_class_path) || ($this->©function->is_possible('trait_exists') && trait_exists($_ns_class_path)))
						$ns_class[] = $_ns_class_path;
				}
			unset($_dir_file, $_file_sub_path, $_ns_class_path); // Housekeeping.

			# Iterate through each `\namespace\class` and collect details to return in the final array.

			foreach(array_unique($ns_class) as $_ns_class) // Iterate through all classes.
			{
				$ns_class_details['class: '.$_ns_class]['name'] = $_ns_class;
				$_properties                                    = $_methods = array();
				$_reflection                                    = new \ReflectionClass($_ns_class);
				$_doc_block_tabs                                = str_repeat("\t", 4);
				$_nested_doc_block_tabs                         = str_repeat("\t", 8);

				if(in_array('class_doc_blocks', $details, TRUE))
					$ns_class_details['class: '.$_ns_class]['doc_block'] = // Suitable for dumping.
						"\n".$_doc_block_tabs. // We strip any leading indents established by line #2.
						ltrim($this->©string->strip_leading_indents((string)$_reflection->getDocComment(), 2, $_doc_block_tabs.' '));

				if(in_array('properties', $details, TRUE))
				{
					foreach($_reflection->getProperties() as $_property)
					{
						$_key = 'property: $'.$_property->getName();

						$_properties[$_key]['name'] = '$'.$_property->getName();

						if(in_array('property_doc_blocks', $details, TRUE))
							$_properties[$_key]['doc_block'] = // Suitable for dumping.
								"\n".$_nested_doc_block_tabs. // We strip any leading indents established by line #2.
								ltrim($this->©string->strip_leading_indents((string)$_property->getDocComment(), 2, $_nested_doc_block_tabs.' '));

						$_properties[$_key]['modifiers']       = implode(' ', \Reflection::getModifierNames($_property->getModifiers()));
						$_properties[$_key]['declaring-class'] = $_property->getDeclaringClass()->getName();
					}
					$ns_class_details['class: '.$_ns_class]['properties'] = $_properties;
				}
				if(in_array('methods', $details, TRUE))
				{
					foreach($_reflection->getMethods() as $_method)
					{
						$_key = 'method: '.$_method->getName().'()';

						$_methods[$_key]['name'] = $_method->getName().'()';

						if(in_array('method_doc_blocks', $details, TRUE))
							$_methods[$_key]['doc_block'] = // Suitable for dumping.
								"\n".$_nested_doc_block_tabs. // We strip any leading indents established by line #2.
								ltrim($this->©string->strip_leading_indents((string)$_method->getDocComment(), 2, $_nested_doc_block_tabs.' '));

						$_methods[$_key]['modifiers']       = implode(' ', \Reflection::getModifierNames($_method->getModifiers()));
						$_methods[$_key]['declaring-class'] = $_method->getDeclaringClass()->getName();

						if(in_array('method_parameters', $details, TRUE))
							foreach($_method->getParameters() as $_parameter)
								if($_parameter->isOptional())
								{
									$__key = 'param: $'.$_parameter->getName();

									$_methods[$_key]['accepts-parameters'][$__key]['optional'] = TRUE;

									if($_parameter->isPassedByReference())
										$_methods[$_key]['accepts-parameters'][$__key]['only-by-reference'] = TRUE;

									$_methods[$_key]['accepts-parameters'][$__key]['name']          = '$'.$_parameter->getName();
									$_methods[$_key]['accepts-parameters'][$__key]['default-value'] = $_parameter->getDefaultValue();
								}
								else // It's a requirement argument (handle this a bit differently).
								{
									$__key = 'param: $'.$_parameter->getName();

									$_methods[$_key]['accepts-parameters'][$__key]['required'] = TRUE;

									if($_parameter->isPassedByReference())
										$_methods[$_key]['accepts-parameters'][$__key]['only-by-reference'] = TRUE;

									$_methods[$_key]['accepts-parameters'][$__key]['name'] = '$'.$_parameter->getName();
								}
					}
					$ns_class_details['class: '.$_ns_class]['methods'] = $_methods;
				}
			}
			unset($_reflection, $_doc_block_tabs, $_nested_doc_block_tabs, $_properties, $_methods, $_property, $_method, $_key, $__key);

			return $ns_class_details; // This is potentially a HUGE array of details. Be careful if dumping this on-screen.
		}
	}
}