jQuery.fn.gallery = function() {
	return this.each(function(){
		var images = jQuery('img.attachment-medium',this);
		images.hide().css({opacity:0});
		jQuery(images[0]).show().css({opacity:1});
		jQuery(this).after('<ul id="gallery-nav"></ul>');
		
		if (images.length > 1) {
			//var changer = jQuery('+ul',this);
			images.each(function(){
				var numberLink = (images.index(this)+1).toString();
				if (numberLink.length == 1) numberLink = '0' + numberLink;
				jQuery('<li><a href="#">'+numberLink+'</a></li>').click(showImage).appendTo("#gallery-nav");
			});
			jQuery('#gallery-nav li:first').addClass('first current');
		}

		function showImage() {
			jQuery(this).addClass('current').siblings().removeClass('current');
			var clicked = this;
			images.each(function(){
				if (jQuery(this).is(':visible')) {
					jQuery(this).animate({opacity:0},200,function(){
						jQuery(this).hide();
						jQuery(images[jQuery(clicked).parent().children('li').index(clicked)]).css({display:'block'}).animate({opacity:1},200);
					});
				}
			});
			return false;
		}
	});
}