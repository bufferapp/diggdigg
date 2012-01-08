=== Plugin Name ===
Contributors: YONG MOOK KIM
Donate link: http://www.diggdigg2u.com/
Tags: digg digg, digg, google, google+1, linkedin, reddit, dzone, yahoo buzz, tweetMeme, twitter, topsy, facebook share, facebook like, stumbleUpon, delicious, designbump, thewebblend, blogengage and serpd.

Requires at least: 2.3
Tested up to: 3.3
Stable tag: 4.5.3.4

All-in-One Social Vote Buttons.

== Description ==
Integrate popular social buttons into Wordpress easily.

= Features =

* Display counts for popular social butons like Digg, LinkedIn, Google +1, Reddit, dDone, Twitter, TweetMeme, Topsy, Yahoo Buzz, facebook share, facebook like, StumbleUpon, Delicious, Sphinn, Google Buzz, Designbump, WebBlend, BlogEngage and Serpd.
* Facebook Like (Iframe or XFBXM), support thumbnail generation, multiple languages, show faces and send button.
* Rich button layout customisation.
* Flexible button display controls.
* Lazy loading to increase website performance.
* Left or right scrolling effect like Mashable.com.
* Support in excerpt mode.
* Support for email and print services.
* And many many ......

== Installation ==

1. Download and extract it
2. Copy digg-digg folder to the "/wp-content/plugins/" directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Done

Post Installation
1. Access the setting -> Digg Digg to do the configuration

== Frequently Asked Questions ==
Refer User Guide and FAQ Here, <a href="http://www.diggdigg2u.com/user-guide/" target="_blank">http://www.diggdigg2u.com/user-guide/</a>

== Screenshots ==
1. Buttons + Before Content + Normal Mode
2. Buttons + Before Content + Compact Mode
3. Buttons + Right Float + Normal Mode + Vertical Mode
4. Buttons + Left Scrolling Effect
5. Buttons + Right Scrolling Effect
6. Buttons + Before Content + Compact Mode + Excerpt Mode

== Changelog ==

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