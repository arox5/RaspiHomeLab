<?php require 'session.php'  ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    --> camera settings / to be done as of 21/01/2018
<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>
