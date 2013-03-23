<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo Kohana::lang('ui_main.ushahidi_admin'); ?></title>
	<?php echo html::stylesheet(array('themes/mapascoletivos/css/mapascoletivos.css', 'media/css/admin/login.css')); ?>
</head>

<body>
<div id="ushahidi_login_container">
    <div id="ushahidi_login_logo"><img src="<?php echo url::base() ?>media/img/admin/logo_2.png" /></div>
    <div id="ushahidi_login">
    	<table width="100%" border="0" cellspacing="3" cellpadding="4" background="" id="ushahidi_loginbox">
    		<?php if ($form_error): ?>
			<div class="red-box">
				<?php foreach ($errors as $error_item => $error_description): ?>
					<p align="center"><?php echo  ( ! $error_description) ? '' : $error_description; ?></p>
				<?php endforeach; ?>
				</td>
			</div>
			<?php endif; ?>
    		<?php echo form::open(NULL, array('style'=>'line-height: 100%; margin-top: 0; margin-bottom: 0;')); ?>
				<tr>
					<td><strong><?php echo Kohana::lang('ui_main.email_address');?>:</strong><br />
						<input type="text" name="username" id="username" class="login_text" />
					</td>
				</tr>
				<tr>
					<td><strong><?php echo Kohana::lang('ui_main.password');?>:</strong><br />
						<input name="password" type="password" class="login_text" id="password" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" id="remember" name="remember" value="1" checked="checked" />
						<?php echo Kohana::lang('ui_main.password_save');?>
					</td>
				</tr>
				<tr>
					<td><input type="submit" id="submit" name="submit" value="Log In" class="login_btn" /></td>
				</tr>
				<tr>
					<td>
						<a href="<?php echo url::site('users/reset_password'); ?>">
							<?php echo Kohana::lang('ui_main.forgot_password');?>
						</a>
					</td>
				</tr>
	            <tr></tr>
				<input type="hidden" id="oauth_enabled" name="oauth_enabled" value="0" />            
				<input type="hidden" id="oauth_name" name="oauth_name" value="" />
				<input type="hidden" id="oauth_username" name="oauth_username" value="" />
				<input type="hidden" id="oauth_email" name="oauth_email" value="" />	                
	        <?php echo form::close(); ?>
		</table>

		<br/>
		<span class="padd">Ainda não faz parte do mapasColetivos.com?</span><br/>

		<span class="padd">
        	<?php echo html::anchor("users/signup", "Cadastre-se aqui", array('class'=>'first')); ?>
        	para poder colaborar
		</span>
	</div>
	<div id="buttons">
		<div id="fb-root"></div>
		<?php
			// Links to JavaScript files to be included
			$scripts = array(
			    "https://platform.twitter.com/anywhere.js?id=FFppDFVn2sGgAYzlyVJ3A",
			    "http://connect.facebook.net/en_US/all.js",
			    "media/js/jquery"
			); 
			echo html::script($scripts); 
		?>
		<script>
			var res;
			FB.init({ 
            	appId:'259556637419906', cookie:true, 
            	status:true, xfbml:true 
         	});
			
         	function login_facebook(){
				    FB.login(function(response) {
			        if (response.session) {
  			        FB.api('/me',  function(response) {
  			        	$("#oauth_name").val(response.name);
  			        	$("#oauth_email").val(response.email);
  			        	$("#oauth_username").val(response.username);
                  $("#oauth_enabled").val(response.id);		
                  $("#submit").click();	        	
  			          }
  			        );
  			      }
			    } , {perms:'email'}); 
			 }
			function login_twitter(){
				twttr.anywhere(function (T) {
					T.signIn();
				});
			}
			twttr.anywhere(function (T) {
				T.bind("authComplete", function (e, user) {
					alert("complete");
			    });
			});
      	</script>
		<br />
	</div>
</div>
</body>
</html>
