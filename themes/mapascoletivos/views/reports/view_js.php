<?php
/**
 * Reports view js file.
 *
 * Handles javascript stuff related to reports view function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @module     Reports Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>

// Set the base url
Ushahidi.baseURL = "<?php echo url::site(); ?>";
Ushahidi.markerRadius = "<?php echo Kohana::config('map.marker_radius'); ?>";
Ushahidi.markerOpacity = "<?php echo kohana::config('map.marker_opacity'); ?>";
Ushahidi.markerStokeWidth = "<?php echo Kohana::config('map.marker_stroke_width'); ?>";
Ushahidi.markerStrokeOpacity = "<?php echo Kohana::config('map.marker_stroke_opacity'); ?>";

var map = null;
jQuery(window).load(function() {

	<?php echo map::layers_js(FALSE); ?>

	// Configuration for the map
	var mapConfig = {

		// Zoom level
		zoom: <?php echo ($map_zoom) ? $map_zoom : intval(Kohana::config('settings.default_zoom')); ?>,

		// Map center
		center: {
			latitude: <?php echo $latitude; ?>,
			longitude: <?php echo $longitude; ?>
		},

		// Map controls
		mapControls: [
			new OpenLayers.Control.Navigation(),
			new OpenLayers.Control.PanZoomBar(),
			new OpenLayers.Control.MousePosition(),
			new OpenLayers.Control.ScaleLine(),
			new OpenLayers.Control.Scale('mapScale'),
			new OpenLayers.Control.LayerSwitcher(),
			new OpenLayers.Control.Attribution()
		],

		// Base layers
		baseLayers: <?php echo map::layers_array(FALSE); ?>

	};

	// Initialize the map
	map = new mapasColetivos.Map('user_map', mapConfig);
	map.addLayer(Ushahidi.GEOJSON, {
		name: "<?php echo $layer_name; ?>",
		url: "<?php echo $markers_url; ?>",
	});

	// When the display of the layers listing is toggled
	$("a.filter-switch").toggle(
		function(e){
			$(".layers-overlay").slideDown();
			$("img", this).attr("src", "<?php echo url::site("media/img/arrow_up_gray.png"); ?>");
			return false;
		}, 

		function(e){
			$(".layers-overlay").slideUp();
			$("img", this).attr("src", "<?php echo url::site("media/img/arrow_down_gray.png"); ?>");
			return false;
		}
	);

	// Layer selection
	$("ul.layers-listing li > a").click(function(e) {
		// Get the layer id
		var layerId = $(this).data("layer-id");

		var isCurrentLayer = false;
		var context = this;

		// Remove all actively selected layers
		$(".layers-listing a").each(function(i) {
			if ($(this).hasClass("active")) {
				if ($(this).data("layer-id") == $(context).data("layer-id")) {
					isCurrentLayer = true;
				}
				map.trigger("deletelayer", $(this).data("layer-name"));
				$(this).removeClass("active");
			}
		});

		// Was a different layer selected?
		if (!isCurrentLayer) {
			// Set the currently selected layer as the active one
			$(this).addClass("active");
			map.addLayer(Ushahidi.KML, {
				name: $(this).data("layer-name"),
				url: "json/layer/" + layerId
			});
		}

		return false;
	});
});