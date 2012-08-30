<div id="main" class="clearing-fix">
	<div class="big-block">
	<?php if ($form_error): ?>
		<!-- red-box -->
		<div class="red-box">
			<h3><?php echo Kohana::lang('ui_main.error');?></h3>
			<ul>
			<?php foreach ($errors as $error_item => $error_description): ?>
			<?php if ($error_description): ?>
				<li> <?php echo $error_description; ?></li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ($form_saved): ?>
		<!-- green-box -->
		<div class="green-box">
			<h3><?php echo Kohana::lang('ui_main.profile_saved');?></h3>
		</div>
	<?php endif; ?>
	
	<?php print form::open(); ?>
	<div class="report-form">
		<!-- column -->		
		<div class="sms_holder">
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.username');?></h4>
				<?php print form::input('username', $form['username'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.full_name');?></h4>
				<?php print form::input('name', $form['name'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.email');?></h4>
				<?php print form::input('email', $form['email'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.password');?></h4>
				<?php print form::password('password', $form['password'], ' class="text long2"'); ?>
			</div>
		</div>
	</div>
	<?php print form::close(); ?>
	</div>
</div>
