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
					<a href="#" id="category_switch_link">
						<?php echo html::image('media/img/arrow_down_gray.png'); ?>
					</a>
				</div>
				<div class="submit submit_geocode"></div>
				<div class="search">
					<p>
						<input type="text" id="location_find_main" name="location_find"
						    value="" title="buscar local" class="findtext" placeholder="digitar endereÃ§o, SÃ£o Paulo, SP">
						<span id="find_loading" class="report-find-loading"></span>								
					</p>
				</div>				    
			</div>
		</div>
		
		<div>
			<!-- right column -->
			<div id="category_column" class="clearingfix" style="display:none;">
				<!-- category filters -->
				<ul id="category_switch" class="category-filters">
					<li>
						<a class="active" id="cat_0" href="#" data-category-id="0">
							<span class="swatch">
								<img id="cat_x" src="<?php echo url::base(); ?>/media/img/cat_x.png" alt="x" style="vertical-align:middle" />
							</span>
							<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
						</a>
					</li>
          		<?php
					foreach ($categories as $category)
					{
						$category_image = '';
						$color_css = 'class="swatch" style="background-color:#'.$category->category_color.'"';
						
						// Check if the category image thumb exists
						if
						(
							$category->category_image_thumb != NULL AND
							file_exists(Kohana::config('upload.relative_directory').'/'.$category->category_image_thumb)
						)
						{
							$category_image = html::image(array(
							    'src'=>Kohana::config('upload.relative_directory').'/'.$category->category_image_thumb,
							    'style'=>'float:left;padding-right:5px;'
							));
							
							$color_css = '';
						}
						
						$li = '<li>'
						    . '<a href="#" id="cat_%s" data-category-id="'.$category->id.'">'
						    . '<span %s>%s</span><span class="category-title">%s</span>'
						    . '</a>'
						    . '</li>';
						echo sprintf($li, $category->id, $color_css, $category_image, $category->category_title);						
					}
				?>
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

<!-- / main body -->

<!-- left content block -->
<div>
  <iframe id="news_iframe" frameborder="0" width="100%" height="700px" overflow-y="auto" src="http://mapascoletivos.com.br/noticias"></iframe>
</div>
