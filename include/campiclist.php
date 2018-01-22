<?php require 'session.php' ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    --> camera pictures list / to be done



<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>
