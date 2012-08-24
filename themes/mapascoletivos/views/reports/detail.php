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
				<?php echo html::anchor("", "Convidar"); ?>
			</div>
			<div class="links">
				<?php echo html::anchor("locations/submit/".$incident->id, "Colobar", array('class' => 'btn_collaborate')); ?>
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
						// Show the follow/unfollow buttons
						if ($user->is_incident_follower($incident))
						{
							echo html::anchor("social/unfollow_map/".$incident->id, html::image("media/img/btn_deixar_seguir_mapa.png"));
						}
						else
						{
							echo html::anchor("social/follow_map/".$incident->id, html::image("media/img/btn_seguir_mapa.png"));
						}
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
				<span id="hide_show" >
					<span id="hide_show_text">legenda</span>
					<?php echo html::image("media/img/arrow_down_gray.png", array("id" => "image_arrow_map")); ?>
				</span> 
			</div>

			<!-- map display -->
			<div id="user_map">
				<div id="display_box">

					<!-- kmls for the incident -->
					<div id="kmls"></div>
					<!-- /kmls -->
				</div>
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