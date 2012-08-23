<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>

	<title><?php echo $site_name; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="<?php echo url::base() ?>media/js/tailorbirds.js"></script>
	<?php echo $header_block; ?>
	<?php
		echo html::stylesheet('media/css/admin/all_layer', '', TRUE);
	?>
	<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>
	<link href="<?php echo url::base() ?>media/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="<?php echo url::base() ?>media/facebox/facebox.js"></script>
    <script type="text/javascript" src="<?php echo url::base() ?>media/js/selectToUISlider.jQuery.js"></script>    	
    <?php if (isset($fb_title)): ?>
	    <meta property="og:title" content="<?php echo $fb_title; ?>" />
		<meta property="og:description" content="<?php echo $fb_description; ?>" />
		<meta property="og:image" content="<?php echo $fb_image; ?>" />
	<?php endif; ?>
</head>

<?php if (isset($_SERVER['HTTP_USER_AGENT']) AND (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)): ?>
<script type="text/javascript">
	var alertMessage = "Internet Explorer (IE) detectado\n\n" +
	    "O mapasColetivos não pode ser visualizado corretamente em Internet Explorer. " +
	    "Por favor, utilize umas das opções abaixo: \n\n" +
	    "Chrome    https://www.google.com/chrome/ \n" +
	    "Firefox       http://www.mozilla.com/firefox/ \n" + 
	    "Safari         http://www.apple.com/br/safari/ \n\n" +
	    "IMPORTANTE: o IE não respeita normas da w3c e este site não funcionará corretamente nele.";

	alert(alertMessage);
</script>
<?php endif; ?>

<body id="page">

  <!-- logo -->
	<div id="logo_final">
	<a href='<?php echo url::site()."main"; ?>'><img src="<?php echo url::base(); ?>/media/img/logo_2.png"></a>
	</div>
	<!-- / logo -->
  
  <!-- mainmenu -->
  <div id="mainmenu">
  	<div class="rapidxwpr floatholder clearingfix">
  		<div id="menucontent"> 
  			<?php nav::main_tabs($this_page); ?>

  			<div style="clear: both;"></div>
			<?php echo $search; ?>

  		</div>
  	</div>
  </div>
  <!-- / mainmenu -->
	
	<!-- wrapper -->
	<div class="rapidxwpr floatholder">
		<!-- main body -->
		<div id="middle">
			<div class="background layoutleft">
