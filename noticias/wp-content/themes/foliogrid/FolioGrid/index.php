<?php get_header(); ?>
	
   <div id="postwrapper">

	   <?php 
	   if (have_posts()) : ?>
	
			<?php while (have_posts()) : the_post(); ?>
			
			<div class="post <?php echo frogs_column_width($post->ID); ?> infinite removeonceloaded" id="post-<?=$post->ID;?>">
				<div>
					<div class="post-header">
						<?php frogs_media($post->ID); ?>
					</div>
			
					<div class="post-content">
						<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<p><?php frog_the_excerpt_reloaded(50, '<a>', TRUE, '...', FALSE, 1); ?></p>
					</div>
			
					<div class="post-footer">
						<small>Published on <?php the_time('M d, Y'); ?><br />
						Filed under: <?php the_category(' | ') ?>
						</small>
					</div>
				</div>
		
			</div>
	
			<?php 
			endwhile; ?>
		
			<div class="nextPrev">
				<div class="post archiveTitle older">
					<?php next_posts_link('&larr; Older') ?>
					<?php previous_posts_link('Newer &rarr;') ?>
				</div>
			</div>
	
		<?php else : ?>
		
			<div class="post">
				<div>
					<h1>Not Found</h1>
					<p>Sorry, but you are looking for something that isn't here.</p>
				</div>
			 </div>
	
		<?php endif; ?>
		
		<div class="post copyright">
			<div>
			   <p>FolioGrid - <a href="http://www.frogsthemes.com">Premium Wordpress Themes</a> by FrogsThemes.com</p>
			</div>
		</div>
	
	</div>

<?php get_footer(); ?>