	<?php
		$selected = false; 
		foreach ($layers as $layer)
			{
				$class = "layer_description";
		?>
		<div class="<?php echo $class ?>" id="layer<?php echo $layer->id ?>" data-id=<?php echo $layer->id ?> >
			<span class="layer_color" style="background:#<?php echo $layer->layer_color ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<a class="select_layer" ><?php echo $layer->layer_name; ?></a> <a class="edit_layer" rel="layer" href='<?php echo url::base() ?>index.php/layers/edit/<?php echo $layer->id ?>'>(editar)</a> <?php if ($layer->owner_id == $user->id){?><a class="delete_layer">(X)</a></br> <? } ?>
	</div>
	<?php } ?>
	</div>	