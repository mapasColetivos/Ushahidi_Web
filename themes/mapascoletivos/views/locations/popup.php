<div class="popup" id="location_popup_<?php echo $location->id; ?>">
	<?php echo html::image("media/img/close.png", array("title"=>"close", "class" => "close_image_popup")); ?>
	<h1><?php echo $location->location_name; ?></h1>
	<h3><?php echo html::anchor("reports/view/".$location->incident_id, $location->incident->incident_title); ?></h3>

	<div class="asset_area <?php if (count($location_media)) echo "hooverable"; ?>">
		<div class="asset-overlay" <?php if (count($location_media)) echo 'style="display: none;"' ?> >
			<p><?php echo str_replace("\n","<br />", $location->location_description); ?></p>
		</div>

		<?php foreach($location_media as $media): ?>
			<?php $media_type = $media->media_type; ?>
			<div class="assets" data-owner="<?php echo $media->user->name; ?>" data-owner-id="<?php $media->user_id; ?>"
				data-media="<?php echo $media_type; ?>" data-media-id="<?php echo $media->id; ?>">
		<?php
			switch($media_type)
			{
				case 4:
					// NEWS
					$anchor_text = html::image("media/img/external_link.png")
					    . '<span class="external_link">Link externo</span>';
					echo html::anchor($media->media_link, $anchor_text, array('target'=>'_blank'));
					break;
				case 2:
					// VIDEO
					$video_embeder->embed($media->media_link,'', 350,208);
					echo "<span class=\"ignore-hover\"></span>";
					break;
				case 1:
					// PHOTO
					$prefix = url::base().Kohana::config('upload.relative_directory');
					echo html::image($prefix."/".$media->media_link, array('class'=>'delimiter', 'style'=>'width:100%;'));
					break;
			}
		?>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="popup_controls">
		<?php if ($location->media->count() > 1): ?>
		<a id="asset_nav_previous">&larr;</a>
		<span class="asset-nav">
			<span id="current_asset_pos">1</span> de <?php echo count($location_media); ?>
		</span>
		<a id="asset_nav_next">&rarr;</a>
		<?php endif; ?>
		<a href="#" id="remove_asset" style="display:none;">Remover esse upload</a>
		<span id="owner" style="float:right">
			<?php echo html::anchor("users/index/".$location->user_id, $location->user->name); ?>
		</span>
	</div>
</div>