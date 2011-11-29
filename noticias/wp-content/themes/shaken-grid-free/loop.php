<?php /* If there are no posts to display, such as an empty archive page  */ ?>
<?php if (have_posts()) : ?>

<?php /* Display navigation to next/previous pages when applicable  */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<!-- <div id="nav-above" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>  + antigos') ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( ' + recentes <span class="meta-nav">&rarr;</span>') ); ?></div>-->
    </div><!-- #nav-below -->
<?php endif; ?>

	<div id="sort">
	<?php while (have_posts()) : the_post(); ?>
	<div class="box">
    	<?php
		if ( has_post_thumbnail() ){ ?>
			<?php $thumbID = get_post_thumbnail_id($post->ID); ?>
            <a href="<?php echo wp_get_attachment_url($thumbID); ?>" rel="gallery" title="<?php the_title(); ?>">        
                <?php the_post_thumbnail(); ?>
                <span class="view-large"></span>
            </a>
        <?php } ?>
        
        <!-- <h2><?php the_title(); ?></h2> -->
        
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

         <!-- <?php the_excerpt('<p>Continue Lendo &rarr;</p>'); ?></h2> -->

<?php the_excerpt(); ?>
<p class="postmetadata"><?php the_time( get_option( 'date_format' ) ); ?>
<!-- | <?php comments_popup_link('Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p> ||Eu apaguei o link dos comentários-->

        <?php edit_post_link('Edit this post'); ?>
    </div>
    <?php endwhile; ?>
    </div><!-- #sort -->

<?php /* Display navigation to next/previous pages when applicable  */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-below" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span>  + antigos') ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( ' + recentes <span class="meta-nav">&rarr;</span>') ); ?></div>
    </div><!-- #nav-below -->
<?php endif; ?>

<?php else : ?>
<div id="sort">
<div class="box">
	<h2>Ops, nenhum post encontrado.</h2>
    <?php get_search_form(); ?>
</div>
</div><!-- #sort -->
<?php endif; ?>
