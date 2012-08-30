<?php

/*
Plugin Name: FT Tabbed Widget
Plugin URI: http://www.frogsthemes.com
Description: Add a tabbed widget to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class TabbedWidget extends WP_Widget {
    
	/** constructor */
    function TabbedWidget() {
        
		$options = array( 'description' => __('Add a tabbed widget to your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Tabbed Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
    	
		global $wpdb;
		extract( $args );

		/* Our variables from the widget settings. */
		$tab1 = $instance['tab1'];
		$tab2 = $instance['tab2'];
		$tab3 = $instance['tab3'];
		$tab4 = $instance['tab4'];

		//Randomize tab order in a new array
		$tab = array();
		
		?>
        
		<div class="tab-wrap">
			<ul class="tabs">
				<li id="firsttab"><a href="#tab1"><?php echo $tab1; ?></a></li>
				<li><a href="#tab2"><?php echo $tab2; ?></a></li>
				<li><a href="#tab3"><?php echo $tab3; ?></a></li>
				<li id="lasttab"><a href="#tab4"><?php echo $tab4; ?></a></li>
			</ul>
			
			<div class="tab_container">
				<div id="tab1" class="tab_content">
					<ul class="tab-posts">
						<?php 
						$popPosts = new WP_Query();
						$popPosts->query('caller_get_posts=1&posts_per_page=5&orderby=comment_count');
						while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
                        
                        <li>
                        	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
                            <div class="tab-post-thumb">
                                <a href="<?php the_permalink(); ?>" class="f-thumb"><?php the_post_thumbnail('thumb45'); ?></a>
                            </div><!--image-->
							<?php else: ?>
							<div class="tab-post-thumb">
                                <a href="<?php the_permalink(); ?>" class="f-thumb"><img src="<?php bloginfo('template_directory'); ?>/assets/images/sml1.jpg" alt="thumb" /></a>
                            </div><!--image-->
                            <?php endif; ?>
                            
                            <div class="tab-post-info">
                                <h3 class="tab-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="tab-post-details"><?php the_time( get_option('date_format') ); ?>&nbsp;&nbsp;//&nbsp;&nbsp;<?php comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></div>
                            </div><!--details-->
                        </li>
                        
                        <?php endwhile; ?>
                        <?php wp_reset_query(); ?>
						
					</ul>
				</div>
				<div id="tab2" class="tab_content">
				   <ul class="tab-posts">
						<?php
						
						$recentPosts = new WP_Query();
						$recentPosts->query('caller_get_posts=1&posts_per_page=5');
						while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
                       
                        <li>
                        	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
                            <div class="tab-post-thumb">
                                <a href="<?php the_permalink(); ?>"class="f-thumb"><?php the_post_thumbnail('thumb45'); ?></a>
                            </div><!--image-->
							<?php else: ?>
							<div class="tab-post-thumb">
                                <a href="<?php the_permalink(); ?>" class="f-thumb"><img src="<?php bloginfo('template_directory'); ?>/assets/images/sml1.jpg" alt="thumb" /></a>
                            </div><!--image-->
                            <?php endif; ?>
                            
                            <div class="tab-post-info">
                                <h3 class="tab-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="tab-post-details"><?php the_time( get_option('date_format') ); ?>&nbsp;&nbsp;//&nbsp;&nbsp;<?php comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></div>
                            </div><!--details-->
                        </li>
                        
                        <?php endwhile;?>
						<?php wp_reset_query(); ?>
						
					</ul>
				</div>
				<div id="tab3" class="tab_content">
				   <ul class="tab-posts">
						<?php 
						$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
						$comments = $wpdb->get_results($sql);
						foreach ($comments as $comment) :
						?>
                        <li>
                            <div class="tab-post-thumb">
                                <a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'framework'); ?><?php echo $comment->post_title; ?>" class="f-thumb"><?php echo get_avatar( $comment, '45' ); ?></a>
                            </div><!--image-->
                            
                            <div class="tab-post-info">
                                <h3 class="tab-post-title"><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'framework'); ?><?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?></a></h3>
                            </div><!--details-->
                        </li>

                        <?php endforeach; ?>
                        <?php wp_reset_query(); ?>
						
					</ul>
				</div>
				<div id="tab4" class="tab_content">
				  <div class="tag-cloud">
					  <?php wp_tag_cloud( array( 'largest' => '12', 'smallest' => '12', 'unit' => 'px' ) ); ?>
				  </div>
				  <?php wp_reset_query(); ?>
				</div>
			</div>
		</div>
		
		<?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* No need to strip tags */
		$instance['tab1'] = $new_instance['tab1'];
		$instance['tab2'] = $new_instance['tab2'];
		$instance['tab3'] = $new_instance['tab3'];
		$instance['tab4'] = $new_instance['tab4'];
		
		return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		
		$defaults = array(
		'tab1' => 'Popular',
		'tab2' => 'Recent',
		'tab3' => 'Comments',
		'tab4' => 'Tags',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- tab 1 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Tab 1 Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $instance['tab1']; ?>" />
		</p>
		
		<!-- tab 2 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Tab 2 Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $instance['tab2']; ?>" />
		</p>
		
		<!-- tab 3 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e('Tab 3 Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo $instance['tab3']; ?>" />
		</p>
		
		<!-- tab 4 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Tab 4 Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab4' ); ?>" name="<?php echo $this->get_field_name( 'tab4' ); ?>" value="<?php echo $instance['tab4']; ?>" />
		</p>
        <?php
	}

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("TabbedWidget");'));


?>