<?php
/*
Plugin Name: Google Earth Tours
Description: A tool for embedding a Google Earth Tour with a shortcode and a custom field. Requires a Google Maps API key and PHP5.
Version: 1.0
Author: Andrew Norcross
Author URI: http://andrewnorcross.com
*/

/*  Copyright 2010 Andrew Norcross

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License (GPL v2) only.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// create custom plugin settings menu
add_action('admin_menu', 'google_earth_create_menu');

function google_earth_create_menu() {

	//create new top-level menu
	add_options_page('Google Earth Tour Settings', 'Google Earth Tour', 'administrator', __FILE__, 'google_earth_settings_page',plugins_url('/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_google_earth_tour' );
}

function gtour_shortcode($atts){
	extract(shortcode_atts(array(  
		"link" 		=> '',
		"width"		=> '500px;', 
		"height" 	=> '380px;',
	), $atts)); 
	$out = '
	  <div id="map3d" style="height: '.$height.'; width: '.$width.'"></div>
      <div id ="controls">
         <input type="button" onclick="enterTour()" value="Enter Tour"/>
         <input type="button" onclick="playTour()" value="Play Tour"/>
         <input type="button" onclick="pauseTour()" value="Pause Tour"/>
         <input type="button" onclick="resetTour()" value="Stop/Reset Tour"/>
         <input type="button" onclick="exitTour()" value="Exit Tour"/>
      </div>';
	return $out;
}
add_shortcode("gtour", "gtour_shortcode"); 

if ( !class_exists('myCustomFields') ) {

	class myCustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = '';
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields =	array(
			array(
				"name"			=> "google_tour_file",
				"title"			=> "Tour file URL",
				"description"	=> "Upload the Google Earth Tour .kml or .kmz file and put the complete URL here. For use with the [gtour] shortcode.",
				"type"			=>	"text",
				"scope"			=>	array( "post", "page" ),
				"capability"	=> "edit_posts"
			)
		);
		/**

		/**
		* PHP 4 Compatible Constructor
		*/
		function myCustomFields() { $this->__construct(); }
		/**
		* PHP 5 Constructor
		*/
		function __construct() {
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
			// Comment this line out if you want to keep default custom fields meta box
		}
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			if ( function_exists( 'add_meta_box' ) ) {
				add_meta_box( 'my-custom-fields', 'Google Earth Tour file', array( &$this, 'displayCustomFields' ), 'page', 'normal', 'high' );
				add_meta_box( 'my-custom-fields', 'Google Earth Tour file', array( &$this, 'displayCustomFields' ), 'post', 'normal', 'high' );
			}
		}

		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post;
			?>
			<div class="form-wrap">
				<?php
				wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
				foreach ( $this->customFields as $customField ) {
					// Check scope
					$scope = $customField[ 'scope' ];
					$output = false;
					foreach ( $scope as $scopeItem ) {
						switch ( $scopeItem ) {
							case "post": {
								// Output on any post screen
								if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="post-new.php" || $post->post_type=="post" )
									$output = true;
								break;
							}
							case "page": {
								// Output on any page screen
								if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="page-new.php" || $post->post_type=="page" )
									$output = true;
								break;
							}
						}
						if ( $output ) break;
					}
					// Check capability
					if ( !current_user_can( $customField['capability'], $post->ID ) )
						$output = false;


					// Output if allowed
					if ( $output ) { ?>
						<div class="form-field form-required">
							<?php
							switch ( $customField[ 'type' ] ) {
								case "checkbox": {
									// Checkbox
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&nbsp;&nbsp;';
									echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
									if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
										echo ' checked="checked"';
									echo '" style="width: auto;" />';
									break;
								}
								case "textarea":
								case "wysiwyg": {
									// Text area
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
									// WYSIWYG
									if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
										<script type="text/javascript">
											jQuery( document ).ready( function() {
												jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
												if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
													tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
												}
											});
										</script>
									<?php }
									break;
								}
								default: {
									// Plain text field
									echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
									echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									break;
								}
							}
							?>
							<?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
					<?php
					}
				} ?>
			</div>
            </div>
			<?php }

		/**
		* Save the new Custom Fields values
		*/
		function saveCustomFields( $post_id, $post ) {
			if ( !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			if ( $post->post_type != 'page' && $post->post_type != 'post' )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) ) {
					if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
						$value = $_POST[ $this->prefix . $customField['name'] ];
						// Auto-paragraphs for any WYSIWYG
						if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $_POST[ $this->prefix . $customField['name'] ] );
					} else {
						delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
					}
				}
			}
		}

	} // End Class

} // End if class exists statement

// Instantiate the class
if ( class_exists('myCustomFields') ) {
	$myCustomFields_var = new myCustomFields();
}

// Adds javascript to head based on existence of shortcode
add_filter('the_posts', 'gtour_scripts_and_styles'); // the_posts gets triggered before wp_head
function gtour_scripts_and_styles($posts){
	if (empty($posts)) return $posts;
 
	$shortcode_found = false; // use this flag to see if styles and scripts need to be enqueued
	foreach ($posts as $post) {
		if (stripos($post->post_content, '[gtour]')) {
			$shortcode_found = true; // bingo!
			break;
		}
	}
 
	if ($shortcode_found) {
		// enqueue here
		add_action('wp_head', 'gtour_head_info');
	}
 
	return $posts;
}

function gtour_head_info() { ?>
<script src="http://www.google.com/jsapi?key=<?php echo (get_option ('google_maps_api')); ?>" type="text/javascript"> </script>
<script src="http://earth-api-samples.googlecode.com/svn/trunk/lib/kmldomwalk.js" type="text/javascript"> </script>
      <script type="text/javascript">

         var ge;
         var tour;
         google.load("earth", "1");

         function init() {
            google.earth.createInstance('map3d', initCB, failureCB);
         }

         function initCB(instance) {
            ge = instance;
            ge.getWindow().setVisibility(true);
            ge.getNavigationControl().setVisibility(ge.VISIBILITY_SHOW);

            var href = '<?php
						global $wp_query;
						$postid = $wp_query->post->ID;
						echo get_post_meta($postid, 'google_tour_file', true);
						?>
						';
            google.earth.fetchKml(ge, href, fetchCallback);

            function fetchCallback(fetchedKml) {
               // Alert if no KML was found at the specified URL.
               if (!fetchedKml) {
                  setTimeout(function() {
                     alert('Bad or null KML');
                  }, 0);
                  return;
               }

               // Add the fetched KML into this Earth instance.
               ge.getFeatures().appendChild(fetchedKml);

               // Walk through the KML to find the tour object; assign to variable 'tour.'
               walkKmlDom(fetchedKml, function() {
                  if (this.getType() == 'KmlTour') {
                     tour = this;
                     return false;
                  }
               });
            }
         }

         function failureCB(errorCode) {
         }

         // Tour control functions
         function enterTour() {
            if (!tour) {
               alert('No tour found!');
               return;
            }
            ge.getTourPlayer().setTour(tour);
         }
         function playTour() {
            ge.getTourPlayer().play();
         }
         function pauseTour() {
            ge.getTourPlayer().pause();
         }
         function resetTour() {
            ge.getTourPlayer().reset();
         }
         function exitTour() {
            ge.getTourPlayer().setTour(null);
         }

         google.setOnLoadCallback(init);
      </script>
	<?php }

function register_google_earth_tour() {
	//register our settings
	register_setting( 'google-earth-tour-settings-group', 'google_maps_api' );
}


function gtour_css_head() { ?>
<style type="text/css"  >

.gtour {padding-top:15px;}
.gtour p.options_text {width:100%; margin-bottom:7px;}
.gtour p.gtour_setting {width:100%; padding:10px 0;}
.gtour ul {padding-left:25px;}
.gtour ul li{list-style-type:circle;}

</style>
<?php }
add_action('admin_head', 'gtour_css_head');

function google_earth_settings_page() {
?>
<div class="wrap gtour">
<h2>Google Earth Tour Embed</h2>

<p class="options_text">Enter your Google Maps API key in the field below for the plugin shortcode to work.</p>
<p class="options_text"><strong>Need a Google Maps API?</strong> <a href="http://code.google.com/apis/maps/signup.html" target="_blank">Get one here</a></p>

<form method="post" action="options.php">
    <?php settings_fields( 'google-earth-tour-settings-group' ); ?>
	<p class="gtour_setting">
	<label for="google_maps_api">Google Maps API Key</label>
	<input name="google_maps_api" id="google_maps_api" type="text" size="100" value="<?php echo get_option('google_maps_api'); ?>" />
	</p>

	<p class="gtour_setting">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

</form>


<h3>Instructions</h3>
<p>After activating the plugin and entering your Google API code in the field above, do the following:</p>
<ul>
	<li>Upload your .kml or .kmz file to a public location (your WP-Uploads will suffice)</li>
    <li>Get the complete URL (including the http://) of the file</li>
    <li>Save the URL of the file is the meta box below the post editor.</li>
    <li>In the HTML tab (not visual editor) place the shortcode [gtour] anywhere in a post or page where you want your tour to display.</li>
    <li>That's it. The map should display.</li>
</ul>

</div>

<?php } ?>