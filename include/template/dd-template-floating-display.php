<?php 
function dd_page_for_floating_display(){
	
	global $ddFloatDisplay,$ddFloatButtons;
	
	if (isset($_POST[DD_FORM_SAVE])) {

		foreach(array_keys($ddFloatDisplay) as $key){
	    	
			foreach(array_keys($ddFloatDisplay[$key]) as $subkey){
				
				//echo '<h2>$key : ' . $key . ' - $subkey : ' . $subkey . ' - [' . $_POST[$subkey] . ']</h2>';
				if(isset($_POST[$subkey])){
					
					if($subkey==DD_FLOAT_OPTION_INITIAL_POSITION || $subkey==DD_FLOAT_OPTION_SCROLLING_POSITION){
						$ddFloatDisplay[$key][$subkey] = dd_filter_weird_characters($_POST[$subkey]);
					}else{
						$ddFloatDisplay[$key][$subkey] = $_POST[$subkey];
					}
					
				}
				
			}
	    }

	   	update_option(DD_FLOAT_DISPLAY_CONFIG, $ddFloatDisplay);
	   	
		foreach($ddFloatButtons[DD_FLOAT_BUTTON_DISPLAY] as $key => $value){
			
			foreach(array_keys($value->wp_options) as $option){
		    	if(isset($_POST[$option])){
		    		$value->wp_options[$option] = $_POST[$option];
		    	}else{
		    		$value->wp_options[$option] = DD_EMPTY_VALUE;
		    	}
		    }

			if(($value->getOptionAjaxLeftFloat()!=DD_DISPLAY_OFF)){
				$ddFloatButtons[DD_FLOAT_BUTTON_FINAL][$key] = $value;
			}
			    	
	    }
	    
		update_option(DD_FLOAT_BUTTON, $ddFloatButtons);

		echo "<div id=\"updatemessage\" class=\"updated fade\"><p>Digg Digg settings updated.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";	
		
		
  	}else if(isset($_POST[DD_FORM_CLEAR])){
	
        dd_clear_form_float_display(DD_FUNC_TYPE_RESET);
        
		echo "<div id=\"errmessage\" class=\"error fade\"><p>Digg Digg settings cleared.</p></div>\n";
		echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#errmessage').hide('slow');}, 3000);</script>";	
			
  	}

  	$ddFloatButtons = get_option(DD_FLOAT_BUTTON);
	$ddFloatDisplay = get_option(DD_FLOAT_DISPLAY_CONFIG);
	
  	//sort it
	$dd_sorting_data = array();
	foreach($ddFloatButtons[DD_FLOAT_BUTTON_DISPLAY] as $obj){
		$dd_sorting_data[$obj->getOptionButtonWeight().'-'.$obj->name] = $obj;
	}	
	krsort($dd_sorting_data,SORT_NUMERIC);
	
  	dd_print_float_form($dd_sorting_data, $ddFloatDisplay);
}

function dd_print_float_form($ddFloatButtons, $ddFloatDisplay){
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$("table tr:nth-child(even)").addClass("striped");

	$("#display_option_post").click(function () {
		checkCategory();
	});

	checkCategory();

});

function checkCategory(){

	jQuery(document).ready(function($) {
	
		var isCheck = $('input:checkbox[name=display_option_post]').is(':checked');

	 	if(isCheck){
	 		$("#dd-insider-block-category").show();
	 	}else{
	 		$("#dd-insider-block-category").hide();
	 	}
		
	});
	
}
</script>

<div id=msg></div>

<div id="dd_admin_block">

	<div id="dd_head_block">
		<span id="dd_plugin_title">Digg Digg - Floating Button Configuration</span>
	</div>

<!-- start of dd_admin_left_block -->
<div id="dd_admin_left_block">
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo DD_FORM; ?>">
	
	<div class="dd-block">
		<div class="dd-title">
		<h2>1. Status : 
		<?php if($ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON){
			echo '<span class="dd-enabled">Enabled</span>';
		}else{
			echo '<span class="dd-disabled">Disabled</span>';	
		}
		?>
		</h2>
		</div>
		<div class="dd-insider">
				<INPUT TYPE=CHECKBOX NAME="<?php echo DD_STATUS_OPTION_DISPLAY ?>" 
				<?php echo ($ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
				<span>Enable Floating Display</span>
			
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			
			<div style="clear:both"></div>
			
		</div>	
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>2. Display Configuration</h2></div>
		<div class="dd-insider">
		
			<div class="dd-insider-block">
				<span>2.1. Buttons are display in vertical order.</span>
			</div>
			
			<div class="dd-insider-block">
			<p>2.2 Buttons are allow to display in...</p>
			<p>
			<?php 
				foreach($ddFloatDisplay[DD_DISPLAY_OPTION] as $key => $value){
		    	
					echo " <INPUT TYPE=CHECKBOX NAME='" . $key . "'" ;
					
					if($value==DD_DISPLAY_ON){
						echo DD_CHECK_BOX_ON;
					}else{
						echo DD_CHECK_BOX_OFF;
					}
					
					echo " ID='" . $key . "' /> ";
					echo dd_GetText(DD_DISPLAY_OPTION,$key);
			    }
	    	?>
			</p>
			</div>
								
			<div class="dd-insider-block" id="dd-insider-block-category">
				<p>
				2.3 Display in "Post" under categories...
				</p>
				<?php 
					$dd_category_option = $ddFloatDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_RADIO];
					$dd_category_option_text_include = $ddFloatDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_TEXT_INCLUDE];
					$dd_category_option_text_exclude = $ddFloatDisplay[DD_CATEORY_OPTION][DD_CATEORY_OPTION_TEXT_EXCLUDE];
				?>
				<div id="dd-insider-block-category-include">
					<INPUT TYPE="radio" NAME="<?php echo DD_CATEORY_OPTION_RADIO ?>" VALUE="<?php echo DD_CATEORY_OPTION_RADIO_INCLUDE ?>" 
					 <?php echo ($dd_category_option==DD_CATEORY_OPTION_RADIO_INCLUDE) ? DD_RADIO_BUTTON_ON : DD_RADIO_BUTTON_OFF; ?>
					 />
					Include  : <input type="text" size="40" value="<?php echo $dd_category_option_text_include ?>" 
					name="<?php echo DD_CATEORY_OPTION_TEXT_INCLUDE;?>" /> (e.g category1, category2,...)
				</div>
				
				<div id="dd-insider-block-category-exclude">
					<INPUT TYPE="radio" NAME="<?php echo DD_CATEORY_OPTION_RADIO ?>" VALUE="<?php echo DD_CATEORY_OPTION_RADIO_EXCLUDE ?>"
					 <?php echo ($dd_category_option==DD_CATEORY_OPTION_RADIO_EXCLUDE) ? DD_RADIO_BUTTON_ON : DD_RADIO_BUTTON_OFF; ?>
					 />
					Exclude : <input type="text" size="40" value="<?php echo $dd_category_option_text_exclude; ?>" 
					name="<?php echo DD_CATEORY_OPTION_TEXT_EXCLUDE;?>" /> (e.g category1, category2,...)
				</div>
				
			</div>
			
			<div class="dd-insider-block" >
				<?php 
					$dd_extra_option_default_width = $ddFloatDisplay[DD_EXTRA_OPTION][DD_EXTRA_OPTION_SCREEN_WIDTH];
				?>
				<p>
				2.4 Hide buttons if browser's width &lt; 
				<input type="text" size="10" value="<?php echo $dd_extra_option_default_width; ?>" 
				name="<?php echo DD_EXTRA_OPTION_SCREEN_WIDTH;?>" /> px
				</p>
			</div>
		
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			
			<div style="clear:both"></div>
			
		</div>
		
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>3. Buttons Selection</h2></div>
		<div class="dd-insider">
			<p>Choose and customize the button layout to display.</p>
	
				<table border="1" width="100%" class="dd-table">
				<tr>
				    <th width="3%"></th>
					<th width="30%" class="left">Website</th>
					<th width="5%">Weight</th>
					<th width="15%">Ajax Floating</th>
					<th width="15%">Lazy Loading</th>
				</tr>
				
				<?php
					$count=1;
					foreach($ddFloatButtons as $obj){	
				?>	
						<tr>
							<td>
								<?php echo $count++; ?>.
							</td>
							<td class="left">
								<a href="<?php echo $obj->websiteURL; ?>" target="_blank"><?php echo $obj->name; ?></a>
							</td>
							<td>
								<input name=<?php echo $obj->option_button_weight; ?> type="text" value="<?php echo ($obj->getOptionButtonWeight()==DD_EMPTY_VALUE) ? 0 : $obj->getOptionButtonWeight(); ?>"  size="3" maxlength="3"/>
							</td>
							
							<td>
								<INPUT TYPE=CHECKBOX NAME="<?php echo $obj->option_ajax_left_float; ?>" 
								<?php echo ($obj->getOptionAjaxLeftFloat()==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
							</td>
							<td>
								<?php
									if($obj->islazyLoadAvailable){
								?>
								<INPUT TYPE=CHECKBOX NAME="<?php echo $obj->option_lazy_load; ?>" 
								<?php echo ($obj->getOptionLazyLoad()==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
								<?php
									}else{
										if($obj->name == "Facebook Like (XFBML)"){
											echo "<span class='dd-not-support'>Build-in Support</span>";	
										}
										else{
											echo "<span class='dd-not-support'>Not Support</span>";	
										}
									}
								?> 
							</td>
						</tr>
				<?php 
					}
				?>
				</table>
			
			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>4. Extra Integration</h2></div>
		<div class="dd-insider">
			<p>Append extra services at the end of the floating buttons.</p>
			
			<h3>
				4.1. Email Button - 
				<span><?php if($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_STATUS]==DD_DISPLAY_ON){
				echo '<span class="dd-enabled">Enabled</span>';
				}else{
					echo '<span class="dd-disabled">Disabled</span>';	
				}
				?>
				</span>
			</h3>
			<div>
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_EXTRA_OPTION_EMAIL_STATUS; ?>" 
			<?php echo ($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_STATUS]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>> Enable email button.
			</div>
			
			
			<div>
			<br/>
			*ShareThis Publisher ID is required : <input name=<?php echo DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID; ?> type="text" 
				value="<?php echo $ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID] ?>"  size="50" maxlength="40"/>
			</div>
			
			<div>
			<br/>
			<i>P.S You will need to <a href="http://sharethis.com/register" target="_blank">register at ShareThis.com</a> (it's free!) to obtain your ShareThis Publisher ID.</i>
			</div>
			
			<h3>
				4.2 Print Button - 
				<span><?php if($ddFloatDisplay[DD_EXTRA_OPTION_PRINT][DD_EXTRA_OPTION_PRINT_STATUS]==DD_DISPLAY_ON){
				echo '<span class="dd-enabled">Enabled</span>';
				}else{
					echo '<span class="dd-disabled">Disabled</span>';	
				}
				?>
				</span>
			</h3>
			<div>
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_EXTRA_OPTION_PRINT_STATUS; ?>" 
			<?php echo ($ddFloatDisplay[DD_EXTRA_OPTION_PRINT][DD_EXTRA_OPTION_PRINT_STATUS]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>> Enable print button.
			</div>
			
			<div class="dd-button">
				<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	
	<div class="dd-block">
		<div class="dd-title">
		<h2>5. Ajax Floating Configuration</h2>
		</div>
		<div class="dd-insider">

			<p>
			Due to different theme layout design, high chance the pre-defined settings are not suitable. So, you may need to configure the <strong>initial position</strong> and <strong>scolling position</strong> below. 
			</p>
			
			<h4>5.1 Initial Position</h4> 
			
			<p>
				This is the position where buttons initial display, try change the default "<span class="dd-note">margin-left:-120</span>" value to suit your theme.
			</p>
			<p class="dd-note dd-note-blue">Note : Edit the initial value in below box directly and save the changes, not in the css file</p>
			<p>
				<textarea name="<?php echo DD_FLOAT_OPTION_INITIAL_POSITION;?>" rows="10" cols="88" style="background-color:#F9F9F9;"><?php echo $ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_POSITION]; ?></textarea>
			</p>
			
			<h4>5.2 Scrolling Position</h4> 
			<p>
			This is the position where buttons display while you scrolling the page, try change the default "<span class="dd-note">top:16</span>" value to suit your theme.
			</p>
			<p class="dd-note dd-note-blue">Note : Edit the scrolling value in below box directly and save the changes, not in the css file</p>
			<p>
			<textarea name="<?php echo DD_FLOAT_OPTION_SCROLLING_POSITION;?>" rows="38" cols="88" style="background-color:#F9F9F9;"><?php echo 	$ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_SCROLLING_POSITION]; ?></textarea>
			</p>

			<div class="dd-button">
					<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			
			<div style="clear:both"></div>
			
		</div>	
	</div>

	<div class="dd-block">
		<div class="dd-title"><h2>6. Credit Link</h2></div>
		<div class="dd-insider">
			<p>Status : 
			<span><?php if($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_CREDIT]==DD_DISPLAY_ON){
			echo '<span class="dd-disabled">Disabled</span>';
			}else{
				echo '<span class="dd-enabled">Enabled</span>';	
			}
			?>
			</p>
			
			<p>
			<INPUT TYPE=CHECKBOX NAME="<?php echo DD_FLOAT_OPTION_CREDIT; ?>" 
			<?php echo ($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_CREDIT]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>> Disabled digg digg credit link (The small text link at the end of the floating box). 
			</p>
			
			<div>
				<span style="font-style: italic;font-weight: bold">Consider
				<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AWXCPTQXB7YAS" target="_blank">DONATE</a>
				 before remove this credit link, much appreciated :)
				</span>
			</div>
			
			<div class="dd-button">
				<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
	
	<div class="dd-block">
		<div class="dd-title"><h2>7. Reset Floating Display Settings</h2></div>
		<div class="dd-insider">
		<p>
		Reset "Floating Display" settings to default value.
		</p>
		<input class="button-primary" onclick="if (confirm('Are you sure to reset \'Floating Display\' settings to default value?'))return true;return false" name="<?php echo DD_FORM_CLEAR; ?>" value="Reset Floating Display Settings" type="submit" style="width:200px;"/>
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