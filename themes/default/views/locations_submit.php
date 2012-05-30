<div class="content-bg">
	<div class="big-block">			
		<div id="map_editor" class="report_right">
			<input type='hidden' id="incident_id" value='<?php echo $incident->id; ?>'>
			<input type='hidden' id="latitude" value=0>
			<input type='hidden' id="longitude" value=0>
			<div class="report_row">
				<div class="report-find-location">
					<a id="finish_edition" href="<?php echo url::site().'index.php/reports/view/'.$incident->id; ?>" class="btn_submit_location" >Finalizar Mapa</a>
					<?php if ($umessage): ?>
						<?php echo $umessage; ?>
						<script type='text/javascript'>alert('".<?php echo $umessage; ?>. "');</script>"
					<?php endif; ?>
					
					<h3>
						<?php echo $incident->incident_title; ?>
						<?php if ($incident->id AND ( ($incident->owner_id == $user->id) OR ($user->id == 1)) ): ?>
							<a class="btn_editar" href="<?php echo url::site().'index.php/reports/edit/'.$incident->id ;?>">editar</a>
						<?php endif; ?>
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

					<div id="divMap" class="report_map">
						<div id="edit_box">
							<div id="table_of_contents" style="display:none;">
								<h2><?php echo Kohana::lang('ui_main.location_layers'); ?></h2>
								<?php
									$selected = FALSE; 
									foreach ($layers as $layer)
	      							{
										$class = "layer_description";
	      								if  ( ! $selected)
										{
											$selected = true;
											$class = $class." selected";
										}
	      						?>
									<div class="<?php echo $class ?> layer<?php echo $layer->id ?>" data-id=<?php echo $layer->id ?> >
										<span class="layer_color" style="background:#<?php echo $layer->layer_color ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<a class="select_layer" ><?php echo $layer->layer_name; ?></a></br> 
									</div>
								<?php } ?>
							</div>
							
							<div id="kmls" class="edition">
								<ul>
								<?php foreach($incident->layers() as $kml): ?>
									<li>
										<img class="swatch" src="<?php echo url::site()."media/img/kml.png"; ?> />
											<span id="layer_kml<?php echo $kml->id; ?>" class="category-title"">
										<?php echo $kml->layer_name; ?>
									
										<?php
											// KML entries entries for the current incident
		  									$incident_kml_id = ORM::factory("incident_kml")
											    ->where("incident_id", $incident->id)
											    ->where("owner_id", $user->id)
											    ->where("kml_id", $kml->id)
											    ->find()
											    ->id;
										?>
										<?php if ($incident_kml_id > 0): ?>
											<a class="layer_remove" href="<?php echo url::site()."/locations/kml_delete/".$kml->id."/".$incident->id; ?>">X</a>
										<?php endif; ?>
										</span>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
							
							<div id="location_box" style="display:none"></div>
						</div>
					</div>
				</div>
			<div id="report_points"></div>				
		</div>
</div>