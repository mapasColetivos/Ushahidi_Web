var map;
var proj_4326 = new OpenLayers.Projection('EPSG:4326');
var proj_900913 = new OpenLayers.Projection('EPSG:900913');
var markers;
var vectors;
var baseUrl = "<?php echo url::base(); ?>";
var activeFilters = ["0","1","2","3","4"];
        
var asset_count;
var asset_pointer;

function display_message() {
	var message = (asset_pointer + 1) +" de "+asset_count;
	$("#asset_count").text(message);
	asset_id = $("#asset"+asset_pointer).attr("data-id");
}

function link_tag() {
	url = baseUrl+"/users/index/"+$("#asset"+asset_pointer).attr("data-owner-id");
	link_tag_value = "<a href='"+url+"'>"+$("#asset"+asset_pointer).attr("data-owner")+"</a>";
	return link_tag_value;
}

function after_load_popup(){
	$(".assets").hide();
	asset_count = $(".assets").size();
	asset_pointer = 0;
	
	if (asset_count > 0) {
		$("#remove_asset").hide();				
		$("#asset"+asset_pointer).show();
		$("#owner").html(link_tag());				
		display_message();
		
		$("#next_button").click(function(){
			$(".assets").hide();
			asset_pointer = (asset_pointer +1) % asset_count;
			$("#asset"+asset_pointer).show();
			$("#owner").html(link_tag());
			display_message();
		});
		
		$("#previous_button").click(function(){
			$(".assets").hide();
			asset_pointer = (asset_count + asset_pointer -1) % asset_count;
			$("#asset"+asset_pointer).show();
			$("#owner").html(link_tag());
			display_message();	
		});
		
		$(".hooverable").mouseover(function(){
			if  ($("#asset"+asset_pointer).attr("data-media") == 2) {
				return "";
			}
			
			width = $(".delimiter").filter(":visible").width();
			total_area = 350;
			margin = (total_area - width)/2;
			if (margin < 0) {
			      margin = 0;
			      twidth = -30;
			} else {
			      twidth=width-10;
			}   
			$("#description").css("margin-left",margin+"px");														
			$("#description").css("width",(twidth)+"px");
			$("#description").css("height","100%");													
			if ($("iframe").filter(":visible").size() == 1){
				$("#description").css("height","100%");
			} else if ($(".external_link").filter(":visible").size() == 1){
				$("#description").css("height","100%");
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


/**
 * Destroys the popup window
 */
function onPopupClose (evt) {
    // selectControl.unselect(selectedFeature);
	for (var i=0; i<map.popups.length; ++i) {
		map.removePopup(map.popups[i]);
	}
}

function onFeatureUnselect(feature) {
    map.removePopup(feature.popup);
    feature.popup.destroy();
    feature.popup = null;
}

/** 
 * Display popup when feature selected
 */
function onFeatureSelect (feature) {
	onPopupClose(null);
	selectedFeature = feature.event;

	zoom_point = feature.geometry.getBounds().getCenterLonLat();
	lon = zoom_point.lon;
	lat = zoom_point.lat;
	
	// Variable to hold the popup content
	var content, popup;
	
	var size = new OpenLayers.Size(372, 310);
	var closeButton = false;
	
	// Check for feature id
	if (typeof feature.fid != "undefined" && feature.fid != null) {
		
		// Get the location id from the feature
		var id = feature.fid;
		
		// Issue synchronous Ajax request - a blocking call
		$.ajax({
			url: baseUrl+"index.php/locations/popup/"+id,
			async: false,
			success: function(data) {
				content = data;
			},
			error: function(data) {
				// Show error notification
				alert("Oops! An error occurred while fetching content from the server");
			}
		});
		
	} else {
		// Build a string to hold the content
		content = "<div class=\"infowindow\">\n";
		content = content + "<div class=\"infowindow_list\">"+feature.attributes.name + "</div>\n";
		content = content + "</div>\n";
		content += "</div>";
		
		size = new OpenLayers.Size(210, 120);
		closeButton = true;
	}

	popup = new OpenLayers.Popup.Anchored("chicken",
		feature.geometry.getBounds().getCenterLonLat(), 
		size,
		content, 
		null, closeButton, onPopupClose);
		
	feature.popup = popup;
	map.addPopup(popup);
	after_load_popup();
	
}

function add_marker(lon,lat,fid,cat,color) {
	var geometry = new OpenLayers.Geometry.Point(lon,lat);
	geometry = geometry.transform(proj_4326, map.getProjectionObject())
	var feature = new OpenLayers.Feature.Vector(geometry);
	feature.fid = fid;
	feature.color = color;
	feature.category = cat;
	vectors.addFeatures(feature);
	return feature;
}

function fill_map_with_markers() {
	<?php foreach ($markers as $location): ?>
		lat = <?php echo $location->latitude ?>;
		lon = <?php echo $location->longitude ?>;
		fid = <?php echo $location->id ?>;
		cat = <?php echo $location->category_id() ?>;
		color = "<?php if($color_with_category) {echo $location->category_color();} else {echo $location->layer_color();} ?>";
	
		add_marker(lon,lat,fid,cat,"#"+color);
	
	<?php endforeach; ?>
}
        
$(document).ready(function() {

	var options = {
		units: "dd", 
		numZoomLevels: 18, 
		controls:[],
		projection: proj_900913,
		'displayProjection': proj_4326
	};
	map = new OpenLayers.Map('<?php echo $map_div_name; ?>', options);
	
	$('#mapProjection').html(""+map.projection);
	
	<?php echo map::layers_js(FALSE); ?>
	map.addLayers(<?php echo map::layers_array(FALSE); ?>);
	
	map.addControl(new OpenLayers.Control.Navigation());
	map.addControl(new OpenLayers.Control.PanZoomBar());
	map.addControl(new OpenLayers.Control.MousePosition({
		div: document.getElementById('mapMousePosition'), 
		numdigits: 5 
	}));    
	map.addControl(new OpenLayers.Control.Scale("mapScale"));
	map.addControl(new OpenLayers.Control.ScaleLine());
	map.addControl(new OpenLayers.Control.LayerSwitcher());	
	
	var myPoint = new OpenLayers.LonLat(<?php echo $longitude; ?>, <?php echo $latitude; ?>);
	myPoint.transform(proj_4326, map.getProjectionObject());
	
	var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
	renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
	
	var context = {
		getColor: function(feature) {
			if (feature.color)
				return feature.color; 
			
			return "#ffffff";
		},
		getSize: function(feature) {
			return 5;
		}
	};
	
	var template = {
		pointRadius: "${getSize}", // using context.getSize(feature)
		fillColor: "${getColor}", // using context.getColor(feature)
		strokeWidth: 1
	};

	var default_style = new OpenLayers.Style(template, {context: context});

	// Create the vector layer - to render the report
	vectors = new OpenLayers.Layer.Vector("Pontos", {
	    styleMap: new OpenLayers.StyleMap({"default":default_style}),
	    renderers: OpenLayers.Layer.Vector.prototype.renderers
	});

	// Add markers to the vector layer
	fill_map_with_markers();
	map.setCenter(myPoint, <?php echo $zoom; ?>);

	// Storage for all layers
	var layersArray = [vectors];

	
	// Add all available KML layers to the map
	<?php if (isset($layers)): ?>
		<?php foreach ($layers as $kml): ?>

	      	// Create GML object for each KML entry
	      	kmlOverlay = new OpenLayers.Layer.GML('<?php echo $kml->layer_name; ?>', 
	      		'<?php echo $kml->embed(); ?>', {
	      			format: OpenLayers.Format.KML,
	      			projection: proj_4326,
	      			formatOptions: {
	      				extractStyles: true,
	      				extractAttributes: true
	      			}
	      		}
	      	);

	      	<?php if (isset($hide_layers)): ?>
	      		kmlOverlay.display(false);              	    
	      		$("[id*='_input_'][type*='checkbox']").attr("checked",false);              	    
	      	<?php endif; ?>  
	              		
	        // Add to layers array
	        layersArray.push(kmlOverlay);

	  	<?php endforeach; ?>
	<?php endif; ?>

	// Add the layers to the map
	map.addLayers(layersArray);

	// SelectFeature control
	selectControl = new OpenLayers.Control.SelectFeature(layersArray, {
		onSelect: onFeatureSelect, 
		onUnselect: onFeatureUnselect,
		hover: true
	});

	map.addControl(selectControl);
	selectControl.activate();

	
	$(".dataLbl").html("<b>Camadas</b>")
	$(".baseLbl").html("<b>Mapa Base</b>")
	
	$("#location_find_main").val("digitar endereÃ§o, SÃ£o Paulo, SP");
	$("#location_find_main").css("color","#ccc");	
	$("#location_find_main").blur(function(){
		$(this).css("color","#ccc");			  
	});
	
	$("#location_find_main").focus(function(){
		$("#location_find_main").css("color","black");				  
	});
	

	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("position","relative");
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("right","30px");
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("float","right");
	
	// $("#OpenLayers_Control_MinimizeDiv").click(function(){	
	// 	$("#OpenLayers\\.Control\\.LayerSwitcher_38").children().hide()
	// 	$("#OpenLayers_Control_MinimizeDiv").hide();
	// 	$("#OpenLayers_Control_MaximizeDiv").show();				
	// });
	// 
	// $("#OpenLayers_Control_MaximizeDiv").click(function(){			
	// 	$("#OpenLayers_Control_MaximizeDiv").css("margin-top","-18px");		
	// 	$("#OpenLayers\\.Control\\.LayerSwitcher_38").children().show()
	// 	$("#OpenLayers_Control_MinimizeDiv").show();
	// 	$("#OpenLayers_Control_MaximizeDiv").hide();								
	// });
		
	$("a[id^='cat_']").click(function(event){		
		var catID = this.id.substring(4);
		var isActive = $(this).hasClass("active");

		if($("#cat_0").hasClass("active")){
			apply_category_selection(0,true);		
		}
		
		animate_category_selection(catID,this);
		apply_category_selection(catID,isActive);
	});
	
	$("#image_arrow_map").attr("src","<?php echo url::base();?>media/img/arrow_down_gray.png");
	$("#hide_show").click(function (){
		$("#layer_list").toggle();
		if ($("#layer_list").is(":visible")) {
			$("#image_arrow_map").attr("src","<?php echo url::base();?>media/img/arrow_up_gray.png");
		} else {
			$("#image_arrow_map").attr("src","<?php echo url::base(); ?>media/img/arrow_down_gray.png");
		}
	});
	
	function set_filter_off(this_filter,element) {
		$($(element).children()[0]).attr("src", 
			"<?php echo url::base(); ?>media/img/filtro-"+this_filter+"-off.png");
	}
	
	function set_filter_on(this_filter,element) {
		$($(element).children()[0]).attr("src", 
			"<?php echo url::base(); ?>media/img/filtro-"+this_filter+"-on.png");
	}
	
	function toggle_filter(this_filter,element){
		if (activeFilters[this_filter] == this_filter){
			activeFilters[this_filter] = -1;
			
			set_filter_off(this_filter,element);
		} else {
			activeFilters[this_filter] = this_filter;
			
			set_filter_on(this_filter,element);
		}
	}
	
	$("[data-filter]").click(function (){
		toggle_filter($(this).attr("data-filter"),this);
	});
	
	function iframe_link(event){
		window.location = baseUrl+"newspage/?target="+event.currentTarget.href.match(/.*\?(.*)/)[1];
	}
		
	$("#news_iframe").load(function(){
		$("#news_iframe").contents().find('[href^="http://mapascoletivos.com"]').click(iframe_link);
		$("#news_iframe").height($("#news_iframe").contents().find("html").height());    
	});
  
	function animate_category_selection(catID,element){
		if (catID == 0){
			show_all_categories();
		} else {
			show_category(element);
		}
	}
	
	function show_all_categories(){
		var isAllActive = $("#cat_0").hasClass("active");
		$("a[id^='cat_']").removeClass("active");
		if(!isAllActive) {
			$("#cat_0").addClass("active");
		}
	}

	function show_category(element){
		selected = $(element).hasClass("active");
		if (selected){
			$(element).removeClass("active");
		} else {
			$(element).addClass("active");
		}
		$("#cat_0").removeClass("active");		
	}	
	
	function apply_category_selection(catID,isActive){	
		for (layer_id in map.layers) {
			current_features = map.layers[layer_id].features;
			for (id in current_features) {
				feature = current_features[id];
				
				if(catID == 0){
					feature.style = (isActive == true) ? "none" : "";
				} else {
					if (feature.category == catID) {
						feature.style = (isActive == true)? "none" : "";
					}
				}
			}
			map.layers[layer_id].redraw();
		}
	}
	
	$(".submit_geocode").live("click",function(){
		geoCode();    	
    });

});

function selectList(event){
	element = event.currentTarget;
	id = element.id
	$('#'+lastListShown+'_list').hide()
	$('#'+lastListShown).removeClass('active')
	lastListShown = id
	$('#'+lastListShown+'_list').show()
	$('#'+lastListShown).addClass('active')
}

var lastListShown = 'created_counter'
$(function() {
	$('.maps_counter').click(selectList);
});

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
	
function geoCode() {
	$('#find_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');
	address = $("#location_find_main").val();
	
	$.post("<?php echo url::site() . 'reports/geocode/' ?>", {address: address}, 
		function (data) {
			if (data.status == 'success') {
				var lonlat = new OpenLayers.LonLat(data.message[1], data.message[0]);
				lonlat.transform(proj_4326,proj_900913);
				map.setCenter(lonlat, 13);
			} else {
				// Build the alert message
				var alertMessage = "not found!\n\n***************************\nEnter more details like city, ";
				alertMessage = alertMessage + "town, country\nor find a city or town close by and zoom in\n";
				alertMessage = alertMessage + "to find your precise location";
				
				alert(address + alertMessage);
			}
			$('#find_loading').html('');
		}, 
		"json"
	);
	
	return false;
}