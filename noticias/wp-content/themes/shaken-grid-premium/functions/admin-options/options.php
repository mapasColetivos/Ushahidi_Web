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
 * Displays a message that options aren't available in the current theme
 *  
 */

function optionsframework_options() {
		
		$images_path = get_template_directory_uri() . '/images/';
		$skins_array = array("default" => "Default","bumble-bee" => "Bumble Bee","mint" => "Mint","fancy" => "Fancy","silver" => "Silver","blue" => "Blue","rose" => "Rose","dark" => "Dark");
		$typography_styles = array("default" => "Sans Serif","serif" => "Serif");
		$box_sizes = array("col1" => "135px","col2" => "310px","col3" => "485px","col4" => "660px");
		
		$google_fonts = array(
			'PT+Sans:400,700:latin' => 'PT Sans (sans-serif)', 
			'Yanone+Kaffeesatz:regular,bold' => 'Yanone Kaffeesatz (original | sans-serif)',
			'Arvo:400:latin' => 'Arvo (slab serif)',
			'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister (handwriting)',
			'Oswald:latin' => 'Oswald (gothic)'
		);
		
		// Pull all the categories into an array
		$options_categories = array();  
		$options_categories_obj = get_categories();
		$options_categories['all'] = 'All Categories';
		foreach ($options_categories_obj as $category) {
	    	$options_categories[$category->cat_ID] = $category->cat_name;
		}
		
		/* ********************************************************
								Thank You
		******************************************************** */
		$options[] = array( "name" => "Thank You",
							"type" => "heading");
		
		$options[] = array( "name" => "Thank you!",
							"desc" => "Thank you for purchasing from <a href=\"http://shakenandstirredweb.com\">Shaken and Stirred</a>. To stay up to date with the latest theme updates and releases, <a href=\"http://twitter.com/shakenweb\">follow us on Twitter</a>",
							"type" => "info");
		
		$options[] = array( "name" => "Documentation, Changelog, and Support",
							"desc" => "<ul>
							<li><a href=\"http://support.shakenandstirredweb.com/shaken-grid\">Documentation, FAQ, and Changelog</a></li>
							<li><a href=\"http://shakenandstirredweb.com/theme-support\">Theme Support</a> (please read the Documentation first)</li>
							<li><a href=\"http://shakenandstirredweb.com/tips-tricks\">Tips &amp; Tricks</a></li>
							</ul>",
							"type" => "info");
		
		/* ************************************************
						General Settings
		************************************************ */
		
		$options[] = array( "name" => "General",
							"type" => "heading");
		
		$options[] = array( "name" => "Frontpage Category",
							"desc" => "Choose what category is displayed on the frontpage",
							"id" => "frontpage_category",
							"std" => "all",
							"type" => "select",
							"options" => $options_categories);
							
		$options[] = array( "name" => "Display all posts on main blog page",
							"desc" => "Removes pagination and displays all posts.",
							"id" => "show_all",
							"std" => false,
							"type" => "checkbox");
							
		$options[] = array( "name" => "Hide filter options",
							"desc" => "These are only visible on the main blog page",
							"id" => "hide_filters",
							"std" => false,
							"type" => "checkbox");
		
		$options[] = array( "name" => "Hide the view/share/comment buttons",
							"desc" => "These are the buttons that display when you hover over a post on the gallery pages.",
							"id" => "hide_action_buttons",
							"std" => false,
							"type" => "checkbox");
		
		$options[] = array( "name" => "Copyright Text",
							"desc" => "Add text after &copy; Copyright",
							"id" => "copyright",
							"type" => "text");
		
		/* ************************************************
						Social Networks
		************************************************ */
		$options[] = array( "name" => "Social",
							"type" => "heading");		
		
		$options[] = array( "name" => "This theme supports the Social Bartender plugin",
							"desc" => "Don't see a social network option below or want to use your own icons? Install the Social Bartender WordPress plugin to add whatever links and icons that you want.",
							"type" => "info");
		
		$options[] = array( "name" => '<img src="'.$images_path.'twitter-ic-16.png" width="16" height="16" alt="" /> Twitter',
						"desc" => "Twitter username",
						"id" => "twitter",
						"type" => "text");
		
		$options[] = array( "name" => '<img src="'.$images_path.'facebook-ic-16.png" width="16" height="16" alt="" /> Facebook',
						"desc" => "Enter the full Facebook Page URL",
						"id" => "facebook",
						"type" => "text");
		
		$options[] = array( "name" => '<img src="'.$images_path.'youtube.png" width="16" height="16" alt="" /> YouTube',
						"desc" => "YouTube username",
						"id" => "youtube",
						"type" => "text");
		
		$options[] = array( "name" => '<img src="'.$images_path.'vimeo.png" width="16" height="16" alt="" /> Vimeo',
						"desc" => "Vimeo username",
						"id" => "vimeo",
						"type" => "text");
						
		$options[] = array( "name" => '<img src="'.$images_path.'flickr-ic-16.png" width="16" height="16" alt="" /> Flickr',
						"desc" => "Flickr username",
						"id" => "flickr",
						"type" => "text");
		
		$options[] = array( "name" => '<img src="'.$images_path.'delicious-ic-16.png" width="16" height="16" alt="" /> Delicious',
						"desc" => "Delicious username",
						"id" => "delicious",
						"type" => "text");	
						
		$options[] = array( "name" => '<img src="'.$images_path.'lastFM-ic-16.png" width="16" height="16" alt="" /> last.FM',
						"desc" => "last.FM username",
						"id" => "last_fm",
						"type" => "text");	
						
		$options[] = array( "name" => '<img src="'.$images_path.'dribbble-ic-16.png" width="16" height="16" alt="" /> Dribbble',
						"desc" => "Dribbble username",
						"id" => "dribbble",
						"type" => "text");
		
		$options[] = array( "name" => '<img src="'.$images_path.'email-ic-16.png" width="16" height="16" alt="" /> Email',
						"desc" => "Email Address",
						"id" => "email",
						"type" => "text");
						
		$options[] = array( "name" => '<img src="'.$images_path.'rss.png" width="16" height="16" alt="" /> Custom RSS Feed',
						"desc" => "If you have a custom RSS feed setup through a service like Feedburner, enter its URL here",
						"id" => "rss",
						"type" => "text");
						
		$options[] = array( "name" => "Hide RSS icon",
							"desc" => "Remove the RSS link from the social network bar in the header.",
							"id" => "hide_rss",
							"std" => false,
							"type" => "checkbox");

		/* ************************************************
						Look & Feel
		************************************************ */
		$options[] = array( "name" => "Styles",
						"type" => "heading");
						
		$options[] = array( "name" => "Logo",
							"desc" => "Upload your custom logo and click &quot;Use This Image&quot;",
							"id" => "logo",
							"type" => "upload");
		
		$options[] = array( "name" => "Theme Skin",
							"desc" => "Change the color scheme of your theme",
							"id" => "alt_stylesheet",
							"std" => "default",
							"type" => "select",
							"options" => $skins_array);
		
		/* ******************************************** Backgrounds ******************************************** */				
		$options[] = array( "name" => "Backgrounds",
							"desc" => "The following options allow you to customize the background of your theme elements. To customize the background of the site, head to Appearance &rarr; Background in the sidebar.",
							"type" => "info");
		
		$options[] = array( "name" => "Header Background",
							"desc" => "The background of the header",
							"id" => "header_color",
							"std" => "",
							"type" => "background");
		
		$options[] = array( "name" => "Sub-menu Background",
							"desc" => "The background of the sub-menus",
							"id" => "submenu_bg",
							"std" => "",
							"type" => "background");
		
		$options[] = array( "name" => "Social Networks Background",
							"desc" => "The background of the social networks container in the header",
							"id" => "social_bg",
							"std" => "",
							"type" => "background");
		
		$options[] = array( "name" => "Content Containers Background",
							"desc" => "Page container and post boxes",
							"id" => "container_color",
							"std" => "",
							"type" => "background");
		
		$options[] = array( "name" => "Widget Title Background",
							"desc" => "The background of the titles in the sidebar",
							"id" => "widget_title_bg",
							"std" => "",
							"type" => "background");
		
		$options[] = array( "name" => "Footer Background",
							"desc" => "The background of the footer",
							"id" => "footer_color",
							"std" => "",
							"type" => "background");				
							
		/* ******************************************** Logo ******************************************** */					
		$options[] = array( "name" => "Logo Colors",
							"desc" => "The following options allow you to customize the colors of your logo and tagline.",
							"type" => "info");	
		
		$options[] = array( "name" => "Logo Title Color",
							"desc" => "Typically your site/company title",
							"id" => "logo_title_color",
							"std" => "",
							"type" => "color");									
		
		$options[] = array( "name" => "Logo Tagline Color",
							"desc" => "Site description",
							"id" => "logo_tagline_color",
							"std" => "",
							"type" => "color");
		
		/* ******************************************** Header Menu ******************************************** */
		$options[] = array( "name" => "Navigation Menu Items",
							"desc" => "The following options allow you to customize the colors of the text displayed in your header navigation menu.",
							"type" => "info");
		
		$options[] = array( "name" => "Menu text color",
							"desc" => "The color of the nav menu's links",
							"id" => "nav_text_color",
							"std" => "",
							"type" => "color");									
		
		$options[] = array( "name" => "Current menu item and menu item hover text color",
							"desc" => "The color of the elements of the current page being displayed, and the color of the link when you hover over it.",
							"id" => "nav_special_text_color",
							"std" => "",
							"type" => "color");
		
		/* ******************************************** Text ******************************************** */
		$options[] = array( "name" => "Text Color",
							"desc" => "The following options allow you to customize the colors of the text displayed in your theme.",
							"type" => "info");
		
		$options[] = array( "name" => "Headlines",
							"desc" => "The color of the headlines",
							"id" => "headline_color",
							"std" => "",
							"type" => "color");									
		
		$options[] = array( "name" => "Body Text",
							"desc" => "Paragraphs, lists, blockquotes, and other important text elements.",
							"id" => "body_text_color",
							"std" => "",
							"type" => "color");
		
		$options[] = array( "name" => "Unemphasized Text",
							"desc" => "Citations, notes, grid box content. Typically lower contrast than the body text.",
							"id" => "small_color",
							"std" => "",
							"type" => "color");
							
		$options[] = array( "name" => "Widget Title",
							"desc" => "The title above each widget in the sidebar",
							"id" => "widget_title_color",
							"std" => "",
							"type" => "color");	
		
		$options[] = array( "name" => "Links",
							"desc" => "The color of links",
							"id" => "link_color",
							"std" => "",
							"type" => "color");
		
		$options[] = array( "name" => "Footer Text",
							"desc" => "Color of the text displayed in the footer of the theme",
							"id" => "footer_text_color",
							"std" => "",
							"type" => "color");
							
		$options[] = array( "name" => "Footer Links",
							"desc" => "The color of links in the footer",
							"id" => "footer_link_color",
							"std" => "",
							"type" => "color");						
										
		/* ************************************************
						  Typography
		************************************************ */
		$options[] = array( "name" => "Typography",
							"type" => "heading");
		
		$options[] = array( "name" => "Font Stack #1",
							"desc" => "The Google Web Font used on headlines and the navigation links.",
							"id" => "header_fontface",
							"type" => "select",
							"options" => $google_fonts);
		
		$options[] = array( "name" => "Logo Font",
							"desc" => "The Google Web Font used on the logo",
							"id" => "logo_fontface",
							"std" => 'Oswald:latin',
							"type" => "select",
							"options" => $google_fonts);
				
		$options[] = array( "name" => "Disable Google Web Fonts",
							"desc" => 'This theme imports a typeface from <a href="http://code.google.com/webfonts">Google Web Fonts</a> to use on the headlines',
							"id" => "disable_fontface",
							"std" => false,
							"type" => "checkbox");
							
		$options[] = array( "name" => "Headline Style",
							"desc" => "Change the font style of the headlines (disable Google Web Fonts to use this)",
							"id" => "header_style",
							"std" => "default",
							"type" => "select",
							"options" => $typography_styles);
							
		$options[] = array( "name" => "Body Text Style",
							"desc" => "Change the font style of the main body text",
							"id" => "content_style",
							"std" => "default",
							"type" => "select",
							"options" => $typography_styles);
		
		/* ************************************************
						Advertisments
		************************************************ */
		
		$options[] = array( "name" => "Ads",
							"type" => "heading");
							
		$options[] = array( "name" => "Ad Size",
							"desc" => "Choose the size of the box that will hold your ad",
							"id" => "ads_size",
							"std" => "col1",
							"type" => "select",
							"options" => $box_sizes);
		
		$options[] = array( "name" => "Hide ads on frontpage",
							"desc" => "Don't display the ads on the homepage",
							"id" => "ads_home",
							"std" => false,
							"type" => "checkbox");
							
		$options[] = array( "name" => "Custom Ad Code",
							"desc" => "If the advertiser has supplied their own code, you can paste it here.",
							"id" => "ads_custom",
							"type" => "textarea"); 	
		
		/* ******************************************** Ad One ******************************************** */				
							
		$options[] = array( "name" => "Ad One &mdash; Image",
							"desc" => "Upload your image and click &quot;Use This Image&quot;",
							"id" => "ad_one_img",
							"type" => "upload");
							
		$options[] = array( "name" => "Ad One &mdash; URL",
							"desc" => "The URL the user is taken to when they click the ad",
							"id" => "ad_one_link",
							"type" => "text");
		
		/* ******************************************** Ad One ******************************************** */				
		$options[] = array( "name" => "Ad Two &mdash; Image",
							"desc" => "Upload your image and click &quot;Use This Image&quot;",
							"id" => "ad_two_img",
							"type" => "upload");
							
		$options[] = array( "name" => "Ad Two &mdash; URL",
							"desc" => "The URL the user is taken to when they click the ad",
							"id" => "ad_two_link",
							"type" => "text");
								
	return $options;
}