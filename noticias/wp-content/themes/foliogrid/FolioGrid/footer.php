<a href="<?php if(of_get_option('ft_rss_url')!=''){ echo of_get_option('ft_rss_url'); }else{ echo bloginfo('rss2_url'); } ?>" id="rss_link" onmouseover="animateRSS()" onmouseout="animateRSS()">Subscribe</a> 

<div id="searchBox" onmouseover="animateSearch()" onmouseout="animateSearch()">
	<form method="get" class="searchform" action="<?php bloginfo('url'); ?>/">
        <input type="text" value="Search term..." name="s" class="s" onblur="if(this.value=='')this.value='Search term...';" onfocus="if(this.value=='Search term...')this.value='';" />
    </form>
</div>

<a href="#body" class="anchor1 anchorLink" id="top_link" onmouseover="animateTopLink()" onmouseout="animateTopLink()">Scroll to Top</a> 

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.infinitescroll.js"></script>
<script type="text/javascript">

jQuery(window).load(function(){
	
	jQuery('#postwrapper').masonry({ 
		columnWidth: 10, 
		itemSelector: '.post'
	});

	jQuery('#postwrapper').infinitescroll({
		navSelector  : '.nextPrev',    // selector for the paged navigation 
		nextSelector : '.nextPrev a',    // selector for the NEXT link (to page 2)
		itemSelector : '.infinite',       // selector for all items you'll retrieve
		loadingImg : '<?php bloginfo('template_directory'); ?>/images/loader.gif',
		donetext  : 'No more pages to load.',
		debug: true,
		errorCallback: function() { 
			// fade out the error message after 2 seconds
			jQuery('#infscr-loading').animate({opacity: .8},2000).fadeOut('normal');     
		}
	},
		// call masonry as a callback
		function() { 
			//$('.removeonceloaded').hide();
			//setTimeout(function() { $('.removeonceloaded').fadeIn(500); },1000);
			//$('.post').removeClass('.removeonceloaded');
			jQuery('.older').css('display', 'none'); // hide 'older' link
			jQuery('#postwrapper').masonry({ appendedContent: jQuery(this) ,columnWidth: 10, 
		itemSelector: '.post'});
			jFadeInit();
		}
	);
	
});

</script>	

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/foliogrid.js"></script>
<script language="javascript" type="text/javascript">

var dropdown = document.getElementById("cat");
function onCatChange() {
	if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
		location.href = "<?php echo get_option('home');?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
	}
}
dropdown.onchange = onCatChange;

</script>

<?php wp_footer(); ?>

</body>
</html>