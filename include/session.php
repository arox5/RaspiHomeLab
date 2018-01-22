<?php
require 'config.php';

session_start();

//handle logout
if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    //destroy session
    $_SESSION['isloggedin'] = false;
    //header('Location: ' . $_SERVER['PHP_SELF']);
	header('Location: login.php');
    die;
}

//normal session is present
$isloggedin = false;
if(isset($_SESSION['isloggedin'])) {
    $isloggedin = $_SESSION['isloggedin'];
}

if($isloggedin == false) {
	/*
	echo 'file:' . __FILE__ . '<br />';
	echo 'PHP_SELF: ' . $_SERVER['PHP_SELF'] . '<br />';
	echo 'pos include: ' . strpos($_SERVER['PHP_SELF'], 'include/'). '<br />';
	echo 'pos login: ' . strpos($_SERVER['PHP_SELF'], 'login.php'). '<br />';
	//die;
	*/

	//not authenticated and called from a file in include folder
	if(strpos($_SERVER['PHP_SELF'], 'include/') > 0) {
		//echo 'a';
		header('Location: ../login.php');
		die;
	}

	//not authenticated and not called from login.php
	if(strpos($_SERVER['PHP_SELF'], 'login.php') == 0) {
		//echo 'b';
		header('Location: login.php');
		die;
	}
}
?>