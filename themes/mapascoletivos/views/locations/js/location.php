<?php
/**
 * JavaScript for the locations page
 */
?>

<script type="text/javascript">
$(function(){
	var map = null;

	// 
	// Backbone JS wiring for the models and views
	// 

	// Location model
	var IncidentLocation = Backbone.Model.extend({
		// Default values
		defaults: {
			"id": null,
			"incident_id": <?php echo $incident_id; ?>,
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

	// Initialize the locations collection
	var locations = new IncidentLocations();

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
			"click li a": "toggleControl",
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

	// 
	// View for adding/editing a location
	// 
	var AddLocationView = Backbone.View.extend({

		tagName: "div",

		className: "modal-dialog",

		template: _.template($("#add-location-template").html()),

		_submitted: false,

		initialize: function() {
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

		// When the dialog is closed
		close: function(e) {
			var context = this;
			$(this._dialogContainer).fadeOut("slow", function() { $(context._dialogContainer).remove(); });
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

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			// Add the media (video, news, images)
			this.addMedia("news");
			this.addMedia("video");
			this.addMedia("photo");

			// Add the dialog to its container
			$(this._dialogContainer).append(this.$el).fadeIn("slow");

			// Center the dialog - we can only get the offset after the dialog
			// has been displayed
			var margin = "-" + (this.el.offsetWidth/2) + "px";
			this.$el.css({left: "50%", "margin-left": margin});

			return this;
		}
	});

	// --------------------------------------------------------------------------
	// 


	// 
	// Initialize the list of locations
	// 
	locations.reset(<?php echo $locations; ?>);
	locations.on("add", function(location) {
		new AddLocationView({model: location}).render();
	});


	// Callback function for feature selection
	var onFeatureSelect = function(feature) {
		// Get the location id
		var locationID = feature.attributes.id;

		// Display the edit location dialog
		new AddLocationView({model: locations.get(locationID)}).render();

		return false;
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


	// 
	// Initialize the toolbar control
	// 
	var toolbarControl = new ToolbarControl();

});
</script>