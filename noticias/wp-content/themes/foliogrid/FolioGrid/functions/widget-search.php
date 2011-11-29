<?php

/*
Plugin Name: FT Search Widget
Plugin URI: http://www.frogsthemes.com
Description: A styled search form for your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class SearchWidget extends WP_Widget {
    
	/** constructor */
    function SearchWidget() {
        
		$options = array( 'description' => __('A styled search form for your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Search Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<!-- Search -->
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="top-search">
			<input type="text" name="s" value="Search and hit enter" class="search-input clearme" />
		</form>
		<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
		
		?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
	}

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("SearchWidget");'));


?>