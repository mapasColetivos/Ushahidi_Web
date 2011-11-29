<div id="content">
	<div class="content-bg">
		<!-- start reports block -->
		<div class="big-block-reports">
			<?php
			// Filter::report_stats - The block that contains reports list statistics
			Event::run('ushahidi_filter.report_stats', $report_stats);
			echo $report_stats;
			?>
			<div style="clear:both;"></div>
			<div class="r_cat_tooltip"> <a href="#" class="r-3">2a. Structures a risque | Structures at risk</a> </div>
			<div class="reports-box">
				<?php
				foreach ($incidents as $incident){
  				{
 					$location = $incident->locations->current();				
  					$incident_id = $incident->id;
  					$incident_title = $incident->incident_title;
  					$incident_description = $incident->incident_description;
  					//$incident_category = $incident->incident_category;
  					// Trim to 150 characters without cutting words
  					// XXX: Perhaps delcare 150 as constant

  					$incident_description = text::limit_chars(strip_tags($incident_description), 150, "...", true);
  					$incident_date = date('H:i M d, Y', strtotime($incident->incident_date));
  					//$incident_time = date('H:i', strtotime($incident->incident_date));
  					$location_name = $incident->incident_title;
					
  					$comment_count = $incident->comment->count();
					
  					$data_thumbnail = "<div data-map='".$incident->id."' style='cursor:pointer;height:118px;width:178px;border:1px solid #C0C2B8;' id='map".$incident->id."'></div>";
  					$media = $incident->media;
					?>
					<div class="rb_report">

						<div class="r_media">
							<p class="r_photo"> 
								<?php echo $data_thumbnail ?>
							</p>

							<!-- Only show this if the report has a video -->
							<p class="r_video" style="display:none;"><a href="#">Video</a></p>
							
							<!-- Category Selector -->
							<div class="r_categories">
								<h4><?php echo Kohana::lang('ui_main.categories'); ?></h4>
								<?php
								foreach ($incident->category AS $category)
								{
									if ($category->category_image_thumb)
									{
										?>
										<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>"><span class="r_cat-box"><img src="<?php echo url::base().Kohana::config('upload.relative_directory')."/".$category->category_image_thumb; ?>" height="16" width="16" /></span> <span class="r_cat-desc"><?php echo $localized_categories[(string)$category->category_title];?></span></a>
										<?php
									}
									else
									{
										?>
										<a class="r_category" href="<?php echo url::site(); ?>reports/?c=<?php echo $category->id; ?>"><span class="r_cat-box" style="background-color:#<?php echo $category->category_color;?>;"></span> <span class="r_cat-desc"><?php echo $localized_categories[(string)$category->category_title];?></span></a>
										<?php
									}
									echo $category->category_title;
								}
								?>
							</div>
							<div class="r_media">
								Tags: <?php echo $incident->tags() ?>
							</div>
						</div>

						<div class="r_details">
							<h3><a class="r_title" href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>"><?php echo $location_name; ?></a> <a href="<?php echo url::site(); ?>reports/view/<?php echo $incident_id; ?>#discussion" class="r_comments"><?php echo $comment_count; ?></a></h3>
							<p class="r_date r-3 bottom-cap"><?php echo $incident_date; ?></p>
							<div class="r_description"> <?php echo $incident_description; ?> </div>
						</div>
					</div>
				<?php }} ?>
			</div>
			<?php echo $pagination; ?>
		</div>
		<!-- end reports block -->
	</div>
</div>
<div style="width:89px;height:59px" id="map"></div>