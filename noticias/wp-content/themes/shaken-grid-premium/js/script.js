jQuery.noConflict();
(function($) {
	
	// Responsive Videos
	$('.vid-container').fitVids();
	
	// Show/Hide Filter Menu
	$('#filtering-nav ul').hide();
	$('a.filter-btn').click(function(){
		$('#filtering-nav ul').slideToggle();
		return false;
	});
	
	// Submenus
	var submenu_config = {    
		 over: function(){ $('ul', this).fadeIn(200); },  
		 timeout: 300,
		 out: function(){ $('ul', this).fadeOut(300); }  
	};
	$('.header-nav ul > li').not(".header-nav ul li li").hoverIntent(submenu_config);
	
	// Create the dropdown base
	$("<select />").appendTo(".header-nav");
	
	// Create default option "Go to..."
	$("<option />", {
	   "selected": "selected",
	   "value"   : "",
	   "text"    : "Go to..."
	}).appendTo(".header-nav select");
	
	// Populate dropdown with menu items
	$(".header-nav a").each(function() {
	 	var el = $(this);
	 	
	 	if( el.parent().parent().hasClass('sub-menu') ){
	 		var prefix = "- ";
	 	} else{
	 		var prefix = '';
	 	}
	 	
		$("<option />", {
		     "value"   : el.attr("href"),
		     "text"    : prefix + el.text()
		}).appendTo(".header-nav select");
	});

	// Dropdown menu clicks
	$(".header-nav select").change(function() {
        window.location = $(this).find("option:selected").val();
	});
	
	// Vertically align header items
	$('#site-info, #social-networks, #header ul.menu').vit();
	
	// Sidebar Ads
	$('.shaken_sidebar_ads a:odd img').addClass('last-ad');
	
	// Share Icons
	$('.share-container').hide();
	
	$('.share').live('click', function(){
		$('.share-container', $(this).parent()).slideToggle('fast');				   
	});
	
	// Display pop-up when clicking on share icons
	$('.share-window').live('click', function(){
		var width  = 650;
		var height = 500;
		var left   = (screen.width  - width)/2;
		var top    = (screen.height - height)/2;
		var params = 'width='+width+', height='+height;
		params += ', top='+top+', left='+left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=no';
		params += ', status=no';
		params += ', toolbar=no';
		newwin=window.open($(this).attr('href'),'Share', params);
		if (window.focus) {newwin.focus();}
		return false;
	});
	
	// Lightbox Init
	var fancyboxArgs = {
	    padding: 0,
	    overlayColor: "#000",
	    overlayOpacity: 0.85,
	    titleShow: false
	};
	$('.gallery-icon a').attr('rel', 'post-gallery');
	$("a[rel='gallery'], a[rel='lightbox'], .gallery-icon a, .colorbox").fancybox( fancyboxArgs );
	
	// Remove margins
	$('.gallery-thumb:nth-child(3n)').addClass('last');
	
	// Slider Init
	$('.slider').slides({
		play: 4500,
		pause: 2500,
		hoverPause: true,
		effect: 'fade',
		generatePagination: false
	});
	
	$(window).load(function(){
		
		// Vertically center all images in the slider
		$('.slides_container').quickEach(function(){
			var containerH = this.height();
			
			$('img', this).quickEach(function(){
				var imgH = this.height();	
				if(imgH != containerH){
					var margin = (containerH - imgH)/2; 
					this.css('margin-top', margin);
				}
			});
		});
		
		// Isotope Init		
		$('.sort, #sort').isotope({
			itemSelector : '.box:not(.invis)',
			transformsEnabled: false,
			masonry: {
				columnWidth : 175 
			}
		});
		
		// Filtering
		$('#filtering-nav li a').click(function(){
			var selector = $(this).attr('data-filter');
		  	$('#sort, .sort').isotope({ filter: selector });
		  	return false;
		});

	});
})(jQuery);

jQuery.fn.quickEach = (function(){
    var jq = jQuery([1]);
    return function(c) {
        var i = -1, el, len = this.length;
        try {
            while (
                 ++i < len &&
                 (el = jq[0] = this[i]) &&
                 c.call(jq, i, el) !== false
            );
        } catch(e){
            delete jq[0];
            throw e;
        }
        delete jq[0];
        return this;
    };
}());