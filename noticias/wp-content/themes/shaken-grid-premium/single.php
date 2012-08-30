<?php
/* Single Post Template
 * @since   1.0
 * @alter   2.0
*/
get_header(); ?>

<div class="wrap">

<?php 
if(have_posts()) : while(have_posts()) : the_post();

	$vid = get_post_meta($post->ID, 'soy_vid', true);
	$vid_url = get_post_meta($post->ID, 'soy_vid_url', true);
	$vid_wide = get_post_meta($post->ID, 'soy_vid_wide', true);
	$post_style = get_post_meta($post->ID, 'soy_post_style', true);
?>  

    <div id="page" class="post<?php if( $post_style == 'Minimal' ){ echo ' minimal-post'; } echo ' '.get_post_format(); ?>">
			
		<div class="content">
		<div class="box-content">
			
			 <div class="post-media">
				<!-- <?php 
				// Display media (Video URL >> Wide embed >> Embed >> Image)
				if($vid_url):
		        	echo apply_filters( 'the_content', "[embed width='670']" . $vid_url . "[/embed]" );
		        elseif($vid_wide):
					echo $vid_wide; 
		        elseif($vid): 
					echo $vid; 
				elseif ( has_post_thumbnail() ):
		            the_post_thumbnail('col4', array( 'class' => 'feat-img' ) );
		        endif; ?> -->
		        
		       <!-- <?php 
		        // Display Gallery
		        if( has_post_format('gallery') ):
		        	get_template_part( 'includes/single-gallery'); 
		        endif; ?>-->
	        </div><!-- #post-media -->
	        
	        <?php if( $post_style != 'Minimal' ): ?>
    			
    			<div class="entry">
			        <h1 class="post-title"><?php the_title(); ?></h1>
			        
			        <p class="post-details">
			        	<?php _e('Publicado em', 'shaken'); ?> <?php echo get_the_time( get_option( 'date_format' ), $post ); ?>
			            	
						<?php if( is_multi_author() ): ?> 
							<?php _e('por', 'shaken'); ?> 
				            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="View all posts by <?php echo get_the_author(); ?>" id="author-link">
								<?php echo get_the_author(); ?>
				           </a>
			           <?php endif; ?>
				    </p>
			        

			        <?php /* The Post */ ?>
			        
						<?php the_content(); ?>
			            

			            <?php wp_link_pages( array( 'before' => '<p><strong>' . __( 'Pages:', 'shaken' ), 'after' => '</strong></p>', 'next_or_number' => 'number' ) ); ?>
			            
			            <?php edit_post_link( __('Edit this post', 'shaken'), '<p>', '</p>' ); ?>
			        
			        <?php /* Post Metadata */ ?>
			        <div class="postmetadata">
			        
			            <strong><?php _e( 'Category', 'shaken' ); ?></strong>: <?php the_category(', '); ?>
			            
			            <?php if( has_tag() ): ?>
			            	<strong><?php _e( 'Tags' ,'shaken' ); ?></strong>: <?php the_tags( '', ', ', ''); ?>
			            <?php endif; ?>
			                
<?php show_social_widgets(); ?>

			        </div><!-- #postmetadata -->
	        	</div><!-- #entry -->
	        <?php endif; ?>
        	
        	<?php comments_template(); ?>
        	
        </div><!-- # $feature_container -->
        </div><!-- #content -->
	</div><!-- #page -->
	
	<?php 
	/* The Minimal Post Style */ 
	if($post_style == 'Minimal'): ?>
		<div id="sidebar" class="minimal-content">
			 
			 <h1 class="post-title"><?php the_title(); ?></h1>
			 
			 <div class="entry">
				 <?php the_content(); ?>
				 
				 <?php wp_link_pages( array( 'before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) ); ?>
				 
				 <p class="category"><strong><?php _e( 'Category', 'shaken' ); ?></strong>: <?php the_category(', '); ?></p>
		         
		         <?php edit_post_link( __('Edit this post', 'shaken'), '<p>', '</p>' ); ?>
	         </div>
	         
		</div><!-- #sidebar -->
	<?php endif; ?>
	
    <?php /* End: loop */
    endwhile; endif; ?>
    
    <?php if( $post_style != 'Minimal' ){ get_sidebar(); } ?>
</div><!-- #wrap -->
<?php get_footer(); ?>