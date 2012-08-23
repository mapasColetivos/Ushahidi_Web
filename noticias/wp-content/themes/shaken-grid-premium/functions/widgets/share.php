<?php
class shareWidget extends WP_Widget {
	
function shareWidget() {
		$widget_ops = array( 'description' => __('Add social bookmarking links for users to share your blog post') );
		parent::WP_Widget(false, __('Shaken - Share Buttons'), $widget_ops );
		
	} #sharewidget
	
function form($instance) {
		$title = esc_attr($instance['title']);
		
		?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'shaken'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<?php
	}// #form
	
function update($new_instance, $old_instance) {
		// processes widget options to be saved
		return $new_instance;
	} //#update
	
function widget($args, $instance) {
	
		extract( $args );
		
		// outputs the content of the widget
		if( !$instance["title"] )
		$instance["title"] = "Tell Your Friends";
		
		$title = $instance['title'];
		?>
        
        
        <?php echo $before_widget . $before_title . $title . $after_title; ?>
        	<div class="share-icons">
		        <?php if( of_get_option('twitter') ):
	                $twitRec = of_get_option('twitter');
	            else:
	                $twitRec = ''; 
	            endif; ?>

				<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php urlencode(get_permalink()); ?>" data-text="<?php the_title_attribute(); ?>" data-count="horizontal" data-via="<?php echo $twitRec; ?>">Tweet</a>
				<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				
				<iframe src="http://www.facebook.com/plugins/like.php?app_id=179762912095902&amp;href=<?php urlencode(the_permalink()); ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>

          	</div>
        <?php echo $after_widget; ?>
    <?php
	} // #widget
	
} // class

register_widget('shareWidget');
?>
