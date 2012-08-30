<?php
/**
 * Theme Functions
 *
 * @package      Shaken Grid (Premium)
 * @since        1.0
 * @alter        2.0
 *
 */
 
$functions_path = TEMPLATEPATH . '/functions/';
$widgets_path = TEMPLATEPATH . '/functions/widgets/';

add_action( 'after_setup_theme', 'shaken_setup' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override shaken_setup() in a child theme, add your own shaken_setup to your child theme's
 * functions.php file.
 *
 * @since 1.5.0
 */
if(!function_exists('shaken_setup')):
function shaken_setup() {
	// Theme support
		
		if ( ! isset( $content_width ) ){
			$content_width = 620;
		}
		
		// Enable support for default WordPress components 
		add_theme_support( 'post-formats', array( 'quote', 'gallery' ) );
		add_editor_style();
		add_theme_support('automatic-feed-links');
		add_custom_background('shaken_custom_background_cb');
		
		// Set featured image sizes
		add_theme_support( 'post-thumbnails');
		set_post_thumbnail_size( 310, 232); //1800
		add_image_size( 'sidebar', 75, 75, true);
		add_image_size( 'gallery', 210, 210, true);
		add_image_size( 'col1', 145, 1800);
		add_image_size( 'col3', 495, 1800);
		add_image_size( 'col4', 670, 1800);
		
		/**
		 * Support added for theme specific components 
		 * To remove support, create a child theme and use remove_theme_support()
		 * in its functions.php file.
		 *
		 * We can remove the parent theme's hook only after it is attached, which means we need to
 		 * wait until setting up the child theme:
		 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
		 * function my_child_theme_setup() {
		 *     // We are removing support for the hover buttons
		 *     remove_theme_support('shaken_action_buttons');
 		 *     ...
		 * }
		 * @since 1.5.0
		*/
		
		// Buttons shown on image hover
		add_theme_support('shaken_action_buttons');
		
		// Footer credit text
		add_theme_support('shaken_footer_credit');
		
		/* Uncomment the line below to enable comments
		   on all page templates. */
		//add_theme_support('shaken_page_comments');
	
	// Actions
		
		/* Add your nav menus function to the 'init' action hook. */
		add_action( 'init', 'shaken_register_menus' );
		
		/* Add your sidebars function to the 'widgets_init' action hook. */
		add_action( 'widgets_init', 'shaken_register_sidebars' );
		
		// Threaded comments
		add_action('get_header', 'enable_threaded_comments');
		
		// Setup the custom stylesheet used in the Theme Options
		add_action( 'parse_request', 'shaken_custom_styles' );
		
		// Customize dashboard widgets
		add_action('wp_dashboard_setup', 'shaken_dashboard_widgets');
		
	// Filters
		
		// No more jumping on Read More link
		add_filter('excerpt_more', 'no_more_jumping');
		
		// Show home link in wp_nav_menu() fallback
		add_filter( 'wp_page_menu_args', 'shaken_page_menu_args' );
		
		// Add featured images to RSS
		add_filter('pre_get_posts','feedFilter');
		
		// Add wmode='transparent' to auto embedded Flash videos
		add_filter('embed_oembed_html', 'add_video_wmode', 10, 3);
		
		// Allow shortcodes in text widgets
		add_filter('widget_text', 'shortcode_unautop');
		add_filter('widget_text', 'do_shortcode');
		
	/* Make theme available for translation
	 * Translations can be filed in the /languages/ directory */
	load_theme_textdomain( 'shaken', TEMPLATEPATH . '/languages' );
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
}
endif;

/** 
 * shaken_custom_background_cb()
 * Create a callback for custom backgrounds
 * Removes the old background so the user defined background can display.
 *
 * @since 1.6.0
**/
if(!function_exists('shaken_custom_background_cb')){
function shaken_custom_background_cb() {
	$background = get_background_image();
	$color = get_background_color();
	if ( ! $background && ! $color )
		return;
 
	$style = $color ? "background-color: #$color;" : '';
 
	if ( $background ) {
		$image = " background-image: url('$background');";
 
		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";
 
		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";
 
		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";
 
		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css">
body {background:none; <?php echo trim( $style ); ?> }
</style>
<?php }
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 */
function shaken_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

function shaken_register_menus(){
	register_nav_menus( array(
			'header' => __( 'Header Menu'),
	) );
}

// --------------  Register Menus -------------- 
function shaken_register_sidebars(){
	register_sidebar( array (
		'name' => 'Page Sidebar',
		'id' => 'page-sidebar',
		'description' => __( 'The sidebar on basic pages'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => "Unique Sidebar",
		'id' => 'unique-sidebar',
		'description' => __( 'The sidebar on pages with the template of "Unique Sidebar" assigned to them.'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => "Blog Post Sidebar",
		'id' => 'post-sidebar',
		'description' => __( 'The sidebar on blog post pages'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => 'Gallery Sidebar',
		'id' => 'gallery-sidebar',
		'description' => __( 'The sidebar on the gallery and archive pages'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

// smart jquery inclusion
if (!is_admin()) {
	wp_enqueue_script('jquery');
}

// enable threaded comments
function enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
			wp_enqueue_script('comment-reply');
		}
}

// no more jumping for read more link
if(!function_exists('no_more_jumping')){
function no_more_jumping($post) {
	return ' ...<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Lendo'.'</a>';
}}

// -------------- Add featured images to RSS feed --------------
if(!function_exists('feedContentFilter')){
function feedContentFilter($content) {
	$thumbId = get_post_thumbnail_id();
	
	$embed_code = get_post_meta(get_the_id(), 'soy_vid', true);
    $vid_url = get_post_meta(get_the_id(), 'soy_vid_url', true);
 	
	if($thumbId) {
		$img = wp_get_attachment_image_src($thumbId, 'col3');
		$image = '<img src="'. $img[0] .'" alt="" width="'. $img[1] .'" height="'. $img[2] .'" />';
		echo $image;
	}
 	
 	if($embed_code){
 		echo $embed_code;
 	} else if($vid_url){
 		echo '<p><strong><a href="'.$vid_url.'">View Video</a></strong></p>';
 	}
 	
	return $content;
}}

if(!function_exists('feedFilter')){
function feedFilter($query) {
	if ($query->is_feed) {
		add_filter('the_content', 'feedContentFilter');
		}
	return $query;
}}

// -------------- Custom Styles --------------
function shaken_custom_styles($wp) {
    if (
        !empty( $_GET['shaken-custom-content'] )
        && $_GET['shaken-custom-content'] == 'css'
    ) {
        header( 'Content-Type: text/css' );
        require dirname( __FILE__ ) . '/custom-styles.php';
        exit;
    }
}

// Add S&S RSS feed to dashboard
function shaken_rss_output(){
    echo '<div class="rss-widget">';
     
       wp_widget_rss_output(array(
            'url' => 'http://feeds.feedburner.com/shakenandstirredweb/MLnE',  //put your feed URL here
            'title' => 'Latest News from Shaken &amp; Stirred', // Your feed title
            'items' => 5, //how many posts to show
            'show_summary' => 1, // 0 = false and 1 = true 
            'show_author' => 0,
            'show_date' => 0
       ));
       
       echo "</div>";
}

// Add text dashboard widget
function shaken_twitter_dash_output(){
    echo '<div class="text-widget">';
     
	echo '<p>Follow Shaken and Stirred on <strong><a href="http://twitter.com/shakenweb" target="_blank">Twitter (@shakenweb)</a></strong> to stay up to date with the latest theme updates and new releases. You can also <strong><a href="http://shakenandstirredweb.com" target="_blank">visit our website</a></strong> to read our Tips &amp; Tricks to get the most out of your theme. We hope you enjoy our theme!</p>';
       
    echo "</div>";
}

// Add and remove dashboard widgets
function shaken_dashboard_widgets(){
	// Add custom widgets
	wp_add_dashboard_widget( 'shaken-twitter', 'Stay Updated!', 'shaken_twitter_dash_output');
  	wp_add_dashboard_widget( 'shaken-rss', 'Latest News from Shaken &amp; Stirred', 'shaken_rss_output');
	
	// Remove built-in dashboard widgets
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
}

// --------------  Custom Widgets  -------------- 
require_once ($widgets_path . 'flickr.php');
require_once ($widgets_path . 'twitter.php');
require_once ($widgets_path . 'category-posts.php');
require_once ($widgets_path . 'testimonials.php');
require_once ($widgets_path . 'related-posts.php');
require_once ($widgets_path . 'popular-posts.php');
require_once ($widgets_path . 'share.php');
require_once ($widgets_path . 'ads.php');

// --------------  Theme Options Panel --------------
require_once ($functions_path . 'framework-init.php');

// --------------  Custom Post Fields -------------- 
if( current_user_can( 'edit_posts' ) ){
	require_once ($functions_path . 'admin-custom.php');
}

// --------------  Custom Excerpt Lengths -------------- 
include_once ($functions_path . 'custom-excerpts.php');	

// --------------  Other custom functions -------------- 
require_once($functions_path . 'shaken-utils.php');
?>