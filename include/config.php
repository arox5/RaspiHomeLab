<?php
require 'config_local.php';	// this is not committed to Github
require 'config_env.php';

date_default_timezone_set('Europe/Rome');

if(ENVIRONMENT=='TST'){
	//windows dev environment
	define("PICFOLDER", "C:/Andrea/Development/git/cam_files/");
} else {
	//raspberry
	define("PICFOLDER", "/home/pi/FTP/cam/");
}

$camurl = '';
$camport = '';
$camusr = '';
$campwd = '';

$google_site_verification = '';

$sitename = 'Dummy';

if(isset($local_cfg_is_set)){
	//settings taken from file config_local.php (this file is not available in github)
	$userinfo = $local_userinfo;

	$camurl = $local_camurl;
	$camport = $local_camport;
	$camusr = $local_camusr;
	$campwd = $local_campwd;

	$google_site_verification = $local_google_site_verification;

	$sitename = $local_sitename;

	define("CAM_LAST_PIC_URL", "http://" . $camurl . ":" . $camport . "/image/jpeg.cgi");
	define("CAM_URL", "http://" . $camusr . ":" . $campwd . "@" . $camurl . ":" . $camport . "/");	
} else {
	//if not set this 'no' will be used by index.php
	$local_cfg_is_set = 'no';

	//default user/password
	$userinfo = array(
		'usr1' => 'pwd1'
		);	
}
?>