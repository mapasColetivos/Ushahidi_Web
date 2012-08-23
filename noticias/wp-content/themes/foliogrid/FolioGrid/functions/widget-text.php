<?php

/*
Plugin Name: FT Text Widget
Plugin URI: http://www.frogsthemes.com
Description: A widget to add text/HTML to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class TextWidget extends WP_Widget {
    
	/** constructor */
    function TextWidget() {
        
		$options = array( 'description' => __('A widget to add text/HTML to your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Text Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<?php echo $instance['text']; ?>
		<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['text'] = $new_instance['text'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
		$text = esc_attr($instance['text']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text/HTML:'); ?></label> 
          <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text"><?php echo $text; ?></textarea>
        </p>
        <?php
	}

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("TextWidget");'));


?>