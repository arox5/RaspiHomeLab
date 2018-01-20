<?php
require 'config.php';

session_start();

//handle logout
if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    //destroy session
    $_SESSION['isloggedin'] = false;
    header('Location: ' . $_SERVER['PHP_SELF']);
    die;
}

//normal valid session or session creation
$isloggedin = false;
$loginresult = '';

if(isset($_POST['username'])) {
	//default behavior: not logged in
	$loginresult = 'Invalid Login';
	$_SESSION['isloggedin'] = false;

	if(isset($userinfo[$_POST['username']])) {
		if($userinfo[$_POST['username']] == $_POST['password']) {
			$_SESSION['isloggedin'] = true;
			$loginresult = '';
		}
	}

	//log the wrong input username and password
	if($_SESSION['isloggedin'] == false) {
		error_log($_SERVER['REMOTE_ADDR'] . " Username=" . $_POST['username'] . " Password=" . $_POST['password']);
	}
}

if(isset($_SESSION['isloggedin'])) {
    $isloggedin = $_SESSION['isloggedin'];
}
?>