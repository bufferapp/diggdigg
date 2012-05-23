jQuery(document).ready(function(){
	
	// Load Linked In Sharers (Resolves issue with position on page)
	if(jQuery('.dd-linkedin-share').length && !jQuery('.dd_outer').length){
		jQuery('.dd-linkedin-share div').each(function(index) {
		    var $linkedinSharer = jQuery(this);
		    
		    if($linkedinSharer.hasClass('parsed')){
		    	return;
		    }
		    
		    var linkedinShareURL = $linkedinSharer.attr('data-url');
			var linkedinShareCounter = $linkedinSharer.attr('data-counter');
			
			var linkedinShareCode = jQuery('<script>').attr('type', 'unparsed-IN/Share').attr('data-url', linkedinShareURL).attr('data-counter', linkedinShareCounter);
			
			$linkedinSharer.html(linkedinShareCode);
			
			IN.Event.on(IN, "systemReady", function() {
				$linkedinSharer.children('script').first().attr('type', 'IN/Share');
				IN.parse();
			});
			
			$linkedinSharer.addClass('parsed');
		});
	}
	
});
