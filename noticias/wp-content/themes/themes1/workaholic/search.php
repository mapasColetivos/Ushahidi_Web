<?php get_header(); ?>

	<div id="content" class="grid_12">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>


		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?>>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>
				<?php the_excerpt(); ?>
				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Post your Thoughts &rarr;', '1 Thought &rarr;', '% Thoughts &rarr;'); ?></p>
			</div>
			<hr class="dotted" />	
		<?php endwhile; ?>

		<div class="navigation-archive">
			<div class="next"><?php next_posts_link('Next &rarr;') ?></div>
			<div class="prev"><?php previous_posts_link('&larr; Previous') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>