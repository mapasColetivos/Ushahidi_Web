<?php 
/**
 * Sidebar.php
 *
 * This file will display the appropriate sidebar based on  
 * what page is being displayed. If the page doesn't own a
 * unique sidebar, it will be assigned the normal "page-sidebar"
 * 
 * @since 1.0
 * @alter 1.6
 */ ?>
<div id="sidebar" class="widget-area">

	<?php if(is_single()){
		dynamic_sidebar( 'post-sidebar' );
	} else if(is_page_template('template-unique-sidebar.php')) {
		dynamic_sidebar( 'unique-sidebar' );
	} else if(is_archive() || is_home()) {
		dynamic_sidebar( 'gallery-sidebar' );
	} else { ?>

		<?php if ( ! dynamic_sidebar( 'page-sidebar' ) ) : ?>
            <h3 class="widget-title"><?php _e( 'Archives', 'shaken'); ?></h3>
            <ul>
                <?php wp_get_archives( 'type=monthly' ); ?>
            </ul>
        <?php endif; // end primary widget area ?>
    
    <?php } ?>
    
</div><!-- #primary .widget-area -->