<div id="main" class="clearing-fix">
	<div id="profile" class="static_content">

		<!-- social -->
		<div id="social">
			<div id="facebook_button">
				<?php
					// URL to share on Facebook
					echo html::anchor("#", "",
					    array("name"=>"fb_share", "type"=>"icon", "share_url"=>""));

					// Facebook sharing JavaScript
					echo html::script("http://static.ak.fbcdn.net/connect.php/js/FB.Share");
				?>
			</div>
			<div id="twitter_button">
				<?php
					// Twitter button
					echo html::anchor("https://twitter.com/share", "Twitter", array(
					    "data-text" => $visited_user->name,
					    "data-url" => "",
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
			<p id="mapeador">
			<?php
				if ( ! empty($visiting_user) AND ($visiting_user->id != $visited_user->id))
				{
					// Attributes for the anchor
					$attributes = array(
						'class' => 'user-follow',
						'data-user-id' => $visited_user->id,
						'data-action-name' => 'follow'
					);

					if ($visiting_user->is_following($visited_user))
					{
						// Add thefollowing class
						$attributes['class'] = 'user-follow following';
						$attributes['data-action-name'] = 'unfollow';
					}

					// Display the anchor
					echo html::anchor("#", "", $attributes);
				}
			?>
			</p>
			<?php echo html::image($visited_user->gravatar(150)); ?>
			<br>

			<div class="user_title">
				<h2>
				<?php
					echo $visited_user->name;
					if ($visiting_user AND ($visiting_user->id == $visited_user->id))
					{
						echo html::anchor("users/profile", "editar", array('class'=>'edit'));
					}
				?>
				</h2>
				<br>

				<!-- Locality -->
				<p>
					localização: <?php echo ( ! empty($visited_user->localization)) ? $visited_user->localization : "Não informado"; ?>
				</p>
				<!-- /Locality -->

				<!-- user website -->
				<p>
					web:
				<?php
					if ($visited_user->web)
					{
						$url = $visited_user->web;
						if ( ! strpos($url, "http"))
						{
							$url = "http://".$url;
						}

						// Show the link to the user's website
						echo html::anchor($url, $url, array('target'=>'_blank'));
					}
					else
					{
						echo "Não informado";
					}
				?>
				</p>
				<!-- /user website -->

				<!-- user bio -->
				<p>
					bio: <?php echo ( ! empty($visited_user->bio)) ? $visited_user->bio : "Não informado"; ?>
				</p>
				<!-- /user bio -->
			</div>

			<div class="maping">
				<h3>Mapeadores</h3>

				<!-- users following -->
				<div class="followee_box">
				<?php
					foreach ($users_following as $user)
					{
						// Display the collaborator's avatar
						echo html::anchor(
							"users/index/".$user->id,
							html::image($user->gravatar(),
								array('width'=>'30px', 'title'=>$user->name)));
					}
				?>
				</div>
				<!-- /users following -->
			</div>

			<div id="maps_count">
				<h3 id="maps_count_header">mapasColetivos</h3>
				<div id="maps_count_content">
					<table id="maps_count_counter">
						<tr>
							<!-- No. of maps (incidents) the visited use has created -->
							<td class="maps_counter active" id="created_counter">
								<span><?php echo count($incidents); ?></span><br/>
								criados
							</td>
							<td/>
							<!-- No. of maps (incidents) the visited user has collaborated on -->
							<td class="maps_counter" id="available_counter">
								<span><?php echo count($incidents_collaborated_on); ?></span><br/>
								colaborando
							</td>
							<td/>

							<!-- No. of incidents (maps) the visited user following -->
							<td class="maps_counter" id="following_counter">
								<span><?php echo count($incidents_following); ?></span><br/>
								seguindo
							</td>
						</tr>
					</table>
					<div id="maps_count_list">
						<!-- List the maps (incidents) created by the visited user -->
						<ul class="map_list" id="created_counter_list">
						<?php foreach ($incidents as $incident): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
						<?php endforeach; ?>
						</ul>

						<!-- List the maps being collaborated on -->
						<ul class="map_list" id="available_counter_list" style='display:none'>
						<?php foreach ($incidents_collaborated_on as $incident): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
						<?php endforeach; ?>
						</ul>

						<!-- List of maps (incidents) the visited user is following -->
						<ul class="map_list" id="following_counter_list" style='display:none'>
						<?php foreach ($incidents_following as $incident): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>

		</div>
		<!-- /left_column -->

		<!-- right_column -->
		<div id="right_column">
			<div id="filters_bar">
				<h1 id="map_title">Geografia pessoal</h1>

				<div class="map-filters">
					<?php if ($visited_user->layer->count()): ?>
					<div id="menu_filters">
						<a href="#" class="filter-switch">
							<span><?php echo Kohana::lang('ui_main.location_layers'); ?></span>
							<?php echo html::image("media/img/arrow_down_gray.png", "", array('border'=>'0')); ?>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- map display -->
			<div id="user_map">

				<?php if ($visited_user->layer->count()): ?>
				<!-- user layers -->
				<div class="layers-overlay" style="display:none;">
					<div class="map-layers">
						<ul class="layers-listing">
					 	<?php foreach ($visited_user->layer as $layer): ?>
					 		<li>
					 			<a href="#" data-layer-id="<?php echo $layer->id; ?>" data-layer-name="<?php echo $layer->layer_name; ?>">
						 			<span class="layer-color" style="background-color: #<?php echo $layer->layer_color; ?>"></span>
						 			<span class="user-layer-name"><?php echo $layer->layer_name; ?></span>
					 			</a>
					 		</li>
					 	<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<?php endif; ?>
				<!-- /user layers -->
			</div>

		</div>
		<!-- /right_column -->

	</div>
</div>

<script type="text/javascript">
$(function(){
	$("#mapeador a.user-follow").click(function(e){
		var data = {
			user_id: $(this).data("user-id"),
			action: $(this).data("action-name")
		};

		var context = this;

		$.ajax({
			type: "POST",
			url: "<?php echo url::site("users/social"); ?>",
			data: data,
			success: function(response) {
				var action = data.action === "follow" ? "unfollow" : "follow";
				$(context).data("action-name", action);
				$(context).toggleClass("following");
			},
			dataType: "json"
		});
		return false;
	});

	// Toggle selection of the "mapasColetivos" tabs
	$(".maps_counter").click(function(e){
		var targetId = "#" + $(this).attr("id") + "_list";

		// Remove "active" class from all tabs
		$(".maps_counter").each(function(i){
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
			}
		})

		// Hide all lists
		$("ul.map_list").hide();

		// Show the selected list
		$(this).addClass("active");
		$(targetId).show();

		// Prevent further event processing
		return false;
	});
});
</script>