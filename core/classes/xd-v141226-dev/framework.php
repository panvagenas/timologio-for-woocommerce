<?php
/**
 * XDaRk Core Framework.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
# -----------------------------------------------------------------------------------------------------------------------------------------
# XDaRk Core framework (only if it does NOT exist yet). This is the base class for the XDaRk Core.
# -----------------------------------------------------------------------------------------------------------------------------------------
namespace xd_v141226_dev {
	if (!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	if (!class_exists('\\'.__NAMESPACE__.'\\framework')) {
		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core stub class; and an internal/namespaced alias.
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!class_exists('\\'.__NAMESPACE__)) {
			$GLOBALS[ 'autoload_'.__NAMESPACE__ ] = false;
			require_once dirname(dirname(dirname(__FILE__))).'/stub.php';
		}
		if (!class_exists('\\'.__NAMESPACE__.'\\stub'))
			class_alias('\\'.__NAMESPACE__, __NAMESPACE__.'\\stub');

		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core deps class; and an internal/namespaced alias.
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!class_exists('\\deps_'.__NAMESPACE__))
			require_once dirname(__FILE__).'/deps.php';

		if (!class_exists('\\'.__NAMESPACE__.'\\deps'))
			class_alias('\\deps_'.__NAMESPACE__, __NAMESPACE__.'\\deps');

		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core framework constants.
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!interface_exists('\\'.__NAMESPACE__.'\\fw_constants'))
			require_once dirname(__FILE__).'/fw-constants.php';

		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core instance config class.
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!class_exists('\\'.__NAMESPACE__.'\\instance'))
			require_once dirname(__FILE__).'/instance.php';

		# -----------------------------------------------------------------------------------------------------------------------------
		# WordPress® version (only if NOT already defined by WordPress®).
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!defined('WP_VERSION'))
			/**
			 * @var string WordPress® version.
			 */
			define('WP_VERSION', $GLOBALS['wp_version']);

		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core framework class definition.
		# -----------------------------------------------------------------------------------------------------------------------------
		/**
		 * XDaRk Core Framework.
		 *
		 * @package XDaRk\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 *
		 * @note Dynamic properties/methods are defined explicitly here.
		 *    This way IDEs jive with `__get()` and `__call()`.
		 *
		 * @note Magic properties/methods should be declared with a FQN because PhpStorm™ seems to have trouble
		 *    identifying them throughout the entire codebase w/o a FQN (for whatever reason — a possible bug).
		 *
		 * @property \xd_v141226_dev\actions                                  $©actions
		 * @property \xd_v141226_dev\actions                                  $©action
		 * @method \xd_v141226_dev\actions ©actions()
		 * @method \xd_v141226_dev\actions ©action()
		 *
		 * @property \xd_v141226_dev\arrays                                   $©arrays
		 * @property \xd_v141226_dev\arrays                                   $©array
		 * @method \xd_v141226_dev\arrays ©arrays()
		 * @method \xd_v141226_dev\arrays ©array()
		 *
		 * @property \xd_v141226_dev\booleans                                 $©booleans
		 * @property \xd_v141226_dev\booleans                                 $©boolean
		 * @method \xd_v141226_dev\booleans ©booleans()
		 * @method \xd_v141226_dev\booleans ©boolean()
		 *
		 * @method \xd_v141226_dev\builder ©builder()
		 * @method \xd_v141226_dev\builder ©build()
		 *
		 * @property \xd_v141226_dev\caps                                     $©caps
		 * @property \xd_v141226_dev\caps                                     $©cap
		 * @method \xd_v141226_dev\caps ©caps()
		 * @method \xd_v141226_dev\caps ©cap()
		 *
		 * @property \xd_v141226_dev\captchas                                 $©captchas
		 * @property \xd_v141226_dev\captchas                                 $©captcha
		 * @method \xd_v141226_dev\captchas ©captchas()
		 * @method \xd_v141226_dev\captchas ©captcha()
		 *
		 * @property \xd_v141226_dev\classes                                  $©classes
		 * @property \xd_v141226_dev\classes                                  $©class
		 * @method \xd_v141226_dev\classes ©classes()
		 * @method \xd_v141226_dev\classes ©class()
		 *
		 * @property \xd_v141226_dev\commands                                 $©commands
		 * @property \xd_v141226_dev\commands                                 $©command
		 * @method \xd_v141226_dev\commands ©commands()
		 * @method \xd_v141226_dev\commands ©command()
		 *
		 * @property \xd_v141226_dev\cookies                                  $©cookies
		 * @property \xd_v141226_dev\cookies                                  $©cookie
		 * @method \xd_v141226_dev\cookies ©cookies()
		 * @method \xd_v141226_dev\cookies ©cookie()
		 *
		 * @property \xd_v141226_dev\crons                                    $©crons
		 * @property \xd_v141226_dev\crons                                    $©cron
		 * @method \xd_v141226_dev\crons ©crons()
		 * @method \xd_v141226_dev\crons ©cron()
		 *
		 * @property \xd_v141226_dev\currencies                               $©currencies
		 * @property \xd_v141226_dev\currencies                               $©currency
		 * @method \xd_v141226_dev\currencies ©currencies()
		 * @method \xd_v141226_dev\currencies ©currency()
		 *
		 * @property \xd_v141226_dev\dates                                    $©dates
		 * @property \xd_v141226_dev\dates                                    $©date
		 * @method \xd_v141226_dev\dates ©dates()
		 * @method \xd_v141226_dev\dates ©date()
		 *
		 * @property \wpdb|\xd_v141226_dev\db                                 $©db
		 * @method \wpdb|\xd_v141226_dev\db ©db()
		 *
		 * @property \xd_v141226_dev\db_cache                                 $©db_cache
		 * @method \xd_v141226_dev\db_cache ©db_cache()
		 *
		 * @property \xd_v141226_dev\db_tables                                $©db_tables
		 * @property \xd_v141226_dev\db_tables                                $©db_table
		 * @method \xd_v141226_dev\db_tables ©db_tables()
		 * @method \xd_v141226_dev\db_tables ©db_table()
		 *
		 * @property \xd_v141226_dev\db_utils                                 $©db_utils
		 * @property \xd_v141226_dev\db_utils                                 $©db_util
		 * @method \xd_v141226_dev\db_utils ©db_utils()
		 * @method \xd_v141226_dev\db_utils ©db_util()
		 *
		 * @property \xd_v141226_dev\diagnostics                              $©diagnostics
		 * @property \xd_v141226_dev\diagnostics                              $©diagnostic
		 * @method \xd_v141226_dev\diagnostics ©diagnostics()
		 * @method \xd_v141226_dev\diagnostics ©diagnostic()
		 *
		 * @property \xd_v141226_dev\dirs                                     $©dirs
		 * @property \xd_v141226_dev\dirs                                     $©dir
		 * @method \xd_v141226_dev\dirs ©dirs()
		 * @method \xd_v141226_dev\dirs ©dir()
		 *
		 * @property \xd_v141226_dev\dirs_files                               $©dirs_files
		 * @property \xd_v141226_dev\dirs_files                               $©dir_file
		 * @method \xd_v141226_dev\dirs_files ©dirs_files()
		 * @method \xd_v141226_dev\dirs_files ©dir_file()
		 *
		 * @property \xd_v141226_dev\encryption                               $©encryption
		 * @method \xd_v141226_dev\encryption ©encryption()
		 *
		 * @property \xd_v141226_dev\env                                      $©env
		 * @method \xd_v141226_dev\env ©env()
		 *
		 * @property \xd_v141226_dev\errors                                   $©errors
		 * @property \xd_v141226_dev\errors                                   $©error
		 * @method \xd_v141226_dev\errors ©errors()
		 * @method \xd_v141226_dev\errors ©error()
		 *
		 * @property \xd_v141226_dev\exception                                $©exception
		 * @method \xd_v141226_dev\exception ©exception()
		 *
		 * @property \xd_v141226_dev\feeds                                    $©feeds
		 * @property \xd_v141226_dev\feeds                                    $©feed
		 * @method \xd_v141226_dev\feeds ©feeds()
		 * @method \xd_v141226_dev\feeds ©feed()
		 *
		 * @property \xd_v141226_dev\files                                    $©files
		 * @property \xd_v141226_dev\files                                    $©file
		 * @method \xd_v141226_dev\files ©files()
		 * @method \xd_v141226_dev\files ©file()
		 *
		 * @property \xd_v141226_dev\floats                                   $©floats
		 * @property \xd_v141226_dev\floats                                   $©float
		 * @method \xd_v141226_dev\floats ©floats()
		 * @method \xd_v141226_dev\floats ©float()
		 *
		 * @property \xd_v141226_dev\forms                                    $©forms
		 * @property \xd_v141226_dev\forms                                    $©form
		 * @method \xd_v141226_dev\forms ©forms()
		 * @method \xd_v141226_dev\forms ©form()
		 *
		 * @property \xd_v141226_dev\form_fields                              $©form_fields
		 * @property \xd_v141226_dev\form_fields                              $©form_field
		 * @method \xd_v141226_dev\form_fields ©form_fields()
		 * @method \xd_v141226_dev\form_fields ©form_field()
		 *
		 * @property \xd_v141226_dev\framework                                $©framework
		 * @method \xd_v141226_dev\framework ©framework()
		 *
		 * @property \xd_v141226_dev\functions                                $©functions
		 * @property \xd_v141226_dev\functions                                $©function
		 * @method \xd_v141226_dev\functions ©functions()
		 * @method \xd_v141226_dev\functions ©function()
		 *
		 * @property \xd_v141226_dev\gmp                                      $©gmp
		 * @method \xd_v141226_dev\gmp ©gmp()
		 *
		 * @property \xd_v141226_dev\headers                                  $©headers
		 * @property \xd_v141226_dev\headers                                  $©header
		 * @method \xd_v141226_dev\headers ©headers()
		 * @method \xd_v141226_dev\headers ©header()
		 *
		 * @property \xd_v141226_dev\initializer                              $©initializer
		 * @method \xd_v141226_dev\initializer ©initializer()
		 *
		 * @property \xd_v141226_dev\installer                                $©installer
		 * @method \xd_v141226_dev\installer ©installer()
		 *
		 * @property \xd_v141226_dev\integers                                 $©integers
		 * @property \xd_v141226_dev\integers                                 $©integer
		 * @method \xd_v141226_dev\integers ©integers()
		 * @method \xd_v141226_dev\integers ©integer()
		 *
		 * @property \xd_v141226_dev\ips                                      $©ips
		 * @property \xd_v141226_dev\ips                                      $©ip
		 * @method \xd_v141226_dev\ips ©ips()
		 * @method \xd_v141226_dev\ips ©ip()
		 *
		 * @property \xd_v141226_dev\mail                                     $©mail
		 * @method \xd_v141226_dev\mail ©mail()
		 *
		 * @property \xd_v141226_dev\markdown                                 $©markdown
		 * @method \xd_v141226_dev\markdown ©markdown()
		 *
		 * @property \xd_v141226_dev\menu_pages                               $©menu_pages
		 * @property \xd_v141226_dev\menu_pages                               $©menu_page
		 * @method \xd_v141226_dev\menu_pages ©menu_pages()
		 * @method \xd_v141226_dev\menu_pages ©menu_page()
		 *
		 * @property \xd_v141226_dev\menu_pages\general_options               $©menu_pages__general_options
		 * @method \xd_v141226_dev\menu_pages\general_options ©menu_pages__general_options()
		 *
		 * @property \xd_v141226_dev\menu_pages\menu_page                     $©menu_pages__menu_page
		 * @method \xd_v141226_dev\menu_pages\menu_page ©menu_pages__menu_page()
		 *
		 * @property \xd_v141226_dev\menu_pages\main_page                     $©menu_pages__main_page
		 * @method \xd_v141226_dev\menu_pages\main_page ©menu_pages__main_page()
		 *
		 * @property \xd_v141226_dev\menu_pages\update_sync                   $©menu_pages__update_sync
		 * @method \xd_v141226_dev\menu_pages\update_sync ©menu_pages__update_sync()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\community_forum        $©menu_pages__panels__community_forum
		 * @method \xd_v141226_dev\menu_pages\panels\community_forum ©menu_pages__panels__community_forum()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\donations              $©menu_pages__panels__donations
		 * @method \xd_v141226_dev\menu_pages\panels\donations ©menu_pages__panels__donations()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\email_updates          $©menu_pages__panels__email_updates
		 * @method \xd_v141226_dev\menu_pages\panels\email_updates ©menu_pages__panels__email_updates()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\news_kb                $©menu_pages__panels__news_kb
		 * @method \xd_v141226_dev\menu_pages\panels\news_kb ©menu_pages__panels__news_kb()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\panel                  $©menu_pages__panels__panel
		 * @method \xd_v141226_dev\menu_pages\panels\panel ©menu_pages__panels__panel()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\pro_upgrade            $©menu_pages__panels__pro_upgrade
		 * @method \xd_v141226_dev\menu_pages\panels\pro_upgrade ©menu_pages__panels__pro_upgrade()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\quick_start_video      $©menu_pages__panels__quick_start_video
		 * @method \xd_v141226_dev\menu_pages\panels\quick_start_video ©menu_pages__panels__quick_start_video()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\update                 $©menu_pages__panels__update
		 * @method \xd_v141226_dev\menu_pages\panels\update ©menu_pages__panels__update()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\update_sync_pro        $©menu_pages__panels__update_sync_pro
		 * @method \xd_v141226_dev\menu_pages\panels\update_sync_pro ©menu_pages__panels__update_sync_pro()
		 *
		 * @property \xd_v141226_dev\menu_pages\panels\videos                 $©menu_pages__panels__videos
		 * @method \xd_v141226_dev\menu_pages\panels\videos ©menu_pages__panels__videos()
		 *
		 * @property \xd_v141226_dev\messages                                 $©messages
		 * @property \xd_v141226_dev\messages                                 $©message
		 * @method \xd_v141226_dev\messages ©messages()
		 * @method \xd_v141226_dev\messages ©message()
		 *
		 * @property \xd_v141226_dev\functions                                $©methods
		 * @property \xd_v141226_dev\functions                                $©method
		 * @method \xd_v141226_dev\functions ©methods()
		 * @method \xd_v141226_dev\functions ©method()
		 *
		 * @property \xd_v141226_dev\no_cache                                 $©no_cache
		 * @method \xd_v141226_dev\no_cache ©no_cache()
		 *
		 * @property \xd_v141226_dev\notices                                  $©notices
		 * @property \xd_v141226_dev\notices                                  $©notice
		 * @method \xd_v141226_dev\notices ©notices()
		 * @method \xd_v141226_dev\notices ©notice()
		 *
		 * @property \xd_v141226_dev\options                                  $©options
		 * @property \xd_v141226_dev\options                                  $©option
		 * @method \xd_v141226_dev\options ©options()
		 * @method \xd_v141226_dev\options ©option()
		 *
		 * @property \xd_v141226_dev\objects_os                               $©objects_os
		 * @property \xd_v141226_dev\objects_os                               $©object_os
		 * @method \xd_v141226_dev\objects_os ©objects_os()
		 * @method \xd_v141226_dev\objects_os ©object_os()
		 *
		 * @property \xd_v141226_dev\objects                                  $©objects
		 * @property \xd_v141226_dev\objects                                  $©object
		 * @method \xd_v141226_dev\objects ©objects()
		 * @method \xd_v141226_dev\objects ©object()
		 *
		 * @property \xd_v141226_dev\packages                                 $©packages
		 * @property \xd_v141226_dev\packages                                 $©package
		 * @method \xd_v141226_dev\packages ©packages()
		 * @method \xd_v141226_dev\packages ©package()
		 *
		 * @method \xd_v141226_dev\packages\package                           ©packages__package()
		 * @method \xd_v141226_dev\packages\package                           ©package__package()
		 *
		 * @method \xd_v141226_dev\packages\dependency                        ©packages__dependency()
		 * @method \xd_v141226_dev\packages\dependency                        ©package__dependency()
		 *
		 * @property \xd_v141226_dev\php                                      $©php
		 * @method \xd_v141226_dev\php ©php()
		 *
		 * @property \xd_v141226_dev\plugins                                  $©plugins
		 * @property \xd_v141226_dev\plugins                                  $©plugin
		 * @method \xd_v141226_dev\plugins ©plugins()
		 * @method \xd_v141226_dev\plugins ©plugin()
		 *
		 * @property \xd_v141226_dev\posts                                    $©posts
		 * @property \xd_v141226_dev\posts                                    $©post
		 * @method \xd_v141226_dev\posts ©posts()
		 * @method \xd_v141226_dev\posts ©post()
		 *
		 * @method \xd_v141226_dev\replicator ©replicator()
		 * @method \xd_v141226_dev\replicator ©replicate()
		 *
		 * @property \xd_v141226_dev\scripts                                  $©scripts
		 * @property \xd_v141226_dev\scripts                                  $©script
		 * @method \xd_v141226_dev\scripts ©scripts()
		 * @method \xd_v141226_dev\scripts ©script()
		 *
		 * @property \xd_v141226_dev\strings                                  $©strings
		 * @property \xd_v141226_dev\strings                                  $©string
		 * @method \xd_v141226_dev\strings ©strings()
		 * @method \xd_v141226_dev\strings ©string()
		 *
		 * @property \xd_v141226_dev\styles                                   $©styles
		 * @property \xd_v141226_dev\styles                                   $©style
		 * @method \xd_v141226_dev\styles ©styles()
		 * @method \xd_v141226_dev\styles ©style()
		 *
		 * @property \xd_v141226_dev\successes                                $©successes
		 * @property \xd_v141226_dev\successes                                $©success
		 * @method \xd_v141226_dev\successes ©successes()
		 * @method \xd_v141226_dev\successes ©success()
		 *
		 * @property \xd_v141226_dev\templates                                $©templates
		 * @property \xd_v141226_dev\templates                                $©template
		 * @method \xd_v141226_dev\templates ©templates()
		 * @method \xd_v141226_dev\templates ©template()
		 *
		 * @property \xd_v141226_dev\urls                                     $©urls
		 * @property \xd_v141226_dev\urls                                     $©url
		 * @method \xd_v141226_dev\urls                                       ©urls()
		 * @method \xd_v141226_dev\urls                                       ©url()
		 *
		 * @property \xd_v141226_dev\vars                                     $©vars
		 * @property \xd_v141226_dev\vars                                     $©var
		 * @method \xd_v141226_dev\vars ©vars()
		 * @method \xd_v141226_dev\vars ©var()
		 *
		 * @property \xd_v141226_dev\videos                                   $©videos
		 * @property \xd_v141226_dev\videos                                   $©video
		 * @method \xd_v141226_dev\videos ©videos()
		 * @method \xd_v141226_dev\videos ©video()
		 *
		 * @property \xd_v141226_dev\users                                    $©users
		 * @property \xd_v141226_dev\users                                    $©user
		 * @method \xd_v141226_dev\users                                      ©users()
		 * @method \xd_v141226_dev\users                                      ©user()
		 *
		 * @property \xd_v141226_dev\user_utils                               $©user_utils
		 * @method \xd_v141226_dev\user_utils ©user_utils()
		 *
		 * @property \xd_v141226_dev\xml                                      $©xml
		 * @method \xd_v141226_dev\xml ©xml()
		 *
		 * @property \xd_v141226_dev\instance                                 $instance Public/magic read-only access.
		 *
		 * @property \xd_v141226_dev\edd_updater                              $©edd_updater
		 * @method \xd_v141226_dev\edd_updater                                ©edd_updater()
		 *
		 * @property \xd_v141226_dev\ajax                                     $©ajax
		 * @method \xd_v141226_dev\ajax                                       ©ajax()
		 *
		 * @property \xd_v141226_dev\views                                    $©views
		 * @property \xd_v141226_dev\views                                    $©view
		 * @method \xd_v141226_dev\views                                      ©views()
		 * @method \xd_v141226_dev\views                                      ©view()
		 *
		 * @property \xd_v141226_dev\queries                                  $©queries
		 * @property \xd_v141226_dev\queries                                  $©query
		 * @method \xd_v141226_dev\queries                                    ©queries()
		 * @method \xd_v141226_dev\queries                                    ©query()
		 */
		class framework implements fw_constants // Base class for the XDaRk Core (and for plugins powered by it).
		{
			# --------------------------------------------------------------------------------------------------------------------------
			# Instance configuration properties.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Current instance configuration.
			 *
			 * @var instance Current instance config for `$this`.
			 *    Defaults to NULL. Set by constructor.
			 *
			 * @by-constructor Set by class constructor.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *    However, we DO allow public/magic read-only access.
			 */
			protected $instance; // Defaults to a NULL value.

			/**
			 * A global/static cache of all instance configurations.
			 *
			 * @var instance[] A global/static cache of all instance configurations.
			 *    Defaults to an empty array. Set by constructor.
			 *
			 * @by-constructor Set by class constructor.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected static $___instance_cache = array();

			# --------------------------------------------------------------------------------------------------------------------------
			# Dynamic class properties.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * A global/static cache for dynamic singleton object references.
			 *
			 * @var array A global/static cache for dynamic singleton object references.
			 *    Defaults to an empty array. Set by `__get()` method.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 */
			protected static $___dynamic_class_reference_cache = array();

			/**
			 * A global/static cache for dynamic singleton object instances.
			 *
			 * @var array A global/static cache for dynamic singleton object instances.
			 *    Defaults to an empty array. Set by `__get()` method.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 */
			protected static $___dynamic_class_instance_cache = array();

			/**
			 * Dynamic class aliases.
			 *
			 * @var array Associative array of dynamic class aliases.
			 *    These are "always on" in the XDaRk Core.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 * @see __call()
			 * @see __isset()
			 */
			protected static $___dynamic_class_aliases = array(
				'action'              => 'actions',
				'array'               => 'arrays',
				'boolean'             => 'booleans',
				'build'               => 'builder',
				'cap'                 => 'caps',
				'captcha'             => 'captchas',
				'class'               => 'classes',
				'command'             => 'commands',
				'cookie'              => 'cookies',
				'cron'                => 'crons',
				'currency'            => 'currencies',
				'date'                => 'dates',
				'db_table'            => 'db_tables',
				'db_util'             => 'db_utils',
				'diagnostic'          => 'diagnostics',
				'dir'                 => 'dirs',
				'dir_file'            => 'dirs_files',
				'error'               => 'errors',
				'feed'                => 'feeds',
				'file'                => 'files',
				'float'               => 'floats',
				'form'                => 'forms',
				'form_field'          => 'form_fields',
				'function'            => 'functions',
				'menu_page'           => 'menu_pages',
				'message'             => 'messages',
				'methods'             => 'functions',
				'method'              => 'functions',
				'header'              => 'headers',
				'integer'             => 'integers',
				'ip'                  => 'ips',
				'notice'              => 'notices',
				'option'              => 'options',
				'object_os'           => 'objects_os',
				'object'              => 'objects',
				'package'             => 'packages',
				'package__package'    => 'packages__package',
				'package__dependency' => 'packages__dependency',
				'plugin'              => 'plugins',
				'post'                => 'posts',
				'replicate'           => 'replicator',
				'script'              => 'scripts',
				'string'              => 'strings',
				'style'               => 'styles',
				'success'             => 'successes',
				'template'            => 'templates',
				'url'                 => 'urls',
				'user'                => 'users',
				'var'                 => 'vars',
				'video'               => 'videos',
				'view'                => 'views',
				'query'               => 'queries'
			);

			/**
			 * Dynamic class aliases.
			 *
			 * @var array Associative array of dynamic class aliases.
			 *
			 * @extenders If extenders need to add additional class aliases.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 * @see __call()
			 * @see __isset()
			 */
			protected static $____dynamic_class_aliases = array();

			# --------------------------------------------------------------------------------------------------------------------------
			# Type check properties.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * PHP's `is_...()` type checks.
			 *
			 * @var array PHP `is_...()` type checks.
			 *    Keys correspond with type hints accepted by `check_arg_types()`.
			 *    Values are `is_...()` functions needed to test for each type.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected static $___is_type_checks = array(
				'string'          => 'is_string',
				'!string'         => 'is_string',
				'string:!empty'   => 'is_string',
				'boolean'         => 'is_bool',
				'!boolean'        => 'is_bool',
				'boolean:!empty'  => 'is_bool',
				'bool'            => 'is_bool',
				'!bool'           => 'is_bool',
				'bool:!empty'     => 'is_bool',
				'integer'         => 'is_integer',
				'!integer'        => 'is_integer',
				'integer:!empty'  => 'is_integer',
				'int'             => 'is_integer',
				'!int'            => 'is_integer',
				'int:!empty'      => 'is_integer',
				'float'           => 'is_float',
				'!float'          => 'is_float',
				'float:!empty'    => 'is_float',
				'real'            => 'is_float',
				'!real'           => 'is_float',
				'real:!empty'     => 'is_float',
				'double'          => 'is_float',
				'!double'         => 'is_float',
				'double:!empty'   => 'is_float',
				'numeric'         => 'is_numeric',
				'!numeric'        => 'is_numeric',
				'numeric:!empty'  => 'is_numeric',
				'scalar'          => 'is_scalar',
				'!scalar'         => 'is_scalar',
				'scalar:!empty'   => 'is_scalar',
				'array'           => 'is_array',
				'!array'          => 'is_array',
				'array:!empty'    => 'is_array',
				'object'          => 'is_object',
				'!object'         => 'is_object',
				'object:!empty'   => 'is_object',
				'resource'        => 'is_resource',
				'!resource'       => 'is_resource',
				'resource:!empty' => 'is_resource',
				'null'            => 'is_null',
				'!null'           => 'is_null',
				'null:!empty'     => 'is_null'
			);

			# --------------------------------------------------------------------------------------------------------------------------
			# Properties for static hooks.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * A global/static array of hooks across all extenders; broken down by plugin root namespace.
			 *
			 * @var array A global/static array of hooks across all extenders; broken down by plugin root namespace.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected static $___hooks = array();

			/**
			 * A reference to the array of hooks across all extenders; for the current plugin root namespace.
			 *
			 * @return array A reference to the array of hooks across all extenders; for the current plugin root namespace.
			 *
			 * @final May NOT be overridden by extenders.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			final protected static function &___hooks()
			{
				$plugin_root_ns = strstr(get_called_class(), '\\', true);

				if (!isset(static::$___hooks[ $plugin_root_ns ]))
					static::$___hooks[ $plugin_root_ns ] = array();

				return static::$___hooks[ $plugin_root_ns ];
			}

			/**
			 * An instance-based reference to the array of hooks across all extenders; for the current plugin root namespace.
			 *
			 * @var array An instance-based reference to the array of hooks across all extenders; for the current plugin root namespace.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected $hooks = array();

			# --------------------------------------------------------------------------------------------------------------------------
			# Properties for static & instance-based caches.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * A global/static cache across all extenders; broken down by blog ID & class extender.
			 *
			 * @var array A global/static cache across all extenders; broken down by blog ID & class extender.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see The {@link ___static()} method for further details on this.
			 */
			protected static $___statics = array();

			/**
			 * A reference to the global/static cache for the current blog ID & class extender.
			 *
			 * @return array A reference to the global/static cache for the current blog ID & class extender.
			 *
			 * @final May NOT be overridden by extenders.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			final protected static function &___static()
			{
				$class   = get_called_class();
				$blog_id = (integer) $GLOBALS['blog_id'];

				if (!isset(static::$___statics[ $blog_id ][ $class ]))
					static::$___statics[ $blog_id ][ $class ] = array();

				return static::$___statics[ $blog_id ][ $class ];
			}

			/**
			 * An instance-based reference to the global/static cache for the current blog ID & class extender.
			 *
			 * @var array An instance-based reference to the global/static cache for the current blog ID & class extender.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected $static = array();

			/**
			 * An instance-based cache for each class.
			 *
			 * @var array An instance-based cache for each class.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 */
			protected $cache = array();

			# --------------------------------------------------------------------------------------------------------------------------
			# Read-only property configurations.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Read-only properties.
			 *
			 * @var array An array of read-only properties.
			 *    These are "always on" in the XDaRk Core.
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 * @see __call()
			 * @see __isset()
			 */
			protected static $___read_only_properties = array('instance');

			/**
			 * Read-only properties.
			 *
			 * @var array An array of read-only properties.
			 *
			 * @extenders If extenders need to add additional read-only properties.
			 *
			 * @protected Accessible only to self & extenders.
			 *
			 * @see __get()
			 * @see __call()
			 * @see __isset()
			 */
			protected static $____read_only_properties = array();

			# --------------------------------------------------------------------------------------------------------------------------
			# XDaRk Core class constructor.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Core class constructor.
			 *
			 * @param framework|array $instance Required at all times.
			 *    A framework class object instance containing a parent's `$instance`.
			 *    Or, a new `$instance` array with the elements listed below.
			 *
			 *    An array MUST contain the following elements:
			 *       • `(string)$instance['plugin_name']` — Name of current plugin.
			 *       • `(string)$instance['plugin_var_ns']` — Plugin variable namespace.
			 *       • `(string)$instance['plugin_cap']` — Capability required to manage the plugin.
			 *       • `(string)$instance['plugin_root_ns']` — Root namespace of current plugin.
			 *       • `(string)$instance['plugin_version']` — Version of current plugin.
			 *       • `(string)$instance['plugin_dir']` — Current plugin directory.
			 *       • `(string)$instance['plugin_site']` — Plugin site URL (http://).
			 *
			 * @throws \exception If there is a missing and/or invalid `$instance`.
			 * @throws \exception If there are NOT 7 configuration elements in an `$instance` array.
			 *
			 * @throws \exception If the plugin's root namespace does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_plugin_root_ns}
			 *
			 * @throws \exception If the plugin's variable namespace does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_plugin_var_ns}
			 *
			 * @throws \exception If the plugin's capability does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_plugin_cap}
			 *
			 * @throws \exception If the plugin's version does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_plugin_version}
			 *
			 * @throws \exception If the plugin's directory is missing (e.g. the plugin's directory MUST actually exist).
			 *    In addition, the plugin's directory MUST contain a main `classes` directory with the name `classes`.
			 *    In addition, the plugin's directory MUST contain a main plugin file with the name `plugin.php`.
			 *
			 * @throws \exception If the plugin's site URL is NOT valid (MUST start with `http://.+`).
			 *
			 * @throws \exception If the namespace\class path does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_plugin_ns_class}
			 *
			 * @throws \exception If the core namespace does NOT match this regex validation pattern.
			 *    See: {@link stub::$regex_valid_core_ns_version}
			 *
			 * @public A magic/overload constructor MUST always remain public.
			 *
			 * @extenders If a class extender creates its own constructor,
			 *    it MUST collect an `$instance`, and it MUST call upon this core constructor using:
			 *    `parent::__construct($instance)`.
			 *
			 * @note This should NOT rely directly or indirectly on any other core class objects.
			 *    Any static properties/methods in the XDaRk Core stub will be fine to use though.
			 *    In addition — once the object if fully constructed; we can use anything :-)
			 */
			public function __construct($instance)
			{
				$this->hooks  =& static::___hooks();
				$this->static =& static::___static();

				if ($instance instanceof framework)
					$parent_instance = $instance->instance;
				else $parent_instance = null; // No parent config.

				$ns_class = get_class($this); // Always NEED `$this` for cache entry.

				if ($parent_instance) // Can we bypass validation in this case?
				{
					$cache_entry = $parent_instance->plugin_root_ns.$ns_class;

					if (isset(static::$___instance_cache[ $cache_entry ])) {
						$this->instance = static::$___instance_cache[ $cache_entry ];

						return; // Using cache. Nothing more to do here.
					}
					$this->instance = clone $parent_instance;
				} else if (is_array($instance) && count($instance) === 7

				           && !empty($instance['plugin_name']) && is_string($instance['plugin_name'])

				           && !empty($instance['plugin_root_ns']) && is_string($instance['plugin_root_ns'])
				           && preg_match(stub::$regex_valid_plugin_root_ns, $instance['plugin_root_ns'])

				           && !empty($instance['plugin_var_ns']) && is_string($instance['plugin_var_ns'])
				           && preg_match(stub::$regex_valid_plugin_var_ns, $instance['plugin_var_ns'])

				           && !empty($instance['plugin_version']) && is_string($instance['plugin_version'])
				           && preg_match(stub::$regex_valid_plugin_version, $instance['plugin_version'])

				           && !empty($instance['plugin_cap']) && is_string($instance['plugin_cap'])
				           && preg_match(stub::$regex_valid_plugin_cap, $instance['plugin_cap'])

				           && !empty($instance['plugin_dir']) && is_string($instance['plugin_dir'])
				           && is_dir($instance['plugin_dir'] = stub::n_dir_seps($instance['plugin_dir']))
				           && is_file($instance['plugin_dir'].'/plugin.php') && is_dir($instance['plugin_dir'].'/classes')

				           && !empty($instance['plugin_site']) && is_string($instance['plugin_site'])
				           && ($instance['plugin_site'] = rtrim($instance['plugin_site'], '/'))
				           && preg_match('/^http(s)?\:\/\/.+/i', $instance['plugin_site'])

				) // A fully validated `$instance` array (we'll convert to an object).
				{
					$cache_entry = $instance['plugin_root_ns'].$ns_class;

					if (isset(static::$___instance_cache[ $cache_entry ])) {
						$this->instance = static::$___instance_cache[ $cache_entry ];

						return; // Using cache (nothing more to do here).
					}
					$this->instance = new instance($instance);
				} else throw new \exception(sprintf(stub::__('Invalid `$instance` to constructor: `%1$s`'), print_r($instance, true)));

				// Mostly from core stub. These properties will NOT change from one class instance to another.
				if (!$parent_instance) // Only if we did NOT get a `$parent_instance`.
				{
					// Core name & core site; begins with `http://`.
					$this->instance->core_name = stub::$core_name;
					$this->instance->core_site = stub::$core_site;

					// Core directories; mostly from stub.
					$this->instance->local_wp_dev_dir    = stub::$local_wp_dev_dir;
					$this->instance->local_core_repo_dir = stub::$local_core_repo_dir;
					$this->instance->core_dir            = stub::n_dir_seps_up(__FILE__, 3);
					$this->instance->core_classes_dir    = $this->instance->core_dir.'/classes';

					// Based on `stub::$core_prefix`.
					$this->instance->core_prefix             = stub::$core_prefix;
					$this->instance->core_prefix_with_dashes = stub::$core_prefix_with_dashes;

					// Based on `stub::$core_ns`.
					$this->instance->core_ns             = stub::$core_ns;
					$this->instance->core_ns_prefix      = stub::$core_ns_prefix;
					$this->instance->core_ns_with_dashes = stub::$core_ns_with_dashes;

					// Based on `stub::$core_ns_stub`.
					$this->instance->{stub::$core_ns_stub}    = stub::$core_ns_stub;
					$this->instance->core_ns_stub             = stub::$core_ns_stub;
					$this->instance->core_ns_stub_with_dashes = stub::$core_ns_stub_with_dashes;

					// Based on `stub::$core_ns_stub_v`.
					$this->instance->core_ns_stub_v             = stub::$core_ns_stub_v;
					$this->instance->core_ns_stub_v_with_dashes = stub::$core_ns_stub_v_with_dashes;

					// Based on `stub::$core_version`.
					$this->instance->core_version                  = stub::$core_version;
					$this->instance->core_version_with_underscores = stub::$core_version_with_underscores;
					$this->instance->core_version_with_dashes      = stub::$core_version_with_dashes;

					// Check core `namespace` for validation issues.
					if (!preg_match(stub::$regex_valid_core_ns_version, $this->instance->core_ns))
						throw new \exception(sprintf(stub::__('Invalid core namespace: `%1$s`.'),
							$this->instance->core_ns));
				}
				// Check `namespace\sub_namespace\class` for validation issues.
				if (!preg_match(stub::$regex_valid_plugin_ns_class, ($this->instance->ns_class = $ns_class)))
					throw new \exception(sprintf(stub::__('Namespace\\class contains invalid chars: `%1$s`.'),
						$this->instance->ns_class));

				// The `namespace\sub_namespace` for `$this` class.
				$this->instance->ns = substr($this->instance->ns_class, 0, strrpos($this->instance->ns_class, '\\'));

				// The `sub_namespace\class` for `$this` class.
				$this->instance->sub_ns_class                  = ltrim(strstr($this->instance->ns_class, '\\'), '\\');
				$this->instance->sub_ns_class_with_underscores = stub::with_underscores($this->instance->sub_ns_class);
				$this->instance->sub_ns_class_with_dashes      = stub::with_dashes($this->instance->sub_ns_class);

				// The `namespace\sub_namespace\class` for `$this` class.
				$this->instance->ns_class_prefix           = '\\'.$this->instance->ns_class;
				$this->instance->ns_class_with_underscores = stub::with_underscores($this->instance->ns_class);
				$this->instance->ns_class_with_dashes      = stub::with_dashes($this->instance->ns_class);
				$this->instance->ns_class_basename         = basename(str_replace('\\', '/', $this->instance->ns_class));

				// Only if we're NOT in the same namespace as the `$parent_instance`.
				if (!$parent_instance || $parent_instance->ns !== $this->instance->ns) {
					// The `namespace\sub_namespace` for `$this` class.
					$this->instance->ns_prefix           = '\\'.$this->instance->ns;
					$this->instance->ns_with_underscores = stub::with_underscores($this->instance->ns);
					$this->instance->ns_with_dashes      = stub::with_dashes($this->instance->ns);

					// The `namespace` for `$this` class.
					$this->instance->root_ns             = strstr($this->instance->ns_class, '\\', true);
					$this->instance->root_ns_prefix      = '\\'.$this->instance->root_ns;
					$this->instance->root_ns_with_dashes = stub::with_dashes($this->instance->root_ns);
				}
				// Based entirely on current plugin. These properties will NOT change from one class instance to another.
				if (!$parent_instance) // Only need this routine if we did NOT get a `$parent_instance`.
				{
					// Plugin name & plugin site; begins with `http://`.
					$this->instance->plugin_name = $this->instance->plugin_name;
					$this->instance->plugin_site = $this->instance->plugin_site;

					// Based on `plugin_version`.
					$this->instance->plugin_version                  = $this->instance->plugin_version;
					$this->instance->plugin_version_with_underscores = stub::with_underscores($this->instance->plugin_version);
					$this->instance->plugin_version_with_dashes      = stub::with_dashes($this->instance->plugin_version);

					// Based on `plugin_var_ns` (which serves a few different purposes).
					$this->instance->plugin_var_ns             = $this->instance->plugin_var_ns;
					$this->instance->plugin_var_ns_with_dashes = stub::with_dashes($this->instance->plugin_var_ns);

					// Based on `plugin_var_ns` (which serves a few different purposes).
					$this->instance->plugin_prefix             = $this->instance->plugin_var_ns.'_';
					$this->instance->plugin_prefix_with_dashes = stub::with_dashes($this->instance->plugin_prefix);
					if ($this->instance->plugin_root_ns === $this->instance->core_ns) {
						$this->instance->plugin_prefix             = $this->instance->core_prefix;
						$this->instance->plugin_prefix_with_dashes = $this->instance->core_prefix_with_dashes;
					}
					// Based on `plugin_cap` (used for a default set of access controls).
					$this->instance->plugin_cap             = $this->instance->plugin_cap;
					$this->instance->plugin_cap_with_dashes = stub::with_dashes($this->instance->plugin_cap);

					// Based on plugin's root `namespace` (via `plugin_root_ns`).
					$this->instance->plugin_root_ns             = $this->instance->plugin_root_ns;
					$this->instance->plugin_root_ns_prefix      = '\\'.$this->instance->plugin_root_ns;
					$this->instance->plugin_root_ns_with_dashes = stub::with_dashes($this->instance->plugin_root_ns);

					// Based on plugin's root `namespace` (via `plugin_root_ns`).
					$this->instance->plugin_root_ns_stub             = $this->instance->plugin_root_ns;
					$this->instance->plugin_root_ns_stub_with_dashes = $this->instance->plugin_root_ns_with_dashes;
					if ($this->instance->plugin_root_ns === $this->instance->core_ns) {
						$this->instance->plugin_root_ns_stub             = $this->instance->core_ns_stub;
						$this->instance->plugin_root_ns_stub_with_dashes = $this->instance->core_ns_stub_with_dashes;
					}
					// Based on the plugin's directory (i.e. `plugin_dir`).
					$this->instance->plugin_dir               = $this->instance->plugin_dir;
					$this->instance->plugin_dir_basename      = basename($this->instance->plugin_dir);
					$this->instance->plugin_dir_file_basename = $this->instance->plugin_dir_basename.'/plugin.php';

					// Based on the plugin's directory (i.e. `plugin_dir`).
					if ($this->instance->plugin_root_ns === $this->instance->core_ns)
						$this->instance->plugin_data_dir = stub::get_temp_dir().'/'.$this->instance->core_ns_stub_with_dashes.'-data';
					else $this->instance->plugin_data_dir = stub::n_dir_seps(WP_CONTENT_DIR).'/data/'.$this->instance->plugin_dir_basename;

					// Based on the plugin's directory (i.e. `plugin_dir`).
					$this->instance->plugin_data_dir = // Give filters a chance to modify this if they'd like to.
						apply_filters($this->instance->plugin_root_ns_stub.'__data_dir', $this->instance->plugin_data_dir);

					// Based on the plugin's directory (i.e. `plugin_dir`).
					$this->instance->plugin_file           = $this->instance->plugin_dir.'/plugin.php';
					$this->instance->plugin_classes_dir    = $this->instance->plugin_dir.'/classes';
					$this->instance->plugin_api_class_file = $this->instance->plugin_classes_dir.'/'.$this->instance->plugin_root_ns_with_dashes.'.php';

					// Based on the current plugin; we establish properties for a pro add-on (optional).
					$this->instance->plugin_pro_var = $this->instance->plugin_root_ns.'_pro';

					$this->instance->plugin_pro_dir = $this->instance->plugin_dir.'-pro';
					if (stripos($this->instance->plugin_pro_dir, 'phar://') === 0) // In case of core.
						$this->instance->plugin_pro_dir = substr($this->instance->plugin_pro_dir, 7);
					$this->instance->plugin_pro_dir_basename      = basename($this->instance->plugin_pro_dir);
					$this->instance->plugin_pro_dir_file_basename = $this->instance->plugin_pro_dir_basename.'/plugin.php';

					$this->instance->plugin_pro_file        = $this->instance->plugin_pro_dir.'/plugin.php';
					$this->instance->plugin_pro_classes_dir = $this->instance->plugin_pro_dir.'/classes';
					$this->instance->plugin_pro_class_file  = $this->instance->plugin_pro_classes_dir.'/'.$this->instance->plugin_root_ns_with_dashes.'/pro.php';
				}
				// Based on `plugin_root_ns_stub`.
				// Also on `namespace\sub_namespace\class` for `$this` class.
				// Here we swap out the real root namespace, in favor of the plugin's root namespace.
				// This is helpful when we need to build strings for hooks, filters, contextual slugs, and the like.
				$this->instance->plugin_stub_as_root_ns_class                  = // Extended classes (e.g. `_x`) are treated the same here.
					$this->instance->plugin_root_ns_stub.substr(preg_replace('/_x$/', '', $this->instance->ns_class), ($root_ns_length = strlen($this->instance->root_ns)));
				$this->instance->plugin_stub_as_root_ns_class_with_underscores = stub::with_underscores($this->instance->plugin_stub_as_root_ns_class);
				$this->instance->plugin_stub_as_root_ns_class_with_dashes      = stub::with_dashes($this->instance->plugin_stub_as_root_ns_class);

				// Based on `plugin_root_ns_stub`.
				// Also on `namespace\sub_namespace` for `$this` class.
				// Here we swap out the real root namespace, in favor of the plugin's root namespace.
				// This is helpful when we need to build strings for hooks, filters, contextual slugs, and the like.
				$this->instance->plugin_stub_as_root_ns                  = $this->instance->plugin_root_ns_stub.substr($this->instance->ns, $root_ns_length);
				$this->instance->plugin_stub_as_root_ns_with_underscores = stub::with_underscores($this->instance->plugin_stub_as_root_ns);
				$this->instance->plugin_stub_as_root_ns_with_dashes      = stub::with_dashes($this->instance->plugin_stub_as_root_ns);

				// Now let's cache `$this->instance` for easy re-use.
				static::$___instance_cache[ $cache_entry ] = $this->instance;

				// Check global reference & load plugin (if applicable).
				if (!isset($GLOBALS[ $this->instance->plugin_root_ns ])
				    || !($GLOBALS[ $this->instance->plugin_root_ns ] instanceof framework)
				) // Create global reference & load plugin on first instance (if applicable).
				{
					$GLOBALS[ $this->instance->plugin_root_ns ] = $this;
					if ($this->instance->plugin_root_ns !== stub::$core_ns)
						$this->©plugin->load(); // Not the core (only load plugins).
				}
			}

			# --------------------------------------------------------------------------------------------------------------------------
			# Magic methods in the XDaRk Core.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Checks magic/overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a valid magic/overload property.
			 *    Or a dynamic class to check, using the special class `©` prefix.
			 *
			 * @return boolean TRUE if the magic/overload property (or dynamic singleton class instance) is set.
			 *    Otherwise, this will return FALSE by default (i.e. the property is NOT set).
			 *
			 * @public Magic/overload methods must always remain public.
			 *
			 * @extenders If a class extender creates its own `__isset()` method, it MUST first make an attempt to resolve `$property` on its own.
			 *    If it CANNOT resolve `$property`, it MUST then return a call to this method, using: `parent::__isset($property)`.
			 *    This allows the core `__isset()` method to make a final attempt at resolving the value of `$property`.
			 *
			 * @note This method should NOT rely directly or indirectly on any other dynamic properties.
			 */
			public function __isset($property)
			{
				$property    = (string) $property;
				$blog_id     = (integer) $GLOBALS['blog_id'];
				$cache_entry = $this->instance->plugin_root_ns.'#'.$property;

				if (isset(static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ]))
					return true; // It's a dynamic class reference that's set already.

				if (property_exists($this, $property) && (in_array($property, static::$___read_only_properties, true) || in_array($property, static::$____read_only_properties, true)))
					return isset($this->$property); // Available via `__get()` magic (public read-only; it's protected or private).

				return false; // Default return value.
			}

			/**
			 * Sets magic/overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a magic/overload property.
			 *    Or a dynamic class, using the special class `©` prefix.
			 *
			 * @param mixed $value The new value for this magic/overload property.
			 *
			 * @return mixed The `$value` assigned to the magic/overload `$property`.
			 *
			 * @throws exception If attempting to set magic/overload properties (this is NOT allowed).
			 *    This magic/overload method is currently here ONLY to protect magic/overload property values.
			 *    All magic/overload properties in the XDaRk Core (and plugins that extend it); are read-only.
			 *
			 * @public Magic/overload methods must always remain public.
			 *
			 * @extenders If a class extender creates its own `__set()` method, it MUST first make an attempt to set `$property` on its own.
			 *    If it CANNOT set `$property`, it MUST then return a call to this method, using: `parent::__set($property)`.
			 *    This allows the core `__set()` method to make a final attempt at setting the value of `$property`.
			 *
			 * @note This method should NOT rely directly or indirectly on any other magic/overload properties.
			 */
			public function __set($property, $value)
			{
				$property = (string) $property;

				throw new exception( // Do NOT allow this.
					$this, $this->method(__FUNCTION__).'#read_only_magic_property_error_via____set()', get_defined_vars(),
					sprintf($this->__('Attempting to set magic/overload property: `%1$s` (which is NOT allowed).'), $property).
					' '.sprintf($this->__('This property MUST be defined explicitly by: `%1$s`.'), get_class($this))
				);
			}

			/**
			 * Unsets magic/overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a magic/overload property.
			 *    Or a dynamic class, using the special class `©` prefix.
			 *
			 * @throws exception If attempting to unset magic/overload properties (this is NOT allowed).
			 *    This magic/overload method is currently here ONLY to protect magic/overload property values.
			 *    All magic/overload properties in the XDaRk Core (and plugins that extend it); are read-only.
			 *
			 * @public Magic/overload methods must always remain public.
			 *
			 * @extenders If a class extender creates its own `__unset()` method, it MUST first make an attempt to unset `$property` on its own.
			 *    If it CANNOT unset `$property`, it MUST then return a call to this method, using: `parent::__unset($property)`.
			 *    This allows the core `__unset()` method to make a final attempt at unsetting the `$property`.
			 *
			 * @note This method should NOT rely directly or indirectly on any other magic/overload properties.
			 */
			public function __unset($property)
			{
				$property = (string) $property;

				throw new exception( // Do NOT allow this.
					$this, $this->method(__FUNCTION__).'#read_only_magic_property_error_via____unset()', get_defined_vars(),
					sprintf($this->__('Attempting to unset magic/overload property: `%1$s` (which is NOT allowed).'), $property).
					' '.sprintf($this->__('This property MUST be defined explicitly by: `%1$s`.'), get_class($this))
				);
			}

			/**
			 * Handles magic/overload properties (and dynamic singleton class instances).
			 *
			 * @param string $property Name of a valid magic/overload property.
			 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
			 *
			 *    When a class `©` prefix is present, we look for the class to exist first in the current plugin's root namespace, else in the core namespace.
			 *    Do NOT create plugin classes with the same names as those in the core, unless you really want to override or extend the core version.
			 *
			 *    Note... this routine treats double underscores like namespace separators, so double underscores will prevent dynamic usage.
			 *    This point is actually moot, since the core constructor does NOT allow double underscores anyway.
			 *
			 *    The object that's returned, is a dynamic singleton for each plugin (to clarify, one single instance of each dynamic class, for each plugin).
			 *    This OOP design pattern can be more accurately described as a {@link http://en.wikipedia.org/wiki/Multiton_pattern Multiton}.
			 *    However, this takes even the concept of a Multiton a little further. For instance, the cache routine here is MUCH smarter.
			 *    Also, here we're overloading dynamic singleton classes with `©`, and also dealing with class aliases.
			 *
			 *    Repeat calls will return an existing instance, if one exists for the current plugin; else a new instance is instantiated here.
			 *    When/if a new instance is instantiated here, we pass the current object (i.e. `$this`) to the constructor.
			 *    The resulting instance is then cached into memory, for the current plugin to re-use.
			 *
			 *    A quick example might look like: `$this->©class`. Which becomes: `new \plugin_root_ns\class()`.
			 *    If `\plugin_root_ns\class()` is missing, we'll try `new \xd_v141226_dev\class()`.
			 *
			 *    If a sub-namespace is needed, suffix the required sub-namespace(s) with double underscores `__`.
			 *    A quick example might look like: `$this->©sub_namespace__sub_namespace__class`.
			 *    Which becomes: `new \plugin_root_ns\sub_namespace\sub_namespace\class()`.
			 *    Or: `new \xd_v141226_dev\sub_namespace\sub_namespace\class()`.
			 *
			 *    If the property contains a fully qualified namespace, use a `©` suffix, instead of a prefix.
			 *    Then use double underscores `__` to separate any namespace paths in the property name.
			 *    A quick example: `$this->my_namespace__sub_namespace__class©`.
			 *    Becomes: `new \my_namespace\sub_namespace\class()`.
			 *
			 *    This method also takes dynamic class aliases into consideration.
			 *       See: `$___dynamic_class_aliases` for further details.
			 *       See also: `$____dynamic_class_aliases`.
			 *
			 * @return mixed Magic/overload property values, or a dynamic object instance; else an exception is thrown.
			 *    Dynamic class instances are defined explicitly in the docBlock above.
			 *    This way IDEs will jive with this dynamic behavior.
			 *
			 * @throws exception If `$property` CANNOT be defined in any way.
			 *
			 * @note It is intentionally NOT possible to pass additional arguments to an object constructor this way.
			 *    Any class that needs to be constructed with more than an `$instance`, cannot be instantiated here.
			 *    Instead see `__call()` to instantiate "new" dynamic object instances with `©`.
			 *
			 * @public Magic/overload methods must always remain public.
			 *
			 * @extenders If a class extender creates its own `__get()` method, it MUST first make an attempt to resolve `$property` on its own.
			 *    If it CANNOT resolve `$property`, it MUST then return a call to this method, using: `parent::__get($property)`.
			 *    This allows the core `__get()` method to make a final attempt at resolving the value of `$property`.
			 *
			 * @note This method should NOT rely directly or indirectly on any other magic/overload properties.
			 */
			public function __get($property)
			{
				$property    = (string) $property;
				$blog_id     = (integer) $GLOBALS['blog_id'];
				$cache_entry = $this->instance->plugin_root_ns.'#'.$property;

				if (isset(static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ]) /* Cached already? */)
					return static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ];

				if (($©strpos = strpos($property, '©')) !== false) // A dynamic singleton is being requested in this case.
				{
					// Note... this `$dyn_class` may or may not contain a fully qualified namespace. In some cases it will (if `©` is a suffix).
					// However, in most cases `$dyn_class` will contain only a class name itself, or perhaps a sub_namespace\class.
					$dyn_class = str_replace('__', '\\', trim($property, '©')); // Converts to a `$dyn_class` path.

					// This maps dynamic class aliases to their real (i.e. actual class) counterparts.
					// Mapped by `$property`, after it's been converted into a `$dyn_class` path, and BEFORE any prefixes occur.
					// Example: `$this->©sub_namespace__class` maps to the alias entry `sub_namespace\class`.
					// Another example: `$this->©class` maps to the alias entry `class`.

					if (!empty(static::$___dynamic_class_aliases[ $dyn_class ]))
						$dyn_class = static::$___dynamic_class_aliases[ $dyn_class ];

					else if (!empty(static::$____dynamic_class_aliases[ $dyn_class ]))
						$dyn_class = static::$____dynamic_class_aliases[ $dyn_class ];

					// Now let's establish an array of lookups.
					$dyn_class_lookups = array(); // Possible locations.

					if ($©strpos !== 0) // Assuming a fully qualified namespace has been given in this case.
						$dyn_class_lookups[] = '\\'.$dyn_class; // So we only add the `\` prefix.

					else // Otherwise try `$this->instance->plugin_root_ns`, then `$this->instance->core_ns`.
					{
						$dyn_class_lookups[] = $this->instance->plugin_root_ns_prefix.'\\'.$dyn_class;
						$dyn_class_lookups[] = $this->instance->core_ns_prefix.'\\'.$dyn_class;
					}
					// Note... `$cache` entries are created for each `$this->instance->plugin_root_ns.$property` combination.
					// However, `$dyn_class_instances` may contain entries used under several different aliases (i.e. by more than one cache entry).
					// Therefore, ALWAYS check for the existence of a class instance first, even if a cache entry for it is currently missing.
					// In other words, the instance itself may already exist; and perhaps we just need a new cache entry to reference it.

					$this_class = '\\'.get_class($this); // So we can check references to self; in the routine below.

					foreach ($dyn_class_lookups as $_dyn_class) // Iterate lookups.
					{
						$_dyn_class_entry = $this->instance->plugin_root_ns.'#'.$_dyn_class;

						if (isset(static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ]))
							return (static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ] = static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ]);

						if ($_dyn_class === $this_class) // A dynamic class object reference to this class?
						{
							static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ] = $this;

							return (static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ] = static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ]);
						}
						if (class_exists($_dyn_class)) // This triggers autoloading in the PHP interpreter.
						{
							static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ] = new $_dyn_class($this);

							return (static::$___dynamic_class_reference_cache[ $blog_id ][ $cache_entry ] = static::$___dynamic_class_instance_cache[ $blog_id ][ $_dyn_class_entry ]);
						}
					}
					unset($_dyn_class, $_dyn_class_entry); // A little housekeeping.
				}
				if (property_exists($this, $property) && (in_array($property, static::$___read_only_properties, true) || in_array($property, static::$____read_only_properties, true)))
					return (is_object($this->$property)) ? clone $this->$property : $this->$property; // Public read-only; it's protected or private.

				if ($©strpos === false && strpos($property, "\xa9") !== false) // 1-byte `©` symbol?
					throw new exception( // Detailed error; this is HARD to figure out when it happens.
						$this, $this->method(__FUNCTION__).'#undefined_magic_property_error_via__get()', get_defined_vars(),
						sprintf($this->__('Undefined property: `%1$s`. Possible issue with encoding.'), $property).
						' '.$this->__('Please make sure your `©` symbol is a valid UTF-8 sequence: `\\xc2\\xa9`.')
					);
				throw new exception($this, $this->method(__FUNCTION__).'#undefined_magic_property_error_via__get()', get_defined_vars(),
					sprintf($this->__('Undefined property: `%1$s`.'), $property));
			}

			/**
			 * Handles magic/overload methods (and dynamic class instances).
			 *
			 * @param string $method Name of a valid magic/overload method to call upon.
			 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
			 *    Or a dynamic singleton class method to call upon; also using the `©` prefix, along with a `.method_name` suffix.
			 *
			 *    When a class `©` prefix is present, we look for the class to exist first in the current plugin's root namespace, else in the core namespace.
			 *    Do NOT create plugin classes with the same names as those in the core, unless you really want to override or extend the core version.
			 *
			 *    Note... this routine treats double underscores like namespace separators, so double underscores will prevent dynamic usage.
			 *    This point is actually moot, since the core constructor does NOT allow double underscores anyway.
			 *
			 *    Repeat calls will NOT return an existing instance (exception: dynamic singleton methods). Otherwise, each call instantiates a new dynamic class instance.
			 *    This OOP design pattern can be more accurately described as a {@link http://en.wikipedia.org/wiki/Factory_method_pattern Factory}.
			 *    However, this takes even the concept of a Factory a little further. Here we're overloading dynamic factory classes with `©`,
			 *    and we're also dealing with dynamic class aliases.
			 *
			 *    A quick example might look like: `$this->©class($arg1, $arg2)`. Which becomes: `new \plugin_root_ns\class($arg1, $arg2)`.
			 *    If `\plugin_root_ns\class()` is missing, we'll try `new \xd_v141226_dev\class($arg1, $arg2)`.
			 *
			 *    If a sub-namespace is needed, suffix the required sub-namespace(s) with double underscores `__`.
			 *    A quick example might look like: `$this->©sub_namespace__sub_namespace__class($arg1, $arg2)`.
			 *    Which becomes: `new \plugin_root_ns\sub_namespace\sub_namespace\class($arg1, $arg2)`.
			 *    Or: `new \xd_v141226_dev\sub_namespace\sub_namespace\class($arg1, $arg2)`.
			 *
			 *    If the method name contains a fully qualified namespace, use a `©` suffix, instead of a prefix.
			 *    Then use double underscores `__` to separate any namespace paths in the property name.
			 *    A quick example: `$this->my_namespace__sub_namespace__class©($arg1, $arg2)`.
			 *    Becomes: `new \my_namespace\sub_namespace\class($arg1, $arg2)`.
			 *
			 *    As mentioned earlier, it is also possible to call a dynamic singleton class method; also using the `©` prefix, along with a `.method_name` suffix.
			 *    This special combination is handled a bit differently. We make a call to the `__get()` method in this case, for the dynamic singleton instance.
			 *    Then, we use the dynamic singleton instance, and issue a call to `.method_name`, with `$args` passing through as well.
			 *    A quick example: `call_user_func_array(array($this, '©class.method_name'), array($arg1, $arg2))`.
			 *
			 *    This method also takes dynamic class aliases into consideration.
			 *       See: `$___dynamic_class_aliases` for further details.
			 *       See also: `$____dynamic_class_aliases`.
			 *
			 * @param array $args An array of arguments to the magic/overload method, or dynamic class object constructor.
			 *    In the case of dynamic objects, it's fine to exclude the first argument, which is handled automatically by this routine.
			 *    That is, the first argument to any extender is always the parent instance (i.e. `$this`).
			 *
			 * @return mixed Magic/overload return values, or a dynamic object instance; else an exception is thrown.
			 *    Dynamic class instances are defined explicitly in the docBlock above.
			 *    This way IDEs will jive with this dynamic behavior.
			 *
			 * @throws exception If `$method` CANNOT be defined in any way.
			 *
			 * @public Magic/overload methods must always remain public.
			 *
			 * @extenders If a class extender creates its own `__call()` method, it MUST first make an attempt to resolve `$method` on its own.
			 *    If it CANNOT resolve `$method`, it MUST then return a call to this method, using: `parent::__call($method, $args)`.
			 *    This allows the core `__call()` method to make a final attempt at resolving the value of `$method`.
			 *
			 * @note This method should NOT rely directly or indirectly on any other magic/overload methods.
			 */
			public function __call($method, $args)
			{
				$method = (string) $method; // Force string.
				$args   = (array) $args; // Must have an array.

				if (($©strpos = strpos($method, '©')) !== false) // Looking for a dynamic class?
				{
					// If `$method` ends with a `.method_name` we handle things quite differently.
					if (strpos($method, '.') !== false) // Calling a dynamic class method?
					{
						list($dyn_class, $dyn_method) = explode('.', $method, 2);

						return call_user_func_array(array($this->__get($dyn_class), $dyn_method), $args);
					}
					// Note... this `$dyn_class` may or may not contain a fully qualified namespace. In some cases it will (if `©` is a suffix).
					// However, in most cases `$dyn_class` will contain only a class name itself, or perhaps a sub_namespace\class.
					$dyn_class = str_replace('__', '\\', trim($method, '©')); // Converts to a `$dyn_class` path.

					// This maps dynamic class aliases to their real (i.e. actual class) counterparts.
					// Mapped by `$method`, after it's been converted into a `$dyn_class` path, and BEFORE any prefixes occur.
					// Example: `$this->©sub_namespace__class()` maps to the alias entry `sub_namespace\class`.
					// Another example: `$this->©class()` maps to the alias entry `class`.

					if (!empty(static::$___dynamic_class_aliases[ $dyn_class ]))
						$dyn_class = static::$___dynamic_class_aliases[ $dyn_class ];

					else if (!empty(static::$____dynamic_class_aliases[ $dyn_class ]))
						$dyn_class = static::$____dynamic_class_aliases[ $dyn_class ];

					// Now let's establish an array of lookups.
					$dyn_class_lookups = array(); // Possible locations.

					if ($©strpos !== 0) // Assuming a fully qualified namespace has been given in this case.
						$dyn_class_lookups[] = '\\'.$dyn_class; // So we only add the `\` prefix.

					else // Otherwise try `$this->instance->plugin_root_ns`, then `$this->instance->core_ns`.
					{
						$dyn_class_lookups[] = $this->instance->plugin_root_ns_prefix.'\\'.$dyn_class;
						$dyn_class_lookups[] = $this->instance->core_ns_prefix.'\\'.$dyn_class;
					}
					// Regarding a standard in the XDaRk Core.
					// When/if a class extender creates its own `__construct()` method,
					// it MUST collect an `$instance`, and it MUST call: `parent::__construct($instance)`.

					foreach ($dyn_class_lookups as $_dyn_class) // Now let's try to find the class.
					{
						if (!class_exists($_dyn_class)) // Triggers autoloader.
							continue; // This class does NOT exist (we'll keep searching).

						switch (count($args)) // Handles up to 10 hard coded `$args`.
						{
							// This tries to avoid the ReflectionClass, because it's MUCH slower.
							// If there's more than 10 arguments to a constructor, we'll have to use it though, unfortunately.
							// However, it's NOT likely. More than 10 arguments to a constructor is NOT a common practice.
							case 0:
								return new $_dyn_class($this);
							case 1:
								return new $_dyn_class($this, $args[0]);
							case 2:
								return new $_dyn_class($this, $args[0], $args[1]);
							case 3:
								return new $_dyn_class($this, $args[0], $args[1], $args[2]);
							case 4:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3]);
							case 5:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4]);
							case 6:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
							case 7:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
							case 8:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
							case 9:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
							case 10:
								return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
							default:
								$args                 = array_merge(array($this), $args);
								$_dyn_class_reflector = new \ReflectionClass($_dyn_class);

								return $_dyn_class_reflector->newInstanceArgs($args);
						}
					}
					unset($_dyn_class, $_dyn_class_reflector);
				}
				if ($©strpos === false && strpos($method, "\xa9") !== false) // 1 byte `©` symbol?
					throw new exception( // Detailed error; this is HARD to figure out when it happens.
						$this, $this->method(__FUNCTION__).'#undefined_magic_method_error_via__call()', get_defined_vars(),
						sprintf($this->__('Undefined method: `%1$s`. Possible issue with encoding.'), $method).
						' '.$this->__('Please make sure your `©` symbol is a valid UTF-8 sequence: `\\xc2\\xa9`.')
					);
				throw new exception($this, $this->method(__FUNCTION__).'#undefined_magic_method_error_via__call()', get_defined_vars(),
					sprintf($this->__('Undefined method: `%1$s`.'), $method));
			}

			# --------------------------------------------------------------------------------------------------------------------------
			# Methods related to type checks in the XDaRk Core.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Checks function/method arguments against a list of type hints.
			 *
			 * @note Very important for this method to remain HIGHLY optimized at all times.
			 *    This method is called MANY times throughout the entire XDaRk Core framework.
			 *
			 * @note This is about 6.5 times slower than `is_...()` checks alone (tested in PHP v5.3.13).
			 *    We've ALREADY put quite a bit of work into optimizing this as-is, so we might need an entirely new approach in the future.
			 *    Benchmarking this against straight `is..()` checks alone, is not really fair either; since this routine "enforces" type hints.
			 *    In the mean time, the benefits of using this method, far outweigh the cost in performance — in most cases.
			 *    ~ Hopefully we'll have better support for type hinting upon the release of PHP 6.0.
			 *
			 * @note Try NOT to `check_arg_types()` recursively (i.e. in recursive functions). It's really a waste of resources.
			 *    If a function is going to be called recursively, please design your function (while in recursion), to bypass `check_arg_types()`.
			 *
			 * @params-variable-length This method accepts any number of parameters (i.e. type hints, as seen below).
			 *
			 *    Arguments to this method should first include a variable-length list of type hints.
			 *
			 *    Format as follows: `check_arg_types('[type]', '[type]' ..., func_get_args())`.
			 *    Where type hint arguments MUST be ordered exactly the same as each argument requested by the function/method we're checking.
			 *    However, it's fine to exclude certain arguments from the end (i.e. any we don't need to check), or via exclusion w/ an empty string.
			 *
			 *    Where `[type]` can be any string (or array combination) of: `:!empty|int|integer|real|double|float|string|bool|boolean|array|object|resource|scalar|numeric|null|[instanceof]`.
			 *    Where `[instanceof]` can be used in cases where we need to check for a specific type of object instance. Anything not matching a standardized type, is assumed to be an `[instanceof]` check.
			 *    For performance reasons, `[type]` is caSe sensitive. Therefore, `INTeger` will NOT match `integer` (that would be invalid; resulting in a check requiring an instance of `INTeger`).
			 *
			 *    Negating certain types.
			 *    Example: `check_arg_types('!object', func_get_args())`.
			 *    Allows anything, except an object type.
			 *
			 *    Require values that are NOT `empty()`.
			 *    Example: `check_arg_types('string:!empty', func_get_args())`.
			 *    Requires a string that is NOT considered `empty()` by the PHP interpreter.
			 *
			 *    Require anything that is NOT `empty()`.
			 *    Example: `check_arg_types(':!empty', func_get_args())`.
			 *    Anything that is NOT considered `empty()` by the PHP interpreter.
			 *
			 *    Using an array of multiple type hints.
			 *    Example: `check_arg_types(array('string', 'object'), func_get_args())`.
			 *    Example: `check_arg_types(array('string:!empty', 'object'), func_get_args())`.
			 *    Allows either a string `OR` an object to be passed in as the first argument value.
			 *    In the second example, we allow a string (NOT empty) `OR` an object instance.
			 *
			 *    Array w/ an empty type hint value (NOT recommended).
			 *    Example: `check_arg_types(array('string', ''), func_get_args())`.
			 *    Allows a string, or anything else (so actually, anything is allowed here).
			 *    It would be VERY odd to do this. Just documenting this behavior for the sake of clarity.
			 *
			 *    Using an `[instanceof]` check.
			 *    Example: `check_arg_types('\\xd_v141226_dev\\users', func_get_args())`.
			 *    Example: `check_arg_types(array('WP_User', '\\xd_v141226_dev\\users'), func_get_args())`.
			 *    For practicality & performance reasons, we do NOT check `!` or `:!empty` in the case of `[instanceof]`.
			 *    It's VERY rare that one would need to require something that's NOT a specific object instance.
			 *    And, objects are NEVER empty anyway, according to PHPs `empty()` function.
			 *
			 * @note Ordinarily, the last argument to this method is a numerically indexed array of all arguments that were passed into the function/method we're checking.
			 *    Use `func_get_args()` as the last argument to this method. Example: `check_arg_types('[type]', '[type]' ..., func_get_args())`.
			 *
			 * @note For performance reasons, array keys in the last argument, MUST be indexed numerically.
			 *    Please make sure that `func_get_args()` is used as the last argument. Or, any array that uses numeric indexes, is also fine.
			 *    Associative arrays will cause PHP notices, due to undefined indexes. We're expecting a numerically indexed array of arguments here.
			 *
			 * @note If the last argument to this method is an integer, instead of an array; we treat the last argument as the number of required arguments.
			 *    Example: `check_arg_types('[type]', '[type]' ..., func_get_args(), 2)`. This requires a minimum of two argument values.
			 *    This is NOT needed in most cases. PHP should have already triggered a warning about missing arguments.
			 *
			 * @return boolean TRUE if all argument values can be validated against the list of type hints; else an exception is thrown.
			 *
			 * @throws exception If the last parameter is an integer indicating a number of required arguments,
			 *    and the number of arguments passed in, is less than this number.
			 * @throws exception If even ONE argument is passed incorrectly.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function check_arg_types()
			{
				$_arg_type_hints__args__required_args = func_get_args();
				$_last_arg_value                      = array_pop($_arg_type_hints__args__required_args);
				$required_args                        = 0; // Default number of required arguments.

				if (is_integer($_last_arg_value)) // Required arguments?
				{
					$required_args = $_last_arg_value; // Number of required arguments.
					$args          = (array) array_pop($_arg_type_hints__args__required_args);
				} else $args = (array) $_last_arg_value; // Use `$_last_arg_value` as `$args`.

				$arg_type_hints      = $_arg_type_hints__args__required_args; // Type hints (remaining arguments).
				$total_args          = count($args); // Total arguments passed into the function/method we're checking.
				$total_arg_positions = $total_args - 1; // Based on total number of arguments.

				// Commenting for performance. NOT absolutely necessary.
				# unset($_arg_type_hints__args__required_args, $_last_arg_value); // Housekeeping.

				if ($total_args < $required_args) // Enforcing minimum args?
					throw $this->©exception( // Need to be VERY descriptive here.
						$this->method(__FUNCTION__).'#args_missing', get_defined_vars(),
						sprintf($this->__('Missing required argument(s); `%1$s` requires `%2$s`, `%3$s` given.'),
							$this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $required_args, $total_args).
						' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($args)));

				if ($total_args === 0)
					return true; // Stop here (no arguments to check).

				foreach ($arg_type_hints as $_arg_position => $_arg_type_hints) // Type hints.
				{
					if ($_arg_position > $total_arg_positions) // Argument not even passed in?
						continue; // Argument was not even passed in (we don't need to check this value).

					unset($_last_arg_type_key); // Unset before iterating (define below if necessary).

					foreach (($_arg_types = (array) $_arg_type_hints) as $_arg_type_key => $_arg_type) {
						switch (($_arg_type = (string) $_arg_type)) // Checks type requirements.
						{
							case '': // Anything goes (there are NO requirements).
								break 2; // We have a valid type/value here.

							/****************************************************************************/

							case ':!empty': // Anything goes. But check if it's empty.
								if (empty($args[ $_arg_position ])) // Is empty?
								{
									if (!isset($_last_arg_type_key))
										$_last_arg_type_key = count($_arg_types) - 1;

									if ($_arg_type_key === $_last_arg_type_key) // Exhausted list of possible types.
									{
										$problem = array(
											'types'    => $_arg_types,
											'position' => $_arg_position,
											'value'    => $args[ $_arg_position ],
											'empty'    => empty($args[ $_arg_position ])
										);
										break 3; // We DO have a problem here.
									}
								} else break 2; // We have a valid type/value here.

								break 1; // Default break 1; and continue type checking.

							/****************************************************************************/

							case 'string': // All of these fall under `!is_...()` checks.
							case 'boolean':
							case 'bool':
							case 'integer':
							case 'int':
							case 'float':
							case 'real':
							case 'double':
							case 'numeric':
							case 'scalar':
							case 'array':
							case 'object':
							case 'resource':
							case 'null':

								$is_ = static::$___is_type_checks[ $_arg_type ];

								if (!$is_($args[ $_arg_position ])) // Not this type?
								{
									if (!isset($_last_arg_type_key))
										$_last_arg_type_key = count($_arg_types) - 1;

									if ($_arg_type_key === $_last_arg_type_key) // Exhausted list of possible types.
									{
										$problem = array(
											'types'    => $_arg_types,
											'position' => $_arg_position,
											'value'    => $args[ $_arg_position ],
											'empty'    => empty($args[ $_arg_position ])
										);
										break 3; // We DO have a problem here.
									}
								} else break 2; // We have a valid type/value here.

								break 1; // Default break 1; and continue type checking.

							/****************************************************************************/

							case '!string': // All of these fall under `is_...()` checks.
							case '!boolean':
							case '!bool':
							case '!integer':
							case '!int':
							case '!float':
							case '!real':
							case '!double':
							case '!numeric':
							case '!scalar':
							case '!array':
							case '!object':
							case '!resource':
							case '!null':

								$is_ = static::$___is_type_checks[ $_arg_type ];

								if ($is_($args[ $_arg_position ])) // Is this type?
								{
									if (!isset($_last_arg_type_key))
										$_last_arg_type_key = count($_arg_types) - 1;

									if ($_arg_type_key === $_last_arg_type_key) // Exhausted list of possible types.
									{
										$problem = array(
											'types'    => $_arg_types,
											'position' => $_arg_position,
											'value'    => $args[ $_arg_position ],
											'empty'    => empty($args[ $_arg_position ])
										);
										break 3; // We DO have a problem here.
									}
								} else break 2; // We have a valid type/value here.

								break 1; // Default break 1; and continue type checking.

							/****************************************************************************/

							case 'string:!empty': // These are `!is_...()` || `empty()` checks.
							case 'boolean:!empty':
							case 'bool:!empty':
							case 'integer:!empty':
							case 'int:!empty':
							case 'float:!empty':
							case 'real:!empty':
							case 'double:!empty':
							case 'numeric:!empty':
							case 'scalar:!empty':
							case 'array:!empty':
							case 'object:!empty':
							case 'resource:!empty':
							case 'null:!empty':

								$is_ = static::$___is_type_checks[ $_arg_type ];

								if (!$is_($args[ $_arg_position ]) || empty($args[ $_arg_position ])) // Now, have we exhausted the list of possible types?
								{
									if (!isset($_last_arg_type_key))
										$_last_arg_type_key = count($_arg_types) - 1;

									if ($_arg_type_key === $_last_arg_type_key) // Exhausted list of possible types.
									{
										$problem = array(
											'types'    => $_arg_types,
											'position' => $_arg_position,
											'value'    => $args[ $_arg_position ],
											'empty'    => empty($args[ $_arg_position ])
										);
										break 3; // We DO have a problem here.
									}
								} else break 2; // We have a valid type/value here.

								break 1; // Default break 1; and continue type checking.

							/****************************************************************************/

							default: // Assume object `instanceof` in this default case handler.
								// For practicality & performance reasons, we do NOT check `!` or `:!empty` here.
								// It's VERY rare that one would need to require something that's NOT a specific object instance.
								// Objects are NEVER empty anyway, according to PHPs `empty()` function.

								if (!($args[ $_arg_position ] instanceof $_arg_type)) {
									if (!isset($_last_arg_type_key))
										$_last_arg_type_key = count($_arg_types) - 1;

									if ($_arg_type_key === $_last_arg_type_key) // Exhausted list of possible types.
									{
										$problem = array(
											'types'    => $_arg_types,
											'position' => $_arg_position,
											'value'    => $args[ $_arg_position ],
											'empty'    => empty($args[ $_arg_position ])
										);
										break 3; // We DO have a problem here.
									}
								} else break 2; // We have a valid type for this arg.

								break 1; // Default break 1; and continue type checking.
						}
					}
				}
				// Commenting for performance. NOT absolutely necessary.
				# unset($_arg_position, $_arg_type_hints, $_arg_types, $_arg_type_key, $_last_arg_type_key, $_arg_type, $is_);

				if (!empty($problem)) // We have a problem!
				{
					$position   = $problem['position'] + 1;
					$types      = implode('|', $problem['types']);
					$empty      = ($problem['empty']) ? $this->__('empty').' ' : '';
					$type_given = (is_object($problem['value'])) ? get_class($problem['value']) : gettype($problem['value']);

					throw $this->©exception( // Need to be VERY descriptive here.
						$this->method(__FUNCTION__).'#invalid_args', get_defined_vars(),
						sprintf($this->__('Argument #%1$s passed to `%2$s` requires `%3$s`, %4$s`%5$s` given.'),
							$position, $this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $types, $empty, $type_given).
						' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($args)));
				}

				return true; // Default return value (no problem).
			}

			/**
			 * Checks intersecting arguments against a list of type hints (and extends defaults).
			 *
			 * @note Very important for this method to remain HIGHLY optimized at all times.
			 *    This method is called MANY times throughout the entire XDaRk Core framework.
			 *
			 * @params-variable-length This method accepts any number of parameters (i.e. type hints, as seen below).
			 *
			 *    Arguments to this method should first include a variable-length list of type hints.
			 *
			 *    Format as follows: `check_extension_arg_types('[type]', '[type]' ..., $default_args, $args)`.
			 *    Where type hint arguments MUST be ordered exactly the same as each argument in the array of `$default_args`.
			 *    However, it's fine to exclude certain arguments from the end (i.e. any we don't need to check), or via exclusion w/ an empty string.
			 *    This method uses `check_arg_types()`. Please see `check_arg_types()` to learn more about type hints in the XDaRk Core.
			 *
			 * @note Ordinarily, the last argument to this method is an associative array of all arguments that were passed in through a single function/method parameter.
			 *    For example: `check_extension_arg_types('[type]', '[type]' ..., $default_args, array('hello' => 'hello', 'world' => 'world')`.
			 *
			 * @note If the last argument to this method is an integer, instead of an array; we treat the last argument as the number of required arguments.
			 *    Example: `check_extension_arg_types('[type]', '[type]' ..., $default_args, $args, 2)`. This requires a minimum of two argument values.
			 *    Required argument keys, are those which appear first in the array of `$default_args` (e.g. always based on default argument key positions).
			 *
			 * @return array Returns an array of extended `$default_args`, if all argument values can be validated against the list of type hints.
			 *    Note: the `$default_args` are extended with `array_merge()`. Otherwise, an exception is thrown when there are problems.
			 *
			 * @throws exception If the last parameter is an integer indicating a number of required arguments,
			 *    and the number of arguments passed in, is less than this number.
			 * @throws exception If even ONE argument is passed incorrectly.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function check_extension_arg_types()
			{
				$_arg_type_hints__default_args__args__required_args = func_get_args();
				$_last_arg_value                                    = array_pop($_arg_type_hints__default_args__args__required_args);
				$required_args                                      = 0; // Default number of required arguments.

				if (is_integer($_last_arg_value)) // Do we have required arguments in last position?
				{
					$required_args = $_last_arg_value; // Number of required arguments.
					$args          = (array) array_pop($_arg_type_hints__default_args__args__required_args);
				} else $args = (array) $_last_arg_value; // Use `$_last_arg_value` as `$args`.

				$default_args   = (array) array_pop($_arg_type_hints__default_args__args__required_args);
				$arg_type_hints = $_arg_type_hints__default_args__args__required_args; // Type hints (remaining args).

				// Commenting for performance. NOT absolutely necessary.
				# unset($_arg_type_hints__default_args__args__required_args, $_last_arg_value);

				$default_arg_key_positions = // Initialize these important arrays (build them below).
				$extension_args = $intersecting_args = $intersecting_arg_type_hints = array();

				// Builds a legend of default argument key positions; and checks for missing argument keys.

				foreach (array_keys($default_args) as $_default_arg_key_position => $_default_arg_key) {
					$default_arg_key_positions[ $_default_arg_key ] = // Numeric indexes.
						$_default_arg_key_position; // This builds a legend for routines below.

					if ($_default_arg_key_position < $required_args && !array_key_exists($_default_arg_key, $args))
						throw $this->©exception( // Missing required arg! We're VERY descriptive here.
							$this->method(__FUNCTION__).'#args_missing', get_defined_vars(),
							sprintf($this->__('`%1$s` requires missing argument key `%2$s`.'),
								$this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $_default_arg_key).
							' '.sprintf($this->__('Got: `%1$s`.'), $this->©var->dump($args)));
				}
				// Commenting for performance. NOT absolutely necessary.
				# unset($_default_arg_key_position, $_default_arg_key); // Housekeeping.

				// Build `$extension_args`, `$intersecting_args` and `$intersecting_arg_type_hints`.

				foreach (array_intersect_key($default_args, $args) as $_default_arg_key => $_default_arg) {
					$extension_args[ $_default_arg_key ] =& $args[ $_default_arg_key ];
					$intersecting_args[]                 =& $args[ $_default_arg_key ];

					if (isset($arg_type_hints[ $default_arg_key_positions[ $_default_arg_key ] ]))
						$intersecting_arg_type_hints[] =& $arg_type_hints[ $default_arg_key_positions[ $_default_arg_key ] ];
				}
				// Commenting for performance. NOT absolutely necessary.
				# unset($_default_arg_key, $_default_arg); // Housekeeping.

				// Put everything into a single array & `check_arg_types()`.

				$arg_type_hints__args   = $intersecting_arg_type_hints;
				$arg_type_hints__args[] =& $intersecting_args;

				call_user_func_array(array($this, 'check_arg_types'), $arg_type_hints__args);

				return array_merge($default_args, $extension_args);
			}

			# --------------------------------------------------------------------------------------------------------------------------
			# Methods related to property values.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Sets properties on `$this` object instance.
			 *
			 * @param array|object $properties An associative array|object w/ object instance properties.
			 *    Each property MUST already exist, and value types MUST match up.
			 *
			 * @param boolean $typecast Optional. Defaults to a `FALSE` value.
			 *    If `TRUE`, all values will be typecasted whenever possible.
			 *    If `TRUE`, exceptions regarding invalid data types are bypassed since
			 *       we are forcing the type via {@link \settype()} in this scenario.
			 *
			 * @throws exception If attempting to set a special property (e.g. `___*`).
			 * @throws exception If attempting to set an undefined property (i.e. non-existent).
			 * @throws exception If attempting to set a property value, which has a different value type.
			 *    Properties with an existing NULL value, are an exception to this rule.
			 *    If an existing property `is_null()`, we allow ANY new value type.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function set_properties($properties = array(), $typecast = false)
			{
				$properties = (array) $properties;

				foreach ($properties as $_property => $_value) {
					if (strpos($_property, '___') === 0 || $_property === 'instance')
						throw $this->©exception( // Do NOT allow special properties here.
							$this->method(__FUNCTION__).'#special_property', get_defined_vars(),
							sprintf($this->__('Attempting to set special property: `%1$s`.'), $_property)
						);
					if (!property_exists($this, $_property))
						throw $this->©exception( // NOT already defined.
							$this->method(__FUNCTION__).'#nonexistent_property', get_defined_vars(),
							sprintf($this->__('Attempting to set nonexistent property: `%1$s`.'), $_property)
						);
					$_value_type    = gettype($_value);
					$_property_type = gettype($this->$_property);

					if (!$typecast && $_property_type !== 'NULL' && $_value_type !== $_property_type)
						throw $this->©exception( // Invalid property type.
							$this->method(__FUNCTION__).'#invalid_property_type', get_defined_vars(),
							sprintf($this->__('Property type mismatch for property name: `%1$s`.'), $_property).
							' '.sprintf($this->__('Should be `%1$s`, `%2$s` given.'), $_property_type, $_value_type)
						);
					$this->$_property = $typecast && $_property_type !== 'NULL' ? settype($_value, $_property_type) : $_value;
				}
				unset($_property, $_value, $_property_type, $_value_type); // A little housekeeping.
			}

			/**
			 * Gets `__METHOD__` for current class.
			 *
			 * @param string $function Pass `__FUNCTION__` from any class member.
			 *    Current class is prepended to this (very much like `__METHOD__`).
			 *
			 * @return string `__METHOD__` for current class; i.e. `get_class($this)`.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function method($function)
			{
				$function = (string) $function; // Force string.

				return $this->instance->ns_class.'::'.$function;
			}

			/**
			 * Gets dynamic `©class.®method` call for current class.
			 *
			 * @param string $function Pass `__FUNCTION__` from any class member.
			 *    Current sub-namespace class is prepended; and we prefix a `©` symbol also.
			 *    Please be sure `__FUNCTION__` begins w/ `®` if it's a registered call action handler.
			 *
			 * @return string Dynamic `©class.®method` call for current class; i.e. `get_class($this)`.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function dynamic_call($function)
			{
				$function = (string) $function; // Force string.

				return '©'.$this->instance->sub_ns_class_with_underscores.'.'.$function;
			}

			# --------------------------------------------------------------------------------------------------------------------------
			# Methods related to hooks/filters.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Adds a new plugin-related action handler.
			 *
			 * @param string $hook An action hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Action hook priority (optional); defaults to `10`.
			 *
			 * @param integer $args Number of arguments to handler (optional); defaults to `1`.
			 *
			 * @return boolean Always returns a boolean TRUE value.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___add_hook()
			 */
			final public function add_action($hook, $call, $priority = 10, $args = 1)
			{
				return $this->___add_hook($hook, $call, $priority, $args, $this::action_type);
			}

			/**
			 * Removes an existing plugin-related action handler.
			 *
			 * @param string $hook An action hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Action hook priority (optional); defaults to `10`.
			 *    Note that `$priority` MUST match the original action priority.
			 *
			 * @return boolean TRUE if action removal was a success.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___remove_hook()
			 */
			final public function remove_action($hook, $call, $priority = 10)
			{
				return $this->___remove_hook($hook, $call, $priority, $this::action_type);
			}

			/**
			 * Removes all existing plugin-related action handlers.
			 *
			 * @param string $hook An action hook (optional).
			 *    If empty remove all actions; w/ any hook name.
			 *
			 * @param integer|null $priority Action hook priority (optional).
			 *    If NULL remove all actions, no matter the priority.
			 *
			 * @return integer Total number of action removals.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___remove_all_hooks()
			 */
			final public function remove_all_actions($hook = '', $priority = null)
			{
				return $this->___remove_all_hooks($hook, $priority, $this::action_type);
			}

			/**
			 * Adds a new plugin-related filter handler.
			 *
			 * @param string $hook A filter hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Filter hook priority (optional); defaults to `10`.
			 *
			 * @param integer $args Number of arguments to handler (optional); defaults to `1`.
			 *
			 * @return boolean Always returns a boolean TRUE value.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___add_hook()
			 */
			final public function add_filter($hook, $call, $priority = 10, $args = 1)
			{
				return $this->___add_hook($hook, $call, $priority, $args, $this::filter_type);
			}

			/**
			 * Removes an existing plugin-related filter handler.
			 *
			 * @param string $hook A filter hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Filter hook priority (optional); defaults to `10`.
			 *    Note that `$priority` MUST match the original filter priority.
			 *
			 * @return boolean TRUE if filter removal was a success.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___remove_hook()
			 */
			final public function remove_filter($hook, $call, $priority = 10)
			{
				return $this->___remove_hook($hook, $call, $priority, $this::filter_type);
			}

			/**
			 * Removes all existing plugin-related filter handlers.
			 *
			 * @param string $hook A filter hook (optional).
			 *    If empty remove all filters; w/ any hook name.
			 *
			 * @param integer|null $priority Action hook priority (optional).
			 *    If NULL remove all filters, no matter the priority.
			 *
			 * @return integer Total number of filter removals.
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @uses ___remove_all_hooks()
			 */
			final public function remove_all_filters($hook = '', $priority = null)
			{
				return $this->___remove_all_hooks($hook, $priority, $this::filter_type);
			}

			/**
			 * Adds a new plugin-related hook handler.
			 *
			 * @param string $hook An action/filter hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Action/filter hook priority.
			 *
			 * @param integer $args Number of arguments to handler.
			 *
			 * @param string $type {@link action_type} or {@link filter_type}.
			 *
			 * @return boolean Always returns a boolean TRUE value.
			 *
			 * @final May NOT be overridden by extenders.
			 * @private Accessible only to self.
			 *
			 * @see add_action()
			 * @see add_filter()
			 */
			final private function ___add_hook($hook, $call, $priority, $args, $type)
			{
				$hook     = (string) $hook;
				$call     = (string) $call;
				$priority = (integer) $priority;
				$args     = (integer) $args;
				$type     = (string) $type;

				$plugin                = $GLOBALS[ $this->instance->plugin_root_ns ];
				$idx                   = spl_object_hash($plugin).$call.$priority;
				$plugin->hooks[ $idx ] = compact('hook', 'call', 'priority', 'type');

				if ($type === $this::filter_type)
					return add_filter($hook, array($plugin, $call), $priority, $args);

				return add_action($hook, array($plugin, $call), $priority, $args);
			}

			/**
			 * Removes an existing plugin-related hook handler.
			 *
			 * @param string $hook An action/filter hook.
			 *
			 * @param string $call A dynamic `©class.method` call handler.
			 *
			 * @param integer $priority Action/filter hook priority.
			 *    Note that `$priority` MUST match the original priority.
			 *
			 * @param string $type {@link action_type} or {@link filter_type}.
			 *
			 * @return boolean TRUE if hook removal was a success.
			 *
			 * @final May NOT be overridden by extenders.
			 * @private Accessible only to self.
			 *
			 * @see remove_action()
			 * @see remove_filter()
			 */
			final private function ___remove_hook($hook, $call, $priority, $type)
			{
				$hook     = (string) $hook;
				$call     = (string) $call;
				$priority = (integer) $priority;
				$type     = (string) $type;

				$plugin = $GLOBALS[ $this->instance->plugin_root_ns ];
				unset($plugin->hooks[ spl_object_hash($plugin).$call.$priority ]);

				if ($type === $this::filter_type)
					return remove_filter($hook, array($plugin, $call), $priority);

				return remove_action($hook, array($plugin, $call), $priority);
			}

			/**
			 * Removes all existing plugin-related hook handlers.
			 *
			 * @param string $hook An action/filter hook.
			 *    If empty remove all action/filter hooks, w/ any name.
			 *
			 * @param integer|null $priority Action/filter hook priority.
			 *    If NULL remove all action/filter hooks, no matter the priority.
			 *
			 * @param string $type {@link action_type} or {@link filter_type}.
			 *
			 * @return integer Total number of hook removals.
			 *
			 * @final May NOT be overridden by extenders.
			 * @private Accessible only to self.
			 *
			 * @uses ___remove_hook()
			 */
			final private function ___remove_all_hooks($hook, $priority, $type)
			{
				$hook = (string) $hook; // Force arg types.
				if (!is_integer($priority))
					$priority = null;

				$removals = 0; // Initialize.

				foreach ($GLOBALS[ $this->instance->plugin_root_ns ]->hooks as $_idx => $_hook) {
					if ((!$hook || $_hook['hook'] === $hook) && (!isset($priority) || $_hook['priority'] === $priority) && $_hook['type'] === $type)
						if ($this->___remove_hook($_hook['hook'], $_hook['call'], $_hook['priority'], $_hook['type']))
							$removals++;
				} // Increment removal counter.
				unset($_idx, $_hook); // Housekeeping.

				return $removals;
			}

			/**
			 * Fires WordPress® Action Hooks for `$this` class.
			 *
			 * Automatically prefixes hook/filter names with the calling `namespace_stub__sub_namespace__class__`.
			 * This allows for hooks/filters to be written with short names inside class methods, while still being
			 * given a consistently unique `namespace_stub__sub_namespace__class__` prefix.
			 *
			 * The `namespace_stub__sub_namespace__class__` slug will always start with the plugin's root namespace stub,
			 * so that every hook/filter implemented by a plugin contains the same prefix,
			 * regardless of which namespace `$this` class is actually in.
			 *
			 * For example, if a hook/filter is fired by `$this` class `xd_v141226_dev\framework`,
			 * the hook/filter slug is prefixed by: `$this->instance->plugin_stub_as_root_ns_class_with_underscores`.
			 * Which will result in this hook/filter name: `plugin_root_ns_stub__framework__hook_filter_name`.
			 *
			 * In the case of a sub-namespace, it works the same way.
			 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
			 * If a hook/filter is fired by `$this` class `xd_v141226_dev\sub_namespace\class`,
			 * the hook/filter slug is prefixed again by: `$this->instance->plugin_stub_as_root_ns_class_with_underscores`.
			 * Which will result in this hook/filter name: `plugin_root_ns_stub__sub_namespace__class__hook_filter_name`.
			 *
			 * @param string $hook Action hook name.
			 * @params-variable-length Additional arguments pass data to an action handler.
			 *
			 * @return null|mixed Result from call to `do_action()` (should be NULL).
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function do_action($hook)
			{
				$args    = func_get_args();
				$args[0] = (string) $args[0]; // Force string.
				$args[0] = $this->instance->plugin_stub_as_root_ns_class_with_underscores.'__'.$args[0];

				return call_user_func_array('do_action', $args);
			}

			/**
			 * Fires WordPress® Filters for `$this` class.
			 *
			 * Automatically prefixes hook/filter names with the calling `namespace_stub__sub_namespace__class__`.
			 * This allows for hooks/filters to be written with short names inside class methods, while still being
			 * given a consistently unique `namespace_stub__sub_namespace__class__` prefix.
			 *
			 * The `namespace_stub__sub_namespace__class__` slug will always start with the plugin's root namespace stub,
			 * so that every hook/filter implemented by a plugin contains the same prefix,
			 * regardless of which namespace `$this` class is actually in.
			 *
			 * For example, if a hook/filter is fired by `$this` class `xd_v141226_dev\framework`,
			 * the hook/filter slug is prefixed by: `$this->instance->plugin_stub_as_root_ns_class_with_underscores`.
			 * Which will result in this hook/filter name: `plugin_root_ns_stub__framework__hook_filter_name`.
			 *
			 * In the case of a sub-namespace, it works the same way.
			 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
			 * If a hook/filter is fired by `$this` class `xd_v141226_dev\sub_namespace\class`,
			 * the hook/filter slug is prefixed again by: `$this->instance->plugin_stub_as_root_ns_class_with_underscores`.
			 * Which will result in this hook/filter name: `plugin_root_ns_stub__sub_namespace__class__hook_filter_name`.
			 *
			 * @param string $hook Filter hook name.
			 * @param mixed $value Value to Filter.
			 * @params-variable-length Additional arguments pass data to a filter handler.
			 *
			 * @return mixed Result from call to `apply_filters()` (e.g. filtered value).
			 *
			 * @final May NOT be overridden by extenders.
			 * @public Available for public usage.
			 */
			final public function apply_filters($hook, $value)
			{
				$args    = func_get_args();
				$args[0] = (string) $args[0]; // Force string.
				$args[0] = $this->instance->plugin_stub_as_root_ns_class_with_underscores.'__'.$args[0];

				return call_user_func_array('apply_filters', $args);
			}

			# --------------------------------------------------------------------------------------------------------------------------
			# Methods related to translations.
			# --------------------------------------------------------------------------------------------------------------------------

			/**
			 * Contextual translation wrapper (context: `admin-side`).
			 *
			 * Automatically prefixes contextual slugs with the calling `namespace-stub--sub-namespace--`.
			 * This allows for translations to be performed with a simple call to `$this->__()`, while still being
			 * given a consistently unique `namespace-stub--sub-namespace--` prefix.
			 *
			 * The `namespace-stub--sub-namespace--` slug will always start with the plugin's root namespace-stub,
			 * so that every translation call implemented by a plugin contains the same prefix,
			 * regardless of which namespace `$this` class is actually in.
			 *
			 * For example, if a translation call is fired by `$this` class `xd_v141226_dev\framework`,
			 * the contextual slug prefix is: `$this->instance->plugin_stub_as_root_ns_with_dashes`.
			 * Which would result in this contextual slug: `plugin-root-ns-stub--(front|admin)-side`.
			 *
			 * In the case of a sub-namespace, it works the same way.
			 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
			 * So if a translation call is fired by `$this` class `xd_v141226_dev\sub_namespace\class`,
			 * the contextual slug prefix is again: `$this->instance->plugin_stub_as_root_ns_with_dashes`.
			 * Which would result in this contextual slug: `plugin-root-ns-stub--sub-namespace--(front|admin)-side`.
			 *
			 * @param string $string String to translate.
			 *
			 * @return string Translated string.
			 *
			 * @final This method may NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @see _n()
			 * @see _x()
			 * @see _nx()
			 */
			final public function __($string)
			{
				$string  = (string) $string; // Context is always ...`--admin-side`.
				$context = $this->instance->plugin_stub_as_root_ns_with_dashes.'--admin-side';

				return _x($string, $context, $this->instance->plugin_root_ns_stub_with_dashes);
			}

			/**
			 * Plural/contextual translation wrapper (context: `admin-side`).
			 *
			 * @param string $string_singular String to translate (in singular format).
			 * @param string $string_plural String to translate (in plural format).
			 * @param string|integer $numeric_value Value to translate (always a numeric value).
			 *
			 * @return string Translated string.
			 *
			 * @final This method may NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @see __()
			 * @see _x()
			 * @see _nx()
			 */
			final public function _n($string_singular, $string_plural, $numeric_value)
			{
				$string_singular = (string) $string_singular;
				$string_plural   = (string) $string_plural;
				$numeric_value   = (string) $numeric_value;
				$context         = $this->instance->plugin_stub_as_root_ns_with_dashes.'--admin-side';

				return _nx($string_singular, $string_plural, $numeric_value, $context, $this->instance->plugin_root_ns_stub_with_dashes);
			}

			/**
			 * Contextual translation wrapper (context: `front-side`).
			 *
			 * @param string $string String to translate.
			 *
			 * @param string $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 *
			 * @final This method may NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @see __()
			 * @see _n()
			 * @see _nx()
			 */
			final public function _x($string, $other_contextuals = '')
			{
				$string            = (string) $string;
				$other_contextuals = (string) $other_contextuals;
				$context           = $this->instance->plugin_stub_as_root_ns_with_dashes.'--front-side'
				                     .(($other_contextuals) ? ' '.$other_contextuals : '');

				return _x($string, $context, $this->instance->plugin_root_ns_stub_with_dashes);
			}

			/**
			 * Plural/contextual translation wrapper (context: `front-side`).
			 *
			 * @param string $string_singular String to translate (in singular format).
			 * @param string $string_plural String to translate (in plural format).
			 * @param string|integer $numeric_value Value to translate (always a numeric value).
			 *
			 * @param string $other_contextuals Optional. Other contextual slugs relevant to this translation.
			 *    Contextual slugs normally follow the standard of being written with dashes.
			 *
			 * @return string Translated string.
			 *
			 * @final This method may NOT be overridden by extenders.
			 * @public Available for public usage.
			 *
			 * @see __()
			 * @see _n()
			 * @see _x()
			 */
			final public function _nx($string_singular, $string_plural, $numeric_value, $other_contextuals = '')
			{
				$string_singular   = (string) $string_singular;
				$string_plural     = (string) $string_plural;
				$numeric_value     = (string) $numeric_value;
				$other_contextuals = (string) $other_contextuals;
				$context           = $this->instance->plugin_stub_as_root_ns_with_dashes.'--front-side'.
				                     (($other_contextuals) ? ' '.$other_contextuals : '');

				return _nx($string_singular, $string_plural, $numeric_value, $context, $this->instance->plugin_root_ns_stub_with_dashes);
			}
		}

		# -----------------------------------------------------------------------------------------------------------------------------
		# Now include the XDaRk Core autoload/exception handlers.
		# -----------------------------------------------------------------------------------------------------------------------------

		require_once dirname(__FILE__).'/autoloader.php';
		require_once dirname(__FILE__).'/exception-handler.php';

		# -----------------------------------------------------------------------------------------------------------------------------
		# Creates an instance of the XDaRk Core framework.
		# -----------------------------------------------------------------------------------------------------------------------------

		$GLOBALS[ stub::$core_ns ] = new framework(
			array(
				'plugin_root_ns' => stub::$core_ns,
				'plugin_var_ns'  => stub::$core_ns,
				'plugin_cap'     => stub::$core_cap,
				'plugin_name'    => stub::$core_name,
				'plugin_site'    => stub::$core_site,
				'plugin_version' => stub::$core_version,
				'plugin_dir'     => stub::n_dir_seps_up(__FILE__, 3)
			));

		# -----------------------------------------------------------------------------------------------------------------------------
		# Update XDaRk Core global stub w/ a reference to the latest available version at runtime.
		# -----------------------------------------------------------------------------------------------------------------------------

		if (!isset($GLOBALS[ stub::$core_ns_stub ]) || !($GLOBALS[ stub::$core_ns_stub ] instanceof framework)
		    || version_compare($GLOBALS[ stub::$core_ns_stub ]->instance->core_version,
				$GLOBALS[ stub::$core_ns ]->instance->core_version, '<')
		)
			$GLOBALS[ stub::$core_ns_stub ] = $GLOBALS[ stub::$core_ns ];

		# -----------------------------------------------------------------------------------------------------------------------------
		# XDaRk Core API functions/classes (some for internal use only).
		# -----------------------------------------------------------------------------------------------------------------------------

		/**
		 * XDaRk Core framework instance (this version; internal use only).
		 *
		 * @param string $version A specific version of the XDaRk Core?
		 *    WARNING: This function will NOT automatically load a specific version for you.
		 *       The version that you specify MUST already be loaded up.
		 *
		 * @return framework The global XDaRk Core framework instance (this version).
		 *
		 * @note If `$version` is passed in, this returns a specific version of the XDaRk Core.
		 *
		 * @note This compliments {@link \xd()} in the global namespace.
		 *    This is for calls within THIS namespace; where we want to use this specific version.
		 *
		 * @see \xd() The global version of this function.
		 */
		function core($version = '')
		{
			if (!$version)
				return $GLOBALS[ stub::$core_ns ];

			return $GLOBALS[ stub::$core_ns_stub_v.stub::with_underscores((string) $version) ];
		}

		/*
		 * Easier global access for those who DON'T CARE about the version.
		 */
		if (!core()->©function->is_possible('\\'.stub::$core_ns_stub)) // Only if it does NOT exist yet?
			core()->©php->¤eval('function '.stub::$core_ns_stub.'($version = \'\'){if(!$version) return $GLOBALS[\''.stub::$core_ns_stub.'\']; return $GLOBALS[\''.stub::$core_ns_stub_v.'\'.'.stub::$core_ns.'::with_underscores((string)$version)];}');

		/**
		 * XDaRk Core API class (this version; internal use only).
		 *
		 * @note This compliments {@link \xd} in the global namespace.
		 *    This is for calls within THIS namespace; where we want to use this specific version.
		 *
		 * @see api XDaRk Core API abstraction.
		 * @see \xd The global version of this class.
		 */
		final class core extends api // XDaRk Core API abstraction.
		{
			// Version is worked out by the API class. Nothing more we need to do here.
		}

		/*
		 * Easier global access for those who DON'T CARE about the version.
		 */
		if (!class_exists('\\'.stub::$core_ns_stub)) // Only if it does NOT exist yet?
			core()->©php->¤eval('final class '.stub::$core_ns_stub.' extends \\'.stub::$core_ns.'\\api{}');
	}
}