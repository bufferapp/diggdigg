<?php
// XXX: NEW BUTTONS: Extend this base class. Set defaults as class properties
class BaseDD {
	
	//String for replacement.
	const VOTE_URL = 'VOTE_URL'; 
	const VOTE_TITLE = 'VOTE_TITLE';
	const VOTE_IMAGE = 'VOTE_IMAGE';
	const VOTE_BUTTON_DESIGN = 'VOTE_BUTTON_DESIGN';
	const SCHEDULER_TIMER = 'SCHEDULER_TIMER';
	const POST_ID = 'POST_ID';
	const VOTE_BUTTON_DESIGN_LAZY_WIDTH = 'VOTE_BUTTON_DESIGN_LAZY_WIDTH';
	const VOTE_BUTTON_DESIGN_LAZY_HEIGHT = 'VOTE_BUTTON_DESIGN_LAZY_HEIGHT';
	
	//default value
	const DEFAULT_APPEND_TYPE = 'none';
	const DEFAULT_OPTION_AJAX = 'false';
	const DEFAULT_BUTTON_DESIGN = 'Normal';
	const DEFAULT_BUTTON_WEIGHT = '100';

    // define properties
    var $name; //name of the vote button
    var $websiteURL; //website URL
    var $apiURL; //Button API for development
    
    var $baseURL; // vote button URL, before construt
    var $baseURL_lazy; // vote button URL, before construt, lazy version
    var $baseURL_lazy_script; // jQuery script , lazy version
    var $scheduler_lazy_script; //scheduler function
    var $scheduler_lazy_timer; //miliseconds
	
    var $finalURL; //final URL for display, after constructs
    var $finalURL_lazy;//final lazy URL for display, after constructs
    var $finalURL_lazy_script;//final jQuery, after constructs
    var $final_scheduler_lazy_script; //final scheduler, after constructs
    
    var $isEncodeRequired = true; //is URL or title need encode?
    var $islazyLoadAvailable = true; //is lazy load avaliable?
    
    //contains DD option value, in array
    var $wp_options; 
    var $option_append_type;
	var $option_button_design;
	var $option_button_weight;
	var $option_ajax_left_float;
	var $option_lazy_load;
	 
	var $button_weight_value;
	
	//default float button design
	var $float_button_design = self::DEFAULT_BUTTON_DESIGN;
	
	//default button layout, suit in most cases
	var $buttonLayout = array(
		"Normal" => "Normal",
		"Compact" => "Compact"
	);
	
	// Default options
	var $append_type = 'none';
	var $button_design = 'Normal';
	var $ajax_left_float = false;
	var $lazy_load = false;
	
	public function getButtonDesign($button){
    	return $this->buttonLayout[$button];
    }
    
    //default lazy button layout, suit in most cases
    var $buttonLayoutLazy = array(
		"Normal" => "Normal",
		"Compact" => "Compact"
	);
	
    public function getButtonDesignLazy($button){
    	return $this->buttonLayoutLazy[$button];
    }
    
    var $buttonLayoutLazyWidth = array(
		"Normal" => "51",
		"Compact" => "120"
	);
	
	public function getButtonDesignLazyWidth($button){
    	return $this->buttonLayoutLazyWidth[$button];
    }
    
    var $buttonLayoutLazyHeight = array(
		"Normal" => "69",
		"Compact" => "22"
	);
	
	public function getButtonDesignLazyHeight($button){
    	return $this->buttonLayoutLazyHeight[$button];
    }
    
    function BaseDD($name, $websiteURL, $apiURL, $baseURL) {
    	$this->name = $name;
    	$this->websiteURL = $websiteURL;
    	$this->apiURL = $apiURL;
    	$this->baseURL = $baseURL;
    	
    	$this->initWPOptions();
    }
    
    private function initWPOptions() {
    	$this->wp_options = array();
		
		// XXX: Set default options in the subclass
    	$this->wp_options[$this->option_append_type] = $this->append_type;
    	//$this->wp_options[$this->option_append_type] = self::DEFAULT_APPEND_TYPE;
    	
    	$this->wp_options[$this->option_button_design] = $this->button_design;
    	//$this->wp_options[$this->option_button_design] = self::DEFAULT_BUTTON_DESIGN;
    	
    	$this->wp_options[$this->option_ajax_left_float] = $this->ajax_left_float;
    	//$this->wp_options[$this->option_ajax_left_float] = self::DEFAULT_OPTION_AJAX;
    	
    	$this->wp_options[$this->option_lazy_load] = $this->lazy_load;
    	//$this->wp_options[$this->option_lazy_load] = self::DEFAULT_OPTION_AJAX;
    	
    	$this->wp_options[$this->option_button_weight] = $this->button_weight_value;
    }
    
    public function getOptionLazyLoad(){
    	return $this->wp_options[$this->option_lazy_load];
    }
    public function getOptionAjaxLeftFloat(){
    	return $this->wp_options[$this->option_ajax_left_float];
    }
    public function getOptionButtonWeight(){
    	return $this->wp_options[$this->option_button_weight];
    }
    public function getOptionAppendType(){
    	return $this->wp_options[$this->option_append_type];
    }
    public function getOptionButtonDesign(){
    	return $this->wp_options[$this->option_button_design];
    }
    
	//construct base URL, based on $lazy value
 	public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){
    	
 		//rawurlencode - replace space with %20
    	//urlencode - replace space with + 
 		if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
    	if($lazy==DD_EMPTY_VALUE || $lazy==false){
    		$this->constructNormalURL($url, $title,$button, $postId);
    	}else{
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    	}
    	
    }
    
	public function constructNormalURL($url, $title,$button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
    	$this->finalURL = $finalURL;
    }
    
    public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	
    	$finalURL_lazy = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);
    	
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	//lazy loading javascript
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	//scheduler to run the lazy loading
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
}

//iframe class has different construct URL for normal and lazy load
class BaseIFrameDD extends BaseDD{
	const EXTRA_VALUE = "EXTRA_VALUE";
	
	var $buttonLayoutWidthHeight = array(
		"Normal" => "height=\"69\" width=\"51\"",
		"Compact" => "height=\"22\" width=\"120\"",
	);
	
	public function getIframeWH($button){
    	return $this->buttonLayoutWidthHeight[$button];
    }
    
	public function constructNormalURL($url, $title,$button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(parent::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(parent::VOTE_URL,$url,$finalURL);
    	$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
    	
    	$finalURL = str_replace(self::EXTRA_VALUE,$this->getIframeWH($button),$finalURL);
    	$this->finalURL = $finalURL;
    }
    
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);    	
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}
	
//warning : in baseURL or lazyURL, all text have to enclose by html tag, else it will display pure text in the_excerpt mode

// DEFAULT BUTTONS (IN THEIR DEFAULT ORDER)

// TODO: consider tidying this up by loading these classes from separate files

/******************************************************************************************
 * 
 * http://www.twitter.com
 * //data-counturl
 */
class DD_Twitter extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Normal';
	var $ajax_left_float = 'on';
	var $lazy_load = false;
	
	const NAME = "Twitter";
	const URL_WEBSITE = "http://www.twitter.com";
	const URL_API = "http://twitter.com/goodies/tweetbutton";
	const DEFAULT_BUTTON_WEIGHT = "110";

	const BASEURL ="<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"VOTE_URL\" data-count=\"VOTE_BUTTON_DESIGN\" data-text=\"VOTE_TITLE\" data-via=\"VOTE_SOURCE\" ></a><script type=\"text/javascript\" src=\"//platform.twitter.com/widgets.js\"></script>";
	
	const OPTION_APPEND_TYPE = "dd_twitter_appendType";
	const OPTION_BUTTON_DESIGN = "dd_twitter_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_twitter_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_twitter_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_twitter_lazy_load";
	
	const BASEURL_LAZY ="<div class='dd-twitter-ajax-load dd-twitter-POST_ID'></div><a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"VOTE_URL\" data-count=\"VOTE_BUTTON_DESIGN\" data-text=\"VOTE_TITLE\" data-via=\"VOTE_SOURCE\" ></a>";
	const BASEURL_LAZY_SCRIPT = " function loadTwitter_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-twitter-POST_ID').remove();\$.getScript('http://platform.twitter.com/widgets.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadTwitter_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";

	var $buttonLayout = array(
		"Normal" => "vertical",
		"Compact" => "horizontal"
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => "vertical",
		"Compact" => "horizontal"
	);
	
	var $isEncodeRequired = false;
	
	const VOTE_SOURCE = "VOTE_SOURCE";
	
    public function DD_Twitter() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    }

 	public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){
    	
 		if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
 		$twitter_source = '';
 		if($globalcfg!=''){
 			$twitter_source = $globalcfg[DD_GLOBAL_TWITTER_OPTION][DD_GLOBAL_TWITTER_OPTION_SOURCE]; 
 		}

    	if($lazy==DD_EMPTY_VALUE){
    		//format twitter source
    		$this->baseURL = str_replace(self::VOTE_SOURCE,$twitter_source,$this->baseURL);
    		
    		$this->constructNormalURL($url, $title,$button, $postId);
    		
    	}else{
    		//format twitter source
    		$this->baseURL_lazy = str_replace(self::VOTE_SOURCE,$twitter_source,$this->baseURL_lazy);
    	
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    	}
    	
    }

	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    }
    
}

/******************************************************************************************
 * Buffer Button
 * http://bufferapp.com/goodies/button
 *
 */
class DD_Buffer extends BaseDD{
	var $append_type = 'after_content';
	var $button_design = 'Normal';
	var $ajax_left_float = 'on';
	var $lazy_load = false;
	
	const NAME = "Buffer";
	const URL_WEBSITE = "http://bufferapp.com/";
	const URL_API = "http://bufferapp.com/goodies/button/";
	const DEFAULT_BUTTON_WEIGHT = "99";
	
	var $isEncodeRequired = false;
	
	const BASEURL = '<a href="http://bufferapp.com/add" class="buffer-add-button" data-count="VOTE_BUTTON_DESIGN" data-text="VOTE_TITLE" data-url="VOTE_URL" data-via="VOTE_BUFFER_SOURCE"></a><script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>';

	const BASEURL_LAZY = '<a href="http://bufferapp.com/add" class="buffer-add-button" data-count="VOTE_BUTTON_DESIGN" data-text="VOTE_TITLE" data-url="VOTE_URL" data-via="VOTE_BUFFER_SOURCE"></a>';
	const BASEURL_LAZY_SCRIPT = "function loadBuffer_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-buffer-POST_ID').remove();\$.getScript('http://static.bufferapp.com/js/button.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadBuffer_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
    
	const OPTION_APPEND_TYPE = "dd_buffer_appendType";
	const OPTION_BUTTON_DESIGN = "dd_buffer_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_buffer_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_buffer_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_buffer_lazy_load";
	
	const VOTE_BUFFER_SOURCE = "VOTE_BUFFER_SOURCE";
	
	var $buttonLayout = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none"
	);
	
	// XXX: Old-style constructor
    public function DD_Buffer() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }

	public function constructURL($url, $title, $button, $postId, $lazy, $globalcfg = ''){
    	
 		if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
 		$buffer_source = '';
 		if($globalcfg!=''){
 			$buffer_source = $globalcfg[DD_GLOBAL_BUFFER_OPTION][DD_GLOBAL_BUFFER_OPTION_SOURCE];
 		}

    	if($lazy==DD_EMPTY_VALUE || $lazy==false){
    		//format twitter source
			$this->baseURL = str_replace(self::VOTE_BUFFER_SOURCE,$buffer_source,$this->baseURL);
    		$this->constructNormalURL($url, $title,$button, $postId);   		
    	}else{
    		//format twitter source
    		$this->baseURL_lazy = str_replace(self::VOTE_BUFFER_SOURCE,$buffer_source,$this->baseURL_lazy);
    	
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    	}
    	
    }
    
	public function constructNormalURL($url, $title, $button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
		$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
    	$this->finalURL = $finalURL;
    }

	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}
/******************************************************************************************
 * 
 * Facebook Like (XFBML)
 * https://developers.facebook.com/tools/lint/
 * 
 */
class DD_FbLike_XFBML extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Like Button Count';
	var $ajax_left_float = 'on';
	var $lazy_load = false;
	
	const NAME = "Facebook Like (XFBML)";
	const URL_WEBSITE = "http://www.facebook.com";
	const URL_API = "http://developers.facebook.com/docs/reference/plugins/like";

	const BASEURL = "<script src=\"//connect.facebook.net/FACEBOOK_LOCALE/all.js#xfbml=1\"></script><fb:like href=\"VOTE_URL\" FACEBOOK_SEND FACEBOOK_SHOW_FACE VOTE_BUTTON_DESIGN ></fb:like>";
		
	const FB_LOCALES = "http://www.facebook.com/translations/FacebookLocales.xml";
	const DEFAULT_BUTTON_WEIGHT = "96";
	
	const OPTION_APPEND_TYPE = "dd_fblike_xfbml_appendType";
	const OPTION_BUTTON_DESIGN = "dd_fblike_xfbml_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_fblike_xfbml_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_fblike_xfbml_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_fblike_xfbml_lazy_load";
	
	const LIKE_STANDARD =  " width=\"450\" "; 
	const LIKE_BUTTON_COUNT= " layout=\"button_count\" width=\"92\" ";
	const LIKE_BOX_COUNT= " layout=\"box_count\" width=\"50\" ";
	const RECOMMEND_STANDARD = " action=\"recommend\" width=\"400\" ";
	const RECOMMEND_BUTTON_COUNT= " action=\"recommend\" layout=\"button_count\" width=\"130\" ";
	const RECOMMEND_BOX_COUNT= " action=\"recommend\" layout=\"box_count\" width=\"90\" ";

	const FACEBOOK_SEND = "FACEBOOK_SEND"; //send=\"true\"
	const FACEBOOK_SHOW_FACE = "FACEBOOK_SHOW_FACE"; //show_faces=\"true\" 
	const FACEBOOK_LOCALE = "FACEBOOK_LOCALE";
	
	var $islazyLoadAvailable = false;
	
	var $float_button_design = "Like Box Count";
	
	var $buttonLayout = array(
		"Like Standard" => self::LIKE_STANDARD,
		"Like Button Count" => self::LIKE_BUTTON_COUNT,
		"Like Box Count" => self::LIKE_BOX_COUNT,
		"Recommend Standard" => self::RECOMMEND_STANDARD,
		"Recommend Button Count" => self::RECOMMEND_BUTTON_COUNT,
		"Recommend Box Count" => self::RECOMMEND_BOX_COUNT
	);
    
    public function DD_FbLike_XFBML() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    } 

	public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){
    	
 		if($this->isEncodeRequired){
 			//$title = rawurlencode($title);
    		//$url = rawurlencode($url);
 		}
 	
 		$fb_locale = '';
 		$fb_send = '';
 		$fb_face = '';
 		$fb_send_value = '';
 		$fb_face_value = '';
 		
 		if($globalcfg!=''){
 			$fb_locale = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_LOCALE]; 
 			$fb_send = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_SEND]; 
 			$fb_face = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_FACE]; 
 			
 			if($fb_send == DD_DISPLAY_ON){
 				$fb_send_value = "send=\"true\"";
 			}else{
 				$fb_send_value = "send=\"false\"";
 			}
 			
 			if($fb_face == DD_DISPLAY_ON){
 				$fb_face_value = "show_faces=\"true\"";
 			}else{
 				$fb_face_value = "show_faces=\"false\"";
 			}
 			
 		}

 		//show face and send button 
    	$this->baseURL = str_replace(self::FACEBOOK_LOCALE,$fb_locale,$this->baseURL);
    	$this->baseURL = str_replace(self::FACEBOOK_SEND,$fb_send_value,$this->baseURL);
    	$this->baseURL = str_replace(self::FACEBOOK_SHOW_FACE,$fb_face_value,$this->baseURL);
    	
    	$this->constructNormalURL($url, $title,$button, $postId);
    	    	
    }
    
}

/******************************************************************************************
 * 
 * http://www.google.com/+1/button/
 * http://www.google.com/webmasters/+1/button/
 *
 */
class DD_Google1 extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Normal';
	var $ajax_left_float = 'on';
	var $lazy_load = false;
	
	const NAME = "Google +1";
	const URL_WEBSITE = "http://www.google.com/+1/button/";
	const URL_API = "http://code.google.com/apis/+1button/";
	const DEFAULT_BUTTON_WEIGHT = "95";
	
	var $isEncodeRequired = false;
	
	const BASEURL = "<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone size='VOTE_BUTTON_DESIGN' href='VOTE_URL'></g:plusone>";

	const BASEURL_LAZY = "<div class='dd-google1-ajax-load dd-google1-POST_ID'></div><g:plusone size='VOTE_BUTTON_DESIGN' href='VOTE_URL'></g:plusone>";
	const BASEURL_LAZY_SCRIPT = " function loadGoogle1_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-google1-POST_ID').remove();\$.getScript('https://apis.google.com/js/plusone.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadGoogle1_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
    
	const OPTION_APPEND_TYPE = "dd_google1_appendType";
	const OPTION_BUTTON_DESIGN = "dd_google1_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_google1_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_google1_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_google1_lazy_load";
	
	var $buttonLayout = array(
		"Normal" => "tall",
		"Compact (15px)" => "small",
		"Compact (20px)" => "medium",
		"Compact (24px)" => "none"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "tall",
		"Compact (15px)" => "small",
		"Compact (20px)" => "medium",
		"Compact (24px)" => "none"
	);
	
    public function DD_Google1() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }
    
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}

/******************************************************************************************
 * 
 * http://www.linkedin.com
 *
 */
class DD_Linkedin extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Normal';
	var $ajax_left_float = 'on';
	var $lazy_load = false;
	
	const NAME = "Linkedin";
	const URL_WEBSITE = "http://www.linkedin.com";
	const URL_API = "http://www.linkedin.com/publishers";
	const DEFAULT_BUTTON_WEIGHT = "94";
	
	const BASEURL = "<script src='//platform.linkedin.com/in.js' type='text/javascript'></script><script type='IN/Share' data-url='VOTE_URL' data-counter='VOTE_BUTTON_DESIGN'></script>";
	const BASEURL_LAZY = "<div class='dd-linkedin-ajax-load dd-linkedin-POST_ID'></div><script type='IN/share' data-url='VOTE_URL' data-counter='VOTE_BUTTON_DESIGN'></script>";
	const BASEURL_LAZY_SCRIPT = " function loadLinkedin_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-linkedin-POST_ID').remove();\$.getScript('http://platform.linkedin.com/in.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadLinkedin_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
    
	const OPTION_APPEND_TYPE = "dd_linkedin_appendType";
	const OPTION_BUTTON_DESIGN = "dd_linkedin_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_linkedin_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_linkedin_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_linkedin_lazy_load";

	var $buttonLayout = array(
		"Normal" => "top",
		"Compact" => "right",
		"NoCount" => "none" 
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "top",
		"Compact" => "right",
		"NoCount" => "none" 
	);
	
	var $isEncodeRequired = false;
	
    public function DD_Linkedin() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    } 
    
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(self::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}






// NON-DEFAULTS

/******************************************************************************************
 * 
 * Pinterest
 * http://pinterest.com/about/goodies/#button_for_websites
 *
 */
class DD_Pinterest extends BaseDD{
	const NAME = "Pinterest";
	const URL_WEBSITE = "http://pinterest.com";
	const URL_API = "http://pinterest.com/about/goodies/#button_for_websites";
	const DEFAULT_BUTTON_WEIGHT = "10";

	const BASEURL = '<a href="http://pinterest.com/pin/create/button/?url=VOTE_URL&description=VOTE_TITLE&media=VOTE_IMAGE" class="pin-it-button" count-layout="VOTE_BUTTON_DESIGN"></a><script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>';
	const BASEURL_LAZY = '<a href="http://pinterest.com/pin/create/button/?url=VOTE_URL&description=VOTE_TITLE&media=VOTE_IMAGE" class="pin-it-button dd-pinterest-ajax-load dd-pinterest-POST_ID" count-layout="VOTE_BUTTON_DESIGN"></a>';
	const BASEURL_LAZY_SCRIPT = "function loadPinterest_POST_ID(){ jQuery(document).ready(function(\$) { \$.getScript('http://assets.pinterest.com/js/pinit.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadPinterest_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
    
	const OPTION_APPEND_TYPE = "dd_pinterest_appendType";
	const OPTION_BUTTON_DESIGN = "dd_pinterest_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_pinterest_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_pinterest_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_pinterest_lazy_load";
	
	var $buttonLayout = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none" 
	);
	
    public function DD_Pinterest() {

		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }

	//construct base URL, based on $lazy value
 	public function constructURL($url, $title, $button, $postId, $lazy, $globalcfg = ''){
 		//rawurlencode - replace space with %20
    	//urlencode - replace space with + 
 		if($this->isEncodeRequired) {
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
    	if($lazy==DD_EMPTY_VALUE || $lazy==false){
    		$this->constructNormalURL($url, $title,$button, $postId);
    	}else{
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    	}
    	
    }
    
	public function constructNormalURL($url, $title,$button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
		$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
		$finalURL = str_replace(parent::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(parent::VOTE_URL,$url,$finalURL);
    	
    	// If theme uses post thumbnails, grab the chosen thumbnail if not grab the first image attached to post
		if(current_theme_supports('post-thumbnails')){
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'full');
		} else {
			$image_args = array(
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_type'      => 'attachment',
				'post_parent'    => $postId,
				'post_mime_type' => 'image',
				'post_status'    => null,
				'numberposts'    => -1,
			);
			$attachments = get_posts($image_args);
		  	
		  	if ($attachments) {
		  		$thumb = wp_get_attachment_image_src($attachments[0]->ID, 'full');
		  	}	
		}
		
		if($thumb){
			$image = $thumb[0];
		} else {
			$image = '';
		}
		
		$finalURL = str_replace(parent::VOTE_IMAGE,$image,$finalURL);
    	$this->finalURL = $finalURL;
    }
    
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
		$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
		if(current_theme_supports('post-thumbnails')) $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'full' );
		else $thumb = false;
		if($thumb) $image = $thumb[0];
		else $image = '';
		$finalURL_lazy = str_replace(parent::VOTE_IMAGE,$image,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);

    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}

/******************************************************************************************
 * 
 * Flattr
 * http://developers.flattr.net/button/
 *
 */
class DD_Flattr extends BaseDD{
	const NAME = "Flattr";
	const URL_WEBSITE = "http://flattr.com";
	const URL_API = "http://developers.flattr.net/button/";
	const DEFAULT_BUTTON_WEIGHT = "10";

	const BASEURL = '<script src="http://api.flattr.com/js/0.6/load.js?mode=auto"></script><a class="FlattrButton" href="VOTE_URL" style="display:none;" title="VOTE_TITLE" data-flattr-uid="VOTE_FLATTR_UID" data-flattr-button="VOTE_BUTTON_DESIGN" data-flattr-category="text"></a>';
	const BASEURL_LAZY = '<a class="FlattrButton" href="VOTE_URL" style="display:none;" title="VOTE_TITLE" data-flattr-uid="VOTE_FLATTR_UID" data-flattr-button="VOTE_BUTTON_DESIGN" data-flattr-category="text"></a>';
	const BASEURL_LAZY_SCRIPT = "function loadFlattr_POST_ID(){ jQuery(document).ready(function(\$) { \$.getScript('http://api.flattr.com/js/0.6/load.js?mode=auto'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadFlattr_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";

	const OPTION_APPEND_TYPE = "dd_flattr_appendType";
	const OPTION_BUTTON_DESIGN = "dd_flattr_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_flattr_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_flattr_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_flattr_lazy_load";
	
	var $buttonLayout = array(
		"Normal" => "default",
		"Compact" => "compact"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "default",
		"Compact" => "compact"
	);
	
	const VOTE_FLATTR_UID = 'VOTE_FLATTR_UID';
	
    public function DD_Flattr() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL = self::BASEURL;
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }

	//construct base URL, based on $lazy value
 	public function constructURL($url, $title, $button, $postId, $lazy, $globalcfg = ''){
	
		$flattr_uid = 'flattr';
 		if($globalcfg!=''){
 			$flattr_uid = $globalcfg[DD_GLOBAL_FLATTR_OPTION][DD_GLOBAL_FLATTR_OPTION_UID];
			if(empty($flattr_uid)) $flattr_uid = 'flattr';
 		}

    	if($lazy==DD_EMPTY_VALUE || $lazy==false){
			$this->baseURL = str_replace(self::VOTE_FLATTR_UID, $flattr_uid, $this->baseURL);
    		$this->constructNormalURL($url, $title, $button, $postId);

    	}else{
    		$this->baseURL_lazy = str_replace(self::VOTE_FLATTR_UID, $flattr_uid, $this->baseURL_lazy);
    		$this->constructLazyLoadURL($url, $title, $button, $postId);
    	}
    	
    }
    
	public function constructNormalURL($url, $title, $button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
		$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
    	$this->finalURL = $finalURL;
    }

	public function constructLazyLoadURL($url, $title, $button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
		$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}


/******************************************************************************************
 * 
 * Facebook Like (IFrame)
 * 
 */
class DD_FbLike extends BaseIFrameDD{
	const NAME = "Facebook Like (IFrame)";
	const URL_WEBSITE = "http://www.facebook.com";
	const URL_API = "http://developers.facebook.com/docs/reference/plugins/like";
	const BASEURL = "<iframe src='http://www.facebook.com/plugins/like.php?href=VOTE_URL&amp;locale=FACEBOOK_LOCALE&amp;VOTE_BUTTON_DESIGN' scrolling='no' frameborder='0' style='border:none; overflow:hidden; EXTRA_VALUE' allowTransparency='true'></iframe>";
	
	const FB_LOCALES = "http://www.facebook.com/translations/FacebookLocales.xml";
	const DEFAULT_BUTTON_WEIGHT = "96";
	
	const OPTION_APPEND_TYPE = "dd_fblike_appendType";
	const OPTION_BUTTON_DESIGN = "dd_fblike_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_fblike_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_fblike_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_fblike_lazy_load";
	
	const BASEURL_LAZY = "<div class='dd-fblike-ajax-load dd-fblike-POST_ID'></div><iframe class=\"DD_FBLIKE_AJAX_POST_ID\" src='' height='0' width='0' scrolling='no' frameborder='0' allowTransparency='true'></iframe>";
	const BASEURL_LAZY_SCRIPT = " function loadFBLike_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-fblike-POST_ID').remove();\$('.DD_FBLIKE_AJAX_POST_ID').attr('width','VOTE_BUTTON_DESIGN_LAZY_WIDTH');\$('.DD_FBLIKE_AJAX_POST_ID').attr('height','VOTE_BUTTON_DESIGN_LAZY_HEIGHT');\$('.DD_FBLIKE_AJAX_POST_ID').attr('src','http://www.facebook.com/plugins/like.php?href=VOTE_URL&amp;locale=FACEBOOK_LOCALE&amp;VOTE_BUTTON_DESIGN'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadFBLike_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	const LIKE_STANDARD = "layout=standard&amp;action=like&amp;width=350&amp;height=24&amp;colorscheme=light"; //350x24
	const LIKE_BUTTON_COUNT= "layout=button_count&amp;action=like&amp;width=92&amp;height=20&amp;colorscheme=light"; //92x20
	const LIKE_BOX_COUNT= "layout=box_count&amp;action=like&amp;width=50&amp;height=60&amp;colorscheme=light"; //50x60
	const RECOMMEND_STANDARD = "layout=standard&amp;action=recommend&amp;width=400&amp;height=24&amp;colorscheme=light"; //400x24
	const RECOMMEND_BUTTON_COUNT= "layout=button_count&amp;action=recommend&amp;width=130&amp;height=20&amp;colorscheme=light"; //130x20
	const RECOMMEND_BOX_COUNT= "layout=box_count&amp;action=recommend&amp;width=90&amp;height=60&amp;colorscheme=light"; //90x60

	const EXTRA_VALUE = "EXTRA_VALUE";
	const FACEBOOK_LOCALE = "FACEBOOK_LOCALE";
	
	var $float_button_design = "Like Box Count";
	
	var $buttonLayout = array(
		"Like Standard" => self::LIKE_STANDARD,
		"Like Button Count" => self::LIKE_BUTTON_COUNT,
		"Like Box Count" => self::LIKE_BOX_COUNT,
		"Recommend Standard" => self::RECOMMEND_STANDARD,
		"Recommend Button Count" => self::RECOMMEND_BUTTON_COUNT,
		"Recommend Box Count" => self::RECOMMEND_BOX_COUNT
	);
    
	var $buttonLayoutLazy = array(
		"Like Standard" => self::LIKE_STANDARD,
		"Like Button Count" => self::LIKE_BUTTON_COUNT,
		"Like Box Count" => self::LIKE_BOX_COUNT,
		"Recommend Standard" => self::RECOMMEND_STANDARD,
		"Recommend Button Count" => self::RECOMMEND_BUTTON_COUNT,
		"Recommend Box Count" => self::RECOMMEND_BOX_COUNT
	);
	
	var $buttonLayoutWidthHeight = array(
		"Like Standard" => "width:500px; height:24px;",
		"Like Button Count" => "width:92px; height:20px;",
		"Like Box Count" => "width:50px; height:62px;",
		"Recommend Standard" => "width:500px; height:24px;",
		"Recommend Button Count" => "width:130px; height:20px;",
		"Recommend Box Count" => "width:90px; height:60px;"
	);
	
	var $buttonLayoutLazyWidth = array(
		"Like Standard" => "500",
		"Like Button Count" => "92",
		"Like Box Count" => "50",
		"Recommend Standard" => "500",
		"Recommend Button Count" => "130",
		"Recommend Box Count" => "90"
	);
    
    var $buttonLayoutLazyHeight = array(
		"Like Standard" => "24",
		"Like Button Count" => "20",
		"Like Box Count" => "62",
		"Recommend Standard" => "24",
		"Recommend Button Count" => "20",
		"Recommend Box Count" => "60"
	);
	
    public function DD_FbLike() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    } 
    
    public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);	
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	
    	//add new line
    	//convert &amp; to &
    	$finalURL_lazy_script = str_replace("&amp;","&",$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
	public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){
    	
 		if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
 		$facebook_locale = '';
 		if($globalcfg!=''){
 			$facebook_locale = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_LOCALE]; 
 		}
	
    	if($lazy==DD_EMPTY_VALUE){

    		$this->baseURL = str_replace(self::FACEBOOK_LOCALE,$facebook_locale,$this->baseURL);
    		$this->constructNormalURL($url, $title,$button, $postId);
    		
    	}else{

    		$this->baseURL_lazy_script = str_replace(self::FACEBOOK_LOCALE,$facebook_locale,$this->baseURL_lazy_script);
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    		
    	}
    	
    }
    
}


/******************************************************************************************
 *  
 * http://www.digg.com
 *
 */
class DD_Digg extends BaseDD{
	
}


/******************************************************************************************
 * 
 * http://www.reddit.com
 *
 */
class DD_Reddit extends BaseIFrameDD{
	
	const NAME = "Reddit";
	const URL_WEBSITE = "http://www.reddit.com";
	const URL_API = "http://www.reddit.com/buttons/";
	const DEFAULT_BUTTON_WEIGHT = "99";
	
	const BASEURL = "<iframe src=\"http://www.reddit.com/static/button/VOTE_BUTTON_DESIGN&url=VOTE_URL&title=VOTE_TITLE&newwindow='1'\" EXTRA_VALUE scrolling='no' frameborder='0'></iframe>";
	
	const BASEURL_LAZY = "<div class='dd-reddit-ajax-load dd-reddit-POST_ID'></div><iframe class='DD_REDDIT_AJAX_POST_ID' src='' height='0' width='0' scrolling='no' frameborder='0'></iframe>";
	const BASEURL_LAZY_SCRIPT = " function loadReddit_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-reddit-POST_ID').remove();\$('.DD_REDDIT_AJAX_POST_ID').attr('width','VOTE_BUTTON_DESIGN_LAZY_WIDTH');\$('.DD_REDDIT_AJAX_POST_ID').attr('height','VOTE_BUTTON_DESIGN_LAZY_HEIGHT');\$('.DD_REDDIT_AJAX_POST_ID').attr('src','http://www.reddit.com/static/button/VOTE_BUTTON_DESIGN&url=VOTE_URL&title=VOTE_TITLE&newwindow=1'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadReddit_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	const OPTION_APPEND_TYPE = "dd_reddit_appendType";
	const OPTION_BUTTON_DESIGN = "dd_reddit_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_reddit_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_reddit_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_reddit_lazy_load";
	
	var $buttonLayout = array(
		"Normal" => "button2.html?width=51", 
		"Compact" => "button1.html?width=120", 
		"Icon" => "button3.html?width=69"
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => "button2.html?width=51", 
		"Compact" => "button1.html?width=120", 
		"Icon" => "button3.html?width=69"
	);
	
	var $buttonLayoutLazyWidth = array(
		"Normal" => "51",
		"Compact" => "120",
		"Icon" => "69"
	);
    
    var $buttonLayoutLazyHeight = array(
		"Normal" => "69",
		"Compact" => "22",
    	"Icon" => "52"
	);
	
	var $buttonLayoutWidthHeight = array(
		"Normal" => "height=\"69\" width=\"51\"",
		"Compact" => "height=\"22\" width=\"120\"",
		"Icon" => "height=\"52\" width=\"69\""
	);
	
	public function DD_Reddit() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
			
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    }
    
}

/******************************************************************************************
 * 
 * http://www.google.com/buzz
 *
 */
class DD_GBuzz extends BaseDD{
}

/******************************************************************************************
 * 
 * http://www.dzone.com
 *
 */
class DD_DZone extends BaseDD{
	
	const NAME = "DZone";
	const URL_WEBSITE = "http://www.dzone.com";
	const URL_API = "http://www.dzone.com/links/buttons.jsp";
	const BASEURL = "<iframe src='http://widgets.dzone.com/links/widgets/zoneit.html?url=VOTE_URL&amp;title=VOTE_TITLE&amp;t=VOTE_BUTTON_DESIGN frameborder='0' scrolling='no'></iframe>";
	
	const BASEURL_LAZY = "<div class='dd-dzone-ajax-load dd-dzone-POST_ID'></div><iframe class='DD_DZONE_AJAX_POST_ID' src='' height='0' width='0' scrolling='no' frameborder='0'></iframe>";
	const BASEURL_LAZY_SCRIPT = " function loadDzone_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-dzone-POST_ID').remove();\$('.DD_DZONE_AJAX_POST_ID').attr('width','VOTE_BUTTON_DESIGN_LAZY_WIDTH');\$('.DD_DZONE_AJAX_POST_ID').attr('height','VOTE_BUTTON_DESIGN_LAZY_HEIGHT');\$('.DD_DZONE_AJAX_POST_ID').attr('src','http://widgets.dzone.com/links/widgets/zoneit.html?url=VOTE_URL&title=VOTE_TITLE&t=VOTE_BUTTON_DESIGN'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadDzone_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	const OPTION_APPEND_TYPE = "dd_dzone_appendType";
	const OPTION_BUTTON_DESIGN = "dd_dzone_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_dzone_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_dzone_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_dzone_lazy_load";
	
	const DEFAULT_BUTTON_WEIGHT = "97";

	var $buttonLayout = array(
		"Normal" => "1' height='70' width='50'", 
		"Compact" => "2' height='25' width='155'"
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => "1", 
		"Compact" => "2"
	);
	
	var $buttonLayoutLazyWidth = array(
		"Normal" => "50",
		"Compact" => "155"
	);
    
    var $buttonLayoutLazyHeight = array(
		"Normal" => "70",
		"Compact" => "25"
	);
	
    public function DD_DZone() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    } 
  
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}

/******************************************************************************************
 * 
 * http://www.facebook.com
 * FB share API is missing from Facebook.com, all redirect to FB Like API?
 */
class DD_FbShare extends BaseDD{
	
	const NAME = "Facebook Share";
	const URL_WEBSITE = "http://www.facebook.com";
	const URL_API = "http://www.facebook.com/share/";
	const BASEURL = "<a name='fb_share' type='VOTE_BUTTON_DESIGN' share_url='VOTE_URL' href='http://www.facebook.com/sharer.php'></a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";
	const DEFAULT_BUTTON_WEIGHT = "95";
	
	const OPTION_APPEND_TYPE = "dd_fbshare_appendType";
	const OPTION_BUTTON_DESIGN = "dd_fbshare_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_fbshare_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_fbshare_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_fbshare_lazy_load";
	
	const BASEURL_LAZY = "<div class='dd-fbshare-ajax-load dd-fbshare-POST_ID'></div><a class='DD_FBSHARE_AJAX_POST_ID' name='fb_share' type='VOTE_BUTTON_DESIGN' share_url='VOTE_URL' href='http://www.facebook.com/sharer.php'></a>";
	const BASEURL_LAZY_SCRIPT = " function loadFBShare_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-fbshare-POST_ID').remove(); \$.getScript('http://static.ak.fbcdn.net/connect.php/js/FB.Share'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadFBShare_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	var $buttonLayout = array(
		"Normal" => "box_count",
		"Compact" => "button_count"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "box_count",
		"Compact" => "button_count"
	);
	
	var $isEncodeRequired = false;
	
    public function DD_FbShare() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }
 
	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(self::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}

/******************************************************************************************
 * 
 * http://www.fbshare.me
 * 
 */
class DD_FbShareMe extends BaseDD{
	
	const NAME = "fbShare.me";
	const URL_WEBSITE = "http://www.fbshare.me";
	const URL_API = "http://www.fbshare.me";
	const DEFAULT_BUTTON_WEIGHT = "94";
	
	const BASEURL = "<script>var fbShare = {url: 'VOTE_URL',size: 'VOTE_BUTTON_DESIGN',}</script><script src='http://widgets.fbshare.me/files/fbshare.js'></script>";

	const OPTION_APPEND_TYPE = "dd_fbshareme_appendType";
	const OPTION_BUTTON_DESIGN = "dd_fbshareme_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_fbshareme_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_fbshareme_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_fbshareme_lazy_load";

	const BASEURL_LAZY = "<div class='dd-fbshareme-ajax-load dd-fbshareme-POST_ID'></div><iframe class=\"DD_FBSHAREME_AJAX_POST_ID\" src='' height='0' width='0' scrolling='no' frameborder='0' allowtransparency='true'></iframe>";
	const BASEURL_LAZY_SCRIPT = " function loadFBShareMe_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-fbshareme-POST_ID').remove();\$('.DD_FBSHAREME_AJAX_POST_ID').attr('width','VOTE_BUTTON_DESIGN_LAZY_WIDTH');\$('.DD_FBSHAREME_AJAX_POST_ID').attr('height','VOTE_BUTTON_DESIGN_LAZY_HEIGHT');\$('.DD_FBSHAREME_AJAX_POST_ID').attr('src','http://widgets.fbshare.me/files/fbshare.php?url=VOTE_URL&size=VOTE_BUTTON_DESIGN');  }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadFBShareMe_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	var $buttonLayout = array(
		"Normal" => "large",
		"Compact" => "small"
	);
    
	var $buttonLayoutLazy = array(
		"Normal" => "large",
		"Compact" => "small"
	);
	
	var $buttonLayoutLazyWidth = array(
		"Normal" => "53",
		"Compact" => "80"
	);
    
    var $buttonLayoutLazyHeight = array(
		"Normal" => "69",
		"Compact" => "18"
	);
	
	var $isEncodeRequired = false;
	
    public function DD_FbShareMe() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;

		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
      
    }
 
    public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(self::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(self::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(self::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(self::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
    
}




/******************************************************************************************
 * 
 * http://www.delicious.com
 * 
 */
class DD_Delicious extends BaseDD{
	
	const NAME = "Delicious";
	const URL_WEBSITE = "http://www.delicious.com";
	const URL_API = "http://www.delicious.com/help/feeds";
	const DEFAULT_BUTTON_WEIGHT = "93";
	
	const BASEURL = "<div class='VOTE_BUTTON_DESIGN dd_delicious'><a class='VOTE_BUTTON_DESIGN' href='http://delicious.com/save' onclick=\"window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url='+encodeURIComponent('VOTE_URL')+'&amp;title='+encodeURIComponent('VOTE_TITLE'),'delicious', 'toolbar=no,width=550,height=550'); return false;\"><span id='DD_DELICIOUS_AJAX_POST_ID'><div style='padding-top:3px'>SAVED_COUNT</div></span></a></div>";
	
	const OPTION_APPEND_TYPE = "dd_delicious_appendType";
	const OPTION_BUTTON_DESIGN = "dd_delicious_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_delicious_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_delicious_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_delicious_lazy_load";

	const BASEURL_LAZY = "<div class='VOTE_BUTTON_DESIGN dd_delicious'><a href='http://delicious.com/save' onclick=\"window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url='+encodeURIComponent('VOTE_URL')+'&amp;title='+encodeURIComponent('VOTE_TITLE'),'delicious', 'toolbar=no,width=550,height=550'); return false;\"><span id='DD_DELICIOUS_AJAX_POST_ID'>SAVED_COUNT</span></a></div>";
	const BASEURL_LAZY_SCRIPT = " function loadDelicious_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-delicious-POST_ID').remove();\$.getJSON('http://feeds.delicious.com/v2/json/urlinfo/data?url=VOTE_URL&amp;callback=?',function(data) {var msg ='';var count = 0;if (data.length > 0) {count = data[0].total_posts;if(count ==0){msg = '0';}else if(count ==1){msg = '1';}else{msg = count}}else{msg = '0';}\$('#DD_DELICIOUS_AJAX_POST_ID').text(msg);}); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadDelicious_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	const SAVED_COUNT = "SAVED_COUNT";

	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => DD_PLUGIN_STYLE_DELICIOUS,
		"Compact" => DD_PLUGIN_STYLE_DELICIOUS_COMPACT
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => DD_PLUGIN_STYLE_DELICIOUS,
		"Compact" => DD_PLUGIN_STYLE_DELICIOUS_COMPACT
	);
	
    public function DD_Delicious() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    }  

	public function constructNormalURL($url, $title,$button, $postId){
		
		$count = '';
    	$shareUrl = urlencode($url);
		$deliciousStats = json_decode(wp_remote_retrieve_body(wp_remote_get('http://feeds.delicious.com/v2/json/urlinfo/data?url='.$shareUrl)));
		
		if(!empty($deliciousStats)){
			if($deliciousStats->total_posts == 0) {
			    $count = '0';
			} elseif($deliciousStats->total_posts == 1) {
			    $count = '1';
			} else {
			    $count = $deliciousStats->total_posts;
			}
		}else{
			$count = '0';
		}
		
		$finalURL = $this->baseURL;
    	$finalURL = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(parent::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(parent::VOTE_URL,$url,$finalURL);
    	$finalURL = str_replace(self::SAVED_COUNT,$count,$finalURL);
    	
    	$this->finalURL = $finalURL;
    }
   
    public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	//add new line
    	$finalURL_lazy = str_replace(self::SAVED_COUNT,'',$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN_LAZY_WIDTH,$this->getButtonDesignLazyWidth($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN_LAZY_HEIGHT,$this->getButtonDesignLazyHeight($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_TITLE,$title,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::VOTE_URL,$url,$finalURL_lazy_script);
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    }
}

/******************************************************************************************
 * 
 * http://www.stumbleupon.com
 * 
 */
class DD_StumbleUpon extends BaseDD{
	
	const NAME = "Stumbleupon";
	const URL_WEBSITE = "http://www.stumbleupon.com";
	const URL_API = "http://www.stumbleupon.com/badges/";
	const BASEURL = "<script src='http://www.stumbleupon.com/hostedbadge.php?s=VOTE_BUTTON_DESIGN&amp;r=VOTE_URL'></script>";
	const DEFAULT_BUTTON_WEIGHT = "97";
	
	const OPTION_APPEND_TYPE = "dd_stumbleupon_appendType";
	const OPTION_BUTTON_DESIGN = "dd_stumbleupon_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_stumbleupon_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_stumbleupon_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_stumbleupon_lazy_load";

	var $islazyLoadAvailable = false;
	
	var $buttonLayout = array(
		"Normal" => "5",
		"Compact" => "1"
	);
	
    public function DD_StumbleUpon() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    }
    
}

/******************************************************************************************
 * 
 * http://buzz.yahoo.com
 * 
 */
class DD_YBuzz extends BaseDD{

	const NAME = "Yahoo Buzz";
	const URL_WEBSITE = "http://buzz.yahoo.com";
	const URL_API = "http://buzz.yahoo.com/buttons";
	const DEFAULT_BUTTON_WEIGHT = "90";
	
	const BASEURL = "<script type='text/javascript'>yahooBuzzArticleHeadline=\"VOTE_TITLE\";yahooBuzzArticleId=\"VOTE_URL\";</script><script type='text/javascript' src='http://d.yimg.com/ds/badge2.js' badgetype='VOTE_BUTTON_DESIGN'></script>";
	
	const OPTION_APPEND_TYPE = "dd_ybuzz_appendType";
	const OPTION_BUTTON_DESIGN = "dd_ybuzz_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_ybuzz_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_ybuzz_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_ybuzz_lazy_load";
	
	var $islazyLoadAvailable = false;
	
	var $buttonLayout = array(
		"Normal" => "square",
		"Compact" => "small-votes",
		"Compact_Text" => "text-votes"
	);
	
	var $isEncodeRequired = false;
	
    public function DD_YBuzz() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    } 
    
}

/******************************************************************************************
 * 
 * http://www.blogengage.com
 * 
 */
class DD_BlogEngage extends BaseDD{

	const NAME = "BlogEngage";
	const URL_WEBSITE = "http://www.blogengage.com";
	const URL_API = "http://www.blogengage.com/profile_promo.php";
	const DEFAULT_BUTTON_WEIGHT = "84";
	
	const BASEURL = "<script type='text/javascript'>submit_url = 'VOTE_URL';</script><script src='http://blogengage.com/evb/VOTE_BUTTON_DESIGN'></script>";
  
	const OPTION_APPEND_TYPE = "dd_blogengage_appendType";
	const OPTION_BUTTON_DESIGN = "dd_blogengage_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_blogengage_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_blogengage_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_blogengage_lazy_load";
	
	var $islazyLoadAvailable = false;
	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => "button4.php"
	);
	
    public function DD_BlogEngage() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
         parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    } 
    
}  

/******************************************************************************************
 * 
 * http://www.designbump.com
 * 
 */
class DD_DesignBump extends BaseDD{
	
	const NAME = "DesignBump";
	const URL_WEBSITE = "http://www.designbump.com";
	const URL_API = "http://designbump.com/content/evb";
	const DEFAULT_BUTTON_WEIGHT = "87";

	const BASEURL = "<script type='text/javascript'>url_site='VOTE_URL'; </script> <script src='http://designbump.com/sites/all/modules/drigg_external/js/button.js' type='text/javascript'></script>";
	
	const OPTION_APPEND_TYPE = "dd_designbump_appendType";
	const OPTION_BUTTON_DESIGN = "dd_designbump_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_designbump_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_designbump_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_designbump_lazy_load";
	
	var $islazyLoadAvailable = false;
	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => "Normal"
	);
	
    public function DD_DesignBump() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);

    } 
    
}

/******************************************************************************************
 * 
 * http://www.thewebblend.com
 * 
 */
class DD_TheWebBlend extends BaseDD{

	const NAME = "TheWebBlend";
	const URL_WEBSITE = "http://www.thewebblend.com";
	const URL_API = "http://thewebblend.com/tools/vote";
	const DEFAULT_BUTTON_WEIGHT = "85";

	const BASEURL = "<script type='text/javascript'>url_site='VOTE_URL'; VOTE_BUTTON_DESIGN</script><script src='http://thewebblend.com/sites/all/modules/drigg_external/js/button.js' type='text/javascript'></script>";
	
	const OPTION_APPEND_TYPE = "dd_webblend_appendType";
	const OPTION_BUTTON_DESIGN = "dd_webblend_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_webblend_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_webblend_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_webblend_lazy_load";
	
	var $islazyLoadAvailable = false;
	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => "",
		"Compact" => "badge_size='compact';"
	);
	
    public function DD_TheWebBlend() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    }    
}

/******************************************************************************************
 * 
 * http://www.tweetmeme.com/
 * 
 */
class DD_TweetMeme extends BaseDD{
	
	const NAME = "TweetMeme";
	const URL_WEBSITE = "http://www.tweetmeme.com/";
	const URL_API = "http://wordpress.org/extend/plugins/tweetmeme/";
	const DEFAULT_BUTTON_WEIGHT = "97";
	
	const BASEURL ="<iframe src='http://api.tweetmeme.com/button.js?url=VOTE_URL&source=VOTE_SOURCE&service=VOTE_SERVICE_NAME&service_api=VOTE_SERVICE_API&style=VOTE_BUTTON_DESIGN frameborder='0' scrolling='no'></iframe>";
	const OPTION_APPEND_TYPE = "dd_tweetmeme_appendType";
	const OPTION_BUTTON_DESIGN = "dd_tweetmeme_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_tweetmeme_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_tweetmeme_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_tweetmeme_lazy_load";
	
	const BASEURL_LAZY = "<div class='dd-tweetmeme-ajax-load dd-tweetmeme-POST_ID'></div><iframe class='DD_TWEETMEME_AJAX_POST_ID' src='' height='0' width='0' scrolling='no' frameborder='0'></iframe>";
	const BASEURL_LAZY_SCRIPT = " function loadTweetMeme_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-tweetmeme-POST_ID').remove();\$('.DD_TWEETMEME_AJAX_POST_ID').attr('width','VOTE_BUTTON_DESIGN_LAZY_WIDTH');\$('.DD_TWEETMEME_AJAX_POST_ID').attr('height','VOTE_BUTTON_DESIGN_LAZY_HEIGHT');\$('.DD_TWEETMEME_AJAX_POST_ID').attr('src','http://api.tweetmeme.com/button.js?url=VOTE_URL&source=VOTE_SOURCE&style=VOTE_BUTTON_DESIGN&service=VOTE_SERVICE_NAME&service_api=VOTE_SERVICE_API'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadTweetMeme_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";
	
	var $buttonLayout = array(
		"Normal" => "normal' height='61' width='50'",
		"Compact" => "compact' height='20' width='90'"
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => "normal",
		"Compact" => "compact"
	);
	
	var $buttonLayoutLazyWidth = array(
		"Normal" => "50",
		"Compact" => "90"
	);
    
    var $buttonLayoutLazyHeight = array(
		"Normal" => "61",
		"Compact" => "20"
	);
	
	var $isEncodeRequired = false;
     
	const VOTE_SOURCE = "VOTE_SOURCE";
	const VOTE_SERVICE_NAME = "VOTE_SERVICE_NAME";
	const VOTE_SERVICE_API = "VOTE_SERVICE_API";
	
    public function DD_TweetMeme() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;

		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    } 
    
	public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){
    	
 		if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
 		$source = '';
 		$service = '';
 		$serviceapi = '';
 		
 		if($globalcfg!=''){
 			$source = $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SOURCE]; 
 			$service = $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE];
 			$serviceapi = $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API];
 		}

    	if($lazy==DD_EMPTY_VALUE){

    		$this->baseURL = str_replace(self::VOTE_SOURCE,$source,$this->baseURL);
    		$this->baseURL = str_replace(self::VOTE_SERVICE_NAME,$service,$this->baseURL);
    		$this->baseURL = str_replace(self::VOTE_SERVICE_API,$serviceapi,$this->baseURL);
    	
    		$this->constructNormalURL($url, $title,$button, $postId);
    		
    	}else{

    		$this->baseURL_lazy_script = str_replace(self::VOTE_SOURCE,$source,$this->baseURL_lazy_script);
    		$this->baseURL_lazy_script = str_replace(self::VOTE_SERVICE_NAME,$service,$this->baseURL_lazy_script);
    		$this->baseURL_lazy_script = str_replace(self::VOTE_SERVICE_API,$serviceapi,$this->baseURL_lazy_script);
    	
    		$this->constructLazyLoadURL($url, $title,$button, $postId);
    	}
    	
    }
    
}

/******************************************************************************************
 * 
 * http://www.topsy.com
 * 
 */
class DD_Topsy extends BaseDD{
	
	const NAME = "Topsy";
	const URL_WEBSITE = "http://www.topsy.com";
	const URL_API = "http://labs.topsy.com/button/retweet-button/";
	const DEFAULT_BUTTON_WEIGHT = "96";
	
	const BASEURL = "<script type=\"text/javascript\" src=\"http://cdn.topsy.com/topsy.js?init=topsyWidgetCreator\"></script><div class=\"topsy_widget_data\"><!--{\"url\":\"VOTE_URL\",\"style\":\"VOTE_BUTTON_DESIGN\",\"theme\":\"VOTE_THEME\",\"nick\":\"VOTE_SOURCE\"}--></div>";

	const OPTION_APPEND_TYPE = "dd_topsy_appendType";
	const OPTION_BUTTON_DESIGN = "dd_topsy_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_topsy_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_topsy_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_topsy_lazy_load";

	const VOTE_SOURCE = "VOTE_SOURCE";
	const VOTE_THEME = "VOTE_THEME";
	
	var $islazyLoadAvailable = false;
	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => "big",
		"Compact" => "compact"
	);
	
    public function DD_Topsy() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;

		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    } 
    
    public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = ''){

    	if($this->isEncodeRequired){
 			$title = rawurlencode($title);
    		$url = rawurlencode($url);
 		}
 		
 		$source = '';
 		$theme = '';
 		
 		if($globalcfg!=''){
 			$source = $globalcfg[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_SOURCE]; 
 			$theme = $globalcfg[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_THEME];
 		}
 		
    	$finalURL = '';
    	$finalURL = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$this->baseURL);
    	$finalURL = str_replace(parent::VOTE_URL,$url,$finalURL);
    	$finalURL = str_replace(self::VOTE_SOURCE,$source,$finalURL);
    	$finalURL = str_replace(self::VOTE_THEME,$theme,$finalURL);
    
    	$this->finalURL = $finalURL;

    }
    
}

/******************************************************************************************
 * 
 * Post comments
 * 
 */
class DD_Comments extends BaseDD{

	const NAME = "Comments";
	const URL_WEBSITE = "http://none";
	const URL_API = "http://none";
	const DEFAULT_BUTTON_WEIGHT = "88";
	
	const BASEURL = "<div id='dd_comments'><a class='clcount' href=VOTE_URL><span class='ctotal'>COMMENTS_COUNT</span></a><a class='clink' href=VOTE_URL></a></div>";
	
	const OPTION_APPEND_TYPE = "dd_comments_appendType";
	const OPTION_BUTTON_DESIGN = "dd_comments_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_comments_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_comments_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_comments_lazy_load";
	
	const COMMENTS_COUNT = "COMMENTS_COUNT";
	const COMMENTS_RESPONSE_ID = "#respond";
	
	var $islazyLoadAvailable = false;
	
	var $buttonLayout = array(
		"Normal" => "Normal",
	);
    
    public function DD_Comments() {
    	
    	$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    }     
    
    public function constructURL($url, $title,$button, $postId, $lazy, $globalcfg = '', $commentcount = ''){
    	$result = '';
    	
    	$url = $url . self::COMMENTS_RESPONSE_ID;
    	$result = str_replace(self::VOTE_URL,$url,$this->baseURL);
    	$result = str_replace(self::COMMENTS_COUNT,$commentcount,$result);
    	
    	$this->finalURL = $result;
    }
    
}

/******************************************************************************************
 * 
 * http://www.serpd.com
 * 
 */
class DD_Serpd extends BaseDD{
	
	const NAME = "Serpd";
	const URL_WEBSITE = "http://www.serpd.com";
	const URL_API = "http://www.serpd.com/widgets/";
	const BASEURL = "<script type=\"text/javascript\">submit_url = \"VOTE_URL\";</script><script type=\"text/javascript\" src=\"http://www.serpd.com/index.php?page=evb\"></script>";
	
	const OPTION_APPEND_TYPE = "dd_serpd_appendType";
	const OPTION_BUTTON_DESIGN = "dd_serpd_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_serpd_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_serpd_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_serpd_lazy_load";
	
	const DEFAULT_BUTTON_WEIGHT = "86";
	
	var $islazyLoadAvailable = false;
	var $isEncodeRequired = false;
	
	var $buttonLayout = array(
		"Normal" => "",
	);
	
    public function DD_Serpd() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
    }    
}


/******************************************************************************************
 * 
 * Pocket
 * 
 */
class DD_Pocket extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Normal';
	var $lazy_load = false;
	
	const NAME = "Pocket";
	const URL_WEBSITE = "http://www.getpocket.com";
	const URL_API = "https://getpocket.com/publisher/button";
	const DEFAULT_BUTTON_WEIGHT = "93";

	const BASEURL ="<a data-pocket-label=\"pocket\" data-pocket-count=\"VOTE_BUTTON_DESIGN\" data-save-url=\"VOTE_URL\" class=\"pocket-btn\" data-lang=\"en\"></a><script type=\"text/javascript\">!function(d,i){if(!d.getElementById(i)){var j=d.createElement(\"script\");j.id=i;j.src=\"https://widgets.getpocket.com/v1/j/btn.js?v=1\";var w=d.getElementById(i);d.body.appendChild(j);}}(document,\"pocket-btn-js\");</script>";
	
	const OPTION_APPEND_TYPE = "dd_pocket_appendType";
	const OPTION_BUTTON_DESIGN = "dd_pocket_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_pocket_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_pocket_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_pocket_lazy_load";
	
	const BASEURL_LAZY ="<div class='dd-pocket-ajax-load dd-pocket-POST_ID'></div><a data-pocket-label=\"pocket\" data-pocket-count=\"VOTE_BUTTON_DESIGN\" class=\"pocket-btn\" data-lang=\"en\"></a>";
	const BASEURL_LAZY_SCRIPT = " function loadPocket_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-pocket-POST_ID').remove();\$.getScript('https://widgets.getpocket.com/v1/j/btn.js?v=1'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadPocket_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";

	var $buttonLayout = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none"
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => "vertical",
		"Compact" => "horizontal",
		"No Count" => "none"
	);
	
	var $isEncodeRequired = false;
	
	const VOTE_SOURCE = "VOTE_SOURCE";
	
    public function DD_Pocket() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    }
    
    public function constructNormalURL($url, $title, $button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
		$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
    	$this->finalURL = $finalURL;
    }

	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
}



/******************************************************************************************
 * 
 * Tumblr
 * 
 */
class DD_Tumblr extends BaseDD{
	var $append_type = 'left_float';
	var $button_design = 'Normal';
	var $lazy_load = false;
	
	const NAME = "Tumblr";
	const URL_WEBSITE = "http://www.tumblr.com";
	const URL_API = "http://www.tumblr.com/buttons";
	const DEFAULT_BUTTON_WEIGHT = "94";

	const BASEURL ='<a href="http://www.tumblr.com/share?link=VOTE_URL" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">Share on Tumblr</a><script src="http://platform.tumblr.com/v1/share.js"></script>';
	
	//<a data-pocket-label=\"pocket\" data-pocket-count=\"VOTE_BUTTON_DESIGN\" data-save-url=\"VOTE_URL\" class=\"pocket-btn\" data-lang=\"en\"></a>
	
	const OPTION_APPEND_TYPE = "dd_tumblr_appendType";
	const OPTION_BUTTON_DESIGN = "dd_tumblr_buttonDesign";
	const OPTION_BUTTON_WEIGHT = "dd_tumblr_button_weight";
	const OPTION_AJAX_LEFT_FLOAT = "dd_tumblr_ajax_left_float";
	const OPTION_LAZY_LOAD = "dd_tumblr_lazy_load";
	
	const BASEURL_LAZY ='<div class="dd-tumblrajax-load dd-tumblr-POST_ID"></div><a href="http://www.tumblr.com/share?link=VOTE_URL" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">Share on Tumblr</a>';
	const BASEURL_LAZY_SCRIPT = " function loadTumblr_POST_ID(){ jQuery(document).ready(function(\$) { \$('.dd-pocket-POST_ID').remove();\$.getScript('http://platform.tumblr.com/v1/share.js'); }); }";
	const SCHEDULER_LAZY_SCRIPT = "window.setTimeout('loadTumblr_POST_ID()',SCHEDULER_TIMER);";
	const SCHEDULER_LAZY_TIMER = "1000";

	var $buttonLayout = array(
		"Normal" => ""
	);
	
	var $buttonLayoutLazy = array(
		"Normal" => ""
	);
	
	var $isEncodeRequired = true;
	
	const VOTE_SOURCE = "VOTE_SOURCE";
	
    public function DD_Tumblr() {
    	
		$this->option_append_type = self::OPTION_APPEND_TYPE;
		$this->option_button_design = self::OPTION_BUTTON_DESIGN;
		$this->option_button_weight = self::OPTION_BUTTON_WEIGHT;
		$this->option_ajax_left_float = self::OPTION_AJAX_LEFT_FLOAT;
		$this->option_lazy_load = self::OPTION_LAZY_LOAD;
		
		$this->baseURL_lazy = self::BASEURL_LAZY;
    	$this->baseURL_lazy_script = self::BASEURL_LAZY_SCRIPT;
    	$this->scheduler_lazy_script = self::SCHEDULER_LAZY_SCRIPT;
    	$this->scheduler_lazy_timer = self::SCHEDULER_LAZY_TIMER;
    	
		$this->button_weight_value = self::DEFAULT_BUTTON_WEIGHT;
		
        parent::BaseDD(self::NAME, self::URL_WEBSITE, self::URL_API, self::BASEURL);
        
    }
    
    public function constructNormalURL($url, $title, $button, $postId){
		
    	$finalURL = $this->baseURL;
    	$finalURL = str_replace(self::VOTE_BUTTON_DESIGN,$this->getButtonDesign($button),$finalURL);
    	$finalURL = str_replace(self::VOTE_TITLE,$title,$finalURL);
    	$finalURL = str_replace(self::VOTE_URL,$url,$finalURL);
		$finalURL = str_replace(parent::POST_ID,$postId,$finalURL);
    	$this->finalURL = $finalURL;
    }

	public function constructLazyLoadURL($url, $title,$button, $postId){
    	
    	$finalURL_lazy = $this->baseURL_lazy;
    	$finalURL_lazy = str_replace(parent::VOTE_URL,$url,$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::VOTE_BUTTON_DESIGN,$this->getButtonDesignLazy($button),$finalURL_lazy);
    	$finalURL_lazy = str_replace(parent::POST_ID,$postId,$finalURL_lazy);
    	$this->finalURL_lazy = $finalURL_lazy;
    	
    	$finalURL_lazy_script = $this->baseURL_lazy_script;
    	$finalURL_lazy_script = str_replace(parent::POST_ID,$postId,$finalURL_lazy_script);
    	$this->finalURL_lazy_script = $finalURL_lazy_script;
    	
    	$final_scheduler_lazy_script = $this->scheduler_lazy_script;
    	$final_scheduler_lazy_script = str_replace(parent::SCHEDULER_TIMER,$this->scheduler_lazy_timer,$final_scheduler_lazy_script);
    	$final_scheduler_lazy_script = str_replace(parent::POST_ID,$postId,$final_scheduler_lazy_script);
    	$this->final_scheduler_lazy_script =  $final_scheduler_lazy_script;
    	
    }
}



?>
