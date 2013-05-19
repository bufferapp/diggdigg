<?php 
function dd_page_for_floating_display(){
	
	global $ddFloatDisplay,$ddFloatButtons;
	
	if (isset($_POST[DD_FORM_SAVE]) && check_admin_referer('digg_digg_floating_save','digg_digg_floating_nonce')) {
		
		if(isset($_POST[DD_STATUS_OPTION_DISPLAY])) $ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY] = DD_DISPLAY_ON;
		else $ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY] = DD_DISPLAY_OFF;
		
		if(isset($_POST[DD_COMMENT_ANCHOR_OPTION])) $ddFloatDisplay[DD_COMMENT_ANCHOR_OPTION][DD_COMMENT_ANCHOR_OPTION_STATUS] = DD_DISPLAY_ON;
		else $ddFloatDisplay[DD_COMMENT_ANCHOR_OPTION][DD_COMMENT_ANCHOR_OPTION_STATUS] = DD_DISPLAY_OFF;

		foreach(array_keys($ddFloatDisplay) as $key){
	    	
			foreach(array_keys($ddFloatDisplay[$key]) as $subkey){
				
				//echo '<h2>$key : ' . $key . ' - $subkey : ' . $subkey . ' - [' . $_POST[$subkey] . ']</h2>';
				if(isset($_POST[$subkey])){
					
					if($subkey==DD_FLOAT_OPTION_INITIAL_POSITION){
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



<div class="wrap dd-wrap columns-2">
	<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
	<h2>Digg Digg - Floating Button Bar Configuration</h2>
	
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<?php include("dd-sidebar.php"); ?>
		<div id="post-body">
			<div id="post-body-content">
				
				
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="<?php echo DD_FORM; ?>">
			
					<div class="stuffbox">
						<h3><label for="link_name">1. Status</label></h3>
						<div class="inside">
							<table class="form-table">
								<tr valign="top">
									<th scope="row">Enable Floating Display</th>
									<td>
										<INPUT TYPE=CHECKBOX NAME="<?php echo DD_STATUS_OPTION_DISPLAY ?>" 
				<?php echo ($ddFloatDisplay[DD_STATUS_OPTION][DD_STATUS_OPTION_DISPLAY]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
									</td>
								</tr>
						    </table>
							
							<div class="submit">
								<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
							</div>
						</div>
					</div>
					<!-- End Status -->
					
					
					<div class="stuffbox">
						<h3><label for="link_name">2. Display Configuration</label></h3>
						<div class="inside">
							<table class="form-table">
								<tr valign="top">
									<th scope="row">2.1. Buttons are always displayed in vertically in the floating bar.</th>
									<td>
										
									</td>
								</tr>
								
								<tr valign="top">
						        	<th scope="row">2.2 Buttons are allowed to display on...</th>
						        	<td>
						        		<?php 
											foreach($ddFloatDisplay[DD_DISPLAY_OPTION] as $key => $value){
												if($key == DD_DISPLAY_OPTION_HOME) continue;
									    	
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
						        	</td>
						        </tr>
						        
						        <tr valign="top">
						        	<th scope="row">2.3 Display in "Post" under categories...</th>
						        	<td>
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
						        	</td>
						        </tr>
						        
						        
						        <tr valign="top">
						        	<th scope="row">2.4 Choose how far from to the left of the content Digg Digg is placed</th>
						        	<td>
						        		<input name=<?php echo DD_FLOAT_OPTION_LEFT; ?> type="number" value="<?php echo (!empty($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT])?($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_LEFT]):DD_FLOAT_OPTION_LEFT_VALUE); ?>"  size="5" style="width:50px;" maxlength="4"/>px</p>
						        	</td>
						        </tr>
						        
						        <tr valign="top">
						        	<th scope="row">2.5 Choose how far from the top of the content Digg Digg is initially placed</th>
						        	<td>
						        		<input name=<?php echo DD_FLOAT_OPTION_TOP; ?> type="number" value="<?php echo (!empty($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_TOP])?($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_TOP]):DD_FLOAT_OPTION_TOP_VALUE); ?>"  size="5" style="width:50px;" maxlength="4"/>px</p>
						        	</td>
						        </tr>
						        
						        <tr valign="top">
						        	<th scope="row">2.6 Let Digg Digg bar float past the end of the post</th>
						        	<td>
						        		<input name=<?php echo DD_COMMENT_ANCHOR_OPTION; ?> type="checkbox" <?php echo ($ddFloatDisplay[DD_COMMENT_ANCHOR_OPTION][DD_COMMENT_ANCHOR_OPTION_STATUS]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
						        	</td>
						        </tr>
						        
						        <tr valign="top">
						        	<th scope="row">2.7 Override initial floating bar location</th>
						        	<td>
										Element : #<input type="text" value="<?php echo $ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_INITIAL_ELEMENT] ?>" 
											name="<?php echo DD_FLOAT_OPTION_INITIAL_ELEMENT;?>" /> (without preceding #)
						        	</td>
						        </tr>
						    </table>
							
							<div class="submit">
								<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
							</div>
						</div>
					</div>
					<!-- End Display Configuration Config -->
					
					
					<div class="stuffbox">
						<h3><label for="link_name">3. Button Selection</label></h3>
						<div class="inside">
							<p>Choose which buttons to display and how they should appear.</p>
							
							<table border="1" width="100%" class="dd-table">
							<tr>
							    <th width="3%"></th>
								<th width="30%" class="left">Website</th>
								<th width="5%">Weight</th>
								<th width="15%">Enabled</th>
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
														echo "<span class='dd-not-support'>Built-in Support</span>";	
													}
													else{
														echo "<span class='dd-not-support'>Not Supported</span>";	
													}
												}
											?> 
										</td>
									</tr>
							<?php 
								}
							?>
							</table>
							
							<div class="submit">
								<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
							</div>
						</div>
					</div>
					<!-- End Button Selection -->
					
					
					
					<div class="stuffbox">
						<h3><label for="link_name">4. Extra Integration</label></h3>
						<div class="inside">
							<p>Append extra services at the end of the floating buttons.</p>
							
							<table class="form-table">
								<tr valign="top">
									<th scope="row">4.1. Enable Email Button</th>
									<td>
										<INPUT TYPE=CHECKBOX NAME="<?php echo DD_EXTRA_OPTION_EMAIL_STATUS; ?>" 
			<?php echo ($ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_STATUS]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
									</td>
								</tr>
								
								<tr valign="top">
						        	<th scope="row">*ShareThis Publisher ID is required</th>
						        	<td>
						        		<input name=<?php echo DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID; ?> type="text" 
				value="<?php echo $ddFloatDisplay[DD_EXTRA_OPTION_EMAIL][DD_EXTRA_OPTION_EMAIL_SHARETHIS_PUB_ID] ?>"  size="50" maxlength="40"/>
										<p>P.S You will need to <a href="http://sharethis.com/register" target="_blank">register at ShareThis.com</a> (it's free!) to obtain your ShareThis Publisher ID.</p>
						        	</td>
						        </tr>
						        
						        <tr valign="top">
						        	<th scope="row">4.2 Enable Print Button</th>
						        	<td>
						        		<INPUT TYPE=CHECKBOX NAME="<?php echo DD_EXTRA_OPTION_PRINT_STATUS; ?>" 
			<?php echo ($ddFloatDisplay[DD_EXTRA_OPTION_PRINT][DD_EXTRA_OPTION_PRINT_STATUS]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
						        	</td>
						        </tr>
						    </table>
							
							<div class="submit">
								<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
							</div>
						</div>
					</div>
					<!-- End Extra Integration -->
					
					
					
					<div class="stuffbox">
						<h3><label for="link_name">5. Credit Link</label></h3>
						<div class="inside">
							<table class="form-table">
								<tr valign="top">
									<th scope="row">Enable Credit Link</th>
									<td>
										<INPUT TYPE=CHECKBOX NAME="<?php echo DD_FLOAT_OPTION_CREDIT; ?>" 
			<?php echo ($ddFloatDisplay[DD_FLOAT_OPTION][DD_FLOAT_OPTION_CREDIT]==DD_DISPLAY_ON) ? DD_CHECK_BOX_ON : DD_CHECK_BOX_OFF ?>>
									</td>
								</tr>
						    </table>
							
							<div class="submit">
								<input class="button-primary" name="<?php echo DD_FORM_SAVE; ?>" value="Save changes" type="submit" style="width:100px;" />
							</div>
						</div>
					</div>
					<!-- End Credit -->
					
					
					
					<div class="stuffbox">
						<h3><label for="link_name">6. Reset Floating Display Settings</label></h3>
						<div class="inside">
							<div class="submit">
								<input class="button-primary" onclick="if (confirm('Are you sure to reset \'Floating Display\' settings to default value?'))return true;return false" name="<?php echo DD_FORM_CLEAR; ?>" value="Reset Floating Display Settings" type="submit" style="width:200px;"/>
							</div>
						</div>
					</div>
					<!-- End Reset Floating Display Settings -->
					
					<?php wp_nonce_field('digg_digg_floating_save','digg_digg_floating_nonce'); ?>
				</form>
				
			</div>
		</div>
	</div>
</div>
<?php 
}
?>