=== Digg Digg ===
Contributors: joelg87, andy7629
Tags: digg digg, buffer, digg, google, google+1, plus one, tweet, twitter, facebook, share, like, stumbleupon, social sharing, linkedin, reddit, pinterest, sharebar, social media, social networking, sharethis, pocket, tumblr
Requires at least: 2.3
Tested up to: 3.5.1
Stable tag: 5.3.6

Your all in one share buttons plugin. Add a floating bar with share buttons to your blog. Just like Mashable!

== Description ==
With Digg Digg by Buffer, you have an all in one social sharing plugin for your blog. Display all social sharing buttons nicely on your blog and make it look amazing, just like Mashable.

= Features =

* Display all popular social sharing buttons with count, such as Twitter, Buffer, Facebook Share, Facebook Like, Digg, LinkedIn, Google +1, Reddit, dZone, TweetMeme, Topsy, Yahoo Buzz, StumbleUpon, Del.icio.us, Sphinn, Designbump, WebBlend, BlogEngage, Serpd, Pinterest, Pocket and Tumblr.
* Facebook Like (Iframe or XFBML), support thumbnail generation, multiple languages, show faces and send button.
* Great customization options. Choose a floating bar like here: http://blog.bufferapp.com or sharing buttons at the top or bottom of the post.
* Lazy loading to increase website performance.
* Left or right scrolling effect like Mashable.com.
* Support in excerpt mode.
* Support for email and print services.
* Nearly any button out there you can think of.
* Have any suggestions we should include in the next update? Email us: diggdigg@bufferapp.com

== Installation ==

1. Download the plugin from this page and extract it
2. Copy the digg-digg folder to the "/wp-content/plugins/" directory 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. You are done – you can now customize it however you want by clicking on "Digg Digg" in the "settings" section.

Post Installation
1. Go to the Digg Digg admin section to setup your social buttons

== Frequently Asked Questions ==
If you have any questions, we'd love to hear from you. Email us: diggdigg@bufferapp.com


= How can I disable the Digg Digg Floating Bar on a particular page? =

You can insert the following within the HTML editor anywhere when editing a post and it will disable Digg Digg on that page.

`<!-- Digg Digg Disabled -->`

Another method to disable the bar on a particular page add the following few lines to your themes functions.php file, changing the conditional tags to ones that fit your requirement.

`function dd_exclude_from_pages() {
if(is_page(1)) {
      remove_filter('the_excerpt', 'dd_hook_wp_content');
    	remove_filter('the_content', 'dd_hook_wp_content');
	}
}
add_action('template_redirect', 'dd_exclude_from_pages');`

More details here... http://www.eugenoprea.com/code-snippets/exclude-diggdigg-from-specific-pages/

= How can I add the Digg Digg Floating Bar on a particular page? =

To add the bar to a particular page add the following few lines to your themes functions.php file, changing the conditional tags to ones that fit your requirement.

`if(is_page('page-slug-1') || is_page('page-slug-2')) {
	add_filter('the_excerpt', 'dd_hook_wp_content');
	add_filter('the_content', 'dd_hook_wp_content');
}`


= How can I change the order of sharers throughout Digg Digg? =

In both Normal Display and Floating Display settings pages you can change the weight of a sharer. The highest weighted sharer will be displayed first, the lowest weighted sharer will be displayed last.


== Screenshots ==
1. Floating Bar
2. Normal Bar with Large Buttons at Top
3. Normal Bar with Large Buttons at Bottom
4. Normal Bar with Small Buttons at Top

== Changelog ==

= Digg Digg v5.3.6 - 01/07/2013 =
* Fixed: Use WordPress HTTP API for delicious.
* Fixed: Typo in Linkedin sharer.
* Fixed: Uses wp_enqueue_script rather than wp_head.

= Digg Digg v5.3.5 - 19/05/2013 =
* Added: Support for WordPress nonce fields. Prevents cross-site request forgery. Credit to Charlie Eriksen via Secunia SVCRP for finding and reporting.

= Digg Digg v5.3.4 - 05/05/2013 =
* Added: Support for both HTTP and HTTPS URL Schemes. Thanks Maks3w.
* Added: Extra flexibility over the position of the Digg Digg Floating Bar, allowing you to set a specific DOM element per post using Custom Fields. Thanks DaveBurns.
* Added: Site wide customisation of the specific DOM element that Digg Digg uses to set its initial position. Thanks again DaveBurns for inspiration for adding this.
* Fixed: Facebook Like XFMBL no longer requires URL Encoding. Thanks to various people in the support forum for pointing this out.
* Fixed: Various other small bug fixes.
* Note: As always if you have a bugfix or a feature and want to help make Digg Digg better then you can contribute via GitHub here... https://github.com/bufferapp/diggdigg

= Digg Digg v5.3.3 - 12/04/2013 =
* Fixed: Critical issue with updating Digg Digg where the plugin would disappear completely. Sorry about that guys!

= Digg Digg v5.3.2 - 12/04/2013 =
* New: Added Pocket Publisher Button
* New: Added Tumblr Share Button
* New: Buffer button now uses the post title rather than grabbing content from the page title.

= Digg Digg v5.3.1 - 03/03/2013 =
* New: Extra documentation for excluding Digg Digg from certain pages within the FAQ.
* Fixed: Issue with duplicate LinkedIn buttons.
* Fixed: Issue with HTTPS CSS, thanks desrosj.
* Removed: Old buttons that are no longer available. Google Buzz, Digg.

= Digg Digg v5.3.0 - 25/11/2012 =
* New: Digg Digg is now Open Source, please contribute on GitHub here... https://github.com/bufferapp/diggdigg
* Fixed: Validated the URLs and improved CSS (Thanks aronmarriott-smith)
* Fixed: Fix for manually placed Flattr buttons (Thanks JimmStout)

= Digg Digg v5.2.9 - 28/06/2012 =
* Fixed: Pinterest button selects full image rather than thumbnail.
* Fixed: Increase size of offset inputs so number isn't cut off in various browsers.
* New: If post thumbnails aren't used Digg Digg will select the first image attached to a post.

= Digg Digg v5.2.8 - 19/06/2012 =
* Fixed: Issue with LinkedIn not displaying when using Manual Display.
* Fixed: Issue with Buffer button adding two @ symbols in front of username.
* New: Link to FAQ on WordPress.org before Feedback form.
* New: FAQ content updated.

= Digg Digg v5.2.7 - 24/05/2012 =
* New: Feedback page to allow plugin users to email the developers directly from the WordPress admin.
* Fixed: LinkedIn Button positioned correctly rather than bottom left corner of site.
* Fixed: Digg Digg Credit is enabled on correct checkbox state rather than unchecked for enabled and checked for disabled.
* Fixed: Mentions with Buffer button now add @ symbol unless already added in admin field.

= Digg Digg v5.2.6 - 24/04/2012 =
* New: Option to allow Digg Digg to scroll beyond the end of a post, into the comments.
* Fixed: Bug where in some cases Digg Digg buttons in the floating bar were not clickable.
* Fixed: Bug where the Digg Digg floating bar positioning would be wrong if you scroll before the page is fully loaded.

= Digg Digg v5.2.5 - 19/04/2012 =
* Fixed: Digg Digg no longer forces an old version of jQuery. This should solve a number of different issues.
* New: Choose the offset of the floating bar from the top of the page.
* New: The floating bar stops at the comments, so it doesn't overlap.

= Digg Digg v5.2.4 - 09/04/2012 =
* Fixed: Bug where the floating bar would be in the wrong position (over content) and would not stay in place as you scroll. This was caused by a bug with the Email feature.
* Fixed: Issue where the floating bar would not appear due to an incorrect calculation of where to place it.

= Digg Digg v5.2.3 - 03/04/2012 =
* Fixed: Issue where the floating bar was in the wrong position in some themes and Firefox and Internet Explorer, particularly related to pictures at the start of a post.
* Fixed: The option to put the floating bar on the blog homepage has been removed. This is due to confusion and issues arising with this option. If you want buttons on your posts on the blog homepage, you should enable the Normal Display buttons for either just the homepage or for all. 

= Digg Digg v5.2.2 - 03/04/2012 =
* Fixed: Themes missing the wp_footer hook caused the floating bar to not display. Now using an alternative method.

= Digg Digg v5.2.1 - 12/03/2012 =
* Fixed: An alternate usage of jQuery caused floating bar to not work with certain themes.

= Digg Digg v5.2 - 12/03/2012 =
* Fixed: Problem on some themes where the floating bar only appeared when you scrolled partly down the page.
* Fixed: Bug where the words "Buffer" and "Pin It" appeared in the excerpt.
* Fixed: Width of the floating bar now adjusts to allow for larger buttons.
* Fixed: Buttons in the floating bar have better vertical spacing.
* New: Choose the offset of the floating bar from the left of the content.
* New: The floating bar will automatically hide when it goes off the side of the page.

= Digg Digg v5.1.2 - 07/03/2012 =
* Fixed: Width of Tweet button is now set by Twitter, instead of fixed by Digg Digg. This allows Tweet buttons of languages other than English to display correctly, and fixes a bug where the count was hidden on the compact button.

= Digg Digg v5.1.1 - 05/03/2012 =
* Fixed: Inconsistencies with the scrolling behaviour of the floating bar amongst different themes. If the floating bar was acting odd for you, grab this update.

= Digg Digg v5.1 - 01/03/2012 =
* Critical Bug Fix: The horrible Fatal Error which resulted in the page stopping loading mid-way caused by conflict with W3 Total Cache. If you are using W3 Total Cache, you should definitely grab this update.

= Digg Digg v5.0.5 - 29/02/2012 =
* Fixed: Fatal error: Call to undefined function get_post_thumbnail_id() when using Pinterest button on themes which don't support featured images.

= Digg Digg v5.0.4 - 28/02/2012 =
* Fixed: Flattr button. You can choose your Flattr username from the global configuration page.
* Fixed: You can now choose a Twitter username to be mentioned when people use the Buffer button. Set it in the global configuration page.
* Fixed: Bug where "Buffer" and "Pin It" appeared at the start of excerpts.

= Digg Digg v5.0.3 - 27/02/2012 =
* Fixed: Pinterest button let's people pin the featured image for the blog post.
* Fixed: The vertical Tweet button width has been set to 55px, to fix a current issue from Twitter.
* Fixed: The floating bar shadow is now set using alpha transparency, to avoid a "glow" effect on dark backgrounds.

= Digg Digg v5.0.2 - 08/02/2012 =
* Fixed: Added back the ability to disable the credit link.

= Digg Digg v5.0.1 - 08/02/2012 =
* Fixed: Fatal error: "unexpected T_PAAMAYIM_NEKUDOTAYIM" error message when updating.
* Fixed: Bug where you could no longer turn off the floating bar.

= Digg Digg v5.0 - 08/02/2012 =
* Welcome to Digg Digg by Buffer!
* New: Brand new floating bar design.
* Added: Pinterest button added.
* Added: Buffer button added.
* Added: Plugin now starts with a default set of buttons enabled in the floating bar.
* Fixed: LinkedIn button.

= Digg Digg v4.5.3.4 - 16/12/2011 =
* Fixed : Fatal error: Cannot use object of type stdClass as array in dd-class.php 1205, happend when normal delicious button is selected.

= Digg Digg v4.5.3.3 - 28/06/2011 =
* Fixed : Warning in dd-printform.php

= Digg Digg v4.5.3.2 - 28/06/2011 =
* Fixed : Google+1 manual code always display same button size.
* Updated : Update heading and some text in configuration page. 
* Added : Digg Digg facebook page in configuration page.
* Added : Digg Digg user guide.

= Digg Digg v4.5.3.1 - 07/06/2011 =

* Fixed : Google +1 URL encoding issue, caused, display wrong counts in home page.
* Added : Add manual code for Google +1 button.
* Added : Add manual code for fblike (xfbxm) button.
* Added : Add manual code for serpd button.

= Digg Digg v4.5.3 - 06/06/2011 =

* Fixed : FBLike (XFBML) , send button typo error caused send button failed to display.
* Added : Add Google +1 button.
* Added : Add reset everything settings in global config.
* Fixed : If user compact HTML file, floating buttons are failed to display.

= Digg Digg v4.5.2 - 06/05/2011 =

* Fixed : Update FBLike (iframe) , height from 23 to 24px.
* Fixed : Chrome/Safari (webkit) auto scrolling when hits symbol "#" in iframe.
* Fixed : Facebook Like Thumbnail problem , add default images in global config.
* Update : Update jQuery to 1.6.0 for performance improve.
* Update : Update lazy load to facebook-like loading icon
* New : New FB Like using XFBML, to support "send" button and plugin compatible issue.

= Digg Digg v4.5.1.1 - 14/04/2011 =

Fixed : Configuration button on Wordpress not working
Update : Credit link updated to DiggDigg support forum
Update : Floating hide value update from 1280px to 790px

= Digg Digg v4.5.1 - 30/03/2011 =

* Fixed : Reddit + LazyLoading caused reddit button failed to function.
* Fixed : Delicious does not display in IE.
* Fixed : FaceBook Share display partially in browser, "e" is display in next line.
* Features : Add "Wide" layout for Digg button.
* Features : Integrate ShareThis email feature in floating display.
* Features : Add print button in floating display.
* Performance : Puts admin css in digg digg admin page only.
* Performance : Change the way of upgrade digg digg settings.
* Performance : Code refactor to increase performance.
* Remove : sphinn button.
* Remove : AddThis button in Floating mode.
* Update : FAQ page and admin page.

= Digg Digg v4.5.0.7 - 17/01/2011 =

* Minor bugs fixed.

= Digg Digg v4.5.0.6 - 04/01/2011 =

* Fixed : Floating button is not display if no "hidewidth" value is found.

= Digg Digg v4.5.0.5 - 26/12/2010 =

* Fixed : After digg digg is upgraded, buttons are not display.
* Fixed : Google Chrome auto scroll to center (floating button).

= Digg Digg v4.5.0.4 - 25/12/2010 =

* Add support for serpd button.
* Facebook Like width extended.
* Facebook Like support multiple languages.
* Hide floating buttons if browser width is smaller than certain value (for mobile device).
* Update FAQ page.

= Digg Digg v4.5.0.3 - 08/12/2010 =

* Add support for linkedin button

= Digg Digg v4.5.0.2 - 23/10/2010 =

* Add support to exclude button in individual pages.
* Update FAQ page.
* Add back the comment counts.

= Digg Digg v4.5.0.1 - 12/10/2010 =

* Add option to disabled diggdigg excerp fucntion.
* Bug fixed for diggdigg excerp function override the post excerp issue.
* Bug fixed for display control in Normal Display mode.

= Digg Digg v4.5 - 10/10/2010 =

* 80% code refactor for better performance and maintenance.
* New admin control menu.
* Normal display and floating display have own display settings.
* Delete post comments, deisgnfloat and polladium.
* Many major and minor bugs fixed.

= Digg Digg v4.2.2.2 - 23/8/2010 =

* Hot fixed for twitter title encoding issue (manual code).

= Digg Digg v4.2.2.1 - 17/8/2010 =

* Hot fixed for twitter title encoding issue.

= Digg Digg v4.2.2 - 17/8/2010 =

* Add configuration for twitter account name.
* Updated twitter manual code to support account name - digg_digg_twitter_generate('button','source').
* Bug fixed for twitter's title.
			
= Digg Digg v4.2.1 - 13/8/2010 =

* Add support for official twitter button
* Bug fixed for twitter and tweetmeme conflict issue
* Add show_face support for Facebook like
* Admin page redesigned
* Add changelog tab in wordpress.org

= Digg Digg v4.2 - 25/7/2010 =
* Add support for topsy button
* In admin setup, Link change log to changed-log.txt
* Add Announcement block
* Bug Fixed, ajax float scrolling back, push down images or content issue (major script changed).
* Update Digg Digg FAQ to explain the new changed.

= Digg Digg v4.1 - 22/7/2010 =
* Add change log tab

= Digg Digg v4.0.9 - 1/7/2010 =
* Bug fix for tweetmeme, urlshorten and new contructor
* Add floating issue in FAQ

= Digg Digg v4.0.8 - 28/6/2010 =
* Admin UI Redesign
* Bug fix for tweetmeme
* Add URL shorten api for tweetmeme

= Digg Digg v 4.0.7 - 22/6/2010 =
* Add option to disable the credit link

= Digg Digg v 4.0.6 - 8/6/2010 =
* Add fbshare back
 
= Digg Digg v 4.0.5 - 3/6/2010 =
* Bug fixed delicious img css
* Bug fixed for unexpected '"' error. 

= Digg Digg v 4.0.4 - 1/6/2010 =
* Bug fixed twitter source is not working

= Digg Digg v 4.0.3 - 27/5/2010 =
* Bug fixed for unexpected '"' error. 
(Not sure what's root cause, just delete all the '"' code, but delicious)
* Add version display for debug

= Digg Digg v 4.0.2 - 25/5/2010 =
* Bugs fixed for manual code, missing the postId argument.
* CSS fixed for delicious.

= Digg Digg v 4.0.1 - 25/5/2010 =
* Bug fixed for manual code (Compact is not working), twitter, gBuzz.
* dZone bug fixed.

= Digg Digg v 4.0 - 24/5/2010 =
* Add Lazy loading feature to improve the performance.
* Remove abstract class from base class.
* Ajax float enable in page.
* enable the jQuery library in Wordpress
* add shared count for delicious
* Refactor (front-end and back-end), many fixes

= Digg Digg v 3.9.6 - 13/5/2010 =
* Hot fixed for checkbox is not work properly.

= Digg Digg v 3.9.5 - 7/5/2010 =
* Hot fixed, disable the debugging mode.

= Digg Digg v 3.9.4 - 7/5/2010 =
* Add facebook like function
* Refactor the DiggDigg button display option
* Many minor bugs fixed

= Digg Digg v 3.9.3 - 6/5/2010 =
* Fixed for Wordpress 3.0 beta , 
"You do not have sufficient permissions to access this page message" - add filename to add_submenu_page()

= Digg Digg v 3.9.2 - 28/4/2010 =
* Fix for jQuery conflict issue
* Do not display Digg Digg Ajax script in home page

= Digg Digg v 3.9.1 - 23/4/2010 =
* Enable or disable ajax float totally.

= Digg Digg v 3.9 - 14/4/2010 =
* upgrade Google Buzz button.
* add support for BlogEngage.com
* change the dzone height to 52px

= Digg Digg v 3.8.1 - 13/4/2010 =
* Ajax float setup refactor
* Add option to load Google's Jquery to avoid JQuery conflict.
* add validation for variable to avoid offset hit null.

= Digg Digg v 3.8 - 10/4/2010 =
* float like Mashable.com (testing, get feedback)
* add change log adsense daemon link 
* upgrade reddit button
* change google buzz to iframe to control d width and height

= Digg Digg v 3.7 - 4/4/2010 =
* Google Buzz changed to Buzrr for shared count support
* CSS fixed for no border in image.
* Exclude display buttons in excerpt() mode.

= Digg Digg v 3.6 - 26/3/2010 =
* Digg upgrade to smart digg button
* Customize the Facebook icon width and height
* Replace split with explode 
* Add buttons display in certain category only
* Bug fix for stumbleupon custom url

= Digg Digg v 3.5.1 - 16/3/2010 =
* Change the buttons layout to div holder

= Digg Digg v 3.5 - 15/3/2010 =
* upgrade to new Stumble upon button
* upgrade to new Facebook share button
* add support for designbump
* add support for designfloat
* add support for web blend
* add hook to the_excerpt()
* fixed for line-up, right float problem, compact
* Admin UI redesign

= Digg Digg v 3.4 - 20/2/2010 =
* add support Google buzz
* addon to disable DiggDigg buttons on select pages
* fixed for contact me broken link
* fixed for css background image 
* fixed for broken comment link in main page

= Digg Digg v 3.3.1 - 9/2/2010 =
* Add options to choose ul or table layout
* Append version number behind css file to avoid css cache
* hot fixed - plugin descript and post count error

= Digg Digg v 3.3 - 8/2/2010 =
* Add support for post comments
* Add confirm message for reset button
* CSS align change from table to ul
* add replace & with &amp; for delicious button

= Digg Digg v 3.2.4 - 2/1/2010 =
* W3c validate for 1.0 xhtml
* Add support for sphinn
* CSS fixed ,add vertical align for table td

= Digg Digg v 3.2.3 - 7/12/2009 =
* CSS fixed for stumbleupon and delicious image border

= Digg Digg v 3.2.2 - 3/12/2009 =
* Wordpress website causing error

= Digg Digg v 3.2.1 - 3/12/2009 =
* Hot fix for stumbleupon & delicious image

= Digg Digg v 3.2 - 1/12/2009 =
* Add support for StumbleUpon & Delicious
* Fix CSS bug

= Digg Digg v 3.1 - 30/11/2009 =
* Refactor the reset and initial function to keep the existing user settings
* Change all buttons' class name to avoid name conflict with other plugins
* All buttons' border default to none

= Digg Digg v 3.0 - 24/11/2009 =
* Architeture refactor (front end and back end)
* Digg Digg no longer display in feed URL
* Allow buttons to display in priority order
* Core funtions changed to OO structure, for easy maintenance

= Digg Digg v 2.3 - 11/10/2009 =
* add support for polladium

= Digg Digg v2.2 - 08/10/2009 =
* Custom CSS style for the button's table container

= Digg Digg v2.1 - 25/09/2009 =
* Tag point to wrong folder in Wordpress plugin directory
* Release a new version and point to correct directory 

= Digg Digg v2.0 - 25/09/2009 =
* Add Support for fbshare.me (sharecount for facebook)

= Digg Digg v1.9 - 17/09/2009 =
* Replace htmlspecialchars() with urlencode() method
* Buf fixed for typo error 
  * $dd_twiter_display to $dd_twitter_display, 
  * $dd_twiter_buttonDesign to $dd_twitter_buttonDesign
* Refactor twitter API

= Digg Digg v1.8 - 30/06/2009 =
* Add Support for TweetMeme (twitter) button 

= Digg Digg v1.7 - 12/03/2009 =
* Add support for line up horizontal or vertical

= Digg Digg v1.6 - 08/02/2009 =
* Add Support for Yahoo Buzz button
* Add dd_ybuzz for all YBuzz's variables

= Digg Digg v1.5.1 - 22/12/2008 =
* Make digg digg plugin w3c complient, Thanks Pross
* Bug fix Bug fix digg_digg_generate() button design is not display correctly.

= Digg Digg v1.5 - 23/11/2008 =
* Add Support for dZone me button
* Add dd_dzone for all dzone's variables
* Bug fix Bug fix for "Button Allow Display Options" is not working for reddit and dzone

= Digg Digg v1.4.1 - 15/11/2008 =
* Bug fix for Display Right float , append "&" in button
* Bug fix for "Button Allow Display Options" is not working, button is not display in right position

= Digg Digg v1.4 - 14/11/2008 =
* Add Support for Reddit me button
* Bug fix for digg submit, when click digg button, open a new windows.
* Add dd_digg for all digg's variables
* Add dd_reddit for all reditt's variables
* <?php if(function_exists('digg_digg_reddit_generate')) { digg_digg_reddit_generate(); } ?>
* <?php if(function_exists('digg_digg_generate')) { digg_digg_generate(); } ?>

= Digg Digg v1.3 - 01/11/2008 =
* Bug fix for digg submit, didnt include post title (thanks Byron)
* Add digg_digg prefix to every variables and methods
* Choose Digg Button Design - normal, compact or icon

= Digg Digg v1.2 - 05/09/2008 =
Add Digg Button Control Display function Setup Screen.
* Display at Home page
* Display at Static page
* Display at Post Page
* Display at Category Page
* Display at Archive Page

= Digg Digg v1.1 - 31/07/2008 =
Add Setup screen (Setting->DiggDigg) to let user choose where user want to display Digg button.
* Append Digg Button with Left Float Content
* Append Digg Button with Right Float Content
* Append Digg Button Before Content
* Append Digg Button After Content