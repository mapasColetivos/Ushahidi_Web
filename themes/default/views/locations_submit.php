	<div class="content-bg">
		<div class="big-block">			
			<div id="map_editor" class="report_right">
				<input type='hidden' id="incident_id" value='<?php echo $incident->id; ?>'>
				<input type='hidden' id="latitude" value=0>
				<input type='hidden' id="longitude" value=0>
				<div class="report_row">
					<div class="report-find-location">
						<a id="finish_edition" href="<?php echo url::base() ?>index.php/reports/view/<?php echo $incident->id?>" class="btn_submit_location" >Finalizar Mapa</a>
						<h3><?php echo $incident->incident_title ?>
							<?php if($incident->id and ($incident->owner_id == $user->id)) { ?>
								 <a class="btn_editar" href="<?php echo url::base() ?>index.php/reports/edit/<?php echo $incident->id?>">
								 	editar
								 </a>
							<? } ?>
						</h3>
						<div class="toolbox">
				            <ul id="controlToggle"> 
				                <li>
				                    <input style="display:none;" type="radio" name="type" value="none" id="noneToggle" data-image="arrow"           onclick="toggleControl('select');andControl('navigation');" checked="checked" /> 
				                    <label for="noneToggle"><img title="posicione o cursor sobre o ponto para editá-lo" id="img_arrow" src="<?php echo url::base() ?>media/img/toolbar/arrow.png" /></label> 
				                </li>			                 
				                <li> 
				                    <input style="display:none;" type="radio" name="type" value="point" id="pointToggle" onclick="toggleControl('point');" data-image="location"  /> 
				                    <label for="pointToggle"><img title="criar novo ponto" for="pointToggle" id="img_location" src="<?php echo url::base() ?>media/img/toolbar/location.png" /></label> 
				                </li>
				                <li>
									<a rel="layer" href="<?php echo url::base() ?>index.php/kml/index/<?php echo $incident->id ?>"><img src="<?php echo url::base() ?>/media/img/toolbar/upload.png" data-image="upload" title="importar camadas (.KML)"/></a>
								</li>					                			     		
				                <li>
				                	<a href="<?php echo url::base() ?>index.php/locations/export/<?php echo $incident->id?>" class="save-rep-btn"><img src="<?php echo url::base() ?>/media/img/toolbar/download.png" data-image="download" title="exportar dados (.CSV)" /></a>
				                </li>
							</ul>
							<div style="clear:both;" id="find_text"><?php echo Kohana::lang('ui_main.pinpoint_location'); ?>.</div>						
							<div id="location-search">
								<?php print form::input('location_find', '', ' title="'.Kohana::lang('ui_main.location_example').'" class="findtext"'); ?>
								<input type="button" name="button" id="button" value="<?php echo Kohana::lang('ui_main.find_location'); ?>" class="btn_find" />
								<span id="find_loading" class="report-find-loading"></span>								
								<?php print form::close(); ?>
							</div>
						</div>	
					</div>

					<div id="divMap" class="report_map">
							<div id="edit_box">
							<div id="table_of_contents" style="display:none;">
								<h2><?php echo Kohana::lang('ui_main.location_layers'); ?></h2>
							<?php
								$selected = false; 
								foreach ($layers as $layer)
      							{
									$class = "layer_description";
      								if (!$selected){
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
								<?php foreach($incident->layers() as $kml) {
								  echo "<li>";
								  echo "<img class='swatch' src='".url::base()."media/img/kml.png'/>";
								  echo "<span id='layer_kml".$kml->id."' class='category-title'>";
									echo $kml->layer_name;
									#Move this if to inside a method
  									if (ORM::factory("incident_kml")->where("incident_id",$incident->id)->where("owner_id",$user->id)->where("kml_id",$kml->id)->find()->id > 0) {?>
                      <a class="layer_remove" href="<?php echo url::base(); ?>/locations/kml_delete/<?php echo $kml->id ?>/<?php echo $incident->id ?>">X</a>
  								<?php 
								    }
									echo "</span>";								  
								  echo "</li>";
                  }?>
              </ul>    
							</div>	
							<div id="location_box" style="display:none">
							</div>
						</div>
					</div>
				</div>
		<div id="report_points"></div>				
	</div>
</div>