<div id="content">
	<div class="content-bg">
		<!-- start report form block -->
		
		<?php print form::open(url::base()."index.php/reports/submit/".$id, array('enctype' => 'multipart/form-data', 'id' => 'reportForm', 'name' => 'reportForm', 'class' => 'gen_forms')); ?>
		<div class="big-block">
			<h1 style="margin-top:36px;"><?php echo Kohana::lang('ui_main.reports_submit_new'); ?></h1>
			<div class="row">
				<input type="hidden" name="form_id" id="form_id" value="<?php echo $id?>">
			</div>
			<div class="report_left">
				<div id="space">
				</div>

				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_title'); ?></h4>
					<?php print form::input('incident_title', $form['incident_title'], ' class="text long"'); ?>
				</div>
				
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_description'); ?></h4>
					<?php print form::textarea('incident_description', $form['incident_description'], ' rows="10" class="textarea long" ') ?>
   <!-- text::limit_chars($incident->incident_title, 40, '...', True);-->

				</div>

				<div class="report_row" id="datetime_default" style="display:none">
					<h4><a href="#" id="date_toggle" class="show-more"><?php echo Kohana::lang('ui_main.modify_date'); ?></a><?php echo Kohana::lang('ui_main.date_time'); ?>: 
						<?php echo Kohana::lang('ui_main.today_at')." "."<span id='current_time'>".$form['incident_hour']
							.":".$form['incident_minute']." ".$form['incident_ampm']."</span>"; ?></h4>
				</div>
				
				<div class="report_row hide" id="datetime_edit">
					<div class="date-box">
						<h4><?php echo Kohana::lang('ui_main.reports_date'); ?></h4>
						<?php print form::input('incident_date', $form['incident_date'], ' class="text short"'); ?>								
						<script type="text/javascript">
							$().ready(function() {
								$("#incident_date").datepicker({ 
									showOn: "both", 
									buttonImage: "<?php echo url::base() ?>media/img/icon-calendar.gif", 
									buttonImageOnly: true 
								});
							});
						</script>
					</div>
					<div class="time">
						<h4><?php echo Kohana::lang('ui_main.reports_time'); ?></h4>
						<?php
							for ($i=1; $i <= 12 ; $i++) { 
								$hour_array[sprintf("%02d", $i)] = sprintf("%02d", $i);	 // Add Leading Zero
							}
							for ($j=0; $j <= 59 ; $j++) { 
								$minute_array[sprintf("%02d", $j)] = sprintf("%02d", $j);	// Add Leading Zero
							}
							$ampm_array = array('pm'=>'pm','am'=>'am');
							print form::dropdown('incident_hour',$hour_array,$form['incident_hour']);
							print '<span class="dots">:</span>';
							print form::dropdown('incident_minute',$minute_array,$form['incident_minute']);
							print '<span class="dots">:</span>';
							print form::dropdown('incident_ampm',$ampm_array,$form['incident_ampm']);
						?>
					</div>
					<div style="clear:both; display:block;" id="incident_date_time"></div>
				</div>
				<script type="text/javascript">
					var now = new Date();
					var h=now.getHours();
					var m=now.getMinutes();
					var ampm="am";
					if (h>=12) ampm="pm"; 
					if (h>12) h-=12;
					var hs=(h<10)?("0"+h):h;
					var ms=(m<10)?("0"+m):m;
					$("#current_time").text(hs+":"+ms+" "+ampm);
					$("#incident_hour option[value='"+hs+"']").attr("selected","true");
					$("#incident_minute option[value='"+ms+"']").attr("selected","true");
					$("#incident_ampm option[value='"+ampm+"']").attr("selected","true");
				</script>
				<div class="report_row">
					<h4><?php echo Kohana::lang('ui_main.reports_categories'); ?></h4>
					<div class="report_category" id="categories">
						<?php
						$selected_categories = array();
                if (!empty($form['incident_category']) && is_array($form['incident_category'])) {
							$selected_categories = $form['incident_category'];
						}
						$columns = 2;
						echo category::tree($categories, $selected_categories, 'incident_category', $columns);
						?>
					</div>
				</div>
				<script type="text/javascript">
					$(".check-box").each(function(){
						var name = $(this).attr('name');
					    var value = $(this).attr('value');
						var html = '<input type="radio" name="'+name+'" value="'+value+'" class="check-box" />';
						$(this).after(html).remove();
					});
				</script>
				
			<div class="report_row">
					<?php echo Kohana::lang('ui_main.privacy_map');?>
					<br/><br/>
					<?php print form::radio('incident_privacy', false,$form['incident_privacy'] == false); ?> <?php echo Kohana::lang('ui_main.public_map');?>
					<br/><br/>
					<?php print form::radio('incident_privacy', true,$form['incident_privacy'] == true); ?> <?php echo Kohana::lang('ui_main.private_map'); ?>
				</div>	

				<?php
				// Action::report_form - Runs right after the report categories
				Event::run('ushahidi_action.report_form');
				?>
				<div id="custom_forms">
					
                                <?php
                                
					foreach ($disp_custom_fields as $field_id => $field_property)
					{
						echo "<div class=\"report_row\">";
						echo "<h4>" . $field_property['field_name'] . "</h4>";
						if ($field_property['field_type'] == 1)
						{ // Text Field
							// Is this a date field?
							if ($field_property['field_isdate'] == 1)
							{
								echo form::input('custom_field['.$field_id.']', $form['custom_field'][$field_id],
								' id="custom_field_'.$field_id.'" class="text"');
								echo "<script type=\"text/javascript\">
									$(document).ready(function() {
									$(\"#custom_field_".$field_id."\").datepicker({ 
									showOn: \"both\", 
									buttonImage: \"" . url::base() . "media/img/icon-calendar.gif\", 
									buttonImageOnly: true 
									});
									});
								</script>";
							}
							else
							{
								echo form::input('custom_field['.$field_id.']', $form['custom_field'][$field_id],
								' id="custom_field_'.$field_id.'" class="text custom_text"');
							}
						}
						elseif ($field_property['field_type'] == 2)
						{ // TextArea Field
							echo form::textarea('custom_field['.$field_id.']', $form['custom_field'][$field_id], ' class="custom_text" rows="3"');
						}
						echo "</div>";
					}
					?>
				</div>
								
				<div class="report_row">
					<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" /> 
				</div>
			</div>	
				<div class="report_right r-column">
					<h4><?php echo Kohana::lang('settings.configure_map');?></h4>
				
					<div style="width: 279px; float: left; margin-top: 10px;">
						<span class="bold_span"><?php echo Kohana::lang('settings.default_zoom_level');?></span>
						<div class="slider_container">
							<?php print form::dropdown('default_zoom',$default_zoom_array,$form['default_zoom']); ?>
						</div>
					</div>
					<div style="width: 279px; height: 90px; float: left; margin-top: 10px;">
						<div class="location-info">
							<table>
								<tr>
									<td><?php echo Kohana::lang('ui_main.latitude');?>:</td>
									<td><?php print form::input('default_lat', $form['default_lat'], ' readonly="readonly" class="text"'); ?></td>	
								</tr>
								<tr>
									<td><?php echo Kohana::lang('ui_main.longitude');?>:</td>
									<td><?php print form::input('default_lon', $form['default_lon'], ' readonly="readonly" class="text"'); ?></td>	
								</tr>
							</table>
						</div>
					</div>					
					<div style="clear:both;"></div>
					<h4><?php echo Kohana::lang('ui_main.preview');?></h4>
					<p class="bold_desc"><?php echo Kohana::lang('settings.set_location');?>.</p>
				
					<div id="map_holder">
						<div id="map" class="mapstraction"></div>    
					</div>
					<div style="margin-top:25px" id="map_loaded"></div>
				</div>
				</div>
	</div>
</div>