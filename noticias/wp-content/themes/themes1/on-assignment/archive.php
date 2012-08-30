<?php get_header(); rewind_posts(); ?>
<div class="span-24 last">

		<?php 
		query_posts($query_string.'&posts_per_page=24');
		if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h3 class="sub"><?php single_cat_title(); ?></h3>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h3 class="sub"><?php printf(__('Posts Tagged &#8216;%s&#8217;','gpp_i18n'),single_tag_title('',false)); ?></h3>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h3 class="sub"><?php printf(__('Archive for %s','gpp_i18n'),get_the_time(__('F jS, Y','gpp_i18n'))); ?></h3>		
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="sub"><?php printf(__('Archive for %s','gpp_i18n'),get_the_time(__('F, Y','gpp_i18n'))); ?></h3>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h3 class="sub"><?php printf(__('Archive for %s','gpp_i18n'),get_the_time(__('Y','gpp_i18n'))); ?></h3>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h3 class="sub"><?php _e('Author Archive','gpp_i18n'); ?></h3>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h3 class="sub"><?php _e('Archives','gpp_i18n'); ?></h3>
 	  <?php } ?>
<div class="clear"></div>
<?php $i = 0; ?>
<div class="content">
<?php while (have_posts()) : the_post(); $i++; ?>
	<div class="span-7<?php if ($i == 3) : ?> last<?php  else : ?> colborder<?php endif; ?>">
		<div class="post-<?php the_ID(); ?>">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_post_thumbnail('270x150'); ?></a>
			<h3 class="title-overlay"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></h3>
			<p class="byline"><?php the_time(__('M d, Y', 'gpp_i18n')); ?> | <?php comments_popup_link(__('Discuss', 'gpp_i18n'), __('1 Comment', 'gpp_i18n'),__ngettext('% Comment', '% Comments',get_comments_number (),'gpp_i18n')); ?></p>
			<p><?php the_excerpt(); ?></p>
			</div>
		</div>
<?php if ($i == 3) { ?><hr /><?php $i = 0; } ?>
<?php endwhile; ?>
</div>
<div class="clear"></div>

<div class="nav-interior">
			<div class="prev"><?php next_posts_link(__('&laquo; Older Entries','gpp_i18n')); ?></div>
			<div class="next"><?php previous_posts_link(__('Newer Entries &raquo;','gpp_i18n')); ?></div>
		</div>
<div class="clear"></div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','gpp_i18n'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
</div>
</div>


<!-- Begin Footer -->
<?php get_footer(); ?>