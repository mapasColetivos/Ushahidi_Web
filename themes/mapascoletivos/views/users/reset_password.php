<div id="main" class="clearing-fix">
	<div class="big-block">
		<?php if (isset($message)): ?>
			<div class="<?php echo $message_class; ?>">
				<h4><?php echo $message; ?></h4>
			</div>
		<?php endif; ?>

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
			<?php echo form::hidden('action', $form['action']); ?>
			<div class="report-form">
				<!-- column -->		
				<div class="sms_holder">
					
					<?php if ($form['action'] == 'forgot_password'): ?>
					<div class="row">
						<h4><?php echo Kohana::lang('ui_main.email_address');?></h4>
						<?php print form::input('resetemail', $form['resetemail'], ' class="text long2"'); ?>
					</div>
					<?php elseif ($form['action'] == 'change_password'): ?>
						<?php echo form::hidden('token', $form['token']); ?>
						<div class="row">
							<h4><?php echo Kohana::lang('ui_main.password'); ?></h4>
							<?php echo form::password('password', '', 'class="text long2"'); ?>
						</div>
						<div class="row">
							<h4><?php echo Kohana::lang('ui_main.password_again'); ?></h4>
							<?php echo form::password('password_again', '', 'class="text long2"')?>
						</div>
					<?php endif; ?>

					<div class="row">
						<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" />
					</div>
				</div>
			</div>
		<?php print form::close(); ?>
	</div>
</div>
