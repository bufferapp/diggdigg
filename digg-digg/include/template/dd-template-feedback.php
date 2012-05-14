<?php

function dd_feedback_setup(){
	$dd_feedback_errors = array();
	
	if($_POST['submit']) {
		$dd_feedback_name = $_POST['object']['name'];
		$dd_feedback_email = $_POST['object']['email'];
		$dd_feedback_message = $_POST['object']['message'];
		$dd_feedback_diagnostics = $_POST['object']['diagnostics'];
	
		if($dd_feedback_name=='') $dd_feedback_errors[] = 'Please make sure you have entered a name.';
		if($dd_feedback_email=='') $dd_feedback_errors[] = 'Please make sure you have entered a valid email address.';
		//if(!array_key_exists($this->data->type, $this->feedback_types)) $dd_feedback_errors[] = 'Please make sure you have selected a feedback type.';
		if($dd_feedback_message == '') $dd_feedback_errors[] = 'Please make sure you have entered a message.';
		if(strlen($dd_feedback_message)>2500) $dd_feedback_errors[] = 'Please make sure your message is less than 2500 characters in length.';
		
		if(count($dd_feedback_errors)==0) {
			// Send email to diggdigg@bufferapp.com
			$dd_feedback_subject = "Digg Digg Feedback ". DD_VERSION;
			$dd_feedback_message = "Name: $dd_feedback_name.\n\n Email: $dd_feedback_email.\n\n Message: $dd_feedback_message\n\n Diagnostics: $dd_feedback_diagnostics";
			wp_mail("diggdigg@bufferapp.com", $dd_feedback_subject, $dd_feedback_message); 
			
			dd_feedback_success();
			return;
		}
	}

	$diagnostics = dd_get_diagnostics();
?>

	<div class="wrap">
				
		<?php if(count($dd_feedback_errors) != 0): ?><div class="error"><ul style="padding-top:6px;"><li><?php echo implode('</li><li>',$dd_feedback_errors); ?></li></ul></div><?php endif; ?>
		
		<h2>Digg Digg <?php echo DD_VERSION; ?> Feedback</h2>
		<p>Welcome to the feedback page for Digg Digg. Here you can quickly and easily send messages to the plugin developers. If you are having trouble getting something to work, would like to know how to perform a certain action or have a new feature request just use the form below to get in touch.</p>
		
		<form method="post" action="">
			<table class="form-table">
				<tr>
					<th scope="row">Plugin</th>
					<td><strong>Digg Digg</strong> (version <?php echo DD_VERSION; ?>)</td>
				</tr>
				<tr>
					<th scope="row">Your name</th>
					<td><input type="text" name="object[name]" value="<?php echo dd_e($dd_feedback_name); ?>" class="regular-text" /></td>
				</tr>
				<tr>
					<th scope="row">Your email address</th>
					<td>
						<input type="text" name="object[email]" value="<?php echo dd_e($dd_feedback_email); ?>" class="regular-text" />
						<br /><span class="description">This will only be used to reply to you</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Feedback type</th>
					<td>
						<select name="object[type]">
							<option>General feedback</option>
							<option>Bug report</option>
							<option>Feature request</option>
							<option>Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Your message<br /><span class="description">Max 2500 chars</span></th>
					<td>
						<textarea name="object[message]" class="large-text" rows="10" cols="50"><?php echo dd_e($dd_feedback_message); ?></textarea>
					</td>
				</tr>
				<?php if(is_array($diagnostics) and count($diagnostics)>0): ?>
					<tr>
						<th scope="row">Diagnostic data</th>
						<td>
							The following information will also be sent with your message, it allows us to more easily identify any potential problems. No personally identifiable data will be transmitted except for what you enter above.
							<textarea name="object[diagnostics]" class="large-text" rows="5" cols="50"><?php foreach($diagnostics as $k=>$v): ?><?php echo $k.': '.$v."\n"; ?><?php endforeach; ?></textarea>
						</td>
					</tr>
				<?php endif; ?>
				
			</table>
			<div class="submit">
				<input type="submit" name="submit" value="Send" class="button-primary" />
			</div>
		</form>
		<p class="description">All data sent is confidential and will not be shared with third parties. We endeavour to respond to all enquiries as quickly as possible but delays may be encountered.</p>
	</div>

<?php
} // end func: dd_feedback_setup



function dd_feedback_success(){
?>
	<div class="wrap">
		<h2>Digg Digg <?php echo DD_VERSION; ?> Feedback</h2>
		<div class="updated"><p>Feedback sent successfully.</p></div>
		<p>Thank you for getting in touch. Your message has been sent to the plugin developer(s).</p>
	</div>

<?php
} // end func: dd_feedback_success





/*
	Sanitise output
*/
function dd_e($str) {
	return htmlspecialchars($str);
} // end func: dd_e



function dd_get_diagnostics() {
	global $wpdb, $wp_version;
	$p = dd_phpinfo_array();
	
	$d = array();
	$d['host_os'] = $p['PHP Configuration']['System'];
	$d['server_api'] = $p['PHP Configuration']['Server API'];
	$d['php_version'] = $p['Core']['PHP Version'];
	$d['safe_mode'] = $p['Core']['safe_mode'];
	$d['mysql_version'] = $wpdb->get_var('SELECT version()');
	$d['wordpress_version'] = $wp_version;
	$d['timezone'] = $p['date']['date.timezone'];
	$d['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	
	return $d;
} // end func: dd_get_diagnostics


/*
	Returns phpinfo() as an array (why doesn't PHP offer this as a built-in?)
	  * Reproduced from http://www.php.net/manual/en/function.phpinfo.php#87463
*/
function dd_phpinfo_array() {
	ob_start(); 
	phpinfo(-1);
	
	$pi = preg_replace(
	array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
	'#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
	"#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
	.'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
	'#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
	"# +#", '#<tr>#', '#</tr>#'),
	array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
	'<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
	"\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
	'<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
	'<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
	'<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
	ob_get_clean());
	
	$sections = explode('<h2>', strip_tags($pi, '<h2><th><td>'));
	unset($sections[0]);
	
	$pi = array();
	foreach($sections as $section){
		$n = substr($section, 0, strpos($section, '</h2>'));
		preg_match_all('#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',$section, $askapache, PREG_SET_ORDER);
		foreach($askapache as $m) $pi[$n][$m[1]]=(!isset($m[3])||$m[2]==$m[3])?$m[2]:array_slice($m,2);
	}
	
	return $pi;
} // end func: dd_phpinfo_array

?>