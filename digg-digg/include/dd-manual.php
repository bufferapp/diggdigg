<?php

// XXX: NEW BUTTONS: Add declarations to $dd_manual_code array, and functions below to initialise class
/***********************************Advance Usage*********************************/
global $dd_manual_code;
$dd_manual_code = array(
	"Twitter" => array(
		"Normal" => "dd_twitter_generate('Normal','twitter_username')",
		"Compact" => "dd_twitter_generate('Compact','twitter_username')"
	),
	"Buffer" => array(
		"Normal" => "dd_buffer_generate('Normal')",
		"Compact" => "dd_buffer_generate('Compact')",
		"No Count" => "dd_buffer_generate('No Count')"
	),
	"FaceBook Like" => array(
		"Like Standard" => "dd_fblike_generate('Like Standard')",
		"Like Button Count" => "dd_fblike_generate('Like Button Count')",
		"Like Box Count" => "dd_fblike_generate('Like Box Count')",
		"Recommend Standard" => "dd_fblike_generate('Recommend Standard')",
		"Recommend Button Count" => "dd_fblike_generate('Recommend Button Count')",
		"Recommend Box Count" => "dd_fblike_generate('Recommend Box Count')"
	),
	"FaceBook Like (XFBML)" => array(
		"Like Standard" => "dd_fblike_xfbml_generate('Like Standard')",
		"Like Button Count" => "dd_fblike_xfbml_generate('Like Button Count')",
		"Like Box Count" => "dd_fblike_xfbml_generate('Like Box Count')",
		"Recommend Standard" => "dd_fblike_xfbml_generate('Recommend Standard')",
		"Recommend Button Count" => "dd_fblike_xfbml_generate('Recommend Button Count')",
		"Recommend Box Count" => "dd_fblike_xfbml_generate('Recommend Box Count')"
	),
	"Google +1" => array(
		"Normal" => "dd_google1_generate('Normal')",
		"Compact (15px)" => "dd_google1_generate('Compact (15px)')",
		"Compact (20px)" => "dd_google1_generate('Compact (20px)')",
		"Compact (24px)" => "dd_google1_generate('Compact (24px)')"
	),
	"Linkedin" => array(
		"Normal" => "dd_linkedin_generate('Normal')",
		"Compact" => "dd_linkedin_generate('Compact')",
		"NoCount" => "dd_linkedin_generate('NoCount')"
	),
	"Reddit" => array(
		"Normal" => "dd_reddit_generate('Normal')",
		"Compact" => "dd_reddit_generate('Compact')",
		"Icon" => "dd_reddit_generate('Icon')"
	),
	"DZone" => array(
		"Normal" => "dd_dzone_generate('Normal')",
		"Compact" => "dd_dzone_generate('Compact')"
	),
	"Yahoo Buzz" => array(
		"Normal" => "dd_ybuzz_generate('Normal')",
		"Compact" => "dd_ybuzz_generate('Compact')",
		"Compact_Text" => "dd_ybuzz_generate('Compact_Text')"
	),
	"TweetMeme" => array(
		"Normal" => "dd_tweetmeme_generate('Normal','twitter_username')",
		"Normal + URL" => "dd_tweetmeme_generate('Normal','twitter_username','awe.sm')",
		"Normal + URL + API" => "dd_tweetmeme_generate('Normal','twitter_username','bit.ly','api_key')",
		"Compact" => "dd_tweetmeme_generate('Compact','twitter_username')",
		"Compact + URL" => "dd_tweetmeme_generate('Compact','twitter_username','awe.sm')",
		"Compact + URL + API" => "dd_tweetmeme_generate('Compact','twitter_username','bit.ly','api_key')",	
	),
	"Tospy" => array(
		"Normal" => "dd_topsy_generate('Normal','twitter_username')",
		"Normal + Theme" => "dd_topsy_generate('Normal','twitter_username','theme_code')",
		"Compact" => "dd_topsy_generate('Compact','twitter_username')",
		"Compact + Theme" => "dd_topsy_generate('Compact','twitter_username','theme_code')"
	),
	"FaceBook Share" => array(
		"Normal" => "dd_fbshare_generate('Normal')",
		"Compact" => "dd_fbshare_generate('Compact')"
	),
	"FBShare.Me" => array(
		"Normal" => "dd_fbshareme_generate('Normal')",
		"Compact" => "dd_fbshareme_generate('Compact')"
	),
	"StumbleUpon" => array(
		"Normal" => "dd_stumbleupon_generate('Normal')",
		"Compact" => "dd_stumbleupon_generate('Compact')"
	),
	"Delicious" => array(
		"Normal" => "dd_delicious_generate('Normal')",
		"Compact" => "dd_delicious_generate('Compact')"
	),
	"The Web Blend" => array(
		"Normal" => "dd_thewebblend_generate('Normal')",
		"Compact" => "dd_thewebblend_generate('Compact')"
	),
	"DesignBump" => array(
		"Normal" => "dd_designbump_generate('Normal')"
	),
	"BlogEngage" => array(
		"Normal" => "dd_blogengage_generate('Normal')"
	),
	"PostComment" => array(
		"Normal" => "dd_post_comments_generate('Normal')"
	),
	"Serpd" => array(
		"Normal" => "dd_serpd_generate('Normal')"
	),
	"Pinterest" => array(
		"Normal" => "dd_pinterest_generate('Normal')",
		"Compact" => "dd_pinterest_generate('Compact')"
	),
	"Flattr" => array(
		"Normal" => "dd_flattr_generate('Normal','flattr_username')",
		"Compact" => "dd_flattr_generate('Compact','flattr_username')"
	),
	"Pocket" => array(
		"Normal" => "dd_pocket_generate('Normal')",
		"Compact" => "dd_pocket_generate('Compact')"
	),
	"Tumblr" => array(
		"Normal" => "dd_tumblr_generate('Normal')",
	),
);		
	
function dd_digg_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_digg = new DD_Digg();
    $dd_digg->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'], false);
			
	echo $dd_digg->finalURL;
}	

function dd_linkedin_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_linkedin = new DD_Linkedin();
    $dd_linkedin->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'], false);
	
	echo $dd_linkedin->finalURL;
}	

function dd_reddit_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_reddit = new DD_Reddit();
    $dd_reddit->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'], false);

	echo $dd_reddit->finalURL;
}

function dd_dzone_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_dzone = new DD_DZone();
    $dd_dzone->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_dzone->finalURL;
}

function dd_ybuzz_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_ybuzz = new DD_YBuzz();
    $dd_ybuzz->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'], false);
    
	echo $dd_ybuzz->finalURL;
}

function dd_twitter_generate($buttonDesign='Normal', $source=''){
	$post_data = dd_getPostData();
    
    global $globalcfg;
    $globalcfg[DD_GLOBAL_TWITTER_OPTION][DD_GLOBAL_TWITTER_OPTION_SOURCE] = $source;
    
    $dd_twitter = new DD_Twitter();
    $dd_twitter->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false,$globalcfg);
    
	echo $dd_twitter->finalURL;
}

function dd_tweetmeme_generate($buttonDesign='Normal', $source='', $service='',$serviceapi=''){
	$post_data = dd_getPostData();
	
    global $globalcfg;
    $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SOURCE] = $source;
    $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE] = $service;
    $globalcfg[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API] = $serviceapi;
    
    $dd_tweetmeme = new DD_TweetMeme();
    $dd_tweetmeme->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false,$globalcfg);
     
	echo $dd_tweetmeme->finalURL;
}

function dd_topsy_generate($buttonDesign='Normal', $source='', $theme='blue'){
	$post_data = dd_getPostData();
	
    global $globalcfg;
    $globalcfg[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_SOURCE] = $source;
    $globalcfg[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_THEME] = $theme;
  
    $dd_topsy = new DD_Topsy();
    $dd_topsy->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false,$globalcfg);
    
	echo $dd_topsy->finalURL;
}

function dd_fbshare_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_fbshare = new DD_FbShare();
    $dd_fbshare->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_fbshare->finalURL;
}

function dd_fbshareme_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_fbshareme = new DD_FbShareMe();
    $dd_fbshareme->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_fbshareme->finalURL;
}

function dd_fblike_generate($buttonDesign='Like Standard'){
	$post_data = dd_getPostData();
    
    $dd_fblike = new DD_FbLike();
    $dd_fblike->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_fblike->finalURL;
}

function dd_stumbleupon_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_stumbleupon = new DD_StumbleUpon();
    $dd_stumbleupon->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_stumbleupon->finalURL;
}	

function dd_delicious_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_delicious = new DD_Delicious();
    $dd_delicious->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_delicious->finalURL;
}	

function dd_sphinn_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_sphinn = new DD_Sphinn();
    $dd_sphinn->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_sphinn->finalURL;
}	

function dd_gbuzz_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_gbuzz = new DD_GBuzz();
    $dd_gbuzz->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_gbuzz->finalURL;
}

function dd_designbump_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_designbump = new DD_DesignBump();
    $dd_designbump->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_designbump->finalURL;
}	

function dd_thewebblend_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_webblend = new DD_TheWebBlend();
    $dd_webblend->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_webblend->finalURL;
}	

function dd_blogengage_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_blogengage = new DD_BlogEngage();
    $dd_blogengage->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_blogengage->finalURL;
}

function dd_post_comments_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_comments = new DD_Comments();
    $dd_comments->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'], false,'',$comments);
			
	echo $dd_comments->finalURL;
}	

function dd_serpd_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_serpd = new DD_Serpd();
    $dd_serpd->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_serpd->finalURL;
}

function dd_fblike_xfbml_generate($buttonDesign='Like Standard'){
	$post_data = dd_getPostData();
    
    $dd_fblike_xfbml = new DD_FbLike_XFBML();
    $dd_fblike_xfbml->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_fblike_xfbml->finalURL;
}

function dd_google1_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_google1 = new DD_Google1();
    $dd_google1->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_google1->finalURL;
}


function dd_buffer_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_buffer = new DD_Buffer();
    $dd_buffer->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_buffer->finalURL;
}

function dd_pinterest_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_pinterest = new DD_Pinterest();
    $dd_pinterest->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_pinterest->finalURL;
}

function dd_flattr_generate($buttonDesign='Normal', $uid=''){
	$post_data = dd_getPostData();
    
	global $globalcfg;
	$globalcfg[DD_GLOBAL_FLATTR_OPTION][DD_GLOBAL_FLATTR_OPTION_UID] = $uid;
	
    $dd_flattr = new DD_Flattr();
    $dd_flattr->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false,$globalcfg);
    
	echo $dd_flattr->finalURL;
}

function dd_pocket_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_pocket = new DD_Pocket();
    $dd_pocket->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_pocket->finalURL;
}

function dd_tumblr_generate($buttonDesign='Normal'){
	$post_data = dd_getPostData();
    
    $dd_tumblr = new DD_Tumblr();
    $dd_tumblr->constructURL($post_data['link'],$post_data['title'],$buttonDesign,$post_data['id'],false);
    
	echo $dd_tumblr->finalURL;
}

function dd_getPostData() {
	global $wp_query; 
    $post = $wp_query->post; //get post content
    $id = $post->ID; //get post id
    $postlink = get_permalink($id); //get post link
    $title = trim($post->post_title); // get post title
    $link = split(DD_DASH,$postlink); //split the link with '#', for comment
    
    return array( 'id' => $id, 'link' => $link[0], 'title' => $title );
}
?>