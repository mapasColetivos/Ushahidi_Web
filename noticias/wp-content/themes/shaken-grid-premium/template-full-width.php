<?php 
/* 
 * Template Name: Full Width
 * @since         1.0
 * @alter         2.0
*/

get_header('full'); ?>

<div class="wrap">    
    <div id="full-page">
        <div class="box-content post">
        	<?php if(have_posts()) : while(have_posts()) : the_post() ?>
			
			<?php if ( has_post_thumbnail() ){ 
                the_post_thumbnail('col4', array( 'class' => 'feat-img' ) );
            } ?>
            
            <div class="page-entry">
            	<h1 class="page-title"><?php the_title(); ?></h1>
                
				<?php the_content(); ?>
                
                <?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'shaken'), 'after' => '</strong></p>', 'next_or_number' => 'number')); ?>

                <?php edit_post_link(__('Edit this post', 'shaken')); ?>
            </div><!-- #page-entry -->
                
            <?php endwhile; endif; ?>
        </div>
        
        <?php if(current_theme_supports('shaken_page_comments')) : 
        	comments_template( '', true ); 
        endif; ?>
        
	</div><!-- #page -->
    
</div><!-- #wrap -->
<?php get_footer('full'); ?>