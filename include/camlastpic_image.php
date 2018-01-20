<?php require 'session.php' ?>
<?php
if(isset($isloggedin) && $isloggedin) {
    /*
    $imageDataEncoded = base64_encode(file_get_contents(CAM_LAST_PIC_URL));
    $imageData = base64_decode($imageDataEncoded);
    $source = imagecreatefromstring($imageData);

    //echo base64_decode($imageDataEncoded);
    //echo 'data:image/jpeg;base64,' . $imageDataEncoded;
    */

    //create image from URL
    $source = imagecreatefromstring(file_get_contents(CAM_LAST_PIC_URL));
    //get image height (480)
    $imgSY = ImageSY($source);
    //set string color (black)
    $textcolor = imagecolorallocate($source, 0, 0, 0);
    //set background color (white)
    $bg_color = imagecolorallocate($source, 211, 211, 211);
    //draw background
    imagefilledrectangle($source, 2, 2, 175, 19, $bg_color);
    // Write the string at the bottom left 
    imagestring($source, 5, 3, 3, date("d/m/Y H:i:s"), $textcolor);
    //output
    header("Content-type: image/png");
    imagepng($source);
    //release memory
    imagedestroy($imageData);

} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>