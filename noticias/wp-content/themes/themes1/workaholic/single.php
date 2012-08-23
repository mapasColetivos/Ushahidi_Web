<?php get_header(); ?>

	<div id="content" class="grid_8">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2 class="entry-title"><?php the_title(); ?></h2>			

			<div class="entry">
				<?php if(!in_category("$blog_ID")) { ?>
		
				<?php if(checkimage()) { // if there is an image ?>		
					<div id="gallery"><?php postimages('medium'); ?></div>				
				<?php } } ?>
				<?php the_content(); ?>
			
			<?php if(in_category($blog_ID)) { ?>
				
				<hr class="dotted" />
				<p class="postmetadata alt">
					<small>
						This entry was posted on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
						and is filed under <?php the_category(', ') ?>.
						You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							You can <a href="#respond">leave your thoughts</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

						<?php } edit_post_link('Edit this entry','','.'); ?>

					</small>
				</p>
				<hr class="dotted" />				
				<?php } ?>		
					
			</div>
		</div>
		
	<?php if(in_category("$blog_ID")) { comments_template(); } ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>
	
<?php if(in_category($blog_ID)) { 
	get_sidebar(); 
} else {
	get_sidebar("portfolio"); 
} ?>
<?php get_footer(); ?>
