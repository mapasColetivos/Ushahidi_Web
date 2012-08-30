<?php

/*
Plugin Name: FT Flickr Widget
Plugin URI: http://www.frogsthemes.com
Description: A widget to add your Flickr feed to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/

class FlickrWidget extends WP_Widget {
	                  
	function FlickrWidget() {
		# this builds the basic widget where everything else will pile into. 
		$widget_ops = array(
			'classname' => 'widget_flickr',
			'description' => 'A widget that grabs recent images from your Flickr account.'
		);
    $control_ops = array('width' => 200, 'height' => 350);
    $this->WP_Widget('FlickrWidget', __('FT Flickr Widget'), $widget_ops, $control_ops);                              
	} 
	          
		
	
	function form($instance) {
		# now this is right here is Sir Widget Form himself. In other, not-sleep-deprived words,
		# this generates the form that the user will see and interact with
   	$instance = wp_parse_args( (array) $instance, array( 'hif_title' => '') );
   	$hif_title = strip_tags($instance['hif_title']);
    $hif_userif = strip_tags($instance['hif_userif']); 
		$hif_numpics = strip_tags($instance['hif_numpics']); 
		$hif_imgWidth = strip_tags($instance['hif_imgWidth']);
		# just a quick note about _e() in Wordpress. You don't have to use it, but I see it in 
		# the best plugins and I'm pretty sure it's used for localisation stuff (that means translation) 
		?> 
	   <p><label for="<?php echo $this->get_field_id('hif_title'); ?>"><?php _e('Title:'); ?></label>
		 <input class="widefat" id="<?php echo $this->get_field_id('hif_title'); ?>" name="<?php echo $this->get_field_name('hif_title'); ?>" type="text" value="<?php echo esc_attr($hif_title); ?>" /></p>   
		 
		 <p><label for="<?php echo $this->get_field_id('hif_userif'); ?>"><?php _e('Flickr User ID:'); ?></label>
	   <br>
		 <input class="widefat" id="<?php echo $this->get_field_id('hif_userif'); ?>" name="<?php echo $this->get_field_name('hif_userif'); ?>" type="text" value="<?php echo esc_attr($hif_userif); ?>" />
		 <br>
		 <small><em>Don't know your ID? Please visit <a href="http://idgettr.com/">http://idgettr.com/</a> to find it.</em></small> 
		 </p>    
		
		 <p><label for="<?php echo $this->get_field_id('hif_numpics'); ?>"><?php _e('Number of Pictures to Display:'); ?></label>
	   <input maxlength="3" class="widefat" id="<?php echo $this->get_field_id('hif_numpics'); ?>" name="<?php echo $this->get_field_name('hif_numpics'); ?>" type="text" value="<?php echo esc_attr($hif_numpics); ?>" />
		 </p>
		
<?php
	}        
		          
	            
	
	function update($new_instance, $old_instance)  {
		# here, we're actually handling the updates that the user makes
		# strip_tags...strips any tags from previous inputs
		$instance = $old_instance;
		$instance['hif_title'] = strip_tags($new_instance['hif_title']);
		$instance['hif_userif'] = strip_tags($new_instance['hif_userif']);
		$instance['hif_numpics']= strip_tags($new_instance['hif_numpics']);
		$instance['hif_imgWidth']= strip_tags($new_instance['hif_imgWidth']);
		return $instance;          
	}                                                                          
	       
	
	
	function widget( $args, $instance ) {
      extract($args); 
			# classic widget instance stuff. very simple
      $hif_title = apply_filters('widget_hif_title', empty($instance['hif_title']) ? '' : $instance['hif_title'], $instance);
      $hif_userif = apply_filters('widget_hif_userif', empty($instance['hif_userif']) ? '' : $instance['hif_userif'], $instance);
      $hif_numpics = apply_filters('widget_hif_userif', empty($instance['hif_numpics']) ? '' : $instance['hif_numpics'], $instance);
      $hif_imgWidth = apply_filters('widget_hif_userif', empty($instance['hif_imgWidth']) ? '' : $instance['hif_imgWidth'], $instance);
      
      
			# this is mainly used by themes and such
			echo $before_widget;  
			  
				# here we grab the hif_title that was entered and throw on some sexy `<h3>` tags
     		$hif_title = $hif_title;
		 		if ( !empty( $hif_title ) ) { echo $before_title . $hif_title . $after_title; } 
					 
					 # first we create a div for the js to append the images to
 	 				 echo '<ul class="widget-flickr" id="flickr-images">';?>    
			       <script type="text/javascript">
						 	/* <![CDATA[ */ <?php
							 # technically, we don't have to `echo` anything that's not dynamic, but I
							 # echoed some non-variable things anyway just so it was easier for me to read and separate
               echo '$(document).ready(function() {'; 
               echo '$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=' .$hif_userif. '&format=json&jsoncallback=?", function(data) {';
               echo '    var target = "#flickr-images";'; 
							 # here, we just concatenate dem variables that were stored above and throw 'em into js vars 
							 echo '    var hifimgwidth = "60";';
               # setting i = 1 instead of = 0 is sort of a hack; if i = 0, a user entry would generate the user
							 # entry plus one. So if you entered 10, it would spit out 11 imgs. setting i = 1 corrected that
							 echo '      for (i = 1 ; i <=' .$hif_numpics .'; i = i + 1) {'; 
 								
               echo '                 var pic = data.items[i];';
               echo '                 var liNumber = i + 1;'; ?> 
                              $(target).append("<li class='f-thumb' style='padding:2px;'><div class='f-thumb-div'><a title='" + pic.hif_title + "' href='" + pic.link + "' target='_blank'><img width='120' src='" + pic.media.m + "' /></a></div></li>");
                          }
                         });
                      });
                  /* ]]> */ 			
             </script>      
 					 <?php echo '</ul>' /* close the div, captain */;
			 
			# again, mainly for themes and such. this closes the widget
      echo $after_widget;
  }


}

add_action('widgets_init', create_function('', 'return register_widget("FlickrWidget");'));

?>