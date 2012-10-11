<?php
/**
 * Main cluster js file.
 * 
 * Server Side Map Clustering
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>

// Initialize the Ushahidi namespace
Ushahidi.baseUrl = "<?php echo url::site(); ?>";
Ushahidi.markerRadius = <?php echo $marker_radius; ?>;
Ushahidi.markerOpacity = <?php echo $marker_opacity; ?>;
Ushahidi.markerStokeWidth = <?php echo $marker_stroke_width; ?>;
Ushahidi.markerStrokeOpacity = <?php echo $marker_stroke_opacity; ?>;

// Default to most active month
var startTime = <?php echo $active_startDate ?>;

// Default to most active month
var endTime = <?php echo $active_endDate ?>;

// To hold the Ushahidi.Map reference
var map = null;
var enableTimeline = <?php echo (Kohana::config('settings.enable_timeline')) ? "true" : "false"; ?>;


/**
 * Toggle Layer Switchers
 */
function toggleLayer(link, layer) {
	if ($("#"+link).text() == "<?php echo Kohana::lang('ui_main.show'); ?>")
	{
		$("#"+link).text("<?php echo Kohana::lang('ui_main.hide'); ?>");
	}
	else
	{
		$("#"+link).text("<?php echo Kohana::lang('ui_main.show'); ?>");
	}
	$('#'+layer).toggle(500);
}

/**
 * Create a function that calculates the smart columns
 */
function smartColumns() {
	//Reset column size to a 100% once view port has been adjusted
	$("ul.content-column").css({ 'width' : "100%"});

	//Get the width of row
	var colWrap = $("ul.content-column").width();

	// Find how many columns of 200px can fit per row / then round it down to a whole number
	var colNum = <?php echo $blocks_per_row; ?>;

	// Get the width of the row and divide it by the number of columns it 
	// can fit / then round it down to a whole number. This value will be
	// the exact width of the re-adjusted column
	var colFixed = Math.floor(colWrap / colNum);

	// Set exact width of row in pixels instead of using % - Prevents
	// cross-browser bugs that appear in certain view port resolutions.
	$("ul.content-column").css({ 'width' : colWrap});

	// Set exact width of the re-adjusted column	
	$("ul.content-column li").css({ 'width' : colFixed});
}


<?php if (Kohana::config('settings.enable_timeline')): ?>
/**
 * Callback function for rendering the timeline
 */
function refreshTimeline() {


	var options = (arguments.length == 0) ? {} : arguments[0];

	// Compute the start and end dates
	var from = (options.s == undefined)
	    ? new Date(startTime * 1000)
	    : new Date(options.s * 1000);

	var to = (options.e == undefined)
	    ? new Date(endTime * 1000)
	    : new Date(options.e * 1000);

	var url = "<?php echo url::site().'json/timeline/'; ?>";
	url += (options.c !== undefined && parseInt(options.c) > 0) ?  options.c : '';

	var interval = (to - from) / (1000 * 3600 * 24);
	if (interval <= 3) {
		options.i = "hour";
	} else if (interval >= 124) {
		options.i = "day";
	}

	// Get the graph data
	$.ajax({
		url: url,
		data: options,
		success: function(response) {
			// Clear out the any existing plots
			$("#graph").html('');

			if (response != null && response[0].data.length < 2)
				return;

			var graphData = [];
			var raw = response[0].data;
			for (var i=0; i<raw.length; i++) {
				var date = new Date(raw[i][0]);

				var dateStr = date.getFullYear() + "-";
				dateStr += (date.getMonth() < 10) ? "0" : "";
				dateStr += (date.getMonth() +1) + "-" ;
				dateStr += (date.getDate() < 10) ? "0" : "";
				dateStr += date.getDate();

				graphData.push([dateStr, parseInt(raw[i][1])]);
			}
			var timeline = $.jqplot('graph', [graphData], {
				seriesDefaults: {
					color: response[0].color,
					lineWidth: 1.6,
					markerOptions: {
						show: false
					}
				},
				axesDefaults: {
					pad: 1.23,
				},
				axes: {
					xaxis: {
						renderer: $.jqplot.DateAxisRenderer,
						tickOptions: {
							formatString: '%#d&nbsp;%b\n%Y'
						}
					},
					yaxis: {
						min: 0,
						tickOptions: {
							formatString: '%.0f'
						}
					}
				},
				cursor: {show: false}
			});
		},
		dataType: "json"
	});
}
<?php endif; ?>


jQuery(function() {

	// Render thee JavaScript for the base layers so that
	// they are accessible by Ushahidi.js
	<?php echo map::layers_js(FALSE); ?>
	
	// Map configuration
	var config = {

		// Zoom level at which to display the map
		zoom: <?php echo Kohana::config('settings.default_zoom'); ?>,

		// Center of the map
		center: {
			latitude: <?php echo Kohana::config('settings.default_lat'); ?>,
			longitude: <?php echo Kohana::config('settings.default_lon'); ?>
		},

		// Map controls
		mapControls: [
			new OpenLayers.Control.LoadingPanel({minSize: new OpenLayers.Size(573, 366)}),
			new OpenLayers.Control.Navigation(),
			new OpenLayers.Control.Attribution(),
			new OpenLayers.Control.PanZoomBar(),
			new OpenLayers.Control.MousePosition({
				div: document.getElementById('mapMousePosition'),
				numdigits: 5
			}),
			new OpenLayers.Control.Scale('mapScale'),
			new OpenLayers.Control.ScaleLine(),
			new OpenLayers.Control.LayerSwitcher()
		],

		// Base layers
		baseLayers: <?php echo map::layers_array(FALSE); ?>,

		// Display the map projection
		showProjection: true

	};

	// Initialize the map
	map = new mapasColetivos.Map('map', config);
	map.addLayer(Ushahidi.GEOJSON, {
		name: "<?php echo Kohana::lang('ui_main.reports'); ?>",
		url: "json/locations"
	}, true);


	if (enableTimeline) {
		// Register the referesh timeline function as a callback
		map.register("filterschanged", refreshTimeline);
		setTimeout(function() { refreshTimeline(); }, 1500);
	}


	// When the category switcher is selected
	$("#category_switch_link").toggle(
		function(e){
			$("#category_column").slideDown();
			$("img", this).attr("src", "<?php echo url::site("media/img/arrow_up_gray.png"); ?>");
			return false;
		},
		function(e){
			$("#category_column").slideUp();
			$("img", this).attr("src", "<?php echo url::site("media/img/arrow_down_gray.png"); ?>");
			return false;
		}
	);

	// Category Switch Action
	$("ul#category_switch li > a").click(function(e) {		
		var categoryId = $(this).data("category-id");

		// Remove All active
		$("a[id^='cat_']").removeClass("active");
		
		// Hide All Children DIV
		$("[id^='child_']").hide();

		// Add Highlight
		$(this).addClass("active"); 

		// Show children DIV
		$("#child_" + categoryId).show();
		$(this).parents("div").show();
		
		// Update report filters
		map.updateReportFilters({c: categoryId});

		return false;
	});
	
	//Execute the function when page loads
	smartColumns();
});

$(window).resize(function () { 
	//Each time the viewport is adjusted/resized, execute the function
	smartColumns();
});