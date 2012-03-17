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
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
		// Map JS
		
		var popup;
		var filterData = {};
		var activeFilters = ["0","1","2","3","4"];		
		var requesting = false;
		// Map Object
		var map;
		// Selected Category
		var currentCat;
		// Selected Layer
		var thisLayer;
		// WGS84 Datum
		var proj_4326 = new OpenLayers.Projection('EPSG:4326');
		// Spherical Mercator
		var proj_900913 = new OpenLayers.Projection('EPSG:900913');
		// Change to 1 after map loads
		var mapLoad = 0;
		// /json or /json/cluster depending on if clustering is on
		var default_json_url = "<?php echo $json_url ?>";
		// Current json_url, if map is switched dynamically between json and json_cluster
		var json_url = default_json_url;
		
		var baseUrl = "<?php echo url::base(); ?>";
		var longitude = <?php echo $longitude; ?>;
		var latitude = <?php echo $latitude; ?>;
		var defaultZoom = <?php echo $default_zoom; ?>;
		var markerRadius = <?php echo $marker_radius; ?>;
		var markerOpacity = "<?php echo $marker_opacity; ?>";

		var gMarkerOptions = {baseUrl: baseUrl, longitude: longitude,
		                     latitude: latitude, defaultZoom: defaultZoom,
							 markerRadius: markerRadius,
							 markerOpacity: markerOpacity,
							 protocolFormat: OpenLayers.Format.GeoJSON};
		
		function apply_filters(){			
			for (layer_id in map.layers){
				current_features = map.layers[layer_id].features;
				for (id in current_features) {
					feature = current_features[id];
					feature.style = "none";
	
					for(filter_id in activeFilters) {
						filter = activeFilters[filter_id];
						if (filter != -1){
							if (filterData[feature.data.id][filter] == true){
								feature.style = "";
							}
						}
					};
				}
				map.layers[layer_id].redraw();
			}
		}
		
		function toggle_filter(this_filter,element){
			if (activeFilters[this_filter] == this_filter){
				activeFilters[this_filter] = -1;
				$($(element).children()[0]).css("background-color","red");
			} else {
				activeFilters[this_filter] = this_filter;
				$($(element).children()[0]).css("background-color","lightgreen");
			}
		}
		
		function load_filter_data(){
			<?php foreach( $locations as $location) { ?>
				<?php 
					echo "filterData[".$location->id."] = {};\n";
					
					echo "\tfilterData['".$location->id."']['0'] = ".$location->filters(0).";\n";
					echo "\tfilterData['".$location->id."']['1'] = ".$location->filters(1).";\n";
					echo "\tfilterData['".$location->id."']['2'] = ".$location->filters(2).";\n";
					echo "\tfilterData['".$location->id."']['3'] = ".$location->filters(3).";\n";
					echo "\tfilterData['".$location->id."']['4'] = ".$location->filters(4).";\n";
				?>
			<?php } ?>
		}
		
		/*
		Create the Markers Layer
		*/
		function addMarkers(catID,startDate,endDate, currZoom, currCenter,
			mediaType, thisLayerID, thisLayerType, thisLayerUrl, thisLayerColor, keep_markers)
		{
			return $.timeline({categoryId: catID,
			                   startTime: new Date(startDate * 1000),
			                   endTime: new Date(endDate * 1000),
							   mediaType: mediaType
							  }).addMarkers(
								startDate, endDate, gMap.getZoom(),
								gMap.getCenter(), thisLayerID, thisLayerType, 
								thisLayerUrl, thisLayerColor, json_url,keep_markers);
		}

		/*
		Display loader as Map Loads
		*/
		function onMapStartLoad(event)
		{
			if ($("#loader"))
			{
				$("#loader").show();
			}

			if ($("#OpenLayers\\.Control\\.LoadingPanel_4"))
			{
				$("#OpenLayers\\.Control\\.LoadingPanel_4").show();
			}
		}

		/*
		Hide Loader
		*/
		function onMapEndLoad(event)
		{
			if ($("#loader"))
			{
				$("#loader").hide();
			}

			if ($("#OpenLayers\\.Control\\.LoadingPanel_4"))
			{
				$("#OpenLayers\\.Control\\.LoadingPanel_4").hide();
			}
		}

		/*
		Close Popup
		*/
		function onPopupClose(evt)
		{
            // selectControl.unselect(selectedFeature);
			for (var i=0; i<map.popups.length; ++i)
			{
				map.removePopup(map.popups[i]);
			}
			requesting = false;
        }
        
        var asset_count;
        var asset_pointer;
        function display_message(){
			var message = (asset_pointer + 1) +" de "+asset_count;
			$("#asset_count").text(message);
		}
        
		function after_load_popup(){
			$(".assets").hide();
			asset_count = $(".assets").size();
			asset_pointer = 0;
			
			if (asset_count > 0){				
				$("#asset"+asset_pointer).show(); 
				$("#owner").html($("#asset"+asset_pointer).attr("data-owner"));										
				display_message();
				
				$("#next_button").click(function(){
					$(".assets").hide();
					asset_pointer = (asset_pointer +1) % asset_count;
					$("#asset"+asset_pointer).show();
					$("#owner").html($("#asset"+asset_pointer).attr("data-owner"));					
					display_message();
				});
				
				$("#previous_button").click(function(){
					$(".assets").hide();
					asset_pointer = (asset_count + asset_pointer -1) % asset_count;
					$("#asset"+asset_pointer).show();
					$("#owner").html($("#asset"+asset_pointer).attr("data-owner"));					
					display_message();	
				});
				
				$(".hooverable").mouseover(function(){
					if  ($("#asset"+asset_pointer).attr("data-media") == 2) {
						return "";
					}
					
					width = $(".delimiter").filter(":visible").width();
					total_area = 350;
					margin = (total_area - width)/2
					if (margin < 0){
					      margin = 0;
					}
					$("#description").css("margin-left",margin+"px");														
					$("#description").css("width",(width-10)+"px");
					$("#description").css("height","208px");													
					if ($("iframe").filter(":visible").size() == 1){
						$("#description").css("height","180px");
					} else if ($(".external_link").filter(":visible").size() == 1){
						$("#description").css("height","150px");
					}
					$("#description").show();				
				});
				
				$(".hooverable").mouseout(function(){
					$("#description").hide();
				});
				
			} else {
				$(".popup_controls").hide();
				$("#description").show();
			}

			$(".close_image_popup").click(function(){
				$("#chicken").hide();
			});	
		}
		/*
		Display popup when feature selected
		*/
        function onFeatureSelect(event)
		{
			if(!(event.feature.attributes.id === undefined)){
				onPopupClose(event);
	            selectedFeature = event;
	
				zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
				lon = zoom_point.lon;
				lat = zoom_point.lat;
				
				id = event.feature.attributes.id;
				if (!requesting){
					requesting = true;
					$.get(baseUrl+"index.php/locations/popup/"+id,function(data){
						requesting = false;
						content = data;
			            var popup = new OpenLayers.Popup.Anchored("chicken",event.feature.geometry.getBounds().getCenterLonLat(),
						new OpenLayers.Size(372,310),
						content,
						null, false, onPopupClose);
		    	        event.feature.popup = popup;
						onPopupClose(event);				    	        
			            map.addPopup(popup);
						after_load_popup();
					});		
				}
			}
        }

		/*
		Destroy Popup Layer
		*/
        function onFeatureUnselect(event)
		{
//            map.removePopup(event.feature.popup);
//            event.feature.popup.destroy();
//           event.feature.popup = null;
        }

		// Refactor Clusters On Zoom
		// *** Causes the map to load json twice on the first go
		// *** Need to fix this!
		function mapZoom(event)
		{
			// Prevent this event from running on the first load
			if (mapLoad > 0)
			{
				// Get Current Category
				currCat = $("#currentCat").val();

				// Get Current Start Date
				currStartDate = $("#startDate").val();

				// Get Current End Date
				currEndDate = $("#endDate").val();

				// Get Current Zoom
				currZoom = map.getZoom();

				// Get Current Center
				currCenter = map.getCenter();

				// Refresh Map
				addMarkers(currCat, currStartDate, currEndDate, currZoom, currCenter);
			}
		}

		function mapMove(event)
		{
			// Prevent this event from running on the first load
			if (mapLoad > 0)
			{
				// Get Current Category
				currCat = $("#currentCat").val();

				// Get Current Start Date
				currStartDate = $("#startDate").val();

				// Get Current End Date
				currEndDate = $("#endDate").val();

				// Get Current Zoom
				currZoom = map.getZoom();

				// Get Current Center
				currCenter = map.getCenter();

				// Refresh Map
				addMarkers(currCat, currStartDate, currEndDate, currZoom, currCenter);
			}
		}


		/*
		Refresh Graph on Slider Change
		*/
		function refreshGraph(startDate, endDate)
		{
			var currentCat = 0;

			// refresh graph
			if (!currentCat || currentCat == '0')
			{
				currentCat = '0';
			}

			var startTime = new Date(startDate * 1000);
			var endTime = new Date(endDate * 1000);

			// daily
			var graphData = "";

			// plot hourly incidents when period is within 2 days
			if ((endTime - startTime) / (1000 * 60 * 60 * 24) <= 3)
			{
				$.getJSON("<?php echo url::site()."json/timeline/"?>"+currentCat+"?i=hour", function(data) {
					graphData = data[0];

					gTimeline = $.timeline({categoryId: currentCat,
						startTime: new Date(startDate * 1000),
					    endTime: new Date(endDate * 1000), mediaType: gMediaType,
						markerOptions: gMarkerOptions,
						graphData: graphData
					});
					gTimeline.plot();
				});
			} 
			else if ((endTime - startTime) / (1000 * 60 * 60 * 24) <= 124)
			{
			    // weekly if period > 2 months
				$.getJSON("<?php echo url::site()."json/timeline/"?>"+currentCat+"?i=day", function(data) {
					graphData = data[0];

					gTimeline = $.timeline({categoryId: currentCat,
						startTime: new Date(startDate * 1000),
					    endTime: new Date(endDate * 1000), mediaType: gMediaType,
						markerOptions: gMarkerOptions,
						graphData: graphData
					});
					gTimeline.plot();
				});
			} 
			else if ((endTime - startTime) / (1000 * 60 * 60 * 24) > 124)
			{
				// monthly if period > 4 months
				$.getJSON("<?php echo url::site()."json/timeline/"?>"+currentCat, function(data) {
					graphData = data[0];

					gTimeline = $.timeline({categoryId: currentCat,
						startTime: new Date(startDate * 1000),
					    endTime: new Date(endDate * 1000), mediaType: gMediaType,
						markerOptions: gMarkerOptions,
						graphData: graphData
					});
					gTimeline.plot();
				});
			}

			// Get dailyGraphData for All Categories
			$.getJSON("<?php echo url::site()."json/timeline/"?>"+currentCat+"?i=day", function(data) {
				dailyGraphData = data[0];
			});

			// Get allGraphData for All Categories
			$.getJSON("<?php echo url::site()."json/timeline/"?>"+currentCat, function(data) {
				allGraphData = data[0];
			});

		}

		/*
		Zoom to Selected Feature from within Popup
		*/
		function zoomToSelectedFeature(lon, lat, zoomfactor)
		{
			var lonlat = new OpenLayers.LonLat(lon,lat);

			// Get Current Zoom
			currZoom = map.getZoom();
			// New Zoom
			newZoom = currZoom + zoomfactor;
			// Center and Zoom
			map.setCenter(lonlat, newZoom);
			// Remove Popups
			for (var i=0; i<map.popups.length; ++i)
			{
				map.removePopup(map.popups[i]);
			}
		}

		/*
		Add KML/KMZ Layers
		*/
		function switchLayer(layerID, layerURL, layerColor)
		{
			if ( $("#layer_" + layerID).hasClass("active") )
			{
				new_layer = map.getLayersByName("Layer_"+layerID);
				if (new_layer)
				{
					for (var i = 0; i < new_layer.length; i++)
					{
						map.removeLayer(new_layer[i]);
					}
				}
				$("#layer_" + layerID).removeClass("active");
			}
			else
			{
				$("#layer_" + layerID).addClass("active");

				// Get Current Zoom
				currZoom = map.getZoom();

				// Get Current Center
				currCenter = map.getCenter();

				// Add New Layer
				addMarkers('', '', '', currZoom, currCenter, '', layerID, 'layers', layerURL, layerColor);
			}
		}

		/*
		Toggle Layer Switchers
		*/
		function toggleLayer(link, layer){
			if ($("#"+link).text() == "<?php echo Kohana::lang('ui_main.show'); ?>")
			{
				$("#"+link).text("<?php echo Kohana::lang('ui_main.hide'); ?>");
				width_map = $("#map").width();
				width_categories = $("#category_switch").width();	
				new_left = width_map - width_categories;
				$("#category_switch").css("left",new_left.toString()+"px");
			}
			else
			{
				$("#"+link).text("<?php echo Kohana::lang('ui_main.show'); ?>");
			}
			$('#'+layer).toggle();
		}
		
		function switchImage(img, layer){
		  image = $(img);
			current_src = image.attr('data-current-src');
			if(current_src == "down") {
				image.attr("src","<?php echo url::base();?>media/img/arrow_up_gray.png" );
				image.attr("data-current-src", "up");			
				
			}
			else {
				image.attr("src","<?php echo url::base(); ?>media/img/arrow_down_gray.png" );
				image.attr("data-current-src", "down");	
				width_map = $("#map").width();
				width_categories = $("#category_switch").width();	
				new_left = width_map - width_categories;
				$("#category_switch").css("left",new_left.toString()+"px");
							
			}
			$('#'+layer).toggle();
			
		}
		
		
		function switchIcon(new_src){
		  $(this).attr("src", new_src);
		}
		

		jQuery(function() {
		
		    $(".submit").live("click",function(){
				geoCode();    	
		    });

		
			var map_layer;
			markers = null;
			var catID = '';
			OpenLayers.Strategy.Fixed.prototype.preload=true;
      		
      		load_filter_data();
      		
      		$("[data-filter]").click(function (){
      			toggle_filter($(this).attr("data-filter"),this);
      			apply_filters();
      		});
			
			/*
			- Initialize Map
			- Uses Spherical Mercator Projection
			- Units in Metres instead of Degrees					
			*/
			var options = {
				units: "mi",
				numZoomLevels: 50,
				minZoomLevel: 2,
				controls:[],
				projection: proj_900913,
				'displayProjection': proj_4326,
				eventListeners: {
						"zoomend": mapMove
				    },
				'theme': null
				};
			map = new OpenLayers.Map('map', options);
			//map.addControl( new OpenLayers.Control.LoadingPanel({minSize: new OpenLayers.Size(573, 366)}) );
			
			<?php echo map::layers_js(FALSE); ?>
			map.addLayers(<?php echo map::layers_array(FALSE); ?>);
			
			
			// Add Controls
			map.addControl(new OpenLayers.Control.Navigation());
			map.addControl(new OpenLayers.Control.Attribution());
			map.addControl(new OpenLayers.Control.PanZoomBar());
			map.addControl(new OpenLayers.Control.MousePosition(
				{
					div: document.getElementById('mapMousePosition'),
					numdigits: 5
				}));    
			map.addControl(new OpenLayers.Control.Scale('mapScale'));
            map.addControl(new OpenLayers.Control.ScaleLine());
			map.addControl(new OpenLayers.Control.LayerSwitcher());
			
			map.events.register("click", map , function(e){
				onPopupClose(e);
			});
			
			// display the map projection
			document.getElementById('mapProjection').innerHTML = map.projection;
			
				
			gMap = map;
			
			var select_all_categories = function()
			{ 				
				$("a[id^='cat_']").removeClass("active");
				$("#all_cat").addClass("active");
				$.each($("a[id^='cat_']"),function(index,value){
					$(this).click();
				});
			};
			
			$("#all_cat").click(select_all_categories);

			// Category Switch Action
			$("a[id^='cat_']").click(function()
			{ 
				var catID = this.id.substring(4);
				var catSet = 'cat_' + this.id.substring(4);
				
				$("#all_cat").removeClass("active");
				selected = $(this).hasClass("active");
				if (selected){
					$(this).removeClass("active");
				} else {
					$(this).addClass("active");
				}
				
				$("[id^='child_']").hide(); // Hide All Children DIV
				$("#child_" + catID).show(); // Show children DIV
				$(this).parents("div").show();

				selections = $("a[id^='cat_']").filter(".active");
				
				if (selections.size() > 0){
					first = selections[0];
					rest = selections.filter(function(index){
						return index != 0;
					});
					
					catID = first.id.substring(4);
					setCategory(catID);
					
					$.map(rest,function(item){
						catID = item.id.substring(4);
						setCategory(catID,true);
					});
				} else {
					
					select_all_categories();
				}
			});
			
			function setCategory(catID,keep_markers){
				currentCat = 0;
				$("#currentCat").val(catID);

				onPopupClose();
				currZoom = map.getZoom();
				currCenter = map.getCenter();
				
				gCategoryId = 0;
				startTime = new Date($("#startDate").val() * 1000);
				endTime = new Date($("#endDate").val() * 1000);
				
				addMarkers(catID, $("#startDate").val(), $("#endDate").val(), currZoom, currCenter, gMediaType,null,null,null,null,keep_markers);
								
				return false;
			}
			
			// Sharing Layer[s] Switch Action
			$("a[id^='share_']").click(function()
			{
				var shareID = this.id.substring(6);
				
				if ( $("#share_" + shareID).hasClass("active") )
				{
					share_layer = map.getLayersByName("Share_"+shareID);
					if (share_layer)
					{
						for (var i = 0; i < share_layer.length; i++)
						{
							map.removeLayer(share_layer[i]);
						}
					}
					$("#share_" + shareID).removeClass("active");
					
				} 
				else
				{
					$("#share_" + shareID).addClass("active");
					
					// Get Current Zoom
					currZoom = map.getZoom();

					// Get Current Center
					currCenter = map.getCenter();
					
					// Add New Layer
					addMarkers('', '', '', currZoom, currCenter, '', shareID, 'shares');
				}
			});

			// Exit if we don't have any incidents
			if (!$("#startDate").val())
			{
				map.setCenter(new OpenLayers.LonLat(<?php echo $longitude ?>, <?php echo $latitude ?>), 5);
				return;
			}
			
			//Accessible Slider/Select Switch
			$("select#startDate, select#endDate").selectToUISlider({
				labels: 4,
				labelSrc: 'text',
				sliderOptions: {
					change: function(e, ui)
					{
						var startDate = $("#startDate").val();
						var endDate = $("#endDate").val();
						var currentCat = 0;
						
						// Get Current Category
						currCat = currentCat;
						
						// Get Current Zoom
						currZoom = map.getZoom();
						
						// Get Current Center
						currCenter = map.getCenter();
						
						// If we're in a month date range, switch to
						// non-clustered mode. Default interval is monthly
						var startTime = new Date(startDate * 1000);
						var endTime = new Date(endDate * 1000);
						if ((endTime - startTime) / (1000 * 60 * 60 * 24) <= 32)
						{
							json_url = "json";
						} 
						else
						{
							json_url = default_json_url;
						}
						
						// Refresh Map
						addMarkers(currCat, startDate, endDate, '', '', gMediaType);
						
						refreshGraph(startDate, endDate);
					}
				}
				
			});
			
			var allGraphData = "";
			var dailyGraphData = "";
			
			var startTime = <?php echo $active_startDate ?>;	// Default to most active month
			var endTime = <?php echo $active_endDate ?>;		// Default to most active month
					
			// get the closest existing dates in the selection options
			options = $('#startDate > optgroup > option').map(function()
			{
				return $(this).val(); 
			});
			startTime = $.grep(options, function(n,i)
			{
			  return n >= ('' + startTime) ;
			})[0];
			
			options = $('#endDate > optgroup > option').map(function()
			{
				return $(this).val(); 
			});
			endTime = $.grep(options, function(n,i)
			{
			  return n >= ('' + endTime) ;
			})[0];
			
			gCategoryId = '0';
			gMediaType = 0;
			//$("#startDate").val(startTime);
			//$("#endDate").val(endTime);
			
			// Initialize Map
			addMarkers(0, $("#startDate").val(), $("#endDate").val(), defaultZoom, gMap.getCenter, gMediaType,null,null,null,null,false);
			refreshGraph(startTime, endTime);

			gMap.setCenter(gMap.getCenter, defaultZoom);			
			
			// Media Filter Action
			$('.filters li a').click(function()
			{
				var startTimestamp = $("#startDate").val();
				var endTimestamp = $("#endDate").val();
				var startTime = new Date(startTimestamp * 1000);
				var endTime = new Date(endTimestamp * 1000);
				gMediaType = parseFloat(this.id.replace('media_', '')) || 0;
				
				// Get Current Zoom
				currZoom = map.getZoom();
					
				// Get Current Center
				currCenter = map.getCenter();
				
				// Refresh Map
				addMarkers(currentCat, startTimestamp, endTimestamp, 
				           currZoom, currCenter, gMediaType);
				
				$('.filters li a').attr('class', '');
				$(this).addClass('active');
				gTimeline = $.timeline({categoryId: gCategoryId, startTime: startTime, 
				    endTime: endTime, mediaType: gMediaType,
					url: "<?php echo url::site(); ?>json/timeline/"
				});
				gTimeline.plot();
			});
			
			$('#playTimeline').click(function()
			{
			    gTimelineMarkers = gTimeline.addMarkers(gStartTime.getTime()/1000,
					$.dayEndDateTime(gEndTime.getTime()/1000), gMap.getZoom(),
					gMap.getCenter(),null,null,null,null,"json");
				gTimeline.playOrPause('raindrops');
			});
			
			$("#OpenLayers\\.Control\\.LayerSwitcher_50").css("margin-top","350px");
			$("#OpenLayers_Control_MinimizeDiv").css("margin-top","-125px");
			$("#OpenLayers_Control_MaximizeDiv").css("margin-top","-27px");												
			
			$("#OpenLayers_Control_MinimizeDiv").click(function(){	
				$("#OpenLayers\\.Control\\.LayerSwitcher_50").children().hide()
				$("#OpenLayers_Control_MinimizeDiv").hide();
				$("#OpenLayers_Control_MaximizeDiv").show();				
			});
			
			$("#OpenLayers_Control_MaximizeDiv").click(function(){			
				$("#OpenLayers_Control_MaximizeDiv").css("margin-top","-18px");		
				$("#OpenLayers\\.Control\\.LayerSwitcher_50").children().show()
				$("#OpenLayers_Control_MinimizeDiv").show();
				$("#OpenLayers_Control_MaximizeDiv").hide();								
			});			
		});
		
	function geoCode()
    {
      $('#find_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');
      address = $("#location_find_main").val();
      $.post("<?php echo url::site() . 'reports/geocode/' ?>", { address: address },
        function(data){
          if (data.status == 'success'){
			var lonlat = new OpenLayers.LonLat(data.message[1], data.message[0]);
            lonlat.transform(proj_4326,proj_900913);
            gMap.setCenter(lonlat, 13);
          } else {
            alert(address + " not found!\n\n***************************\nEnter more details like city, town, country\nor find a city or town close by and zoom in\nto find your precise location");
          }
          $('#find_loading').html('');
        }, "json");
      return false;
    }
     