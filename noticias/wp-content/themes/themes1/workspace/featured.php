<?php
	$featured_category_ID = $gpp['gpp_featured_cat'];
	$featured_category = get_cat_name($featured_category_ID);
	if($featured_category_ID=="0") {$featured_category = __('Latest','gpp_i18n');}
?>
<div class="span-24 last">

<h3 class="sub"><?php echo "$featured_category"; ?></h3>

	<?php $my_query = new WP_Query("cat='$featured_category_ID'&showposts=9"); ?>
	<?php $i = 0; ?>
	<?php while ($my_query->have_posts()) : $my_query->the_post(); $do_not_duplicate = $post->ID; $i++;  ?>
			
			<div class="span-8<?php if (($i%3)==0) { ?> last<?php } ?>">
			<div class="post-<?php the_ID(); ?> portfolio-image-wrapper">
			
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_post_thumbnail('310x150'); ?></a>
			
				<div class="title-overlay">
					<h6><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_title() ?></a></h6>
					<p><?php if (the_category(', '))  the_category(); ?></p>
			</div>
			</div>
			<div class="clear"></div>
			</div>
			
	<?php endwhile; wp_reset_query(); ?>
</div>