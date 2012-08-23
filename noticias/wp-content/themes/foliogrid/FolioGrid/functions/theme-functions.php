<?php


/* determine column width */
function frogs_column_width($postID)
{	
	switch(get_post_meta($postID, 'columns', true))
	{
		case 'One':
		
			return 'post';
		
		break;
		
		default:
		
			return 'post';
		
		break;
	}
}

/* determine media type */
function frogs_media($postID)
{	
	switch(get_post_meta($postID, 'media_use', true))
	{
		case 'image':
		
			frogs_image($postID);
		
		break;
		
		default:
		
		break;
	}
}

function cssifysize($img) { 
$dimensions = getimagesize($img); 
$dimensions = str_replace("=\"", ":", $dimensions['3']); 
$dimensions = str_replace("\"", "px;", $dimensions); 
return $dimensions; 
} 

/* get image to insert into post header */
function frogs_image($postID)
{
	if(has_post_thumbnail())
	{
		$image_id = get_post_thumbnail_id();  
		$image_url = wp_get_attachment_image_src($image_id,frogs_column_width($postID));  
		$image_url = $image_url[0]; 

		echo '<a href="'.get_permalink($postID).'"><img src="'.$image_url.'" alt="" style="'.cssifysize($image_url).'" /></a>';
	}
	elseif(get_post_meta($postID, 'image', true) && frogs_column_width($postID)=='post')
	{
		$image_url = get_bloginfo('template_directory').'/assets/images/thumb200.jpg';
		echo '<a href="'.get_permalink($postID).'"><img src="'.$image_url.'" alt="" style="'.cssifysize($image_url).'" /></a>';
	}
	elseif(get_post_meta($postID, 'image', true) && frogs_column_width($postID)=='twocols')
	{
		$image_url = get_bloginfo('template_directory').'/assets/images/thumb430.jpg';
		echo '<a href="'.get_permalink($postID).'"><img src="'.$image_url.'" alt="" style="'.cssifysize($image_url).'" /></a>';
	}
}

/* goes into wp_head(); */
function frogs_wp_head()
{
	// stylesheet selector
	if($_REQUEST['style'])
	{
		$style = $_REQUEST['style'];
		$_SESSION['style'] = $style;
	}
	else
	{
		$style = $_SESSION['style'];
	}
	
	
	if ($style != '') 
	{
		$GLOBALS['stylesheet'] = $style;
		echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] .'/'.strtolower($GLOBALS['stylesheet']).'.css" rel="stylesheet" type="text/css" />'."\n";
	} 
	else 
	{ 
		$GLOBALS['stylesheet'] = of_get_option('ft_colour_scheme');
		
		if($GLOBALS['stylesheet'] != '')
		{
			echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] .'/'.strtolower($GLOBALS['stylesheet']).'.css" rel="stylesheet" type="text/css" />'."\n";
		}
		else
		{
			echo '<link href="'. get_bloginfo('template_directory') .'/styles/Light/light.css" rel="stylesheet" type="text/css" />'."\n";
		}
	} 
	
	// custom favicon
	if(of_get_option('ft_custom_favicon') != '') 
	{
		echo '<link rel="shortcut icon" href="'.  of_get_option('ft_custom_favicon')  .'"/>'."\n";
	}
	
	// custom css
	if(of_get_option('ft_custom_css')!='')
	{
		echo "\n<style type=\"text/css\">\n" . of_get_option('ft_custom_css') . "</style>\n";
	}
	
}

/* initialise scripts and css */
function frogs_init() {

	$file_dir=get_bloginfo('template_directory');
	
	if(!is_admin()):
		wp_deregister_script( 'jquery' );
	    //wp_register_script( 'jquery', $file_dir."/js/jquery.masonry.js");
	
		wp_enqueue_script("jquery", $file_dir."/assets/js/jquery.js", false, "1.4.2");
		wp_enqueue_script("jquery_masonry", $file_dir."/assets/js/jquery.masonry.js", false, "1.2.0");
	endif;
	
	if(is_admin()):
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http://code.jquery.com/jquery.min.js", false, false);
		wp_enqueue_script('jquery');
		
		wp_enqueue_style("admin-css", $file_dir."/functions/admin/admin.css", false, "1.0", "all");
		wp_enqueue_script("ft_script", $file_dir."/functions/admin/admin.js", false, "1.0");
	endif;
}


/* goes into wp_footer(); */
function frogs_wp_footer()
{	
	if(of_get_option('ft_tracking_code'))
	{
		echo stripslashes(of_get_option('ft_tracking_code'));	
	}
	
	// stylesheet selector
	if($_REQUEST['style'])
	{
		$style = $_REQUEST['style'];
		$_SESSION['style'] = $style;
	}
	else
	{
		$style = $_SESSION['style'];
	}
	
	if ($style == '')
	{ 
		$GLOBALS['stylesheet'] = of_get_option('ft_colour_scheme');
		
		if($GLOBALS['stylesheet'] != '')
		{
			echo '<script type="text/javascript" src="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] .'/'.strtolower($GLOBALS['stylesheet']).'.js"></script>'."\n";
		}
		else
		{
			echo '<script type="text/javascript" src="'. get_bloginfo('template_directory') .'/styles/Light/light.js"></script>'."\n";
		}
	}
	else
	{
		echo '<script type="text/javascript" src="'. get_bloginfo('template_directory') .'/styles/'. $GLOBALS['stylesheet'] .'/'.strtolower($GLOBALS['stylesheet']).'.js"></script>'."\n";
	}
}


/* excerpt reloaded functions */
function frog_wp_the_excerpt_reloaded($args='')
{
	parse_str($args);
	if(!isset($excerpt_length)) $excerpt_length = 120; // length of excerpt in words. -1 to display all excerpt/content
	if(!isset($allowedtags)) $allowedtags = '<a>'; // HTML tags allowed in excerpt, 'all' to allow all tags.
	if(!isset($filter_type)) $filter_type = 'none'; // format filter used => 'content', 'excerpt', 'content_rss', 'excerpt_rss', 'none'
	if(!isset($use_more_link)) $use_more_link = 1; // display
	if(!isset($more_link_text)) $more_link_text = "(more...)";
	if(!isset($force_more)) $force_more = 1;
	if(!isset($fakeit)) $fakeit = 1;
	if(!isset($fix_tags)) $fix_tags = 1;
	if(!isset($no_more)) $no_more = 0;
	if(!isset($more_tag)) $more_tag = 'div';
	if(!isset($more_link_title)) $more_link_title = 'Continue reading this entry';
	if(!isset($showdots)) $showdots = 1;

	return frog_the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots);
}

function frog_the_excerpt_reloaded($excerpt_length=120, $allowedtags='<a>', $filter_type='none', $use_more_link=true, $more_link_text="(more...)", $force_more=true, $fakeit=1, $fix_tags=true, $no_more=false, $more_tag='div', $more_link_title='Continue reading this entry', $showdots=true)
{
	if(preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) 
	{
		$filter_type = 'the_' . $filter_type;
	}
	echo frog_get_the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $no_more, $more_tag, $more_link_title, $showdots);
}

function frog_get_the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $no_more, $more_tag, $more_link_title, $showdots) 
{
	global $post;

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) { // and it doesn't match cookie
			if(is_feed()) { // if this runs in a feed
				$output = __('There is no excerpt because this is a protected post.');
			} else {
	            $output = get_the_password_form();
			}
		}
		return $output;
	}

	if($fakeit == 2) { // force content as excerpt
		$text = $post->post_content;
	} elseif($fakeit == 1) { // content as excerpt, if no excerpt
		$text = (empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { // excerpt no matter what
		$text = $post->post_excerpt;
	}

	if($excerpt_length < 0) 
	{
		$output = $text;
	} 
	else 
	{
		if(!$no_more && strpos($text, '<!--more-->')) 
		{
		    $text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} 
		else 
		{
			$text = explode(' ', $text);
			if(count($text) > $excerpt_length) 
			{
				$l = $excerpt_length;
				$ellipsis = 1;
			} 
			else 
			{
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . ' ';
	}

	if('all' != $allowed_tags) 
	{
		$output = strip_tags($output, $allowedtags);
	}

	//	$output = str_replace(array("\r\n", "\r", "\n", "  "), " ", $output);
	$output = rtrim($output, "\s\n\t\r\0\x0B");
	$output = ($fix_tags) ? $output : balanceTags($output);
	$output .= ($showdots && $ellipsis) ? '...' : '';

	switch($more_tag) 
	{
		case('div') :
			$tag = 'div';
		break;
		case('span') :
			$tag = 'span';
		break;
		case('p') :
			$tag = 'p';
		break;
		default :
			$tag = 'span';
	}

	if ($use_more_link && $more_link_text)
	{
		if($force_more)
		{
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post->ID) . '#more-' . $post->ID .'" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		} 
		else 
		{
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post->ID) . '" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		}
	}

	$output = apply_filters($filter_type, $output);

	return $output;
}
?>