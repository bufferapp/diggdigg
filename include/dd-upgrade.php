<?php
require_once 'dd-global-variable.php';

// XXX: This is a broken way of doing this. If someone upgrades from version 2 to version 4, they will miss version 3

function dd_upgrade_setting_version_1() {
	//reset everything
	dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
	dd_clear_form_normal_display(DD_FUNC_TYPE_RESET);
	dd_clear_form_float_display(DD_FUNC_TYPE_RESET);
}

function dd_upgrade_setting_version_2() {
	dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
	dd_add_button(DD_BUTTON_FBLIKE_XFBML,new DD_FbLike_XFBML());
}

function dd_upgrade_setting_version_3() {
	dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
	dd_add_button(DD_BUTTON_GOOGLE1,new DD_Google1());
}


function dd_upgrade_setting_version_4() {
	dd_clear_form_global_config(DD_FUNC_TYPE_RESET);
	dd_add_button(DD_BUTTON_BUFFER,new DD_Buffer());
	dd_add_button(DD_BUTTON_PINTEREST,new DD_Pinterest());
	dd_add_button(DD_BUTTON_FLATTR,new DD_Flattr());
}

function dd_remove_button($button_nama=''){
	$dd_normal_buttons = get_option(DD_NORMAL_BUTTON);
	unset($dd_normal_buttons[DD_NORMAL_BUTTON_DISPLAY][$button_nama]);
	unset($dd_normal_buttons[DD_NORMAL_BUTTON_FINAL][$button_nama]);
	update_option(DD_NORMAL_BUTTON,$dd_normal_buttons);
	
	$dd_float_buttons = get_option(DD_FLOAT_BUTTON);
	unset($dd_float_buttons[DD_FLOAT_BUTTON_DISPLAY][$button_nama]);
	unset($dd_float_buttons[DD_FLOAT_BUTTON_FINAL][$button_nama]);
	update_option(DD_FLOAT_BUTTON,$dd_float_buttons);
}

function dd_add_button($button_nama='', $button_class){
	$dd_normal_buttons = get_option(DD_NORMAL_BUTTON);
	$dd_normal_buttons[DD_NORMAL_BUTTON_DISPLAY][$button_nama] = $button_class;
	update_option(DD_NORMAL_BUTTON,$dd_normal_buttons);
	
	$dd_float_buttons = get_option(DD_FLOAT_BUTTON);
	$dd_float_buttons[DD_FLOAT_BUTTON_DISPLAY][$button_nama] = $button_class;
	update_option(DD_FLOAT_BUTTON,$dd_float_buttons);
}

?>