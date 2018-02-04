<?php 
require 'include/config.php';
require 'include/simple_html_dom.php';

/*  ------------------------------------------------------------------
    take last screenshot / see code in camlastpic_image.php / start
    ------------------------------------------------------------------ */
$lastpic = '...';
$content = file_get_contents(CAM_LAST_PIC_URL);
if (strlen($content) > 0) {
    $lastpic = 'OK';
} else {
    $lastpic = 'KO';
}
//  take last screenshot / see code in camlastpic_image.php / end

/*  ------------------------------------------------------------------
    read camera pictures / start
    ------------------------------------------------------------------ */
$campics = '...';

$directory = PICFOLDER;
$images = glob($directory . "*.jpg");
$imgcnt = count($images);

$imagefound = false;
foreach($images as $image) {
    $imageFileName = substr($image, strrpos($image, '/', -1)+1);
    $imageDateTime = date("d/m/Y H:i:s", filemtime($image));
    $imageData = base64_encode(file_get_contents($image));
    $imagefound = true;
    break;
}
if ($imagefound) {
    $campics = 'OK';
} else {
    $campics = 'KO';
}
//  read camera pictures / end

/*  ------------------------------------------------------------------
    read camera configuration / start
    ------------------------------------------------------------------ */
$camsett = '...';
$url = CAM_URL . 'motion.htm';

$ch = curl_init($url);
$http_headers = array(
    'User-Agent: Junk', // Any User-Agent will do here
);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

// Create a DOM object
$dom = new simple_html_dom();
// Load HTML from a string
$dom->load($response);

$tagfound = false;
foreach($dom->find('input') as $element) {
    if ($element->type == 'radio' and $element->name == 'MotionDetectionEnable' and $element->value == '1') {
        $tagfound = true;
        break;
    }
}

if ($tagfound) {
    $camsett = 'OK';
} else {
    $camsett = 'KO';
}
// read camera configuration / end

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.ico">
	<meta name="robots" content="noindex, nofollow">
	<title>Lab5 Monitor</title>
    <!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>

<main role="main" class="container">
	<div class="starter-template" id="starter-template">
		<h1><?php echo $sitename ?> monitor</h1>

        <div class="row">
            <div class="col">
                Web Server
            </div>
            <div class="col">
                OK
            </div>
        </div>
        <div class="row">
            <div class="col">
                Camera Last Picture
            </div>
            <div class="col">
                <?php echo $lastpic ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Camera Picture List
            </div>
            <div class="col">
                <?php echo $campics ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Camera Settings
            </div>
            <div class="col">
                <?php echo $camsett ?>
            </div>
        </div>
        <p></p>
        <div class="row">
            <div class="col">
                Current time on server
            </div>
            <div class="col">
                <?php echo date('d/m/Y H:i:s'); ?>
            </div>
        </div>
    </div>
</main><!-- /.container -->

</body>
</html>