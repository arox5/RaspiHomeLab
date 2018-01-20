<?php require 'session.php' ?>
<?php
if(isset($isloggedin) && $isloggedin) {
    $imageData = base64_encode(file_get_contents(CAM_LAST_PIC_URL));
    header("Content-type: image/gif");
    echo base64_decode($imageData);
    //echo 'data:image/jpeg;base64,' . $imageData;
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>