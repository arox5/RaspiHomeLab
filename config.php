<?php
require 'config_local.php';
require 'config_env.php';

date_default_timezone_set('Europe/Rome');

if(ENVIRONMENT=='TST'){
	//windows dev environment
	define("PICFOLDER", "../cam_files/");
} else {
	//raspberry
	define("PICFOLDER", "/home/pi/FTP/cam/");
}

$camurl = '';
$camport = '';
$camusr = '';
$campwd = '';

$google_site_verification = '';

if(isset($local_cfg_is_set)){
	//settings taken from file config_local.php (this file is not available in github)
	$userinfo = $local_userinfo;

	$camurl = $local_camurl;
	$camport = $local_camport;
	$camusr = $local_camusr;
	$campwd = $local_campwd;

	$google_site_verification = $local_google_site_verification;

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