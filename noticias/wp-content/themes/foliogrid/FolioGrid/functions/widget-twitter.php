<?php

/*
Plugin Name: FT Twitter Widget
Plugin URI: http://www.frogsthemes.com
Description: A widget to add your last Tweets to your sidebar.
Author: FrogsThemes.com
Version: 1
Author URI: http://www.frogsthemes.com
*/


class TwitterWidget extends WP_Widget {
    
	/** constructor */
    function TwitterWidget() {
        
		$options = array( 'description' => __('A widget to add your last Tweets to your sidebar.') );
		
		parent::WP_Widget(false, $name = 'FT Twitter Widget', $options);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		
		?>
		<?php echo $before_widget; ?>
		<h3 class="f-widget-title title-twitter"><?php echo $title; ?></h3>
		<ul id="twitter_update_list" class="widget-twitter twitter_update_list">
			<li>Twitter</li>
		</ul>
		<script type="text/javascript">

		function twitterCallback2(twitters) {
		  var statusHTML = [];
		  for (var i=0; i<twitters.length; i++){
			var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			  return '<a href="'+url+'">'+url+'</a>';
			}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
			});
			statusHTML.push('<li><span>'+status+'</span> <a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');
		  }
		  jQuery('.twitter_update_list').html(statusHTML.join(''));
		}
		
		function relative_time(time_value) {
		  var values = time_value.split(" ");
		  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		  var parsed_date = Date.parse(time_value);
		  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		  delta = delta + (relative_to.getTimezoneOffset() * 60);
		
		  if (delta < 60) {
			return 'less than a minute ago';
		  } else if(delta < 120) {
			return 'about a minute ago';
		  } else if(delta < (60*60)) {
			return (parseInt(delta / 60)).toString() + ' minutes ago';
		  } else if(delta < (120*60)) {
			return 'about an hour ago';
		  } else if(delta < (24*60*60)) {
			return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
		  } else if(delta < (48*60*60)) {
			return '1 day ago';
		  } else {
			return (parseInt(delta / 86400)).toString() + ' days ago';
		  }
		}
		
		</script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo strtolower($instance['ft_twittter_user']);?>.json?callback=twitterCallback2&amp;count=2"></script>
		<p class="follow-link">Follow <a href="http://twitter.com/#!/<?php echo $instance['ft_twittter_user'];?>" target="_blank">@<?php echo $instance['ft_twittter_user'];?></a></p>
		<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['ft_twittter_user'] = strip_tags($new_instance['ft_twittter_user']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
		$ft_twittter_user = esc_attr($instance['ft_twittter_user']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('ft_twittter_user'); ?>"><?php _e('Twitter Username:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('ft_twittter_user'); ?>" name="<?php echo $this->get_field_name('ft_twittter_user'); ?>" type="text" value="<?php echo $ft_twittter_user; ?>" />
        </p>
        <?php
	}

}

// register TwitterWidget widget
add_action('widgets_init', create_function('', 'return register_widget("TwitterWidget");'));


?>