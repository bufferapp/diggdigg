jQuery(document).ready(function($){

	var $floating_bar = $('#dd_ajax_float');
	var $content_wrap = $('.dd_content_wrap');
	
	if($content_wrap.length > 0){
	
		var position_from_top = parseInt($content_wrap.offset().top - 30);
		var pullX = $floating_bar.css('margin-left');
	
		$(window).scroll(function () { 
		  
			var scroll_from_top = $(window).scrollTop();
			var is_fixed = $content_wrap.css('position') == 'fixed';
			
			if($floating_bar.length > 0){
			
				if ( scroll_from_top > position_from_top && !is_fixed ) {
					$content_wrap.css({
						position: 'fixed',
						top: 30
					});
				} else if ( scroll_from_top < position_from_top && is_fixed ) {
					$content_wrap.css({
						position: 'relative',
						top: 0
					});
				}
				
			}
	
		});
	}
});