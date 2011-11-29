<?php

// constants paths
define('WL_PATH', dirname(__FILE__));

// constants URIs
define('WL_URI', get_bloginfo('template_directory') . '/functions/wizylike');
define('WL_CSSURI', WL_URI . '/css');
define('WL_JSURI', WL_URI . '/js');
define('WL_IMGURI', WL_URI . '/images');


// Calls database global
global $wpdb, $wl_tablename;


// Combines default db tables prefix with our newly tabel name
$wl_tablename = $wpdb->prefix . 'ft_like';


// includes plugin files
require_once(WL_PATH . '/widget.wizylike.php');			// Sidebar widget


// Runs when the plugin is activated
function wizylike_activate() {
	global $wpdb, $wl_tablename;
	
	if (!empty($wpdb->charset))
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		
		// run the SQL statement on the database
		$wpdb->query("CREATE TABLE {$wl_tablename} (
							id BIGINT(20) NOT NULL AUTO_INCREMENT,
							post_id BIGINT(20) NOT NULL,
							ip_address VARCHAR(25) NOT NULL,
							user_id BIGINT(20) NOT NULL,
							like_status VARCHAR(25) NOT NULL DEFAULT 'like',
							PRIMARY KEY (id), 
							UNIQUE (id)
							){$charset_collate};");
		
		$wpdb->query("ALTER TABLE `$wpdb->posts` ADD `like_count` BIGINT( 20 ) NOT NULL DEFAULT  '0'");
	
	update_option('wizylike_capabilities', 'all');
	update_option('wizylike_colour', 'red');
	update_option('wizylike_style', 'style_1');
	update_option('wizylike_like_txt', 'Like?');
	update_option('wizylike_unlike_txt', 'Unlike!');
	update_option('wizylike_widget_txt', 'Likes');
	
	
}
add_action('after_setup_theme', 'wizylike_activate');
#wp_register_theme_activation_hook($themename, 'my_theme_activate');
#register_activation_hook(__FILE__, 'wizylike_activate');


// register functions
add_action('init', 'wizylike_init');

// wizylike front-end init
function wizylike_init(){
	
	// includes main class
	require_once(WL_PATH . '/class.wizylike.php');
	
	// includes template tags for ease of usage
	require_once(WL_PATH . '/template-tags.php');

}

// wizylike front-end head
function wizylike_head(){
	$js = '<script type="text/javascript"> var wizylike_url = "' . get_bloginfo('template_directory') . '/functions/wizylike/index.php"; </script>' . "\n";
	echo apply_filters('wizylike_head', $js);
	
	do_action('wizylike_head');
}
add_action('wp_head', 'wizylike_head');

?>