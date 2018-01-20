//fill the page content with requested section

//used by index.php
var toAutoRefresh;

function loadSection(section) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("starter-template").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "include/" + section + ".php", true);
    xhttp.send();
}

//used by camlastpic.php
function setAutoRefreshImage(intoggle) {
    console.log('toogle: ' + intoggle);
    if(intoggle == 'on') {
        toAutoRefresh = setTimeout(function() {
            refreshImage();
            setAutoRefreshImage(intoggle);
        }, 3000);
        console.log('start timeout');
    } else {
        clearTimeout(toAutoRefresh);
        console.log('end timeout');
    }
}

function refreshImage() {
    console.log('refresh');
    document.getElementById("lastimage").src = "include/camlastpic_image.php";
}
