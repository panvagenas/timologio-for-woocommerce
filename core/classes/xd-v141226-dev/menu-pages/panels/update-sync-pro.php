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
	class update_sync_pro extends panel
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

			$call        = '©plugin.®update_sync_pro';
			$form_fields = $this->©form_fields(array('for_call' => $call));
			$data        = $this->©action->get_call_data_for($call);

			$username    = $this->©string->is_not_empty_or($data->username, '');
			$password    = $this->©string->is_not_empty_or($data->password, '');
			$credentials = $this->©plugin->get_site_credentials($username, $password);

			$this->heading_title = sprintf($this->__('%1$s Pro Add-on (Update/Sync)'), $this->instance->plugin_name);

			$this->content_body = // Updates the Pro add-on to the latest version.

				'<p>'. // Brief description.
				'<img class="pull-right l-margin" src="'.esc_attr($this->©url->to_template_dir_file('/client-side/images/icon-128x128-pro.png')).'" alt="" />'.
				sprintf($this->__('This will update (synchronize) your copy of the %1$s Pro add-on; so that it matches your currently installed version of the %1$s Framework.'),
				        esc_html($this->instance->plugin_name)).
				'</p>'.
				'<p>'. // Disclose that this routine will contact our remote update server.
				sprintf($this->__('While this update routine is powered (in part) by WordPress®, it connects to <em>our</em> remote update server for authentication; and to provide the necessary files.'),
				        esc_html($this->instance->plugin_name)).
				'</p>'.
				'<div class="alert alert-warning">'. // A friendly reminder.
				sprintf($this->__('<i class="fa fa-support"></i> Please be sure to <strong>BACKUP</strong> your entire file structure <strong>and ALSO</strong> your MySQL database before updating any WordPress® component. Just to be safe <i class="fa fa-smile-o"></i>'),
				        esc_html($this->instance->plugin_name)).
				'</div>'.

				'<form method="post" action="'.esc_attr($this->©menu_page->url($this->menu_page->slug, $this->slug)).'">'.
				$this->©action->hidden_inputs_for_call($call, $this::private_type).
				$this->©action->get_call_responses_for($call).

				'<div class="form-group">'.
				'<label>'.$this->__('Customer Username *').'</label>'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($credentials['username']),
					array(
						'required'    => TRUE,
						'type'        => 'text',
						'name'        => $this->©action->input_name_for_call_arg(1),
						'placeholder' => $this->__('customer username...')
					)
				).
				'</div>'.
				'<p class="help-block">'.$this->__('i.e. the username you purchased the Pro add-on with.').'</p>'.
				'</div>'.

				'<div class="form-group">'.
				'<label>'.$this->__('Customer Password; or Software License Key *').'</label>'.
				'<div class="input-group">'.
				'<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>'.
				$form_fields->markup(
					$form_fields->value($credentials['password']),
					array(
						'required'    => TRUE,
						'type'        => 'password',
						'name'        => $this->©action->input_name_for_call_arg(2),
						'placeholder' => $this->__('customer password; or software license key...')
					)
				).
				'</div>'.
				'<p class="help-block"><i class="fa fa-lightbulb-o"></i> '.$this->__('for best security, please use your software license key here.').'</p>'.
				'</div>'.

				'<div class="form-group no-b-margin">'.
				$form_fields->markup(
					'<i class="fa fa-magic"></i> '.sprintf($this->__('Update %1$s Pro Add-on'), $this->instance->plugin_name),
					array('type' => 'submit', 'name' => 'update')
				).
				'</div>'.

				'</form>';
		}
	}
}