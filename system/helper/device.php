<?php
function is_mobile() {    
	return(device()=='mobile');  
}

function is_tablet() {    
	return(device()=='tablet');  
}

function is_TV() {    
	return(device()=='tv');  
}

function is_desktop() {    
	return(device()=='desktop');  
}

function is_weixin() {
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {  //微信端
		return true;
	} else {
		return false;
	}
}

function device(){
	$catergorize_tablets_as_desktops = FALSE;  //If TRUE, tablets will be categorized as desktops
	$catergorize_tvs_as_desktops     = FALSE;  //If TRUE, smartTVs will be categorized as desktops
	
	// Category name - In the event the script is already using 'category' in the session variables, you could easily change it by only needing to change this value.
	$category = 'category';
	
	//Set User Agent = $ua
	if(isset($_SERVER['HTTP_USER_AGENT'])) {
		$ua = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$ua = '';
	}
	
	// Check to see if device type is set in query string
	if(isset($_GET["view"])){
		$view = $_GET["view"];
		// If view=desktop set in your query string
		if ($view == "desktop")	{
			$device = "desktop";
		}	else if ($view == "tablet") { // If view=tablet set in your query string
			$device = "tablet";
		}	else if ($view == "tv")	{ // If view=tablet set in your query string
			$device = "tv";
		}	else if ($view == "mobile")	{	// If view=mobile set in your query string
			$device = "mobile";
		}
	}// End Query String check
	
	// If session not yet set, check user agents
	if(!isset($device)){
		// Check if user agent is a smart TV - http://goo.gl/FocDk
		if ((preg_match('/GoogleTV|SmartTV|Internet.TV|NetCast|NETTV|AppleTV|boxee|Kylo|Roku|DLNADOC|CE\-HTML/i', $ua))) {
			$device = "tv";
		}	else if ((preg_match('/Xbox|PLAYSTATION.3|Wii/i', $ua))) {	// Check if user agent is a TV Based Gaming Console
			$device = "tv";
		}	else if((preg_match('/iP(a|ro)d/i', $ua)) || (preg_match('/tablet/i', $ua)) && (!preg_match('/RX-34/i', $ua)) || (preg_match('/FOLIO/i', $ua)))	{	// Check if user agent is a Tablet
			$device = "tablet";
		}	else if ((preg_match('/Linux/i', $ua)) && (preg_match('/Android/i', $ua)) && (!preg_match('/Fennec|mobi|HTC.Magic|HTCX06HT|Nexus.One|SC-02B|fone.945/i', $ua)))	{	// Check if user agent is an Android Tablet
			$device = "tablet";
		}	else if ((preg_match('/Kindle/i', $ua)) || (preg_match('/Mac.OS/i', $ua)) && (preg_match('/Silk/i', $ua))) {	// Check if user agent is a Kindle or Kindle Fire
			$device = "tablet";
		}	else if ((preg_match('/GT-P10|SC-01C|SHW-M180S|SGH-T849|SCH-I800|SHW-M180L|SPH-P100|SGH-I987|zt180|HTC(.Flyer|\_Flyer)|Sprint.ATP51|ViewPad7|pandigital(sprnova|nova)|Ideos.S7|Dell.Streak.7|Advent.Vega|A101IT|A70BHT|MID7015|Next2|nook/i', $ua)) || (preg_match('/MB511/i', $ua)) && (preg_match('/RUTEM/i', $ua))) {	// Check if user agent is a pre Android 3.0 Tablet
			$device = "tablet";
		}	else if ((preg_match('/BOLT|Fennec|Iris|Maemo|Minimo|Mobi|mowser|NetFront|Novarra|Prism|RX-34|Skyfire|Tear|XV6875|XV6975|Google.Wireless.Transcoder/i', $ua))) {	// Check if user agent is unique Mobile User Agent
			$device = "mobile";
		}	else if ((preg_match('/Opera/i', $ua)) && (preg_match('/Windows.NT.5/i', $ua)) && (preg_match('/HTC|Xda|Mini|Vario|SAMSUNG\-GT\-i8000|SAMSUNG\-SGH\-i9/i', $ua))) {	// Check if user agent is an odd Opera User Agent - http://goo.gl/nK90K
			$device = "mobile";
		}	else if ((preg_match('/Windows.(NT|XP|ME|9)/', $ua)) && (!preg_match('/Phone/i', $ua)) || (preg_match('/Win(9|.9|NT)/i', $ua))) {	// Check if user agent is Windows Desktop
			$device = "desktop";
		}	else if ((preg_match('/Macintosh|PowerPC/i', $ua)) && (!preg_match('/Silk/i', $ua))) {	// Check if agent is Mac Desktop
			$device = "desktop";
		}	else if ((preg_match('/Linux/i', $ua)) && (preg_match('/X11/i', $ua))) {	// Check if user agent is a Linux Desktop
			$device = "desktop";
		}	else if ((preg_match('/Solaris|SunOS|BSD/i', $ua))) {	// Check if user agent is a Solaris, SunOS, BSD Desktop
			$device = "desktop";
		}	else if ((preg_match('/Bot|Crawler|Spider|Yahoo|ia_archiver|Covario-IDS|findlinks|DataparkSearch|larbin|Mediapartners-Google|NG-Search|Snappy|Teoma|Jeeves|TinEye/i', $ua)) && (!preg_match('/Mobile/i', $ua))) {	// Check if user agent is a Desktop BOT/Crawler/Spider
			$device = "desktop";
		}	else {	// Otherwise assume it is a Mobile Device
			$device = "mobile";
		}
	}// End if session not set
	
	// Categorize Tablets as desktops
	if ($catergorize_tablets_as_desktops && $device == "tablet"){
		$device = "desktop";
	}
	
	// Categorize TVs as desktops
	if ($catergorize_tvs_as_desktops && $device == "tv"){
		$device = "desktop";
	}
	
	return $device;
}