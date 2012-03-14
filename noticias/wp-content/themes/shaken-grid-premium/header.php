<?php
/**
 * Header Template
 *
 * This file is responsible for generating the
 * top-most html for all public-facing views.
 * It's content is generated via core WordPress
 * functions as well as custom actions defined
 * in functions.php.
 *
 * Child themes are encouraged to work with the
 * actions defined herein to add or remove data
 * to/from the top of the template. In the event
 * that the html needs to be modified, this
 * template may be duplicated inside a child theme
 * and edited there.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.0
 * @alter        2.0
 *
 */
 ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'shaken' ), max( $paged, $page ) );

?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?v=3" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox-1.3.4.css" />

<?php 
/* Alternate Stylesheet selected in Theme Options */
if( of_get_option('alt_stylesheet') && of_get_option('alt_stylesheet') != "default" ): ?>
	
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/skins/<?php echo of_get_option('alt_stylesheet'); ?>.css" media="screen" />
	
<?php endif; ?>

<?php /* Custom styles set in Theme Options */ ?>
<link rel="stylesheet" href="<?php bloginfo('url'); ?>/?shaken-custom-content=css&v=2" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/custom.css" />

<?php wp_head(); ?>

<?php 
// @font-face (Google Web Fonts) 
if( !of_get_option('disable_fontface') ): ?>
	
	<?php if( of_get_option('header_fontface') ):
		$header_ff_name = explode( ':', of_get_option('header_fontface') ); // grab font name
		
		$header_ff_clean = str_replace( '+', '-', $header_ff_name[0] ); // hyphenate
		
		$header_ff_name = str_replace( '+', ' ', $header_ff_name[0] ); // add spaces
		
		$header_ff_clean = strtolower( $header_ff_clean ); // lowercase
	else:
		// Defaults
		$header_ff_name = "PT Sans";
		$header_ff_clean = 'pt-sans';
	endif; ?>
	
	<script type="text/javascript">
	    WebFontConfig = {
	    	google: { families: [ '<?php echo of_get_option( 'header_fontface' ); ?>' ] }
	    };
	    (function() {
	    var wf = document.createElement('script');
	    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	    wf.type = 'text/javascript';
	    wf.async = 'true';
	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(wf, s);
	    })();
    </script>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/<?php echo $header_ff_clean; ?>.css" />
    
    <?php if( of_get_option( 'logo_fontface' ) && of_get_option( 'logo_fontface' ) != of_get_option( 'header_fontface' ) ) :
    
		$logo_ff_clean = of_get_option( 'logo_fontface' ); // grab entire font string
		$logo_ff_name = explode( ':', $logo_ff_clean ); // grab font name
		$logo_ff_name = str_replace( '+', ' ', $logo_ff_name[0] ); // add spaces
		$load_single = true;
		
	elseif( of_get_option( 'logo_fontface' ) && of_get_option( 'header_fontface' ) == of_get_option( 'logo_fontface' ) ):
	
		$logo_ff_name = $header_ff_name;
		$logo_ff_clean = of_get_option( 'header_fontface' );
		$load_single = false;
		
	else:
		
		// Defaults
		$logo_ff_name = 'Oswald';
		$logo_ff_clean = 'Oswald';
		$load_single = true;
				
	endif; ?>
	
	<?php if( $load_single ): ?>
    	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo $logo_ff_clean; ?>&text=<?php echo urlencode( esc_attr( get_bloginfo( 'name', 'display' ) ) ); ?>">
    <?php endif; ?>
    
    <style>
    	#logo{
    		font-family: "<?php echo $logo_ff_name; ?>", "Myriad Pro", Helvetica Neue, Arial, sans-serif;
    	}
    </style>
	
<?php endif; ?>

<?php 
/* Insert Analytics Code set in Theme Options (Option deprecated in 1.6.0 - Use a plugin instead) */
if (get_option('shaken_analytics_code') ){ echo get_option('shaken_analytics_code'); } ?>

</head>

<body <?php body_class(); ?>>

<div id="header">
	<?php /* Logo and Tagline */ ?>
	<div id="site-info">
    
    	<?php if( of_get_option('logo') ) : 
    		$logo_size = getimagesize( of_get_option('logo') );
    	?>

            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
           	 <img src="<?php echo of_get_option('logo'); ?>" alt="<?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?>" title="<?php bloginfo( 'name' ); ?>" id="logo" />
            </a>

        <?php else: ?>

			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			
            <<?php echo $heading_tag; ?> id="logo">
                
                <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                
            </<?php echo $heading_tag; ?>>
            
            <div id="site-description"><?php bloginfo( 'description' ); ?></div>

      	<?php endif; ?>
        
    </div><!-- #site-info -->
    
    <?php /* Main Menu */ ?>
    <div class="header-nav">
    	<?php wp_nav_menu( array( 'theme_location' => 'header', 'container' => '' ) ); ?>
    </div>
    
    <?php /* Social network links set in Theme Options */ ?>
    <div id="social-networks">
		<?php if(of_get_option('twitter')){ ?>
            <a href="http://twitter.com/<?php echo of_get_option('twitter'); ?>" title="Twitter">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/twitter-ic-16.png" alt="Twitter" />
            </a>
        
		<?php } 
		if(of_get_option('facebook')){ ?>
            <a href="<?php echo of_get_option('facebook'); ?>" title="Facebook">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/facebook-ic-16.png" alt="Facebook" />
            </a>
        
		<?php } 
		if(of_get_option('youtube')){ ?>
            <a href="http://www.youtube.com/user/<?php echo of_get_option('youtube'); ?>" title="YouTube">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" alt="YouTube" />
            </a>
            
        <?php } 
		if(of_get_option('vimeo')){ ?>
            <a href="http://www.vimeo.com/<?php echo of_get_option('vimeo'); ?>" title="Vimeo">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/vimeo.png" alt="Vimeo" />
            </a>
        
		<?php } 
		if(of_get_option('flickr')){ ?>
            <a href="http://www.flickr.com/photos/<?php echo of_get_option('flickr'); ?>/" title="Flickr">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/flickr-ic-16.png" alt="Flickr" />
            </a>
        
        <?php } 
		if(of_get_option('dribbble')){ ?>
            <a href="http://dribbble.com/<?php echo of_get_option('dribbble'); ?>" title="Dribbble">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/dribbble-ic-16.png" alt="Dribbble" />
            </a>
        
        <?php } 
		if(of_get_option('last_fm')){ ?>
            <a href="http://www.last.fm/user/<?php echo of_get_option('last_fm'); ?>" title="last.FM">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/lastFM-ic-16.png" alt="last.FM" />
            </a>
        
        <?php } 
		if(of_get_option('delicious')){ ?>
            <a href="http://delicious.com/<?php echo of_get_option('delicious'); ?>" title="Delicious">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/delicious-ic-16.png" alt="Delicious" />
            </a>
            
        <?php } 
		if(of_get_option('email')){ ?>
            <a href="mailto:<?php echo of_get_option('email'); ?>" title="Email">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/email-ic-16.png" alt="Email" />
            </a>
        
		<?php } if(!of_get_option('hide_rss')) { ?>
            <a href="<?php if(of_get_option('rss')){ echo of_get_option('rss'); } else { bloginfo('rss2_url'); }?>" title="Subscribe">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/rss.png" alt="RSS" />
            </a>
       	<?php } ?>
       	
	   	<?php if( function_exists( 'social_bartender' )){ social_bartender(); } ?>

    </div><!-- #social-networks -->
    
    <div class="clearfix"></div>
</div>