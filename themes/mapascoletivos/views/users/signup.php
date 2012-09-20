<div id="main" class="clearing-fix">
	<div class="big-block">
	<?php if ($form_error): ?>
		<!-- red-box -->
		<div class="red-box">
			<h4><?php echo Kohana::lang('ui_main.error');?></h4>
			<ul>
			<?php foreach ($errors as $error_item => $error_description): ?>
			<?php if ($error_description): ?>
				<li> <?php echo $error_description; ?></li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php print form::open(); ?>
	<div class="report-form">
		<!-- column -->		
		<div class="sms_holder">
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.email');?></h4>
				<?php print form::input('email', $form['email'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.security_code'); ?></h4>
				<?php echo $captcha->render();  ?>
				<br>
				<?php print form::input('security_code', '', ' class="text long2"'); ?>
			</div>
			<div class="row">
				<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" />
			</div>
		</div>
	</div>
	<?php print form::close(); ?>
	</div>
</div>
