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
								<a href="#" data-image="arrow" class="default toggle">
								<?php
									echo html::image("media/img/toolbar/arrow.png", "clique com o cursor sobre o ponto para editá-lo",
									    array('id'=>'img_arrow'));
								?>
								</a>
							</li>
							<li>
								<a href="#" data-image="location" data-control="point" class="toggle">
								<?php
									echo html::image("media/img/toolbar/location.png", "criar novo ponto",
										array('for'=>"pointToggle", 'id'=>'img_location'));
								?>
								</a>
							</li>
							<li>
							<?php
								echo html::anchor("#",
									// Image
									html::image("media/img/toolbar/upload.png", "importar camadas (.KML, .KMZ)",
										array('data-image'=>'upload')),
									// Anchor attributes
									array('title'=>'layer', 'class' => 'kml-layer'));
							?>
							</li>
							<li>
								<a href="<?php echo url::site('locations/export/'.$incident->id); ?>" class="save-rep-btn">
								<img src="<?php echo url::site('media/img/toolbar/download.png'); ?>"
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

					<?php if ($incident->incident_kml->count()): ?>
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


<?php
	// Include the backbone JS scripts
	$scripts = array('media/js/underscore-min', 'media/js/backbone-min');
	echo html::script($scripts, TRUE);
?>

<script type="text/template" id="add-location-template">
	<div class="dialog-close"><a href="#" title="<?php echo Kohana::lang('ui_main.close'); ?>">X</a></div>

	<div class="report_map">
		<div class="green-box" style="display:none;">
			<h3>A localização foi salvo com sucesso.</h3>
		</div>
		<h2>Editar Ponto</h2>
		<?php
			echo form::open("locations/manage/".$incident->id, array(
			    'enctype' => 'multipart/form-data',
			    'target' => 'location_submit_target'
			));
		?>
		<input type="hidden" name="id" value="<%= id %>" />
		<input type="hidden" name="latitude" value="<%= latitude %>" />
		<input type="hidden" name="longitude" value="<%= longitude %>" />
		<input type="hidden" id="incident_legend_id" name="incident_legend_id" value="<%= incident_legend_id %>" />

		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.reports_location_name'); ?><br /></h4>
			<input type="text" name="location_name" value="<%= location_name %>" class="text long2">
		</div>
		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.reports_location_description'); ?></h4>
			<span class="box_edit_span">
				os primeiros 200 caracteres serão visualizados no balão de informações de cada ponto. Use ENTER para separar as linhas
			</span>
			<textarea name="location_description" rows="10" class="textarea long"><%= location_description %></textarea>
		</div>

		<div id="divLegends" class="report_row">
			<h4>Legendas <a id="add-legend" href="#">[adicionar legenda]</a></h4>
			<div class="create-legend" style="display:none;"></div>
			<ul class="legend-list"></ul>
		</div>

		<div id="divNews" class="report_row">
			<h4>
				<?php echo Kohana::lang('ui_main.reports_news'); ?>
				<span class="box_edit_span">link http://www.url.com</span>
			</h4>
		</div>
		<div id="divVideo" class="report_row">
			<h4>
				<?php echo Kohana::lang('ui_main.reports_video'); ?>
				<span class="box_edit_span">link para youtube</span>
			</h4>
		</div>

		<div id="divPhoto" class="report_row">
			<h4>
				<?php echo Kohana::lang('ui_main.reports_photos'); ?>
				<span class="box_edit_span">extensões permitidas: .jpg,.png,.gif || max 2MB</span>
			</h4>
		</div>

		<div style="clear: both;"></div>
		<div class="location_buttons">
			<a href="#" class="btn_cancel" ><?php echo Kohana::lang('ui_main.reports_btn_cancel'); ?></a>
			<input type='submit' class="btn_submit_location" value='<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>'/>
		</div>

		<div style="clear: both;"></div>
		<div id="save_progress_bar" style="display:none;" align="center">
			<?php echo html::image('media/img/loading_g.gif'); ?>
		</div>

		<?php echo form::close(); ?>
	</div>
	<iframe name="location_submit_target" id="location_submit_target" src="" style="width:0;height:0;border:none;"></iframe>
</script>

<script type="text/template" id="add-layer-dialog-template">
	<div class="dialog-close"><a href="#" title="<?php echo Kohana::lang('ui_main.close'); ?>">X</a></div>
	<div class="report_map">
		<h2><?php echo Kohana::lang('ui_main.layers'); ?></h2>

		<div class="report_row">
			<a href="#" class="create-layer"><?php echo Kohana::lang('ui_main.add_edit'); ?></a>
			<div class="create-layer" style="display: none;"></div>
		</div>

	</div>
</script>

<script type="text/template" id="add-layer-item-template">
	<div class="layer-info">
	<h4><%= layer_name %></h4>
	<span class="box_edit_span">
	<% if (layer_file !== '') { %>
		<?php echo Kohana::lang('ui_main.kml_kmz_file'); ?>: <%= layer_file %>
	<% } else if (layer_url !== '') { %>
		<?php echo Kohana::lang('ui_main.kml_url'); ?>: <%= layer_url %>
	<% } %>
	</span>
	</div>
	<div class="actions">
		<ul>
			<li><a href="#" class="add-layer">Adicionar ao Mapa</a></li>
			<li><a href="#" class="edit"><?php echo Kohana::lang('ui_main.edit'); ?></a></li>
			<li><a href="#" class="remove"><?php echo Kohana::lang('ui_main.delete'); ?></a></li>
		</ul>
	</div>
	<div style="clear: both;"></div>
</script>

<script type="text/template" id="add-input-field-template">
	<% if (input_type === "file") { %>
		<input type="file" name="<%= field_name %>" class="file long2"/>
	<% } else { %>
		<input type="<%= input_type %>" name="<%= field_name %>" value="<%= value %>" class="<%= input_type %> long2">
	<% } %>

	<a href="#" class="add">add</a>
	<% if (show_remove) { %>
		<a href="#" class="rem">remove</a>
	<% } %>
</script>

<script type="text/template" id="edit-layer-template">
	<?php echo form::open("reports/layers/".$incident->id, array(
	    'enctype' => 'multipart/form-data',
	    'target' => 'layer_submit_target')); ?>

		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.layer_name'); ?></h4>
			<input type="text" name="layer_name" value="<%= layer_name %>" class="text long2">
		</div>
		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.layer_color'); ?></h4>
			<input type="text" name="layer_color" id="layer_color" value="<%= layer_color %>" class="text short">
		</div>
		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.layer_url'); ?></h4>
			<input type="text", name="layer_url" value="<%= layer_url %>" class="text long2">
		</div>
		<div class="report_row">
			<h4><?php echo Kohana::lang('ui_main.kml_kmz_upload'); ?></h4>
			<input type="file" name="layer_file">
		</div>
		<div style="clear:both"></div>
		<div class="location_buttons">
			<input type='submit' class="btn_submit_location" value='<?php echo Kohana::lang('ui_main.save'); ?>'/>
		</div>
	<?php echo form::close(); ?>
	<iframe name="layer_submit_target" id="layer_submit_target" src="" style="width:0;height:0;border:none;"></iframe>
</script>

<script type="text/template" id="add-legend-template">
	<a href="#" class="legend">
		<span class="legend-color" style="background-color: #<%= legend_color %>;"></span>
		<span class="legend-title"><%= legend_name %></span>
	</a>
	<div class="legend-actions">
		<ul>
			<li><a href="#" class="edit"><?php echo Kohana::lang('ui_main.edit'); ?></a></li>
			<li><a href="#" class="remove"><?php echo Kohana::lang('ui_main.delete'); ?></a></li>
		</ul>
	</div>
</script>

<script type="text/template" id="edit-legend-template">
	<div class="report_row">
		<h4><?php echo Kohana::lang('ui_main.name'); ?></h4>
		<input type="text" name="legend_name" id="legend_name" value="<%= legend_name %>" class="text long"/>
	</div>
	<div class="report_row">
		<h4><?php echo Kohana::lang('ui_main.color'); ?></h4>
		<input type="text" name="legend_color" id="legend_color" value="<%= legend_color %>" class="text short" />
	</div>
	<div style="clear: both;"></div>
	<div class="report-row buttons">
		<a href="#" class="cancel"><?php echo Kohana::lang('ui_main.cancel'); ?></a>
		<a href="#" class="save"><?php echo Kohana::lang('ui_main.save'); ?></a>
	</div>
</script>

<?php echo $javascript; ?>
