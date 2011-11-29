<?php

/*
Plugin Name: FT Archive Widget
Plugin URI: http://www.frogsthemes.com
Description: A styled monthly archive of your site's posts.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class FTArchiveWidget extends WP_Widget {
    
	/** constructor */
    function FTArchiveWidget() {
        
		$options = array( 'description' => __('A styled monthly archive of your site\'s posts.') );
		
		parent::WP_Widget(false, $name = 'FT Archive Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
		$title = apply_filters('widget_title', $instance['title']);

		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		
		<ul class="widget-ul">
			<?php 
			//get blogroll
			$args = array(
							'type'            => 'monthly',
							'show_post_count' => false,
							'echo'            => 1
						);
			
			wp_get_archives( $args );
			
			?>
			<?php wp_reset_query(); ?>
		</ul>
		
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
add_action('widgets_init', create_function('', 'return register_widget("FTArchiveWidget");'));


?>