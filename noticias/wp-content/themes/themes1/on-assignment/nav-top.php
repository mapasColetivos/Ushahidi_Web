<?php
	
// Same as wp_list_categories But display the category which selected by Navigation Categories Option
function ro_list_categories( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'orderby' => 'name',
		'order' => 'ASC', 'show_last_update' => 0,
		'style' => 'list', 'show_count' => 0,
		'hide_empty' => 1, 'use_desc_for_title' => 1,
		'child_of' => 0, 'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '', 'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __('Categories','gpp_18n'),
		'echo' => 1, 'depth' => 0
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	if ( isset( $r['show_date'] ) ) {
		$r['include_last_update_time'] = $r['show_date'];
	}

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}

	extract( $r );
	
	
	
	// Edit By Rock
	$categ = get_categories( $r );
	foreach( $categ as $cat) {
		if( get_option("gpp_Navi_category_".$cat->term_id) == 'true' || get_option("gpp_Navi_category_".$cat->term_id) === FALSE) {
			$categories[] = $cat;
		}
	}
	// End
	
	
	

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="categories">' . $r['title_li'] . '<ul>';

	if ( empty( $categories ) ) {
		if ( 'list' == $style )
			$output .= '<li>' . __('No categories','gpp_18n') . '</li>';
		else
			$output .= __('No categories','gpp_18n');
	} else {
		global $wp_query;

		if( !empty( $show_option_all ) )
			if ( 'list' == $style )
				$output .= '<li><a href="' .  get_bloginfo( 'url' )  . '">' . $show_option_all . '</a></li>';
			else
				$output .= '<a href="' .  get_bloginfo( 'url' )  . '">' . $show_option_all . '</a>';

		if ( empty( $r['current_category'] ) && is_category() )
			$r['current_category'] = $wp_query->get_queried_object_id();

		if ( $hierarchical )
			$depth = $r['depth'];
		else
			$depth = -1; // Flat.

		$output .= walk_category_tree( $categories, $depth, $r );
	}

	if ( $title_li && 'list' == $style )
		$output .= '</ul></li>';

	$output = apply_filters( 'wp_list_categories', $output );

	if ( $echo )
		echo $output;
	else
		return $output;
}
 ?>
<!-- Navigation -->
<div id="nav-wrap-top">
<ul class="sf-menu">
	<?php ro_list_categories('orderby=name&depth=-1&title_li=&show_up=true'); ?>
</ul>
</div>
<div class="clear"></div>
