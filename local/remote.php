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
    $url = CAM_URL . 'setSystemControl?LEDControl=';
    if ($action == 'on') {
        $url = $url . '0';
    } else {
        $url = $url . '1';
    }
    $url = $url . '&ReplyErrorPage=errradv.htm&ReplySuccessPage=advanced.htm&ConfigSystemControl=Apply';
    
    //echo 'url:' . $url;
    
    // setting update
    call_url($url);
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