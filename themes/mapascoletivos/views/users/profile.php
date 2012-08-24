<div class="bg-small fullarea">
	<?php if ($form_error): ?>
	<!-- red-box -->
	<div class="red-box-small sms_holder_area">
		<h3><?php echo Kohana::lang('ui_main.error');?></h3>
		<ul>
			<?php foreach ($errors as $error_item => $error_description): ?>
			<li><?php echo (!$error_description) ? '' : $error_description; ?> </li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ($form_saved): ?>
		<!-- green-box -->
		<div class="green-box-small">
			<h3><?php echo Kohana::lang('ui_main.profile_saved');?></h3>
		</div>
	<?php endif; ?>

	<?php print form::open(NULL, array('enctype' => 'multipart/form-data')); ?>
	<div class="report-form">
		<!-- column -->		
		<div class="sms_holder">
			<div class="row">
				<h4>
					<?php echo Kohana::lang('ui_main.username');?>
					<br/>
					<span class="users_message">Incentivamos a participação individual e de organizações sem fins lucrativos. O uso comercial não será aprovado.</span>
				</h4>
				<?php
				if ($user AND $user->loaded AND $user->id == 1)
				{
					print form::input('username', $form['username'], ' class="text long2" readonly="readonly"');
				}
				else
				{
					print form::input('username', $form['username'], ' class="text long2"');
				}
				?>
			</div>
			<div class="row">
				<h4>Photo</h4>
				<img src="<?php echo $user->photo(154) ?>" />
				<br/>
				Para alterar sua imagem, acesse ou crie sua conta no <a href="http://en.gravatar.com/" target="_blank" >Gravatar</a> usando o mesmo e-mail cadastrado (<?php echo $user->email ?>). <br>
                Assegure-se de que a foto esteja classificada no gravatar como "G".
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
				<h4>Bio</h4>
				<?php print form::textarea('bio', $form['bio'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4>Localização</h4>
				<?php print form::input('localization', $form['web'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4>Web</h4>
				<?php print form::input('web', $form['localization'], ' class="text long2"'); ?>
			</div>
			<div class="row">
				<h4><?php echo Kohana::lang('ui_main.password');?></h4>
				<?php print form::password('password', $form['password'], ' class="text"'); ?>
				<div style="clear:both;"></div>
				<h4><?php echo Kohana::lang('ui_main.password_again');?></h4>
				<?php print form::password('password_again', $form['password_again'], ' class="text"'); ?>
			</div>
			
            <?php 
            // users_form_admin - add content to users from
            Event::run('ushahidi_action.users_form_admin', $id);
            ?>
            
            <input type="image" src="<?php echo url::base() ?>media/img/admin/btn-save-settings.gif" class="save-rep-btn" />
		</div>


	</div>
	<?php print form::close(); ?>
</div>
