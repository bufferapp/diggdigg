<?php
require_once 'dd-global-variable.php';

//3.1 : This hook is now fired only when the user activates the plugin and not when an automatic plugin update occurs
////http://codex.wordpress.org/Function_Reference/register_activation_hook
function dd_run_when_plugin_activated(){

	dd_clear_form_global_config();
	dd_clear_form_normal_display();
	dd_clear_form_float_display();

}

function dd_clear_all_forms_settings(){

	dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
	dd_clear_form_normal_display(DD_FUNC_TYPE_RESET);
	dd_clear_form_float_display(DD_FUNC_TYPE_RESET);

}

function dd_clear_form_global_config($type=""){

	global $ddGlobalConfig;

	$old_ddGlobalConfig = get_option(DD_GLOBAL_CONFIG);

	if(empty($old_ddGlobalConfig) || $type==DD_FUNC_TYPE_RESET){

		//update $ddGlobalConfig to default setting
		update_option(DD_GLOBAL_CONFIG, $ddGlobalConfig);

	}

}

function dd_clear_form_normal_display($type=""){

	global $ddNormalDisplay,$ddNormalButtons;

	$dd_Old_NormalDisplay = get_option(DD_NORMAL_DISPLAY_CONFIG);

	if(empty($dd_Old_NormalDisplay) || $type==DD_FUNC_TYPE_RESET){

		//update $ddNormalDisplay to default setting
		update_option(DD_NORMAL_DISPLAY_CONFIG, $ddNormalDisplay);

	}

	foreach($ddNormalButtons[DD_NORMAL_BUTTON_DISPLAY] as $key => $value){

		if(($value->getOptionAppendType()!=DD_SELECT_NONE)){
			$ddNormalButtons[DD_NORMAL_BUTTON_FINAL][$key] = $value;
		}
    }

	$dd_Old_NormalButton = get_option(DD_NORMAL_BUTTON);

	if(empty($dd_Old_NormalButton) || $type==DD_FUNC_TYPE_RESET){

		//update $ddNormalButtons to default setting
		update_option(DD_NORMAL_BUTTON, $ddNormalButtons);

	}

}

function dd_clear_form_float_display($type=""){

	global $ddFloatDisplay,$ddFloatButtons;

	$dd_Old_FloatDisplay = get_option(DD_FLOAT_DISPLAY_CONFIG);

	if(empty($dd_Old_FloatDisplay) || $type==DD_FUNC_TYPE_RESET){

		//update $ddFloatDisplay to default setting
		update_option(DD_FLOAT_DISPLAY_CONFIG, $ddFloatDisplay);

	}

	foreach($ddFloatButtons[DD_FLOAT_BUTTON_DISPLAY] as $key => $value){

		if(($value->getOptionAjaxLeftFloat()!=DD_DISPLAY_OFF)){
			$ddFloatButtons[DD_FLOAT_BUTTON_FINAL][$key] = $value;
		}

    }

	$dd_Old_FloatButton = get_option(DD_FLOAT_BUTTON);

	if(empty($dd_Old_FloatButton) || $type==DD_FUNC_TYPE_RESET){

		//update $ddFloatButtons to default setting
		update_option(DD_FLOAT_BUTTON, $ddFloatButtons);

	}

}

function dd_wp_enqueue_styles() {
	wp_enqueue_style( 'digg-digg', plugins_url( 'css/diggdigg-style.css', dirname( __FILE__ ) ), array(), DD_VERSION, 'screen' );
}

function dd_get_thumbnails_for_fb()
{
	//check ig crawl is allowed
	$globalcfg = get_option(DD_GLOBAL_CONFIG);

	$fb_thumb = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_THUMB];

	if($fb_thumb==DD_DISPLAY_ON){

		global $posts;
		$default = $globalcfg[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB];

		$content = $posts[0]->post_content;
		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
		if ($output > 0){
			$thumb = $matches[1][0];
		}else{
			$thumb = $default;
		}

		echo "<link rel=\"image_src\" href=\"$thumb\" />";

	}

}

//http://codex.wordpress.org/Function_Reference/wp_enqueue_script
function dd_enable_required_js_in_wordpress() {

	$ddFloatDisplay = get_option(DD_FLOAT_DISPLAY_CONFIG);
	$email_option = ($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_STATUS]==DD_DISPLAY_ON);
	if(!empty($email_option))
	{
		wp_deregister_script('dd_sharethis_js');
		wp_register_script('dd_sharethis_js', 'http://w.sharethis.com/button/buttons.js');
		wp_enqueue_script('dd_sharethis_js','http://w.sharethis.com/button/buttons.js',array('sharethis'),'1.0.0',true);
	}

	if (!is_admin()) {

		//jQuery need to put on head
		wp_enqueue_script('jquery');
	}
}

//filter for ajax floating javascript
function dd_filter_weird_characters($str){

	$str = str_replace("\\\"", "\"", $str);
	$str = str_replace("\'", "'", $str);

	return $str;
}

function dd_IsDisplayAllow($ddDisplay){

	if(dd_IsDisplayOptionAllow($ddDisplay[DD_DISPLAY_OPTION],$ddDisplay[DD_CATEORY_OPTION])){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if the current page allow to display button
 * @param $ddDisplayOptions -> $ddNormalDisplay[DD_DISPLAY_OPTION])
 * @param $ddCategoryOptions -> $ddNormalDisplay[DD_CATEORY_OPTION]
 *
 */
function dd_IsDisplayOptionAllow($ddDisplayOptions, $ddCategoryOptions){

	//get display option
    $dd_display_home = $ddDisplayOptions[DD_DISPLAY_OPTION_HOME];
	$dd_display_page = $ddDisplayOptions[DD_DISPLAY_OPTION_PAGE];
	$dd_display_post = $ddDisplayOptions[DD_DISPLAY_OPTION_POST];
	$dd_display_category = $ddDisplayOptions[DD_DISPLAY_OPTION_CAT];
	$dd_display_tag = $ddDisplayOptions[DD_DISPLAY_OPTION_TAG];
	$dd_display_archive = $ddDisplayOptions[DD_DISPLAY_OPTION_ARCHIVE];

	//TODO: can it display in feed?
	$dd_display_feed = DD_DISPLAY_OFF;

	if(is_home() && ($dd_display_home==DD_DISPLAY_ON)){
		return true;
	}else if(is_feed() && ($dd_display_feed==DD_DISPLAY_ON)){
		return true;
	}else if(is_single() && ($dd_display_post==DD_DISPLAY_ON)){

		//check category allow
		return dd_IsCategoryAllow($ddCategoryOptions);


	}else if(is_category() && ($dd_display_category==DD_DISPLAY_ON)){
		return true;
	}else if(is_page() && ($dd_display_page==DD_DISPLAY_ON)){
		return true;
	}else if(is_tag() && ($dd_display_tag==DD_DISPLAY_ON)){
		return true;
	}else if(is_archive() && ($dd_display_archive==DD_DISPLAY_ON)){
		return true;
	}else{
		return false;
	}
}


/**
 * Genaric function to get text base on id and key
 * @param $id - array key
 * @param $key - array key
 */
function dd_GetText($id, $key){

	if($id==DD_DISPLAY_OPTION){
		switch($key){
			case DD_DISPLAY_OPTION_HOME :
				return DD_DISPLAY_OPTION_LABEL_HOME;
				break;
			case DD_DISPLAY_OPTION_POST :
				return DD_DISPLAY_OPTION_LABEL_POST;
				break;
			case DD_DISPLAY_OPTION_PAGE :
				return DD_DISPLAY_OPTION_LABEL_PAGE;
				break;
			case DD_DISPLAY_OPTION_CAT :
				return DD_DISPLAY_OPTION_LABEL_CAT;
				break;
			case DD_DISPLAY_OPTION_TAG :
				return DD_DISPLAY_OPTION_LABEL_TAG;
				break;
			case DD_DISPLAY_OPTION_ARCHIVE :
				return DD_DISPLAY_OPTION_LABEL_ARCHIVE;
				break;
			default:
       			return DD_DEFAULT_TEXT;
				break;
		}
	}else if($id==DD_LINE_UP_OPTION){
		switch($key){
			case DD_LINE_UP_OPTION_SELECT_HORIZONTAL :
				return DD_LINE_UP_OPTION_LABEL_HORIZONTAL;
				break;
			case DD_LINE_UP_OPTION_SELECT_VERTICAL :
				return DD_LINE_UP_OPTION_LABEL_VERTICAL;
				break;
			default:
       			return DD_DEFAULT_TEXT;
				break;
		}
	}
}


/**
 * @return "true" if page excluded
 */
function dd_isThisPageExcluded($content){

	if (preg_match("/" . DD_DISABLED . "/i", $content)) {
	    return true;
	} else {
	    return false;
	}

}

/**
 * Check if the current category allow to display button
 * @param $category_options -> $ddNormalDisplay[DD_CATEORY_OPTION])
 */
function dd_IsCategoryAllow($category_options){

	$catOptions = $category_options[DD_CATEORY_OPTION_RADIO];
	$catOptionsInclude = $category_options[DD_CATEORY_OPTION_TEXT_INCLUDE];
	$catOptionsExclude = $category_options[DD_CATEORY_OPTION_TEXT_EXCLUDE];

	if($catOptions == DD_CATEORY_OPTION_RADIO_INCLUDE){

		return dd_IsCategoryInclude($catOptionsInclude);

	}else if($catOptions == DD_CATEORY_OPTION_RADIO_EXCLUDE){

		return !dd_IsCategoryExclude($catOptionsExclude);

	}else{

		return dd_IsCategoryInclude($catOptionsInclude);
	}

}

/**
 *
 * @param $category_allow - categories allow to display
 * @return true = allow, false = disallow
 */
function dd_IsCategoryInclude($category_allow){

	$category_allow = trim(strtolower($category_allow));

	//echo 'Category allow : ' . $category_allow;
	if($category_allow == '' || ($category_allow==strtolower(DD_ALL_VALUE))){
		return true;
	}

	$cats_allow = explode(",", strtolower($category_allow));

	foreach((get_the_category()) as $post_category) {

		//echo '<br/> category name : ' . $post_category->cat_name;
		foreach($cats_allow as $cat_allow){

			$post_category_name = strtolower($post_category->cat_name);
			//echo '<br/>Category allow loop : ' . $cat_allow . '<br/> current category name : ' . $post_category_name;

			if($post_category_name==trim($cat_allow)){
				//echo ' match';
				return true;
			}else{
				//echo ' not match';
			}
		}
	}
	return false;
}

/**
 *
 * @param $category_disallow - categories disallow to display
 * @return true = disallow, false = allow
 */
function dd_IsCategoryExclude($category_disallow){

	$category_disallow = trim(strtolower($category_disallow));

	//echo 'Category disallow : ' . $category_disallow;
	if($category_disallow == '' || ($category_disallow==strtolower(DD_NONE_VALUE))){
		return false;
	}

	$cats_disallow = explode(",", strtolower($category_disallow));

	foreach((get_the_category()) as $post_category) {

		//echo '<br/> category name : ' . $post_category->cat_name;
		foreach($cats_disallow as $cat_disallow){

			$post_category_name = strtolower($post_category->cat_name);
			//echo '<br/>Category allow loop : ' . $cat_disallow . '<br/> current category name : ' . $post_category_name;

			if($post_category_name==trim($cat_disallow)){
				//echo ' match';
				return true;
			}else{
				//echo ' not match';
			}
		}
	}
	return false;
}

function get_server() {
	$protocol = 'http';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
		$protocol = 'https';
	}
	$host = $_SERVER['HTTP_HOST'];
	$baseUrl = $protocol . '://' . $host;
	if (substr($baseUrl, -1)=='/') {
		$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
	}
	return $baseUrl;
}

function getCurPageURL() {
	 $pageURL = 'http';

	 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	 	$pageURL .= "s";
	 }
	 $pageURL .= "://";

	 if ($_SERVER["SERVER_PORT"] != "80") {
	  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }

	 return $pageURL;
}

//get normal display settings
$ddNormalDisplayTemp = get_option(DD_NORMAL_DISPLAY_CONFIG);
//if diggdigg excerp is allow
if($ddNormalDisplayTemp[DD_EXCERP_OPTION][DD_EXCERP_OPTION_DISPLAY]==DD_DISPLAY_ON){

	remove_filter('get_the_excerpt', 'wp_trim_excerpt');
	add_filter('get_the_excerpt', 'dd_exclude_js_trim_excerpt');

}

//clone from wordpress 3.0.1 wp_trim_excerpt, add extra js filter
function dd_exclude_js_trim_excerpt($text) {

	// Only generate excerpt if it does not exist
	if($text==''){

		$text = get_the_content('');
		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);

		//exclude js script , in order to display button in the_excerpt() mode
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

		//exclude css , in order to display ajax float button in the_excerpt() mode
		$text = preg_replace('@<style[^>]*?>.*?</style>@si', '', $text);

		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}

	}
	return $text;
}

//not implement yet
//make sure wordpress > 2.3 and PHP >= 5
function dd_check_version(){

	global $wp_version;

	echo '<h1>Current PHP version: ' . phpversion() . '</h1>';

	echo '<h1>Current Wordpress version: ' . $wp_version . '</h1>';

	$exit_msg="<div id='errmessage' class='error fade'><p>Digg Digg requires WordPress 2.3 or newer. <a href='http://codex.wordpress.org/Upgrading_WordPress'>Please update!</a></p></div>";

	if (version_compare($wp_version,"2.3",">"))
	{
		exit ($exit_msg);
	}

}
?>