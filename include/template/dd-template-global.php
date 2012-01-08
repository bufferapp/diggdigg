<?php 
//for global setting
function dd_button_global_setup(){
	
	global $ddGlobalConfig;
	
	if (isset($_POST[DD_FORM_SAVE])) {

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

<div id=msg></div>

<div id="dd_admin_block">

	<div id="dd_head_block">
		<span id="dd_plugin_title">Digg Digg - Global Configuration</span>
	</div>

<!-- start of dd_admin_left_block -->
<div id="dd_admin_left_block">
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo DD_FORM; ?>">
	
	<div class="dd-block">
		<div class="dd-title"><h2>1. Facebook Like Configuration</h2></div>
		<div class="dd-insider">
		
			<p>
			1.1 FaceBook language (locale) : <input type="text" 
			value="<?php echo $ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_LOCALE]; ?>" 
			name="<?php echo DD_GLOBAL_FACEBOOK_OPTION_LOCALE;?>" /> e.g English(en_US), French(fr_FR)...
			</p>
			<p class="dd-remark">
				See all Facebook supported locale here -  
				<a href="http://www.facebook.com/translations/FacebookLocales.xml" target="_blank">XML</a> file. 
				Copy locale code in between the "&lt;representation&gt;" tag.
			</p>
			
			<br />

			<p>
			1.2 FaceBook "send" button (XFBML only) : 
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_SEND ?>" 
			<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_SEND]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
			Enable
			</p>
			
			<br />
			
			<p>
			1.3 FaceBook "show" face : 
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_FACE ?>" 
			<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_FACE]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
			Enable
			</p>
			
			<br />
			
			<p>
			1.4 DiggDigg crawls your post's image as thumbnail : 
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_GLOBAL_FACEBOOK_OPTION_THUMB ?>" 
			<?php echo ($ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_THUMB]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
			Enable
			
			</p>
			
			<p class="dd-remark">
				If post's thumbnail is not available, use below default image as your thumbnail.
				<br />
				Image URL : <input type="text" 
				value="<?php echo $ddGlobalConfig[DD_GLOBAL_FACEBOOK_OPTION][DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB]; ?>" 
				name="<?php echo DD_GLOBAL_FACEBOOK_OPTION_DEFAULT_THUMB;?>" size="70" />
			
			</p>
			
			<br />
			

			<div class="dd-button">
				<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>	
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>2. Official Twitter configuration</h2></div>
		<div class="dd-insider">
			<p>
			2.1 Twitter account : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWITTER_OPTION][DD_GLOBAL_TWITTER_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TWITTER_OPTION_SOURCE;?>" /> (without @ symbol)
			</p>
			<p class="dd-remark">
			This user will be @ mentioned in the suggested Tweet.
			</p>
			<div class="dd-button">
				<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>	
	</div>
	
	
	<div class="dd-block">
		<div class="dd-title"><h2>3. TweetMeme configuration</h2></div>
		<div class="dd-insider">
			<p>
			3.1 TweetMeme source RT @ : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SOURCE;?>" /> 
			</p>
			<p class="dd-remark">
			Please use the format of 'yourname', not 'RT @yourname'.
			</p>
			<p>
			3.2 URL Shortener : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SERVICE;?>" /></p> 
			<p class="dd-remark">
			For example, bit.ly, awe.sm...
			</p>
			<p>
			3.3 URL Shortener API Key : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TWEETMEME_OPTION][DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API]; ?>" name="<?php echo DD_GLOBAL_TWEETMEME_OPTION_SERVICE_API;?>" /> 			
			</p>
			<p class="dd-remark">
			API Key for use with URL Shortener (If any). Bit.ly Pro requires the API Key to be in the format 'user_name:api_key'. Where user_name is your username and api_key is your API Key.
			</p>
			<p class="dd-note">
			Note : If you do not required the URL shortner service, just leave it blank.
			</p>
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>	
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>4. Topsy configuration</h2></div>
		<div class="dd-insider">
			<p>
			4.1 Topsy source : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_SOURCE]; ?>" name="<?php echo DD_GLOBAL_TOPSY_OPTION_SOURCE;?>" /> 
			</p>
			<p class="dd-remark">
			Please put your twitter username.
			</p>
			<p>
			4.2 Theme : <input type="text" value="<?php echo $ddGlobalConfig[DD_GLOBAL_TOPSY_OPTION][DD_GLOBAL_TOPSY_OPTION_THEME]; ?>" name="<?php echo DD_GLOBAL_TOPSY_OPTION_THEME;?>" /></p> 
			<p class="dd-remark">
			Please <a href="http://labs.topsy.com/button/retweet-button/" target="_blank">check here</a> for all the available Topsy color theme, <strong>default is blue</strong>.
			</p>
			<p>
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>	
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>5. Reset Global Configuration Settings</h2></div>
		<div class="dd-insider">
			<p>
			Reset all "Global Configuration" settings to default value.
			</p>
			<input class="button-primary" onclick="if (confirm('Are you sure to reset \'Global Configuration\' settings to default value?'))return true;return false" name="<?php echo DD_FORM_CLEAR; ?>" value="Reset Global Config Settings" type="submit" style="width:200px;"/>
		</div>
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>6. Reset Everything</h2></div>
		<div class="dd-insider">
			<p>
			Reset all settings (everything) to default value.
			</p>
			<input class="button-primary" onclick="if (confirm('Are you sure to reset all settings \'everyting\' to default value?'))return true;return false" name="<?php echo DD_FORM_CLEAR_ALL; ?>" value="Reset All Settings" type="submit" style="width:200px;"/>
		</div>
	</div>
	
	</form>

	<!-- start of dd-footer.php -->
	<?php include("dd-footer.php"); ?>
	<!-- end of dd-footer.php -->
	
</div>
<!-- end of dd_admin_left_block -->

<!-- start of dd-sidebar.php -->
<?php include("dd-sidebar.php"); ?>
<!-- end of dd-sidebar.php -->

</div>
<?php 
}
?>