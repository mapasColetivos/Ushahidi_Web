<?php
/**
 * Slideshow
 *
 * This file outputs a group of all images attached to
 * a post which will be displayed as a slideshow. This is
 * used in loop.php when a post has a post format
 * of "Gallery" assigned to it.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.6
 * @alter        1.6.2
 *
 */

// 1. find images attached to this post
global $post;
global $my_size;

if($my_size == 'col1'){ $my_size = array( 135, 105 ); }
else if($my_size == 'col2'){ $my_size = array( 320, 225 ); }
else if($my_size == 'col3'){ $my_size = array( 495, 340 ); }
else{ $my_size = array( 670, 455 ); }

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
<div class="slider-container">
<div class="slider">
    <div class="slides_container">
        <?php // 2. Loop through the images and show them
		foreach($images as $image)
		{
			$big_array = image_downsize( $image->ID, 'full' );
 			$img_url = $big_array[0];
			echo '<a href="'.$img_url.'" rel="'.$post->ID.'" title="'.$post->post_title.'" class="colorbox">';
			echo wp_get_attachment_image($image->ID, $my_size);
			echo '</a>';
		}
       ?>
        
    </div><!-- #slides_container -->
    <a href="#" class="prev"><img src="<?php echo get_template_directory_uri(); ?>/images/left-ar.png" width="28" height="28" alt="Prev"></a>
    <a href="#" class="next"><img src="<?php echo get_template_directory_uri(); ?>/images/right-ar.png" width="28" height="28" alt="Next"></a>
</div><!-- #slider -->
</div><!-- slider-container -->
<?php endif; ?>