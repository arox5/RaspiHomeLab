<?php
require 'session.php';
require 'simple_html_dom.php';
require 'util.php';

/* ----------------------------------------------------------------------------------  */
// write camera settings
$url = '';
$camsettingcfg = '';
IF (isset($_GET['camsettingcfg'])) {
    $camsettingcfg = $_GET['camsettingcfg'];
}

switch($camsettingcfg) {
    case 'setMotionOff':
        $url = CAM_URL . 'setSystemMotion?MotionDetectionEnable=0&ReplyErrorPage=motion.htm&ReplySuccessPage=motion.htm&ConfigSystemMotion=Save';
        break;
    case 'setMotionOn':
        $url = CAM_URL . 'setSystemMotion?MotionDetectionEnable=1&ReplyErrorPage=motion.htm&ReplySuccessPage=motion.htm&ConfigSystemMotion=Save';
        break;
    case 'setDateNightAuto':
        $url = CAM_URL . 'setDayNightMode?DayNightMode=0&ReplyErrorPage=errrnght.htm&ReplySuccessPage=night.htm&ConfigDayNightMode=Save';
        break;
    case 'setDateNightAlwaysDayMode':
        $url = CAM_URL . 'setDayNightMode?DayNightMode=2&ReplyErrorPage=errrnght.htm&ReplySuccessPage=night.htm&ConfigDayNightMode=Save';
        break;
    default:
        $url = '';
        break;
}

if ($url != '') {
    //apply defined settings
    //echo 'url: ' . $url;
    $response = call_url($url);
    //echo '<div>response: ' . $response . '</div>';
}
// end write camera settings


/* ----------------------------------------------------------------------------------  */
// read motion detection start
$url = CAM_URL . 'motion.htm';
$response = call_url($url);

//echo '<div>response: ' . $response . '</div>';

// Create a DOM object
$dom = new simple_html_dom();
// Load HTML from a string
$dom->load($response);

//MotionDetectionEnable / default is false
$motiondet = false;

foreach($dom->find('input') as $element) {
    if ($element->type == 'radio' and $element->name == 'MotionDetectionEnable' and $element->value == '1' and $element->checked == true) {
        $motiondet = true;
    }
}
// read motion detection end

/* ----------------------------------------------------------------------------------  */
// read day/night mode start
$url = CAM_URL . 'night.htm';
$response = call_url($url);

//echo '<div>response: ' . $response . '</div>';

// Create a DOM object
$dom = new simple_html_dom();
// Load HTML from a string
$dom->load($response);

//Day/Night mode / default is auto
$daynightauto = true;

foreach($dom->find('input') as $element) {
    if ($element->type == 'radio' and $element->name == 'DayNightMode' and $element->value == '2' and $element->checked == true) {
        $daynightauto = false;
    }
}
// read day/night mode end

//$motiondet = false;
//$daynightauto = false;

//echo '$motiondet: ' . $motiondet . '<br />';
//echo '$daynightauto: ' . $daynightauto . '<br />';
?>

<?php if(isset($isloggedin) && $isloggedin): ?>
    <form>
        <div class="row">
            <div class="col">
                <div id="cam-setting-mot-det">
                    Motion detection
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-dark <?php echo ($motiondet? 'active' : '') ?>">
                            <input type="radio" name="options" id="set-mot-det-on" autocomplete="off" <?php echo ($motiondet? 'checked' : '') ?> >On
                        </label>
                        <label class="btn btn-outline-dark <?php echo ($motiondet? '' : 'active') ?>">
                            <input type="radio" name="options" id="set-mot-det-off" autocomplete="off" <?php echo ($motiondet? '' : 'checked') ?> > Off
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div id="cam-setting-day-night">
                    Day/Night Mode
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-dark <?php echo ($daynightauto? 'active' : '') ?>">
                            <input type="radio" name="options" id="set-day-night-auto" autocomplete="off" <?php echo ($daynightauto? 'checked' : '') ?> >Auto
                        </label>
                        <label class="btn btn-outline-dark <?php echo ($daynightauto? '' : 'active') ?>">
                            <input type="radio" name="options" id="set-day-night-day" autocomplete="off" <?php echo ($daynightauto? '' : 'checked') ?> > Off
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br /><br />in progress
            </div>
        </div>
    </form>
    <script>
        attachEventsToCamSetting();
    </script>
<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>
