<?php

/*

FrogsThemes.com - FT Installer

*/

// get theme name
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$themename = preg_replace("/\W/", "", strtolower($themename) );

// when theme activated, it updates the option and redirects to the FT Installer page
function my_theme_activate() {
	header("Location: admin.php?page=frogsthemes_installer");
}
wp_register_theme_activation_hook($themename, 'my_theme_activate');

// when theme deactivated, it removes the option
function my_theme_deactivate() {
	// code to execute on theme deactivation
}
wp_register_theme_deactivation_hook($themename, 'my_theme_deactivate');

function wp_register_theme_activation_hook($code, $function) {
	$optionKey="theme_is_activated_" . $code;
	if(!get_option($optionKey)) {
		call_user_func($function);
		update_option($optionKey , 1);
	}
}
function wp_register_theme_deactivation_hook($code, $function) {
	 $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
	 $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');
	 add_action("switch_theme", $fn);
}

// import css and js files
function ft_installer_scripts() { 
	if(isset($_GET['page'])&&($_GET['page']=='frogsthemes_installer')){	
		#wp_enqueue_style('ft-installer-css',get_bloginfo('template_directory').'/functions/ft-installer/css/ft-installer.css',false);
		wp_enqueue_style('admin-style', OPTIONS_FRAMEWORK_DIRECTORY .'css/admin-style.css');
	}
}
add_action('admin_init', 'ft_installer_scripts');

// check if uploads folder exists and pemrissions are set to write
function fticheckuploads(){

	$upload_dir = wp_upload_dir();
	
	if(is_dir($upload_dir['basedir']) && !is_writable($upload_dir['basedir'])):
	
		return true;
	
	elseif(!is_dir($upload_dir['basedir'])):
		
		return true;
	
	else:
		
		return false;
		
	endif;
}

// Get the id of a page by its name
function ft_get_page_id($page_name){
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."' AND post_type='page'");
	return $page_name;
}

function fti_themeoptions(){
				
	// default options array
	$optionval = 'a:7:{s:16:"ft_colour_scheme";s:5:"Light";s:14:"ft_custom_logo";s:0:"";s:13:"ft_custom_css";s:0:"";s:17:"ft_custom_favicon";s:0:"";s:10:"ft_rss_url";s:0:"";s:16:"ft_tracking_code";s:0:"";s:19:"ft_footer_copyright";s:0:"";}';
	
	global $wpdb;
	$wpdb->query("UPDATE $wpdb->options SET option_value='".$optionval."' WHERE option_name = 'foliogridpro'");
}

function fti_widgets(){

	// set widgets to sidebars
	$sidebars = get_option("sidebars_widgets");
	$sidebars["sidebar"] = array("twitterwidget-2");
	update_option("sidebars_widgets",$sidebars);
	
	// widget_twitterwidget
	$widget_twitterwidget = get_option("widget_twitterwidget");
	$widget_twitterwidget[2] = array("title" => "Twitter", "ft_twittter_user" => "frogsthemes");
	$widget_twitterwidget["_multiwidget"] = 1;
	update_option("widget_twitterwidget",$widget_twitterwidget);

}

function fti_importcontent(){

	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	
	require_once ABSPATH . 'wp-admin/includes/import.php';
	
	$importer_error = false;
	
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	
		if ( file_exists( $class_wp_importer ) )
		{
			require_once($class_wp_importer);
		}
		else
		{
			$importer_error = true;
		}
	}
	
	if ( !class_exists( 'WP_Import' ) ) {
		$class_wp_import = TEMPLATEPATH . '/functions/ft-installer/importer/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) )
			require_once($class_wp_import);
		else
			$importerError = true;
	}
	
	if($importer_error)
	{
		die("Error in import :(");
	}
	else
	{
		if ( class_exists( 'WP_Import' )) 
		{
			include_once('importer/class.frogsthemes-importer.php');
		}
	
		if(!is_file(TEMPLATEPATH."/functions/ft-installer/frogsthemes_content_no_images.xml"))
		{
			echo "The XML file containing the dummy content is not available or could not be read in <pre>".TEMPLATEPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your themes folder: frogsthemes_content.xml) manually <a href='/wp-admin/import.php'>here.</a>";
		}
		else
		{
			$wp_import = new frogsthemes_import();
			$wp_import->fetch_attachments = true;
			$wp_import->import(TEMPLATEPATH."/functions/ft-installer/frogsthemes_content_no_images.xml");
			$wp_import->saveOptions();
		}
	}
}

function frogsthemes_installer() {
	$url = get_admin_url()."admin.php?page=frogsthemes_installer"; 
	?>
	<script type="text/javascript">
	
	jQuery(document).ready(function()
	{
		jQuery('.togglecont').slideUp(); // have options boxes closed as default
		
		<?php if($_GET["step"]=="createmenus"): ?>
		jQuery('.fti-currentinstall-step1 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step1 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="themeoptions"): ?>
		jQuery('.fti-currentinstall-step2 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step2 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="sliders"): ?>
		jQuery('.fti-currentinstall-step3 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step3 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="widgets"): ?>
		jQuery('.fti-currentinstall-step4 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step4 h3').addClass('active');
		<?php endif; ?>
		
		// opening and closing of options boxes on admin page
		jQuery('.fti-currentinstall-steps h3').click(function()
		{
			if(jQuery(this).next('.togglecont').css('display')=='none')
			{	
				jQuery(this).addClass('active');
			}
			else
			{	
				jQuery(this).removeClass('active');
			}
			jQuery(this).next('.togglecont').slideToggle('slow');
		});	
	});	
	
	</script>
	<div id="of_container">
		<div id="header">
			<div class="logo">
				<h2><a href="http://www.frogsthemes.com" target="_blank">FrogsThemes.com</a></h2>
			</div>
			<div class="version">
				Theme Installer<br /><span>Version 1.0.0</span>
			</div>
			<div class="clear"></div>
        </div>
		<div id="ft-installer">
			<?php 
			if(isset($_GET["step"])) :
			
				if($_GET["step"]=="importcontent") : 
	   
					$complete_message = "Content is imported!";
					
					fti_themeoptions();
					fti_importcontent();
					fti_themeoptions();
					fti_widgets();
					
				endif;
				
				if($_GET["step"]=="themeoptions") : 
					
					$complete_message_2 = true;
					
					fti_themeoptions();
					
				endif;
		 
				if($_GET["step"]=="widgets") : 
					
					$complete_message_4 = true;
					
					fti_widgets();
					
				endif;
				
			endif; ?>
	
				
			<?php 
			if(fticheckuploads()): 
			
				?>
				
				<div class="fti-error">
				
				<h2>Before we begin!</h2>
				
					<p>We've noticed that your <a href="http://codex.wordpress.org/Settings_Media_SubPanel" target="_blank">uploads folder</a> isn't writeable. You need to change the permissions to '755'. Once complete come back and refresh this page.</p>
					<p class="smaller">---</p>
					<p class="smaller"><strong>I have no idea how to do this!</strong><br />
					That's ok we promise it's easy and shouldn't take you very long at all. WordPress shows you how to do it, simply visit <a href="http://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client" target="_blank">this page</a> and scroll down the page to the section 'Using an FTP Client'. Once complete come back to this page and refresh the page.</p>
				
				</div>
				
				<?php
			
			else: ?>
				
				<div class="fti-installationtype">
					
					<h2>Pick your installation type</h2>
					
					<div class="fti-newinstall">
						<a href="<?php echo $url."&amp;route=fti-newinstall"; ?>"<?php if($_GET['route']=='fti-newinstall'): echo ' class="selected"'; endif; ?><?php if($_GET['route']=='fti-currentinstall'): echo ' class="oppselected"'; endif; ?>>
						<span>I'm installing this theme on a brand new website</span>
						Choose this installation type if this 
						website is a brand new website with
						a fresh installation of WordPress.
						</a>
					</div>
					
					<div class="fti-currentinstall">
						<a href="<?php echo $url."&amp;route=fti-currentinstall"; ?>"<?php if($_GET['route']=='fti-currentinstall'): echo ' class="selected"'; endif; ?><?php if($_GET['route']=='fti-newinstall'): echo ' class="oppselected"'; endif; ?>>
						<span>I'm installing this theme on my existing website</span>
						Choose this installation type if this 
						website already has live content like 
						pages, posts and comments.
						</a>
					</div>
					
				</div>
				
				<?php if(!$_GET['route']): ?>
				<div class="fti-intro">
				
					<h1>Welcome to the FrogsThemes Theme installer</h1>
					
					<p>The installer is the perfect solution for everybody who's in a hurry and doesn't have time to read the docs or wait for support. With a few clicks your new theme will be installed and looking great. There are a few things you need to consider before using this installer. Each section has it's own explanation, useful links and warnings. Please read them carefully before clicking on any buttons.</p>
					<p><br /><strong>First, please choose an installation type above to start installing...</strong></p>
				
				</div>
				<?php endif; ?>
				
				<?php if($_GET['route']=='fti-newinstall'): ?>
				
					<div class="fti-intro">
						<h1>Our famous 1-click installer</h1>
						
						<p>Setup your brand new WordPress website with just a click of a button. Just click the green button below and let our famous 1-click installer do all the hard work. The installer will import dummy content, setup your theme options, build your custom menus, set your widgets and create some homepage banners. Once it has finished feel free to look around the options in the left column and delete the dummy data once you're more familiar with the theme.</p>
					</div>
					
					<div class="fti-newinstall-steps">
					
						<?php if(get_option("fti_content_added")): ?>
						
							<div class="success">Your website has been setup successfully.</div>
						
						<?php else: ?>
						
							<div class="fti-newinstall-step1">
								<div class="fti-stage-importcontent">
									<div class="fti-1clickdiv">
										<div class="fti-1clickdivinner">
											<a href="<?php echo $url."&amp;route=fti-newinstall&amp;step=importcontent"; ?>" class="fti-button" onclick="return confirm('Are you sure you wish to continue and import dummy content to your site?');">Install this theme in 1-click</a>
										</div>
									</div>
									<div class="fti-information">
										<h2>Important Information</h2>
										<p>Do not use this installer if you already have an active website. Instead click on the other tab above and install the elements separately. </p>
									</div>
								</div>
							</div>
					
						<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if($_GET['route']=='fti-currentinstall'): ?>
				<div class="fti-currentinstall-steps">
					<div class="fti-currentinstall-step2">
						<div class="fti-stage-themeoptions">
							<h3><a href="#" onclick="javascript:return false;">Step 1 - Theme Options</a></h3>

							<div class="togglecont">
								
								<p>This step sets the default options for the theme found under '<a href="<?php echo get_admin_url()."admin.php?page=frogsthemes"; ?>">Theme Options</a>'.
								<br />It can be run at any time, but will reset any changes you have made.
								<br /><strong>Note:</strong> You may need to select your front page and posts page under 'front page displays' on the page <a href="<?php echo get_admin_url()."options-reading.php"; ?>">SETTINGS -> READING</a></p>
								
								<?php if($complete_message_2!=''): ?>
								<div class="success">Theme options are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=themeoptions"; ?>" class="fti-button" onclick="return confirm('Click OK to reset. Any theme settings will be lost!');">Set theme option defaults!</a>
									</div>
								</div>
								<?php endif; ?>
								
							</div>
							
						</div>
					</div>
					<div class="fti-currentinstall-step4">
						<div class="fti-stage-widgets">
							<h3><a href="#" onclick="javascript:return false;">Step 2 - Widgets</a></h3>
							
							<div class="togglecont">
								
								<p>This step creates and places widgets in designated spots around the site for you.
								<br />Running this will archive any current widgets you have.</p>
								
								<?php if($complete_message_4!=''): ?>
								<div class="success">Widgets are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=widgets"; ?>" class="fti-button" onclick="return confirm('Click OK to reset. Any widgets already placed added will be lost!');">Set dummy widgets for widget areas!</a>
									</div>
								</div>
								<?php endif; ?>
								
							</div>
							
						</div>
					</div>
					<div class="fti-currentinstall-step5">
						<div class="fti-stage-thumbnails">
							<h3 class="fti-last"><a href="#" onclick="javascript:return false;">Step 3 - Image Regeneration</a></h3>
							
							<div class="togglecont">
							
								<p>You may need to resize your images to fit into the theme. For this we advise you install and run the Regenerate Thumbnails plugin, which can be <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">found here</a>.</p>
							
							</div>
							
						</div>
					</div>
					<br />&nbsp;
					<div class="fti-information">
						<h2>Important Information</h2>
						<p>The installer has been split into 3 separate steps to allow ultimate control over what you will install. Each step is voluntary and is designed to help you get the theme setup in as little time as possible. You can work through and install each step or choose which steps to install, it's completely up to you.</p>
					</div>
				<?php endif; ?>
				<?php endif; // fticheckuploads() ?>
			</div>
		</div>
		<?php 
	} 
?>