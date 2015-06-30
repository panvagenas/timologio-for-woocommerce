<?php
/**
 * Menu Page Panel.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 140523
 */
namespace xd_v141226_dev\menu_pages\panels
{
	if(!defined('WPINC'))
		exit('Do NOT access this file directly: '.basename(__FILE__));

	/**
	 * Menu Page Panel.
	 *
	 * @package XDaRk\Core
	 * @since 140523
	 *
	 * @assert ($GLOBALS[__NAMESPACE__])
	 */
	class update extends panel
	{
		/**
		 * Constructor.
		 *
		 * @param object|array $instance Required at all times.
		 *    A parent object instance, which contains the parent's ``$instance``,
		 *    or a new ``$instance`` array.
		 *
		 * @param \xd_v141226_dev\menu_pages\menu_page
		 *    $menu_page A menu page class instance.
		 */
		public function __construct($instance, $menu_page)
		{
			parent::__construct($instance, $menu_page);

			$call        = '©plugin.®update';
			$form_fields = $this->©form_fields(array('for_call' => $call));

			$this->heading_title = sprintf($this->__('%1$s Updater'), $this->instance->plugin_name);

			$this->content_body = // Updates Framework to the latest version.

				'<p>'. // Brief description.
				'<img class="pull-right l-margin" src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/icon-128x128.png')).'" alt="" />'.
				sprintf($this->__('This will automatically update your copy of the %1$s Framework to the latest available version. This update routine is powered by WordPress®. Depending on your configuration of WordPress® you might be asked for FTP credentials before the update will begin. The %1$s Framework (which is free) can also be updated from the plugins menu in WordPress®.'),
				        esc_html($this->instance->plugin_name)).
				'</p>'.
				'<div class="alert alert-warning">'. // A friendly reminder.
				sprintf($this->__('<i class="fa fa-support"></i> Please be sure to <strong>BACKUP</strong> your entire file structure <strong>and ALSO</strong> your MySQL database before updating any WordPress® component. Just to be safe <i class="fa fa-smile-o"></i>'),
				        esc_html($this->instance->plugin_name)).
				'</div>'.

				'<form method="post" action="'.esc_attr($this->©menu_page->url($this->menu_page->slug, $this->slug)).'">'.
				$this->©action->hidden_inputs_for_call($call, $this::private_type).
				$this->©action->get_call_responses_for($call).

				'<div class="form-group no-b-margin">'.
				$form_fields->markup(
					'<i class="fa fa-magic"></i> '.sprintf($this->__('Update %1$s Framework'), $this->instance->plugin_name),
					array('type' => 'submit', 'name' => 'update')
				).
				'</div>'.

				'</form>';
		}
	}
}