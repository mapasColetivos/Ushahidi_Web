<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if lte IE 7]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/library/ie.css" type="text/css" media="screen, projection" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/library/ie8.css" type="text/css" media="screen, projection" /><![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
<?php 
// pull from theme options
global $blog_ID;
$blog_cat = html_entity_decode(get_option('T_blog_cat'));
$blog_ID = get_cat_ID($blog_cat);
?>
<?php if ( is_single() ) {
		if ( !in_category($blog_ID) ) { ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.gallery.js"></script>
<?php } } ?>
<script type="text/javascript">
jQuery(document).ready(function() { 
    jQuery('ul.sf-menu').superfish({ 
        delay:       500,                            // one second delay on mouseout 
        animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
        speed:       'fast',                          // faster animation speed 
        autoArrows:  false,                           // disable generation of arrow mark-up 
        dropShadows: true                            // disable drop shadows 
    });
});
jQuery(function(){
	//portfolio thumb fadein fadeout
	jQuery('#content div.portfolio').hover(function(){
		jQuery(this).find('img').fadeOut();
	}, function(){
		jQuery(this).find('img').fadeIn();
	});
	<?php if ( is_single() ) {
		if ( !in_category($blog_ID) ) { ?>
			jQuery('#gallery').gallery();
	<?php } } ?>

});
</script>
</head>

<body <?php body_class(); ?>>
<div class="container_12">
<div id="header" class="grid_12">
	<div id="logo">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<span class="description"><?php bloginfo('description'); ?></span>	
	</div>
 	<?php if(function_exists('get_search_form')) : ?>
		<?php get_search_form(); ?>
		<?php else : ?>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	<?php endif; ?>

	<?php wp_nav_menu('theme_location=main-menu&container=false&menu_class=sf-menu'); ?>
	
</div>	
<hr class="grid_12" />
