<?php
/**
 * Gallery Grid
 *
 * This file outputs a group of all images attached to
 * a post in a grid layout. This is used in single.php
 * when the post has the "Gallery" post format assigned
 * to it.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.6
 * @alter        1.6.2
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
<div class="gallery-thumbs">
        <?php // 2. Loop through the images and show them
		foreach($images as $image)
		{
			$big_array = image_downsize( $image->ID, 'full' );
 			$img_url = $big_array[0];
			echo '<a href="'.$img_url.'" rel="gallery" title="'.$image->post_title.'" class="gallery-thumb">';
			echo wp_get_attachment_image($image->ID, $size='gallery');
			echo '<span class="enlarge-ic">Enlarge</span></a>';
		}
       ?>
</div>
<?php endif; ?>