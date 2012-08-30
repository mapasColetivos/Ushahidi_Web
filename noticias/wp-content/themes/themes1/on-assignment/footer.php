<?php global $gpp; ?>
<!-- BeginFooter -->
<div class="clear"></div>
</div>
</div>
<div id="footer-wrap">
<div id="footer">
<!-- EndFooter -->

<?php if ( !$gpp || $gpp['gpp_featured'] == 'true' ) { include ('featured.php'); } ?>

<div class="column span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Left') ) : ?>
<?php endif; ?>
</div>
<div class="column span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Middle') ) : ?>
<?php endif; ?>
</div>
<div class="column span-10 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Right') ) : ?>
<?php endif; ?>
</div>
<!-- BeginFooter -->
<div class="column span-5 small last">
<div class="credits">
<h3 class="sub"><?php _e('Credits','gpp_i18n'); ?></h3>
<p class="quiet">
		<?php _e('Design by <a href="http://graphpaperpress.com" title="Graph Paper Press">Graph Paper Press</a>','gpp_i18n'); ?><br />
		<a href="<?php if ( $gpp['gpp_feedburner_url'] <> "" ) { echo $gpp['gpp_feedburner_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="feed" title="<?php _e('Subscribe to entries','gpp_i18n'); ?>"><?php _e('Subscribe to entries','gpp_i18n'); ?></a><br/>
		<a href="<?php bloginfo('comments_rss2_url'); ?>" class="feed" title="<?php _e('Subscribe to comments','gpp_i18n'); ?>"><?php _e('Subscribe to comments','gpp_i18n'); ?></a><br />
		<?php printf(__('All content &copy; %1$s by %2$s','gpp_i18n'),date('Y'),__(get_bloginfo('name'))); ?>
</p>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<?php wp_footer(); ?>
<?php
	$gpp_tracking_code = $gpp['gpp_tracking_code'];
	if($gpp_tracking_code != ''){
		echo stripslashes($gpp_tracking_code);
	}
?>
<!-- EndFooter -->
</body>
</html>