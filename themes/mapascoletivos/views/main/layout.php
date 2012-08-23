<!-- main body -->
<div id="news_place" ></div>
<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox withright">

		<div>
            <h9><?php echo $site_message; ?></h9>
		</div>
	
		<!-- content column -->
		<div id="content" class="clearingfix">
			<!-- / filters -->
			<div id="filters_bar" class="margin_top">
				<div id="filtro"  style="display:none">
					<?php echo Kohana::lang('ui_main.filters'); ?>
			  </div>
			<div id="actions" style="display:none">
				<a data-filter="1" class="filters" id="media_4" href="#">
					<img src="<?php echo url::base(); ?>/media/img/filtro-1-off.png" alt="<?php echo Kohana::lang('ui_main.news'); ?>" style="vertical-align:middle" />
				</a>
				
				<a data-filter="2" class="filters" id="media_1" href="#">
					<img src="<?php echo url::base(); ?>/media/img/filtro-2-off.png" alt="<?php echo Kohana::lang('ui_main.pictures'); ?>"
						style="vertical-align:middle" />
				</a>
				<a data-filter="3" class="filters" id="media_2" href="#">
					<img src="<?php echo url::base(); ?>/media/img/filtro-3-off.png" alt="<?php echo Kohana::lang('ui_main.video'); ?>"
						style="vertical-align:middle" />
				</a>
					
				<a data-filter="4" class="filters" id="media_5" href="#">
					<img id="all" src="<?php echo url::base(); ?>/media/img/filtro-4-off.png" alt="todos" style="vertical-align:middle" />
				</a>
			</div>
			
			<div id='box_search_btn'>
				<div id="menu_filters">
					<?php echo Kohana::lang('ui_main.category_filter'); ?>
					<a href="javascript:switchImage('#image_arrow', 'category_switch')" id="category_switch_link">
						<?php echo html::image('media/img/arrow_down_gray.png', array('id'=> 'image_arrow', 'data-current-src'=>'down')); ?>
					</a>
				</div>
				<div class="submit submit_geocode"></div>
				<div class="search">
					<p>
						<input type="text" id="location_find_main" name="location_find" value="" title="buscar local" class="findtext">
						<span id="find_loading" class="report-find-loading"></span>								
					</p>
				</div>				    
			</div>
		</div>
		
		<div>
			<!-- right column -->
			<div id="category_column" class="clearingfix">
				<!-- category filters -->
				<ul id="category_switch" class="category-filters" style="display:none;">
					<li>
						<a class="active" id="cat_0" href="#">
							<span class="swatch">
								<img id="cat_x" src="<?php echo url::base(); ?>/media/img/cat_x.png" alt="x" style="vertical-align:middle" />
							</span>
							<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
						</a>
					</li>
          		<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = $category_info[0];
						$category_color = $category_info[1];
						$category_image = '';
						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						
						if ($category_info[2] != NULL AND file_exists(Kohana::config('upload.relative_directory').'/'.$category_info[2]))
						{
							$category_image = html::image(array(
							    'src'=>Kohana::config('upload.relative_directory').'/'.$category_info[2],
							    'style'=>'float:left;padding-right:5px;'
							));
							
							$color_css = '';
						}
						
						$li = '<li><a href="#" id="cat_%s"><span %s>%s</span><span class="category-title">%s</span></a>';
						echo sprintf($li, $category, $color_css, $category_image, $category_title);
						
						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
						if( sizeof($category_info[3]) != 0)
						{
							echo '<ul>';
							foreach ($category_info[3] as $child => $child_info)
							{
								$child_title = $child_info[0];
								$child_color = $child_info[1];
								$child_image = '';
								$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
								
								if($child_info[2] != NULL AND file_exists(Kohana::config('upload.relative_directory').'/'.$child_info[2]))
								{
									$child_image = html::image(array(
									    'src'=>Kohana::config('upload.relative_directory').'/'.$child_info[2],
									    'style'=>'float:left;padding-right:5px;'
									));
									
									$color_css = '';
								}

								echo '<li style="padding-left:20px;">'
								    . '<a href="#" id="cat_'. $child .'">'
								    . '<span '.$color_css.'>'.$child_image.'</span>'
								    . '<span class="category-title">'.$child_title.'</span>'
								    . '</a></li>';
							}
							echo '</ul>';
						}
						echo '</div></li>';
					}
				?>

          		<?php if ($layers): ?>
				<!-- Layers (KML/KMZ) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?></strong>
				</div>
				<?php
					foreach ($layers as $layer => $layer_info)
					{
          				$layer_name = $layer_info[0];
          				$layer_color = $layer_info[1];
          				$layer_url = $layer_info[2];
          				$layer_file = $layer_info[3];

						$layer_link = ( ! $layer_url)
						    ? url::base().Kohana::config('upload.relative_directory').'/'.$layer_file
						    : $layer_url;
						
						echo '<li><a href="#" id="layer_'. $layer .'"'
						    . 'onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;">'
						    . '<div class="swatch" style="background-color:#'.$layer_color.'"></div>'
						    . '<div>'.$layer_name.'</div></a></li>';
					}
				?>
				<!-- /Layers -->
				<?php endif; ?>
			</ul>
			
          	<br />

			<!-- additional content -->
			<?php if (Kohana::config('settings.allow_reports')): ?>
          	<?php endif; ?>

          	<!-- / additional content -->

          	<?php
          	// Action::main_sidebar - Add Items to the Entry Page Sidebar
          	Event::run('ushahidi_action.main_sidebar');
          	?>

          </div>
          <!-- / right column -->
  				<?php								
  				// Map and Timeline Blocks
  				echo $div_map;
  				//echo $div_timeline;
  				?>
  			</div>

			</div>
		</div>
		<!-- / content column -->

	</div>

<!-- / main body
</div>
<div id="black-separator">
</div> -->

<!-- left content block -->
<div>
  <!--
  <iframe id="news_iframe" frameborder="0" width="100%" height="700px" overflow-y="auto" src="http://mapascoletivos.com.br/noticias"></iframe>
  -->
</div>
