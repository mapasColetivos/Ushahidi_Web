<div id="main" class="clearfix">
	<div id='map_dash' class="static_content">
	<div id="social">
		
        <div id="facebook_button">
			<a name="fb_share" type="icon" share_url="<?php echo $incident->share_url(); ?>" ></a>  
			<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript">
			</script>
		</div>
        
		<div id="twitter_button" >			
			<a href="https://twitter.com/share" data-text="<?php echo $incident->incident_title; ?>" data-url="<?php echo $incident->share_url(); ?>" class="twitter-share-button" data-count="none" data-lang="pt">Tweetar</a>
			<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
		</div>
	</div>
		<div id="left_column" style="height:100%">
			<div id="convidar">	
				<a class="btn_convidar" href="mailto:<?php echo $incident->share_mail_to();?>"> Convidar </a>
			</div>
			<div class="links">
				<a class="btn_collaborate" href="<?php echo url::base().'locations/submit/'.$incident->id?>">Colaborar</a>
			</div>

			<div class="description_map">
				<h2>
					<?php echo $incident->incident_title ?>
				</h2>
				<p>
					<?php echo $incident->incident_description ?>
				</p>
				<br/>
				<div class="minimize">
					<p>
						Categoria:<a href="<?php echo url::base()."reports/?c=".$incident->category[0] ?>"> <?php echo $incident->category[0]->category_title ?></a>
					</p>
					<p>
						Tags: <?php echo $incident->tags() ?>
					</p>
				</div>
			</div>
			<div class="divisor"></div>
			<div class="maps_count">
				<p>
					exibições: 
				</p>
				<p>
					última atualização:
				</p>
				<table>
					<tr>	
						<td><span><?php echo $incident->count_images() ?></span>
							</br>
						fotos
						</td>
						<td><span><?php echo $incident->count_videos() ?></span>
							</br>
						videos
						</td>
						<td><span><?php echo $incident->count_reports() ?></span>
							</br>
						reports
						</td>
					</tr>
				</table>	
			</div>
			<div class="divisor"></div>
			<div class="about">
				<p>
				criado em:<span> <?php echo $incident->incident_dateadd ?></span>
				</p>
				<br/>
				<p>
					criado por:
          <br/>
					<?php $map_admin = ORM::factory("user")->where("id",$incident->owner_id)->find() ?>
					<a href=<?php echo url::base().'users/index/'.$map_admin->id; ?>>
						<img width='30px' title="<?php echo $map_admin->username ?>" src="<?php echo $map_admin->photo(30)?>"/>
					</a>					
				</p>
				<br/>
				<p>
				  colaboradores:
				<div class="followee_box">
					<?php foreach ($incident->collaborators() as $collaborator) { ?>
						<a href=<?php echo url::base().'users/index/'.$collaborator->id; ?>>
							<img width='30px' title="<?php echo $collaborator->username ?>" src="<?php echo $collaborator->photo(30)?>"/>
						</a>
					<?php } ?>
				</div>
        </p>	
					
				<div class="follow">
					<p>
						<?php 
							if ($user){
								if ($user->follows_map($incident)) {
									echo "<a href='".url::base()."social/unfollow_map/".$incident->id."'><img src='".url::base()."media/img/btn_deixar_seguir_mapa.png'></a>";
								} else {
									echo "<a href='".url::base()."social/follow_map/".$incident->id."'> <img src='".url::base()."media/img/btn_seguir_mapa.png'></a>";
								}
							} 
						?>	
					</p>
				</div>
			</div>	
		</div>
		<div id="right_column">
			<div id="filters_bar">        
				<h1 id="map_title">
					<?php echo $incident->incident_title ?>
				</h1>
				
				<span id="hide_show" >
					<span id="hide_show_text">legenda</span>
					<img id='image_arrow_map' src="<?php echo url::base(); ?>/media/img/arrow_down_gray.png">
				</span> 
				
			</div>
			<div id="user_map">						
        <div id="display_box">			
  			  <div id="kmls">
    			  <ul id="layer_list" style="display:none;">
    				<?php foreach($incident->layers() as $kml) {
    				  echo "<li>";
    				  echo "<img class='swatch' src='".url::base()."media/img/kml.png'/>";
    				  echo "<span id='layer_kml".$kml->id."' class='category-title'>";
    					echo $kml->layer_name;
    					echo "</span>";								  
    				  echo "</li>";
              }?>
      				<?php foreach($incident->categories() as $category) {
      				  echo "<li>";
      				  echo "<span class='swatch' style='background-color:#".$category->layer_color."'></span>";
      				  echo "<span class='category-title'>";
      					echo $category->layer_name;
      					echo "</span>";								  
      				  echo "</li>";
                }?>
            </ul>                  
    			</div>
    		</div>
			</div>
			<div id="map_comments" class="clearfix" style="display:block;float:none;clear:both">
				<script>
				var idcomments_acct = '5b8f7e7c53bd3d3a5211a974f92a8886';
				var idcomments_post_id = <?php echo $incident->id ?>;
				var idcomments_post_url;
				</script>
				<script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>
				<span id="IDCommentsPostTitle" style="display:none"></span>
			</div>			
		</div>
	</div>
</div>