<?php
/**
 * Database Utilities.
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
	 * Database Utilities.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class db_utils extends framework
	{
		/**
		 * Handles CRON configuration routine.
		 *
		 * @attaches-to WordPress® `wp_loaded` action hook.
		 * @hook-priority `10010`; i.e. after {@link crons\wp_loaded}.
		 */
		public function wp_loaded_crons()
		{
			$this->©crons->config($this->cron_jobs);
		}

		/**
		 * @var array Array of CRON jobs associated with this class.
		 */
		public $cron_jobs = array
		(
			array(
				'©class.method' =>
					'©db_utils.cleanup_expired_transients',
				'schedule'      => 'daily'
			)
		);

		/**
		 * Checks if a table exists in DB
		 *
		 * @param $tableName
		 *
		 * @return bool
		 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
		 * @since TODO ${VERSION}
		 */
		public function tableExists( $tableName ) {
			global $wpdb;
			$res = $wpdb->query( "SHOW TABLES LIKE '$tableName'" );

			return $res > 0;
		}

		/**
		 * Prepares meta names/values.
		 *
		 * @param mixed $value Any mixed data value is fine.
		 *
		 * @note Very important for this routine to ALLOW empty values.
		 *    Sometimes meta values are supposed to be empty (e.g. empty on purpose).
		 *
		 * @return array Array of name/value pairs (the array is NEVER empty).
		 */
		public function metafy($value)
		{
			$value = (array)$this->©array->ify_deep($value);

			foreach($value as $_name => $_value)
			{
				if(is_array($_value) || is_object($_value))
					$_value = serialize($_value);

				if(is_numeric($_name))
					$_name = '_'.(string)$_name;

				$meta[$_name] = (string)$_value;
			}
			unset($_name, $_value); // Housekeeping.

			if(empty($meta)) // Default key in this case.
				$meta['_0'] = (string)$value;

			return $meta; // Name/value pairs (NEVER empty).
		}

		/**
		 * Prepares query for meta table insertions (or updates).
		 *
		 * @param string  $table Unprefixed table name.
		 * @param string  $rel_id_column Column name for related ID.
		 * @param string  $rel_id Value for the related ID column.
		 *
		 * @param mixed   $data Any mixed data value is fine.
		 *    This will be passed through `metafy()`. Converts to an array of name/value pairs.
		 *
		 * @param boolean $update_on_duplicate_key Optional. Defaults to a FALSE value.
		 *    If this is TRUE, meta values/times are updated when/if a duplicate key is encountered during insertion.
		 *    Meta tables should each have a UNIQUE index based on their `$rel_id_column` and `name` columns.
		 *
		 * @return string A full MySQL query, with one or more meta table insertions (NEVER empty).
		 *    The query returned by this routine, can be fired in a single shot (inserts/updates multiple rows).
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 * @throws exception If `$table` is invalid (i.e. non-existent).
		 * @throws exception If unable to generate meta name/value pairs.
		 */
		public function prep_metafy_query($table, $rel_id_column, $rel_id, $data, $update_on_duplicate_key = FALSE)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', '', 'boolean', func_get_args());

			$query = // Prepares `_meta` table name/value insertions.
				"INSERT INTO `".$this->©string->esc_sql($this->©db_tables->get($table))."`".
				"(".$this->comma_tickify(array($rel_id_column, 'name', 'value', 'time')).")";

			$_values = array(); // Initialize.
			$_time   = time(); // Current UTC time.

			foreach($this->metafy($data) as $_name => $_value)
				$_values[] = "(".$this->comma_quotify(array($rel_id, $_name, $_value, $_time)).")";
			$query .= " VALUES".implode(',', $_values); // Implode values.

			unset($_time, $_name, $_value, $_values); // Housekeeping.

			if($update_on_duplicate_key)
				$query .= " ON DUPLICATE KEY UPDATE".
				          " `value` = VALUES(`value`), `time` = VALUES(`time`)";

			return $query; // Ready for DB query.
		}

		/**
		 * Purges meta values from our object cache.
		 *
		 * @param string $table Unprefixed table name.
		 * @param string $rel_id_column Column name for related ID.
		 * @param string $rel_id Value in the related ID column.
		 * @param string $name Optional. If purging ONLY a specific meta key name.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 */
		public function purge_meta_values_cache($table, $rel_id_column, $rel_id, $name = '')
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'string', func_get_args());

			if($name) // We only need to purge a specific name?
				unset($this->cache['get_meta_values'][$table][$rel_id_column][$rel_id][$name]);
			else unset($this->cache['get_meta_values'][$table][$rel_id_column][$rel_id]);
		}

		/**
		 * Gets meta value(s) from a specific meta table.
		 *
		 * @param string       $table Unprefixed table name.
		 * @param string       $rel_id_column Column name for related ID.
		 * @param string       $rel_id Value in the related ID column.
		 *
		 * @param string|array $names Optional. A string name; or an array of name(s) associated with meta values.
		 *    Or this can also be set to {@fw_constants::all}; indicating ALL meta values (e.g. for all names automatically).
		 *    This defaults to a value of {@fw_constants::all}; indicating an array of all meta name/value pairs.
		 *
		 * @return mixed If `$names` is a string, we simply return a meta value matching the meta key name.
		 *    If an array of `$names` (or {@fw_constants::all}) are requested, we return an associative array with each meta name/value.
		 *    Requested meta values that do NOT exist, are still included; but they default to a FALSE boolean value.
		 *
		 * @note See also: {@link refresh_meta_values_cache()}, {@link insert_meta_values()}, {@link update_meta_values()}, {@link delete_meta_values()}.
		 *    ~ These methods automatically purge cache keys filled by this routine; which is VERY important to consider.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 * @throws exception If `$table` is invalid (i.e. non-existent).
		 * @throws exception If `$names` is empty, or if it contains an empty or non-string value.
		 *    Meta names are ALWAYS strings (and they should NEVER be empty).
		 */
		public function get_meta_values($table, $rel_id_column, $rel_id, $names = self::all)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', array('string:!empty', 'array:!empty'), func_get_args());

			$cache =& $this->cache[__FUNCTION__][$table][$rel_id_column][$rel_id]; // Shorter reference for use below.

			// CAUTION: We do NOT cache queries that require all name/value pairs; as this could lead to memory issues.
			// If caching needs to occur against queries for ALL meta name/value pairs; please implement separately.

			if($names === $this::all) // We need to query for ALL names automatically in this case?
			{
				$values = array(); // Initialize.

				$query =
					"SELECT".
					" `".$this->©string->esc_sql($table)."`.`name`,".
					" `".$this->©string->esc_sql($table)."`.`value`".

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

					" WHERE".
					" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'".
					" AND `".$this->©string->esc_sql($table)."`.`name` IS NOT NULL AND `".$this->©string->esc_sql($table)."`.`name` != ''";

				if(is_array($results = $this->©db->get_results($query, OBJECT)))
					foreach($this->typify_results_deep($results) as $_result)
						$values[$_result->name] = maybe_unserialize($_result->value);
				unset($_result); // A little housekeeping.

				return $values; // All name/value pairs.
			}
			$query_names           = array();
			$is_single_string_name = FALSE;

			if(is_string($names)) // Single?
			{
				$is_single_string_name = TRUE;
				$names                 = array($names);
			}
			foreach(($names = array_unique($names)) as $_name)
			{
				if(!$this->©string->is_not_empty($_name))
					throw $this->©exception( // Should NOT happen.
						$this->method(__FUNCTION__).'#invalid_name', get_defined_vars(),
						$this->__('Expecting a non-empty string `$_name` value.').
						' '.sprintf($this->__('Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->__('empty').' ' : ''), gettype($_name))
					);
				if(!isset($cache[$_name])) // We have NO value for this name yet?
				{
					$cache[$_name] = FALSE; // Defaults to FALSE here.
					$query_names[] = $_name; // MUST query DB below.
				}
			}
			unset($_name); // Just a little housekeeping here.

			if($query_names) // Some we don't have yet?
			{
				$query = // This WILL be cached (as seen below).
					"SELECT".
					" `".$this->©string->esc_sql($table)."`.`name`,".
					" `".$this->©string->esc_sql($table)."`.`value`".

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

					" WHERE".
					" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'".
					" AND `".$this->©string->esc_sql($table)."`.`name` IN(".$this->comma_quotify($query_names).")";

				if(is_array($results = $this->©db->get_results($query, OBJECT)))
					foreach($this->typify_results_deep($results) as $_result)
						$cache[$_result->name] = maybe_unserialize($_result->value);
				unset($_result); // A little housekeeping.
			}
			if($is_single_string_name) return $cache[$names[0]]; // Single value.

			return $this->©array->compile_key_elements_deep($cache, $names, TRUE, 1);
		}

		/**
		 * Inserts (or updates) meta value(s); in a specific meta table.
		 *
		 * @param string $table Unprefixed table name.
		 * @param string $rel_id_column Column name for related ID.
		 * @param string $rel_id Value for the related ID column.
		 * @param array  $values Associative array of meta values (e.g. key/value pairs).
		 *
		 * @return integer Number of rows affected by this insertion/update.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 * @throws exception If `$table` is invalid (i.e. non-existent).
		 * @throws exception If `$values` are empty.
		 */
		public function update_meta_values($table, $rel_id_column, $rel_id, $values)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

			foreach($values as $_name => $_value)
			{
				if(!$this->©string->is_not_empty($_name))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_name', get_defined_vars(),
						$this->__('Expecting a non-empty string `$_name` value.').
						' '.sprintf($this->__('Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->__('empty').' ' : ''), gettype($_name))
					);
				$this->purge_meta_values_cache($table, $rel_id_column, $rel_id, $_name);
			}
			unset($_name, $_value); // A little housekeeping.

			return (integer)$this->©db->query($this->©db_utils->prep_metafy_query($table, $rel_id_column, $rel_id, $values, TRUE));
		}

		/**
		 * Inserts new meta value(s); into a specific meta table.
		 *
		 * @param string $table Unprefixed table name.
		 * @param string $rel_id_column Column name for related ID.
		 * @param string $rel_id Value for the related ID column.
		 * @param array  $values Associative array of meta values (e.g. key/value pairs).
		 *
		 * @return integer Number of rows affected by this insertion.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 * @throws exception If `$table` is invalid (i.e. non-existent).
		 * @throws exception If `$values` are empty.
		 */
		public function insert_meta_values($table, $rel_id_column, $rel_id, $values)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

			foreach($values as $_name => $_value)
			{
				if(!$this->©string->is_not_empty($_name))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_name', get_defined_vars(),
						$this->__('Expecting a non-empty string key `$_name` value.').
						' '.sprintf($this->__('Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->__('empty').' ' : ''), gettype($_name))
					);
				$this->purge_meta_values_cache($table, $rel_id_column, $rel_id, $_name);
			}
			unset($_name, $_value); // A little housekeeping.

			return (integer)$this->©db->query($this->©db_utils->prep_metafy_query($table, $rel_id_column, $rel_id, $values, FALSE));
		}

		/**
		 * Deletes meta value(s) from a specific meta table.
		 *
		 * @param string       $table Unprefixed table name.
		 * @param string       $rel_id_column Column name for related ID.
		 * @param string       $rel_id Value in the related ID column.
		 *
		 * @param string|array $names Optional. A string name; or an array of name(s) associated with meta values.
		 *    Or this can also be set to {@fw_constants::all}; indicating ALL meta values (e.g. for all names automatically).
		 *    This defaults to a value of {@fw_constants::all}; indicating the deletion of any/all names.
		 *
		 * @return integer The number of rows affected by this deletion.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$table`, `$rel_id_column`, or `$rel_id` are empty.
		 * @throws exception If `$table` is invalid (i.e. non-existent).
		 * @throws exception If `$names` is empty, or if it contains an empty or non-string value.
		 *    Meta names are ALWAYS strings (and they should NEVER be empty).
		 */
		public function delete_meta_values($table, $rel_id_column, $rel_id, $names = self::all)
		{
			$this->check_arg_types('string:!empty', 'string:!empty',
			                       'integer:!empty', array('string:!empty', 'array:!empty'), func_get_args());

			if($names === $this::all) // Deleting all names automatically?
			{
				$this->purge_meta_values_cache($table, $rel_id_column, $rel_id);

				return (integer)$this->©db->query(
					"DELETE".
					" `".$this->©string->esc_sql($table)."`". // By table name for future expansion.

					" FROM".
					" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

					" WHERE".
					" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'"
				);
			}
			if(is_string($names)) $names = array($names); // Any other string is converted to an array.

			foreach(($names = array_unique($names)) as $_name)
			{
				if(!$this->©string->is_not_empty($_name))
					throw $this->©exception(
						$this->method(__FUNCTION__).'#invalid_name', get_defined_vars(),
						$this->__('Expecting a non-empty string `$_name` value.').
						' '.sprintf($this->__('Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->__('empty').' ' : ''), gettype($_name))
					);
				$this->purge_meta_values_cache($table, $rel_id_column, $rel_id, $_name);
			}
			unset($_name); // A little housekeeping.

			return (integer)$this->©db->query(
				"DELETE".
				" `".$this->©string->esc_sql($table)."`". // By table name for future expansion.

				" FROM".
				" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

				" WHERE".
				" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'".
				" AND `".$this->©string->esc_sql($table)."`.`name` IN(".$this->comma_quotify($names).")"
			);
		}

		/**
		 * Prepares comma-delimited, single-quoted values for an SQL query.
		 *
		 * @param array   $array An array of values (ONE dimension only here).
		 *
		 * @param boolean $convert_nulls_no_esc_wrap Optional. Defaults to a FALSE value.
		 *    By default, we convert all values into strings, and then we escape & wrap them w/ quotes.
		 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`,
		 *    and they are NOT quotified here. This should be enabled when/if NULL values are being inserted into a DB table.
		 *
		 * @return string A comma-delimited, single-quoted array of values, for an SQL query.
		 *
		 * @note It is VERY important for this routine to preserve the order of the input array.
		 */
		public function comma_quotify($array, $convert_nulls_no_esc_wrap = FALSE)
		{
			$this->check_arg_types('array', 'boolean', func_get_args());

			$array = $this->©strings->esc_sql_deep($array, $convert_nulls_no_esc_wrap);
			$array = $this->©strings->wrap_deep($array, "'", "'", TRUE, $convert_nulls_no_esc_wrap);

			return implode(',', $array);
		}

		/**
		 * Prepares comma-delimited, backticked values for an SQL query.
		 *
		 * @param array $array An array of values (ONE dimension only here).
		 *
		 * @return string A comma-delimited, backticked array of values, for an SQL query.
		 *
		 * @note It is VERY important for this routine to preserve the order of the input array.
		 */
		public function comma_tickify($array)
		{
			$this->check_arg_types('array', func_get_args());

			$array = $this->©strings->esc_sql_deep($array);
			$array = $this->©strings->wrap_deep($array, "`", "`");

			return implode(',', $array);
		}

		/**
		 * Prepares SQL file queries.
		 *
		 * @param string $sql_file Absolute server path to an SQL file.
		 *
		 * @return array An array containing SQL queries to execute, else an exception is thrown.
		 *    It's possible for this to return an empty array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$sql_file` is empty or invalid (i.e. NOT an SQL file).
		 * @throws exception If `$sql_file` does NOT have an `sql` file extension.
		 * @throws exception If we fail to prepare queries.
		 */
		public function prep_sql_file_queries($sql_file)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$table_prefix  = $this->©db_table->prefix;
			$plugin_prefix = $this->instance->plugin_prefix;
			$charset       = ($this->©db->charset) ? $this->©db->charset : 'utf8';
			$collate       = ($this->©db->collate) ? $this->©db->collate : 'utf8_unicode_ci';

			$replace = array(
				'/^SET\s+.+?;$/im',
				'/^\-{2}.*$/im',
				'/^\/\*\!.*?;$/im',
				'/ENGINE\s*\=\s*\w+/i',
				'/`(?:wp_)?'.preg_quote($plugin_prefix, '/').'/',
				'/DEFAULT\s+CHARSET\s*\=\s*\w+/i',
				'/DEFAULT\s+CHARACTER\s+SET\s*\=\s*\w+/i',
				'/DEFAULT\s+CHARACTER\s+SET\s+\w+/i',
				'/COLLATE\s*\=\s*\w+/i',
				'/COLLATE\s+\w+/i'
			);
			$with    = array(
				'', // No SET statements.
				'', // No SQL comment lines.
				'', // No code-containing comments.
				'', // No engine specs (use default).
				'`'.$this->©string->esc_refs($table_prefix),
				'DEFAULT CHARSET='.$this->©string->esc_refs($charset),
				'DEFAULT CHARACTER SET='.$this->©string->esc_refs($charset),
				'DEFAULT CHARACTER SET '.$this->©string->esc_refs($charset),
				'COLLATE='.$this->©string->esc_refs($collate),
				'COLLATE '.$this->©string->esc_refs($collate)
			);
			if(!is_file($sql_file))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#nonexistent_sql_file', get_defined_vars(),
					sprintf($this->__('Nonexistent SQL file: `%1$s`.'), $sql_file)
				);
			if($this->©file->extension($sql_file) !== 'sql')
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_sql_file_extension', get_defined_vars(),
					sprintf($this->__('Invalid SQL file extension: `%1$s`.'), $sql_file)
				);
			if(!is_string($query = file_get_contents($sql_file)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#read_write_issues', get_defined_vars(),
					sprintf($this->__('Unable to read SQL file: `%1$s`.'), $sql_file)
				);
			if(!is_string($query = preg_replace($replace, $with, $query)))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#preparation_failure', get_defined_vars(),
					sprintf($this->__('Unable to prepare queries from SQL file: `%1$s`.'), $sql_file)
				);
			$queries = preg_split('/;$/m', $query, NULL, PREG_SPLIT_NO_EMPTY);
			$queries = $this->©strings->trim_deep($queries);
			$queries = $this->©array->remove_0b_strings_deep($queries);

			return $queries; // Ready for SQL queries.
		}

		/**
		 * Forces integer/float values deeply (in DB result sets, if applicable).
		 *
		 * @see `$this->©db_tables->regex_(integer|float)_columns`.
		 *
		 * @param mixed               $value Any value. Typically an array of results, where each result is an object or array with string keys.
		 *    Array/object keys MUST be strings, in order to match `$this->©db_tables->regex_(integer|float)_columns`.
		 *    Integer keys are ignored completely.
		 *
		 * @param null|string|integer $___key Used during recursion (this is an internal argument value).
		 *    If any string key matches a regex pattern in `$this->©db_tables->regex_(integer|float)_columns`;
		 *    AND, the existing associative value is numeric, this routine forces an (integer or float).
		 *
		 * @param boolean             $___recursion Internal use only (tracks recursion).
		 *
		 * @return mixed|array|object Mixed. Normally an array/object (i.e. a DB result set).
		 */
		public function typify_results_deep($value, $___key = NULL, $___recursion = FALSE)
		{
			if(!$___recursion) // Only for initial caller.
				$this->check_arg_types('', array('null', 'integer', 'string'), 'boolean', func_get_args());

			if(is_array($value) || is_object($value))
			{
				foreach($value as $_key => &$_value)
					$_value = $this->typify_results_deep($_value, $_key, TRUE);
				unset($_key, $_value);

				return $value; // Array/object.
			}
			if(is_string($___key) && is_numeric($value))
			{
				if($this->©string->in_regex_patterns($___key, $this->©db_tables->regex_integer_columns)
				   && !$this->©string->in_regex_patterns($___key, $this->©db_tables->regex_float_columns)
				   && !$this->©string->in_regex_patterns($___key, $this->©db_tables->regex_string_columns)
				) return (integer)$value;

				if($this->©string->in_regex_patterns($___key, $this->©db_tables->regex_float_columns)
				   && !$this->©string->in_regex_patterns($___key, $this->©db_tables->regex_integer_columns)
				   && !$this->©string->in_regex_patterns($___key, $this->©db_tables->regex_string_columns)
				) return (float)$value;
			}
			return $value; // Default return value.
		}

		/**
		 * Gets return value for `SQL_CALC_FOUND_ROWS/FOUND_ROWS()`.
		 *
		 * @param string $query Any valid MySQL SELECT query (in string format).
		 *    This routine forces the LIMIT to a value of `1`.
		 *
		 * @return integer Number of rows that would have been returned, had a LIMIT not been applied.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$query` is NOT a `SELECT` statement.
		 */
		public function calc_found_rows($query)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$query = trim($query); // Trim the query up.

			if(!preg_match('/^SELECT\s+/i', $query))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#invalid_query', get_defined_vars(),
					$this->__('Cannot get `FOUND_ROWS()` (missing `SELECT` statement).').
					' '.sprintf($this->__('This `$query` is NOT a `SELECT` statement: `%1$s`.'), $query)
				);
			$query = preg_replace('/^SELECT\s+/i', 'SELECT SQL_CALC_FOUND_ROWS ', $query);
			$query = preg_replace('/\s+LIMIT\s+[0-9\s,]*$/i', '', $query).' LIMIT 1';

			$this->©db->query($query);

			return (integer)$this->©db->get_var('SELECT FOUND_ROWS()');
		}

		/**
		 * Adds (or updates) a transient key/value (w/ database storage).
		 *
		 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
		 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
		 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
		 *
		 * @param string  $key The key/name for this transient value.
		 *
		 * @param mixed   $value Any value is fine (mixed data types are OK here).
		 *
		 * @param integer $expires_after Optional. Time (in seconds) this transient should last for. Defaults to `-1` (no automatic expiration).
		 *    If this is set to anything <= `0`, the transient will NOT expire automatically (e.g. it remains until all transients are deleted from the DB).
		 *
		 * @return boolean TRUE if the transient value was set, else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$key` is empty (or if it's too long; producing a key which exceeds DB storage requirements).
		 */
		public function set_transient($key, $value, $expires_after = -1)
		{
			$this->check_arg_types('string:!empty', '', 'integer', func_get_args());

			$transient_prefix         = '_'.$this->instance->plugin_prefix.'transient_';
			$transient_timeout_prefix = '_'.$this->instance->plugin_prefix.'transient_timeout_';

			$transient         = $transient_prefix.md5($key);
			$transient_timeout = $transient_timeout_prefix.md5($key);

			$timeout  = ($expires_after > 0) ? time() + $expires_after : 0;
			$autoload = (!$timeout) ? 'yes' : 'no'; // Only if NO timeout value.

			if(get_option($transient) === FALSE) // It's new?
			{
				if($timeout) // This will timeout?
					add_option($transient_timeout, $timeout, '', 'no');

				return add_option($transient, $value, '', $autoload);
			}
			else // This transient already exists (let's update it).
			{
				if($timeout) // Update timeout value?
					update_option($transient_timeout, $timeout);

				return update_option($transient, $value);
			}
		}

		/**
		 * Gets a transient value (from the database).
		 *
		 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
		 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
		 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
		 *
		 * @param string $key The key/name for this transient value.
		 *
		 * @return mixed|boolean The transient value (if NOT expired yet), else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$key` is empty.
		 */
		public function get_transient($key)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$transient_prefix         = '_'.$this->instance->plugin_prefix.'transient_';
			$transient_timeout_prefix = '_'.$this->instance->plugin_prefix.'transient_timeout_';

			$transient         = $transient_prefix.md5($key);
			$transient_timeout = $transient_timeout_prefix.md5($key);

			if(!defined('WP_INSTALLING')) // WordPress® `get_transient()` does this.
			{
				$all_options = wp_load_alloptions(); // The `alloptions` cache.

				// If option is NOT in alloptions, it is NOT autoloaded, and thus has a timeout.
				if(!isset($all_options[$transient]) && (integer)get_option($transient_timeout) < time())
				{
					$this->delete_transient($key);

					return FALSE; // No longer exists (expired).
				}
			}
			return get_option($transient); // Default return value.
		}

		/**
		 * Deletes a transient value (from the database).
		 *
		 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
		 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
		 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
		 *
		 * @param string $key The key/name for this transient value.
		 *
		 * @return boolean TRUE if deletion was successful, else FALSE by default.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$key` is empty.
		 */
		public function delete_transient($key)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$transient_prefix         = '_'.$this->instance->plugin_prefix.'transient_';
			$transient_timeout_prefix = '_'.$this->instance->plugin_prefix.'transient_timeout_';

			$transient         = $transient_prefix.md5($key);
			$transient_timeout = $transient_timeout_prefix.md5($key);

			if(($deleted = delete_option($transient)))
				delete_option($transient_timeout);

			return ($deleted) ? TRUE : FALSE;
		}

		/**
		 * Deletes expired transients from the database (for the current plugin).
		 *
		 * @return integer Number of rows deleted from the database.
		 *    Note that each transient has two rows (so this count might be off in some respects).
		 */
		public function cleanup_expired_transients()
		{
			$transient_prefix         = '_'.$this->instance->plugin_prefix.'transient_';
			$transient_timeout_prefix = '_'.$this->instance->plugin_prefix.'transient_timeout_';

			$query = // Cleanup expired transients (for the current plugin).

				"DELETE".
				" `transient`, `transient_timeout`".

				" FROM".
				" `".$this->©db_tables->get_wp('options')."` AS `transient`,".
				" `".$this->©db_tables->get_wp('options')."` AS `transient_timeout`".

				" WHERE".
				" `transient`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_prefix))."%'".
				" AND `transient`.`option_name` NOT LIKE '".$this->©string->esc_sql(like_escape($transient_timeout_prefix))."%'".

				" AND `transient_timeout`.`option_name` = CONCAT('".$this->©string->esc_sql($transient_timeout_prefix)."', SUBSTRING(`transient`.`option_name`, CHAR_LENGTH('".$this->©string->esc_sql($transient_prefix)."') + 1))".
				" AND `transient_timeout`.`option_value` < '".$this->©string->esc_sql((string)time())."'";

			$deletions = (integer)$this->©db->query($query);

			return $deletions; // Return total deletions.
		}

		/**
		 * Deletes transients from the database (for the current plugin).
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
		 *
		 * @return integer Number of rows deleted from the database.
		 *    Note that each transient has two rows (so this count might be off in some respects).
		 */
		public function delete_transients($confirmation)
		{
			$this->check_arg_types('boolean', func_get_args());

			$transient_prefix         = '_'.$this->instance->plugin_prefix.'transient_';
			$transient_timeout_prefix = '_'.$this->instance->plugin_prefix.'transient_timeout_';

			if(!$confirmation) return 0; // Added security.

			$query = // Purge all transients (for the current plugin).
				"DELETE".
				" `transients`".

				" FROM".
				" `".$this->©db_tables->get_wp('options')."` AS `transients`".

				" WHERE".
				" `transients`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_prefix))."%'".
				" OR `transients`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_timeout_prefix))."%'";

			return (integer)$this->©db->query($query);
		}

		/**
		 * Deletes all CRON jobs associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
		 *
		 * @return integer The number of CRON jobs that were deleted. Possibly `0`.
		 *    Check the CRONs class for further details on this return value.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 *
		 * @note Called upon by the {@link ___uninstall___()} method below.
		 */
		public function delete_cron_jobs($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation) return 0; // Added security.

			return $this->©crons->delete(TRUE, $this->cron_jobs);
		}

		/**
		 * Adds data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully installed.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___activate___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation) return FALSE; // Added security.

			$this->cleanup_expired_transients();
			$this->delete_cron_jobs(TRUE);

			return TRUE;
		}

		/**
		 * Removes data/procedures associated with this class.
		 *
		 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
		 *    If this is FALSE, nothing will happen; and this method returns FALSE.
		 *
		 * @return boolean TRUE if successfully uninstalled.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function ___uninstall___($confirmation = FALSE)
		{
			$this->check_arg_types('boolean', func_get_args());

			if(!$confirmation) return FALSE; // Added security.

			$this->delete_transients(TRUE);
			$this->delete_cron_jobs(TRUE);

			return TRUE;
		}
	}
}