/*!
 * WebSharks Core™; copyright 2014 WebSharks, Inc.
 * GPL license <https://github.com/websharks/core>
 */
/**
 * XDaRk Core Scripts
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */

/* ----------------------------------------------------------------------------------------------------------------------------------------
 * This is phase one; XDaRk Core class definition.
 * ------------------------------------------------------------------------------------------------------------------------------------- */

(function($) // Begin XDaRk Core closure.
{
	'use strict'; // Strict standards.

	/**
	 * @type {Object} Core class definition.
	 */
	window.$$xd_v141226_dev = window.$$xd_v141226_dev || {};
	var $$xd = window.$$xd_v141226_dev;
	if(typeof $$xd.$$ === 'function')
		return; // Core already exists.

	/**
	 * @constructor XDaRk Core constructor.
	 *
	 * @note This is called by the XDaRk Core constructor.
	 *    It sets up dynamic property values available only at runtime.
	 *
	 * @param {String} [plugin_root_ns] Plugin's root namespace.
	 *    Optional. Defaults to the core itself; bypass with an empty string.
	 *
	 * @param {String} [extension] The name of the extension to generate.
	 *    Optional; defaults to a value of `$`; i.e. the default extension namespace.
	 *
	 * @class $$xd.$$
	 */
	$$xd.$$ = function(plugin_root_ns, extension)
	{
		var core_ns = 'xd_v141226_dev'; // Must hard code.
		if(typeof plugin_root_ns !== 'string' || !plugin_root_ns)
			plugin_root_ns = core_ns; // The core itself.

		if(typeof extension !== 'string' || !extension)
			extension = '$'; // Default extension namespace.

		/**
		 * @type {Object} All `is...()` type checks.
		 */
		this.___is_type_checks = {
			'string'       : 'is_string',
			'!string'      : 'is_string',
			'string:!empty': 'is_string',

			'boolean'       : 'is_boolean',
			'!boolean'      : 'is_boolean',
			'boolean:!empty': 'is_boolean',

			'bool'       : 'is_boolean',
			'!bool'      : 'is_boolean',
			'bool:!empty': 'is_boolean',

			'integer'       : 'is_integer',
			'!integer'      : 'is_integer',
			'integer:!empty': 'is_integer',

			'float'       : 'is_float',
			'!float'      : 'is_float',
			'float:!empty': 'is_float',

			'number'       : 'is_number',
			'!number'      : 'is_number',
			'number:!empty': 'is_number',

			'numeric'       : 'is_numeric',
			'!numeric'      : 'is_numeric',
			'numeric:!empty': 'is_numeric',

			'array'       : 'is_array',
			'!array'      : 'is_array',
			'array:!empty': 'is_array',

			'function'       : 'is_function',
			'!function'      : 'is_function',
			'function:!empty': 'is_function',

			'xml'       : 'is_xml',
			'!xml'      : 'is_xml',
			'xml:!empty': 'is_xml',

			'object'       : 'is_object',
			'!object'      : 'is_object',
			'object:!empty': 'is_object',

			'null'       : 'is_null',
			'!null'      : 'is_null',
			'null:!empty': 'is_null',

			'undefined'       : 'is_undefined',
			'!undefined'      : 'is_undefined',
			'undefined:!empty': 'is_undefined'
		};

		/**
		 * @type {String} Represents a `public` type.
		 */
		this.___public_type = '___public_type___';

		/**
		 * @type {String} Represents a `protected` type.
		 */
		this.___protected_type = '___protected_type___';

		/**
		 * @type {String} Represents a `private` type.
		 */
		this.___private_type = '___private_type___';

		/**
		 * @type {Object} Instance cache.
		 */
		this.cache = {}; // Initialize object cache.

		/**
		 * @type {Object} Current plugin root namespaces.
		 */
		this.___plugin_root_namespaces = [];

		// Build the dynamic `___plugin_root_namespaces` property.
		// Only the core's default `$` extension has this array.

		if(plugin_root_ns === core_ns && extension === '$')
			if(typeof window['$' + core_ns + '___plugin_root_namespaces'] === 'object')
				if(window['$' + core_ns + '___plugin_root_namespaces'] instanceof Array)
					this.___plugin_root_namespaces = window['$' + core_ns + '___plugin_root_namespaces'];

		/**
		 * @type {Object} Current instance configuration.
		 */
		this.___instance = {plugin_js_extension_ns: extension};

		// Build the dynamic `___instance` property.

		if(typeof window['$' + core_ns + '___instance'] === 'object')
			$.extend(this.___instance, window['$' + core_ns + '___instance']);

		if(typeof window['$' + plugin_root_ns + '___instance'] === 'object')
			$.extend(this.___instance, window['$' + plugin_root_ns + '___instance']);

		/**
		 * @type {Object} Current translations.
		 */
		this.___i18n = {}; // Initialize.

		// Build the dynamic `___i18n` property.

		if(typeof window['$' + core_ns + '___i18n'] === 'object')
			$.extend(this.___i18n, window['$' + core_ns + '___i18n']);

		if(typeof window['$' + core_ns + '__' + extension + '___i18n'] === 'object')
			$.extend(this.___i18n, window['$' + core_ns + '__' + extension + '___i18n']);

		// Build the dynamic `___i18n` property; allow plugins to override.

		if(typeof window['$' + plugin_root_ns + '___i18n'] === 'object')
			$.extend(this.___i18n, window['$' + plugin_root_ns + '___i18n']);

		if(typeof window['$' + plugin_root_ns + '__' + extension + '___i18n'] === 'object')
			$.extend(this.___i18n, window['$' + plugin_root_ns + '__' + extension + '___i18n']);

		/**
		 * @type {Object} Current verifiers.
		 */
		this.___verifiers = {}; // Initialize.

		// Build the dynamic `___verifiers` property.

		if(typeof window['$' + plugin_root_ns + '___verifiers'] === 'object')
			$.extend(this.___verifiers, window['$' + plugin_root_ns + '___verifiers']);

		if(typeof window['$' + plugin_root_ns + '__' + extension + '___verifiers'] === 'object')
			$.extend(this.___verifiers, window['$' + plugin_root_ns + '__' + extension + '___verifiers']);
	};

	/**
	 * Builds a new extension of the core prototype.
	 *
	 * @param {String} plugin_root_ns Plugin's root namespace.
	 *    Optional. Defaults to the core itself; bypass with an empty string.
	 *
	 * @param {String} extension The name of the extension to generate (required).
	 *
	 * @return $$xd.$$ Extension class (required); extends core prototype.
	 *    The class will NOT be instantiated here. That's for the caller to handle.
	 *
	 * ``` // Example usage.
	 * var extension = $xd.$.extension('plugin_root_ns', 'extension');
	 * $plugin_root_ns.$extension = new extension();
	 * ```
	 * @note Class for a plugin extension is stored as follows: `$$plugin.$$extension`.
	 * @note Class for a core extension is stored as follows: `$$xd.$$extension`.
	 */
	$$xd.$$.prototype.extension_class = function(plugin_root_ns, extension)
	{
		this.check_arg_types('string', 'string:!empty', arguments, 2);

		if(!this.is_default_core_extension()) // Only the core may call this.
			throw this.sprintf(this.__('core_only_failure'), 'extension_class');

		if(plugin_root_ns && plugin_root_ns !== this.instance('core_ns'))
		{
			window['$$' + plugin_root_ns] = window['$$' + plugin_root_ns] || {};
			window['$$' + plugin_root_ns]['$$' + extension] = function(){}; // Class constructor.
			window['$$' + plugin_root_ns]['$$' + extension].prototype = new $$xd.$$(plugin_root_ns, extension);
			window['$$' + plugin_root_ns]['$$' + extension].prototype.constructor = window['$$' + plugin_root_ns]['$$' + extension];

			return window['$$' + plugin_root_ns]['$$' + extension]; // e.g. `$$plugin.$$extension`.
		}
		else if(extension !== '$') // The core itself. No need for another global variable in this case.
		{
			$$xd['$$' + extension] = function(){}; // Class constructor.
			$$xd['$$' + extension].prototype = new $$xd.$$('', extension);
			$$xd['$$' + extension].prototype.constructor = $$xd['$$' + extension];

			return $$xd['$$' + extension]; // e.g. `$$xd.$$extension`.
		}
		throw 'extension === $'; // This should not happen.
	};

	/**
	 * Get instance configuration property.
	 *
	 * @param {String} key Key to get.
	 *
	 * @return {String|Array|Object|Number|Boolean}
	 */
	$$xd.$$.prototype.instance = function(key)
	{
		if(typeof this.___instance[key] === 'string')
			return this.___instance[key];

		throw this.sprintf(this.__('instance__failure'), key);
	};

	/**
	 * Constructs a core namespace-prefixed string.
	 *
	 * @param {String} string String to prefix.
	 *
	 * @return {String} Prefixed string.
	 */
	$$xd.$$.prototype.core = function(string)
	{
		if(!this.cache.core_ns_with_dashes) // Prevent a 2nd function call each time.
			this.cache.core_ns_with_dashes = this.instance('core_ns_with_dashes');
		return this.cache.core_ns_with_dashes + string;
	};

	/**
	 * JavaScript equivalent to PHP's `sprintf()` function.
	 *
	 * @see http://cdnjs.cloudflare.com/ajax/libs/sprintf/0.0.7/sprintf.js
	 *
	 * @returns {String}
	 */
	$$xd.$$.prototype.sprintf = function()
	{
		return window[this.core('->sprintf')].apply(window, arguments);
	};

	/**
	 * JavaScript equivalent to PHP's `vsprintf()` function.
	 *
	 * @see http://cdnjs.cloudflare.com/ajax/libs/sprintf/0.0.7/sprintf.js
	 *
	 * @returns {String}
	 */
	$$xd.$$.prototype.vsprintf = function()
	{
		return window[this.core('->vsprintf')].apply(window, arguments);
	};

	/**
	 * Get string verifier property.
	 *
	 * @param {String} key Key to get.
	 *
	 * @return {String}
	 */
	$$xd.$$.prototype.verifier = function(key)
	{
		if(typeof this.___verifiers[key] === 'string')
			return this.___verifiers[key];

		throw this.sprintf(this.__('verifier__failure'), key);
	};

	/**
	 * Get i18n string translation property.
	 *
	 * @param {String} key Key to get.
	 *
	 * @return {String}
	 */
	$$xd.$$.prototype.__ = function(key)
	{
		if(typeof this.___i18n[key] === 'string')
			return this.___i18n[key];

		throw this.sprintf(this.___i18n['____failure'], key);
	};

	/**
	 * Test for string type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_string = function(v)
	{
		return (typeof v === 'string');
	};

	/**
	 * Test for boolean type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_boolean = function(v)
	{
		return (typeof v === 'boolean');
	};

	/**
	 * Test for integer type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_integer = function(v)
	{
		return (typeof v === 'number' && !isNaN(v) && String(v).indexOf('.') === -1);
	};

	/**
	 * Test for float type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_float = function(v)
	{
		return (typeof v === 'number' && !isNaN(v) && String(v).indexOf('.') !== -1);
	};

	/**
	 * Test for number type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_number = function(v)
	{
		return (typeof v === 'number' && !isNaN(v));
	};

	/**
	 * Test for numeric type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_numeric = function(v)
	{
		return ((typeof(v) === 'number' || typeof(v) === 'string') && v !== '' && !isNaN(v));
	};

	/**
	 * Test for array type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_array = function(v)
	{
		return (v instanceof Array);
	};

	/**
	 * Test for function type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_function = function(v)
	{
		return (typeof v === 'function');
	};

	/**
	 * Test for XML type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_xml = function(v)
	{
		return (typeof v === 'xml');
	};

	/**
	 * Test for object type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_object = function(v)
	{
		return (typeof v === 'object');
	};

	/**
	 * Test for NULL type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_null = function(v)
	{
		return (typeof v === 'null');
	};

	/**
	 * Test for undefined type.
	 *
	 * @param {*} v
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.is_undefined = function(v)
	{
		return (typeof v === 'undefined');
	};

	/**
	 * JavaScript equivalent to PHP's `isset()` function.
	 *
	 * @note Like PHP, this accepts a variable-length list of arguments.
	 *
	 * @return {Boolean} False if any of the arguments are `undefined` or `null`.
	 *    i.e. Only returns true if all of the arguments ARE set.
	 */
	$$xd.$$.prototype.isset = function()
	{
		for(var _i = 0; _i < arguments.length; _i++)
			if(arguments[_i] === undefined || arguments[_i] === null)
				return false;
		return true;
	};

	/**
	 * JavaScript equivalent to PHP's `empty()` function.
	 *
	 * This is NOT a substitute for `typeof` checks.
	 * We do NOT consider the string `undefined` to be empty.
	 *    Use `if(typeof X === 'undefined')` please.
	 *
	 * @note Unlike PHP, this accepts a variable-length list of arguments.
	 *
	 * @return {Boolean} True if any of the arguments are empty.
	 *    i.e. False if all arguments are NOT empty.
	 */
	$$xd.$$.prototype.empty = function()
	{
		empty: // Main iteration loop.
			for(var _i = 0, _p; _i < arguments.length; _i++)
			{
				if(arguments[_i] === '' || arguments[_i] === 0 || arguments[_i] === '0'
				   || arguments[_i] === null || arguments[_i] === false) return true;

				else if(typeof arguments[_i] === 'undefined')
				// Note that we do NOT consider the string `undefined` to be empty.
					return true; // An undefined data value type.

				else if(arguments[_i] instanceof Array && !arguments[_i].length)
					return true; // An empty array.

				else if(typeof arguments[_i] == 'object')
				{
					for(_p in arguments[_i])
						continue empty;
					return true; // Object empty.
				}
			}
		return false;
	};

	/**
	 * The default XDaRk Core extension?
	 *
	 * @return {Boolean} True if this is the default XDaRk Core extension.
	 */
	$$xd.$$.prototype.is_default_core_extension = function()
	{
		return (this.instance('plugin_root_ns') === this.instance('core_ns')
		        && this.instance('plugin_js_extension_ns') === '$');
	};

	/**
	 * Quotes regex meta characters.
	 *
	 * @param {String} string
	 * @param [delimiter] {String|undefined}
	 *
	 * @return {String}
	 */
	$$xd.$$.prototype.preg_quote = function(string, delimiter)
	{
		this.check_arg_types('string', 'string', arguments, 1);

		delimiter = delimiter ? '\\' + delimiter : ''; // Make this is a string value.
		return string.replace(new RegExp('[.\\\\+*?[\\^\\]$(){}=!<>|:\\-' + delimiter + ']', 'g'), '\\$&');
	};

	/**
	 * Escapes HTML special chars.
	 *
	 * @param {String} string
	 *
	 * @return {String}
	 */
	$$xd.$$.prototype.esc_html = $$xd.$$.prototype.esc_attr = function(string)
	{
		this.check_arg_types('string', arguments, 1);

		if(/[&<>"']/.test(string))
		{
			string = string.replace(/&/g, '&amp;');
			string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');
			string = string.replace(/"/g, '&quot;').replace(/'/g, '&#039;');
		}
		return string;
	};

	/**
	 * Escapes variables for use in jQuery™ attribute selectors.
	 *
	 * @param {String} string
	 *
	 * @return {String}
	 */
	$$xd.$$.prototype.esc_jq_attr = function(string)
	{
		this.check_arg_types('string', arguments, 1);

		return string.replace(/([.:\[\]])/g, '\\$1');
	};

	/**
	 * Dashes replace non-alphanumeric chars.
	 *
	 * @param {String} string Any input string value.
	 *
	 * @return {String} Dashes replace non-alphanumeric chars.
	 *    Escape characters `\` are converted into double dashes.
	 */
	$$xd.$$.prototype.with_dashes = function(string)
	{
		this.check_arg_types('string', arguments, 1);

		string = string.replace(/\\/g, '--');
		string = string.replace(/[^a-z0-9]/gi, '-');

		return string; // With underscores.
	};

	/**
	 * Underscores replace non-alphanumeric chars.
	 *
	 * @param {String} string Any input string value.
	 *
	 * @return {String} Underscores replace non-alphanumeric chars.
	 *    Escape characters `\` are converted into double underscores.
	 */
	$$xd.$$.prototype.with_underscores = function(string)
	{
		this.check_arg_types('string', arguments, 1);

		string = string.replace(/\\/g, '__');
		string = string.replace(/[^a-z0-9]/gi, '_');

		return string; // With underscores.
	};

	/**
	 * Platform detection (no longer available in jQuery).
	 *
	 * @returns {Object} An object with a possible property matching one or more
	 *    of the following user agents: `chrome`, `webkit`, `opera`, `msie`, and/or `mozilla`.
	 */
	$$xd.$$.prototype.browser = function()
	{
		if(this.cache.browser)
			return this.cache.browser;

		var ua_match = function()
		{
			var ua = navigator.userAgent.toLowerCase();
			var match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
			            /(webkit)[ \/]([\w.]+)/.exec(ua) ||
			            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
			            /(msie) ([\w.]+)/.exec(ua) ||
			            ua.indexOf('compatible') === -1 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) ||
			            []; // Default to an empty array; i.e. failure to detect browser.
			return {browser: match[1] || '', version: match[2] || '0'};
		};
		var matched = ua_match();
		this.cache.browser = {};
		if(matched.browser)
		{
			this.cache.browser[matched.browser] = true;
			this.cache.browser.version = matched.version;
		}
		if(this.cache.browser.chrome) this.cache.browser.webkit = true;
		else if(this.cache.browser.webkit) this.cache.browser.safari = true;

		return this.cache.browser;
	};

	/**
	 * Gets closest theme CSS class (for current plugin).
	 *
	 * @note The search begins with `to` (and may also end at `to`, if it contains a theme CSS class).
	 *    The search continues with jQuery™ `parents()`; the search will fail if no parents have a theme class.
	 *
	 * @param {Node|Object|String} object The object to start from.
	 *
	 * @return {String} CSS class name. The full class name; including the plugin's root namespace.
	 */
	$$xd.$$.prototype.closest_theme_class_to = function(object)
	{
		this.check_arg_types(['object', 'string:!empty'], arguments, 1);

		var theme_class = '', // Initialize working variables.
			core_ns_with_dashes = this.instance('core_ns_with_dashes'),
			plugin_root_ns_with_dashes = this.instance('plugin_root_ns_with_dashes');

		$(object).add($(object).parents('.' + plugin_root_ns_with_dashes))
			.each(function() // Begin iterations (we have two here).
			      {
				      $.each(String($(this).attr('class')).split(/\s+/), function(_i, _class)
				      {
					      if(_class.indexOf(plugin_root_ns_with_dashes + '--t--') === 0)
						      theme_class = _class.replace(plugin_root_ns_with_dashes + '--t--', '');
					      return (theme_class) ? false : true;
				      });
				      return (theme_class) ? false : true;
			      });
		if(theme_class) // Found a theme?
			return core_ns_with_dashes + '--t--' + theme_class + ' ' + plugin_root_ns_with_dashes + '--t--' + theme_class;
		return ''; // Default (empty string on failure).
	};

	/**
	 * Prepare forms; i.e. add a few JS enhancements.
	 */
	$$xd.$$.prototype.enhance_forms = function()
	{
		var _ = this, // Initialize working variables.
			$forms = $('.' + _.instance('plugin_root_ns_with_dashes') + ' form');

		// Chrome & Safari autofills.

		if(_.browser().webkit) // Is this a webkit browser?
		{
			var autofill = {interval_time: 100, intervals: 0, max_intervals: 50};

			autofill.interval = setInterval((autofill.handler = function()
			{
				autofill.intervals++; // Increments counter.

				if((!autofill.$fields || !autofill.$fields.length)
				   && (autofill.$fields = $forms.find('input:-webkit-autofill').filter('[autocomplete="off"]')).length)
				{
					clearInterval(autofill.interval), autofill.$fields
						.each(function() // Do our best to disable autofill here.
						      {
							      var $this = $(this), $clone = $this.clone(true);
							      var value = $clone.val(), initial_value = $clone.data('initial-value');

							      if(value && initial_value !== undefined && initial_value === '')
								      $clone.val(''); // Remove autofilled value.

							      if($clone.attr('type') === 'password') // Use text w/ security.
								      $clone.attr('type', 'text').css({'-webkit-text-security': 'disc'});

							      $this.after($clone).remove();
						      });
				}
				if(autofill.intervals > autofill.max_intervals)
					clearInterval(autofill.interval);

			}), autofill.interval_time);

			setTimeout(autofill.handler, 50);
		}
		// Password strength/mismatch indicators.

		var password_strength_mismatch_status = function(password1, password2)
		{
			_.check_arg_types('string', 'string', arguments, 2);

			var score = 0; // Initialize score.

			if((password1 != password2) && password2.length > 0)
				return 'mismatch';
			else if(password1.length < 1)
				return 'empty';
			else if(password1.length < 6)
				return 'short';

			if(/[0-9]/.test(password1))
				score += 10;
			if(/[a-z]/.test(password1))
				score += 10;
			if(/[A-Z]/.test(password1))
				score += 10;
			if(/[^0-9a-zA-Z]/.test(password1))
				score = (score === 30) ? score + 20 : score + 10;

			if(score < 30) return 'weak';
			if(score < 50) return 'good';

			return 'strong'; // Default return value.
		};
		$forms.find(':input[type="password"][data-confirm="true"]')
			.each(function() // Handles password strength/mismatch indicators.
			      {
				      var progress_bar_status = {
					      'empty'   : '', // n/a
					      'short'   : 'danger',
					      'weak'    : 'warning',
					      'good'    : 'info',
					      'strong'  : 'success',
					      'mismatch': 'warning'
				      };
				      var $password1 = $(this), $password2 = $password1.next(':input[type="password"][data-confirm!="true"]');
				      var $progress = $('<div class="progress clear em-t-margin text-center"><div class="width-100"></div></div>');
				      var $progress_bar = $progress.find('> div');

				      $password2.closest('.form-group').append($progress),
					      $password1.add($password2).keyup(function() // Handles `keyup` events & initialization.
					                                       {
						                                       var strength_mismatch_status // `empty`, `short`, `weak`, `good`, `strong`, or `mismatch`.
							                                       = password_strength_mismatch_status($.trim(String($password1.val())), $.trim(String($password2.val())));

						                                       if(strength_mismatch_status === 'empty') // Fields empty.
							                                       $progress_bar.attr('class', 'progress-bar no-bg color-inherit width-100')
								                                       .html(_.__('password_strength_status__' + strength_mismatch_status));

						                                       else $progress_bar.attr('class', 'progress-bar progress-bar-' + progress_bar_status[strength_mismatch_status] + ' width-100')
							                                       .html(_.__('password_strength_status__' + strength_mismatch_status));
					                                       })
						      .trigger('keyup'); // Trigger immediately.
			      });
		// Form field validation handlers.
		// Here we position validation errors when/if the DOM includes them (i.e. from the server-side).
		// We also attach an onsubmit form field validation handler too (i.e. client-side JavaScript validation).

		$forms.each(function() // Iteration over each form.
		            {
			            var $form = $(this), $response_errors = $form.prevAll('.responses.errors');

			            $response_errors.find('> ul > li[data-form-field-code]')// Those w/ a form-field-code.
				            .each(function() // Iterate over each error that includes a form-field-code.
				                  {
					                  var $this = $(this), form_field_code,
						                  $input, $closest_form_group, $validation_errors;

					                  if(!(form_field_code = $this.attr('data-form-field-code')))
						                  return; // Leave error in its current location.

					                  if(!($input = $form.find(':input[name="' + _.esc_jq_attr(form_field_code) + '"],' +
					                                           ':input[name$="' + _.esc_jq_attr('[' + form_field_code + ']') + '"],' +
					                                           ':input[name$="' + _.esc_jq_attr('[' + form_field_code + '][]') + '"]')
							                  .first()).length) // First in this form.
						                  return; // Leave error in its current location.

					                  if(!($closest_form_group = $input.closest('.form-group')).length)
						                  return; // Leave error in its current location.

					                  if(($validation_errors = $closest_form_group.find('.validation-errors')).length)
					                  {
						                  $this.clone().appendTo($validation_errors.find('> ul'));
						                  $this.remove(); // Remove original error.
					                  }
					                  else // We need to create a new set of response validation errors (none exist yet).
					                  {
						                  $validation_errors = $(// Validation errors.
							                  '<div class="validation-errors alert alert-danger em-x-margin em-padding font-90">' +
							                  '<ul></ul>' + // Empty for now.
							                  '</div>'
						                  ); // Now add the <li> tags.
						                  $this.clone().appendTo($validation_errors.find('> ul'));
						                  $this.remove(); // Remove original error.

						                  _.expand_collapsible_parents_of($closest_form_group); // Visible.
						                  if($closest_form_group.has('.input-group').length === 1) // Has an input group?
							                  $closest_form_group.find('.input-group').after($validation_errors); // Validation errors.
						                  else $closest_form_group.append($validation_errors); // Validation errors.
					                  }
				                  }); // Don't leave the response errors completely empty.
			            $response_errors.find('> ul:empty').append('<li><i class="fa fa-exclamation-triangle"></i> ' + _.__('validate_form__check_issues_below') + '</li>');
		            });
		$forms.attr({'novalidate': 'novalidate'})// Disables HTML 5 validation via browser.
			.on('submit', function() // This uses our own form field validation handler instead of the browser's.
			    {
				    return _.validate_form(this);
			    });
	};

	/**
	 * Validates form fields (VERY complex).
	 *
	 * @note This function may ONLY be called upon the core itself.
	 *
	 * @note This is an EXTREMELY COMPLEX routine that should NOT be modified without serious consideration.
	 *    See standards here: \xd_v141226_dev\form_fields in the XDaRk Core.
	 *
	 * @param {Node|Object|String} context
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.validate_form = function(context)
	{
		this.check_arg_types(['object', 'string:!empty'], arguments, 1);

		var _ = this; // Self reference.
		var confirmation_errors = {}, unique_value_errors = {},
			required_minimum_errors = {}, rc_required_minimum_errors = {}, validation_errors = {};

		$('div.validation-errors', context).remove(); // Remove any existing errors.

		$(':input[data-confirm="true"]', context)// Validation routine (for field confirmations).
			.each(function() // Checks form fields that request user confirmation (e.g. we look for mismatched fields).
			      {
				      var $this = $(this), $field1 = $this,
					      $field2 = $field1.next(':input[data-confirm!="true"]');

				      if(!$field1.length || !$field2.length)
					      throw '!$field1.length || !$field2.length';

				      if($field1.attr('readonly') || $field2.attr('readonly'))
					      return; // One of these is NOT even enabled (do nothing in this case).

				      if($field1.attr('disabled') || $field2.attr('disabled'))
					      return; // One of these is NOT even enabled (do nothing in this case).

				      var id = $field1.attr('id');
				      if(!id || !_.is_string(id))
					      return; // Must have an ID.
				      else id = id.replace(/\-{3}[0-9]+$/, '');

				      confirmation_errors[id] = confirmation_errors[id] || [];

				      var name = $field1.attr('name');
				      if(!name || !_.is_string(name))
					      return; // Must have a name.

				      var tag_name = $field1.prop('tagName');
				      if(!tag_name || !_.is_string(tag_name))
					      return; // Must have a tag name.
				      else tag_name = tag_name.toLowerCase();

				      var type = $field1.attr('type'); // May need this below (for input tags).
				      if(tag_name === 'input') // Must have a type for input tags.
					      if(!type || !_.is_string(type))
						      return; // Must have a type.
					      else type = type.toLowerCase();

				      if($.inArray(tag_name, ['button']) !== -1)
					      return; // We do NOT compare buttons.

				      if(tag_name === 'input' && $.inArray(type, ['hidden', 'file', 'radio', 'checkbox', 'image', 'button', 'reset', 'submit']) !== -1)
					      return; // We do NOT compare any of these input types.

				      // NOTE: It's possible for either of these values to be empty (perfectly OK).

				      var field1_value = $field1.val(); // Possible array.
				      if(_.is_number(field1_value)) field1_value = String(field1_value); // Force numeric string.
				      if(_.is_string(field1_value)) field1_value = $.trim(field1_value); // Trim string value.

				      var field2_value = $field2.val(); // Possible array.
				      if(_.is_number(field2_value)) field2_value = String(field2_value); // Force numeric string.
				      if(_.is_string(field2_value)) field2_value = $.trim(field2_value); // Trim string value.

				      if(field1_value !== field2_value) // Values are a mismatch?
					      confirmation_errors[id].push(_.__('validate_form__mismatch_fields'));
			      });
		$(':input[data-unique]', context)// Validation routine (for fields that MUST be unique).
			.each(function() // Checks form fields that require unique values (this relies upon callbacks).
			      {
				      var $this = $(this); // jQuery object instance.

				      if($this.attr('readonly') || $this.attr('disabled'))
					      return; // It's NOT even enabled (or it's read-only).

				      var id = $this.attr('id');
				      if(!id || !_.is_string(id))
					      return; // Must have an ID.
				      else id = id.replace(/\-{3}[0-9]+$/, '');

				      unique_value_errors[id] = unique_value_errors[id] || [];

				      var name = $this.attr('name');
				      if(!name || !_.is_string(name))
					      return; // Must have a name.

				      var tag_name = $this.prop('tagName');
				      if(!tag_name || !_.is_string(tag_name))
					      return; // Must have a tag name.
				      else tag_name = tag_name.toLowerCase();

				      var type = $this.attr('type'); // May need this below (for input tags).
				      if(tag_name === 'input') // Must have a type for input tags.
					      if(!type || !_.is_string(type))
						      return; // Must have a type.
					      else type = type.toLowerCase();

				      if($.inArray(tag_name, ['button', 'select']) !== -1)
					      return; // Exclude (these are NEVER checked for a unique value).

				      if(tag_name === 'input' && $.inArray(type, ['file', 'radio', 'checkbox', 'image', 'button', 'reset', 'submit']) !== -1)
				      // Notice that we do NOT exclude hidden input fields here.
					      return; // Exclude (these are NEVER checked for a unique value).

				      var callback = $this.attr('data-unique-callback'); // Need this below.
				      if(!callback || !_.is_string(callback) || typeof window[callback] !== 'function')
					      return; // Must have a type.

				      var value = $this.val(); // Possible array.
				      if(_.is_number(value)) value = String(value); // Force numeric string.
				      if(_.is_string(value)) value = $.trim(value); // Trim string value.

				      if(value && _.is_string(value) && !window[callback](value))
					      unique_value_errors[id].push(_.__('validate_form__unique_field'));
			      });
		$(':input[data-required]', context)// Validation routine (for required fields).
			.each(function() // Checks each `data-required` form field (some tag names are handled differently).
			      {
				      var $this = $(this); // jQuery object instance.

				      if($this.attr('readonly') || $this.attr('disabled'))
					      return; // It's NOT even enabled (or it's read-only).

				      var id = $this.attr('id');
				      if(!id || !_.is_string(id))
					      return; // Must have an ID.
				      else id = id.replace(/\-{3}[0-9]+$/, '');

				      required_minimum_errors[id] = required_minimum_errors[id] || [];
				      rc_required_minimum_errors[id] = rc_required_minimum_errors[id] || [];

				      var name = $this.attr('name');
				      if(!name || !_.is_string(name))
					      return; // Must have a name.

				      var tag_name = $this.prop('tagName');
				      if(!tag_name || !_.is_string(tag_name))
					      return; // Must have a tag name.
				      else tag_name = tag_name.toLowerCase();

				      var type = $this.attr('type'); // May need this below (for input tags).
				      if(tag_name === 'input') // Must have a type for input tags.
					      if(!type || !_.is_string(type))
						      return; // Must have a type.
					      else type = type.toLowerCase();

				      if($.inArray(tag_name, ['button']) !== -1)
					      return; // Exclude (these are NEVER required).

				      if(tag_name === 'input' && $.inArray(type, ['image', 'button', 'reset', 'submit']) !== -1)
				      // Notice that we do NOT exclude hidden input fields here.
					      return; // Exclude (these are NEVER required).

				      var value = $this.val(); // Possible array.
				      if(_.is_number(value)) value = String(value); // Force numeric string.
				      if(_.is_string(value)) value = $.trim(value); // Trim string value.

				      var validation_minimum, validation_min_max_type, validation_abs_minimum = null;
				      var _i, files, checked; // For files/radios/checkboxes below.

				      switch(tag_name) // Some tag names are handled a bit differently here.
				      {
					      case 'select': // We also check for multiple selections (i.e. `multiple="multiple"`).

						      if($this.attr('multiple')) // This field allows multiple selections?
						      {
							      if($this.attr('data-validation-name-0')) // Has validators?
							      {
								      for(_i = 0; _i <= 24; _i++) // Iterate validation patterns.
								      {
									      validation_minimum = $this.attr('data-validation-minimum-' + _i);
									      validation_minimum = (_.is_numeric(validation_minimum)) ? Number(validation_minimum) : null;
									      validation_min_max_type = $this.attr('data-validation-min-max-type-' + _i);

									      if(validation_min_max_type === 'array_length' && _.isset(validation_minimum) && validation_minimum > 1)
										      if(!_.isset(validation_abs_minimum) || validation_minimum < validation_abs_minimum)
											      validation_abs_minimum = validation_minimum;
								      }
								      if(_.isset(validation_abs_minimum) && (!_.is_array(value) || value.length < validation_abs_minimum))
									      required_minimum_errors[id].push(_.sprintf(_.__('validate_form__required_select_at_least'), validation_abs_minimum));
							      }
							      if(!required_minimum_errors[id].length && (!_.is_array(value) || value.length < 1))
								      required_minimum_errors[id].push(_.__('validate_form__required_select_at_least_one'));
						      }
						      else if(!_.is_string(value) || value.length < 1)
							      required_minimum_errors[id].push(_.__('validate_form__required_field'));

						      break; // Break switch handler.

					      case 'input': // Check for multiple files/radios/checkboxes here too.

						      switch(type) // Handle various input types.
						      {
							      case 'file': // Handle file uploads.

								      if($this.attr('multiple')) // Allows multiple files?
								      {
									      files = $this.prop('files'); // List of files (object: FileList).

									      if($this.attr('data-validation-name-0')) // Has validators?
									      {
										      for(_i = 0; _i <= 24; _i++) // Iterate validation patterns.
										      {
											      validation_minimum = $this.attr('data-validation-minimum-' + _i);
											      validation_minimum = (_.is_numeric(validation_minimum)) ? Number(validation_minimum) : null;
											      validation_min_max_type = $this.attr('data-validation-min-max-type-' + _i);

											      if(validation_min_max_type === 'array_length' && _.isset(validation_minimum) && validation_minimum > 1)
												      if(!_.isset(validation_abs_minimum) || validation_minimum < validation_abs_minimum)
													      validation_abs_minimum = validation_minimum;
										      }
										      if(_.isset(validation_abs_minimum) && (!(files instanceof FileList) || files.length < validation_abs_minimum))
											      required_minimum_errors[id].push(_.sprintf(_.__('validate_form__required_file_at_least'), validation_abs_minimum));
									      }
									      if(!required_minimum_errors[id].length && (!(files instanceof FileList) || files.length < 1))
										      required_minimum_errors[id].push(_.__('validate_form__required_file_at_least_one'));
								      }
								      else if(!_.is_string(value) || value.length < 1)
									      required_minimum_errors[id].push(_.__('validate_form__required_file'));

								      break; // Break switch handler.

							      case 'radio': // Radio button(s).

								      checked = $('input[id^="' + _.esc_jq_attr(id) + '"]:checked', context).length;

								      if(checked < 1) // MUST have at least one checked radio.
								      {
									      if(!rc_required_minimum_errors[id].length) // Only ONE error for each group.
										      required_minimum_errors[id].push(_.__('validate_form__required_radio'));
									      rc_required_minimum_errors[id].push(_.__('validate_form__required_radio'));
								      }
								      break; // Break switch handler.

							      case 'checkbox': // Checkbox(es).

								      checked = $('input[id^="' + _.esc_jq_attr(id) + '"]:checked', context).length;

								      if($('input[id^="' + _.esc_jq_attr(id) + '"]', context).length > 1)
								      {
									      if($this.attr('data-validation-name-0')) // Has validators?
									      {
										      for(_i = 0; _i <= 24; _i++) // Iterate validation patterns.
										      {
											      validation_minimum = $this.attr('data-validation-minimum-' + _i);
											      validation_minimum = (_.is_numeric(validation_minimum)) ? Number(validation_minimum) : null;
											      validation_min_max_type = $this.attr('data-validation-min-max-type-' + _i);

											      if(validation_min_max_type === 'array_length' && _.isset(validation_minimum) && validation_minimum > 1)
												      if(!_.isset(validation_abs_minimum) || validation_minimum < validation_abs_minimum)
													      validation_abs_minimum = validation_minimum;
										      }
										      if(_.isset(validation_abs_minimum) && checked < validation_abs_minimum)
										      {
											      if(!rc_required_minimum_errors[id].length) // Only ONE error for each group.
												      required_minimum_errors[id].push(_.sprintf(_.__('validate_form__required_check_at_least'), validation_abs_minimum));
											      rc_required_minimum_errors[id].push(_.sprintf(_.__('validate_form__required_check_at_least'), validation_abs_minimum));
										      }
									      }
									      if(!required_minimum_errors[id].length && checked < 1)
									      {
										      if(!rc_required_minimum_errors[id].length) // Only ONE error for each group.
											      required_minimum_errors[id].push(_.__('validate_form__required_check_at_least_one'));
										      rc_required_minimum_errors[id].push(_.__('validate_form__required_check_at_least_one'));
									      }
								      }
								      else if(checked < 1) // A single checkbox.
									      required_minimum_errors[id].push(_.__('validate_form__required_checkbox'));

								      break; // Break switch handler.

							      default: // All other input types (default handler).

								      if(!_.is_string(value) || value.length < 1)
									      required_minimum_errors[id].push(_.__('validate_form__required_field'));

								      break; // Break switch handler.
						      }
						      break; // Break switch handler.

					      default: // Everything else (including textarea fields).

						      if(!_.is_string(value) || value.length < 1)
							      required_minimum_errors[id].push(_.__('validate_form__required_field'));

						      break; // Break switch handler.
				      }
			      });
		$(':input[data-validation-name-0]', context) // Validation (for data requirements).
			.each(function() // Checks each form field for attributes `data-requirements-name-[n]`.
			      {
				      var $this = $(this); // jQuery object instance.

				      if($this.attr('readonly') || $this.attr('disabled'))
					      return; // It's NOT even enabled (or it's read-only).

				      var id = $this.attr('id');
				      if(!id || !_.is_string(id))
					      return; // Must have an ID.
				      else id = id.replace(/\-{3}[0-9]+$/, '');

				      validation_errors[id] = validation_errors[id] || [];

				      var name = $this.attr('name');
				      if(!name || !_.is_string(name))
					      return; // Must have a name.

				      var tag_name = $this.prop('tagName');
				      if(!tag_name || !_.is_string(tag_name))
					      return; // Must have a tag name.
				      else tag_name = tag_name.toLowerCase();

				      var type = $this.attr('type'); // May need this below (for input tags).
				      if(tag_name === 'input') // Must have a type for input tags.
					      if(!type || !_.is_string(type))
						      return; // Must have a type.
					      else type = type.toLowerCase();

				      if($.inArray(tag_name, ['button']) !== -1)
					      return; // Exclude (these are NEVER validated here).

				      if(tag_name === 'input' && $.inArray(type, ['image', 'button', 'reset', 'submit']) !== -1)
				      // Notice that we do NOT exclude hidden input fields here.
					      return; // Exclude (these are NEVER validated here).

				      var value = $this.val(); // Possible array.
				      if(_.is_number(value)) value = String(value); // Force numeric string.
				      if(_.is_string(value)) value = $.trim(value); // Trim the value.

				      if(typeof value === 'undefined' || typeof value.length === 'undefined' || !value.length)
					      if(!_.isset($this.attr('data-required'))) return; // Empty (but NOT required).
					      else // This value is required and it is NOT defined. We need to stop here.
					      {
						      validation_errors[id].push(_.__('validate_form__required_field'));
						      return; // We CANNOT validate this any further.
					      }
				      var validation_description_prefix, validation_name, validation_regex;
				      var validation_minimum, validation_maximum, validation_min_max_type, validation_description;
				      var regex_begin, regex_end, regex_pattern, regex_flags, regex;
				      var id_validation_errors, rc_id_validation_errors;
				      var _i, __i, files, size, checked;

				      for(id_validation_errors = [], rc_id_validation_errors = [], _i = 0; _i <= 24; _i++)
				      {
					      if(id_validation_errors.length)
						      validation_description_prefix = _.__('validate_form__or_validation_description_prefix');
					      else validation_description_prefix = _.__('validate_form__validation_description_prefix');

					      validation_name = $this.attr('data-validation-name-' + _i);
					      if(!validation_name || !_.is_string(validation_name))
						      continue; // Must have a validation name.

					      validation_description = $this.attr('data-validation-description-' + _i);
					      if(!validation_description || !_.is_string(validation_description))
						      continue; // Must have a validation description.

					      validation_regex = $this.attr('data-validation-regex-' + _i);
					      if(!validation_regex || !_.is_string(validation_regex))
						      validation_regex = '/[\\s\\S]*/';

					      validation_minimum = $this.attr('data-validation-minimum-' + _i);
					      validation_minimum = (_.isset(validation_minimum)) ? Number(validation_minimum) : null;

					      validation_maximum = $this.attr('data-validation-maximum-' + _i);
					      validation_maximum = (_.isset(validation_maximum)) ? Number(validation_maximum) : null;

					      validation_min_max_type = $this.attr('data-validation-min-max-type-' + _i);

					      if((regex_begin = validation_regex.indexOf('/')) !== 0)
						      continue; // We do NOT have a regex validation pattern.

					      if((regex_end = validation_regex.lastIndexOf('/')) < 2)
						      continue; // We do NOT have a regex validation pattern.

					      regex_pattern = validation_regex.substr(regex_begin + 1, regex_end - 1);
					      regex_flags = validation_regex.substr(regex_end + 1);
					      regex = new RegExp(regex_pattern, regex_flags);

					      if(typeof id_validation_errors[_i] === 'undefined') // Still no error?
						      switch(tag_name) // Perform regex validations (based on tag name).
						      {
							      case 'input': // This includes several type checks.

								      switch(type) // Handle based on input type.
								      {
									      case 'file': // Deal with file uploads.

										      if($this.attr('multiple') && (files = $this.prop('files')) instanceof FileList)
										      {
											      for(__i = 0; __i < files.length; __i++) if(!_.is_string(files[__i].name) || !regex.test(files[__i].name))
											      {
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
												      break; // No need to check any further.
											      }
										      } // Else look for a single file.
										      else if(!$this.attr('multiple'))
										      {
											      if(!_.is_string(value) || !regex.test(value)) // Regex validation.
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
										      }
										      break; // Break switch handler.

									      default: // All other types (excluding radios/checkboxes).

										      if($.inArray(type, ['radio', 'checkbox']) === -1) // Exclusions w/ predefined values.
										      {
											      if(!_.is_string(value) || !regex.test(value)) // Regex validation.
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
										      }
										      break; // Break switch handler.
								      }
								      break; // Break switch handler.

							      default: // All other tag names (excluding select fields).

								      if(tag_name !== 'select') // Exclusions w/ predefined values.
								      {
									      if(!_.is_string(value) || !regex.test(value)) // Regex validation.
										      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
								      }
								      break; // Break switch handler.
						      }
					      if(typeof id_validation_errors[_i] === 'undefined' && (_.isset(validation_minimum) || _.isset(validation_maximum)))
						      switch(validation_min_max_type) // Handle this based on min/max type.
						      {
							      case 'numeric_value': // Against min/max numeric value.

								      switch(tag_name) // Handle based on tag name.
								      {
									      case 'input': // This includes several type checks.

										      switch(type) // Handle based on input type.
										      {
											      default: // All other types (excluding files/radios/checkboxes).
												      if($.inArray(type, ['file', 'radio', 'checkbox']) === -1) // Exclusions w/ predefined and/or non-numeric values.
												      {
													      if(_.isset(validation_minimum) && (!_.is_string(value) || !value.length || isNaN(value) || Number(value) < validation_minimum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

													      else if(_.isset(validation_maximum) && (!_.is_string(value) || !value.length || isNaN(value) || Number(value) > validation_maximum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
												      }
												      break; // Break switch handler.
										      }
										      break; // Break switch handler.

									      default: // All other tag names (excluding select fields).

										      if(tag_name !== 'select') // Exclusions w/ predefined values.
										      {
											      if(_.isset(validation_minimum) && (!_.is_string(value) || !value.length || isNaN(value) || Number(value) < validation_minimum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

											      else if(_.isset(validation_maximum) && (!_.is_string(value) || !value.length || isNaN(value) || Number(value) > validation_maximum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
										      }
										      break; // Break switch handler.
								      }
								      break; // Break switch handler.

							      case 'file_size': // Against total file size.

								      switch(tag_name) // Handle based on tag name.
								      {
									      case 'input': // This includes several type checks.

										      switch(type) // Handle based on input type.
										      {
											      case 'file': // Deal with file uploads.

												      if((files = $this.prop('files')) instanceof FileList)
												      {
													      for(size = 0, __i = 0; __i < files.length; __i++) size += files[__i].size;

													      if(_.isset(validation_minimum) && size < validation_minimum)
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

													      else if(_.isset(validation_maximum) && size > validation_maximum)
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
												      }
												      break; // Break switch handler.
										      }
										      break; // Break switch handler.
								      }
								      break; // Break switch handler.

							      case 'string_length': // Against string length.

								      switch(tag_name) // Handle based on tag name.
								      {
									      case 'input': // This includes several type checks.

										      switch(type) // Handle based on input type.
										      {
											      default: // All other types (excluding files/radios/checkboxes).
												      if($.inArray(type, ['file', 'radio', 'checkbox']) === -1) // Exclusions w/ predefined and/or n/a values.
												      {
													      if(_.isset(validation_minimum) && (!_.is_string(value) || value.length < validation_minimum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

													      else if(_.isset(validation_maximum) && (!_.is_string(value) || value.length > validation_maximum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
												      }
												      break; // Break switch handler.
										      }
										      break; // Break switch handler.

									      default: // All other tag names (excluding select fields).

										      if(tag_name !== 'select') // Exclusions w/ predefined values.
										      {
											      if(_.isset(validation_minimum) && (!_.is_string(value) || value.length < validation_minimum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

											      else if(_.isset(validation_maximum) && (!_.is_string(value) || value.length > validation_maximum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
										      }
										      break; // Break switch handler.
								      }
								      break; // Break switch handler.

							      case 'array_length': // Against array lengths.

								      switch(tag_name) // Handle based on tag name.
								      {
									      case 'select': // Select menus w/ multiple options possible.

										      if($this.attr('multiple')) // Multiple?
										      {
											      if(_.isset(validation_minimum) && (!_.is_array(value) || value.length < validation_minimum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

											      else if(_.isset(validation_maximum) && (!_.is_array(value) || value.length > validation_maximum))
												      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
										      }
										      break; // Break switch handler.

									      case 'input': // This includes several type checks.

										      switch(type) // Handle based on input type.
										      {
											      case 'file': // Handle file uploads w/ multiple files possible.

												      if($this.attr('multiple')) // Multiple files possible?
												      {
													      files = $this.prop('files'); // List of files (object: FileList).

													      if(_.isset(validation_minimum) && (!(files instanceof FileList) || files.length < validation_minimum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;

													      else if(_.isset(validation_maximum) && (!(files instanceof FileList) || files.length > validation_maximum))
														      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
												      }
												      break; // Break switch handler.

											      case 'checkbox': // Checkboxes (more than one).

												      if($('input[id^="' + _.esc_jq_attr(id) + '"]', context).length > 1) // Multiple?
												      {
													      checked = $('input[id^="' + _.esc_jq_attr(id) + '"]:checked', context).length;

													      if(_.isset(validation_minimum) && checked < validation_minimum)
													      {
														      if(!rc_id_validation_errors.length) // Only ONE error for each group.
															      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
														      rc_id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
													      }
													      else if(_.isset(validation_maximum) && checked > validation_maximum)
													      {
														      if(!rc_id_validation_errors.length) // Only ONE error for each group.
															      id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
														      rc_id_validation_errors[_i] = validation_description_prefix + ' ' + validation_description;
													      }
												      }
												      break; // Break switch handler.
										      }
										      break; // Break switch handler.
								      }
								      break; // Break switch handler.
						      }
					      if(typeof id_validation_errors[_i] === 'undefined' && typeof rc_id_validation_errors[_i] === 'undefined')
					      // If this one passes it negates all existing validation errors (e.g. OR logic).
						      id_validation_errors = [], rc_id_validation_errors = [];
				      }
				      validation_errors[id] = validation_errors[id].concat(id_validation_errors);
			      });
		var id, errors = {}, errors_exist, $input, $closest_form_group, $validation_errors;

		for(id in confirmation_errors) if(confirmation_errors.hasOwnProperty(id))
			errors[id] = errors[id] || [], errors[id] = errors[id].concat(confirmation_errors[id]);

		for(id in unique_value_errors) if(unique_value_errors.hasOwnProperty(id))
			errors[id] = errors[id] || [], errors[id] = errors[id].concat(unique_value_errors[id]);

		for(id in required_minimum_errors) if(required_minimum_errors.hasOwnProperty(id))
			errors[id] = errors[id] || [], errors[id] = errors[id].concat(required_minimum_errors[id]);

		for(id in validation_errors) if(validation_errors.hasOwnProperty(id))
			errors[id] = errors[id] || [], errors[id] = errors[id].concat(validation_errors[id]);

		for(id in errors) // Iterate all errors (from all of the routines above).
		{
			if(!errors.hasOwnProperty(id) || !errors[id].length)
				continue; // No errors in this entry.
			errors_exist = true; // We DO have errors.

			if(!($input = $('#' + id, context)).length)
				$input = $('#' + id + '---0', context); // Radios/checkboxes.
			if(!$input.length) throw '!$input.length'; // Should not occur.

			if(!($closest_form_group = $input.closest('.form-group')).length)
				throw '!$closest_form_group.length'; // Should not occur.

			$validation_errors = $(// Creates validation errors.
				'<div class="validation-errors alert alert-danger em-x-margin em-padding font-90">' +
				'<ul>' + // Includes an error icon prefix, for each list item we display.
				'<li><i class="fa fa-exclamation-triangle"></i> ' +
				errors[id].join('</li><li><i class="fa fa-exclamation-triangle"></i> ') +
				'</li>' +
				'</ul>' +
				'</div>'
			); // The <li> tags are built dynamically.

			_.expand_collapsible_parents_of($closest_form_group); // Visible.
			if($closest_form_group.has('.input-group').length === 1) // Has an input group?
				$closest_form_group.find('.input-group').after($validation_errors); // Validation errors.
			else $closest_form_group.append($validation_errors); // Validation errors.
		}
		if(errors_exist) // If errors exist, scroll to them now.
			$[_.core('->scrollTo')]($('.validation-errors', context).closest('.form-group'),
			                        {offset: {top: -100, left: 0}, duration: 500});

		return errors_exist ? false : true; // Prevents form from being submitted w/ errors.
	};

	/**
	 * Gets a query string variable value.
	 *
	 * @param {String} query_var Query var to get the value for.
	 *
	 * @return {String} Query var value; else an empty string.
	 */
	$$xd.$$.prototype.get_query_var = function(query_var)
	{
		this.check_arg_types('string:!empty', arguments, 1);

		var qs_pairs = []; // Initialize.

		if(location.hash.substr(0, 2) === '#!')
			qs_pairs = qs_pairs.concat(location.hash.substr(2).split('&'));

		qs_pairs = qs_pairs.concat(location.search.substr(1).split('&'));

		for(var _i = 0, _qs_pair; _i < qs_pairs.length; _i++)
		{
			_qs_pair = qs_pairs[_i].split('=', 2);
			if(_qs_pair.length === 2 && decodeURIComponent(_qs_pair[0]) === query_var)
				return $.trim(decodeURIComponent(_qs_pair[1].replace(/\+/g, ' ')));
		}
		return '';
	};

	/**
	 * Test for WordPress® administrative areas.
	 *
	 * @return {Boolean} True if we are in an administrative area of the site.
	 */
	$$xd.$$.prototype.is_admin = function()
	{
		return /\/wp\-admin(?:[\/?#]|$)/.test(location.href);
	};

	/**
	 * Is this a WordPress® menu page for the current plugin?
	 *
	 * @param {String|Array} [slugs] Optional. A string or array of possible slugs.
	 *    Unlike our PHP version of this function, this one does NOT support wildcards.
	 *
	 * @param {Boolean} [return_slug_class_basename] Optional. Defaults to a `false` value.
	 *    If this is `true`, instead of returning the slug (with dashes) we return the associated
	 *    menu page class basename (with underscores).
	 *
	 * @return {String} An empty string if NOT a plugin menu page.
	 *
	 * @see-php See \xd_v141226_dev\menu_pages\is_plugin_page
	 */
	$$xd.$$.prototype.is_plugin_menu_page = function(slugs, return_slug_class_basename)
	{
		this.check_arg_types(['string', 'array'], 'boolean', arguments, 0);

		var current_page, matches, slug, slug_class_basename; // Initialize.
		var plugin_root_ns_stub_with_dashes = this.instance('plugin_root_ns_stub_with_dashes');
		var preg_quote_plugin_root_ns_stub_with_dashes = this.preg_quote(plugin_root_ns_stub_with_dashes);
		var regex = new RegExp('^' + preg_quote_plugin_root_ns_stub_with_dashes + '(?:\\-\\-(.+))?$');

		if(this.is_admin() && (current_page = this.get_query_var('page'))
		   && (matches = regex.exec(current_page)) && matches.length)
		{
			slug = (matches.length >= 2 && matches[1])
				? matches[1] : plugin_root_ns_stub_with_dashes;

			if(return_slug_class_basename) // If so, convert this into a string.
				if(slug === plugin_root_ns_stub_with_dashes) // The plugin's main page?
					slug_class_basename = 'main_page'; // Convert slug to it's class.
				else slug_class_basename = this.with_underscores(slug);

			if(this.empty(slugs)// Don't care which slug?
			   || (this.is_string(slugs) && slug === slugs)
			   || (this.is_array(slugs) && $.inArray(slug, slugs) !== -1))
				return return_slug_class_basename && slug_class_basename
					? slug_class_basename : slug;
		}
		return ''; // Empty.
	};

	/**
	 * Expand all collapsibles wrapping a given object.
	 *
	 * @param {Node|Object|String} object
	 */
	$$xd.$$.prototype.expand_collapsible_parents_of = function(object)
	{
		this.check_arg_types(['object', 'string:!empty'], arguments, 1);

		$(object).parents('.collapse') // Expands all parents.
			[this.core('->collapse')]({toggle: false})
			[this.core('->collapse')]('show');
	};

	/**
	 * Selects a DOM element.
	 *
	 * @param {Node|Object|String} object
	 */
	$$xd.$$.prototype.select_all = function(object)
	{
		this.check_arg_types(['object', 'string:!empty'], arguments, 1);

		if((object = $(object)[0]) && document.implementation.hasFeature('Range', '2.0'))
		{
			var selection, range; // Initialize.
			selection = getSelection(), selection.removeAllRanges();
			range = document.createRange(), range.selectNodeContents(object);
			selection.addRange(range);
		}
	};

	/**
	 * Opens source code for a DOM element, in a new window.
	 *
	 * @param {Node|Object|String} object
	 */
	$$xd.$$.prototype.view_source = function(object)
	{
		this.check_arg_types(['object', 'string:!empty'], arguments, 1);

		var $object = $(object), win, source, // Initialize.
			css = '* { list-style:none; font-size:12px; font-family:"Menlo","Monaco","Consolas",monospace; }';

		if((win = this.win_open('', 750, 500)) && (source = win.document) && source.open())
		{
			source.write('<!DOCTYPE html>');
			source.write('<html>');

			source.write('<head>');
			source.write('<title>' + this.__('view_source__doc_title') + '</title>');
			source.write('<style type="text/css" media="all">' + css + '</style>');
			source.write('</head>');

			source.write('<body><pre>' + $object.html() + '</pre></body>');

			source.write('</html>');

			source.close(), win.blur(), win.focus();
		}
	};

	/**
	 * Opens a new window.
	 *
	 * @param {String} url The URL to open in a new window.
	 * @param {Number} [width] Width of the new window.
	 * @param {Number} [height] Height of the new window.
	 * @param {String} [name] Name for the new window.
	 *
	 * @return {Object}|null A window handle on success.
	 */
	$$xd.$$.prototype.win_open = function(url, width, height, name)
	{
		this.check_arg_types('string', 'integer', 'integer', 'string', arguments, 1);

		width = (width) ? width : 1000, height = (height) ? height : 700, name = (name) ? name : '_win_open';
		var win, params = 'scrollbars=yes,resizable=yes,centerscreen=yes,modal=yes,width=' + width + ',height=' + height + ',top=' + ((screen.height - height) / 2) + ',screenY=' + ((screen.height - height) / 2) + ',left=' + ((screen.width - width) / 2) + ',screenX=' + ((screen.width - width) / 2);

		if(!(win = open(url, name, params)))
			alert(this.__('win_open__turn_off_popup_blockers'));
		else win.blur(), win.focus();

		return win; // Window handle (or null on failure).
	};

	/**
	 * JavaScript equivalent to PHP's `mt_rand()` function.
	 *
	 * @param {Number} [min] Minimum random number to start from.
	 * @param {Number} [max] Maximum random number to go up to.
	 *
	 * @return {Number} Random number.
	 */
	$$xd.$$.prototype.mt_rand = function(min, max)
	{
		this.check_arg_types('integer', 'integer', arguments, 0);

		min = min ? min : 0, max = max ? max : 2147483647;

		return Math.floor(Math.random() * (max - min + 1)) + min;
	};

	/**
	 * Adds a query string argument onto a URL.
	 *
	 * @param {String} name Query arg key name.
	 * @param {String} value Query arg value.
	 * @param {String} url URL to add the query arg to.
	 *
	 * @return {String} URL w/ query arg appended onto it.
	 */
	$$xd.$$.prototype.add_query_arg = function(name, value, url)
	{
		this.check_arg_types('string:!empty', 'string', 'string', arguments, 3);

		url += (url.indexOf('?') === -1) ? '?' : '&';
		url += encodeURIComponent(name) + '=' + encodeURIComponent(value);

		return url;
	};

	/**
	 * Gets verifier for an AJAX action call.
	 *
	 * @param {String} call Call action.
	 * @param {String} type Call action type.
	 *
	 * @return {String} Verifier for the call action.
	 */
	$$xd.$$.prototype.get_call_verifier = function(call, type)
	{
		this.check_arg_types('string:!empty', 'string:!empty', arguments, 2);

		return this.verifier(type + '::' + call);
	};

	/**
	 * Makes an AJAX call.
	 *
	 * @param {String} method HTTP request method; i.e. `GET` or `POST`.
	 * @param {String} call Call action.
	 * @param {String} type Call action type.
	 * @param {Array} [args] Call action arguments.
	 * @param {Object} [ajax] Any additional AJAX args.
	 */
	$$xd.$$.prototype.ajax = function(method, call, type, args, ajax)
	{
		this.check_arg_types('string:!empty', 'string:!empty', 'string:!empty', 'array', 'object', arguments, 3);

		var url = this.instance('wp_load_url');
		var plugin_var_ns = this.instance('plugin_var_ns');

		ajax = (ajax) ? ajax : {};
		ajax.type = method, ajax.url = url, ajax.data = {};

		ajax.data[plugin_var_ns + '[a][s]'] = 'ajax';
		ajax.data[plugin_var_ns + '[a][c]'] = call;
		ajax.data[plugin_var_ns + '[a][t]'] = type;
		ajax.data[plugin_var_ns + '[a][v]'] = this.get_call_verifier(call, type);

		if(args && args.length) // Has arguments?
			ajax.data[plugin_var_ns + '[a][a]'] = JSON.stringify(args);

		if(!(ajax.complete instanceof Array))
			ajax.complete = (ajax.complete) ? [ajax.complete] : [];
		ajax.complete.push(function(jqXHR, status)
		                   {
			                   if(status !== 'success') console.log(jqXHR);
		                   });
		$.ajax(ajax);
	};

	/**
	 * Makes an AJAX call via the GET method.
	 *
	 * @param {String} call Call action.
	 * @param {String} type Call action type.
	 * @param {Array} [args] Call action arguments.
	 * @param {Object} [ajax] Any additional AJAX args.
	 */
	$$xd.$$.prototype.get = function(call, type, args, ajax)
	{
		this.check_arg_types('string:!empty', 'string:!empty', 'array', 'object', arguments, 2);

		var _arguments = $.makeArray(arguments);
		_arguments.unshift('GET'), this.ajax.apply(this, _arguments);
	};

	/**
	 * Makes an AJAX call via the POST method.
	 *
	 * @param {String} call Call action.
	 * @param {String} type Call action type.
	 * @param {Array} [args] Call action arguments.
	 * @param {Object} [ajax] Any additional AJAX args.
	 */
	$$xd.$$.prototype.post = function(call, type, args, ajax)
	{
		this.check_arg_types('string:!empty', 'string:!empty', 'array', 'object', arguments, 2);

		var _arguments = $.makeArray(arguments);
		_arguments.unshift('POST'), this.ajax.apply(this, _arguments);
	};

	/**
	 * Checks argument types.
	 *
	 * @note This accepts a variable-length list of arguments.
	 *    Each argument can be a string or an array containing the type hint(s).
	 *    The last argument should always be the number of required arguments.
	 *    The next-to-last argument should contain the `arguments` themselves.
	 *    i.e. <http://wsharks.com/1kOAjip>
	 *
	 * @return {Boolean}
	 */
	$$xd.$$.prototype.check_arg_types = function()
	{
		var _arg_type_hints__args__required_args = $.makeArray(arguments);

		var required_args = Number(_arg_type_hints__args__required_args.pop());
		var args = $.makeArray(_arg_type_hints__args__required_args.pop());
		var arg_type_hints = _arg_type_hints__args__required_args;

		var total_args = args.length;
		var total_arg_positions = total_args - 1;

		var _arg_position, _arg_type_hints;
		var _arg_types, _arg_type_key, _last_arg_type_key, _arg_type, is_;
		var problem, position, caller, types, empty, type_given;

		if(total_args < required_args)
		{
			caller = this.__('check_arg_types__caller'); // Generic.
			// caller = arguments.callee.caller.name; not possible in strict mode.
			throw this.sprintf(this.__('check_arg_types__missing_args'), caller, required_args, total_args);
		}
		else if(total_args === 0) // No arguments (no problem).
			return true; // We can stop right here in this case.

		main_loop: // Marker for main loop (iterating each of the `arg_type_hints`).

			for(_arg_position = 0; _arg_position < arg_type_hints.length; _arg_position++)
			{
				_arg_type_hints = arg_type_hints[_arg_position]; // Possible `string|array`.
				_arg_types = !this.is_array(_arg_type_hints) ? [_arg_type_hints] : _arg_type_hints;

				if(_arg_position > total_arg_positions) // Argument not even passed in?
					continue; // Argument was not even passed in (we don't need to check this value).

				_last_arg_type_key = -1; // Reset before iterating (we'll define below, if necessary).

				types_loop: // Marker for types loop (iterating each of the `_arg_types` here).

					for(_arg_type_key = 0; _arg_type_key < _arg_types.length; _arg_type_key++)
					{
						_arg_type = _arg_types[_arg_type_key];

						switch_handler: // Marker for switch handler.

							switch(_arg_type)
								// This may NOT be a string representation.
								// JavaScript handles `instanceof`, w/ comparison to a function.
							{
								case '': // Anything goes (there are NO requirements).
									break types_loop; // We have a valid type/value here.

								/****************************************************************************/

								case ':!empty': // Anything goes. But check if it's empty.
									if(this.empty(args[_arg_position])) // Is empty?
									{
										if(_last_arg_type_key === -1)
											_last_arg_type_key = _arg_types.length - 1;

										if(_arg_type_key === _last_arg_type_key)
										// Exhausted list of possible types.
										{
											problem = {
												'types'   : _arg_types,
												'position': _arg_position,
												'value'   : args[_arg_position],
												'empty'   : this.empty(args[_arg_position])
											};
											break main_loop;
										}
									}
									else break types_loop; // We have a valid type/value here.

									break switch_handler; // Default break; and continue type checking.

								/****************************************************************************/

								case 'string': // All of these fall under `!is_...()` checks.
								case 'boolean':
								case 'bool':
								case 'integer':
								case 'float':
								case 'number':
								case 'numeric':
								case 'array':
								case 'function':
								case 'xml':
								case 'object':
								case 'null':
								case 'undefined':

									is_ = this[this.___is_type_checks[_arg_type]];

									if(!is_(args[_arg_position])) // Not this type?
									{
										if(_last_arg_type_key === -1)
											_last_arg_type_key = _arg_types.length - 1;

										if(_arg_type_key === _last_arg_type_key)
										// Exhausted list of possible types.
										{
											problem = {
												'types'   : _arg_types,
												'position': _arg_position,
												'value'   : args[_arg_position],
												'empty'   : this.empty(args[_arg_position])
											};
											break main_loop;
										}
									}
									else break types_loop; // We have a valid type/value here.

									break switch_handler; // Default break; and continue type checking.

								/****************************************************************************/

								case '!string': // All of these fall under `is_...()` checks.
								case '!boolean':
								case '!bool':
								case '!integer':
								case '!float':
								case '!number':
								case '!numeric':
								case '!array':
								case '!function':
								case '!xml':
								case '!object':
								case '!null':
								case '!undefined':

									is_ = this[this.___is_type_checks[_arg_type]];

									if(is_(args[_arg_position])) // Is this type?
									{
										if(_last_arg_type_key === -1)
											_last_arg_type_key = _arg_types.length - 1;

										if(_arg_type_key === _last_arg_type_key)
										// Exhausted list of possible types.
										{
											problem = {
												'types'   : _arg_types,
												'position': _arg_position,
												'value'   : args[_arg_position],
												'empty'   : this.empty(args[_arg_position])
											};
											break main_loop;
										}
									}
									else break types_loop; // We have a valid type/value here.

									break switch_handler; // Default break; and continue type checking.

								/****************************************************************************/

								case 'string:!empty': // These are `!is_...()` || `empty()` checks.
								case 'boolean:!empty':
								case 'bool:!empty':
								case 'integer:!empty':
								case 'float:!empty':
								case 'number:!empty':
								case 'numeric:!empty':
								case 'array:!empty':
								case 'function:!empty':
								case 'xml:!empty':
								case 'object:!empty':
								case 'null:!empty':
								case 'undefined:!empty':

									is_ = this[this.___is_type_checks[_arg_type]];

									if(!is_(args[_arg_position]) || this.empty(args[_arg_position]))
									// Now, have we exhausted the list of possible types?
									{
										if(_last_arg_type_key === -1)
											_last_arg_type_key = _arg_types.length - 1;

										if(_arg_type_key === _last_arg_type_key)
										// Exhausted list of possible types.
										{
											problem = {
												'types'   : _arg_types,
												'position': _arg_position,
												'value'   : args[_arg_position],
												'empty'   : this.empty(args[_arg_position])
											};
											break main_loop;
										}
									}
									else break types_loop; // We have a valid type/value here.

									break switch_handler; // Default break; and continue type checking.

								/****************************************************************************/

								default: // Assume object `instanceof` in this default case handler.
									// For practicality & performance reasons, we do NOT check `!` or `:!empty` here.
									// It's VERY rare that one would need to require something that's NOT a specific object instance.
									// In fact, the `_arg_type` value should NOT be a string representation in this case.
									// JavaScript ONLY handles `instanceof`, w/ comparison to an actual function value.

									if(!this.is_function(_arg_type) || !(args[_arg_position] instanceof _arg_type))
									{
										if(_last_arg_type_key === -1)
											_last_arg_type_key = _arg_types.length - 1;

										if(_arg_type_key === _last_arg_type_key)
										// Exhausted list of possible types.
										{
											problem = {
												'types'   : _arg_types,
												'position': _arg_position,
												'value'   : args[_arg_position],
												'empty'   : this.empty(args[_arg_position])
											};
											break main_loop;
										}
									}
									else break types_loop; // We have a valid type for this arg.

									break switch_handler; // Default break; and continue type checking.
							}
					}
			}

		if(problem) // We have a problem!
		{
			position = problem.position + 1;

			type_given = $.type(problem.value);
			empty = (problem.empty) ? this.__('check_arg_types__empty') + ' ' : '';

			if(problem.types.length && this.is_string(problem.types[0]))
				types = problem.types.join('|');
			// Else we say `[a different object type]`.
			else types = this.__('check_arg_types__diff_object_type');

			caller = this.__('check_arg_types__caller'); // Generic.
			// caller = arguments.callee.caller.name; not possible in strict mode.
			throw this.sprintf(this.__('check_arg_types__invalid_arg'), position, caller, types, empty, type_given);
		}
		return true; // Default return value (no problem).
	};
})(jQuery); // End XDaRk Core closure.

/* ----------------------------------------------------------------------------------------------------------------------------------------
 * This is phase two; the core initializes itself here.
 * ------------------------------------------------------------------------------------------------------------------------------------- */

(function($) // Begin XDaRk Core closure.
{
	'use strict'; // Strict standards.

	/**
	 * @type {Object} Core class instance.
	 */
	window.$xd_v141226_dev = window.$xd_v141226_dev || {};
	var $$xd = $$xd_v141226_dev;
	var $xd = $xd_v141226_dev;
	if(typeof $xd.$ === 'object')
		return; // Core already exists.

	/**
	 * @type {$$xd.$$} Core.
	 */
	$xd.$ = new $$xd.$$();

	/*
	 * Globals for each plugin; i.e. object containers.
	 */
	if(!$xd.___did_globals) // Only if not done already.
	{
		$.each($xd.$.___plugin_root_namespaces,
		       function(plugin_root_ns_index, plugin_root_ns)
		       {
			       window['$' + plugin_root_ns] = window['$' + plugin_root_ns] || {};
		       });
		$xd.___did_globals = true;
	}
	/*
	 * Core enhances forms for all plugins; one time only.
	 */
	if(!$xd.___did_enhance_forms) // Only if not done already.
	{
		$.each($xd.$.___plugin_root_namespaces,
		       function(plugin_root_ns_index, plugin_root_ns)
		       {
			       var extension // Extension definition.
				       = $xd.$.extension_class(plugin_root_ns, 'enhance_forms');
			       window['$' + plugin_root_ns].$enhance_forms = new extension();
			       var _ = window['$' + plugin_root_ns].$enhance_forms;

			       $(document).on('ready', _.enhance_forms.bind(_));
		       });
		$xd.___did_enhance_forms = true;
	}
})(jQuery); // End XDaRk Core closure.