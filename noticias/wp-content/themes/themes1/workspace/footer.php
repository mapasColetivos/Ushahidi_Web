<?php global $gpp; ?>
<div class="clear"></div>
</div>
</div>
<!-- BeginFooter -->
<div id="footer-wrap">
	<div id="footer">
		<div class="span-3 append-1 small">
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
		<div class="column span-5 small last">
			<div class="credits">
				<h3 class="sub"><?php _e('Credits','gpp_i18n'); ?></h3>
				<p class="quiet">
						<?php _e('<a href="http://graphpaperpress.com/themes/modularity" title="Modularity photo &amp; video theme for WordPress">Modularity theme</a> by <a href="http://graphpaperpress.com" title="Graph Paper Press">Graph Paper Press</a>','gpp_i18n'); ?><br />
						<a href="<?php if ( $gpp['gpp_feedburner_url'] <> "" ) { echo $gpp['gpp_feedburner_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="feed" title="<?php _e('Subscribe to entries','gpp_i18n'); ?>"><?php _e('Subscribe to entries','gpp_i18n'); ?></a><br/>
						<a href="<?php bloginfo('comments_rss2_url'); ?>" class="feed" title="<?php _e('Subscribe to comments','gpp_i18n'); ?>"><?php _e('Subscribe to comments','gpp_i18n'); ?></a><br />
						<?php printf(__('All content &copy; %1$s by %2$s','gpp_i18n'),date('Y'),__(get_bloginfo('name'))); ?>
				</p>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		// Fade
		jQuery(".portfolio-image-wrapper .title-overlay").fadeTo("slow", 0.0); // Sets opacity to fade down to 30% when page loads
		jQuery(".portfolio-image-wrapper").hover(function(){
			jQuery(this).children(".title-overlay").fadeTo("slow", 0.8); // Sets 100% on hover
		},function(){
			jQuery(this).children(".title-overlay").fadeTo("slow", 0.0); // Sets opacity back to 30% on mouseout
		});
		jQuery(".portfolio-image-wrapper img").hover(function(){
			jQuery(this).fadeTo("slow", 0.8); // Sets 100% on hover
		},function(){
			jQuery(this).fadeTo("slow", 1.0); // Sets opacity back to 30% on mouseout
		});
	});
</script>
<?php
	$gpp_tracking_code = $gpp['gpp_tracking_code'];
	if($gpp_tracking_code != ''){
		echo stripslashes(stripslashes($gpp_tracking_code));
	}
?>
<?php wp_footer(); ?>
<!-- EndFooter -->
</body>
</html>