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
    var map;
    var thisLayer;
    var empty_location_form;
    var proj_4326 = new OpenLayers.Projection('EPSG:4326');
    var proj_900913 = new OpenLayers.Projection('EPSG:900913');
    var markers;
    var controls;
    var current_control;
    var vectors;
    var current_location;
    var popup;
	var baseUrl = "<?php echo url::base(); ?>";
	var userId = "<?php echo $user_id; ?>";	

	function current_layer_id(){
		return $(".layer_description").filter(".selected").attr("data-id");
	}
	
	function current_layer_color(){
		return $(".layer_description").filter(".selected").children('span').css("background");
	}
	
	function update_map_colors(layer_id,color){
	  for(fid in vectors.features) {
      feature = vectors.features[fid];
  		if(feature.layer_id == layer_id){
        feature.color = color;
      }
    }
    vectors.redraw();
	}
	
	function add_marker(lon,lat,fid,cat,layer,color){
		var geometry = new OpenLayers.Geometry.Point(lon,lat);
		geometry = geometry.transform(proj_4326, map.getProjectionObject())
		var feature = new OpenLayers.Feature.Vector(geometry);
		feature.fid = fid;
		feature.color = color;
		feature.category = cat;
		feature.layer_id = layer;
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
		color = "<?php echo $location->layer_color() ?>";
		layer = <?php echo $location->layer_id ?>;
		
		add_marker(lon,lat,fid,cat,layer,"#"+color)
		
		<?php } ?>
	}
	
	function find_feature_by_id(id){
		 for(fid in vectors.features) {
           feature = vectors.features[fid];
			if(feature.fid == id){
				return feature;
            }
         }
	}

	function submit_map_form(){
		$("#mapsForm").ajaxForm();
	}

    function remove_location_from_server(id){
  		$("#location_box").load("<?php echo url::base() ?>index.php/locations/destroy/"+id);
    }
      
      function get_location_from_server(id){
                console.log("AA");
                $('#location_box').show();
		$('#location_box').html('<img src="<?php echo url::base() . "media/img/loading_g.gif"; ?>">');		
		map_id = $("#incident_id").val();
		if (id <= 0){
			$("#location_box").html(empty_location_form);
			
			$(".btn_remove").hide();
			
			if (id == -1){
  				$("#location_name").val($("#location_find").val());
  			}
  				
		    $("#location_lat").val($("#latitude").val());
		    $("#location_lon").val($("#longitude").val());
		} else {
			$("#location_box").load("<?php echo url::base() ?>index.php/locations/show/"+id+"/"+map_id, function (){	
			 
			      $(".btn_cancel").click(function(){
		   			$("#location_box").hide();
					hideSettings();          
			      }); 			
			      
			      $(".btn_remove").click(function(){

				/*var feature = find_feature_by_id(id);
				$("#location_find").val(find_feature_by_id(id));
				$("#find_text").html("<p>YESSSSSS</p>");
				for(att in feature){
				      alert(feature[att]);
				}*/

				if(confirm("<?php echo Kohana::lang('ui_main.confirm_remove').' esse ponto?'?>")){	  			
				      var feature = find_feature_by_id(id);
				      vectors.removeFeatures(feature);
					      
				      remove_location_from_server(id);
				    }
				
				$("#location_box").hide();
					hideSettings();
			      });
			});
		}
		
		if (!$("#location_box").is(":visible")){
			showSettings();
		    $("#location_box").show();
		}
      }
      
      var open_select_feature = function (location){
	      current_location = location;	      
	      get_location_from_server(location.fid);
	      if (location.fid > 0){
			    onFeatureSelect(location);
		    }
      }
      
	  var points = 0;
      var add_point_to_form = function (location){
	      location.seq = points;
	      points++;
	      
		  location.color = "#ffffff";
	      geometry = location.geometry.clone();
	      geometry.transform(map.getProjectionObject(),proj_4326);
		  var point = geometry.getVertices()[0];	      
  		  $("#latitude").val(point.y);
  		  $("#longitude").val(point.x);
	      incident_id = $("#incident_id").val();
	      
	      location.fid = 0;
		  //open_select_feature(location);		  
		  $("#noneToggle").click(); 
       }
       
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
	        
    // jQuery Textbox Hints Plugin
    // Will move to separate file later or attach to forms plugin
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
        
    /**
     * Google GeoCoder
     */
    function geoCode()
    {
      $('#find_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');
      address = $("#location_find").val();
      $.post("<?php echo url::site() . 'reports/geocode/' ?>", { address: address },
        function(data){
          if (data.status == 'success'){
			feature = add_marker(data.message[1],data.message[0],-1,"#ffffff");        
			
			var lonlat = new OpenLayers.LonLat(data.message[1], data.message[0]);
            lonlat.transform(proj_4326,proj_900913);
            map.setCenter(lonlat, <?php echo $zoom; ?>);

            // Update form values
            $("#latitude").attr("value", data.message[0]);
            $("#longitude").attr("value", data.message[1]);
            $("#location_name").attr("value", $("#location_find").val());
			//add_point_to_form(feature);
          } else {
            alert(address + " not found!\n\n***************************\nEnter more details like city, town, country\nor find a city or town close by and zoom in\nto find your precise location");
          }
          $('#find_loading').html('');
        }, "json");
      return false;
    }
    
    
    $(document).ready(function() {
		map_id = $("#incident_id").val();
        $.get("<?php echo url::base() ?>index.php/locations/show/0/"+map_id, function (data){
      		empty_location_form = data;
	    });

		$('img[data-image]').mousedown(function(){
			image = $(this).attr("data-image");
			$(this).attr("src",baseUrl+"media/img/toolbar/"+image+"_clicked.png");
		});
		
		$('img[data-image]').mouseout(function(){
			image = $(this).attr("data-image");
			$(this).attr("src",baseUrl+"media/img/toolbar/"+image+".png");
		});
 
		$('a[rel*=layer]').live("click",function(){
			link = $(this).attr("href");
			$.facebox(function() {
				$.facebox('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');
				$(".close_image").attr("src","<?php echo url::base().'facebox/closelabel.png' ?>");						
				$.get(link,function(data){
					$.facebox(data);
				});
			});	
			return false;
		});
		    
    $("#download_csv").click(function(){
			url = $(this).attr('data-get');
			$.get(url,function(){
			});
		});
    
		$(".select_layer").live("click",function(){
			$(".layer_description").removeClass("selected");
			var selected_id = $(this).parent().attr("data-id");
			$("#layer_id").val(selected_id);
			$(this).closest("div").addClass("selected");
		});	
		
		$(".delete_layer").live("click",function(){
			id = $(this).parent().attr("data-id");
				  	if(confirm("<?php echo Kohana::lang('ui_main.confirm_remove').' esse layer?'?> ")){
			$.get("<?php echo url::base() ?>index.php/layers/destroy/"+id,function(){
			window.location = $("#incident_id").val();
			});
		}			
		});

		$("#new_layer").live("click",function(){ console.log("LAB MACAMBIRA");
			id = $("#incident_id").val();
			$.get("<?php echo url::base() ?>index.php/layers/create/"+id,function(data,textStatus,jqXHR){
				$("#table_of_contents").append(data);
				$("#location_table_of_contents").append(data);			
			});
		});
	
    // Now initialise the map
    var options = {
    units: "m"
    , numZoomLevels: 50
    , minZoomLevel: 2
    , controls:[],
    projection: proj_900913,
    'displayProjection': proj_4326
    };
    map = new OpenLayers.Map('divMap', options);

    <?php echo map::layers_js(FALSE); ?>
    map.addLayers(<?php echo map::layers_array(FALSE); ?>);
    
    <?php foreach($incident->layers() as $kml) {?>
      $.ajax({
          url: '<?php echo $kml->embed(); ?>',
          type:'HEAD',
          error:
            function(){
              $("#layer_kml"+'<?php echo $kml->id; ?>').append("<span class='kml_failure'>(falha)</span>");
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
          	    map.addLayer(layer);
            	  pixel_size = $("#OpenLayers_Control_MinimizeDiv").css("margin-top");
            	  actual_size = parseInt(pixel_size,10);
            	  actual_size -= 14;
            	  $("#OpenLayers_Control_MinimizeDiv").css("margin-top",actual_size+"px");            	            	    
              }
      });
      
  	<?php }?>

    
	// map.addControl(new OpenLayers.Control.PanZoom());
	map.addControl(new OpenLayers.Control.PanZoomBar());
    map.addControl(new OpenLayers.Control.MousePosition(
        { div:  document.getElementById('mapMousePosition'), numdigits: 5 
    }));    
    map.addControl(new OpenLayers.Control.Scale('mapScale'));
    map.addControl(new OpenLayers.Control.ScaleLine());
	  map.addControl(new OpenLayers.Control.LayerSwitcher());	    
	  
    // Create the markers layer
    markers = new OpenLayers.Layer.Markers("Markers");
    map.addLayer(markers);
    
    // create a lat/lon object
    var myPoint = new OpenLayers.LonLat(<?php echo $longitude; ?>, <?php echo $latitude; ?>);
    myPoint.transform(proj_4326, map.getProjectionObject());
    
    // create a marker positioned at a lon/lat
    //var marker = new OpenLayers.Marker(myPoint);
    //markers.addMarker(marker);
    // allow testing of specific renderers via "?renderer=Canvas", etc
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
  
  	navigate = new OpenLayers.Control.Navigation(vectors)
    controls = {
      navigation: navigate,
        
      point: new OpenLayers.Control.DrawFeature(vectors,
                  OpenLayers.Handler.Point,{"featureAdded": add_point_to_form}),
      line: new OpenLayers.Control.DrawFeature(vectors,
                  OpenLayers.Handler.Path),
      polygon: new OpenLayers.Control.DrawFeature(vectors,
                  OpenLayers.Handler.Polygon),
      drag: new OpenLayers.Control.DragFeature(vectors),
        
      select: new OpenLayers.Control.SelectFeature(
            vectors,
            {
              "onSelect": open_select_feature,
                clickout: true, toggle: false,
                multiple: false, hover: false,
                toggleKey: "ctrlKey", // ctrl key removes from selection
                multipleKey: "shiftKey", // shift key adds to selection
                box: true
            }
        )
    };
    
    for(var key in controls) {
        map.addControl(controls[key]);
    }
    navigate.disableZoomWheel();
          
    // display the map centered on a latitude and longitude (Google zoom levels)
    map.setCenter(myPoint, <?php echo $zoom; ?>);
	
    toggleControl('select');
    andControl('navigation');
    hideSettings();
    
    $(".dataLbl").html("<b>Camadas</b>")
  	$(".baseLbl").html("<b>Mapa Base</b>")
  	//$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("margin-top","350px");

	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("position","relative");
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("right","30px");
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("top","30px");
	$("#OpenLayers\\.Control\\.LayerSwitcher_38").css("float","right");

  	$("#OpenLayers_Control_MinimizeDiv").css("margin-top","-140px");
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
    // Detect Dropdown Select
    $("#select_city").change(function() {
      var lonlat = $(this).val().split(",");
      if ( lonlat[0] && lonlat[1] )
      {
        l = new OpenLayers.LonLat(lonlat[0], lonlat[1]);
        l.transform(proj_4326, map.getProjectionObject());
        m = new OpenLayers.Marker(l);
        markers.clearMarkers();
        markers.addMarker(m);
        map.setCenter(l, <?php echo $zoom; ?>);
        
        // Update form values (jQuery)
        $("#location_name").attr("value", $('#select_city :selected').text());
                  
        $("#latitude").attr("value", lonlat[1]);
        $("#longitude").attr("value", lonlat[0]);
      }
    });
    
    // GeoCode
    $('.btn_find').live('click', function () {
      geoCode();
    });
    
    // Location Find
    $('#location_find').bind('keypress', function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if(code == 13) { //Enter keycode
        geoCode();
        return false;
      }
    });
    
    // Textbox Hints
    $("#location_find").hint();
    
    // Toggle Date Editor
    $('a#date_toggle').click(function() {
        $('#datetime_edit').show(400);
      $('#datetime_default').hide();
        return false;
    });
    
    
    // Category treeview
    $("#category-column-1,#category-column-2").treeview({
      persist: "location",
      collapsed: true,
      unique: false
    });
  
    }); //ends the document load query
    
    function deactivateControls(){
      for(key in controls) {
        controls[key].deactivate();
      }
    }
    
    function toggleControl(name) {
	  deactivateControls();
      controls[name].activate();
      $.map($("input[data-image]"),function(input){
      	if ($("#"+input.id).attr("checked")){
      		image = $("#"+input.id).attr("data-image");
			$("#img_"+image).attr("src",baseUrl+"media/img/toolbar/"+image+"_clicked.png");
      	} else {
      		image = $("#"+input.id).attr("data-image");
			$("#img_"+image).attr("src",baseUrl+"media/img/toolbar/"+image+".png");      		
      	}
      });
    }
      
    function andControl(name){
      controls[name].activate();
    }
    
    function showSettings(){
      $("#edit_box").height(594);
    }
    
    function hideSettings(){
      layers = $(".layer_description").size();
	    $("#chicken").hide();
    }
    
    
    //POPUP COPY
    	/*
		Close Popup
		*/
		function onPopupClose(evt)
		{
            // selectControl.unselect(selectedFeature);
			for (var i=0; i < map.popups.length; ++i )
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

			$("#remove_asset").click(function(){
        var answer = confirm('Você tem certeza que deseja remover esse anexo ?');
        if (answer){
          window.location = "<?php echo url::base() . 'locations/deleteAsset2/' ?>"+asset_id+"<?php echo '/' . $user_id; ?>";	  
        }
    	});
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
    		$("#remove_asset").show();				
    		$("#asset"+asset_pointer).show();
    		$("#owner").html(link_tag());				
    		display_message();

    		$("#next_button").click(function(){
    			$(".assets").hide();
    			asset_pointer = (asset_pointer +1) % asset_count;
    			$("#asset"+asset_pointer).show();
    			$("#owner").html(link_tag());
    			if(userId == $("#asset"+asset_pointer).attr("data-owner-id")){
    				$("#remove_asset").show();									
    			} else {
    				$("#remove_asset").hide();					
    			}					
    			display_message();
    		});

    		$("#previous_button").click(function(){
    			$(".assets").hide();
    			asset_pointer = (asset_count + asset_pointer -1) % asset_count;
    			$("#asset"+asset_pointer).show();
    			$("#owner").html(link_tag());
    			if(userId == $("#asset"+asset_pointer).attr("data-owner-id")){
    				$("#remove_asset").show();									
    			} else {
    				$("#remove_asset").hide();					
    			}										
    			display_message();	
    		});
				
				$(".hooverable").mouseover(function(){
					width = $(".delimiter").filter(":visible").width();
					total_area = 350;
					margin = (total_area - width)/2;
					if (margin < 0){
					      margin = 0;
					      twidth = -30;
					}
					else {
					      twidth=width-10;
					}   
					$("#description").css("margin-left",margin+"px");														
					$("#description").css("width",(twidth)+"px");
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


			$(".close_image_popup").hide();			
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
