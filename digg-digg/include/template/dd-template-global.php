<?php 
//for global setting
function dd_button_global_setup(){
	
	global $ddGlobalConfig;
	
	if (isset($_POST[DD_FORM_SAVE]) && check_admin_referer('digg_digg_global_save','digg_digg_global_nonce')) {

		//update global settings options
		foreach(array_keys($ddGlobalConfig) as $key){
			//echo '<h1>' . $key . '</h1>';
			
			foreach(array_keys($ddGlobalConfig[$key]) as $option){
				
				//echo '<h1>' . $option . '</h1>';
		    	if(isset($_POST[$option])){
		    		$ddGlobalConfig[$key][$option] = $_POST[$option];
		    	}else{
		    		$ddGlobalConfig[$key][$option] = DD_EMPTY_VALUE;
		    	}
		    }
	    }
	   
		update_option(DD_GLOBAL_CONFIG, $ddGlobalConfig);
		

		echo "<div id=\"updatemessage\" class=\"updated fade\"><p>Digg Digg settings updated.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
				
  	}else if(isset($_POST[DD_FORM_CLEAR])){
	
        dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
        
		echo "<div id=\"errmessage\" class=\"error fade\"><p>Digg Digg settings cleared.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#errmessage').hide('slow');}, 3000);</script>";	
			
  	}else if(isset($_POST[DD_FORM_CLEAR_ALL])){
	
        dd_clear_all_forms_settings();
		echo "<div id=\"errmessage\" class=\"error fade\"><p>Digg Digg settings cleared.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#errmessage').hide('slow');}, 3000);</script>";	
			
  	}
  	
  	//get back the settings from wordpress options
  	$ddGlobalConfig = get_option(DD_GLOBAL_CONFIG);
	
  	dd_print_global_form($ddGlobalConfig);
}

function dd_print_global_form($ddGlobalConfig){
?>

<div class="wrap columns-2 dd-wrap">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
	<h2>Digg Digg - Global Configuration</h2>
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<?php include("dd-sidebar.php"); ?>
		<div id="post-body">
			<div id="post-body-content">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo DD_FORM; ?>">
						<div class="stuffbox">
							<h3><label for="link_name">1. Facebook Like Configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
								        <th scope="row">1.1 Language (locale)</th>
								        <td>
								        	<input type="text" 
									value="<?php echo $ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_LOCALE]; ?>" 
									name="<?php echo DD_GLOBAL_FACEBOOK_OPTION_LOCALE;?>" />
											<p>See all locales supported by Facebook <a href="http://www.facebook.com/translations/FacebookLocales.xml" target="_blank">here</a> (XML).
											<br />
											Copy the locale code from the "&lt;representation&gt;" tag, e.g. &lt;representation&gt;<strong>en_US</strong>&lt;/representation&gt;.</p>
										</td>
							        </tr>
							         
							        <tr valign="top">
							        	<th scope="row">1.2 Include Send button (XFBML only)</th>
							        	<td>
							        		<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_SEND ?>" 
								<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_SEND]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
							        	</td>
							        </tr>
							        
							        <tr valign="top">
							        	<th scope="row">1.3 Show faces</th>
							        	<td>
							        		<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_FACE ?>" 
								<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_FACE]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
							        	</td>
							        </tr>
							        
							        <tr valign="top">
							        	<th scope="row">1.4 Use post images in Facebook wall thumbnail</th>
							        	<td>
							        		<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_THUMB ?>" 
								<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_THUMB]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
							        	</td>
							        </tr>
							        
							        <tr valign="top">
							        	<th scope="row">1.5 Default thumbnail image</th>
							        	<td>
							        		<input type="text" 
												value="<?php echo $ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB]; ?>" 
												name="<?php echo DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB;?>" size="70" />
											<p>If post's thumbnail is not available, use the above default image as your thumbnail.</p>
							        	</td>
							        </tr>
							        <!--
							        <tr valign="top">
							        	<th scope="row">Some Other Option</th>
							        	<td>
							        		<input type="text" name="some_other_option" value="<?php echo get_option('some_other_option'); ?>" />
							        	</td>
							        </tr>
							        -->
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End FB Like Config -->
						
						
						
						<div class="stuffbox">
							<h3><label for="link_name">2. Official Twitter configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
							        	<th scope="row">2.1 Twitter account</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWITTER_OPTION][DD_GLOBAL_TWITTER_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TWITTER_OPTION_SOURCE;?>" />
							        		<p>This user will be @ mentioned in the suggested tweet.</p>
							        	</td>
							        </tr>
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End Twitter Config -->
						
						
						<div class="stuffbox">
							<h3><label for="link_name">3. Buffer configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
							        	<th scope="row">3.1 Twitter username</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_BUFFER_OPTION][DD_GLOBAL_BUFFER_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_BUFFER_OPTION_SOURCE;?>" />
							        		<p>This user will be @ mentioned in the suggested tweet.</p>
							        	</td>
							        </tr>
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End Buffer Config -->
						
						
						<div class="stuffbox">
							<h3><label for="link_name">4. Flattr configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
							        	<th scope="row">4.1 Flattr username</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_FLATTR_OPTION][DD_GLOBAL_FLATTR_OPTION_UID]; ?>" name="<?php echo DD_GLOBAL_FLATTR_OPTION_UID;?>" />
							        		<p>This Flattr username will be credited when people use the Flattr button.</p>
							        	</td>
							        </tr>
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End Flattr Config -->
						
						
						<div class="stuffbox">
							<h3><label for="link_name">5. TweetMeme configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
							        	<th scope="row">5.1 TweetMeme source RT @</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SOURCE;?>" />
							        		<p>Please use the format of 'yourname', not 'RT @yourname'.</p>
							        	</td>
							        </tr>
							        
							        
							        <tr valign="top">
							        	<th scope="row">5.2 URL Shortener</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SERVICE;?>" />
							        		<p>For example, bit.ly, awe.sm...</p>
							        	</td>
							        </tr>
							        
							        <tr valign="top">
							        	<th scope="row">5.3 URL Shortener API Key</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API;?>" />
							        		<p>API Key for use with URL Shortener (If any). Bit.ly Pro requires the API Key to be in the format 'user_name:api_key'.</p>
							        		<p>Note : If you do not required the URL shortner service, just leave it blank.</p>
							        	</td>
							        </tr>
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End TweetMeme Config -->
						
						
						<div class="stuffbox">
							<h3><label for="link_name">6. Topsy configuration</label></h3>
							<div class="inside">
								<table class="form-table">
							        <tr valign="top">
							        	<th scope="row">6.1 Topsy source</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TOPSY_OPTION_SOURCE;?>" /> 
							        		<p>Please put your Twitter username.</p>
							        	</td>
							        </tr>
							        
							        <tr valign="top">
							        	<th scope="row">6.2 Theme</th>
							        	<td>
							        		<input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_THEME]; ?>" name="<?php echo DD_GLOBAL_TOPSY_OPTION_THEME;?>" />
							        		<p>Please <a href="http://labs.topsy.com/button/retweet-button/" target="_blank">check here</a> for all the available Topsy color themes, <strong>default is blue</strong>.</p>
							        	</td>
							        </tr>
							    </table>
								
								<div class="submit">
									<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
								</div>
							</div>
						</div>
						<!-- End Topsy Config -->
						
						
						<div class="stuffbox">
							<h3><label for="link_name">7. Reset Global Configuration Settings</label></h3>
							<div class="inside">
								<br />
								<p>Reset all "Global Configuration" settings to their default values.</p>
								<input class="button-primary" onclick="if (confirm('Are you sure you want to reset \'Global Configuration\' settings to their default values?'))return true;return false" name="<?php echo DD_FORM_CLEAR; ?>" value="Reset Global Config Settings" type="submit" style="width:200px;"/>
								<br /><br />
							</div>
						</div>
						<!-- End Reset Global Config -->
						
						
						<?php // XXX: This seems pretty drastic... I doubt many people do this one! ?>
						<div class="stuffbox">
							<h3><label for="link_name">8. Reset Everything</label></h3>
							<div class="inside">
								<br />
								<p>Reset all settings (everything) to their default values.</p>
								<input class="button-primary" onclick="if (confirm('Are you sure you want to reset all settings to their default values?'))return true;return false" name="<?php echo DD_FORM_CLEAR_ALL; ?>" value="Reset All Settings" type="submit" style="width:200px;"/>
								<br /><br />
							</div>
						</div>
						<!-- End Reset All Config -->
						
						<?php wp_nonce_field('digg_digg_global_save','digg_digg_global_nonce'); ?>
					</form>
			</div>
		</div>
	</div>
</div>
<?php 
}
?>