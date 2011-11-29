<div class="popup">
	<img src="<?php echo url::base(); ?>/media/img/close.png" title="close" class="close_image_popup" />
	<h1><?php echo $location->location_name; ?></h1>
	<h3><a href="<?php echo url::base().'/reports/view/'.$incident->id ?>"><?php echo $incident->incident_title; ?></a></h3>
	<div class="asset_area hooverable">
		<div id="description" style="display:none;">
			<?php echo $location->location_description; ?>	
		</div>
		<?php 
			$i = 0;
			$link_count = 0;
			foreach($location->media as $media) {
				echo "<div class='assets' data-owner='".ORM::factory("user")->where("id",$media->owner_id)->find()->name."' data-owner-id='".$media->owner_id."' data-media='".$media->media_type."' data-id='".$media->id."' id='asset".$i."'>";
				$i++;
				switch($media->media_type){
					case 4:// NEWS
						$prefix = url::base()."media/img/";
						$link_count++;
						echo '<a href="'.$media->media_link.'" target="_blank" ><img class="delimiter" src="'.$prefix.'/external_link.png"/><span class="external_link">Link externo '.$link_count.'</span></a>';
						break;
					case 2:// VIDEO
						$video_embeder = new VideoEmbed();
						$video_embeder->embed($media->media_link,'', 350,208);
						break;
					case 1:// PHOTO
						$thumb = str_replace(".","_p.",$media->media_link);
						$prefix = url::base().Kohana::config('upload.relative_directory');		
						echo '<img class="delimiter" src="'.$prefix.'/'.$thumb.'"/>';
						break;
				}
				echo "</div>";
			}
		?>
	</div>
	<div class="popup_controls">
		<a id="previous_button"><</a>
		 
		<span id="asset_count"></span>
		 
		<a id="next_button">></a>
		<a href="#" id="remove_asset" style="display:none;">		
			Remover esse upload	
		</a>		
		<span id="owner" style="float:right"></span>		
	</div>
</div>
<script type="text/javascript">
</script>