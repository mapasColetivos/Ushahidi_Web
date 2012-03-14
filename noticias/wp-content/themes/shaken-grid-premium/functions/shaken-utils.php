<?php
/*
 * @since 1.6
 * @alter 2.0
 */

// Add wmode=transparent 
if(!function_exists('add_video_wmode')){
function add_video_wmode($html, $url, $attr) {
   if (strpos($html, "<embed src=" ) !== false && strpos($html, "wmode=\"transparent\"" ) !== true) {
		$html = str_replace('</param><embed', '</param><param name="wmode" value="transparent"></param><embed wmode="transparent" ', $html);
		return $html;
   } else {
		return $html;
   }
}}
 
// -------------- Custom Comment Structure -------------- 
if ( ! function_exists( 'shaken_comment' ) ) :
function shaken_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
        	<div class="author-avatar"><?php echo get_avatar( $comment, 35 ); ?></div>
            
            <div class="comment-meta">
                <span class="author-name"><?php printf( __( '%s', 'shaken' ), sprintf( '%s', get_comment_author_link() ) ); ?></span>
                <span class="comment-date"><?php printf( __( '%1$s at %2$s', 'shaken' ), get_comment_date( get_option( 'date_format' ) ),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)', 'shaken' ), ' ' );?></span>
            </div><!-- .comment-meta -->
        
			<?php if ( $comment->comment_approved == '0' ) : ?>
                <em><?php _e( 'Your comment is awaiting moderation.', 'shaken' ); ?></em>
                <br />
            <?php endif; ?>
			
			<?php comment_text(); ?>
            
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
		</div><!-- #comment-ID -->
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'shaken' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'shaken'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
} endif; 

/*
Plugin Name: WP-Archives
Plugin URI: http://blog.unijimpe.net/
Description: Display your archives with year/month list.
Version: 0.8
Author: Jim Penaloza Calixto
Author URI: http://blog.unijimpe.net
*/
if(!function_exists('shaken_timeline')){
function shaken_timeline() {
global $month, $wpdb, $wp_version;
	$now = current_time('mysql');
	
	if (version_compare($wp_version, '2.1', '<')) {
		$current_posts = "post_date < '$now'";
	} else {
		$current_posts = "post_type='post'";
	}
    $arcresults = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts  FROM " . $wpdb->posts . " WHERE post_status='publish' AND $current_posts AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC");
    
    if ($arcresults) {
        foreach ($arcresults as $arcresult) {
            $url = get_month_link($arcresult->year, $arcresult->month);
            $text = sprintf('%s %d', $month[zeroise($arcresult->month,2)], $arcresult->year);
            echo "<h2 class='month-header'>" . $text . "</h2>\n";
           
            $thismonth = zeroise($arcresult->month,2);
            $thisyear = $arcresult->year;        

            $arcresults2 = $wpdb->get_results("SELECT ID, post_date, post_title, comment_status FROM " . $wpdb-> posts . " WHERE post_date LIKE '$thisyear-$thismonth-%' AND $current_posts AND post_status='publish' AND post_password='' ORDER BY post_date DESC");
            
            if ($arcresults2) {
            	echo "<div class=\"sort\">\n";
                foreach ($arcresults2 as $arcresult2) {
					if ($arcresult2->post_date != '0000-00-00 00:00:00') {
                         $url = get_permalink($arcresult2->ID);
                         $arc_title = $arcresult2->post_title;
						 $arc_post_type = get_post_format($arcresult2->ID);
						 
						 $args = array(
							'post_type' => 'attachment',
							'post_mime_type' => 'image',
							'numberposts' => 1,
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'post_parent' => $arcresult2->ID
						);
						$images = get_posts($args);
						$first_attachment = false;
							
						foreach($images as $image){	
							$first_attachment = wp_get_attachment_image($image->ID, 'col1');
						}
						 
						 if($arc_post_type == ''){
							 $arc_post_type = 'standard';
						 }

                         if ($arc_title) {
						 	$text = strip_tags($arc_title);
                         } else {
						 	$text = $arcresult2->ID;
						 }
                         $title_text = esc_html($text);
                         echo "<div class=\"box col1\">
                         <div class=\"box-content\">
                         <a href=\"" . $url . "\" title=\"" . $title_text . "\" class=\"". $arc_post_type . "\">";
                         
                         if(has_post_thumbnail($arcresult2->ID)){
                         	echo get_the_post_thumbnail($arcresult2->ID, 'col1');
                         } else if($first_attachment){
                         	echo wp_get_attachment_image($image->ID, 'col1');
                         }
                         
                         echo wptexturize($text) . "</a>
                         </div></div>\n";
                     }
                }
                echo "</div>\n";
            }
        }
    }
}}

///////////////////////////////////////////
// Returns the URL of the video image
///////////////////////////////////////////
if(!function_exists('shaken_get_image_url')){
function shaken_get_image_url($url){
	$image_src = parse_url($url);
	if($image_src['host'] == 'www.vimeo.com' || $image_src['host'] == 'vimeo.com' || $image_src['host'] == 'player.vimeo.com'){
		parse_str($image_src['query'], $query);
		if(isset($query['clip_id']) && $query['clip_id'] != ""){
			$id = $query['clip_id'];
		} else {
			$path = explode("/",$image_src['path']);
			$id = $path[(count($path)-1)];
		}
		if(function_exists('curl_init')){;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = unserialize(curl_exec($ch));
			$output = $output[0]['thumbnail_small'];
			curl_close($ch);
			return $output;	
		}
	}
	else if($image_src['host'] == 'www.youtube.com' || $image_src['host'] == 'youtube.com'){
		parse_str($image_src['query'], $query);
		if(isset($query['v']) && $query['v'] != ""){
			$id = $query['v'];
		} else {
			$path = explode("/",$image_src['path']);
			$id = $path[count($path)-1];
		}
		return "http://img.youtube.com/vi/".$id."/default.jpg";				
	} else{
		return false;
	}
}}

?>