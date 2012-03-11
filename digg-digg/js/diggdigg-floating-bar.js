var dd_top = 0;
var dd_left = 0;

$(document).ready(function(){

	var $floating_bar = $('#dd_ajax_float');
	var $dd_start = $('#dd_start');
	var $dd_outer = $('.dd_outer');
	
	dd_top = parseInt($dd_start.offset().top);
	dd_left = -(dd_offset_from_content + 55);
	
	dd_adjust_inner_width();
	dd_position_floating_bar(dd_top, dd_left);
	
	$floating_bar.fadeIn('slow');
	
	if($floating_bar.length > 0){
	
		var pullX = $floating_bar.css('margin-left');
	
		$(window).scroll(function () { 
		  
			var scroll_from_top = $(window).scrollTop() + 30;
			var is_fixed = $dd_outer.css('position') == 'fixed';
			
			if($floating_bar.length > 0)
			{
				if ( scroll_from_top > dd_top && !is_fixed )
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
});

$(window).load(function(){

	var $dd_start = $('#dd_start');
	var $floating_bar = $('#dd_ajax_float');
	
	dd_top = parseInt($dd_start.offset().top);
	
	// reposition the floating bar
	dd_position_floating_bar(dd_top, dd_left);
	dd_adjust_inner_width();
});

$(window).resize(function() {
	dd_adjust_inner_width();
});

var dd_is_hidden = false;
var dd_resize_timer;
function dd_adjust_inner_width() {
	
	var $dd_inner = $('.dd_inner');
	var $dd_floating_bar = $('#dd_ajax_float')
	var width = parseInt($(window).width() - ($('#dd_start').offset().left * 2));
	$dd_inner.width(width);
	var dd_should_be_hidden = ((($(window).width() - width)/2) < -dd_left);
	var dd_is_hidden = $dd_floating_bar.is(':hidden');
	
	if(dd_should_be_hidden && !dd_is_hidden)
	{
		clearTimeout(dd_resize_timer);
		dd_resize_timer = setTimeout(function(){ $('#dd_ajax_float').fadeOut(); }, -dd_left);
	}
	else if(!dd_should_be_hidden && dd_is_hidden)
	{
		clearTimeout(dd_resize_timer);
		dd_resize_timer = setTimeout(function(){ $('#dd_ajax_float').fadeIn(); }, -dd_left);
	}
}

function dd_position_floating_bar(top, left, position) {
	
	var $floating_bar = $('#dd_ajax_float');
	if(top == undefined) top = 0;
	if(left == undefined) left = 0;
	if(position == undefined) position = 'absolute';
	
	$floating_bar.css({
		position: position,
		top: top + 'px',
		left: left + 'px'
	});
}