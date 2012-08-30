<?php global $gpp; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

    <title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ); ?></title>

	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	
	<?php if(is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
    <?php }?>
    
<!-- BeginStyle -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/print.css" type="text/css" media="print" />
	<!--[if IE]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen, projection" /><![endif]-->
<!-- EndStyle -->

<!-- Conditional Javascripts -->
	<!--[if IE 6]>
	<script src="<?php bloginfo('template_directory'); ?>/includes/js/pngfix.js"></script>
	<![endif]-->
<!-- End Conditional Javascripts -->

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( $gpp['gpp_feedburner_url'] <> "" ) { echo $gpp['gpp_feedburner_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

</head>
<body <?php body_class(); ?>>

<!-- BeginHeader -->
<div id="top">
<?php	
	wp_nav_menu( 'theme_location=top-menu&sort_column=menu_order&container_id=nav-wrap-top&menu_class=sf-menu&fallback_cb=' );	
?>
</div>

<div class="container">
<div class="container-inner">

<div id="masthead">
        <div id="logo">
            <h1 class="sitename"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><?php if($gpp['gpp_logo_off']=="true") { ?><img class="sitetitle" src="<?php if ( $gpp['gpp_logo'] <> "" ) { echo $gpp['gpp_logo']; } else { bloginfo('stylesheet_directory'); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" /><?php  } else { bloginfo('name'); } ?></a></h1>
            <div class="description"><?php bloginfo('description'); ?></div>
            <?php get_search_form(); ?>
        </div>
</div>
<div class="clear"></div>

<!-- EndHeader -->

<?php if (is_home()) { ?>

<?php if ( !$gpp || $gpp['gpp_slideshow'] == 'true' || $gpp['gpp_slideshow'] === FALSE ) { include (TEMPLATEPATH . '/apps/slideshow.php'); } ?>

<?php if ( $gpp['gpp_video'] == 'true' ) { include (TEMPLATEPATH . '/apps/video-home.php'); } ?>

<?php } ?>

<!-- BeginHeader -->

<?php	
	wp_nav_menu( 'theme_location=main-menu&sort_column=menu_order&container_id=nav-main&menu_class=sf-menu&fallback_cb=' );	
?>

<!-- EndHeader -->

<!-- BeginContent -->