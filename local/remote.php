<?php 
require '../include/config.php';
require '../include/simple_html_dom.php';
require '../include/util.php';

$token = '';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
}
if ($token != $local_token) {
    // if token is not correct redirect to login
    header('Location: ../login.php');
    die;
}

$action = '';
$ledUpdate = false;
IF (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'on':
        // set motion and ftp on
        $ledUpdate = true;
        break;
    case 'off':
        // set motion and ftp off
        $ledUpdate = true;
        break;
}

if ($ledUpdate) {
    //swith on/off the led, the camera motion and the day/night
    $url_led = CAM_URL . 'setSystemControl?LEDControl=';
    $url_motion = CAM_URL . 'setSystemMotion?MotionDetectionEnable=';
    $url_daynight = CAM_URL . 'setDayNightMode?DayNightMode=';

    if ($action == 'on') {
        $url_led = $url_led . '0';
        $url_motion = $url_motion . '1';
        $url_daynight = $url_daynight . '0';
    } else {
        $url_led = $url_led . '1';
        $url_motion = $url_motion . '0';
        $url_daynight = $url_daynight . '2';
    }

    $url_led = $url_led . '&ReplyErrorPage=errradv.htm&ReplySuccessPage=advanced.htm&ConfigSystemControl=Apply';
    $url_motion = $url_motion . '&ReplyErrorPage=motion.htm&ReplySuccessPage=motion.htm&ConfigSystemMotion=Save';
    $url_daynight = $url_daynight . '&ReplyErrorPage=errrnght.htm&ReplySuccessPage=night.htm&ConfigDayNightMode=Save';
    
    //echo 'url_led:' . $url_led;

    // setting update
    call_url($url_led);
    call_url($url_motion);
    call_url($url_daynight);
}

/* ----------------------------------------------------------------------------------  */
// read advanced mode start
$url = CAM_URL . 'advanced.htm';
$response = call_url($url);

//echo '<div>response: ' . $response . '</div>';

// Create a DOM object
$dom = new simple_html_dom();
// Load HTML from a string
$dom->load($response);

//Day/Night mode / default is auto
$LedOff = true;

foreach($dom->find('input') as $element) {
    if ($element->type == 'radio' and $element->name == 'LEDControl' and $element->value == '0' and $element->checked == true) {
        $LedOff = false;
    }
}
// read advanced mode end

if ($LedOff) {
    echo 'OFF';
} else {
    echo 'ON';
}

//echo 'ip:' . $_SERVER['REMOTE_ADDR'] . '<br />';

?>