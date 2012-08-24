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
					if ($visiting_user->is_following($visited_user))
					{
						echo html::anchor("social/unfollow/".$visited_user->id, html::image("media/img/btn_deixar_seguir_mapeador.png"));
					}
					else
					{
						echo html::anchor("social/follow/".$visited_user->id, html::image("media/img/btn_seguir_mapeador.png"));
					}
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
								<span><?php echo $visited_user->incident->count(); ?></span>
								</br>
								criados
							</td>
							<td/>
							<!-- No. of maps (incidents) the visited user has collaborated on -->
							<td class="maps_counter" id="available_counter">
								<span><?php echo count($visited_user->get_incidents_collaborated_on()); ?></span>
								</br>
								colaborando
							</td>
							<td/>

							<!-- No. of incidents (maps) the visited user following -->
							<td class="maps_counter" id="following_counter">
								<span><?php echo $visited_user->incident_follows->count(); ?></span>
								</br>
								seguindo
							</td>
						</tr>
					</table>
					<div id="maps_count_list">

						<!-- List the maps (incidents) created by the visited user -->
						<ul class="map_list" id="created_counter_list">
						<?php foreach ($visited_user->incident as $incident): ?>
							<?php if ( ! $incident->incident_privacy): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>

						<!-- List the maps being collaborated on -->
						<ul class="map_list" id="available_counter_list" style='display:none'>
						<?php foreach ($visited_user->get_incidents_collaborated_on() as $incident): ?>
							<?php if ( ! $incident->incident_privacy): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>

						<!-- List of maps (incidents) the visited user is following -->
						<ul class="map_list" id="following_counter_list" style='display:none'>
						<?php foreach ($visited_user->incident_follows as $follow): ?>
							<?php $incident = $follow->incident; ?>
							<?php if ( ! $incident->incident_privacy): ?>
							<li>
								<?php echo html::anchor("reports/view/".$incident->id, $incident->incident_title); ?>
							</li>
							<?php endif; ?>
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
				<span id="hide_show" >
					<span id="hide_show_text">legenda</span>
					<?php echo html::image("media/img/arrow_down_gray.png", array("id" => "image_arrow_map")); ?>
				</span> 
			</div>

			<!-- map display -->
			<div id="user_map">
				<div id="display_box">

					<!-- user categories -->
					<div id="kmls"></div>
					<!-- /user categories -->
				</div>
			</div>

		</div>
		<!-- /right_column -->

	</div>
</div>

<script type="text/javascript">
	// JavaScript for toggling the selection of the
	// tabs under the mapasColetivos header
</script>