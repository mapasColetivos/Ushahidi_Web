<?php
/**
 * Reports listing js file.
 *
 * Handles javascript stuff related to reports list function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
$(document).ready(function() {

	// hover functionality for each report
    $(".rb_report").hover(function () {
          $(this).addClass("hover");
        }, 
        function () {
          $(this).removeClass("hover");
        }
	);
		    
	// category tooltip functionality
	var $tt = $('.r_cat_tooltip');
	$("a.r_category").hover(function () {
			// place the category text inside the category tooltip
			$tt.find('a').html($(this).find('.r_cat-desc').html());
	        // display the category tooltip
			$tt.css({
	            'left': ($(this).offset().left - 6),
	            'top': ($(this).offset().top - 27)
	        }).show();
       	}, 
        function () {
          $tt.hide();
        }
	);
	incidents = new Array();
	<?php foreach($incidents as $incident){
	 	echo "incidents[".$incident->id."] = [".$incident->incident_default_lat.",".$incident->incident_default_lon.",".$incident->incident_default_zoom."];\n\t";
	} ?>
	
	var proj_4326 = new OpenLayers.Projection("EPSG:4326");
    var proj_900913 = new OpenLayers.Projection("EPSG:900913");
	var options = {
		controls:[],
		projection: proj_900913,
		displayProjection: proj_4326
	};

	$('[data-map]').click(function(){
		window.location = "<?php echo url::site() ?>"+"/reports/view/" + $(this).attr("data-map");
	});
 
	$.each($('[data-map]'), function(index,value){
		id = $(this).attr("data-map");
		data = incidents[id];
		lat = data[0];
		lon = data[1];
		zoom = data[2];
		
		map = new OpenLayers.Map("map"+id, options);    
		<?php echo map::layers_js(FALSE); ?>
	    map.addLayers(<?php echo map::layers_array(FALSE); ?>)
        
        lonLat = new OpenLayers.LonLat( lon,lat ).transform(proj_4326, proj_900913);
        map.setCenter (lonLat, 12);
	});
	
	$(".olLayerGooglePoweredBy").css("bottom","10px");
});