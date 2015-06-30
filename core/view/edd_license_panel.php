<?php
/**
 * Created by PhpStorm.
 * User: Vagenas Panagiotis <pan.vagenas@gmail.com>
 * Date: 17/10/2014
 * Time: 8:25 μμ
 */
if (!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/* @var \xd_v141226_dev\menu_pages\panels\edd_license $callee */
/* @var \xd_v141226_dev\views $this */

if(!$this->©edd_updater->isEDD()){
	echo 'No valid license params. Please set edd.update = 1 and enter a valid url in edd.store_url option.';
	return;
}
$isInDemo = $this->©edd_updater->hasDemo() && $this->©edd_updater->isDemoActive();
if($isInDemo && !$this->©edd_updater->getLicenseStatus(false)){
	$status = 'Demo Mode';
	$ends = $this->©edd_updater->getDemoEndTime();
	$expiryDate = date('d M, Y', $ends);
	$licensedTo = 'Demo User';
	$timesActivated = 1;
	$activationsLeft = 0;
	$activeLic = false;
} else {
	$license   = $this->©edd_updater->getLicenseDataFromServer();
	if($license === 2){
		echo '<div class="alert alert-danger" role="alert">';
		echo $callee->__('Connection to licence server failed. Please check your settings');
		echo'</div>';
		return;
	}
	$activeLic = isset($license->license) && $license->license == 'valid';

	$status = $activeLic ? 'Active' : 'Inactive';
	$expiryDate = $license->expires ? date('d M, Y',strtotime($license->expires)) : 'No data';
	$licensedTo = $license->customer_email ? $license->customer_email : 'No data';
	$timesActivated = $license->site_count ? $license->site_count : 'No data';
	$activationsLeft = $license->activations_left ? $license->activations_left : 'No data';
}

?>
	<ul class="list-group">
		<li class="list-group-item">
			Status: <strong class="<?php echo $activeLic ? 'text-success' : 'text-danger'; ?>"><?php echo $status; ?></strong>
		</li>
		<li class="list-group-item">
			Expiry Date: <strong><?php echo $expiryDate; ?></strong>
		</li>
		<li class="list-group-item">
			Licensed to: <strong><?php echo $licensedTo; ?></strong>
		</li>
		<li class="list-group-item">
			Times Activated: <strong><?php echo $timesActivated; ?></strong>
		</li>
		<li class="list-group-item">
			Activations Left: <strong><?php echo $activationsLeft; ?></strong>
		</li>
	</ul>

	<div class="form-horizontal" role="form">
		<div class="form-group row">
			<label for="license" class="col-md-3 control-label"><?php echo $this->__('License'); ?></label>

			<div class="col-sm-7">
				<?php
				$inputOptions = array(
					'type'        => 'text',
					'name'        => '[license_input]',
					'title'       => $this->__('License'),
					'placeholder' => $this->__('Enter a valid license key'),
					'required'    => true,
					'id'          => 'license',
					'attrs'       => '',
					'classes'     => 'form-control col-md-9 license-input'
				);
				echo $callee->menu_page->option_form_fields->markup($this->©option->get('edd_license'), $inputOptions);
				?>
			</div>
		</div>
	</div>
<?php
$btnOpts = array(
	'type'    => 'button',
	'name'    => 'deactivate',
	'title'   => 'Deactivate License',
	'classes' => 'btn btn-danger deactivate-lic col-md-5',
	'attrs'   => 'readonly data-target="#" '.($activeLic ? '' : 'disabled')
);
echo $callee->menu_page->©form_field->markup($this->__('Deactivate'), $btnOpts);

$btnOpts = array(
	'type'    => 'button',
	'name'    => 'activate',
	'title'   => 'Activate License',
	'classes' => 'btn btn-success activate-lic col-md-5 col-md-offset-2',
	'attrs'   => 'readonly data-target="#" '.($activeLic ? 'disabled' : '')
);
echo $callee->menu_page->©form_field->markup($this->__('Activate'), $btnOpts);