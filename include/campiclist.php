<?php
if(isset($isloggedin)) {
	if($isloggedin){
        echo '--> campiclist / to be done';
    }
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>
