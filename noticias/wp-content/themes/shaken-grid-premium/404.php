<?php
/* Page not found
 *
 * @since   1.0
 * @alter   1.6
*/

get_header(); ?>

<div class="wrap">    
    <div id="full-page">
        <div class="page-content post">
        	<div class="page-entry">
                <h1 class="page-title"><?php _e('Page Not Found', 'shaken'); ?></h1>
                <p><?php _e('Maybe try searching for something?', 'shaken'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
	</div><!-- #page -->
    
</div><!-- #wrap -->
<?php get_footer(); ?>