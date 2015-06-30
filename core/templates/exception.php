<?php
namespace xd_v141226_dev;
/**
 * Template
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 120318
 *
 * @note All WordPress® template tags are available for use in this template.
 *    See: {@link http://codex.wordpress.org/Template_Tags}
 *    See: {@link http://codex.wordpress.org/Conditional_Tags}
 *
 * @note The current plugin instance is available through the special keyword: `$this`.
 * @var $this templates|framework Template instance (extends framework).
 * @var $exception exception Exception class instance.
 */
if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

$exception = $this->data->exception;
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8" />
	<title><?php echo $this->_x('Uncaught Exception'); ?> | <?php echo esc_html(get_bloginfo('name')); ?></title>
	<?php echo $this->stand_alone_styles(); ?>
</head>
<body class="<?php echo esc_attr($this->stand_alone_body_classes()); ?>">

<div class="<?php echo esc_attr($this->stand_alone_wrapper_classes()); ?>">
	<div class="<?php echo esc_attr($this->stand_alone_inner_wrap_classes()); ?>">
		<div class="container">

			<div class="header wrapper">
				<div class="header inner-wrap">
					<?php echo $this->stand_alone_header(); ?>
				</div>
			</div>

			<div class="content wrapper">
				<div class="content inner-wrap">
					<div class="panel panel-default">
						<div class="panel-body">

							<!-- BEGIN: Content Body -->

							<a name="exception" class="anchor"></a>

							<i class="fa fa-frown-o pull-right l-margin">
								<?php echo esc_attr($this->_x('So sorry about this!')); ?></i>

							<h1 class="no-t-margin">
								<i class="fa fa-exclamation-triangle"></i>
								<?php echo $this->_x('Uncaught Exception'); ?>
							</h1>

							<h3 class="no-margin">
								<code class="text-wrap-break"><?php echo esc_html($exception->getCode()); ?></code>
							</h3>

							<?php if($this->©env->is_in_wp_debug_display_mode() || is_super_admin()): ?>

								<hr />

								<a class="opacity-fade-hover no-text-decor pull-right l-margin" style="float:right;" href="<?php echo esc_attr($this->©url->to_plugin_site_uri('/')); ?>" target="_blank" title="<?php echo esc_attr($this->instance->plugin_name); ?> <?php echo esc_attr($this->_x('(Report Bug?)')); ?>">
									<img src="<?php echo esc_attr($this->©url->to_template_dir_file('/client-side/images/icon-24x24.png')); ?>" alt="" title="<?php echo esc_attr($this->instance->plugin_name); ?>" /> <i class="fa fa-bug"></i> <i class="fa fa-wordpress fa-2x"></i>
								</a>

								<h3><i class="fa fa-lightbulb-o text-info"></i> <?php echo $this->__('Exception Message (Please Read)'); ?></h3>
								<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
								<pre class="text-no-wrap scroll-y-overflow-200-max"><?php echo esc_html($exception->getMessage()); ?> <?php echo esc_html(sprintf($this->__('At line # %1$s in: %2$s'), $exception->getLine(), $exception->getFile())); ?></pre>

								<hr />

								<h3><i class="fa fa-stack-overflow"></i> <?php echo $this->__('Stack Trace (For Debugging Purposes)'); ?></h3>
								<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
								<pre class="text-no-wrap scroll-y-overflow-200-max"><?php echo esc_html($exception->getTraceAsString()); ?></pre>

								<?php if(isset($exception->data)): ?>
									<hr />

									<h3><i class="fa fa-puzzle-piece"></i> <?php echo $this->__('Additional Data (For Debugging Purposes)'); ?></h3>
									<small><?php echo $this->__('The following is displayed in <a href="http://codex.wordpress.org/Editing_wp-config.php#Debug">WP_DEBUG_DISPLAY</a> mode; and for all super administrators of the site.'); ?></small>
									<pre class="text-no-wrap scroll-y-overflow-200-max"><?php echo esc_html($this->©var->dump($exception->data)); ?></pre>
								<?php endif; ?>

							<?php endif; ?>

							<hr />

							<div class="row">
								<div class="col-md-6">
									<p class="no-margin">
										<?php echo sprintf($this->_x('If problems persist, please <a href="%1$s">contact support</a> for assistance.'), $this->©options->get('support.url')) ?>
									</p>
								</div>
								<div class="col-md-6 text-right">
									<p class="no-margin">
										<a href="<?php echo esc_attr($this->©url->to_wp_home_uri()); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a> <i class="fa fa-chevron-circle-right"></i>
									</p>
								</div>
							</div>

							<!-- / END: Content Body -->

						</div>
					</div>
				</div>
			</div>

			<div class="footer wrapper">
				<div class="footer inner-wrap">
					<?php echo $this->stand_alone_footer(); ?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php echo $this->stand_alone_footer_scripts(); ?>

</body>
</html>