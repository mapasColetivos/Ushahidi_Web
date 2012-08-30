<!--Featured Posts -->

<div class="app">
<div id="featured">
<?php
$featured_category_ID = $gpp['gpp_featured_cat'];
$blog_category_ID = $gpp['gpp_blog_cat'];

$featured_category = get_cat_name($featured_category_ID);
$blog_category = get_cat_name($blog_category_ID);

if($featured_category_ID=="0") {$featured_category = __('Featured','gpp_i18n');}
if($blog_category_ID=="0") {$blog_category = __('Blog','gpp_i18n');}

$i = 0; 
$default_medium = get_bloginfo('stylesheet_directory') . "/images/default-medium-270-150.jpg";
?>
<div class="span-7 colborder">

<h3 class="sub"><?php echo "$featured_category"; ?></h3>
<hr />
	<?php $featured_query = new WP_Query("cat='$featured_category_ID'&showposts=1"); ?>
	<?php $i = 0; ?>
	<?php while ($featured_query->have_posts() && $i<8) : $featured_query->the_post();
		$do_not_duplicate = $post->ID;  ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_post_thumbnail('270x150'); ?></a>
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></h3>
			<p class="byline"><?php the_time(__('M d, Y', 'gpp_i18n')); ?> | <?php comments_popup_link(__('Discuss', 'gpp_i18n'), __('1 Comment', 'gpp_i18n'),_n('% Comment', '% Comments',get_comments_number (),'gpp_i18n')); ?></p>
			<p><?php the_excerpt(); ?></p>
			<div class="clear"></div>
	<?php endwhile; wp_reset_query(); ?>
	<h3 class="sub"><?php _e('More','gpp_i18n'); ?></h3>
	<?php $featured_offset_query = new WP_Query("cat='$featured_category_ID'&showposts=5&offset=1"); ?>
	<ul>
		<?php while ($featured_offset_query->have_posts()) : $featured_offset_query->the_post();
		$do_not_duplicate = $post->ID; ?>
			<li class="post" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></li>
		<?php endwhile; wp_reset_query(); ?>
	</ul>
</div>

<div class="span-7 colborder">
<h3 class="sub"><?php echo "$blog_category"; ?></h3>
<hr />
	<?php $blog_query = new WP_Query("cat='$blog_category_ID'&showposts=1"); ?>
		<?php while ($blog_query->have_posts()) : $blog_query->the_post();
		$do_not_duplicate = $post->ID; ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_post_thumbnail('270x150'); ?></a>
			<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></h3>
			<p class="byline"><?php the_time(__('M d, Y', 'gpp_i18n')); ?> | <?php comments_popup_link(__('Discuss', 'gpp_i18n'), __('1 Comment', 'gpp_i18n'),_n('% Comment', '% Comments',get_comments_number (),'gpp_i18n')); ?></p>
			<p><?php the_excerpt(); ?></p>
			<?php endwhile; wp_reset_query();?>
<h3 class="sub"><?php _e('More','gpp_18n'); ?></h3>
	<?php $blog_offset_query = new WP_Query("cat='$blog_category_ID'&showposts=5&offset=1"); ?>
	<ul>
		<?php while ($blog_offset_query->have_posts()) : $blog_offset_query->the_post();
		$do_not_duplicate = $post->ID; ?>
			<li class="post" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></li>
		<?php endwhile; wp_reset_query();?>
	</ul>
</div>

<?php get_sidebar(); ?>
<hr />
</div>
</div>