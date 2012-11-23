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
			options.selectOnHover = true;

		} else if (layerType === Ushahidi.KML) {
			options.selectOnHover = false;

			// Delegate feature selection to the parent function
			mapasColetivos.Map.prototype.onFeatureSelect = Ushahidi.Map.prototype.onFeatureSelect;
		}
		Ushahidi.Map.prototype.addLayer.call(this, layerType, options, save);
		return this;
	}

	/**
	 * Overrides the default feature selection behaviour
	 */
	mapasColetivos.Map.prototype.onFeatureSelect = function(feature) {
		// Close all open popups
		this.closePopups();

		// Cache the currently selected feature
		this._selectedFeature = feature;

		// Get the location id of the selected feature
		var locationId = feature.attributes.id;
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
						feature.geometry.getBounds().getCenterLonLat(),
						new OpenLayers.Size(372, 310),
						response,
						null,
						false,
						context.onPopupClose
					);

					// Display the popup
					context._olMap.addPopup(popup);
					popup.show();

					// Register the popup
					context.registerPopup(popup);

					// Register click events for the popup
					var responseDOM = $("#location_popup_"+locationId);
					$(".close_image_popup", responseDOM).click(function(){
						popup.destroy();
					});

					// Attach events to the popup DOM
					attachEvents2Popup(responseDOM);
				}
			});
		}, 500);
	}

	/**
	 * Attaches events to the popup DOM
	 */
	attachEvents2Popup = function(dom) {
		// Get total no. of assets then hide them
		var assets = $(".asset_area div.assets", dom);
		var assetCount = assets.size();
		var idx = 0;

		// Show the first element
		$(".asset_area div.assets", dom).remove();
		displayMediaAsset(idx, false);

		// Next button clicked
		$("#asset_nav_next", dom).click(function(e) {
			idx += ((idx + 1) == assetCount) ? -idx : 1;
			displayMediaAsset(idx, true);
			return false;
		});

		// Previous button clicked
		$("#asset_nav_previous", dom).click(function(e){
			idx = (idx == 0) ? assetCount - 1 : idx - 1;
			displayMediaAsset(idx, true);
			return false;
		});
		
		// Displays the media asset
		function displayMediaAsset(index, clearAssetArea) {
			if (clearAssetArea) {
				$(".asset_area div.assets", dom).fadeOut().remove();
			}

			// Get the asset at the specified index
			var asset = $(assets[index]);
			
			// Display the asset
			$(".asset_area", dom).append(asset).fadeIn("slow");

			// Update the position
			$("#current_asset_pos", dom).html(index+1);

			// (Un)Bind events
			if ($(".ignore-hover", asset).length) {
				$(".hooverable", dom).mouseover(function(e) { return false; });
			} else {
				// Mouseover
				$(".hooverable", dom).mouseover(function(e) {
					var imgNode = $("img.delimiter", this); 
					var margin = (imgNode.position() !== null) ? $(imgNode).position().left : 0;
				
					// Attributes for the overlay
					var attrs = {
						"margin-left": margin  + "px",
					};
					$(".asset-overlay", dom).css(attrs).show();
					return false;
				});
				
				// Mouseout
				$(".hooverable", dom).mouseout(function(e){
					$(".asset-overlay", dom).hide();
					return false;
				});
			}
		}
	}
}
</script>