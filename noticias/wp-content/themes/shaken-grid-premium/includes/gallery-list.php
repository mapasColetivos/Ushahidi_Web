<?php
/**
 * Gallery List
 *
 * This file outputs a list of links to each 
 * image attached to a post. This is used in loop.php
 * when a "Gallery" post is being shown and the
 * slideshow is hidden.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.6
 * @alter        2.0
 *
 */

// 1. find images attached to this post
global $post;
$args = array(
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'numberposts' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'post_parent' => $post->ID
);
$images = get_posts($args);

if($images):
?>
<div class="gallery-link-list">
    <?php // 2. Loop through the images and show them
	foreach($images as $image)
	{
		if($image->ID != get_post_thumbnail_id($post->ID)):
			$big_array = image_downsize( $image->ID, 'full' );
			$img_url = $big_array[0];
			echo '<a href="'.$img_url.'" rel="'.$post->ID.'" title="'.$post->post_title.'" class="colorbox">';
			echo $image->post_title;
			echo '</a>';
		endif;
	}
   ?>
</div><!-- gallery-link-list -->
<?php endif; ?>