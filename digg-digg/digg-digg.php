<?php
/*
 Plugin Name: Digg Digg
 Version: 5.3.6
 Plugin URI: http://bufferapp.com/diggdigg
 Author: Buffer
 Author URI: http://bufferapp.com/
 Description: Add a floating bar with share buttons to your blog. Just like Mashable!
              Help your posts get more shares, help yourself get more traffic.
              Simply Activate Digg Digg now to enhance your posts.
*/

define( 'DD_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

// fix for the W3 Total Cache bug (fixed in Digg Digg 5.1)
if( function_exists( 'w3tc_objectcache_flush' ) )
	w3tc_objectcache_flush();

require_once 'include/dd-global-variable.php';
require_once 'include/dd-printform.php';
require_once 'include/dd-helper.php';
require_once 'include/dd-manual.php';
require_once 'include/dd-upgrade.php';

//http://codex.wordpress.org/Function_Reference/register_activation_hook
//function to be run when the plugin is activated
register_activation_hook( __FILE__, 'dd_run_when_plugin_activated' );

add_action('init', 'dd_enable_required_js_in_wordpress' );
add_action( 'wp_enqueue_scripts', 'dd_wp_enqueue_styles' );
add_action( 'wp_head', 'dd_get_thumbnails_for_fb' );
add_filter( 'the_excerpt', 'dd_hook_wp_content' );
add_filter( 'the_content', 'dd_hook_wp_content' );

function dd_hook_wp_content($content = ''){
	if(dd_isThisPageExcluded($content)==true){
		return $content;
	}

	global $wp_query;
	$post = $wp_query->post; //get post content
	$id = $post->ID; //get post id
	$postlink = get_permalink($id); //get post link
	$commentcount = $post->comment_count; //get post comment count
	$title = trim($post->post_title); // get post title
	$link = explode(DD_DASH,$postlink); //split the link with '#', for comment link
	$url = $link[0];

	$dd_global_config = get_option(DD_GLOBAL_CONFIG);

	$ddNormalDisplay = get_option(DD_NORMAL_DISPLAY_CONFIG);
	$content = process_normal_button_display($ddNormalDisplay, $content, $url, $title, $id, $commentcount, $dd_global_config);

	$ddFloatDisplay = get_option(DD_FLOAT_DISPLAY_CONFIG);
	$content = process_floating_button_display($ddFloatDisplay, $content, $url, $title, $id, $commentcount, $dd_global_config);

	return $content;
}

function process_normal_button_display($ddNormalDisplay, $content, $url, $title, $id, $commentcount, $dd_global_config){

	if(isNormalButtonAllowDisplay($ddNormalDisplay)){

		$dd_normal_button_for_display = constructNormalButtons($url, $title, $id, $commentcount, $dd_global_config);
		$dd_line_up = getNormalButtonLineUpOption($ddNormalDisplay);
		$modified_content = integrateNormalButtonsIntoWpContent($dd_normal_button_for_display,$content,$dd_line_up);
		return $modified_content;

	}else{

		return $content;

	}

}

function isNormalButtonAllowDisplay($ddNormalDisplay){

	if($ddNormalDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON){
		if(dd_IsDisplayAllow($ddNormalDisplay)){
			return true;
		}
	}

}

function getNormalButtonLineUpOption($ddNormalDisplay){
	//horizontal or vertical
	return $ddNormalDisplay[DD_LINE_UP_OPTION][DD_LINE_UP_OPTION_SELECT];

}

function constructNormalButtons($url, $title, $id, $commentcount, $dd_global_config){

	$dd_display_buttons = get_option(DD_NORMAL_BUTTON);
	$dd_sorting_data = array();

	foreach(array_keys($dd_display_buttons[DD_NORMAL_BUTTON_FINAL]) as $key){

		$obj = $dd_display_buttons[DD_NORMAL_BUTTON_FINAL][$key];

		if($obj->name == "Comments"){

			$obj->constructURL($url,$title,$obj->getOptionButtonDesign(),$id, $obj->getOptionLazyLoad(), $dd_global_config,$commentcount);

		}else{

			$obj->constructURL($url,$title,$obj->getOptionButtonDesign(),$id, $obj->getOptionLazyLoad(), $dd_global_config);

		}

		$dd_sorting_data[$obj->getOptionButtonWeight().'-'.$obj->name] = $obj;
	}

	krsort($dd_sorting_data,SORT_NUMERIC);

	return $dd_sorting_data;

}

function integrateNormalButtonsIntoWpContent($dd_normal_button_for_display, $content, $dd_line_up){

	$dd_before_content = DD_EMPTY_VALUE;
	$dd_after_content = DD_EMPTY_VALUE;
	$dd_left_float = DD_EMPTY_VALUE;
	$dd_right_float = DD_EMPTY_VALUE;
	$dd_jQuery_script =DD_EMPTY_VALUE;
	$dd_scheduler_script =DD_EMPTY_VALUE;
	$scheduler = DD_EMPTY_VALUE;

	foreach($dd_normal_button_for_display as $obj){

		$finalURL=DD_EMPTY_VALUE;
		$name=$obj->name;

		if($obj->getOptionLazyLoad()==DD_EMPTY_VALUE){
			$finalURL=$obj->finalURL;
		}else{
			$finalURL=$obj->finalURL_lazy;
			$dd_jQuery_script.=$obj->finalURL_lazy_script;
			$dd_scheduler_script.=$obj->final_scheduler_lazy_script;
		}

		if($obj->getOptionAppendType() == DD_SELECT_LEFT_FLOAT){
			$dd_left_float .= generateNormalButtonDiv($finalURL,$dd_line_up,$name);

		}else if($obj->getOptionAppendType() == DD_SELECT_RIGHT_FLOAT){
			$dd_right_float .= generateNormalButtonDiv($finalURL,$dd_line_up,$name);

		}else if($obj->getOptionAppendType() == DD_SELECT_BEFORE_CONTENT){
			$dd_before_content .= generateNormalButtonDiv($finalURL,$dd_line_up,$name);

		}else if($obj->getOptionAppendType() == DD_SELECT_AFTER_CONTENT){
			$dd_after_content .= generateNormalButtonDiv($finalURL,$dd_line_up,$name);

		}

	}

	//combine all scripts and html tags for display
	if($dd_before_content!=DD_EMPTY_VALUE){
		$dd_before_content = "<div class='dd_post_share'><div class='dd_buttons'>" . $dd_before_content. "</div><div style='clear:both'></div></div><div style='clear:both'></div>";
	}

	if($dd_after_content!=DD_EMPTY_VALUE){
		$dd_after_content = "<div class='dd_post_share'><div class='dd_buttons'>" . $dd_after_content. "</div><div style='clear:both'></div></div>";
	}

	if($dd_left_float!=DD_EMPTY_VALUE){
		$dd_left_float = "<div class='dd_post_share dd_post_share_left'><div class='dd_buttons'>" . $dd_left_float. "</div></div>";
	}

	if($dd_right_float!=DD_EMPTY_VALUE){
		$dd_right_float = "<div class='dd_post_share dd_post_share_right'><div class='dd_buttons'>" . $dd_right_float. "</div></div>";
	}

	if($dd_jQuery_script!=DD_EMPTY_VALUE){
		$dd_jQuery_script = "<script type=\"text/javascript\">" . $dd_jQuery_script . "</script>";
	}

	if($dd_scheduler_script!=DD_EMPTY_VALUE){
		//$scheduler = "<script type=\"text/javascript\">function dd_init(){ jQuery(document).ready(function($) { " . $dd_scheduler_script . " }); }</script>";
		$scheduler = "<script type=\"text/javascript\"> jQuery(document).ready(function($) { " . $dd_scheduler_script . " }); </script>";
	}

	$content = $dd_left_float . $dd_right_float . $dd_before_content . $content . $dd_after_content . $scheduler . $dd_jQuery_script . DD_AUTHOR_SITE;

	return $content;

}

function generateNormalButtonDiv($finalURL, $dd_line_up,$name){

	$result ='';

	if($dd_line_up==DD_LINE_UP_OPTION_SELECT_HORIZONTAL){

		$result = "<div class='dd_button'>" .$finalURL. "</div>" ;

	}else if($dd_line_up==DD_LINE_UP_OPTION_SELECT_VERTICAL){

		//TODO:for facebook only?
		if ($name=="Facebook") {
			$result = "<div class='dd_button_v'>" . $finalURL . "</div><div style='clear:left'></div>" ;
		}
		else{
			$result = "<div class='dd_button_v'>" . $finalURL . "</div>" ;
		}

	}else{

		$result = "<div class='dd_button'>" . $finalURL . "</div>" ;

	}

	return $result;

}

function process_floating_button_display($ddFloatDisplay, $content, $url, $title, $id, $commentcount, $dd_global_config){

	if(isFloatingButtonAllowDisplay($ddFloatDisplay)){

		$dd_floating_button_for_display = constructFloatingButtons($url, $title, $id, $commentcount, $dd_global_config);
		$modified_content = integrateFloatingButtonsIntoWpContent($dd_floating_button_for_display, $content, $ddFloatDisplay);
		return $modified_content;

	}else{

		return $content;

	}

}

function isFloatingButtonAllowDisplay($ddFloatDisplay){

	if($ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON){
		if(is_home()){
			return false;
		}
		elseif(dd_IsDisplayAllow($ddFloatDisplay)){
			return true;
		}
	}

}

function constructFloatingButtons($url, $title, $id, $commentcount, $dd_global_config){

	$dd_display_buttons = get_option(DD_FLOAT_BUTTON);
	$dd_sorting_data = array();

	global $wp_query;
	//home, cat and looping post will caused post_count > 1
	if($wp_query->post_count > 1){
		//make sure the floating script only run once in home, cat or looping post
		if($wp_query->current_post==0){

			$dd_title = '';

			if(is_home()){
				$dd_title = get_bloginfo('description');
			}else{
				$dd_title = single_cat_title("",false);
			}

			foreach(array_keys($dd_display_buttons[DD_FLOAT_BUTTON_FINAL]) as $key){

				$obj = $dd_display_buttons[DD_FLOAT_BUTTON_FINAL][$key];
				//get current page URL, not post URL
				//get default button design
				$obj->constructURL(getCurPageURL(),$dd_title,$obj->float_button_design,$id, $obj->getOptionLazyLoad(), $dd_global_config,$commentcount);

				$dd_sorting_data[$obj->getOptionButtonWeight().'-'.$obj->name] = $obj;
			}
		}

	}else{
		//post page usually has post_count = 1
		foreach(array_keys($dd_display_buttons[DD_FLOAT_BUTTON_FINAL]) as $key){

			$obj = $dd_display_buttons[DD_FLOAT_BUTTON_FINAL][$key];
			$obj->constructURL($url,$title,$obj->float_button_design,$id, $obj->getOptionLazyLoad(), $dd_global_config,$commentcount);

			$dd_sorting_data[$obj->getOptionButtonWeight().'-'.$obj->name] = $obj;
		}
	}

	krsort($dd_sorting_data,SORT_NUMERIC);

	return $dd_sorting_data;

}

function integrateFloatingButtonsIntoWpContent($dd_floating_button_for_display,$content,$ddFloatDisplay){

	global $dd_floating_bar;

	$floatButtonsContainer=DD_EMPTY_VALUE;
	$dd_lazyLoad_jQuery_script =DD_EMPTY_VALUE;
	$dd_lazyLoad_scheduler_script =DD_EMPTY_VALUE;
	$scheduler = DD_EMPTY_VALUE;

	foreach($dd_floating_button_for_display as $obj){

		$finalURL=DD_EMPTY_VALUE;

		if($obj->getOptionLazyLoad()==DD_EMPTY_VALUE){
			$finalURL=$obj->finalURL;
		}else{
			$finalURL=$obj->finalURL_lazy;
			$dd_lazyLoad_jQuery_script.=$obj->finalURL_lazy_script;
			$dd_lazyLoad_scheduler_script.=$obj->final_scheduler_lazy_script;
		}

		$floatButtonsContainer .= "<div class='dd_button_v'>" . $finalURL . "</div><div style='clear:left'></div>";

	}

	if($floatButtonsContainer != DD_EMPTY_VALUE){

		$floatButtonsContainer = dd_construct_final_floating_buttons($floatButtonsContainer, $ddFloatDisplay);

		if($dd_lazyLoad_jQuery_script!=DD_EMPTY_VALUE){
			$dd_lazyLoad_jQuery_script = "<script type=\"text/javascript\">" . $dd_lazyLoad_jQuery_script . "</script>";
		}

		if($dd_lazyLoad_scheduler_script!=DD_EMPTY_VALUE){
			$dd_lazyLoad_scheduler_script = "<script type=\"text/javascript\"> jQuery(document).ready(function($) { " . $dd_lazyLoad_scheduler_script . " }); </script>";
		}

        // See if the post has custom meta tags to override the position of the top/y coord
        global $wp_query;
        $post = $wp_query->post; //get post content
        $id = $post->ID; //get post id
        
        // Try post overriden start_anchor_id before falling back to sitewide
        if(get_post_meta( $id, 'dd_override_start_anchor_id', true ) || get_post_meta( $id, 'dd_override_top_offset', true )){        
	        $dd_override_start_anchor_id = get_post_meta( $id, 'dd_override_start_anchor_id', true );
	        $dd_override_top_offset = get_post_meta( $id, 'dd_override_top_offset', true );
        } else if($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_ELEMENT] != ""){
	        $dd_override_start_anchor_id = $ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_ELEMENT];
	        $dd_override_top_offset = 0;
        }

		// $floatingCSS = '<style type="text/css" media="screen">' . $ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_POSITION] . '</style>';
        $floatingJSOptions = '<script type="text/javascript">';
		$floatingJSOptions .= 'var dd_offset_from_content = '.(!empty($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT]) ? ($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT]) : DD_FLOAT_OPTION_LEFT_VALUE).';';
        $floatingJSOptions .= 'var dd_top_offset_from_content = '.(!empty($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_TOP]) ? ($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_TOP]) : DD_FLOAT_OPTION_TOP_VALUE).';';
        $floatingJSOptions .= 'var dd_override_start_anchor_id = "'. $dd_override_start_anchor_id . '";';
        $floatingJSOptions .= 'var dd_override_top_offset = "'. $dd_override_top_offset . '";';
        $floatingJSOptions .= '</script>';
		$floatingJS = '<script type="text/javascript" src="' . DD_PLUGIN_URL . '/js/diggdigg-floating-bar.js?ver=' . DD_VERSION . '"></script>';

		$dd_floating_bar = "<div class='dd_outer'><div class='dd_inner'>" . $floatButtonsContainer . "</div></div>" . $floatingJSOptions . $floatingJS . $dd_lazyLoad_scheduler_script . $dd_lazyLoad_jQuery_script;
		$dd_start_anchor = '<a id="dd_start"></a>';

		if(!$ddFloatDisplay[DD_COMMENT_ANCHOR_OPTION][DD_COMMENT_ANCHOR_OPTION_STATUS]){
			$dd_end_anchor = '<a id="dd_end"></a>';
		} else {
			$dd_end_anchor = '';
		}

		$content =  $dd_start_anchor . $content . $dd_end_anchor . $dd_floating_bar;

	}

	return $content;
}


function integrateFloatingButtonsIntoWpContent_footerload($dd_floating_button_for_display,$content,$ddFloatDisplay){

	global $dd_floating_bar;

	$floatButtonsContainer=DD_EMPTY_VALUE;
	$dd_lazyLoad_jQuery_script =DD_EMPTY_VALUE;
	$dd_lazyLoad_scheduler_script =DD_EMPTY_VALUE;
	$scheduler = DD_EMPTY_VALUE;

	foreach($dd_floating_button_for_display as $obj){

		$finalURL=DD_EMPTY_VALUE;

		if($obj->getOptionLazyLoad()==DD_EMPTY_VALUE){
			$finalURL=$obj->finalURL;
		}else{
			$finalURL=$obj->finalURL_lazy;
			$dd_lazyLoad_jQuery_script.=$obj->finalURL_lazy_script;
			$dd_lazyLoad_scheduler_script.=$obj->final_scheduler_lazy_script;
		}

		$floatButtonsContainer .= "<div class='dd_button_v " . $obj->dd_twitter_ajax_left_float . "'>" . $finalURL . "</div><div style='clear:left'></div>";

	}

	if($floatButtonsContainer != DD_EMPTY_VALUE){

		$floatButtonsContainer = dd_construct_final_floating_buttons($floatButtonsContainer, $ddFloatDisplay);

		if($dd_lazyLoad_jQuery_script!=DD_EMPTY_VALUE){
			$dd_lazyLoad_jQuery_script = "<script type=\"text/javascript\">" . $dd_lazyLoad_jQuery_script . "</script>";
		}

		if($dd_lazyLoad_scheduler_script!=DD_EMPTY_VALUE){
			$dd_lazyLoad_scheduler_script = "<script type=\"text/javascript\">function dd_float_scheduler(){ jQuery(document).ready(function($) { " . $dd_lazyLoad_scheduler_script . " }); }</script>";
		}

		// $floatingCSS = '<style type="text/css" media="screen">' . $ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_POSITION] . '</style>';
		$floatingJSOptions = '<script type="text/javascript">var dd_offset_from_content = '.(!empty($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT])?($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT]):DD_FLOAT_OPTION_LEFT_VALUE).';</script>';
		$floatingJS = '<script type="text/javascript" src="' . DD_PLUGIN_URL . '/js/diggdigg-floating-bar.js?ver=' . DD_VERSION . '"></script>';

		$dd_floating_bar = "<div class='dd_outer'><div class='dd_inner'>" . $floatButtonsContainer . "</div></div>" . $floatingCSS . $floatingJSOptions . $floatingJS . $dd_lazyLoad_scheduler_script . $dd_lazyLoad_jQuery_script;

		$dd_start_anchor = '<a id="dd_start"></a>';

		if(!$ddFloatDisplay[DD_COMMENT_ANCHOR_OPTION][DD_COMMENT_ANCHOR_OPTION_STATUS]){
			$dd_end_anchor = '<a id="dd_end"></a>';
		} else {
			$dd_end_anchor = '';
		}

		$content =  $dd_start_anchor . $content . $dd_end_anchor . $dd_floating_bar;

	}

	return $content;
}

function dd_construct_final_floating_buttons($floatButtonsContainer, $ddFloatDisplay){

	if($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_STATUS]==DD_DISPLAY_ON){

		$emailContainer = dd_get_email_service($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID]);
		$floatButtonsContainer .= $emailContainer;

	}

	if($ddFloatDisplay[DD_EXTRA_OPTION_PRINT][DD_EXTRA_OPTION_PRINT_STATUS]==DD_DISPLAY_ON){

		$printContainer = dd_get_print_service();
		$floatButtonsContainer .= $printContainer;

	}

	if (dd_is_credit_link_enabled($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_CREDIT])){
		$floatButtonsContainer .= FLOAT_BUTTON_CREDIT_LINK;
	}

	$floatButtonsContainer = "<div id='dd_ajax_float'>" . $floatButtonsContainer . "</div>";

	return $floatButtonsContainer;

}

//http://help.sharethis.com/customization/custom-buttons
//http://help.sharethis.com/customization/chicklets
function dd_get_email_service($ddShareThisPubId){

	$emailButton = "<div class='dd_button_extra_v'><script type=\"text/javascript\">jQuery(document).load(function(){ stLight.options({";
	$emailButton .= "publisher:'". $ddShareThisPubId ."'";
	$emailButton .= "}); });</script><div class=\"st_email_custom\"><span id='dd_email_text'>email</span></div></div><div style='clear:left'></div>";

	return $emailButton;

}

function dd_get_print_service(){

	$emailButton = "<div class='dd_button_extra_v'><div id='dd_print_button'><span id='dd_print_text'><a href='javascript:window:print()'>print</a></span></div></div><div style='clear:left'></div>";
	return $emailButton;

}

function dd_is_credit_link_enabled($creditLinkStatus){

	if($creditLinkStatus==DD_DISPLAY_ON){
		return true;
	}else{
		return false;
	}

}

/********************************************************
 * Digg Digg Admin Page (Start)
 *******/
add_action('admin_init', 'dd_admin_init_setting');
add_action('admin_menu', 'dd_admin_generate_menu_link');

function dd_admin_generate_menu_link() {

	$page = add_menu_page('Digg Digg', 'Digg Digg', 'manage_options', 'dd_button_setup');

	$dd_button_global_setup = add_submenu_page('dd_button_setup', 'Digg Digg - Global Configuration', 'Global Config', 'manage_options', 'dd_button_setup', 'dd_button_global_setup');
	$dd_page_for_normal_display = add_submenu_page('dd_button_setup', 'Digg Digg - Normal Button Configuration ', 'Normal Display', 'manage_options', 'dd_page_for_normal_display', 'dd_page_for_normal_display');
	$dd_page_for_floating_display = add_submenu_page('dd_button_setup', 'Digg Digg - Floating Button Configuration', 'Floating Display', 'manage_options', 'dd_page_for_floating_display', 'dd_page_for_floating_display');
	$dd_button_manual_setup = add_submenu_page('dd_button_setup', 'Digg Digg - Manual Placement', 'Manual Placement', 'manage_options', 'dd_button_manual_setup', 'dd_button_manual_setup');

	//puts admin css in digg digg admin page only
	add_action('admin_print_styles-' .$dd_button_global_setup, 'dd_admin_output_admin_css');
	add_action('admin_print_styles-' .$dd_page_for_normal_display, 'dd_admin_output_admin_css');
	add_action('admin_print_styles-' .$dd_page_for_floating_display, 'dd_admin_output_admin_css');
	add_action('admin_print_styles-' .$dd_button_manual_setup, 'dd_admin_output_admin_css');

}

function dd_admin_init_setting() {
	dd_check_if_client_need_upgrade_setting();
	wp_register_style('dd_admin_style', DD_PLUGIN_URL . '/css/diggdigg-style-admin.css');
}

//$dd_current_version = 2;
//$dd_current_version = 3;
$dd_current_version = 5;
function dd_check_if_client_need_upgrade_setting() {

	global $dd_current_version;

	$dd_client_version = get_option('dd_client_version');
	//print_r('$dd_current_version : [' . $dd_current_version . ']<br/>');
	//print_r('$dd_client_version : [' . $dd_client_version . ']<br/>');

	if(empty($dd_client_version)){

		//print_r('$dd_client_upgrade_version is empty - first time<br/>');
		//do first time setting upgrade
		dd_upgrade_setting_version_1();
		update_option('dd_client_version', $dd_current_version);

	}else{

		//print_r('$dd_client_upgrade_version is not empty - not first time<br/>');

		if($dd_current_version > $dd_client_version){

			//print_r('<h1>setting is upgrading.....</h1>');
			dd_upgrade_setting_version_5();
			update_option('dd_client_version', $dd_current_version);

		}else{
			//print_r('setting is up to date<br/>');
			//update_option('dd_client_version', 2);
		}
		//delete_option('dd_client_version');
	}

}

function dd_admin_output_admin_css(){
	wp_enqueue_style('dd_admin_style');
}
/*******
 * Digg Digg Admin Page (End)
 ********************************************************/
?>