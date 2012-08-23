=== On Assignment ===

** NOTE: On Assignment is a child theme for Modularity, a multimedia theme framework for WordPress. You must have Modularity installed for On Assignment to work. **

== About ==
**Contributors:** [Chandra Maharzan](http://graphpaperpress.com/about), designer/developer; [Thad Allender](http://graphpaperpress.com/about), founder/designer/developer; [Philip Arthur Moore](http://graphpaperpress.com/about), debugger/developer.
**Support** [Sign Up](http://graphpaperpress.com/members/signup.php), [Log In](http://graphpaperpress.com/members/member.php)
**Requires at least:** 2.9


== Installation ==
This section describes how to install On Assignment and get it working. 

	1. Download On Assignment from your Graph Paper Press [member dashboard](https://graphpaperpress.com/members/member.php) to your Desktop.
	2. Unzip on-assignment.zip to your Desktop.	
		* Note: make sure that the extracted folder is `on-assignment` and that your ZIP file has not created two levels of folders (for example, `on-assignment/on-assignment`).
	
	3. Go to `/wp-content/themes/` and make sure that you do not already have a `on-assignment` folder installed. If you do, then back it up and remove it from `/wp-content/themes/` before uploading your copy of On Assignment.
	4. Upload `on-assignment` to `/wp-content/themes/`.
	5. Activate On Assignment through the Appearance -> Themes menu in your WordPress Dashboard.
	6.Go to Settings -> Media and make sure to enter the following values:	
		* Image sizes		
			** Thumbnail size
				*** Width: 150
				*** Height: 150
				*** [checked] Crop thumbnails to exact dimensions (normally thumbnails are proportional)
				
			** Medium size
				*** Max Width: 270
				*** Max Height: 0
				
			** Large size
				*** Max Width: 950
				*** Max Height: 0
				
		
		* Embeds
			** [checked] When possible, embed the media content from a URL directly onto the page. For example: links to Flickr and YouTube.
			** Maximum embed size
				*** Width: 620
				*** Height: 0
				
		
		* Embeds
			** [checked] When possible, embed the media content from a URL directly onto the page. For example: links to Flickr and YouTube.
			** Maximum embed size
				*** Width: 620
				*** Height: 0

		
= Installation Troubleshooting =

If you've performed a clean install of on-assignment and are having problems, make sure that the following conditions have been met: 
			* Make sure that you've installed the theme properly. You should use an FTP program like FileZilla, WinSCP, or Fetch to upload your files. Do not use WordPress' Install a theme in .zip format option.
			* Permissions: On most servers, the theme files should be set to 644 and folders should be set to 755
			* Make sure that you've deactivated all of your plugins before installing and/or upgrading if you continue to have theme activation problems.
			* Your on-assignment folder should be named `on-assignment`. Do not rename this folder.
			* If you are upgrading your version of on-assignment, make sure to backup first and completely delete your old version of on-assignment from your server before uploading the new version of on-assignment to your server. With version 1.1 and above, the upgrading has been made simpler. You can go to on-assignment -> Updates in your menu, add your API key from your [member dashboard](https://graphpaperpress.com/members/member.php) and click the Update button.
			* on-assignment uses jQuery for much of its functionality. If parts of your theme appear broken or unresponsive, then you likely have a JavaScript conflict being caused by an active plugin. Deactivate your plugins, one-by-one, to determine which plugin is conflicting with jQuery.
			

			
== Description ==
On Assignment is a child theme for Modularity, a multimedia theme framework for Wordpress. You must have Modularity installed for On Assignment to work. The theme design was developed with users who appreciate visual browsing and prefer a minimal layout, with their photos and multimedia featured front and center. But, the theme can been used to create everything from e-commerce sites, music review sites, portfolio sites, and everything in between. Homepage designs can be turned on and off at the click of a button on the Theme Options panel.

= Full list of major features: =
	* Theme options panel to configure homepage design, easy logo 		insertion, css style override, ability to insert ads and more
	* Built-in HD video player for self-hosting HD quality video, 		multiple videos in a post
	* Automatic thumbnail generator with the ability to override the 	automated thumbnails
	* Ability to embed any kind of Flash media via custom fields
	* Built atop CSS frameworks to speed customization
	* Three footer widgets
	* Multi-tier drop-down navigation to maximize homepage space
	* Forward and backward compatibility with previous versions of 		WordPress
	* XHTML: This theme has been tested on Firefox, Safari, IE 8, 7.

	
= Modifications =

If you want to make changes to how this theme looks and feels, than create a child theme. Never make changes to the original theme files. Why? Because when a new version of this theme is released, all of your changes will be lost when you update. Plus, making a child theme is incredibly easy. More information on that here (http://op111.net/53/)

= Theme Options =

This theme has seven optional homepage designs:

	* Slideshow Section - A full page slideshow
	* HD Video Section - A full page video presentation
	* Featured Sliding Posts - A horizontal slider that reveals six 	featured posts
	* Thumbnail Slider - A horizontal list of thumbnails representing 	recent posts
	* Featured Section - A main post at left, with three earlier posts 	at right
	* Blog Section- A normal tubular list of posts
	* Categories Section - A five column grid of selected categories

Please activate each option and view your new homepage design. Remember, less is more.

= Thumbnails =

Every Post needs to have a Featured Image assigned to it.  You can assign a Featured Image by uploading an image to the Post, and then click the "Use as featured image" button to make the image the Featured Image for that post.  [Watch a video tutorial](http://vimeo.com/8462281).

If you are migrating from an old theme to a new theme and your thumbnails look squished or distorted, you might need to re-upload the image you plan on using for the post thumbnail. This is because WordPress creates your image sizes based on the dimensions you specified above. Old thumbnails will not be automatically resized.  You can regenerate your thumbnails with the [Regenerate Thumbnails](http://wordpress.org/extend/plugins/regenerate-thumbnails/) WordPress plugin.

= Built-in HD video player for self-hosted HD-quality videos; multiple videos per Post or Page are supported: =

	* The built-in video player plays FLV files. To add a video to a Post or Page, create a custom field key/value pair of `video | http://your-domain.com/path/to/your/video/file.flv`.
	* In order to set a thumbnail for your video player, create a custom field key/value pair of `video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`
	* For multiple videos within a Post or Page, enter more than 1 custom field key/value pair for `video|URL` and `video-thumb|URL`, for example:
		** `video | http://your-domain.com/path/to/your/video/file.flv`
		** `video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`
		** `video | http://your-domain.com/path/to/your/video/file-2.flv`
		** `video-thumb | http://your-domain.com/path/to/your/video/thumbnail-2.jpg`


= Embed multimedia into Posts or Pages: =

	* For externally hosted videos (for example a YouTube or Vimeo video), you can directly paste the link of your video page into the content editor. You do not have to paste the embed code. WordPress will automatically embed the video from the link.`

= Navigation = 

	* The navigation contains a listing of all your pages and posts, your contact info and the search bar. You can set or remove the contact info from the Theme Options panel.

= Widgets: =

	* There are a total of three widgetized areas on this theme, depending on which options you activate on the Theme Options panel. Three widgetized areas appear on the bottom and there is one sidebar widget. You can add and delete widgets by clicking Design - Widgets, from within your Wordpress admin panel..

= Advertising =

	* This theme has two built-in spots for advertising: One in the sidebar, which measures 310 pixels wide, and one underneath the main post, which measures 590 pixels wide. You can add your adversing code on the Theme Options panel.


= WordPress 3.0+ support =

	* To add menu to your website, go to Appearance -> Menus and add a new menu. You can then add categories, pages and custom links to this new menu. You can also drag and drop menus around to make sub menus or reorder them.

	
== Changelog ==
These are the changes seen by On Assignment since it was first available for public download.

= Version 1.0 (October 1, 2009) =
	* Initial release