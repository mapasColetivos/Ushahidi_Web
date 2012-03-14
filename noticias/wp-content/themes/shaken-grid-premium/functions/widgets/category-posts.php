<?php
/*
Plugin Name: Category Posts Widget
Plugin URI: http://jameslao.com/2009/12/30/category-posts-widget-3-0/
Description: Adds a widget that can display posts from a single category.
Author: James Lao	
Version: 3.1
Author URI: http://jameslao.com/
*/

// Register thumbnail sizes.
if ( function_exists('add_image_size') )
{
	$sizes = get_option('jlao_cat_post_thumb_sizes');
	if ( $sizes )
	{
		foreach ( $sizes as $id=>$size )
			add_image_size( 'cat_post_thumb_size' . $id, $size[0], $size[1], true );
	}
}

class shaken_CategoryPosts extends WP_Widget {

function shaken_CategoryPosts() {
	parent::WP_Widget(false, $name='Shaken - Category Posts');
}

/**
 * Displays category posts widget on blog.
 */
function widget($args, $instance) {
	global $post;
	$post_old = $post; // Save the post object.
	
	extract( $args );
	
	$sizes = get_option('jlao_cat_post_thumb_sizes');
	
	// If not title, use the name of the category.
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}
	
	// Get array of post info.
	$cat_posts = new WP_Query("showposts=" . $instance["num"] . "&cat=" . $instance["cat"]);

	echo $before_widget;
	
	// Widget title
	echo $before_title;
	if( $instance["title_link"] )
		echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>';
	else
		echo $instance["title"];
	echo $after_title;
	echo "<ul class='cat-posts'>\n";
	// The Posts
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
	?>
		<li class="cat-post-item">
        	
            <?php
            	$soy_video_url = get_post_meta($post->ID, 'soy_vid_url', true);
				if($soy_video_url){
					$vid_src = shaken_get_image_url($soy_video_url);
				} else{
					$vid_src = false;
				}
            	
				$args = array(
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'numberposts' => 1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post_parent' => $post->ID
				);
				$images = get_posts($args);
				$first_attachment = '';
				$first_attachment = wp_get_attachment_image($images[0]->ID, 'sidebar');
				
				if($first_attachment || has_post_thumbnail() || $soy_video_url):
			?>
			<div class="post-thumb">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php 
				if(has_post_thumbnail()){
					the_post_thumbnail('sidebar');
				} else if($soy_video_url){
					echo "<img src='$vid_src' />";
				} else {
					echo $first_attachment;
				}
				?>
				</a>
			</div>
			<?php endif; ?>

			<div class="post-info">
				<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p><?php _e('Posted in', 'shaken'); ?>: <?php the_category(', '); ?></p>
			</div>
            
            <div class="clearfix"></div>
		</li>
	<?php
	}
	
	echo "</ul>\n";
	echo $after_widget;

	$post = $post_old; // Restore the post object.
}

/**
 * Form processing... Dead simple.
 */
function update($new_instance, $old_instance) {
	
	return $new_instance;
}

/**
 * The configuration form.
 */
function form($instance) {
?>
	<p>
		<label for="<?php echo $this->get_field_id("title"); ?>">
			<?php _e( 'Title', 'shaken' ); ?>:
			<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</label>
	</p>
	
	<p>
		<label>
			<?php _e( 'Category', 'shaken' ); ?>:
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id("num"); ?>">
			<?php _e('Number of posts to show', 'shaken'); ?>:
			<input style="text-align: center;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo absint($instance["num"]); ?>" size='3' />
		</label>
	</p>
<?php

}

}

add_action( 'widgets_init', create_function('', 'return register_widget("shaken_CategoryPosts");') );

?>
