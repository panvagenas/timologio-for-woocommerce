<?php
/**
 * Form Fields
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
	 * Form Fields
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class form_fields extends framework
	{
		/**
		 * @var string Prefix for field IDs.
		 *
		 * @note This can be overridden on a per-field basis.
		 */
		public $id_prefix = '';

		/**
		 * @var string Prefix for field names.
		 *
		 * @note This can be overridden on a per-field basis.
		 */
		public $name_prefix = '';

		/**
		 * @var string Common CSS classes.
		 *
		 * @note This can be supplemented on a per-field basis.
		 *    Each form field can add their own additional classes.
		 *
		 * @note Common classes are common to ALL fields in this instance.
		 *    If a specific field sets the `classes` option we will use the per-field specification;
		 *    but then we append any globally common classes onto the end of that per-field value.
		 *    Therefore, these CANNOT be completely overridden on a per-field basis.
		 */
		public $common_classes = '';

		/**
		 * @var string Common attributes.
		 *
		 * @note This can be supplemented on a per-field basis.
		 *    Each field can add their own additional common attributes.
		 *
		 * @note Common attributes are common to ALL fields in this instance.
		 *    If a specific field sets the `attrs` option we will use the per-field specification;
		 *    but then we append any globally common attributes onto the end of that per-field value.
		 *    Therefore, these CANNOT be completely overridden on a per-field basis.
		 */
		public $common_attrs = '';

		/**
		 * @var boolean Use option update markers?
		 *
		 * @note This can be overridden on a per-field basis.
		 *
		 * @note This is used in `select` fields that allow `multiple` option selections;
		 *    and also for checkbox`[]` options sent to the server as arrays.
		 *    Update markers pad these arrays with an `___update` index.
		 */
		public $use_update_markers = FALSE;

		/**
		 * @var array Form field config defaults.
		 *
		 * @note Data types are IMPORTANT here. See {@link standardize_field_config()}.
		 *
		 * @by-constructor Updated dynamically by class constructor.
		 */
		public $defaults = array(
			// Required.
			'type'                => '',
			'name'                => '',

			// Common, but optional.
			'title'               => '',
			'placeholder'         => '',
			'tabindex'            => 0,

			// If empty, we establish this dynamically.
			// It is generally a bad idea to customize this.
			// Auto-generated using: `[basename(name)]`.
			'code'                => '',

			// If empty, we establish this dynamically.
			// Generated using: `[spl_object_hash]-[MD5(name)]`.
			// This will NEVER be the same when generated automatically.
			// If persistence is needed; please customize this value.
			'id'                  => '',

			// This is for types: `input|textarea`,
			// when `$value` is NULL (i.e. not yet defined).
			'default_value'       => '',
			// Does NOT work with radio buttons or checkboxes.
			// Use: `checked_value`, `checked_by_default`.

			// Requirements.
			'unique'              => FALSE,
			'unique_callback_js'  => '',
			'unique_callback_php' => NULL,
			'required'            => FALSE,
			'maxlength'           => 0,

			// Validation patterns; an array of arrays.
			// Each pattern MUST have a `name`, `description` & `regex` pattern (none can be empty).
			// Each pattern may optionally specify a `minimum`, `maximum` configuration based on `min_max_type`.
			//    Where `min_max_type` is one of: `array_length`, `string_length`, `numeric_value`, `file_size`.
			'validation_patterns' => array(),

			// For types: `input|textarea`.
			'confirm'             => FALSE,

			// For type: `textarea`.
			'cols'                => 50,
			'rows'                => 3,
			'wrap'                => TRUE,

			// For type: `image`.
			'src'                 => '',
			'alt'                 => '',

			// For type: `select`.
			'size'                => 3,
			// For type: `select|file`.
			'multiple'            => FALSE,

			// For type: `select`.
			// For type: `radios`.
			// For type: `checkboxes`.
			'options'             => array(),

			// For type: `file`.
			'accept'              => '',
			'move_to_dir'         => '',

			// For type: `radio|checkbox`.
			'checked_value'       => '1',
			'checked_by_default'  => FALSE,

			// Other statuses.
			'readonly'            => FALSE,
			'disabled'            => FALSE,

			// Other/misc specs.
			'spellcheck'          => TRUE,
			'autocomplete'        => FALSE,
			'use_button_tag'      => TRUE,

			// Option update marker.
			'use_update_marker'   => FALSE,

			// Field ID prefix.
			'id_prefix'           => '',

			// Field name prefix.
			'name_prefix'         => '',

			// Custom classes.
			'classes'             => '',

			// Custom attributes.
			'attrs'               => ''
		);

		/**
		 * @var array All possible field types.
		 *
		 * @note If this list is updated, we will also need to update
		 *    the `core.js` validation routines in many cases.
		 */
		public $types = array(
			'tel',
			'url',
			'text',
			'file',
			'email',
			'number',
			'search',
			'password',
			'color',
			'range',
			'date',
			'datetime',
			'datetime-local',
			'radio',
			'radios',
			'checkbox',
			'checkboxes',
			'image',
			'button',
			'reset',
			'submit',
			'select',
			'textarea',
			'hidden',
			'media'
		);

		/**
		 * @var array All possible `input` types.
		 */
		public $input_types = array(
			'tel',
			'url',
			'text',
			'file',
			'email',
			'number',
			'search',
			'password',
			'color',
			'range',
			'date',
			'datetime',
			'datetime-local',
			'radio',
			'checkbox',
			'image',
			'button',
			'reset',
			'submit',
			'hidden',
			'media'
		);

		/**
		 * @var array Form control `input` types.
		 */
		public $form_control_input_types = array(
			'tel',
			'url',
			'text',
			'file',
			'email',
			'number',
			'search',
			'password',
			'color',
			'range',
			'date',
			'datetime',
			'datetime-local',
			'media'
		);

		/**
		 * @var array Field types that serve as buttons.
		 */
		public $button_types = array(
			'image',
			'button',
			'reset',
			'submit'
		);

		/**
		 * @var array Field types that include a single checked value.
		 *    Note that `radios` and `checkboxes` use options; NOT a single checked value.
		 */
		public $single_check_types = array(
			'radio',
			'checkbox'
		);

		/**
		 * @var array Field types that include multiple checked values.
		 *    Note that `radios` and `checkboxes` use options; NOT checked values.
		 */
		public $multi_check_types = array(
			'radios',
			'checkboxes'
		);

		/**
		 * @var array Field types that include options.
		 *    Note that `radio` and `checkbox` use a single checked value.
		 */
		public $types_with_options = array(
			'radios',
			'checkboxes',
			'select'
		);

		/**
		 * @var array Confirmable field types.
		 */
		public $confirmable_types = array(
			'tel',
			'url',
			'text',
			'email',
			'number',
			'search',
			'password',
			'color',
			'range',
			'date',
			'datetime',
			'datetime-local',
			'select',
			'textarea'
		);

		/**
		 * @var string Fields for a specific call action?
		 *    Set this to a dynamic `©class.®method`.
		 */
		public $for_call = ''; // Defaults to empty string.

		/**
		 * @var boolean Is an action {@link $for_call}?
		 *
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $is_action_for_call = FALSE;

		/**
		 * @var string Current object instance hash ID.
		 *
		 * @by-constructor Set dynamically by class constructor.
		 */
		public $spl_object_hash = '';

		/**
		 * @var array A record of all fields generated by this instance.
		 *
		 * @note This list is built by {@link construct_field_markup()}.
		 */
		public $generated_fields = array();

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @param array        $properties Optional array of properties to set upon construction.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function __construct($instance, $properties = array())
		{
			parent::__construct($instance);

			$this->check_arg_types('', 'array', func_get_args());

			if($properties) $this->set_properties($properties);

			$this->defaults['name_prefix']       = $this->name_prefix;
			$this->defaults['id_prefix']         = $this->id_prefix;
			$this->defaults['use_update_marker'] = $this->use_update_markers;

			if($this->for_call) // For a specific call action?
				$this->is_action_for_call = $this->©action->is_call($this->for_call);

			$this->spl_object_hash = spl_object_hash($this);
		}

		/**
		 * Builds HTML markup for a form field.
		 *
		 * @param null|string (or scalar)|array $field_value The current value(s) for this field.
		 *    If there is NO current value, set this to NULL so that default values are considered properly.
		 *    That is, default values are only implemented if `$value` is currently NULL.
		 *
		 * @note The current `$field_value` will be piped through `$this->value()` and/or `$this->values()`.
		 *    In other words, we convert the `$field_value` into a NULL/string/array; depending upon the `type` of form field.
		 *    The current `call` action will also be considered if this instance is associated with one.
		 *    See: {@link value()} and {@link values()} for further details.
		 *
		 * @param array                         $field Field configuration options.
		 *
		 * @return string HTML markup for a form field, compatible with core themes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @throws exception If invalid types are found in the configuration array.
		 *    Each configuration option MUST have a value type matching it's default counterpart as defined by this routine.
		 *
		 * @throws exception If required config options are missing.
		 */
		public function markup($field_value, $field)
		{
			$this->check_arg_types(array('null', 'scalar', 'array'), 'array:!empty', func_get_args());

			$value  = $this->value($field_value); // String (or NULL by default).
			$values = $this->values($field_value); // Array (or NULL by default).

			$field                                  = $this->check_config($field_value, $field);
			$this->generated_fields[$field['code']] = $field; // Indexed by code.
			$html                                   = ''; // Initialize string value.

			if(in_array($field['type'], $this->types_with_options, TRUE) && $field['type'] === 'select')
			{
				if($field['multiple'] && $field['use_update_marker'])
				{
					$html .= '<input type="hidden"'.
					         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
					         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
					         ' value="'.esc_attr('___update').'"'.
					         '/>';
				}
				$html .= '<select'.
				         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
				         ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['multiple']) ? '[]' : '')).'"'.
				         ' class="form-control'.esc_attr($field['classes']).'"'.

				         (($field['multiple']) ? ' multiple="multiple" size="'.esc_attr((string)$field['size']).'"' : '').

				         (($field['confirm']) ? ' data-confirm="'.esc_attr('true').'"' : '').
				         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
				         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

				         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').
				         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').

				         ((!$field['autocomplete']) ? ' autocomplete="off"' : '').

				         (($field['readonly']) ? ' readonly="readonly"' : '').
				         (($field['disabled']) ? ' disabled="disabled"' : '').

				         $field['attrs']. // Custom attributes.
				         '>';
				foreach($field['options'] as $_key => $_option)
				{
					$html .= '<option'.
					         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---'.esc_attr($_key).'"'.
					         ' value="'.esc_attr($_option['value']).'"'.

					         (((!$field['multiple'] && is_string($value) && $value === $_option['value'])
					           || (!$field['multiple'] && !isset($value) && $_option['is_default'])
					           || ($field['multiple'] && is_array($values) && in_array($_option['value'], $values, TRUE))
					           || ($field['multiple'] && !isset($values) && $_option['is_default']))
						         ? ' selected="selected"' : '').
					         '">'.

					         $_option['label'].

					         '</option>';
				}
				unset($_key, $_option);

				$html .= '</select>';
			}
			else if(in_array($field['type'], $this->types_with_options, TRUE) && in_array($field['type'], $this->multi_check_types, TRUE))
			{
				if($field['type'] === 'checkboxes' && $field['use_update_marker'])
				{
					$html .= '<input'.
					         ' type="hidden"'.
					         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
					         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
					         ' value="'.esc_attr('___update').'"'.
					         '/>';
				}
				foreach($field['options'] as $_key => $_option)
				{
					$html .= '<label'. // For each radio/checkbox.
					         (($field['classes']) ? ' class="'.esc_attr(trim($field['classes'])).'"' : '').
					         '>'. // Classes apply to the label in a set of radios/checkboxes.

					         '<input'.
					         ' type="'.esc_attr(rtrim($field['type'], 'es')).'"'.
					         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---'.esc_attr($_key).'"'.
					         ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['type'] === 'checkboxes') ? '[]' : '')).'"'.
					         ' value="'.esc_attr($_option['value']).'"'.

					         ((($field['type'] === 'radios' && is_string($value) && $value === $_option['value'])
					           || ($field['type'] === 'radios' && !isset($value) && $_option['is_default'])
					           || ($field['type'] === 'checkboxes' && is_array($values) && in_array($_option['value'], $values, TRUE))
					           || ($field['type'] === 'checkboxes' && !isset($values) && $_option['is_default']))
						         ? ' checked="checked"' : '').

					         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
					         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

					         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').

					         (($field['readonly']) ? ' readonly="readonly"' : '').
					         (($field['disabled']) ? ' disabled="disabled"' : '').

					         $field['attrs']. // Custom attributes.
					         ' />'.

					         ' '.$_option['label'].

					         '</label>';
				}
				unset($_key, $_option);
			}
			else if($field['type'] === 'textarea')
			{
				$html .= '<textarea'.
				         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
				         ' name="'.esc_attr($field['name_prefix'].$field['name']).'"'.
				         ' class="'.esc_attr('form-control'.$field['classes']).'"'.

				         (($field['confirm']) ? ' data-confirm="'.esc_attr('true').'"' : '').
				         (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
				         (($field['maxlength']) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
				         (($field['unique']) ? ' data-unique="'.esc_attr('true').'" data-unique-callback="'.esc_attr($field['unique_callback_js']).'"' : '').
				         (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '').

				         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').
				         (($field['placeholder']) ? ' placeholder="'.esc_attr($field['placeholder']).'"' : '').
				         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').

				         ((!$field['spellcheck']) ? ' spellcheck="false"' : '').
				         ((!$field['autocomplete']) ? ' autocomplete="off"' : '').

				         (($field['readonly']) ? ' readonly="readonly"' : '').
				         (($field['disabled']) ? ' disabled="disabled"' : '').

				         ((!$field['wrap']) ? ' wrap="off"' : '').

				         ' cols="'.esc_attr((string)$field['cols']).'"'.
				         ' rows="'.esc_attr((string)$field['rows']).'"'.

				         $field['attrs']. // Custom attributes.
				         '>'.

				         ((!isset($value)) ? esc_html($field['default_value']) : esc_html((string)$value)).

				         '</textarea>';
			}
			else if(in_array($field['type'], $this->button_types, TRUE) && $field['use_button_tag'])
			{
				$html .= '<button'.
				         ' type="'.esc_attr($field['type']).'"'.
				         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
				         (($field['type'] === 'image') ? ' class="'.esc_attr(trim($field['classes'])).'"'
					         : ' class="btn'.((strpos($field['classes'], 'btn-') !== FALSE) ? '' : (($field['type'] === 'submit')
						         ? ' btn-primary width-100' : ' btn-default width-100')).
					           esc_attr($field['classes'])).'"'.

				         (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').
				         (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '').

				         (($field['readonly']) ? ' readonly="readonly"' : '').
				         (($field['disabled']) ? ' disabled="disabled"' : '').

				         $field['attrs']. // Custom attributes.
				         '>'.

				         ((!isset($value)) ? $field['default_value'] : (string)$value).

				         '</button>';
			}
			else if(in_array($field['type'], $this->input_types, TRUE))
			{
				if($field['type'] === 'file' && $field['multiple'] && $field['use_update_marker'])
				{
					$html .= '<input'.
					         ' type="hidden"'.
					         ' id="'.esc_attr($field['id_prefix'].$field['id']).'---update"'.
					         ' name="'.esc_attr($field['name_prefix'].$field['name'].'[___update]').'"'.
					         ' value="'.esc_attr('___update').'"'.
					         '/>';
				} else if($field['type'] === 'media')
				{
					wp_enqueue_media();
					$html .= '<div class="input-group input-media-wrapper">';
				}

				$html .= '<input'. // MANY conditions here.

				         ' type="'.esc_attr($field['type']).'"'.
				         ' id="'.esc_attr($field['id_prefix'].$field['id']).'"'.
				         ((in_array($field['type'], $this->button_types, TRUE)) ? '' : ' name="'.esc_attr($field['name_prefix'].$field['name'].(($field['type'] === 'file' && $field['multiple']) ? '[]' : '')).'"').
				         (($field['type'] === 'hidden' || !in_array($field['type'], $this->form_control_input_types, TRUE))
					         ? ' class="'.esc_attr($field['classes']).'"'
					         : ($field['type'] === 'media'
						         ? ' class="form-control media-input '.esc_attr($field['classes']).'"'
						         : ' class="form-control'.esc_attr($field['classes']).'"')).

				         (($field['type'] === 'file') ? '' // Exclude (NOT possible to define a value for files).
					         : ((in_array($field['type'], $this->single_check_types, TRUE)) ? ' value="'.esc_attr($field['checked_value']).'"'
						         : ((!isset($value)) ? ' value="'.esc_attr($field['default_value']).'" data-initial-value="'.esc_attr($field['default_value']).'"'
							         : ' value="'.esc_attr((string)$value).'" data-initial-value="'.esc_attr($field['default_value']).'"'))).
				         // Note, the `data-initial-value` property is used in JavaScript to help block WebKit autofill behavior.

				         ((in_array($field['type'], $this->single_check_types, TRUE)
				           && ((!isset($value) && $field['checked_by_default']) || (is_string($value) && $value === $field['checked_value'])))
					         ? ' checked="checked"' : '').

				         (($field['src'] && $field['type'] === 'image') ? ' src="'.esc_attr($field['src']).'"' : '').
				         (($field['alt'] && $field['type'] === 'image') ? ' alt="'.esc_attr($field['alt']).'"' : '').
				         (($field['accept'] && $field['type'] === 'file') ? ' accept="'.esc_attr($field['accept']).'"' : '').
				         (($field['multiple'] && $field['type'] === 'file') ? ' multiple="multiple"' : '').

				         ((in_array($field['type'], $this->button_types, TRUE)) ? '' // Exclude.
					         : (($field['confirm']) ? ' data-confirm="'.esc_attr('true').'"' : '').
					           (($field['required']) ? ' data-required="'.esc_attr('true').'"' : '').
					           (($field['maxlength'] && !in_array($field['type'], array_merge($this->single_check_types, array('file')), TRUE)) ? ' maxlength="'.esc_attr((string)$field['maxlength']).'"' : '').
					           (($field['unique'] && !in_array($field['type'], array_merge($this->single_check_types, array('file')), TRUE)) ? ' data-unique="'.esc_attr('true').'" data-unique-callback="'.esc_attr($field['unique_callback_js']).'"' : '').
					           (($field['validation_patterns']) ? ' '.$this->validation_attrs($field['validation_patterns']) : '')).

				         (($field['type'] === 'hidden') ? '' // Exclude.
					         : (($field['title']) ? ' title="'.esc_attr($field['title']).'"' : '').
					           (($field['placeholder']) ? ' placeholder="'.esc_attr($field['placeholder']).'"' : '').
					           (($field['tabindex']) ? ' tabindex="'.esc_attr((string)$field['tabindex']).'"' : '')).

				         ((in_array($field['type'], array_merge($this->button_types, $this->single_check_types, array('file', 'hidden')), TRUE)) ? '' // Exclude.
					         : ((!$field['autocomplete']) ? ' autocomplete="off"' : '').
					           ((!$field['spellcheck']) ? ' spellcheck="false"' : '')).

				         (($field['readonly']) ? ' readonly="readonly"' : '').
				         (($field['disabled']) ? ' disabled="disabled"' : '').

				         $field['attrs']. // Custom attributes.
				         ' />';
				if($field['type'] === 'media')
				{
					// TODO Implement
					$html .= '<span class="input-group-btn">';
					$html .= '<button class="btn btn-default input-media-btn" type="button">';
					$html .= isset($field['button_label']) ? $field['button_label'] : 'Go!';
					$html .= '</button>';
					$html .= '</span>';
					$html .= '</div>';
				}
			}
			else throw $this->©exception($this->method(__FUNCTION__).'#invalid_type', get_defined_vars(), sprintf($this->__('Invalid form field type: `%1$s`.'), $field['type']));

			if($field['confirm'] && in_array($field['type'], $this->confirmable_types, TRUE))
			{
				$field_clone = $field; // Clone.

				if($field['placeholder']) // Confirm placeholder.
					$field_clone['placeholder'] = $this->_x('again to confirm...');
				$field_clone['name_prefix']         = 'c_'.$field_clone['name_prefix'];
				$field_clone['id_prefix']           = 'c-'.$field_clone['id_prefix'];
				$field_clone['code']                = 'c_'.$field_clone['code'];
				$field_clone['confirm']             = FALSE; // Confirm ONE time only.
				$field_clone['unique']              = FALSE; // No unique enforcements.
				$field_clone['unique_callback_js']  = ''; // No unique enforcements.
				$field_clone['unique_callback_php'] = NULL; // No unique enforcements.
				$field_clone['required']            = FALSE; // No required enforcements.
				$field_clone['maxlength']           = 0; // No maxlength enforcements.

				$html .= $this->markup($field_value, $field_clone);
			}

			return $html; // HTML markup.
		}

		/**
		 * Validates form field values against form field configurations.
		 *
		 * @param array                       $field_values An array of field values to be validated here.
		 *
		 * @param null|array                  $fields Optional. Field configuration arrays.
		 *    If this is NULL, we use {@link $generated_fields} as a default value.
		 *
		 * @param null|integer|\WP_User|users $user The user we're working with here.
		 *
		 * @param array                       $args Optional. Arguments that control validation behavior.
		 *
		 * @return boolean|errors Either a TRUE value (no errors); or an errors object instance.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note This is an EXTREMELY COMPLEX routine that should NOT be modified without serious consideration.
		 *
		 * @security-note Callers should NEVER process disabled form fields (for security purposes).
		 *    It's always possible for disabled fields to be submitted by malicious users (not common, but possible).
		 *    This method does NOT validate disabled fields (we do NOT expect these to be submitted).
		 *    Any routines that process form submissions should be sure NOT to process these.
		 *
		 * @note Given this complex/lengthy routine, the result of ANY call to this method is cached statically.
		 *    An MD5 checksum is used to determine if we have ALREADY validated the `$fields` prior.
		 *    If we have, there is NO need to validate them again.
		 */
		public function validate($field_values, $fields = NULL, $user = NULL, $args = array())
		{
			$this->check_arg_types('array', array('null', 'array'), $this->©user_utils->which_types(), 'array', func_get_args());

			if(!isset($fields))
				$fields = $this->generated_fields;
			$user = $this->©user_utils->which($user);

			$default_args = array( // Defaults.
			                       'enforce_required_fields'  => TRUE,
			                       'validate_readonly_fields' => TRUE,
			                       'validate_disabled_fields' => FALSE
			); // All of these arguments are optional at all times.
			$args         = $this->check_extension_arg_types('boolean', 'boolean', 'boolean', $default_args, $args);
			$md5          = md5(serialize($field_values).serialize($fields).serialize($user).serialize($args));
			$errors       = $this->©errors(); // Initialize an errors object (we deal w/ these below).

			if(isset($this->static[__FUNCTION__][$md5])) // Already validated these fields?
				return $this->static[__FUNCTION__][$md5]; // We can save LOTS of time here.

			if($args['enforce_required_fields']) foreach($fields as $_key => $_field)
			{
				$_value = NULL; // A default value (e.g. assume NOT set).
				if(isset($field_values[$_key])) $_value = $field_values[$_key];
				if(is_array($_value)) unset($_value['___update'], $_value['___file_info']);

				$_field = $this->check_config($_value, $_field); // Standardize.

				if(!$_field['required'] || !$args['enforce_required_fields']) continue;
				if($_field['readonly'] && !$args['validate_readonly_fields']) continue;
				if($_field['disabled'] && !$args['validate_disabled_fields']) continue;

				if(in_array($_field['type'], array('image', 'button', 'reset', 'submit'), TRUE))
					// Notice that we do NOT exclude hidden input fields here.
					continue; // Exclude (these are NEVER required).

				switch($_field['type']) // Some field types are handled a bit differently here.
				{
					case 'select': // We also check for multiple selections (i.e. `multiple="multiple"`).

						if($_field['multiple']) // Allows multiple selections?
						{
							foreach($_field['validation_patterns'] as $_validation_pattern)
							{
								if($_validation_pattern['min_max_type'] === 'array_length')
									if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
										if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
											$_validation_abs_minimum = $_validation_pattern['minimum'];
							}
							if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             sprintf($this->_x('Please select at least %1$s options.'), $_validation_abs_minimum));

							else if(!is_array($_value) || count($_value) < 1)
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             $this->_x('Please select at least 1 option.'));

							unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.
						}
						else if(!is_string($_value) || !isset($_value[0])) // Must have at least one char in the string.
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('This is a required field.'));

						break; // Break switch handler.

					case 'file': // We also check for multiple files (i.e. `multiple="multiple"`).

						if($_field['multiple']) // Allows multiple file uploads?
						{
							foreach($_field['validation_patterns'] as $_validation_pattern)
							{
								if($_validation_pattern['min_max_type'] === 'array_length')
									if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
										if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
											$_validation_abs_minimum = $_validation_pattern['minimum'];
							}
							if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             sprintf($this->_x('Please select at least %1$s files.'), $_validation_abs_minimum));

							else if(!is_array($_value) || count($_value) < 1)
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             $this->_x('Please select at least one file.'));

							unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.
						}
						else if(!is_string($_value) || !isset($_value[0])) // Must have at least one char in the string.
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('A file MUST be selected please.'));

						break; // Break switch handler.

					case 'radio': // Single radio button (not common).
					case 'radios': // Multiple radio buttons.

						if(!is_string($_value) || !isset($_value[0])) // Must have at least one char in the string.
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Please choose one of the available options.'));

						break; // Break switch handler.

					case 'checkbox': // A single checkbox (string).

						if(!is_string($_value) || !isset($_value[0])) // Must have at least one char in the string.
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('This box MUST be checked please.'));

						break; // Break switch handler.

					case 'checkboxes': // Checkboxes (array).

						foreach($_field['validation_patterns'] as $_validation_pattern)
						{
							if($_validation_pattern['min_max_type'] === 'array_length')
								if(isset($_validation_pattern['minimum']) && $_validation_pattern['minimum'] > 1)
									if(!isset($_validation_abs_minimum) || $_validation_pattern['minimum'] < $_validation_abs_minimum)
										$_validation_abs_minimum = $_validation_pattern['minimum'];
						}
						if(isset($_validation_abs_minimum) && (!is_array($_value) || count($_value) < $_validation_abs_minimum))
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             sprintf($this->_x('Please check at least %1$s boxes.'), $_validation_abs_minimum));

						else if(!is_array($_value) || count($_value) < 1)
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Please check at least one box.'));

						unset($_validation_pattern, $_validation_abs_minimum); // A bit of housekeeping here.

						break; // Break switch handler.

					default: // Everything else (including textarea fields).

						if(!is_string($_value) || !isset($_value[0])) // Must have at least one char in the string.
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('This is a required field.'));

						break; // Break switch handler.
				}
			}
			unset($_key, $_field, $_value); // Housekeeping.

			foreach($fields as $_key => $_field) // Iterates field configurations.
			{
				$_value = $_file_info = NULL; // Default values (e.g. assume NOT set).
				if(isset($field_values[$_key])) $_value = $field_values[$_key];
				if(is_array($_value)) unset($_value['___update']);

				// Collect file info (if applicable).

				if(!empty($_field['type']) && $_field['type'] === 'file')
					if(is_array($_value) && isset($_value['___file_info']) && is_array($_value['___file_info']))
					{
						$_file_info = $_value['___file_info'];
						unset($_value['___file_info']); // Remove file info.
					}
					else if(is_string($_value) && $this->©array->is($field_values['___file_info'][$_key]))
						$_file_info = $field_values['___file_info'][$_key];

				$_field = $this->check_config($_value, $_field); // Standardize.

				// Catch invalid data types. These should always trigger an error.

				if(isset($_value) && ($_field['multiple'] || $_field['type'] === 'checkboxes') && !is_array($_value))
				{
					$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
					             $this->_x('Invalid data type. Expecting an array.'));
					continue; // We CANNOT validate this any further.
				}
				if(isset($_value) && !$_field['multiple'] && $_field['type'] !== 'checkboxes' && !is_string($_value))
				{
					$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
					             $this->_x('Invalid data type. Expecting a string.'));
					continue; // We CANNOT validate this any further.
				}
				// Catch readonly/disabled fields.

				if($_field['readonly'] && !$args['validate_readonly_fields']) continue;
				if($_field['disabled'] && !$args['validate_disabled_fields']) continue;

				if(isset($_value) && $_field['disabled']) // This should NOT happen (but just in case).
				{
					$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
					             $this->_x('Invalid data. Disabled fields should NOT be submitted w/ a value.'));
					continue; // We CANNOT validate this any further.
				}
				// Catch field types that we NEVER validate any further.

				if(in_array($_field['type'], array('image', 'button', 'reset', 'submit'), TRUE))
					// Notice that we do NOT exclude hidden input fields here.
					continue; // Exclude (these are NEVER validated any further).

				// Catch any other NULL, empty and/or invalid values. Stop here?

				if(!isset($_value) || (!is_string($_value) && !is_array($_value))
				   || (is_string($_value) && !isset($_value[0])) || (is_array($_value) && !$_value)
				) if(!$_field['required'] || !$args['enforce_required_fields']) continue;
				else // This warrants an error. This field value is invalid or missing.
				{
					if(!$errors->get_code($this->method(__FUNCTION__).'#'.$_field['code'])) // Avoid duplicate errors.
						$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
						             $this->_x('This is a required field.'));
					continue; // We CANNOT validate this any further.
				}
				// Handle validation patterns now. This is an extremely complex routine.

				foreach($_field['validation_patterns'] as $_validation_pattern) // Check all validation patterns.
				{
					if($errors->get_code($this->method(__FUNCTION__).'#vp_'.$_field['code']))
						$_validation_description_prefix = $this->_x('<strong>OR:</strong>');
					else $_validation_description_prefix = $this->_x('<strong>REQUIRES:</strong>');

					if(!is_array($_error_data = $errors->get_data($this->method(__FUNCTION__).'#vp_'.$_field['code']))
					   || $_error_data['validation_pattern_name'] !== $_validation_pattern['name']
					)
						switch($_field['type']) // Based on field type.
						{
							case 'file': // Handle file upload selections.

								if($_field['multiple']) // Allows multiple?
								{
									if(!is_array($_value)) // Invalid data type?
										$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
										             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
										             $_validation_description_prefix.' '.$_validation_pattern['description']);

									else foreach($_value as $__key => $__value) if(!is_string($__value) || !preg_match($_validation_pattern['regex'], $__value))
									{
										$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
										             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
										             $_validation_description_prefix.' '.$_validation_pattern['description']);
										break; // No need to check any further.
									}
									unset($__key, $__value); // Housekeeping.
								}
								else if(!is_string($_value) || !preg_match($_validation_pattern['regex'], $_value))
									$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
									             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
									             $_validation_description_prefix.' '.$_validation_pattern['description']);

								break; // Break switch handler.

							default: // All other types (excluding multiples).

								if(!$_field['multiple'] && $_field['type'] !== 'checkboxes') // Exclusions w/ predefined values.
								{
									if(!is_string($_value) || !preg_match($_validation_pattern['regex'], $_value))
										$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
										             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
										             $_validation_description_prefix.' '.$_validation_pattern['description']);
								}
								break; // Break switch handler.
						}
					if(!is_array($_error_data = $errors->get_data($this->method(__FUNCTION__).'#vp_'.$_field['code']))
					   || $_error_data['validation_pattern_name'] !== $_validation_pattern['name']
					)
						if(isset($_validation_pattern['minimum']) || isset($_validation_pattern['maximum']))
							switch($_validation_pattern['min_max_type']) // Handle this based on min/max type.
							{
								case 'numeric_value': // Against min/max numeric value.

									switch($_field['type']) // Based on field type.
									{
										default: // All other types (minus exclusions w/ predefined and/or non-numeric values).

											if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
											{
												if(!is_string($_value)) // Invalid data type?
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['minimum']) && (!is_numeric($_value) || $_value < $_validation_pattern['minimum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['maximum']) && (!is_numeric($_value) || $_value > $_validation_pattern['maximum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);
											}
											break; // Break switch handler.
									}
									break; // Break switch handler.

								case 'file_size': // Against total file size.

									switch($_field['type']) // Based on field type.
									{
										case 'file': // Handle file upload selections.

											if($_field['multiple']) // Allows multiple files?
											{
												if(!is_array($_value)) // Invalid data type?
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if($_file_info) // We need to collect the total file size and then run validation against that value.
												{
													$__size = 0; // Initialize total size of all files.

													foreach($_value as $__key => $__value) if(!is_string($__value) || !isset($_file_info[$__key]))
													{
														$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
														             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
														             $_validation_description_prefix.' '.$_validation_pattern['description']);
														break; // No need to check any further.
													}
													else $__size += $_file_info[$__key]['size']; // Of all files.

													if(!is_array($_error_data = $errors->get_data($this->method(__FUNCTION__).'#vp_'.$_field['code']))
													   || $_error_data['validation_pattern_name'] !== $_validation_pattern['name']
													)
														if(isset($_validation_pattern['minimum']) && (!is_numeric($__size) || $__size < $_validation_pattern['minimum']))
															$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
															             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
															             $_validation_description_prefix.' '.$_validation_pattern['description']);

														else if(isset($_validation_pattern['maximum']) && (!is_numeric($__size) || $__size > $_validation_pattern['maximum']))
															$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
															             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
															             $_validation_description_prefix.' '.$_validation_pattern['description']);

													unset($__size, $__key, $__value); // Housekeeping.
												}
											}
											else // We're dealing with a single file in this case.
											{
												if(!is_string($_value)) // Invalid data type?
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if($_file_info && isset($_validation_pattern['minimum']) && (!is_numeric($_file_info['size']) || $_file_info['size'] < $_validation_pattern['minimum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if($_file_info && isset($_validation_pattern['maximum']) && (!is_numeric($_file_info['size']) || $_file_info['size'] > $_validation_pattern['maximum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);
											}
											break; // Break switch handler.
									}
									break; // Break switch handler.

								case 'string_length': // Against string length.

									switch($_field['type']) // Based on field type.
									{
										default: // All other types (minus exclusions w/ predefined and/or N/A values).

											if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
											{
												if(!is_string($_value)) // Invalid data type?
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['minimum']) && (!is_string($_value) || strlen($_value) < $_validation_pattern['minimum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['maximum']) && (!is_string($_value) || strlen($_value) > $_validation_pattern['maximum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);
											}
											break; // Break switch handler.
									}
									break; // Break switch handler.

								case 'array_length': // Against array lengths.

									switch($_field['type']) // Based on field type.
									{
										case 'select': // Select menus w/ multiple options possible.
										case 'file': // Handle file upload selections w/ multiple files possible.
										case 'checkboxes': // Handle multiple file upload selections.

											if($_field['multiple'] || $_field['type'] === 'checkboxes') // Allows multiple?
											{
												if(!is_array($_value)) // Invalid data type?
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['minimum']) && (!is_array($_value) || count($_value) < $_validation_pattern['minimum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);

												else if(isset($_validation_pattern['maximum']) && (!is_array($_value) || count($_value) > $_validation_pattern['maximum']))
													$errors->add($this->method(__FUNCTION__).'#vp_'.$_field['code'],
													             array('form_field_code' => $_field['code'], 'validation_pattern_name' => $_validation_pattern['name']),
													             $_validation_description_prefix.' '.$_validation_pattern['description']);
											}
											break; // Break switch handler.
									}
									break; // Break switch handler.
							}
					if(is_array($_error_data = $errors->get_data($this->method(__FUNCTION__).'#vp_'.$_field['code'])) && $_error_data['validation_pattern_name'] !== $_validation_pattern['name'])
						$errors->remove($this->method(__FUNCTION__).'#vp_'.$_field['code']); // If this one passes it negates all existing validation pattern errors.
				}
				unset($_validation_pattern, $_validation_description_prefix, $_error_data); // Housekeeping.

				if($errors->get_code($this->method(__FUNCTION__).'#vp_'.$_field['code'])) continue; // No need to go any further.

				if($_field['maxlength']) // Validate string length against max allowed chars?
					switch($_field['type']) // Based on field type.
					{
						default: // All other types (minus exclusions w/ predefined and/or N/A values).

							if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
							{
								if(!is_string($_value)) // Invalid data type?
								{
									$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->_x('Invalid data type. Expecting a string.'));
									continue 2; // We CANNOT validate this any further.
								}
								else if(strlen($_value) > $_field['maxlength'])
								{
									$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             sprintf($this->_x('Too long. Max string length: `%1$s` characters.'), $_field['maxlength']));
									continue 2; // We CANNOT validate this any further.
								}
							}
							break; // Break switch handler.
					}
				if($_field['unique']) // Check uniqueness w/ a callback?
					switch($_field['type']) // Based on field type.
					{
						default: // All other types (minus exclusions w/ predefined and/or N/A values).

							if(!in_array($_field['type'], array('file', 'select', 'radio', 'radios', 'checkbox', 'checkboxes'), TRUE))
							{
								if(!is_string($_value)) // Invalid data type?
								{
									$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->_x('Invalid data type. Expecting a string.'));
									continue 2; // We CANNOT validate this any further.
								}
								else if(!$_field['unique_callback_php'] || !is_callable($_field['unique_callback_php']))
								{
									$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->_x('Unable to validate. Invalid unique callback.'));
									continue 2; // We CANNOT validate this any further.
								}
								else if(!$_field['unique_callback_php']($_value, $user))
								{
									$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
									             $this->_x('Please try again (this value MUST be unique please).'));
									continue 2; // We CANNOT validate this any further.
								}
							}
							break; // Break switch handler.
					}
				// Handle file errors (when/if applicable; during file uploads).

				if($_field['type'] === 'file' && $_file_info) // Should check?
				{
					if($_field['multiple']) // Allows multiple files?
					{
						if(!is_array($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting an array.'));
							continue; // We CANNOT validate this any further.
						}
						else foreach($_value as $__key => $__value)
							if(!is_string($__value) || !isset($_file_info[$__key]) || $_file_info[$__key]['error'] !== UPLOAD_ERR_OK)
							{
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             $this->_x('File upload failure.').' '.$this->©string->file_upload_error($_file_info[$__key]['error']));
								continue 2; // We CANNOT validate this any further.
							}
						unset($__key, $__value); // Housekeeping.
					}
					else // We're dealing with a single file in this case.
					{
						if(!is_string($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting a string.'));
							continue; // We CANNOT validate this any further.
						}
						else if($_file_info['error'] !== UPLOAD_ERR_OK)
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('File upload failure.').' '.$this->©string->file_upload_error($_file_info['error']));
							continue; // We CANNOT validate this any further.
						}
					}
				}
				// Handle file MIME types now (when/if applicable; during file uploads).

				if($_field['type'] === 'file' && $_field['accept'] && $_file_info) // Should check?
				{
					$_mime_types        = $this->©file->mime_types();
					$_wildcard_patterns = preg_split('/[;,]+/', $_field['accept'], NULL, PREG_SPLIT_NO_EMPTY);

					if($_field['multiple']) // Allows multiple files?
					{
						if(!is_array($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting an array.'));
							continue; // We CANNOT validate this any further.
						}
						else foreach($_value as $__key => $__value)
							if(!is_string($__value) || !isset($_file_info[$__key])
							   || (!$this->©string->in_wildcard_patterns($_file_info[$__key]['type'], $_wildcard_patterns, TRUE)
							       && (!$_file_info[$__key]['name'] || !($__extension = $this->©file->extension($_file_info[$__key]['name'])) || empty($_mime_types[$__extension])
							           || !$this->©string->in_wildcard_patterns($_mime_types[$__extension], $_wildcard_patterns, TRUE)))
							) // Check MIME type from browser; and also MIME type as determined by the file extension.
							{
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             sprintf($this->_x('Invalid MIME type. Expecting: `%1$s`.'), $_field['accept']));
								continue 2; // We CANNOT validate this any further.
							}
						unset($__key, $__value, $__extension); // Housekeeping.
					}
					else // We're dealing with a single file in this case.
					{
						if(!is_string($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting a string.'));
							continue; // We CANNOT validate this any further.
						}
						else if(!$this->©string->in_wildcard_patterns($_file_info['type'], $_wildcard_patterns, TRUE)
						        && (!$_file_info['name'] || !($__extension = $this->©file->extension($_file_info['name'])) || empty($_mime_types[$__extension])
						            || !$this->©string->in_wildcard_patterns($_mime_types[$__extension], $_wildcard_patterns, TRUE))
						) // Check MIME type from browser; and also MIME type as determined by the file extension.
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             sprintf($this->_x('Invalid MIME type. Expecting: `%1$s`.'), $_field['accept']));
							continue; // We CANNOT validate this any further.
						}
						unset($__extension); // Housekeeping.
					}
					unset($_mime_types, $_wildcard_patterns); // Housekeeping.
				}
				// Handle file processing now (when/if applicable; during file uploads).
				// We ONLY move each file ONE time. This routine caches each `tmp_name` statically.

				if($_field['type'] === 'file' && $_field['move_to_dir'] && $_file_info) // Move?
				{
					$_field['move_to_dir'] = $this->©dir->n_seps($_field['move_to_dir']);

					if(strpos($_field['move_to_dir'].'/', $this->©dir->n_seps(ABSPATH).'/') !== 0)
						if(strpos($_field['move_to_dir'].'/', $this->©dir->n_seps(WP_CONTENT_DIR).'/') !== 0)
							if(strpos($_field['move_to_dir'].'/', ($_dir_temp = $this->©dir->temp()).'/') !== 0)
								$_field['move_to_dir'] = $_dir_temp.'/'.ltrim($_field['move_to_dir'], '/');
					unset($_dir_temp); // Just a little housekeeping.

					if(!is_dir($_field['move_to_dir']) && is_writable($this->©dir->n_seps_up($_field['move_to_dir'])))
					{
						mkdir($_field['move_to_dir'], 0755); // NOT recursively.
						clearstatcache(); // Clear stat cache before checking again.

						if(!is_dir($_field['move_to_dir']) || !is_writable($_field['move_to_dir']))
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Unable to handle file upload(s). Unable to move uploaded file(s).').
							             ' '.sprintf($this->_x('Move-to directory NOT writable: `%1$s`.'), $_field['move_to_dir']));
							continue; // We CANNOT validate this any further.
						}
					} // If we get here, the directory exists.

					if($_field['multiple']) // Uploading multiple files?
					{
						if(!is_array($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting an array.'));
							continue; // We CANNOT validate this any further.
						}
						else foreach($_value as $__key => $__value)
							if(!is_string($__value) || !isset($_file_info[$__key])
							   || !$_file_info[$__key]['tmp_name'] || !$_file_info[$__key]['name']
							   || (!isset($this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info[$__key]['tmp_name']])
							       && (!is_uploaded_file($_file_info[$__key]['tmp_name']) || !move_uploaded_file($_file_info[$__key]['tmp_name'], $_field['move_to_dir'].'/'.$_file_info[$__key]['name'])))
							) // File `name` value is always unique. See {@link vars::_merge_FILES_deeply_into()}.
							{
								$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
								             sprintf($this->_x('Unable to handle file upload. Unable to move to: `%1$s`.'), $_field['move_to_dir']));
								continue 2; // We CANNOT validate this any further.
							}
							else $this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info[$__key]['tmp_name']] = $_field['move_to_dir'];

						unset($__key, $__value); // Housekeeping.
					}
					else // We're dealing with a single file in this case.
					{
						if(!is_string($_value)) // Invalid data type?
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             $this->_x('Invalid data type. Expecting a string.'));
							continue; // We CANNOT validate this any further.
						}
						else if(!$_file_info['tmp_name'] || !$_file_info['name']
						        || (!isset($this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info['tmp_name']])
						            && (!is_uploaded_file($_file_info['tmp_name']) || !move_uploaded_file($_file_info['tmp_name'], $_field['move_to_dir'].'/'.$_file_info['name'])))
						) // File `name` value is always unique. See {@link vars::_merge_FILES_deeply_into()}.
						{
							$errors->add($this->method(__FUNCTION__).'#'.$_field['code'], array('form_field_code' => $_field['code']),
							             sprintf($this->_x('Unable to handle file upload. Unable to move to: `%1$s`.'), $_field['move_to_dir']));
							continue; // We CANNOT validate this any further.
						}
						else $this->static[__FUNCTION__.'_moved_tmp_name_to'][$_file_info['tmp_name']] = $_field['move_to_dir'];
					}
				}
			}
			unset($_key, $_field, $_value, $_file_info); // Housekeeping.

			return ($this->static[__FUNCTION__][$md5] = ($errors->exist()) ? $errors : TRUE);
		}

		/**
		 * Builds validation pattern attributes.
		 *
		 * @param array $validation_patterns An array of validation patterns.
		 *
		 * @return string A string of validation pattern attributes.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function validation_attrs($validation_patterns)
		{
			$this->check_arg_types('array', func_get_args());

			$attrs = ''; // Initialize string to contain all validation attributes.

			foreach(array_values($validation_patterns) /* Numerically indexed (always). */ as $_i => $_validation_pattern)
				$attrs .= (($_validation_pattern['name']) ? ' data-validation-name-'.$_i.'="'.esc_attr($_validation_pattern['name']).'"' : '').
				          (($_validation_pattern['description']) ? ' data-validation-description-'.$_i.'="'.esc_attr($_validation_pattern['description']).'"' : '').
				          (($_validation_pattern['regex']) ? ' data-validation-regex-'.$_i.'="'.esc_attr($_validation_pattern['regex']).'"' : '').
				          ((isset($_validation_pattern['minimum'])) ? ' data-validation-minimum-'.$_i.'="'.esc_attr((string)$_validation_pattern['minimum']).'"' : '').
				          ((isset($_validation_pattern['maximum'])) ? ' data-validation-maximum-'.$_i.'="'.esc_attr((string)$_validation_pattern['maximum']).'"' : '').
				          ((isset($_validation_pattern['min_max_type'])) ? ' data-validation-min-max-type-'.$_i.'="'.esc_attr($_validation_pattern['min_max_type']).'"' : '');
			unset($_i, $_validation_pattern); // Just a little housekeeping.

			return $attrs; // Return all attributes now.
		}

		/**
		 * Checks a field's configuration options.
		 *
		 * @param null|string (or scalar)|array $field_value The current value(s) for this field.
		 *    If there is NO current value, set this to NULL so default values are considered properly.
		 *    That is, default values are only implemented if `$value` is currently NULL.
		 *
		 * @note The current `$field_value` will be piped through {@link value()} and/or {@link values()}.
		 *    In other words, we convert the `$field_value` into a NULL/string/array; depending upon the `type` of form field.
		 *    The current `call` action will also considered if this instance is associated with one.
		 *    See: {@link value()} and {@link values()} for further details.
		 *
		 * @param array                         $field The array of field configuration options.
		 *
		 * @return array A fully validated and completely standardized configuration array.
		 *    Otherwise, we throw an exception on any type of validation failure.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If invalid types are found in the configuration array.
		 * @throws exception If required config options are missing.
		 */
		public function check_config($field_value, $field)
		{
			$this->check_arg_types(array('null', 'scalar', 'array'), 'array:!empty', func_get_args());

			$value  = $this->value($field_value); // String (or NULL by default).
			$values = $this->values($field_value); // Array (or NULL by default).

			foreach($this->defaults as $_key => $_default) // Validate types.
				if(array_key_exists($_key, $field) && !is_null($_default) && gettype($field[$_key]) !== gettype($_default))
					throw $this->©exception( // There's a problem with this key.
						$this->method(__FUNCTION__).'#invalid_key', get_defined_vars(),
						sprintf($this->__('Form field. Invalid key: `%1$s`.'), $_key).
						' '.sprintf($this->__('Invalid field configuration: `%1$s`.'), $this->©var->dump($field)).
						' '.sprintf($this->__('Defaults: `%1$s`.'), $this->©var->dump($this->defaults))
					);
			unset($_key, $_default); // Just a little housekeeping.

			$field = array_merge($this->defaults, $field); // Merge with defaults.

			// Handle field types.

			if(!$field['type'])
				throw $this->©exception(
					$this->method(__FUNCTION__).'#type_missing', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing `type`).')
				);
			if(!in_array($field['type'], $this->types, TRUE))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_type', get_defined_vars(),
					$this->__('Form field. Invalid configuration (invalid `type`).')
				);
			if($field['confirm'] && !in_array($field['type'], $this->confirmable_types, TRUE))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_type', get_defined_vars(),
					$this->__('Form field. Invalid configuration (NOT a confirmable `type`).')
				);
			// Handle field names (and we consider a name prefix here too).

			if(!$field['name'])
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_name', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing `name`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['name'])
				);
			if(!preg_match('/^(?:[a-z][a-z0-9_]*?[a-z0-9]|[a-z])(?:\[(?:[a-z][a-z0-9_]*?[a-z0-9]|[1-9][0-9]+|[0-9]|[a-z])\])*$/i', $field['name_prefix'].$field['name']))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_name_prefix_name', get_defined_vars(),
					$this->__('Form field. Invalid configuration (invalid `name_prefix`.`name`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['name_prefix'].$field['name'])
				);
			// Handle field end name/code.

			if(!$field['code']) // Auto-generate end name/code.
			{
				$field['code'] = str_replace(array('[', ']'), '/', $field['name']);
				$field['code'] = basename(rtrim($field['code'], '/'));
			}
			if(!isset($field['code'][0])) // Allow `[0] = 0`.
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_code', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing `code`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['code'])
				);
			if(!preg_match('/^(?:[a-z][a-z0-9_]*?[a-z0-9]|[1-9][0-9]+|[0-9]|[a-z])$/i', $field['code']))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_code', get_defined_vars(),
					$this->__('Form field. Invalid configuration (invalid `code`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['code'])
				);
			// Handle field ID values.

			if(!$field['id']) // We can auto-generate IDs based on class object hash & field name.
				// NOTE: auto-generated IDs will NEVER be the same from one page view to the next.
				$field['id'] = 'o'.$this->spl_object_hash.'-'.md5($field['name']);

			if(!$field['id'])
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_id', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing `id`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['id'])
				);
			if(!preg_match('/^(?:[a-z][a-z0-9\-]*?[a-z0-9]|[a-z])$/i', $field['id_prefix'].$field['id']))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_id_prefix_id', get_defined_vars(),
					$this->__('Form field. Invalid configuration (invalid `id_prefix`.`id`).').
					' '.sprintf($this->__('Got: `%1$s`.'), $field['id_prefix'].$field['id'])
				);
			// Handle field options.

			$field['options'] = array_values($field['options']);
			$_option_defaults = array('label' => '', 'value' => '', 'is_default' => FALSE);

			foreach($field['options'] as &$_option)
			{
				$_option = array_merge($_option_defaults, (array)$_option);

				if(!$this->©strings->are_set($_option['label'], $_option['value']) || !is_bool($_option['is_default']))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_options', get_defined_vars(),
						$this->__('Form field. Invalid configuration (invalid `options`).')
					);
			}
			unset($_option_defaults, $_option); // Housekeeping.

			if(in_array($field['type'], $this->types_with_options, TRUE) && !$field['options'])
				throw $this->©exception(
					$this->method(__FUNCTION__).'#options_missing', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing `options`).')
				);
			// Handle unique fields (validate PHP callback).

			if($field['unique'] && !is_callable($field['unique_callback_php']))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#missing_unique_callback_php', get_defined_vars(),
					$this->__('Form field. Invalid configuration (missing and/or invalid `unique_callback_php`).').
					' '.sprintf($this->__('Expecting callable. Got: `%1$s`.'), $this->©var->dump($field['unique_callback_php']))
				);
			// Handle validation patterns.

			$_validation_pattern_defaults = array(
				'name'    => '', 'description' => '', 'regex' => '',
				'minimum' => NULL, 'maximum' => NULL, 'min_max_type' => NULL);
			$field['validation_patterns'] = array_values($field['validation_patterns']);

			foreach($field['validation_patterns'] as &$_validation_pattern)
			{
				$_validation_pattern = array_merge($_validation_pattern_defaults, (array)$_validation_pattern);
				if((!$this->©strings->are_not_empty($_validation_pattern['name'], $_validation_pattern['description'], $_validation_pattern['regex']))
				   || (!is_null($_validation_pattern['minimum']) && !is_numeric($_validation_pattern['minimum']))
				   || (!is_null($_validation_pattern['maximum']) && !is_numeric($_validation_pattern['maximum']))
				   || (!is_null($_validation_pattern['min_max_type']) && !$this->©string->is_not_empty($_validation_pattern['min_max_type']))
				) throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_validation_patterns', get_defined_vars(),
					$this->__('Form field. Invalid configuration (invalid `validation_patterns`).')
				);
			}
			unset($_validation_pattern_defaults, $_validation_pattern); // Housekeeping.

			// Handle field titles.

			if(!$field['title'] && $field['placeholder']) $field['title'] = rtrim($field['placeholder'], '.');
			else if(!$field['title'] && in_array($field['type'], $this->button_types, TRUE) && is_string($value))
				$field['title'] = trim(strip_tags($value)); // Use button value.

			// Handle common classes.

			if(($field['classes'] = trim($field['classes']))) $field['classes'] = ' '.$field['classes'];
			if($this->common_classes) $field['classes'] .= ' '.$this->common_classes;

			// Handle common attributes.

			if(($field['attrs'] = trim($field['attrs']))) $field['attrs'] = ' '.$field['attrs'];
			if($this->common_attrs) $field['attrs'] .= ' '.$this->common_attrs;

			return $field; // Standardized now.
		}

		/**
		 * Gets a string form field value.
		 *
		 * @note This considers the current action call (if this instance is associated with one).
		 *
		 * @param mixed $value A variable (always by reference).
		 *    See {@link ¤value()}, to pass a variable and/or an expression.
		 *
		 * @note A boolean FALSE is converted into a `0` string representation.
		 *
		 * @return string|null A string if `$value` is scalar, or this is the current action.
		 *    Else this returns NULL by default, so that default form field values can be considered properly.
		 */
		public function value(&$value)
		{
			if(is_scalar($value))
				return ($value === FALSE) ? '0' : (string)$value;

			if($this->is_action_for_call)
				return '';

			return NULL;
		}

		/**
		 * Same as {@link value()}, but this allows an expression.
		 *
		 * @param mixed $value A variable (or an expression).
		 *
		 * @return string|null See {@link value()} for further details.
		 */
		public function ¤value($value)
		{
			return $this->value($value);
		}

		/**
		 * Gets an array of form field values.
		 *
		 * @note This considers the current action call (if this instance is associated with one).
		 *
		 * @param mixed $values A variable (always by reference).
		 *    See {@link ¤values()}, to pass a variable and/or an expression.
		 *
		 * @return array|null An array if `$values` is an array, or this is the current action.
		 *    Else this returns NULL by default, so that default form field values can be considered properly.
		 */
		public function values(&$values)
		{
			if(is_array($values))
				return $values;

			if($this->is_action_for_call)
				return array();

			return NULL;
		}

		/**
		 * Same as {@link values()}, but this allows an expression.
		 *
		 * @param mixed $values A variable (or an expression).
		 *
		 * @return array|null See {@link values()} for further details.
		 */
		public function ¤values($values)
		{
			return $this->values($values);
		}
	}
}