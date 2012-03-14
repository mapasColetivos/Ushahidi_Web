<?php
/**
 * Action Buttons
 *
 * This file outputs the buttons that are displayed
 * when a user hovers over a post on the gallery pages
 *
 * @package      Shaken Grid (Premium)
 * @since        2.0
 * @alter        2.0
 *
 */
 
global $embed_code, $force_feat_img, $vid_url, $post; 
$thumbID = get_post_thumbnail_id($post->ID);
?>
<div class="actions<?php if ( ! comments_open() ){ echo ' comments-hidden'; } ?>">
    
    <?php 
    // Play / Enlarge
    if( ( $embed_code || $vid_url ) && $force_feat_img): ?>
        <a href="<?php the_permalink(); ?>" title="Play this video" class="view play">Play</a>

    <!-- <?php else: 
    	$img_rel = ( has_post_format('gallery')) ? $post->ID : 'gallery';
    ?>-->  

        <a href="<?php echo wp_get_attachment_url($thumbID); ?>" rel="<?php echo $img_rel; ?>" title="<?php the_title_attribute(); ?>" class="view colorbox">
       	<?php _e('Aumentar', 'shaken'); ?>	
        </a>
    <?php endif; ?>
     
    <a class="share"><?php _e('Compartilhar', 'shaken'); ?></a>  
 
     
    <?php 
    // Comment count
    if ( comments_open() ): ?>
        <a href="<?php comments_link(); ?>" class="comment"><span><?php comments_number('0', '1', '%'); ?></span> <?php _e('Comentar', 'shaken'); ?></a> 
    <?php endif; ?>

    <div class="share-container">
        <div class="share-icons">
            
            <?php if( of_get_option('twitter') ):
                $twitRec = '&via='.of_get_option('twitter');
            else:
                $twitRec = ''; 
            endif; ?>
            
            <a href="http://twitter.com/share?url target="blank" =<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?><?php echo $twitRec; ?>" class="share-window">
            <img src="<?php echo get_template_directory_uri(); ?>/images/twitter-ic-16.png" alt="Share on Twitter" /></a>
            
            <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&t=<?php echo urlencode(get_the_title()); ?>"  class="share-window">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/facebook-ic-16.png" alt="Share on Facebook" />
            </a>
            
            <a href="http://www.tumblr.com/share/photo?source=<?php echo urlencode(wp_get_attachment_url($thumbID)) ?>&caption=<?php echo urlencode(get_the_title()); ?>&clickthru=<?php echo urlencode(get_permalink()); ?>" title="Share on Tumblr">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/tumblr-ic-16.png" alt="Share on Tumblr" />
            </a>
            
        </div><!-- #share-icons -->
    </div><!-- #share-container -->  
          
</div><!-- #actions --> 