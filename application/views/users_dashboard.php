<div id="main" class="clearfix">
	<div id='profile' class="static_content">
		<div id="social">
			<div id="facebook_button">
				<a name="fb_share" type="icon" share_url="YOUR_URL" ></a> 
				<script type="text/javascript" src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"></script>
			</div>
            
			<div id="twitter_button" >			
				<a href="https://twitter.com/share" data-text="<?php echo $user->name; ?>" class="twitter-share-button" data-count="none" data-lang="pt">Tweetou</a>
				<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			</div>
		
        </div>
		<div id="left_column_profile" style="height:100%">
			<p id="mapeador">
				<?php if ($myself and ($myself->id != $user->id)) {
					if ($myself->follows($user)) {
						echo "<a href='".url::base()."social/unfollow/".$user->id."'><img src='".url::base()."media/img/btn_deixar_seguir_mapeador.png'></a>";
					} else {
						echo "<a href='".url::base()."social/follow/".$user->id."'><img src='".url::base()."media/img/btn_seguir_mapeador.png'></a>";
					}
				} ?>	
			</p>
			<img src="<?php echo $user->photo(154)?>"/>
			<br />			
			<div class="user_title">
				<h2>
					<?php echo $user->name;?>
					<?php if ($myself && ($user->id == $myself->id)) { ?>
					  <a class="btn_editar edit" href='<?php echo url::base()."users/profile/".$user->id ?>'>editar</a>
					<? } ?>
				</h2>
				<br/>
				<p>
					localização: <?php if ($user->localization) {echo $user->localization;} else {echo "Não informado";} ?>
				</p>
				<p>
<?php
if(substr_count($user->web,'http'))
    $uweb = $user->web;
else 
    $uweb = 'http://'.$user->web;
?>
					web: <?php if ($user->web) {echo "<a href='".$uweb."' target='_blank' >".$uweb."</a>";} else {echo "Não informado";} ?>
                    
				</p>
				<p>
					bio: <?php if ($user->bio) {echo $user->bio;} else {echo "Não informado";} ?>
				</p>
			</div>			
			<div class="maping">
				<h3>Mapeadores</h3>
				<div class="followee_box">
					<?php foreach ($user->followees() as $followee) { ?>
						<a href=<?php echo url::base().'users/index/'.$followee->followee_id; ?>>
							<img width='30px' title="<?php echo ORM::factory('user')->find($followee->followee_id)->username ?>" src="<?php echo ORM::factory('user')->find($followee->followee_id)->photo(30)?>"/>
						</a>
					<?php } ?>
				</div>		
			</div>			
			<div id="maps_count">
				<h3 id="maps_count_header">mapasColetivos</h3>
				<div id="maps_count_content">
					<table id="maps_count_counter">
						<tr>	
							<td class="maps_counter active" id="created_counter">
								<span><?php echo $user->created_maps()->count() ?></span>
								</br>
								criados
							</td>
							<td/>
							<td class="maps_counter" id="available_counter">
								<span><?php echo count($user->available_maps()) ?></span>
								</br>
								colaborando
							</td>
							<td/>
							<td class="maps_counter" id="following_counter">
								<span><?php echo count($user->following_maps()) ?></span>
								</br>
								seguindo
							</td>
						</tr>
					</table>
					<div id="maps_count_list">
						<ul class="map_list" id="created_counter_list">							
							<?php foreach ($user->created_maps() as $map) { 
								  if ( $map->incident_privacy-1) { ?>
								      <li>
									      <a href="<?php echo url::base()."reports/view/".$map->id ?>">
										      <?php echo $map->incident_title ?>
									      </a>
								      </li>
							<?php 	  } 
								}?>

						</ul>				
						<ul class="map_list" id="available_counter_list" style='display:none'>							
							<?php foreach ($user->available_maps() as $map) {
								  if ( $map->incident_privacy-1) { ?>
									<li>
										<a href="<?php echo url::base()."reports/view/".$map->id ?>">
											<?php echo $map->incident_title ?>
										</a>
									</li>
							<?php 	  } 
								}?>
						</ul>
						<ul class="map_list" id="following_counter_list" style='display:none'>
							<?php foreach ($user->following_maps() as $map) {
								  if ( $map->incident_privacy-1) { ?>
									      <li>
										      <a href="<?php echo url::base()."reports/view/".$map->id ?>">
											      <?php echo $map->incident_title ?>
											      
										      </a>
									      </li>
							<?php 	  } 
								}?>
						</ul>							
					</div>
					<p id="new_map">
						<?php
							echo "<a href='".url::base()."reports/submit'>+ criar novo mapa</a>"
						?>
					</p>	
				</div>
			</div>	
		
		</div>	
		<div id="right_column">
			<div id="filters_bar">        
				<h1 id="map_title">
					Geografia pessoal
				</h1>
				
				<span id="hide_show">
					<span id="hide_show_text">categorias</span>
					<img id='image_arrow_map' src="<?php echo url::base(); ?>/media/img/arrow_down_gray.png">
				</span> 				
			</div>
			
			<div id="user_map">
		        <div id="display_box" >			
      			  <div id="kmls">
        			  <ul id="layer_list" style="display:none;">
        			  <?php foreach($user_categories as $category) {
        				  echo "<li>";
        				  echo "<span class='swatch' style='background-color:#".$category->category_color."'></span>";
        				  echo "<span class='category-title'>";
        					echo $category->category_title;
        					echo "</span>";								  
        				  echo "</li>";
                  }?>        			  
                </ul>                  
        			</div>
        		</div>
    			</div>
			</div>	
		</div>
	</div>
</div>
