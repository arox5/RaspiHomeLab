<?php require 'session.php' ?>
<?php 
if(isset($isloggedin) && $isloggedin) {
    $directory = PICFOLDER;
    $images = glob($directory . "*.jpg");
    //sort by file date
    usort($images, create_function('$b,$a', 'return filemtime($a) - filemtime($b);'));

    //default values
    $picsperpage = 12;
    $curpage = 1;
    $totalpages = 0;
    $startpic = 0;

    //retrieve input values
    IF (isset($_GET['picsperpage'])) {
        $picsperpage = $_GET['picsperpage'];
    }
    IF (isset($_GET['curpage'])) {
        $curpage = $_GET['curpage'];
    }

    $imgcnt = count($images);
    $totalpages = round($imgcnt / $picsperpage);
    $startpic = (($curpage*$picsperpage)-$picsperpage)+1;

    /*
    echo 'picsperpage: ' . $picsperpage . '<br>';
    echo 'totalpages: ' . $totalpages . '<br>';
    echo 'startpic: ' . $startpic . '<br>';
    echo 'curpage: ' . $curpage . '<br>';
    */

    //return the number of total pages based on the input/default parameters
    echo '<form id="form-out">' .
         '<input type="hidden" id="totalpagesout" value="' . $totalpages . '" />' .
         '<input type="hidden" id="totalpicturesout" value="' . $imgcnt . '" />' .
         '</form>';

    $cnt = 1;
    foreach($images as $image) {
        
        $imageFileName = substr($image, strrpos($image, '/', -1)+1);
        $imageDateTime = date("d/m/Y H:i:s", filemtime($image));
        $imageData = base64_encode(file_get_contents($image));

        IF($cnt >= $startpic) {
            //show the image
            echo '
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="data:image/jpeg;base64,'.$imageData.'">
                    <div class="card-body">
                        <p class="card-text">' . sprintf('%04d', $cnt) . ') ' . $imageFileName . ' ' . $imageDateTime . '</p>
                    </div>
                </div>
            </div>';
        }

        $cnt++;
        if ($cnt > ($picsperpage*$curpage)) {
            break;
        }
    }
} else {
    //not authenticated, redirect to home page
    header('Location: ../');
}
?>