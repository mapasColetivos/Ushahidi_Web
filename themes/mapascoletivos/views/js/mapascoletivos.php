<script type="text/javascript">
// Check if the Ushahidi namespace has been registered
// Create a mapasColetivos namespace and extend the Ushahidi.Map object
if (window.Ushahidi) {

	// Set the width and height of the external graphics
	Ushahidi.graphicWidth = 14;
	Ushahidi.graphicHeight = 22;

	/**
	 * Extend Ushahidi.Map within the mapasColetivos namespace
	 */
	window.mapasColetivos = {
		Map: function(div, config) {
			Ushahidi.Map.apply(this, arguments);
			this._timeoutID = null;
			return this;
		}
	};

	// Default the constructor for mapasColetivos.Map to Ushahidi.Map
	mapasColetivos.Map.prototype = Object.create(Ushahidi.Map.prototype);

	/**
	 * Overload Ushahidi.Map.addLayer
	 */
	mapasColetivos.Map.prototype.addLayer = function(layerType, options, save) {

		if (layerType === Ushahidi.GEOJSON) {
			// Enable layer selection on hover
			this._selectOnHover = true;

		} else if (layerType === Ushahidi.KML) {
			this._selectOnHover = false;

			// Delegate feature selection to the parent function
			mapasColetivos.Map.prototype.onFeatureSelect = Ushahidi.Map.prototype.onFeatureSelect;
		}

		Ushahidi.Map.prototype.addLayer.call(this, layerType, options, save);
		return this;
	}

	/**
	 * Overrides the default feature selection behaviour
	 */
	mapasColetivos.Map.prototype.onFeatureSelect = function(event) {
		// Close all popups
		this.closePopups();

		// Cache the currently selected feature
		this._selectedFeature = event.feature;

		// Get the location id of the selected feature
		var locationId = event.feature.attributes.id;
		var context = this;

		// Check if we have a timeout to clear
		if (this._timeoutID !== null) {
			window.clearTimeout(this._timeoutID);
		}

		// Load the popup content via XHR
		this._timeoutID = window.setTimeout(function() {
			$.ajax({
				type: "GET",
				url: Ushahidi.baseURL + "json/location_popup/" + locationId,
				success: function(response) {
					var popup = new OpenLayers.Popup.Anchored("chicken",
						event.feature.geometry.getBounds().getCenterLonLat(),
						new OpenLayers.Size(372, 310),
						response,
						null,
						false,
						this.onPopupClose
					);

					// Display the popup
					event.feature.popup = popup;
					context._olMap.addPopup(popup);
					popup.show();

					// Register the popup
					context.registerPopup(popup);

					// Register click events for the popup
					$(".close_image_popup").click(context.onPopupClose);

					// Get total no. of assets then hide them
					var assets = $(".asset_area div.assets");
					var assetCount = assets.size();
					var idx = 0;

					// Show the first element
					$(".asset_area div.assets").remove();
					$(".asset_area").append($(assets[idx]).fadeIn());

					// Next button clicked
					$("#asset_nav_next").click(function(e) {
						$(".asset_area div.assets").fadeOut().remove();
						if ((idx + 1) == assetCount) {
							// We're already on the last item
							idx = 0;
							$(".asset_area").append($(assets[idx]).fadeIn());						
						} else {
							idx += 1;
							$(".asset_area").append($(assets[idx]).fadeIn());
						}

						$("#current_asset_pos").html((idx+1));

						return false;
					});

					// Previous button clicked
					$("#asset_nav_previous").click(function(e){
						$(".asset_area div.assets").fadeOut().remove();
						if (idx == 0) {
							// We're already on the first item
							idx = assetCount - 1;
							$(".asset_area").append($(assets[idx]).fadeIn());
						} else {
							idx -= 1;
							$(".asset_area").append($(assets[idx]).fadeIn());
						}
						$("#current_asset_pos").html((idx+1));
						return false;
					});

					// Mouseover events
					$(".hooverable").mouseover(function(e){
						var overlayWidth = $("img.delimiter", this).width();
						var margin = $("img.delimiter", this).position().left;

						if (overlayWidth < 100) {
							overlayWidth = $("div.assets", this).width();
							margin = 0;
						}

						// Attributes for the overlay
						var attrs = {
							"margin-left": margin  + "px",
							"width": overlayWidth + "px"
						};
						$(".asset-overlay").css(attrs).show();
					});

					$(".hooverable").mouseout(function(e){
						$(".asset-overlay").hide();
					});
				}
			});
		}, 500);
	}

}
</script>