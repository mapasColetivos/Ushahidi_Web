<?php 
/*
 * Template Name: Archives
 * @since         1.0
 * @alter         1.6
*/

get_header('archives'); ?>

<div class="wrap" id="archives-page">    
    <div id="grid">

		<div class="sort">
        
        	<div class="box col2">
                <div class="box-content">
                    <h2><?php _e('Recent Posts', 'shaken'); ?></h2>
                    <ul class="recent-posts">
                    
                    <?php 
					  $recentPostsQuery = new WP_Query('posts_per_page=5');
					  if ( $recentPostsQuery->have_posts() ) : while ( $recentPostsQuery->have_posts() ) : $recentPostsQuery->the_post(); ?>
                    <li class="cat-post-item">
                		
                		<?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumb">
                            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('sidebar'); ?></a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="post-info">
                            <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                            <p>
                            	<?php _e('Publicado em', 'shaken'); ?> <?php the_time('F jS, Y') ?><br />
                            	<strong><?php _e('Category', 'shaken'); ?></strong>: <?php the_category(', '); ?>
                                <?php if(has_tag()){ ?>
                                    <br /><strong><?php _e('Tags', 'shaken'); ?></strong>: <?php the_tags( '', ', ', ''); ?>
                                <?php } ?>
                            </p>
                        </div>
                        
                        <div class="clearfix"></div>
                    </li>
                    <?php endwhile; endif; ?>
                    
                    </ul>
            	</div>
            </div><!-- #recent-posts -->
        	
            <div class="box col2">
            <div class="box-content">
            	<h2><?php _e('Categories', 'shaken'); ?></h2>
                <ul>											  
                    <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>	
                </ul>
            </div>
            </div>
            
            <div class="box col2">
            <div class="box-content">
            	<h2><?php _e('Monthly Archives', 'shaken'); ?></h2>
                <ul>											  
                    <?php wp_get_archives('type=monthly&show_post_count=1') ?>
                </ul>
            </div>
            </div><!-- #Monthly Archives -->
            
            <div class="box col2">
            <div class="box-content">
            	<h2><?php _e('Most Popular Posts', 'shaken'); ?></h2>
                <ul>
					<?php $popularPostsQuery = new WP_Query('orderby=comment_count&posts_per_page=10');
                    if ( $popularPostsQuery->have_posts() ) : while ( $popularPostsQuery->have_posts() ) : $popularPostsQuery->the_post(); ?>
                    
                        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                    <?php endwhile; endif; ?>		
              </ul>
            </div>
            </div><!-- #Most Popular Posts -->
            
        </div>

	</div><!-- #grid -->
</div><!-- #wrap -->
<?php get_footer('archives'); ?>