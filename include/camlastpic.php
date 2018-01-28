<?php require 'session.php' ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    <form>
        <div id="nav-last-pic">
            Auto refresh every 3 seconds 
            &nbsp;&nbsp;
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-dark ">
                    <input type="radio" name="options" id="setOn" autocomplete="off">On
                </label>
                <label class="btn btn-outline-dark active">
                    <input type="radio" name="options" id="setOff" autocomplete="off" checked> Off
                </label>
            </div>
            &nbsp;&nbsp;&nbsp;
            <button type="button" id="refresh-img" class="btn btn-outline-dark">Refresh</button>
        </div>
    <form>
    <br />
    <script>
        attachEventsToCamLastPic();
    </script>
    <img id="lastimage" src="include/camlastpic_image.php" class="img-fluid" />
<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>