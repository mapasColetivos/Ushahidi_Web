<!-- main body -->

<title>iframe</title>

<div id="news_place" ></div>
<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox withright">

	<?php if($site_message = "Mutirão de Dados Compartilhados") { ?>
		<!--<h3><div class="green-box"></h3>-->
            <h9><?php echo $site_message; ?></h9>
        
		</div>
	<?php } ?>
	
		<!-- content column -->
		<div id="content" class="clearingfix">
				<!-- / filters -->
				<div id="filters_bar" class="margin_top">
					<div id="filtro"  style="display:none">
						<?php echo Kohana::lang('ui_main.filters'); ?>
				  </div>
					
				  <div id="actions"  style="display:none">
  				  
  				  <a data-filter="1" class="filters" id="media_4" href="#"><img src="<?php echo url::base(); ?>/media/img/filtro-1-off.png" alt="<?php echo Kohana::lang('ui_main.news'); ?>" style="vertical-align:middle" /></a>
						
  				  <a data-filter="2" class="filters" id="media_1" href="#"><img src="<?php echo url::base(); ?>/media/img/filtro-2-off.png" alt="<?php echo Kohana::lang('ui_main.pictures'); ?>" style="vertical-align:middle" /></a>
  				  
  				  <a data-filter="3" class="filters" id="media_2" href="#"><img src="<?php echo url::base(); ?>/media/img/filtro-3-off.png" alt="<?php echo Kohana::lang('ui_main.video'); ?>" style="vertical-align:middle" /></a>
  				  
  				  <a data-filter="4" class="filters" id="media_5" href="#"><img id="all" src="<?php echo url::base(); ?>/media/img/filtro-4-off.png" alt="todos" style="vertical-align:middle" /></a></a>

				  </div>
				  <div id='box_search_btn'>
				    <div id="menu_filters">
      	      <?php echo Kohana::lang('ui_main.category_filter');?><a href="javascript:switchImage('#image_arrow', 'category_switch')" id="category_switch_link"><img id='image_arrow' src="<?php echo url::base(); ?>/media/img/arrow_down_gray.png" data-current-src="down"></a>
				    </div>
				    <div class="submit submit_geocode"></div>
					<div class="search">
						<p>
							<input type="text" id="location_find_main" name="location_find" value="" title="buscar local" class="findtext">								<span id="find_loading" class="report-find-loading"></span>								
						</p>
					</div>				    
				  </div>
				</div>
				
				
				<div>
  				<!-- right column -->
          <div id="category_column" class="clearingfix">
          	<!-- category filters -->
          	<ul id="category_switch" class="category-filters" style="display:none;">
          		<li><a class="active" id="cat_0" href="#"><span class="swatch"><img id="cat_x" src="<?php echo url::base(); ?>/media/img/cat_x.png" alt="x" style="vertical-align:middle" /></span><span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span></a></li>
          		<?php
          			foreach ($categories as $category => $category_info)
          			{
          				$category_title = $category_info[0];
          				$category_color = $category_info[1];
          				$category_image = '';
          				$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
          				if($category_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$category_info[2])) {
          					$category_image = html::image(array(
          						'src'=>Kohana::config('upload.relative_directory').'/'.$category_info[2],
          						'style'=>'float:left;padding-right:5px;'
          						));
          					$color_css = '';
          				}
          				echo '<li><a href="#" id="cat_'. $category .'"><span '.$color_css.'>'.$category_image.'</span><span class="category-title">'.$category_title.'</span></a>';
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
                                                                  if($child_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$child_info[2])) {
                                                                          $child_image = html::image(array(
                                                                                  'src'=>Kohana::config('upload.relative_directory').'/'.$child_info[2],
                                                                                  'style'=>'float:left;padding-right:5px;'
                                                                                  ));
                                                                          $color_css = '';
                                                                  }
                                                                  echo '<li style="padding-left:20px;"><a href="#" id="cat_'. $child .'"><span '.$color_css.'>'.$child_image.'</span><span class="category-title">'.$child_title.'</span></a></li>';
                                                          }
                                                          echo '</ul>';
                                                      }
          				echo '</div></li>';
          			}
          		?>
          		          	<?php
          	if (false && $layers)
          	{
          		?>
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
          				$layer_link = (!$layer_url) ?
          					url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
          					$layer_url;
          				echo '<li><a href="#" id="layer_'. $layer .'"
          				onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
          				<div>'.$layer_name.'</div></a></li>';
          			}
          			?>
          		<!-- /Layers -->
          		<?php
          	}
          	?>

          	</ul>
          	<?php
          	if (false && $shares)
          	{
          		?>
          		<!-- Layers (Other Ushahidi Layers) -->
          		<div class="cat-filters clearingfix" style="margin-top:20px;">
          			<strong><?php echo Kohana::lang('ui_main.other_ushahidi_instances');?> <span>[<a href="javascript:toggleLayer('sharing_switch_link', 'sharing_switch')" id="sharing_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
          		</div>
          		<ul id="sharing_switch" class="category-filters">
          			<?php
          			foreach ($shares as $share => $share_info)
          			{
          				$sharing_name = $share_info[0];
          				$sharing_color = $share_info[1];
          				echo '<li><a href="#" id="share_'. $share .'"><div class="swatch" style="background-color:#'.$sharing_color.'"></div>
          				<div>'.$sharing_name.'</div></a></li>';
          			}
          			?>
          		</ul>
          		<!-- /Layers -->
          		<?php
          	}
          	?>


          	<br />

          	<!-- additional content -->
          	<?php
          	if (Kohana::config('settings.allow_reports'))
          	{
          		?>
          	<?php } ?>

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
<div class="content-block-left" style="display:none">
  <div id="feed">
		<h5><?php echo Kohana::lang('ui_main.incidents_listed'); ?></h5>
		<table class="table-list">
			<thead>
				<tr>
					<th scope="col" class="title"><?php echo Kohana::lang('ui_main.title'); ?></th>
					<th scope="col" class="date"><?php echo Kohana::lang('ui_main.date'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if ($total_items == 0)
				{
				?>
				<tr><td colspan="2"><?php echo Kohana::lang('ui_main.no_reports'); ?></td></tr>

				<?php
				}
				//TODO: Using very bad technic
				$report_count = 3;
				foreach ($incidents as $incident)
				{
					$location = $incident->locations[0];
					$incident_id = $incident->id;
					$incident_date = $incident->incident_date;
					$incident_title = text::limit_chars($incident->incident_title, 40, '...', True);
			if ($report_count ==0){
				break;
			}
			$report_count -= 1;							
				?>
		<tr>
					<td><a href="<?php echo url::site() . 'locations/submit/' . $incident_id; ?>"> <?php echo $incident_title ?></a></td>
					<td><?php echo $incident_date; ?></td>
				</tr>
				<?php
				}
				?>

			</tbody>
		</table>
		<a class="more" href="<?php echo url::site() . 'reports/' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
	</div>
</div>
<div>
  <iframe id="news_iframe" frameborder="0" width="100%" height="700px" overflow-y="auto" src="http://mapascoletivos.com.br/noticias"></iframe>
</div>


<!-- content -->
<div class="content-container" style="display:none">

	<!-- content blocks -->
	<div class="content-blocks clearingfix">
		<!-- right content block -->
		<div class="content-block-right">
			<h5><?php echo Kohana::lang('ui_main.official_news'); ?></h5>
			<table class="table-list">
				<thead>
					<tr>
						<th scope="col"><?php echo Kohana::lang('ui_main.title'); ?></th>
						<th scope="col"><?php echo Kohana::lang('ui_main.source'); ?></th>
						<th scope="col"><?php echo Kohana::lang('ui_main.date'); ?></th>
					</tr>
				</thead>
					<?php
                                        if ($feeds->count() != 0)
                                        {
                                            echo '<tbody>';
                                            foreach ($feeds as $feed)
                                            {
                                                    $feed_id = $feed->id;
                                                    $feed_title = text::limit_chars($feed->item_title, 40, '...', True);
                                                    $feed_link = $feed->item_link;
                                                    $feed_date = date('M j Y', strtotime($feed->item_date));
                                                    $feed_source = text::limit_chars($feed->feed->feed_name, 15, "...");
                                            ?>
                                            <tr>
                                                    <td><a href="<?php echo $feed_link; ?>" target="_blank"><?php echo $feed_title ?></a></td>
                                                    <td><?php echo $feed_source; ?></td>
                                                    <td><?php echo $feed_date; ?></td>
                                            </tr>
                                            <?php
                                            }
                                            echo '</tbody>';
                                        }
                                        else
                                        {
                                            echo '<tbody><tr><td></td><td></td><td></td></tr></tbody>';
                                        }
					?>
			</table>
			<a class="more" href="<?php echo url::site() . 'feeds' ?>"><?php echo Kohana::lang('ui_main.view_more'); ?></a>
		</div>
		<!-- / right content block -->

	</div>
	<!-- /content blocks -->
</div>
<!-- content -->

