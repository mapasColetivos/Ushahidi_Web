<div class="layers-overlay" style="display:none;">
	<div class="map-layers">

	<!-- incident legends -->				
	<?php if (count($incident_legends)): ?>
		<ul class="legend-filters" id="legend-switcher">
		<?php foreach ($incident_legends as $legend): ?>
			<li>
				<a href="#" data-legend-id="<?php echo $legend['id']; ?>">
					<span class="swatch" style="background-color: #<?php echo $legend['legend_color']; ?>;"></span>
					<span class="legend-title"><?php echo $legend['legend_name']; ?></span>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<!-- /incident legends -->
					
	<!-- incident layers -->
	<?php if (count($incident_layers)): ?>
		<ul class="legend-filters" id="layer-switcher">
	 	<?php foreach ($incident_layers as $layer): ?>
	 		<li>
	 			<a href="#" data-layer-id="<?php echo $layer->id; ?>" data-layer-name="<?php echo $layer->layer_name; ?>">
		 			<span class="swatch" style="background-color: #<?php echo $layer->layer_color; ?>"></span>
		 			<span class="legend-title"><?php echo $layer->layer_name; ?></span>
	 			</a>
	 		</li>
	 	<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<!-- /incident layers -->
	</div>
</div>

<script type="text/javascript">
jQuery(window).load(function() {

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
	$("ul#layer-switcher li > a").click(function(e) {
		// Get the layer id
		var layerId = $(this).data("layer-id");

		var isCurrentLayer = false;
		var context = this;

		// Remove all actively selected layers
		$("#layer-switcher a").each(function(i) {
			if ($(this).hasClass("active")) {
				isCurrentLayer = $(this).data("layer-id") == layerId;
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
	
	// Legend selection
	$("ul#legend-switcher li > a").click(function(e){

		// Get the legend id
		var legendId = $(this).data("legend-id"),
			isCurrentLegend = false;

		$("#legend-switcher a").each(function(i){
			if ($(this).hasClass("active")) {
				isCurrentLegend = $(this).data("legend-id") == legendId;
				$(this).removeClass("active");
			}
		});
		
		if (!isCurrentLegend) {
			$(this).addClass("active");
			map.updateReportFilters({legend: legendId});
		} else {
			map.updateReportFilters({legend: 0});
		}

		return false;
	});
});
</script>