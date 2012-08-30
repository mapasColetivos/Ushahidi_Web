<?php

/*
*
* Author: FrogsThemes
* File: sets up custom post types for the theme
*
*
*/


//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_portfolio_taxonomies', 0 );

//create two taxonomies, genres and writers for the post type "book"
function create_portfolio_taxonomies() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Portfolio Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Portfolio Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Portfolio Types' ),
    'all_items' => __( 'All Portfolio Types' ),
    'parent_item' => __( 'Parent Portfolio Type' ),
    'parent_item_colon' => __( 'Parent Portfolio Type:' ),
    'edit_item' => __( 'Edit Portfolio Type' ), 
    'update_item' => __( 'Update Portfolio Type' ),
    'add_new_item' => __( 'Add New Portfolio Type' ),
    'new_item_name' => __( 'New Portfolio Type' ),
    'menu_name' => __( 'Portfolio Types' ),
  ); 	

  register_taxonomy('portfolio-types',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'portfolio-types' ),
  ));
}

// initialise the admin pages for the custom post type
function admin_init(){
	add_meta_box("portfolio_meta", "Portfolio Details", "portfolio_meta", "portfolio", "normal", "low");
	add_meta_box("homebanner_meta", "Banner Details", "homebanner_meta", "home_banners", "normal", "low");
	add_meta_box("testimonial_meta", "Testimonial Details", "testimonial_meta", "testimonials", "normal", "low");
}

/*  --------------------------------------- home_banners -----------------------------------------*/

add_action('init', 'home_banners_register');
 
function home_banners_register() {
 
	$labels = array(
		'name' => _x('Home Banners', 'post type general name'),
		'singular_name' => _x('Home Banner', 'post type singular name'),
		'add_new' => _x('Add Home Banner', 'ctas'),
		'add_new_item' => __('Add New Home Banner'),
		'edit_item' => __('Edit Home Banner'),
		'new_item' => __('New Home Banner'),
		'view_item' => __('View Home Banner'),
		'search_items' => __('Search Home Banners'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail')
	  ); 
 
	register_post_type( 'home_banners' , $args );
}
add_action("admin_init", "admin_init");

function homebanner_meta() {
	global $post;
	$custom = get_post_custom($post->ID);
	$_wp_banner_url = $custom["_wp_banner_url"][0];
	$_wp_banner_caption = $custom["_wp_banner_caption"][0];
	?>
    <table class="form-table">
        <tr>
            <th style="width:150px; padding:13px 10px 10px 10px;">
                <label for="columns">Banner URL:</label>
            </th>
            <td>
                <input name="_wp_banner_url" value="<?php echo $_wp_banner_url; ?>" style="width:500px;" />
                <input type="hidden" name="_wp_banner_url_noncename" id="_wp_banner_url_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
            </td>
        </tr>
        <tr>
            <th style="width:150px; padding:13px 10px 10px 10px;">
                <label for="columns">Banner Caption Text:</label>
            </th>
            <td>
                <input name="_wp_banner_caption" value="<?php echo $_wp_banner_caption; ?>" style="width:500px;" />
                <input type="hidden" name="_wp_banner_caption_noncename" id="_wp_banner_caption_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
            </td>
        </tr>		
    </table>
	<?php
}

add_action('save_post', 'homebanner_save_details');

function homebanner_save_details(){
  global $post;
 
  update_post_meta($post->ID, "_wp_banner_url", $_POST["_wp_banner_url"]);
  update_post_meta($post->ID, "_wp_banner_caption", $_POST["_wp_banner_caption"]);
}

/*  --------------------------------------- end home_banners -----------------------------------------*/

/*  --------------------------------------- portfolio items -----------------------------------------*/

add_action('init', 'portfolio_register');
 
function portfolio_register() {
 
	$labels = array(
		'name' => _x('Portfolio Items', 'post type general name'),
		'singular_name' => _x('Portfolio', 'post type singular name'),
		'add_new' => _x('Add Portfolio Item', 'ctas'),
		'add_new_item' => __('Add New Portfolio Item'),
		'edit_item' => __('Edit Portfolio Item'),
		'new_item' => __('New Portfolio Item'),
		'view_item' => __('View Portfolio Item'),
		'search_items' => __('Search Portfolio Items'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail','editor')
	  ); 
 
	register_post_type( 'portfolio' , $args );
}
add_action("admin_init", "admin_init");

function portfolio_meta() {
	global $post;
	$custom = get_post_custom($post->ID);
	$_wp_home_tabs_sub_title = $custom["_wp_home_tabs_sub_title"][0];
	$_wp_showonhomepageport = $custom["_wp_showonhomepageport"][0];
	?>
    <table class="form-table">
        <tr>
            <th style="width:150px; padding:13px 10px 10px 10px;">
                <label for="columns">Show in 'Recent Work' slider?</label>
            </th>
            <td>
                <select name="_wp_showonhomepageport" id="_wp_showonhomepageport">
                <?php 
                
                $options = array('No', 'Yes');
                
                foreach($options as $option)
                {
                    ?>
                    <option <?php if ( htmlentities( get_post_meta( $post->ID, '_wp_showonhomepageport', true ), ENT_QUOTES ) == $option ) echo ' selected="selected"'; ?>>
                        <?php echo $option; ?>
                    </option>
                    <?php 
                }
                ?>
                </select>
                <input type="hidden" name="_wp_showonhomepageport_noncename" id="_wp_showonhomepageport_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
            </td>
        </tr>
    </table>
	<?php
}

add_action('save_post', 'portfolio_save_details');

function portfolio_save_details(){
  global $post;
 
  update_post_meta($post->ID, "_wp_home_tabs_sub_title", $_POST["_wp_home_tabs_sub_title"]);
  update_post_meta($post->ID, "_wp_showonhomepageport", $_POST["_wp_showonhomepageport"]);
}

/*  --------------------------------------- end portfolio items -----------------------------------------*/

/*  --------------------------------------- testimonials -----------------------------------------*/

add_action('init', 'testimonials_register');
 
function testimonials_register() {
 
	$labels = array(
		'name' => _x('Testimonials', 'post type general name'),
		'singular_name' => _x('Testimonials', 'post type singular name'),
		'add_new' => _x('Add Testimonial', 'ctas'),
		'add_new_item' => __('Add New Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonials'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail', 'editor')
	  ); 
 
	register_post_type( 'testimonials' , $args );
}
add_action("admin_init", "admin_init");

function testimonial_meta() {
	global $post;
	$custom = get_post_custom($post->ID);
	$_wp_testimonee = $custom["_wp_testimonee"][0];
	?>
    <table class="form-table">
        <tr>
            <th style="width:150px; padding:13px 10px 10px 10px;">
                <label for="columns">Testimonial By:</label>
            </th>
            <td>
                <input name="_wp_testimonee" value="<?php echo $_wp_testimonee; ?>" style="width:500px;" />
                <input type="hidden" name="_wp_testimonee_noncename" id="_wp_testimonee_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
            </td>
        </tr>	
    </table>
	<?php
}

add_action('save_post', 'testimonial_save_details');

function testimonial_save_details(){
  global $post;
 
  update_post_meta($post->ID, "_wp_testimonee", $_POST["_wp_testimonee"]);
}


/*  --------------------------------------- end testimonials -----------------------------------------*/

?>