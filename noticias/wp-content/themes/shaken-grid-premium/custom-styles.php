<?php // ===============================
//				Backgrounds
// ================================ ?>
#header{
	<?php $background = of_get_option('header_color');
		if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
			echo 'border:none 0;';
		elseif($background['color']):
			echo "background: $background[color];";
			echo 'border:none 0;';
		endif;	
    ?>
}
#footer{
	<?php $background = of_get_option('footer_color');
		if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
		elseif($background['color']):
			echo "background: $background[color];";
		endif;	
    ?>
}
<?php 
$background = of_get_option('container_color');
if( $background['image'] || $background['color'] ): 
?>

.box-content, .page-content, .flickr_badge_image, .jta-tweet-profile-image, .post-thumb{
	<?php if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
		elseif($background['color']):
			echo "background: $background[color];";
		endif;	
    ?>
}

.postmetadata, ol.commentlist li{
	border: 1px solid rgba(0, 0, 0, 0.12);
	background: none;
}

<?php endif; ?>

<?php // ===============================
//				Links
// ================================ ?>

a, a.more-link p, #sidebar a{
	color:<?php echo of_get_option('link_color'); ?>;
}
#footer a{
	color:<?php echo of_get_option('footer_link_color'); ?>;
}

<?php // ===============================
//				Text Color
// ================================ ?>
h1, h1 a, h2, h2 a, .box h2 a, .box h2, #page h2, #full-page h2, h3, h3 a, #page h3, #sidebar h3 a, .widget ul h3 a, .widget .cat-post-item h3 a, .recent-posts h3 a, h4, h5, h6{
	color:<?php echo of_get_option('headline_color'); ?>;
    <?php if(of_get_option('headline_color')) { echo 'text-shadow:none;'; } ?> 
}
body, blockquote, #single .post p, #single .post, .entry, .postmetadata, .postmetadata a, ol.commentlist li, .author-name{
	color:<?php echo of_get_option('body_text_color'); ?>;
}
.post-info p, #archives-page .box .post-info p, .jta-tweet-timestamp, cite, .box, .box blockquote, .comment-date, .reply a{
	color:<?php echo of_get_option('small_color'); ?>;
}
#footer{
	color:<?php echo of_get_option('footer_text_color'); ?>;
}

<?php // ===============================
//				Header
// ================================ ?>

#logo a, a #logo, #logo a:hover{
	color:<?php echo of_get_option('logo_title_color'); ?>;
}
#site-description{
	color:<?php echo of_get_option('logo_tagline_color'); ?>;
}

.header-nav li a, .header-nav li.current-menu-item li a, .header-nav li.current_page_ancestor li a{
	color:<?php echo of_get_option('nav_text_color'); ?>;
}
.header-nav li a:hover, .header-nav li.current-menu-item li a:hover, .header-nav li.current-menu-item a, .header-nav li.current_page_ancestor a, .header-nav li.current_page_ancestor li a:hover, .header-nav li.current_page_ancestor li.current-menu-item a{
    color:<?php echo of_get_option('nav_special_text_color'); ?>;
}
.header-nav ul ul{
	<?php $background = of_get_option('submenu_bg');
		if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
		elseif($background['color']):
			echo "background: $background[color];";
		endif;	
    ?>
}

#social-networks{
	<?php $background = of_get_option('social_bg');
		if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
			echo "-webkit-box-shadow:none;
			-moz-box-shadow:none;
			-o-box-shadow:none;
			box-shadow:none;";
		elseif($background['color']):
			echo "background: $background[color];";
			echo "-webkit-box-shadow:none;
			-moz-box-shadow:none;
			-o-box-shadow:none;
			box-shadow:none;";
		endif;	
    ?>
}

<?php // ===============================
//				Misc.
// ================================ ?>

h3.widget-title{
	<?php $background = of_get_option('widget_title_bg');
		if ($background['image']) :
			echo "background: url($background[image]) $background[position] $background[repeat] $background[attachment] $background[color];";
			echo 'text-shadow:none;';
		elseif($background['color']):
			echo "background: $background[color];";
			echo 'text-shadow:none;';
		endif;	
    ?>
    color:<?php echo of_get_option('widget_title_color'); ?>;
}

<?php // ======== Font families ========= ?>

<?php if(of_get_option('header_style') == 'serif') { ?>
    h1, h2, h3, h4, h5, h6, #logo, #logo a, #site-description, .postmetadata, .postmetadata strong{
        font-family:Georgia, "Times New Roman", Times, serif;
    }
    .wf-active .postmetadata{
        font-size:14px;
    }
<?php } ?>

<?php if(of_get_option('content_style') == 'serif') { ?>
    body, input, textarea, .header-nav ul ul li a, .header-nav li a{
        font-family:Georgia, "Times New Roman", Times, serif;
    }
    .wf-active .header-nav li{
    	font-size:18px;
    }
<?php } ?>
    
<?php // ===============================
//			Typography Options
// ================================ ?>

<?php // ======== Headlines ========= ?>

h1, .wf-active h1{
	font-size:<?php echo get_option('shaken_h1'); ?>px;
}
h2, .wf-active h2{
	font-size:<?php echo get_option('shaken_h2'); ?>px;
}
	.wf-active .box h2, .box h2, .wf-active .widget ul h3, .wf-active .widget .cat-post-item h3, .wf-active .recent-posts h3,
    .widget ul h3, .cat-post-item h3, .recent-posts h3{
    	font-size:<?php echo get_option('shaken_small_titles'); ?>px;
    }
h3, .wf-active h3{
	font-size:<?php echo get_option('shaken_h3'); ?>px;
}
	.wf-active h3.widget-title,  h3.widget-title{
    	font-size:<?php echo get_option('shaken_widget_title'); ?>px;
    }
h4, .wf-active h4{
	font-size:<?php echo get_option('shaken_h4'); ?>px;
}
h5, .wf-active h5{
	font-size:<?php echo get_option('shaken_h5'); ?>px;
}
h6, .wf-active h6{
	font-size:<?php echo get_option('shaken_h6'); ?>px;
}

<?php // ======== Content ========= ?>

body, p, ul, ol, .author-name{
	font-size:<?php echo get_option('shaken_body_text'); ?>px;
}
.box blockquote, .box, .box p, .box ul, .box ol, #footer p, cite, .jta-tweet-timestamp, .post-info p, #archives-page .box .post-info p, .comment-date, .reply a{
	font-size:<?php echo get_option('shaken_small_text'); ?>px;
}
blockquote{
	font-size:<?php echo get_option('shaken_blockquote'); ?>px;
}

<?php // ======== Header ========= ?>

.wf-active #logo, #logo{
	font-size:<?php echo get_option('shaken_logo_size'); ?>px;
}

.wf-active #site-description, #site-description{
	font-size:<?php echo get_option('shaken_tagline_size'); ?>px;
}

.wf-active .header-nav li, .header-nav li{
	font-size:<?php echo get_option('shaken_nav_size'); ?>px;
}
.header-nav ul ul li a{
	font-size:<?php echo get_option('shaken_subnav_size'); ?>px;
}

<?php echo get_option('shaken_custom_styles'); ?>