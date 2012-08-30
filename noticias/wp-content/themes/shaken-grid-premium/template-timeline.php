<?php 
/*
 * Template Name: Timeline
 * @since         1.5
 * @alter         1.5
*/

get_header('timeline'); ?>

<div class="wrap">    
    <div id="grid" class="timeline">
    
	<?php shaken_timeline(); ?> 
	
	</div><!-- #grid -->
    
</div><!-- #wrap -->
<?php get_footer('timeline'); ?>