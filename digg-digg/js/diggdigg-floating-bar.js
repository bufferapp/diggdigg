var dd_top = 0;
var dd_left = 0;

jQuery(document).ready(function(){

	var $floating_bar = jQuery('#dd_ajax_float');
	
    var dd_anchorId = 'dd_start';
    if ( typeof dd_override_start_anchor_id !== 'undefined' && dd_override_start_anchor_id.length > 0 ) {
        dd_anchorId = dd_override_start_anchor_id;
    }

	var $dd_start = jQuery( '#' + dd_anchorId );
	var $dd_end = jQuery('#dd_end');
	var $dd_outer = jQuery('.dd_outer');
	
	// first, move the floating bar out of the content to avoid position: relative issues
	$dd_outer.appendTo('body');
	
    if ( typeof dd_override_top_offset !== 'undefined' && dd_override_top_offset.length > 0 ) {
        dd_top_offset_from_content = parseInt( dd_override_top_offset );
    }
	dd_top = parseInt($dd_start.offset().top) + dd_top_offset_from_content;
	
	if($dd_end.length){
		dd_end = parseInt($dd_end.offset().top);
	}
	
	dd_left = -(dd_offset_from_content + 55);
	
	dd_adjust_inner_width();
	dd_position_floating_bar(dd_top, dd_left);
	
	$floating_bar.fadeIn('slow');
	
	if($floating_bar.length > 0){
	
		var pullX = $floating_bar.css('margin-left');
		
		jQuery(window).scroll(function () { 
		  
			var scroll_from_top = jQuery(window).scrollTop() + 30;
			var is_fixed = $dd_outer.css('position') == 'fixed';
			
			if($dd_end.length){
				var dd_ajax_float_bottom = dd_end - ($floating_bar.height() + 30);
			}
			
			if($floating_bar.length > 0)
			{
				if(scroll_from_top > dd_ajax_float_bottom && $dd_end.length){
					dd_position_floating_bar(dd_ajax_float_bottom, dd_left);
					$dd_outer.css('position', 'absolute');
				} 
				else if ( scroll_from_top > dd_top && !is_fixed )
				{
					dd_position_floating_bar(30, dd_left);
					$dd_outer.css('position', 'fixed');
				}
				else if ( scroll_from_top < dd_top && is_fixed )
				{
					dd_position_floating_bar(dd_top, dd_left);
					$dd_outer.css('position', 'absolute');
				}
				
			}
	
		});
	}
	
	// Load Linked In Sharers (Resolves issue with position on page)
	if(jQuery('.dd-linkedin-share').length){
		jQuery('.dd-linkedin-share div').each(function(index) {
		    var $linkedinSharer = jQuery(this);
		    
		    var linkedinShareURL = $linkedinSharer.attr('data-url');
			var linkedinShareCounter = $linkedinSharer.attr('data-counter');
			
			var linkedinShareCode = jQuery('<script>').attr('type', 'unparsed-IN/Share').attr('data-url', linkedinShareURL).attr('data-counter', linkedinShareCounter);
			
			$linkedinSharer.html(linkedinShareCode);
			
			IN.Event.on(IN, "systemReady", function() {
				$linkedinSharer.children('script').first().attr('type', 'IN/Share');
				IN.parse();
			});
		});
	}
	
});


jQuery(window).resize(function() {
	dd_adjust_inner_width();
});

var dd_is_hidden = false;
var dd_resize_timer;
function dd_adjust_inner_width() {
	
	var $dd_inner = jQuery('.dd_inner');
	var $dd_floating_bar = jQuery('#dd_ajax_float')
	var width = parseInt(jQuery(window).width() - (jQuery('#dd_start').offset().left * 2));
	$dd_inner.width(width);
	var dd_should_be_hidden = (((jQuery(window).width() - width)/2) < -dd_left);
	var dd_is_hidden = $dd_floating_bar.is(':hidden');
	
	if(dd_should_be_hidden && !dd_is_hidden)
	{
		clearTimeout(dd_resize_timer);
		dd_resize_timer = setTimeout(function(){ jQuery('#dd_ajax_float').fadeOut(); }, -dd_left);
	}
	else if(!dd_should_be_hidden && dd_is_hidden)
	{
		clearTimeout(dd_resize_timer);
		dd_resize_timer = setTimeout(function(){ jQuery('#dd_ajax_float').fadeIn(); }, -dd_left);
	}
}

function dd_position_floating_bar(top, left, position) {
	var $floating_bar = jQuery('#dd_ajax_float');
	if(top == undefined) top = 0 + dd_top_offset_from_content;;
	if(left == undefined) left = 0;
	if(position == undefined) position = 'absolute';
	
	$floating_bar.css({
		position: position,
		top: top + 'px',
		left: left + 'px'
	});
}