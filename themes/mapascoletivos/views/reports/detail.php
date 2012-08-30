<div id="main" class="clearing-fix">
	<div id="map_dash" class="static_content">

		<!-- social -->
		<div id="social">
			<div id="facebook_button">
				<?php 
					// URL to share on Facebook
					echo html::anchor($incident->share_url(), "", 
					    array("name"=>"fb_share", "type"=>"icon", "share_url"=>$incident->share_url()));

					// Facebook sharing JavaScript
					echo html::script("http://static.ak.fbcdn.net/connect.php/js/FB.Share"); 
				?>
			</div>
			<div id="twitter_button">
				<?php
					// Twitter button
					echo html::anchor("https://twitter.com/share", "Twitter", array(
					    "data-text" => $incident->incident_title,
					    "data-url" => $incident->share_url(),
					    "class" => "twitter-share-button",
					    "data-count" => "none",
					    "data-lang" => "pt"
					));

					// Twitter widget JavaScript 
					echo html::script("https://platform.twitter.com/widgets.js");
				?>
			</div>
		</div>
		<!-- /social -->

		<!-- left_column -->
		<div id="left_column">
			<!-- TODO Finish up the email button -->
			<div id="convidar">
				<?php echo html::anchor("#", "Convidar", array('class'=>'btn_convidar')); ?>
			</div>
			<div class="links">
				<?php echo html::anchor("locations/create/".$incident->id, "Colobar", array('class' => 'btn_collaborate')); ?>
			</div>
			<!-- /TODO -->

			<div class="description_map">
				<h2><?php echo $incident->incident_title; ?></h2>
				<p><?php echo $incident->incident_description; ?></p>
				<br/>
				<div class="minimize">
					<p>
						Categoria:
						<?php echo html::anchor("reports/index?c=".$incident->category[0], $incident->category[0]->category_title); ?>
					</p>
					<p>
					<!-- Incident tags go here -->
						Tags: 
					<?php 
						foreach ($incident->incident_tags as $incident_tag)
						{
							$tag = $incident_tag->tag;
							echo html::anchor('reports/?t='.$tag->id, $tag->value);
						}
					?>
					</p>
				</div>
			</div>
			
			<div class="divisor"></div>

			<div class="maps_count">
				<p>exibições: </p>
				<p>última atualização:</p>
				<table>
					<tr>	
						<td><span><?php echo $incident->count_images(); ?></span>
							</br>
						fotos
						</td>
						<td><span><?php echo $incident->count_videos(); ?></span>
							</br>
						videos
						</td>
						<td><span><?php echo $incident->count_reports(); ?></span>
							</br>
						reports
						</td>
					</tr>
				</table>
			</div>

			<div class="divisor"></div>
			<div class="about">
				<p>
				criado em:<span> <?php echo $incident->incident_dateadd; ?></span>
				</p>

				<p>
					criado por:<br>
					<?php
					 	// Show the author's gravatar
						$creator = $incident->user;
						echo html::anchor("users/index/".$creator->id, 
							html::image($creator->gravatar(), array('width'=>'30px', 'title'=>$creator->username)));
					?>
				</p>

				<?php if ( ! empty($collaborators)): ?>
				<!-- followers -->
				<p>
					colaboradores:
					<div class="followee_box">
					<?php
						foreach ($collaborators as $collaborator)
						{
							// Display the collaborator's avatar
							echo html::anchor(
								"users/index/".$collaborator->id, 
								html::image($collaborator->gravatar(), 
									array('width'=>'30px', 'title'=>$collaborator->username)));
						}
					?>
					</div>
				</p>
				<!-- /followers -->
				<?php endif; ?>

				<?php if ($user): ?>
				<!-- follow incident(map) -->
				<div class="follow">
					<p>
					<?php
						// Attributes for the anchor
						$attributes = array(
							'data-incident-id' => $incident->id,
							'data-action-name' => 'follow',
							'class' => 'incident-follow'
						);

						if ($user->is_incident_follower($incident))
						{
							// Add the following class
							$attributes['class'] = 'incident-follow following';
							$attributes['data-action-name'] = 'unfollow';
						}

						echo html::anchor("#", "", $attributes);
					?>
					</p>
				</div>
				<!-- /follow -->
				<?php endif; ?>

			</div>

		</div>
		<!-- /left_column -->

		<!-- right_column -->
		<div id="right_column">
			<div id="filters_bar">
				<h1 id="map_title"><?php echo $incident->incident_title; ?></h1>

				<?php if ($incident->incident_kml->count()): ?>
				<div class="map-filters">
					<div id="menu_filters">
						<a href="#" class="filter-switch">
							<span><?php echo Kohana::lang('ui_main.location_layers'); ?></span>
							<?php echo html::image("media/img/arrow_down_gray.png", "", array('border'=>'0')); ?>
						</a>
					</div>
				</div>
				<?php endif; ?>

			</div>

			<!-- map display -->
			<div id="user_map">
				<?php if ($incident->incident_kml->count()): ?>
				<!-- incident layers -->
				<div class="layers-overlay" style="display:none;">
					<div class="map-layers">
						<ul class="layers-listing">
					 	<?php foreach ($incident->incident_kml as $kml): ?>
					 	<?php if ($kml->layer->loaded): ?>
					 		<li>
					 			<a href="#" data-layer-id="<?php echo $kml->layer_id; ?>" data-layer-name="<?php echo $kml->layer->layer_name; ?>">
						 			<span class="layer-color" style="background-color: #<?php echo $kml->layer->layer_color; ?>"></span>
						 			<span class="user-layer-name"><?php echo $kml->layer->layer_name; ?></span>
					 			</a>
					 		</li>
					 	<?php endif; ?>
					 	<?php endforeach; ?>
						</ul>

					</div>
				</div>
				<!-- /incident layers -->
				<?php endif; ?>
			</div>

			<!-- map comments -->
			<div id="map_comments" class="clearfix" style="display:block; float:none; clear:both;">
				<script>
					var idcomments_acct = '5b8f7e7c53bd3d3a5211a974f92a8886';
					var idcomments_post_id = <?php echo $incident->id; ?>;
					var idcomments_post_url;
				</script>
				<?php echo html::script("http://www.intensedebate.com/js/genericCommentWrapperV2.js"); ?>
				<span id="IDCommentsPostTitle" style="display:none"></span>
			</div>
			<!-- /map comments -->
		</div>
		<!-- /right_column -->

	</div>
</div>

<?php if ($user): ?>
<script type="text/javascript">
$(function() {
	// When the follow/unfollow map button is clicked
	$(".follow a.incident-follow").click(function(e){
		var data = {
			action: $(this).data("action-name"),
			incident_id: $(this).data("incident-id"),
			user_id: <?php echo $user->id; ?>
		};

		var context = this;

		// Submit the request
		$.ajax({
			type: "POST",
			url: "<?php echo url::site("reports/social"); ?>",
			data: data,
			success: function(response) {
				var action = data.action === "follow" ?"unfollow" : "follow";
				$(context).data("action-name", action);
				$(context).toggleClass("following");
			},
			dataType: "json"
		});
		return false;
	});
});
</script>
<?php endif; ?>