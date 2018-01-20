<?php
require 'session.php';

if(isset($isloggedin) && $isloggedin) {
    echo '--> camera pictures list / to be done';
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>
