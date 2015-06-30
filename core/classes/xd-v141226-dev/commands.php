<?php
/**
 * Command Line Tools.
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
	 * Command Line Tools.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class commands extends framework
	{
		/**
		 * Path to Git application.
		 *
		 * Normally exit status `0` indicates success.
		 *
		 * @var string Path to `git` command line tool.
		 */
		public $git = 'git';

		/**
		 * Path to SASS application.
		 *
		 * Normally exit status `0` indicates success.
		 *
		 * @var string Path to `sass` command line tool.
		 */
		public $sass = 'sass';

		/**
		 * Path to YUI Compressor application.
		 *
		 * Normally exit status `0` indicates success.
		 *
		 * @var string Path to `yuicompressor` command line tool.
		 */
		public $yuic = 'yuicompressor --charset="utf-8"';

		/**
		 * Path to Java™ application.
		 *
		 * Normally exit status `0` indicates success.
		 * However, this depends on which JAR file is called upon.
		 *
		 * @var string Path to `java` command line tool.
		 */
		public $java = 'java -Xms2M -Xmx32M';

		/**
		 * Path to `rmdir` in Windows®. Exit status `0` on success.
		 *
		 * However, unable to find any official docs on exit status codes.
		 *
		 * @var string Path to `rmdir` command line tool.
		 *
		 * @note This command requires `\` directory separators; else it chokes.
		 */
		public $rmdir = 'rmdir';

		/**
		 * Path to `mklink` on Windows®. Exit status `0` on success.
		 *
		 * However, unable to find any official docs on exit status codes.
		 *
		 * @var string Path to `mklink` command line tool.
		 */
		public $mklink = 'mklink';

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance); // Construct instance.

			$this->sass = 'sass --cache-location='.escapeshellarg($this->©dir->temp().'/.sass-cache');
		}

		/**
		 * Are command line operations possible?
		 *
		 * @return boolean TRUE if commands are possible.
		 */
		public function possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->©function->is_possible('exec')
			   && $this->©function->is_possible('shell_exec')
			   && $this->©function->is_possible('proc_open')
			   && !ini_get('open_basedir')
			) $this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are Unix® command line operations possible?
		 *
		 * @return boolean TRUE if Unix® command line operations are possible.
		 */
		public function unix_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && $this->©env->is_unix())
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are Windows® command line operations possible?
		 *
		 * @return boolean TRUE if Windows® command line operations are possible.
		 */
		public function windows_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && $this->©env->is_windows())
				$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are Java™ command line operations possible?
		 *
		 * @return boolean TRUE if Java™ command line operations are possible.
		 */
		public function java_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($java = $this->exec($this->java.' -version', '', TRUE)))
				if($java['status'] === 0 && preg_match('/[1-9]+\.[0-9]/', $java['output']))
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are Git command line operations possible?
		 *
		 * @return boolean TRUE if Git command line operations are possible.
		 */
		public function git_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($git = $this->exec($this->git.' --version', '', TRUE)))
				if($git['status'] === 0 && preg_match('/[1-9]+\.[0-9]/', $git['output']))
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are SASS command line operations possible?
		 *
		 * @return boolean TRUE if SASS command line operations are possible.
		 */
		public function sass_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($sass = $this->exec($this->sass.' --version', '', TRUE)))
				if($sass['status'] === 0 && preg_match('/[1-9]+\.[0-9]/', $sass['output']))
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Are YUI Compressor command line operations possible?
		 *
		 * @return boolean TRUE if YUI Compressor command line operations are possible.
		 */
		public function yuic_possible()
		{
			if(isset($this->static[__FUNCTION__]))
				return $this->static[__FUNCTION__];

			$this->static[__FUNCTION__] = FALSE;

			if($this->possible() && is_array($yuic = $this->exec($this->yuic.' --version', '', TRUE)))
				if($yuic['status'] === 0 && preg_match('/[1-9]+\.[0-9]/', $yuic['output']))
					$this->static[__FUNCTION__] = TRUE;

			return $this->static[__FUNCTION__];
		}

		/**
		 * Command line execution processor.
		 *
		 * @param string  $cmd_args Command and arguments.
		 *
		 * @param string  $stdin Optional standard input to this command. This will be written to the input pipe.
		 *
		 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
		 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *
		 * @param boolean $return_errors If an error occurs, return an `errors` object instead of a string or array? Defaults to FALSE.
		 *    If TRUE, upon an error occurring, an `errors` object will be returned instead of a string or array.
		 *
		 * @param string  $cwd The initial working dir for the command. This must be an absolute directory path.
		 *    Defaults to an empty string. If needed, this parameter can by bypassed with an empty string.
		 *    Actually, this defaults to a NULL value, but that's handled internally.
		 *    To bypass this argument, use an empty string.
		 *
		 * @param array   $env An array with the environment variables for the command that will be run,
		 *    or an empty array to use the same environment as the current PHP process. Defaults to an empty array.
		 *    Actually, this defaults to a NULL value, but that's handled internally.
		 *    To bypass this argument, use an empty array.
		 *
		 * @param array   $other Allows you to specify additional options. Defaults to an empty array.
		 *    Actually, this defaults to a NULL value, but that's handled internally.
		 *    To bypass this argument, use an empty array.
		 *
		 * @see {@link http://php.net/manual/en/function.proc-open.php}
		 *
		 * @return string|array|errors The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *    The return value of this function will depend very much on the command that was actually called upon.
		 *    ~ And, of course, also based on the argument values: `$return_array`, `$return_errors`.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function exec($cmd_args, $stdin = '', $return_array = FALSE, $return_errors = FALSE, $cwd = '', $env = array(), $other = array())
		{
			$this->check_arg_types('string:!empty', 'string', 'boolean', 'boolean',
			                       array('string', 'null'), array('array', 'null'), array('array', 'null'), func_get_args());

			// Bypass each of these in the `proc_open()` call with NULL values (if they are empty).

			$cwd   = $this->©var->is_not_empty_or($cwd, NULL);
			$env   = $this->©var->is_not_empty_or($env, NULL);
			$other = $this->©var->is_not_empty_or($other, NULL);

			$specs  = array( // Configure file descriptor specifications.
			                 0 => array('pipe', 'r'), // Input pipe for command to read input from (for us to write to).
			                 1 => array('pipe', 'w'), // Output pipe for command to write its output to (for us to read from).
			                 2 => array('pipe', 'w') // Error output pipe for command to write its errors to (for us to read from).
			);
			$errors = $this->©errors(); // Initialize an errors object instance.

			if(!$this->possible() || !is_resource($_process = proc_open($cmd_args, $specs, $_pipes, $cwd, $env, $other)))
			{
				$error = (!$this->possible()) ? $this->__('Commands are NOT possible on this server.')
					: $this->__('Unable to acquire a `proc_open()` resource.');

				$errors->add($this->method(__FUNCTION__), get_defined_vars(), $error);

				if($return_errors)
					return $errors;

				if($return_array)
					return array(
						'output' => '',
						'error'  => $error,
						'errors' => $errors,
						'status' => -1
					);
				return ''; // Default return value (failure).
			}
			if(strlen($stdin))
				fwrite($_pipes[0], $stdin);
			fclose($_pipes[0]); // Close pipe.

			$output = trim((string)stream_get_contents($_pipes[1]));
			fclose($_pipes[1]); // Close pipe.

			$error = trim((string)stream_get_contents($_pipes[2]));
			fclose($_pipes[2]); // Close pipe.

			$status = (integer)proc_close($_process);
			unset($_process, $_pipes);

			if($error) // Did we get an error?
				$errors->add($this->method(__FUNCTION__), get_defined_vars(), $error);

			if($return_errors && $errors->exist())
				return $errors;

			if($return_array)
				return array(
					'output' => $output,
					'error'  => $error,
					'errors' => $errors,
					'status' => $status
				);
			return $output;
		}

		/**
		 * A utility method for easier SASS interaction.
		 *
		 * @param string  $args Command and arguments; or only the arguments.
		 *    It is NOT necessary to prefix this with `sass`; this routine will handle that automatically.
		 *    If you do pass `sass`; it will be removed automatically and replaced with `$this->sass`.
		 *
		 * @param string  $cwd Current working directory. This must be an absolute directory path.
		 *    Optional. This is the working directory from which SASS will be called upon.
		 *
		 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
		 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *
		 * @return string|array The output from SASS; always a string. However, this will throw an exception if SASS returns a non-zero status or errors.
		 *    If `$return_array` is TRUE, we simply return the full array of connection details, regardless of what SASS returns.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$return_array` is FALSE; and SASS returns a non-zero status.
		 * @throws exception If `$return_array` is FALSE; and SASS returns errors.
		 */
		public function sass($args, $cwd = '', $return_array = FALSE)
		{
			$this->check_arg_types('string:!empty', 'string', 'boolean', func_get_args());

			$sass_args = $this->sass.' '.preg_replace('/^(?:'.preg_quote($this->sass, '/').'|sass)\s+/', '', $args);
			$sass      = $this->exec($sass_args, '', TRUE, FALSE, $cwd);

			if($return_array) return $sass; // Return array to caller?

			$sass_status = $sass['status'];
			$sass_errors = $sass['errors'];
			/** @var errors $sass_errors */

			if($sass_status !== 0)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#non_zero_status', get_defined_vars(),
					sprintf($this->__('The command: `%1$s` returned a non-zero status: `%2$s`. SASS said: `%3$s`'),
					        $sass_args, $sass_status, $sass_errors->get_message())
				);
			if($sass_errors->exist())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#errors_exist', get_defined_vars(),
					sprintf($this->__('The command: `%1$s` returned errors w/ status: `%2$s`. SASS said: `%3$s`'),
					        $sass_args, $sass_status, $sass_errors->get_message())
				);
			return $sass['output'];
		}

		/**
		 * A utility method for easier YUI Compressor interaction.
		 *
		 * @param string  $args Command and arguments; or only the arguments.
		 *    It is NOT necessary to prefix this with `yuicompressor`; this routine will handle that automatically.
		 *    If you do pass `yuicompressor`; it will be removed automatically and replaced with `$this->yuic`.
		 *
		 * @param string  $cwd Current working directory. This must be an absolute directory path.
		 *    Optional. This is the working directory from which YUI Compressor will be called upon.
		 *
		 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
		 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *
		 * @return string|array The output from YUI Compressor; always a string. However, this will throw an exception if YUI Compressor returns a non-zero status or errors.
		 *    If `$return_array` is TRUE, we simply return the full array of connection details, regardless of what YUI Compressor returns.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$return_array` is FALSE; and YUI Compressor returns a non-zero status.
		 * @throws exception If `$return_array` is FALSE; and YUI Compressor returns errors.
		 */
		public function yuic($args, $cwd = '', $return_array = FALSE)
		{
			$this->check_arg_types('string:!empty', 'string', 'boolean', func_get_args());

			$yuic_args = $this->yuic.' '.preg_replace('/^(?:'.preg_quote($this->yuic, '/').'|yuicompressor)\s+/', '', $args);
			$yuic      = $this->exec($yuic_args, '', TRUE, FALSE, $cwd);

			if($return_array) return $yuic; // Return array to caller?

			$yuic_status = $yuic['status'];
			$yuic_errors = $yuic['errors'];
			/** @var errors $yuic_errors */

			if($yuic_status !== 0)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#non_zero_status', get_defined_vars(),
					sprintf($this->__('The command: `%1$s` returned a non-zero status: `%2$s`. YUI Compressor said: `%3$s`'),
					        $yuic_args, $yuic_status, $yuic_errors->get_message())
				);
			if($yuic_errors->exist())
				throw $this->©exception(
					$this->method(__FUNCTION__).'#errors_exist', get_defined_vars(),
					sprintf($this->__('The command: `%1$s` returned errors w/ status: `%2$s`. YUI Compressor said: `%3$s`'),
					        $yuic_args, $yuic_status, $yuic_errors->get_message())
				);
			return $yuic['output'];
		}

		/**
		 * A utility method for easier Git interaction.
		 *
		 * @param string  $args Command and arguments; or only the arguments.
		 *    It is NOT necessary to prefix this with `git`; this routine will handle that automatically.
		 *    If you do pass `git`; it will be removed automatically and replaced with `$this->git`.
		 *
		 * @param string  $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @param boolean $return_array Return full array? Defaults to FALSE. If TRUE, this method will return an array with all connection details.
		 *    The default behavior of this function is to simply return a string that contains any output received from the command line routine.
		 *
		 * @return string|array The output from Git; always a string. However, this will throw an exception if Git returns a non-zero status.
		 *    If `$return_array` is TRUE, we simply return the full array of connection details, regardless of what Git returns.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If `$return_array` is FALSE; and Git returns a non-zero status.
		 *    We ignore Git error messages; because Git writes its progress to STDERR.
		 *    Thus, STDERR really should NOT be used to determine Git status.
		 */
		public function git($args, $cwd_repo_dir, $return_array = FALSE)
		{
			$this->check_arg_types('string:!empty', 'string:!empty', 'boolean', func_get_args());

			$cwd_repo_dir = $this->©dir->n_seps($cwd_repo_dir);
			$args         = preg_replace('/\/+/', '/', str_replace(array(DIRECTORY_SEPARATOR, '\\', '/'), '/', $args));
			$args         = str_ireplace($cwd_repo_dir.'/', '', $args);

			$git_args = $this->git.' '.preg_replace('/^(?:'.preg_quote($this->git, '/').'|git)\s+/', '', $args);
			$git      = $this->exec($git_args, '', TRUE, FALSE, $cwd_repo_dir);

			if($return_array) return $git; // Return array to caller?

			$git_status = $git['status'];
			$git_errors = $git['errors'];
			/** @var errors $git_errors */

			if($git_status !== 0)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#non_zero_status', get_defined_vars(),
					sprintf($this->__('The command: `%1$s` returned a non-zero status: `%2$s`. Git said: `%3$s`'),
					        $git_args, $git_status, $git_errors->get_message())
				);
			return $git['output'];
		}

		/**
		 * Gets current Git branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The current Git branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to determine the current Git branch.
		 */
		public function git_current_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			if(!($current_branch = trim($this->git('rev-parse --abbrev-ref HEAD', $cwd_repo_dir))))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#unable_to_determine', get_defined_vars(),
					sprintf($this->__('Unable to determine current branch in: `%1$s`.'), $cwd_repo_dir)
				);
			return $current_branch;
		}

		/**
		 * Gets an array of all Git branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all Git branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git branches.
		 */
		public function git_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = trim($this->git('branch', $cwd_repo_dir));
			$branches = preg_split('/['."\r\n".']+/', $branches, NULL, PREG_SPLIT_NO_EMPTY);
			$branches = $this->©strings->trim_deep($branches, '', '*');

			foreach($branches as &$_branch) // Cleanup symbolic reference pointers.
				if(strpos($_branch, '->') !== FALSE) $_branch = trim(strstr($_branch, '->', TRUE));
			unset($_branch); // Housekeeping.

			$branches = $this->©strings->trim_deep($branches);
			$branches = $this->©array->remove_empty_values_deep($branches);

			if(!$branches)
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_branches', get_defined_vars(),
					sprintf($this->__('No branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $branches;
		}

		/**
		 * Gets an array of all Git version branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all Git version branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git version branches.
		 */
		public function git_version_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = $this->git_branches($cwd_repo_dir);

			foreach($branches as $_branch) // Version branches.
				if($this->©string->is_version($_branch))
					$version_branches[] = $_branch;
			unset($_branch); // Housekeeping.

			if(empty($version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_version_branches', get_defined_vars(),
					sprintf($this->__('No version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $version_branches;
		}

		/**
		 * Gets an array of all Git plugin version branches for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return array An array of all Git plugin version branches; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git plugin version branches.
		 */
		public function git_plugin_version_branches($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$branches = $this->git_branches($cwd_repo_dir);

			foreach($branches as $_branch) // Plugin version branches.
				if($this->©string->is_plugin_version($_branch))
					$plugin_version_branches[] = $_branch;
			unset($_branch); // Housekeeping.

			if(empty($plugin_version_branches)) // No plugin version branches?
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			return $plugin_version_branches;
		}

		/**
		 * Gets latest Git version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git version branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git version branches.
		 */
		public function git_latest_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			usort($version_branches, 'version_compare');

			return array_pop($version_branches);
		}

		/**
		 * Gets latest Git plugin version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git plugin version branch; else an exception is thrown.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git plugin version branches.
		 */
		public function git_latest_plugin_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			usort($plugin_version_branches, 'version_compare');

			return array_pop($plugin_version_branches);
		}

		/**
		 * Gets latest Git dev version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git dev version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git version branches.
		 * @throws exception If there are no Git dev version branches available.
		 */
		public function git_latest_dev_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			foreach($version_branches as $_version_branch)
				if($this->©string->is_dev_version($_version_branch))
					$dev_version_branches[] = $_version_branch;
			unset($_version_branch); // Housekeeping.

			if(empty($dev_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_dev_version_branches', get_defined_vars(),
					sprintf($this->__('No dev version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($dev_version_branches, 'version_compare');

			return array_pop($dev_version_branches);
		}

		/**
		 * Gets latest Git plugin dev version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git plugin dev version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git plugin version branches.
		 * @throws exception If there are no Git plugin dev version branches available.
		 */
		public function git_latest_plugin_dev_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			foreach($plugin_version_branches as $_plugin_version_branch)
				if($this->©string->is_plugin_dev_version($_plugin_version_branch))
					$plugin_dev_version_branches[] = $_plugin_version_branch;
			unset($_plugin_version_branch); // Housekeeping.

			if(empty($plugin_dev_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_dev_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin dev version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($plugin_dev_version_branches, 'version_compare');

			return array_pop($plugin_dev_version_branches);
		}

		/**
		 * Gets latest Git stable version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git stable version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git version branches.
		 * @throws exception If there are no Git stable version branches available.
		 */
		public function git_latest_stable_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$version_branches = $this->git_version_branches($cwd_repo_dir);

			foreach($version_branches as $_version_branch)
				if($this->©string->is_stable_version($_version_branch))
					$stable_version_branches[] = $_version_branch;
			unset($_version_branch); // Housekeeping.

			if(empty($stable_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_stable_version_branches', get_defined_vars(),
					sprintf($this->__('No stable version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($stable_version_branches, 'version_compare');

			return array_pop($stable_version_branches);
		}

		/**
		 * Gets latest Git plugin stable version branch for a given repo directory.
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return string The latest Git plugin stable version branch.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 * @throws exception If unable to acquire Git plugin version branches.
		 * @throws exception If there are no Git plugin stable version branches available.
		 */
		public function git_latest_plugin_stable_version_branch($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$plugin_version_branches = $this->git_plugin_version_branches($cwd_repo_dir);

			foreach($plugin_version_branches as $_plugin_version_branch)
				if($this->©string->is_plugin_stable_version($_plugin_version_branch))
					$plugin_stable_version_branches[] = $_plugin_version_branch;
			unset($_plugin_version_branch); // Housekeeping.

			if(empty($plugin_stable_version_branches))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#no_plugin_stable_version_branches', get_defined_vars(),
					sprintf($this->__('No plugin stable version branches in: `%1$s`.'), $cwd_repo_dir)
				);
			usort($plugin_stable_version_branches, 'version_compare');

			return array_pop($plugin_stable_version_branches);
		}

		/**
		 * Any uncommitted changes (and/or untracked & unignored) files?
		 *
		 * @param string $cwd_repo_dir The repo directory. This must be an absolute directory path.
		 *    This is the working directory from which Git will be called upon (i.e. the repo directory).
		 *
		 * @return boolean TRUE if there are any uncommitted changes (and/or untracked & unignored) files.
		 *
		 * @throws exception If invalid types are passed through arguments list.
		 */
		public function git_changes_exist($cwd_repo_dir)
		{
			$this->check_arg_types('string:!empty', func_get_args());

			$porcelain = trim($this->git('status --porcelain', $cwd_repo_dir));

			return (strlen($porcelain)) ? TRUE : FALSE;
		}
	}
}