<div id="main" class="clearing-fix">
	<div class="content-bg">
		<div class="big-block">

		<?php if ($form_saved): ?>
			<div class="green-box">
				<h3><?php echo Kohana::lang('ui_main.login_account_creation_successful'); ?></h3>
			</div>
		<?php else: ?>

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
						<h4><?php echo Kohana::lang('ui_main.username');?></h4>
						<?php print form::input('username', $form['username'], ' class="text long2"'); ?>
					</div>

					<div class="row">
						<h4><?php echo Kohana::lang('ui_main.full_name');?></h4>
						<?php print form::input('name', $form['name'], ' class="text long2"'); ?>
					</div>

					<div class="row">
						<h4><?php echo Kohana::lang('ui_main.email');?></h4>
						<?php print form::input('email', $form['email'], ' readonly class="text long2"'); ?>
					</div>
					<div class="row">
						<h4><?php echo Kohana::lang('ui_main.password');?></h4>
						<?php print form::password('password', $form['password'], ' class="text"'); ?>
						<div style="clear:both;"></div>
						<h4><?php echo Kohana::lang('ui_main.password_again');?></h4>
						<?php print form::password('password_again', $form['password_again'], ' class="text"'); ?>
					</div>
					<div class="row">
						<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" />
					</div>
				</div>
			</div>
			<?php print form::close(); ?>
		<?php endif; ?>

		</div>
	</div>
</div>
