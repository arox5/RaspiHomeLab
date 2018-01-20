<?php
if(isset($isloggedin)) {
	if($isloggedin){
        echo '--> camsetting / to be done';
    }
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>