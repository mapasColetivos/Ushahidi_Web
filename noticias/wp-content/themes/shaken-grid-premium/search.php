<?php
/* Search Results
 *
 * @since   1.0
 * @alter   1.6
*/

get_header('search'); ?>
<div class="wrap">    
    <div id="grid">
    
    <?php if ( have_posts() ) : ?>
    
	<?php
	/* Run the loop to output the posts.
	* If you want to overload this in a child theme then include a file
	* called loop-index.php and that will be used instead.
	*/
	get_template_part( 'loop', 'search' );
	?>
    
    <?php else : ?>
    	
        <div class="box">
        	<div class="box-content">
            	<h2><?php _e('Nenhum post encontrado', 'shaken'); ?></h2>
                <p><?php _e('Tente buscar por palavras alternativas', 'shaken'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
        
    <?php endif; ?>
	</div><!-- #grid -->
</div><!-- #wrap -->
<?php get_footer('search'); ?>