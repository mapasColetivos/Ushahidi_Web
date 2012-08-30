<?php

/*
Plugin Name: FT Blogroll Widget
Plugin URI: http://www.frogsthemes.com
Description: A widget to add your blogroll to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class BlogrollWidget extends WP_Widget {
    
	/** constructor */
    function BlogrollWidget() {
        
		$options = array( 'description' => __('A widget to add your blogroll to your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Blogroll Widget', $options);
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
						'orderby'        => 'name', 
						'order'          => 'ASC',
						'limit'          => -1);
			
			$bookmarks = get_bookmarks( $args );
			
			if(count($bookmarks) > 0):
				
				foreach( $bookmarks as $bookmark ):
				  
					?>
					<li><a href="<?php echo $bookmark->link_url; ?>" target="<?php echo $bookmark->link_target; ?>"><?php echo $bookmark->link_name; ?></a></li>
					<?php
				
				endforeach;
				
			endif;
			
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
add_action('widgets_init', create_function('', 'return register_widget("BlogrollWidget");'));


?>