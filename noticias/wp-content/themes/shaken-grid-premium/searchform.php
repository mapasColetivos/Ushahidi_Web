<?php
/**
 * The Search Form
 *
 * Optional file that allows displaying a custom search form
 * when the get_search_form() template tag is used.
 *
 * @package Shaken Grid (Premium)
 * @since 1.0
 * @alter 1.6
 */
?>

    <form id="searchform" name="searchform" method="get" action="<?php echo home_url(); ?>">
		<div>
			<input type="text" id="s" name="s" />
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Buscar', 'shaken'); ?>" />
		</div>
    </form>