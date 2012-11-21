<script type="text/javascript">

// Set the marker raidus, opacit, stroke witdh and opacity
Ushahidi.markerRadius = "<?php echo Kohana::config('map.marker_radius'); ?>";
Ushahidi.markerOpacity = "<?php echo kohana::config('map.marker_opacity'); ?>";
Ushahidi.markerStokeWidth = "<?php echo Kohana::config('map.marker_stroke_width'); ?>";
Ushahidi.markerStrokeOpacity = "<?php echo Kohana::config('map.marker_stroke_opacity'); ?>";

var map;

/**
 * JavaScript for the locations page
 */
$(function(){

	// 
	// Backbone JS wiring for the models and views
	// 

	// Location model
	var IncidentLocation = Backbone.Model.extend({
		// Default values
		defaults: {
			"id": null,
			"incident_id": <?php echo $incident_id; ?>,
			"incident_legend_id": null,
			"location_name": null,
			"location_description": null,
			"latitude": null,
			"longitude": null,
			"news": [],
			"photo": [],
			"video": []
		}
	});
	var IncidentLocations = Backbone.Collection.extend({
		model: IncidentLocation,
		url: "<?php echo $action_url; ?>",
	});

	var KmlLayer = Backbone.Model.extend({
		defaults: {
			"id": "",
			"layer_name": "",
			"layer_file": "",
			"layer_url": "",
			"layer_color": "",
			"layer_visible": 1,
			"user_id": <?php echo $user->id; ?>
		}
	});
	var KmlLayersList = Backbone.Collection.extend({
		model: KmlLayer,
		url: "<?php echo $layers_api_url; ?>"
	});
	
	// Legends
	var Legend = Backbone.Model.extend();
	var LegendsList = Backbone.Collection.extend({
		model: Legend,
		url: "<?php echo $legends_api_url; ?>"
	});

	// Initialize the collections
	var locations = new IncidentLocations();
	var kmlLayers = new KmlLayersList();
	var incidentLegends = new LegendsList();

	// 
	// View for the controls on the toolbar
	// 
	var ToolbarControl = Backbone.View.extend({
		el: "#controlToggle",

		initialize: function() {
			if (this.$("li a.active").length === 0) {
				this.activateDefaultControl();
			}

			if (map !== null) {
				var layer = map._overlays['<?php echo $layer_name; ?>'];
				this._drawPointControl = new OpenLayers.Control.DrawFeature(
					layer, OpenLayers.Handler.Point, {featureAdded: this.addLocation});
				map._olMap.addControl(this._drawPointControl);
			}
		},

		events: {
			"click li a.toggle": "toggleControl",
			"click li a.kml-layer": "addLayer",
		},

		// Deactivates all controls
		deactivateAllControls: function() {
			var context = this;
			this.$("li a").each(function(i, control){
				$(control).removeClass("active");
				var imageSrc = context.getControlImage(control);
				$("img", control).attr("src", imageSrc);
			});

		},

		activateDefaultControl: function() {
			// Deactivate all controls
			this.deactivateAllControls();

			var control = this.$("li a.default");
			this.$("li a.default").addClass("active");

			var imageSrc = this.getControlImage(control, true)
			this.$("li a.default img").attr("src", imageSrc);
		},

		// Gets the image for the specified control
		getControlImage: function(control, clicked) {
			var imageFile = $(control).data("image");

			// Return the current image of the control, 
			// if it doesn't have an image data attribute
			if (imageFile == "" || imageFile == null) {
				return $("img", control).attr("src");
			}

			if (clicked !== undefined && clicked) {
				imageFile += "_clicked";
			}

			// Add extension
			imageFile += ".png";
			return "<?php echo url::site('media/img/toolbar'); ?>" + "/" + imageFile;
		},

		toggleControl: function(e) {
			// Deactivate all controls
			this.deactivateAllControls();

			var selectedControl = $(e.currentTarget);

			// Set the image to denote that the control has been selected
			selectedControl.addClass("active");
			var imageSrc = this.getControlImage(selectedControl, true);
			$("img", selectedControl).attr("src", imageSrc);

			// Check for the draw feature control
			if (this._drawPointControl !== undefined) {
				if (selectedControl.data("control") === "point") {
					this._drawPointControl.activate();
				} else {
					this._drawPointControl.deactivate();
				}
			}

			return false;
		},

		// Displays the add layers dialog
		addLayer: function(e) {
			new AddLayerDialog().render();
			return false;
		},

		// Shows the add location dialog
		addLocation: function(feature) {
			// Transform the coordinats to spherical mercator
			var point = new OpenLayers.Geometry.Point(feature.geometry.x, feature.geometry.y);
			OpenLayers.Projection.transform(point, Ushahidi.proj_900913, Ushahidi.proj_4326);
			// Destroy the feature
			// Only show the point after location has been saved
			feature.destroy();
			// Delete the feature
			locations.add({
				latitude: point.y,
				longitude: point.x
			});
		}

	});

	// 
	// Renders an input field
	// 
	var AddInputField = Backbone.View.extend({

		tagName: "div",

		className: "report_row",

		template: _.template($("#add-input-field-template").html()),

		events: {
			"click a.add": "add",
			"click a.rem": "delete"
		},

		add: function(e) {
			// Add media item			
			this.options.dialog.addMediaItem({
				id: null,
				media_type: this.model.media_type,
				media_link: null,
				show_remove: true
			});
			return false;
		},

		delete: function(e) {
			var view = this;
			if (this.model.id == null) {
				this.$el.fadeOut("slow");
				view.$el.remove();
			} else {

			}
			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model));
			return this;
		}
	});

	// Base dialog view
	var BaseDialog = Backbone.View.extend({

		tagName: "div",

		className: "modal-dialog",

		_init: function() {
			// Initialize the dialog container
			this._dialogContainer = document.createElement('div');
			var _css = {
				position: "absolute",
				width: "100%",
				height: "100%",
				top: "0px",
				left: "0px",
				bottom: "0px",
				right: "0px",
				"z-index": "9999",
			};

			$(this._dialogContainer).css(_css);

			var _fadedOverlay = $(this._dialogContainer).clone();
			$(_fadedOverlay).css({
				"background-color": "#000",
				opacity: "0.6",
			});

			$(this._dialogContainer).css({display: "none"});
			$(this._dialogContainer).append(_fadedOverlay);

			// Add the dialog container to the DOM
			$("body").append(this._dialogContainer);

		},

		// When the dialog is closed
		close: function(e) {
			var context = this;
			$(this._dialogContainer).fadeOut("slow", function() { $(context._dialogContainer).remove(); });
			return false;
		},

		// Displays the dialog
		display: function() {
			// Add the dialog to its container
			$(this._dialogContainer).append(this.$el).fadeIn("slow");

			// Center the dialog - we can only get the offset after the dialog
			// has been displayed
			var margin = "-" + (this.el.offsetWidth/2) + "px";
			this.$el.css({left: "50%", "margin-left": margin});			
		}
	});

	// 
	// View for adding/editing a location
	// 
	var AddLocationView = BaseDialog.extend({

		template: _.template($("#add-location-template").html()),

		_submitted: false,

		initialize: function() {
			this._init();

			// Mapping of media field types to the input types
			this._mediaFieldMap = {
				video: "text",
				news: "text",
				photo: "file"
			};

			// HashMap for the media type and the containers
			this._mediaContainers = {
				video: "#divVideo",
				news: "#divNews",
				photo: "#divPhoto",
			};
			
			// Register reset and add events for the legends collection
			incidentLegends.on("add", this.addLegend, this);			
		},

		// Events
		events: {
			"click .dialog-close a": "close",
			"click a.btn_cancel": "close",
			"click .btn_submit_location": "beginSave",
		},

		// When the save button is clicked
		beginSave: function(e) {
			// Mark the input fields as readonly
			this.$(":input").attr("readonly");

			// Replace the buttons with the loading icon
			this.$(".location_buttons").hide();
			this.$("#save_progress_bar").show();

			// When the iframe finishes loading
			var submitTarget = this.$("#location_submit_target");
			$(submitTarget).bind("load", {iframe: submitTarget, dialog: this}, this.completeSave);

		},

		// When the save is complete
		completeSave: function(e) {
			var dialog = e.data.dialog, iframe = e.data.iframe;

			// Read the response from the iframe DOM
			dialog.$("#save_progress_bar").hide();

			// Convert the JSON string to a JSON object
			// Wrap the text in parenthesis to avoid a syntax error
			var response = eval("("+iframe.contents().find("body").html()+")");
			if (response.status === "OK") {
				// Show message
				// dialog.$(".green-box").fadeIn();

				// Add the feature to the map
				map.addLocationMarker('<?php echo $layer_name; ?>', JSON.stringify(response.location));

				// Close the dialog
				setTimeout(function() { dialog.$(".dialog-close a").trigger("click"); }, 800);
			} else {
				dialog.$(".location_buttons").show();
			}

			return false;
		},

		addMediaItem: function(media) {
			var templateData = {
				id: media.id,
				media_type: media.media_type,
				input_type: this._mediaFieldMap[media.media_type],
				field_name: "location_" + media.media_type + "[]",
				value: media.media_link
			};

			// Dirty hack to allow the "remove" button to be shown
			if (media.show_remove !== undefined || media.id !== null) {
				templateData.show_remove = true;
			} else {
				templateData.show_remove = false;
			}

			var parentEl = this._mediaContainers[media.media_type];
			var view = new AddInputField({model: templateData, dialog: this});
			this.$(parentEl).append(view.render().el);
		},

		// Adds the input fields for the specified media type
		addMedia: function(mediaType) {
			if (this.model.get(mediaType).length) {
				_.each(this.model.get(mediaType), this.addMediaItem, this);
			} else {
				this.addMediaItem({id: null, media_type: mediaType, media_link: null});
			}
		},
		
		addLegend: function(legend) {
			var view = new LegendItemView({model: legend, locationView: this});
			this.$("ul.legend-list").append(view.render().el);
			
			if (this.model.get("incident_legend_id") == legend.get("id")) {
				view.$el.addClass("active");
			}
			
			// Attach events
			var context = this;
			view.$(".legend-actions a.edit").toggle(function() {
				context.editLegend(legend, view);
			}, function() {
				context.hideEditLegendForm();
			});
		},
		
		addLegends: function() {
			incidentLegends.each(this.addLegend, this);
		},
		
		// Sets the legend id for this locatio 
		// in the legend_id hidden field
		setLegend: function(legendId) {
			this.$("#incident_legend_id").val(legendId);
		},

		// Displays the form for editing a legend item
		editLegend: function(legend, legendView) {
			var view = new EditLegendView({model: legend, legendView: legendView});
			this.$("div.create-legend").html(view.render().el).slideDown();
		},
		
		// Rolls up the edit legend form
		hideEditLegendForm: function(e) {
			this.$("div.create-legend").slideUp();
			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			// Add the media (video, news, images)
			this.addMedia("news");
			this.addMedia("video");
			this.addMedia("photo");
			this.addLegends();

			this.display();
			
			// Event binding
			var context = this;
			this.$("a#add-legend").toggle(function(){
				context.editLegend(new Legend({legend_name: null, legend_color: null}));
			}, function() {
				context.hideEditLegendForm();
			});

			return this;
		}
	});
	

	// 
	// Dialog for the KMLs
	// 
	var AddLayerDialog = BaseDialog.extend({

		template: _.template($("#add-layer-dialog-template").html()),

		initialize: function() {
			this._init();
			kmlLayers.on("add", this.addLayer, this);
		},

		events: {
			"click .dialog-close a": "close",
		},

		addLayer: function(layer) {
			var view = new LayerItemView({model: layer});
			this.$("div.report_map").append(view.render().el);

			var context = this;
			view.$("a.edit").toggle(function() {
				context.editLayer(layer);
			}, function() {
				context.hideEditForm();
			})
		},

		addLayers: function() {
			kmlLayers.each(this.addLayer, this);
		},

		editLayer: function(layer) {
			var view = new EditLayerView({model: layer});
			this.$("div.create-layer").html(view.render().el).slideDown();
		},

		hideEditForm: function() {
			this.$("div.create-layer").slideUp();
		},

		render: function() {
			this.$el.html(this.template());
			kmlLayers.each(this.addLayer, this);

			$(this._dialogContainer).append(this.$el).fadeIn("slow");
			this.display();

			var context = this;
			this.$("a.create-layer").toggle(function() {
				context.editLayer(new KmlLayer());
			}, function() {
				context.hideEditForm();
			});

			return this;
		}
	});

	// View for a single layer item in the dialog
	var LayerItemView = Backbone.View.extend({

		tagName: "div",

		className: "report_row border",

		template: _.template($("#add-layer-item-template").html()),

		events: {
			"click a.remove": "delete",
			"click a.add-layer": "addToIncident"
		},

		delete: function(e) {
			var context = this;
			this.model.destroy({wait: true, success: function(response) {
				context.$el.fadeOut();
			}});

			return false;
		},

		addToIncident: function(e) {
			var context = this;
			this.model.save({}, {
				wait: true,
				success: function(model, response){
					kmlLayers.remove(model);
					context.$el.fadeOut();					
				}
			});
			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));

			var context = this;
			this.$el.hover(function() {
				context.$el.css({"background-color": "#FFFEEB"});
			}, function() {
				context.$el.css({"background-color": "#FFF"});
			});

			return this;
		}
	});

	// View for editing/adding a new layer
	var EditLayerView = Backbone.View.extend({

		template: _.template($("#edit-layer-template").html()),

		events: {
			"click .btn_submit_location" : "beginSave"
		},

		beginSave: function(e) {
			// Mark the input fields as readonly
			this.$(":input").attr("disabled");

			// Replace the buttons with the loading icon
			this.$(".location_buttons").hide();
			this.$("#save_progress_bar").show();

			// When the iframe finishes loading
			var submitTarget = this.$("#layer_submit_target");
			$(submitTarget).bind("load", {iframe: submitTarget, form: this}, this.completeSave);
		},

		// When saving is complete
		completeSave: function(e) {
			var form = e.data.form, iframe = e.data.iframe;

			// Convert the JSON string to a JSON object
			// Wrap the text in parenthesis to avoid a syntax error
			var response = eval("("+iframe.contents().find("body").html()+")");
			if (response.success) {
				if (response.layer !== undefined) {
					kmlLayers.add(response.layer);
				}
				$(form.$el).parent('div.create-layer').slideUp();
			} else {
				// An error ocurred
				form.$(":input").removeAttr("disabled");
				form.$(".location_buttons").hide();
			}

			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));

			// Color picker events
			var context = this;
			this.$("#layer_color").ColorPicker({
				onSubmit: function(hsb, hex, rgb) {
					$('#layer_color').val(hex);
				},
				onChange: function(hsb, hex, rgb) {
					$('#layer_color').val(hex);
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			}).bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});

			$(".colorpicker").css({"z-index": 10001});
			return this;
		}
	});
	
	// View for a single legend item
	var LegendItemView = Backbone.View.extend({
		
		tagName: "li",
		
		template: _.template($("#add-legend-template").html()),
				
		events: {
			"click a.legend": "select",
			"click .legend-actions a.remove": "delete"
		},
		
		// Sets the legend for the current location to the
		// selected one
		select: function(e) {
			// Remove the active class from all legends
			$("ul.legend-list li").removeClass("active");
			this.$el.addClass("active");

			this.options.locationView.setLegend(this.model.get("id"));
			return false;
		},
		
		// Updates display when the model (legend name or color) is modified
		update: function(legend) {
			this.model = legend;
			this.$el.html(this.template(legend.toJSON()));
		},

		// Handles deletion of legends
		delete: function(e) {
			var view = this;
			this.model.destroy({
				wait: true, 
				success: function(model, response) {
					// Remove the legend from view
					view.$el.fadeOut();
				}
			});

			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			return this;
		}
	});
	
	// Add/edit legend view
	var EditLegendView = Backbone.View.extend({
		
		template: _.template($("#edit-legend-template").html()),
		
		_isSaving: false,
		
		events: {
			"click a.save": "save",
			"click a.cancel": "cancel",
		},
		
		// Add/edit legends
		save: function(e) {
			if (!this._isSaving) {
				this._isSaving = true;

				// Grey/disable out the input fields
				this.$("input").attr("readonly");
		
				// Get the input data - legned name and color
				var legendName = this.$("#legend_name").val(),
					legendColor = this.$("#legend_color").val(),
					context = this;
				
				// Abort of legend name or color are not specified
				if (legendName == '' || legendColor == '')
					return false;
				
				// Options to be passed when adding/updating a legend	
				var saveOptions = {						
					wait: true, 
					success: function(model, response) {
						// Show success message
						context._isSaving = false;
						if (context.options.legendView !== undefined) {
							context.options.legendView.update(model);
						}
						// Hide this form
						context.$el.parent("div.create-legend").slideUp();
					},
					error: function(response) {
						context.$("input").removeAttr("readonly");
						context._isSaving = false;
					},
				};
				
				// Legend data to be saved
				var legendData = {legend_name: legendName, legend_color: legendColor}; 
				
				if (this.model.get("id") === undefined) {
					// Adding a new model, add to the collection
					incidentLegends.create(legendData, saveOptions);
				} else {
					// Updating a model
					this.model.save(legendData, saveOptions);
				}
			}
			// Halt further event processing
			return false;
		},
		
		// Cancel add/edit
		cancel: function(e) {
			this.$el.parent("div.create-legend").slideUp();
			return false;
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			
			// Color picker events
			this.$("#legend_color").ColorPicker({
				onSubmit: function(hsb, hex, rgb) {
					$('#legend_color').val(hex);
				},
				onChange: function(hsb, hex, rgb) {
					$('#legend_color').val(hex);
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			}).bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});

			$(".colorpicker").css({"z-index": 10001});
			return this;
		}
	});
	
	var StatusDialog = BaseDialog.extend({
		template: _.template($("#status-dialog-template").html()),
		
		initialize: function() {
			this._init();
		},
		
		events: {
			"click .dialog-close a": "close",
		},
		
		message: function(message) {
			// Hides the loading gif and displays a message in it's place
			this.$(".status-message").html(message);
		},
		
		render: function(){
			this.$el.html(this.template());
			this.display();
			return this;
		}
	});

	// --------------------------------------------------------------------------
	// 


	// 
	// Initialize the list of locations, kmls and legends
	// 
	locations.reset(<?php echo $locations; ?>);
	locations.on("add", function(location) {
		new AddLocationView({model: location}).render();
	});

	kmlLayers.reset(<?php echo $layers; ?>);
	incidentLegends.reset(<?php echo $incident_legends; ?>);


	// Callback function for feature selection
	var onFeatureSelect = function(feature) {
		// Get the location id
		var locationID = feature.attributes.id;

		// Display the edit location dialog
		new AddLocationView({model: locations.get(locationID)}).render();
	};



	// -----------------
	// Boostrap the map
	// -----------------
	// Set the base url
	Ushahidi.baseURL = "<?php echo url::site(); ?>";

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
	map = new Ushahidi.Map('user_map', mapConfig);
	map.addLayer(Ushahidi.GEOJSON, {
		name: "<?php echo $layer_name; ?>",
		url: "<?php echo $markers_url; ?>",
		onFeatureSelect: onFeatureSelect,
	}, true);

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

	// When the "Find location" button is clicked
	$("#find-location").click(function(){
		// Get the location name
		var locationName = $.trim($("#location_find").val());
		if (locationName.length > 0) {
			findLocation(locationName);
		}
		
		// Prevent further even propagation
		return false;
	});
	
	// When the "return" key is pressed while the location address bar
	// is in focus
	$("#location_find").bind("keyup", function(e){
		if (e.which == 13) {
			var locationName = $.trim(this.value);
			if (locationName.length > 0) {
				findLocation(locationName);
				return false;
			}
		}
	});
	
	// Geocodes the provided location name and displays the "Add Location" dialog
	// If the location is not found, the status dialog will display a 
	// "Location not found" message
	var findLocation = function(locationName) {
		var statusDialog = new StatusDialog();
		statusDialog.render();

		setTimeout(function(){
			$.ajax({
				type: "post",
					
				url: "<?php echo $geocoder_url; ?>",
					
				data: {address: locationName},
					
				// Server returned status 200
				success: function(response){
					// Get the location name, latitude and longitude
					if (response.location_name !== undefined) {
						statusDialog.$(".dialog-close a").trigger("click");

						// Show add location dialog
						locations.add({
							location_name: response.location_name,
							latitude: response.latitude,
							longitude: response.longitude
						});
					} else {
						// Show "Location not found" on message dialog
						var message = "<h3>Location \"" + locationName + "\" not found.</h3>";
						statusDialog.message(message);
					}
				},

				//  Server returned status code other than 200
				error: function(response) {
					var message = "<h3>An unknown error has occured. Please try again.</h3>";
					statusDialog.message(message);
				},
					
				dataType: "json"
			});
		}, 1500);		
	}


	// 
	// Initialize the toolbar control
	// 
	var toolbarControl = new ToolbarControl();	

});
</script>