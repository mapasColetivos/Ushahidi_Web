=== Workaholic ===

** NOTE: Workaholic is a child theme for Modularity, a multimedia theme framework for WordPress. You must have Modularity installed for Workaholic to work. **

== About ==
**Contributors:** [Chandra Maharzan](http://graphpaperpress.com/about), designer/developer; [Thad Allender](http://graphpaperpress.com/about), founder/designer/developer; [Philip Arthur Moore](http://graphpaperpress.com/about), debugger/developer.
**Support** [Sign Up](http://graphpaperpress.com/members/signup.php), [Log In](http://graphpaperpress.com/members/member.php)
**Requires at least:** 2.9


== Installation ==
This section describes how to install Workaholic and get it working. 

	1. Download Workaholic from your Graph Paper Press [member dashboard](https://graphpaperpress.com/members/member.php) to your Desktop.
	2. Unzip workaholic.zip to your Desktop.	
		* Note: make sure that the extracted folder is `workaholic` and that your ZIP file has not created two levels of folders (for example, `workaholic/workaholic`).
	
	3. Go to `/wp-content/themes/` and make sure that you do not already have a `workaholic` folder installed. If you do, then back it up and remove it from `/wp-content/themes/` before uploading your copy of Workaholic.
	4. Upload `workaholic` to `/wp-content/themes/`.
	5. Activate Workaholic through the Appearance -> Themes menu in your WordPress Dashboard.
	6.In Wordpress, click on Media Settings. Set your thumbnails to 270 x 150. Set your medium photo size to 570. Set your large size to 950.
This theme will automatically create thumbnails from the images that you upload. By default, the thumbnail size is 270 x 150. This can be easily changed, if you know a little bit of CSS.
	7. If you plan on self-hosting your own video to use the theme's built-in HD video player, you need to use the Post Thumbnail text field on the Write Post panel and paste the URL to your video thumbnail. The dimensions of the thumbnail should exactly match the dimensions of the video dimensions that you plug into the Post Video Options panel.
				
		
		* Embeds
			** [checked] When possible, embed the media content from a URL directly onto the page. For example: links to Flickr and YouTube.
			** Maximum embed size
				*** Width: 620
				*** Height: 0

		
= Installation Troubleshooting =

If you've performed a clean install of workaholic and are having problems, make sure that the following conditions have been met: 
			* Make sure that you've installed the theme properly. You should use an FTP program like FileZilla, WinSCP, or Fetch to upload your files. Do not use WordPress' Install a theme in .zip format option.
			* Permissions: On most servers, the theme files should be set to 644 and folders should be set to 755
			* Make sure that you've deactivated all of your plugins before installing and/or upgrading if you continue to have theme activation problems.
			* Your workaholic folder should be named `workaholic`. Do not rename this folder.
			* If you are upgrading your version of workaholic, make sure to backup first and completely delete your old version of workaholic from your server before uploading the new version of workaholic to your server. With version 1.1 and above, the upgrading has been made simpler. You can go to workaholic -> Updates in your menu, add your API key from your [member dashboard](https://graphpaperpress.com/members/member.php) and click the Update button.
			* workaholic uses jQuery for much of its functionality. If parts of your theme appear broken or unresponsive, then you likely have a JavaScript conflict being caused by an active plugin. Deactivate your plugins, one-by-one, to determine which plugin is conflicting with jQuery.
			

			
== Description ==
Workaholic is a child theme for Modularity, a multimedia theme framework for Wordpress. You must have Modularity installed for Workaholic to work. The theme design was developed with users who appreciate visual browsing and prefer a minimal layout, with their photos and multimedia featured front and center. But, the theme can been used to create everything from e-commerce sites, music review sites, portfolio sites, and everything in between. Homepage designs can be turned on and off at the click of a button on the Theme Options panel.

= Full list of major features: =
	* Separate Blog and Portfolio section
	* Blog lists posts as normal blog
	* Portfolio pulls latest thumbnail of the post and lists each of 	them on three columns
	* Multiple image gallery container (slider) on portfolio posts
	* Basic Theme Options
	* Twitter integrated - shows latest Tweet
	* Separate sidebar on Portfolio and normal sidebar on Blog
	* One Page template with separate sidebar
	* Ability to have a separate desired Thumbnail if WP-Post-Thumbnail 	plugin is installed
	* jQuery effects on Portfolio thumbnails
	* Multi-level Drop Down Menu
	* Support Nested Comments
	* Three footer widgets
	* Uses 960 css framework and jQuery javascript framework
	* XHTML: This theme has been tested on Firefox, Safari, IE 8, 7.

	
= Modifications =

If you want to make changes to how this theme looks and feels, than create a child theme. Never make changes to the original theme files. Why? Because when a new version of this theme is released, all of your changes will be lost when you update. Plus, making a child theme is incredibly easy. More information on that here (http://op111.net/53/)

= Setting Up Portfolio Slider =

When you post a new post, click the Add an Image button (small icon on the top of the post text area). You will get the Add an Image window. Click Select Files and select your images / screenshots. Once you upload an image or a set of images, click Save Changes. Don't click Insert into Post button. Then close the Add an Image window. You will not get any text / images on the post text area but these images has been added to the database. You can write up any additional text about the portfolio item.

Below your post text area, you should see the area called Excerpt. Add any one line excerpt that describes the portfolio item. This excerpt will be used in the sidebar (under Similar Projects). The sidebar on each Portfolio item shows 10 other items from the same category randomly.

= Thumbnails =

By default, thumbnails are auto cropped by Wordpress. You can override these crops in WordPress 2.9. This is the order in which the theme attempts to grab an image to use as a post thumbnail:

1. Looks for an image by custom field called "thumbnail".
2. If no image is added by custom field, it checks for a post image (WordPress 2.9+ feature).
3. If no image is found, it grabs the latest image attached to your post using the Add Media icon.
4. If no image is attached, it can extract an image from your post content (off by default).
5. If no image is found at this point, it will defer to a default image.				
* Regenerate your thumbnails with the [Regenerate Thumbnails](http://wordpress.org/extend/plugins/regenerate-thumbnails/) WordPress plugin.


= Embed multimedia into Posts or Pages: =

	* For externally hosted videos (for example a YouTube or Vimeo video), you can directly paste the link of your video page into the content editor. You do not have to paste the embed code. WordPress will automatically embed the video from the link.`

= Widgets: =

	* There are a total of four widgetized areas on this theme in addition to the default sidebar. The bottom area on the homepage three-column area is 100% widgetized. You can add and delete widgets by clicking Appearance -> Widgets, from within your Wordpress admin panel.

= Advertising =

	* This theme has two built-in spots for advertising: One in the sidebar, which measures 310 pixels wide, and one underneath the main post, which measures 590 pixels wide. You can add your adversing code on the Theme Options panel.


= WordPress 3.0+ support =

	* To add menu to your website, go to Appearance -> Menus and add a new menu. You can then add categories, pages and custom links to this new menu. You can also drag and drop menus around to make sub menus or reorder them.

	
== Changelog ==
These are the changes seen by Workaholic since it was first available for public download.

= Version 1.0 (June 18, 2009) =
	* Initial release