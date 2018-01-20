<?php
require 'session.php';

if(isset($isloggedin) && $isloggedin) {
    echo '--> theft protection / to be done';
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>
