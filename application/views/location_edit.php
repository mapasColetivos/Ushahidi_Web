<h2>Editar Ponto</h2>
<?php print form::open('locations/edit/'.$location->id."/".$incident_id, array('enctype' => 'multipart/form-data', 'id' => 'mapsForm', 'name' => 'mapsForm', 'class' => 'gen_forms', 'action' => "oi")); ?>

				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_location_name'); ?><br /></h4>
					<?php print form::input('location_name', $form['location_name'], ' class="text long"'); ?>
					<input type="hidden" name="location_lon" id="location_lon" value="<?php echo $location->longitude; ?>"></input>
					<input type="hidden" name="location_lat" id="location_lat" value="<?php echo $location->latitude; ?>"></input>					
				<input type="hidden" id="location_id" value="<?php echo $location->id; ?>"></input>
				<input type="hidden" id="location_seq"></input>
					<h4><?php echo Kohana::lang('ui_main.reports_location_description'); ?></h4><span class="box_edit_span">os primeiros 200 caracteres serão visualizados no balão de informações de cada ponto. Use ENTER para separar as linhas</span>
					<?php print form::textarea('location_description', $form['location_description'], ' rows="10" class="textarea long" ') ?>

				<!-- News Fields -->
				<div id="divNews" class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_news'); ?> <span class="box_edit_span">link http:// </span></h4>
					<?php
						$this_div = "divNews";
						$this_field = "incident_news";
						$this_startid = "news_id";
						$this_field_type = "text";
						if (empty($form[$this_field]))
						{
							$i = 1;
							print "<div class=\"report_row\">";
							print form::input($this_field . '[]', '', ' class="text long2"');
							print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
							print "</div>";
						}
						else
						{
							$i = 0;
							foreach ($form[$this_field] as $value) {
							print "<div class=\"report_row\" id=\"$i\">\n";

							print form::input($this_field . '[]', $value, ' class="text long2"');
							print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
							if ($i != 0)
							{
								print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
							}
							print "</div>\n";
							$i++;
						}
					}
					print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
				?>
				</div>


				<!-- Video Fields -->
				<div id="divVideo" class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_video'); ?> <span class="box_edit_span">link para youtube</span></h4>
					<?php
						$this_div = "divVideo";
						$this_field = "incident_video";
						$this_startid = "video_id";
						$this_field_type = "text";

						if (empty($form[$this_field]))
						{
							$i = 1;
							print "<div class=\"report_row\">";
							print form::input($this_field . '[]', '', ' class="text long2 youtube"');
							print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
							print "</div>";
						}
						else
						{
							$i = 0;
							foreach ($form[$this_field] as $value) {
								print "<div class=\"report_row\" id=\"$i\">\n";

								print form::input($this_field . '[]', $value, ' class="text long2 youtube"');
								print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
								if ($i != 0)
								{
									print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
								}
								print "</div>\n";
								$i++;
							}
						}
						print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
					?>
				</div>

				<!-- Photo Fields -->
				<div id="divPhoto" class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_photos'); ?> <span class="box_edit_span">extensões permitidas: jpg, png, gif, tiff</span></h4>
					<?php
						$this_div = "divPhoto";
						$this_field = "incident_photo";
						$this_startid = "photo_id";
						$this_field_type = "file";

						if (empty($form[$this_field]['name'][0]))
						{
							$i = 1;
							print "<div class=\"report_row\">";
							print form::upload($this_field . '[]', '', ' class="file long2"');
							print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
							print "</div>";
						}
						else
						{
							$i = 0;
							foreach ($form[$this_field]['name'] as $value) 
							{
								print "<div class=\"report_row\" id=\"$i\">\n";

								// print "\"<strong>" . $value . "</strong>\"" . "<BR />";
								print form::upload($this_field . '[]', $value, ' class="file long2"');
								print "<a href=\"#\" class=\"add\" onClick=\"addFormField('$this_div','$this_field','$this_startid','$this_field_type'); return false;\">add</a>";
								if ($i != 0)
								{
									print "<a href=\"#\" class=\"rem\"	onClick='removeFormField(\"#" . $this_field . "_" . $i . "\"); return false;'>remove</a>";
								}
								print "</div>\n";
								$i++;
							}
						}
						print "<input type=\"hidden\" name=\"$this_startid\" value=\"$i\" id=\"$this_startid\">";
					?>
				<br/>
				</div>				
				
				
				<div id="location_table_of_contents">
				<h4 id="legend"><?php echo Kohana::lang('ui_main.location_layers'); ?><a id="new_layer" >(<?php echo Kohana::lang('ui_main.add_location_layer'); ?>)</a>
			  </h4>
				<span class="box_edit_span">agrupe seus pontos por tipo de informação</span>
				<div class="pad"></div>
				<?php
					$selected = false; 
					foreach ($layers as $layer)
						{
							$class = "layer_description";
							if ($layer->id == $location->layer_id){
							$selected = true;
							$class = $class." selected";
							}
					?>
					<div class="<?php echo $class ?>" id="layer<?php echo $layer->id ?>" data-id=<?php echo $layer->id ?> >
						<span class="layer_color" style="background:#<?php echo $layer->layer_color ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<a class="select_layer" ><?php echo $layer->layer_name; ?></a> <a class="edit_layer" rel="layer" href='<?php echo url::base() ?>index.php/layers/edit/<?php echo $layer->id ?>'>(editar)</a> <?php if ($layer->owner_id == $user->id){?><a class="delete_layer">(X)</a></br> <? } ?>
				</div>
				<?php } ?>
				</div>	
			<input type="hidden" id="layer_id" name="layer_id" value="<?php echo $location->layer_id; ?>"/></input>
				<div class="location_buttons">
					<a href="#" class="btn_cancel" ><?php echo Kohana::lang('ui_main.reports_btn_cancel'); ?>
					</a>
					<?php if ($location->owner_id == $user->id) { ?>
						<a href="#" class="btn_remove" ><?php echo Kohana::lang('ui_main.reports_btn_remove'); ?> </a>
					<? } ?>
					<input type='submit' class="btn_submit_location" value='<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>'/>
					<span id="save_loading" class="report-find-loading"></span>
				</div>
			</div>
<?php print form::close(); ?>

<script type="text/javascript">
    function validate_form_submission(){
		$('#save_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');		
	  	$(".invalid_form").hide();
		$("#location_name").css("background-color","#ffffff");  	
		$("#location_description").css("background-color","#ffffff");	
	  	location_name = $("#location_name").val();
	  	location_description = $("#location_description").val();
	  	youtube_url = 
	  	valid = true;
	  	if (location_name == ""){
	  		$("#location_name").css("background-color","#FFE0DD");
	  		$("#location_name").after("<span class='invalid_form'>O nome do local é obrigatório</span>");
	  		valid = false;
	  	}
	  	if (location_description == ""){
	  		$("#location_description").css("background-color","#FFE0DD");
	  		$("#location_description").after("<span class='invalid_form'>A Descrição é obrigatória</span>");
	  		valid = false;
	  	}
	  	
	  	extensions = {
	  		".jpg": 1,
	  		".jpeg": 1,
	  		".png": 1,
	  	}
	  	
		$.map($('.youtube'),function(input){
	  		value = $(input).val();
	  		if (value != null && value != ""){
				if (!value.match(/http:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/)){
			  		$(input).css("background-color","#FFE0DD");				
		  			$(input).parent().before("<table><tr><td><span class='invalid_form'> Essa não é uma url de youtube válida.</span></td></tr></table>");
			  		valid = false;
				}
			}
	  	});

	  	
	  	$.map($(".file"),function(input){
	  		value = $(input).val();
	  		if (value != null && value != ""){
				extension = value.toLowerCase().match(/\.[^\.]+$/);
				if (!extensions[extension]){
			  		$(input).css("background-color","#FFE0DD");				
		  			$(input).parent().before("<table><tr><td><span class='invalid_form'>Formato de arquivo '"+extension+"' não suportado.</span></td></tr></table>");
			  		valid = false;
				}
			}
	  	});
	  	
		if (!valid){
			$('#save_loading').html('');		
		}
	  	return valid;
    }
  $("#mapsForm").submit(validate_form_submission);
</script>
