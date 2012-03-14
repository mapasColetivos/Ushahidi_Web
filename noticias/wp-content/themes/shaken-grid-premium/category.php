<?php
/* Category Archive
 *
 * @since   1.0
 * @alter   1.6
*/

get_header('category'); ?>

<div class="wrap">    
    <div id="grid">
	<?php
	/* Run the loop to output the posts.
	* If you want to overload this in a child theme then include a file
	* called loop-category.php and that will be used instead.
	*/
	get_template_part( 'loop', 'category' );
	?>
	</div><!-- #grid -->
</div><!-- #wrap -->
<?php get_footer('category'); ?>