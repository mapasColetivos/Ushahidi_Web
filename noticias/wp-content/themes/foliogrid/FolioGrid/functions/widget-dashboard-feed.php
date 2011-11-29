<?php

/*
Plugin Name: FT Dash Feed Widget - For theme dashboard
Plugin URI: http://www.frogsthemes.com
Description: This pulls out our latest blog articles for reading on the dasboard in WP Admin.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


add_action('wp_dashboard_setup', 'ft_dashboard_widgets');

function ft_dashboard_widgets() {
     global $wp_meta_boxes;
     wp_add_dashboard_widget( 'dashboard_custom_feed', 'FrogsThemes.com' , 'ft_dashboard_custom_feed_output' );
}

function ft_dashboard_custom_feed_output() {
     echo '<div class="rss-widget">';
     wp_widget_rss_output(array(
          'url' => 'http://blog.frogsthemes.com/feed/',
          'title' => 'MY_FEED_TITLE',
          'items' => 3,
          'show_summary' => 1,
          'show_author' => 0,
          'show_date' => 1
     ));
     echo '</div>';
}

?>