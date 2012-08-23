<?php
/**
 * Footer Template
 *
 * This file is responsible for generating the
 * bottom-most html for all public-facing views.
 * It's content is generated via core WordPress
 * functions as well as custom actions defined
 * in functions.php.
 *
 * Child themes are encouraged to work with the
 * actions defined herein to add or remove data
 * to/from the bottom of the template. In the event
 * that the html needs to be modified, this
 * template may be duplicated inside a child theme
 * and edited there.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.0
 * @alter        2.0
 *
 */
 ?>
<br class="clearfix" />
<!-- <div id="footer">
	<p><?php _e('Copyright', 'shaken'); ?> &copy; <?php echo date('Y'); ?> <?php echo of_get_option('copyright'); ?> 
	
		<?php if(current_theme_supports('shaken_footer_credit')): ?> 
        <span class="alignright">
            <?php _e('Powered by', 'shaken'); ?> <a href="http://shakenandstirredweb.com/theme/shaken-grid" target="_blank">Shaken Grid Premium</a><br />
        	<?php _e('Social media icons by', 'shaken'); ?> <a href="http://icondock.com/free/vector-social-media-icons" target="_blank">icondock</a>
        </span>
        <?php endif; ?>
        
    </p>
    <div class="clearfix"></div>
</div>-->

<script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js?v=2"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js?v=2"></script>

<?php if( is_home() || is_archive() || is_search() ): ?>
	<script src="http://platform.tumblr.com/v1/share.js"></script>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>