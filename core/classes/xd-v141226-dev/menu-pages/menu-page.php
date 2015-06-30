<?php
/**
 * Menu Page.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 */
namespace xd_v141226_dev\menu_pages
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page.
	 *
	 * @package XDaRk\Core
	 * @since 120318
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class menu_page extends \xd_v141226_dev\framework
	{
		/**
		 * @var string Slug for this menu page.
		 * @note Set to the basename of the class w/ dashes.
		 */
		public $slug = '';

		/**
		 * @var string Heading/title for this menu page.
		 * @extenders Should be overridden by class extenders.
		 */
		public $heading_title = '';

		/**
		 * @var string Sub-heading/description for this menu page.
		 * @extenders Should be overridden by class extenders.
		 */
		public $sub_heading_description = '';

		/**
		 * @var array Array of content panels for this menu page.
		 * @note Constructed dynamically by adding panels via `add_content_panel()`.
		 */
		public $content_panels = array();

		/**
		 * @var array Array of sidebar panels for this menu page.
		 * @note Constructed dynamically by adding panels via `add_sidebar_panel()`.
		 */
		public $sidebar_panels = array();

		/**
		 * @var boolean Should sidebar panels share a global order?
		 * @extenders Can be overridden by class extenders.
		 */
		public $sidebar_panels_share_global_order = TRUE;

		/**
		 * @var boolean Should sidebar panels share a global state?
		 * @extenders Can be overridden by class extenders.
		 */
		public $sidebar_panels_share_global_state = TRUE;

		/**
		 * @var boolean Defaults to FALSE. Does this menu page update options?
		 *    When TRUE, each menu page is wrapped with a form tag that calls `©options.®update`.
		 *    In addition, `$this->option_fields` will be populated, for easy access to a `©form_fields` instance.
		 *    In addition, each menu page will have a `Save All Options` button.
		 *
		 * @note This comes in handy, when a menu page is dedicated to updating options.
		 *    Making it possible for a site owner to update all options (i.e. from all panels), in one shot.
		 *    The `Save All Options` button at the bottom will facilitate this.
		 *
		 * @extenders Can easily be overridden by class extenders.
		 */
		public $updates_options = FALSE;

		/**
		 * @var null|\xd_v141226_dev\form_fields Instance of form fields class, for option updates.
		 * @note Set only if `$updates_options` is TRUE.
		 */
		public $option_form_fields; // Defaults to a NULL value.

		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's `$instance`,
		 *    or a new `$instance` array.
		 */
		public function __construct($instance)
		{
			parent::__construct($instance);

			$this->slug = $this->instance->ns_class_basename;
			$this->slug = $this->©string->with_dashes($this->slug);

			if($this->updates_options) // This updates options?
			{
				$this->option_form_fields = $this->©form_fields(
					array(
						'for_call'           => '©options.®update',
						'name_prefix'        => $this->©action->input_name_for_call_arg(1),
						'use_update_markers' => TRUE
					)
				);
			}
		}

		/**
		 * Displays HTML markup for this menu page.
		 *
		 * @attaches-to WordPress® `add_menu_page` or `add_submenu_page` handlers.
		 * @hook-priority Irrelevant. This is handled internally by WordPress®.
		 */
		public function display()
		{
			$this->display_notices();

			$this->display_header();

			$this->display_content_header();
			$this->display_content_panels();
			$this->display_content_footer();

			$this->display_sidebar_header();
			$this->display_sidebar_panels();
			$this->display_sidebar_footer();

			$this->display_footer();
		}

		/**
		 * Adds HTML markup for a menu page panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $sidebar Defaults to FALSE (by default, we assume this is a content panel).
		 *    Set this to TRUE, to indicate the addition of a panel for the sidebar.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 * @throws \xd_v141226_dev\exception If `$panel->slug` or `$panel->heading_title` are empty.
		 */
		public function add_panel($panel, $sidebar = FALSE, $active = FALSE)
		{
			$this->check_arg_types($this->instance->core_ns_prefix.'\\menu_pages\\panels\\panel', 'boolean', 'boolean', func_get_args());

			if(empty($panel->slug))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#slug_missing', get_defined_vars(),
					$this->__('Panel `slug` is empty. Check panel configuration.')
				);
			if(empty($panel->heading_title))
				throw $this->©exception(
					$this->method(__FUNCTION__).'#heading_title_missing', get_defined_vars(),
					$this->__('Panel has no `heading_title`. Check panel configuration.')
				);
			if($this->apply_filters('exclude_panel_by_slug', FALSE, $panel->slug))
				return; // Filters can exclude panels.

			if(!$this->©user->wp->has_cap($this->©caps->map('manage_'.$this->instance->plugin_root_ns,
			                                                'menu_pages__panel__'.$this->©string->with_underscores($panel->slug)))
			) return; // Do NOT include; use lacks permission.

			if($sidebar) // This panel is for the sidebar?
			{
				$panel_index = ($this->sidebar_panels)
					? count($this->sidebar_panels) - 1 : 0;

				$states    = $this->get_sidebar_panel_states();
				$is_active = ( // Should this panel be active by default?
					($active && !in_array($panel->slug, $states['inactive'], TRUE))
					|| in_array($panel->slug, $states['active'], TRUE)) ? TRUE : FALSE;
			}
			else // Otherwise, this is a content panel (default functionality).
			{
				$panel_index = ($this->content_panels)
					? count($this->content_panels) - 1 : 0;

				$states    = $this->get_content_panel_states();
				$is_active = ( // Should this panel be active by default?
					($active && !in_array($panel->slug, $states['inactive'], TRUE))
					|| in_array($panel->slug, $states['active'], TRUE)) ? TRUE : FALSE;
			}
			$class_id = 'panel--'.$panel->slug;

			$markup = '<div id="'.esc_attr($class_id).'" class="panel panel-default '.esc_attr($class_id).'"'.
			          ' data-panel-slug="'.esc_attr($panel->slug).'" data-panel-index="'.esc_attr($panel_index).'"'.
			          '>';

			$markup .= '<div class="panel-heading">';
			$markup .= '<h4 class="panel-title">'.
			           (($is_active) ? // Carets; controlled further via JavaScript.
				           ' <i class="fa fa-caret-up fa-fw pull-right" style="margin-right:-10px;"></i>'
				           : ' <i class="fa fa-caret-down fa-fw pull-right" style="margin-right:-10px;"></i>').

			           '<span class="opacity-fade cursor-move pull-left em-r-margin">'.
			           '<i class="fa fa-ellipsis-v" style="margin-right:1px;"></i><i class="fa fa-ellipsis-v"></i>'.
			           '</span>'.

			           '<a href="#" class="block-display no-text-decor cursor-pointer" name="'.esc_attr($panel->slug).'"'.
			           ' data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-collapse').'"'.
			           ' data-target="#'.esc_attr($class_id.' > .panel-collapse').'">'.$panel->heading_title.
			           '</a>'.
			           '</h4>';
			$markup .= '</div>';

			$markup .= '<div class="panel-collapse collapse'.(($is_active) ? ' in' : '').'">';
			$markup .= '<div class="panel-body clearfix">';

			if($panel->documentation)
			{
				$markup .= '<button class="btn btn-default btn-sm pull-right l-margin documentation-btn"'.
				           ' data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'"'.
				           ' data-target="#'.esc_attr($class_id.'--documentation-modal-window').'">'.
				           $this->__('Documentation').
				           '</button>';

				$markup .= '<div id="'.esc_attr($class_id.'--documentation-modal-window').'" class="modal fade">';
				$markup .= '<div class="modal-dialog">';
				$markup .= '<div class="modal-content">';

				$markup .= '<div class="modal-header">';
				$markup .= '<button type="button" class="close" data-dismiss="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'">&times;</button>';
				$markup .= '<h4 class="modal-title">'.$this->__('Documentation').'</h4>';
				$markup .= '</div>';

				$markup .= '<div class="modal-body">'.
				           $panel->documentation.
				           '</div>';

				$markup .= '</div>';
				$markup .= '</div>';
				$markup .= '</div>';
			}
			if($panel->yt_playlist && $sidebar)
			{
				$markup .= '<div class="center-block">'.
				           $this->©video->yt_playlist_iframe_tag($panel->yt_playlist, array('height' => '200px')).
				           '</div>';
			}
			else if($panel->yt_playlist)
			{
				$markup .= '<button class="btn btn-default btn-sm pull-right l-margin"'.
				           ' data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'"'.
				           ' data-target="#'.esc_attr($class_id.'--yt-playlist-modal-window').'">'.
				           $this->__('Video Tutorial').
				           '</button>';

				$markup .= '<div id="'.esc_attr($class_id.'--yt-playlist-modal-window').'" class="modal fade">';
				$markup .= '<div class="modal-dialog">';
				$markup .= '<div class="modal-content">';

				$markup .= '<div class="modal-header">';
				$markup .= '<button type="button" class="close" data-dismiss="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'" aria-hidden="true">&times;</button>';
				$markup .= '<h4 class="modal-title">'.$this->__('Video Tutorial').'</h4>';
				$markup .= '</div>';

				$markup .= '<div class="modal-body center-block">'.
				           $this->©video->yt_playlist_iframe_tag($panel->yt_playlist).
				           '</div>';

				$markup .= '</div>';
				$markup .= '</div>';
				$markup .= '</div>';
			}
			$markup .= $panel->content_body;

			$markup .= '</div>';
			$markup .= '</div>';

			$markup .= '</div>';

			if($sidebar) // Add markup.
				$this->sidebar_panels[$panel->slug] = $markup;
			else $this->content_panels[$panel->slug] = $markup;
		}

		/**
		 * Adds HTML markup for a menu page content panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 * @throws \xd_v141226_dev\exception If `$panel_slug`, `$panel_heading_title` or `$panel_content_body` are empty.
		 *
		 * @alias See `add_panel()` for further details.
		 */
		public function add_content_panel($panel, $active = FALSE)
		{
			return $this->add_panel($panel, FALSE, $active);
		}

		/**
		 * Adds HTML markup for a menu page sidebar panel.
		 *
		 * @param panels\panel $panel A panel object instance.
		 *
		 * @param boolean      $active Defaults to FALSE. TRUE if this is an active panel (e.g. it should be open by default).
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 * @throws \xd_v141226_dev\exception If `$panel_slug`, `$panel_heading_title` or `$panel_content_body` are empty.
		 *
		 * @alias See `add_panel()` for further details.
		 */
		public function add_sidebar_panel($panel, $active = FALSE)
		{
			return $this->add_panel($panel, TRUE, $active);
		}

		/**
		 * Displays HTML markup for notices, for this menu page.
		 *
		 * @extenders Can be overridden by class extenders (e.g. by each menu page),
		 *    so that custom notices could be displayed in certain cases.
		 */
		public function display_notices()
		{
		}

		/**
		 * Displays HTML markup for a menu page header.
		 */
		public function display_header()
		{
			if(!in_array(($current_menu_pages_theme = $this->©options->get('menu_pages.theme')), array_keys($this->©styles->themes()), TRUE))
				$current_menu_pages_theme = $this->©options->get('menu_pages.theme', TRUE);

			$classes[] = $this->instance->core_ns_with_dashes;
			$classes[] = $this->instance->plugin_root_ns_with_dashes;

			$classes[] = $this->instance->core_ns_with_dashes.'--t--'.$current_menu_pages_theme;
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--t--'.$current_menu_pages_theme;

			$classes[] = 'menu-page'; // Simple `menu-page` class.
			$classes[] = $this->instance->core_ns_with_dashes.'--menu-page';
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--menu-page';
			$classes[] = $this->instance->core_ns_with_dashes.'--menu-page--'.$this->slug;
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--menu-page--'.$this->slug;

			$classes[] = 'wrapper'; // Simple `wrapper` class.
			$classes[] = $this->instance->core_ns_with_dashes.'--wrapper';
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--wrapper';
			$classes[] = $this->instance->core_ns_with_dashes.'--wrapper--'.$this->slug;
			$classes[] = $this->instance->plugin_root_ns_with_dashes.'--wrapper--'.$this->slug;

			echo '<div class="'.esc_attr(implode(' ', $classes)).'">';
			echo '<div class="inner-wrap">';

			echo '<div class="container-fluid">';

			echo '<div class="row b-margin">';
			echo '<div class="col-md-12">';

			echo '<div class="row">';

			echo '<div class="col-md-7">';
			echo '<h2 class="no-margin no-padding"><img src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/icon-24x24.png')).'" alt="" /> '.$this->heading_title.'</h2>';
			echo '<div>'.$this->sub_heading_description.'</div>';
			echo '</div>';

			echo '<div class="col-md-5 hidden-sm hidden-xs">';
			$this->display_header_controls();
			echo '</div>';

			echo '</div>';

			echo '</div>';
			echo '</div>';

			echo '<div class="row">';
		}

		/**
		 * Displays HTML markup for controls in a menu page header.
		 */
		public function display_header_controls()
		{
			$this->display_header_control__restore_default_options();
			$this->display_header_control__import_export_options();
			$this->display_header_control__update_theme();
			$this->display_header_control__toggle_all_panels();
		}

		/**
		 * Displays HTML markup that presents a button to restore default options.
		 */
		public function display_header_control__restore_default_options()
		{
			if(!$this->©user->wp->has_cap($this->©caps->map('manage_'.$this->instance->plugin_root_ns, 'menu_pages__restore_default_options')))
				return; // Do NOT display here; use lacks permission.

			echo '<button type="button" class="btn btn-warning pull-right l-margin" title="'.esc_attr($this->__('Restore Default Plugin Options')).'"'.
			     ' data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'" data-target=".menu-page .restore-default-options.modal">'.
			     '<i class="fa fa-history"></i>'.
			     '</button>';

			echo '<div class="restore-default-options modal">'.
			     '<div class="modal-dialog">'.
			     '<div class="modal-content">';

			echo '<div class="modal-header">';

			echo '<button type="button" class="close" data-dismiss="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'">&times;</button>';
			echo '<h4 class="modal-title">'.$this->__('Restore Default Plugin Options?').'</h4>';

			echo '</div>';

			echo '<div class="modal-body">';

			echo '<p class="clearfix">'.
			     '<i class="fa fa-history fa-5x pull-right l-margin"></i>'.
			     $this->__('This will <strong>delete</strong> ALL of your existing configuration options; and then restore the default options that came with the software.').
			     ' '.$this->__('Are you absolutely sure that\'s what you want to do?').
			     '</p>';

			echo '<div class="row t-margin">';
			echo '<div class="col-md-6">';
			echo '<button type="button" class="btn btn-danger pull-left" data-dismiss="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'">'.
			     '<i class="fa fa-times-circle"></i> '.$this->__('No, Cancel').
			     '</button>';
			echo '</div>';

			echo '<div class="col-md-6">';
			$form_fields = $this->©form_fields(array('for_call' => '©options.®restore_defaults'));
			echo '<form method="post" class="pull-right">'.$this->©action->hidden_inputs_for_call('©options.®restore_defaults', $this::private_type).
			     '<input type="hidden" name="'.esc_attr($this->©action->input_name_for_call_arg(1)).'" value="1" />';

			echo '<div class="form-group no-b-margin">'.
			     $form_fields->markup($this->__('Yes, Restore').' <i class="fa fa-history"></i>', array('type' => 'submit', 'name' => 'restore')).
			     '</div>';

			echo '</form>';
			echo '</div>';
			echo '</div>';

			echo '</div>';

			echo '</div>'.
			     '</div>'.
			     '</div>';
		}

		/**
		 * Displays HTML markup that presents a button to restore default options.
		 */
		public function display_header_control__import_export_options()
		{
			if(!$this->©user->wp->has_cap($this->©caps->map('manage_'.$this->instance->plugin_root_ns, 'menu_pages__import_export_options')))
				return; // Do NOT display here; use lacks permission.

			echo '<button type="button" class="btn btn-primary pull-right l-margin" title="'.esc_attr($this->__('Import/Export Plugin Options')).'"'.
			     ' data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'" data-target=".menu-page .import-export-options.modal">'.
			     '<i class="fa fa-gears"></i>'.
			     '</button>';

			echo '<div class="modal import-export-options">'.
			     '<div class="modal-dialog">'.
			     '<div class="modal-content">';

			echo '<div class="modal-header">'.
			     '<button type="button" class="close" data-dismiss="'.esc_attr($this->instance->core_ns_with_dashes.'-modal').'">&times;</button>'.
			     '<h4 class="modal-title">'.$this->__('Import/Export Plugin Options?').'</h4>'.
			     '</div>';

			echo '<div class="modal-body">';

			echo '<p class="clearfix">'.
			     '<i class="fa fa-gears fa-5x pull-right l-margin"></i>'.
			     sprintf($this->__('If you\'re using %1$s on multiple sites, import/export can be a HUGE time-saver.'), esc_html($this->instance->plugin_name)).
			     ' '.sprintf($this->__('Configure the plugin just once (on one installation); then export your <code>%1$s.json</code> configuration file for use as a starting point on new sites in the future.'), esc_html($this->instance->plugin_root_ns_with_dashes)).
			     '</p>';

			echo '<ul class="nav nav-tabs">'.
			     '<li class="active"><a href="#" data-target=".menu-page .import-export-options .tab-pane.import" data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-tab').'">'.$this->__('Import').'</a></li>'.
			     '<li><a href="#" data-target=".menu-page .import-export-options .tab-pane.export" data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-tab').'">'.$this->__('Export').'</a></li>'.
			     '</ul>';

			echo '<div class="tab-content">';

			echo '<div class="tab-pane active import">';

			echo '<p class="em-t-margin">'.
			     sprintf($this->__('Import a previously downloaded copy of your <code>%1$s.json</code> configuration file.'), esc_html($this->instance->plugin_root_ns_with_dashes)).
			     $this->__(' Select the file from your computer and click the button to upload &amp; import.').
			     '</p>';

			$form_fields = $this->©form_fields(array('for_call' => '©options.®import'));
			echo '<form method="post" enctype="multipart/form-data">'.$this->©action->hidden_inputs_for_call('©options.®import', $this::private_type);

			echo '<div class="form-group">'.
			     '<div class="input-group">'.
			     '<span class="input-group-addon"><i class="fa fa-paperclip fa-fw"></i></span>'.
			     $form_fields->markup(NULL, $this->©options->import_json_form_field_config).
			     '</div>'.
			     '</div>';

			echo '<div class="form-group no-b-margin">'.
			     $form_fields->markup($this->__('Upload &amp; Import').' <i class="fa fa-upload"></i>', array('type' => 'submit', 'name' => 'import')).
			     '</div>';

			echo '</form>';

			echo '</div>';

			echo '<div class="tab-pane export">';

			echo '<p class="em-t-margin">'.
			     sprintf($this->__('Click this button to export &amp; download the <code>%1$s.json</code> configuration file that contains your currently configured setings for %2$s.'), esc_html($this->instance->plugin_root_ns_with_dashes), esc_html($this->instance->plugin_name)).
			     '</p>';

			$form_fields = $this->©form_fields(array('for_call' => '©options.®export'));
			echo '<form method="post">'.$this->©action->hidden_inputs_for_call('©options.®export', $this::private_type);

			echo '<div class="form-group no-b-margin">'.
			     $form_fields->markup($this->__('Export &amp; Download').' <i class="fa fa-download"></i>', array('type' => 'submit', 'name' => 'export')).
			     '</div>';

			echo '</form>';

			echo '</div>';

			echo '</div>';

			echo '</div>';

			echo '</div>'.
			     '</div>'.
			     '</div>';
		}

		/**
		 * Displays HTML markup to provide a way to update the current menu pages theme.
		 */
		public function display_header_control__update_theme()
		{
			if(!$this->©user->wp->has_cap($this->©caps->map('manage_'.$this->instance->plugin_root_ns, 'menu_pages__update_theme')))
				return; // Do NOT display here; use lacks permission.

			echo '<div class="update-theme btn-group pull-right l-margin" title="'.esc_attr($this->__('Choose an Administrative Theme')).'">';

			echo '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="'.esc_attr($this->instance->core_ns_with_dashes.'-dropdown').'">'.
			     '<i class="fa fa-wordpress"></i> '.$this->__('Admin Theme').' <span class="caret"></span>'.
			     '</button>';

			echo '<ul class="dropdown-menu">';
			$current_theme = $this->©options->get('menu_pages.theme');
			foreach($this->©styles->themes() as $_theme => $_theme_file)
				echo '<li data-theme="'.esc_attr($_theme).'"'.selected($_theme, $current_theme, FALSE).'>'.
				     '<a href="#">'.(($_theme === $current_theme) ? '<i class="fa fa-check-square-o"></i> ' : '').
				     esc_html(ucwords(str_replace('-', ' ', $_theme))).'</a>'.
				     '</li>';
			unset($_theme, $_theme_file);
			echo '</ul>';

			$form_fields = $this->©form_fields(array('for_call' => '©menu_pages.®update_theme'));
			echo '<form method="post">'.$this->©action->hidden_inputs_for_call('©menu_pages.®update_theme', $this::private_type).
			     '<input type="hidden" class="selected-theme" name="'.esc_attr($this->©action->input_name_for_call_arg(1)).'" />';
			echo '</form>';

			echo '</div>';
		}

		/**
		 * Displays HTML markup providing a way to toggle all panels on/off; and save the selected state.
		 */
		public function display_header_control__toggle_all_panels()
		{
			if(!$this->©user->wp->has_cap($this->©caps->map('manage_'.$this->instance->plugin_root_ns, 'menu_pages__toggle_all_panels')))
				return; // Do NOT display here; use lacks permission.

			echo '<button type="button" class="toggle-all-panels btn btn-default pull-right" title="'.esc_attr($this->__('Toggle All Panels On/Off')).'">'.
			     '<i class="fa fa-caret-up"></i> '.$this->__('Toggle All').' <i class="fa fa-caret-down"></i>'.
			     '</button>';
		}

		/**
		 * Displays HTML markup for a menu page footer.
		 */
		public function display_footer()
		{
			echo '</div>';

			echo '</div>';

			echo '</div>';
			echo '</div>';
		}

		/**
		 * Displays HTML markup for a menu page content header.
		 */
		public function display_content_header()
		{
			echo '<div class="col-md-8">';
			$this->display_before_content_panels();
			echo '<div class="content-panels">';
		}

		/**
		 * Displays HTML markup before content panels, for this menu page.
		 */
		public function display_before_content_panels()
		{
			if($this->updates_options)
			{
				echo '<form method="post" class="update-options">';
				echo $this->©action->hidden_inputs_for_call('©options.®update', $this::private_type);
				echo $this->©action->get_call_responses_for('©options.®update');
			}
			echo $this->©action->get_call_responses_for('©options.®import');
			echo $this->©action->get_call_responses_for('©options.®export');
			echo $this->©action->get_call_responses_for('©options.®restore_defaults');
		}

		/**
		 * Displays HTML markup producing content panels for this menu page.
		 *
		 * @extenders Should be overridden by class extenders (e.g. by each menu page),
		 *    so that custom content panels can be displayed by this routine.
		 */
		public function display_content_panels()
		{
			$this->display_content_panels_in_order();
		}

		/**
		 * Displays HTML markup producing content panels for this menu page (in order).
		 *
		 * @extenders Should be called upon by class extenders (e.g. by each menu page),
		 *    so that custom content panels can be displayed by this routine.
		 */
		public function display_content_panels_in_order()
		{
			$panel_slugs_displayed           = array(); // Initialize.
			$content_panels_in_order_by_slug = $this->get_content_panel_order();

			foreach($content_panels_in_order_by_slug as $_panel_slug)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($this->content_panels[$_panel_slug]))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $this->content_panels[$_panel_slug];
					}
			}
			unset($_panel_slug); // Housekeeping.

			foreach($this->content_panels as $_panel_slug => $_panel_markup)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($_panel_markup))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $_panel_markup;
					}
			}
			unset($_panel_slug, $_panel_markup); // Housekeeping.
		}

		/**
		 * Updates the order of content panels, for this menu page.
		 *
		 * @param array $new_order An array of content panel slugs for this menu page, in a specific order.
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_content_panels_order($new_order)
		{
			$this->check_arg_types('array', func_get_args());

			$order = $this->©options->get('menu_pages.panels.order');

			$order[$this->slug]['content_panels'] = $new_order;

			$this->©options->update(array('menu_pages.panels.order' => $order));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets order for content panels in this menu page.
		 *
		 * @return array Array of content panel slug, in a specific order.
		 *    Possible for this to return empty arrays, if panels currently have only a default order.
		 */
		public function get_content_panel_order()
		{
			$order = $this->©options->get('menu_pages.panels.order');

			return $this->©array->isset_or($order[$this->slug]['content_panels'], array());
		}

		/**
		 * Updates the state of content panels, for this menu page.
		 *
		 * @param array $new_active An array of content panel slugs for this menu page, which are active.
		 *
		 * @param array $new_inactive An array of content panel slugs for this menu page, which are inactive.
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_content_panels_state($new_active, $new_inactive)
		{
			$this->check_arg_types('array', 'array', func_get_args());

			$state = $this->©options->get('menu_pages.panels.state');

			$state[$this->slug]['content_panels']['active']   = array_diff($new_active, $new_inactive);
			$state[$this->slug]['content_panels']['inactive'] = array_diff($new_inactive, $new_active);

			$this->©options->update(array('menu_pages.panels.state' => $state));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets active/inactive states, for content panels in this menu page.
		 *
		 * @return array Two array elements, `active` and `inactive`, both arrays containing panel slugs.
		 *    Possible for this to return empty arrays, if panels currently have only a default state.
		 */
		public function get_content_panel_states()
		{
			$state = $this->©options->get('menu_pages.panels.state');
			$state = $this->©array->isset_or($state[$this->slug]['content_panels'], array());

			return array(
				'active'   => $this->©array->isset_or($state['active'], array()),
				'inactive' => $this->©array->isset_or($state['inactive'], array())
			);
		}

		/**
		 * Displays HTML markup after content panels, for this menu page.
		 */
		public function display_after_content_panels()
		{
			if($this->updates_options)
			{
				echo '<hr />'; // Divider w/ margins.
				echo $this->option_form_fields->markup(
					'<i class="fa fa-save"></i> '.$this->__('Save All Options'),
					array(
						'type'    => 'submit',
						'name'    => '[update_options]',
						'classes' => 'btn-primary btn-lg width-100'
					)
				);
				echo '</form>';
			}
		}

		/**
		 * Displays HTML markup for a menu page content footer.
		 */
		public function display_content_footer()
		{
			echo '</div>';
			$this->display_after_content_panels();
			echo '</div>';
		}

		/**
		 * Displays HTML markup for a menu page sidebar header.
		 */
		public function display_sidebar_header()
		{
			echo '<div class="col-md-4 hidden-sm hidden-xs">';
			$this->display_before_sidebar_panels();
			echo '<div class="sidebar-panels">';
		}

		/**
		 * Displays HTML markup before sidebar panels, for this menu page.
		 */
		public function display_before_sidebar_panels()
		{
		}

		/**
		 * Displays HTML markup producing sidebar panels for this menu page.
		 *
		 * @extenders Can be overridden by class extenders (i.e. by each menu page),
		 *    so that custom sidebar panels can be displayed by this routine.
		 */
		public function display_sidebar_panels()
		{
			if(!$this->©plugin->has_pro_active())
				$this->add_sidebar_panel($this->©menu_pages__panels__pro_upgrade($this), TRUE);
			$this->add_sidebar_panel($this->©menu_pages__panels__email_updates($this));
			$this->add_sidebar_panel($this->©menu_pages__panels__news_kb($this));
			$this->add_sidebar_panel($this->©menu_pages__panels__community_forum($this));
			$this->add_sidebar_panel($this->©menu_pages__panels__videos($this));
			$this->add_sidebar_panel($this->©menu_pages__panels__donations($this));

			$this->display_sidebar_panels_in_order();
		}

		/**
		 * Displays HTML markup producing sidebar panels for this menu page (in order).
		 *
		 * @extenders Should be called upon by class extenders (e.g. by each menu page),
		 *    so that custom sidebar panels can be displayed by this routine.
		 */
		public function display_sidebar_panels_in_order()
		{
			$sidebar_panels_in_order_by_slug = $this->get_sidebar_panel_order();
			$panel_slugs_displayed           = array();

			foreach($sidebar_panels_in_order_by_slug as $_panel_slug)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($this->sidebar_panels[$_panel_slug]))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $this->sidebar_panels[$_panel_slug];
					}
			}
			unset($_panel_slug); // Housekeeping.

			foreach($this->sidebar_panels as $_panel_slug => $_panel_markup)
			{
				if(!in_array($_panel_slug, $panel_slugs_displayed, TRUE))
					if($this->©string->is_not_empty($_panel_markup))
					{
						$panel_slugs_displayed[] = $_panel_slug;
						echo $_panel_markup;
					}
			}
			unset($_panel_slug, $_panel_markup);
		}

		/**
		 * Updates the order of sidebar panels, for this menu page.
		 *
		 * @param array $new_order An array of sidebar panel slugs for this menu page, in a specific order.
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_sidebar_panels_order($new_order)
		{
			$this->check_arg_types('array', func_get_args());

			$order = $this->©options->get('menu_pages.panels.order');

			$global_order = $this->©array->isset_or($order['---global']['sidebar_panels'], array());

			// Reverse prepend each slug in the new order.
			foreach(array_reverse($new_order) as $_panel_slug)
				array_unshift($global_order, $_panel_slug);
			unset($_panel_slug); // Housekeeping.

			// Reduce to a unique set of values.
			$global_order = array_unique($global_order);

			$order[$this->slug]['sidebar_panels'] = $new_order;
			$order['---global']['sidebar_panels'] = $global_order;

			$this->©options->update(array('menu_pages.panels.order' => $order));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets order for sidebar panels in this menu page.
		 *
		 * @return array Array of sidebar panel slug, in a specific order.
		 *    Possible for this to return empty arrays, if panels currently have only a default order.
		 */
		public function get_sidebar_panel_order()
		{
			$order = $this->©options->get('menu_pages.panels.order');

			if($this->sidebar_panels_share_global_order)
				return $this->©array->isset_or($order['---global']['sidebar_panels'], array());
			else return $this->©array->isset_or($order[$this->slug]['sidebar_panels'], array());
		}

		/**
		 * Updates the state of sidebar panels, for this menu page.
		 *
		 * @param array $new_active An array of sidebar panel slugs for this menu page, which are active.
		 *
		 * @param array $new_inactive An array of sidebar panel slugs for this menu page, which are inactive.
		 *
		 * @throws \xd_v141226_dev\exception If invalid types are passed through arguments list.
		 */
		public function ®update_sidebar_panels_state($new_active, $new_inactive)
		{
			$this->check_arg_types('array', 'array', func_get_args());

			$state = $this->©options->get('menu_pages.panels.state');

			$global_active = $this->©array->isset_or($state['---global']['sidebar_panels']['active'], array());
			$global_active = array_unique(array_merge($global_active, $new_active));
			$global_active = array_diff($global_active, $new_inactive);

			$global_inactive = $this->©array->isset_or($state['---global']['sidebar_panels']['inactive'], array());
			$global_inactive = array_unique(array_merge($global_inactive, $new_inactive));
			$global_inactive = array_diff($global_inactive, $new_active);

			$state[$this->slug]['sidebar_panels']['active'] = array_diff($new_active, $new_inactive);
			$state['---global']['sidebar_panels']['active'] = array_diff($global_active, $global_inactive);

			$state[$this->slug]['sidebar_panels']['inactive'] = array_diff($new_inactive, $new_active);
			$state['---global']['sidebar_panels']['inactive'] = array_diff($global_inactive, $global_active);

			$this->©options->update(array('menu_pages.panels.state' => $state));

			$this->©action->set_call_data_for($this->dynamic_call(__FUNCTION__), get_defined_vars());
		}

		/**
		 * Gets active/inactive states, for sidebar panels in this menu page.
		 *
		 * @return array Two array elements, `active` and `inactive`; both arrays containing panel slugs.
		 *    Possible for this to return empty arrays if panels currently have only a default state.
		 */
		public function get_sidebar_panel_states()
		{
			$state = $this->©options->get('menu_pages.panels.state');

			if($this->sidebar_panels_share_global_state)
				$state = $this->©array->isset_or($state['---global']['sidebar_panels'], array());
			else $state = $this->©array->isset_or($state[$this->slug]['sidebar_panels'], array());

			return array(
				'active'   => $this->©array->isset_or($state['active'], array()),
				'inactive' => $this->©array->isset_or($state['inactive'], array())
			);
		}

		/**
		 * Displays HTML markup after sidebar panels, for this menu page.
		 */
		public function display_after_sidebar_panels()
		{
		}

		/**
		 * Displays HTML markup for a menu page sidebar footer.
		 */
		public function display_sidebar_footer()
		{
			echo '</div>';
			$this->display_after_sidebar_panels();
			echo '</div>';
		}
	}
}