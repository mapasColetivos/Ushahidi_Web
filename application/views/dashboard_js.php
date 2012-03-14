var map;
var proj_4326 = new OpenLayers.Projection('EPSG:4326');
var proj_900913 = new OpenLayers.Projection('EPSG:900913');
var markers;
var vectors;
var baseUrl = "<?php echo url::base(); ?>";
var activeFilters = ["0","1","2","3","4"];

function onPopupClose(evt)
{
    // selectControl.unselect(selectedFeature);
	for (var i=0; i<map.popups.length; ++i)
	{
		map.removePopup(map.popups[i]);
	}
}
        
var asset_count;
var asset_pointer;

function display_message(){
	var message = (asset_pointer + 1) +" de "+asset_count;
	$("#asset_count").text(message);
	asset_id = $("#asset"+asset_pointer).attr("data-id");
}

function link_tag(){
  url = baseUrl+"/users/index/"+$("#asset"+asset_pointer).attr("data-owner-id");
	link_tag_value = "<a href='"+url+"'>"+$("#asset"+asset_pointer).attr("data-owner")+"</a>";
	return link_tag_value;
}

function after_load_popup(){
	$(".assets").hide();
	asset_count = $(".assets").size();
	asset_pointer = 0;
	
	if (asset_count > 0){
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
			margin = (total_area - width)/2
			$("#description").css("margin-left",margin+"px");														
			$("#description").css("width",(width-10)+"px");
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

/*
Display popup when feature selected
*/
function onFeatureSelect(location)
{
	if (!(location.fid === undefined)){
		onPopupClose(null);
        selectedFeature = location.event;

		zoom_point = location.geometry.getBounds().getCenterLonLat();
		lon = zoom_point.lon;
		lat = zoom_point.lat;
		
		id = location.fid;
		$.get(baseUrl+"index.php/locations/popup/"+id,function(data){
			content = data;
            var popup = new OpenLayers.Popup.Anchored("chicken",location.geometry.getBounds().getCenterLonLat(),
				new OpenLayers.Size(372,310),
				content,
				null, false, onPopupClose);
	        location.popup = popup;
			onPopupClose(null);				    	        
            map.addPopup(popup);
			after_load_popup();
		});
	}
}

function add_marker(lon,lat,fid,cat,color){
	var geometry = new OpenLayers.Geometry.Point(lon,lat);
	geometry = geometry.transform(proj_4326, map.getProjectionObject())
	var feature = new OpenLayers.Feature.Vector(geometry);
	feature.fid = fid;
	feature.color = color;
	feature.category = cat;
	vectors.addFeatures(feature);
	return feature;
}

function fill_map_with_markers(){
	<?php
		foreach ($markers as $location){
	?>
		lat = <?php echo $location->latitude ?>;
		lon = <?php echo $location->longitude ?>;
		fid = <?php echo $location->id ?>;
		cat = <?php echo $location->category_id() ?>;
		color = "<?php if($color_with_category) {echo $location->category_color();} else {echo $location->layer_color();} ?>";
	
		add_marker(lon,lat,fid,cat,"#"+color)
	
	<?php } ?>
}
        
$(document).ready(function() {

	var options = {
		units: "m"
		, numZoomLevels: 50
		, minZoomLevel: 2
		, controls:[],
		projection: proj_900913,
		'displayProjection': proj_4326
	};
	map = new OpenLayers.Map('<?php echo $map_div_name; ?>', options);
	
	$('#mapProjection').html(""+map.projection);
	
	<?php echo map::layers_js(FALSE); ?>
	map.addLayers(<?php echo map::layers_array(FALSE); ?>);
	
	map.addControl(new OpenLayers.Control.PanZoomBar());
	map.addControl(new OpenLayers.Control.MousePosition(
	    { div:  document.getElementById('mapMousePosition'), numdigits: 5 
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
	
	vectors = new OpenLayers.Layer.Vector("Pontos", {
	    styleMap: new OpenLayers.StyleMap({"default":default_style}),
	    renderers: OpenLayers.Layer.Vector.prototype.renderers
	});
	
	map.addLayers([vectors]);
	
	map.addControl(new OpenLayers.Control.MousePosition());
	map.events.register("click", map, function(e) {
	  onPopupClose(e);
	  if ($("#location_box").is(":visible")){
	    $("#location_box").hide();
		hideSettings();
	  }
	});

	fill_map_with_markers();
      
	map.setCenter(myPoint, <?php echo $zoom; ?>);
	selectControl = new OpenLayers.Control.SelectFeature(
            vectors,
            {
              "onSelect": onFeatureSelect,
                clickout: true, toggle: false,
                multiple: false, hover: true,
                toggleKey: "ctrlKey", // ctrl key removes from selection
                multipleKey: "shiftKey", // shift key adds to selection
                box: true
            }
        )			
	map.addControl(selectControl);
	selectControl.activate();
	navigation = new OpenLayers.Control.Navigation(vectors,{'zoomWheelEnabled': false})
	map.addControl(navigation);
	navigation.disableZoomWheel();
	
	<?php if(isset($layers)) {?>
      <?php foreach($layers as $kml) {?>
        $.ajax({
            url: '<?php echo $kml->embed(); ?>',
            type:'HEAD',
            error:
              function(){
                $("#layer_kml"+'<?php echo $kml->id; ?>').append("<span class='kml_failure'>(falha)</span>");
            	  <?php if(isset($hide_layers)) {?>
                  $("[id*='_input_'][type*='checkbox']").attr("checked",false);              	    
                <?php } ?>                
              },
            success:
                function(){
                  layer = new OpenLayers.Layer.GML('<?php echo $kml->layer_name; ?>', '<?php echo $kml->embed(); ?>', {
              		   format: OpenLayers.Format.KML,
              		   projection: proj_4326,		   
              		   formatOptions: {
              				extractStyles: true,
              				extractAttributes: true
              			}
              		});
              	  <?php if(isset($hide_layers)) {?>
              	    layer.display(false);              	    
                    $("[id*='_input_'][type*='checkbox']").attr("checked",false);              	    
                  <?php } ?>  
              		
            	    map.addLayer(layer);
              	  
              	  pixel_size = $("#OpenLayers_Control_MinimizeDiv").css("margin-top");
              	  actual_size = parseInt(pixel_size,10);
              	  actual_size -= 14;
              	  $("#OpenLayers_Control_MinimizeDiv").css("margin-top",actual_size+"px");            	  
                }
        });
  	<?php }?>	  
	<?php } else { ?>
	<?php } ?>

	
	$(".dataLbl").html("<b>Camadas</b>")
	$(".baseLbl").html("<b>Mapa Base</b>")
	
	$("#location_find_main").val("digitar endereço, São Paulo, SP");
	$("#location_find_main").css("color","#ccc");	
	$("#location_find_main").blur(function(){
    $(this).css("color","#ccc");			  
	});
	
	$("#location_find_main").focus(function(){
	  $("#location_find_main").css("color","black");				  
	});
	
	
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("margin-top","350px");
	$("#OpenLayers_Control_MinimizeDiv").css("margin-top","-126px");
	$("#OpenLayers_Control_MaximizeDiv").css("margin-top","-27px");					
	
	$("#OpenLayers_Control_MinimizeDiv").click(function(){	
		$("#OpenLayers\\.Control\\.LayerSwitcher_38").children().hide()
		$("#OpenLayers_Control_MinimizeDiv").hide();
		$("#OpenLayers_Control_MaximizeDiv").show();				
	});
	
	$("#OpenLayers_Control_MaximizeDiv").click(function(){			
		$("#OpenLayers_Control_MaximizeDiv").css("margin-top","-18px");		
		$("#OpenLayers\\.Control\\.LayerSwitcher_38").children().show()
		$("#OpenLayers_Control_MinimizeDiv").show();
		$("#OpenLayers_Control_MaximizeDiv").hide();								
	});
		
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
	  if ($("#layer_list").is(":visible")){
			$("#image_arrow_map").attr("src","<?php echo url::base();?>media/img/arrow_up_gray.png");
	  } else {
			$("#image_arrow_map").attr("src","<?php echo url::base(); ?>media/img/arrow_down_gray.png");
	  }
	});
	
	function set_filter_off(this_filter,element){
	  $($(element).children()[0]).attr("src","<?php echo url::base(); ?>media/img/filtro-"+this_filter+"-off.png");
	}
	
	function set_filter_on(this_filter,element){
	  $($(element).children()[0]).attr("src","<?php echo url::base(); ?>media/img/filtro-"+this_filter+"-on.png");
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
		if(catID == 0){
			show_all_categories();
		} else {
			show_category(element);
		}
	}
	
	function show_all_categories(){
		var isAllActive = $("#cat_0").hasClass("active");
		$("a[id^='cat_']").removeClass("active");
		if(!isAllActive){
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
		for (layer_id in map.layers){
			current_features = map.layers[layer_id].features;
			for (id in current_features) {
				feature = current_features[id];
				
				if(catID == 0){
					if (isActive == true){
						feature.style = "none"; 				
					} else {
						feature.style = ""; 				
					}				
				} else {
					if (feature.category == catID){
						if (isActive == true){	
							feature.style = "none"; 				
						} else {
							feature.style = ""; 				
						}				
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
	
function geoCode()
{
  $('#find_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');
  address = $("#location_find_main").val();
  $.post("<?php echo url::site() . 'reports/geocode/' ?>", { address: address },
    function(data){
      if (data.status == 'success'){
		var lonlat = new OpenLayers.LonLat(data.message[1], data.message[0]);
        lonlat.transform(proj_4326,proj_900913);
        map.setCenter(lonlat, 13);
      } else {
        alert(address + " not found!\n\n***************************\nEnter more details like city, town, country\nor find a city or town close by and zoom in\nto find your precise location");
      }
      $('#find_loading').html('');
    }, "json");
  return false;
}


