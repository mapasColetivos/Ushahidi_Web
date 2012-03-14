<?php
/*
Plugin Name: Easy Facebook Share Thumbnails
Plugin URI: http://hebeisenconsulting.com/wordpress-ios-icon-for-wordpress/
Description: The post's featured image is used as the thumbnail when the page is being shared on facebook. A default image can also be specified.
Version: 1.7
Author: Hebeisen Consulting - R Bueno
Author URI: http://www.hebeisenconsulting.com
License: A "Slug" license name e.g. GPL2

   Copyright 2011 Hebeisen Consulting

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Thanks to Ryan Hemeon for fixing database prefix bug.
   
                                http://ryan-hemeon.is-a-geek.com/

Wordpress admin settings and core installation
*/

add_action('admin_menu', 'fbthumbnails_menu');
add_action('wp_head', 'fbthumbnails_head');
add_option('fbthumbnails_head_section', '');
add_option('fbthumbnails_link_rel', '');
define('PLUGINPATH', ABSPATH . 'wp-content/plugins/easy-facebook-share-thumbnails');
define('PLUGINLINK', get_bloginfo('siteurl') . '/wp-content/plugins/easy-facebook-share-thumbnails/');

//Check if featured immage is supported on current theme
//If not, set it on      
if(!function_exists('the_post_thumbnail()')){
	add_theme_support( 'post-thumbnails' ); 
}

//plugin installation
//create ew table upon activating plugin
function fbthumbnails_install()
{
    global $wpdb;
    $table = $wpdb->prefix . "fbthumbnails";
	if($wpdb->get_var("show tables like '$table'") != $table) {
	    $sql = "CREATE TABLE " . $table . " (
					  id int(11) NOT NULL AUTO_INCREMENT,
					  thumbnail varchar(150) NOT NULL,
					  path text NOT NULL,
					  url text NOT NULL,
					  active INT(1) NOT NULL,
					  PRIMARY KEY (id)
					)";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	    dbDelta($sql);
	}
}
register_activation_hook(__FILE__,'fbthumbnails_install');

//plugin <head></head> overriding
function fbthumbnails_head()
{
	global $wpdb;	
	global $post;
	$table = $wpdb->prefix . "fbthumbnails";
	   $post_id = $post;	    
		    if ((is_single($post_id) || is_page($post_id))  && has_post_thumbnail($post->ID))
		    {
		    	$post_id = $post_id->ID;
		      	$site_title = get_the_title($post->ID);
		      	$fb_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($thumbnail->ID, 'thumbnail'));
		      	$post_var = get_post($post_id, ARRAY_A);
		        $raw_content = $post_var['post_content'];		        
			$content = substr( strip_tags($raw_content), 0, strpos( $raw_content, "." ) + 1 );
			//$content = strpos( $raw_content, "." );
	
			 echo "\n";
			 echo "\n";
			 echo "<!-- Easy Facebook Share Thumbnails --><!-- Post type with Featured image -->";
			 echo "\n";
			 echo '<meta property="og:title" content="'. $site_title . '"/>' . "\n";
			 echo '<meta property="og:type" content="article"/>' . "\n";
			 echo '<meta property="og:url" content="' . get_permalink($post_id->ID) . '"/>' . "\n";
			 echo '<meta property="og:image" content="' . $fb_thumbnail_src[0] . '"/>' . "\n";
			 echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>' . "\n";
			 echo '<meta property="og:description" content="' . $content . '"/>' . "\n";
			 echo '<link rel="image_src" href="' . $fb_thumbnail_src[0] . '"/>' . "\n";
			 echo "<!-- Easy Facebook Share Thumbnails -->";
			 echo "\n";
			 echo "\n";
		    }		    
		    else //if( is_single($post_id) || is_page($post_id))
		    {		 	
		 	//use default image instead
		 	//select active thumbnail in database
		 	$active = $wpdb->get_row("SELECT * FROM $table WHERE active = '1'", ARRAY_A);
		 	$image = $active['url'];
		 	$post_id = $post_id->ID;
		      	$site_title = get_the_title($post->ID);		      	
		      	$post_var = get_post($post_id, ARRAY_A);
		        $raw_content = $post_var['post_content'];
			$content = substr( strip_tags($raw_content), 0, strpos( $raw_content, "." ) + 1 ); 
		 	 
		 	 echo "\n";
		 	 echo "\n";
		 	 echo "<!-- Easy Facebook Share Thumbnails --><!-- Post type using default image -->";
			 echo "\n";
			 echo '<meta property="og:title" content="'. get_bloginfo('name') . '"/>' . "\n";
			 echo '<meta property="og:type" content="article"/>' . "\n";
			 echo '<meta property="og:url" content="' . get_bloginfo('wpurl') . '"/>' . "\n";
			 echo '<meta property="og:image" content="' . $image . '"/>' . "\n";
			 echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>' . "\n";
			 echo '<meta property="og:description" content="' . get_bloginfo('description') . '"/>' . "\n";
			 echo '<link rel="image_src" href="' . $image . '"/>' . "\n";
			 echo "<!-- Easy Facebook Share Thumbnails -->";
			 echo "\n";
			 echo "\n";

		   }
}

//Wordpress admin menu
function fbthumbnails_menu()
{
	add_options_page('Easy Facebook Share Thumbnails', 'Easy Facebook Share Thumbnails', 'manage_options', 'facebook-thumbnail-slug', 'facebook_thumbnail_option');
}

function facebook_thumbnail_option()
{
	global $wpdb;	
	$table = $wpdb->prefix . "fbthumbnails";
	switch( $_GET['a'] )
		{
			case'delete-thumbnail':
				//delete thumbnail
				//perform deletion
				$wpdb->query("DELETE FROM $table WHERE id = '".$_GET['ID']."'"); 
				echo '<div id="message" class="updated fade"><p>Thumbnail deleted.</p></div>';				
			break;
			case'activate-thumbnail':
				//activate thumbnail
				//select current activate thumbnail		
				$active = $wpdb->get_row("SELECT * FROM $table WHERE active = '1'", ARRAY_A);		
				
				//and turn it off
				$wpdb->query( "UPDATE $table SET active = '0' WHERE id = '" . $active['id'] . "'" );
				
				//activate currently selected thumbnail from $_GET['id']
				$wpdb->query( "UPDATE $table SET active = '1' WHERE id = '" . $_GET['ID'] . "'" );
				echo '<div id="message" class="updated fade"><p>Thumbnail Activated.</p></div>';
			break;
			case'add-new-thumbnail':
				
				//image directories
				$upload_dir = wp_upload_dir();
				//add new thumbnail			
				//image name generator
				$image_name = md5(rand());
				
				//determin active value
				if($_POST['active'] == ""){
				
				 //not use as default
				 // leave setting as it is
				 $active = "0";
				 
				 //validate data
				if($_POST['thumbnail'] == ""){
				 echo '<div id="message" class="updated fade"><p>Please enter Thumbnail.</p></div>';
				}else{
				 
				 //determine image type
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_GIF )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".gif"; 
				  $url = $upload_dir['url'] . $image_name . ".gif";
				 }
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".jpeg"; 
				  $url = $upload_dir['url'] . $image_name . ".jpeg";
				 }
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_PNG )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".png"; 
				  $url = $upload_dir['url'] . $image_name . ".png";
				 }		  
				  
				  //check file upload if image 
				  if((exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_GIF ) || (exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG ) || (exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_PNG ))
				  {
				  	//validate image
				  	 //perform operation
					 if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {	
					 
					 //insert database
					 $wpdb->insert( $table, array(
									'thumbnail' => $_POST['thumbnail'],
									'path' => $target_path,
									'url' => $url,
									'active' => $active )
									);
					 //declare success message
					 echo '<div id="message" class="updated fade"><p>Success!.</p></div>';
					 
					 }else{
					 
					 //declare error message
					 echo '<div id="message" class="updated fade"><p>There was an error uploading the file, please try again!</p></div>' . $target_path;
					 
					 }
				  }
				  else
				  {
				  	 
				  	//unrecognised, declare error and stop operation
				   	echo '<div id="message" class="updated fade"><p>File type is not supported. Make sure it is either .PNG, .GIF, .JPEG only.</p></div>';
				  }
				}
				 
				}else{
				
				//use as default
				//first, deactivate currently used thumbnail
				// then set the new thumbnail as default
				
				//select current activate thumbnail		
				$fbthm = $wpdb->get_row("SELECT * FROM $table WHERE active = '1'", ARRAY_A);
				
				//and turn it off
				$wpdb->query( "UPDATE $table SET active = '0' WHERE id = '" . $fbthm['id'] . "'" );
				
				$active = "1";
				 
				 //validate data
				if($_POST['thumbnail'] == ""){
				 echo '<div id="message" class="updated fade"><p>Please enter Thumbnail.</p></div>';
				}else{
				 
				 //determine image type
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_GIF )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".gif"; 
				  $url = $upload_dir['url'] . $image_name . ".gif";
				 }
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".jpeg"; 
				  $url = $upload_dir['url'] . $image_name . ".jpeg";
				 }
				 if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_PNG )
				 {
				  $target_path = $upload_dir['path'] . $image_name . ".png"; 
				  $url = $upload_dir['url'] . $image_name . ".png";
				 } 
				
				 //check file upload if image 
				  if((exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_GIF ) || (exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG ) || (exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_PNG ))
				  {
				  	//validate image
				  	 //perform operation
					 if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {	
					 
					 //insert database
					 $wpdb->insert( $table, array(
									'thumbnail' => $_POST['thumbnail'],
									'path' => $target_path,
									'url' => $url,
									'active' => $active )
									);
					 //declare success message
					 echo '<div id="message" class="updated fade"><p>Success!.</p></div>';
					 
					 }else{
					 
					 //declare error message
					 echo '<div id="message" class="updated fade"><p>There was an error uploading the file, please try again!</p></div>' . $target_path;
					 
					 }
				  }
				  else
				  {
				  	 
				  	//unrecognised, declare error and stop operation
				   	echo '<div id="message" class="updated fade"><p>File type is not supported. Make sure it is either .PNG, .GIF, .JPEG only.</p></div>';
				  }
				}
				
				}
			break;
		}
	switch($_GET['page']) {		
		case 'facebook-thumbnail-slug':		
?>
<?php
	
	$record = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table;"));
		if ( $record != "0" )
			{
?>
		<div class="wrap">
		 <h2>Welcome to Easy Facebook Share Thumbnail</h2>
		 <div class="postbox">
		  <table class="form-table">
		   <tr valign="top" class="alternate">
		    <th scope="row"><label>Thumbnail</label></th><th scope="row"><label>Activate</label></th><th scope="row"><label>Action</label></th>
		   </tr>
<?php

			foreach( $wpdb->get_results("SELECT * FROM $table;") as $key => $row) {
			// each column in your row will be accessible like this
			$thumbnail = $row->thumbnail;
			$url = $row->url;
			$activate = $row->active;
?>
		    <tr><td><img src = "<?php echo $url; ?>" width = "50px"></td><td><?php if($activate == "1"){ echo "Yes"; } else { echo "No"; }; ?></td><td><input type="submit" class="button-primary" value = "Delete" onClick = "location.href='options-general.php?page=facebook-thumbnail-slug&a=delete-thumbnail&ID=<?php echo $row->id; ?>';"> <?php if($activate == "1") {?><input type="submit" class="button-primary" value = "Currently Used Thumbnail"><?php }else{ ?> <input type="submit" class="button-primary" value = "Activate" onClick = "location.href='options-general.php?page=facebook-thumbnail-slug&a=activate-thumbnail&ID=<?php echo $row->id; ?>';"><?php } ;?></td></tr>
<?php
				}				
?>		   	
 		  </table>
 		 </div>
		</div>
<?php
			}
?>
		<div class="wrap">
		<form method="post" enctype="multipart/form-data" action="options-general.php?page=facebook-thumbnail-slug&a=add-new-thumbnail">
		<input type="hidden" name="" id="info_update1" value="true" />
		 <h2>Upload New Thumbnail</h2>
		 <div class="postbox">
		  <table class="form-table">
		   <tr valign="top" class="alternate"><th scope="row"style="width:32%;" ><label>Thumbnail Name:</label></th><td><input type = "text" name = "thumbnail"></td></tr>
		   <tr valign="top" class="alternate"><th scope="row"style="width:32%;" ><label>Use Thumbnail as Default:</label></th><td><input type = "checkbox" name = "active"></td></tr>	  
		   <tr valign="top" class="alternate"><th scope="row"style="width:32%;" ><label>Image:</label></th><td><input type = "file" name = "image"></td></tr> 
		   <tr valign="top" class="alternate"><th scope="row"style="width:32%;" ></th><td><input type="submit" class="button-primary" value = "Submit"></td></tr> 
		  </table>
		 </div>
		</form>
		</div>
<?php
		break;
	}
}
?>