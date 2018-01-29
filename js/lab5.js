//fill the page content with requested section

//used by index.php
var toAutoRefresh;

//used by index.php
function attachEventsToMenu() {
    $(".navbar-nav #menu-camlastpic").click(function() {
        //take last snapshot
        loadSection('camlastpic');
    });
    $(".navbar-nav #menu-campiclist").click(function() {
        //take last snapshot
        loadSection('campiclist');
    });
    $(".navbar-nav #menu-camsetting").click(function() {
        //take last snapshot
        loadSection('camsetting');
    });
    $(".navbar-nav #menu-theftprot").click(function() {
        //take last snapshot
        loadSection('theftprot');
    });
}

//main navigation
function loadSection(section) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseURL.indexOf('login.php') > 0) {
                //a redirect to login.php is detected, this means that the session is expired
                document.location.href = '/';
            } else {
                $("#starter-template").html(this.responseText);
            }
        }
    };
    xhttp.open("GET", "include/" + section + ".php", true);
    xhttp.send();

    //force the nav bar collapse
    $(".navbar-collapse").collapse('hide');
}

//used by camlastpic.php
function attachEventsToCamLastPic() {
    $("#nav-last-pic #refresh-img").click(function() {
        //take last snapshot
        refreshImage();
    });
    $("#nav-last-pic #setOn").change(function() {
        //take last snapshot
        setAutoRefreshImage();
    });
    $("#nav-last-pic #setOff").change(function() {
        //take last snapshot
        setAutoRefreshImage();
    });
}

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

//used by campiclist.php
function attachEventsToCamPicList() {
    $("#nav-form #picsperpage").change(function() {
        //when number of pictures per page changes I go to 1st page
        goToPage('first');
    });
    $("#nav-form #goToFirst").click(function() {
        //when number of pictures per page changes I go to 1st page
        goToPage('first');
    });
    $("#nav-form #goToPrev").click(function() {
        //when number of pictures per page changes I go to 1st page
        goToPage('prev');
    });
    $("#nav-form #goToNext").click(function() {
        //when number of pictures per page changes I go to 1st page
        goToPage('next');
    });
    $("#nav-form #goToLast").click(function() {
        //when number of pictures per page changes I go to 1st page
        goToPage('last');
    });
}

function goToPage(goto) {
    curpage = parseInt($("#nav-form #curpage").text());
    picsperpage = parseInt($("#nav-form #picsperpage").val());
    if ($("#nav-form #totalpages").text() == '?') {
        totalpages = 10;
    } else {
        totalpages = parseInt($("#nav-form #totalpages").text());
    }

    //calculate page to be loaded
    switch(goto) {
        case 'first':
            curpage = 1;
            break;
        case 'prev':
            if (curpage > 1) {
                curpage--;
            }
            break;
        case 'next':
            if (curpage < totalpages) {
                curpage++;
            }
            break;
        case 'last':
            curpage = totalpages;
            break;
        default:
            curpage = 1;
            break;
    }

    /*
    console.log(
        'goto: ' + goto + '\n' +
        'picsperpage: ' + picsperpage + '\n' +
        'curpage: ' + curpage
    );
    */

    if (curpage == 1) {
        //disable left arrows
        $("#nav-form #goToFirst").prop("disabled",true);
        $("#nav-form #goToPrev").prop("disabled",true);
        $("#nav-form #goToNext").prop("disabled",false);
        $("#nav-form #goToLast").prop("disabled",false);
    } else if (curpage == totalpages) {
        //disable right arrows
        $("#nav-form #goToFirst").prop("disabled",false);
        $("#nav-form #goToPrev").prop("disabled",false);
        $("#nav-form #goToNext").prop("disabled",true);
        $("#nav-form #goToLast").prop("disabled",true);
    } else {
        //enable all arrows
        $("#nav-form #goToFirst").prop("disabled",false);
        $("#nav-form #goToPrev").prop("disabled",false);
        $("#nav-form #goToNext").prop("disabled",false);
        $("#nav-form #goToLast").prop("disabled",false);
    }

    //update navigation parameters
    $("#nav-form #curpage").text(curpage);
    $("#nav-form #picsperpage").val(picsperpage);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseURL.indexOf('login.php') > 0) {
            //a redirect to login.php is detected, this means that the session is expired
            document.location.href = '/';
        } else {
            //show the content
            $("#piclistgallery").html(this.responseText);

            //take real number of pages from the output
            //$("#totalpages").val($("#totalpagesout").val());
            $("#nav-form #totalpages").text($("#form-out #totalpagesout").val());
            $("#nav-form #totalpictures").text($("#form-out #totalpicturesout").val());

            //reset the spinner
            $("#nav-form #spinner").text('');
        }
      }
    };
    xhttp.open("GET", "include/campiclist_image.php"
        + "?picsperpage=" + picsperpage
        + "&curpage=" + curpage, true);
    xhttp.send();

    //show the spinner
    //$("#nav-form #spinner").prepend('<img src="spinner.gif" width="80" />');
    $("#nav-form #spinner").text(' (loading...) ');
}

//used by camsetting.php
function attachEventsToCamSetting() {
    $("#cam-setting-mot-det #set-mot-det-on").change(function() {
        changeCamSetting('setMotionOn');
    });
    $("#cam-setting-mot-det #set-mot-det-off").change(function() {
        changeCamSetting('setMotionOff');
    });
    $("#cam-setting-day-night #set-day-night-auto").change(function() {
        changeCamSetting('setDateNightAuto');
    });
    $("#cam-setting-day-night #set-day-night-day").change(function() {
        changeCamSetting('setDateNightAlwaysDayMode');
    });
}

function changeCamSetting(configName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseURL.indexOf('login.php') > 0) {
            //a redirect to login.php is detected, this means that the session is expired
            document.location.href = '/';
        } else {
            $("#starter-template").html(this.responseText);
        }
      }
    };
    xhttp.open("GET", "include/camsetting.php"
        + "?camsettingcfg=" + configName, true);
    xhttp.send();
}