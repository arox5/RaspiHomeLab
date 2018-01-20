<?php require 'session.php' ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    <div>
        Auto refresh every 3 seconds 
        &nbsp;&nbsp;
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary ">
                <input type="radio" name="options" id="setOn" autocomplete="off" onchange="setAutoRefreshImage()">On
            </label>
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="setOff" autocomplete="off" checked onchange="setAutoRefreshImage()"> Off
            </label>
        </div>
        &nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-secondary" onclick="refreshImage()">Refresh</button>
    </div>
    <br />
    <img id="lastimage" src="include/camlastpic_image.php" class="img-fluid" />
<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>