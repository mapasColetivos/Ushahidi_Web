<div id="content">
	<div class="content-bg">
		<!-- start contacts block -->
		<div class="big-block">
	<br></br>
    <br></br>
			<div id="contact_us" class="contact">
				<?php
				if ($form_error)
				{
					?>
					<!-- red-box -->
					<div class="red-box">
						<h3>Erro!</h3>
						<ul>
							<?php
							foreach ($errors as $error_item => $error_description)
							{
								print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
							}
							?>
						</ul>
					</div>
					<?php
				}

				if ($form_sent)
				{
					?>
					<!-- green-box -->
					<div class="green-box">
						<h3>Sua Mensagem foi enviada!</h3>
					</div>
					<?php
				}								
				?>
				<?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>
				<div class="report_row">
					<strong>Nome:</strong><br />
					<?php print form::input('contact_name', $form['contact_name'], ' class="text"'); ?>
				</div>
				<div class="report_row">
					<strong>E-mail:</strong><br />
					<?php print form::input('contact_email', $form['contact_email'], ' class="text"'); ?>
				</div>
				
                 <!--
                <div class="report_row">
					Telefone (opcional):<br />
					<?php print form::input('contact_phone', $form['contact_phone'], ' class="text"'); ?>
				</div>
                 -->
				
                <div class="report_row">
					<strong>Assunto:</strong><br />
					<?php print form::input('contact_subject', $form['contact_subject'], ' class="text"'); ?>
				</div>								
				<div class="report_row">
					<strong>Mensagem:</strong><br />
					<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea long" ') ?>
				</div>		
				
                <div class="report_row">
					<strong>Código de Segurança:</strong><br /> 
                    </div>
                    <?php print $captcha->render(); ?><br /> 	
                    				<?php print form::input('captcha', $form['captcha'], ' class="text"'); ?> 
				

                
				<div class="report_row">
					<input name="submit" type="submit" value="Enviar" class="btn_submit" />
                </div>      
              <br />
			  </p>
              <p style="padding-left: 60px;"><span style="color: #000000; font-size:14px;">ou escreva diretamente para <strong>contato@mapascoletivos.com</strong></span></p>
              <p style="padding-left: 60px;"><span style="color: #000000; font-size:14px;">em caso de dúvidas técnicas ou relato de bugs escreva para: <strong>suporte@mapascoletivos.com</strong> </span></p>  
                </div>          
                
				<?php print form::close(); ?>
			</div>
			
		</div>
		<!-- end contacts block -->
	</div>
</div>