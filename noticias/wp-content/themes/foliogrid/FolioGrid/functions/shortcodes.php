<?php

/*
*
* Author: FrogsThemes
* File: shortcodes
*
*
*/

// underline_h1
function underline_h1($atts, $content = null) {
	return '<h1 class="widget-title">'.do_shortcode($content).'</h1>';
}
add_shortcode('underline_h1', 'underline_h1');

// Add left 1/2 column
function half($atts, $content = null) {
	return '<div class="one_half">'.do_shortcode($content).'</div>';
}
add_shortcode('half', 'half');

// Add right 1/2 column
function half_last($atts, $content = null) {
	return '<div class="one_half omega">'.do_shortcode($content).'</div>';
}
add_shortcode('half_last', 'half_last');


// Add left 1/3 column
function third($atts, $content = null) {
	return '<div class="one_third">'.do_shortcode($content).'</div>';
}
add_shortcode('third', 'third');

// Add right 1/3 column
function third_last($atts, $content = null) {
	return '<div class="one_third omega">'.do_shortcode($content).'</div>';
}
add_shortcode('third_last', 'third_last');


// Add left 2/3 column
function two_third($atts, $content = null) {
	return '<div class="two_third">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third', 'two_third');

// Add right 2/3 column
function two_third_last($atts, $content = null) {
	return '<div class="two_third omega">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third_last', 'two_third_last');


// Add left 1/4 column
function fourth($atts, $content = null) {
	return '<div class="one_fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('fourth', 'fourth');

// Add right 1/4 column
function fourth_last($atts, $content = null) {
	return '<div class="one_fourth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('fourth_last', 'fourth_last');


// Add left 3/4 column
function three_fourth($atts, $content = null) {
	return '<div class="three_fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth', 'three_fourth');

// Add right 3/4 column
function three_fourth_last($atts, $content = null) {
	return '<div class="three_fourth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth_last', 'three_fourth_last');


// Add left 1/5 column
function fifth($atts, $content = null) {
	return '<div class="one_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('fifth', 'fifth');

// Add right 1/5 column
function fifth_last($atts, $content = null) {
	return '<div class="one_fifth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('fifth_last', 'fifth_last');


// Add left 2/5 column
function two_fifth($atts, $content = null) {
	return '<div class="two_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth', 'two_fifth');

// Add right 2/5 column
function two_fifth_last($atts, $content = null) {
	return '<div class="two_fifth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth_last', 'two_fifth_last');


// Add left 3/5 column
function three_fifth($atts, $content = null) {
	return '<div class="three_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth', 'three_fifth');

// Add right 3/5 column
function three_fifth_last($atts, $content = null) {
	return '<div class="three_fifth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth_last', 'three_fifth_last');


// Add left 4/5 column
function four_fifth($atts, $content = null) {
	return '<div class="four_fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth', 'four_fifth');

// Add right 4/5 column
function four_fifth_last($atts, $content = null) {
	return '<div class="four_fifth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth_last', 'four_fifth_last');


// Add left 1/6 column
function sixth($atts, $content = null) {
	return '<div class="one_sixth">'.do_shortcode($content).'</div>';
}
add_shortcode('sixth', 'sixth');

// Add right 1/6 column
function sixth_last($atts, $content = null) {
	return '<div class="one_sixth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('sixth_last', 'sixth_last');


// Add left 5/6 column
function five_sixth($atts, $content = null) {
	return '<div class="five_sixth">'.do_shortcode($content).'</div>';
}
add_shortcode('five_sixth', 'five_sixth');

// Add right 5/6 column
function five_sixth_last($atts, $content = null) {
	return '<div class="five_sixth omega">'.do_shortcode($content).'</div>';
}
add_shortcode('five_sixth_last', 'five_sixth_last');


// Add row divider
function row_divider($atts, $content = null) {
	return '<div class="row-divider">'.do_shortcode($content).'</div>';
}
add_shortcode('row_divider', 'row_divider');


// back to top
function back_to_top($atts, $content = null) {
	return '<div class="row"><div class="hr"><a href="#top" class="scrollTop">'.do_shortcode($content).'</a></div></div>';
}
add_shortcode('back_to_top', 'back_to_top');


// info box
function info_box($atts, $content = null) {
	return '<div class="alert-box info clear">'.do_shortcode($content).'</div>';
}
add_shortcode('info_box', 'info_box');


// alert box
function alert_box($atts, $content = null) {
	return '<div class="alert-box alert clear">'.do_shortcode($content).'</div>';
}
add_shortcode('alert_box', 'alert_box');


// tick box
function tick_box($atts, $content = null) {
	return '<div class="alert-box tick clear">'.do_shortcode($content).'</div>';
}
add_shortcode('tick_box', 'tick_box');


// error box
function error_box($atts, $content = null) {
	return '<div class="alert-box error clear">'.do_shortcode($content).'</div>';
}
add_shortcode('error_box', 'error_box');


// download box
function download_box($atts, $content = null) {
	return '<div class="alert-box download clear">'.do_shortcode($content).'</div>';
}
add_shortcode('download_box', 'download_box');


// help box
function help_box($atts, $content = null) {
	return '<div class="alert-box help clear">'.do_shortcode($content).'</div>';
}
add_shortcode('help_box', 'help_box');


// button_small
function button_small($atts, $content = null) {
	return '<a href="'.$atts['href'].'" class="button small">'.do_shortcode($content).'</a>';
}
add_shortcode('button_small', 'button_small');


// button_standard
function button_standard($atts, $content = null) {
	return '<a href="'.$atts['href'].'" class="button">'.do_shortcode($content).'</a>';
}
add_shortcode('button_standard', 'button_standard');


// button_large
function button_large($atts, $content = null) {
	return '<a href="'.$atts['href'].'" class="button large">'.do_shortcode($content).'</a>';
}
add_shortcode('button_large', 'button_large');


// lightbox_single
function lightbox_single($atts, $content = null) {
	return '<p><a href="'.$atts['large'].'" rel="prettyPhoto" title="'.$atts['title'].'"><img src="'.$atts['thumb'].'" alt="'.$atts['alt'].'" title="'.$atts['title'].'" class="imageHover" /></a></p>';
}
add_shortcode('lightbox_single', 'lightbox_single');

// lightbox_gallery
function lightbox_gallery($atts, $content = null) {
	$gallery_images = explode(',', $atts['large']);
	$gallery_titles = explode(',', $atts['title']);
	$lightbox_gallery = '<p><a href="'.$gallery_images[0].'" rel="prettyPhoto[gallery]"><img src="'.$atts['thumb'].'" alt="'.$gallery_titles[0].'" class="imageHover" /></a></p>';
    $lightbox_gallery .= '<div class="hidden">';
	for($i=1; $i<count($gallery_images); $i++):
		$lightbox_gallery .= '<a href="'.$gallery_images[$i].'" rel="prettyPhoto[gallery]"><img src="'.$atts['thumb'].'" alt="'.$gallery_titles[$i].'" class="imageHover" /></a>';
	endfor;
	$lightbox_gallery .= '</div>';
	
	return $lightbox_gallery;
}
add_shortcode('lightbox_gallery', 'lightbox_gallery');


// lightbox_flash
function lightbox_flash($atts, $content = null) {
	return '<p><a href="'.$atts['url'].'?width='.$atts['width'].'&amp;height='.$atts['height'].'" class="button" rel="prettyPhoto[flash]" title="'.$atts['title'].'">'.$content.'</a></p>';
}
add_shortcode('lightbox_flash', 'lightbox_flash');


// lightbox_youtube
function lightbox_youtube($atts, $content = null) {
	return '<p><a href="'.$atts['url'].'" class="button" rel="prettyPhoto" title="'.$atts['title'].'">'.$content.'</a></p>';
}
add_shortcode('lightbox_youtube', 'lightbox_youtube');


// lightbox_vimeo
function lightbox_vimeo($atts, $content = null) {
	return '<p><a href="'.$atts['url'].'" class="button" rel="prettyPhoto" title="'.$atts['title'].'">'.$content.'</a></p>';
}
add_shortcode('lightbox_vimeo', 'lightbox_vimeo');


// lightbox_quicktime
function lightbox_quicktime($atts, $content = null) {
	return '<p><a href="'.$atts['url'].'?width='.$atts['width'].'&amp;height='.$atts['height'].'" rel="prettyPhoto[movies]" class="button" rel="prettyPhoto" title="'.$atts['title'].'">'.$content.'</a></p>';
}
add_shortcode('lightbox_quicktime', 'lightbox_quicktime');


// lightbox_website
function lightbox_website($atts, $content = null) {
	return '<p><a href="'.$atts['url'].'?iframe=true&width=100%&height=100%" class="button" rel="prettyPhoto" title="'.$atts['title'].'">'.$content.'</a></p>';
}
add_shortcode('lightbox_website', 'lightbox_website');
?>