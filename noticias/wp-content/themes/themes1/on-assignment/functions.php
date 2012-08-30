<?php

// Define Theme Options Variables
$themename="On-Assignment";
$thumbnailsize = "270 x 150 pixels";
$gppslideshow = "true";
$thumbslider = "false";
$featured = "true";
$category_columns = "true";
$default_thumb = get_bloginfo('stylesheet_directory') . "/images/default-thumb.jpg";

add_action( 'init', 'register_oa_menus' );

function register_oa_menus() {
	register_nav_menus(
		array(
			'top-menu' => __( 'Top Menu' )
		)
	);
}

?>