			</div>
		</div>
		<!-- / main body -->

	</div>
	<!-- / wrapper -->
	
	<!-- footer -->
	<div id="footer" class="clearingfix">
 
		<div id="underfooter"></div>

				
		<!-- footer content -->
		<div class="rapidxwpr floatholder">
 
			<!-- footer credits -->
			<div class="footer-credits">
			  <div id="mapas">
    		  <p id="realizacao">realização</p>
    		  <p id="apoio">apoio</p>
    		  <p id="plataformas">plataformas</p>  		  
    		</div>

			<a href="http://www.oeco.com.br/">
				<img src="<?php echo url::base(); ?>/media/img/eco_logo_original_white.png" alt="oeco" style="vertical-align:middle" />
			</a>
			<a href="https://www.institutoclaro.org.br/">
				<img id="claro" src="<?php echo url::base(); ?>/media/img/Institutoclaro_alta.png" alt="Claro" style="vertical-align:middle" />
			</a>
			<a href="http://www.ushahidi.com/">
				<img src="<?php echo url::base(); ?>/media/img/footer-logo.png" alt="Ushahidi" style="vertical-align:middle" />
			</a>
			<a href="http://www.wordpress.org/">
				<img id="wordpress" src="<?php echo url::base(); ?>/media/img/logo_wordpress_grey-m.png" alt="Wordpress" style="vertical-align:middle" />
			</a>
				
			</div>
			<!-- / footer credits -->
		
			<!-- footer menu -->
			<div class="footermenu">
				<ul class="clearingfix">
					<li><a class="item1" href="<?php echo url::base(); ?>/static/apps"><?php echo Kohana::lang('ui_main.app_cellphone'); ?></a></li>	
					<!--<li><a href="<?php echo url::base(); ?>/static/sms"><?php echo Kohana::lang('ui_main.sms'); ?></a></li>-->
					<li><a href="<?php echo url::base(); ?>/static/privacy">termos de uso</a></li>	  
					<li><a href="<?php echo url::site()."help"; ?>"><?php echo Kohana::lang('ui_main.help'); ?></a></li>   
					<li><a href="<?php echo url::base(); ?>/static/credits">créditos</a></li>	        		        
					<li><a href="<?php echo url::base(); ?>/contact"><?php echo Kohana::lang('ui_main.contact'); ?></a></li>
					<?php
					// Action::nav_main_bottom - Add items to the bottom links
					Event::run('ushahidi_action.nav_main_bottom');
					?>
				</ul>
				<?php if ($site_copyright_statement != ''): ?>
	      		<p><?php echo $site_copyright_statement; ?></p>
		      	<?php endif; ?>
			</div>

			<!-- / footer menu -->


		</div>
		<!-- / footer content -->
 
	</div>
	<!-- / footer -->
 
	<?php
	echo $footer_block;
	// Action::main_footer - Add items before the </body> tag
	Event::run('ushahidi_action.main_footer');
	?>
</body>
</html>