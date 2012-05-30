<h2>Editar Ponto</h2>
<?php 
	print form::open('locations/edit/'.$location->id."/".$incident_id, array(
		'enctype' => 'multipart/form-data',
		'id' => 'mapsForm',
		'name' => 'mapsForm',
		'class' => 'gen_forms',
		'action' => "oi"
	)); 
?>

<div class="report_row">
	<h4><?php echo Kohana::lang('ui_main.reports_location_name'); ?><br /></h4>
	<?php print form::input('location_name', $form['location_name'], ' class="text long"'); ?>
	<input type="hidden" name="location_lon" id="location_lon" value="<?php echo $location->longitude; ?>" />
	<input type="hidden" name="location_lat" id="location_lat" value="<?php echo $location->latitude; ?>" />
	<input type="hidden" id="location_id" value="<?php echo $location->id; ?>" />
	<input type="hidden" id="location_seq" />
	<h4><?php echo Kohana::lang('ui_main.reports_location_description'); ?></h4>
	<span class="box_edit_span">os primeiros 200 caracteres serão visualizados no balão de informações de cada ponto. Use ENTER para separar as linhas</span>

	<?php print form::textarea('location_description', $form['location_description'], ' rows="10" class="textarea long" ') ?>
	
	<!-- News Fields -->
	<div id="divNews" class="report_row">
		<h4>
			<?php echo Kohana::lang('ui_main.reports_news'); ?> 
			<span class="box_edit_span">link http://www.url.com </span>
		</h4>
		<?php if (empty($form['incident_news'])): ?>
		<?php $i = 1; ?>
		<div class="report_row">
			<?php print form::input('incident_news[]', '', ' class="text long2"'); ?>
			<a href="#" class="add" onClick="addFormField('divNews', 'incident_news', 'news_ids', 'text'); return false;">add</a>
		</div>
		<?php else: ?>
			<?php $i = 0; ?>
			<?php foreach ($form['incident_news'] as $value): ?>
				<div class="report_row" id="<?php echo $i; ?>">
					<?php print form::input('incident_news[]', $value, ' class="text long2"'); ?>
					<a href="#" class="add" onClick="addFormField('divNews', 'incident_news', 'news_id', 'text'); return false;">add</a>
				
					<?php if ($i != 0): ?>
						<a href="#" class="rem"	onClick="removeFormField('#incident_news_<?php echo $i; ?>'); return false;">remove</a>";
					<?php endif; ?>
				
				</div>
				<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<input type="hidden" name="news_id" value="<?php echo $i; ?>" id="news_id">";
	</div>

	<!-- Video Fields -->
	<div id="divVideo" class="report_row">
		<h4>
			<?php echo Kohana::lang('ui_main.reports_video'); ?> 
			<span class="box_edit_span">link para youtube</span>
		</h4>
		<?php if (empty($form['incident_video'])): ?>
		<?php $i = 1; ?>
		<div class="report_row">
			<?php print form::input('incident_video[]', '', ' class="text long2 youtube"'); ?>
			<a href="#" class="add" onClick="addFormField('divVideo', 'incident_video', 'video_id', 'text'); return false;">add</a>
		</div>
		<?php else: ?>
			<?php $i = 0; ?>
			<?php foreach ($form['incident_video'] as $value): ?>
				<div class="report_row" id="<?php echo $i; ?>">
					<?php echo print form::input('incident_video[]', $value, ' class="text long2 youtube"'); ?>
					<a href="#" class="add" onClick="addFormField('divVideo','incident_video','video_id','text'); return false;">add</a>
					<?php if ($i != 0): ?>
						<a href="#" class="rem" onClick="removeFormField('#incident_video_<?php echo $i; ?>'); return false;">remove</a>
					<?php endif; ?>
				</div>
				<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<input type="hidden" name="video_id" value="<?php echo $i; ?>" id="video_id" />
	</div>

	<!-- Photo Fields -->
	<div id="divPhoto" class="report_row">
		<h4>
			<?php echo Kohana::lang('ui_main.reports_photos'); ?> 
			<span class="box_edit_span">extensões permitidas: .jpg,.png,.gif || max 2MB</span>
		</h4>
		<?php if (empty($form['incident_photo']['name'][0])): ?>
		<?php $i = 1; ?>
		<div class="report_row">
			<?php print form::upload('incident_photo[]', '', ' class="file long2"'); ?>
			<a href="#" class="add" onClick="addFormField('divPhoto','incident_photo','photo_id','file'); return false;">add</a>
		</div>
		<?php else: ?>
			<?php $i = 0; ?>
			<?php foreach ($form['incident_photo']['name'] as $value): ?>
				<div class="report_row" id="<?php echo $i; ?>">
				<?php print form::upload('incident_photo[]', $value, ' class="file long2"'); ?>
				<a href="#" class="add" onClick="addFormField('divPhoto','incident_photo', 'photo_id', 'file'); return false;">add</a>
				<?php if ($i != 0): ?>
					<a href="#" class="rem"	onClick="removeFormField('#incident_photo_<?php echo $i; ?>'); return false;">remove</a>
				<?php endif; ?>
				</div>
				<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<input type="hidden" name="photo_id" value="<?php echo $i; ?>" id="photo_id" />
		<br/>
	</div>				
				
	<div id="location_table_of_contents">
		<h4 id="legend">
			<?php echo Kohana::lang('ui_main.location_layers'); ?> 
			<a id="new_layer" >  [adicionar legenda] </a>  
		</h4>
		span class="box_edit_span"> agrupe seus pontos por tipo de informação </span>
		<div class="pad"></div>
		<?php
			$selected = FALSE;
			foreach ($layers as $layer):
				$class = "layer_description";
				if ($layer->id == $location->layer_id)
				{
					$selected = TRUE;
					$class = $class." selected";
				}
		?>
			<div class="<?php echo $class ?>" id="layer<?php echo $layer->id ?>" data-id=<?php echo $layer->id ?> >
				<span class="layer_color" style="background:#<?php echo $layer->layer_color ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<a class="select_layer" ><?php echo $layer->layer_name; ?></a> 
				<a class="edit_layer" rel="layer" href='<?php echo url::base() ?>index.php/layers/edit/<?php echo $layer->id ?>'> 
					[editar legenda]
				</a>
				<?php if ($layer->owner_id == $user->id): ?>
					<a class="delete_layer">[apagar]</a></br>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>	
	
	<input type="hidden" id="layer_id" name="layer_id" value="<?php echo $location->layer_id; ?>" />
	<div class="location_buttons">
		<?php if ($location->owner_id): ?>
			<a href="#" class="btn_cancel" ><?php echo Kohana::lang('ui_main.reports_btn_cancel'); ?></a>
		<?php endif; ?>
		<?php if ($location->owner_id == $user->id): ?>
			<a href="#" class="btn_remove" ><?php echo Kohana::lang('ui_main.reports_btn_remove'); ?></a>
		<?php endif; ?>
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
	  		$("#location_description").after("<span class='invalid_form'>A descrição é obrigatória</span>");
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
