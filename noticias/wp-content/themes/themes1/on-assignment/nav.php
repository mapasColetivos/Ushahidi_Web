<?php
 	$pages_title = get_option('gpp_pages_title');
 	$contact_info = get_option('gpp_contact_info');
 	$email = get_option('gpp_email');
 	$phone = get_option('gpp_phone');
 	if ($email === FALSE) { $emailval = "you@email.com"; } else { $emailval = get_option('gpp_email');}
 	if ($phone === FALSE) { $phoneval = "1-800-867-5309"; } else { $phoneval = get_option('gpp_phone');}
 	$photoshelter_name = get_option('gpp_photoshelter_name');
 	
// Same as wp_list_pages But display the category which selected by Navigation Pages Option
function ro_list_pages($args = '') {
	$defaults = array(
		'depth' => 0, 'show_date' => '',
		'date_format' => get_option('date_format'),
		'child_of' => 0, 'exclude' => '',
		'title_li' => __('Pages','gpp_i18n'), 'echo' => 1,
		'authors' => '', 'sort_column' => 'menu_order, post_title',
		'link_before' => '', 'link_after' => ''
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$output = '';
	$current_page = 0;

	// sanitize, mostly to keep spaces out
	$r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);

	// Allow plugins to filter an array of excluded pages
	$r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', explode(',', $r['exclude'])));

	// Query pages.
	$r['hierarchical'] = 0;


	
	
	// Edit By Rock
	$pagess = get_pages($r);
	foreach( $pagess as $onepage) {
		if( get_option("gpp_Navi_Pages_".$onepage->ID) == 'true' || get_option("gpp_Navi_Pages_".$onepage->ID) === FALSE) {
			$pages[] = $onepage;
		}
	}
	// End
	
	

	if ( !empty($pages) ) {
		if ( $r['title_li'] )
			$output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';

		global $wp_query;
		if ( is_page() || is_attachment() || $wp_query->is_posts_page )
			$current_page = $wp_query->get_queried_object_id();
		$output .= walk_page_tree($pages, $r['depth'], $current_page, $r);

		if ( $r['title_li'] )
			$output .= '</ul></li>';
	}

	$output = apply_filters('wp_list_pages', $output);

	if ( $r['echo'] )
		echo $output;
	else
		return $output;
}
 ?>
<?php
	// multi level menu options
	if(get_option('gpp_multilevel_pages') == "true"){ $pparam = 'orderby=name&title_li='; }
	else { $pparam = 'orderby=name&depth=-1&title_li='; }
?>
<!-- Navigation -->
<div id="nav-main">
<ul class="sf-menu">
    <li>
		<a href="#" title="pages"><?php if($pages_title==="" || $pages_title === FALSE) { _e('pages','gpp_i18n'); } else { echo $pages_title; } ?></a>
		<ul>
			<?php ro_list_pages($pparam); ?>
		</ul>
	</li>
	<li class="subscribe-list">
	    <a href="#" title="<?php _e('subscribe','gpp_i18n'); ?>"><?php _e('subscribe','gpp_i18n'); ?></a>
	    <ul>
	        <li><a href="<?php if ( get_option('gpp_feedburner_url') <> "" ) { echo get_option('gpp_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="<?php _e('feed','gpp_i18n'); ?>"><?php _e('posts','gpp_i18n'); ?></a></li>
            <li><a href="<?php bloginfo('comments_rss2_url'); ?>" class="icon comments" title="<?php _e('comments','gpp_i18n'); ?>"><?php _e('comments','gpp_i18n'); ?></a></li>
        </ul>
    </li>
    
<?php if ( get_option('gpp_contact_info') == 'true' || get_option('gpp_contact_info') === FALSE) { ?>
	<li>
	    <a href="#" title="<?php _e('contact','gpp_i18n'); ?>"><?php _e('contact','gpp_i18n'); ?></a>
	    <ul>
                <?php if(($phone === FALSE || $phone != "")) { ?><li><a href="tel:<?php echo $phoneval; ?>" class="icon phone" title="<?php echo $phoneval; ?>"><?php echo $phoneval; ?></a></li><?php } ?>
                <?php if(($email === FALSE || $email != "")) { ?><li><a href="mailto:<?php echo $emailval; ?>" class="icon email" title="<?php _e('email me','gpp_i18n'); ?>"><?php _e('email me','gpp_i18n'); ?></a></li><?php } ?>
        </ul>
    </li>
<?php } ?>
    
<?php if ( get_option('gpp_photoshelter') == 'true' ) { ?>
	<li>
	    <a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com" title="<?php _e('image archive','gpp_i18n'); ?>"><?php _e('image archive','gpp_i18n'); ?></a>
	    <ul>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/" title="<?php _e('archive home','gpp_i18n'); ?>"><?php _e('archive home','gpp_i18n'); ?></a></li>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/gallery-list" title="<?php _e('galleries','gpp_i18n'); ?>"><?php _e('galleries','gpp_i18n'); ?></a></li>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/search-page" title="<?php _e('search archive','gpp_i18n'); ?>"><?php _e('search archive','gpp_i18n'); ?></a></li>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/lbx/lbx-list" title="<?php _e('lightbox','gpp_i18n'); ?>"><?php _e('lightbox','gpp_i18n'); ?></a></li>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/cart/cart-show" title="<?php _e('cart','gpp_i18n'); ?>"><?php _e('cart','gpp_i18n'); ?></a></li>
				<li><a href="https://<?php echo $photoshelter_name; ?>.photoshelter.com/usr/usr-account" title="<?php _e('client login','gpp_i18n'); ?>"><?php _e('client login','gpp_i18n'); ?></a></li>
				<li><a href="http://<?php echo $photoshelter_name; ?>.photoshelter.com/about" title="<?php _e('about','gpp_i18n'); ?>"><?php _e('about','gpp_i18n'); ?></a></li>
      </ul>
    </li>
<?php } ?> 
    
<?php if ( get_option('gpp_link_addition') == 'true' ) { ?>
    <li>
        <a href="<?php echo get_option('gpp_link_URL');?>" title="<?php echo get_option('gpp_link_title');?>"><?php echo get_option('gpp_link_title');?></a>
        <ul>
		<?php if( get_option('gpp_link_url_2') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_2');?>" title="<?php echo get_option('gpp_link_title_2');?>"><?php echo get_option('gpp_link_title_2');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_3') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_3');?>" title="<?php echo get_option('gpp_link_title_3');?>"><?php echo get_option('gpp_link_title_3');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_4') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_4');?>" title="<?php echo get_option('gpp_link_title_4');?>"><?php echo get_option('gpp_link_title_4');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_5') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_5');?>" title="<?php echo get_option('gpp_link_title_5');?>"><?php echo get_option('gpp_link_title_5');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_6') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_6');?>" title="<?php echo get_option('gpp_link_title_6');?>"><?php echo get_option('gpp_link_title_6');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_7') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_7');?>" title="<?php echo get_option('gpp_link_title_7');?>"><?php echo get_option('gpp_link_title_7');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_8') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_8');?>" title="<?php echo get_option('gpp_link_title_8');?>"><?php echo get_option('gpp_link_title_8');?></a></li><?php } ?>
		<?php if( get_option('gpp_link_url_9') != "") { ?><li><a href="<?php echo get_option('gpp_link_URL_9');?>" title="<?php echo get_option('gpp_link_title_9');?>"><?php echo get_option('gpp_link_title_9');?></a></li><?php } ?>     	
		</ul>
    </li>
<?php } else { ?> 
  <li class="search"><a href="#" title="<?php _e('search','gpp_i18n'); ?>"><?php _e('search','gpp_i18n'); ?></a>
    <ul>
      <li><?php if(function_exists('get_search_form')) : ?>
			<?php get_search_form(); ?>
			<?php else : ?>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			<?php endif; ?></li>
    </ul>
  </li>
	<?php } ?>
</ul>
</div>