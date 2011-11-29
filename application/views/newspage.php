<div id="main" class="clearfix">
	<div class="static_content">
    <iframe id="news_iframe" frameborder="0" scrolling="no" width="100%" height="600px" src="<?php echo url::base(); ?>/noticias/?<?php echo $url; ?>"></iframe>	
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var baseUrl = "<?php echo url::base(); ?>";  
	function iframe_link(event){
	  window.location = baseUrl+"newspage/?target="+event.currentTarget.href.match(/.*\?(.*)/)[1];
  }
  
  $("#news_iframe").load(function(){
    $("#news_iframe").contents().find('[href^="http://mapascoletivos.com"]').click(iframe_link);    
    $("#news_iframe").height($("#news_iframe").contents().find("html").height());    
  });
});
</script>