<?php

/*
*
* Author: FrogsThemes
* File: include all classes functions, includes and components
*
*
*/

define('CONCATENATE_SCRIPTS', false);

// allow post thumbnails
add_theme_support( 'post-thumbnails', array( 'post' ) ); // Add it for posts
set_post_thumbnail_size( 220, 161, true );
add_image_size( 'post', 200, 9999 );
add_image_size( 'twocols', 430, 9999 );
add_image_size( 'threecols', 660, 9999 );

// theme specific functions
include TEMPLATEPATH . '/functions/theme-functions.php';

// admin functions
include TEMPLATEPATH . '/functions/post-functions.php';

// FT widgets
include TEMPLATEPATH . '/functions/widget-twitter.php';
include TEMPLATEPATH . '/functions/widget-dashboard-feed.php';

// theme specific options page
include TEMPLATEPATH . '/functions/admin-options.php';

// theme options framework
define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/functions/admin/');
define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/functions/admin/');
include TEMPLATEPATH . '/functions/admin/options-framework.php';

// ft installer
include TEMPLATEPATH . '/functions/ft-installer/ft-installer.php';

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s widget">',
		'after_widget' => '</div>',
		'before_title' => '<span class="widget-title">',
		'after_title' => '</span>'
	) );
}

add_action('wp_head', 'frogs_wp_head');
add_action('wp_footer', 'frogs_wp_footer');
#add_action('admin_init', 'frogs_add_init');
#add_action('admin_menu', 'frogs_add_admin');
add_action('init', 'frogs_init');

?>