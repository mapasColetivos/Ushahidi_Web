<div class="popup">
	<img src="<?php echo url::base(); ?>/media/img/close.png" title="close" class="close_image_popup" />
	<h1 id="kmlhacktitle"></h1>


	<h3 id="kmlSubtitle">-------------------------</h3>
	<div class="asset_area hooverable">
		<div id="description" style="display:none;margin-left:10px;">
Aqui acessar a descricao
		</div>
	</div>
<?php
echo "<span style='float:right'>" . "<a href='/users/index/". "ID_SUBIU" . "' >" . "AQUI O NOME DE QUEM SUBIU O KML". "</a></span>";

?>
	<div class="popup_controls">
		<a id="previous_button"></a>
		 
		<span id="asset_count"></span>
		 
		<a id="next_button"></a>

		<a href="#" id="remove_asset" style="display:none;">		


			Remover esse upload	
		</a>		
		<span id="owner" style="float:right"></span>		

<script type="text/javascript">
//	        var asset_count;
//        var asset_pointer;
//	var message = (asset_pointer + 1) +" de "+asset_count;

//	$("#asset_count").text(message);
//	asset_id = $("#asset"+asset_pointer).attr("data-id");
//	$("#remove_asset").text('aaaaa');
var elem = document.getElementById("remove_asset");  
    	//$media = ORM::factory('media')->where('id',asset_id)->find();
// asset_id $user_id;
// 	LSel=document.getElementById(LS['id']);
	elem.style.position="relative";
//	elem.style.right="20px";
    elem.style.cssFloat = "right";  
//	LSel.style.cssFloat="right";
</script>
	</div>
</div>
<script type="text/javascript">
</script>
aAAAAAAAAAaaaaaaaaa
