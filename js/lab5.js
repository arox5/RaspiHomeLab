//fill the page content with requested section

//used by index.php
var toAutoRefresh;

function loadSection(section) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        $("#starter-template").html(this.responseText);
      }
    };
    xhttp.open("GET", "include/" + section + ".php", true);
    xhttp.send();

    //force the nav bar collapse
    $(".navbar-collapse").collapse('hide');
}

//used by camlastpic.php
function setAutoRefreshImage() {
    intoggle = 'off';
    if($("#setOn").is(":checked")) {
        intoggle = 'on';
    }
    //console.log('toogle: ' + intoggle);

    if(intoggle == 'on') {
        toAutoRefresh = setTimeout(function() {
            refreshImage();
            setAutoRefreshImage(intoggle);
        }, 3000);
        //console.log('start timeout');
    } else {
        clearTimeout(toAutoRefresh);
        //console.log('end timeout');
    }
}

function refreshImage() {
    //console.log('refresh');
    $("#lastimage").attr("src", "include/camlastpic_image.php");
}
