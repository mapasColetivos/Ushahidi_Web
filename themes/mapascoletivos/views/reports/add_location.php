<div class="content-bg">
	<div class="big-block">			
		<div id="map_editor" class="report_right">
			<input type='hidden' id="incident_id" value='<?php echo $incident->id; ?>'>
			<input type='hidden' id="latitude" value="0">
			<input type='hidden' id="longitude" value="0">
			<div class="report_row">
				<div class="report-find-location">
					<?php 
						echo html::anchor('reports/view/'.$incident->id, "Finalizar Mapa",
							array('id'=>'finish_edition', 'class'=>'btn_submit_location'));
					?>
					<h3>
					<?php 
						echo $incident->incident_title;
						if ($incident->is_owner($user))
						{
							echo html::anchor("reports/edit/".$incident->id, "editar", array('class'=>'btn_editar'));
						}
					?>
					</h3>
					<div class="toolbox">
						<ul id="controlToggle"> 
							<li>
								<input style="display:none;" type="radio" name="type" value="none" 
								    id="noneToggle" data-image="arrow"
								    onclick="toggleControl('select');andControl('navigation');" checked="checked" />
								<label for="noneToggle">
									<img title="clique com o cursor sobre o ponto para editá-lo" id="img_arrow"
									    src="<?php echo url::base() ?>media/img/toolbar/arrow.png" />
								</label>
							</li>
							<li> 
								<input style="display:none;" type="radio" name="type" 
								    value="point" id="pointToggle" onclick="toggleControl('point');" data-image="location"  />
								<label for="pointToggle">
									<img title="criar novo ponto" for="pointToggle"
									    id="img_location" src="<?php echo url::site() ?>media/img/toolbar/location.png" />
								</label> 
							</li>
							<li>
								<a rel="layer" href="<?php echo url::site().'index.php/kml/index/'.$incident->id; ?>">
									<img src="<?php echo url::base() ?>/media/img/toolbar/upload.png"
									    data-image="upload" title="importar camadas (.KML, .KMZ)"/>
								</a>
							</li>
							<li>
								<a href="<?php echo url::site().'index.php/locations/export/'.$incident->id; ?>" class="save-rep-btn">
								<img src="<?php echo url::site().'/media/img/toolbar/download.png'; ?>" 
								    data-image="download" title="exportar dados (.CSV)" /></a>
							</li>
						</ul>
						<div style="clear:both;" id="find_text"><?php echo Kohana::lang('ui_main.pinpoint_location'); ?>.</div>						
							<div id="location-search">
								<?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext"'); ?>
								<input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find" />
								<span id="find_loading" class="report-find-loading"></span>
							</div>
					</div>	
				</div>

				<div id="user_map" class="report_map">

					<?php if($incident->incident_kml->count()): ?>
					<!-- incident layers -->
					<div class="layers-overlay" style="display:none;">
						<div class="map-layers">
							<ul class="layers-listing">
						 	<?php foreach ($incident->incident_kml as $kml): ?>
						 	<?php if ($kml->layer->loaded): ?>
						 		<li>
						 			<a href="#" data-layer-id="<?php echo $kml->layer_id; ?>" data-layer-name="<?php echo $kml->layer->layer_name; ?>">
							 			<span class="layer-color" style="background-color: #<?php echo $kml->layer->layer_color; ?>"></span>
							 			<span class="user-layer-name"><?php echo $kml->layer->layer_name; ?></span>
						 			</a>
						 		</li>
						 	<?php endif; ?>
						 	<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<!-- /incident layers -->
					<?php endif; ?>

				</div>
			</div>
			<div id="report_points"></div>				
		</div>
	</div>
</div>