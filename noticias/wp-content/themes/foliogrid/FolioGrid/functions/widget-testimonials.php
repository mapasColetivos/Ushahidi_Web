<?php

/*
Plugin Name: FT Testimonial Widget
Plugin URI: http://www.frogsthemes.com
Description: A widget to add your testimonials to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class TestimonialsWidget extends WP_Widget {
    
	/** constructor */
    function TestimonialsWidget() {
        
		$options = array( 'description' => __('A widget to add your testimonials to your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Testimonial Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$poststoshow = apply_filters('widget_title', $instance['poststoshow']);
		$postorder = apply_filters('widget_title', $instance['postorder']);
		$postorderdesc = apply_filters('widget_title', $instance['postorderdesc']);
		
		if(!$poststoshow):
			$poststoshow = 5;
		endif;
		
		if(!$postorder):
			$postorder = 'rand';
		endif;
		
		if(!$postorderdesc):
			$postorderdesc = 'DESC';
		endif;
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		
		<ul class="slider-nav">
			<li><a href="#" id="prev5">&larr;</a></li>
			<li><a href="#" id="next5">&rarr;</a></li>
		</ul>
		<div id="testimonials-sb">
			<?php 
			//get latest blog articles
			global $post;
			$portposts = get_posts(array( 'post_type' => 'testimonials', 'order' => $postorderdesc, 'numberposts' => $poststoshow, 'orderby' => $postorder));
			
			if (isset($portposts)) : 
				
				foreach( $portposts as $post ) : setup_postdata($post);
				  	
					?>
					<div class="slide">
						<blockquote><?php the_content(); ?></blockquote>
						<?php if(get_post_meta($post->ID, '_wp_testimonee', true)): ?>
						<p><?php echo get_post_meta($post->ID, '_wp_testimonee', true); ?></p>
						<?php endif; ?>
					</div>
					<?php
				
				endforeach;
				
			endif;
			
			?>
		</div>

		<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['poststoshow'] = strip_tags($new_instance['poststoshow']);
	$instance['postorder'] = strip_tags($new_instance['postorder']);
	$instance['postorderdesc'] = strip_tags($new_instance['postorderdesc']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
		$poststoshow = esc_attr($instance['poststoshow']);
		$postorder = esc_attr($instance['postorder']);
		$postorderdesc = esc_attr($instance['postorderdesc']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('poststoshow'); ?>"><?php _e('Number of testimonials to show:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('poststoshow'); ?>" name="<?php echo $this->get_field_name('poststoshow'); ?>" type="text" value="<?php echo $poststoshow; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('postorder'); ?>"><?php _e('Order by:'); ?></label> 
          <select name="<?php echo $this->get_field_name('postorder'); ?>" class="" id="<?php echo $this->get_field_id('postorder'); ?>">
		  	<option value="none" <?php if($poststoshow == 'none'): ?>selected="selected"<?php endif; ?>>None</option>
			<option value="ID" <?php if($poststoshow == 'ID'): ?>selected="selected"<?php endif; ?>>ID</option>
			<option value="title" <?php if($poststoshow == 'title'): ?>selected="selected"<?php endif; ?>>Title</option>
			<option value="date" <?php if($poststoshow == 'date'): ?>selected="selected"<?php endif; ?>>Date Published</option>
			<option value="modified" <?php if($poststoshow == 'modified'): ?>selected="selected"<?php endif; ?>>Date Modified</option>
			<option value="rand" <?php if($poststoshow == 'rand'): ?>selected="selected"<?php endif; ?>>Random</option>
		  </select>
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('postorderdesc'); ?>"><?php _e('Order:'); ?></label> 
          <select name="<?php echo $this->get_field_name('postorderdesc'); ?>" class="" id="<?php echo $this->get_field_id('postorderdesc'); ?>">
		  	<option value="DESC" <?php if($postorderdesc == 'DESC'): ?>selected="selected"<?php endif; ?>>Descending</option>
			<option value="ASC" <?php if($postorderdesc == 'ASC'): ?>selected="selected"<?php endif; ?>>Ascending</option>
		  </select>
        </p>
        <?php
	}

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("TestimonialsWidget");'));


?>