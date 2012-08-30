<!-- Begin slider -->
<?php $slider_cat_ID = $gpp['gpp_slider_cat']; ?>

<div id="slider-section">
	<div class="sliderGallery">
		<?php $slider_query = new WP_Query("posts_per_page=10&cat=$slider_cat_ID"); ?>
		<ul class="items">
			<?php if ($slider_query->have_posts()) : while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
			<li class="post-<?php the_ID(); ?> slider-item">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','gpp_i18n'),the_title_attribute('echo=0')); ?>"><?php the_post_thumbnail('310x150'); ?><span class="slider-title"><?php the_title() ?></span></a>
			</li>
			<?php endwhile; endif; wp_reset_query(); ?>
		</ul>
	</div>
</div>

<div id="slider-handle">
	<div id="content-slider"></div>
</div>