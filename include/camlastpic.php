<?php if(isset($isloggedin)): ?>
    <?php if($isloggedin): ?>
        <?php
        $lastimage = CAM_LAST_PIC_URL;
        $imageData = base64_encode(file_get_contents($lastimage));
        $autorefresh = 'off';
        IF (isset($_POST['autorefresh'])) {
            $autorefresh = $_POST['autorefresh'];
        }

        //echo '$autorefresh: ' . $autorefresh;
        ?>
        <script>
        </script>
        <form name="camlastpic" id="camlastpic" method="post">
            <input type="hidden" name="action" id="action" value="camlastpic" />
            <input type="hidden" name="autorefresh" id="autorefresh" value="<?php echo $autorefresh ?>" />
            <div>
                Auto refresh every 3 seconds 
                <div class="btn-group" role="group" >
                    <button type="button" class="btn <?php echo ($autorefresh=='on'? 'btn-dark' : 'btn-secondary') ?>" onclick="setAutoRefresh('on')">On</button>
                    <button type="button" class="btn <?php echo ($autorefresh=='off'? 'btn-dark' : 'btn-secondary') ?>" onclick="setAutoRefresh('off')">Off</button>
                </div>            
            </div>
            <br />
            <script>
                function setAutoRefresh(toggle) {
                    document.getElementById("autorefresh").value = toggle;
                    document.getElementById("camlastpic").submit();
                }
                setTimeout(function() {
                    //console.log('checked: ' + document.getElementById("chkautorefresh").checked);
                    if(document.getElementById("autorefresh").value=="on") {
                        document.getElementById("camlastpic").submit();
                    }
                }, 3000);
            </script>
        </form>
        <img src="data:image/jpeg;base64,<?php echo $imageData ?>" class="img-fluid" />
    <?php else: ?>
        <?php
            //not authenticated, redirect to home page
            header('Location: ../');
        ?>
    <?php endif ?>
<?php endif ?>