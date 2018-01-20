<?php require 'session.php' ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    <div>
        Auto refresh every 3 seconds 

        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary ">
                <input type="radio" name="options" id="setOn" autocomplete="off" onclick="setAutoRefreshImage('on')">On
            </label>
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="setOff" autocomplete="off" checked onclick="setAutoRefreshImage('off')"> Off
            </label>
        </div>

        <div class="btn-group" role="group" >
            <button type="button" class="btn btn-dark" onclick="setAutoRefreshImage('on')">On</button>
            <button type="button" class="btn btn-secondary" onclick="setAutoRefreshImage('off')">Off</button>
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