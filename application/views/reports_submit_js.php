<?php
/**
 * Report submit js file.
 *
 * Handles javascript stuff related to report submit function.
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
    jQuery.fn.hint = function (blurClass) {
      if (!blurClass) { 
        blurClass = 'texthint';
      }

      return this.each(function () {
        // get jQuery version of 'this'
        var $input = jQuery(this),

        // capture the rest of the variable to allow for reuse
          title = $input.attr('title'),
          $form = jQuery(this.form),
          $win = jQuery(window);

        function remove() {
          if ($input.val() === title && $input.hasClass(blurClass)) {
            $input.val('').removeClass(blurClass);
          }
        }

        // only apply logic if the element has the attribute
        if (title) { 
          // on blur, set value to title attr if text is blank
          $input.blur(function () {
            if (this.value === '') {
              $input.val(title).addClass(blurClass);
            }
          }).focus(remove).blur(); // now change all inputs to title

          // clear the pre-defined text when form is submitted
          $form.submit(remove);
          $win.unload(remove); // handles Firefox's autocomplete
        $(".btn_find").click(remove);
        }
      });
    };
    

    $().ready(function() {
      // validate signup form on keyup and submit
      $("#reportForm").validate({
        rules: {
          incident_title: {
            required: true,
            minlength: 3
          },
          incident_description: {
            required: true,
            minlength: 3
          },
          incident_date: {
            required: true,
            date: true
          },
          incident_hour: {
            required: true,
            range: [1,12]
          },
          incident_minute: {
            required: true,
            range: [0,60]
          },
          incident_ampm: {
            required: true
          },  
          "points[]": {
            required: true,
            minlength: 1
          },
          "incident_category[]": {
            required: true,
            minlength: 1
          },
          "incident_news[]": {
            url: true
          },
          "incident_video[]": {
            url: true
          }
        },
        messages: {
          incident_title: {
            required: "Please enter a Title",
            minlength: "Your Title must consist of at least 3 characters"
          },
          incident_description: {
            required: "Please enter a Description",
            minlength: "Your Description must be at least 3 characters long"
          },
          incident_date: {
            required: "Please enter a Date",
            date: "Please enter a valid Date"
          },
          incident_hour: {
            required: "Please enter an Hour",
            range: "Please enter a valid Hour"
          },
          incident_minute: {
            required: "Please enter a Minute",
            range: "Please enter a valid Minute"
          },
          incident_ampm: {
            required: "Please enter either AM or PM"
          },
          "incident_category[]": {
            required: "Please select at least one Category",
            minlength: "Please select at least one Category"
          },
          latitude: {
            required: "Please select a valid point on the map",
            range: "Please select a valid point on the map"
          },
          longitude: {
            required: "Please select a valid point on the map",
            range: "Please select a valid point on the map"
          },
          "points[]": {
            url: "Please add at least one point"
          },
          "incident_news[]": {
            url: "Please enter a valid News link"
          },
          "incident_news[]": {
            url: "Please enter a valid Video link"
          } 
        },
        groups: {
          incident_date_time: "incident_date incident_hour",
          latitude_longitude: "latitude longitude"
        },
        errorPlacement: function(error, element) {
          if (element.attr("name") == "incident_date" || element.attr("name") == "incident_hour" || element.attr("name") == "incident_minute" )
          {
            error.append("#incident_date_time");
          }else if (element.attr("name") == "latitude" || element.attr("name") == "longitude"){
            error.insertAfter("#find_text");
          }else if (element.attr("name") == "incident_category[]"){
            error.insertAfter("#categories");
          }else{
            error.insertAfter(element);
          }
        }
      });
    });
    
    function addFormField(div, field, hidden_id, field_type) {
      var id = document.getElementById(hidden_id).value;
      $("#" + div).append("<div class=\"report_row\" id=\"" + field + "_" + id + "\"><input type=\"" + field_type + "\" name=\"" + field + "[]\" class=\"" + field_type + " long2\" /><a href=\"#\" class=\"add\" onClick=\"addFormField('" + div + "','" + field + "','" + hidden_id + "','" + field_type + "'); return false;\">add</a><a href=\"#\" class=\"rem\"  onClick='removeFormField(\"#" + field + "_" + id + "\"); return false;'>remove</a></div>");

      $("#" + field + "_" + id).effect("highlight", {}, 800);

      id = (id - 1) + 2;
      document.getElementById(hidden_id).value = id;
    }

    function removeFormField(id) {
      var answer = confirm("Are You Sure You Want To Delete This Item?");
        if (answer){
        $(id).remove();
        }
      else{
        return false;
        }
    }
    
    $(document).ready(function() {      
	    $("#location_find").hint();
    
	    $('a#date_toggle').click(function() {
	        $('#datetime_edit').show(400);
	      $('#datetime_default').hide();
	        return false;
	    });
	    
	    $("#category-column-1,#category-column-2").treeview({
	      persist: "location",
	      collapsed: true,
	      unique: false
	    });
		var markers;
		var marker;
		var myPoint;
		var lonlat;
		var DispProj = new OpenLayers.Projection("EPSG:4326");
		var MapProj = new OpenLayers.Projection("EPSG:900913");
		var options = { numZoomLevels: 50,
						minZoomLevel: 2
						, units: "m"
						, projection: MapProj
						, 'displayProjection': DispProj
						, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34)
						, controls: [	new OpenLayers.Control.Navigation(),
											new OpenLayers.Control.MouseDefaults(),
											new OpenLayers.Control.PanZoom(),
											new OpenLayers.Control.ArgParser(),
											new OpenLayers.Control.MousePosition()]
		};
		
		var map = new OpenLayers.Map('map', options);
		
		<?php echo map::layers_js(FALSE); ?>
		map.addLayers(<?php echo map::layers_array(FALSE); ?>);
		
		// Transform feature point coordinate to Spherical Mercator
		preFeatureInsert = function(feature) {		
			var point = new OpenLayers.Geometry.Point(feature.geometry.x, feature.geometry.y);
			OpenLayers.Projection.transform(point, DispProj, MapProj);
		};
		
		
		// Create the markers layer
		markers = new OpenLayers.Layer.Markers("Markers", {
			preFeatureInsert:preFeatureInsert,
			projection: DispProj
		});
		map.addLayer(markers);
		
		
		// create myPoint, a lat/lon object
		myPoint = new OpenLayers.LonLat(<?php echo $default_lon; ?>, <?php echo $default_lat; ?>).transform(DispProj, MapProj);
		
		
		// create a marker using the myPoint lat/lon object
		marker = new OpenLayers.Marker(myPoint);
		markers.addMarker(marker);
		
		
		// set map center and zoom in to default zoom level
		map.setCenter(myPoint, <?php echo $default_zoom; ?>);

		// add info bubble to the marker
		// popup = new OpenLayers.Popup.Anchored("test", myPoint,new OpenLayers.Size(200,200),"Hello!", true);
		
		
		// create new marker at map click location
		map.events.register("click", map, function(e){
			// Update the myPoint global
			myPoint = map.getLonLatFromViewPortPx(e.xy);
			lonlat = map.getLonLatFromViewPortPx(e.xy);
			markers.removeMarker(marker);
			marker = new OpenLayers.Marker(lonlat);
	    	markers.addMarker(marker);
					
			// Update form values (jQuery)
			lonlat = lonlat.transform(MapProj,DispProj);
			$("#default_lat").attr("value", lonlat.lat);
			$("#default_lon").attr("value", lonlat.lon);
		});
		
		$('input[value|="<?php echo $category; ?>"]').attr('checked', true);

		
		// zoom slider detection
		$('select#default_zoom').selectToUISlider({
			labels: 5,
			sliderOptions: {
				change:function(e, ui) {
					var new_zoom = parseInt($("#default_zoom").val());
					$('#zoom_level').html('"' + new_zoom + '"');
					map.setCenter(myPoint, new_zoom);
					markers.removeMarker(marker);
					marker = new OpenLayers.Marker(myPoint);
			    	markers.addMarker(marker);
				}
			}
		}).hide();		
    });
