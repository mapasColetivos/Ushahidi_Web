<div id="layer_edit">
	<h2>Editar Legenda</h2>
	<?php print form::open('layers/update/'.$id, array('enctype' => 'multipart/form-data', 'id' => 'layerForm', 'name' => 'mapsForm', 'class' => 'gen_forms', 'action' => "submit")); ?>
					<div class="report_row">
						<!-- <?php echo Kohana::lang('ui_main.layer_name'); ?> -->
						<?php print form::input('layer_name', $form['layer_name'], ' class="text"'); ?>
						<h4><?php echo Kohana::lang('ui_main.layer_color'); ?><br /></h4>
						<?php print form::hidden('layer_color', $form['layer_color'], 'id="layer_color"'); ?>
						<div id="colorSelector"><div id="colorBG" style="background-color:#<?php echo$form['layer_color'] ?>;"></div><img id="colorIMG" src='<?php echo url::base() ?>media/colorpicker/images/select.png'></img></div> 	
					</div>
					<div class="location_buttons">
						<a href="#" class="btn_cancel_layer" ><?php echo Kohana::lang('ui_main.reports_btn_cancel'); ?>
						</a>
						<input type='submit' class="btn_submit_location_layer" value='<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>'/>
						<span id="layer_loading"></span>
					</div> 
				</div>
	
	<?php print form::close(); ?>
</div>
<script type="text/javascript">
	$('#colorSelector').ColorPicker({
		color: '#0000ff',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector div').css('backgroundColor', '#' + hex);
			$('[name="layer_color"]').val(hex);
		}
	});
	$('.btn_cancel_layer').click(function () {
		$.facebox.close();
	});	
	$('.btn_submit_location_layer').click(function () {
	  $('#layer_loading').html('<img src="<?php echo url::base() . "index.php/media/img/loading_g.gif"; ?>">');  
		id = <?php echo $id ?>;
		name = $("#layer_name").val();
		color = $("[name$='layer_color']").val();
		select_id = $("#layer_id").val();
			
		$.get("<?php echo url::base()."layers/update/"?>"+id+"/"+name+"/"+color, function(data){
		  $(".layer_description").remove();
		  $("#location_table_of_contents").html(data);
		  $("#layer"+select_id).addClass("selected");
  		update_map_colors(id,color);
  		$.facebox.close();		  
		});
		return false;
	});		
</script>
