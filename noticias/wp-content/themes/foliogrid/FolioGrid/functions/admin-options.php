<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Theme colours
	$ft_colour_scheme = array("Dark" => "Dark", "Light" => "Light", "Yellow" => "Yellow", "Red" => "Red", "Purple" => "Purple", "Blue" => "Blue", "Green" => "Green");
	
	// Nivo slider transitions
	$ft_nivo_effects = array("random" => "Random", "sliceDown" => "Slice Down", "sliceDownLeft" => "Slice Dwon Left", "sliceUp" => "Slice Up", "sliceUpLeft" => "Slice Up Left", "sliceUpDown" => "Slice Up Down", "sliceUpDownLeft" => "Slice Up Down Left", "fold" => "Fold", "fade" => "Fade", "slideInRight" => "Slide In Right", "slideInLeft" => "Slide In Left", "boxRandom" => "Box Random", "boxRain" => "Box Rain", "boxRainReverse" => "Box Rain Reverse", "boxRainGrow" => "Box Rain Grow", "boxRainGrowReverse" => "Bow Rain Grow Reverse");
	
	// Background Defaults
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/functions/images/';
		
	$options = array();
		
	$options[] = array( "name" => "General Settings",
						"type" => "heading");
	
	$options[] = array( "name" => "Custom Logo",
						"desc" => "Upload a logo for your theme or add a URL to a logo elsewhere.",
						"id" => "ft_custom_logo",
						"type" => "upload");
	
	$options[] = array( "name" => "Custom CSS",
						"desc" => "Paste your custom CSS in here.",
						"id" => "ft_custom_css",
						"std" => "",
						"type" => "textarea");
	
	$options[] = array( "name" => "Custom Favicon",
						"desc" => "Paste the URL of a 16 x 16px <a href='http://www.favicon.co.uk/' target=\"_blank\">.ico image</a> for your theme.",
						"id" => "ft_custom_favicon",
						"type" => "text");
	
	$options[] = array( "name" => "RSS URL",
						"desc" => "Enter your preferred RSS URL here (e.g. http://feeds.feedburner.com/frogsthemes).",
						"id" => "ft_rss_url",
						"std" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Footer",
						"type" => "heading");
	
	$options[] = array( "name" => "Tracking Code",
						"desc" => "Paste your Google Analytics (or other) code in here so it can be added in the footer of your site.",
						"id" => "ft_tracking_code",
						"std" => "",
						"type" => "textarea"); 
	
	$options[] = array( "name" => "Copyright Text",
						"desc" => "Enter the text for your copyright here.",
						"id" => "ft_footer_copyright",
						"std" => "",
						"type" => "text");
								
	return $options;
}